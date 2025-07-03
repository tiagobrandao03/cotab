<?php

namespace App\Entity;

use App\Repository\AtivoempRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtivoempRepository::class)]
class Ativoemp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'Ativo', cascade: ['persist', 'remove'])]
    private ?Employee $employee = null;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "decimoterceiro")]
    private ?string $atdecimoterceiro = null;

    #[ORM\OnetoOne(targetEntity: Employee::class,inversedBy: "acidentado")]
    private ?string $atacidentado = null;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "ferias")]
    private ?string $atferias = null;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "diastrabalhados")]
    private ?string $atdiastrabalho = null;


    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "faltasJustificadas")]
    private ?string $atfaltasJustificadas = null;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "faltasInjustificadas")]
    private ?string $atfaltasInjustificadas=null;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "ativo")]
    private ?string $ativoemp = null;

    #[ORM\OneToOne(mappedBy: 'Ativo', cascade: ['persist', 'remove'])]
    private ?Employee $atemployee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $atemployee): static
    {
        // set the owning side of the relation if necessary
        if ($atemployee->getAtivo() !== $this) {
            $atemployee->setAtivo($this);
        }

        $this->atemployee = $atemployee;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getATDecimoterceiro(): ?Employee
    {
        return $this->atdecimoterceiro;
    }

    /**
     * @param string|null $atdecimoterceiro
     */
    public function setATDecimoterceiro(?string $atdecimoterceiro): void
    {
        $this->atdecimoterceiro = $atdecimoterceiro;
    }

    /**
     * @return string|null
     */
    public function getATAcidentado(): ?Employee
    {
        return $this->atacidentado;
    }

    /**
     * @param string|null $atacidentado
     */
    public function setATAcidentado(?string $atacidentado): void
    {
        $this->atacidentado = $atacidentado;
    }

    /**
     * @return string|null
     */
    public function getATFerias(): ?Employee
    {
        return $this->atferias;
    }

    /**
     * @param string|null $atferias
     */
    public function setATFerias(?string $atferias): void
    {
        $this->atferias = $atferias;
    }

    /**
     * @return string|null
     */
    public function getAtDiastrabalho(): ?Employee
    {
        return $this->atdiastrabalho;
    }

    /**
     * @param string|null $atdiastrabalho
     */
    public function setAtDiastrabalho(?string $atdiastrabalho): void
    {
        $this->atdiastrabalho = $atdiastrabalho;
    }

    /**
     * @return string|null
     */
    public function getFaltasemp(): ?Employee
    {
        return $this->faltasemp;
    }

    /**
     * @param string|null $faltasemp
     */
    public function setFaltasemp(?string $faltasemp): void
    {
        $this->faltasemp = $faltasemp;
    }

    /**
     * @return string
     */
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
    /**
     * @return string|null
     */
    public function getAtfaltasJustificadas(): ?Employee
    {
        return $this->atfaltasJustificadas;
    }

    /**
     * @return string|null
     */
    public function getAtfaltasInjustificadas(): ?string
    {
        return $this->atfaltasInjustificadas;
    }


}
