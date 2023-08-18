<?php 

namespace App\Helpers\Orders;

use App\Models\Customer;

class UpdateCustomer 
{
    public static function update_customer($request, $order)
    {
        Customer::where('id', $order->customer->id)->update([
            'fname'    => $request->fname,
            'gender'   => $request->gender,
            'birthday' => $request->birthday
        ]);
    }
}