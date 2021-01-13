<?php

namespace App\Controller;

use App\Form\UpdatePasswordFormType;
use App\Form\UpdateUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UpdatePasswordController extends AbstractController
{
    /**
     * @Route("/update/password", name="UpdatePasswordForm")
     */
    public function index(): Response
    {
        $Form = $this->createForm(UpdatePasswordFormType::class, $this->getUser(), [
            'action' => $this->generateUrl('UpdatePassword'),
            'method' => 'POST'
        ]);

        return $this->render('update_password/index.html.twig', [
            'Form' => $Form->createView()
        ]);
    }

    /**
     * @Route("/update/password/update", name="UpdatePassword")
     */
    public function UpdatePass(Request $Request,  UserPasswordEncoderInterface $Encoder): Response
    {

       $Form = $this->createForm(UpdatePasswordFormType::class);
       $Form->handleRequest($Request);

       if($Form->isSubmitted() && $Form->isValid() )
       {
           $OldPass = $Form->get('password')->getData();
           if($Encoder->isPasswordValid($this->getUser(), $OldPass) )
           {
               $NewPass = $Form->get('new_password')->getData();
               $NewPassH = $Encoder->encodePassword($this->getUser(), $NewPass);

               $this->getUser()->setPassword($NewPassH);

               $Doc = $this->getDoctrine()->getManager();
               $Doc->flush();

               $this->addFlash('Msg', 'Votre mot de passe à bien été modifier.');
               return $this->redirectToRoute('UpdatePasswordForm');
           }
           else
           {
               $this->addFlash('Err', "Le mot de passe actuel n'est pas valide");
               return $this->redirectToRoute('UpdatePasswordForm');
           }
       }
       else
       {
           $this->addFlash('Err', "Les mots de passes ne correspondent pas..");
           return $this->redirectToRoute('UpdatePasswordForm');
       }
    }
}
