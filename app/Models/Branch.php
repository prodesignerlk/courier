<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $primaryKey = 'branch_id';

    protected $fillable = [
        'branch_code',
        'branch_name',
        'branch_address',
        'branch_city',
        'branch_district',
        'branch_tp',
        'branch_email',
        'status',
    ];

    public function order()
    {
        return $this->hasMany(Order::class,'branch_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'branch_id');
    }
}
