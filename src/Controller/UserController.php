<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user/new', name: 'app_user_new')]
    public function new(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }    

    #[Route('/user/{id}/edit', name: 'app_user_edit')]
    public function edit(\Symfony\Component\HttpFoundation\Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_user_index');
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
    
    #[Route('/user/{id}/delete', name: 'app_user_delete')]
    public function delete(User $user): Response
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_user_index');
    }

    #[Route('/user/{id}', name: 'app_user_show')]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/list', name: 'app_user_list')]
    public function list(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
    
    #[Route('/user/search', name: 'app_user_search')]
    public function search(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $searchTerm = $request->query->get('q');
        $users = $this->entityManager->getRepository(User::class)->findByName($searchTerm);
        return $this->render('user/search.html.twig', [
            'users' => $users,
            'searchTerm' => $searchTerm,
        ]);
    }
}
