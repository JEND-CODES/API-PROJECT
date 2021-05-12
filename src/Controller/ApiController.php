<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Repository\ClientRepository;
use App\Repository\ConsumerRepository;
use App\Repository\ProductRepository;

class ApiController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    /**
     * @Route("/", name="security_connexion", methods={"GET","POST"})
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function connexion(AuthenticationUtils $utils): Response
    {
        $current_user = $this->security->getUser();

        $error = $utils->getLastAuthenticationError();

        return $this->render('security/connexion.html.twig', [
            'error' => $error,
            'current_user' => $current_user
        ]);
    }

    /**
     * @Route("/gotoapi", name="gotoapi", methods={"GET"})
     * @return RedirectResponse
     */
    public function goToApi(): RedirectResponse
    {
        // Une redirection 301 est une substitution permanente de l’adresse initialement demandée par l’adresse obtenue
        return $this->redirect('/api', 301);
        
    }
    
}
