<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceFail extends Model
{
    use HasFactory;

    protected $table = 'invoice_fails';

    protected $primaryKey = 'invoice_fail_id';

    protected $fillable = [
        'seller_id',
        'fail_reason',
        'is_fixed',
    ];

}
