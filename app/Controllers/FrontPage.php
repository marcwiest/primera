<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('ABSPATH') || exit;

class FrontPage extends Controller
{
    public function test()
    {
        return "FRONT PAGE DATA TEST";
    }
}
