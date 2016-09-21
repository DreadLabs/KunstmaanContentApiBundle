<?php

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
