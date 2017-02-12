<?php

/*
 * This file is part of invokatis/sendotp package.
 *
 * (c) Invokatis Technologies <admin@invokatis.tech>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace SendOTP;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface as GuzzleInterface;

/**
 * Class Client
 * @package SendOTP
 */
class Client implements ClientInterface
{
    /**
     * @var GuzzleInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $key;

    /**
     * Client constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->client = new Guzzle(array(
            'base_uri' => 'https://sendotp.msg91.com/api/',
            'http_errors' => false,
        ));
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($number, $cc = '91', $retrieve = false)
    {
        $response = $this->client->post('generateOTP', array(
            'headers' => array('Application-Key' => $this->key),
            'json' => array(
                'countryCode' => $cc,
                'getGeneratedOTP' => $retrieve,
                'mobileNumber' => $number,
            ),
        ));
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            if ($json->status === 'success') {
                return $retrieve ? $json->response->oneTimePassword : true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function status($token, $number, $cc = '91')
    {
        $response = $this->client->get('checkStatus', array(
            'headers' => array('Application-Key' => $this->key),
            'query' => array(
                'countryCode' => $cc,
                'mobileNumber' => $number,
                'refreshToken' => $token,
            ),
        ));
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            return $json->status === 'success';
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function verify($input, $number, $cc = '91')
    {
        $response = $this->client->post('verifyOTP', array(
            'headers' => array('Application-Key' => $this->key),
            'json' => array(
                'countryCode' => $cc,
                'mobileNumber' => $number,
                'oneTimePassword' => $input,
            ),
        ));
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            if ($json->status === 'success') {
                return $json->response->refreshToken;
            }
        }
        return false;
    }
}
