<?php

namespace App\EventDispatcher;

use App\Entity\User;
use App\Event\ContactSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Security;

class ContactSuccessEmailSubscriber implements EventSubscriberInterface
{      
    protected $logger;
    protected $mailer;
    protected $security;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer, Security $security)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            'contact.success' => 'sendSuccessEmail'
        ];
    }

    public function sendSuccessEmail(ContactSuccessEvent $contactSuccessEvent)
    {   

        $email = new TemplatedEmail();
        $email->from(new Address("contact@mail.com", "Infos de la boutique"))
            ->to("admin@mail.com")
            ->text("un visiteur vous a laissé un message" . $contactSuccessEvent->getContact()->getId())
            ->htmlTemplate('emails/contact_view.html.twig')
            ->context([
                'contact' => $contactSuccessEvent->getContact()
            ])
            ->subject("Message d'un visiteur");

        $this->mailer->send($email);

        $this->logger->info("Email envoyé à l'admin pour le produit " . $contactSuccessEvent->getContact()->getId());
    }
}