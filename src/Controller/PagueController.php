<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagueController extends AbstractController
{
    public function __construct(private EmployeeRepository $employeeRepository)
    {

    }
    #[Route('/pague', name: 'app_pague', methods: ['GET'])]
    public function employeeList():Response
    {
        $employeeList=$this->employeeRepository->findAll();
        return $this->render('pague/index.html.twig',[
            'employeeList'=>$employeeList,
        ]);
    }

    #[Route('/pague/create', methods: ['GET'])]
    public function addEmployeeForm():Response
    {
        return $this->render('pague/form.html.twig');
    }

    #[Route('/pague/create',methods: ['POST'])]
    public function addEmployee(Request $request):Response
    {
        $employeeName=$request->request->get('name');
        $employee=new Employee($employeeName);

        $this->employeeRepository->add($employee,true);
        return new RedirectResponse('/pague');
    }
}
