<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Form\TexteUpdateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateTxtController extends AbstractController
{
    /**
     * @Route("/form/update-txt/{id}", name="UpdateTxtForm")
     */
    public function UpdateTxtForm($id): Response
    {
        $Doc = $this->getDoctrine()->getManager();
        $RepTxt = $Doc->getRepository(Texte::class);

        $Texte = $RepTxt->find($id);

        $Form = $this->createForm(TexteUpdateFormType::class, $Texte, [
            'method' => 'POST',
            'action' => $this->generateUrl('UpdateTxt', ['id' => $id])
        ]);

        $Mode = "Update";
        return $this->render('update_txt/index.html.twig', [
            'Form' => $Form->createView(),
            'Mode' => $Mode
        ]);
    }

    /**
     * @Route("/UpdateTxt/{id}", name="UpdateTxt")
     */
    public function UpdateTxt(Request $Request, $id): Response
    {
        $Doc = $this->getDoctrine()->getManager();
        $RepTxt = $Doc->getRepository(Texte::class);
        $Txt = $RepTxt->find($id);

        if(!$Txt)
        {
            return $this->redirectToRoute('UpdateTxtForm');
            exit;
        }

        $Form = $this->createForm(TexteUpdateFormType::class, $Txt);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() )
        {
            $Txt = $Form->getData();
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
