<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    protected $fillable = [
        'product_id',
        'rate',
        'count'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
