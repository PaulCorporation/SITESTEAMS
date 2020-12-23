<?php
namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Jeu;
class jeuxService
{

        public function loadList(int $page, EntityManagerInterface $em)
        {
		$queryBuilder = $em->createQueryBuilder();
		$queryBuilder->select('j')
                ->from(Jeu::class, 'j')
                ->setFirstResult($page)
                ->setMaxResults(8)
		->orderBy('j.date', 'DESC');
		$query = $queryBuilder->getQuery();
		return $query->getResult();
        }
	public function getByDescription($desc, $nom, $genre, EntityManagerInterface $em)
	{
                $repository = $em->getRepository(Jeu::class);
                return $repository->findByDescription($desc, $genre, $nom, 8);
	}
	public function getById(int $id, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(Jeu::class);
		return $repository->findById($id);
	}
	public function deleteById(int $id, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(Jeu::class);
		$repository->deleteById($id);
	}

}
