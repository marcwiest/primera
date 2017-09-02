<?php

# Current theme version.
define( 'PRIMERA_VERSION', wp_get_theme()->get('Version') );

# Set content width.
if ( empty( $GLOBALS['content_width'] ) ) {
	$GLOBALS['content_width'] = 1140;
}


/**
* Load text domain.
*
* First .mo file found gets used.
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

    # Image Sizes
	set_post_thumbnail_size( 300, 300, true );
}
add_action( 'after_setup_theme', 'primera_add_theme_support' );


/**
* Enqueue frontend scripts.
*
* @since 1.0
*/
function primera_enqueue_frontend_scripts()
{
	$version = PRIMERA_VERSION;
	if ( defined('WP_DEBUG') && WP_DEBUG )
		$version = filemtime( get_template_directory().'/app.js' );

	wp_enqueue_style(
		'primera',
		get_stylesheet_uri(),
		array(),
		$version
	);

	wp_enqueue_script(
		'primera',
		get_template_directory_uri().'/app.js',
		array('jquery'),
		$version,
		true
	);

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
		'primary' => esc_html_x('Primary Menu','Registered nav-menu name.','primera'),
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
		'id'            => 'primary',
		'name'          => esc_html_x('Primary Sidebar','Sidebar title.','primera'),
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => apply_filters( 'primera_before_widget_title', '<h4 class="widget-title">' ),
		'after_title'   => apply_filters( 'primera_after_widget_title', '</h4>' ),
	) );
}
add_action( 'widgets_init', 'primera_register_sidebars' );
