<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'feature',
        'option',
        'relevent_model',
        'org_id'
    ];

    public function waybill_option()
    {
        return $this->belongsTo(WaybillOption::class, 'option', 'waybill_option_id');
    }

    public function sms_option()
    {
        return $this->belongsTo(SmsOption::class, 'option', 'sms_option_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    
}
