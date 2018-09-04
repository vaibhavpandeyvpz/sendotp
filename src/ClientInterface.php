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

/**
 * Interface ClientInterface
 * @package SendOTP
 */
interface ClientInterface
{
    /**
     * @param string $number
     * @param string $cc
     * @param array $params
     * @return bool
     */
    public function generate($number, $cc = '91', array $params = []);

    /**
     * @param string $number
     * @param string $cc
     * @param string $type
     * @return bool
     */
    public function resend($number, $cc = '91', $type = 'voice');

    /**
     * @param string $input
     * @param string $number
     * @param string $cc
     * @return bool
     */
    public function verify($input, $number, $cc = '91');
}
