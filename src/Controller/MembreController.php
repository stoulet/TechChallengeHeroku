<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembreController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, EntityManagerInterface $em, MembreRepository $repo): Response
    {
        $membre = new Membre();

        $form = $this->createForm(MembreType::class, $membre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membre = $form->getData();

            $em->persist($membre);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('membre/index.html.twig', [
            'form' => $form->createView(),
            'membres' => $repo->findAll()
        ]);
    }
}
