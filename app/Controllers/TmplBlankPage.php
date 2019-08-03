<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

defined('WPINC') || exit;

class TmplBlankPage extends Controller
{
    // Runs after this->data is set up, but before the class methods are run.
    public function __before()
    {
        add_action( 'wp_enqueue_scripts', function() {

            wp_enqueue_style(
                'primeraFunctionPrefix-tmpl-blank-page',
                get_theme_file_uri("public/css/tmpl-blank-page.css"),
                ['beedelightful'],
                filemtime(get_theme_file_path("public/css/tmpl-blank-page.css"))
            );

            wp_enqueue_script(
                'primeraFunctionPrefix-tmpl-blank-page',
                get_theme_file_uri("public/js/tmpl-blank-page.js"),
                ['beedelightful', 'jquery-ui-datepicker', 'bd-nice-select'],
                filemtime(get_theme_file_path("public/js/tmpl-blank-page.js"))
            );
            wp_script_add_data( 'primeraFunctionPrefix-tmpl-blank-page', 'defer', true );
        });
    }

    // Runs after all the class methods have run.
    // public function __after() {}

    public function test()
    {
        return "FRONT PAGE DATA TEST";
    }
}
