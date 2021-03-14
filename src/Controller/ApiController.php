<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ApiController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    /**
     * @Route("/", name="security_connexion")
     */
    public function connexion(AuthenticationUtils $utils)
    {
        $current_user = $this->security->getUser();

        // if(!is_null($current_user)) {
        //     return $this->redirectToRoute('gotoapi');
        // }

        $error = $utils->getLastAuthenticationError();

        return $this->render('security/connexion.html.twig', [
            'error' => $error,
            'current_user' => $current_user
        ]);
    }

    /**
     * @Route("/disconnect", name="security_disconnect")
     */
    public function disconnect() {}

    /**
     * @Route("/gotoapi", name="gotoapi")
     */
    public function goToApi()
    {
        // Une redirection 301 est une substitution permanente de l’adresse initialement demandée par l’adresse obtenue
        return $this->redirect('/api', 301);
        
    }

}
