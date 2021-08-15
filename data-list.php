
<?php 
include __DIR__. '/partials/init.php';
$title = '資料列表' ;

// 集中在此 php 區塊，要資料

//固定每頁最多幾筆
$perPage = 3;

//用戶決定看第幾頁，預設值為1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//總筆數
//透過query會拿到只有一個欄位的一筆資料(Recordset)；用索引式陣列顯示第一欄(fetch_num)
$totalRows = $pdo->query("SELECT count(1) FROM address_book_0814")->fetch(PDO::FETCH_NUM)[0];
echo "$totalRows,";

//確定總頁數，才可確定分頁按鈕 (總頁數 ＝ 總筆數 / 每頁顯示筆數)
// ceil 正數時無條件進位
$totalPage = ceil($totalRows/$perPage);
echo "$totalPage "; exit;




    $rows = $pdo
    ->query("SELECT * FROM address_book_0814 ORDER BY sid DESC LIMIT 4 ")
    ->fetchall();
            // 透過降冪的sid排序，ORDER BY sid DESC
            // order & limit 順序不可變



?>


<!-- 從head開始到foot結束，都當作view的部分，僅負責資料呈現；資料讀取、控制器觸發都不要放在這 -->
<?php include __DIR__. '/partials/html-head.php'; ?>
<!-- 從head往下，就是html的內容輸出 -->

<?php include __DIR__. '/partials/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <!-- SELECT `sid`, `name`, `email`, `mobile`, `birthday`, `address`, `created_at` FROM `address_book_0814` WHERE 1 -->
                        <th scope="col">sid</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">mobile</th>
                        <th scope="col">birthday</th>
                        <th scope="col">address</th>
                    </tr>
                 </thead>

                <tbody>
                <!-- 一筆就是一個tr，用迴圈把tbody內的tr包起來 -->
                <?php foreach($rows as $r):?>  
                    <tr>
                        <td><?= $r['sid'] ?></td>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= $r['mobile'] ?></td>
                        <td><?= $r['birthday'] ?></td>
                        <td><?= $r['address'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
             </table>


        </div>
    </div>



    <!-- (每句?外層都有<>，拿掉才可註解成功)
        ?php foreach($rows as $r):?
        ?php foreach($rows as $r):?
        <h2> ?= $r['name'] ? </h2>
        ?php endforeach; ?   -->
</div>

<?php include __DIR__. '/partials/scripts.php'; ?>
<?php include __DIR__. '/partials/html-foot.php'; ?>




 <!-- 可以在任何位置，取得資料庫的某一張資料表資料；
 但不建議在任何地方要資料，建議集中在最前面；
目前沒有用任何框架，寫法彈性，但在專案協作時，較難找到每人不同的存放資料位置 -->


 <!-- MVC, Model-View-controller : 程式設計的設計模型 design pattern；
 model 針對資料；
view (視圖)呈現給用戶的畫面 -> 用戶透過畫面點擊按鈕，連到特訂的url -> view 透過url觸動controller(控制器) -> controller 請 model(模型) 去找資料 -> model再到database取。
圖解 https://tinyurl.com/3sjsw7py -->