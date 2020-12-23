<?php

namespace App\Repository;

use App\Entity\Jeu;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeu[]    findAll()
 * @method Jeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeu::class);
    }
    public function getByUser(User $user, int $number, int $offset)
    {
	return $this->createQueryBuilder('j')->innerJoin('j.user', 'u')->where('u.id = :id')->setParameter(':id', $user->getId())->orderBy('j.date', 'ASC')->setFirstResult($offset*$number)->setMaxResults($number)->getQuery()->getResult();
    }
    public function countByUser(User $user)
    {
	return $this->createQueryBuilder('j')->select('count(j.id)')->innerJoin('j.user', 'u')->where('u.id = :id')->setParameter(':id', $user->getId())->getQuery()->getResult()[0];
    }
    public function findByDescription($desc, $genre, $name, int $number)
    {
	return $this->createQueryBuilder('j')->where("j.description LIKE :d")->setParameter(':d', '%'.$desc.'%')->andWhere("j.name LIKE :n")->setParameter(':n', '%'.$name.'%')->andWhere("j.genre LIKE :genre")->setParameter(':genre', '%'.$genre.'%')->setMaxResults($number)->getQuery()->getResult();
    }
    public function findById(int $id)
    {
        return $this->createQueryBuilder('j')->where("j.id = :id")->setParameter(':id', $id)->getQuery()->getResult()[0];
    }
    public function deleteById(int $id)
    {

	$this->createQueryBuilder('j')->delete()->where("j.id = :id")->setParameter(':id', $id)->getQuery()->execute();
    }
    // /**
    //  * @return Jeu[] Returns an array of Jeu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jeu
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
