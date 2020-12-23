<?php

namespace App\Controller; 

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\jeuxService;
use App\Services\downloadService;
class jeu extends AbstractController
{
    /**
    * @Route("/game/{id}", name="game")
    **/
    public function index($id, Request $request,  EntityManagerInterface $em, jeuxService $jService, downloadService $dS) {
	session_start();
	if(!isset($_SESSION['user']))
	{
		 return $this->redirectToRoute('accueil');
	}
	$jeu = $jService->getById($id, $em);
	if($_SESSION['user']->getId() == $jeu->getUser()->getId())
		$isOwner = true;
	else
		$isOwner = false;
        return $this->render('jeu.html.twig', [
	'jeu' => $jeu,
	'name' => $_SESSION['user']->getName(),
	'owner' => $isOwner,
	'download' => $dS->count($jeu,$em)[1]
        ]);
    }
    /**
    * @Route("/delete", name="deletegame")
    **/
    public function delete(Request $request,  EntityManagerInterface $em, jeuxService $jService) {
        session_start();
        if(!isset($_SESSION['user']))
        {
                 return $this->redirectToRoute('accueil');
        }
	$id = intval($_GET['id']);
        $jeu = $jService->getById($id, $em);
        if($_SESSION['user']->getId() == $jeu->getUser()->getId())
                $isOwner = true;
        else
                $isOwner = false;
	if($isOwner)
	{
		$jService->deleteById($id, $em);
	}
	return $this->redirectToRoute('accueil');
    }

}
