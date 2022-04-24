<?php

namespace App\Controller;

use App\Entity\Days;
use App\Form\DaysType;
use App\Repository\DaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BulletController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, DaysRepository $repoDays)
    {
        $this->em = $em;
        $this->repoDays = $repoDays;
    }

    #[Route('/bullet', name: 'app_bullet')]
    public function index(): Response
    {
        return $this->render('bullet/index.html.twig', [
        ]);
    }

    #[Route('/bullet/create', name: 'bullet_create')]
    public function BulletCreate(Request $request): Response
    {
        $days = new Days();
        $form = $this->createForm(DaysType::class, $days);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($days);
            $this->em->flush();

            return $this->redirectToRoute('app_bullet');
        }
        return $this->render('bullet/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
