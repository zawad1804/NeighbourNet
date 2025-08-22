<?php

if (!function_exists('user_avatar')) {
    /**
     * Get the user's avatar URL or return a default avatar if not set
     *
     * @param  \App\Models\User|null  $user
     * @param  string  $size  sm|md|lg
     * @return string
     */
    function user_avatar($user = null, $size = 'md')
    {
        // Default image paths for different sizes
        $defaults = [
            'sm' => secure_url_asset('images/avatars/default-lg.png'),
            'md' => secure_url_asset('images/avatars/default-avater.jpg'),
            'lg' => secure_url_asset('images/avatars/default-avater.jpg'),
        ];

        // If no user is provided, return default
        if (!$user) {
            return $defaults[$size] ?? $defaults['md'];
        }

        // If user has an avatar, return it
        if ($user->avatar) {
            return secure_url_asset('storage/' . $user->avatar);
        }

        // Generate a custom default avatar based on user's name initials using ui-avatars.com
        $name = $user->name ?? 'User';
        return "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=4a6fa5&color=fff&size=150";
    }
}
