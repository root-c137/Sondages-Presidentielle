<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use \Mailjet\Resources;


class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        $mj = new \Mailjet\Client('5b2ccc83799e166ea583ffaf46cf787a','923784f11810a991ccbd8c3316cbb740',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mr.moussawalid@gmail.com",
                        'Name' => "Walid"
                    ],
                    'To' => [
                        [
                            'Email' => "mr.moussawalid@gmail.com",
                            'Name' => "Walid"
                        ]
                    ],
                    'Subject' => "Greetings from Mailjet.",
                    'TextPart' => "My first Mailjet email",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
