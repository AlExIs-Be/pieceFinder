<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Game $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Game $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function searchWithAll($name,$cat,$auth,$plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat
            AND g.title LIKE :title
            AND g.author = :auth
            AND g.playerMin < :play"
        )->setParameters([
            "cat" => $cat,
            "title" => $name,
            "auth" => $auth,
            "play" => $plays
        ]);
        $results = $query->getResult();
        dd($query, $results);
        return $results;
    }
    public function searchWithAllButPlayers($name,$cat,$auth){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat
            AND g.title LIKE :title
            AND g.author = :auth"
        )->setParameters([
            "cat" => $cat,
            "title" => $name,
            "auth" => $auth
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithAllButAuthor($name,$cat,$plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat
            AND g.title LIKE :title
            AND g.playerMin < :play"
        )->setParameters([
            "cat" => $cat,
            "title" => $name,
            "play" => $plays
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithAllButCat($name,$auth,$plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.author = :auth
            AND g.title LIKE :title
            AND g.playerMin < :play"
        )->setParameters([
            "title" => $name,
            "auth" => $auth,
            "play" => $plays
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithAllButTitle($cat,$auth,$plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat
            AND g.author = :auth
            AND g.playerMin < :play"
        )->setParameters([
            "cat" => $cat,
            "auth" => $auth,
            "play" => $plays
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithNameAndCat($name,$cat){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat
            AND g.title LIKE :title"
        )->setParameters([
            "cat" => $cat,
            "title" => "%$name%"
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithNameAndAuthor($name,$auth){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.title LIKE :title
            AND g.author = :auth"
        )->setParameters([
            "title" => "%$name%",
            "auth" => $auth
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithNameAndPlayers($name,$plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.title LIKE :title
            AND g.playerMin < :play"
        )->setParameters([
            "title" => "%$name%",
            "play" => $plays
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithCatAndAuthor($cat,$auth){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat
            AND g.author = :auth"
        )->setParameters([
            "cat" => $cat,
            "auth" => $auth
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithAuthorAndPlayers($auth,$plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.author = :auth
            AND g.playerMin < :play"
        )->setParameters([
            "auth" => $auth,
            "play" => $plays
        ]);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithCategory($cat){
        $man = $this->getEntityManager();
        /*$query = $this->createQueryBuilder('game')
            ->innerJoin('game.categories', 'cat')
            ->where('cat.id = :cat')
            ->setParameter('cat', $cat)
            ->getQuery();*/
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            INNER JOIN g.categories c
            WHERE c.id = :cat"
        )->setParameter("cat", $cat);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithAuthor($auth){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.author = :auth"
        )->setParameter("auth", $auth);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithPlayers($plays){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.playerMin < :play"
        )->setParameter("play", $plays);
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }
    public function searchWithName($name){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g
            WHERE g.title LIKE :title"
        )->setParameter("title", "%$name%");
        $results = $query->getResult();
        //dd($query, $results);
        return $results;
    }

    public function searchGame(Game $game){
        $qb = $this->createQueryBuilder("game")
            ->where("game.title = :title")
            ->andWhere("game.playerMin < :players")
            ->andWhere("game.author = :auth")
            ->setParameters([
                "title" => $game->getTitle(),
                "players" => $game->getPlayerMin(),
                "auth" => $game->getAuthor()    
            ]);
        $query = $qb->getQuery();
        $results = $query->getResult();
        dd($query, $results);
        return $results;
    }

    public function searchGame01(Array $a){
        $man = $this->getEntityManager();
        $query = $man->createQuery(
            "SELECT g
            FROM App\Entity\Game g,
            WHERE g.title LIKE %:title%
            AND g.category_id = :cat
            AND g.author_id = :auth
            AND g.player_min >= :nb
            ORDER BY g.title ASC"
        )->setParameters(
            [
                ":title" => $a["game"]??$a["game"]|"",
                ":cat" => $a["category"]??$a["category"]|"%",
                ":auth" => $a["author"]??$a["author"]|"%",
                ":nb" => $a["players"]??$a["players"]|1
            ]
        );
    }

    public function searchGame00(Array $a){
        return $this->createQueryBuilder("game")
            ->where("game.title = :name")
            ->andWhere("game.Author = :author")
            ->andWhere("game.playerMin < :nb")
            ->andWhere("game.playerMax > :nb")
            ->setParameters([
                ":name" => $a["game"]??$a["game"]|"%",
                ":author" => $a["author"]??$a["author"]|"%",
                ":nb" => $a["players"]??$a["players"]|1
            ])
            ->orderBy("game.title", "ASC")
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
