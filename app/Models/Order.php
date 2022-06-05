<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_id','order_date','user_id','customer_name','delivery_address','phone','total_qty','cart_total','final_cost',
        'transaction_id','payment_ss'
    ];
}
