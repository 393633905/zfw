<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//软删除
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Btn;
class BaseModel extends Model{

    //使用软删除：
    use SoftDeletes,Btn;
    //软删除字段：
    protected $dates=['deleted_at'];
    //黑名单
    protected  $guarded=[];


    /**
     * 获取无限极分类数据：
     * @param $datas
     * @param int $pid 此pid在当前菜单作为id，在上级菜单作为pid
     * @param int $level
     */
    public function category_list($datas,$level=0,$pid=0,$html='----'){
        static $temp=[];
        foreach ($datas as $data){
            //找下级菜单：下级菜单的pid=本级菜单的id
            if($data['pid']==$pid){//顶级菜单
                $data['level']=$level;
                $data['level_html']=str_repeat($html,$level);
                $temp[]=$data;
                $this->category_list($datas,$level+1,$data['id'],$html='----');
            }
        }

        return $temp;
    }

    /**
     * 将数组转换为树状结构：
     */
    public function tree_list($datas,$pid=0){
        $temp=[];
        foreach($datas as $data){
            if($data['pid']==$pid){
                $data['son']=$this->tree_list($datas,$data['id']);
                $temp[]=$data;
            }
        }
        return $temp;
    }
}