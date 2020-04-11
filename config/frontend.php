<?php

namespace App\config\frontend;

defined('ABSPATH') || exit;

// Actions
add_action( 'wp_head' , __NAMESPACE__ . '\\addHeadMeta' );

// Filters
add_filter( 'body_class'                , __NAMESPACE__ . '\\filterBodyClasses' );
add_filter( 'nav_menu_css_class'        , __NAMESPACE__ . '\\filterNavMenuListItemClasses', 10, 4 );
add_filter( 'nav_menu_link_attributes'  , __NAMESPACE__ . '\\filterNavMenuLinkAtts', 10, 4 );
add_filter( 'use_default_gallery_style' , '__return_false' );

/**
* Add head meta data.
*
* @since 1.0
*/
function addHeadMeta()
{
    $meta = [
        'viewport' => '<meta name="viewport" content="width=device-width, initial-scale=1">', // , shrink-to-fit=no
    ];

    if ($GLOBALS['is_IE']) {
        $meta['ie_edge'] = '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    }

    // Add a pingback url auto-discovery header for singularly identifiable articles.
    if (is_singular() && pings_open()) {
        $meta['pingback'] = '<link rel="pingback" href="' . esc_url(get_bloginfo('pingback_url')) . '">';
    }

    foreach ($meta as $m) echo $m;
}

/**
* Modify <body> class list.
*
* @link  https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans
* @link  https://wptavern.com/wordpress-4-8-will-end-support-for-internet-explorer-versions-8-9-and-10
* @since  1.0
*/
function filterBodyClasses( $classes )
{
	if ( is_singular() ) {
		$classes[] = 'singular';
	} else {
		$classes[] = 'hfeed';
	}

    $woocommerce_blocks = array(
		'woocommerce/featured-product',
		'woocommerce/handpicked-products',
		'woocommerce/product-best-sellers',
		'woocommerce/product-category',
		'woocommerce/product-new',
		'woocommerce/product-on-sale',
		'woocommerce/product-top-rated',
		'woocommerce/products-by-attribute',
	);
	if ( array_filter( array_map( 'has_block', $woocommerce_blocks ) ) ) {
		$classes[] = 'woocommerce-page';
	}

    return array_unique( $classes );
}

/**
* Filter nav menu list item classes.
*
* This filter can be found in wp-includes/class-walker-nav-menu.php
*
* @since  1.0
* @return  array  Numeric array of list item classes.
*/
function filterNavMenuListItemClasses( $classes, $item, $args, $depth )
{
    if ( 'primary' == $args->theme_location ) {
        array_push( $classes, 'menu-item--primary' );
    }

    return $classes;
}

/**
* Filter nav menu link attributes.
*
* This filter can be found in wp-includes/class-walker-nav-menu.php
*
* @since  1.0
* @return  array  Asccociative array of anchor attributes.
*/
function filterNavMenuLinkAtts( $atts, $item, $args, $depth )
{
    $atts['class'] = 'menu-link';

    if ( 'primary' == $args->theme_location ) {
        $atts['class'] .= ' menu-link--primary';

        // if ( 'category' === $item->object ) {
        //     $atts['data-category-id'] = absint( $item->object_id );
        // }
    }

    if ( $item->current ) {
        $atts['class'] .= ' menu-link--active';
    }
    elseif ( $item->current_item_parent ) {
        $atts['class'] .= ' menu-link--active-parent';
        $atts['class'] .= ' menu-link--parent';
    }
    elseif ( $item->current_item_ancestor ) {
        $atts['class'] .= ' menu-link--active-ancestor';
        $atts['class'] .= ' menu-link--ancestor';
    }

    // First, check if "current" is set, which means the item is a nav menu item.
    if ( isset( $item->current ) ) {
        if ( $item->current ) {
            $atts['aria-current'] = 'page';
        }
    }
    // Otherwise, it's a post item, so check if the item is the current post.
    elseif ( ! empty( $item->ID ) ) {
        global $post;
        if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
            $atts['aria-current'] = 'page';
        }
    }

    return $atts;
}
