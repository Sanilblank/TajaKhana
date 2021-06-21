<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChefResponsibility extends Model
{
    use HasFactory;

    protected $fillable =[
        'chef_id',
        'branchmenu_id',
        'branch_id',
    ];

    public function chef()
    {
        return $this->belongsTo(Chef::class, 'chef_id', 'id');
    }

    public function branchmenu()
    {
        return $this->belongsTo(BranchMenu::class, 'branchmenu_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
