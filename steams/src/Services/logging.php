<?php

namespace App\Services;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
class logging
{

        public function logged(User $usr, EntityManagerInterface $em)
        {
                $repository = $em->getRepository(User::class);
                $usrbase = $repository->getByName($usr->getName());
		if(isset($usrbase[0]))
		{
			if(password_verify($usr->getPassword(), $usrbase[0]->getPassword()))
			{
                        	return true;
                	}
                	else
                	{
                       		return false;
                	}
		}

        }
	public function getByName($name, EntityManagerInterface $em)
	{
		$repository = $em->getRepository(User::class);
		return $repository->getByName($name);
	}

}
