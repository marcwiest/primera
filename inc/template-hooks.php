<?php /*
This file distributes template functions via hooks.
*/

/**
* Header
*/
add_action( 'primera/header', 'primera_site_tag_open', 1 );
add_action( 'primera/header', 'primera_site_canvas_tag_open', 5 );
add_action( 'primera/header', 'primera_header' );

/**
* Index
*/
add_action( 'primera/index', 'primera_main_content_tag_open', 1 );
add_action( 'primera/index', 'primera_entries' );
add_action( 'primera/index', 'primera_sidebar' );
add_action( 'primera/index', 'primera_main_content_tag_open', 9999 );

/**
* Footer
*/
add_action( 'primera/footer', 'primera_colophon' );
add_action( 'primera/footer', 'primera_site_canvas_tag_close', 9995 );
add_action( 'primera/footer', 'primera_site_tag_close', 9999 );
