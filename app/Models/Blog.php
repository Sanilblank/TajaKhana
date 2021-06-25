<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        'category'=>'array',
    ];

    protected $fillable = ['title', 'image', 'category', 'date', 'details', 'view_count', 'authorname', 'authorimage'];

    public function searchableAs()
    {
        return 'tajakhana_blogs';
    }
}
