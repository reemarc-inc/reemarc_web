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
        'user_first_name',
        'user_last_name',
        'user_email',
        'user_phone',
        'clinic_id',
        'clinic_name',
        'clinic_phone',
        'clinic_address',
        'clinic_region',
        'booked_date',
        'booked_day',
        'booked_time',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
