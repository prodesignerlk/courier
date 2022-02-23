<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'cod_amount',
        'delivery_cost',
        'remark',
        'status',
        'st_1_at',
        'st_1_by',
        'st_2_at',
        'st_2_by',
        'st_3_at',
        'st_3_by',
        'st_4_at',
        'st_4_by',
        'st_5_at',
        'st_5_by',
        'st_6_at',
        'st_6_by',
        'st_9_at',
        'st_9_bt',
        'st_10_at',
        'st_10_by',
        'st_11_at',
        'st_11_by',
        'st_12_at',
        'st_12_by',
        'st_13_at',
        'st_13_by',
        'st_14_at',
        'st_14_by',
        'waybill_id',
        'receiver_id',
        'seller_id',
        'pickup_branch_id',
        'branch_id',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Receiver::class, 'receiver_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'waybill_id', 'waybill_id');
    }
}
