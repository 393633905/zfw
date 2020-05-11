<?php

namespace App\Models;

use App\Models\BaseModel;

class Node extends BaseModel
{

    //使用访问器控制菜单显示：是/否
    public function getIsMenuAttribute(){
        return $this->attributes['is_menu'] ?  ' <span class="label label-success">是</span>':'<span class="label label-danger">否</span>';
    }

    //获取数据，并转换成无限极分类格式：
    public function getNodeCateList(){
       $datas=self::all()->toArray();
       return $this->category_list($datas);
    }

    //获取用户菜单：
    public function getUserMenuData($nodes){
        $query=Node::where('is_menu',1);
        if($nodes){
            //获取该用户所拥有的权限数据：
            $query->whereIn('id',array_keys($nodes));
        }
        $menuData=$query->get()->toArray();
        return $this->tree_list($menuData);
    }
}
