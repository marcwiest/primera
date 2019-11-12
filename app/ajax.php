<?php

namespace App\ajax;

defined('ABSPATH') || exit;

/**
* Add AJAX actions helper.
* TODO: Add function `add_priv_ajax_action()` vs. approach below (make 2 functions).
* @param  $cb  callable|array  If array uses "priv" and "nopriv" keys the callbacks are split up (use false to disable either), else use callable for both.
*/
function add_ajax_action(string $action, $cb): void
{
    if (is_array($cb) && ! wp_is_numeric_array($cb)) {

        $nopriv = ($cb['nopriv'] ?? false) ? $cb['nopriv'] : false;
        $priv = ($cb['priv'] ?? false) ? $cb['priv'] : $nopriv;
    }
    else {
        $nopriv = $priv = $cb;
    }

    ($nopriv && is_callable($nopriv)) && add_ajax_action("wp_ajax_nopriv_{$action}", $nopriv);
    ($priv && is_callable($priv)) && add_ajax_action("wp_ajax_{$action}", $priv);
}

// Usage example:
// add_ajax_action('do-something', __NAMESPACE__ . '\\do_something');
// add_ajax_action('do-something', [
//     'nopriv' => flase,
//     'priv' => __NAMESPACE__ . '\\do_something',
// ]);
// function do_something() {}
