
<?php 
    include __DIR__. '/food_partials/01db_connect.php';
    $title = '文章列表';

//固定每頁最多幾筆
$perPage = 3;

//預設呈現第一頁
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//總筆數
$totalRows = $pdo->query("SELECT count(1) FROM `Column` ")
->fetch(PDO::FETCH_NUM)[0];


//確定總頁數，才可確定分頁按鈕 (總頁數 ＝ 總筆數 / 每頁顯示筆數)
$totalPage = ceil($totalRows/$perPage);

//讓page的值在安全範圍內
if($page<1){header('location: ?page=1');exit;}
if($page>$totalPage){header('location: ?page='. $totalPage); exit;}


$sql = sprintf("SELECT * FROM `Column` LIMIT %s, %s",
 ($page-1) * $perPage, $perPage );

    $rows = $pdo->query($sql)->fetchall();

?>



<?php include __DIR__. '/food_partials/02html-head.php'; ?>
<?php include __DIR__. '/food_partials/03navbar.php'; ?>

<div class="container">
    <div class="row ">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-md-center">
                    
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= 1 ?>">
                        第一頁
                        </a></li>

                    <!-- 在li的class直接下disabled，就會使整個左箭頭失效；
                    下三元陣列，設定頁數小於1，才失效-->
                    <li class="page-item <?= $page<=1 ? 'disabled' : '' ?> ">
                        <a class="page-link" href="?page=<?= $page-1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a></li>

                    <!-- ?page 當連結由問號開頭，代表該url資源，是目前撰寫中的檔案 -->
                    <!-- 如果aclass直接下active，選擇任一分頁後，全部分頁選項都會反白；下三元陣列，設定只有選定的頁面會反白 -->
                    <!-- 透過$i=$page-5; $i<=$Page+5 讓頁碼最多一次出現11個 -->
                    <!-- 把頁碼顯示錯寫成無限迴圈，資料庫直接掛掉(i=$page-5; $i=$Page+5) -->
                    <!-- <?php for($i=$page-5; $i < $page+5; $i++):
                        if($i>=1 and $i<=$totalPage): ?> -->
                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>">
                            <?= $i ?>
                        </a></li>
                    <?php endif; endfor; ?>

                    <li class="page-item <?= $page>=$totalPage ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a></li>

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
                        <th scope="col">sid</th>
                        <th scope="col">article_cate_sid</th>
                        <th scope="col">article_id</th>
                        <th scope="col">article_title</th>
                        <th scope="col">article_author</th>
                        <th scope="col">article_date</th>
                        <th scope="col">article_highlight</th>
                        <th scope="col"><i class="fas fa-edit"></i></th>

                    </tr>
                 </thead>
                <tbody>
                <!-- 一筆就是一個tr，用迴圈把tbody內的tr包起來; -->
                <?php foreach($rows as $r):?>  
                    <tr>
                        <td>
                            <a href="data-delete.php?side=<?= $r['sid'] ?>">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>

                        <!-- 透過htmlentities，跳脫大於小於功能，避免xss攻擊 -->
                        <td><?= $r['sid'] ?></td>
                        <td><?= $r['article_cate_sid'] ?></td>
                        <td><?= $r['article_id'] ?></td>
                        <td><?= htmlentities($r['article_title']) ?></td>
                        <td><?= htmlentities($r['article_author']) ?></td>
                        <td><?= htmlentities($r['article_date']) ?></td>
                        <td><?= htmlentities($r['article_highlight']) ?></td>


                        <td>
                            <a href="data-edit.php?side=<?= $r['sid'] ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
             </table>


        </div>
    </div>

<?php include __DIR__. '/food_partials/04html-end.php'; ?>