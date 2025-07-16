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

        //$employee->setAtivo($ativo);
        $decimoterceiroValue = filter_var($request->request->get('decimoterceiro'), FILTER_VALIDATE_BOOLEAN);
        $acidentadoValue = filter_var($request->request->get('acidentado'), FILTER_VALIDATE_BOOLEAN);
        $feriasValue=filter_var($request->request->get('ferias'),FILTER_VALIDATE_BOOLEAN);
        $ativoValue=filter_var($request->request->get('ativo'),FILTER_VALIDATE_BOOLEAN);
        // Pega o valor enviado (string)
        $dayworkRaw = $request->request->get('daywork');     // ex.: "15"

        if (is_numeric($dayworkRaw) && $dayworkRaw >= 1 && $dayworkRaw <= 30) {

            $ativoDias = new Ativoemp();
            $ativoDias->setDiasTrabalho((string) $dayworkRaw); // Sempre salva como string, como você quer

            $employee->setDaywork($ativoDias);

        } else {
            // Se não for válido, ainda assim cria para evitar NULL no banco
            $ativoDias = new Ativoemp();
            $ativoDias->setDiasTrabalho('0'); // valor padrão de segurança (ou pode lançar erro se preferir)

            $employee->setDaywork($ativoDias);
        }
        if ($ativoValue){
            $ativoEmp=new Ativoemp();
            $employee->setFerias($ativoEmp);
        }
        if ($feriasValue){
            $ativoFerias=new Ativoemp();
            $employee->setFerias($ativoFerias);
        }
        if ($acidentadoValue) {
            $ativoAcidentado = new Ativoemp();
            $employee->setAcidentado($ativoAcidentado);
        }

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

                    // Associa corretamente pelo método da entidade
                    $employee->addNumerosocial($numerosocial);
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
