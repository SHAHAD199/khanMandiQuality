<?php 

namespace App\Helpers\Orders;

use App\Models\Discount;

class ImmediatelyDiscount
{
    public static function is_immediately($request, $order)
    {
        Discount::create([
            'order_id'        => $order->id,
            'customer_id'     => $order->customer->id,
            'is_immediately'  => $request->is_immediately,
            'value'           => $request->value,
            'debt'            => $request->debt,
            'status'          => 2,
            'added_by'        => auth()->user()->name
           ]);
           $order->update(['status' => 2]);
           $body = 'shahad test';
           // $this->whatsapp->send($order->customer->phone, $body);
    }

}