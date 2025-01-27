<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'patients')]
class Patient implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING,length:128)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::STRING,length:128)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::STRING,length:16)]
    private ?string $phone = null;

    public function getVisible(): array
    {
        return [
            'phone' => $this->phone,
            'lastName' => $this->lastName,
            'firstName' => $this->firstName
        ];
    }

    public function getid():?int {
        return $this->id;
    }

    public function setid(?int $id):void {
        $this->id = $id;
    }

    public function getFirstName():?string {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName):void {
        $this->firstName = $firstName;
    }

    public function getLastName():?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName):void {
        $this->lastName = $lastName;
    }

    public function getPhone():?string {
        return $this->phone;
    }

    public function setPhone(?string $phone):void {
        $this->phone = $phone;
    }

    public function getFullName(): ?string {
        if(null === $this->firstName || $this->lastName === null)
        {
            return null;
        }

        return $this->firstName.' '.$this->lastName;
    }
}
