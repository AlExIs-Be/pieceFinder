<?php

namespace App\Repository;

use App\Entity\GameContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameContent[]    findAll()
 * @method GameContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameContent::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(GameContent $entity, bool $flush = true): void
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
    public function remove(GameContent $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function findPieces($type, $value, $mat, $col){
        $query = $this
            ->createQueryBuilder("piece")
            ->select( "piece", "ct")
            ->join("piece.componentType", "ct");
            //->join("gameContent.component", "c");
        
        if( $type ){
            $query = $query
                ->andWhere("piece.componentType = :id")
                ->setParameter(":id", $type);
        }
        if( $value ){
            $query = $query
                ->andWhere("piece.component = :id")
                ->setParameter(":id", $value);
        }
        if( $mat ){
            $query = $query
                ->andWhere("piece.material LIKE :mat")
                ->setParameter(":mat", $mat);
        }
        if( $col ){
            $query = $query
                ->andWhere("piece.color LIKE :col")
                ->setParameter(":col", $col);
        }
        return $query->getQuery()->getResult();

    }

    // /**
    //  * @return GameContent[] Returns an array of GameContent objects
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
    public function findOneBySomeField($value): ?GameContent
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
