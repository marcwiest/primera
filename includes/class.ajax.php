<?php

# primeraRenderModule
add_action( 'wp_ajax_primeraRenderModule'        , 'Primera_AJAX::primeraRenderModule' );
add_action( 'wp_ajax_nopriv_primeraRenderModule' , 'Primera_AJAX::primeraRenderModule' );

/**
* Handels ajax requests.
*/
final class Primera_AJAX
{

    /**
    * Checks if the ajax nonce is valid.
    *
    * @since  1.0.0
    * @param  string  $query_arg  The $_REQUEST parameter that sends the nonce via ajax.
    * @param  string  $action  The action name as specified within wp_create_nonce.
    * @param  bool  $die  Whether to die if the nonce is invalid.
    * @return  bool  True if nonce is correct, false otherwise.
    */
    public static function check_nonce( $query_arg='nonce', $action='wp_ajax', $die=true )
    {
        return check_ajax_referer( $action, $query_arg, $die );
    }


    public static function new_response()
    {
        $response = new stdClass;
        $response->success = true;
        $response->code = 200;
        $response->message = '';

        return $response;
    }


    public static function get_request( $defaults )
    {
        return wp_parse_args( $_REQUEST, $defaults );
    }


    /**
    * Gets a module via ajax.
    *
    * @since  1.0.0
    * @return  void
    */
    public static function primeraRenderModule()
    {
        $response = self::new_response();
        $response->module = '';

        self::check_nonce();

        // $is_nonce_true = check_ajax_referer( 'wp_ajax', 'nonce' );
        // $module = isset($_REQUEST['module'])     ? $_REQUEST['module']     : '';
        // $data   = isset($_REQUEST['moduleData']) ? $_REQUEST['moduleData'] : array();

        $request = self::get_request( array(
            'module'     => '',
            'moduleData' => array(),
        ) );

        if ( $module = Primera_Module::render( $request['module'], $request['moduleData'] ) ) {

            $response->module  = $module;

            wp_send_json_success( $response );
        }
        else {

            $response->success = false;
            $response->code    = 500;
            $response->message = 'Your request needs to include a module parameter';

            wp_send_json_error( $response );
        }
    }


} // end of class
