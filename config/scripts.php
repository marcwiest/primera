<?php

namespace App\config\scripts;

defined('ABSPATH') || exit;

// Actions
add_action( 'wp_enqueue_scripts'      , __NAMESPACE__ . '\\enqueueFrontendScripts' );
add_action( 'wp_print_footer_scripts' , __NAMESPACE__ . '\\skipLinkFocusFix' );

// Filters
add_filter( 'primera/template/script-file-url'     , __NAMESPACE__ . '\\filterPrimeraTemplateScriptFileUrl', 10, 3 );
add_filter( 'primera/template/script-file-version' , '__return_null' );

/**
* Enqueue frontend scripts.
* @since 1.0
*/
function enqueueFrontendScripts()
{
    $script_name = str_replace(' ', '-', env('THEME_SLUG', 'primera'));
    $js_handle = preg_replace('/[^A-Za-z]+/g', '', $script_name);

    // App CSS
    wp_enqueue_style(
        $script_name,
        mix('css/app.css'),
        [],
        null
    );

    // App JS
    wp_enqueue_script(
        $script_name,
        mix('js/app.js'),
        [
            // 'wp-util' ,     // loads jQuery, UndescoreJS, wp.ajax & wp.template
            // 'hoverIntent',  // briancherne.github.io/jquery-hoverIntent/
            // 'imagesloaded', // imagesloaded.desandro.com/
            // 'jquery-form',  // malsup.com/jquery/form/
            // 'jquery-ui-selectmenu',
            // 'jquery-hotkeys',
            // 'backbone',
            'jquery',
        ],
        null
    );
    wp_script_add_data( $script_name, 'defer', true );

    // Localized App JS
    wp_localize_script(
        $script_name,
        "{$js_handle}LocalizedData", // js handle
        [
            'imgUrl'         => esc_url( get_theme_file_uri('public/img/') ),
            'ajaxUrl'        => esc_url_raw( admin_url('admin-ajax.php') ),
            'restUrl'        => esc_url_raw( rest_url('/primeraTextDomain/v1/') ),
            'wpRestUrl'      => esc_url_raw( rest_url() ),
            'ajaxNonce'      => wp_create_nonce( 'wp_ajax' ),
            'restNonce'      => wp_create_nonce( 'wp_rest' ), // must be named: wp_rest
            'isUserLoggedIn' => is_user_logged_in(),
            'isUserAdmin'    => current_user_can( 'manage_options' ),
        ]
    );

    // WP Comments
    if ( is_singular() && comments_open() && get_option('thread_comments') ) {
        wp_enqueue_script( 'comment-reply', '', '', '',  true );
    }
}

/**
* Fix skip link focus in IE11.
*
* This does not enqueue the script because it is tiny and because it is only for IE11,
* thus it does not warrant having an entire dedicated blocking script being loaded.
*
* @link https://git.io/vWdr2
*/
function skipLinkFocusFix()
{
    if (! $GLOBALS['is_IE']) {
        return;
    }
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
    ?><script>/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);</script><?php
}

/**
* Filter Primera template script (JS/CSS) file enqueue URL using mix.
*
* @since  1.0
*/
function filterPrimeraTemplateScriptFileUrl($url, $file_name, $file_type)
{
    return mix("{$file_type}/{$file_name}.{$file_type}");
}
