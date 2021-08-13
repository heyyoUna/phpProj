<?php

//查看session狀態，用來除錯
//登入成功後，可透過此檔，看到該用戶資料
session_start();
// session_destroy() //清除所有的session，如果下在購物車，就會將購物車內的資料一起清掉
unset($_SESSION['user']);    //unset移除變數設定、移除陣列內的元素


header('location: index_.php');  //直接redirection


// 在index_.php 按下登出後，網頁不變；但在檢查network時，會出現status 302的logout.php

// 在session內的變數名稱為user -> 會員的登入登出；若要增加管理者的登入登出，可新增admin的session變數