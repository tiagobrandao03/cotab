<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 100)]
    private ?string $cpf = null;

    #[ORM\Column(length: 100)]
    private ?string $faltas = null;

    //#[ORM\OneToOne(inversedBy: 'employee', cascade: ['persist', 'remove'])]
    //private ?Numerosocial $numerosociais = null;

    public function __construct(
        #[ORM\Column]
        private string $name
    )
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getFaltas(): ?string
    {
        return $this->faltas;
    }

    public function setFaltas(string $faltas): static
    {
        $this->faltas = $faltas;

        return $this;
    }

    //public function getNumerosociais(): ?Numerosocial
   // {
     //   return $this->numerosociais;
   // }

   // public function setNumerosociais(?Numerosocial $numerosociais): static
    //{
    //    $this->numerosociais = $numerosociais;
//
    //    return $this;
   // }

  

}
