<?php

$header = <<<EOF
This file is part of invokatis/sendotp package.

(c) Invokatis Technologies <contact@invokatis.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.md.
EOF;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return Config::create()
    ->setFinder(
        Finder::create()
            ->in(__DIR__ . '/src')
    )
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        'header_comment' => compact('header'),
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setUsingCache(true);
