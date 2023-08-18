<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersReportsController extends Controller
{
    public function delivary(Request $request)
    {
 
        $index = 1;
        $branches = Branch::get();
        if($request->branch_id && ($request->start_at && $request->end_at))
        {
          $orders = Order::whereHas('complaint')->where('branch_id' , $request->branch_id)
          ->where('order_type_id',1)
          ->whereBetween('order_date', [$request->start_at, $request->end_at])
          ->get();
        } else if($request->branch_id)
        {
            $orders = Order::whereHas('complaint')->where('branch_id' , $request->branch_id)
            ->where('order_type_id',1)
            ->get();
        }else if($request->start_at && $request->end_at){
            $orders = Order::whereHas('complaint')
            ->where('order_type_id',1)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get();  
        }
        else {
            $orders = Order::whereHas('complaint')->where('order_type_id',1)->get();  
        }
        return view('reports.delivary', compact('index', 'branches', 'orders'));
    }

    public function takeaway(Request $request)
    {
        $index = 1;
        $branches = Branch::get();
        if($request->branch_id && ($request->start_at && $request->end_at))
        {
          $orders = Order::whereHas('complaint')->where('branch_id' , $request->branch_id)
          ->where('order_type_id',2)
          ->whereBetween('order_date', [$request->start_at, $request->end_at])
          ->get();
        } else if($request->branch_id)
        {
            $orders = Order::whereHas('complaint')->where('branch_id' , $request->branch_id)
            ->where('order_type_id',2)
            ->get();
        }else if($request->start_at && $request->end_at){
            $orders = Order::whereHas('complaint')
            ->where('order_type_id',2)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get();  
        }
        else {
            $orders = Order::whereHas('complaint')->where('order_type_id',2)->get();  
        }
        return view('reports.delivary', compact('index', 'branches', 'orders'));
    }
    public function departments(Request $request)
    {
        $index = 1;
        $branches = Branch::get();
        $departments = Department::get();

        if($request->branch_id && ($request->start_at && $request->end_at) && $request->department_id)
        {
          $orders = Order::whereHas('complaint', function($q) use($request){
            $q->where('department_id', $request->department_id);
          })->where('branch_id' , $request->branch_id)
          ->whereBetween('order_date', [$request->start_at, $request->end_at])
          ->get();
        } else if($request->branch_id && $request->department_id)
        {
            $orders = Order::whereHas('complaint',function($q) use($request){
                $q->where('department_id', $request->department_id);
            })->where('branch_id' , $request->branch_id)         
            ->get();
        }else if($request->department_id &&($request->start_at && $request->end_at)){
            $orders = Order::whereHas('complaint',function($q) use($request){
                $q->where('department_id', $request->department_id);
            })
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get();  
        }
        else if($request->branch_id &&($request->start_at && $request->end_at)){
            $orders = Order::whereHas('complaint')
            ->where('branch_id', $request->branch_id)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->get();  
        }else if($request->department_id){
            $orders = Order::whereHas('complaint',function($q) use($request){
                $q->where('department_id', $request->department_id);
            })
            ->get();
        }else if($request->branch_id){
            $orders = Order::whereHas('complaint')->where('branch_id' , $request->branch_id)->get();
        }
        else {
            $orders = Order::whereHas('complaint')->get();  
        }
        return view('reports.departments', compact('index', 'branches', 'orders', 'departments'));
    }
}
