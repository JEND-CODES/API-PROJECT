<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Consumer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Service\MailSender;

final class ConsumerMailSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailSender
     */
    private $mailSender;

    /**
     * @var string $managerMail
     */
    private $managerMail;

    public function __construct(MailSender $mailSender, string $managerMail)
    {
        $this->mailSender = $mailSender;
        $this->managerMail = $managerMail;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE],
        ];
    }

    public function sendMail(ViewEvent $event): void
    {
        $consumer = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();

        if (!$consumer instanceof Consumer || Request::METHOD_POST !== $method) {
            return;
        }

        // ENVOI D'UN EMAIL À L'UTILISATEUR
        $message = "Votre compte Api Bilemo vient d'être ajouté. Vous pouvez vous connecter avec le pseudo suivant : {$consumer->getUsername()} ; et le mot de passe que vous aviez communiqué. Ce compte utilisateur est rattaché au compte client {$consumer->getClient()->getName()} et est référencé avec l'identifiant n°{$consumer->getId()}. Nous vous remercions pour votre confiance !";

        $this->mailSender->sendMail($this->mailSender::NEW_API_USER, $consumer->getEmail(), $message);

    }

}
