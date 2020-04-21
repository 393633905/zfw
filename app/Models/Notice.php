<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends BaseModel
{
    public function owner(){
        return $this->belongsTo(FangOwner::class,'fangowner_id','id');
    }
}
