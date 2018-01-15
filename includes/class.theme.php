<?php

class Primera_Theme
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
    * First .mo file found gets used. Text domain should match theme folder name.
    *
    * @since  1.0
    */
    public static function load_theme_textdomain()
    {
        // wp-content/languages/themes/theme-name/it_IT.mo
        load_theme_textdomain( 'primera', WP_LANG_DIR.'/themes/'.get_template() );

        // wp-content/themes/child-theme-name/languages/it_IT.mo
        load_theme_textdomain( 'primera', get_stylesheet_directory().'/languages' );

        // wp-content/themes/theme-name/languages/it_IT.mo
        load_theme_textdomain( 'primera', get_template_directory().'/languages' );
    }


    /**
    * Add head meta.
    *
    * @since  1.0
    */
    public static function add_head_meta()
    {
        $meta = apply_filters( 'primera_head_meta', array(
            'viewport' => '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">',
            'ie_edge'  => '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
        ) );

        if ( ! $GLOBALS['is_IE'] && ! empty($meta['ie_edge']) ) {
            unset( $meta['ie_edge'] );
    	}

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

        # Override default image size (default: 150x150)
    	set_post_thumbnail_size( 300, 300, true );

    	# Add Custom Image Size (16:9)
    	// add_image_size( 'post_entry_banner', 1680, (1680/16*9) );
    }


    /**
    * Enqueue frontend scripts.
    *
    * @since 1.0
    */
    public static function enqueue_frontend_scripts()
    {
        $version = wp_get_theme()->get('Version');
        if ( defined('WP_DEBUG') && WP_DEBUG || ! $version ) {
            $version = time();
        }

    	wp_enqueue_style(
    		'primera',
    		get_stylesheet_uri(),
    		array(),
    		$version
    	);

    	wp_enqueue_script(
    		'primera',
    		get_template_directory_uri().'/script.js',
    		array( 'wp-util', 'hoverIntent' ), // wp-util: jQuery, undescore, wp
    		$version,
    		true
    	);

    	wp_localize_script(
    		'primera',
    		'primeraLocalizedData',
    		array(
    			'ajaxUrl'   => esc_url_raw( admin_url('admin-ajax.php') ),
    			'restUrl'   => esc_url_raw( rest_url('/primera/v1/') ),
    			'ajaxNonce' => wp_create_nonce( 'wp_ajax' ),
    			'restNonce' => wp_create_nonce( 'wp_rest' ),
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
    public static function register_nav_menus()
    {
    	register_nav_menus( array(
    		'primera_primary'  => esc_html_x('Primary Menu','Registered nav-menu name.','primera'),
    		'primera_colophon' => esc_html_x('Colophon Menu','Registered nav-menu name.','primera'),
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
    		'id'            => 'primera_primary',
    		'name'          => esc_html_x('Content Sidebar','Sidebar title.','primera'),
    		'description'   => '',
    		'before_widget' => '<aside id="%1$s" class="primera-widget primera-widget-content widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => apply_filters( 'primera_before_widget_title', '<h4 class="widget-title">' ),
    		'after_title'   => apply_filters( 'primera_after_widget_title', '</h4>' ),
    	) );

    	register_sidebar( array(
    		'id'            => 'primera_off_canvas',
    		'name'          => esc_html_x('Off Canvas Sidebar','Sidebar title.','primera'),
    		'description'   => '',
    		'before_widget' => '<aside id="%1$s" class="primera-widget primera-widget-off-canvas widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => apply_filters( 'primera_before_widget_title', '<h4 class="widget-title">' ),
    		'after_title'   => apply_filters( 'primera_after_widget_title', '</h4>' ),
    	) );
    }


    /**
    * Add HTML tag before registered sidebars.
    *
    * @since 1.0
    * @return string HTML opening tag for sidebar.
    */
    public static function dynamic_sidebar_before( $index )
    {
    	$primera_sidebars = array(
    		'primera_content',
    		'primera_off_canvas',
    	);

    	if ( in_array( $index, $primera_sidebars ) && is_active_sidebar($index) ) {

    		// $index = str_replace( '_', '-', $index );

    		echo "<div class='primera-sidebar'>";
    	}
    }


    /**
    * Add HTML tag after registered sidebars.
    *
    * @since 1.0
    * @return string HTML closing tag for sidebar.
    */
    public static function dynamic_sidebar_after( $index )
    {
    	$primera_sidebars = array(
    		'primera_content',
    		'primera_off_canvas',
    	);

    	if ( in_array( $index, $primera_sidebars ) && is_active_sidebar($index) ) {
    		echo '</div>';
    	}
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
    		$note = esc_html__('Recommened Image Size: 300x300','primera');
    	}

    	if ( $note ) {
    		return $content . "<p class='primera-recommened-thumbnail-size'>$note</p>";
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
    	// $args['number']    = 24;
    	// $args['smallest']  = 14;
    	// $args['largest']   = 14;
    	// $args['unit']      = 'px';
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
    public static function filter_nav_menu_list_item_classes( $classes, $item, $args, $depth ) {

    	if ( 'primera_primary' == $args->theme_location ) {
    		array_push( $classes, 'primera-menu-item primera-menu-item-demo' );
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
    public static function filter_nav_menu_link_atts( $atts, $item, $args, $depth ) {

    	if ( 'primera_primary' == $args->theme_location ) {
    		$atts['class'] = 'primera-menu-link primera-menu-link-demo';
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
    	return get_bloginfo( 'name' );
    }


} // end of class
