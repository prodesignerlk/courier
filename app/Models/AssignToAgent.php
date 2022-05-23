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
        'staff_id',
        'order_id',
        'status',
        'assign_by',
        'assign_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}