<?php

namespace App\Controller;

use App\Entity\TheatrePlay;
use App\Form\TheatreType;
use App\Repository\TheatrePlayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class TheatrePlayController extends AbstractController
{
   #[Route('/displayplay', name: 'app_displayplay')]
    public function DisplayPlay(TheatrePlayRepository $tr): Response
    {
        $list=$tr->findAll();
        return $this->render (
            'theatre_play/liste.html.twig', 
        [
           "list"=>$list
        ]);
    }
    #[Route('/displayAdd', name: 'Add_Show')]
    public function DisplayAdd(ManagerRegistry $doctrine, Request $request): Response
    {
    $tr=new TheatrePlay(); 
        $form = $this->createForm(TheatreType::class, $tr);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
        $em=$doctrine->getManager(); // appel entity manager
        $em->persist($tr); // insert into
        $em->flush();// d'envoyer tout ce qui a été persisté avant à la base de données
        return $this->redirectToRoute('app_displayplay');
        }
             return $this->render('theatre_play/add.html.twig', [
            'form' => $form->createView()
        ]);}
}