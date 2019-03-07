<?php

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

use primeraPhpNamespace\Theme;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extension_StringLoader;
use Twig_Extension_Debug;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

abstract class Twig
{

    /**
    * Holds twig instance.
    *
    * @since  1.0
    * @var  object
    */
    private static $_twig;


    /**
    * Holds a reference to the theme's environment.
    *
    * @since  1.0
    * @var  string
    */
    private static $_theme_env;


    /**
    * Holds the path to the cache directory for twig templates.
    *
    * @since  1.0
    * @var  string
    */
    private static $_cache_dir;


    /**
    * Holds the path to the views directory.
    *
    * @since  1.0
    * @var  string
    */
    private static $_views_dir;


    /**
    * Holds Twig setup options.
    *
    * @since  1.0
    * @var  array
    */
    private static $_options;


    /**
    * Holds an array of additional Twig filters.
    *
    * @since  1.0
    * @var  array
    */
    private static $_filters;


    /**
    * Holds an array of additional Twig functions.
    *
    * @since  1.0
    * @var  array
    */
    private static $_functions;


    /**
    * Constructor method.
    *
    * @since  1.0
    * @access  public
    */
    public static function init()
    {
        self::$_theme_env = Theme::get_env();

        // NOTE Was: trailingslashit( wp_get_upload_dir()['basedir'] ).'twig-cache';
        self::$_cache_dir = trailingslashit( get_theme_file_path( '/build/twig' ) );

        self::$_views_dir = trailingslashit( get_theme_file_path( 'templates' ) );

        self::$_options = array(
            'charset'          => get_bloginfo( 'charset' ),
            'autoescape'       => false, //'html',
            'debug'            => 'production' == self::$_theme_env ? false : true,
            'auto_reload'      => 'production' == self::$_theme_env ? false : true,
            'strict_variables' => 'production' == self::$_theme_env ? false : true,
            'cache'            => self::$_cache_dir,
        );

        self::$_filters = array(
            'trailingslashit'    => array( 'trailingslashit' ),
            'tslashit'           => array( 'trailingslashit' ),
            'untrailingslashit'  => array( 'untrailingslashit' ),
            'unslashit'          => array( 'untrailingslashit' ),
            'html_class'         => array( 'sanitize_html_class' ),
            'ltrim'              => array( 'ltrim' ),
            'rtrim'              => array( 'rtrim' ),
            'wpautop'            => array( 'wpautop' ),
            'autop'              => array( 'wpautop' ),
            'number_format_i18n' => array( 'number_format_i18n' ),
            'number_i18n'        => array( 'number_format_i18n' ),
            'apply_filters'      => array( __CLASS__ . '::_apply_filters' ),
            'time_ago'           => array( __CLASS__ . '::_time_ago' ),
            // 'trim_words'         => array( __CLASS__ . '::trim_words' ),
        );

        self::$_functions = array(
            'enqueue_script' => [ __CLASS__ . '::_enqueue_script' ],
            'have_posts' => [ 'have_posts' ],
            'the_post'   => [ 'the_post' ],
            // 'do_action' => array( __CLASS__ . '::_do_action', array('needs_context'=>true) ),
        );

        self::_init_twig();
    }


    public static function render_string( $string, $context )
    {
        $template = self::$_twig->createTemplate( $string );

        return $template->render( $context );
    }


    // @param  array|string  $template_files  A sting or an array of template file names. First template found will get used.
    public static function render( $template_files, $context )
    {
        $template = self::_choose_template( $template_files );

        return self::$_twig->render( "$template.twig", $context );
    }


    public static function display( $template_files, $context )
    {
        echo self::render( $template_files, $context );
    }


    private static function _choose_template( $paths )
    {
        if ( is_array( $paths ) ) {

            foreach ( $paths as $path ) {

                $file_path = trailingslashit( parent::$templates_dir ) . $path;

                if ( file_exists( $file_path ) ) {
                    return $path;
                }
            }

            return $paths[0];
        }

        return $paths;
    }


    public static function _init_twig()
    {
        // Make sure the cache directory exists.
        if ( ! wp_is_writable( self::$_cache_dir ) ) {
            wp_mkdir_p( self::$_cache_dir );
        }

        self::$_twig = new Twig_Environment(
            new Twig_Loader_Filesystem( self::$_views_dir ),
            self::$_options
        );

        // Add twig string-loader extension.
        // This makes the template_from_string() function available within templates.
        // twig.sensiolabs.org/doc/functions/template_from_string.html
        self::$_twig->addExtension( new Twig_Extension_StringLoader );

        // Add Twig debug extension.
        // This makes the dump() function available within templates.
        // twig.sensiolabs.org/doc/functions/dump.html
        if ( 'production' != self::$_theme_env ) {
            self::$_twig->addExtension( new Twig_Extension_Debug );
        }

        // NOTE Uncomment to clear cache files. Left here for reference.
        // self::$_twig->clearCacheFiles();

        // Add filters.
        foreach ( self::$_filters as $name => $val ) {

            if ( ! is_array( $val ) || ! is_callable( $val[ 0 ] ) ) {
                continue;
            }

            self::$_twig->addFilter(
                new Twig_SimpleFilter( $name, $val[ 0 ] ),
                isset($val[1]) && is_array($val[1]) ? $val[1] : []
            );
        }

        // Add functions.
        foreach ( self::$_functions as $name => $val ) {

            if ( ! is_array( $val ) || ! is_callable( $val[ 0 ] ) ) {
                continue;
            }

            self::$_twig->addFunction(
                new Twig_SimpleFunction( $name, $val[ 0 ] ),
                isset($val[1]) && is_array($val[1]) ? $val[1] : []
            );
        }
    }


    public static function _time_ago( $date, $suffix=true )
    {
        $date = new DateTime( $date );
        $r = human_time_diff( $date->format('U'), current_time('timestamp') );
        if ( $suffix ) {
            /* translators: Suffix for time_ago filter */
            return $r .' '. __('ago', 'novathemer-theme');
        }
        return $r;
    }


    public static function _do_action( $context )
    {
        $args = func_get_args();

        // Remove first arg.
        array_shift( $args );

        $args[] = $context;

        call_user_func_array( 'do_action', $args );
    }


    public static function _enqueue_script( $script_name )
    {
        if ( strpos( $script_name, '.css' ) ) {

            // TODO Print, not enqueue (wp_add_inline_script?)
            // wp_enqueue_style( get_parent_theme_file_uri( "assets/css/$script_name" ) );
        }
        else {

            // TODO Print, not enqueue (wp_add_inline_script?)
            // wp_enqueue_style( get_parent_theme_file_uri( "assets/js/$script_name" ) );
        }
    }


} // end of class
