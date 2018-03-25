<?php

    // echo '<pre>';
    // echo '$_POST=';
    // echo var_dump($_POST);
    // echo '</pre>';


    // セッション開始
    session_start();

    // DBコネクション
    require('../dbconnect.php');
    require('../functions.php');

    if(!isset($_SESSION['register'])) {
        header('Location: signup.php');
        exit();
    }

    // echo '<pre>';
    // echo '$_SESSION=';
    // echo var_dump($_SESSION);
    // echo '</pre>';

    $email = $_SESSION['register']['email'];
    $name = $_SESSION['register']['name'];
    $password = $_SESSION['register']['password'];
    $gender = $_SESSION['register']['gender'];

    // $_POSTが空じゃなければ処理=ユーザー登録ボタンがおされたら
    if(!empty($_POST)){
        // パスワードのハッシュ化
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        // echo $hash_password;
        // echo '<br>';

        // STEP2
        $sql = 'INSERT INTO `users` SET `email` = ?, `name` = ?, `password` = ?, `gender` = ?, `created` = now()';
        // $sql = 'SELECT * FROM `survey` WHERE 1';
        $data = array($email, $name, $hash_password, $gender);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // STEP3
        $dbh=null;

        // セッションの初期化
        unset($_SESSION['register']);

        // thanks.phpページへ遷移
        header('Location: thanks.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
<?php
  require('favicons_link.php');
  require('stylesheet_link.php');
?>
</head>
<body style="margin-top: 60px">
<!--ヘッダーりくワイヤ -->
<?php
    require('../header.php');
?>
  <h3>check</h3>
  <div class="container">
    <div class="row">
      <div>
        <p>メールアドレス:<?php echo htmlspecialchars($email); ?></p>
        <p>ユーザー名:<?php echo htmlspecialchars($name); ?></p>
        <p>パスワード:●●●●●●●●</p>

        <form method="POST" actoin="thanks.php">
          <input type="hidden" name="hoge" value="fuga">
          <!-- action=rewrite 
                ユーザーが入力した状態で戻る -->
          <a href="signup.php?action=rewrite">戻る</a>
          <input type="submit" value="登録">
        </form>
      </div>
    </div>
  </div>
    <!-- フッターりくワイヤ⇩ -->
  <?php
      require('../footer.php');
  ?>
<!-- ジャバスクリプトりくワイヤ -->
<?php
  require('javascript_link.php');
?>
</body>
</html>