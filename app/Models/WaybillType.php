<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaybillType extends Model
{
    use HasFactory;

    protected $table = 'waybill_types';

    protected $primaryKey = 'waybill_type_id';

    protected $fillable = [
        'type',
        'description',
    ];
}
