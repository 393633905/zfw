<?php

namespace App\Models;

use App\Models\BaseModel;
class Article extends BaseModel
{
    //追加按钮数据：
    protected $appends=['action'];


    //访问器：
    public function getActionAttribute(){
        return $this->btn('admin.article.edit','修改')."&nbsp;". $this->btn('admin.article.destroy','删除');
    }

    //修改器：
    public function setPicAttribute($pic){
        $this->attributes['pic']=empty($pic)?config('up.default'):$pic;
    }
}
