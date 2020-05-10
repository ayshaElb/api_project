<?php

namespace App\Events;

use App\Entity\Customer;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class CustomerUserSubcriber implements EventSubscriberInterface 
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setUserForCustomer', EventPriorities::PRE_VALIDATE]
        ];
    }
    public function setUserForCustomer( ViewEvent $event)
    {
        $customer = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        

        if($customer instanceof Customer && $method === "POST"){
            //récuperer l'utilisateur actuellement connecté
            $user = $this->security->getUser();
            //assigner l'utilisateur au Customer qu'on est en train de créer
            $customer->setUser($user);
        
        }
        
    }
}