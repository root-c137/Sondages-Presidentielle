<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdatePasswordController extends AbstractController
{
    /**
     * @Route("/update/password", name="Updatepassword")
     */
    public function index(): Response
    {
        return $this->render('update_password/index.html.twig', [
            'controller_name' => 'UpdatePasswordController',
        ]);
    }
}
