<?php

/*
 * This file is part of invokatis/sendotp package.
 *
 * (c) Invokatis Technologies <contact@invokatis.com>
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
    const RESEND_TEXT = 'text';
    const RESEND_VOICE = 'voice';

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
     * @param string $endpoint
     */
    public function __construct($key, $endpoint = 'https://control.msg91.com/api/')
    {
        $this->client = new Guzzle([
            'base_uri' => $endpoint,
            'http_errors' => false,
        ]);
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($number, $cc = '91', array $params = [])
    {
        $response = $this->client->post('sendotp.php', [
            'form_params' => array_merge($params, [
                'authkey' => $this->key,
                'mobile' => $cc.$number,
            ]),
        ]);
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            return isset($json->type) && ('success' === $json->type);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function resend($number, $cc = '91', $type = self::RESEND_VOICE)
    {
        $response = $this->client->post('retryotp.php', [
            'form_params' => [
                'authkey' => $this->key,
                'mobile' => $cc.$number,
                'retrytype' => $type,
            ],
        ]);
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            return isset($json->type) && ('success' === $json->type);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function verify($input, $number, $cc = '91')
    {
        $response = $this->client->post('verifyRequestOTP.php', [
            'form_params' => [
                'authkey' => $this->key,
                'mobile' => $cc.$number,
                'otp' => $input,
            ],
        ]);
        if ($response->getStatusCode() === 200) {
            $json = json_decode((string)$response->getBody());
            return 'success' === $json->type;
        }
        return false;
    }
}
