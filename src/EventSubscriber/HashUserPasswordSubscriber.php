<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashUserPasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        // Je récupère l'objet qui va être persisté
        $entity = $args->getObject();

        // Si l'objet n'est pas un User, je peux quitter cette méthode
        // Je ne suis pas concerné
        if (!$entity instanceof User) {
            return;
        }

        $entity->setPassword(
            $this->hasher->hashPassword($entity, $entity->getPassword())
        );
    }
}
