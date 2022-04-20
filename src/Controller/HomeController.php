<?php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, CompetencesRepository $repoSkill)
    {
        $this->em = $em;     
        $this->repoSkill = $repoSkill;

    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $skills = $this->repoSkill->findAll();
        return $this->render('home/index.html.twig', [
            'skills'=> $skills,
        ]);
    }
}
