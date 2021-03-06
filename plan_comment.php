<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    // 配列表示
    // echo_var_dump('$_POST',$_POST);

    // $_POSTが未定義の場合は、signin.phpへ強制遷移
    if (empty($_POST)) {
        header('Location: signin.php');
        exit();
    }

    //Ajaxによるリクエストかどうかの識別を行う
    //strtolower()を付けるのは、XMLHttpRequestやxmlHttpRequestで返ってくる場合があるため
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        if (!empty($_POST)){
            // 'name'取得
            $name = htmlspecialchars($_POST['name']);
            // 'plan_id'取得
            $plan_id = htmlspecialchars($_POST['plan_id']);
            // 'user_comment'取得
            $comment = htmlspecialchars($_POST['user_comment']);

            if ($name != '' && $plan_id != '' && $comment != '') {
                //トランザクション開始
                $dbh->beginTransaction();

                try{
                    // insert文
                    $sql = 'INSERT INTO comments SET user_id = ?, plan_id = ?, comment = ?, created = NOW()';
                    $data = array($_SESSION['user']['id'], $plan_id, $comment);
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute($data);
                    $dbh->commit();

                    // 完了後、データを戻り値として返す処理
                    $sql = 'SELECT c.*, u.* FROM comments AS c, users AS u WHERE c.user_id = u.user_id AND c.plan_id = ? ORDER BY c.created DESC LIMIT 1';
                    $data = array($plan_id);
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute($data);

                    $add_comment = $stmt->fetch(PDO::FETCH_ASSOC);

                    // フラッシュメッセージ
                    // flash('success', 'You completed to add a comment!!');

                    // 最新コメントの追加
                    echo '<div class="comment clearfix"><div class="comment-avatar"><img src="user_profile_img/'. $add_comment['image'] .'" alt="avatar"/></div><div class="comment-content clearfix"><div class="comment-author font-alt"><a href="profile.php?id=' . $add_comment['user_id'] . '">' . $add_comment['name'] . '</a></div><div class="comment-body"><p>' . $add_comment['comment'] . '</p></div><div class="comment-meta font-alt">' . $add_comment['created'] . '</div></div></div>';

                }
                // 例外処理
                catch (exception $e) {
                    // フラッシュメッセージ
                    // flash('alert', 'You failed to add a comment...');

                   echo "登録に失敗しました。" . $e->getMessage();
                  //ロールバック
                  $dbh->rollback();
                }
            }
        }
    }else{
      echo 'This access is not valid.';
    }

?>