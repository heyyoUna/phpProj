
<?php 
    include __DIR__. '/partials/init.php';
    $title = '登入';

    //php的跳轉是直接透過header(redirect)，直接跳轉到別的頁面
    if(isset($_SESSION['user'])){
        header('location:index_.php');
        exit;  //如果沒下結束，後面還是會繼續執行；網頁都要跳走了，再跑後面的程式也沒有意義
    }
//在登入的情況下，進入login.php的檔案，會直接跳到index檔案(彷彿login.php檔案不曾發生過)，但在檢查可以發現帶著status 302 的login.php

//也適用於限定登入後才可觀看的頁面，改成「沒有登入(isset前面加！)，就離開」。
    
?>

<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>

<style>
    form .form-group small{
        color: red;
        display: none;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">登入</h5>

                    <form name="form1" onsubmit="sendForm(); return false;">
                        <div class="form-group">
                            <label for="account">帳號</label>
                            <input type="text" class="form-control" id="account" name="account" aria-describedby="emailHelp">
                            <small class="form-text">請填寫帳號</small>     <!-- 可以當作訊息提示 -->
                        </div>

                        <div class="form-group">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text">請填寫密碼</small> 
                        </div>
            
        
                        <button type="submit" class="btn btn-primary">登入</button>  <!-- 如果type一定要設定，可以是submit / button-->
                    </form>

                </div>
            </div>


        </div>
    </div>
</div>


<?php include __DIR__. '/partials/scripts.php'; ?>

<script>
    function sendForm(){
        let isPass = true;  //設定會通過檢查 - true；先假設是true，但若有任一項檢查項目不合格，就會跳false
        document.form1.account.nextElementSibling.style.display = 'none';
        document.form1.password.nextElementSibling.style.display = 'none';

        if(! document.form1.account.value){     
            document.form1.account.nextElementSibling.style.display = 'block';   //回傳element 的下一個元素，可透過console檢查
            isPass = false;  //檢查項目1
        }

        if(! document.form1.password.value){     
            document.form1.password.nextElementSibling.style.display = 'block';  
            isPass = false; //檢查項目2；所有檢查項目，只要有一項不合格，就會跳為false 
        }

        if(isPass){
            const fd = new FormData(document.form1);    //這邊的form1顯示name屬性的重要！

            fetch('login-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r=>r.json()) 
                .then(obj=>{
                    console.log('result:', obj);
                    if(obj.success){
                        location.href = 'index_.php'; //登入成功跳轉到其他頁面(js的跳轉)
                    } else {
                        alert(obj.error); //登入錯誤跳警示
                    }
                });
        }
    }
</script>

<?php include __DIR__. '/partials/html-foot.php'; ?>

<!-- 更改完頁面要重新整理，不然會停留在舊的內容(舊的快取)；
搜尋列旁的'preserve log'、'disable cache'要打勾，否則也會停留在舊內容的快取 -->

