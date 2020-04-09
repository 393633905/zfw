<?php

namespace App\Models;

use App\Models\BaseModel;

class Node extends BaseModel
{
    //获取数据，并转换成无限极分类格式：
    public function getNodeCateList(){
       $datas=self::all()->toArray();
       return $this->category_list($datas);
    }
}
