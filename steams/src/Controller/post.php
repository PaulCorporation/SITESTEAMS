<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\JeuFormType;
use App\Services\jeuxService;
class post extends AbstractController
{
    /**
    * @Route("/post", name="post")
    **/
    public function index(Request $request, EntityManagerInterface $em) {
        session_start();
        $form = $this->createForm(JeuFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && isset($_SESSION['user'])) {
                $jeu = $form->getData(); 
		$jeu->setUser($_SESSION['user']);
		$jeu->setImagelink(htmlspecialchars($jeu->getImageLink()));
		$jeu->setLink(htmlspecialchars($jeu->getLink()));
		$jeu->setDescription(htmlspecialchars($jeu->getDescription()));
		$jeu->setDate(date_create());
		$jeu->setName(htmlspecialchars($jeu->getName()));
		$jeu->setGenre(htmlspecialchars($jeu->getGenre()));
		$em->merge($jeu);
    		$em->flush();
		 return $this->redirectToRoute('accueilloged');
        }
	if(isset($_SESSION['user']))
		return $this->render('post.html.twig', ['form' => $form->createView(), 'name' => $_SESSION['user']->getName()]);
	 return $this->redirectToRoute('accueil');
    }
     /**
    * @Route("/post/edit/{id}", name="edit")
    **/
    public function edit(int $id, Request $request, EntityManagerInterface $em, jeuxService $js) {
        session_start();
        $form = $this->createForm(JeuFormType::class);
        $form->handleRequest($request);
	$jeuBDD = $js->getById($id, $em);
        if ($form->isSubmitted() && $form->isValid() && isset($_SESSION['user']) && $_SESSION['user']->getId() == $jeuBDD->getUser()->getId()) {
                $jeu = $form->getData();
                $jeuBDD->setImagelink(htmlspecialchars($jeu->getImageLink()));
                $jeuBDD->setLink(htmlspecialchars($jeu->getLink()));
                $jeuBDD->setDescription(htmlspecialchars($jeu->getDescription()));
		$jeuBDD->setName(htmlspecialchars($jeu->getName()));
		$jeuBDD->setGenre(htmlspecialchars($jeu->getGenre()));
                $em->merge($jeuBDD);
                $em->flush();
                 return $this->redirectToRoute('accueilloged');
        }
        if(isset($_SESSION['user']))
                return $this->render('post.html.twig', ['name' => $_SESSION['user']->getName(), 'placeholder_name' => $jeuBDD->getName(), 'placeholder_desc' => $jeuBDD->getDescription(),
		'placeholder_link' => $jeuBDD->getLink(),
		'placeholder_imagelink' => $jeuBDD->getImageLink(),
		'placeholder_genre' => $jeuBDD->getGenre()]);
         return $this->redirectToRoute('accueil');
    }

}
