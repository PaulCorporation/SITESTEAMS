<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SettingsFormType;
use App\Services\profil;
class settings extends AbstractController
{
    /**
    * @Route("/settings", name="settings")
    **/
    public function index(Request $request, profil $pr, EntityManagerInterface $em) {

	session_start();
	if(isset($_SESSION['user']))
	{
        	$form = $this->createForm(SettingsFormType::class);
        	$form->handleRequest($request);
        	if ($form->isSubmitted() && $form->isValid()) {
			$usr = $form->getData();
			if($usr->getName() != "")
			{
				if(!$pr->exist($usr->getName(), $em))
					$_SESSION['user']->setName(htmlspecialchars($usr->getName()));
			}
			if($usr->getPassword() != "")
			{
			$_SESSION['user']->setPassword(password_hash($usr->getPassword(), PASSWORD_DEFAULT));
			}
			$em->merge($_SESSION['user']);
			$em->flush();
			return $this->render('settings.html.twig', [
                	"form" => $form->createView(),
                	'name' => $_SESSION['user']->getName()
                	]);
		}
		else
   	    	 return $this->render('settings.html.twig', [
		"form" => $form->createView(),
		'name' => $_SESSION['user']->getName()
        	]);
    	}
	else
	{
		 return $this->render('login.html.twig', [
                ]);
	}
	}
}
