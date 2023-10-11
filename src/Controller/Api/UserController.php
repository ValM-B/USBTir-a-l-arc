<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Service\DataQueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="api_users")
     */
    public function index(DataQueryService $dataQueryService): JsonResponse
    {
        
        return $this->json($dataQueryService->getUsersOfOnePage(), Response::HTTP_OK, [], ["groups" => "users"]);
    }

    /**
     * @Route("/users/{id}/subscription", name="api_users_subscription", methods={"PUT"})
     */
    public function editSubscription(Request $request, UserRepository $userRepository, $id)
    {
        $data = json_decode($request->getContent(), true);
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json(["error" => "Utilisateur non trouvé"], Response::HTTP_NOT_FOUND);
        }
        if (isset($data['subscription'])) {
            $user->setSubscription($data['subscription']);
            $userRepository->add($user, true);

            return $this->json(["message" => "Subscription mise à jour avec succès"],Response::HTTP_OK,["Location" => $this->generateUrl("app_back_user_show",["id" => $user->getId()])]);
        }

        return $this->json(["error" => "Aucune donnée valide fournie pour la mise à jour de la subscription"], Response::HTTP_BAD_REQUEST);
    }


}
