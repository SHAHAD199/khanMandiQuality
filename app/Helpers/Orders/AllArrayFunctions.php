<?php 

namespace App\Helpers\Orders;

use App\Models\Complaint;

class AllArrayFunctions
{
    public static function  all_array($request)
    {
        $all_array = array();

        for($i = 1; $i <= 9; $i++){
          $aa = 'all_'.$i;         
          array_push($all_array, $request->$aa);
         }
        $result = array_filter($all_array, fn ($value) => !is_null($value));
        return $result = array_values($result);

    }


    public static function store_complaints($request, $order)
    {
        foreach(self::all_array($request) as $key=>$row)
        {

        foreach($row as $value){

              Complaint::create([
              'order_id' => $order->id,
              'department_id' =>  explode(',', $value)[0],
              'metarial'      =>  explode(',',  $value)[1],
              'complaint'     =>  explode(',',  $value)[2],

           ]);
        }
        }
    }
}