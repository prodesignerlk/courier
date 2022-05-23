<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'regular_price',
        'extra_price',
        'handling_free',
        'total_cod_amount',
        'total_delivery_fee',
        'total_handling_fee',
        'total_payable',
        'total_weight',
        'package_count',
        'payment_status',
        'payment_at',
        'payment_by',
        'approved_at',
        'approved_by',
        'seller_id',
        'invoice_date',
    ];
}
