<?php /*
This file distributes template functions via hooks.
*/

/**
* Header
*/
add_action( 'primera/header', 'primera_site_wrapper_tag_open' );
add_action( 'primera/header', 'primera_site_tag_open' );
add_action( 'primera/header', 'primera_header' );

/**
* Index
*/
add_action( 'primera/index', 'primera_index' );

/**
* Footer
*/
add_action( 'primera/footer', 'primera_footer' );
add_action( 'primera/footer', 'primera_site_wrapper_tag_close' );
add_action( 'primera/footer', 'primera_site_tag_close' );
