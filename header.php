<?php

    $root_dir = search_assets(debug_backtrace());

    // // タグ情報取得
    // $sql = 'SELECT t.* FROM plans_tags AS pt, tags AS t WHERE pt.tag_id = t.tag_id AND pt.plan_id = ?';
    // $data = array($_REQUEST['id']);
    // $stmt = $dbh->prepare($sql);
    // $stmt-> execute($data);

    // $tags =  $stmt->fetchAll();

    // echo_var_dump('$tags', $tags);

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


            <div class="row mb-60">
              <div class="col-sm-8 col-sm-offset-2">
                <form role="form">
                  <div class="search-box">
                    <input class="form-control" type="text" placeholder="Search..."/>
                    <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                  </div>
                </form>
              </div>
            </div>

<!-- ヘッダーメニューバー -->
          <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Home</a>
                <ul class="dropdown-menu">
                  <?php if(isset($_SESSION['user']['id'])) { ?>
                  <li><a href="<?php $root_dir; ?>profile.php?id=<?php echo $_SESSION['user']['id']; ?>">My page</a></li>
                  <?php } else { ?>
                  <li><a href="<?php $root_dir; ?>signin.php">My page</a></li>
                  <?php } ?>
                  <li><a href="<?php $root_dir; ?>index.php#works">List plan / request</a></li>
                  <li><a href="<?php $root_dir; ?>Plan_Request_post.php">Create plan / request</a></li>
                  <li><a href="<?php $root_dir; ?>signout.php">Signout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>