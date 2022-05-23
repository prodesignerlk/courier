<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class previousReRoute extends Model
{
    use HasFactory;

    protected $table = 'previous_re_routes';

    protected $primaryKey = 'previous_re_route_id';

    protected $fillable = [
        'st_4_at',
        'st_4_by',
        'st_5_at',
        'st_5_by',
        'st_6_at',
        'st_6_by',
        'st_6_branch',
        'order_id',
        'reroute_at',
        'reroute_by',
    ];
}
