<?php 

namespace App\Services\OrdersReports;

use App\Models\{
    Branch, Order
};


class Takeaway 
{
    public function index($request)
    {
        $index = 1;
        $branches = Branch::get();

        $orders = ($request->branch_id && ($request->start_at && $request->end_at)) ?
        Order::whereHas('complaints')->where('branch_id' , $request->branch_id)
            ->where('order_type_id',2)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get()

        : (($request->branch_id) ?
        Order::whereHas('complaints')->where('branch_id' , $request->branch_id)
            ->where('order_type_id',2)
            ->get() 
        : (($request->start_at && $request->end_at) ?
         Order::whereHas('complaints')
            ->where('order_type_id',2)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get() : Order::whereHas('complaints')->where('order_type_id',2)->get()
             ));


        return view('reports.delivary', compact('index', 'branches', 'orders'));
    }
}