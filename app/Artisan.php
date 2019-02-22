<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    //
    /// //Tble name
    protected $table = 'artisans';
    //Primary key
    public $primarykey = 'id';
    //timestamps
    public $timestamps = true;

    protected $fillable = ['title', 'body'];

}
