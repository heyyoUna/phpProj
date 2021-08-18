<?php
    include __DIR__. '/partials/init.php';
    $title = '修改資料';

    //拿到primary key
    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

    $sql = "SELECT * FROM `address_book_0814` WHERE sid=$sid";
    $row = $pdo->query($sql)->fetch();
    
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
    