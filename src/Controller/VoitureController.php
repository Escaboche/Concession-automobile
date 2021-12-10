<?php

namespace App\Controller;

use App\Entity\RechercheVoiture;
use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\RechercheVoitureType;

class VoitureController extends AbstractController
{
    /**
     * @Route("/client/voitures", name="page_des_voitures")
     */
    public function index(VoitureRepository $repo,PaginatorInterface $paginator, Request $request): Response
    {

        $rechercherVoiture = New RechercheVoiture();

        $form = $this->createForm(RechercheVoitureType::class, $rechercherVoiture);
        $form->handleRequest($request);
        

        $voitures = $paginator->paginate(
            $repo->findAllWithPagination($rechercherVoiture), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        
        
        return $this->render('voiture/pageVoitures.html.twig', [
            'voitures' => $voitures,
            'form' => $form->createView(),
            'admin' => false
            
        ]);
    }
}
