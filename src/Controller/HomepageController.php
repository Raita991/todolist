<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use App\Form\TaskListType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage")
     */
    public function homepage(Request $request, EntityManagerInterface $em, TodoRepository $todoRepository): Response
    {
        $taskList = new Todo();
        $form = $this->createForm(TaskListType::class, $taskList)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($taskList);
            $em->flush();
        }

        $results = $todoRepository->findTask(3);
        
        return  $this->render('home.html.twig', ['form' => $form->createView(),
        'data' => $taskList, 'results' => $results
        
        ]);
    }

    /**
     * @Route("/{result}")
     *
     * @return Response
     */
    public function deleteTask(TodoRepository $todoRepository, Request $request) : Response
    {
        $result = $request->get('result');
        $todoRepository->DeleteTask($result);

        return new Response($this->render('home.html.twig'));
    }
}
