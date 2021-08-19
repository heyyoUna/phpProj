<?php
include __DIR__. './food_partials/01db_connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$output = [
    'success' => false,
    'error' => '沒有給 sid',
    'sid' => $sid,
];

if(! empty($sid)){  //如果是空值，就直接跳到結尾echo；不是空值，才跑內部程式
    $sql = "DELETE FROM `Column` WHERE sid=$sid";
    $stmt = $pdo->query($sql);

    if($stmt->rowCount()==1){   //如成功刪除一筆，要進行的程式
        $output['success'] = true;
        $output['error'] = '';
    } else {    //有sid，但不是對應的sid
        $output['error'] = '沒有刪除成功（可能沒有該筆資料）';
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);

