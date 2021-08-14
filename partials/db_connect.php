<?php


$db_host = 'localhost'; //設定要連到的主機 
$db_name = 'mfee19'; //設定要連到的資料庫
$db_user = 'root'; 
$db_pass = '';

// date source name 
$dsn = "mysql:host={$db_host};dbname={$db_name};charset=udf8"; //引號內容，不要加任何空格




//建立連線 
//(兩個冒號，代表此常數是定義在類別的，ATTR為類別)
$pdo_options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //錯誤的模式，要用例外的模式
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //在拿資料時，每筆都會變成關聯式陣列
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", //一開始連線後，要執行sql的敘述
]; 

// 如果沒有要做錯處理，可以直接連線
$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
 