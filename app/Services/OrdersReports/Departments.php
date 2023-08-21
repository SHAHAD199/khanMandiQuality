<?php 

namespace App\Services\OrdersReports;

use App\Models\{
    Branch, Order, Department
};


class Departments
{
    public function index($request)
    {
        $index = 1;
        $branches = Branch::get();
        $departments = Department::get();

        $orders = ($request->branch_id && ($request->start_at && $request->end_at) && $request->department_id)
        ? Order::whereHas('complaints', function($q) use($request){
            $q->where('department_id', $request->department_id);
            })->where('branch_id' , $request->branch_id)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get()

        : (($request->branch_id && $request->department_id)
        ? Order::whereHas('complaints',function($q) use($request){
             $q->where('department_id', $request->department_id);
        })->where('branch_id' , $request->branch_id)->get()
        
        : (($request->department_id &&($request->start_at && $request->end_at))
        ?  Order::whereHas('complaints',function($q) use($request){
            $q->where('department_id', $request->department_id);
        })
        ->whereBetween('order_date', [$request->start_at, $request->end_at])
        ->get()
        : (($request->department_id)
        ? Order::whereHas('complaints',function($q) use($request){
            $q->where('department_id', $request->department_id);
        })->get()
        : (($request->branch_id)
        ? Order::whereHas('complaints')->where('branch_id' , $request->branch_id)->get()

        : Order::whereHas('complaints')->get()

    ))));

        return view('reports.departments', compact('index', 'branches', 'orders', 'departments'));
    }
}