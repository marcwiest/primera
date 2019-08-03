<?php

declare(strict_types=1);

namespace App;

defined('WPINC') || exit;

add_action('rest_api_init', function() {

    register_rest_route( 'primera/v1', '/get-pdf-from-post/', [
        'methods'  => 'POST',
        'callback' => '\App\Controllers\App::get_pdf_from_post',
    ], true );
});
