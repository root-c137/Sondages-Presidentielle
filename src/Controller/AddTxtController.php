<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Form\TexteUpdateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddTxtController extends AbstractController
{
    /**
     * @Route("/form/add/txt", name="AddTxtForm")
     */
    public function index(): Response
    {

        $Texte = new Texte();
        $Form = $this->createForm(TexteUpdateFormType::class, $Texte, [
            'method' => 'POST',
            'action' => $this->generateUrl('AddTxt')
        ]);

        $Mode = "Add";

        return $this->render('update_txt/index.html.twig', [
            'Form' => $Form->createView(),
            'Mode' => $Mode
        ]);
    }

    /**
     * @Route("/add/txt", name="AddTxt")
     */
    public function AddTxt(Request $Request): Response
    {
        $Texte = new Texte();
        $Form = $this->createForm(TexteUpdateFormType::class, $Texte);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() )
        {
            $Texte = $Form->getData();
            $Doc = $this->getDoctrine()->getManager();

            $Doc->persist($Texte);
            $Doc->flush();

            $this->addFlash('Msg', 'Texte bien ajouté..');
            return $this->redirectToRoute('back_office');
        }
        else
        {
            $this->addFlash('Msg', "problème quelque part..");
            return $this->redirectToRoute('back_office');
        }
    }
}
