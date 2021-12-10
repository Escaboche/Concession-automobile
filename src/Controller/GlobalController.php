<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="acceuil")
     */
    public function index(): Response
    {
        return $this->render('global/acceuil.html.twig');
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $emi, UserPasswordHasherInterface $passwordHasher){
        $utilisateur = new Utilisateur();

        $formInscription = $this->createForm(InscriptionType::class, $utilisateur);
        $formInscription->handleRequest($request);
        
        if ($formInscription->isSubmitted() && $formInscription->isValid()) { 
            $utilisateur->setRoles('ROLE_USER');
            $passwordCrypt = $passwordHasher->hashPassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($passwordCrypt);
            $emi->persist($utilisateur);
            $emi->flush();
            return $this->redirectToRoute('acceuil');
        }

        return $this->render('global/inscription.html.twig',[
            'form' => $formInscription->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
    
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('global/login.html.twig',[
        'lastUsername' => $lastUsername,
        'error' => $error
        ]);
    }

     /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        
    }
}
