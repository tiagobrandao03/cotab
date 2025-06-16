<?php

namespace App\Entity;

use App\Repository\NumerosocialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumerosocialRepository::class)]
class Numerosocial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nome_filho = null;

    #[ORM\Column(length: 100)]
    private ?string $cpf_filho = null;

    #[ORM\OneToOne(inversedBy: 'numerosocial', cascade: ['persist', 'remove'])]
    private ?Employee $numero_social = null;

    #[ORM\OneToOne(mappedBy: 'numerosociais', cascade: ['persist', 'remove'])]
    private ?Employee $employee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeFilho(): ?string
    {
        return $this->nome_filho;
    }

    public function setNomeFilho(string $nome_filho): static
    {
        $this->nome_filho = $nome_filho;

        return $this;
    }

    public function getCpfFilho(): ?string
    {
        return $this->cpf_filho;
    }

    public function setCpfFilho(string $cpf_filho): static
    {
        $this->cpf_filho = $cpf_filho;

        return $this;
    }

    public function getNumeroSocial(): ?Employee
    {
        return $this->numero_social;
    }

    public function setNumeroSocial(?Employee $numero_social): static
    {
        $this->numero_social = $numero_social;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        // unset the owning side of the relation if necessary
        if ($employee === null && $this->employee !== null) {
            $this->employee->setNumerosociais(null);
        }

        // set the owning side of the relation if necessary
        if ($employee !== null && $employee->getNumerosociais() !== $this) {
            $employee->setNumerosociais($this);
        }

        $this->employee = $employee;

        return $this;
    }
}
