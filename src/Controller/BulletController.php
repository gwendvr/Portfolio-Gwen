<?php

namespace App\Controller;

use App\Entity\DayCategory;
use App\Entity\Goal;
use App\Entity\Shop;
use App\Entity\ShopCategory;
use App\Entity\Tag;
use App\Entity\Task;
use App\Entity\Tasks;
use App\Entity\WeekNumber;
use App\Form\DayType;
use App\Form\GoalType;
use App\Form\NumberType;
use App\Form\ShopCatType;
use App\Form\ShopType;
use App\Form\TagType;
use App\Form\TasksType;
use App\Form\TaskType;
use App\Repository\DayCategoryRepository;
use App\Repository\GoalRepository;
use App\Repository\ShopRepository;
use App\Repository\TagRepository;
use App\Repository\TaskRepository;
use App\Repository\TasksRepository;
use App\Repository\WeekNumberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BulletController extends AbstractController
{
    public function __construct(EntityManagerInterface $em,
    WeekNumberRepository $repoNumber, TagRepository $repoTag, GoalRepository $repoGoal,
    ShopRepository $repoShop, TaskRepository $repoTask)
    {
        $this->em = $em;
        $this->repoNumber = $repoNumber;
        $this->repoTag = $repoTag;
        $this->repoGoal = $repoGoal;
        $this->repoShop = $repoShop;
        $this->repoTask = $repoTask;
    }

    #[Route('/bullet', name: 'app_bullet')]
    public function index(): Response
    {
        $tasks = $this->repoTask->findAll();
        $numbers = $this->repoNumber->findAll();
        $tags = $this->repoTag->findAll();
        $goals = $this->repoGoal->findAll();
        $shops = $this->repoShop->findAll();
        return $this->render('bullet/index.html.twig', [
            'numbers'=> $numbers,
            'tags'=> $tags,
            'goals'=> $goals,
            'shops'=> $shops,
            'tasks'=> $tasks,
        ]);
    }

    /****************** TASKS ******************/
    #[Route('/bullet/createTask', name: 'create_task')]
    public function createTask(Request $request) : Response
    {
        $task = new Task();
        $form = $this->createForm(TasksType::class, $task);
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
    public function deleteTask(int $id, Request $request, Task $task) : Response
    {
        if($this->isCsrfTokenValid('deleteTask'. $task->getId(), $request->get('_token')))
        {
            $this->em->remove($task);
            $this->em->flush();
            $this->addFlash('Success', 'La tâche a été supprimé !');
        }

        return $this->redirectToRoute('app_bullet');
    }

    /****************** WEEK NUMBER ******************/
    #[Route('/bullet/createNumber', name: 'create_number')]
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

    #[Route('/bullet/deleteNumber/{id}', name: 'delete_number')]
    public function deleteNumber(int $id, Request $request, WeekNumber $number) : Response
    {
        if($this->isCsrfTokenValid('deleteNumber'. $number->getId(), $request->get('_token')))
        {
            $this->em->remove($number);
            $this->em->flush();
            $this->addFlash('Success', 'Le numéro a été supprimé !');
        }

        return $this->redirectToRoute('app_bullet');
    }

    /****************** TAG ******************/
    #[Route('/bullet/createTag', name: 'create_tag')]
    public function createTag(Request $request) : Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($tag);
            $this->em->flush();

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render("bullet/tag/CreateTag.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[Route('/bullet/deleteTag/{id}', name: 'delete_tag')]
    public function deleteTag(int $id, Request $request, Tag $tag) : Response
    {
        if($this->isCsrfTokenValid('deleteTag'. $tag->getId(), $request->get('_token')))
        {
            $this->em->remove($tag);
            $this->em->flush();
            $this->addFlash('Success', 'Le tag a été supprimé !');
        }

        return $this->redirectToRoute('app_bullet');
    }

    /****************** RESET BUTTON ******************/
    #[Route('/bullet/delete', name: 'bullet_reset')]
    public function resetTable(Request $request)
    {
        $taskTable = $this->repoTask->findAll();
        $weekTable = $this->repoNumber->findAll();
        $tagTable = $this->repoTag->findAll();

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

            foreach ($tagTable as $tag) {
                $this->em->remove($tag);
                $this->em->flush();
            }
        }

        return $this->redirectToRoute('app_bullet');
    }

    /****************** GOALS ******************/
    #[Route('/bullet/createGoal', name: 'create_goal')]
    public function createGoal(Request $request) : Response
    {
        $goal = new Goal();
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($goal);
            $this->em->flush();

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render("bullet/goal/CreateGoal.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[Route('/bullet/deleteGoal/{id}', name: 'delete_goal')]
    public function deleteGoal(int $id, Request $request, Goal $goal) : Response
    {
        if($this->isCsrfTokenValid('deleteGoal'. $goal->getId(), $request->get('_token')))
        {
            $this->em->remove($goal);
            $this->em->flush();
            $this->addFlash('Success', "L'objectif a été supprimé !");
        }

        return $this->redirectToRoute('app_bullet');
    }

    /****************** SHOPPING ******************/
    #[Route('/bullet/createShop', name: 'create_shop')]
    public function createShop(Request $request) : Response
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($shop);
            $this->em->flush();

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render("bullet/shop/CreateShop.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[Route('/bullet/deleteshop/{id}', name: 'delete_shop')]
    public function deleteShop(int $id, Request $request, Shop $shop) : Response
    {
        if($this->isCsrfTokenValid('deleteShop'. $shop->getId(), $request->get('_token')))
        {
            $this->em->remove($shop);
            $this->em->flush();
            $this->addFlash('Success', "L'article a été supprimé !");
        }

        return $this->redirectToRoute('app_bullet');
    }

    #[Route('/bullet/createshopCat', name: 'create_shopCat')]
    public function createShopCat(Request $request) : Response
    {
        $shopCat = new ShopCategory();
        $form = $this->createForm(ShopCatType::class, $shopCat);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($shopCat);
            $this->em->flush();

            return $this->redirectToRoute('create_shop');
        }
        return $this->render("bullet/shop/CreateshopCat.html.twig", [
            'form' => $form->createView()
        ]);
    }

     /****************** TASKS ******************/
     #[Route('/bullet/createDay', name: 'create_day')]
     public function createDay(Request $request) : Response
     {
         $day = new DayCategory();
         $form = $this->createForm(DayType::class, $day);
         $form->handleRequest($request);
         
         if ($form->isSubmitted() && $form->isValid())
         {
             $this->em->persist($day);
             $this->em->flush();
 
             return $this->redirectToRoute('app_bullet');
         }
         return $this->render("bullet/CreateDay.html.twig", [
             'form' => $form->createView()
         ]);
     }
}   
