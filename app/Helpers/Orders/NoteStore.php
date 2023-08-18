<?php 

namespace App\Helpers\Orders;

use App\Models\Note;

class NoteStore 
{
    public static function store_note($request, $order)
    {
        Note::create([
            'order_id' => $order->id,
            'note'     => $request->note
         ]);
         $order->update(['status' => 0]);
    }
}