<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    // エラーの連想配列を定義
    $errors = array();

    if(empty($_POST)){
        // ページ遷移元を取得
        $_SESSION['before_page'] = get_page_name();
        echo $_SESSION['before_page'];
    }

    // echo_var_dump('$_POST', $_POST);

    if (!empty($_POST)) {
        $email = h($_POST['input_email']);
        $password = h($_POST['input_password']);

        if($email != '' && $password != '') {
            $sql = 'SELECT * FROM users WHERE email = ?';
            $data = array($email);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            // バリデーション
            // レコードがない場合(メールアドレス入力ミス)
            if($record == false){
                $errors['email'] = 'norecord';
            }
            // レコードがある場合
            else {
                // password_verify(普通文字列パスワード, ハッシュ文字列パスワード);
                // 一致してればtrueを、そうでなければfalseを返す
                $verify = password_verify($password, $record['password']);

                if($verify){
                    // サインイン処理

                    // セッションにサインインユーザーのidを保存
                    $_SESSION['user']['id'] = $record['user_id'];
                    // echo_var_dump('$record', $record);

                    if ($_SESSION['before_page'] == 'thanks.php') {
                        // profile_edit.phpに遷移
                        header('Location: profile_edit.php?id=' . $_SESSION['user']['id']);
                        exit();
                    }
                    else{
                        // 遷移元に戻る
                        header('Location:' . $_SESSION['before_page']);
                        exit();
                    }
                }
                else {
                    $errors['password'] = "incorrect";
                }
            }
        }

        // echo_var_dump('$errors', $errors);
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
    <title>Titan | Multipurpose HTML5 Template</title>

    <!-- favicons -->
    <?php include('favicons_link.php'); ?>
    <!-- stylesheet -->
    <?php include('stylesheet_link.php'); ?>
    
  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...
        </div>
      </div>

      <?php //require('../header.php'); ?>

      <!-- メイン画像 -->
      <div class="main">
        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-5">
                <h4 class="font-alt">Signin</h4>
                <hr class="divider-w mb-10">
                <form class="form" method="POST" action="signin.php">

                  <!-- email入力 -->
                  <div class="form-group">
                    <input class="form-control" id="email" type="email" name="input_email" placeholder="Email" value=""/>
                  </div>

                  <!-- password入力 -->
                  <div class="form-group">
                    <input class="form-control" id="password" type="password" name="input_password" placeholder="Password"/>
                  </div>

                  <?php if(!empty($errors)) { ?>
                  <p style="color: red;">Either email or password is invaild.</p>
                  <?php } ?>

                  <!-- インプットでなくbuttonを使用 -->
                  <div class="form-group">
                    <button class="btn btn-block btn-round btn-b" type='submit'>Signin</button>
                  </div>

                  <div class="form-group">
                    <a href="register/signup.php" class="btn btn-block btn-round btn-default">Signup</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>

        <?php require('footer.php'); ?>

      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <!-- JavaScripts -->
    <?php include('javascript_link.php'); ?>
  </body>
</html>