<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookbookItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        'category'=>'array',
    ];

    protected $fillable = [
        'itemname',
        'category',
        'slug',
        'itemimage',
        'recipeby',
        'recipebyimage',
        'serving',
        'timetoprepare',
        'timetocook',
        'description',
        'course',
        'cuisine',
        'timeofday',
        'levelofcooking_id',
        'recipetype_id',
        'ingredients',
        'steps',
        'view_count',
    ];

    public function searchableAs()
    {
        return 'tajakhana_cookbooks';
    }

    public function levelofcooking()
    {
        return $this->belongsTo(Levelofcooking::class, 'levelofcooking_id', 'id');
    }

    public function recipetype()
    {
        return $this->belongsTo(Recipetype::class, 'recipetype_id', 'id');
    }

}
