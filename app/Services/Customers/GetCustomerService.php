<?php 

namespace App\Services\Customers;

use App\Models\Customer;

class GetCustomerService 
{
    public function index($request)
    {
     $index =1;

     $customers = ($request->start_at && $request->end_at) 
     ?  Customer::whereHas('orders', function($q) use($request){
        $q->whereBetween('order_date', [$request->start_at, $request->end_at]);
     })->orWhereHas('discounts')->get()
     : (($request->gender) ? Customer::where('gender', $request->gender)->get()
     : (($request->birthday) ? Customer::where('birthday', $request->birthday)->get() 
     : Customer::with('orders')->with('discounts')->get()
    ));

    
      return view('reports.customers', compact('index', 'customers'));
    }
}