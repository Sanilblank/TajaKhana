<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menuitem extends Model
{
    use HasFactory;
    protected $casts = [
        'category_id' => 'array',
    ];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'price',
        'discount',
        'quantity',
        'unit',
        'details',
        'status',
        'featured',
        'costprice',
    ];
}
