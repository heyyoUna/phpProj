<?php include __DIR__. '/homepageNavbar.php'; ?> 

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


</style>

<div class="container nav_container">
    <div class="row">
        <div class="mr-auto column_nav_wrap">
            <div class="column_nav add_column"><a href="f_data-insert.php">新增文章</a></div>
            <div class="column_nav"><a href="f_data-list.php">所有文章</a></div>
            <div class="column_nav"><a href="f_data-list.php">聰明飲食</a></div>
            <div class="column_nav"><a href="f_data-list.php">食物謠言</a></div>
            <div class="column_nav"><a href="f_data-list.php">美味食譜</a></div>
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
                        <a class="page-link" href="?page=<?= $totalPage ?>">
                        最末頁
                        </a></li>

                </ul>
            </nav>

        </div>
    </div>
</div>