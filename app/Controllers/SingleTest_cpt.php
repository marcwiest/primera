<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('WPINC') || exit;

class SingleTest_cpt extends Controller
{
    public function test()
    {
        return "Test CPT Data";
    }
}
