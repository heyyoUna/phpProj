<?php
include __DIR__. './food_partials/01db_connect.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if(! empty($sid)){
    $sql = "DELETE FROM `Column` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}

// $_SERVER['HTTP_REFERER'] 從哪個頁面連過來的
// 不一定有資料
// 看起來好像頁面沒變，但其實已經從delete頁面，再回來list頁面
if(isset($_SERVER['HTTP_REFERER'])){
    header("Location: ". $_SERVER['HTTP_REFERER']); //確認server有沒有送HTTP_REFERER這個檔頭過來
} else {
    header('Location: f_data-list.php'); //若無，回到data-list頁面 
}


