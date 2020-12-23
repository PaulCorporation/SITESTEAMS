<?php

namespace App\Controller; 

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\logging;
use App\Services\jeuxService;
use App\Form\JeuSearchFormType;
class accueil extends AbstractController
{
    /**
    * @Route("/", name="accueil")
    **/
    public function index(Request $request,  EntityManagerInterface $em, logging $logserv) {
	session_start();
	if(isset($_SESSION['user']))
	{
		 return $this->redirectToRoute('accueilloged');
	}
	$form = $this->createForm(LoginType::class);
	$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
		$usr = $form->getData();
		if($logserv->logged($usr, $em))
		{
  	 		 $_SESSION['user'] = $logserv->getByName($usr->getName(), $em)[0];
			 return $this->redirectToRoute('accueilloged');
		}
	}
        return $this->render('login.html.twig', [
	'form' => $form->createView()
        ]);
    }
    /**
    * @Route("/accueil", name="accueilloged")
    **/
    public function loged(Request $request, jeuxService $jserv, EntityManagerInterface $em) {
	session_start();
	if(isset($_SESSION['user']))
        {
	 $form = $this->createForm(JeuSearchFormType::class);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid())
                {
			$jeu = $form->getData();
			$jeux = $jserv->getByDescription($jeu->getDescription(), $jeu->getName(), $jeu->getGenre(), $em);
                }
		else
		{
			$jeux = $jserv->loadList(0, $em);
		}
        return $this->render('accueil.html.twig', [
	'jeux' =>  $jeux,
	'form' => $form->createView(),
	'name' => $_SESSION['user']->getName()
        ]);
	}
	else
	{
	return $this->redirectToRoute('accueil');
	}
    }

}
