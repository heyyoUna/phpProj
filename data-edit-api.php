
<?php
include __DIR__. '/food_project/food_partials/01db_connect.php';

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
    empty($_POST['ar_title']) or
    empty($_POST['ar_author']) or
    empty($_POST['ar_date']) or
    empty($_POST['ar_highlight']) or
    empty($_POST['ar_content01']) or
    empty($_POST['ar_content02']) 
){
    echo json_encode($output);
    exit;
}


// 資料格式檢查
if(mb_strlen($_POST['ar_title']) < 3){
    $output['error'] = '請填寫完整文章標題';
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
$sql = "UPDATE `Column` SET 
                          `ar_title`=?,
                          `ar_pic`=?,
                          `ar_author`=?,
                          `ar_date`=?,
                          `ar_content01`=?,
                          `ar_content02`=?
                          WHERE `sid`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['ar_title'],
    $_POST['ar_pic'],
    $_POST['ar_author'],
    $_POST['ar_date'],
    $_POST['ar_content01'],
    $_POST['ar_content02'],
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
