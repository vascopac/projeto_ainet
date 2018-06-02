<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    public function typeToStr()
    {
        switch ($this->admin) {
            case 0:
                return 'Normal';
            case 1:
                return 'Administrator';
        }

        return 'Unknown';
    }

    public function statusToStr()
    {
        switch ($this->blocked) {
            case 0:
                return 'Ok';
            case 1:
                return 'Blocked';
        }

        return 'Unknown';
    }
}
