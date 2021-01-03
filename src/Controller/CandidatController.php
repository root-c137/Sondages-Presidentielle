<?php

namespace App\Controller;

use App\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat/{slug}", name="candidat")
     */
    public function index(Candidat $Candidat): Response
    {
        return $this->render('candidat/index.html.twig', [
            'Candidat' => $Candidat
        ]);
    }
}
