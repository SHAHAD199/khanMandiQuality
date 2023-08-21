<?php 

namespace App\Services\Orders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Order;
use App\Models\OrderType;

class GetOrderService
{

    public static function index($request)
    {
        extract($request->all());
        $orders =  (!empty($phone)) ? Order::where('add_status', 0)->whereHas('customer', function($q) use ($phone){
            $q->where('phone', $phone);
         })->get()  :  Order::where('add_status', 0)->get();
        $index = 1;
        return view('orders.index' , compact('orders','index'));
    }


    public static function create($order)
    {
        $departments = Department::get();
        $branches = Branch::get();
        $ordertypes = OrderType::get();
        return view('orders.add', compact('order','departments', 'branches', 'ordertypes'));
    }

    public static function notes($request)
    {
        $auth_branch = auth()->user()->branch_id;      
        $index = 1;
        $branches = Branch::get();
       
      
        $orders = ($request->branch_id && ($request->start_at && $request->end_at))
         ?  Order::where('branch_id', $request->branch_id)
         ->where('status',0)
         ->whereBetween('order_date', [$request->start_at, $request->end_at])
         ->whereHas('note')->get()

         : (($request->branch_id) 
         ? Order::where('branch_id', $request->branch_id)
         ->where('status',0)
         ->whereHas('note')->get()
         : (($request->start_at && $request->end_at)

         ? Order::whereBetween('order_date', [$request->start_at, $request->end_at])
         ->where('status',0)
         ->whereHas('note')->get()
         :(($auth_branch != null)

         ? Order::where('branch_id' , $auth_branch)->where('status', 0) ->get()
         : Order::where('status',0)->whereHas('note')->get()
         )));
 
        return view('orders/notes', compact('branches', 'index', 'orders'));
    }
}