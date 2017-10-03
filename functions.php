<?php

# Current theme version.
define( 'PRIMERA_VERSION', wp_get_theme()->get('Version') );

# Set embedded media width.
if ( empty( $GLOBALS['content_width'] ) ) {
	$GLOBALS['content_width'] = 800;
}

# Load include files.
require_once get_template_directory().'/inc/template-tags.php';


/**
* Load text domain.
*
* First .mo file found gets used. Text domain should match theme folder name.
*
* @since  1.0
*/
function primera_load_theme_textdomain()
{
    // wp-content/languages/themes/theme-name/it_IT.mo
    load_theme_textdomain( 'primera', WP_LANG_DIR.'/themes/'.get_template() );

    // wp-content/themes/child-theme-name/languages/it_IT.mo
    load_theme_textdomain( 'primera', get_stylesheet_directory().'/languages' );

    // wp-content/themes/theme-name/languages/it_IT.mo
    load_theme_textdomain( 'primera', get_template_directory().'/languages' );
}
add_action( 'after_setup_theme', 'primera_load_theme_textdomain' );



/**
* Add head meta.
*
* @since  1.0
*/
function primera_add_head_meta()
{
    $meta = apply_filters( 'primera_head_meta', array(
        'viewport' => '<meta name="viewport" content="width=device-width, initial-scale=1">',
        'ie_edge'  => '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
    ) );

    if ( ! $GLOBALS['is_IE'] && ! empty($meta['ie_edge']) ) {
        unset( $meta['ie_edge'] );
	}

    foreach ( $meta as $m ) {
        echo $m;
    }
}
add_action( 'wp_head', 'primera_add_head_meta' );


/**
* Add theme support.
*
* @since  1.0
*/
function primera_add_theme_support()
{
	# WordPress
	add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption') );
    add_theme_support( 'automatic-feed-links' ); // adds posts and comments RSS feed links
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    # Image Sizes (default: 150x150)
	set_post_thumbnail_size( 300, 300, true );

	# Add Custom Image Size (16:9)
	// add_image_size( 'post_entry_banner', 1680, (1680/16*9) );
}
add_action( 'after_setup_theme', 'primera_add_theme_support' );


/**
* Filter featured image HTML in admin.
*
* @since  1.0
* @return  string  Featured image HTML with note reg. recommened size.
*/
function primera_filter_admin_post_thumbnail_html( $content, $post_id, $thumbnail_id )
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
add_filter( 'admin_post_thumbnail_html', 'primera_filter_admin_post_thumbnail_html', 10, 3 );


/**
* Enqueue frontend scripts.
*
* @since 1.0
*/
function primera_enqueue_frontend_scripts()
{
	$version = PRIMERA_VERSION;
	if ( defined('WP_DEBUG') && WP_DEBUG )
		$version = time();

	wp_enqueue_style(
		'primera',
		get_stylesheet_uri(),
		array(),
		$version
	);

	wp_enqueue_script(
		'primera',
		get_template_directory_uri().'/script.js',
		array( 'jquery' ),
		$version,
		true
	);

	// wp_remote_get( rest_url('/wp/v2/') );
	// wp_localize_script( 'primera', 'primeraRest', array(
	// 	'nonce' => wp_create_nonce( 'primera_rest' ),
	// 	'root'  => esc_url_raw( rest_url('/wp/v2/') ),
	// ) );

	if ( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script('comment-reply');
	}
}
add_action( 'wp_enqueue_scripts', 'primera_enqueue_frontend_scripts' );


/**
* Register nav menus.
*
* @since  1.0
*/
function primera_register_nav_menus()
{
	register_nav_menus( array(
		'primera_primary_menu'  => esc_html_x('Primary Menu','Registered nav-menu name.','primera'),
		'primera_colophon_menu' => esc_html_x('Colophon Menu','Registered nav-menu name.','primera'),
	) );
}
add_action( 'after_setup_theme', 'primera_register_nav_menus' );


/**
* Register sidebars.
*
* @since  1.0
*/
function primera_register_sidebars()
{
	register_sidebar( array(
		'id'            => 'primera_content_sidebar',
		'name'          => esc_html_x('Content Sidebar','Sidebar title.','primera'),
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="primera-content-widget widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => apply_filters( 'primera_before_widget_title', '<h4 class="widget-title">' ),
		'after_title'   => apply_filters( 'primera_after_widget_title', '</h4>' ),
	) );

	register_sidebar( array(
		'id'            => 'primera_off_canvas_sidebar',
		'name'          => esc_html_x('Off Canvas Sidebar','Sidebar title.','primera'),
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="primera-off-canvas-widget widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => apply_filters( 'primera_before_widget_title', '<h4 class="widget-title">' ),
		'after_title'   => apply_filters( 'primera_after_widget_title', '</h4>' ),
	) );
}
add_action( 'widgets_init', 'primera_register_sidebars' );


/**
* Add HTML tag before registered sidebars.
*
* @since 1.0
* @return string HTML opening tag for sidebar.
*/
function primera_dynamic_sidebar_before( $index )
{
	$primera_sidebars = array(
		'primera_content_sidebar',
		'primera_off_canvas_sidebar',
	);

	if ( in_array( $index, $primera_sidebars ) && is_active_sidebar($index) ) {

		$index = str_replace( '_', '-', $index );

		echo "<div class='primera-sidebar $index'>";
	}
}
add_action( 'dynamic_sidebar_before', 'primera_dynamic_sidebar_before' );


/**
* Add HTML tag after registered sidebars.
*
* @since 1.0
* @return string HTML closing tag for sidebar.
*/
function primera_dynamic_sidebar_after( $index )
{
	$primera_sidebars = array(
		'primera_content_sidebar',
		'primera_off_canvas_sidebar',
	);

	if ( in_array( $index, $primera_sidebars ) && is_active_sidebar($index) ) {
		echo "</div>";
	}
}
add_action( 'dynamic_sidebar_after', 'primera_dynamic_sidebar_after' );


/**
* Changing the logo link from wordpress.org to home_url.
*
* @since  1.0
*/
function primera_modify_login_url()
{
	return esc_url( home_url('/') );
}
add_filter( 'login_headerurl', 'primera_modify_login_url' );


/**
* Changing the alt text on the logo to show your site name.
*
* @since  1.0
*/
function primera_modify_login_title()
{
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'primera_modify_login_title' );


/**
* Modify Tag Cloud widget arguments.
*
* @since  1.0
*/
function primera_modify_tag_cloud_args( $args )
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
add_filter( 'widget_tag_cloud_args', 'primera_modify_tag_cloud_args' );


/**
* Filter nav menu list item classes.
*
* This filter can be found in wp-includes/class-walker-nav-menu.php
*
* @since  1.0
* @return  array  Numeric array of list item classes.
*/
function primera_filter_nav_menu_list_item_classes( $classes, $item, $args, $depth ) {

	if ( 'primera_primary_menu' == $args->theme_location ) {
		array_push( $classes, 'primera-menu-item primera-menu-item-demo' );
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'primera_filter_nav_menu_list_item_classes', 10, 4 );


/**
* Filter nav menu link attributes.
*
* This filter can be found in wp-includes/class-walker-nav-menu.php
*
* @since  1.0
* @return  array  Asccociative array of anchor attributes.
*/
function primera_filter_nav_menu_link_atts( $atts, $item, $args, $depth ) {

	if ( 'primera_primary_menu' == $args->theme_location ) {
		$atts['class'] = 'primera-menu-link primera-menu-link-demo';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'primera_filter_nav_menu_link_atts', 10, 4 );
