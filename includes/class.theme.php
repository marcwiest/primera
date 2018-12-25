<?php

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
* Handles frontend & theme setup.
*/
abstract class Theme
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

        add_filter( 'body_class'                , __CLASS__ . '::_filter_body_classes' );
        add_filter( 'widget_tag_cloud_args'     , __CLASS__ . '::_filter_tag_cloud_args' );
        add_filter( 'nav_menu_css_class'        , __CLASS__ . '::_filter_nav_menu_list_item_classes', 10, 4 );
        add_filter( 'nav_menu_link_attributes'  , __CLASS__ . '::_filter_nav_menu_link_atts', 10, 4 );
        add_filter( 'page_menu_link_attributes' , __CLASS__ . '::_filter_nav_menu_link_atts', 10, 4 );
        add_filter( 'login_headerurl'           , __CLASS__ . '::_filter_login_url' );
        add_filter( 'login_headertitle'         , __CLASS__ . '::_filter_login_title' );
        add_filter( 'script_loader_tag'         , __CLASS__ . '::_filter_script_loader_tag', 10, 2 );
    }


    /**
    * Get current environment.
    *
    * TODO: Replace %% strings with theme-config.json values.
    * @since  1.0
    */
    public static function get_env()
    {
        if ( in_array( $_SERVER['REMOTE_ADDR'], array( '::1', '127.0.0.1' ) ) ) {

            return 'local';
        }
        elseif ( in_array( '%development-url%', array( $_SERVER['SERVER_NAME'], $_SERVER['HTTP_HOST'] ) ) ) {

            return 'development';
        }
        elseif ( in_array( '%staging-url%', array( $_SERVER['SERVER_NAME'], $_SERVER['HTTP_HOST'] ) ) ) {

            return 'staging';
        }

        return 'production';
    }


    /**
    * Is production environment.
    *
    * @since  1.0
    * @return  bool  True if in production environment, false otherwise.
    */
    public static function is_env_prod()
    {
        if ( 'production' == self::get_env() ) {
            return true;
        }

        return false;
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

        // TODO: $is_script_debug = '';

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
        load_theme_textdomain( 'primeraTextDomain', get_theme_file_path('public/lang') );
    }


    /**
    * Add head meta.
    *
    * @since  1.0
    */
    public static function _add_head_meta()
    {
        $meta = array(
            'viewport' => '<meta name="viewport" content="width=device-width, initial-scale=1">',
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

        # Gutenberg feature. Replaces Fitvids?
        # wordpress.org/gutenberg/handbook/extensibility/theme-support/#responsive-embedded-content
        add_theme_support( 'responsive-embeds' );

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
                'name'  => __( 'Dusty orange', 'primeraTextDomain' ),
                'slug'  => 'dusty-orange',
                'color' => '#ed8f5b',
            ),
            array(
                'name'  => __( 'Dusty red', 'primeraTextDomain' ),
                'slug'  => 'dusty-red',
                'color' => '#e36d60',
            ),
            array(
                'name'  => __( 'Dusty wine', 'primeraTextDomain' ),
                'slug'  => 'dusty-wine',
                'color' => '#9c4368',
            ),
            array(
                'name'  => __( 'Dark sunset', 'primeraTextDomain' ),
                'slug'  => 'dark-sunset',
                'color' => '#33223b',
            ),
            array(
                'name'  => __( 'Almost black', 'primeraTextDomain' ),
                'slug'  => 'almost-black',
                'color' => '#0a1c28',
            ),
            array(
                'name'  => __( 'Dusty water', 'primeraTextDomain' ),
                'slug'  => 'dusty-water',
                'color' => '#41848f',
            ),
            array(
                'name'  => __( 'Dusty sky', 'primeraTextDomain' ),
                'slug'  => 'dusty-sky',
                'color' => '#72a7a3',
            ),
            array(
                'name'  => __( 'Dusty daylight', 'primeraTextDomain' ),
                'slug'  => 'dusty-daylight',
                'color' => '#97c0b7',
            ),
            array(
                'name'  => __( 'Dusty sun', 'primeraTextDomain' ),
                'slug'  => 'dusty-sun',
                'color' => '#eee9d1',
            ),
        ) );

        // Font sizes.
        add_theme_support( 'editor-font-sizes', array(
            array(
                'name' => __( 'small', 'primeraTextDomain' ),
                'shortName' => __( 'S', 'primeraTextDomain' ),
                'size' => 12,
                'slug' => 'small'
            ),
            array(
                'name' => __( 'regular', 'primeraTextDomain' ),
                'shortName' => __( 'M', 'primeraTextDomain' ),
                'size' => 16,
                'slug' => 'regular'
            ),
            array(
                'name' => __( 'large', 'primeraTextDomain' ),
                'shortName' => __( 'L', 'primeraTextDomain' ),
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
        $is_local = 'local' == self::get_env() ? true : false;

        $urls = array(
            'fitvids'       => 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js',
            'fontawesome'   => 'https://use.fontawesome.com/releases/v5.0.13/js/all.js',
            'slickslider'   => 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
            'fancybox'      => 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js',
            'formvalidator' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js',
        );

        // NOTE: This helps you developing even if you aren't online.
        if ( $is_local ) {

            $urls = array(
                'fitvids'       => get_parent_theme_file_uri( 'public/js/vendor/fitvids.js' ),
                'fontawesome'   => get_parent_theme_file_uri( 'public/js/vendor/fontawesome.js' ),
                'slickslider'   => get_parent_theme_file_uri( 'public/js/vendor/slickslider.js' ),
                'fancybox'      => get_parent_theme_file_uri( 'public/js/vendor/fancybox.js' ),
                'formvalidator' => get_parent_theme_file_uri( 'public/js/vendor/formvalidator.js' ),
            );
        }

        // fitvidsjs.com/
        wp_register_script(
            'primeraFunctionPrefix-fitvids',
            $urls['fitvids'],
            array(),
            '5.0.13',
            true
        );

        // fontawesome.com/
        wp_register_script(
            'primeraFunctionPrefix-fontawesome',
            $urls['fontawesome'],
            array(),
            '5.0.13',
            true
        );

        // kenwheeler.github.io/slick/
        wp_register_script(
            'primeraFunctionPrefix-slickslider',
            $urls['slickslider'],
            array( 'jquery' ),
            '1.8.1',
            true
        );

        // fancyapps.com/fancybox/3/
        wp_register_script(
            'primeraFunctionPrefix-fancybox',
            $urls['fancybox'],
            array( 'jquery' ),
            '3.4.1',
            true
        );

        // formvalidator.net/
        wp_register_script(
            'primeraFunctionPrefix-formvalidator',
            $urls['formvalidator'],
            array( 'jquery' ),
            '3.4.1',
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
        // $version = self::get_version();

    	if ( is_singular() && comments_open() && get_option('thread_comments') ) {
    		wp_enqueue_script( 'comment-reply', '', '', '',  true );
    	}

    	// wp_enqueue_style(
    	// 	'primeraFunctionPrefix',
    	// 	get_stylesheet_uri(),
    	// 	array(),
    	// 	$version
    	// );

    	wp_enqueue_script(
    		'primeraFunctionPrefix',
    		get_parent_theme_file_uri( 'public/js/app.js' ),
    		array(
                'wp-util' ,// jQuery, undescore, wp.ajax & wp.template
                // 'hoverIntent', // briancherne.github.io/jquery-hoverIntent/
                // 'imagesloaded', // imagesloaded.desandro.com/
                // 'jquery-form', // malsup.com/jquery/form/
                // 'jquery-ui-selectmenu'
            ),
            filemtime( get_parent_theme_file_path('public/js/app.js') ),
    		true
    	);

        wp_localize_script(
            'primeraFunctionPrefix',
            'primeraFunctionPrefixLocalizedData',
            array(
                // 'buildUrl'  => esc_url( get_theme_file_uri('build') ),
                // TODO: Why was esc_url_raw used and not esc_url?
                'ajaxUrl'   => esc_url_raw( admin_url('admin-ajax.php') ),
                'restUrl'   => esc_url_raw( rest_url('/primeraTextDomain/v1/') ),
                'ajaxNonce' => wp_create_nonce( 'wp_ajax' ),
                'restNonce' => wp_create_nonce( 'wp_rest' ), // must be named: wp_rest
            )
        );
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
    }


    /**
    * Modify <body> class list.
    *
    * @link  https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans
    * @link  https://wptavern.com/wordpress-4-8-will-end-support-for-internet-explorer-versions-8-9-and-10
    * @since  1.0
    */
    public static function _filter_body_classes( $classes )
    {
        if ( wp_is_mobile() ) {
            $classes[] = 'primeraCssPrefix-is-mobile-device';
        }

        if ( $GLOBALS['is_edge'] ) {

            $classes[] = 'primeraCssPrefix-is-edge';
        }
        elseif ( $GLOBALS['is_IE'] ) {

            $classes[] = 'primeraCssPrefix-is-ie';
        }

        // TODO: Add is_iphone, is_chrome, is_safari
        // TODO: Create is_firefox, see wp source code and: stackoverflow.com/questions/9209649/how-to-detect-if-browser-is-firefox-with-php

        return $classes;
    }


    /**
    * Modify Tag Cloud widget arguments.
    *
    * @since  1.0
    */
    public static function _filter_tag_cloud_args( $args )
    {
    	$args['number']    = 18;
    	$args['smallest']  = 1;
    	$args['largest']   = 1;
    	$args['unit']      = 'rem';
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
        $atts['class'] = 'primeraCssPrefix-menu-link';

    	if ( 'primary' == $args->theme_location ) {
    		$atts['class'] .= ' primeraCssPrefix-menu-link--primary';

            // if ( 'category' === $item->object ) {
            //     $atts['data-category-id'] = absint( $item->object_id );
            // }
    	}

        if ( $item->current ) {
            $atts['class'] .= ' primeraCssPrefix-menu-link--active';
        }
        elseif ( $item->current_item_parent ) {
            $atts['class'] .= ' primeraCssPrefix-menu-link--active';
            $atts['class'] .= ' primeraCssPrefix-menu-link--parent';
        }
        elseif ( $item->current_item_ancestor ) {
            $atts['class'] .= ' primeraCssPrefix-menu-link--active';
            $atts['class'] .= ' primeraCssPrefix-menu-link--ancestor';
        }

        // First, check if "current" is set, which means the item is a nav menu item.
        if ( isset( $item->current ) ) {
            if ( $item->current ) {
                $atts['aria-current'] = 'page';
            }
        }
        // Otherwise, it's a post item so check if the item is the current post.
        elseif ( ! empty( $item->ID ) ) {
            global $post;
            if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
                $atts['aria-current'] = 'page';
            }
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


    /**
    * Adds async/defer attributes to enqueued / registered scripts.
    *
    * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
    *
    * Source: https://github.com/wprig/wprig/blob/master/dev/inc/template-functions.php#L41
    *
    * @since  1.0
    * @link  https://core.trac.wordpress.org/ticket/12009
    * @param  string  $tag  The script tag.
    * @param  string  $handle  The script handle.
    * @return  array
    */
    public static function _filter_script_loader_tag( $tag, $handle )
    {
    	foreach ( array( 'async', 'defer' ) as $attr ) {

    		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
    			continue;
    		}

    		// Prevent adding attribute when already added in #12009.
    		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
    			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
    		}

            // Only allow async or defer, not both.
    		break;
    	}

    	return $tag;
    }


} // end of class
