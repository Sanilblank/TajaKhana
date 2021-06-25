<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menuitem extends Model
{
    use HasFactory;
    use Searchable;
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
        'is_combo',
    ];

    public function searchableAs()
    {
        return 'tajakhana_items';
    }
}
