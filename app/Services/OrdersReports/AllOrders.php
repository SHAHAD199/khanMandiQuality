<?php 

namespace App\Services\OrdersReports;

use App\Models\{
    Branch, Complaint, Department, Order
};
use App\Services\Orders\PdfOrderService;

class AllOrders 
{
    public function index($request)
    {
 
        $index = 1;
        $branches = Branch::get();
        $departments = Department::get();

           
          $start_at = $request->start_at;
          $end_at = $request->end_at;
          $branch_id = $request->branch_id;


      switch([$start_at, $end_at,$branch_id]){
         case isset($start_at) && isset($end_at) && isset($branch_id)  : 
          
          $orders =  Order::whereHas('complaints' , function($q) use($start_at, $end_at, $branch_id) {
            $q->whereBetween('order_date',[$start_at, $end_at])->where('branch_id', $branch_id);
          })->orWhereHas('note', function($q) use($start_at, $end_at, $branch_id) {
            $q->whereBetween('order_date',[$start_at, $end_at])->where('branch_id', $branch_id);
          })->get();

         $complaints = Complaint::whereHas('order', function($q) use($start_at, $end_at, $branch_id){
            $q->whereBetween('order_date', [$start_at, $end_at])->where('branch_id', $branch_id);
          })->get();
          break;

          case($start_at && $end_at) :
            $orders =  Order::whereHas('complaints' , function($q) use($start_at, $end_at, $branch_id) {
              $q->whereBetween('order_date',[$start_at, $end_at]);
            })->orWhereHas('note', function($q) use($start_at,$end_at) {
              $q->whereBetween('order_date',[$start_at, $end_at]);
            })->get();

            $complaints  = Complaint::whereHas('order', function($q) use($start_at,$end_at){
              $q->whereBetween('order_date', [$start_at, $end_at]);
            })->get();

           break;
          case($branch_id) :
            Order::whereHas('complaints' , function($q) use($branch_id) {
              $q->where('branch_id', $branch_id);
            })->orWhereHas('note', function($q) use($branch_id) {
              $q->where('branch_id', $branch_id);
            })->get();

            $complaints = Complaint::whereHas('order', function($q) use($branch_id){
              $q->where('branch_id', $branch_id);
            })->get();
            break;

            default :
            $orders = Order::whereHas('complaints')->orWhereHas('note')->get();
            $complaints = Complaint::get();
       
        }


        if($request->input('action') == 'orders') {
          return view('reports.all_orders', compact('index', 'branches', 'orders' , 'start_at', 'end_at','branch_id','complaints','departments'));
        }else if($request->input('action') == 'pdf'){
          PdfOrderService::create_content($orders ,$complaints);
        }
        else {
          return view('reports.all_orders', compact('index', 'branches', 'orders' , 'start_at', 'end_at','branch_id','complaints','departments'));
        }

       
    }
}