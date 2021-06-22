<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'branch_id',
        'menuitem_id',
        'quantity',
        'price',
        'status_id',
        'reason',
        'monthyear',
    ];

    public function menuitem()
    {
        return $this->belongsTo(Menuitem::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
