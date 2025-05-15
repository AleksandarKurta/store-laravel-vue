<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'title',
        'price',
        'description',
        'category',
        'image'
    ];

    public function rating()
    {
        return $this->hasOne(ProductRating::class);
    }
}
