<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
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
        return $this->redirect('/api', 301);
    }

}
