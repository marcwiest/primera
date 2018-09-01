<?php

abstract class primeraObjectPrefix_Mail
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
    */
    public static function send_contact_form()
    {
        // Form was not submitted via submit button.
        // TODO Test
        if ( empty( $_POST['submit'] ) ) {
            return;
        }

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
        if ( ! $message = sanitize_textarea_field( $_POST['message'] ) ) {
            $missing_fields[] = 'message';
        }

        if ( $missing_fields ) {
            // TODO
        }

        $to       = DEV_EMAIL;
        $reply_to = DEV_NAME.' <'.DEV_EMAIL.'>';

        // TODO Test
        // if ( 'production' == Orsak_Theme::get_env() ) {
        //     $to       = 'info@laneorzak.com';
        //     $reply_to = 'Lane Orsak <info@laneorzak.com>';
        // }

        $mail = array(
            'to'      => $to,
            'subject' => $subject,
            'message' => wpautop( $message ),
            'headers' => array(
                'Content-Type: text/html; charset=UTF-8',
                "from: $first_name $last_name <$email>",
                "reply-to: $reply_to",
            ),
            'attachments' => array(),
        );

        $success = wp_mail(
            $mail['to'],
            $mail['subject'],
            $mail['message'],
            $mail['headers'],
            $mail['attachments']
        );

        // if ( $success ) {}
        // else {}
    }


} // end of class
