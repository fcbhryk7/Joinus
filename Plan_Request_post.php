<?php 
  session_start();
  require('dbconnect.php');
  require('functions.php');

  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';
  echo_var_dump('aaa', $_POST);

  // 変数の空定義
  $title = '';
  $tags = '';
  $place = '';
  $date = '';
  $price = '';
  $time = '';
  $location = '';
  $entry_field = '';


  // もし戻ってきた時
  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
    // $_GET = array('action'=>'rewrite');
    // $_POSTを偽造します
    $_POST['input_title'] = $_SESSION['register']['titile'];
    $_POST['input_tags'] = $_SESSION['register']['tags'];
    $_POST['input_place'] = $_SESSION['register']['place'];
    $_POST['input_date'] = $_SESSION['register']['date'];
    $_POST['input_price'] = $_SESSION['register']['price'];
    $_POST['input_time'] = $_SESSION['register']['time'];
    $_POST['input_location'] = $_SESSION['register']['entry_field'];

    // バリデーションメッセージ用 なんでも良いからデータを入れる
    $errors['rewrite'] = true;
  }

  if (!empty($_POST)) {
  echo '送信<br>';

  // 変数定義
  $name = $_POST['input_name'];
  $email = $_POST['input_email'];
  $password = $_POST['input_password'];

  // ユーザー名の空チェック
  if ($name == '') {
      $errors['name'] = 'blank';
  }

  // ①emailとpasswordの空チェック
  if ($email == '') {
      $errors['email'] = 'blank';
  }

  $str_c = strlen($password);
  if ($password == '') {
      $errors['password'] = 'blank';
  } elseif ($str_c < 4 || 16 < $str_c) {
      $errors['password'] = 'length';
  }

  // type=fileの情報を受け取るには $_FILES スーパーグローバル変数が必要
  if (!empty($_POST)) {
        echo '送信<br>';

        if (!isset($_REQUEST['action'])) {
            $file_name = $_FILES['input_img_name']['name'];  
        }
        if (!empty($file_name)) {
            // JPG/PNG/GIFの三種類のみに制限
            $file_type = substr($file_name,-3);
            $file_type = strtolower($file_type);

            // 画像ファイル以外だった場合はTrue処理=エラー
            if ($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif') {
                $errors['img_name'] = 'type';
            }

        } else {
            $errors['img_name'] = 'blank';
        }

        if (isset($_REQUEST['action'])) {
            $errors['img_name'] = 'rewrite';
        }
  }

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
    <title>Joinus! : Plan / Request post</title>
    <!--  
    Favicons
    =============================================
    -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!--  
    Stylesheets
    =============================================
    
    -->
    <!-- Default stylesheets-->
    <link href="assets/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template specific stylesheets-->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Volkhov:400i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="assets/lib/animate.css/animate.css" rel="stylesheet">
    <link href="assets/lib/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/lib/et-line-font/et-line-font.css" rel="stylesheet">
    <link href="assets/lib/flexslider/flexslider.css" rel="stylesheet">
    <link href="assets/lib/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="assets/lib/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link href="assets/lib/simple-text-rotator/simpletextrotator.css" rel="stylesheet">
    <!-- Main stylesheet and color file-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link id="color-scheme" href="assets/css/colors/default.css" rel="stylesheet">
  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>
      
      <!-- ヘッター読み込む -->

      <!-- Body -->
      <div class="main">
        <!-- <section class="module bg-dark-30 about-page-header" data-background="assets/images/about_bg.jpg">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h1 class="module-title font-alt mb-0">Forms</h1>
              </div>
            </div>
          </div>
        </section> -->

        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                <h4 class="font-alt mb-0">Plan / Request post</h4>
                <hr class="divider-w mt-10 mb-20">
                <form class="form" role="form">
                  <div class="col-sm-4 mb-sm-20">
                    <select class="form-control">
                      <option>Plan</option>
                      <option>Request</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-block btn-round btn-g" type="submit">Select</button>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Title"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Tags"/>
                  </div>
                  
                  <span>Plan img</span><br>
                  <input type="file" name="input_img_name" accept="plan_img/*">
                  <?php if (isset($errors['plan_img']) && $errors['img_name'] == 'blank' ){ ?>
                    <span style="color: red;">プロフィール画像を入力してください</span><br>
                  <?php } ?>
                  <?php if (isset($errors['img_name']) && $errors['img_name'] == 'type' ){ ?>
                    <span style="color: red;">プロフィール画像にはjpg / png / gifのいずれかに指定してください</span><br>
                  <?php } ?>
                  <?php if (isset($errors['img_name']) && $errors['img_name'] == 'rewrite' ){ ?>
                    <span style="color: red;">プロフィール画像を再指定してください</span><br>
                  <?php } ?>

                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Plan place"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Date (Calender)"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Price / Hope price"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Meeting time"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Meeting place"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Number of people"/>
                  </div>
                  <textarea class="form-control" rows="7" placeholder="Entry field"></textarea>
                    <p>
                      <button class="btn btn-primary btn-round btn-block" type="button">Post</button>
                    </p>
                </form>
              </div>
            </div>
          </div>
        </section>
        
        <!-- フッター読み込み -->

      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>

    <!--  
    JavaScripts
    =============================================
    -->
    <script src="assets/lib/jquery/dist/jquery.js"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/lib/wow/dist/wow.js"></script>
    <script src="assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js"></script>
    <script src="assets/lib/isotope/dist/isotope.pkgd.js"></script>
    <script src="assets/lib/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="assets/lib/flexslider/jquery.flexslider.js"></script>
    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="assets/lib/smoothscroll.js"></script>
    <script src="assets/lib/magnific-popup/dist/jquery.magnific-popup.js"></script>
    <script src="assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>