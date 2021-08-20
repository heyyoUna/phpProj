<?php
    include __DIR__. '/food_partials/01-init.php';
    $title = '修改資料';

    //拿到primary key
    $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

    $sql = "SELECT * FROM `Column` WHERE sid=$sid ";

    $r = $pdo->query($sql)->fetch();

    if(empty($r)){
        header('Location: f_data-list.php');
        exit;
    }

?>

<?php include __DIR__. '/food_partials/02-html-head.php'; ?>
<?php include __DIR__. '/food_partials/homepageNavbar.php'; ?>
<?php include __DIR__. '/food_partials/03-navbar_without_page.php'; ?>
<style>
    form .form-group small {
        color: red;
    }
    .insert_bt{
        text-align: center;
    }
    #oldJpg{
        width: 300px;
    }

    #previw{
        display: none;
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
                            <label for="ar_cate">商品類別</label>
                            <select class="form-control" id="ar_cate" name="ar_cate">
                                <option value="1"<?= $r['ar_cate']==1 ? 'selected':'' ?>>聰明飲食</option>
                                <option value="2"<?= $r['ar_cate']==2 ? 'selected':'' ?>>食物謠言</option>
                                <option value="3"<?= $r['ar_cate']==3 ? 'selected':'' ?>>美味食譜</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ar_pic">文章封面照</label>
                            <input type="file" class="form-control" id="upload" name="ar_pic">
                            <br>
                            <!-- 設定圖片預覽 -->
                            <img id="preview" src="" alt="">
                            <img id="oldJpg" src="./img/article_img/<?= htmlentities($r['ar_pic']) ?>" alt="">
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
<?php include __DIR__. '/food_partials/04-html-script.php'; ?>
<script>

    var upload = document.getElementById('upload')
    var oldJpg = document.getElementById('oldJpg')
    var preview = document.getElementById('preview')

    // 設定upload 有改變的話觸發handleFiles function
    upload.addEventListener("change",handleFiles,false)

    function handleFiles(){
        readURL(this)
        // 設定顯示新圖檔
        preview.style.display="block"
    }
    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader()
            // 設定舊圖檔消失
            oldJpg.style.display="none";

            reader.onload = function(e){
                document.getElementById("preview").src = e.target.result;
            }
            reader.readAsDataURL(input.files[0])
        }
    }


    function checkForm(){
        let isPass = true;

        if(ar_title.value.length < 3){
            isPass = false;
            ar_title.nextElementSibling.innerHTML = '請填寫完整文章標題';
            ar_title.style.border = '1px red solid';
        }

        if(isPass){
            const fd = new FormData(document.form1);
            fetch('f_data-edit-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功');
                        location.href = 'f_data-list.php';
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error => {
                    console.log('error:', error);
                });
        }
    }
</script>
<?php include __DIR__. '/food_partials/05-html-foot.php'; ?>
