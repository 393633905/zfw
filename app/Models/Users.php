<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Btn;
class Users extends Model
{
    //使用软删除：
    use SoftDeletes,Btn;

    //定义软删除字段：
    protected $dates=['deleted_at'];
    protected $table='users';
    protected $guarded=['remember_token'];
    protected $hidden=['password'];

    //定义与角色关联模型：以用户表来说，用户与角色属于关系：
    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

}
