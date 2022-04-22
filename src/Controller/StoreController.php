<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, ProjectRepository $repoProject)
    {
        $this->em = $em;
        $this->repoProject = $repoProject;
    }

    #[Route('/store', name: 'app_store')]
    public function index(): Response
    {
        $projects = $this->repoProject->findAll();
        return $this->render('store/index.html.twig', [
            'projects'=> $projects
        ]);
    }
}
