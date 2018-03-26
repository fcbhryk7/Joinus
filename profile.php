<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    // require('user_session.php'); //セッション確認

    // フラッシュメッセージのクリア処理
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
    unset($_SESSION['flash']);

    // 配列表示
    // echo_var_dump('$_POST',$_POST);

    // $_REQUEST が空のときは index.php に強制遷移
    if(!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
        header('Location: index.php');
        exit();
    }

    // プロフィール情報取得
    $sql = 'SELECT u.*, c.name AS country_name FROM users AS u, countries AS c WHERE u.country_id = c.country_id AND u.user_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // お気に入りプラン/リクエストの取得
    $sql = 'SELECT u.*, p.*, i.* FROM images AS i, favorites AS f, plans AS p, users AS u WHERE i.plan_id = p.plan_id AND f.plan_id = p.plan_id AND p.user_id = u.user_id AND i.image_order = 1 AND f.user_id = ? ORDER BY p.created DESC';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $favorite_plans = $stmt->fetchAll();

    // echo_var_dump('$favorite_plans', $favorite_plans);

    // 自分のプラン/リクエストの取得
    $sql = 'SELECT u.*, p.*, i.* FROM images AS i, plans AS p, users AS u WHERE i.plan_id = p.plan_id AND p.user_id = u.user_id AND i.image_order = 1 AND u.user_id = ? ORDER BY p.created DESC';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $my_plans = $stmt->fetchAll();

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

    <!-- tab -->
    <link rel="stylesheet" type="text/css" href="assets/css/tab.css">
  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- header -->
      <?php include('header.php'); ?>

      <div class="main">
        <section class="module-small">
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
              <div class="col-xs-offset-1 col-xs-3 mb-40" style="text-align: center;">
                <img class="img-thumbnail" width="150" src="user_profile_img/<?php echo $profile['image']; ?>">
              </div>
              <div class="col-xs-7">
                <div class="well-small">
                  <div class="well-small">
                    <label class="control-label">Name：</label>
                    <?php echo $profile['name']; ?>
                    <!-- user_name -->
                  </div>
                  <div class="well-small">
                    <label class="control-label">Gender：</label>
                    <?php echo $profile['gender']; ?>
                    <!-- gender -->
                  </div>
                  <div class="well-small">
                    <label class="control-label">Country：</label>
                    <?php echo $profile['country_name']; ?>
                    <!-- country_name -->
                  </div>
                  <div class="well-small">
                    <label class="control-label">Staying time：</label>
                    <?php echo $profile['staying_time']; ?>
                    <!-- gender -->
                  </div>
                  <div class="well-small">
                    <label class="control-label">Birthday：</label>
                    <?php echo $profile['birthday']; ?>
                    <!-- gender -->
                  </div>
                  <div class="well-small">
                    <label class="control-label">Entry：</label>
                    <?php echo $profile['created']; ?>
                  </div>
                  <div class="form-group">
                    <!-- <div class="col-xs-3 col-xs-offset-9"> -->
                    <div style="text-align: right;">
                      <!-- <button type="reset" class="btn btn-default">Cancel</button> -->
                      <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $_REQUEST['id'] ) { ?>
                      <a class="btn btn-primary btn-md" href="profile_edit.php?id=<?php echo $_REQUEST['id']; ?>">Edit</a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <hr class="divider-w"> -->
              <div class="col-xs-offset-1 col-xs-10">
                <div class="well-small bs-component mb-40">
                  <form method="POST" action="check.php" class="form-horizontal">
                    <fieldset>
                      <legend>Profile</legend>
                      <!-- <label class="control-label">Name</label> -->
                      <div class="well-small">
                        <?php echo $profile['profile'] ?>
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>

              <div class="col-xs-offset-1 col-xs-10">
                <legend>Favorite</legend>
                <div role="tabpanel">
                  <ul class="nav nav-tabs font-alt" role="tablist">
                    <li class="active"><a href="#favorite_plan" data-toggle="tab"><span class="icon-tools-2"></span>plan</a></li>
                    <li><a href="#favorite_request" data-toggle="tab"><span class="icon-tools-2"></span>request</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="favorite_plan">
                      <div class="row">
                        <?php foreach ($favorite_plans AS $key => $plan) { if($plan['request_type'] == 0){ ?>
                        <a href="plan_detail.php?id=<?php echo $plan['plan_id']; ?>">
                        <!-- <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp"> -->
                          <div class="mb-sm-20 col-sm-6 col-md-3">
                            <div class="team-item">
                              <div class="team-image"><img src="images/<?php echo $plan['image_name']; ?>" alt="image" class="img-thumbnail" />
                                <div class="team-detail">
                                  <h5 class="font-alt"><?php echo $plan['title']; ?></h5>
                                  <!-- <p class="font-serif"></p> -->
                                </div>
                              </div>
                              <div class="team-descr font-alt">
                                <div class="team-name"><?php echo $plan['name']; ?></div>
                                <!-- <div class="team-role">Art Director</div> -->
                              </div>
                            </div>
                          </div>
                        </a>
                        <?php }} ?>
                      </div> <!-- row -->
                    </div>
                    <div class="tab-pane" id="favorite_request">
                      <div class="row">
                        <?php foreach ($favorite_plans AS $key => $request) { if($request['request_type'] == 1){ ?>
                        <a href="request_detail.php?id=<?php echo $request['plan_id']; ?>">
                          <!-- <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp"> -->
                          <div class="mb-sm-20 col-sm-6 col-md-3">
                            <div class="team-item">
                              <div class="team-image"><img src="images/<?php echo $request['image_name']; ?>" alt="image" class="img-thumbnail"/>
                                <div class="team-detail">
                                  <h5 class="font-alt"><?php echo $request['title']; ?></h5>
                                  <!-- <p class="font-serif"></p> -->
                                </div>
                              </div>
                              <div class="team-descr font-alt">
                                <div class="team-name"><?php echo $request['name']; ?></div>
                                <!-- <div class="team-role"></div> -->
                              </div>
                            </div>
                          </div>
                        </a>
                        <?php }} ?>
                      </div> <!-- row -->
                    </div>
                  </div>
                </div> <!-- tabpanel -->
              </div>


              <div class="col-xs-offset-1 col-xs-10">
                <legend>My plan / request</legend>
                <div role="tabpanel">
                  <ul class="nav nav-tabs font-alt" role="tablist">
                    <li class="active"><a href="#my_plan" data-toggle="tab"><span class="icon-tools-2"></span>plan</a></li>
                    <li><a href="#my_request" data-toggle="tab"><span class="icon-tools-2"></span>request</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="my_plan">
                      <div class="row">
                        <?php foreach ($my_plans AS $key => $plan) { if($plan['request_type'] == 0){  ?>
                        <a href="plan_detail.php?id=<?php echo $plan['plan_id']; ?>">
                        <!-- <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp"> -->
                          <div class="mb-sm-20 col-sm-6 col-md-3">
                            <div class="team-item">
                              <div class="team-image"><img src="images/<?php echo $plan['image_name']; ?>" alt="image" class="img-thumbnail" />
                                <div class="team-detail">
                                  <h5 class="font-alt"><?php echo $plan['title']; ?></h5>
                                  <!-- <p class="font-serif"></p> -->
                                </div>
                              </div>
                              <div class="team-descr font-alt">
                                <div class="team-name"><?php echo $plan['name']; ?></div>
                                <!-- <div class="team-role">Art Director</div> -->
                              </div>
                            </div>
                          </div>
                        </a>
                        <?php }} ?>
                      </div> <!-- row -->
                    </div>
                    <div class="tab-pane" id="my_request">
                      <div class="row">
                        <?php foreach ($my_plans AS $key => $request) { if($request['request_type'] == 1){  ?>
                        <a href="request_detail.php?id=<?php echo $request['plan_id']; ?>">
                          <!-- <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp"> -->
                          <div class="mb-sm-20 col-sm-6 col-md-3">
                            <div class="team-item">
                              <div class="team-image"><img src="images/<?php echo $request['image_name']; ?>" alt="image" class="img-thumbnail"/>
                                <div class="team-detail">
                                  <h5 class="font-alt"><?php echo $request['title']; ?></h5>
                                  <!-- <p class="font-serif"></p> -->
                                </div>
                              </div>
                              <div class="team-descr font-alt">
                                <div class="team-name"><?php echo $request['name']; ?></div>
                                <!-- <div class="team-role"></div> -->
                              </div>
                            </div>
                          </div>
                        </a>
                        <?php }} ?>
                      </div> <!-- row -->
                    </div>
                  </div>
                </div> <!-- tabpanel -->
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