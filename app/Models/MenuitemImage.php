<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuitemImage extends Model
{
    use HasFactory;
    protected $fillable = ['menuitem_id', 'filename'];
}
