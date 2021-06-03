<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchMenu extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id', 'menuitem_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function menuitem()
    {
        return $this->belongsTo(Menuitem::class, 'menuitem_id', 'id');
    }
}
