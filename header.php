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
<!--ヘッダー -->
      <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">

<!-- ロゴ-->
              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <a class="navbar-brand" href="<?php echo $root_dir; ?>index.php">Joinus!</a>
          </div>
 <!-- けんさくまど -->

          <div class="collapse navbar-collapse">
            <form class="navbar-form navbar-left" role="search" method="GET" action="index.php#PlanRequest">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Please input tag name" name="input_word">
              </div>
              <button type="submit" class="btn btn-default">SEARCH</button>
            </form>
          </div>

<!-- <div class="row mb-60">
              <div class="col-sm-8 col-sm-offset-2">
                <form role="form">
                  <div class="search-box">
                    <input class="form-control" type="text" placeholder="Search..."/>
                    <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                  </div>
                </form>
              </div>
            </div> -->

<!-- ヘッダーメニューバー -->
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