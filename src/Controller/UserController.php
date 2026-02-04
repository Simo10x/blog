<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/members', name: 'members_list')]
    public function list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/account/{emailUser}', name: 'user_show')]
    public function show(string $emailUser, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['emailUser' => $emailUser]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
