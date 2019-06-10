<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('WPINC') || exit;

class App extends Controller
{
    public function site_name(): string
    {
        return get_bloginfo( 'name', 'display' );
    }

    public function site_desc(): string
    {
        return get_bloginfo( 'description', 'display' );
    }

    public function logo_url(): string
    {
        return '';
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
        ]);
    }
}
