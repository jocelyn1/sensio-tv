<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class AuthentificationSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event)
    {
        $this->logger->debug('ici');
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
