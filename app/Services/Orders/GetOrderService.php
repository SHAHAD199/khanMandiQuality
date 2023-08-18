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
}