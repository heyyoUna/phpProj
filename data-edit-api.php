<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

// 避免直接拜訪時的錯誤訊息(只要有一欄位是空的，就跳出)
if(
    empty($_POST['sid']) or
    empty($_POST['name']) or
    empty($_POST['email']) or
    empty($_POST['mobile']) or
    empty($_POST['birthday']) or
    empty($_POST['address'])
){
    echo json_encode($output);
    exit;
}


// 資料格式檢查
if(mb_strlen($_POST['name'])<2){
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}

if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 420;
    echo json_encode($output);
    exit;
}

//mysql中的update語法；sid是條件，放到最後；沒有加where就會動到整個資料庫
$sql = "UPDATE `address_book_0814` SET 
                          `name`=?,
                          `email`=?,
                          `mobile`=?,
                          `birthday`=?,
                          `address`=?
                          WHERE `sid`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['email'],
    $_POST['mobile'],
    $_POST['birthday'],
    $_POST['address'],
    $_POST['sid'],
]);

$output['rowCount'] = $stmt->rowCount(); // 修改的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}

echo json_encode($output);
