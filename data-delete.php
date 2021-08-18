<?php
include __DIR__. '/partials/init.php';
// init檔案，內含db_connect，這樣才會連到資料庫


/* 透過$_GET確認有沒有sid，沒有的話給0;
若empty() 括號的值/陣列/字串是空的，就會拿到true
若！empty()內不是空的，就會執行$sql(直接刪除)
*/
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if(! empty($sid)){
    $sql = "DELETE FROM `address_book_0814` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}

header('Location: data-list.php'); //網頁刪除完，直接跳回data-list頁面