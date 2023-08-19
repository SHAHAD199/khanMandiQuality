<?php 

namespace App\Services\Discounts;

use App\Models\{
    Branch, Order, Customer,Discount
};

use Carbon\Carbon;

class GetDiscountService 
{
    public function index( $request)
    {
        $index = 1;        
        if($request->phone){
        $discounts = Discount::whereHas('customer', function($q) use($request) 
        {
        $q->where('phone', $request->phone);
        })->get();
        return view('index' , compact('index', 'discounts'));      
        }
        else {
            return view('index');
        }
    }

    public function birthday()
    {
        $index = 1;
        $customers = Customer::where('birthday', Carbon::today())->get();
        return view('discounts.birthday', compact('index', 'customers'));
    }


    public function waiting_list($request)
    {
        $auth_branch = auth()->user()->branch_id;      
        $index = 1;
        $branches = Branch::get();
        $discount_value = [10,15,20,25,50,100];

        // if(isset($auth_branch) && $auth_branch == null)
        // {}
        $orders = ($request->branch_id && ($request->start_at && $request->end_at))
         ?  Order::where('branch_id', $request->branch_id)
         ->where('status',1)
         ->whereBetween('order_date', [$request->start_at, $request->end_at])
         ->whereHas('complaints')->get()

         : (($request->branch_id) 
         ? Order::where('branch_id', $request->branch_id)
         ->where('status',1)
         ->whereHas('complaints')->get()
         : (($request->start_at && $request->end_at)

         ? Order::whereBetween('order_date', [$request->start_at, $request->end_at])
         ->where('status',1)
         ->whereHas('complaints')->get()
         :(($auth_branch != null) ? Order::where('branch_id' , $auth_branch)->whereHas('complaints') ->get()
         : Order::whereHas('complaints') ->get()
         )));
 
        return view('discounts/waiting', compact('branches', 'index', 'orders', 'discount_value'));
    }
}