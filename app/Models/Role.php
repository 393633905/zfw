<?php

namespace App\Models;

use App\Models\BaseModel;
class Role extends BaseModel
{
    //多对多关系：
    public function nodes(){
        //第一个参数：被关联的模型，关系表名，关系表中对应当前模型的主键，关系表中对应当前模型的外键
        return $this->belongsToMany('App\Models\Node','role_node','role_id','node_id');
    }
}
