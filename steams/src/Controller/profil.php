<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
class profil extends AbstractController
{
    /**
    * @Route("/profil/{name}/{page}", name="profil")
    **/
    public function index($name, $page, \App\Services\profil $pr, EntityManagerInterface $em) {
	session_start();
	if(isset($_SESSION['user']))
	{
		if($pr->exist($name, $em))
        	{
			return $this->render('profil.html.twig', [
			'profilename' => htmlspecialchars($name),
			'count' => $pr->count($name, $em)[1],
			'jeux' => $pr->getJeux($name, $page, $em),
			'name' => $_SESSION['user']->getName()
        		]);
		}
	}
	else
	{
		return  $this->render('login.html.twig', []);
	}
    }
}
