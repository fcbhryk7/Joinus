<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    if(!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
        header('Location: index.php');
        exit();
    }

    // echo_var_dump('$_SESSION', $_SESSION);

    // セッションがない場合は部分的に表示
    $display_flg = 0;
    if (isset($_SESSION['user']['id'])) {
        $display_flg = 1;
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
    $sql = 'SELECT * FROM plans WHERE request_type = 1 AND plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $plans = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$plans', $plans);

    // ユーザー情報
    $sql = 'SELECT u.* FROM plans AS p, users AS u WHERE p.request_type = 1 AND p.user_id = u.user_id AND p.plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo_var_dump('$users', $users);

    // コメント情報
    $sql = 'SELECT c.*, u.* FROM comments AS c, users AS u WHERE c.user_id = u.user_id AND c.plan_id = ? ORDER BY c.created';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $comments = $stmt->fetchAll();

    // コメント数取得
    $comment_count = count($comments);

    // echo_var_dump('$commmts', $comments);

    // 履歴情報
    $sql = 'SELECT h.*, u.* FROM histories AS h, users AS u WHERE h.user_id = u.user_id AND h.plan_id = ? ORDER BY h.created';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $histories = $stmt->fetchAll();

    // 履歴数取得
    $history_count = count($histories);

    // echo_var_dump('$commmts', $comments);

    //JOINUS
    $sql = 'SELECT u.* FROM matches AS m, users AS u WHERE m.user_id = u.user_id AND plan_id = ? ORDER BY m.created DESC';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $joinuses = $stmt->fetchAll();

    if($display_flg == 1) {
        //JOINUSしているか確認
        $sql = 'SELECT count(*) AS cnt FROM matches WHERE user_id = ? AND plan_id = ?';
        $data = array($_SESSION['user']['id'], $_REQUEST['id']);
        $stmt = $dbh->prepare($sql);
        $stmt-> execute($data);

        $joinus_count = $stmt->fetch(PDO::FETCH_ASSOC);

        // READユーザー情報
        $sql = 'SELECT * FROM users WHERE user_id = ?';
        $data = array($_SESSION['user']['id']);
        $stmt = $dbh->prepare($sql);
        $stmt-> execute($data);

        $read_user = $stmt->fetch(PDO::FETCH_ASSOC);


        // お気に入り
        $sql = 'SELECT COUNT(*) AS cnt FROM favorites WHERE user_id = ? AND plan_id = ?';
        $data = array($_SESSION['user']['id'], $_REQUEST['id']);
        $stmt = $dbh->prepare($sql);
        $stmt-> execute($data);

        $favorite = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <?php if ($plans == false){ ?>
        <section class="module">
          <h1 style="margin-bottom: 50px;">This content is not available.</h1>
          <<<a href="javascript:history.back()">BACK</a>
        </section>
        <?php } else { ?>
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
                  <a href="profile.php?id=<?php echo $users['user_id']; ?>">
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
                  </a>
                </div>

                <!-- お気に入りの機能 -->
                <?php if ($display_flg == 1) { ?>
                <div class="row">
                  <form method="POST" action="favorites.php" id="favorite_form">
                    <input type="hidden" name="plan_id" value="<?php echo $_REQUEST['id'];?>">
                    <div class="col-sm-12 form-group favorite_button" style="text-align: center;">
                      <?php if($favorite['cnt'] == 0) { ?>
                      <input type="hidden" name="btn" value="favorite">
                      <button class="btn btn-primary btn-md form-control"><i class="fa fa-star solid"></i>favorite!(<span id="Favorite_Count"><?php echo $plans['favorite_count']; ?></span>)</button>
                      <?php } else { ?>
                      <input type="hidden" name="btn" value="unfavorite">
                      <button class="btn btn-default btn-md form-control"><i class="fa fa-star star"></i>unfavorite(<span id="Favorite_Count"><?php echo $plans['favorite_count']; ?></span>)</button>
                      <?php } ?>
                    </div>
                  </form>
                </div>

                <!-- JOINUS機能 -->
                <div class="row">
                  <form method="POST" action="joinus.php">
                    <input type="hidden" name="plan_id" value="<?php echo $_REQUEST['id'];?>">
                    <div class="col-sm-12 form-group" style="text-align: center;">
                      <?php if($joinus_count['cnt'] == 0) { ?>
                      <input type="hidden" name="btn" value="joinus">
                      <button class="btn btn-primary btn-md form-control" <?php if($plans['match_count'] >= $plans['person']){echo 'disabled="disabled"';} ?>>joinus!</button>
                      <?php } else { ?>
                      <input type="hidden" name="btn" value="notjoinus">
                      <button class="btn btn-default btn-md form-control">cancel...</button>
                      <?php } ?>
                    </div>
                  </form>
                </div>

                <!-- 更新ボタン -->
                <div class="row">
                  <div class="col-sm-12 form-group" style="text-align: center;">
                    <!-- <button class="btn btn-primary btn-md form-control">Edit</button> -->
                    <a href="plan_edit.php?id=<?php echo $_REQUEST['id']; ?>" class="btn btn-primary btn-md form-control">edit</a>
                  </div>
                </div>
                <?php } ?>

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
                  <li>
                    <a href="#joinus" data-toggle="tab"><span class="icon-tools-2"></span>joinus (<?php echo $plans['match_count']; ?>)</a>
                  </li>
                  <li>
                    <a href="#history" data-toggle="tab"><span class="icon-tools-2"></span>history (<span><?php echo $history_count; ?></span>)</a>
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
                        <tr>
                          <td>Cost</td>
                          <td><?php echo $plans['cost']; ?>php</td>
                        </tr>
                        <tr>
                          <td>Entry field</td>
                          <td><?php echo $plans['entry_field']; ?></td>
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
                          <div class="comment-author font-alt"><a href="profile.php?id=<?php echo $comment['user_id']; ?>"><?php echo $comment['name']; ?></a></div>
                          <div class="comment-body">
                            <p><?php echo $comment['comment']; ?></p>
                          </div>
                          <div class="comment-meta font-alt"><?php echo $comment['created']; ?></div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <?php if ($display_flg == 1) { ?>
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
                    <?php } ?>
                  </div>
                  <div class="tab-pane" id="joinus">
                    <div class="comments reviews">
                      <?php foreach ($joinuses as $joinus) { ?>
                      <div class="comment clearfix">
                        <div class="comment-avatar"><img src="user_profile_img/<?php echo $joinus['image']; ?>" alt="avatar"/></div>
                        <div class="comment-content clearfix">
                          <div class="comment-author font-alt"><a href="profile.php?id=<?php echo $joinus['user_id']; ?>"><?php echo $joinus['name']; ?></a></div>
                          <div class="comment-body">
                            <p><?php echo $joinus['profile']; ?></p>
                          </div>
                          <div class="comment-meta font-alt"><?php echo $joinus['created']; ?></div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="tab-pane" id="history">
                    <div class="comments reviews">
                      <?php foreach ($histories as $history) { ?>
                      <div class="comment clearfix">
                        <div class="comment-avatar"><img src="user_profile_img/<?php echo $history['image']; ?>" alt="avatar"/></div>
                        <div class="comment-content clearfix">
                          <div class="comment-author font-alt"><a href="profile.php?id=<?php echo $history['user_id']; ?>"><?php echo $history['name']; ?></a></div>
                          <div class="comment-body">
                            <p><?php echo $history['comment']; ?></p>
                          </div>
                          <div class="comment-meta font-alt"><?php echo $history['created']; ?></div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>

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

        $('#favorite_form').submit(function(event){
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
                    $('.favorite_button input').remove();
                    $('.favorite_button button').remove();
                    $('.favorite_button').append(result);
                    // console.log(result);
                    // console.log(textStatus);
                    // console.log(xhr);
                },
                error: function(xhr, textStatus, error){
                    // alert('NG...')
                }
            })
        });

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