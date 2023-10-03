<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Service\DataQueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin35786/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="api_users")
     */
    public function index(Request $request, UserRepository $userRepository, DataQueryService $dataQueryService): JsonResponse
    {
        if($dataQueryService->search()){
           $users = $dataQueryService->search();
        } else {
            $users = $dataQueryService->getUsersOfOnePage();
        }
        
        return $this->json($users, Response::HTTP_OK, [], ["groups" => "users"]);
    }


}
