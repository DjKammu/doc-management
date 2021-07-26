<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // CONST DEFAULT_FIRST_LOGIN = 1;

    // CONST LOGIN_ATTEMPT = 3;

    // CONST LOGIN_BLOCK_HOURS = 8;

    // CONST BLOCKED_MSG  = 'You are account has been bloked. Please try after '.self::LOGIN_BLOCK_HOURS. ' Hours';

    // protected $table = 'Login';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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


    // public function beleges(){
     
    //    return $this->hasMany(Belege::class,'Kundennummer','Kundennummer');
    // }
}
