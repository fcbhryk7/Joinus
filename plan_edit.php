<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);
    // echo_var_dump('$_FILES',$_FILES);

    // $_REQUEST['id'] が空の場合は signin.php へ強制遷移
    if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '' ) {
        header('Location: signin.php');
        exit();
    }

    // プラン詳細情報
    $sql = 'SELECT * FROM plans WHERE user_id = ? AND plan_id = ?';
    $data = array($_SESSION['user']['id'], $_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $plan = $stmt->fetch(PDO::FETCH_ASSOC);

    // イメージ情報
    $sql = 'SELECT * FROM images WHERE plan_id = ? ORDER BY image_order';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $images = $stmt->fetchAll();

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

    <!-- カレンダー表示用CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.datetimepicker.css">

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
              <div class="col-sm-8 col-sm-offset-2">
                <h4 class="font-alt mb-0">Edit Image</h4>
                <hr class="divider-w mt-10 mb-20">
                <img class="mb-20 img-thumbnail" width="150" src="user_profile_img/<?php echo $plan['image']; ?>">
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
              <div class="col-sm-8 col-sm-offset-2 mt-40">
                <form method="POST" action="plan_update.php" class="form" role="form" >
                  <h4 class="font-alt mb-0">Edit Profile</h4>
                  <hr class="divider-w mt-10 mb-20">

                    <!-- title -->
                    <div class="form-group">
                      <label class="control-label">Title</label>
                      <input name="input_title" class="form-control input-lg" type="text"  value="<?php echo $plan['title'] ?>" placeholder="Title"/>
                    </div>

                    <!-- content -->
                    <div class="form-group">
                      <label class="control-label">Content</label>
                      <textarea name="input_content" class="form-control" rows="5" placeholder="Content"><?php echo $plan['content'] ?></textarea>
                    </div>

                    <!-- destination -->
                    <div class="form-group">
                      <label class="control-label">Destination</label>
                      <input name="input_place" class="form-control input-lg" type="text"  value="<?php echo $plan['place'] ?>" placeholder="Destination"/>
                    </div>

                    <!-- Start & End -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-6">
                          <label class="control-label">Start time</label>
                          <input type="text" name="input_start_datetime" value="<?php echo $plan['start_datetime'] ?>" class="form-control input-lg datetimepicker">
                        </div>
                        <div class="col-xs-6">
                          <label class="control-label">End time</label>
                          <input type="text" name="input_end_datetime" value="<?php echo $plan['end_datetime'] ?>" class="form-control input-lg datetimepicker">
                        </div>
                      </div>
                    </div>

                    <!-- rendezvous -->
                    <div class="form-group">
                      <label class="control-label">Rendezvous</label>
                      <input name="input_location" class="form-control input-lg" type="text"  value="<?php echo $plan['location'] ?>" placeholder="Rendezvous"/>
                    </div>

                    <!-- time -->
                    <div class="form-group">
                      <label class="control-label">Time</label>
                      <input type="text" name="input_time" value="<?php echo $plan['time'] ?>" class="form-control input-lg datetimepicker">
                    </div>

                    <!-- person -->
                    <div class="form-group">
                      <label class="control-label">The number of people</label>
                      <input name="input_person" class="form-control input-lg" type="number" value="<?php echo $plan['person'] ?>" placeholder="The number of people"/>
                    </div>

                    <!-- cost -->
                    <div class="form-group">
                      <label class="control-label">Cost (php)</label>
                      <input name="input_cost" class="form-control input-lg" type="number" value="<?php echo $plan['cost'] ?>" placeholder="Cost"/>
                    </div>

                    <!-- Entry field -->
                    <div class="form-group">
                      <label class="control-label">Entry field</label>
                      <textarea name="input_entry_field" class="form-control" rows="5" placeholder="Entry field"><?php echo $plan['entry_field'] ?></textarea>
                    </div>

                    <div class="form-group" style="text-align: right;">
                      <button type="submit" class="btn btn-info btn-md">Update</button>
                      <button type="button" onclick="location.href = 'plan_detail.php?id=<?php echo $_SESSION['user']['id']; ?>';" class="btn btn-default btn-md">Cancel</button>
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

    <!-- カレンダー表示用JS -->
    <script src="assets/js/moment.js"></script>
    <!-- <script src="assets/js/pikaday.js"></script> -->
    <script src="assets/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        // calender表示
        $(function(){
            $('.datetimepicker').datetimepicker();
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