<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $primaryKey = 'city_id';

    public function District()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function receiver()
    {
        return $this->hasMany(Receiver::class, 'receiver_city_id', 'city_id');
    }
}
