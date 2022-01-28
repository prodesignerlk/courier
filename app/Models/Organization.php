<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $primaryKey = 'org_id';

    protected $fillable = [
        'org_name',
        'org_address',
        'org_tp_1',
        'org_tp_2',
        'org_br',
        'org_notes',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'org_id');
    }

    public function setting()
    {
        return $this->hasMany(Setting::class, 'org_id');
    }
}
