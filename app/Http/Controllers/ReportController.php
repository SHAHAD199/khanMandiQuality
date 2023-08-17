<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportController extends Controller
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




    public function approval_discounts(Request $request)
    {
        $index  = 1;
        $branches = Branch::get();
        if($request->branch_id && ($request->start_at && $request->end_at))
        {
           $discounts = Discount::where('status', 2)
           ->whereHas('order', function($q) use($request){
             $q->whereBetween('order_date', [$request->start_at, $request->end_at])
             ->where('branch_id', $request->branch_id);
           })->get();
        }
        else if($request->branch_id){
            $discounts = Discount::where('status', 2)
            ->whereHas('order', function($q) use($request){
              $q->where('branch_id', $request->branch_id);
            })->get();
        }
        else if($request->start_at && $request->end_at){
            $discounts = Discount::where('status', 2)
            ->whereHas('order', function($q) use($request){
                $q->whereBetween('order_date', [$request->start_at, $request->end_at]);
            })->get();
        }
        else if($request->phone){
            $discounts = Discount::where('status', 2)
            ->whereHas('order', function($q) use($request){
                $q->where('customer_id', Customer::where('phone', $request->phone)->first()->id );
            })->get(); 
        }
        else {
            $discounts = Discount::where('status', 2)->get();
        }
        return view('reports.approval_discounts', compact('index', 'branches','discounts'));
    }



    public function reject_discounts(Request $request)
    {
        $index  = 1;
        $branches = Branch::get();

        if($request->branch_id && ($request->start_at && $request->end_at))
        {
           $discounts = Discount::where('status', 3)
           ->whereHas('order', function($q) use($request){
             $q->whereBetween('order_date', [$request->start_at, $request->end_at])
             ->where('branch_id', $request->branch_id);
           })->get();
        }
        else if($request->branch_id){
            $discounts = Discount::where('status', 3)
            ->whereHas('order', function($q) use($request){
              $q->where('branch_id', $request->branch_id);
            })->get();
        }
        else if($request->start_at && $request->end_at){
            $discounts = Discount::where('status', 3)
            ->whereHas('order', function($q) use($request){
                $q->whereBetween('order_date', [$request->start_at, $request->end_at]);
            })->get();
        }
        else if($request->phone){
            $discounts = Discount::where('status', 3)
            ->whereHas('order', function($q) use($request){
                $q->where('customer_id', Customer::where('phone', $request->phone)->first()->id );
            })->get(); 
        }
        else {
            $discounts = Discount::where('status', 3)->get();
        }
        return view('reports.reject_discounts', compact('index', 'branches','discounts'));
    }



    public function used_discounts(Request $request)
    {
         $index  = 1;
        $branches = Branch::get();
        if($request->branch_id && ($request->start_at && $request->end_at))
        {
           $discounts = Discount::where('status', 4)
           ->whereHas('order', function($q) use($request){
             $q->whereBetween('order_date', [$request->start_at, $request->end_at])
             ->where('branch_id', $request->branch_id);
           })->get();
        }
        else if($request->branch_id){
            $discounts = Discount::where('status', 4)
            ->whereHas('order', function($q) use($request){
              $q->where('branch_id', $request->branch_id);
            })->get();
        }
        else if($request->start_at && $request->end_at){
            $discounts = Discount::where('status', 4)
            ->whereHas('order', function($q) use($request){
                $q->whereBetween('order_date', [$request->start_at, $request->end_at]);
            })->get();
        }
        else if($request->phone){
            $discounts = Discount::where('status', 4)
            ->whereHas('order', function($q) use($request){
                $q->where('customer_id', Customer::where('phone', $request->phone)->first()->id );
            })->get(); 
        }
        else {
            $discounts = Discount::where('status', 4)->get();
        }
        return view('reports.used_discounts', compact('index', 'branches','discounts'));
    }


   
}
