<?php
include __DIR__.'/curl.php';
require __DIR__.'/vendor/autoload.php';
//使用QueryList采集：
use QL\QueryList;
//从数据库中获取url和id：
$dsn='mysql:host=localhost;port=3306;charset=utf8;dbname=wwwzfwcom';
$pdo=new PDO($dsn,'root','393633905');
$sql='select id,url from zfw_articles';
$res=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

//采集：
array_map(function($item) use($pdo){
    $url=$item['url'];
    $id=$item['id'];
    if(!empty($url)){//如果url不为空，则表明此文章需采集过
        $contents=QueryList::Query($url,[
            'content'=>['.bd','html']
        ])->data;
        //获取文章内容更新到数据库中：
        $content=$contents[0]['content'];
        $sql="update zfw_articles set url=?, content=? where id=?";
        $pdo->prepare($sql)->execute(['',$content,$id]);
    }
},$res);