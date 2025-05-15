<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRating extends Model
{
    use HasFactory;

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
