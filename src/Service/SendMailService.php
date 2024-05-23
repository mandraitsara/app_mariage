<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendMailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Envoie un email.
     *
     * @param string $from L'adresse email de l'expéditeur
     * @param string $to L'adresse email du destinataire
     * @param string $subject Le sujet de l'email
     * @param string $template Le template Twig de l'email
     * @param array $context Les variables de contexte pour le template
     */
    public function sendEmail(string $from, string $to, string $subject, string $template, array $context): void
    {
        $email = (new TemplatedEmail())
                ->from(new Address($from))
                ->to(new Address($to))
                ->subject($subject)
                ->htmlTemplate($template)
                ->context($context);

        $this->mailer->send($email);
    }
}
