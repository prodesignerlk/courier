<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    use HasFactory;

    protected $table = 'receivers';

    protected $primaryKey = 'receiver_id';

    protected $fillable = [
        'receiver_name',
        'receiver_contact',
        'receiver_contact_2',
        'receiver_address',
        'receiver_city_id',
        'receiver_district_id'
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'receiver_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'receiver_city_id', 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'receiver_district_id', 'district_id');
    }
}
