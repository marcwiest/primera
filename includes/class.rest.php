<?php

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
* Handles REST requests.
*/
abstract class REST
{

    /**
    * Constructor method.
    *
    * @since  1.0.0
    * @return  void
    */
    public static function init()
    {
        // Get something.
        register_rest_route( 'primeraFunctionPrefix/v1', '/get-somthing/', array(
            'methods'  => 'GET',
            'callback' => __CLASS__ . '::get_something',
        ), true );

        // Post something.
        register_rest_route( 'primeraFunctionPrefix/v1', '/post-somthing/', array(
            'methods'  => 'POST',
            'callback' => __CLASS__ . '::post_something',
        ), true );
    }


    /**
    * Creates a new request object.
    *
    * @since  1.0
    * @return  void
    */
    public static function new_response()
    {
        // TODO: Register rest routes hook here and place callbacks below inside this obj.
    }


    /**
    * Get something.
    *
    * @since  1.0
    * @param  object  $req  The request coming from the client. See WP_REST_Request form details.
    * @return  object  $resp  The response that is being send back to the server.
    */
    public static function get_something( WP_REST_Request $req )
    {
        // # You can access parameters via direct array access on the object or via the helper method:
        // $parameters = $req['some_param'];
        // $parameters = $req->get_param( 'some_param' );
        // # You can get the combined, merged set of parameters:
        // $parameters = $req->get_params();
        // # The individual sets of parameters are also available, if needed:
        // $parameters = $req->get_url_params();
        // $parameters = $req->get_query_params();
        // $parameters = $req->get_body_params();
        // $parameters = $req->get_json_params();
        // $parameters = $req->get_default_params();
        // # Uploads aren't merged in, but can be accessed separately:
        // $parameters = $req->get_file_params();

        $resp          = new stdClass;
        $resp->success = true;

        if ( empty($req['someParam']) ) {

            $resp->success = false;

            $resp = new WP_Error(
                'primeraFunctionPrefix_wp_rest_missing_parameter',
                'The "someParam" parameter is required.',
                get_object_vars( $resp )
            );
        }

        return rest_ensure_response( $resp );
    }


    /**
    * Post something.
    *
    * @since  1.0
    * @param  object  $request  The request coming from the client. See WP_REST_Request form details.
    * @return  object  $response  The response that is being send back to the server.
    */
    public static function post_something( $request )
    {
        $resp          = new stdClass;
        $resp->success = true;

        return rest_ensure_response( $response );
    }


} // end of class
