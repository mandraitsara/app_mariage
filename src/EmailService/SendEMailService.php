<?php

namespace App\EmailService;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendEmailService 
{
    public function __construct(private MailerInterface $mailer)
    {
        
    }

    public function sendEmail(
        string $from, string $to, string $subject, string $template, array $context
    ): void
    {
        $email = (new TemplatedEmail())
                ->from($from)
                ->to($to)
                ->subject($subject)
                ->htmlTemplate("security/$template.html.twig")
                ->context( $context);

        $this->mailer->send($email);
    }
}