<?php 
    include __DIR__. '/partials/init.php';
    $title = '新增資料' 
?>



<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>
                    <!-- onsubmit：在表單送出前觸發；return false:取消預設的行為-->
                    <form name="form1">
                        <div class="form-group">
                            <label for="name">姓名 *</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" >
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">手機</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="birthday">生日</label>
                            <input type="text" class="form-control" id="birthday" name="birthday">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="address">地址</label>
                            <input type="text" class="form-control" id="address" name="address" >
                            <small class="form-text "></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    function checkForm(){
        // 待辦事項TODO：讓表單送出前，完成資料欄位檢查

        //整個表單，建立一個formdata，把整個表單放入
        const fd = new FormData(document.form1);
        //跟登入時的架構類似，直接發送ajex，向對象為data-insert-api.php，透過post方式{}
        fetch ('data-insert-api.php', {
            method: 'POST',
            body: fd
        })
        .then(r=>r.text())
        .then(txt=>{
            console.log(txt);
        })

        //當fetch 的方式改為json，api檔案沒有套用json模式，就會出錯，解決方式如下：
        // catch 為fetch 的錯誤處理方式
        // 去呼叫catch的方法，給一個call back function，就會把錯誤資訊丟到console.log內
        // 雖然依然顯示無法辨識json，但js不會因此被中斷
        // js引擎在執行過程，如果錯誤沒有被捕捉，就會一直往外層丟，丟到沒有人接時，就會跳錯誤訊息，並終止後面js的運作
        .catch(error=>{
            console.log('error:', error);
        });
    }


</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>