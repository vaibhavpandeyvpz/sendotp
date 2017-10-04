# invokatis/sendotp
API abstraction for [SendOTP](https://sendotp.msg91.com/) service by [MSG91](https://msg91.com/).

[![Latest Version][latest-version-image]][latest-version-url]
[![Downloads][downloads-image]][downloads-url]
[![PHP Version][php-version-image]][php-version-url]
[![License][license-image]][license-url]

[![SensioLabsInsight][insights-image]][insights-url]

Install
-------
```bash
composer require invokatis/sendotp
```

Usage
-----
```php
<?php

/**
 * @desc Create a SendOTP\Client with your auth key.
 */
$client = new SendOTP\Client('<auth-key>');

/**
 * @desc Send and retrieve whether successful or not.
 */
$sent = $client->generate('9876543210', '91');

/**
 * @desc Verify an OTP entered by user.
 */
$token = $client->verify($_POST['otp'], '9876543210', '91');
if (false !== $token) {
    // OTP verified successfully!
}
```

License
------
See [LICENSE.md][license-url] file.

[latest-version-image]: https://img.shields.io/github/release/invokatis/sendotp.svg?style=flat-square
[latest-version-url]: https://github.com/invokatis/sendotp/releases
[downloads-image]: https://img.shields.io/packagist/dt/invokatis/sendotp.svg?style=flat-square
[downloads-url]: https://packagist.org/packages/invokatis/sendotp
[php-version-image]: http://img.shields.io/badge/php-5.4+-8892be.svg?style=flat-square
[php-version-url]: https://packagist.org/packages/invokatis/sendotp
[license-image]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[license-url]: LICENSE.md
[insights-image]: https://insight.sensiolabs.com/projects/3e4dcd7b-4dcf-4327-b6d5-489900e8b7d0/small.png
[insights-url]: https://insight.sensiolabs.com/projects/3e4dcd7b-4dcf-4327-b6d5-489900e8b7d0
