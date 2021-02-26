<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;


class SendMail
{
    private $Api_Key = '5b2ccc83799e166ea583ffaf46cf787a';
    private $Api_Key_Secret = '923784f11810a991ccbd8c3316cbb740';


    public function send($to_mail,  $Content)
    {
        $mj  = new Client($this->Api_Key, $this->Api_Key_Secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contact@sondagepresidentielle.xyz",
                        'Name' => "sondagepresidentielle.xyz"
                    ],
                    'To' => [
                        [
                            'Email' => $to_mail,
                            'Name' => "passenger 1"
                        ]
                    ],
                    'TemplateID' => 2379529,
                    'TemplateLanguage' => true,
                    'Subject' => "Modifiez votre mot de passe",
                    'Variables' => [
                        "Content"=> $Content
                    ]
                ]
            ]
        ];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}

