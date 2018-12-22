<?php

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

abstract class Controller
{

    public static function init()
    {}


    public static function get_utility_data()
    {
        return array(
            'site_name'        => get_bloginfo( 'name', 'display' ),
            'site_description' => get_bloginfo( 'description', 'display' ),
            'site_url'         => get_home_url( null, '', null ),
            'img_url'          => get_theme_file_uri( 'public/img/' ),
            'current_year'     => date_i18n( 'Y' ),
            'copyright_symbol' => '&copy;',
        );
    }


    public static function get_page_data()
    {
        return array();
    }


} // end of class
