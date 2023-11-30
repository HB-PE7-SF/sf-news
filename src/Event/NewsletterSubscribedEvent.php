<?php

namespace App\Event;

use App\Entity\NewsletterEmail;

class NewsletterSubscribedEvent
{
    public const NAME = "newsletter.subscribed";

    public function __construct(
        private NewsletterEmail $email
    ) {
    }

    public function getEmail(): NewsletterEmail
    {
        return $this->email;
    }
}