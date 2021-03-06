<?php
  $root_dir = search_assets(debug_backtrace());
  // プロフィール画像表示用にusersテーブルから抽出
  if (isset($_SESSION['user']['id'])) {
      $sql = 'SELECT * FROM users WHERE user_id = ?';
      $data = array($_SESSION['user']['id']);
      $stmt = $dbh->prepare($sql);
      $stmt-> execute($data);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
  }
 ?>
<style type="text/css">
    /* 検索窓のテキスト用 */
    @media (min-width: 768px) {
      .navbar-form .form-control {
          width: 300px;
      }
    }
</style>

<!--ヘッダー -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">

    <!-- ロゴ-->
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $root_dir; ?>index.php">Joinus!</a>
    </div>

    <!-- 検索 -->
    <form class="navbar-form navbar-left"  role="search" method="GET" action="index.php#PlanRequest">
      <div class="search-box">
        <input class="form-control" type="text" placeholder="Please input tag" name="input_word"/>
        <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
      </div>
    </form>

    <!-- <div class="collapse navbar-collapse">
      <form class="navbar-form navbar-left" role="search" method="GET" action="index.php#PlanRequest">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Please input tag name" name="input_word">
        </div>
        <button type="submit" class="btn btn-default">SEARCH</button>
      </form>
    </div> -->

    <!-- メニュー -->
    <div class="collapse navbar-collapse" id="custom-collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php if(isset($_SESSION['user']['id'])) { ?>
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><img src="<?php echo $root_dir; ?>user_profile_img/<?php echo $user['image']; ?>" width="30"></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $root_dir; ?>profile.php?id=<?php echo $_SESSION['user']['id']; ?>">My page</a></li>
            <li><a href="<?php echo $root_dir; ?>index.php#PlanRequest">List plan / request</a></li>
            <li><a href="<?php echo $root_dir; ?>post.php">Create plan / request</a></li>
            <li><a href="<?php echo $root_dir; ?>signout.php">Signout</a></li>
          </ul>
        </li>
        <?php } else { ?>
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Home</a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $root_dir; ?>signin.php">Signin</a></li>
            <li><a href="<?php echo $root_dir; ?>index.php#PlanRequest">List plan / request</a></li>
            <li><a href="<?php echo $root_dir; ?>signout.php">Signout</a></li>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </div>

  </div>
</nav>