<?php
include __DIR__. '/food_partials/01db_connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];



if(mb_strlen($_POST['ar_title']) < 3){
    $output['error'] = '請填寫文章標題';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}

//正確做法，將外來資料都視為不安全，用？代替，不必再用單引號包
//若要用錯誤寫法，則要幫每一項變數做sql跳脫， echo $pdo->quote($data);
$sql = "INSERT INTO `Column`(
               `ar_title`, `ar_pic`, `ar_author`,
               `ar_date`, `ar_highlight`, `ar_content01`, `ar_content02`
               ) VALUES (
                    ?, ?, ?,
                    ?, ?, ?, ?
               )";

//query是直接執行，現在只是要prepare
//prepare缺點，無法看到最後執行的sql樣子
//execute直接執行
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['ar_title'],
    $_POST['ar_pic'],
    $_POST['ar_author'],
    $_POST['ar_date'],
    $_POST['ar_highlight'],
    $_POST['ar_content01'],
    $_POST['ar_content02'],
]);

$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
}

echo json_encode($output);

/*
echo json_encode([
    //rowcount如果有新增，就會拿到新增的筆數；如果用select就是讀取的筆數
    'rowCount' => $stmt->RowCount(), 
    'postData' => $_POST, //確認傳送過來的資料樣子
]);
*/
