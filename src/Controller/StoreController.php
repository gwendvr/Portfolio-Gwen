<?php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use App\Repository\FormationRepository;
use App\Repository\TableauCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, TableauCompetenceRepository $repoCompetence,
    CompetencesRepository $repoSkill, FormationRepository $repoFormation)
    {
        $this->em = $em;
        $this->repoCompetence = $repoCompetence;
        $this->repoSkill = $repoSkill;
        $this->repoFormation = $repoFormation;
    }

    #[Route('/store', name: 'app_store')]
    public function index(): Response
    {
        $competences = $this->repoCompetence->findAll();
        $skills = $this->repoSkill->findAll();
        $formations = $this->repoFormation->findAll();
        return $this->render('store/index.html.twig', [
            'competences'=> $competences,
            'skills'=> $skills,
            'formations' => $formations
        ]);
    }
}
