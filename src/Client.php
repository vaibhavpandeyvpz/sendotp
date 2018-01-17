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
            'base_uri' => 'https://control.msg91.com/api/',
            'http_errors' => false,
        ));
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($number, $cc = '91', array $params = [])
    {
        $response = $this->client->get('sendotp.php', array(
            'query' => array_merge($params, [
                'authkey' => $this->key,
                'mobile' => $cc.$number,
            ]),
        ));
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            return 'success' === $json->type;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function verify($input, $number, $cc = '91')
    {
        $response = $this->client->get('verifyRequestOTP.php', array(
            'query' => array(
                'authkey' => $this->key,
                'mobile' => $cc.$number,
                'otp' => $input,
            ),
        ));
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            return 'success' === $json->type;
        }
        return false;
    }
}
