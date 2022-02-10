<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $primaryKey = 'seller_id';

    protected $fillable = [
        'seller_name',
        'seller_tp_1',
        'seller_tp_2',
        'address_line_1',
        'city_id',
        'district_id',
        'payment_period',
        'regular_price',
        'extra_price',
        'handeling_fee',
        'user_id',
    ];

    public function package()
    {
        return $this->hasMany(Package::class, 'seller_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }
    
}
