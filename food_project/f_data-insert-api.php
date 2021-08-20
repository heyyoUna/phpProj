<?php
include __DIR__. '/food_partials/01-init.php';

header('Content-Type: application/json');

// 上傳後的檔案要放在哪裡
$folder = __DIR__. './img/';

// echo json_encode($_POST['ar_title'], JSON_UNESCAPED_UNICODE);

$output = [
    'success' => false,
    'error' => '',
    'rowCount' => 0,
    'postData' => $_POST,
];


if(! empty($_FILES)){

    if(move_uploaded_file(
      $_FILES['ar_pic']['tmp_name'], 
      $folder.$_FILES['ar_pic']['name']
    )){
        $sql = "INSERT INTO `Column`(
               `sid`, `ar_title`, `ar_pic`, `ar_author`,
               `ar_date`, `ar_highlight`, `ar_content01`, `ar_content02`
               ) VALUES (
                   'NULL', ?, '[PW-]', ?,
                    ?, ?, ?, ?
               )";

$stmt = $pdo->prepare($sql);



$stmt->execute([
    $_POST['ar_title'],
    $_FILES['ar_pic']['name'],
    $_POST['ar_author'],
    $_POST['ar_date'],
    $_POST['ar_highlight'],
    $_POST['ar_content01'],
    $_POST['ar_content02'],
]);

$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
} else {
    $output['error'] = '圖片未上傳';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}


}
}
