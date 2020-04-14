<?php

namespace App\config\theme;

defined('ABSPATH') || exit;

// Actions
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\loadThemeTextdomain' );
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addThemeSupport' );
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\defineImageSizes' );
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\registerNavMenus' );
add_action( 'widgets_init'      , __NAMESPACE__ . '\\registerSidebars' );

// Filters
add_filter( 'widget_tag_cloud_args' , __NAMESPACE__ . '\\filterTagCloudArgs' );

/**
* Load text domain.
* Text domain should match theme folder name.
*
* @since 1.0
*/
function loadThemeTextdomain()
{
    load_theme_textdomain(
        env('TEXT_DOMAIN', 'text-domain'),
        get_theme_file_path('languages')
    );
}

/**
* Add theme support.
* @since  1.0
*/
function addThemeSupport()
{
	// Filter theme content width global.
    $GLOBALS['content_width'] = 1200;

    // Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

    // Tell WordPress to use HTML5 markup.
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ]);

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add custom logo support. Usage: the_custom_logo(); https://codex.wordpress.org/Theme_Logo
	// add_theme_support('custom-logo', [
    //     'height'      => 190,
    //     'width'       => 190,
    //     'flex-width'  => true,
    //     'flex-height' => true,
    // ]);
}

/**
* Define thumbnail image size and register custom image sizes.
* @since 1.0
*/
function defineImageSizes()
{
    // Override "post-thumbnail" default size (150x150).
    // set_post_thumbnail_size( 300, 300, true );

    // Uncomment to register custom image sizes.
    // $imageSizes = [
    //     '100vw' => [2000],
    //     '16:9'  => [1600, (1600/16*9), true],
    // ];
    // foreach ( $imageSizes as $name => $size ) {
    //     add_image_size( $name, $size[0], $size[1] ?? 9999, $size[2] ?? false );
    // }
}

/**
* Register nav menus.
* @since 1.0
*/
function registerNavMenus()
{
    register_nav_menus( array(
        'primary' => esc_html__('Primary Menu','primeraTextDomain'),
    ) );
}

/**
* Register Sidebars
*/
function registerSidebars()
{
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
    ];
    register_sidebar([
        'id'          => 'primary',
        'name'        => __('Primary', 'primeraTextDomain'),
        'description' => '',
    ] + $config);
}

/**
* Modify Tag Cloud widget arguments.
*
* @since  1.0
*/
function filterTagCloudArgs( $args )
{
    $args['number']    = 18;
    $args['smallest']  = 1;
    $args['largest']   = 1;
    $args['unit']      = 'rem';
    $args['format']    = 'flat'; // list or flat (custom classes only work with flat)
    $args['separator'] = "\n";
    $args['orderby']   = 'count'; // name (alphabetical) or count (popularity)
    $args['order']     = 'ASC';

    return $args;
}
