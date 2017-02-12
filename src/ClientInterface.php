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
     * @param bool $retrieve
     * @return string|bool
     */
    public function generate($number, $cc = '91', $retrieve = false);

    /**
     * @param string $token
     * @param string $number
     * @param string $cc
     * @return bool
     */
    public function status($token, $number, $cc = '91');

    /**
     * @param string $input
     * @param string $number
     * @param string $cc
     * @return string|false
     */
    public function verify($input, $number, $cc = '91');
}
