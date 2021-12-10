<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Entity\RechercheVoiture;
use App\Form\RechercheVoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfToken;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(VoitureRepository $repo,PaginatorInterface $paginator, Request $request): Response
    {

        $rechercherVoiture = New RechercheVoiture();

        $form = $this->createForm(RechercheVoitureType::class, $rechercherVoiture);
        $form->handleRequest($request);
        

        $voitures = $paginator->paginate(
            $repo->findAllWithPagination($rechercherVoiture), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );
        
        
        return $this->render('voiture/pageVoitures.html.twig', [
            'voitures' => $voitures,
            'form' => $form->createView(),
            'admin' => true
            
        ]);
    }

    /**
     * @Route("/admin/creation",name="creation")
     * @Route("/admin/{id}", name="modif",methods="GET|POST")
     */
    public function Modification(Voiture $voiture = null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$voiture) {
            $voiture = New Voiture();
        }

        $formAdd = $this->createForm(VoitureType::class, $voiture);
        $formAdd->handleRequest($request);
        
        if ($formAdd->isSubmitted() && $formAdd->isValid()) { 
            $existe = $voiture->getId() === null;
            $em->persist($voiture);
            $em->flush();
            $this->addFlash('success', ($existe) ? 'La voiture est bien enregistrée' : 'La voiture est bien modifiée');
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/ajoutEtModifVoiture.html.twig', [
            'formAdd' => $formAdd->createView(),
            'voiture' => $voiture,
            'isExiste' => $voiture->getId() === null,
            
        ]);
    }

    /**
     * @Route("/admin/{id}", name="supression_voiture",methods="SUP")
     */
    public function SupressionVoiture(Voiture $voiture, Request $request, EntityManagerInterface $emi)
    {
        if ($this->isCsrfTokenValid('SUP'.$voiture->getId(),$request->get('_token'))) {
            $emi->remove($voiture);
            $emi->flush();
            $this->addFlash('delete','La voiture est bien supprimée');
            return $this->redirectToRoute('admin');
        }
    }
    
}
