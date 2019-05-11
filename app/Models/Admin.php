<?php

declare(strict_types=1);

namespace App\Models;

// Exit if accessed directly.
defined('ABSPATH') || exit;

\wp_die('<pre style=overflow-x:auto;font-size:12px><code>'.print_r('TEST',true).'</code></pre>');

/**
* Handles admin modifications.
*/
class Admin
{

    public static function init()
    {

    }

} // end of class

