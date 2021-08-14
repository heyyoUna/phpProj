<?php

require __DIR__. '/init.php';


$stmt = $pdo->query("SELECT * FROM address_book_0814 LIMIT 4");


//透過while迴圈取得所有資料
//在limit範圍內， 一次拿一筆，拿到空值為止
//$r 呼叫後面的布林值，把回傳的內容，設定給$r變數；如果有值，$r就會是true；往下一直抓到沒有資料(回傳空值)，$r變成false，結束迴圈
while($r = $stmt->fetch()){
    echo "<p>{$r['sid']}. {$r['name']}</p>";  //外面用雙引號，裡面可以塞變數
}
 