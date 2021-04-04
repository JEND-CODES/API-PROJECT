<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Consumer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ConsumerSubscriber implements EventSubscriberInterface
{
    
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
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

        $message = (new \Swift_Message('Nouveau compte créé'))
            ->setFrom('noreply@bilemo.com')
            ->setTo($consumer->getEmail())
            ->setBody(sprintf('Votre compte #%d a été ajouté', $consumer->getId()));

        $this->mailer->send($message);

    }

}
