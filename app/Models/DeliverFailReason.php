<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverFailReason extends Model
{
    use HasFactory;

    protected $table = 'deliver_fail_reasons';

    protected $primaryKey = 'deliver_fail_reason_id';

    protected $fillable = [
        'reason',
    ];
}
