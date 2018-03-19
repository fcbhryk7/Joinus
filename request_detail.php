<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    if(!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
        header('Location: index.php');
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
    <!--  
    Document Title
    =============================================
    -->
    <title>Titan | Multipurpose HTML5 Template</title>

    <!-- favicons -->
    <?php include('favicons_link.php'); ?>
    <!-- stylesheet -->
    <?php include('stylesheet_link.php'); ?>

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
                  <!-- <?php if (empty($images)) { ?>
                  <div><img src="images/no_image_available.png"></div>
                  <?php } else { foreach ($images as $image) { ?>
                  <div><img src="images/<?php echo $image['image_name'] ?>" width="100%"></div>
                  <?php }} ?> -->
                </div>
                <!-- 説明文 -->
                <div class="row mb-20">
                  <div class="col-sm-12">
                    <div class="description">
                      <p><?php echo $plans['content']; ?></p>
                    </div>
                  </div>
                </div>
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
          </div>
        </section>

        <!-- footer -->
        <?php include('footer.php'); ?>

      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <!-- JavaScripts -->
    <?php include('javascript_link.php'); ?>
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