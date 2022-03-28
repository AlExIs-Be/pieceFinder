<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/everyGames", name="EveryGames")
     */
    public function home(GameRepository $repo): Response
    {
        $games = $repo->findBy( [], ["yearOut" => "DESC"]);
        return $this->render("game/home.html.twig", [
            "games" => $games
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render("home/contact.html.twig");
    }

    /**
     * @Route("/CGU", name="cgu")
     */
    public function cgu(): Response
    {
        return $this->render("home/cgu.html.twig");
    }

}
