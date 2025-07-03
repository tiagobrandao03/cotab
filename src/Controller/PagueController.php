<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Numerosocial;
use App\Repository\EmployeeRepository;
use App\Repository\NumerosocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagueController extends AbstractController
{

    public function __construct(
        private EmployeeRepository $employeeRepository,
        private NumerosocialRepository $numerosocialRepository,

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
        $faltas = $request->request->get('faltas');

        // Criar Employee
        $employee = new Employee($name);
        $employee->setCpf($cpf);

        // Criação dos objetos Ativoemp separados para cada campo
        $objDecimo = new Ativoemp();
        $objDecimo->setATDecimoterceiro($decimoterceiro);
        $employee->setDecimoterceiro($objDecimo);

        $objFerias = new Ativoemp();
        $objFerias->setATFerias($ferias);
        $employee->setFerias($objFerias);

        $objAcidentado = new Ativoemp();
        $objAcidentado->setATAcidentado($acidentado);
        $employee->setAcidentado($objAcidentado);

        $objFaltasJust = new Ativoemp();
        $objFaltasJust->setFaltasemp($faltasJustificadas);
        $employee->setFaltasJustificadas($objFaltasJust);

        $objFaltasInjust = new Ativoemp();
        $objFaltasInjust->setFaltasemp($faltasInjustificadas);
        $employee->setFaltasInjustificadas($objFaltasInjust);

        $objDias = new Ativoemp();
        $objDias->setAtDiastrabalho($diasTrabalhados);
        $employee->setDaywork($objDias);

        $objAtivo = new Ativoemp();
        $objAtivo->setAtivoemp($ativo);
        $employee->setAtivo($objAtivo);


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
