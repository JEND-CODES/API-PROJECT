<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Entity\Consumer;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class DeleteConsumerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onDeleteAction', EventPriorities::PRE_WRITE]
        ];
    }

    public function onDeleteAction(ViewEvent $event): void
    {
        $consumer = $event->getControllerResult();
        $request = $event->getRequest();
        $method = $request->getMethod();

        if (!$consumer instanceof Consumer || Request::METHOD_DELETE !== $method) {
            return;
        }

        if ($this->security->getUser()->getId() === $consumer->getId()) 
        {
            throw new AccessDeniedException("Prohibited operation. You can not delete your own account.");
        } 
        
        $adminRole = $this->security->getUser()->getRole() === 'ROLE_ADMIN';

        $consumerRole = $consumer->getRole() === 'ROLE_USER';

        if ($adminRole && !$consumerRole) 
        {
            throw new AccessDeniedException("Prohibited operation. You can only delete a consumer defined with the property ROLE_USER.");
        }

        $currentUserRefClient = $this->security->getUser()->getClient();

        $consumerRefClient = $consumer->getClient();

        if ($adminRole && $currentUserRefClient !== $consumerRefClient) 
        {
            throw new AccessDeniedException("Prohibited operation. You can only delete a consumer of your client reference.");
        }
       
    }

}
