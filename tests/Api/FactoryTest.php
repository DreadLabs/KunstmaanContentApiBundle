<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace DreadLabs\KunstmaanContentApiBundle\Tests\Api;

use Doctrine\ORM\EntityManagerInterface;
use DreadLabs\KunstmaanContentApiBundle\Api\Exception\MediaTypeNotFoundException;
use DreadLabs\KunstmaanContentApiBundle\Api\Exception\MediaTypeNotMatchException;
use DreadLabs\KunstmaanContentApiBundle\Api\Exception\NotSerializableEntityException;
use DreadLabs\KunstmaanContentApiBundle\Api\Factory;
use DreadLabs\KunstmaanContentApiBundle\Tests\Fixtures\InvalidEntity;
use DreadLabs\KunstmaanContentApiBundle\Tests\Fixtures\StubType;
use DreadLabs\KunstmaanContentApiBundle\Tests\Fixtures\ValidEntity;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RouterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $router;

    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var NodeTranslation|\PHPUnit_Framework_MockObject_MockObject
     */
    private $nodeTranslation;

    public function setUp()
    {
        $this->router = $this->getMockBuilder(RouterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->nodeTranslation = $this->getMockBuilder(NodeTranslation::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @test
     */
    public function it_is_constructable()
    {
        $factory = new Factory($this->router, $this->entityManager);

        $this->assertInstanceOf(Factory::class, $factory);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_mediatype_is_not_set()
    {
        $this->setExpectedException(
            MediaTypeNotFoundException::class,
            'The media_type attribute is not set in the request. Did you enabled the MediaTypeListener?'
        );

        $request = Request::create('/', 'GET', [], [], [], [], null);

        $factory = new Factory($this->router, $this->entityManager);
        $factory->createFromRequestParameterBag($request->attributes);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_mediatype_does_not_match()
    {
        $requested = 'text/html';
        $configured = 'application/json';

        $this->setExpectedException(
            MediaTypeNotMatchException::class,
            sprintf(
                'The media_type attribute of the request "%s" does not match the configured one "%s".',
                $requested,
                $configured
            )
        );

        $request = Request::create('/', 'GET', [], [], [], [], null);
        $request->attributes->set('media_type', $requested);

        $factory = new Factory($this->router, $this->entityManager, $configured);
        $factory->createFromRequestParameterBag($request->attributes);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_entity_is_not_marked_for_serialization()
    {
        $this->setExpectedException(
            NotSerializableEntityException::class,
            'The given entity is not marked for serialization.'
        );

        $request = Request::create('/', 'GET', [], [], [], [], null);
        $request->attributes->set('media_type', 'application/json');
        $request->attributes->set('_entity', new InvalidEntity());

        $factory = new Factory($this->router, $this->entityManager);
        $factory->createFromRequestParameterBag($request->attributes);
    }

    /**
     * @test
     */
    public function it_returns_an_api_popo_for_serialization_usage()
    {
        $request = Request::create('/', 'GET', [], [], [], [], null);
        $request->attributes->set('media_type', 'application/json');
        $request->attributes->set('_nodeTranslation', $this->nodeTranslation);
        $request->attributes->set('_entity', new ValidEntity());

        $factory = new Factory($this->router, $this->entityManager);
        $apiStub = $factory->createFromRequestParameterBag($request->attributes);

        $this->assertInstanceOf(StubType::class, $apiStub);
    }
}
