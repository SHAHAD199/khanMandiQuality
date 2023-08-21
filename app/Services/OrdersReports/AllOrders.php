<?php 

namespace App\Services\OrdersReports;

use App\Models\{
    Branch, Order
};


class AllOrders 
{
    public function index($request)
    {
 
        $index = 1;
        $branches = Branch::get();

        $orders = ($request->branch_id && ($request->start_at && $request->end_at))
        ?  Order::whereHas('complaints' , function($q) use($request) {
          $q->whereBetween('order_date',[$request->start_at, $request->end_at])->where('branch_id', $request->branch_id);
        })->orWhereHas('note', function($q) use($request) {
          $q->whereBetween('order_date',[$request->start_at, $request->end_at])->where('branch_id', $request->branch_id);
        })->get() 
          
        : (($request->branch_id)
        ? Order::whereHas('complaints' , function($q) use($request) {
          $q->where('branch_id', $request->branch_id);
        })->orWhereHas('note', function($q) use($request) {
          $q->where('branch_id', $request->branch_id);
        })->get()
      
          
        : (($request->start_at && $request->end_at)
        ? Order::whereHas('complaints' , function($q) use($request) {
          $q->whereBetween('order_date',[$request->start_at, $request->end_at]);
        })->orWhereHas('note', function($q) use($request) {
          $q->whereBetween('order_date',[$request->start_at, $request->end_at]);
        })->get() 
          
        : Order::whereHas('complaints')->orWhereHas('note')->get()
          ));

        return view('reports.all_orders', compact('index', 'branches', 'orders'));
    }
}