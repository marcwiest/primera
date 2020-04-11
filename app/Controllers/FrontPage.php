<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

defined('ABSPATH') || exit;

class FrontPage extends Controller
{
    public function test()
    {
        return "Test Data";
    }
}
