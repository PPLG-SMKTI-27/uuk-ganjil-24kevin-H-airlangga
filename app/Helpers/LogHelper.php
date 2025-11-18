<?php

if (!function_exists('log_activity')) {
    /**
     * Log user activity untuk audit trail
     *
     * @param string $aktivitas Deskripsi aktivitas
     * @param string|null $tabel_terkait Nama tabel yang terkait
     * @param int|null $id_record ID record yang terkait
     * @return void
     */
    function log_activity($aktivitas, $tabel_terkait = null, $id_record = null)
    {
        try {
            $userId = current_user_id();

            if (!$userId) {
                return; // Skip jika user tidak login
            }

            \App\Models\LogAktivitas::create([
                'id_pengguna' => $userId,
                'aktivitas' => $aktivitas,
                'tabel_terkait' => $tabel_terkait,
                'id_record' => $id_record,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Silent fail - jangan ganggu proses utama
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}

if (!function_exists('get_recent_activities')) {
    /**
     * Get recent activities untuk dashboard
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_recent_activities($limit = 10)
    {
        return \App\Models\LogAktivitas::with('pengguna')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

if (!function_exists('get_user_activities')) {
    /**
     * Get activities untuk user tertentu
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_user_activities($userId, $limit = 10)
    {
        return \App\Models\LogAktivitas::where('id_pengguna', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
