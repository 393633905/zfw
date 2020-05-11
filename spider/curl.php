<?php
function curl($url,$data,$post=true,$https=true){
    $resource=curl_init($url);
    if($post){
        curl_setopt($resource,CURLOPT_POST,true);//post请求
        curl_setopt($resource,CURLOPT_POSTFIELDS,$data);
    }

    if($https){
        //禁止证书验证：
        curl_setopt($resource,CURLOPT_SSL_VERIFYPEER,false);
    }

    //执行返回数据结果，而不是布尔类型
    curl_setopt($resource,CURLOPT_RETURNTRANSFER,true);
    $res=curl_exec($resource);
    curl_close($resource);

    return $res;
}