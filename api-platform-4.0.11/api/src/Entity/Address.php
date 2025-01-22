<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ApiResource]
#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[OneToOne(targetEntity: Address::class)]
    #[JoinColumn(name: 'address_id', referencedColumnName: 'id')]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 16)]
    private ?string $postalCode = null;


    #[ORM\Column(length: 2, nullable:true)]
    private ?string $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function setCountry(string $country): void {
        $this->country = $country;
    }

    public function getCountry(): ?string {
        return $this->country;
    }

    /**
    * @return array<string,string>
    **/
    public function getVisible(): array
    {
        return ['city' => $this->city,
            'address' => $this->address,
            'postalCode' => $this->postalCode,
            'country' => $this->country
        ];
    }

}
