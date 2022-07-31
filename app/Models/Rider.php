<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $table = 'riders';

    protected $primaryKey = 'rider_id';

    protected $fillable = [
        'rider_name',
        'vehicle_no_1',
        'vehicle_no_2',
        'staff_id',
    ];
}
