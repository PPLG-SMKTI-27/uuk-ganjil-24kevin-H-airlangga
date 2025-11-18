<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomAuth
{
    /**
     * Handle an incoming request.
     * Hanya user dengan role_id 1 (Admin) dan 2 (Staff) yang bisa akses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!session("logged_in")) {
            return redirect()
                ->route("login")
                ->with("error", "Silakan login terlebih dahulu");
        }

        // Cek role_id: hanya role 1 (Admin) dan 2 (Staff) yang diizinkan
        $peranId = session("peran_id");

        if (!in_array($peranId, [1, 2])) {
            // Logout user yang tidak berhak
            session()->flush();

            return redirect()
                ->route("login")
                ->withErrors([
                    "email" =>
                        "Akses ditolak. Anda tidak memiliki izin untuk mengakses panel admin.",
                ]);
        }

        return $next($request);
    }
}
