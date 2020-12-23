<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
class signingup
{

	public function logged(User $usr, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(User::class);
		if(!$repository->exist($usr->getName()))
                {
                        $usr->setPassword(password_hash($usr->getPassword(), PASSWORD_DEFAULT));
                        $usr->setDate(date_create());
                        $em->persist($usr);
                        $em->flush();
			return true;
                }
		else
		{
			return false;
		}

	}
	public function getByName($name, EntityManagerInterface $em)
        {
                $repository = $em->getRepository(User::class);
                return $repository->getByName($name);
        }

}
