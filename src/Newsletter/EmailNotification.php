<?php

namespace App\Newsletter;

use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotification
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function confirmSubscription(NewsletterEmail $newsletterEmail): void
    {
        $email = (new Email())
          ->from('admin@mycorp.info')
          ->to($newsletterEmail->getEmail())
          ->subject("Merci pour votre inscription")
          ->text("Votre email " . $newsletterEmail->getEmail() . " a bien été enregistré dans notre newsletter");

        $this->mailer->send($email);
    }
}
