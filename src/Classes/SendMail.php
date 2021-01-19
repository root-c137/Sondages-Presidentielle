<?php

namespace App\Classes;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Mime\Email;


class SendMail
{
    protected static $defaultName = 'send:email';
    private $mailer;
    private $URL;

    public function __construct($mailer, $URL)
    {
        $this->mailer = $mailer;
        $this->URL = $URL;
    }
    public function execute()
    {
        $email = (new TemplatedEmail())
            ->from('rootem21@gmail.com')
            ->to('mr.moussawalid@gmail.com')
            ->subject('I love Me')
            ->context([
                'URL' => $this->URL
              ])
            ->htmlTemplate('Mail/PasswordReset.html.twig');
        // if you want use template from your twig file
        // template/emails/registration.html.twig


        $this->mailer->send($email);
    }
}