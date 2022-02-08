<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $primaryKey = 'district_id';

    public function city()
    {
        return $this->hasMany(City::class, 'district_id');
    }
}
