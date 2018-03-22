<?php 
    session_start();
    require('../functions.php');

    // サインアップ初回のフラグ
    $_SESSION['firsttime'] = 1;
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Joinus!members</title>
<?php
require('../favicons_link.php');
require('../stylesheet_link.php');
?>
<!--ヘッダーりくワイヤ -->
<?php
require('../header.php');
?>
</head>
<body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<h2>thank's!!!You are Joinus member.</h2>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
  <div class="row">
    <div class="mb-20">
      <a href="../signin.php" class="btn btn-info btn-md btn-round">signin</a>
    </div>
  </div>
</div>

<!-- フッターりくワイヤ⇩ -->
<?php
require('../footer.php');
?>
<!-- ジャバスクリプトりくワイヤ -->
<?php
require('../javascript_link.php');
?>
</body>
</html>