<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AddMyCorpHeaderListener
{
    public function __construct(
        private string $customHeaderValue
    ) {
    }

    public function addHeader(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->add(['X-DEVELOPED-BY' => $this->customHeaderValue]);
    }
}
