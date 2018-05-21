<?php

/**
* Handles module rendering.
*/
final class primeraObjectPrefix_Module
{

    /**
    * Parses default values for a module.
    *
    * @since  1.0.0
    * @return  object  The data for the module to use.
    */
    public static function defaults( &$data, $defaults )
    {
        if ( $defaults ) {
            $data = wp_parse_args( $data, $defaults );
        }

        // Empty arrays aren't converted to objects.
        return $data = $data ? json_decode( wp_json_encode($data) ) : new stdClass;
    }


    /**
    * Display a module.
    *
    * @since  1.0.0
    * @param  string  $module  The name of the module file without .php.
    * @param  array  $data  The data made available to the module.
    * @return  void
    */
    public static function display( $module, $data=array() )
    {
        $path = "/modules/$module.php";

        if ( file_exists( get_stylesheet_directory().$path ) ) {

            include get_stylesheet_directory().$path;
        }
        elseif ( file_exists( get_template_directory().$path ) ) {

            include get_template_directory().$path;
        }
    }


    /**
    * Renders and returns a module.
    *
    * @since  1.0.0
    * @param  string  $module  The name of the module.
    * @param  array  $data  The data made available to the module.
    * @return  string  HTML of module.
    */
    public static function render( $module, $data=array() )
    {
        ob_start();

        self::display( $module, $data );

        return ob_get_clean();
    }


} // end of class
