<?php

namespace App\Controller;

use App\Classes\SendMail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ForgotPasswordFormType;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;


class ResetPasswordController extends AbstractController
{

    //Affiche le form pour mettre son email et recevoir un lien....
    /**
     * @Route("/form/reset-password", name="ResetPasswordForm")
     */
    public function index(): Response
    {
        $User = new User();
        $Form = $this->createForm(ForgotPasswordFormType::class, $User, [
            'action' => $this->generateUrl("ResetPasswordToken"),
            'method' => 'POST'
        ]);

        return $this->render('reset_password/index.html.twig', [
            'Form' => $Form->createView()
        ]);
    }

    //Crée le token et envoie le mail........
    /**
     * @Route("/reset-password", name="ResetPasswordToken")
     */
    public function ResetPasswordForm(Request $Request, ValidatorInterface $Validator, MailerInterface $Mailer): Response
    {
        $EmailConstraint = new Assert\Email();
        $EmailConstraint->message = 'Adresse mail invalide.';
        $Errors = $Validator->validate($_POST['forgot_password_form']['email'], $EmailConstraint);

        $User = new User();
        $Form = $this->createForm(ForgotPasswordFormType::class, $User);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() && 0 === count($Errors) )
        {
            $Doc = $this->getDoctrine()->getManager();
            $RepUsers = $Doc->getRepository(User::class);

            $User = $RepUsers->findOneBy(['email' => $Form->get('email')->getData()]);
            if($User)
            {
                $ResetPass = new ResetPassword();
                $ResetPass->setUser($User);
                $ResetPass->setToken(uniqid() );
                $ResetPass->setCreatedAt(new \DateTime());

                $Doc = $this->getDoctrine()->getManager();
                $Doc->persist($ResetPass);

                $Doc->flush();

                $UrlReset = "https://sondagepresidentielle.xyz".$this->generateUrl('ResetPassword', ['Token' => $ResetPass->getToken()]);

                $Mail = new SendMail($Mailer, $ResetPass->getToken());
                $Mail->execute();
                $this->addFlash('Msg', 'Vous allez bientôt recevoir un mail contenant un lien pour 
                redéfinir votre mot de passe.');

                return $this->redirectToRoute('ResetPasswordForm');
            }
            else
            {

                $this->addFlash("Err", "Cette adresse mail ne correspond à aucun compte.");
                return $this->redirectToRoute('ResetPasswordForm');
            }

        }
        else
        {
            if(count($Errors) > 0)
                $this->addFlash('Err', 'Adresse mail invalide');

            return $this->redirectToRoute('ResetPasswordForm');

        }


        return $this->render('reset_password/ResetForm.html.twig');
    }

    //Pour choisir un nouveau mot de passe.......
    /**
     * @Route("/reset-password/{Token}", name="ResetPassword")
     */
    public function Reset($Token): Response
    {
        $User = new User();
        $Form = $this->createForm(ResetPasswordType::class, $User, [
            'action' => $this->generateUrl("Reset", ['Token'=>$Token] ),
            'method' => 'POST'
        ]);


        return $this->render('reset_password/ResetForm.html.twig', [
            'Form' => $Form->createView(),
            'Token' => $Token
        ]);
    }

    //Enfin, redéfinition du mot de passe.......
    /**
     * @Route("/newpassword/{Token}", name="Reset")
     */
    public function Resetpass(Request $Request, UserPasswordEncoderInterface $Encoder, $Token): Response
    {
        $Doc = $this->getDoctrine()->getManager();
        $RepResetPassword = $Doc->getRepository(ResetPassword::class);

        //On vérifie si le token est bon..
        $ResetPass = $RepResetPassword->findOneBy(['Token' => $Token]);
        $Form = $this->createForm(ResetPasswordType::class, $ResetPass->getUser());

        $Form->handleRequest($Request);

        if($ResetPass)
        {

            if($Form->isSubmitted() && $Form->isValid())
            {

                 $NewPass = $Form->get('new_password')->getData();
                 $NewPassEncoder = $Encoder->encodePassword($ResetPass->getUser(), $NewPass);

                 $ResetPass->getUser()->setPassword($NewPassEncoder);

                 $Doc->remove($ResetPass);
                 $Doc->flush();

                 $this->addFlash('Msg', 'Votre mot de passe à bien été modifier.');
                 return $this->redirectToRoute('main');
            }
            else
            {
                if($Request->request->get('reset_password')['new_password']['first'] !=
                    $Request->request->get('reset_password')['new_password']['second'] )
                {
                    $this->addFlash('Err', 'Les mots de passes doivent êtes identiques.');
                    return $this->redirectToRoute('ResetPassword', ['Token' => $Token]);
                }

            }
        }
        else
        {
            return $this->redirectToRoute('main');
        }

    }


}
