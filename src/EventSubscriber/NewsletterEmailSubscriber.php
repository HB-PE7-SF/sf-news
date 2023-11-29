<?php

namespace App\EventSubscriber;

use App\Event\NewsletterSubscribedEvent;
use App\Newsletter\EmailNotification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewsletterEmailSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EmailNotification $emailNotification
    ) {
    }

    public function onNewsletterSubscribed(NewsletterSubscribedEvent $event): void
    {
        $email = $event->getEmail();
        $this->emailNotification->confirmSubscription($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewsletterSubscribedEvent::NAME => 'onNewsletterSubscribed',
        ];
    }
}
