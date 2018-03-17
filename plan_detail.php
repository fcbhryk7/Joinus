<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    // debug
    $_SESSION['user']['id']=2;

    if(!isset($_REQUEST['id'])) {
        echo '$_REQUESTが未定義です';
        exit();
    }

    // タグ情報取得
    $sql = 'SELECT t.* FROM plans_tags AS pt, tags AS t WHERE pt.tag_id = t.tag_id AND pt.plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $tags =  $stmt->fetchAll();

    // echo_var_dump('$tags', $tags);

    // イメージ情報
    $sql = 'SELECT * FROM images WHERE plan_id = ? ORDER BY image_order';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $images = $stmt->fetchAll();

    // echo_var_dump('$images', $images);
    // プラン詳細情報
    $sql = 'SELECT * FROM plans WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $plans = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$plans', $plans);

    // ユーザー情報
    $sql = 'SELECT u.* FROM plans AS p, users AS u WHERE p.user_id = u.user_id AND p.plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$users', $users);

    // READユーザー情報
    $sql = 'SELECT * FROM users WHERE user_id = ?';
    $data = array($_SESSION['user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $read_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$read_user', $read_user);

    // コメント情報
    $sql = 'SELECT c.*, u.* FROM comments AS c, users AS u WHERE c.user_id = u.user_id AND c.plan_id = ? ORDER BY c.created';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $comments = $stmt->fetchAll();

    // コメント数取得
    $comment_count = count($comments);

    // echo_var_dump('$commmts', $comments);

    // お気に入り
    $sql = 'SELECT COUNT(*) AS cnt FROM favorites WHERE user_id = ? AND plan_id = ?';
    $data = array($_SESSION['user']['id'], $_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $favorite = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$favorite', $favorite);

?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Titan | Multipurpose HTML5 Template</title>

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

    <!-- slick css (画像スライド) -->
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/lib/slick/slick-theme.css">
    <!-- Main stylesheet and color file-->
    <link href="assets/css/style.css?<?php echo date('Ymd-Hi');?>" rel="stylesheet">
    <link id="color-scheme" href="assets/css/colors/default.css" rel="stylesheet">
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
              <!-- タイトル -->
              <div class="col-sm-12">
                <h1 class="product-title font-alt"><?php echo $plans['title']; ?></h1>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8 mb-sm-40">
                <div class="row mb-20">
                  <div class="col-sm-12">
                    <!-- タグ出力 -->
                    <div class="product_meta">Tags:
                      <?php foreach ($tags as $tag) { ?>
                      <a href="#" class="badge badge-info"><?php echo $tag['name'];?></a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="your-class">
                  <!-- ここに写真を入力 -->
                  <?php if (empty($images)) { ?>
                  <div><img src="images/no_image_available.png"></div>
                  <?php } else { foreach ($images as $image) { ?>
                  <div><img src="images/<?php echo $image['image_name'] ?>" width="100%"></div>
                  <?php }} ?>
                </div>
                <!-- 説明文 -->
                <div class="row mb-20">
                  <div class="col-sm-12">
                    <div class="description">
                      <p><?php echo $plans['content']; ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- プロフィール -->
              <div class="col-sm-4">
                <div class="row well well-display">
                  <!-- <div class="mb-20"> -->
                    <div class="col-sm-12">
                      <img src="user_profile_img/<?php echo $users['image']; ?>" width="150" class="img-circle img-thumbnail">
                    </div>
                  <!-- </div> -->
                  <!-- <div class="mb-20"> -->
                    <div class="col-sm-12 mt-20">
                      <label class="mb-20"><?php echo $users['name']; ?></label>
                      <div class="description">
                        <p><?php echo $users['profile']; ?></p>
                      </div>
                    </div>
                  <!-- </div> -->
                </div>

                <!-- お気に入りの機能 -->
                <div class="row mb-20">
                  <form method="POST" action="favorites.php">
                    <input type="hidden" name="plan_id" value="<?php echo $_REQUEST['id'];?>">
                    <div class="col-sm-12" style="text-align: center;">
                      <?php if($favorite['cnt'] == 0) { ?>
                      <input type="hidden" name="btn" value="favorite">
                      <button class="btn btn-default btn-md"><i class="fa fa-star solid"></i>Favorite!(<?php echo $plans['favorite_count']; ?>)</button>
                      <?php } else { ?>
                      <input type="hidden" name="btn" value="unfavorite">
                      <button class="btn btn-primary btn-md"><i class="fa fa-star star"></i>Cancel Favorite!(<?php echo $plans['favorite_count']; ?>)</button>
                      <?php } ?>
                    </div>
                  </form>
                </div>
              </div>
            </div> <!-- row -->
            <div class="row mt-70">
              <div class="col-sm-12">
                <ul class="nav nav-tabs font-alt" role="tablist">
                  <li class="active">
                    <a href="#data-sheet" data-toggle="tab"><span class="icon-tools-2"></span>Data sheet</a>
                  </li>
                  <li>
                    <a href="#reviews" data-toggle="tab"><span class="icon-tools-2"></span>Comments (<span id="CommentCount"><?php echo $comment_count; ?></span>)</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="data-sheet">
                    <table class="table table-striped ds-table table-responsive">
                      <tbody>
                        <tr>
                          <td>Place</td>
                          <td><?php echo $plans['place']; ?></td>
                        </tr>
                        <tr>
                          <td>Start time</td>
                          <td><?php echo $plans['start_datetime']; ?></td>
                        </tr>
                        <tr>
                          <td>End time</td>
                          <td><?php echo $plans['end_datetime']; ?></td>
                        </tr>
                        <tr>
                          <td>Meeting place</td>
                          <td><?php echo $plans['location']; ?></td>
                        </tr>
                        <tr>
                          <td>Meeting time</td>
                          <td><?php echo $plans['time']; ?></td>
                        </tr>
                        <tr>
                          <td>The number of people</td>
                          <td><?php echo $plans['person']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="reviews">
                    <div class="comments reviews" id="InsertComment">
                      <?php foreach ($comments as $comment) { ?>
                      <div class="comment clearfix">
                        <div class="comment-avatar"><img src="user_profile_img/<?php echo $comment['image']; ?>" alt="avatar"/></div>
                        <div class="comment-content clearfix">
                          <div class="comment-author font-alt"><?php echo $comment['name']; ?></div>
                          <div class="comment-body">
                            <p><?php echo $comment['comment'] ?></p>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                    <div class="comment-form mt-30">
                      <h4 class="comment-form-title font-alt">Add comment</h4>
                      <form method="post" action="plan_comment.php" id="submit" >
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <!-- <label class="sr-only" for="name"><?php echo $read_user['name']; ?></label> -->
                              <input class="form-control" id="name" type="text" name="name" value="<?php echo $read_user['name']; ?>" placeholder="Name" readonly/>
                              <input type="hidden" name="plan_id" value="<?php echo $_REQUEST['id']; ?>">
                            </div>
                          </div>
                          <!-- <div class="col-sm-4">
                            <div class="form-group">
                              <label class="sr-only" for="email">Name</label>
                              <input class="form-control" id="email" type="text" name="email" placeholder="E-mail"/>
                            </div>
                          </div> -->
                          <!-- <div class="col-sm-4">
                            <div class="form-group">
                              <select class="form-control">
                                <option selected="true" disabled="">Rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select>
                            </div>
                          </div> -->
                          <div class="col-sm-12">
                            <div class="form-group">
                              <textarea class="form-control" id="" name="user_comment" rows="4" placeholder="Comment"></textarea>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <button class="btn btn-round btn-d" type="submit">Submit Comment</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <hr class="divider-w">

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
    <!-- <script src="assets/lib/smoothscroll.js"></script> -->
    <script src="assets/lib/magnific-popup/dist/jquery.magnific-popup.js"></script>
    <script src="assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- slick Java Script -->
    <script src="assets/lib/slick/slick.js"></script>
    <script>
      $(document).ready(function(){
        $('.your-class').slick({
          // setting-name: setting-value,
          dots: true,
          arrows: false,
        });
      });
    </script>
    <script type="text/javascript">
      // コメント追加機能
      $(function(){
        $('#submit').submit(function(event){
            // HTMLでの送信をキャンセル
            event.preventDefault();

            // 操作対象のフォーム要素を取得
            var $form = $(this);

            // 送信
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $form.serialize(),

                success: function(result, textStatus, xhr){
                    $('#InsertComment').append(result);
                    // console.log(result);
                    // console.log(textStatus);
                    // console.log(xhr);

                    // コメント数をカウントアップ
                    var comment_count = Number($('#CommentCount').text());
                    comment_count++;
                    $('#CommentCount').text(comment_count);
                },
                error: function(xhr, textStatus, error){
                    // alert('NG...')
                }
            })
        });
      });
    </script>
  </body>
</html>