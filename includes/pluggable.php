<?php
/**
* Holds pluggable functions.
*/


if ( ! function_exists('get_dynamic_sidebar') ) :
/**
* Get dynamic sidebar.
*
* @since  1.0
* @param  array  $name  Name of sidebar.
* @return  string  HTML of sidebar widgets.
*/
function get_dynamic_sidebar( $name )
{
    ob_start();
    dynamic_sidebar( $name );
    return ob_get_clean();
}
endif;


if ( ! function_exists('get_current_user_roles') ) :
/**
* Get current user's roles.
*
* This function returns an array because it is possible for a user to have multiple roles.
*
* @since  1.0
* @param  int  $user  ID of user.
* @return  array  Numeric array of a user's roles.
*/
function get_current_user_roles( $user=null )
{
	$user = $user ? new WP_User( absint($user) ) : wp_get_current_user();

	return $user->roles ? $user->roles : array();
}
endif;


if ( ! function_exists('time_ago') ) :
/**
* Get the time ago from any date().
*
* @since  1.0
* @param  string  $date  Any date value.
* @param  string  $suffix  The suffix for the return value.
* @return  string  A value relative to how long ago from $date (e.g. 2 days ago, 1 hour ago).
*/
function time_ago( $date, $suffix=' ago' )
{
    $date = new DateTime( $date );
    return human_time_diff( $date->format('U'), current_time('timestamp') ) . $suffix;
}
endif;
