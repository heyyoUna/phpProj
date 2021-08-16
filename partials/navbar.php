<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="data-list.php">資料列表</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data-insert.php">新增</a>
          </li>
        </ul>

      <!-- 更改有無登入後，右上角的顯示文字 -->
        <ul class="navbar-nav">

          <!-- (1) 如果user有設定，代表有登入 -->
          <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="nav-link active"><?= $_SESSION['user']['nickname']  ?></a> <!-- 拿掉href，移除cursor效果 -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">登出</a>
          </li>
        
           <!-- (2) 沒有登入時，要顯示的按鈕們 -->
          <?php else: ?>
              <li class="nav-item">
                <a class="nav-link active"  href="login.php">登入</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">註冊</a>
              </li>

           <!-- (3)  -->
          <?php endif; ?>

        </ul>
 
      </div>
    </div>
  </div>
  </nav>


  <!-- 因為navbar.php有使用session，所以所有～～有串此檔案的其他檔案，都要加上session_start；透過串接寫入該變數的init.php，方便管理；
  因為login-api.php 不會顯示畫面，不要加。 -->