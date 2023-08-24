<?php

use App\Exports\FormExport;
use App\Http\Controllers\{
    CustomerController,
    DiscountController,
    DiscountReportsController,
    EmployeeReportController,
    ExcelController,
    OrderController,
    OrdersReportsController,    
    RoleController,
    UserController,
};
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
 

Route::controller(DiscountController::class)->group(function(){
    Route::get('/', 'index');  
    Route::get('birthday','birthday');
    Route::post('send_birthday_sms', 'send_birthday_sms');
    Route::post('discounts/use_discount', 'use_discount');
    Route::get('waiting_list','waiting_list');
    Route::get('use_discount/{discount}', 'use_discount');
});

Route::controller(ExcelController::class)->group(function(){
    Route::get('excel/add', 'create');
    Route::post('excel/store', 'store');
});


Route::controller(OrderController::class)->group(function(){
    Route::get('orders' , 'index');
    Route::get('notes','notes');
    Route::get('orders/create/{order}','create');
    Route::post('orders/store/{order}','update');
    Route::post('orders/approval/{order}','approval');
    Route::post('orders/reject/{order}', 'reject');
});


Route::controller(OrdersReportsController::class)->group(function(){
    Route::get('delivary','delivary');
    Route::get('takeaway','takeaway');
    Route::get('departments','departments');
    Route::get('reports/orders', 'index');
});

Route::controller(DiscountReportsController::class)->group(function(){
    Route::get('approval_discounts','approval_discounts');
    Route::get('reject_discounts', 'reject_discounts');
    Route::get('used_discounts', 'used_discounts');  
});

Route::controller(CustomerController::class)->group(function(){
    Route::get('customers','index');
    Route::get('customers/{customer}', 'show');
    Route::get('calls', 'calls');
    Route::post('send_calls_messege/{order}', 'send_calls_messege');
});

Route::controller(EmployeeReportController::class)->group(function(){
    Route::get('employees', 'index');
    Route::get('employees/create', 'create');
    Route::post('employees/store', 'store');
    Route::get('calls_parcent', 'calls_parcent');
});

Route::controller(UserController::class)->group(function(){
    Route::get('users', 'index');
    Route::get('users/create', 'create');
    Route::post('users/store', 'store');
    Route::get('users/edit/{user}', 'edit');
    Route::post('users/update/{user}', 'update');
    Route::post('users/delete/{user}', 'delete');
});


Route::controller(RoleController::class)->group(function(){
    Route::get('roles','index');
    Route::get('roles/create','create');
    Route::post('roles/store','store');
    Route::get('roles/edit/{role}','edit');
    Route::post('roles/update/{role}','update');
    Route::post('roles/delete/{role}','delete');
});
});


Route::get('export_forms',  function (Request $request){
  return Excel::download(new FormExport, 'forms.xlsx');
});


Route::get('create_pdf', function (Request $request){

  $orders = ($request->branch_id && ($request->start_at && $request->end_at))
    ?  Order::whereHas('complaints' , function($q) use($request) {
      $q->whereBetween('order_date',[$request->start_at, $request->end_at])->where('branch_id', $request->branch_id);
    })->orWhereHas('note', function($q) use($request) {
      $q->whereBetween('order_date',[$request->start_at, $request->end_at])->where('branch_id', $request->branch_id);
    })->get() 
      
    : (($request->branch_id)
    ? Order::whereHas('complaints' , function($q) use($request) {
      $q->where('branch_id', $request->branch_id);
    })->orWhereHas('note', function($q) use($request) {
      $q->where('branch_id', $request->branch_id);
    })->get()
  
      
    : (($request->start_at && $request->end_at)
    ? Order::whereHas('complaints' , function($q) use($request) {
      $q->whereBetween('order_date',[$request->start_at, $request->end_at]);
    })->orWhereHas('note', function($q) use($request) {
      $q->whereBetween('order_date',[$request->start_at, $request->end_at]);
    })->get() 
      
    : Order::whereHas('complaints')->orWhereHas('note')->get()
      ));
         
           $index = 1;
           $pdf = new \Mpdf\Mpdf(['mode' => 'UTF-8', 'format' => 'A4-P' , 'autoScriptToLang' => true , 'autoLangToFont' => true]);
           $pdf->showImageErrors = true;
          
          
           $html ='
           <head>
           <style>      
               
           </style>
           </head>';
           $html.='
           <body dir="rtl">';

            $html.='<div>
                            <table style="width: 100%;margin-bottom: 1rem;; border:1px solid #eee; "

                            id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">#</th>
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">الرقم</th>
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">التاريخ</th>
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">الفرع</th>
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">نوع الطلب</th>
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">الملاحظات او الشكاوى</th>     
                                    <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;">الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                  foreach($orders as $order):
                                    $html.='<tr style="border:1px solid #000">
                                        <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $index++ .'</td>                                       
                                        <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $order->customer->phone.'</td>';  
                                        $html.='<td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $order->order_date.'</td>';                                    
                                        $html.='<td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $order->branch->name.'</td>';                                     
                                        $html.='<td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $order->orderType->name.'</td>';
                                        $html.='<td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">';
                                        if($order->note) : $order->note->note ;
                                        elseif($order->complaints) :
                                        $html.='<table class="table table-bordered text-center">
                                             <thead>
                                              <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">القسم</th>
                                              <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">الطبق</th>
                                              <th style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">الشكوى</th>
                                             </thead>';
                                            
                                               foreach($order->complaints as $complaint) :
                                              $html.= '<tbody>
                                               <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $complaint->department->name . '</td>
                                               <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">'. $complaint->metarial .'</td>
                                               <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">' . $complaint->complaint .'</td>
                                               </tbody>';
                                               endforeach;
                                           
                                         $html.='</table>';
                                        endif;
                                        $html.='</td>'; 
                                        $html.='<td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;">';
                                        if($order->status == 1) :      $html.='في قائمة الانتظار';
                                        elseif($order->status == 2) :  $html.='خصم مقبول';
                                        elseif($order->status == 3) :  $html.=' خصم مرفوض';
                                        elseif($order->status == 4) :  $html.='خصم مستخدم';
                                        elseif($order->status == 0) :  $html.='لا يوجد خصم';
                                        endif;
                                        $html.='</td>';             
                                    $html.='</tr>';
                                  endforeach;
                                                              
                            $html.='</tbody>
                            </table>
                
     </div>
    </body>
           ';
           $pdf->WriteHTML($html);
           $pdf->Output('orders'.time(). '.' .'pdf' , 'D');
});










   