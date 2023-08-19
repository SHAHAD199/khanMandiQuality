<?php 

namespace App\Services\EmployeesReports;

use App\Models\{
    Branch, MissedCall, OrderType
};


class GetEmployeeReportService 
{
    public static function  index($request)
    {
        $missed_calls = ($request->start_at && $request->end_at) ? MissedCall::whereBetween(date('datetime'), [$request->start_at, $request->end_at])->get()
        : $missed_calls = MissedCall::get();
        $index = 1;
        return view('employees.index', compact('missed_calls', 'index'));
    }
    public static function calls_parcent( $request)
    {
        $branches = Branch::get();
        $orderTypes = OrderType::get();
        $index = 1;
        return view('reports.employees', compact('index', 'branches','orderTypes'));
    }

    public static function create()
    {
        return view('employees.add');
    }
}