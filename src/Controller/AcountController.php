<?php

namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcountController extends AbstractController
{
    /**
     * @Route("/Compte", name="acount")
     */
    public function index(): Response
    {
        $Form = $this->createForm(RegisterType::class, $this->getUser(), [
            'action' => $this->generateUrl('UpdateUser'),
            'method' => 'POST'
        ]);



        return $this->render('acount/index.html.twig', [
            'Form' => $Form->createView()
        ]);
    }

    /**
     * @Route("/Compte", name="UpdateUser")
     */
    public function UpdateUser(): Response
    {
        dd('cc');
        $Form = $this->createForm(RegisterType::class, $this->getUser(), [
            'action' => $this->generateUrl('UpdateUser'),
            'method' => 'POST'
        ]);



        return $this->render('acount/index.html.twig', [
            'Form' => $Form->createView()
        ]);
    }
}
