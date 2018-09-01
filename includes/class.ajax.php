<?php

/**
* Handles AJAX requests.
*/
abstract class primeraObjectPrefix_AJAX
{

    public static function init()
    {
    	// Action: primeraRenderModule
    	add_action( 'wp_ajax_primeraRenderModule'        , __CLASS__ . '::render_module' );
    	add_action( 'wp_ajax_nopriv_primeraRenderModule' , __CLASS__ . '::render_module' );
    }

    /**
    * Checks if the ajax nonce is valid.
    *
    * @since  1.0.0
    * @param  string  $action  The action name as specified within wp_create_nonce.
    * @param  string  $query_arg  Where to look for nonce in $_REQUEST.
    * @param  bool  $die  Whether to die if the nonce is invalid.
    * @return  bool  True if nonce is correct, false otherwise.
    */
    public static function check_nonce( $action='wp_ajax', $query_arg='nonce', $die=true )
    {
        return check_ajax_referer( $action, $query_arg, $die );
    }


    public static function new_response()
    {
        $response = new stdClass;
        $response->success = true;
        $response->code = 200;
        $response->message = get_status_header_desc( 200 );

        return $response;
    }


    /**
    * Gets a module via ajax.
    *
    * @since  1.0.0
    * @return  void
    */
    public static function render_module()
    {
        $response = self::new_response();
        $response->module = '';

        self::check_nonce();

        // $is_nonce_true = check_ajax_referer( 'wp_ajax', 'nonce' );
        // $module = isset($_REQUEST['module'])     ? $_REQUEST['module']     : '';
        // $data   = isset($_REQUEST['moduleData']) ? $_REQUEST['moduleData'] : array();

        $request = wp_parse_args( $_REQUEST, array(
            'module'     => '',
            'moduleData' => array(),
        ) );

        if ( $module = primeraObjectPrefix_Module::render( $request['module'], $request['moduleData'] ) ) {

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
