<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\User;
use App\Entity\Vote;
use App\Form\CandidatFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat/{slug}", name="candidat")
     */
    public function index(Candidat $Candidat): Response
    {
        $Doc = $this->getDoctrine()->getManager();
        $RepVote = $Doc->getRepository(Vote::class);
        $RepUser = $Doc->getRepository(User::class);

        $Votes = $RepVote->findAll();
        $VoteByThisCandidat = $RepVote->findBy( ["Candidat" => $Candidat ] );

        $Ages = [];

        foreach($VoteByThisCandidat as $Vote)
        {
            $Ages[] = $Vote->getUser()->getDatenaissance();
        }

        //On calcul la moyenne d'age...
        $TotalVotesByThisCandidat = 1;
        if(count($VoteByThisCandidat)> 0)
            $TotalVotesByThisCandidat = count($VoteByThisCandidat);

        $SommeAges = array_sum($Ages);
        $MoyenneAge = $SommeAges / $TotalVotesByThisCandidat;

        $TotalVote = count($Votes);
        if(count($Votes) == 0)
            $TotalVote = 1;

        return $this->render('candidat/index.html.twig', [
            'Candidat' => $Candidat,
            'TotalVote' => $TotalVote,
            'MoyenneAge' => $MoyenneAge
        ]);
    }

    /**
     * @Route("backo/candidat/Add", name="AddCandidat")
     */
    public function AddCandidat(Request $Request): Response
    {
        $Candidat = new Candidat();
        $Form = $this->createForm(CandidatFormType::class, $Candidat);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() )
        {
            $Doc = $this->getDoctrine()->getManager();
            $Candidat = $Form->getData();

            $Doc->persist($Candidat);
            $Doc->flush();

            $this->addFlash('Msg', 'Le Candidat '.$Candidat->getFirstname().' à bien été ajouté.');
            return $this->redirectToRoute('back_office');

        }

    }

    /**
     * @Route("backo/candidat/Update/Update/{slug}", name="UpdateCandidat")
     */
    public function UpdateCandidat(Candidat $Candidat, Request $Request): Response
    {
        $Doc = $this->getDoctrine()->getManager();

        $LastCandidat = $Doc->getRepository(Candidat::class)->find($Candidat->getId() );

        $Form = $this->createForm(CandidatFormType::class, $Candidat);
        $Form->handleRequest($Request);

        if($Form->isSubmitted() && $Form->isValid() )
        {
            $LastCandidat = $Form->getData();
            $Doc->flush();

            $this->addFlash('Msg', 'Informations bien modifiés.');

            return $this->redirectToRoute('UpdateCandidatForm', ['slug' => $LastCandidat->getSlug()]);
        }
    }


    /**
     * @Route("backo/candidat/Delete/Delete/{slug}", name="DeleteCandidat")
     */
    public function DeleteCandidat(Candidat $Candidat): Response
    {
       $Doc = $this->getDoctrine()->getManager();

       $Doc->remove($Candidat );
       $Doc->flush();

       return $this->redirectToRoute('back_office');
    }

}


