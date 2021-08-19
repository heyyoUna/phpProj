<?php

require __DIR__. '/db_connect.php';

// 如果沒有啟用session，就啟用他
if(! isset($_SESSION)){
    session_start();
}
