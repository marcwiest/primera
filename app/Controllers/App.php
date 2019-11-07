<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('WPINC') || exit;

class App extends Controller
{
    // Runs after this->data is set up, but before the class methods are run.
    // public function __before() {}
    // Runs after all the class methods have run.
    // public function __after() {}

    public function site_name(): string
    {
        return get_bloginfo('name', 'display');
    }

    public function site_desc(): string
    {
        return get_bloginfo('description', 'display');
    }

    public function current_year(): string
    {
        return date_i18n('Y');
    }

    public function primary_nav(): string
    {
        return wp_nav_menu([
            'theme_location' => 'primary',
            'depth'          => 1,
            'container'      => false,
            'fallback_cb'    => false,
            'echo'           => false,
            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]) ?: '';
    }

    public static function html_class(string $class=''): string
    {
        $class_names = self::html_class_names($class);
        return 'class="' . join(' ',  $class_names) . '"';
    }

    public static function html_class_names(string $class=''): array
    {
        $classes = [];

        if (! $GLOBALS['is_IE']) {
            $classes[] = 'css-vars';
        }

        if (wp_is_mobile()) {
            $classes[] = 'is-mobile-device';
        }

        // In order of market share 2019.
        if ( $GLOBALS['is_chrome'] ) {
            $classes[] = 'is-chrome';
        } elseif ( $GLOBALS['is_safari'] ) {
            $classes[] = 'is-safari';
        } elseif ( $GLOBALS['is_gecko'] ) {
            $classes[] = 'is-gecko';
            $classes[] = 'is-firefox';
        } elseif ( $GLOBALS['is_edge'] ) {
            $classes[] = 'is-ms-edge';
        } elseif ( $GLOBALS['is_IE'] ) {
            $classes[] = 'is-ms-ie';
        }

        if (! empty($class)) {
            if (! is_array($class)) {
                $class = preg_split('#\s+#', $class);
            }
            $classes = array_merge($classes, $class);
        } else {
            // Ensure that we always coerce class to being an array.
            $class = [];
        }

        $classes = array_map('esc_attr', $classes);

        /**
         * Filters the list of CSS html class names.
         *
         * @param string[] $classes An array of body class names.
         * @param string[] $class   An array of additional class names added to the html element.
         */
        $classes = apply_filters('html_class', $classes, $class);

        return array_unique($classes);
    }
}
