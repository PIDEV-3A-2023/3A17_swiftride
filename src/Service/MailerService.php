<?php
namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
   public function __construct(private MailerInterface $mailer)
    {
        
    }
    public function sendEmail($to): void
    {
        $email = (new Email())
            ->from('swiftride2023@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Code de vérification!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
try{
        $this->mailer->send($email);
}
 catch (TransportExceptionInterface $e) {
    // some error prevented the email sending; display an
    // error message or try to resend the message
    echo $e;
}
        // ...
    }
}