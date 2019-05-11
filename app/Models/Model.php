<?php

namespace App\Models;

// Exit if accessed directly.
defined('ABSPATH') || exit;

class Model
{

    public static function init()
    {}


    public static function get_utility_data(): array
    {
        return array(
            'siteName'        => get_bloginfo( 'name', 'display' ),
            'siteDescription' => get_bloginfo( 'description', 'display' ),
            'siteCharset'     => get_bloginfo( 'charset', 'display' ),
            'langAtts'        => get_language_attributes( 'html' ),
            'bodyClass'       => 'class="' . join( ' ', get_body_class() ) . '"',
            'y' => date_i18n( 'Y' ), // current year
            'c' => '&copy;',         // copyright symbol
        );
    }


    public static function get_header_data(): array
    {
        return [
            'logoUrl'         => '',
            'primaryNavItems' => wp_get_nav_menu_items( 'primary', [
                'order'       => 'ASC',
                'orderby'     => 'menu_order',
                'post_type'   => 'nav_menu_item',
                'post_status' => 'publish',
                'output'      => ARRAY_A,
                'output_key'  => 'menu_order',
                'nopaging'    => true,
            ]),
        ];
    }


    public static function get_page_data(): array
    {
        $data = [];

        return array_merge(
            self::get_utility_data(),
            self::get_header_data(),
            $data
        );
    }


} // end of class
