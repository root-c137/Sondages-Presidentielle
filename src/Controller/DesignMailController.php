<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DesignMailController extends AbstractController
{
    /**
     * @Route("/design/mail", name="design_mail")
     */
    public function index(): Response
    {
        return $this->render('Mail/PasswordReset.html.twig');
    }
}
