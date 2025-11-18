<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Get current user profile data
     */
    public function show()
    {
        $user = current_user();

        if (!$user) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "User tidak ditemukan dalam session",
                ],
                401,
            );
        }

        return response()->json([
            "success" => true,
            "data" => [
                "id_pengguna" => $user->id_pengguna,
                "nama" => $user->nama,
                "email" => $user->email,
                "peran" => $user->peran ? $user->peran->nama_peran : "User",
                "last_login" => $user->last_login
                    ? date("d M Y, H:i", strtotime($user->last_login))
                    : "-",
            ],
        ]);
    }

    /**
     * Update user profile (name, email, and optionally password)
     */
    public function update(Request $request)
    {
        try {
            $user = current_user();

            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User tidak ditemukan dalam session",
                    ],
                    401,
                );
            }

            // Validasi input
            $validated = $request->validate(
                [
                    "nama" => ["required", "string", "max:100"],
                    "email" => [
                        "required",
                        "email",
                        "max:100",
                        Rule::unique("pengguna", "email")->ignore(
                            $user->id_pengguna,
                            "id_pengguna",
                        ),
                    ],
                    "password_lama" => ["nullable", "string"],
                    "password_baru" => [
                        "nullable",
                        "string",
                        "min:6",
                        "confirmed",
                    ],
                ],
                [
                    "nama.required" => "Nama harus diisi",
                    "email.required" => "Email harus diisi",
                    "email.email" => "Format email tidak valid",
                    "email.unique" => "Email sudah digunakan",
                    "password_baru.min" => "Password minimal 6 karakter",
                    "password_baru.confirmed" =>
                        "Konfirmasi password tidak cocok",
                ],
            );

            // Update nama dan email
            $user->nama = $validated["nama"];
            $user->email = $validated["email"];

            // Jika user ingin ganti password
            if ($request->filled("password_baru")) {
                // Cek password lama
                if (!$request->filled("password_lama")) {
                    return response()->json(
                        [
                            "success" => false,
                            "message" =>
                                "Password lama harus diisi untuk mengganti password",
                        ],
                        422,
                    );
                }

                // Verify password lama
                if (!Hash::check($request->password_lama, $user->password)) {
                    return response()->json(
                        [
                            "success" => false,
                            "message" => "Password lama tidak sesuai",
                        ],
                        422,
                    );
                }

                // Update password baru
                $user->password = Hash::make($validated["password_baru"]);
            }

            $user->save();

            // Update session dengan data baru
            session([
                "user_name" => $user->nama,
                "user_email" => $user->email,
            ]);

            // Log aktivitas
            $logMessage = "Mengupdate profile";
            if ($request->filled("password_baru")) {
                $logMessage .= " dan mengganti password";
            }
            log_activity($logMessage, "pengguna", $user->id_pengguna);

            return response()->json([
                "success" => true,
                "message" => "Profile berhasil diperbarui",
                "data" => [
                    "nama" => $user->nama,
                    "email" => $user->email,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Validasi gagal",
                    "errors" => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Terjadi kesalahan: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Change user password only
     */
    public function changePassword(Request $request)
    {
        try {
            $user = current_user();

            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User tidak ditemukan dalam session",
                    ],
                    401,
                );
            }

            $validated = $request->validate(
                [
                    "password_lama" => ["required", "string"],
                    "password_baru" => [
                        "required",
                        "string",
                        "min:6",
                        "confirmed",
                    ],
                ],
                [
                    "password_lama.required" => "Password lama harus diisi",
                    "password_baru.required" => "Password baru harus diisi",
                    "password_baru.min" => "Password minimal 6 karakter",
                    "password_baru.confirmed" =>
                        "Konfirmasi password tidak cocok",
                ],
            );

            // Verify password lama
            if (!Hash::check($validated["password_lama"], $user->password)) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Password lama tidak sesuai",
                    ],
                    422,
                );
            }

            // Update password
            $user->password = Hash::make($validated["password_baru"]);
            $user->save();

            // Log aktivitas
            log_activity("Mengganti password", "pengguna", $user->id_pengguna);

            return response()->json([
                "success" => true,
                "message" => "Password berhasil diubah",
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Validasi gagal",
                    "errors" => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Terjadi kesalahan: " . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
