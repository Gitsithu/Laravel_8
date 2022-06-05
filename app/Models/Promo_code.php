<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo_code extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'code','start_date','end_date','user_id',
    ];
}
