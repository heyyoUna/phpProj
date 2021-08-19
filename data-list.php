<?php
    include __DIR__. '/partials/init.php';
    $title = '資料列表';

// 集中在此 php 區塊，要資料
// 可以在任何位置，取得資料庫的某一張資料表資料；
// 但不建議在任何地方要資料，建議集中在最前面；
// 目前沒有用任何框架，寫法彈性，但在專案協作時，較難找到每人不同的存放資料位置 


//  MVC, Model-View-controller : 程式設計的設計模型 design pattern；
// model 針對資料；
// view (視圖)呈現給用戶的畫面 -> 用戶透過畫面點擊按鈕，連到特訂的url -> view 透過url觸動controller(控制器) -> controller 請 model(模型) 去找資料 -> model再到database取。
// 圖解 https://tinyurl.com/3sjsw7py 


//步驟流程(1)固定每頁筆數 (2)用戶決定看第幾頁 (3)總筆數 (4)總頁數 (5)資料呈現

    // 固定每一頁最多幾筆
    $perPage = 5;

    // query string parameters
    $qs = [];

    // 關鍵字查詢
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    // 用戶決定查看第幾頁，預設值為 1
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $where = ' WHERE 1 ';
    if(! empty($keyword)){
        // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞
        $where .= sprintf(" AND `name` LIKE %s ", $pdo->quote('%'. $keyword. '%'));

        $qs['keyword'] = $keyword;
    }



//總筆數
//透過query會拿到只有一個欄位的一筆資料(Recordset)；用索引式陣列顯示第一欄(fetch_num)
    $totalRows = $pdo->query("SELECT count(1) FROM address_book_0814 $where ")
        ->fetch(PDO::FETCH_NUM)[0];


//確定總頁數，才可確定分頁按鈕 (總頁數 ＝ 總筆數 / 每頁顯示筆數)
// ceil 正數時無條件進位
    $totalPages = ceil($totalRows / $perPage); 

    $rows = [];
    // 要有資料才能讀取該頁的資料
    if($totalRows!=0) {


        // 讓 $page 的值在安全的範圍
        if ($page < 1) {
            header('Location: ?page=1');
            exit;
        }
        if ($page > $totalPages) {
            header('Location: ?page=' . $totalPages);
            exit;
        }

// SELECT * FROM address_book_0814 ORDER BY sid DESC LIMIT 0, 5 
// limit 0,5 ：從第1筆開始，最多取5筆
// %s 佔位置
// 透過降冪的sid排序，ORDER BY sid DESC；因為是降冪，抓取資料將從最大值的sid當作第一筆
// order & limit 順序不可變
//如果總筆數是0，會使總頁數也是0，導致輸出錯誤
        $sql = sprintf("SELECT * FROM address_book_0814 %s ORDER BY sid DESC LIMIT %s, %s",
            $where,
            ($page - 1) * $perPage,
                $perPage);

        $rows = $pdo->query($sql)->fetchAll();   // 在網址後面加 ?page=2 ，查看第二頁內容；頁面設為負值，就會語法錯誤；超過有效頁數，會顯示僅會顯示標題列(不會錯誤)

    }
?>

<!-- 從head開始到foot結束，都當作view的部分，僅負責資料呈現；資料讀取、控制器觸發都不要放在這；從head往下，就是html的內容輸出 -->
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
    <style>
        table tbody i.fas.fa-trash-alt {
            color: darkred;
        }
        table tbody i.fas.fa-trash-alt.ajaxDelete {
            color: darkorange;
            cursor: pointer;
        }
    </style>
<div class="container">
    <!-- 關鍵字搜尋 -->
    <div class="row" >
        <div class="col">
            <form action="data-list.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search"
                       value="<?= htmlentities($keyword) ?>"
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">

                    <li class="page-item">
                            <a class="page-link" href="?page=<?= 1 ?>">
                            第一頁
                            </a></li>

                    <!-- 在li的class直接下disabled，就會使整個左箭頭失效；下三元陣列，設定頁數小於1，才失效-->
                    <li class="page-item <?= $page<=1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page-1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>


                    <!-- ?page 當連結由問號開頭，代表該url資源，是目前撰寫中的檔案 -->
                    <!-- 如果aclass直接下active，選擇任一分頁後，全部分頁選項都會反白；下三元陣列，設定只有選定的頁面會反白 -->
                    <!-- 透過$i=$page-5; $i<=$Page+5 讓頁碼最多一次出現11個 -->
                    <!-- 把頁碼顯示錯寫成無限迴圈，資料庫直接掛掉(i=$page-5; $i=$Page+5) -->
                    <?php for($i=$page-5; $i<=$page+5; $i++):
                        if($i>=1 and $i<=$totalPages):
                            $qs['page'] = $i;
                            ?>
                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                    </li>
                    <?php endif;
                        endfor; ?>

                    <li class="page-item <?= $page>=$totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page+1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $totalPage ?>">
                        最末頁
                        </a></li>

                </ul>
            </nav>

        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                    
                    <th scope="col"><i class="fas fa-trash-alt"> ajax</i></th>

                    <!-- SELECT `sid`, `name`, `email`, `mobile`, `birthday`, `address`, `created_at` FROM `address_book_0814` WHERE 1 -->                    
                    <th scope="col">sid</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">mobile</th>
                    <th scope="col">birthday</th>
                    <th scope="col">address</th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                </tr>
                </thead>
                <tbody>

                <!-- 一筆就是一個tr，用迴圈把tbody內的tr包起來; -->
                <?php foreach($rows as $r): ?>
                <tr data-sid="<?= $r['sid'] ?>">    <!-- 開發人員自己定義的屬性，前面就會加data-，方便辨識也不會影響其他屬性 -->
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>
                        <i class="fas fa-trash-alt ajaxDelete"></i> <!-- 用來標示功能 -->
                    </td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    <td><?= $r['birthday'] ?></td>

                    <!-- 透過strip_tag可以取消內部的所有標籤功能，避免xss攻擊；script標籤會消失 
                    <td><?= strip_tags($r['address']) ?></td>
                    -->

                    <!-- 推薦使用！！htmlentities 將內部字串做特殊符號跳脫，主要針對大於小於符號；會顯示完整標籤；原則上每個填入text的欄位，都要加 -->
                    <td><?= htmlentities($r['address']) ?></td>
                    <td>
                        <a href="data-edit.php?sid=<?= $r['sid'] ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除注意</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary modal-del-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>


<?php include __DIR__. '/partials/scripts.php'; ?>
<script>

    //一次處理所有table資料
    const myTable = document.querySelector('table');
    const modal = $('#exampleModal');

    myTable.addEventListener('click', function(event){

        // 判斷有沒有點到橙色的垃圾筒
        if(event.target.classList.contains('ajaxDelete')){
            // console.log(event.target.closest('tr')); //往上找，找到最接近tr的標籤
            const tr = event.target.closest('tr');
            const sid = tr.getAttribute('data-sid'); //透過getAttribute拿到屬性

            console.log(`tr.dataset.sid:`, tr.dataset.sid); // 也可以這樣拿

            if(confirm(`是否要刪除編號為 ${sid} 的資料？`)){    //刪除前確認
                fetch('data-delete-api.php?sid=' + sid)
                    .then(r=>r.json())
                    .then(obj=>{
                        if(obj.success){
                            tr.remove();  // 從 DOM 裡移除元素
                            // location.reload(); //資料刪除後，頁面資料會破壞每頁筆數要求，刷新頁面調整

                        } else {
                            alert(obj.error);
                        }
                    });
            }

        }
    });

    let willDeleteId = 0;
    $('.del1btn').on('click', function(event){
        willDeleteId = event.target.closest('tr').dataset.sid;
        console.log(willDeleteId);
        modal.find('.modal-body').html(`確定要刪除編號為 ${willDeleteId} 的資料嗎？`);
    });

    // 按了確定刪除的按鈕
    modal.find('.modal-del-btn').on('click', function(event){
        console.log(`data-delete.php?sid=${willDeleteId}`);
        location.href = `data-delete.php?sid=${willDeleteId}`;
    });

    // modal 一開始顯示時觸發
    modal.on('show.bs.modal', function(event){
        // console.log(event.target);
    });
</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>