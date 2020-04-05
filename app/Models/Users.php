<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Model;

class Users extends Model
{
    protected $table='users';
    protected $guarded=['remember_token'];
    protected $hidden=['password'];
}
