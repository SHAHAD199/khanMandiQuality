<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\OrderType;
use App\Services\EmployeesReports\GetEmployeeReportService;
use Illuminate\Http\Request;

class EmployeeReportController extends Controller
{
    private $getEmployeeReportService;
    public function __construct(GetEmployeeReportService $getEmployeeReportService)
    {
        $this->getEmployeeReportService = $getEmployeeReportService;
    }
    public function index(Request $request)
    {
      return $this->getEmployeeReportService->index($request);
    }
}
