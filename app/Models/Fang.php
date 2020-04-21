<?php

namespace App\Models;

use App\Observers\FangObserver;
use GuzzleHttp\Client;

class Fang extends BaseModel
{
    public static function boot(){
        parent::boot();
        self::observe(FangObserver::class);
    }

    //获取全部房源属性数据：
    //根据与之对应的field_name名称，查到此属性的id,
    //然后使用where('pid','id')->get()获取当前属性类的所有之类，以便于下拉选择
    public function getRelationData(){
        //1.省份地址：
        $cityData=City::where('pid',0)->get();
        //2.房屋朝向属性：
        $fang_direction_id=FangAttr::where('field_name','fang_direction')->value('id');
        $fang_direction_data=FangAttr::where('pid',$fang_direction_id)->get();
        //3.租赁方式数据：
        $fang_rent_class_id=FangAttr::where('field_name','fang_rent_class')->value('id');
        $fang_rent_class_data=FangAttr::where('pid',$fang_rent_class_id)->get();
        //4.业主：
        $ownerData=FangOwner::get();
        //5.租期方式：
        $fang_rent_type_id=FangAttr::where('field_name','fang_rent_type')->value('id');
        $fang_rent_type_data=FangAttr::where('pid',$fang_rent_type_id)->get();
        //6.配套设施：
        $fang_config_id=FangAttr::where('field_name','fang_config')->value('id');
        $fang_config_data=FangAttr::where('pid',$fang_config_id)->get();

        //返回数据：
        return [
            'cityData'=>$cityData,
            'fang_direction_data'=>$fang_direction_data,
            'fang_rent_class_data'=>$fang_rent_class_data,
            'ownerData'=>$ownerData,
            'fang_rent_type_data'=>$fang_rent_type_data,
            'fang_config_data'=>$fang_config_data
        ];
    }

    public function getCityName($id){
        return City::where('id',$id)->value('name');
    }

    /**
     * 使用Guzzle 进行CURL请求：
     */
    public function get($url){
        $client=new Client([
            'timeout'=>5,
            'verify'=>false,
        ]);
        $res=$client->get($url);
        $body=(string)$res->getBody();
        return json_decode($body,true);
    }

    /**
     * 将真实地址转换为经纬度存储
     */
    public function transAddress($address,$city){
        $url=config('gaode.transform_add');
        $url=sprintf($url,$address,$city);
        //请求api:
        $body=$this->get($url);

        return $body;
    }


    //模型关联：
    public function owner(){
        return $this->belongsTo(FangOwner::class,'fang_owner','id');
    }
    //以房屋表为主，朝向属性对应多个房子，故反过来是属于关系
    public function direction(){
        return $this->belongsTo(FangAttr::class,'fang_direction','id');
    }
    //以房屋为准，租赁方式属性对应多个房子，故反过来是属于关系
    public function rent(){
        return $this->belongsTo(FangAttr::class,'fang_rent_class','id');
    }



    /**
     *  修改器：在入库时对数据进行操作
     *  将配套设施传入的数组数据转换为字符串：
     */
    public function setFangConfigAttribute($value){
        $this->attributes['fang_config']=implode(',',$value);
    }

    /**
     * 访问器：配套设施数据
     */
    public function getFangConfigAttribute(){
        return  explode(',', $this->attributes['fang_config']);
    }

    /**
     * 访问器：将显示的房源图片数据转换转换为数组:
     */
    public function changeFangPicToArray(){
        return explode('#',rtrim($this->attributes['fang_pic'],'#'));
    }

    /**
     * 房屋出租和未出租统计：
     */
    public function getRentData(){
        //房屋总数量：
        $total_num=self::count();
        //房屋已出租数量：
        $rent_num=self::where('fang_status',1)->count();
        //房屋未出租数量：
        $no_rent_num=$total_num-$rent_num;

        return ['rent_num'=>$rent_num,'no_rent_num'=>$no_rent_num];
    }



}
