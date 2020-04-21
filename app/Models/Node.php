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

    //获取用户菜单：
    public function getUserMenuData($nodes){
        $query=Node::where('is_menu',1);
        if($nodes){
            $query->whereIn('id',array_keys($nodes));
        }
        $menuData=$query->get()->toArray();
        return $this->tree_list($menuData);
    }
}
