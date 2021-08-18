<?php
    include __DIR__. '/partials/init.php';
    $title = '新增資料';
?>
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
    <style>
        form .form-group small {
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
                    <form name="form1" onsubmit="checkForm(); return false;">
                        <div class="form-group">
                            <label for="name">姓名 *</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="email">email *</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="birthday">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="address">address</label>
                            <input type="text" class="form-control" id="address" name="address">
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
    //針對必填欄位做檢查
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    const name = document.querySelector('#name');
    const email = document.querySelector('#email');
    
    // mobile.style.border = '1px red solid';

    function checkForm(){
        // 欄位的外觀要回復原來的狀態
        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px #CCCCCC solid';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';

        // 讓表單送出前，完成資料欄位檢查
        // 如果格式不符，要有欄位提示的不同外觀
        /* 
        一開始假設為正確；
        但如果姓名的長度，小於2，就會轉成false，並改變外觀(紅框＋警示)；
        剛好small(警示列)是下一個欄位，可使用nextElementSibling 去更改其內容；*/
        let isPass = true;
        if(name.value.length < 2){
            isPass = false;
            name.nextElementSibling.innerHTML = '請填寫正確的姓名';
            name.style.border = '1px red solid';
        }

        //email.value，前者為欄位，後者為值
        if(! email_re.test(email.value)){
            isPass = false;
            email.nextElementSibling.innerHTML = '請填寫正確的 Email 格式';
            email.style.border = '1px red solid';
        }

        if(isPass){
            const fd = new FormData(document.form1);
            fetch('data-insert-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        location.href = 'data-list.php';    //新增成功，跳到列表頁；如果要新增的資料較多，可改為不跳轉，出現「新增成功」的警示即可
                    } else {
                        alert(obj.error);   //新增失敗，出現警示
                    }
                })
                .catch(error=>{
                    console.log('error:', error);
                });
        }
    }

        /*
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
        */

</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>