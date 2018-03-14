<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);
    // echo_var_dump('$_FILES',$_FILES);

    // $_REQUEST['id'] が空の場合は index.php へ強制遷移
    if (empty($_REQUEST)) {
        header('Location: index.php');
        exit();
    }

    // サインイン時に格納したセッションIDと、抽出したIDが合致しなければ index.php へ強制遷移
    if ($_SESSION['user']['id'] != $_REQUEST['id']) {
        header('Location: index.php');
        exit();
    }

    $sql = 'SELECT u.*, c.name AS country_name FROM users AS u, countries AS c WHERE u.country_id = c.country_id AND u.user_id = ?';
    $data = array($_SESSION['user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // 国名取得
    $countries = get_country_name();
    // echo $countries[0]['name'];

    // 滞在期間
    $staying_time = explode(' ', $profile['staying_time']);
    // echo_var_dump('$staying_time', $staying_time);

    // 以下でプロフィールを表示する
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
    <link href="assets/css/style.css?<?php echo date('Ymd-Hi'); ?>" rel="stylesheet">
    <link id="color-scheme" href="assets/css/colors/default.css" rel="stylesheet">

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
      <?php //include('header.php'); ?>

      <div class="main">
        <section class="module">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                <img class="mb-20 img-thumbnail" width="150" src="user_profile_img/<?php echo $profile['image']; ?>">
                <form method="POST" action="trimming.php" class="form" role="form" enctype="multipart/form-data">
                  <label><span class="btn btn-default btn-round btn-xs">select file<input type="file" id="profile-image" name="input_img_name" accept="images/*" style="display: none;"></span></label>
                  <!-- <input type="file" id="profile-image" name="input_img_name" accept="images/*"/> -->
                  <img id="select-image" style="max-width:500px;">
                  <!-- 切り抜き範囲をhiddenで保持する -->
                  <input type="hidden" id="upload-image-x" name="profileImageX" value="0"/>
                  <input type="hidden" id="upload-image-y" name="profileImageY" value="0"/>
                  <input type="hidden" id="upload-image-w" name="profileImageW" value="0"/>
                  <input type="hidden" id="upload-image-h" name="profileImageH" value="0"/>
                  <button type="submit" id="image_upload" class="btn btn-default btn-round btn-xs" disabled="disabled">upload</button>
                </form>
              </div>
              <div class="col-sm-8 col-sm-offset-2">
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
                        <option <?php if ($profile['gender'] == '---') {echo 'selected';} ?>>---</option>
                        <option <?php if ($profile['gender'] == 'man') {echo 'selected';} ?>>man</option>
                        <option <?php if ($profile['gender'] == 'woman') {echo 'selected';} ?>>woman</option>
                        <option <?php if ($profile['gender'] == 'other') {echo 'selected';} ?>>other</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Country</label>
                      <!-- <input class="form-control input-lg" type="text" placeholder="Country"/> -->
                      <select name="input_country" class="form-control input-lg">
                        <option <?php if ($profile['gender'] == '---') {echo 'selected';} ?>>---</option>

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
        <div class="module-small bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">About Titan</h5>
                  <p>The languages only differ in their grammar, their pronunciation and their most common words.</p>
                  <p>Phone: +1 234 567 89 10</p>Fax: +1 234 567 89 10
                  <p>Email:<a href="#">somecompany@example.com</a></p>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Recent Comments</h5>
                  <ul class="icon-list">
                    <li>Maria on <a href="#">Designer Desk Essentials</a></li>
                    <li>John on <a href="#">Realistic Business Card Mockup</a></li>
                    <li>Andy on <a href="#">Eco bag Mockup</a></li>
                    <li>Jack on <a href="#">Bottle Mockup</a></li>
                    <li>Mark on <a href="#">Our trip to the Alps</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Blog Categories</h5>
                  <ul class="icon-list">
                    <li><a href="#">Photography - 7</a></li>
                    <li><a href="#">Web Design - 3</a></li>
                    <li><a href="#">Illustration - 12</a></li>
                    <li><a href="#">Marketing - 1</a></li>
                    <li><a href="#">Wordpress - 16</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Popular Posts</h5>
                  <ul class="widget-posts">
                    <li class="clearfix">
                      <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-1.jpg" alt="Post Thumbnail"/></a></div>
                      <div class="widget-posts-body">
                        <div class="widget-posts-title"><a href="#">Designer Desk Essentials</a></div>
                        <div class="widget-posts-meta">23 january</div>
                      </div>
                    </li>
                    <li class="clearfix">
                      <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-2.jpg" alt="Post Thumbnail"/></a></div>
                      <div class="widget-posts-body">
                        <div class="widget-posts-title"><a href="#">Realistic Business Card Mockup</a></div>
                        <div class="widget-posts-meta">15 February</div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr class="divider-d">
        <footer class="footer bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <p class="copyright font-alt">&copy; 2017&nbsp;<a href="index.html">TitaN</a>, All Rights Reserved</p>
              </div>
              <div class="col-sm-6">
                <div class="footer-social-links"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a>
                </div>
              </div>
            </div>
          </div>
        </footer>
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

    <!-- カレンダー表示用JS -->
    <script src="assets/js/moment.js"></script>
    <script src="assets/js/pikaday.js"></script>
    <script>
        // calender表示
        var picker = new Pikaday(
        {
            field: document.getElementById('datepicker'),
            firstDay: 1,
            minDate: new Date(1900, 01, 01),
            maxDate: new Date(2020, 12, 31),
            yearRange: [1900,2020]
        });
    </script>

    <!-- cropper JS -->
    <script src="assets/lib/cropper-3.1.6/dist/cropper.min.js"></script>
    <script type="text/javascript">
      $(function(){
          // 初期設定
          var options =
          {
            aspectRatio: 1 / 1,
            viewMode:1,
            crop: function(e) {
                  cropData = $('#select-image').cropper("getData");
                  $("#upload-image-x").val(Math.floor(cropData.x));
                  $("#upload-image-y").val(Math.floor(cropData.y));
                  $("#upload-image-w").val(Math.floor(cropData.width));
                  $("#upload-image-h").val(Math.floor(cropData.height));
            },
            zoomable:false,
            minCropBoxWidth:162,
            minCropBoxHeight:162
          }

          // 初期設定をセットする
          $('#select-image').cropper(options);

          $("#profile-image").change(function(){
              // ファイル選択変更時に、選択した画像をCropperに設定する
              $('#select-image').cropper('replace', URL.createObjectURL(this.files[0]));

              // 無効化ボタンを解除
              $('#image_upload').removeAttr('disabled');
          });


      });
    </script>
  </body>
</html>