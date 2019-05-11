<?php

namespace App\Classes;

use Windwalker\Renderer\BladeRenderer;

// Exit if accessed directly.
defined('ABSPATH') || exit;

class Renderer
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
        self::$_view_dir = get_theme_file_path( 'soruce/views' );
    }

    /**
	* Performs view render.
	* If there is $view attribute presented, it will render requested view.
	* If it's not it will try to find necessary view based on $wp_query.
	*
	* @param  string|null $view View path in blade format, ex: single, layout.default, single.partials.slider and etc.
	* @param  array|null  $data Additional params.
	* @return void
	*/
    public static function render( $view=null, $data=[] )
    {
        $renderer = new BladeRenderer();
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
    public static function _render( $_view_file_name )
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
