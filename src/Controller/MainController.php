<?php

namespace App\Controller;

use App\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $D = $this->getDoctrine()->getRepository(Candidat::class);

        $Candidats = $D->findAll();

        return $this->render('main/index.html.twig',[
            'Candidats' => $Candidats
        ]);
    }

}
