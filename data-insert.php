
<?php 
    include __DIR__. '/partials/init.php';
    $title = '新增資料' 
?>



<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>

                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__. '/partials/scripts.php'; ?>
<?php include __DIR__. '/partials/html-foot.php'; ?>

<!-- 網頁切分方便修改＆維護，假設網頁中navbar相同，就只要改一份檔案
 -->