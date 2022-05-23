<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyFinance extends Model
{
    use HasFactory;

    protected $table = 'daily_finances';

    protected $primaryKey = 'daily_finance_id';

    protected $fillable = [
        'bill_date',
        'total_cod_amount',
        'payment_status', //0->unpaid , 1->payed, 2->pending
        'order_count',
        'branch_id',
        'daily_deposit_id'
    ];

    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function dailyDeposit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DailyDeposit::class, 'daily_deposit_id');
    }
}
