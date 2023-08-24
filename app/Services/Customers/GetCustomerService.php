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
     : (($request->birthday) ? Customer::where('birthday', $request->birthday)->where('birthday_status', 0)->get() 
     : (($request->phone) ? Customer::where('phone', $request->phone)->get()
     : Customer::get()
     )));

     if($request->birthday){
       return view('customers.index', compact('index', 'customers'))->with('birthday', $request->birthday);
     }else {
       return  view('customers.index', compact('index', 'customers'));
     }
   
  
    }


    public function show(Customer $customer)
    {
        $index = 1;
         return view('customers.details' , compact('index', 'customer'));
    }
}