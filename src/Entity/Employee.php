<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;


#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $cpf ;

    #[ORM\OneToOne(mappedBy: "atfaltasJustificadas", targetEntity: Ativoemp::class, cascade: ["persist", "remove"])]
    private ?Ativoemp $faltasJustificadas = null;

    #[ORM\OneToOne(mappedBy: "atfaltasInjustificadas", targetEntity: Ativoemp::class, cascade: ["persist", "remove"])]
    private ?Ativoemp $faltasInjustificadas = null;

    #[ORM\OneToOne(
        mappedBy: "employee",
        targetEntity: Numerosocial::class,
        cascade: ["persist", "remove"]
    )]
    private ?Numerosocial $numerosocial = null;

    #[ORM\OneToOne(
        mappedBy: "atdecimoterceiro",
        targetEntity: Ativoemp::class,
        cascade: ["persist","remove"]
    )]
    #[ORM\Column(length: 100)]
    private ?Ativoemp $decimoterceiro = null;

    #[ORM\OneToOne(
        mappedBy: "atacidentado",
        targetEntity: Ativoemp::class,
        cascade: ["persist","remove"]
    )]
    #[ORM\Column(length: 100)]
    private ?Ativoemp $acidentado = null;


    //atferias
    //atdiastrabalho
    //faltasemp
    #[ORM\OneToOne(
        mappedBy: "atferias",
        targetEntity: Ativoemp::class,
        cascade: ["persist","remove"]
    )]
    #[ORM\Column(length: 100)]
    private ?Ativoemp $ferias = null;


    #[ORM\OneToOne(
        mappedBy: "atdiastrabalho",
        targetEntity: Ativoemp::class,
        cascade:["persist","remove"]
    )]
    #[ORM\Column(length: 100)]
    private ?Ativoemp $daywork = null;

    //daywork atdiastrabalho
    //ferias atferias
    //atdiastrabalho daywork
    //Ativo atemployee
    #[ORM\OneToOne(inversedBy: 'ativoemp', cascade: ['persist', 'remove'])]
    #[ORM\Column(length: 100)]
    private ?Ativoemp $ativo = null;
    // No ArrayCollection needed!

    public function __construct(
        #[ORM\Column]
        private string $name
    )
    {}

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
            && $atfaltasInjustificadas->getfaltasInjustificadas($this)){
            $atfaltasInjustificadas->setfaltasInjustificadas($this);
        }
    }
    public function getNumerosocial(): ?Numerosocial
    {
        return $this->numerosocial;
    }

    public function setNumerosocial(?Numerosocial $numerosocial): void
    {
        $this->numerosocial = $numerosocial;
        // Se estiver definindo um novo numerosocial
        if ($numerosocial !== null && $numerosocial->getEmployee() !== $this) {
            $numerosocial->setEmployee($this);
        }

    }
    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;
        if ($employee !== null && $employee->getNumerosocial() !== $this) {
            $employee->setNumerosocial($this);
        }
        return $this;
    }


    public function getDecimoterceiro(): ?string
    {
        return $this->decimoterceiro;
    }

    public function setDecimoterceiro(?decimoterceiro $decimoterceiro): void
    {
        $this->decimoterceiro = $decimoterceiro;
        if ($decimoterceiro !==null && $decimoterceiro->
            getATDecimoterceiro() !== $this){
            $decimoterceiro->setATDecimoterceiro($this);
        }
    }
    public function setATDecimoterceiro(?atdecimoterceiro $atdecimoterceiro):static{
        $this->atdecimoterceiro = $atdecimoterceiro;
        if ($atdecimoterceiro !==null && $atdecimoterceiro->getDecimoterceiro() !== $this){
            $atdecimoterceiro->setDecimoterceiro($this);
        }
        return $this;
    }
    public function getAcidentado(): ?string
    {
        return $this->acidentado;
    }

    public function setAcidentado(?acidentado $acidentado): void
    {
        $this->acidentado = $acidentado;
        if($acidentado !==null &&
            $acidentado->getATAcidentado() !== $this){
            $acidentado->setATAcidentado($this);
        }

    }

    public function setATAcidentado(?atacidentado $atacidentado): static{
        $this->atacidentado = $atacidentado;
        if($atacidentado !==null && $atacidentado->getAcidentado() !== $this){
            $atacidentado->setAcidentado($this);
        }
        return $this;
    }
    public function getFerias(): ?string
    {
        return $this->ferias;
    }

    public function setFerias(string $ferias): void
    {
        $this->ferias = $ferias;
        if($ferias !=null && $ferias->
            getATFerias() !== $this){
            $ferias->setATFerias($this);
        }
    }
    public function setATFerias(?atferias $atferias): static
    {
        $this->atferias = $atferias;
        if($atferias !==null &&
            $atferias->getFerias() !==$this){
            $atferias->setFerias($this);
        }
        return $this;
    }
    public function getDaywork(): ?string
    {
        return $this->daywork;
    }

    public function setDaywork(string $daywork): void
    {
        $this->daywork = $daywork;
        if($daywork !==null &&
            $daywork->getATDiastrabalho() !==$this){
            $daywork->setATDiastrabalho($this);
        }
    }

    public function setATDiastrabalho(?atdiastrabalho $atdiastrabalho): static
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

    public function setAtivo(Ativoemp $ativo): void
    {
        $this->ativo = $ativo;
        if ($ativo !==null &&
            $ativo->getAtivoemp() !==$this
        ){
            $ativo->setAtivoemp($this);
        }

    }
    public function setAtivoemp(bool $ativoemp): static
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
