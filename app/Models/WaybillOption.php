<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaybillOption extends Model
{
    use HasFactory;

    protected $table = 'waybill_options';

    protected $primaryKey = 'waybill_option_id';

    protected $fillable = [
        'option',
        'description',
    ];
    public function setting()
    {
        return $this->hasOne(Setting::class, 'option', 'waybill_option_id');
    }
}
