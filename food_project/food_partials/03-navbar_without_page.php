<style>
    .nav_container{
        display: flex;
        justify-content: space-between;
        align-items: center;
    
    }

    .column_nav_wrap{
        display: flex;
        margin: 7px auto;
    }

    .column_nav{
        padding: 10px 12px 10px 0;
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
</div>