<?php 

namespace App\Services\Orders;

use App\Helpers\Discounts\DiscountStatus;
use App\Helpers\Orders\AllArrayFunctions;
use App\Helpers\Orders\ImmediatelyDiscount;
use App\Helpers\Orders\NoteStore;
use App\Helpers\Orders\UpdateCustomer;
use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Note;
use App\Services\Whatsapp;

class PostOrderService
{

    public function update($order,$request) 
    {       
       
   
   
    UpdateCustomer::update_customer($request,$order);
    if($request->type && $request->type == 'سيء' )
    {
        

        AllArrayFunctions::store_complaints($request,$order);
        
        $order->update(['status' => 1]);
        if($request->is_immediately && $request->is_immediately == 2)
        {

            ImmediatelyDiscount::is_immediately($request, $order);


        }
    }
     else if($request->type && $request->type == 'جيد')
     {
      
        NoteStore::store_note($request, $order);
     }
     else {
        $order->update(['status' => 0]);
     }

     $order->update([
        'add_status' => 1,
        'response'   => $request->response
        ]);
    return redirect(url('orders'));
    }



    public function approval($order,$request)
    {
       DiscountStatus::store_discount($request, $order);
       return back();
    }

    public function reject($order)
    {      
        $order->update(['status' => 3]);
        $body = '
        '.$order->customer->name.'مرحبا ست / استاذ 
        
        تم استلام الملاحظات المقدمة من قبلكم بخصوص طلبكم الاخير وسيتم العمل عليها 
        نعتذر لكم بالنيابة عن سلسلة مطاعم خان مندي 
        
        نتمنى لكم يوم سعيد 
        عيش التجربة اليمنية#';
        
        Whatsapp::send($order->customer->phone, $body);
        return back();
    }
}