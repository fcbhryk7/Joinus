<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    if (!empty($_POST)) {
        // echo_var_dump('$_POST',$_POST);
        // unset($_SESSION['tags']);
        // foreach ($_POST['tags'] as $key => $value) {
        //     $_SESSION['tags'][] = h($value);
        // }
        // echo_var_dump('$_SESSION',$_SESSION);
        // die();
        // echo_var_dump('$_FILES',$_FILES);
    }

    $errors = array();

    // 戻ってきた場合の処理
    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite'){
        // $_GET = array('action'=>'rewrite');
        // $_POSTを偽造しています
        $_POST['input_request_type'] = $_SESSION['post']['request_type'];
        $_POST['input_title'] = $_SESSION['post']['title'];
        $_POST['input_content'] = $_SESSION['post']['content'];
        $_POST['input_place'] = $_SESSION['post']['place'];
        $_POST['input_start_datetime'] = $_SESSION['post']['start_datetime'];
        $_POST['input_end_datetime'] = $_SESSION['post']['end_datetime'];
        $_POST['input_location'] = $_SESSION['post']['location'];
        $_POST['input_time'] = $_SESSION['post']['time'];
        $_POST['input_person'] = $_SESSION['post']['person'];
        $_POST['input_cost'] = $_SESSION['post']['cost'];
        $_POST['input_entry_field'] = $_SESSION['post']['entry_field'];

        // バリデーションメッセージ用
        $errors['rewrite'] = true;

        // タグを偽造
        foreach ($_SESSION['tags'] as $key => $value) {
            $_POST['tags'][] = $value;
        }
    }

    // 初期化
    $request_type = 'plan';
    $title = '';
    $content = '';
    $place = '';
    $start_datetime = '';
    $end_datetime = '';
    $location = '';
    $time = '';
    $person = '';
    $cost = '';
    $entry_field = '';
    unset($_SESSION['post']);
    // unset($_SESSION['images']);

    if (!empty($_POST)) {
        // 変数格納
        $request_type = htmlspecialchars($_POST['input_request_type']);
        $title = htmlspecialchars($_POST['input_title']);
        $content = htmlspecialchars($_POST['input_content']);
        $place = htmlspecialchars($_POST['input_place']);
        $start_datetime = htmlspecialchars($_POST['input_start_datetime']);
        $end_datetime = htmlspecialchars($_POST['input_end_datetime']);
        $location = htmlspecialchars($_POST['input_location']);
        $time = htmlspecialchars($_POST['input_time']);
        $person = htmlspecialchars($_POST['input_person']);
        $cost = htmlspecialchars($_POST['input_cost']);
        $entry_field = htmlspecialchars($_POST['input_entry_field']);

        // タグをセッションに追加する
        unset($_SESSION['tags']);
        foreach ($_POST['tags'] as $key => $value) {
            $_SESSION['tags'][] = h($value);
        }

        // バリデーション
        if ($title == '') {
            $errors['title'] = 'blank';
        }

        if ($content == '') {
            $errors['content'] = 'blank';
        }

        if ($place == '') {
            $errors['place'] = 'blank';
        }

        if ($start_datetime == '' && $request_type == 'plan') {
            $errors['start_datetime'] = 'blank';
        }

        if ($end_datetime == '' && $request_type == 'plan') {
            $errors['end_datetime'] = 'blank';
        }

        if ($location == '' && $request_type == 'plan') {
            $errors['location'] = 'blank';
        }

        if ($time == '' && $request_type == 'plan') {
            $errors['time'] = 'blank';
        }

        if ($person == '' && $request_type == 'plan') {
            $errors['person'] = 'blank';
        }

        if ($cost == '' && $request_type == 'plan') {
            $errors['cost'] = 'blank';
        }

        // エラーが空だった場合
        if(empty($errors)) {
            // セッションに代入
            $_SESSION['post']['request_type'] = $request_type;
            $_SESSION['post']['title'] = $title;
            $_SESSION['post']['content'] = $content;
            $_SESSION['post']['place'] = $place;
            $_SESSION['post']['start_datetime'] = $start_datetime;
            $_SESSION['post']['end_datetime'] = $end_datetime;
            $_SESSION['post']['location'] = $location;
            $_SESSION['post']['time'] = $time;
            $_SESSION['post']['person'] = $person;
            $_SESSION['post']['cost'] = $cost;
            $_SESSION['post']['entry_field'] = $entry_field;

            header('Location: post_confirm.php');
            exit();
        }
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

    <!-- カレンダー表示用CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.datetimepicker.css">

    <!-- slick css (画像スライド) -->
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick-theme.css">

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
                <h4 class="font-alt mb-0">Post Image</h4>
                <hr class="divider-w mt-10 mb-20">
                <!-- ここに写真を入力 -->
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
                  <button type="submit" name="reset" value="reset" class="btn btn-default btn-round btn-xs">all reset</button>
                </form>
              </div>


              <!-- tag機能 -->
              <form method="POST" action="post.php" class="form" role="form" >
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
                    <?php if(isset($_SESSION['tags'])) {foreach ($_SESSION['tags'] as $key => $tag) { ?>
                      <div class="btn btn-default btn-xs btn-round TagDiv">
                        <button class="close ml-10 TagClose" data-tag="<?php echo $_SESSION['tags'][$key]; ?>">&times;</button>
                        <label class="button-tag"><?php echo $tag; ?></label>
                        <input type="hidden" name="tags[]" value="<?php echo $_SESSION['tags'][$key]; ?>">
                      </div>
                    <?php }} ?>
                  </div>
                </div>


                <div class="col-sm-8 col-sm-offset-2 mt-40">
                  <h4 class="font-alt mb-0">post plan / request</h4>
                  <hr class="divider-w mt-10 mb-20">

                  <div class="form-group">
                    <label class="control-label">Select plan or request</label>
                    <select name="input_request_type" class="form-control input-lg">
                      <option>plan</option>
                      <option>request</option>
                    </select>
                  </div>

                  <!-- title -->
                  <div class="form-group">
                    <label class="control-label">Title</label>
                    <?php if(isset($errors['title']) && $errors['title'] == 'blank'){ ?>
                    <div style="color: red;">Please enter title.</div>
                    <?php } ?>
                    <input name="input_title" value="<?php echo $title;?>" class="form-control input-lg" type="text" placeholder="Title"/>
                  </div>

                  <!-- content -->
                  <div class="form-group">
                    <label class="control-label">Content</label>
                    <?php if(isset($errors['content']) && $errors['content'] == 'blank'){ ?>
                    <div style="color: red;">Please enter content.</div>
                    <?php } ?>
                    <textarea name="input_content" class="form-control" rows="5" placeholder="Content"><?php echo $content;?></textarea>
                  </div>

                  <!-- destination -->
                  <div class="form-group">
                    <label class="control-label">Destination</label>
                    <?php if(isset($errors['place']) && $errors['place'] == 'blank'){ ?>
                    <div style="color: red;">Please enter destination.</div>
                    <?php } ?>
                    <input name="input_place" value="<?php echo $place;?>" class="form-control input-lg" type="text" placeholder="Destination"/>
                  </div>

                  <!-- Start & End -->
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-6">
                        <label class="control-label">Start time</label>
                        <?php if(isset($errors['start_datetime']) && $errors['start_datetime'] == 'blank'){ ?>
                        <div style="color: red;">Please enter start datetime.</div>
                        <?php } ?>
                        <input type="text" name="input_start_datetime" value="<?php echo $start_datetime;?>" class="form-control input-lg datetimepicker" placeholder="0000/00/00 --:--">
                      </div>
                      <div class="col-xs-6">
                        <label class="control-label">End time</label>
                        <?php if(isset($errors['end_datetime']) && $errors['end_datetime'] == 'blank'){ ?>
                        <div style="color: red;">Please enter end datetime.</div>
                        <?php } ?>
                        <input type="text" name="input_end_datetime" value="<?php echo $end_datetime;?>" class="form-control input-lg datetimepicker" placeholder="0000/00/00 --:--">
                      </div>
                    </div>
                  </div>

                  <!-- rendezvous -->
                  <div class="form-group">
                    <label class="control-label">Rendezvous place</label>
                    <?php if(isset($errors['location']) && $errors['location'] == 'blank'){ ?>
                    <div style="color: red;">Please enter rendezvous place.</div>
                    <?php } ?>
                    <input name="input_location" value="<?php echo $location;?>" class="form-control input-lg" type="text" placeholder="Rendezvous"/>
                  </div>

                  <!-- time -->
                  <div class="form-group">
                    <label class="control-label">Rendezvous time</label>
                    <?php if(isset($errors['time']) && $errors['time'] == 'blank'){ ?>
                    <div style="color: red;">Please enter rendezvous time.</div>
                    <?php } ?>
                    <input type="text" name="input_time" value="<?php echo $time;?>" class="form-control input-lg datetimepicker" placeholder="0000/00/00 --:--">
                  </div>

                  <!-- person -->
                  <div class="form-group">
                    <label class="control-label">The number of people</label>
                    <?php if(isset($errors['person']) && $errors['person'] == 'blank'){ ?>
                    <div style="color: red;">Please enter the number of people.</div>
                    <?php } ?>
                    <input name="input_person" value="<?php echo $person;?>" class="form-control input-lg" type="number" placeholder="The number of people"/>
                  </div>

                  <!-- cost -->
                  <div class="form-group">
                    <label class="control-label">Cost (php)</label>
                    <?php if(isset($errors['cost']) && $errors['cost'] == 'blank'){ ?>
                    <div style="color: red;">Please enter cost.</div>
                    <?php } ?>
                    <input name="input_cost" value="<?php echo $cost;?>" class="form-control input-lg" type="number" placeholder="Cost"/>
                  </div>

                  <!-- Entry field -->
                  <div class="form-group">
                    <label class="control-label">Entry field</label>
                    <textarea name="input_entry_field" class="form-control" rows="5" placeholder="Entry field"><?php echo $entry_field;?></textarea>
                  </div>

                  <div class="form-group" style="text-align: right;">
                    <button type="submit" class="btn btn-info btn-md">Confirm</button>
                    <button type="button" onclick="javascript:window.history.back(-1);return false;" class="btn btn-default btn-md">Cancel</button>
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