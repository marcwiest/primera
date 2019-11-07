<?php

namespace App\rest;

defined('ABSPATH') || exit;

add_action('rest_api_init', function() {

    register_rest_route( 'primera/v1', '/get-pdf-from-post/', [
        'methods'  => 'POST',
        'callback' => __NAMESPACE__ . '\\get_pdf_from_post',
    ], true );
});

/**
* REST get PDF from post.
*/
function get_pdf_from_post(\WP_REST_Request $req)
{
    $resp = [
        'success' => true,
        'post' => null,
        'file' => null,
        'msg' => [
            'unsuccessful' =>  __("We are sorry, but it seems something went wrong. Please try again or contact us for help.", 'primeraTextDomain'),
            'no_files' => __("We are sorry, but it seems we couldn't find what you are looking for. Please check your form settings or contact us for help.", 'primeraTextDomain'),
        ],
    ];

    if ( empty($req['post-id']) ) {
        $resp['success'] = false;
        return \rest_ensure_response($resp);
    }

    $resp['post'] = get_post($req['post-id']);

    $file_id      = get_post_field('attched_pdf', $resp['post'], 'raw');
    $resp['file'] = $file_id ? get_post($file_id) : false;

    return \rest_ensure_response($resp);
}
