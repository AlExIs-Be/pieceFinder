<?php

namespace App\Controller;

use App\Entity\Own;
use App\Entity\Game;
use App\Entity\Like;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCollectionController extends AbstractController
{
    /**
     * @Route("/user/collection", name="app_user_collection")
     */
    public function index(): Response
    {
        return $this->render('user_collection/index.html.twig', [
            'controller_name' => 'UserCollectionController',
        ]);
    }

    /**
     * @Route("/user/details/{id}", name="user_details")
     */
    public function profil(User $user){
        return $this->render("user/details.html.twig", [
            "user" => $user
        ]);
    }

    /**
     * @Route("/addown/{id}", name="addown")
     */
    public function addown(Game $game, Request $request, UserRepository $urepo, ManagerRegistry $doc){
    $userId = $request->request->get("userId");
    $user = $urepo->find($userId);
    $coll = $user->addOwn($game);
    $man = $doc->getManager();
    $man->persist($coll);
    $man->flush();
    return $this->json(["reussi" => true]);
    }

}
