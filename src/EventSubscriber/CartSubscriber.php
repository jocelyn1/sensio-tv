<?php

namespace App\EventSubscriber;

use App\Cart\CartEvent;
use App\Cart\CartEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CartSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(CartEvent $event)
    {
        // ...
        $this->logger->info(sprintf('User %s added movie "%s" to cart :).', $event->getUser()->getUsername(), $event->getMovie()->getTitle()));

    }

    public static function getSubscribedEvents()
    {
        return [
            CartEvent::class => 'log',
        ];
    }
}
