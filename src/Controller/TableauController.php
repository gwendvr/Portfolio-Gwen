<?php

namespace App\Controller;

use App\Repository\TableauCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableauController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, TableauCompetenceRepository $repoCompetence)
    {
        $this->em = $em;
        $this->repoCompetence = $repoCompetence;
    }

    #[Route('/tableau', name: 'app_tableau')]
    public function index(): Response
    {
        $competences = $this->repoCompetence->findAll();
        return $this->render('tableau/index.html.twig', [
            'competences'=> $competences,
        ]);
    }
}
