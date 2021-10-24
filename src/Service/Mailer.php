<?php


// src/Controller/MailerController.php
namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Mailer
{
    /**
     * @Var MailerInterface
     */
    public $mailer;

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function sendMail($mail, $token)
    {
                
        $mail = (new TemplatedEmail())
        ->from('SAVmailing@donotreplied.fr')
        ->to(new Address($mail))
        ->subject('Valider votre mail // DO NOT REPLIED')
        ->htmlTemplate('sender/confirmation.html.twig')
        ->context([
            'token'=> $token,
        ]);

        $this->mailer->send($mail);

        // ...
    }
}