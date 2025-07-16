<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
//use phpDocumentor\Reflection\Types\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;


#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 100)]
    private string $cpf ;

    #[ORM\OneToOne(mappedBy: "atfaltasJustificadas", targetEntity: Ativoemp::class, cascade: ["persist", "remove"])]
    private ?Ativoemp $faltasJustificadas= null;

    #[ORM\OneToOne(mappedBy: "atfaltasInjustificadas", targetEntity: Ativoemp::class, cascade: ["persist", "remove"])]
    private ?Ativoemp $faltasInjustificadas = null;

    //#[ORM\OneToOne(
     //   mappedBy: "employee",
   //    targetEntity: Numerosocial::class,
     //   cascade: ["persist", "remove"]
   // )]
    //private ?Numerosocial $numerosocial= null ;
    #[ORM\OneToMany(
        mappedBy: "employee",
        targetEntity: Numerosocial::class,
        cascade: ["persist", "remove"])]
    private Collection $numerosocial;

    #[ORM\OneToOne(
        mappedBy: "atdecimoterceiro",
        targetEntity: Ativoemp::class,
        cascade: ["persist","remove"]
    )]

    private ?Ativoemp $decimoterceiro = null ;

    #[ORM\OneToOne(
        mappedBy: "atacidentado",
        targetEntity: Ativoemp::class,
        cascade: ["persist", "remove"]
    )]
    private ?Ativoemp $acidentado = null;

    #[ORM\OneToOne(
        mappedBy: "atferias",
        targetEntity: Ativoemp::class,
        cascade: ["persist", "remove"]
    )]
    private ?Ativoemp $ferias = null;


    #[ORM\OneToOne(
        mappedBy: "atDiasTrabalho",
        targetEntity: Ativoemp::class,
        cascade: ["persist", "remove"]
    )]
    private ?Ativoemp $daywork = null;

    #[ORM\OneToOne(
        mappedBy: "atAtivo",
        targetEntity: Ativoemp::class,
        cascade: ["persist","remove"]
    )]
    private ?Ativoemp $ativo = null;
    // No ArrayCollection needed!

    public function __construct(
        #[ORM\Column]
        private string $name
    )
    {
        $this->numerosocial = new ArrayCollection();
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
    public function getFaltasJustificadas(): ?Ativoemp
    {
        return $this->faltasJustificadas;
    }
    public function setFaltasJustificadas(?Ativoemp $faltasJustificadas): static
    {
        $this->faltasJustificadas = $faltasJustificadas;
        if ($faltasJustificadas !==null
            && $faltasJustificadas->getAtfaltasJustificadas()
            !== $this){
            $faltasJustificadas->setAtfaltasJustificadas($this);
        }
        return $this;
    }
    public function setATfaltasJustificadas(?Ativoemp $faltasJustificadas){
        $this->faltasJustificadas=$faltasJustificadas;
        if ($faltasJustificadas !==null
            && $faltasJustificadas->getATfaltasJustificadas()
            !==$this){
            $faltasJustificadas->setATfaltasJustificadas($this);
        }
    }
    public function getFaltasInjustificadas(): ?Ativoemp
    {
        return $this->faltasInjustificadas;
    }
    public function setFaltasInjustificadas(?Ativoemp $faltasInjustificadas): static
    {
        $this->faltasInjustificadas = $faltasInjustificadas;
        if ($faltasInjustificadas !==null
            && $faltasInjustificadas->getAtfaltasInjustificadas()
            !==$this){
            $faltasInjustificadas->setAtfaltasInjustificadas($this);
        }

        return $this;
    }
    public function setATfaltasInjustificadas(?Ativoemp $atfaltasInjustificadas):static{
        $this->atfaltasInjustificadas=$atfaltasInjustificadas;
        if($atfaltasInjustificadas !== null
            && $atfaltasInjustificadas->getfaltasInjustificadas()!== $this){
            $atfaltasInjustificadas->setfaltasInjustificadas($this);
        }
    }

    public function getNumerosocial(): Collection
    {
        return $this->numerosocial;
    }
    public function addNumerosocial(Numerosocial $numerosocial): static
    {
        if (!$this->numerosocial->contains($numerosocial)) {
            $this->numerosocial->add($numerosocial);

            // seta o lado inverso sem gerar recursão
            if ($numerosocial->getEmployee() !== $this) {
                $numerosocial->setEmployee($this);
            }
        }

        return $this;
    }

    public function removeNumerosocial(Numerosocial $numerosocial): static
    {
        if ($this->numerosocial->removeElement($numerosocial)) {
            // seta o lado inverso para null sem recursão
            if ($numerosocial->getEmployee() === $this) {
                $numerosocial->setEmployee(null);
            }
        }

        return $this;
    }
    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;
        if ($employee !== null && $employee->getNumerosocial() !== $this) {
            $employee->setNumerosocial($this);
        }
        return $this;
    }
    public function getDecimoTerceiro(): ?string
    {
        return $this->decimoterceiro;
    }
    public function setDecimoTerceiro(?Ativoemp $decimoterceiro): void
    {
        $this->decimoterceiro = $decimoterceiro;

        if ($decimoterceiro !== null && $decimoterceiro->getATDecimoterceiro() !== $this) {
            $decimoterceiro->setATDecimoterceiro($this);
        }
    }
    public function setATDecimoterceiro(?Ativoemp $atdecimoterceiro):static{
        $this->atdecimoterceiro = $atdecimoterceiro;
        if ($atdecimoterceiro !==null && $atdecimoterceiro->getDecimoterceiro() !== $this){
            $atdecimoterceiro->setDecimoterceiro($this);
        }
        return $this;
    }
    public function getAcidentado():?Ativoemp
    {
        return $this->acidentado;
    }
    public function setAcidentado(?Ativoemp $acidentado): void
    {
        $this->acidentado = $acidentado;
        if ($acidentado!==null && $acidentado->getATAcidentado()!== $this){
            $acidentado->setATAcidentado($this);
        }
    }
    public function setATAcidentado(?Ativoemp $atacidentado): static{
        $this->atacidentado = $atacidentado;
        if($atacidentado !==null && $atacidentado->getAcidentado() !== $this){
            $atacidentado->setAcidentado($this);
        }
        return $this;
    }
    public function getFerias():?Ativoemp
    {
        return $this->ferias;
    }
    public function setFerias(?Ativoemp $ferias): void
    {
        $this->ferias = $ferias;
        if ($ferias !== null && $ferias->getATFerias() !== $this) {
            $ferias->setATFerias($this);
        }
    }

    public function setATFerias(?Ativoemp $atferias): static
    {
        $this->atferias = $atferias;
        if($atferias !==null &&
            $atferias->getFerias() !==$this){
            $atferias->setFerias($this);
        }
        return $this;
    }
    public function getDaywork(): ?Ativoemp
    {
        return $this->daywork;
    }
    public function setDaywork(?Ativoemp $daywork): void
    {
        $this->daywork = $daywork;
        if ($daywork !== null && $daywork->getAtDiasTrabalho() !== $this) {
            $daywork->setAtDiasTrabalho($this);
        }
    }
    public function setATDiastrabalho(?Ativoemp $atdiastrabalho): static
    {
        $this->atdiastrabalho = $atdiastrabalho;
        if ($atdiastrabalho !==null &&
            $atdiastrabalho->getDaywork() !==$this){
            $atdiastrabalho->setDaywork($this);
        }
        return $this;
    }

    public function getAtivo(): ?Ativoemp
    {
        return $this->ativo;
    }

    public function setAtivo(?Ativoemp $ativo): void
    {
        $this->ativo = $ativo;
        if ($ativo !==null &&
            $ativo->getAtivoemp() !==$this
        ){
            $ativo->setAtivoemp($this);
        }

    }
    public function setAtivoemp(?Ativoemp $ativoemp): static
    {
        $this->ativoemp = $ativoemp;
        if (
            $ativoemp->getAtivo() !==$this
        ){
            $ativoemp->setAtivo($this);
        }
        return $this;
    }
}
