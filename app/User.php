<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'user_name', 'user_first_name', 'user_last_name', 'user_description', 'user_email_address', 'user_profile_picture', 'user_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'user_id';
    }

}
