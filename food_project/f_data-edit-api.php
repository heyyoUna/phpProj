<?php
include __DIR__. '/food_partials/01-init.php';

header('Content-Type: application/json');
$folder = __DIR__. '/img/';

$sid = ($_POST['sid']); 
$sql = "SELECT * FROM `Column` WHERE `sid` = $sid;";


$row = $pdo->query($sql)->fetch();

$output = [
    'success' => false,
    'error' => '欄位資料不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

// 避免直接拜訪時的錯誤訊息(只要有一欄位是空的，就跳出)
if(
    empty($_POST['ar_title']) 
    // empty($_POST['ar_cate']) or
    // empty($_POST['ar_pic']) or
    // empty($_POST['ar_author']) or
    // empty($_POST['ar_date']) or
    // empty($_POST['ar_highlight']) or
    // empty($_POST['ar_content01']) or
    // empty($_POST['ar_content02']) 
) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$isSaved = false;

if(! empty($_FILES)){
    if(move_uploaded_file(
      $_FILES['ar_pic']['tmp_name'], 
      $folder.$_FILES['ar_pic']['name']
    )){
        //mysql中的update語法；sid是條件，放到最後；沒有加where就會動到整個資料庫
        $sql = "UPDATE `Column` SET 
        `ar_title`=?,
        `ar_cate`=?,
        `ar_pic`=?,
        `ar_author`=?,
        `ar_date`=?,
        `ar_highlight`=?,
        `ar_content01`=?,
        `ar_content02`=?
        WHERE `sid`=?";

        $stmt = $pdo->prepare($sql);


// 資料格式檢查
if(mb_strlen($_POST['ar_title']) < 3){
    $output['error'] = '請填寫完整文章標題';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}


$stmt->execute([
    $_POST['ar_title'],
    $_POST['ar_cate'],
    $_FILES['ar_pic']['name'],
    $_POST['ar_author'],
    $_POST['ar_date'],
    $_POST['ar_highlight'],
    $_POST['ar_content01'],
    $_POST['ar_content02'],
    $_POST['sid']
]);

if($stmt->rowCount()){
    $isSaved = true; 
    $output['error'] = 'no error';
    $output['success'] = true;

    echo json_encode($output);
    exit;
        }
    }
}

if(! $isSaved){
    $sql = "UPDATE `Column` SET 
    `ar_title`=?,
    `ar_cate`=?,
    `ar_pic`=?,
    `ar_author`=?,
    `ar_date`=?,
    `ar_highlight`=?,
    `ar_content01`=?,
    `ar_content02`=?
    WHERE `sid`=?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        $_POST['ar_title'],
        $_POST['ar_cate'],
        $_FILES['ar_pic']['name'],
        $_POST['ar_author'],
        $_POST['ar_date'],
        $_POST['ar_highlight'],
        $_POST['ar_content01'],
        $_POST['ar_content02'],
        $_POST['sid']
]);

if($stmt->rowCount()){
    $output['error'] = '沒有更新圖片';
    $output['success'] = true;
}
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
