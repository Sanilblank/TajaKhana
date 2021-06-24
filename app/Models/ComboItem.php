<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboItem extends Model
{
    use HasFactory;

    protected $fillable = ['combo_id', 'menuitem_id'];

    public function menuitem()
    {
        return $this->belongsTo(Menuitem::class);
    }

    public function combomenu()
    {
        return $this->belongsTo(Menuitem::class, 'combo_id', 'id');
    }
}
