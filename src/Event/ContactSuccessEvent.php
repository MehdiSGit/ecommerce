<?php

namespace App\Event;

use App\Entity\Contact;
use Symfony\Contracts\EventDispatcher\Event;

class ContactSuccessEvent extends Event
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}