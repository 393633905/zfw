<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function getPicAttribute(){
        return config('wechat.host').$this->attributes['pic'];
    }
}
