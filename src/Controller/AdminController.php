<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CompetenceProject;
use App\Entity\Project;
use App\Entity\TableauCompetence;
use App\Form\CatType;
use App\Form\CompetenceType;
use App\Form\ProjectCompetenceType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TableauCompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, TableauCompetenceRepository $repoCompetence,
    ProjectRepository $repoProject)
    {
        $this->em = $em;
        $this->repoCompetence = $repoCompetence;
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
        $projects = $this->repoProject->findAll();
        return $this->render('admin/index.html.twig', [
            'competences'=> $competences,
            'projects' => $projects,
        ]);
    }

    /**
     * Page création tableau de compétence
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
     * Page modification tableau de compétence
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
     * Page suppression tableau de compétence
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
     * Page création catégorie
     * 
     * @Route("/admin/createCat", name="create_cat")
     */
    public function createCat(Request $request) : Response
    {
        $Cat = new Category();
        $form = $this->createForm(CatType::class, $Cat);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($Cat);
            $this->em->flush();

            return $this->redirectToRoute('create_competence');
        }
        return $this->render("admin/category/CreateCat.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * Page création projet
     * 
     * @Route("/admin/createProject", name="create_project")
     */
    public function createProject(Request $request) : Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('app_admin');
        }
        return $this->render("admin/project/CreateProject.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * Page création d'une compétence
     * 
     * @Route("/admin/createProjectCompetence", name="create_project_competence")
     */
    public function createProjetCompetence(Request $request) : Response
    {
        //Ajout d'une nouvelle compétence
        $competenceProject = new CompetenceProject;

        //Création d'un formulaire pour une nouvelle compétence
        $form = $this->createForm(ProjectCompetenceType::class, $competenceProject);
        $form->handleRequest($request);
        
        //On vérifie si le formulaire est envoyé et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            //On envoie en base de données la nouvelle compétence
            $this->em->persist($competenceProject);
            $this->em->flush();

            return $this->redirectToRoute('app_admin');
        }
        return $this->render("admin/project/CreateCompetence.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
