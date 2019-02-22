<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{

=======

class User extends Authenticatable
{
>>>>>>> d7326188948a83cbc56b24d460d3980a62a3722d
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
        'name', 'email', 'password', 'role',
=======
        'name', 'email', 'password',
>>>>>>> d7326188948a83cbc56b24d460d3980a62a3722d
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
<<<<<<< HEAD

    public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        
        public function getJWTCustomClaims()
        {
            return [];
        }


        public static function roles()
    {
        return ["admin", "customer", "artisan"];
    }

    //Roles at the moment "user","admin","superadmin"
    public function hasRole($role){

        if($this->role == "admin"){
            return true;
        } else if($this->role == "customer"){
            return true;
        } else if ($this->role == "artisan") {
            return true;
        }

        return false;
    }

    public static function roleErrorResponse(){

        $error["error"] = "Sorry, You do not have permission to access this";
        return response()->json(['error' => $error], 401);

    }
=======
>>>>>>> d7326188948a83cbc56b24d460d3980a62a3722d
}
