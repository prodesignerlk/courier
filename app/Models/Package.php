<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $primaryKey = 'package_id';

    protected $fillable = [
        'waybill_id',
        'waybill_type',
        'package_weight',
        'package_used_status',
        'batch_number',
        'reserved_date',
        'seller_id',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    
}
