<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Security\LoginAuthenticator;
use Symfony\Component\Validator\Constraints as Assert;


class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="register")
     */
    public function index(): Response
    {
        $Doc = $this->getDoctrine()->getManager();
        $RepTxt = $Doc->getRepository(Texte::class);

        $TxtInscription = $RepTxt->findOneBy(['location' => 'inscription']);

        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User, [
            'action' => $this->generateUrl('newuser'),
            'method' => 'POST'
        ]);


        return $this->render('register/index.html.twig', [
            'Form' => $Form->createView(),
            'TxtInscription' => $TxtInscription->getTxt()
        ]);
    }

    /**
     * @Route("/NewUser", name="newuser")
     */
    public function NewUser(Request $Request, UserPasswordEncoderInterface $Encoder, ValidatorInterface $Validator,
GuardAuthenticatorHandler $Guard,LoginAuthenticator $Login): Response
    {

        $EmailConstraint = new Assert\Email();
        $EmailConstraint->message = 'Adresse mail invalide.';
        $Errors = $Validator->validate($_POST['register']['email'], $EmailConstraint);
        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() && 0 === count($Errors) )
        {
            $Age = $Form->get('datenaissance')->getData();
            if(is_integer($Form->get('datenaissance')->getData()) && $Age > 0)
            {
                //On verifie si le code postal est correct...
                if(preg_match("~^[0-9]{5}$~", $Form->get('codepostal')->getData() , $match) )
                {

                    $Doctrine = $this->getDoctrine()->getManager();
                    $BDD = $this->getDoctrine()->getRepository(User::class);
                    $UserTest = $BDD->findOneBy(['email' => $User->getEmail()]);

                    if (!$UserTest)
                    {
                        $User = $Form->getData();
                        $User->setMp($User->getPassword() );
                        $Pass = $Encoder->encodePassword($User, $User->getPassword());
                        $User->setPassword($Pass);

                        $Doctrine->persist($User);
                        $Doctrine->flush();

                        return $Guard->authenticateUserAndHandleSuccess($User, $Request, $Login, 'main');
                    } else
                    {
                        $this->addFlash("Err", "Cette adresse mail existe déjà..");
                        return $this->redirectToRoute('register');
                    }

                }
                //si code postal incorrect...
                else
                {
                    $this->addFlash("Err", "Le code postal est incorrect.");
                    return $this->redirectToRoute('register');
                }
            }
            //Si l'age n'est pas bon...
            else
            {
                $this->addFlash('Err', 'Veuillez entrer un age valide.');
                return $this->redirectToRoute('register');
            }
        }
        else
        {
            if(count($Errors) > 0)
                $this->addFlash('Err', 'Adresse mail invalide');
            else
                $this->addFlash('Err', 'Les mots de passes ne sont pas identiques..');

           return  $this->redirectToRoute('register');
        }
    }


}
