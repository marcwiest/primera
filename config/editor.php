<?php

namespace App\config\editor;

defined('ABSPATH') || exit;

// Actions
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addGutenbergSupport' );
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addGutenbergColorPalette' );
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addGutenbergGradientPresets' );
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addGutenbergFontSizes' );

/**
* Add Gutenberg support.
*
* @link  wordpress.org/gutenberg/handbook/extensibility/theme-support/
* @since  1.0
*/
function addGutenbergSupport()
{
	// Add support for full and wide align images.
	// add_theme_support( 'align-wide' );

    // Disable custom color picker.
    // add_theme_support( 'disable-custom-colors' );

	// Add support for core block styles.
    // add_theme_support( 'wp-block-styles' );

    // Limit users to the default gradients.
    // add_theme_support( 'disable-custom-gradients' );

    // Disable default gradients.
    // add_theme_support( 'editor-gradient-presets', [] );

    // Editor styles.
    // https://developer.wordpress.org/block-editor/developers/themes/theme-support/#dark-backgrounds
    // add_theme_support( 'editor-styles' );
    // add_theme_support( 'dark-editor-style' );

    // Gutenberg feature. Replaces Fitvids?
    // wordpress.org/gutenberg/handbook/extensibility/theme-support/#responsive-embedded-content
    add_theme_support( 'responsive-embeds' );
}

/**
*
*/
function addGutenbergColorPalette()
{

    add_theme_support('editor-color-palette', array(
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
    ));
}

/**
*
*/
function addGutenbergGradientPresets()
{
    add_theme_support('editor-gradient-presets', array(
        array(
            'name'     => __( 'Vivid cyan blue to vivid purple', 'primeraTextDomain' ),
            'gradient' => 'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)',
            'slug'     => 'vivid-cyan-blue-to-vivid-purple'
        ),
        array(
            'name'     => __( 'Vivid green cyan to vivid cyan blue', 'primeraTextDomain' ),
            'gradient' => 'linear-gradient(135deg,rgba(0,208,132,1) 0%,rgba(6,147,227,1) 100%)',
            'slug'     =>  'vivid-green-cyan-to-vivid-cyan-blue',
        ),
        array(
            'name'     => __( 'Light green cyan to vivid green cyan', 'primeraTextDomain' ),
            'gradient' => 'linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%)',
            'slug'     => 'light-green-cyan-to-vivid-green-cyan',
        ),
        array(
            'name'     => __( 'Luminous vivid amber to luminous vivid orange', 'primeraTextDomain' ),
            'gradient' => 'linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%)',
            'slug'     => 'luminous-vivid-amber-to-luminous-vivid-orange',
        ),
        array(
            'name'     => __( 'Luminous vivid orange to vivid red', 'primeraTextDomain' ),
            'gradient' => 'linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%)',
            'slug'     => 'luminous-vivid-orange-to-vivid-red',
        ),
    ));
}

/**
*
*/
function addGutenbergFontSizes()
{
    // Font sizes.
    add_theme_support('editor-font-sizes', [
        [
            'name' => __( 'small', 'primeraTextDomain' ),
            'shortName' => __( 'S', 'primeraTextDomain' ),
            'size' => 12,
            'slug' => 'small',
        ],
        [
            'name' => __( 'regular', 'primeraTextDomain' ),
            'shortName' => __( 'M', 'primeraTextDomain' ),
            'size' => 16,
            'slug' => 'regular',
        ],
        [
            'name' => __( 'large', 'primeraTextDomain' ),
            'shortName' => __( 'L', 'primeraTextDomain' ),
            'size' => 32,
            'slug' => 'large',
        ],
    ]);
}
