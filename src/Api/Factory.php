<?php

namespace DreadLabs\KunstmaanContentApiBundle\Api;

use Doctrine\ORM\EntityManagerInterface;
use DreadLabs\KunstmaanContentApiBundle\Api\Exception\MediaTypeNotFoundException;
use DreadLabs\KunstmaanContentApiBundle\Api\Exception\MediaTypeNotMatchException;
use DreadLabs\KunstmaanContentApiBundle\Api\Exception\NotSerializableEntityException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Routing\RouterInterface;

class Factory
{

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $mediaType;

    /**
     * Factory constructor.
     *
     * @param RouterInterface        $router
     * @param EntityManagerInterface $entityManager
     * @param string                 $mediaType
     */
    public function __construct(
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        $mediaType = 'application/json'
    ) {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->mediaType = $mediaType;
    }

    public function createFromRequestParameterBag(ParameterBag $attributes)
    {
        if (!$attributes->has('media_type')) {
            throw new MediaTypeNotFoundException(
                'The media_type attribute is not set in the request. Did you enabled the MediaTypeListener?'
            );
        }

        if ($attributes->get('media_type') !== $this->mediaType) {
            throw new MediaTypeNotMatchException(
                sprintf(
                    'The media_type attribute of the request "%s" does not match the configured one "%s".',
                    $attributes->get('media_type'),
                    $this->mediaType
                )
            );
        }

        $entity = $attributes->get('_entity');
        $translation = $attributes->get('_nodeTranslation');

        if (!$entity instanceof SerializableInterface) {
            throw new NotSerializableEntityException('The given entity is not marked for serialization.');
        }

        $type = $entity->getApiType();

        return new $type(
            $entity,
            $translation,
            $this->router,
            $this->entityManager
        );
    }
}
