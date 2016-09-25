<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace DreadLabs\KunstmaanContentApiBundle\Api;

interface SerializableInterface
{
    /**
     * Returns the name of the API type (class).
     *
     * @return string
     */
    public function getApiType();
}
