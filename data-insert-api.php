<?php
include __DIR__. '/partials/init.php';
// 且init檔案，內含db_connect，這樣才會連到資料庫

// 把post進來的資料，原原本本的回傳回去
// echo json_encode($_POST);
// print_r($_POST);



//sid 是primary key，設定是null，可自動產生
//sql 外層雙引號，內層單引號
//把資料拼成sql格式新增
//不建議的作法
$sql = "INSERT INTO `address_book_0814`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        '{$_POST['name']}', '{$_POST['email']}', '{$_POST['mobile']}', 
        '{$_POST['birthday']}', '{$_POST['address']}', NOW()
     )";


$stmt = $pdo->query($sql);
echo json_encode([
    //rowcount如果有新增，就會拿到新增的筆數；如果用select就是讀取的筆數
    'rowCount' => $stmt->RowCount(), 
    'postData' => $_POST, //確認傳送過來的資料樣子
]);







