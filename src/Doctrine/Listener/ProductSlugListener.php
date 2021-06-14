<?php

namespace App\Doctrine\Listener;

use Doctrine\Persistence\Event\LifecycleEventArgs;

class ProductSlugListener 
{
    public function pretPresist(LifecycleEventArgs $event)
    {
        dd("Ca marche");
    }
}