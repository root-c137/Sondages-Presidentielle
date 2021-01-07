<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    /**
     * @Route("/vote/{slug}", name="vote")
     */
    public function index(Candidat $Candidat): Response
    {
        dd($Candidat);
        return $this->render('vote/index.html.twig', [
            'controller_name' => 'VoteController',
        ]);
    }
}
