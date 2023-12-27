<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use App\Models\Concerns\UuidTrait;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'id',
        'user_id',
        'appointment_id',
        'treatment_id',
        'clinic_id',
        'package_id',
        'type',
        'note',
        'is_delete',
        'is_read',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
