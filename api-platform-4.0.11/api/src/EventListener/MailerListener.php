<?php

namespace App\EventListener;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;


class MailerListener
{
    public function __construct(
        private string $emailServer,
        private string $emailContact,
        private MailerInterface $mailerInterface
    ) {

    }



    public function onContact(ContactEvent $contactEvent): void
    {
        $contact = $contactEvent->getContact();
        $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to($this->emailServer)
            ->subject('contact')
            ->htmlTemplate('mail/contactMail.html.twig')
            ->context(['contact' => $contact])
        ;
        try{
            $this->mailerInterface->send($email);
        }catch(TransportException $e){

        }
    }

    public function onSinging(UserEvent $userEvent): void {
        $user = $userEvent->getUser();
        $email = (new TemplatedEmail())
            ->from($this->emailServer)
            ->to($user->getEmail())
            ->subject('inscription')
            ->htmlTemplate('mail/singinMail.html.twig')
        ;
        try{
            $this->mailerInterface->send($email);
        }catch(TransportException $e){

        }
    }
}
