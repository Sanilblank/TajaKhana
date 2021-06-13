<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malhal\Geographical\Geographical;

class Branch extends Model
{
    use HasFactory;
    use Geographical;
    protected $fillable = [
        'branchname',
        'branchlocation',
        'longitude',
        'latitude',
        'phone',
        'status',
        'branchimage',
    ];
}
