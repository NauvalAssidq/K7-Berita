<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Check if the current user has a specific role.
 *
 * @param string $role Role to check (e.g., ROLE_ADMIN)
 * @return bool Returns TRUE if the user has the required role, FALSE otherwise.
 */
if ( ! function_exists('has_role')) {
    function has_role($role) {
        $CI =& get_instance();
        $user_role = $CI->session->userdata('role');
        return ($user_role === $role);
    }
}

/**
 * Check if a user is logged in.
 *
 * @return bool Returns TRUE if logged in, FALSE otherwise.
 */
if ( ! function_exists('is_user_logged_in')) {
    function is_user_logged_in() {
        $CI =& get_instance();
        return ($CI->session->userdata('logged_in') === TRUE);
    }
}
