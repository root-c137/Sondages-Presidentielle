<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Vote;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    /**
     * @Route("/vote/{slug}", name="vote")
     */
    public function index(Candidat $Candidat, Request $Request): Response
    {
        $response = new Response();

        $Doc = $this->getDoctrine()->getManager();
        $Vote = new Vote();

        if($this->getUser()->getVote())
        {
            if($this->getUser()->getVote()->getCandidat() == $Candidat)
            {
                //Si il vote pour le même, alors on annule le vote..

                $RepVote = $Doc->getRepository(Vote::class);
                $Vote = $RepVote->find($this->getUser()->getVote());

                $Doc->remove($Vote);
                $Doc->flush();
            }

        }
        else
        {
            $Vote->setCandidat($Candidat);
            $Vote->setUser($this->getUser());
            $Vote->setCreatedAt(new DateTime());

            $Doc->persist($Vote);
            $Doc->flush();
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(201);

        return $response;
    }
}
