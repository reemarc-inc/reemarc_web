<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatments extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = [
        'id',
        'appointment_id',
        'user_id',
        'clinic_id',
        'package_id',
        'session',
        'month',
        'ship_to_office',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
