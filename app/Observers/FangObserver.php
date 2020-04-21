<?php
namespace App\Observers;
use App\Models\Fang;
class FangObserver{

    //执行添加功能前，此方法会被执行：
    public function creating(Fang $fang){

    }

    //执行添加功能后，此方法会被执行：
    public function created(Fang $fang){
       // $this->esadd($fang);

        //发送消息给客户
    }

    //添加房源标题和房源简介到es索引中：
    public function esadd(Fang $fang){
        $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('es.host'))->build();
        // 写文档
        $params = [
            'index' => 'fang',
            'type' => '_doc',
            'id' => $fang->id,
            'body' => [
                'fang_title' => $fang->fang_name,
                'fang_desn' => $fang->fang_desn,
            ],
        ];
        $response = $client->index($params);
    }

    public function updated(Fang $fang){
        $this->esadd($fang);
    }

}