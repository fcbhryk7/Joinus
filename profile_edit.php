<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // フラッシュメッセージのクリア処理
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
    unset($_SESSION['flash']);

    // 配列表示
    // echo_var_dump('$_POST',$_POST);
    // echo_var_dump('$_FILES',$_FILES);

    // サインアップ後でない場合は、プロフィール画面へ遷移
    if (isset($_SESSION['firsttime']) && $_SESSION['firsttime'] == 1) {
        $_SESSION['firsttime'] = 0;
        header('Location: profile_edit.php?id=' . $_SESSION['user']['id']);
        exit();
    }

    // $_REQUEST['id'] が空の場合は signin.php へ強制遷移
    if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '' ) {
        header('Location: signin.php');
        exit();
    }

    // サインイン時に格納したセッションIDと、抽出したIDが合致しなければ signin.php へ強制遷移
    if ($_SESSION['user']['id'] != $_REQUEST['id']) {
        header('Location: signin.php');
        exit();
    }

    $sql = 'SELECT u.*, c.name AS country_name FROM users AS u, countries AS c WHERE u.country_id = c.country_id AND u.user_id = ?';
    $data = array($_SESSION['user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$profile',$profile);

    // 国名取得
    $countries = get_country_name();
    // echo $countries[0]['name'];

    // 滞在期間
    if (isset($profile['staying_time']) && $profile['staying_time'] != '') {
      $staying_time = explode(' ', $profile['staying_time']);
    } else {
      $staying_time = ['0','---'];
    }
    // echo_var_dump('$staying_time', $staying_time);

    // 以下でプロフィールを表示する
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
    <title>Joinus! : Profile edit</title>

    <!-- favicons -->
    <?php include('favicons_link.php'); ?>
    <!-- stylesheet -->
    <?php include('stylesheet_link.php'); ?>

    <!-- カレンダー表示用CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/pikaday-package.css">

    <!-- cropper CSS -->
    <link rel="stylesheet" type="text/css" href="assets/lib/cropper-3.1.6/dist/cropper.min.css">

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
            <?php
                // フラッシュメッセージ表示
                foreach(array('success', 'info', 'danger', 'warning') as $key) {
                    if(strlen(@$flash[$key])){
                        ?>
                            <div class="flash alert alert-<?php echo $key ?>">
                                <?php echo $flash[$key] ?>
                            </div>
                        <?php
                    }
                }
            ?>
              <div class="col-sm-8 col-sm-offset-2">
                <h4 class="font-alt mb-0">Edit Image</h4>
                <hr class="divider-w mt-10 mb-20">
                <img class="mb-20 img-thumbnail" width="150" src="user_profile_img/<?php echo $profile['image']; ?>">
                <form method="POST" action="profile_trimming.php" class="form" role="form" enctype="multipart/form-data">
                  <label><span class="btn btn-default btn-round btn-xs">select file<input type="file" id="profile-image" name="input_img_name" accept="images/*" style="display: none;"></span></label>
                  <!-- <input type="file" id="profile-image" name="input_img_name" accept="images/*"/> -->
                  <img id="select-image" style="max-width:500px;">
                  <!-- 切り抜き範囲をhiddenで保持する -->
                  <input type="hidden" id="upload-image-x" name="profileImageX" value="0"/>
                  <input type="hidden" id="upload-image-y" name="profileImageY" value="0"/>
                  <input type="hidden" id="upload-image-w" name="profileImageW" value="0"/>
                  <input type="hidden" id="upload-image-h" name="profileImageH" value="0"/>
                  <button type="submit" id="image_upload" class="btn btn-default btn-round btn-xs" disabled="disabled">upload</button>
                  <a href="profile_edit.php?id=<?php echo $_SESSION['user']['id']; ?>" class="btn btn-default btn-round btn-xs">cancel</a>
                </form>
              </div>
              <div class="col-sm-8 col-sm-offset-2 mt-40">
                <form method="POST" action="profile_update.php" class="form" role="form" >
                  <h4 class="font-alt mb-0">Edit Profile</h4>
                  <hr class="divider-w mt-10 mb-20">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input name="input_name" class="form-control input-lg" type="text"  value="<?php echo $profile['name'] ?>" placeholder="Name"/>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Gender</label>
                    <!-- <input class="form-control input-lg" type="text" placeholder="Country"/> -->
                    <select name="input_gender" class="form-control input-lg">
                      <!-- <option <?php if ($profile['gender'] == '---') {echo 'selected';} ?>>---</option> -->
                      <option <?php if ($profile['gender'] == 'female') {echo 'selected';} ?>>female</option>
                      <option <?php if ($profile['gender'] == 'male') {echo 'selected';} ?>>male</option>
                      <option <?php if ($profile['gender'] == 'other') {echo 'selected';} ?>>other</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Country</label>
                    <!-- <input class="form-control input-lg" type="text" placeholder="Country"/> -->
                    <select name="input_country" class="form-control input-lg">
                      <!-- <option <?php if ($profile['gender'] == '---') {echo 'selected';} ?>>---</option> -->

                      <?php foreach ($countries as $key => $value) { ?>
                      <option <?php if ($countries[$key]['name'] == $profile['country_name']) {echo 'selected';} ?>>
                        <?php echo $countries[$key]['name']; ?>
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Address</label>
                    <input name="input_address" class="form-control input-lg" value="<?php echo $profile['address'] ?>" type="text" placeholder="Address"/>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Callnumber</label>
                    <input name="input_callnumber" class="form-control input-lg" type="text" value="<?php echo $profile['callnumber'] ?>" placeholder="Callnumber"/>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Staying time</label>
                    <!-- <input name="input-staying-time" class="form-control input-lg" type="text" value="<?php echo $profile['staying_time'] ?>" placeholder="Staying time"/> -->
                    <div class="row">
                      <div class="col-xs-6">
                        <input type="text" name="input_time_number" value="<?php echo $staying_time[0] ?>" class="form-control input-lg">
                      </div>
                      <div class="col-xs-6">
                        <select name="input_time_unit" class="form-control input-lg">
                          <option <?php if ($staying_time['1'] == '---') {echo 'selected';} ?>>---</option>
                          <option <?php if ($staying_time['1'] == 'days') {echo 'selected';} ?>>days</option>
                          <option <?php if ($staying_time['1'] == 'weeks') {echo 'selected';} ?>>weeks</option>
                          <option <?php if ($staying_time['1'] == 'months') {echo 'selected';} ?>>months</option>
                          <option <?php if ($staying_time['1'] == 'years') {echo 'selected';} ?>>years</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="datepicker">Birthday</label>
                    <input name="input_birthday" id="datepicker" class="form-control input-lg" type="text" value="<?php echo $profile['birthday'] ?>" placeholder="Birthday"/>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Profile</label>
                    <textarea name="input_profile" class="form-control" rows="7" placeholder="Profile"><?php echo $profile['profile'] ?></textarea>
                  </div>

                  <div class="form-group" style="text-align: right;">
                    <button type="submit" class="btn btn-info btn-md">Update</button>
                    <button type="button" onclick="location.href = 'profile.php?id=<?php echo $_SESSION['user']['id']; ?>';" class="btn btn-default btn-md">Cancel</button>
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