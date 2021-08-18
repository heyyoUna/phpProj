<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="homepage.php">好食專欄</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="data-list.php">聰明飲食</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="data-list.php">食物謠言</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="data-list.php">美味食譜</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="data-insert.php">新增</a>
                </li> -->

            </ul>

            <ul class="navbar-nav">
            <li class="nav-item active">
                    <a class="nav-link text-primary" href="data-insert.php">上傳文章</a>
                </li>
            </ul>

            <!-- <ul class="navbar-nav">
                <?php if(isset($_SESSION['user'])): ?>
                    <li class="nav-item active">
                        <a class="nav-link" ><?= $_SESSION['user']['nickname'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile-edit.php">編輯個人資料</a>
                    </li>
                    <li class="nav-item">
                        <?php if(! empty( $_SESSION['user']['avatar'])): ?>
                            <img src="imgs/<?= $_SESSION['user']['avatar'] ?>" alt="" width="50px">
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">登出</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">註冊</a>
                    </li>
                <?php endif; ?>
            </ul> -->

        </div>
    </div>
</nav>