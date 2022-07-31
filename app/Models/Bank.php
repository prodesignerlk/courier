<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';

    protected $primaryKey = 'bank_id';

    protected $fillable = [
        'bank_name',
        'branch_name',
        'account_no',
        'seller_id'
    ];
}
