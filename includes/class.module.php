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
        return $data = self::cast_object(
            wp_parse_args( $data, $defaults )
        );
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

        $args = array_slice( func_get_args(), 2 );

        foreach ( $args as $arg ) {
            $data = wp_parse_args( $data, $arg );
        }

        if ( ! is_object($data) ) {
            $data = self::cast_object( $data );
        }

        if ( ! isset($data->children) ) {
            $data->children = new stdClass;
        }

        if ( file_exists( get_stylesheet_directory().$path ) ) {

            include get_stylesheet_directory().$path;
        }
        elseif ( file_exists( get_template_directory().$path ) ) {

            include get_template_directory().$path;
        }
    }


    /**
    * Displays child modules.
    *
    * @since  1.0
    * @param  object|array|string  $children  Either a string or array of children's names or the
    *                                         entire $data object. Arrays can be numeric or
    *                                         associative holding child data.
    * @return  void
    */
    public static function display_children( $children )
    {
        if ( isset($children->children) ) {
            $children = $children->children;
        }

        if ( is_string($children) && $children ) {
            $children = explode( ' ', $children);
        }

        if ( ! empty($children) ) {

            foreach ( $children as $id => $data ) {

                if ( is_numeric($id) ) {
                    $id = $data;
                    $data = array();
                }

                self::display( $id, $data );
            }
        }
    }


    /**
    * Returns a module instead of displaying it.
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


    /**
    * Returns child modules instead of displaying them.
    *
    * @since  1.0.0
    * @param  string  $children
    * @return  string  HTML of child modules.
    */
    public static function render_children( $children )
    {
        ob_start();

        self::display_children( $children );

        return ob_get_clean();
    }


    /**
    * Cast an array into an object.
    *
    * Using json encode decode casts an array deeply rather than just the top level.
    *
    * @since  1.0
    * @param  array  $array
    * @return  object
    */
    public static function cast_object( $array )
    {
        $obj = ! empty($array) ? json_decode( wp_json_encode($array) ) : new stdClass;

        if ( wp_is_numeric_array($obj) && isset($obj[0]) ) {
            $obj = $obj[0];
        }

        return $obj;
    }
    }


} // end of class
