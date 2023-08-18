<?php 

namespace App\Services\EmployeesReports;

use App\Models\Branch;
use App\Models\OrderType;

class GetEmployeeReportService 
{
    public static function index( $request)
    {
        $branches = Branch::get();
        $orderTypes = OrderType::get();
        $index = 1;
        return view('reports.employees', compact('index', 'branches','orderTypes'));
    }
}