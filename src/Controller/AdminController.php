<?php

namespace App\Controller;

use App\Entity\TableauCompetence;
use App\Form\CompetenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
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
