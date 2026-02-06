<?php

namespace App\Model;

class Contact
{
    private ?string $email = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $phone = null;

    private ?string $message = null;

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function getMessage(): ?string {
        return $this->message;
    }
}
