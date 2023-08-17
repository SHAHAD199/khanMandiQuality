<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
     $index =1;
     if($request->start_at && $request->end_at)
     {
        $customers = Customer::whereHas('orders', function($q) use($request)
        {
           $q->whereBetween('order_date', [$request->start_at, $request->end_at]);
        })->get();
     }elseif($request->gender){
        $customers = Customer::where('gender', $request->gender)->get();
     }elseif($request->birthday){
        $customers = Customer::where('birthday', $request->birthday)->get();
     }
     else {
        $customers = Customer::get();
     }
      return view('reports.customers', compact('index', 'customers'));
    }


    public function show(Customer $customer)
    {
      
    }
}
