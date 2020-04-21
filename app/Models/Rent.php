<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends BaseModel
{

    public function getPhoneAttribute(){
        return empty($this->attributes['phone'])?'无手机号':$this->attributes['phone'];
    }
}
