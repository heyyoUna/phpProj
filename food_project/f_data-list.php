
<?php 
    include __DIR__. '/food_partials/01-init.php';
    $title = '文章列表';

    //固定每頁最多幾筆
    $perPage = 3;
    
    // query string parameters
    $qs = [];

    // 關鍵字查詢
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    
    //預設呈現第一頁
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;
    
    $where = ' WHERE 1 ';
    
    //總筆數
    $totalRows = $pdo->query("SELECT count(1) FROM `Column` where 1")
    ->fetch(PDO::FETCH_NUM)[0];

    // 總共有幾頁, 才能生出分頁按鈕
    $totalPages = ceil($totalRows / $perPage); // 正數是無條件進位

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
if (! $cate){
    $sql = sprintf("SELECT * FROM `Column` %s ORDER BY sid DESC LIMIT %s, %s",
    $where, ($page - 1) * $perPage, $perPage);
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
} else {
    $where .= "AND ar_cate = $cate";
    $qs['ar_cate'] = $cate;
    $sql = "SELECT * FROM `Column` WHERE `ar_cate`=$cate ORDER BY `sid` DESC ;";
    $rows = $pdo->query($sql)->fetchALL();

}

}
?>

<?php include __DIR__. '/food_partials/02-html-head.php'; ?>
<?php include __DIR__. '/food_partials/homepageNavbar.php'; ?>
<style>
        table tbody i.fas.fa-trash-alt {
            color: darkred;
        }

        table tbody i.fas.fa-trash-alt.ajaxDelete {
            color: darkred;
            cursor: pointer;
            margin: auto;
        }

        .data_list_wrap{
            margin: 10px;
            text-align: center;
        }
        .data_list{
            min-width: 65px;
            max-width: auto;
            max-height: 20px;
            overflow: hidden;
        }
    </style>

<style>
    .nav_container{
        display: flex;
        justify-content: space-between;
        align-items: center;
    
    }

    .column_nav_wrap{
        display: flex;
    }

    .column_nav{
        padding: 0 10px;
        color: darkblue;
    }
    .add_column{
        font-weight: bold;
    }

    .data_list img{
        max-width: 100px;
        height: auto;
    }


</style>

<div class="container nav_container">
    <div class="row">
        <div class="mr-auto column_nav_wrap">
            <div class="column_nav add_column"><a href="f_data-insert.php">新增文章</a></div>
            <div class="column_nav"><a href="?">所有文章</a></div>
            <div class="column_nav"><a href="?cate=1">聰明飲食</a></div>
            <div class="column_nav"><a href="?cate=2">食物謠言</a></div>
            <div class="column_nav"><a href="?cate=3">美味食譜</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end mt-3">

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


                    <!-- 把頁碼顯示錯寫成無限迴圈，資料庫直接掛掉(i=$page-5; $i=$Page+5) -->
                    <?php for($i=$page-5; $i<=$page+5; $i++):
                        if($i>=1 and $i<=$totalPages):
                            $qs['page'] = $i;
                            ?>

                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                    </li>
                    <?php endif; endfor; ?>

                    <li class="page-item <?= $page>=$totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page+1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $totalPages ?>">>
                        最末頁
                        </a></li>

                </ul>
            </nav>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="data_list_wrap">

                        <th class="data_list" scope="col"><i class="fas fa-trash-alt"></i></th>

                        <th class="data_list" scope="col">編號</th>
                        <th class="data_list" scope="col">標題*</th>
                        <th class="data_list" scope="col">照片</th>
                        <th class="data_list" scope="col">作者</th>
                        <th class="data_list" scope="col">日期</th>
                        <th class="data_list" scope="col">摘要</th>
                        <th class="data_list" scope="col">內文I</th>
                        <th class="data_list" scope="col">內文II</th>
                        <th class="data_list" scope="col"><i class="fas fa-edit"></i></th>

                    </tr>
                 </thead>
                <tbody>

                <?php foreach($rows as $r): ?>
                <tr data-sid="<?= $r['sid'] ?>"> 

                    <td>
                        <i class="fas fa-trash-alt ajaxDelete pl-2"></i>
                    </td>

                    <td class="data_list"><?= $r['sid'] ?></td>
                    <td class="data_list"><?= $r['ar_title'] ?></td>
                    <td class="data_list"><img src="./img/article_img/<?= $r['ar_pic'] ?>" alt=""></td>
                    <td class="data_list"><?= $r['ar_author'] ?></td>
                    <td class="data_list"><?= $r['ar_date'] ?></td>
                    <td class="data_list"><?= $r['ar_highlight'] ?></td>
                    <td class="data_list"><?= $r['ar_content01'] ?></td>
                    <td class="data_list"><?= $r['ar_content02'] ?></td>
                    <td class="data_list">
                        <a href="f_data-edit.php?sid=<?= $r['sid'] ?>">
                            <i class="fas fa-edit pl-2"></i>
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
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除確認</h5>
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
    </div> -->

<?php include __DIR__. '/food_partials/04-html-script.php'; ?>

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
        fetch('f_data-delete-api.php?sid=' + sid)
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
        console.log(`f_data-delete.php?sid=${willDeleteId}`);
        location.href = `f_data-delete.php?sid=${willDeleteId}`;
    });

    // modal 一開始顯示時觸發
    modal.on('show.bs.modal', function(event){
        // console.log(event.target);
    });
</script>
 

<?php include __DIR__. '/food_partials/05-html-foot.php'; ?>