<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $pengguna = Pengguna::where("email", $request->email)->first();

        if ($pengguna && Hash::check($request->password, $pengguna->password)) {
            // Validasi role_id: hanya role 1 (Admin) dan 2 (Staff) yang bisa akses
            if (!in_array($pengguna->peran_id, [1, 2])) {
                return back()
                    ->withErrors([
                        "email" =>
                            "Akses ditolak. Anda tidak memiliki izin untuk mengakses panel admin.",
                    ])
                    ->withInput();
            }

            // Simpan session manual
            session([
                "user_id" => $pengguna->id_pengguna,
                "user_name" => $pengguna->nama,
                "user_email" => $pengguna->email,
                "peran_id" => $pengguna->peran_id,
                "logged_in" => true,
            ]);

            // Update last login
            $pengguna->update(["last_login" => now()]);

            // Log aktivitas login
            log_activity("Login ke sistem", "pengguna", $pengguna->id_pengguna);

            return redirect()->route("dashboard");
        }

        return back()
            ->withErrors(["email" => "Email atau password salah"])
            ->withInput();
    }

    public function logout()
    {
        // Log aktivitas logout
        log_activity("Logout dari sistem");

        session()->flush();
        return redirect()->route("home");
    }
}
