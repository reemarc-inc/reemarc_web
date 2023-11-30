<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use App\Models\Concerns\UuidTrait;

class Clinic extends Model
{
    use HasFactory;

    protected $table = 'clinic';

    protected $fillable = [
        'id',
        'name',
        'address',
        'description',
        'images',
        'latitude',
        'longitude',
        'region',
        'country_code',
        'time_zone',
        'phone',
        'web_url',
        'booking_start',
        'booking_end',
        'country_code',
        'dentist_name',
        'duration',
        'disabled_days',
        'disabled_dates'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
