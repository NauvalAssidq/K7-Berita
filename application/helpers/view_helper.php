<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Loads a view with a common layout.
 *
 * @param string $view The view file to load
 * @param array $data Data to pass to the view
 * @param string $layout Optional layout name (defaults to 'layout')
 */
if ( ! function_exists('load_view')) {
    function load_view($view, $data = array(), $layout = 'layout') {
        $CI =& get_instance();
        $CI->load->view("layouts/{$layout}_header", $data);
        $CI->load->view($view, $data);
        $CI->load->view("layouts/{$layout}_footer", $data);
    }
}
