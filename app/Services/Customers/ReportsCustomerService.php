<?php 

namespace App\Services\Customers;

use App\Models\Branch;
use App\Models\Order;
use App\Services\Whatsapp;
use Carbon\Carbon;

class ReportsCustomerService 
{
    public static function index($request)
    {

        $index = 1;
        $branches = Branch::get();


        $orders = (($request->start_at && $request->end_at) && $request->branch_id)
        ?  Order::whereBetween('order_date', [$request->start_at, $request->end_at])
          ->where('branch_id', $request->branch_id)->get()

        :(($request->start_at && $request->end_at) 
        ?  Order::whereBetween('order_date', [$request->start_at, $request->end_at])->get()

        : (($request->branch_id)
        ? Order::where('branch_id', $request->branch_id)->get()

        : ((!is_null($request->response))
        ? Order::where('response', '=', $request->response)->where('send_status',0)->get()

        : Order::where('order_date', Carbon::yesterday())->get()
       
      )));
        
        return view('reports.calls', compact('index', 'branches', 'orders'));
    }


    public static function send_calls_messege($order,$request)
    {
      $body = '
      مرحبا بكم في سلسلة مطاعم خان مندي
تم الاتصال بكم من قبل قسم الجودة لتقييم طلبكم الاخير 

يرجي تقييم التجربة من خلال الرابط 
...............

نتمنى لكم يوم سعيد 
#عيش التجربة اليمنية

';
$order->update(['send_status' => 1]);
Whatsapp::send($request->phone, $body);
  return back();
    }
}