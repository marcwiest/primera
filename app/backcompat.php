<?php

defined('ABSPATH') || exit;

if (! function_exists('wp_body_open')) :
// Backward compatibility.
function wp_body_open()
{
    do_action( 'wp_body_open' );
}
endif;
