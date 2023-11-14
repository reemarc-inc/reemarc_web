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
        'tel',
        'duration',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
