<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

//use Spatie\Permission\Traits\HasRoles;
//use App\Models\Concerns\UuidTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'name',
        'id',
        'first_name',
        'last_name',
        'region',
        'role',
//        'user_brand',
        'access_level',
        'email',
        'phone',
        'gender',
        'yob',
        'device_token',
        'sns_login',
        'appointment_status',
        'treatment_status',
        'treatment_id',
        'clinic_id',
        'user_type',
        'payment_customer_id',
        'image',
        'firebase_image',
        'password',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d, M Y H:i:s');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d, M Y H:i:s');
    }

    public function getVerifiedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['email_verified_at'])->format('d, M Y H:i:s');
    }

//    public function getShowEditRemoveBtnAttribute()
//    {
//        if (($this->id == auth()->user()->id) or $this->hasRole(\App\Models\Role::ADMIN)) {
//            return false;
//        }
//
//        return true;
//    }
}
