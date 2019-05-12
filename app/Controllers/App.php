<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('ABSPATH') || exit;

class App extends Controller
{
    public function site(): array
    {
        return [
            'name'        => get_bloginfo( 'name', 'display' ),
            'description' => get_bloginfo( 'description', 'display' ),
            'charset'     => get_bloginfo( 'charset', 'display' ),
        ];
    }

    public function header(): array
    {
        return [
            'logoUrl'         => '',
            'primaryNavItems' => wp_get_nav_menu_items( 'primary', [
                'order'       => 'ASC',
                'orderby'     => 'menu_order',
                'post_type'   => 'nav_menu_item',
                'post_status' => 'publish',
                'output'      => ARRAY_A,
                'output_key'  => 'menu_order',
                'nopaging'    => true,
            ]),
        ];
    }
}
