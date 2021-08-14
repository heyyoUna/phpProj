<?php

require __DIR__. '/init.php';


// statment 縮寫，操作資料
// $stmt = $pdo->query("SELECT * FROM address_book_0814");
$stmt = $pdo->query("SELECT * FROM address_book_0814 LIMIT 3");
//PDO::query 給sql指定一個代理人(pdoStatement)；第1個參數放sql，第2 & 3可省略；回傳類型pdoStatement



//拿到資料
//在test_db.php檔，已告知拿資料時，每筆變成關聯式陣(fetch_assoc)，括號內可空白
// PDO::FETCH_NUM 就會改為索引式陣列；
//both 索引＆關聯都改(兩份資料)；
//建議使用assoc有欄位名稱比較好對
//重複print_r整句，可拿到再下一筆fetch資料；如果是json，會破壞json格式
// print_r($stmt->fetch(PDO::FETCH_ASSOC));


//轉換成json檔案
//fetch是僅拿1筆資料；fetchAll則拿所有資料，耗記憶體，建議在指定資料庫時，加上limit筆數

echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);

