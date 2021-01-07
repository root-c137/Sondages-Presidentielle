<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/candidat/Add", name="AddCandidat")
     */
    public function AddCandidat(Request $Request): Response
    {
        dd($Request);
        $Doc = $this->getDoctrine()->getRepository(Candidat::class);

        $Candidats = $Doc->findAll();

        return $this->render('back_office/index.html.twig', [
            'Candidats' => $Candidats
        ]);
    }

    /**
     * @Route("/candidat/Update/Update/{slug}", name="UpdateCandidat")
     */
    public function UpdateCandidat(Candidat $Candidat, Request $Request): Response
    {
        $Doc = $this->getDoctrine()->getManager();

        $LastCandidat = $Doc->getRepository(Candidat::class)->find($Candidat->getId() );

        $Form = $this->createForm(CandidatFormType::class, $Candidat);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() )
        {
            $LastCandidat = $Form->getData();
            $Doc->flush();

            $this->addFlash('Msg', 'Informations bien modifiés.');

            return $this->redirectToRoute('UpdateCandidatForm', ['slug' => $LastCandidat->getSlug()]);
        }
    }


    /**
     * @Route("/candidat/Delete/Delete/{slug}", name="DeleteCandidat")
     */
    public function DeleteCandidat(Candidat $Candidat): Response
    {
       $Doc = $this->getDoctrine()->getManager();

       $Doc->remove($Candidat );
       $Doc->flush();

       return $this->redirectToRoute('back_office');
    }

}


