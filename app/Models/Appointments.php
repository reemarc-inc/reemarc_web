<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'id',
        'user_id',
        'user_name',
        'user_phone',
        'clinic_id',
        'clinic_name',
        'clinic_phone',
        'clinic_address',
        'booking_start',
        'booking_end',
        'service_duration',
        'disabled_days',
        'disabled_dates',
        'status',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
