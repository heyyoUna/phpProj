<?php
include __DIR__. '/partials/init.php';


/* 透過$_GET確認有沒有sid，沒有的話給0;
若empty() 括號的值/陣列/字串是空的，就會拿到true
若！empty()內不是空的，就會執行$sql(直接刪除)
*/
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if(! empty($sid)){
    $sql = "DELETE FROM `address_book_0814` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}

// $_SERVER['HTTP_REFERER'] 從哪個頁面連過來的
// 不一定有資料
// 看起來好像頁面沒變，但其實已經從delete頁面，再回來list頁面
if(isset($_SERVER['HTTP_REFERER'])){
    header("Location: ". $_SERVER['HTTP_REFERER']); //確認server有沒有送HTTP_REFERER這個檔頭過來
} else {
    header('Location: data-list.php'); //若無，回到data-list頁面 
}


