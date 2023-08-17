<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\OrderType;
use Illuminate\Http\Request;

class EmployeeReportController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::get();
        $orderTypes = OrderType::get();
        $index = 1;
        return view('reports.employees', compact('index', 'branches','orderTypes'));
    }
}
