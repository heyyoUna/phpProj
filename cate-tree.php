<?php
include __DIR__. '/partials/init.php';
/*
    網站的效能 (不考慮頻寬的限制下)
        1. request 數量 (影響到 web server 效能)
        2. 後端程式的複雜度 (PHP)
        3. 資料庫連線 (DB query)
 */

// ALTER TABLE `categories` ADD `sequence` INT NOT NULL DEFAULT '100' AFTER `parent_sid`;

// 拿到第一層的選單資料
// $sql = "SELECT * FROM `categories` WHERE `parent_sid`=0 ORDER BY `sequence`";

$sql = "SELECT * FROM `categories` ORDER BY `sequence`";
$rows = $pdo->query($sql)->fetchAll();

$cate1 = [];
foreach($rows as $r){
    if($r['parent_sid']==0){
        $cate1[] = $r;
    }
}
/*
foreach($cate1 as $k => $c){
    foreach($rows as $r){
        if($r['parent_sid']==$c['sid']){
            // $c['nodes'][] = $r;  // 因為 set by value, 無法設定到 $cate1 裡
            $cate1[$k]['nodes'][] = $r;
        }
    }
}
*/

// 設定第二層
foreach($cate1 as &$c){
    foreach($rows as $r){
        if($r['parent_sid']==$c['sid']){
            $c['nodes'][] = $r;
        }
    }
}



echo json_encode($cate1, JSON_UNESCAPED_UNICODE);