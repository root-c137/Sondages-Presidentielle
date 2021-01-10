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
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class VoteController extends AbstractController
{
    private $NegatifMODE = 0;
    private $PositifMODE = 1;

    /**
     * @Route("/vote/{slug}", name="vote")
     */
    public function index(Candidat $Candidat, Request $Request): Response
    {
        $response = new Response();

        $Doc = $this->getDoctrine()->getManager();
        $RepVote = $Doc->getRepository(Vote::class);

        $Vote = new Vote();
        $LastCandidat = null;
        //Si il a déjà voté...
        if($this->getUser()->getVote())
        {
            $Vote = $RepVote->find($this->getUser()->getVote());

            //Si il vote pour le même, alors on annule le vote..
            if($this->getUser()->getVote()->getCandidat() == $Candidat)
            {
                //On onlève 1 au nbvote candidat..
                $this->UpdateNbVote($Candidat, $this->NegatifMODE, $Doc);

                $LastCandidat = $Candidat->getLastname();

                $Doc->remove($Vote);
                $Doc->flush();

                $this->UpdateSessionVote(null);
            }
            //Si c'est un autre candidat et qu'il a déjà voté.. on change simplement son vote..
            else if($this->getUser()->getVote()->getCandidat() != $Candidat)
            {
                //On enlève 1 au vote précédent..
                $this->UpdateNbVote($this->getUser()->getVote()->getCandidat(), $this->NegatifMODE, $Doc);
                //On ajoute 1 au nouveau..
                $this->UpdateNbVote($Candidat, $this->PositifMODE, $Doc);

                $LastCandidat = $this->getUser()->getVote()->getCandidat()->getLastname();

                $Vote->setCandidat($Candidat);

                $Doc->persist($Vote);
                $Doc->flush();

                $this->UpdateSessionVote($Candidat);
            }

        }
        //Si il n'a pas encore voté alors on enregistre simplement un nouveau vote..
        else
        {
            //On ajoute 1 au nbvote du candidat..
            $this->UpdateNbVote($Candidat, $this->PositifMODE, $Doc);

            $Vote->setCandidat($Candidat);
            $Vote->setUser($this->getUser());
            $Vote->setCreatedAt(new DateTime());

            $Doc->persist($Vote);
            $Doc->flush();
        }

        $TotalVote = count($RepVote->findAll() );
        $RepCandidat = $Doc->getRepository(Candidat::class);
        $AllCandidats = $RepCandidat->findAll();

        //On envoie un tableau contenant les "nbvotes" de tous les candidats pour pouvoir ensuite modifier toutes
        //cartes du coté js facilement..
        $NbVotesAllCandidats = [];
           foreach($AllCandidats as $Value)
            {
                $NbVotesAllCandidats[] = $Value->getNbVote();
            }

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode(array(
            'TotalVote' => $TotalVote,
            'CandidatActuel' => $Candidat->getSlug(),
            'NbVotesArray' => $NbVotesAllCandidats
        )));

        $response->setStatusCode(201);
        return $response;
    }

    public function UpdateNbVote($Candidat, $Mode,  $Doc)
    {
        $RepCandidat = $Doc->getRepository(Candidat::class);

        $C = $RepCandidat->find($Candidat->getId() );

        if($Mode == $this->NegatifMODE)
            $C->setNbVote($Candidat->getNbVote() - 1);
        if($Mode == $this->PositifMODE)
            $C->setNbVote($Candidat->getNbVote() + 1);

        $Doc->persist($C);
    }

    private function UpdateSessionVote($v)
    {
        $this->get('session')->set('VoteActuel', $v);
    }
}
