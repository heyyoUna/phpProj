
<?php 
    include __DIR__. '/food_partials/01-init.php';
    $title = '文章列表';

    //固定每頁最多幾筆
    $perPage = 3;
    
    // query string parameters
    $qs = [];
    
    //預設呈現第一頁
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    
    //總筆數
    $totalRows = $pdo->query("SELECT count(1) FROM Column $where ")
        ->fetch(PDO::FETCH_NUM)[0];
    
    
    //確定總頁數，才可確定分頁按鈕 (總頁數 ＝ 總筆數 / 每頁顯示筆數)
    $totalPages = ceil($totalRows / $perPage); 

    $rows = [];
    // 要有資料才能讀取該頁的資料
    if($totalRows!=0) {
    
        //讓page的值在安全範圍內
        if ($page < 1) {
            header('Location: ?page=1');
            exit;
        }
        if ($page > $totalPages) {
            header('Location: ?page=' . $totalPages);
            exit;
        }
    
        $sql = sprintf("SELECT * FROM Column %s ORDER BY sid DESC LIMIT %s, %s",
            $where,
            ($page - 1) * $perPage,
                $perPage);

        $rows = $pdo->query($sql)->fetchAll(); 
        }
?>

<?php include __DIR__. '/food_partials/02-html-head.php'; ?>
<?php include __DIR__. '/food_partials/03-navbar.php'; ?>
<style>
        table tbody i.fas.fa-trash-alt {
            color: darkred;
        }

        table tbody i.fas.fa-trash-alt.ajaxDelete {
            color: darkred;
            cursor: pointer;
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
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-trash-alt ajaxDelete"></i>
                        </button>
                    </td>

                    <td class="data_list"><?= $r['sid'] ?></td>
                    <td class="data_list"><?= $r['ar_title'] ?></td>
                    <td class="data_list"><img src="/food_project/img/article_img/<?= $r['ar_pic'] ?>" alt=""></td>
                    <td class="data_list"><?= $r['ar_author'] ?></td>
                    <td class="data_list"><?= $r['ar_date'] ?></td>
                    <td class="data_list"><?= $r['ar_highlight'] ?></td>
                    <td class="data_list"><?= $r['ar_content01'] ?></td>
                    <td class="data_list"><?= $r['ar_content02'] ?></td>
                    <td class="data_list">
                        <a href="f_data-edit.php?sid=<?= $r['sid'] ?>">
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
    </div>

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
 

<?php include __DIR__. '/food_project/food_partials/05-html-foot.php'; ?>