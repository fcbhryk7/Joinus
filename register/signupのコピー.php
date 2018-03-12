<?php 
// バリデーション実装
// 空チェック
//なんのエラーか知るために、エラーを定義
if (!empty($_POST)) {
//データ格納
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
        if ($password == '') {
            $errors['password'] = 'blank';
        }
        
        // ジェンダーの空チェック
        if ($gender == '') {
            $errors['gender'] = 'blank';
        }
    }



 ?>


<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  
    Document Title
    =============================================
    -->
    <title>Titan | Multipurpose HTML5 Template</title>
   

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


<!--ヘッダーりくワイヤ -->
      <?php 
      require('../header.php');
       ?>

<!-- メイン画像 -->
      <div class="main">
        <section class="module bg-dark-30" data-background="../Titan-master/assets/images/section-4.jpg">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h1 class="module-title font-alt mb-0">Signup</h1>
              </div>
            </div>
          </div>
        </section>




<!-- register↓ -->
        <section class="module">
          <div class="container">
            <div class="row">
            <!-- フォームのサイズ↓ -->
              <div class="col-sm-5">
                <h4 class="font-alt">Signup</h4>
                <hr class="divider-w mb-10">
                <form class="form" method="POST" action="check.php">


                  <div class="form-group">
                    <input class="form-control" id="email" type="email" name="input_email" placeholder="Email"/>
                  </div>

                  <div class="form-group">
                    <input class="form-control" id="name" type="text" name="inpust_name" placeholder="Username"/>
                  </div>

                  <div class="form-group">
                    <input class="form-control" id="password" type="password" name="input_password" placeholder="Password"/>
                  </div>

                  <!-- 全然ちゃう -->
                  <div class="form-group">
                    <label for="salutation">Select gender</label>
                    <select name="input_gender" id="gender">
                      <option disabled selected>Please pick one</option>
                      <option>female</option>
                      <option>male</option>
                      <option>other</option>
                    </select>
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
        <!-- section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-5 col-sm-offset-1 mb-sm-40">
                <h4 class="font-alt">Login</h4>
                <hr class="divider-w mb-10">
                <form class="form">
                  <div class="form-group">
                    <input class="form-control" id="username" type="text" name="username" placeholder="Username"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="password" type="password" name="password" placeholder="Password"/>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-round btn-b">Login</button>
                  </div>
                  <div class="form-group"><a href="">Forgot Password?</a></div>
                </form>
              </div>
              <div class="col-sm-5">
                <h4 class="font-alt">Register</h4>
                <hr class="divider-w mb-10">
                <form class="form">
                  <div class="form-group">
                    <input class="form-control" id="E-mail" type="text" name="email" placeholder="Email"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="username" type="text" name="username" placeholder="Username"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="password" type="password" name="password" placeholder="Password"/>
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="re-password" type="password" name="re-password" placeholder="Re-enter Password"/>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-block btn-round btn-b">Register</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section> -->

<!-- フッターりくワイヤ⇩ -->
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