<?php
include __DIR__. '/partials/init.php';
// init檔案，內含db_connect，這樣才會連到資料庫

header('content-type: application/json');

$output = [
    'success' => false, //確認是否新增成功
    'error' => '',  //錯誤訊息
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];





//資料格式檢查
/*
檢查在前端為初步格式確認，重點在後端；
filter_var: 使用特定的篩選器，篩選變數；
亦可使用 Regular Express 篩選
//若前面的email為email格式，filter_var就會回傳值；若否，則回傳false
var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL)); 

var_dump(filter_var('http://example.com', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)); 
*/
// strlen — 確認字串長度；中文使用mb_strlen; mb 代表多國語言(亞洲語系)
//如果姓名最低長度要求改為3(前端保持2)，網頁上沒變化，但在檢查network, preview 會跳出預設的警示訊息，並發送失敗
if(strlen($_POST['name']) < 2){
    $output['error'] = '姓名長度太短';
    $output['code'] = '410';

    echo json_encode($output);
    exit;
}

//檢查post過來的email欄位，透過後面的條件
if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $output['error'] = 'email格式錯誤';
    $output['code'] = '420';
    echo json_encode($output);
    exit;
}


// 把post進來的資料，原原本本的回傳回去
// echo json_encode($_POST);
// print_r($_POST);



//sid 是primary key，設定是null，可自動產生
//sql 外層雙引號，內層單引號
//把資料拼成sql格式新增
//不建議的作法，當用戶在欄上使用到單引號，會出現sql錯誤，可能受到SQL injection攻擊
/* 
$sql = "INSERT INTO `address_book_0814`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        '{$_POST['name']}', '{$_POST['email']}', '{$_POST['mobile']}', 
        '{$_POST['birthday']}', '{$_POST['address']}', NOW()
     )";

$stmt = $pdo->query($sql); 
*/

//正確做法，將外來資料都視為不安全，用？代替，不必再用單引號包
//若要用錯誤寫法，則要幫每一項變數做sql跳脫， echo $pdo->quote($data);
    $sql = "INSERT INTO `address_book_0814`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?, 
        ?, ?, NOW()
     )";

//query是直接執行，現在只是要prepare
//prepare缺點，無法看到最後執行的sql樣子
//execute直接執行
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'], $_POST['email'], $_POST['mobile'], 
    $_POST['birthday'], $_POST['address'], 
]);

$output['rowCount'] = $stmt->rowCount();    //新增的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
}

echo json_encode($output);

/*
echo json_encode([
    //rowcount如果有新增，就會拿到新增的筆數；如果用select就是讀取的筆數
    'rowCount' => $stmt->RowCount(), 
    'postData' => $_POST, //確認傳送過來的資料樣子
]);
*/









