<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Services\Whatsapp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    private $whatsapp;
    public function __construct(Whatsapp $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }
    public function birthday()
    {
        $index = 1;
        $customers = Customer::where('birthday', Carbon::today())->get();
        return view('discounts.birthday', compact('index', 'customers'));
    }

    public function send_birthday_sms(Request $request)
    {
       Discount::create([
        'customer_id' => $request->customer_id,
        'value'       => 30,
        'status'      => 2
       ]);
       $body = 'shahad test' ;
       $this->whatsapp->send($request->phone, $body);
       return back();

    }

    public function index(Request $request)
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

    public function waiting_list(Request $request)
    {
        $index = 1;
        $branches = Branch::get();
        $discount_value = [10,15,20,25,50,100];

        if($request->branch_id && ($request->start_at && $request->end_at)){
            $orders = Order::where('branch_id', $request->branch_id)
            ->where('status',1)
            ->whereBetween('order_date', [$request->start_at, $request->end_at])
            ->whereHas('complaints')->get();
        }else if($request->branch_id)
        {
            $orders = Order::where('branch_id', $request->branch_id)
            ->where('status',1)
            ->whereHas('complaints')->get(); 
        }else if($request->start_at && $request->end_at){
            $orders = Order::whereBetween('order_date', [$request->start_at, $request->end_at])
            ->where('status',1)
            ->whereHas('complaints')->get();
        }else {
            $orders = Order::whereHas('complaints')
            ->where('status',1)
            ->get();
        }
        
        return view('discounts/waiting', compact('branches', 'index', 'orders', 'discount_value'));
    }
    public function use_discount(Discount $discount)
    {
       $discount->update([
           'status'    => 4,
           'date_use'  => now()->format('Y-m-d')
       ]);
    }


}
