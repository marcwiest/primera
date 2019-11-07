<?php

declare(strict_types=1);

namespace App\Classes;

defined('ABSPATH') || exit;

class MailchimpApi
{
    /**
    * Mailchimp API key.
    *
    * @since 1.0
    * @access private
    * @var string
    */
    private $apiKey = '';


    /**
    * Set Mailchimp subscriber status.
    *
    * @since 1.0
    * @access public
    * @link http://rudrastyh.com/mailchimp-api/subscription.html
    * @return json string
    */
    public static function setSubscriberStatus(array $args=[])
    {
        $args = wp_parse_args($args, [
            'email_address' => '', // subscriber email address
            'status'        => 'pending', // subscribed, unsubscribed, cleaned, pending
            'audience_id'   => '', // formerly list id
            'api_key'       => $this->apiKey, // Mailchimp API key
            'merge_fields'  => [], // ['FNAME' => '', 'LNAME' => '', ADDRESS => '', PHONE => ''],
        ]);

        if (empty($args['email_address'])) {
            return [
                'success' => false,
                'message' => 'Missing "email_address" argument.'
            ];
        }

        if (empty($args['api_key'])) {
            return [
                'success' => false,
                'message' => 'Missing "api_Key" argument.'
            ];
        }

        if (empty($args['audience_id'])) {
            return [
                'success' => false,
                'message' => 'Missing "audience_id" argument.'
            ];
        }

        // NOTE: Pending status will send a confirmation email.
        if (! in_array($args['status'], ['subscribed','unsubscribed','cleaned','pending'])) {
            return [
                'success' => false,
                'message' => 'Wrong status code. Must be one of either: "subscribed", "unsubscribed", "cleaned", "pending".'
            ];
        }

        // TODO: Delete concatenated string after joined array is tested.
        // $url = 'https://' . substr($args['api_key'],strpos($args['api_key'],'-')+1) . '.api.mailchimp.com/3.0/lists/' . $args['audience_id'] . '/members/' . md5(strtolower($args['email_address']))
        $url = join('', [
            'https://',
            substr($args['api_key'], strpos($args['api_key'], '-') + 1),
            '.api.mailchimp.com/3.0/lists/',
            $args['audience_id'],
            '/members/',
            md5(strtolower($args['email_address']))
        ]);

        $header = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode('user:' . $args['api_key']),
        ];

        // TODO: Refactor CURL using WP remote API instead.
        $mailchimp_api = curl_init();

        curl_setopt($mailchimp_api, CURLOPT_URL, $url);
        curl_setopt($mailchimp_api, CURLOPT_HTTPHEADER, $header);
        curl_setopt($mailchimp_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($mailchimp_api, CURLOPT_RETURNTRANSFER, true); // return the API response
        curl_setopt($mailchimp_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
        curl_setopt($mailchimp_api, CURLOPT_TIMEOUT, 10);
        curl_setopt($mailchimp_api, CURLOPT_POST, true);
        curl_setopt($mailchimp_api, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($mailchimp_api, CURLOPT_POSTFIELDS, json_encode([
            'apikey'        => $args['api_key'],
            'email_address' => $args['email_address'],
            'status'        => $args['status'],
            'merge_fields'  => $args['merge_fields'],
        ]));

        $result = curl_exec($mailchimp_api);

        if ($result->status == 400) {
            return [
                'success' => false,
                'errors' => $result->errors,
            ];
        }

        $r = json_decode($result, true);

        return wp_parse_args($r, [
            'success' => true,
        ]);
    }
}
