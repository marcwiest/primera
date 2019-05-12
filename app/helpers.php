<?php
// Helper functions.

// Backward compatibility.
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
// function locate_template($templates)
// {
//     return \locate_template(filterTemplates($templates));
// }
