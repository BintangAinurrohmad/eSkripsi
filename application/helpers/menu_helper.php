<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('set_active')) {
    function set_active($uri_segment)
    {
        $CI = &get_instance();
        $current_uri = $CI->uri->uri_string();

        if ($CI->uri->segment(1) == $uri_segment || $CI->uri->segment(2) == $uri_segment) {
            return 'active';
        }

        if (strpos($current_uri, $uri_segment) !== false) {
            return 'active';
        }

        return 'collapsed';
    }
}

if (!function_exists('is_dropdown_active')) {
    function is_dropdown_active($uri_segments = [])
    {
        foreach ($uri_segments as $segment) {
            if (set_active($segment) == 'active') {
                return 'show';
            }
        }
        return '';
    }
}

if (!function_exists('set_active_specific')) {
    function set_active_specific($uri_segments = [])
    {
        $CI = &get_instance();
        $current_uri = $CI->uri->uri_string();

        foreach ($uri_segments as $segment) {
            if (strpos($current_uri, $segment) === 0) {
                return 'active';
            }
        }

        return 'collapsed';
    }
}
