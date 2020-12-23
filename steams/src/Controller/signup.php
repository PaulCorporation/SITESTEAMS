<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\signingup;
class signup extends AbstractController
{
    /**
    * @Route("/signup", name="signup")
    **/
    public function index(Request $request, EntityManagerInterface $em, signingup $suServ) {
	session_start();
        $form = $this->createForm(loginType::class);
	$form->handleRequest($request);
	if ($form->isSubmitted() && $form->isValid()) {
	        $usr = $form->getData();
			if($suServ->logged($usr, $em))
			{
				$_SESSION["user"] = $suServ->getByName($usr->getName(), $em)[0];
				return $this->redirectToRoute('accueilloged');
			}
			else
			{
				return $this->render('signup.html.twig', [
        			'form' => $form->createView()
        			]);
			}
    	}
        return $this->render('signup.html.twig', [
        'form' => $form->createView()
        ]);
    }

}
