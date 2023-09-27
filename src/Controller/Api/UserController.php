<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="api_v1_users")
     */
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {
        $page = (int) $request->query->get('page', 1);
        $limit = 10;
        $offset = ($page -1) * $limit;
        $users = $userRepository->findBy([], null, $limit, $offset);
        return $this->json($users, Response::HTTP_OK, [], ["groups" => "users"]);
    }
}
