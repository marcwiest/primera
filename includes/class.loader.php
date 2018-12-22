<?php

// www.ibenic.com/how-to-handle-wordpress-errors-with-wp_error-class/
// $wrong_php_version = null;
// if ( -1 === version_compare( phpversion(), '7.0.0' ) ) {
//
//     $wrong_php_version = new WP_Error(
//         'primeraFunctionPrefix_wrong_php_version',
//         esc_html__('Your current theme requires PHP version 7.0 or higher. Please upgrade the PHP version on your server or contact your host for assistance.','primeraTextDomain'),
//         array( 'current_version' => phpversion() )
//     );
// }
// if ( is_wp_error( $wrong_php_version ) ) {
//     wp_die( $wrong_php_version->get_error_message(), esc_html__('Wrong PHP Version', 'primeraTextDomain') );
// }

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

abstract class Loader
{

    /**
    * Checks if the theme has all its dependencies.
    *
    * It's important to only use syntax available to all (or at least) most versions of PHP within this function.
    *
    * @since  1.0.0
    * @return  array  Array of missing dependencies or empty array.
    */
    public static function missing_dependencies()
    {
        global $wp_version;

        $r = array();

        // Twig requires version 7+.
        // PHP namespaces require version 5.6+.
        if ( -1 === version_compare( phpversion(), '7.0.0' ) ) {
            $r[] = esc_html_x('Your current theme requires PHP version 7.0 or higher. Please upgrade the PHP version on your server or contact your host for assistance.','Admin notice','primeraTextDomain');
        }

        if ( -1 === version_compare( $wp_version, '4.5' ) ) {
    	    $r[] = esc_html_x('Your current theme requires WordPress version 4.5 or higher. Please upgrade WordPress to version 4.5 or higher or contact your administrator for assistance.','Admin notice','primeraTextDomain');
        }

        if ( $r ) {
            add_action( 'admin_notices'         , __CLASS__ . '::_render_notices' );
            add_action( 'network_admin_notices' , __CLASS__ . '::_render_notices' );
        }

        return $r;
    }


    /**
    * Render admin notices.
    *
    * @since  1.0.0
    * @return  void
    */
    public static function _render_notices()
    {
        // if ( current_user_can('update_core') )
        foreach( self::missing_dependencies() as $msg ) {
            echo '<div class="notice notice-error">';
            echo "<p>$msg</p>";
            echo '</div>';
        }
    }


} // end of class
