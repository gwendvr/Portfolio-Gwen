<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\TableauCompetence;
use App\Form\CompetenceType;
use App\Form\ProjectType;
use App\Repository\CompetencesRepository;
use App\Repository\FormationRepository;
use App\Repository\ProjetRepository;
use App\Repository\TableauCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, TableauCompetenceRepository $repoCompetence,
    CompetencesRepository $repoSkill, FormationRepository $repoFormation, ProjetRepository $repoProject)
    {
        $this->em = $em;
        $this->repoCompetence = $repoCompetence;
        $this->repoSkill = $repoSkill;
        $this->repoFormation = $repoFormation;
        $this->repoProject = $repoProject;
    }

    /**
     * Page d'accueil Admin
     * 
     * @Route("/admin", name="app_admin")
     * @return Response
     */
    public function index(): Response
    {
        $competences = $this->repoCompetence->findAll();
        $skills = $this->repoSkill->findAll();
        $formations = $this->repoFormation->findAll();
        $projects = $this->repoProject->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'competences'=> $competences,
            'skills'=> $skills,
            'formations' => $formations,
            'projects' => $projects,
        ]);
    }

    /**
     * Page création admin
     * 
     * @Route("/admin/createCompetence", name="create_competence")
     * @return Response
     */
    public function createCompetence(Request $request) : Response
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

     /**
     * Page modification admin
     * 
     * @Route("/admin/editCompetence/{id}", name="edit_competence")
     * @return Response
     */
    public function editCompetence($id, Request $request) : Response
    {
        $competences = $this->repoCompetence->find($id);
        $form = $this->createForm(CompetenceType::class, $competences);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('Success', 'La compétence a bien été modifié !');

            return $this->redirectToRoute('app_admin');
        }
        return $this->render("admin/competence/EditCompetence.html.twig", [
            'form' => $form->createView(),
            'competences' => $competences
        ]);
    }

     /**
     * Page modification admin
     * 
     * @Route("/admin/deleteCompetence/{id}", name="delete_competence")
     */
    public function deleteCompetence(int $id, Request $request, TableauCompetence $competence)
    {
        if($this->isCsrfTokenValid('delete'. $competence->getId(), $request->get('_token')))
        {
            $this->em->remove($competence);
            $this->em->flush();
            $this->addFlash('Success', 'La compétence a été supprimé !');
        }

        return $this->redirectToRoute('app_admin');
    }

    /**
     * Page création projet
     * 
     * @Route("/admin/createProject", name="create_projet")
     * @return Response
     */
    public function createProject(Request $request) : Response
    {
        $project = new Projet();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('app_admin');
        }
        return $this->render("admin/projects/CreateProject.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
