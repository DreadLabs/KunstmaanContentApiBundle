<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace DreadLabs\KunstmaanContentApiBundle\Tests\Fixtures;

use DreadLabs\KunstmaanContentApiBundle\Api\SerializableInterface;
use Kunstmaan\PagePartBundle\Helper\HasPagePartsInterface;
use Kunstmaan\PagePartBundle\PagePartAdmin\PagePartAdminConfiguratorInterface;

class ValidEntity implements SerializableInterface, HasPagePartsInterface
{
    /**
     * Returns the name of the API type (class).
     *
     * @return string
     */
    public function getApiType()
    {
        return StubType::class;
    }

    public function getId()
    {
        return 1;
    }

    /**
     * @return PagePartAdminConfiguratorInterface[]
     */
    public function getPagePartAdminConfigurations()
    {
        return [];
    }
}
