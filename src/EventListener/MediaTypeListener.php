<?php

/*
 * This file is part of the `DreadLabs/KunstmaanContentApiBundle` project.
 *
 * (c) https://github.com/DreadLabs/KunstmaanContentApiBundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

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
            $request->headers->get('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'),
            $this->priorities
        );

        if (is_null($mediaType) || !$mediaType instanceof Accept) {
            return;
        }

        $request->attributes->set('media_type', $mediaType->getType());
    }
}
