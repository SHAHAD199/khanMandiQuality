<?php 

namespace App\Services\DiscountsReports;


use App\Models\{
    Branch, Customer, Discount
};


class ApprovalService 
{
    public static function approval_discounts($request)
    {
        $index  = 1;
        $branches = Branch::get();

        $discounts = $request->branch_id && ($request->start_at && $request->end_at)
         ? Discount::where('status', 2)
        ->whereHas('order', function($q) use($request){
          $q->whereBetween('order_date', [$request->start_at, $request->end_at])
          ->where('branch_id', $request->branch_id);
        })->get()

        : (($request->branch_id) ? Discount::where('status', 2)
        ->whereHas('order', function($q) use($request){
          $q->where('branch_id', $request->branch_id);
        })->get()

        : (($request->start_at && $request->end_at) ? 
        Discount::where('status', 2)
        ->whereHas('order', function($q) use($request){
            $q->whereBetween('order_date', [$request->start_at, $request->end_at]);
        })->get() 

        :(($request->phone) ?  Discount::where('status', 2)
        ->whereHas('order', function($q) use($request){
            $q->where('customer_id', Customer::where('phone', $request->phone)->first()->id );
        })->orWhereHas('customer', function($q) use($request){
            $q->where('customer_id', Customer::where('phone', $request->phone)->first()->id );
        })->get()
        : Discount::where('status', 2)->get()       
    )));

        return view('reports.approval_discounts', compact('index', 'branches','discounts'));
    }

}