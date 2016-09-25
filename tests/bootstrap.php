<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace {
    if (!$loader = @include __DIR__.'/../vendor/autoload.php') {
        echo <<<'EOM'
You must set up the project dependencies by running the following commands:

curl -s http://getcomposer.org/installer | php
php composer.phar install

EOM;
        exit(1);
    }
}
