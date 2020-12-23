<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\jeuxService;
use App\Services\downloadService;
class download extends AbstractController
{
    /**
    * @Route("/download/{id}", name="download")
    **/
    public function index(int $id, EntityManagerInterface $em, jeuxService $jserv, downloadService $dS) {
        session_start();
        if(isset($_SESSION['user']))
        {
		$jeu = $jserv->getById($id, $em);
		if(!$dS->exist($jeu, $_SESSION['user'], $em))
		{
			$download = new  \App\Entity\download();
			$download->setUser($_SESSION['user']);
			$download->setGame($jeu);
			$em->merge($download);
                	$em->flush();
		}
		return $this->redirect($jeu->getLink());
        }
        else
        {
                return  $this->render('login.html.twig', []);
        }
    }
}
