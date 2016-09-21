<?php

namespace DreadLabs\KunstmaanContentApiBundle\EventListener;

use Negotiation\Accept;
use Negotiation\Negotiator;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MediaTypeListener
{
    /**
     * @var Negotiator
     */
    private $negotiator;

    /**
     * @var array
     */
    private $priorities = [];

    public function __construct(Negotiator $negotiator, array $priorities = [])
    {
        $this->negotiator = $negotiator;

        if (empty($priorities)) {
            $priorities = [
                'text/html',
            ];
        }

        $this->priorities = $priorities;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $mediaType = $this->negotiator->getBest(
            $request->headers->get('Accept'),
            $this->priorities
        );

        if (is_null($mediaType) || !$mediaType instanceof Accept) {
            return;
        }

        $request->attributes->set('media_type', $mediaType->getType());
    }
}
