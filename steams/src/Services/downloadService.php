<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Jeu;
use App\Entity\Download;
class downloadService
{

        public function exist($user, $jeu, EntityManagerInterface $em)
        {
                $repository = $em->getRepository(Download::class);
                return $repository->exist($jeu, $user);
        }
	public function count($jeu,  EntityManagerInterface $em)
	{
		$repository = $em->getRepository(Download::class);
                return $repository->count($jeu);
	}
}
