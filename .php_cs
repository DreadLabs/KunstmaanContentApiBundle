<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

require_once __DIR__.'/vendor/autoload.php';

$header = <<<EOF
This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.

(c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors

For the full copyright and license information, please view the LICENSE.md
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config::create()
    //->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(
        [
            // contrib
            'header_comment',
            'newline_after_open_tag',
            'ordered_use',
            'phpdoc_order',
            'short_array_syntax',
        ]
    )
    ->finder(
        Symfony\CS\Finder::create()
            ->in(__DIR__)
    )
;
