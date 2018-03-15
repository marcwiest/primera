<?php

/**
* Handles REST requests.
*/
final class Primera_REST
{

    /**
    * Constructor method.
    *
    * @since  1.0.0
    * @return  void
    */
    public function __construct()
    {}


    /**
    * Creates a new request object.
    *
    * @since  1.0
    * @return  void
    */
    public static function new_response()
    {
        $response = new stdClass;
        $response->success = true;
        $response->status  = 200;
        $response->message = '';

        return $response;
    }


    /**
    * Get something.
    *
    * @since  1.0
    * @param  object  $request  The request coming from the client. See WP_REST_Request form details.
    * @return  object  $response  The response that is being send back to the server.
    */
    public static function get_something( $request )
    {
        // # You can access parameters via direct array access on the object or via the helper method:
        // $parameters = $request['some_param'];
        // $parameters = $request->get_param( 'some_param' );
        // # You can get the combined, merged set of parameters:
        // $parameters = $request->get_params();
        // # The individual sets of parameters are also available, if needed:
        // $parameters = $request->get_url_params();
        // $parameters = $request->get_query_params();
        // $parameters = $request->get_body_params();
        // $parameters = $request->get_json_params();
        // $parameters = $request->get_default_params();
        // # Uploads aren't merged in, but can be accessed separately:
        // $parameters = $request->get_file_params();

        $response = self::new_response();

        if ( empty($request['data']) ) {
            $response = new WP_Error(
                'primera_rest_missing_parameter',
                'The data parameter is required.',
                array( 'status' => 400 )
            );
        }

        return rest_ensure_response( $response );
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
        $response = self::new_response();

        return rest_ensure_response( $response );
    }


} // end of class
