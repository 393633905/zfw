<?php

namespace App\Models;

class FangAttr extends BaseModel
{
    //获取房源属性数据并转换为无限极分类数据：
    public function getFangAttrList(){
        return $this->category_list(self::all()->toArray());
    }

    //使用修改器处理上传的field_name：因此字段在数据库中为NOT NULL,故若当未添加field_name时则上传''，防止数据库报错；
    public function setFieldNameAttribute($value){
        $this->attributes['field_name']=empty($value)?'':$value;
    }

    public function getIconAttribute(){
        return config('wechat.host').$this->attributes['icon'];
    }



}
