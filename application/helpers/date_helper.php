<?php
if (!function_exists('time_ago')) {
    /**
     * Converts a date to a human-readable "time ago" format
     * 
     * @param string $date_str Date string or timestamp
     * @return string
     */
    function time_ago($date_str) {
        $date = new DateTime($date_str);
        $now = new DateTime();
        $interval = $date->diff($now);

        if ($interval->y >= 1) {
            return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
        } elseif ($interval->m >= 1) {
            return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
        } elseif ($interval->d >= 1) {
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
        } elseif ($interval->h >= 1) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
        } elseif ($interval->i >= 1) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }
}