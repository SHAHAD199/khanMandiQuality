<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'branch_id',
        'city',
        'order_type_id',
        'bill',
        'meal',
        'main_course',
        'drinks',
        'additions',
        'appetizers',
        'status',
        'order_date',
        'response',
        'add_status',
        'call_status',
        'added_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function note()
    {
        return $this->hasOne(Note::class);
    }

    public function img()
    {
        return $this->hasOne(Img::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function OrderDiscount()
    {
       return $this->hasOne(OrderDiscount::class);
    }
}
