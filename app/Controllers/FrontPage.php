<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('ABSPATH') || exit;

class FrontPage extends Controller
{
    // Runs after this->data is set up, but before the class methods are run.
    public function __before()
    {
        wp_enqueue_style(
            'font-page',
            get_theme_file_uri('public/css/page.css')
        );
    }

    // Runs after all the class methods have run.
    // public function __after() {}

    public function test()
    {
        return "FRONT PAGE DATA TEST";
    }
}
