<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RescheduleReason extends Model
{
    use HasFactory;

    protected $table = 'reschedule_reasons';

    protected $primaryKey = 'reschedule_reason_id';

    protected $fillable = [
        'reason',
    ];
}
