<?php

/**
* Handles theme setup.
*/
abstract class primeraObjectPrefix_Theme
{

    /**
    * Initialize theme.
    *
    * @since  1.0
    */
    public static function init()
    {
        add_action( 'after_setup_theme'         , __CLASS__ . '::_set_global_content_width' );
        add_action( 'after_setup_theme'         , __CLASS__ . '::_load_theme_textdomain' );
        add_action( 'wp_head'                   , __CLASS__ . '::_add_head_meta' );
        add_action( 'after_setup_theme'         , __CLASS__ . '::_add_theme_support' );
        add_action( 'after_setup_theme'         , __CLASS__ . '::_add_gutenberg_support' );
        add_action( 'wp_enqueue_scripts'        , __CLASS__ . '::_register_scripts' );
        add_action( 'wp_enqueue_scripts'        , __CLASS__ . '::_enqueue_frontend_scripts' );
        add_action( 'after_setup_theme'         , __CLASS__ . '::_register_nav_menus' );
        add_action( 'widgets_init'              , __CLASS__ . '::_register_sidebars' );

        add_filter( 'widget_tag_cloud_args'     , __CLASS__ . '::_filter_tag_cloud_args' );
        add_filter( 'nav_menu_css_class'        , __CLASS__ . '::_filter_nav_menu_list_item_classes', 10, 4 );
        add_filter( 'nav_menu_link_attributes'  , __CLASS__ . '::_filter_nav_menu_link_atts', 10, 4 );
        add_filter( 'login_headerurl'           , __CLASS__ . '::_filter_login_url' );
        add_filter( 'login_headertitle'         , __CLASS__ . '::_filter_login_title' );
    }


    /**
    * Get current environment.
    *
    * @since  1.0
    */
    public static function get_env()
    {
        if ( in_array( $_SERVER['REMOTE_ADDR'], array( '::1', '127.0.0.1' ) ) ) {

            return 'local';
        }
        elseif ( '%development-url%' == $_SERVER['HTTP_HOST'] ) {

            return 'development';
        }
        elseif ( '%staging-url%' == $_SERVER['HTTP_HOST'] ) {

            return 'staging';
        }

        return 'production';
    }


    /**
    * Get theme version.
    *
    * Varies based on the current environment.
    *
    * @since  1.0
    */
    public static function get_version()
    {
        $version = trim( strval( wp_get_theme()->get('Version') ) );

        $is_debug = defined('WP_DEBUG') && WP_DEBUG;

        $is_production = 'production' == self::get_env();

        if ( $is_debug || ! $is_production || ! $version ) {
            return time();
        }

        return $version;
    }


    /**
    * Set global content width.
    *
    * @since  1.0
    */
    public static function _set_global_content_width()
    {
        $GLOBALS['content_width'] = 840;
    }


    /**
    * Load text domain.
    *
    * Text domain should match theme folder name.
    *
    * @since  1.0
    */
    public static function _load_theme_textdomain()
    {
        load_theme_textdomain( 'primeraTextDomain', get_stylesheet_directory().'/languages' );
    }


    /**
    * Add head meta.
    *
    * @since  1.0
    */
    public static function _add_head_meta()
    {
        $meta = array(
            'viewport' => '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">',
        );

        if ( $GLOBALS['is_IE'] ) {
            $meta['ie_edge'] = '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    	}

        $meta = apply_filters( 'primeraFunctionPrefix_head_meta', $meta );

        foreach ( $meta as $m ) {
            echo $m;
        }
    }


    /**
    * Add theme support.
    *
    * @since  1.0
    */
    public static function _add_theme_support()
    {
    	# WordPress
    	add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption') );
        add_theme_support( 'automatic-feed-links' ); // adds posts and comments RSS feed links
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'customize-selective-refresh-widgets' );

        # Add WooCommerce support.
        // add_theme_support( 'woocommerce' );

        # Override "post-thumbnail" default size (150x150).
    	// set_post_thumbnail_size( 300, 300, true );

    	# Add custom image size (16:9).
    	// add_image_size( 'homepage-banner', 1680, (1680/16*9) );

        # Add logo support. Usage: the_custom_logo();
        // add_theme_support( 'custom-logo' );
    }


    /**
    * Add Gutenberg support.
    *
    * @link  wordpress.org/gutenberg/handbook/extensibility/theme-support/
    * @since  1.0
    */
    public static function _add_gutenberg_support()
    {
    	// Wide aligned images.
        // add_theme_support( 'align-wide' );

        // Disable custom color picker.
        // add_theme_support( 'disable-custom-colors' );

        // Color palette.
        add_theme_support( 'editor-color-palette', array(
            array(
                'name'  => __( 'Dusty orange', 'lane-orsak' ),
                'slug'  => 'dusty-orange',
                'color' => '#ed8f5b',
            ),
            array(
                'name'  => __( 'Dusty red', 'lane-orsak' ),
                'slug'  => 'dusty-red',
                'color' => '#e36d60',
            ),
            array(
                'name'  => __( 'Dusty wine', 'lane-orsak' ),
                'slug'  => 'dusty-wine',
                'color' => '#9c4368',
            ),
            array(
                'name'  => __( 'Dark sunset', 'lane-orsak' ),
                'slug'  => 'dark-sunset',
                'color' => '#33223b',
            ),
            array(
                'name'  => __( 'Almost black', 'lane-orsak' ),
                'slug'  => 'almost-black',
                'color' => '#0a1c28',
            ),
            array(
                'name'  => __( 'Dusty water', 'lane-orsak' ),
                'slug'  => 'dusty-water',
                'color' => '#41848f',
            ),
            array(
                'name'  => __( 'Dusty sky', 'lane-orsak' ),
                'slug'  => 'dusty-sky',
                'color' => '#72a7a3',
            ),
            array(
                'name'  => __( 'Dusty daylight', 'lane-orsak' ),
                'slug'  => 'dusty-daylight',
                'color' => '#97c0b7',
            ),
            array(
                'name'  => __( 'Dusty sun', 'lane-orsak' ),
                'slug'  => 'dusty-sun',
                'color' => '#eee9d1',
            ),
        ) );

        // Font sizes.
        add_theme_support( 'editor-font-sizes', array(
            array(
                'name' => __( 'small', 'lane-orsak' ),
                'shortName' => __( 'S', 'lane-orsak' ),
                'size' => 12,
                'slug' => 'small'
            ),
            array(
                'name' => __( 'regular', 'lane-orsak' ),
                'shortName' => __( 'M', 'lane-orsak' ),
                'size' => 16,
                'slug' => 'regular'
            ),
            array(
                'name' => __( 'large', 'lane-orsak' ),
                'shortName' => __( 'L', 'lane-orsak' ),
                'size' => 36,
                'slug' => 'large'
            ),
        ) );
    }


    /**
    * Register scripts for later use.
    *
    * @since 1.0
    */
    public static function _register_scripts()
    {
        wp_register_script(
            'font-awesome',
            'https://use.fontawesome.com/releases/v5.0.13/js/all.js',
            array(),
            '5.0.13',
            true
        );

        wp_register_script(
            'bx-slider',
            'https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js',
            array( 'jquery' ),
            '4.2.12',
            true
        );
    }


    /**
    * Enqueue frontend scripts.
    *
    * @since 1.0
    */
    public static function _enqueue_frontend_scripts()
    {
        $version = self::get_version();

    	wp_enqueue_style(
    		'primeraFunctionPrefix',
    		get_stylesheet_uri(),
    		array(),
    		$version
    	);

    	wp_enqueue_script(
    		'primeraFunctionPrefix',
    		get_theme_file_uri( 'script.js' ),
    		array(
                'wp-util' // jQuery, undescore, wp
                // 'hoverIntent', // briancherne.github.io/jquery-hoverIntent
                // 'imagesloaded', // imagesloaded.desandro.com
                // 'font-awesome',
                // 'bx-slider'
            ),
    		$version,
    		true
    	);

    	wp_localize_script(
    		'primeraFunctionPrefix',
    		'primeraFunctionPrefixLocalizedData',
    		array(
    			'ajaxUrl'   => esc_url_raw( admin_url('admin-ajax.php') ),
    			'restUrl'   => esc_url_raw( rest_url('/primeraTextDomain/v1/') ),
    			'ajaxNonce' => wp_create_nonce( 'wp_ajax' ),
    			'restNonce' => wp_create_nonce( 'wp_rest' ), // must be named: wp_rest
    		)
    	);

    	if ( is_singular() && comments_open() && get_option('thread_comments') ) {
    		wp_enqueue_script('comment-reply');
    	}
    }


    /**
    * Register nav menus.
    *
    * @since  1.0
    */
    public static function _register_nav_menus()
    {
    	register_nav_menus( array(
    		'primary'  => esc_html__('Primary Menu','primeraTextDomain'),
    		'colophon' => esc_html__('Colophon Menu','primeraTextDomain'),
    	) );
    }


    /**
    * Register sidebars.
    *
    * @since  1.0
    */
    public static function _register_sidebars()
    {
    	register_sidebar( array(
    		'id'            => 'primary',
    		'name'          => esc_html__('Main Sidebar','primeraTextDomain'),
    		'description'   => '',
    		'before_widget' => '<div id="%1$s" class="primeraCssPrefix-widget primeraCssPrefix-widget-content widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => apply_filters( 'primeraFunctionPrefix_before_widget_title', '<h4 class="widget-title">' ),
    		'after_title'   => apply_filters( 'primeraFunctionPrefix_after_widget_title', '</h4>' ),
    	) );

    	register_sidebar( array(
    		'id'            => 'offcanvas',
    		'name'          => esc_html__('Off Canvas','primeraTextDomain'),
    		'description'   => '',
    		'before_widget' => '<div id="%1$s" class="primeraCssPrefix-widget primeraCssPrefix-widget-off-canvas widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => apply_filters( 'primeraFunctionPrefix_before_widget_title', '<h4 class="widget-title">' ),
    		'after_title'   => apply_filters( 'primeraFunctionPrefix_after_widget_title', '</h4>' ),
    	) );
    }


    /**
    * Modify Tag Cloud widget arguments.
    *
    * @since  1.0
    */
    public static function _filter_tag_cloud_args( $args )
    {
    	$args['number']    = 24;
    	$args['smallest']  = 14;
    	$args['largest']   = 14;
    	$args['unit']      = 'px';
    	$args['format']    = 'flat'; // list / flat (custom classes only work with flat)
    	$args['separator'] = "\n";
    	$args['orderby']   = 'count'; // name(alphabetical) / count(popularity)
    	$args['order']     = 'ASC';

    	return $args;
    }


    /**
    * Filter nav menu list item classes.
    *
    * This filter can be found in wp-includes/class-walker-nav-menu.php
    *
    * @since  1.0
    * @return  array  Numeric array of list item classes.
    */
    public static function _filter_nav_menu_list_item_classes( $classes, $item, $args, $depth )
    {
    	if ( 'primary' == $args->theme_location ) {
    		array_push( $classes, 'primeraCssPrefix-menu-item--primary' );
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
    public static function _filter_nav_menu_link_atts( $atts, $item, $args, $depth )
    {
    	if ( 'primary' == $args->theme_location ) {
    		$atts['class'] = 'primeraCssPrefix-menu-link--primary';
    	}

    	return $atts;
    }


    /**
    * Changing the logo link from wordpress.org to home_url.
    *
    * @since  1.0
    */
    public static function _filter_login_url()
    {
    	return esc_url( home_url('/') );
    }


    /**
    * Changing the alt text on the logo to show your site name.
    *
    * @since  1.0
    */
    public static function _filter_login_title()
    {
    	return esc_attr( get_bloginfo('name') );
    }


} // end of class
