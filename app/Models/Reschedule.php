<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reschedule extends Model
{
    use HasFactory;

    protected $table = 'reschedules';

    protected $primaryKey = 'reschedule_id';

    protected $fillable = [
        'reschedule_date',
        'reason_id',
        'order_id',
        'status',
        'reassign',
        'reschedule_by',
        'reschedule_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
