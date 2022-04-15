<?php

namespace App\Controller;

use App\Entity\TableauCompetence;
use App\Form\CompetenceType;
use App\Repository\TableauCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, TableauCompetenceRepository $repoCompetence)
    {
        $this->em = $em;
        $this->repoCompetence = $repoCompetence;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $competences = $this->repoCompetence->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'competences'=> $competences
        ]);
    }

    #[Route('/admin/createCompetence', name: 'create_competence')]
    public function createCompetence(Request $request)
    {
        $competence = new TableauCompetence();
        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($competence);
            $this->em->flush();

            return $this->redirectToRoute('app_admin');
        }
        return $this->render("admin/competence/CreateCompetence.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
