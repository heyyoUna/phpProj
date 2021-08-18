<?php 

//啟動session 功能
session_start();

//可以登入的用戶資料(為方便操作，先寫死)
$users = [          //同時輸入多組帳密
    'shin' => [     //帳號
        'pw' => '123',      //密碼
        'nickname' => '小明',
    ],

    'dear123' => [
        'pw' => '321',
        'nickname' => '小華',
    ],
];

//要輸出的格式
$output = [     
    'success' => false,
    'error' => '',  //警示資訊
    'code' => 0,    //追蹤碼
];

//判斷有無帳號/密碼
if (!isset($_POST['account']) or !isset($_POST['password'])){
    $output['error'] = '沒有帳號/密碼';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


//先判斷有沒有該帳號
if(! isset($users[$_POST['account']])){
    $output['error'] = '帳號錯誤';
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;  //直接離開(中斷)程式 -> 發現帳號錯誤時，不用再比對密碼，直接離開
    // die('中斷訊息');    //和exit 功能相同
}
// 表單送出時，會拿到name='account' ＋ name = 'password'兩個欄位
// name='account'此欄位過來的值(帳號的字串)，變成post
// 把帳號的字串當作key放進來後，就會去對應後台的資料庫
// 有對應到$users的array，會再去對應內部(使用者)array
// 如果沒有對應到(尚未設定)，就會出現output的error
// 用迴圈一個個比對太麻煩了!，推薦if



//判斷密碼
$userData = $users[$_POST['account']]; //如果帳號正確，再去對內層array
if ($_POST['password'] !== $userData['pw']){
    $output['error'] = '密碼錯誤';
    $output['code'] = 405;
    // echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    // exit;
    //if else 最後都會走到最底下的echo，此處的echo & exit 可省略
    
} else {        //密碼正確
    $output['success'] = true;
    $output['code'] = 200;


    //保留登入的狀態
    $_SESSION['user'] = [   //此user變數為自定義
        'account' => $_POST['account'],
        'nickname' => $userData['nickname'],
    ];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
//錯誤會走if；正確會直接跑到這




// <!-- 之後的範例檔名有加『api』，代表設定後端的程式，該程式不會有畫面，用於回覆json資料；
// Application Programming Interface(API):介於程式與電腦間的應用程式介面；接收到資料，回應對方所需的資料 ex.收到formData post 過來的資料， 回應json的格式 -->
