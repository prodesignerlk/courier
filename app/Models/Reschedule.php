<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reschedule extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $primaryKey = 'seller_id';

    protected $fillable = [
        'reschedule_reson',
        'order_id',
        'reschedule_by',
        'reschedule_at',
    ];
}
