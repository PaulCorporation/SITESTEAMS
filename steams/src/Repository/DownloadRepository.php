<?php

namespace App\Repository;

use App\Entity\Download;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Jeu;
/**
 * @method Download|null find($id, $lockMode = null, $lockVersion = null)
 * @method Download|null findOneBy(array $criteria, array $orderBy = null)
 * @method Download[]    findAll()
 * @method Download[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DownloadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Download::class);
    }
    public function count($jeu)
    {
	 return $this->createQueryBuilder('j')->select('count(j.id)')->innerJoin('j.game', 'g')->where('g.id = :id')->setParameter(':id', $jeu->getId())->getQuery()->getResult()[0];
    }
    public function exist($user, $jeu)
    {
	return ($this->createQueryBuilder('d')->select('count(d.id)')->innerJoin('d.user', 'u')->where('u.id = :id')->setParameter(':id', $user->getId())->innerJoin('d.game', 'j')->andWhere('j.id = :id2')->setParameter(':id2', $jeu->getId())->getQuery()->getResult()[0][1] > 0);
    }
    // /**
    //  * @return Download[] Returns an array of Download objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Download
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
