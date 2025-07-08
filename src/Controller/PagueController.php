<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Numerosocial;
use App\Repository\AtivoempRepository;
use App\Repository\EmployeeRepository;
use App\Repository\NumerosocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ativoemp;

class PagueController extends AbstractController
{

    public function __construct(
        private EmployeeRepository $employeeRepository,
        private NumerosocialRepository $numerosocialRepository,
        private AtivoempRepository $ativoempRepository,


    ) {}
    #[Route('/pague', name: 'app_pague', methods: ['GET'])]
    public function employeeList():Response
    {
        $employeeList=$this->employeeRepository->findAll();
        return $this->render('pague/index.html.twig',[
            'employeeList'=>$employeeList,
        ]);
    }

    #[Route('/pague/create',name: 'app_pague_create', methods: ['GET'])]
    public function addEmployeeForm(Request $request): Response
    {
        // Define o número inicial de dependentes (pode vir da requisição)
        $dependentesCount = $request->query->get('dependentes', 1);
        $dependentesCount = max(1, min(10, (int)$dependentesCount)); // Limita entre 1 e 10

        return $this->render('pague/form.html.twig', [
            'dependentesCount' => $dependentesCount,
        ]);
    }

    #[Route('/pague/create',name: 'app_pague_store',methods: ['POST'])]
    #[Route('/pague/create',name: 'app_pague_store',methods: ['POST'])]
    public function addEmployee(Request $request):Response
    {
        // Dados do Employee
        $name = $request->request->get('name');
        $cpf = $request->request->get('cpf');

        $faltasJustificadas = $request->request->get('faltasjustificadas');
        $faltasInjustificadas =$request->request->get('faltasinjustificadas');
        $decimoterceiroValue=$request->request->get('decimoterceiro');
        $acidentado=$request->request->get('acidentado');
        $ferias=$request->request->get('ferias');
        $daywork=$request->request->get('daywork');
        $ativo=$request->request->get('ativo');


        // Criar Employee
        $employee = new Employee($name);
        $employee->setCpf($cpf);
        $employee->setFaltasJustificadas($faltasJustificadas);
        $employee->setFaltasInjustificadas($faltasInjustificadas);
        $employee->setDecimoterceiro($decimoterceiroValue);
        $employee->setAcidentado($acidentado);
        $employee->setFerias($ferias);
        $employee->setDaywork($daywork);
        $employee->setAtivo($ativo);

        // Criação dos objetos Ativoemp separados para cada campo
        if ($decimoterceiroValue) {
            $ativoDecimoTerceiro = new Ativoemp();
            // Configure os valores necessários no objeto Ativoemp
            $employee->setDecimoterceiro($ativoDecimoTerceiro);
        }


        // Verificar se tem dependentes
        if ($request->request->get('tem_dependentes')) {
            // Dados dos Numerosocial (filhos)
            $nomesFilhos = $request->request->all('nome_filho');
            $cpfsFilhos = $request->request->all('cpf_filho');

            // Adicionar Numerosocial (filhos) ao Employee
            foreach ($nomesFilhos as $index => $nomeFilho) {
                if (!empty($nomeFilho) && !empty($cpfsFilhos[$index])) {
                    $numerosocial = new Numerosocial();
                    $numerosocial->setNomeFilho($nomeFilho);
                    $numerosocial->setCpfFilho($cpfsFilhos[$index]);
                    $numerosocial->setEmployee($employee);

                    $this->numerosocialRepository->add($numerosocial, false);
                }
            }
        }


        $this->employeeRepository->add($employee, true);

        return $this->redirectToRoute('app_pague');
    }

    #[Route('/pague/create/add-dependente', name: 'app_pague_add_dependente')]
    public function addDependente(Request $request): Response
    {
        $current = $request->query->get('current', 1);
        return $this->redirectToRoute('app_pague_create', [
            'dependentes' => $current + 1
        ]);
    }

    #[Route('/pague/create/remove-dependente', name: 'app_pague_remove_dependente')]
    public function removeDependente(Request $request): Response
    {
        $current = $request->query->get('current', 1);
        return $this->redirectToRoute('app_pague_create', [
            'dependentes' => max(1, $current - 1)
        ]);
    }
}
