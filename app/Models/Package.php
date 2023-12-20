<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use App\Models\Concerns\UuidTrait;

class Package extends Model
{
    use HasFactory;

    protected $table = 'package';

    protected $fillable = [
        'id',
        'name',
        'invisalign_id',
        'number_of_aligners',
        'treatment_duration',
        'us_price',
        'kr_price',
        'summary',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
