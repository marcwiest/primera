<?php

# Current theme version.
define( 'PRIMERA_VERSION', wp_get_theme()->get('Version') );

# Set content width.
if ( empty( $GLOBALS['content_width'] ) ) {
	$GLOBALS['content_width'] = 1140;
}


/**
* Init site.
*
* @since  1.0
*/
function primera_init_site()
{
	require_once get_template_directory().'/inc/template-functions.php';
	require_once get_template_directory().'/inc/template-hooks.php';
}
add_action( 'after_setup_theme', 'primera_init_site' );


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
		$version = time();

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
	return get_bloginfo('name');
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
