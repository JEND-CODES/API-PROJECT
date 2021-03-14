<?php
// https://gitlab.com/yoandev.co/integration-continue-d-une-api-symfony-api-platform-avec-postman-et-gitlab-ci
// https://www.youtube.com/watch?v=W9H76JvCmhI
// Voir documentation Api Platform : https://api-platform.com/docs/core/events/

// PERMET D'ENCODER LE MOT DE PASSE CHOISI PAR UN NOUVEAU CONSUMER
// Fonctionne sur le ENDPOINT -> POST /api/consumers (Creates a consumer resource)
// Le résultat du POST, c'est l'enregistrement du nouveau consumer + encodage de son password en BDD
namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Consumer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
   
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($result instanceof Consumer && $method === "POST") {
            $hash = $this->encoder->encodePassword($result, $result->getPassword());
            $result->setPassword($hash);
        }
    }
}
