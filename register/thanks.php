<?php 
    session_start();
    require('../dbconnect.php');
    require('../functions.php');

    // サインアップ初回のフラグ
    $_SESSION['firsttime'] = 1;
 ?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Joinus! : Thanks</title>

    <?php 
      require('../favicons_link.php');
      require('../stylesheet_link.php');
    ?>
  </head>

  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
      <main>
        <div class="page-loader">
          <div class="loader">Loading...</div>
        </div>

        <!-- ヘッダー読み込み -->
        <?php include('../header.php'); ?>

        <!-- Body -->
        <div class="main">
          <section class="module">
            <div class="container">
              <div class="row">
                <div class="col-sm-4 col-sm-offset-4 mb-sm-40">
                  <h4 class="font-alt">Thanks you so much!<br>You are Joinus member.</h4>
                  <hr class="divider-w mb-10">
                    <div class="form-group"> 
                      <div class="btn-group btn-group-justified" role="group">
                        <a href="../signin.php">
                          <p>
                            <button class="btn btn-border-d btn-round" type="submit"><i class="fa fa-child"></i> Signin</button>
                          </p>
                        </a>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <!-- Body終了 -->
        <!-- Footer -->
        <?php include('../footer.php'); ?>

        <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
      </main>
      
      <?php include('../javascript_link.php'); ?> 
  </body>
</html>
