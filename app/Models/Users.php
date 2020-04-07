<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Users extends Model
{
    //使用软删除：
    use SoftDeletes;

    //定义软删除字段：
    protected $dates=['deleted_at'];
    protected $table='users';
    protected $guarded=['remember_token'];
    protected $hidden=['password'];

}
