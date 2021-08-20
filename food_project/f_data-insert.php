<?php
    include __DIR__. '/food_partials/01-init.php';
    $title = '新增文章';?>
<?php include __DIR__. '/food_partials/02-html-head.php'; ?>
<?php include __DIR__. '/food_partials/homepageNavbar.php'; ?>
<?php include __DIR__. '/food_partials/03-navbar_without_page.php'; ?>



    <style>
        form .form-group small {
            color: red;
        }

        .container{
            width: 100%;

        }
        .insert_bt{
            text-align: center;
        }

        .column_nav_wrap{
            display: flex;
            padding: 5px;
        }
        
    </style>


<div class="container">
    <div class="row">
        <!-- <div class="col-md-6">
            <div class="card"> -->
                <div class="card-body border mb-3">
                    <h5 class="card-title">新增文章</h5>

                    <!-- onsubmit：在表單送出前觸發；
                    return false:取消預設的行為;
                     在name後面加require表示該欄位為必填-->
                    <form class="insert_form_wrap" name="form1" onsubmit="checkForm(); return false;">
                        <div class="form-group">
                            <label for="ar_title">標題*</label>
                            <input type="text" class="form-control" id="ar_title" name="ar_title">
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group" name="ar_pic" method="post" enctype="multipart/form-data">
                        <label for="ar_title">照片</label>
                            <input type="file" onchange="previewFile()"  class="form-control" id="upload" name="ar_pic" accept="image/*">
                            <img src="" height="200" alt="Image preview...">
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group">
                            <label for="ar_author">作者</label>
                            <input type="text" class="form-control" id="ar_author" name="ar_author">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_date">日期</label>
                            <input type="date" class="form-control" id="ar_date" name="ar_date">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="ar_highlight">摘要</label>
                            <textarea class="form-control" name="ar_highlight" id="ar_highlight" cols="30" rows="13"></textarea>
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group">
                            <label for="ar_content01">內文I</label>
                            <textarea class="form-control" name="ar_content01" id="ar_content01" cols="30" rows="13"></textarea>
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group">
                            <label for="ar_content02">內文II</label>
                            <textarea class="form-control" name="ar_content02" id="ar_content02" cols="30" rows="13"></textarea>
                            <small class="form-text "></small>
                        </div>

                    <div class="insert_bt"><button type="submit" class="btn btn-primary">Submit</button></div>

                    </form>


                </div>
            <!-- </div> -->
        <!-- </div> -->
    </div>


</div>
<?php include __DIR__. '/food_partials/04-html-script.php'; ?>
<script>

function previewFile() {
  const preview = document.querySelector('img');
  const file = document.querySelector('input[type=file]').files[0];
  const reader = new FileReader();

  reader.addEventListener("load", function () {
    // convert image file to base64 string
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}

function checkForm(){
        // 欄位的外觀要回復原來的狀態
        ar_title.nextElementSibling.innerHTML = '';
        ar_title.style.border = '1px #CCCCCC solid';

        // 讓表單送出前，完成資料欄位檢查
        // 如果格式不符，要有欄位提示的不同外觀
        /* 
        一開始假設為正確；
        但如果姓名的長度，小於2，就會轉成false，並改變外觀(紅框＋警示)；
        剛好small(警示列)是下一個欄位，可使用nextElementSibling 去更改其內容；*/
        let isPass = true;
        if(ar_title.value.length < 3){
            isPass = false;
            ar_title.nextElementSibling.innerHTML = '請填寫文章標題';
            ar_title.style.border = '1px red solid';
        }


        if(isPass){
            const fd = new FormData(document.form1);
            fetch('f_data-insert-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        location.href = 'f_data-list.php';    //新增成功，跳到列表頁；如果要新增的資料較多，可改為不跳轉，出現「新增成功」的警示即可
                    } else {
                        alert(obj.error);   //新增失敗，出現警示
                    }
                })
                .catch(error=>{
                    console.log('error:', error);
                });
        }
    }


</script>
<?php include __DIR__. '/food_partials/05-html-foot.php'; ?>