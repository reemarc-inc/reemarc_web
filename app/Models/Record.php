<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Record extends Model
{
    use HasFactory;

    protected $table = 'record';

    protected $fillable = [
        'id',
        'appointment_id',
        'treatment_id',
        'user_id',
        'type',
        'note',
    ];

    public function treatments()
    {
        return $this->belongsTo(Treatments::class, 'treatment_id', 'id');
    }

//    protected $primaryKey = 'id';
//    protected $keyType = 'int';
//    public $incrementing = true;

}
