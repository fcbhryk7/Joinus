<?php
    // セッションスタート
    session_start();
    require('../dbconnect.php');
    require('../functions.php');

    //エラー配列定義
    $errors = array();

    // 戻ってきた場合の処理
    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite'){
        // $_GET = array('action'=>'rewrite');
        // $_POSTを偽造しています
        $_POST['input_email'] = $_SESSION['register']['email'];
        $_POST['input_name'] = $_SESSION['register']['name'];
        $_POST['input_password'] = $_SESSION['register']['password'];
        $_POST['input_gender'] = $_SESSION['register']['gender'];
        // バリデーションメッセージ用
        $errors['rewrite'] = true;
    }

    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';

    $name = '';
    $email = '';
    $password = '';
    $gender = '';


    // バリデーション実装
    // 空チェック
    //なんのエラーか知るために、エラーを定義
    if (!empty($_POST)) {

        //データ格納変数定義
        $email = $_POST['input_email'];
        $name = $_POST['input_name'];
        $password = $_POST['input_password'];
        $gender = $_POST['input_gender'];

        // メールアドレスの空チェック
        if ($email == '') {
            $errors['email'] = 'blank';
        }

        // ユーザー名の空チェック
        if ($name == '') {
            $errors['name'] = 'blank';
        }

        // パスワードの空チェック
        $str_c = strlen($password);
        if ($password == '') {
            $errors['password'] = 'blank';
        // 4より大きく、かつ16より小さい
        } elseif($str_c < 4 || 16 < $str_c) {
            $errors['password'] = 'length';
        }

        // ジェンダーの空チェック
        if ($gender == '') {
            $errors['gender'] = 'blank';
        }

        if (empty($errors)) {
            $_SESSION['register']['email'] = $email;
            $_SESSION['register']['name'] = $name;
            $_SESSION['register']['password'] = $password;
            $_SESSION['register']['gender'] = $gender;

            // echo '<pre>';
            // var_dump($errors);
            // echo '</pre>';
            header('Location: check.php');
            exit();
        }
        // $_SESSION['register'] = $_POST;
    }
?>


<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Joinus! : Signup</title>
    <?php
        require('../favicons_link.php');
        require('../stylesheet_link.php');
    ?>
  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...
        </div>
      </div>

      <!-- Header -->
      <?php include('../header.php'); ?>

        <!-- register↓ -->
        <section class="module">
          <div class="container">
            <div class="row">
              <!-- フォームのサイズ↓ -->
              <div class="col-sm-4 col-sm-offset-4 mb-sm-40">
                <h4 class="font-alt">Signup</h4>
                <hr class="divider-w mb-10">
                <form class="form" method="POST" action="signup.php">


                  <div class="form-group">
                    <input class="form-control" id="email" type="email" name="input_email" placeholder="Email" value="<?php echo $email; ?>"/>
                    <?php if(isset($errors['email']) && $errors['email'] == 'blank') { ?>
                    <span style="color: red;">メールアドレスを入力してください</span>
                    <?php } ?>
                  </div>

                  <div class="form-group">
                    <input class="form-control" id="name" type="text" name="input_name" placeholder="Username" value="<?php echo $name; ?>"/>
                    <?php if(isset($errors['name']) && $errors['name'] == 'blank') { ?>
                    <span style="color: red;">ユーザー名を入力してください</span><br>
                     <?php } ?>
                  </div>


                  <div class="form-group">
                    <input class="form-control" id="password" type="password" name="input_password" placeholder="Password"/>
                    <?php if(isset($errors['password']) && $errors['password'] == 'blank') { ?>
                    <span style="color: red;">パスワードを入力してください</span>
                    <?php } ?>
                    <?php if(isset($errors['password']) && $errors['password'] == 'length') { ?>
                    <span style="color: red;">パスワードは4〜16文字で入力してください</span>
                    <?php } ?>
                    <?php if(isset($errors['rewrite'])) { ?>
                    <span style="color: red;">パスワードを再入力してください</span>
                    <?php } ?>
                  </div>


                  <!-- 全然ちゃう -->
                  <div class="form-group">
                    <label for="salutation">Select gender</label>
                    <select name="input_gender" id="gender">
                      <option value="" selected>Please pick one</option>
                      <option>female</option>
                      <option>male</option>
                      <option>other</option>
                    </select>
                    <?php if(isset($errors['gender']) && $errors['gender'] == 'blank') { ?>
                    <span style="color: red;">Select gender</span>
                    <?php } ?>
                  </div>
                  <br>


                  <!-- インプットでなくbuttonを使用 -->
                  <div class="form-group">
                    <button class="btn btn-block btn-round btn-b" type='submit' name='action' value='send'>Signup</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>

        <!-- フッター⇩ -->
        <?php
            require('../footer.php');
        ?>
      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <!-- ジャバスクリプトりくワイヤ -->
    <?php
        require('../javascript_link.php');
    ?>
  </body>
</html>