<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyDeposit extends Model
{
    use HasFactory;

    protected $table = 'daily_deposits';

    protected $primaryKey = 'daily_deposit_id';

    protected $fillable = [
        'payed_amount',
        'remark',
        'payed_date',
        'payment_approve_by',
        'payment_approve_at',
    ];

    public function dailyFinance(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(DailyFinance::class, 'daily_deposit_id');
    }
}
