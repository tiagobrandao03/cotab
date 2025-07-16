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

    //#[ORM\OneToOne(mappedBy: 'Ativo', cascade: ['persist', 'remove'])]
   // private ?Employee $employee = null;
    #[ORM\ManyToOne(inversedBy: "numerosociais")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

    #[ORM\OneToOne(targetEntity: Employee::class, inversedBy: "decimoterceiro")]
    #[ORM\JoinColumn(name: "employee_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Employee $atdecimoterceiro = null;

    #[ORM\OneToOne(targetEntity: Employee::class, inversedBy: "acidentado")]
    #[ORM\JoinColumn(name: "employee_id_acidentado", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Employee $atacidentado = null;

    #[ORM\OneToOne(targetEntity: Employee::class, inversedBy: "ferias")]
    #[ORM\JoinColumn(name: "employee_id_ferias", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Employee $atferias = null;

    #[ORM\OneToOne(targetEntity: Employee::class, inversedBy: "daywork")]
    #[ORM\JoinColumn(name: "employee_id_daywork", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Employee $atDiasTrabalho = null;

    // (opcional) guarda quantos dias ele trabalhou
    #[ORM\Column(type: 'string', length: 2, nullable: false)]
    private string $diasTrabalho;
    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "faltasJustificadas")]
    private ?string $atfaltasJustificadas ;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "faltasInjustificadas")]
    private ?string $atfaltasInjustificadas;

    #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "ativo")]
    #[ORM\JoinColumn(name: "employe_id_ativo",referencedColumnName: "id",onDelete: "CASCADE")]
    private ?string $atativo = null;

   // #[ORM\OneToOne(targetEntity: Employee::class,inversedBy: "ativo")]
   // #[ORM\JoinColumn(name: "employe_id_ativo",referencedColumnName: "id",onDelete: "CASCADE")]
    //private ?string $ativoemp = null;

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
        if ($atemployee->getAtativo() !== $this) {
            $atemployee->setAtativo($this);
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
    public function setATDecimoterceiro(?Employee $employee): void
    {
        $this->atdecimoterceiro = $employee;
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
    public function setATAcidentado(?Employee $employee): void
    {
        $this->atacidentado = $employee;
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
    public function setATFerias(?Employee $employee): void
    {
        $this->atferias = $employee;
    }

    /**
     * @return string|null
     */
    public function getAtDiasTrabalho(): ?Employee
    {
        return $this->atDiasTrabalho;
    }

    /**
     * @param string|null $atdiastrabalho
     */
    public function setAtDiasTrabalho(?Employee $employee): void
    {
        $this->atDiasTrabalho = $employee;
    }

    public function getDiasTrabalho(): string
    {
        return $this->diasTrabalho;
    }
    public function setDiasTrabalho(string $dias): void
    {
        $this->diasTrabalho = $dias;
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
     * @return string|null
     */
    public function getAtativo(): ?string
    {
        return $this->atativo;
    }

    /**
     * @param string|null $atativo
     */
    public function setAtativo(?string $atativo): void
    {
        $this->atativo = $atativo;
    }

    //}
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
