<?php

namespace App\Entity;

use App\Repository\DevicesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevicesRepository::class)]
class Devices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    #[ORM\Column(type: 'string', length: 3)]
    public $name;

    #[ORM\Column(type: 'string', length: 50)]
    public $ip;

    #[ORM\Column(type: 'integer')]
    public $led1;

    #[ORM\Column(type: 'integer')]
    public $led2;

    #[ORM\Column(type: 'integer')]
    public $led3;

    #[ORM\Column(type: 'integer')]
    public $led4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getLed1(): ?int
    {
        return $this->led1;
    }

    public function setLed1(int $led1): self
    {
        $this->led1 = $led1;

        return $this;
    }

    public function getLed2(): ?int
    {
        return $this->led2;
    }

    public function setLed2(int $led2): self
    {
        $this->led2 = $led2;

        return $this;
    }

    public function getLed3(): ?int
    {
        return $this->led3;
    }

    public function setLed3(int $led3): self
    {
        $this->led3 = $led3;

        return $this;
    }

    public function getLed4(): ?int
    {
        return $this->led4;
    }

    public function setLed4(int $led4): self
    {
        $this->led4 = $led4;

        return $this;
    }
}
