<?php 

namespace App\Services\Discounts;

use App\Models\Discount;
use App\Services\Whatsapp;

class PostDiscountService
{
    public static function send_birthday_sms($request)
    {
       Discount::create([
        'customer_id' => $request->customer_id,
        'value'       => 30,
        'status'      => 2
       ]);
       self::body($request);
       return back();
    }

    public static function body($request)
    {
        $body = 'عسى ايامكم كلها سعادة ومليئة باللحظات الحلوة والنجاحات الدائمة 
        ان تجربتكم لدينا في خان مندي  تمثل لنا اهمية كبيرة ونود ان نكون جزء من يومكم المميز ، استمتع بخصم قدره ٣٠٪ على الفاتورة الاجمالية         
        نتطلع لرؤيتكم في احد فروع خان مندي للاستمتاع بالعرض الحصري ليوم ميلادك' ;
        Whatsapp::send($request->phone, $body);
    }


    public static function use_discount($discount)
    {
       $discount->update([
           'status'    => 4,
           'date_use'  => now()->format('Y-m-d')
       ]);
       return back();
    }

}