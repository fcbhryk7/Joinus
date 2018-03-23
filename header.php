

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
<<<<<<< HEAD
<!--           <div class="row">
              <div class="col-md-6">
                  <div id="custom-search-input">
                      <div class="input-group col-md-12">
                          <input type="text" class="form-control input-lg" placeholder="Buscar" />
                          <span class="input-group-btn">
                              <button class="btn btn-info btn-lg" type="button">
                                  <i class="glyphicon glyphicon-search"></i>
                              </button>
                          </span>
                      </div>
=======


            <div class="row mb-60">
              <div class="col-sm-8 col-sm-offset-2">
                <form role="form">
                  <div class="search-box">
                    <input class="form-control" type="text" placeholder="Search..."/>
                    <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
>>>>>>> master
                  </div>
                </form>
              </div>
<<<<<<< HEAD
          </div> -->


<!-- <form method="GET" action="index.php" target="_blank">
<input type="search" name="s" size="31" maxlength="255" value="">
<input type="submit" name="btng" value="検索">
<input type="hidden" name="hl" value="ja">
</form> -->

<form role="search" method="GET" action="index.php">
<input type="search" placeholder="keyword" name="s">
<input type="submit" class="button" value="search">
</form>


=======
            </div>
>>>>>>> master

<!-- ヘッダーメニューバー -->
          <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Home</a>
                <ul class="dropdown-menu">
<<<<<<< HEAD
                  <li><a href="../profile.php">My page</a></li>
                  <li><a href="index_op_fullscreen_gradient_overlay.html"></a></li>
                  <li><a href="index_agency.html">Create plan</a></li>
                  <li><a href="index_portfolio.html">Create request</a></li>
                  <li><a href="index_restaurant.html">Signout</a></li>
=======
                  <?php if(isset($_SESSION['user']['id'])) { ?>
                  <li><a href="<?php $root_dir; ?>profile.php?id=<?php echo $_SESSION['user']['id']; ?>">My page</a></li>
                  <?php } else { ?>
                  <li><a href="<?php $root_dir; ?>signin.php">My page</a></li>
                  <?php } ?>
                  <li><a href="<?php $root_dir; ?>index.php#works">List plan / request</a></li>
                  <li><a href="<?php $root_dir; ?>Plan_Request_post.php">Create plan / request</a></li>
                  <li><a href="<?php $root_dir; ?>signout.php">Signout</a></li>
>>>>>>> master
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>