<?php
    include __DIR__. '/food_partials/01db_connect.php';
    $title = '修改資料';

    //拿到primary key
    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

    $sql = "SELECT * FROM `Column` WHERE sid=$sid";

    $r = $pdo->query($sql)->fetch();

    if(empty($r)){
        header('Location: f_data-list.php');
        exit;
    }
    // echo json_encode($r, JSON_UNESCAPED_UNICODE);
?>
<?php include __DIR__. '/food_partials/02html-head.php'; ?>
<?php include __DIR__. '/food_partials/03navbar.php'; ?>
<?php include __DIR__. '/food_partials/03.1edit_insertNavbar_css.php'; ?>
<style>
    form .form-group small {
        color: red;
    }
    .insert_bt{
        text-align: center;
    }
</style>
<div class="container">
    <div class="row">
                <div class="card-body border mb-3">
                    <h5 class="card-title">修改文章</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">   <!--將提交資料的sid傳到api檔案-->
                        <div class="form-group">
                            <label for="ar_title">標題</label>
                            <input type="text" class="form-control" id="ar_title" name="ar_title"
                                value="<?= htmlentities($r['ar_title']) ?>">    <!-- 加上value後，才會先呈現原始資料；透過htmlentities跳脫引號bug -->
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_pic">照片</label>
                            <input type="text" class="form-control" id="ar_pic" name="ar_pic"
                                   value="<?= htmlentities($r['ar_pic']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_author">作者</label>
                            <input type="text" class="form-control" id="ar_author" name="ar_author"
                                   value="<?= htmlentities($r['ar_author']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_date">日期</label>
                            <input type="date" class="form-control" id="ar_date" name="ar_date"
                                   value="<?= htmlentities($r['ar_date']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_highlight">摘要</label>
                            <textarea class="form-control" id="ar_highlight" name="ar_highlight" cols="30" rows="5"
                                ><?= htmlentities($r['ar_highlight']) ?></textarea> 
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_content01">內文I</label>
                            <textarea class="form-control" id="ar_content01" name="ar_content01" cols="30" rows="5"
                                ><?= htmlentities($r['ar_content01']) ?></textarea> 
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_content02">內文II</label>
                            <textarea class="form-control" id="ar_content02" name="ar_content02" cols="30" rows="5"
                                ><?= htmlentities($r['ar_content02']) ?></textarea> 
                            <small class="form-text "></small>
                        </div>

                        <div class="insert_bt"><button type="submit" class="btn btn-primary">送出修改</button></div>

                       
                    </form>


                </div>
    </div>


</div>
<?php include __DIR__. '/food_partials/04html-script.php'; ?>
<script>

    function checkForm(){
        // 欄位的外觀要回復原來的狀態
        ar_title.nextElementSibling.innerHTML = '';
        ar_title.style.border = '1px #CCCCCC solid';

        let isPass = true;
        if(ar_title.value.length < 3){
            isPass = false;
            name.nextElementSibling.innerHTML = '請填寫完整文章標題';
            name.style.border = '1px red solid';
        }

        if(isPass){
            const fd = new FormData(document.form1);
            fetch('f_data-edit-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功');
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error=>{
                    console.log('error:', error);
                });
        }
    }
</script>
<?php include __DIR__. '/food_partials/05html-foot.php'; ?>
