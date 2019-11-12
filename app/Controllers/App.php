<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('ABSPATH') || exit;

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

    public function html_class_names(): string
    {
        $classes = [];

        if (wp_is_mobile()) {
            $classes[] = 'is-mobile-device';
        }

        if ($GLOBALS['is_chrome']) {
            $classes[] = 'is-chrome';
        } elseif ($GLOBALS['is_safari']) {
            $classes[] = 'is-safari';
        } elseif ($GLOBALS['is_gecko']) {
            $classes[] = 'is-gecko';
            $classes[] = 'is-firefox';
        } elseif ($GLOBALS['is_edge']) {
            $classes[] = 'is-ms-edge';
        }

        $classes[] = $GLOBALS['is_IE'] ? 'is-ms-ie no-css-vars' : 'css-vars';

        $classes = array_map('esc_attr', $classes);

        return join(' ',  array_unique($classes));
    }
}
