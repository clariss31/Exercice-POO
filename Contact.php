<?php

declare(strict_types=1);

// Classe représentant un contact
class Contact extends ContactManager {
    private ?int $id;
    private ?string $name;
    private ?string $email;
    private ?string $phone_number;

    public function getId() : ?int {
    if (isset($this->id))
        return $this->id;
    return null;
    }

    public function getName() : ?string {
        if (isset($this->name))
            return $this->name;
        return null;
    }

    public function getEmail() : ?string {
        if (isset($this->email))
            return $this->email;
        return null;
    }

    public function getPhoneNumber() : ?string {
        if (isset($this->phone_number))
            return $this->phone_number;
        return null;
    }

    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function setEmail(string $email) : void {
        $this->email = $email;
    }

    public function setPhoneNumber(string $phone_number) : void {
        $this->phone_number = $phone_number;
    }

    // Transformation en chaîne de caractères formatée pour les echos de contact
    public function __toString(): string {
        return "Contact #$this->id : $this->name ($this->email, $this->phone_number)\n";
    }

    public function __construct(int $id, string $name, string $email, string $phone_number) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;

    }
}