<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);
    // echo_var_dump('$_SESSION',$_SESSION);

    // SESSIONが空の場合は index.php へ強制遷移
    if (!isset($_SESSION['post'])) {
        header('Location: index.php');
        exit();
    }

    // 変数格納
    $request_type = $_SESSION['post']['request_type'];
    $title = $_SESSION['post']['title'];
    $content = $_SESSION['post']['content'];
    $place = $_SESSION['post']['place'];
    $start_datetime = $_SESSION['post']['start_datetime'];
    $end_datetime = $_SESSION['post']['end_datetime'];
    $location = $_SESSION['post']['location'];
    $time = $_SESSION['post']['time'];
    $person = $_SESSION['post']['person'];
    $cost = $_SESSION['post']['cost'];
    $entry_field = $_SESSION['post']['entry_field'];

    // plansテーブルを更新
    // $sql = 'INSERT INTO plans SET user_id = ?, request_type = ?, title = ?, content = ?, place = ?, start_datetime = ?, end_datetime = ?,location = ?, time = ?, person = ?, cost = ?, entry_field = ? , updated = NOW() WHERE plan_id = ? AND user_id = ? ';
    // $data = array($_SESSION['user']['id'], $request_type, $title, $content, $place, $start_datetime, $end_datetime, $location, $time, $person, $cost, $entry_field);
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute($data);

    // header('Location: plan_detail.php?id=' . $plan_id);
    // exit();

?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  
    Document Title
    =============================================
    -->
    <title>Titan | Multipurpose HTML5 Template</title>

    <!-- favicons -->
    <?php include('favicons_link.php'); ?>
    <!-- stylesheet -->
    <?php include('stylesheet_link.php'); ?>

    <!-- slick css (画像スライド) -->
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick-theme.css">

  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- header -->
      <?php include('header.php'); ?>

      <div class="main">
        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                <h4 class="font-alt mb-0">Confirm Image</h4>
                <hr class="divider-w mt-10 mb-20">
                <!-- ここに写真を入力 -->
                <div class="your-class">
                  <?php if (!isset($_SESSION['images'])) { ?>
                  <img class="mb-20 img-thumbnail" width="150" src="images/no_image_available.png">
                  <?php } else { foreach ($_SESSION['images'] as $key => $image) { ?>
                  <img class="mb-20 img-thumbnail" width="150" src="images/<?php echo $_SESSION['images'][$key]; ?>">
                  <?php }} ?>
                </div>
              </div>
              <div class="col-sm-8 col-sm-offset-2 mt-40">
                <h4 class="font-alt mb-0">Confirm Image</h4>
                <hr class="divider-w mt-10 mb-20">

                <!-- タグを追加 -->
                <div>
                  <?php if(isset($_SESSION['tags'])) {foreach ($_SESSION['tags'] as $key => $value) { ?>
                    <div class="btn btn-default btn-xs btn-round TagDiv">
                      <label class="button-tag"><?php echo $_SESSION['tags'][$key]; ?></label>
                    </div>
                  <?php }} ?>
                </div>

                <form method="POST" action="post_create.php" class="form" role="form" >
                  <h4 class="font-alt mt-40">Confirm Plan / Request</h4>
                  <hr class="divider-w mt-10 mb-20">

                  <input type="hidden" name="hogehoge" value="hogehoge">

                  <!-- plan / request -->
                  <label class="control-label">plan or request?</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $request_type; ?>
                    </div>
                  </div>

                  <!-- title -->
                  <label class="control-label">Title</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $title; ?>
                    </div>
                  </div>

                  <!-- content -->
                  <label class="control-label">Content</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $content; ?>
                    </div>
                  </div>

                  <!-- destination -->
                  <label class="control-label">Destination</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $place; ?>
                    </div>
                  </div>

                  <!-- Start & End -->
                  <div class="row">
                    <div class="col-xs-6">
                      <label class="control-label">Start time</label>
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <?php echo $start_datetime; ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-6">
                      <label class="control-label">End time</label>
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <?php echo $end_datetime; ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- rendezvous -->
                  <label class="control-label">Rendezvous place</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $location; ?>
                    </div>
                  </div>

                  <!-- time -->
                  <label class="control-label">Rendezvous time</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $time; ?>
                    </div>
                  </div>

                  <!-- person -->
                  <label class="control-label">The number of people</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $person; ?>
                    </div>
                  </div>

                  <!-- cost -->
                  <label class="control-label">Cost (php)</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $cost; ?>
                    </div>
                  </div>

                  <!-- Entry field -->
                  <label class="control-label">Entry field</label>
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <?php echo $entry_field; ?>
                    </div>
                  </div>

                  <div class="form-group" style="text-align: right;">
                    <button type="submit" class="btn btn-info btn-md">Confirm</button>
                    <button type="button" onclick="location.href = 'post.php?action=rewrite'" class="btn btn-default btn-md">Cancel</button>
                  </div>
                </form>
              </div>
            </div> <!-- row -->
          </div> <!-- container -->
        </section>

        <!-- footer -->
        <?php include('footer.php'); ?>

      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <!-- JavaScripts -->
    <?php include('javascript_link.php'); ?>

  </body>
</html>