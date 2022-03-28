<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Form\PasswordChangeType;
use App\Form\UserInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use stdClass;
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
    public function profil(User $user, Request $request, EntityManagerInterface $em){
        /**@var \App\Entity\User $onlineUser */
        $onlineUser = $this->getUser();
        if( $onlineUser && $user == $onlineUser){
            $userInfos = $this->createForm(UserInfoType::class, $user);
            $userInfos->handleRequest($request);
            if( $userInfos->isSubmitted() && $userInfos->isValid() ){
                $em->persist($user);
                $em->flush($user);
            }
            $this->addFlash("success", "Vos informations ont bien été modifiées !");
            return $this->render("user/details.html.twig", [
                "user" => $user,
                "userInfos" => $userInfos->createView()
            ]);
        }
        return $this->render("user/details.html.twig", [
            "user" => $user
        ]);
    }

    /**
     * @Route("/user/changePassword", name="changePassword")
     */
    public function changePassword(Request $request, EntityManagerInterface $em){
        $change = new stdClass();
        /**@var \App\Entity\User*/
        $user = $this->getUser();
        //$change["userId"] = $user->getId();
        $newPass = $this->createForm(PasswordChangeType::class, $change);
        $newPass->handleRequest($request);
        if( $newPass->isSubmitted() && $newPass->isValid() ){

        }
    }

/**
 * @Route("/addown/{id}", name="addown")
 */
public function addown(Game $game, ManagerRegistry $doc){
    /**@var \App\Entity\User $user */
    $user = $this->getUser();
    $coll = $user->addOwn($game);
    $man = $doc->getManager();
    $man->persist($coll);
    $man->flush();
    return $this->json(["reussi" => true]);
}

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Game $game, ManagerRegistry $doc){
        /**@var \App\Entity\User $user */
        $user = $this->getUser();
        $coll = $user->removeOwn($game);
        $man = $doc->getManager();
        $man->persist($coll);
        $man->flush();
        return $this->json(["reussi" => true]);
    }

}
