<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $Doc = $this->getDoctrine()->getManager();
        $RepCandidat = $Doc->getRepository(Candidat::class);
        $RepVote = $Doc->getRepository(Vote::class);

        $Candidats = $RepCandidat->findAll();
        $Votes = $RepVote->findAll();

        $TotalVote = count($Votes);
        if($TotalVote == 0)
            $TotalVote = 1;

        $VoteActuel = '';
        if($this->getUser())
        {
            if($this->getUser()->getVote() != null)
            {
                $VoteActuel = $this->getUser()->getVote()->getCandidat();

                $Session = new Session();
                $Session->set('VoteActuel', $VoteActuel);
            }
        }

        return $this->render('main/index.html.twig',[
            'Candidats' => $Candidats,
            'TotalVote' => $TotalVote,
        ]);
    }

}
