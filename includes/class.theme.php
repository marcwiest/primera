<?php

/**
* Handles theme setup.
*/
final class primeraObjectPrefix_Theme
{

    /**
    * Set global content width.
    *
    * @since  1.0
    */
    public static function set_global_content_width()
    {
        $GLOBALS['content_width'] = 840;
    }


    /**
    * Load text domain.
    *
    * First .mo file found gets used. Check WP_LANG_DIR first, then child theme, then parent theme.
    * Text domain should match theme folder name.
    *
    * @since  1.0
    */
    public static function load_theme_textdomain()
    {
        // wp-content/themes/child-theme-name/languages/it_IT.mo
        if ( load_theme_textdomain( 'primeraTextDomain', get_stylesheet_directory().'/languages' ) ) {
            return true;
        }

        // wp-content/themes/theme-name/languages/it_IT.mo
        return load_theme_textdomain( 'primeraTextDomain', get_template_directory().'/languages' );
    }


    /**
    * Add head meta.
    *
    * @since  1.0
    */
    public static function add_head_meta()
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
    public static function add_theme_support()
    {
    	# WordPress
    	add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption') );
        add_theme_support( 'automatic-feed-links' ); // adds posts and comments RSS feed links
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Gutenberg wide aligned images.
        // add_theme_support( 'align-wide' );

        // More Gutenberg: https://wprig.io/learn/gutenberg-theme-features/

        // if ( function_exists( 'the_custom_logo' ) ) {
        //     the_custom_logo();
        // }
        // add_theme_support( 'custom-logo' );

        # WooCommerce
        add_theme_support( 'woocommerce' );

    	# Add Custom Image Size (16:9)
        # Use the following plugin to regenerate your existing images when adding or changing
        # image sizes: wordpress.org/plugins/regenerate-thumbnails/
    	// add_image_size( 'portfolio-teaser', 1680, (1680/16*9), true );

        # Override default image size (default: 150x150)
        # This is equal to: add_image_size( 'post-thumbnail', 1680, (1680/16*9), true );
    	// set_post_thumbnail_size( 300, 300, true );
    }


    /**
    * Register scripts for later use.
    *
    * @since 1.0
    */
    public static function register_scripts()
    {
        wp_register_script(
            'font-awesome',
            'https://use.fontawesome.com/releases/v5.0.13/js/all.js'
        );
    }


    public static function get_version()
    {
        $version = trim( strval( wp_get_theme()->get('Version') ) );

        if ( defined('WP_DEBUG') && WP_DEBUG || ! $version ) {
            return time();
        }

        return $version;
    }


    /**
    * Enqueue frontend scripts.
    *
    * @since 1.0
    */
    public static function enqueue_frontend_scripts()
    {
    	wp_enqueue_style(
    		'primeraFunctionPrefix',
    		get_stylesheet_uri(),
    		array(),
    		self::get_version()
    	);

        // NOTE Since WP 4.7 you can use these functions to get a file's uri:
        // - get_parent_theme_file_uri
        // - get_theme_file_uri

    	wp_enqueue_script(
    		'primeraFunctionPrefix',
    		get_template_directory_uri().'/script.js',
    		array(
                'wp-util', // loads jquery, undescore, wp.template & wp.ajax.post
                'font-awesome', // registered via self::register_scripts()
                // 'hoverIntent', // briancherne.github.io/jquery-hoverIntent
                // 'imagesloaded', // imagesloaded.desandro.com
            ),
    		self::get_version(),
    		true
    	);

    	wp_localize_script(
    		'primeraFunctionPrefix',
    		'primeraFunctionPrefixLocalizedData',
    		array(
    			'ajaxUrl'   => esc_url_raw( admin_url('admin-ajax.php') ),
    			'restUrl'   => esc_url_raw( rest_url('/primeraFunctionPrefix/v1/') ),
    			'ajaxNonce' => wp_create_nonce( 'wp_ajax' ),
    			'restNonce' => wp_create_nonce( 'wp_rest' ), // must be named wp_rest
    		)
    	);

    	if ( is_singular() && comments_open() && get_option('thread_comments') ) {
    		wp_enqueue_script( 'comment-reply', '', '', '',  true );
    	}
    }


    /**
    * Register nav menus.
    *
    * @since  1.0
    */
    public static function register_nav_menus()
    {
    	register_nav_menus( array(
    		'primary'  => esc_html_x('Primary Menu','Registered nav-menu name.','primeraTextDomain'),
    		'colophon' => esc_html_x('Colophon Menu','Registered nav-menu name.','primeraTextDomain'),
    	) );
    }


    /**
    * Register sidebars.
    *
    * @since  1.0
    */
    public static function register_sidebars()
    {
    	register_sidebar( array(
    		'id'            => 'primary',
    		'name'          => esc_html_x('Main Sidebar','Sidebar title.','primeraTextDomain'),
    		'description'   => '',
    		'before_widget' => '<div id="%1$s" class="primeraCssPrefix-widget primeraCssPrefix-widget-content widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => apply_filters( 'primeraFunctionPrefix_before_widget_title', '<h4 class="widget-title">' ),
    		'after_title'   => apply_filters( 'primeraFunctionPrefix_after_widget_title', '</h4>' ),
    	) );

    	register_sidebar( array(
    		'id'            => 'offcanvas',
    		'name'          => esc_html_x('Off Canvas','Sidebar title.','primeraTextDomain'),
    		'description'   => '',
    		'before_widget' => '<div id="%1$s" class="primeraCssPrefix-widget primeraCssPrefix-widget-off-canvas widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => apply_filters( 'primeraFunctionPrefix_before_widget_title', '<h4 class="widget-title">' ),
    		'after_title'   => apply_filters( 'primeraFunctionPrefix_after_widget_title', '</h4>' ),
    	) );
    }


    /**
    * Filter featured image HTML in admin.
    *
    * @since  1.0
    * @return  string  Featured image HTML with note reg. recommened size.
    */
    public static function filter_admin_post_thumbnail_html( $content, $post_id, $thumbnail_id )
    {
    	$post_type = get_post_type( $post_id );

    	$note = '';

    	if ( 'post' == $post_type ) {
    		$note = esc_html__('Recommened Image Size: 300x300','primeraTextDomain');
    	}

    	if ( $note ) {
    		return $content . "<p class='primeraCssPrefix-recommened-thumbnail-size'>$note</p>";
    	}

    	return $content;
    }


    /**
    * Modify Tag Cloud widget arguments.
    *
    * @since  1.0
    */
    public static function modify_tag_cloud_args( $args )
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
    public static function filter_nav_menu_list_item_classes( $classes, $item, $args, $depth )
    {
    	if ( 'primary' == $args->theme_location ) {
    		array_push( $classes, 'primeraCssPrefix-menu-item primeraCssPrefix-menu-item-demo' );
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
    public static function filter_nav_menu_link_atts( $atts, $item, $args, $depth )
    {
    	if ( 'primary' == $args->theme_location ) {
    		$atts['class'] = 'primeraCssPrefix-menu-link primeraCssPrefix-menu-link-demo';
    	}

    	return $atts;
    }


    /**
    * Changing the logo link from wordpress.org to home_url.
    *
    * @since  1.0
    */
    public static function modify_login_url()
    {
    	return esc_url( home_url('/') );
    }


    /**
    * Changing the alt text on the logo to show your site name.
    *
    * @since  1.0
    */
    public static function modify_login_title()
    {
    	return esc_attr( get_bloginfo('name') );
    }


} // end of class
