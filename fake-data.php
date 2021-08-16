<?php
include __DIR__. '/partials/init.php';
// init檔案，內含db_connect，這樣才會連到資料庫

header('content-type: application/json');


$sql = "INSERT INTO `address_book_0814`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?, 
        ?, ?, NOW()
     )";

// prepare 放外面
$stmt = $pdo->prepare($sql);


//姓名亂數
$str = '一位日本法學教師去星巴克點飲料意外發現店員也在杯身上寫下六法全書的內容圖擷取自推特';
$chrArray = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);


//for內部為要執行的內容
//產生100筆假資料
for($i=0; $i<100; $i++){

    shuffle($chrArray);
    // $ar = array_slice($chrArray, 0, 3);
    $name = implode('', array_slice($chrArray, 0, 3)); //跟$ar定義列合併
    
    $stmt->execute([
        $name, 
        uniqid(). '@test.com', 
        '09'.strval(rand(10000000, 99999999)),  //strval轉換為字串；rand(範圍區間)
        date('Ｙ-m-d', rand(strtotime('1990-01-01'), strtotime('2000-12-31'))), //在此區間內的隨機日期
        '台北市', 
    ]);


}



echo 'ok';









