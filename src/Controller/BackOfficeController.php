<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Texte;
use App\Form\CandidatFormType;
use App\Form\TexteUpdateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackOfficeController extends AbstractController
{
    /**
     * @Route("/backo", name="back_office")
     */
    public function index(): Response
    {
        $Doc = $this->getDoctrine()->getRepository(Candidat::class);

        $Candidats = $Doc->findAll();

        return $this->render('back_office/index.html.twig', [
            'Candidats' => $Candidats
        ]);
    }

    /**
     * @Route("/backo/ajouter-un-candidat", name="AddCandidatForm")
     */
    public function AddCandidat(Request $Request): Response
    {
        $Candidat = new Candidat();
        $Form = $this->createForm(CandidatFormType::class, $Candidat, [
            'action' => $this->generateUrl('AddCandidat'),
            'method' => 'POST'
        ]);

        return $this->render('back_office/AddCandidat.html.twig', [
            'Form' => $Form->createView(),
            'Mode' => 'ADD'
        ]);
    }

    /**
     * @Route("/backo/candidat/Update/{slug}", name="UpdateCandidatForm")
     */
    public function UpdateCandidatForm(Candidat $Candidat): Response
    {
        $Form = $this->createForm(CandidatFormType::class, $Candidat, [
            'action' => $this->generateUrl('UpdateCandidat', ['slug' => $Candidat->getSlug()]),
            'method' => 'POST',
        ]);

        return $this->render('back_office/AddCandidat.html.twig', [
            'Form' => $Form->createView(),
            'Candidat' => $Candidat,
            'Mode' => 'UPDATE'
        ]);
    }


    /**
     * @Route("/backo/candidat/Delete/{slug}", name="DeleteCandidatForm")
     */
    public function DeleteCandidatForm(Candidat $Candidat): Response
    {
        return $this->render('back_office/DeleteCandidat.html.twig', [
            'Candidat' => $Candidat,
        ]);
    }



    /**
     * @Route("/backo/textes", name="TxtBackoForm")
     */
    public function UpdateTxtForm(): Response
    {
        $Texte = new Texte();
        $Form = $this->createForm(TexteUpdateFormType::class, $Texte, [
            'method' => 'POST',
            'action' => $this->generateUrl('UpdateTxt')
        ]);

        return $this->render('back_office/Textes.html.twig', [
            'Form' => $Form->createView()
        ]);
    }

    /**
     * @Route("/backo/textes/updatetxt/", name="UpdateTxt")
     */
    public function UpdateTxt(): Response
    {

        dd('cc');
        return $this->render('back_office/Textes.html.twig');
    }





}
