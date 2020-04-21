<?php

namespace App\Models;

use App\Models\BaseModel;
class Role extends BaseModel
{
    //多对多关系：
    public function nodes(){
        return $this->belongsToMany('App\Models\Node','role_node','role_id','node_id');
    }
}
