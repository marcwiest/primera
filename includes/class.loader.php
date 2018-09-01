<?php

final class primeraObjectPrefix_Loader
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

        // Req. for php.net/manual/en/migration54.new-features.php
        if ( -1 === version_compare( phpversion(), '5.4' ) ) {
            $r[] = esc_html_x('Primera requires PHP version 5.4 or higher. Please upgrade the PHP version on your server or contact your host for assistance.','Admin notice','primeraTextDomain');
        }

        if ( -1 === version_compare( $wp_version, '4.9' ) ) {
    	    $r[] = esc_html_x('Primera requires WordPress version 4.9 or higher. Please upgrade WordPress contact your administrator for assistance.','Admin notice','primeraTextDomain');
        }

        if ( $r ) {
            add_action( 'admin_notices'         , __CLASS__.'::_render_notices' );
            add_action( 'network_admin_notices' , __CLASS__.'::_render_notices' );
        }

        return $r;
    }


    /**
    * Render admin notices.
    *
    * @since  1.0.0
    * @return  void
    */
    public function _render_notices()
    {
        // if ( current_user_can('update_core') )
        foreach( $this->missing_dependencies() as $msg ) {
            echo '<div class="notice notice-error">';
            echo "<p>$msg</p>";
            echo '</div>';
        }
    }


} // end of class
