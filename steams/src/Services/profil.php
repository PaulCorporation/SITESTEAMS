<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Jeu;
class profil
{

	public function exist($name, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(User::class);
                return $repository->exist($name);
	}
	public function count($name, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(User::class);
		$usr = $repository->getByName($name);
		$repository = $em->getRepository(Jeu::class);
                return $repository->countByUser($usr[0]);
	}
	public function getJeux($name, $page, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(User::class);
                $usr = $repository->getByName($name);
		$repository = $em->getRepository(Jeu::class);
                return $repository->getByUser($usr[0], 8, $page);
	}
}

