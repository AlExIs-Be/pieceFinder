<?php

namespace App\Controller;

use App\Entity\Own;
use App\Entity\Game;
use App\Entity\Like;
use App\Entity\Author;
use App\Form\GameType;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Component;
use App\Form\CommentType;
use App\Entity\ComponentType;
use Doctrine\ORM\EntityManager;
use App\Repository\OwnRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\GameContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PiecesLinkController extends AbstractController
{
    /**
     * @Route("/pieces/link", name="app_pieces_link")
     */
    public function index(): Response
    {
        return $this->render('pieces_link/index.html.twig', [
            'controller_name' => 'PiecesLinkController',
        ]);
    }

    /**
     * @Route("/game/details/{id}", name="game_detail")
     */
    public function details(Game $game, Request $request, EntityManagerInterface $em){

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if( $commentForm->isSubmitted() && $commentForm->isValid() ){
            $comment->setUser($this->getUser());
            $comment->setGame($game);
            $em->persist($comment);
            $em->flush($comment);
        }
        return $this->render("game/details.html.twig", [
            "game" => $game,
            "commentForm" => $commentForm->createView(),
        ]);
    }

   
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, EntityManagerInterface $doc, GameRepository $repo, $games=null){
        $ctman = $doc->getRepository(ComponentType::class);
        $catman = $doc->getRepository(Category::class);
        $autman = $doc->getRepository(Author::class);
        $compman = $doc->getRepository(Component::class);
        

        $types = $ctman->findBy( array(), ["type" => "ASC"]);
        $cats = $catman->findBy( array(), ["name" => "ASC"]);
        $auts = $autman->findBy( array(), ["firstname" => "ASC"]);
        $comps = $compman->findBy( array(), ["name" => "ASC"]);

        $game = new Game();
        $gameForm = $this->createForm(GameType::class, $game);
        $gameForm->handleRequest($request);
        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            $games = $repo->searchGame($game);
        }

        /*
        if( $request->isXmlHttpRequest() ){
            $jsonData = [];
            $name = $request->request->get("name");
            $values = $request->request->get("values");
            if( $name == "piece"){
                //do search for piece
            }elseif( $name == "game" ){
                
            }
        }
        */
        return $this->render("search/index.html.twig", [
            "types" => $types,
            "categories" => $cats,
            "authors" => $auts,
            "gameForm" => $gameForm->createView(),
            "games" => $games,
            "values" => $comps
        ]);
    }

    /**
     * @Route("/searchGame", name="searchGame")
     */
    public function searchGame(Request $request, GameRepository $repo){
        $name = $request->request->get("gameName");
        $cat = $request->request->get("category");
        $auth = $request->request->get("author");
        $plays = $request->request->get("players");

        $search = [0, 0, 0, 0];
        if($name != ""){
            $search[0] = 1;
        }
        if( $cat > 0 ){
            $search[1] = 1;
        }
        if( $auth > 0 ){
            $search[2] = 1;
        }
        if( $plays > 0 ){
            $search[3] = 1;
        }
        //dd($name, $cat, $auth, $plays);
        //$games = $repo->findAll();
        //dd($search);
        if( $search[0] == 1 ){
            if( $search[1] == 1 ){
                if( $search[2] == 1 ){
                    if( $search[3] == 1 ){//1111
                        $results = $repo->searchWithAll($name,$cat,$auth,$plays);
                    }else{//1110
                        $results = $repo->searchWithAllButPlayers($name,$cat,$auth);
                    }
                }else{
                    if( $search[3] == 1 ){//1101
                        $results = $repo->searchWithAllButAuthor($name,$cat,$plays);
                    }else{//1100
                        $results = $repo->searchWithNameAndCat($name,$cat);
                    }
                }
            }else{
                if( $search[2] == 1 ){
                    if( $search[3] == 1 ){//1011
                        $results = $repo->searchWithAllButCat($name,$auth,$plays);
                    }else{//1010
                        $results = $repo->searchWithNameAndAuthor($name,$auth);
                    }
                }else{
                    if( $search[3] == 1 ){//1001
                        $results = $repo->searchWithNameAndPlayers($name,$plays);
                    }else{//1000
                        $results = $repo->searchWithName($name);
                    }
                }
            }
        }elseif( $search[0] == 0){
            if( $search[1] == 1 ){
                if( $search[2] == 1 ){
                    if( $search[3] == 1 ){//0111
                        $results = $repo->searchWithAllButTitle($cat,$auth,$plays);
                    }else{//0110
                        $results = $repo->searchWithCatAndAuthor($cat,$auth);
                    }
                }else{
                    if( $search[3] == 1 ){//0101
                        $results = $repo->searchWithCatAndPlayers($cat,$plays);
                    }else{//0100
                        $results = $repo->searchWithCategory($cat);
                    }
                }
            }else{
                if( $search[2] == 1 ){
                    if( $search[3] == 1 ){//0011
                        $results = $repo->searchWithAuthorAndPlayers($auth,$plays);
                    }else{//0010
                        $results = $repo->searchWithAuthor($auth);
                    }
                }else{//0001
                    $results = $repo->searchWithPlayers($plays);
                }
            }

        }
        return $this->render("search/gameResults.html.twig", [ "games" => $results ]);
    }

    /**
     * @Route("/searchPiece", name="searchPiece")
     */
    public function searchPiece(Request $request, GameContentRepository $repo){
        $type = $request->request->get("type");
        $value = $request->request->get("value");
        $mat = $request->request->get("material");
        $col = $request->request->get("color");

        $params = ["type" => $type, "value" => $value, "material" => $mat, "color" => $col];
        //dd($type, $value, $mat, $col);
        $results = $repo->findPieces($type, $value, $mat, $col);
        //dd($results);

        return $this->render("search/pieceResults.html.twig", [ "pieces" => $results, "params" => $params ]);

    }
}
