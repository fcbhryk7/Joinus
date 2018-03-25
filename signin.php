<?php

    session_start();
    require('dbconnect.php'); // 他のファイルの読み込み
    require('functions.php'); //ファンクション

    // エラーの連想配列を定義
    $errors = array();

    // ページ遷移元を取得 (前のページへ)
    if(empty($_POST)) {
      // 遷移元のURLを取得
      $url = get_page_name();
      // signin.php以外の遷移元を格納
      if($url != 'signin.php') {
          $_SESSION['before_page'] = $url;
          echo $_SESSION['before_page'];
      }
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
                      header('Location: index.php');
                      exit();
                  }
                } else {
                    $errors['password'] = "incorrect";
                }
            }
        } else {
            $errors['email'] = 'blank';
        }
        // echo '<pre>';
        // echo '$errors = ';
        // var_dump($errors);
        // echo '</pre>';
    }
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Joinus! : Signin</title>

    <?php 
      require('favicons_link.php');
      require('stylesheet_link.php');
    ?>
  </head>

  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- ヘッダー読み込み -->
      <?php include('header.php'); ?>

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
                  <!-- 追加機能 PW再設定 -->
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
    
    <?php include('javascript_link.php'); ?> 

  </body>
</html>