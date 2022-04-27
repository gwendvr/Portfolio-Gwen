<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Entity\WeekNumber;
use App\Form\NumberType;
use App\Form\TaskType;
use App\Repository\TasksRepository;
use App\Repository\WeekNumberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BulletController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, TasksRepository $repoTask, WeekNumberRepository $repoNumber)
    {
        $this->em = $em;
        $this->repoTask = $repoTask;
        $this->repoNumber = $repoNumber;
    }

    #[Route('/bullet', name: 'app_bullet')]
    public function index(): Response
    {
        $tasks = $this->repoTask->findAll();
        $numbers = $this->repoNumber->findAll();
        return $this->render('bullet/index.html.twig', [
            'tasks'=> $tasks,
            'numbers'=> $numbers
        ]);
    }

    /****************** TASKS ******************/
    #[Route('/bullet/createTask', name: 'create_task')]
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
        return $this->render("bullet/tasks/CreateTask.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[Route('/bullet/editTask/{id}', name: 'edit_task')]
    public function editTask($id, Request $request) : Response
    {
        $task = $this->repoTask->find($id);
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('Success', 'La tâche a bien été modifiée !');

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render("bullet/tasks/EditTask.html.twig", [
            'form' => $form->createView(),
            'task' => $task
        ]);
    }

    #[Route('/bullet/deleteTask/{id}', name: 'delete_task')]
    public function deleteTask(int $id, Request $request, Tasks $task) : Response
    {
        if($this->isCsrfTokenValid('delete'. $task->getId(), $request->get('_token')))
        {
            $this->em->remove($task);
            $this->em->flush();
            $this->addFlash('Success', 'La tâche a été supprimé !');
        }

        return $this->redirectToRoute('app_bullet');
    }

    /****************** WEEK NUMBER ******************/
    #[Route('/bullet/createNumber', name: 'create_Number')]
    public function createNumber(Request $request) : Response
    {
        $number = new WeekNumber();
        $form = $this->createForm(NumberType::class, $number);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($number);
            $this->em->flush();

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render("bullet/number/CreateNumber.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /****************** RESET BUTTON ******************/

    #[Route('/bullet/delete', name: 'bullet_reset')]
    public function resetTable(Request $request)
    {
        $taskTable = $this->repoTask->findAll();
        $weekTable = $this->repoNumber->findAll();

        if($this->isCsrfTokenValid('deleteBullet', $request->get('_token')))
        {
            foreach ($taskTable as $task) {
                $this->em->remove($task);
                $this->em->flush();
            }

            foreach ($weekTable as $week) {
                $this->em->remove($week);
                $this->em->flush();
            }
        }
        
        return $this->redirectToRoute('app_bullet');
    }
}
