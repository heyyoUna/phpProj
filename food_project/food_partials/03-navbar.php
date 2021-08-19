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

    <div class="row mt-3 ar_page">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class=" column_nav_wrap pagination justify-content-end">
                    
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= 1 ?>">
                        第一頁
                        </a></li>

                    <li class="page-item <?= $page<=1 ? 'disabled' : '' ?> ">
                        <a class="page-link" href="?page=<?= $page-1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a></li>

                     <?php for($i=$page-5; $i < $page+5; $i++):
                        if($i>=1 and $i<=$totalPage): ?> 
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
</div>