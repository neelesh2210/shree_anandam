<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'parent_id',
        'name',
        'phone_number',
        'address',
        'password',
        'referral_code',
        'referrer_code',
        'number_of_child',
        'is_block',
        'is_verify',
    ];

    public function userDetail(){
        return $this->hasOne(UserDetail::class);
    }

    public function referrer(){
        return $this->hasOne(User::class,'referral_code','referrer_code');
    }

}
