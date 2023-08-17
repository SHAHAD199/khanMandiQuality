<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'app_name_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function appName()
    {
        return $this->belongsTo(AppName::class);
    }

}
