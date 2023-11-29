<?php

namespace App\EventSubscriber;

use App\Entity\NewsletterEmail;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

class NewsletterEmailSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents(): array
    {
        return [
          Events::prePersist
        ];
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof NewsletterEmail) {
            return;
        }

        $entity
          ->setSubscribed(true)
          ->setSubscriptionDate(new \DateTime());
    }
}
