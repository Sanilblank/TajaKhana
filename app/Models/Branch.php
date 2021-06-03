<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'branchname',
        'branchlocation',
        'longitude',
        'latitude',
        'phone',
        'status',
    ];
}
