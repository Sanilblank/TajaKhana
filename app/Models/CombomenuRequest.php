<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CombomenuRequest extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'fullname',
        'menuitem_id',
        'description',
        'contactno',
    ];

    public function menuitem()
    {
        return $this->belongsTo(Menuitem::class);
    }
}
