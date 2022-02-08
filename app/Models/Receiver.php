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
        'receiver_conatct_2',
        'receiver_address',
        'receiver_city_id',
        'receiver_district_id'
    ];
}
