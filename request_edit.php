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

    // $_REQUEST['id'] が空の場合は signin.php へ強制遷移
    if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '' ) {
        header('Location: signin.php');
        exit();
    }

    // エラー配列
    $errors = array();
    // $_REQUEST['action'] が定義され、rewriteのときは、エラー配列へ格納
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite' ) {
        $errors['history'] = 'blank';
    }

    // プラン詳細情報
    // $sql = 'SELECT * FROM plans WHERE user_id = ? AND plan_id = ?';
    // $data = array($_SESSION['user']['id'], $_REQUEST['id']);
    $sql = 'SELECT * FROM plans WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $plan = $stmt->fetch(PDO::FETCH_ASSOC);

    // イメージ情報
    $sql = 'SELECT * FROM images WHERE plan_id = ? ORDER BY image_order';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $images = $stmt->fetchAll();

    if(!isset($_REQUEST['image']) || $_REQUEST['image'] != 'true'){
      // セッション初期化
      unset($_SESSION['images']);
      // 取得した画像をセンションに格納
      foreach ($images as $key => $value) {
          $_SESSION['images'][] = $value['image_name'];
      }
    }

    // タグ情報
    $sql = 'SELECT t.* FROM plans_tags AS pt, tags AS t WHERE pt.tag_id = t.tag_id AND pt.plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $tags = $stmt->fetchAll();

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
    <title>Joinus! : Request edit</title>

    <!-- favicons -->
    <?php include('favicons_link.php'); ?>
    <!-- stylesheet -->
    <?php include('stylesheet_link.php'); ?>

    <!-- カレンダー表示用CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.datetimepicker.css">

    <!-- cropper CSS -->
    <link rel="stylesheet" type="text/css" href="assets/lib/cropper-3.1.6/dist/cropper.min.css">

    <!-- slick css (画像スライド) -->
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick-theme.css">
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
                <div class="your-class">
                  <?php if (!isset($_SESSION['images'])) { ?>
                    <img class="mb-20 img-thumbnail" width="150" src="images/no_image_available.png">
                  <?php } else { foreach ($_SESSION['images'] as $key => $image) { ?>
                    <img class="mb-20 img-thumbnail" width="150" src="images/<?php echo $_SESSION['images'][$key]; ?>">
                  <?php }} ?>
                </div>
                <form method="POST" action="plan_trimming.php" class="form" role="form" enctype="multipart/form-data" id="image-form">
                  <label><span class="btn btn-default btn-round btn-xs">select file<input type="file" id="plan-image" name="input_img_name" accept="images/*" style="display: none;"></span></label>
                  <!-- <input type="file" id="profile-image" name="input_img_name" accept="images/*"/> -->
                  <img id="select-image" style="max-width:500px;">
                  <!-- 切り抜き範囲をhiddenで保持する -->
                  <input type="hidden" id="upload-image-x" name="profileImageX" value="0"/>
                  <input type="hidden" id="upload-image-y" name="profileImageY" value="0"/>
                  <input type="hidden" id="upload-image-w" name="profileImageW" value="0"/>
                  <input type="hidden" id="upload-image-h" name="profileImageH" value="0"/>
                  <button type="submit" id="image_upload" class="btn btn-default btn-round btn-xs" disabled="disabled">upload</button>
                  <button type="button" id="image_delete" class="btn btn-default btn-round btn-xs">delete</button>
                </form>
              </div>
              <form method="POST" action="request_update.php" class="form" role="form" >
                <!-- tag機能 -->
                <div class="col-sm-8 col-sm-offset-2 mt-40">
                  <h4 class="font-alt">post tags</h4>
                  <hr class="divider-w mt-10 mb-20">
                  <div class="form-group">
                    <div class="row">
                      <!-- <form method="POST" action="tag_control.php" id="tag_form"> -->
                        <div class="col-xs-9">
                          <!-- <label class="control-label">Start time</label> -->
                          <input type="text" name="input_tag_name" class="form-control input-lg" id="TagText" placeholder="Please enter tags">
                        </div>
                        <div class="col-xs-3">
                          <!-- <label class="control-label"> </label> -->
                          <div class="btn btn-default btn-md form-control" id="TagButton">add</div>
                        </div>
                      <!-- </form> -->
                    </div>
                  </div>
                  <div id="TagHead">
                    <?php if(($tags != false)) {foreach ($tags as $key => $tag) { ?>
                      <div class="btn btn-default btn-xs btn-round TagDiv">
                        <button class="close ml-10 TagClose" data-tag="<?php echo $tag['name']; ?>">&times;</button>
                        <label class="button-tag"><?php echo $tag['name']; ?></label>
                        <input type="hidden" name="tags[]" value="<?php echo $tag['name']; ?>">
                      </div>
                    <?php }} ?>
                  </div>
                </div>
                <div class="col-sm-8 col-sm-offset-2 mt-40">
                  <h4 class="font-alt mb-0">Edit Profile</h4>
                  <hr class="divider-w mt-10 mb-20">

                  <!-- plan_id -->
                  <input type="hidden" name="input_plan_id" value="<?php echo $plan['plan_id']; ?>">

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
                      <div class="col-md-6">
                        <label class="control-label">Start time</label>
                        <input type="text" name="input_start_datetime" value="<?php echo $plan['start_datetime'] ?>" class="form-control input-lg datetimepicker">
                      </div>
                      <div class="col-md-6">
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

                  <h4 class="font-alt mt-40">Change history</h4>
                  <hr class="divider-w mt-10 mb-20">
                  <!-- Change history -->
                  <div class="form-group">
                    <?php if(isset($errors['history']) && $errors['history'] = 'blank'){ ?>
                    <span style="color: red;">Please enter change history.</span>
                    <?php } ?>
                    <!-- <label class="control-label">The change history</label> -->
                    <textarea name="input_history" class="form-control" rows="5" placeholder="Change history"></textarea>
                  </div>

                  <div class="form-group" style="text-align: right;">
                    <button type="submit" class="btn btn-info btn-md">Update</button>
                    <button type="button" onclick="location.href = 'request_detail.php?id=<?php echo $plan['plan_id']; ?>';" class="btn btn-default btn-md">Cancel</button>
                  </div>
                </div>
              </form>
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