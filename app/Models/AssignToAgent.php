<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignToAgent extends Model
{
    use HasFactory;

    protected $table = 'assign_to_agents';

    protected $primaryKey = 'assign_to_agent_id';

    protected $fillable = [
        'assign_date',
        'order_id',
        'agent_id',
        'assign_by',
        'assign_at',
    ];
}
