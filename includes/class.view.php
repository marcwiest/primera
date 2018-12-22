<?php

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

abstract class View
{

    /**
    * Holds the directory path to the views.
    *
    * @since  1.0
    * @var  string
    */
    private static $_view_dir;


    /**
    * Constructor method.
    *
    * @since  1.0
    */
    public static function init()
    {
        self::$_view_dir = get_theme_file_path( 'views' );
    }

    /**
    * Renders a model.
    *
    * Use instead of WP's get_template_part(). WP's load_template() is the blueprint for this method.
    *
    * @since  1.0
    * @link  https://developer.wordpress.org/reference/functions/load_template/
    * @param  string  $_view_file_name  The name of the PHP file that holds the model.
    * @return  void
    */
    public static function render( $_view_file_name )
    {
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    	if ( is_array( $wp_query->query_vars ) ) {
    		extract( $wp_query->query_vars, EXTR_SKIP );
    	}

    	if ( isset( $s ) ) {
    		$s = esc_attr( $s );
    	}

        $_view_file_name = rtrim( $_view_file_name, '.php' );

        require trailingslashit( self::$_view_dir ) . "$_view_file_name.php";
    }


    private static function get_site_data()
    {
        return array();
    }


} // end of class
