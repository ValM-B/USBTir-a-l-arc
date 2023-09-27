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
        if($request->query->has('search')){
            $search = $request->query->get('search');
            $users = $userRepository->findAllBySearch($search);
        } else {

            $orderBy = [];
            if ($request->query->has('sort')) {
                $orderBy[$request->query->get('sort')] = "ASC";

            }
            // get the page number in url (/users?page=[int])
            $page = (int) $request->query->get('page', 1);
            //sets the number of users to display on the page
            $limit = 10;
            //sets the number of users of previous pages not to be retrieved
            $offset = ($page - 1) * $limit;
            $users = $userRepository->findBy([], $orderBy, $limit, $offset);
        }
        
        return $this->json($users, Response::HTTP_OK, [], ["groups" => "users"]);
    }


}
