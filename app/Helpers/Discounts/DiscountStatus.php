<?php 

namespace App\Helpers\Discounts;

use App\Models\Discount;
use App\Services\Whatsapp;

class DiscountStatus 
{
    
    public static  function store_discount($request,$order)
    {
        Discount::create([
            'order_id'  => $order->id,
            'customer_id' => $order->customer->id,
            'value'     => $request->value,
            'is_immediately' => 1,
            'status'    => 2
         ]);
        $order->update(['status' => 2]);
        self::send_approval_message($request, $order);
    }


    public static function send_approval_message($request, $order)
    {
        $body = '
        مرحبا ست / استاذ '.$order->customer->name.'
        
         نعتذر لكم بالنيابة عن سلسلة مطاعم خان مندي بخصوص طلبكم الاخير
         ونقدم لكم خصم بقيمة '.$request->value.'% على طلبكم القادم
        صلاحية استخدام الخصم هي اسبوعين من تاريخ استلام الرسالة
        
        نتمنى لكم يوم سعيد 
        عيش التجربة اليمنية#';
         Whatsapp::send($order->customer->phone , $body);
    }

    
}