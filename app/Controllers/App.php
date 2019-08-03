<?php

declare(strict_types=1);

namespace App\Controllers;

use Sober\Controller\Controller;

// Exit if accessed directly.
defined('WPINC') || exit;

class App extends Controller
{
    // Runs after this->data is set up, but before the class methods are run.
    // public function __before() {}
    // Runs after all the class methods have run.
    // public function __after() {}

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
        ]) ?: '';
    }

    /**
    * REST get PDF from post.
    * REST routes must be defined statically.
    */
    public static function get_pdf_from_post(\WP_REST_Request $req)
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
}
