<?php

namespace App\Http\Controllers;

use App\Services\OrdersReports\{
    Delivary, Departments, Takeaway
};

use Illuminate\Http\Request;

class OrdersReportsController extends Controller
{
    private $delivary;
    private $takeaway;
    private $departments;

    public function __construct(Delivary $delivary, Takeaway $takeaway, Departments $departments)
    {
        $this->delivary    = $delivary;
        $this->takeaway    = $takeaway;
        $this->departments = $departments;
    }
    public function delivary(Request $request)
    {
        return $this->delivary->index($request);     
    }

    public function takeaway(Request $request)
    {
        return $this->takeaway->index($request);
    }
    public function departments(Request $request)
    {
        return $this->departments->index($request);
    }
}
