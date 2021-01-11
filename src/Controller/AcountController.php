<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UpdateUserFormType;
use App\Security\LoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;


class AcountController extends AbstractController
{
    /**
     * @Route("/Compte", name="acount")
     */
    public function index(): Response
    {
        $Form = $this->createForm(UpdateUserFormType::class, $this->getUser(), [
            'action' => $this->generateUrl('UpdateUser'),
            'method' => 'POST'
        ]);

        return $this->render('acount/index.html.twig', [
            'Form' => $Form->createView(),
        ]);
    }

    /**
     * @Route("/Compte/UpdateUser", name="UpdateUser")
     */
    public function UpdateUser(Request $Request, ValidatorInterface $Validator,
                               GuardAuthenticatorHandler $Guard,LoginAuthenticator $Login): Response
    {


        $User = $this->getUser();
        $Form = $this->createForm(UpdateUserFormType::class, $User);
        $Form->handleRequest($Request);

        $EmailConstraint = new Assert\Email();
        $EmailConstraint->message = 'Adresse mail invalide.';
        $Errors = $Validator->validate($Form->get('email')->getData(), $EmailConstraint);

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

                        $Doctrine->persist($User);
                        $Doctrine->flush();

                        return $this->redirectToRoute('acount');
                    } else
                    {
                        $this->addFlash("Err", "Cette adresse mail existe déjà..");
                        return $this->redirectToRoute('acount');
                    }

                }
                //si code postal incorrect...
                else
                {
                    $this->addFlash("Err", "Le code postal est incorrect.");
                    return $this->redirectToRoute('acount');
                }
            }
            //Si l'age n'est pas bon...
            else
            {
                $this->addFlash('Err', 'Veuillez entrer un age valide.');
                return $this->redirectToRoute('acount');
            }
        }
        else
        {
                $this->addFlash('Err', 'Adresse mail invalide');

            return $this->redirectToRoute('acount');
        }
    }
}
