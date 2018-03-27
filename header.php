<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">

    <!-- ロゴ -->
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $root_dir; ?>index.html">Joinus!</a>
    </div>

    <!-- 検索 -->
    <form class="navbar-form navbar-left"  role="search">
      <div class="search-box">
        <input class="form-control" type="text" placeholder="Search..."/>
        <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
      </div>
    </form>

    <!-- メニュー -->
    <div class="collapse navbar-collapse" id="custom-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Home</a>
          <ul class="dropdown-menu">
            <?php if(isset($_SESSION['user']['id'])) { ?>
            <li><a href="<?php $root_dir; ?>profile.php?id=<?php echo $_SESSION['user']['id']; ?>">My page</a></li>
            <li><a href="<?php $root_dir; ?>index.php#works">List plan / request</a></li>
            <li><a href="<?php $root_dir; ?>post.php">Create plan / request</a></li>
            <li><a href="<?php $root_dir; ?>signout.php">Signout</a></li>
            <?php } else { ?>
            <li><a href="<?php $root_dir; ?>signin.php">Signin</a></li>
            <li><a href="<?php $root_dir; ?>index.php#works">List plan / request</a></li>
            <li><a href="<?php $root_dir; ?>signout.php">Signout</a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
    </div>

  </div>
</nav>