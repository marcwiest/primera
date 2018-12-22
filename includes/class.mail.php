<?php

namespace primeraPhpNamespace;

// Exit if accessed directly.
defined('ABSPATH') || exit;

use primeraPhpNamespace\Theme;

abstract class Mail
{

    /**
    * Constructor method.
    *
    * @since  1.0
    */
    public static function init()
    {
        $form_action = 'contact_form'; // must match: $_POST['action']
        add_action( 'admin_post_nopriv' . $form_action , __CLASS__ . '::send_contact_form' );
        add_action( 'admin_post' . $form_action        , __CLASS__ . '::send_contact_form' );
    }


    /**
    * Sends the contact form.
    *
    * @since  1.0
    * @return  array|bool  Array: missing fields, true otherwise.
    */
    public static function send_contact_form( $data=null )
    {
        if ( ! is_array( $data ) ) {
            $data = $_POST;
        }

        $should_redirect = boolval( $data['should_redirect'] );
        $post_id         = absint( $data['post_id'] );

        if ( ! $first_name = sanitize_text_field( $_POST['first-name'] ) ) {
            $missing_fields[] = 'first-name';
        }
        if ( ! $last_name = sanitize_text_field( $_POST['last-name'] ) ) {
            $missing_fields[] = 'last-name';
        }
        if ( ! $email = sanitize_email( $_POST['email'] ) ) {
            $missing_fields[] = 'email';
        }
        if ( ! $subject = sanitize_text_field( $_POST['subject'] ) ) {
            $missing_fields[] = 'subject';
        }
        if ( ! $message = wp_kses_post( wpautop( $_POST['message'] ) ) ) {
            $missing_fields[] = 'message';
        }

        if ( $missing_fields ) {
            return $missing_fields;
        }

        $to = 'marc@marcwiest.com';
        // if ( 'production' == Theme::get_env() ) {
        //     $to = 'someone@example.com';
        // }

        $headers = array(
            "MIME-Version: 1.0",
            "Content-Type: text/html; charset=UTF-8",
            "From: $first_name $last_name <$email>",
            // "Reply-To: superman@crypton.planet",
            // "Cc: John Q Codex <jqc@wordpress.org>",
            // "Bcc: iluvwp@wordpress.org",
        );

        $attachments = array();

        $success = wp_mail( $to, $subject, $message, $headers, $attachments );

        if ( $post_id && $should_redirect ) {

            $redirect_url = add_query_arg( array( 'success' => $success ), get_the_permalink( $post_id ) );

            wp_redirect( esc_url( $redirect_url ) );
            exit;
        }
        else {
            return $success;
        }
    }


} // end of class
