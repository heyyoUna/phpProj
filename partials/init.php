<?php

require __DIR__. '/db_connect.php';

// 如果沒有啟用session，就啟用他
if(! isset($_SESSION)){
    session_start();
}

// 因為navbar.php有使用session，所以所有～～有串此檔案的其他檔案，都要加上session_start；透過串接寫入該變數的init.php，方便管理 