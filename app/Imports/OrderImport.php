<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class OrderImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

      if(Customer::where('phone', $row[1])->get()->count() == 0)
      {
       Customer::create([
        'name'  =>  $row[0],
        'phone' =>  $row[1]
       ]);
      }
       Order::create([
         'customer_id'   => Customer::where('phone' , $row[1])->first()->id,
         'branch_id'     => ($row[2] == 'الكرادة') ? 1 : (($row[2] == 'المنصور') ? 2 :  3),
         'city'          => $row[3],
         'order_date'    => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])),
         'order_type_id' => ($row[5] == 'دليفيري') ? 1 : (($row[2] == 'سفري') ? 2 :  3),
         'bill'          => $row[6],
         'meal'          => $row[7],
         'main_course'   => $row[8],
         'drinks'        => $row[9],
         'additions'     => $row[9],
         'appetizers'    => $row[9],
       ]);
    }
}
