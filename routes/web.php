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


Route::get('create_pdf', function(Request $request){
    $index = 1;
   

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
     
      $pdf = new \Mpdf\Mpdf();
      $pdf->showImageErrors = true; 
  
      $html ='
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>';
$html.='
<body dir="rtl">
<table class="table table-bordered text-center">
    <thead>
         <th>تسلسل</th>
         <th>الرقم</th>
         <th>التاريخ</th>
         <th>الفرع</th>
         <th>نوع الطلب</th>
         <th>الملاحظات او الشكاوى</th>     
         <th>الحالة</th>
    </thead>';


    foreach($orders as $order) :
          $html.='<tbody>
               <td>'. $index .'</td>
               <td>'. $order->customer->phone .'</td>
               <td>'. $order->order_date .'</td>
               <td>'. $order->branch->name .'</td>
               <td>'. $order->orderType->name .'</td>
               <td>';

          if($order->note) : $order->note->note ;
          elseif($order->complaints) :
          $html.='<table class="table table-bordered text-center">
               <thead>
                <th>القسم</th>
                <th>الطبق</th>
                <th>الشكوى</th>
               </thead>';
              
                 foreach($order->complaints as $complaint) :
                $html.= '<tbody>
                 <td>'. $complaint->department->name . '</td>
                 <td>'. $complaint->metarial .'</td>
                 <td>' . $complaint->complaint .'</td>
                 </tbody>';
                 endforeach;
             
           $html.='</table>';
                endif;
          $html.='</td>  <td>';
        if($order->status == 1) :      $html.='في قائمة الانتظار';
        elseif($order->status == 2) :  $html.='خصم مقبول';
        elseif($order->status == 3) :  $html.=' خصم مرفوض';
        elseif($order->status == 4) :  $html.='خصم مستخدم';
        elseif($order->status == 0) :  $html.='لا يوجد خصم';
        endif;
        $html.='</td>
        </tbody>';
      endforeach;

      $html.='</table> </body> ';
      $pdf->WriteHTML($html);
      $pdf->Output('shahad'. '.' .'pdf' , 'D');

    });