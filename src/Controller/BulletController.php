<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BulletController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/bullet', name: 'app_bullet')]
    public function index(): Response
    {
        return $this->render('bullet/index.html.twig', [
        ]);
    }

    #[Route('/bullet/createTask', name: 'bullet_create_task')]
    public function createTask(Request $request) : Response
    {
        $task = new Tasks();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render("bullet/CreateTask.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
