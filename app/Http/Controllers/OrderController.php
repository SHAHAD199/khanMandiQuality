<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Complaint;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Discount;
use App\Models\Note;
use App\Models\Order;
use App\Models\OrderType;
use App\Services\Whatsapp;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $whatsapp;
    public function __construct(Whatsapp $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function index(Request $request)
    {
        extract($request->all());
        if(!empty($phone)){
            $orders = Order::where('add_status', 0)->whereHas('customer', function($q) use ($phone){
               $q->where('phone', $phone);
            })->get();
        }else {
            $orders = Order::where('add_status', 0)->get();
        }
        $index = 1;
        return view('orders.index' , compact('orders','index'));
    }

    public function create(Order $order)
    {
        $departments = Department::get();
        $branches = Branch::get();
        $ordertypes = OrderType::get();
        return view('orders.add', compact('order','departments', 'branches', 'ordertypes'));
    }


    public function store(Order $order, Request $request) 
    {       
       
        $all_array = array();
        for($i = 1; $i <= 9; $i++){
          $aa = 'all_'.$i;         
          array_push($all_array, $request->$aa);
         }
        $result = array_filter($all_array, fn ($value) => !is_null($value));
        Customer::where('id', $order->customer->id)->update([
            'fname'    => $request->fname,
            'gender'   => $request->gender,
            'birthday' => $request->birthday
        ]);
       
         $result = array_values($result);
        //  return $result;
   
    if($request->type && $request->type == 'سيء' )
    {
        foreach($result as $key=>$row)
        {

        foreach($row as $tt=>$value){

              Complaint::create([
              'order_id' => $order->id,
              'department_id' =>  explode(',', $value)[0],
              'metarial'      =>  explode(',',  $value)[1],
              'complaint'     =>  explode(',',  $value)[2],

           ]);
        }
        }
        
        $order->update(['status' => 1]);
        if($request->is_immediately && $request->is_immediately == 2)
        {
            Discount::create([
             'order_id'        => $order->id,
             'customer_id'     => $order->customer->id,
             'is_immediately'  => $request->is_immediately,
             'value'           => $request->value,
             'debt'            => $request->debt,
             'status'          => 2
            ]);
            $order->update(['status' => 2]);
            $body = 'shahad test';
            $this->whatsapp->send($order->customer->phone, $body);


        }
    }
     else if($request->type && $request->type == 'جيد')
     {
        Note::create([
           'order_id' => $order->id,
           'note'     => $request->note
        ]);
        $order->update(['status' => 0]);
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

    public function addNew(Order $order)
    {
        $departments = Department::get();
        
        return view('orders.addnew' , compact('order', 'departments'));
    }


    public function approval(Order $order, Request $request)
    {
        Discount::create([
           'order_id'  => $order->id,
           'customer_id' => $order->customer->id,
           'value'     => $request->value,
           'is_immediately' => 1,
           'status'    => 2
        ]);
       $order->update(['status' => 2]);
       $body = '
مرحبا ست / استاذ '.$order->customer->name.'

 نعتذر لكم بالنيابة عن سلسلة مطاعم خان مندي بخصوص طلبكم الاخير
 ونقدم لكم خصم بقيمة '.$request->value.'% على طلبكم القادم
صلاحية استخدام الخصم هي اسبوعين من تاريخ استلام الرسالة

نتمنى لكم يوم سعيد 
عيش التجربة اليمنية#';
       $this->whatsapp->send($order->customer->phone , $body);
       return back();
    }

    public function reject(Order $order)
    {      
        $order->update(['status' => 3]);
        $body = '
        '.$order->customer->name.'مرحبا ست / استاذ 
        
        تم استلام الملاحظات المقدمة من قبلكم بخصوص طلبكم الاخير وسيتم العمل عليها 
        نعتذر لكم بالنيابة عن سلسلة مطاعم خان مندي 
        
        نتمنى لكم يوم سعيد 
        عيش التجربة اليمنية#';
        
        $this->whatsapp->send($order->customer->phone, $body);
        return back();
    }
}
