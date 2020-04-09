<?php

defined('ABSPATH') || exit;

if (! function_exists('wp_body_open')) :
function wp_body_open()
{
    do_action('wp_body_open');
}
endif;

if (! function_exists('apply_shortcodes')) :
function apply_shortcodes($string)
{
    do_shortcode($string);
}
endif;
