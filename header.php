<?php 

    // session_start(); //セッションスタート
    // require('dbconnect.php'); //DB接続
    // require('functions.php'); //ファンクション

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
              <a class="navbar-brand" href="../index.php">Joinus!</a>
          </div>
 <!-- けんさくまど -->
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
                  </div>
              </div>
          </div> -->


<!--           <div class="col-md-6">
            <form action = "index.php" method="post">
              <input type="text" name="nm">
             <input type="submit" name="exec" value="search">
            </form>
          </div> -->

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
                  <li><a href="../profile.php">My page</a></li>
                  <li><a href="index_op_fullscreen_gradient_overlay.html">Bookmark</a></li>
                  <li><a href="index_agency.html">Create plan</a></li>
                  <li><a href="index_portfolio.html">Create request</a></li>
                  <li><a href="index_restaurant.html">Signout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>