<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_detail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id','product_id','price','qty','total','created_by'
    ];
}
