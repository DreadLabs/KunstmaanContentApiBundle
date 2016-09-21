<?php

namespace DreadLabs\KunstmaanContentApiBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManagerInterface;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Kunstmaan\PagePartBundle\Helper\HasPagePartsInterface;
use Symfony\Component\Routing\RouterInterface;

class StubType
{
    /**
     * @var HasPagePartsInterface
     */
    private $entity;

    /**
     * @var NodeTranslation
     */
    private $translation;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param HasPagePartsInterface  $entity
     * @param NodeTranslation        $translation
     * @param RouterInterface        $router
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        HasPagePartsInterface $entity,
        NodeTranslation $translation,
        RouterInterface $router,
        EntityManagerInterface $entityManager
    ) {
        $this->entity = $entity;
        $this->translation = $translation;
        $this->router = $router;
        $this->entityManager = $entityManager;
    }
}
