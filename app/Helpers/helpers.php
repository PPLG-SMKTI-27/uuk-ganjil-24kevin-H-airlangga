<?php

if (!function_exists('current_user')) {
    /**
     * Get current logged in user from session
     *
     * @return \App\Models\Pengguna|null
     */
    function current_user()
    {
        $userId = session('user_id');

        if (!$userId) {
            return null;
        }

        return \App\Models\Pengguna::with('peran')
            ->where('id_pengguna', $userId)
            ->first();
    }
}

if (!function_exists('current_user_id')) {
    /**
     * Get current logged in user ID from session
     *
     * @return int|null
     */
    function current_user_id()
    {
        return session('user_id');
    }
}

if (!function_exists('current_user_name')) {
    /**
     * Get current logged in user name from session
     *
     * @return string|null
     */
    function current_user_name()
    {
        return session('user_name');
    }
}

if (!function_exists('current_user_email')) {
    /**
     * Get current logged in user email from session
     *
     * @return string|null
     */
    function current_user_email()
    {
        return session('user_email');
    }
}

if (!function_exists('is_logged_in')) {
    /**
     * Check if user is logged in
     *
     * @return bool
     */
    function is_logged_in()
    {
        return session('logged_in', false) === true;
    }
}

if (!function_exists('user_has_role')) {
    /**
     * Check if current user has specific role
     *
     * @param string $roleName
     * @return bool
     */
    function user_has_role($roleName)
    {
        $user = current_user();

        if (!$user || !$user->peran) {
            return false;
        }

        return strtolower($user->peran->nama_peran) === strtolower($roleName);
    }
}
