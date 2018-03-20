<?php 
  // 要件メモ
  // セッションにユーザーのidが存在すれば、サインインチェック
  // ログインしたらもとの場所に戻したい ifで全て設定する
  // likes.phpに乗っている$_SERVERをつかって調べることができる

  session_start();
  require('dbconnect.php'); // 他のファイルの読み込み
  require('functions.php'); //ファンクション

  // エラーの連想配列を定義
  $errors = array();

  // ページ遷移元を取得 (前のページへ)
  
  if(empty($_POST)) {
    $_SESSION['before_page'] = get_page_name();
    echo $_SESSION['before_page'];
  }

  // echo_var_dump('$_POST', $_POST);

  // 画面の送信ボタンが押されたとき発動 / $_POSTが空じゃない時に発動
  if(!empty($_POST)) {
    $email = $_POST['input_email'];
    $password = $_POST['input_password'];

    // $emailが空じゃないかつ&passwordが空じゃない
    if($email != '' && $password != '') {
      $sql = 'SELECT * FROM `users` WHERE `email`=?';
      $data = array($email);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if($record == false) {
        // メールアドレスミス
        $errors['email'] = 'norecord';
      } else {
        // パスワードが一致しているか

          // echo $record['password'];
          // echo '<br>';
          // echo $password;
          // echo '<br>';
            
          // password_verify(普通文字列PW、ハッシュ文字列PW)
          // 一致していればtrueを、そうでなければfalseを返す
          $verify = password_verify($password, $record['password']);

            if ($verify == true) {
            // サインイン処理

              // セッションにサインインユーザーのidを保存
              $_SESSION['user']['id'] = $record['user_id'];

              // 次のページに遷移するもの/exitとセット
              if ($_SESSION['before_page'] == 'thanks.php') {
                          // profile_edit.phpに遷移
                header('Location: profile_edit.php?id=' . $_SESSION['user']['id']);
                exit();
              } else {
                  // 遷移元に戻る
                  header('Location:' . $_SESSION['before_page']);
                  exit();
              }
            } else {
                $errors['password'] = "incorrect";
            }
      }
    }
      echo '<pre>';
      echo '$errors = ';
      var_dump($errors);
      echo '</pre>';
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
    <title>Joinus! : Signin</title>
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

      <!-- ヘッダー読み込み -->
      <?php //include('header.php'); ?>

      <!-- Body -->
      <div class="main">
        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-4 mb-sm-40">
                <h4 class="font-alt">Signin</h4>
                <hr class="divider-w mb-10">
                  
                  <!-- signupへ転移 -->
                  <div class="form-group" align="right"><a href="register/signup.php">Signup here</a></div>
                  
                  <form method="POST" action="signin.php">
                    <div class="form-group">
                      <input class="form-control" id="email" type="email" name="input_email" placeholder="Email"/>
                    </div>

                    <div class="form-group">
                      <input class="form-control" id="password" type="password" name="input_password" placeholder="Password"/>
                    </div>

                    <?php if(!empty($errors)) { ?>
                      <p style="color: red;">Either email or password is invaild.</p>
                    <?php } ?>

                    <div class="form-group">
                      <button class="btn btn-round btn-b" type="submit">Signin</button>
                    </div>
                  </form>
                  <!-- <div class="form-group"><a href="">Forgot Password?</a></div> -->
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- Body終了 -->

      <!-- Footer -->
      <?php include('footer.php'); ?>

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