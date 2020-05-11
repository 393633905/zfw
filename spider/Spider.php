<?php
//__DIR__表示：D:/wamp/www/test/www.zfw.com/spider

include __DIR__.'/curl.php';
require __DIR__.'/vendor/autoload.php';



//使用QueryList采集：
use QL\QueryList;
//数据入库：
$dsn='mysql:host=localhost;port=3306;charset=utf8;dbname=wwwzfwcom';
$pdo=new PDO($dsn,'root','393633905');


//采集数据：获取页数
//$html=file_get_contents('https://news.ke.com/bj/baike/0033/');
$html='https://news.ke.com/bj/baike/0033/';
$dataList=QueryList::Query($html,[
    'total'=>['.box-r>.page-box','page-data'],//采集总页数
])->data;

//总的数据页数：
//$pageCount=json_decode($dataList[0]['total'])->totalPage;
//执行采集：
for($page=1;$page<=2;$page++){
    //$html=file_get_contents("https://news.ke.com/bj/baike/0033/pg{$page}/");
    $html="https://news.ke.com/bj/baike/0033/pg{$page}/";
    $datas=QueryList::Query($html,[
        'title'=>['.text>.tit','text'],
        'desn'=>['.summary','text'],
        'pic'=>['.lj-lazy','data-original','',function($item){
            //将图片保存在本地：dirname(__DIR__)=此项目根路径
            $filename=md5($item).'.'.pathinfo($item,PATHINFO_EXTENSION);
            $filepath=dirname(__DIR__).'/public/uploads/article/'.$filename;
            file_put_contents($filepath,curl($item,[],false,true));//将文件保存在本地
            return '/uploads/article/' . $filename;
        }],
        'url'=>['.text>.tit','href'],
    ])->data;

    // 入库
    foreach ($datas as $val) {
        // 添加的sql预处理
        $sql = "insert into zfw_articles (title,desn,pic,url,content) values (?,?,?,?,'')";
        $stmt = $pdo->prepare($sql);
        // 入库
        $stmt->execute([$val['title'], $val['desn'], $val['pic'], $val['url']]);
    }
}




