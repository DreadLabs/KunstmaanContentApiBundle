<?php

namespace DreadLabs\KunstmaanContentApiBundle\Tests\EventListener;

use DreadLabs\KunstmaanContentApiBundle\EventListener\MediaTypeListener;
use Negotiation\Accept;
use Negotiation\Negotiator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MediaTypeListenerTest extends \PHPUnit_Framework_TestCase
{

    const ACCEPT_HEADER = 'application/json;q=0.9,text/html,application/xhtml+xml,application/xml;q=0.8,*/*;q=0.7';

    /**
     * @var Negotiator|\PHPUnit_Framework_MockObject_MockObject
     */
    private $negotiator;

    /**
     * @var GetResponseEvent|\PHPUnit_Framework_MockObject_MockObject
     */
    private $event;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Accept
     */
    private $acceptHeader;

    public function setUp()
    {
        $this->negotiator = $this->getMockBuilder(Negotiator::class)->disableOriginalConstructor()->getMock();
        $this->event = $this->getMockBuilder(GetResponseEvent::class)->disableOriginalConstructor()->getMock();
        $this->request = Request::create(
            '/',
            'GET',
            [],
            [],
            [],
            [
                'HTTP_ACCEPT' => self::ACCEPT_HEADER,
            ],
            null
        );
        $this->acceptHeader = new Accept(self::ACCEPT_HEADER);
    }

    /**
     * @test
     */
    public function it_is_constructable()
    {
        new MediaTypeListener($this->negotiator);
    }

    /**
     * @test
     */
    public function it_queries_the_accept_header_of_the_request()
    {
        $this->event
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);

        $this->negotiator
            ->expects($this->once())
            ->method('getBest')
            ->with(
                $this->equalTo(self::ACCEPT_HEADER)
            )
            ->willReturn($this->acceptHeader);

        $listener = new MediaTypeListener($this->negotiator);
        $listener->onKernelRequest($this->event);
    }

    /**
     * @test
     */
    public function it_set_the_mediatype_attribute_in_the_request()
    {
        $this->event
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);

        $this->negotiator
            ->expects($this->once())
            ->method('getBest')
            ->with(
                $this->equalTo(self::ACCEPT_HEADER)
            )
            ->willReturn($this->acceptHeader);

        $listener = new MediaTypeListener($this->negotiator);
        $listener->onKernelRequest($this->event);

        $this->assertArrayHasKey('media_type', $this->request->attributes->all());
    }

    /**
     * @test
     */
    public function it_will_not_set_the_mediatype_attribute_in_the_request()
    {
        $this->event
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);

        $this->negotiator
            ->expects($this->once())
            ->method('getBest')
            ->with(
                $this->equalTo(self::ACCEPT_HEADER)
            )
            ->willReturn(null);

        $listener = new MediaTypeListener($this->negotiator);
        $listener->onKernelRequest($this->event);

        $this->assertArrayNotHasKey('media_type', $this->request->attributes->all());
    }
}
