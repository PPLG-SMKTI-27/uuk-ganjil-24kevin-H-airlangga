<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Middleware untuk check role specific.
     *
     * Usage: Route::middleware('role:1,2')->group(...)
     *
     * Role ID:
     * 1 = Admin (Full Access)
     * 2 = Staff (Limited Access)
     * 3 = Guru (Read Only - No Admin Access)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles - Role IDs yang diizinkan
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!session("logged_in")) {
            return redirect()
                ->route("login")
                ->with("error", "Silakan login terlebih dahulu");
        }

        // Ambil role_id dari session
        $userRoleId = session("peran_id");

        // Jika tidak ada role yang dispesifikkan, izinkan semua yang sudah login
        if (empty($roles)) {
            return $next($request);
        }

        // Convert role parameters ke array integer
        $allowedRoles = array_map("intval", $roles);

        // Cek apakah user role ada di daftar role yang diizinkan
        if (!in_array($userRoleId, $allowedRoles)) {
            // Log unauthorized access attempt
            if (function_exists("log_activity")) {
                log_activity(
                    "Mencoba akses halaman tanpa izin: " . $request->path(),
                    "pengguna",
                    session("user_id"),
                );
            }

            // Redirect dengan error message
            return redirect()
                ->back()
                ->with(
                    "error",
                    "Anda tidak memiliki izin untuk mengakses halaman ini.",
                )
                ->with("alert_type", "danger");
        }

        return $next($request);
    }

    /**
     * Check if current user is Admin (role_id = 1)
     */
    public static function isAdmin(): bool
    {
        return session("logged_in") && session("peran_id") == 1;
    }

    /**
     * Check if current user is Staff (role_id = 2)
     */
    public static function isStaff(): bool
    {
        return session("logged_in") && session("peran_id") == 2;
    }

    /**
     * Check if current user is Guru (role_id = 3)
     */

    /**
     * Check if current user has admin access (role 1 or 2)
     */
    public static function hasAdminAccess(): bool
    {
        return session("logged_in") && in_array(session("peran_id"), [1, 2]);
    }

    /**
     * Get current user role name
     */
    public static function getRoleName(): string
    {
        if (!session("logged_in")) {
            return "Guest";
        }

        $roleId = session("peran_id");

        $roles = [
            1 => "Admin",
            2 => "Staff",
        ];

        return $roles[$roleId] ?? "Unknown";
    }
}
