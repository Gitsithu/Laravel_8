<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = [
        'name', 'product_code','category_id','qty','image_url1',
    ];
    public function category()
    {
    	return $this->belongsTo('App\Models\Category');
    }
}
