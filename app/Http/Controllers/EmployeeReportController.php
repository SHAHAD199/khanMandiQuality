<?php

namespace App\Http\Controllers;


use App\Services\EmployeesReports\GetEmployeeReportService;
use App\Services\EmployeesReports\PostEmployeeReportService;
use Illuminate\Http\Request;

class EmployeeReportController extends Controller
{
    private $getEmployeeReportService;
    private $posttEmployeeReportService;

    public function __construct(GetEmployeeReportService $getEmployeeReportService, PostEmployeeReportService $posttEmployeeReportService)
    {
        $this->getEmployeeReportService = $getEmployeeReportService;
        $this->posttEmployeeReportService = $posttEmployeeReportService;
    }

    public function index(Request $request)
    {
      return $this->getEmployeeReportService->index($request);
    }
    public function calls_parcent(Request $request)
    {
      return $this->getEmployeeReportService->calls_parcent($request);
    }

    public function create()
    {
      return $this->getEmployeeReportService->create();
    }

    public function store(Request $request)
    {
      return $this->posttEmployeeReportService->store($request);
    }
}
