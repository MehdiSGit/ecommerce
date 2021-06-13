<?php

namespace App\EventDispatcher;

use App\Event\PurchaseSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PurchaseSuccesEmailSubscriber implements EventSubscriberInterface
{   
    public static function getSubscribedEvents()
    {
        return [
            'purchase.success' => 'sendSuccessEmail'
        ];
    }

    public function sendEmailSuccess(PurchaseSuccessEvent $purchaseSuccessEvent)
    {

    }
}