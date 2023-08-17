<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'department_id', 'metarial','complaint'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
