<?php

// Backward compatibility.
if ( ! function_exists( 'wp_body_open' ) ) :
function wp_body_open()
{
    do_action( 'wp_body_open' );
}
endif;

// Get URL of an asset from within the public folder.
if ( ! function_exists( 'asset' ) ) :
function asset( string $filePath ): string
{
    return get_theme_file_uri( "public/{$filePath}" );
}
endif;

// Check if SSL is enabled.
if (! function_exists('isSsl')) :
function isSsl()
{
    if ( is_ssl() ) {
        return true;
    }
    else if ( 0 === stripos( get_option('siteurl'), 'https://' ) ) {
        return true;
    }
    else if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
        return true;
    }

    return false;
}
endif;

if ( ! function_exists( 'envName' ) ) :
/**
* Get current environment.
* @since 1.0
* @return string
*/
function envName( $allowServerName=false )
{
    // TODO: Refactor to always first check HTTP_HOST and only fallback to SERVER_NAME if param $allowServerName is true.
    // See SERVER_NAME on https://www.php.net/manual/en/reserved.variables.server.php for reasoning.

    $server = [
        $_SERVER['SERVER_NAME'],
        $_SERVER['HTTP_HOST'],
    ];

    if ( in_array( '%production-url%', $server ) ) {
        return 'production';
    }
    else if ( in_array( '%staging-url%', $server ) ) {
        return 'staging';
    }
    else if ( in_array( '%development-url%', $server ) ) {
        return 'development';
    }
    else if ( in_array( $_SERVER['REMOTE_ADDR'], ['::1', '127.0.0.1'] ) ) {
        return 'local';
    }

    return 'production';
}
endif;

/**
* Get related posts by category example.
*/
function getRelatedPostsExample( $amount=4 )
{
    global $post;

    if ( ! $post ) {
        the_post();
    }

    if ( ! $cats = wp_get_post_categories( $post->ID ) ) {
        return [];
    }

    $catIds = '';
    foreach ( $cats as $cat ) {
        $catIds .= "$cat,";
    }

    return get_posts([
        'cat'          => $catIds,
        'numberposts'  => $amount,
        'post__not_in' => [$post->ID],
    ]);
}

/**
* Get yoast primary (or 1st found) category.
*/
function getYoastPrimaryCategory( $postId=0 )
{
    // If no category is set, return fasle.
	if ( ! $category = get_the_category( $postId ?: get_the_ID() ) ) {
        return false;
    }

    // Get first category.
    $firstCategory = [
        'title' => $category[0]->name,
        'slug' => $category[0]->slug,
        'url' => get_category_link( $category[0]->term_id ),
    ];

    // If Yoast primary term does not exist, return the first category.
    if ( ! class_exists('WPSEO_Primary_Term') ) {
        return $firstCategory;
    }

    $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id($postId) );

    // If method does not exsits, return the first category.
    if ( ! method_exists($wpseo_primary_term,'get_primary_term') ) {
        return $firstCategory;
    }

    $term = get_term( $wpseo_primary_term->get_primary_term() );

    // If post doesn't have a primary term set, return first category.
    if ( is_wp_error($term) ) {
        return $firstCategory;
    }

    // Yoast primary category is available.
    return [
        'title' => $term->name,
        'slug' => $term->slug,
        'url' => get_category_link( $term->term_id ),
    ];
}
