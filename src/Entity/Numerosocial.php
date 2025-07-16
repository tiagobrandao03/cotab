<?php

namespace App\Entity;

use App\Repository\NumerosocialRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToMany;
use phpDocumentor\Reflection\Types\Collection;

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


    #[ORM\ManyToOne(inversedBy: "numerosocial")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;


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

    public function getNumerosocial(): ?Employee
    {
        return $this->numerosocial;
    }

    public function setNumerosocial(?Employee $numerosocial): void
    {
        $this->numerosocial = $numerosocial;
    }



    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        // Se estiver vinculando um novo employee
        if ($employee !== null && !$employee->getNumerosocial()->contains($this)) {
            $employee->addNumerosocial($this);
        }

        // Se estiver removendo a associação
        if ($employee === null && $this->employee !== null) {
            $this->employee->removeNumerosocial($this);
        }

        $this->employee = $employee;

        return $this;
    }
}
