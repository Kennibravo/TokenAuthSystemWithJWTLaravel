<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Artisan extends Authenticatable implements JWTSubject
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        
        public function getJWTCustomClaims()
        {
            return [];
        }
=======
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    //
>>>>>>> d7326188948a83cbc56b24d460d3980a62a3722d
}
