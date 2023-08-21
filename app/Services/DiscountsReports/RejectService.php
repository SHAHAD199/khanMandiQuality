<?php 

namespace App\Services\DiscountsReports;

use App\Models\{
  Branch, Customer, Discount,
    Order
};


class RejectService
{
    public function reject_discounts( $request)
    {
        $index  = 1;
        $branches = Branch::get();

        $orders = ($request->branch_id && ($request->start_at && $request->end_at)) ?
        Order::where('status', 3)->whereBetween('order_date', [$request->start_at, $request->end_at])
        ->where('branch_id', $request->branch_id)->get()
        : (($request->branch_id) ? 

        Order::where('status', 3)->where('branch_id', $request->branch_id)->get()
        : (($request->start_at && $request->end_at) ?

        Order::where('status', 3)->whereBetween('order_date', [$request->start_at, $request->end_at])->get()
        : (($request->phone) ?

        Order::where('status', 3)->where('customer_id', Customer::where('phone', $request->phone)->first()->id )->get()
        : Order::where('status', 3)->get()
            )));

         return view('reports.reject_discounts', compact('index', 'branches','orders'));
    }

}