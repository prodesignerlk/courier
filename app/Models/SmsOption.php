<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsOption extends Model
{
    use HasFactory;

    protected $table = 'sms_options';

    protected $primaryKey = 'sms_option_id';

    protected $fillable = [
        'option',
        'description',
        'api_key',
        'api_secret',
    ];

    public function setting()
    {
        return $this->belongsTo(Setting::class, 'option', 'sms_option_id');
    }
}
