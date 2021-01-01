<?php

namespace App\Controller;

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
        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User, [
            'action' => $this->generateUrl('newuser'),
            'method' => 'POST'
        ]);


        return $this->render('register/index.html.twig', [
            'Form' => $Form->createView()
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
            $Doctrine = $this->getDoctrine()->getManager();
            $BDD = $this->getDoctrine()->getRepository(User::class);
            $UserTest =  $BDD->findOneBy(['email' => $User->getEmail()] );


            if(!$UserTest)
            {
                $User = $Form->getData();
                $Pass = $Encoder->encodePassword($User, $User->getPassword());

                $User->setPassword($Pass);

                $Doctrine = $this->getDoctrine()->getManager();
                $Doctrine->persist($User);
                $Doctrine->flush();;

                return $Guard->authenticateUserAndHandleSuccess($User,$Request,$Login,'main');
            }
            else
            dd("user existe déjà..");
        }
        else
            dd('err..'.count($Errors) );

        return $this->render('register/index.html.twig');
    }




}
