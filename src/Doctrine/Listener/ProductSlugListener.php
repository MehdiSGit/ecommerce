<?php

namespace App\Doctrine\Listener;

use App\Entity\Product;
use Doctrine\ORM\Event\LifecycleEventArgs as EventLifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductSlugListener 
{      
    protected $slugger;     

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Product $entity, EventLifecycleEventArgs $event)
    {   
        if(empty($entity->getSlug()))
        {
            $entity->setSlug(strtolower($this->slugger->slug($entity->getName())));
        }
    }
}