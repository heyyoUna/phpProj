<?php

//查看session狀態，用來除錯
//登入成功後，可透過此檔，看到該用戶資料
session_start();
echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
