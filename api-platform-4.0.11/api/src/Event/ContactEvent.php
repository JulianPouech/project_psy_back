<?php

namespace App\Event;

use App\Model\Contact;
use Symfony\Contracts\EventDispatcher\Event;

final class ContactEvent extends Event
{
    public function __construct(private Contact $contact) {
    }

    public function getContact(): Contact {
        return $this->contact;
    }
}
