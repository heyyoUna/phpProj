<?php 
    include __DIR__. '/partials/init.php';
    $title = '新增資料' 
?>



<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
<style>
    form .form-group small{
        color: red;

    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>

                    <!-- onsubmit：在表單送出前觸發；
                    return false:取消預設的行為;
                     在name後面加require表示該欄位為必填-->
                    <form name="form1">
                        <div class="form-group">
                            <label for="name">姓名 *</label>
                            <input type="text" class="form-control" id="name" name="name" require>
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" require>
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">手機 *</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" require>
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="birthday">生日</label>
                            <input type="text" class="form-control" id="birthday" name="birthday">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="address">地址</label>
                            <input type="text" class="form-control" id="address" name="address" >
                            <small class="form-text"></small>
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
    //針對必填欄位做檢查
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    mobile.style.border = '1px red solid';


    function checkForm(){
        // TODO:欄位的外觀會回復原來狀態
        // TODO：讓表單送出前，完成資料欄位檢查
        // TODO:如果格式不符，要有欄位提示的不同外觀



        //整個表單，建立一個formdata，把整個表單放入
        const fd = new FormData(document.form1);  
        //跟登入時的架構類似，直接發送ajex，向對象為data-insert-api.php，透過post方式{}
        fetch('/data-insert-api.php', {
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
