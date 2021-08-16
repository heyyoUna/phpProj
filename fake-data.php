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


//for內部為要執行的內容
for($i=0; $i<100; $i++){
    
    $stmt->execute([
        $_POST['name'], 
        $_POST['email'], 
        $_POST['mobile'], 
        $_POST['birthday'], 
        $_POST['address'], 
    ]);


}



echo 'ok';









