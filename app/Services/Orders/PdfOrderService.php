<?php 

namespace App\Services\Orders;

use App\Models\Complaint;
use App\Models\Department;

class PdfOrderService {

public static function create_content($orders,$complaints){
    $index = 1;
    $pdf = new \Mpdf\Mpdf(['mode' => 'UTF-8', 'format' => 'A4-P' , 'autoScriptToLang' => true , 'autoLangToFont' => true]);
    $pdf->showImageErrors = true;

   
    $html ='<head></head>';
    $html.='
    <body dir="rtl">';

     $html.='<div>

     <div style="text-align:center; margin-bottom:30px">
     <img src="./imgs/logo.jpg" alt="khan_mandi" style="width:120px;height:120px;">
     </div>
     
     <div style="width: 100%;float: right;">
     <h5 style="font-size: 16px; color: #792d30">سلسلة مطاعم خان مندي</h5>
     <h5 style="font-size: 16px; color: #792d30"><span> نظام ادارة الجودة</span></h5>
     <h5 style="font-size: 16px; color: #792d30"><span> تاريخ اليوم  : '.date('Y-m-d').'</span> </h5>
     </div>

     
     <div>
         <p>احصائيات الطلبات</p>
         <div style="width:100%">  

         <div style="width:30%; float:right;background-color: #792d30; color: #fff; text-align:center">
             <p>عدد الطلبات الكلي</p>
             <p>' . $orders->count() .'</p>
         </div>
 
         <div style="width:30%; float:right;background-color: #792d30; color: #fff;margin-right:5%; text-align:center">
            <p>عدد الشكاوى</p>
            <p>'. $orders->whereIn('status', [1,2,3,4])->count().'</p>
         </div>

         <div style="width:30%; float:right; background-color: #792d30; color: #fff;margin-right:5%; text-align:center">
           <p> عدد الملاحظات الايجابية</p>
           <p>'. $orders->where('status', 0)->count() .'</p>
         </div>
      
         </div>
      </div>
    
     
  
     <div class="container">
         <p>احصائيات الاقسام</p>
         <div class="state">  
            <table  style="width: 100%;margin-bottom: 1rem;; border:1px solid #eee; text-align:center">';
              foreach(Department::get() as $department) :
                $html.='<tr>
                  <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;width:50%">'. $department->name.'</td>
                  <td style="padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee;width:50%">'. 
                 $complaints->where('department_id', $department->id)->count() .'</td>
                </tr>';
              endforeach;
              
            $html.='</table>
              
         </div>
         </div>';
   
    $html.='<table style="width: 100%;margin-bottom: 1rem;; border:1px solid #eee; text-align:center"

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
                                 if(isset($order->note)) : $html.='<p>'. $order->note->note . '</p>';
                                 elseif(isset($order->complaints)) :

                                 
                                    $html.="<table  style='width: 100%;margin-bottom: 1rem;; border:1px solid #eee; text-align:center'>";
                                      $html.="<tr>
                                        <th style='padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;'>القسم</th>
                                        <th style='padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;'>الوجبة</th>
                                        <th style='padding: 0.75rem 0.4rem;vertical-align: top;border: 1px solid #eee; color:#792d30;'>الشكوى</th>
                                      </tr>";
                                    foreach($order->complaints as $complaint) :
                                    $html.="<tr>";
                                    $html.='<td>'. $complaint->department->name . '</td>';
                                    $html.='<td>'. $complaint->metarial . '</td>';
                                    $html.='<td>'. $complaint->complaint . '</td>';
                                    $html.="</tr>";
                                    endforeach;
                                    $html.="</table>";
                             
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

                     <table style="width:100%; margin-top:30px; color:#333 !important;"> 
                  
                               <tr>
                                <td style="margin-left:5px;width:33%"> توقيع مدير الأتصال </td>                            
                                <td style="margin-left:5px;width:33%"> توقيع مدير الفرع</td>
                                <td style="margin-left:5px;width:33%">توقيع المدير التنفيذي  </td>
                               </tr>
                     </table>
         
</div>
</body>
    ';
    $pdf->WriteHTML($html);
    $pdf->Output('orders'.time(). '.' .'pdf' , 'D');
}
}