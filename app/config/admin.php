<?php

namespace App\config\admin;

defined('ABSPATH') || exit;

// Actions
// https://make.wordpress.org/core/2020/02/25/wordpress-5-4-introduces-new-hooks-to-add-custom-fields-to-menu-items/
// add_action( 'wp_nav_menu_item_custom_fields' , __NAMESPACE__ . '\\wporg_my_custom_field', 10, 5 );

// Filters
add_filter( 'login_headerurl'  , __NAMESPACE__ . '\\filterLoginUrl' );
add_filter( 'login_headertext' , __NAMESPACE__ . '\\filterLoginHeaderText' );

/**
* Changing the logo link from wordpress.org to home_url.
*
* @since  1.0
*/
function filterLoginUrl()
{
    return esc_url( home_url('/') );
}

/**
* Changing the alt text on the logo to show your site name.
*
* @since  1.0
*/
function filterLoginHeaderText()
{
    return esc_attr( get_bloginfo('name') );
}
