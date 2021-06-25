<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branchmenu_id',
        'quantity',
        'price',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branchmenu(){
        return $this->belongsTo(BranchMenu::class);
    }
}
