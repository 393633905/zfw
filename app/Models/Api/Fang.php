<?php

namespace App\Models\Api;

use App\Models\BaseModel;
use App\Models\FangAttr;
use App\Models\FangOwner;
use Illuminate\Database\Eloquent\Model;

class Fang extends BaseModel
{
//    protected $appends=['shi_ting'];
//

    protected $appends=['fang_banner','fang_shi_ting'];

    protected $hidden=['fang_shi','fang_ting'];
    //当要使用访问器自定义字段时：先使用appends追加字段，但是得提前把处理过程中需要用到的字段查询出来
    public function getFangBannerAttribute(){
        return config('wechat.host').explode('#',$this->attributes['fang_pic'])[0];
    }

    public function getFangShiTingAttribute(){
        return $this->attributes['fang_shi'].'室'.$this->attributes['fang_ting'].'厅'.$this->attributes['fang_wei'].'卫';
    }

    public function  getFangPicAttribute(){
        $arr=explode('#',trim($this->attributes['fang_pic'],'#'));
        return array_map(function($item){
            return config('wechat.host').$item;
        },$arr);
    }

    public function getFangRentTypeAttribute(){
        return FangAttr::where('id',$this->attributes['fang_rent_type'])->value('name');
    }

    public function getFangRentClassAttribute(){
        return FangAttr::where('id',$this->attributes['fang_rent_class'])->value('name');
    }

    //关联查询：
    public function owner(){
        return $this->belongsTo(FangOwner::class,'fang_owner','id');
    }


}
