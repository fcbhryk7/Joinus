<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);

    // $_POSTが未定義の場合は、signin.phpへ強制遷移
    if(empty($_POST)){
      header('Location: signin.php');
      exit();
    }

    $return_str;

    //Ajaxによるリクエストかどうかの識別を行う
    //strtolower()を付けるのは、XMLHttpRequestやxmlHttpRequestで返ってくる場合があるため
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        if (!empty($_POST)){
            // SQL(お気に入り登録)
            if ($_POST['btn'] == 'favorite') {
                $sql = 'INSERT INTO favorites SET user_id=?, plan_id=?, created=NOW()';
                $data = array($_SESSION['user']['id'], $_POST['plan_id']);
                $stmt = $dbh->prepare($sql);
                $stmt-> execute($data);

            }
            // SQL(お気に入り削除)
            elseif($_POST['btn'] == 'unfavorite'){
                $sql = 'DELETE FROM favorites where user_id=? AND plan_id=?';
                $data = array($_SESSION['user']['id'], $_POST['plan_id']);
                $stmt = $dbh->prepare($sql);
                $stmt-> execute($data);
            }

            // お気に入り数をカウント
            $sql = 'SELECT count(*) as cnt FROM favorites where plan_id=?';
                $data = array($_POST['plan_id']);
            $stmt = $dbh->prepare($sql);
            $stmt-> execute($data);

            $favorite = $stmt->fetch(PDO::FETCH_ASSOC);

            // plans tableのfavorite_countカラムへ更新
            $sql = 'UPDATE plans SET favorite_count=?, updated=NOW() where plan_id=?';
            $data = array($favorite['cnt'], $_POST['plan_id']);
            $stmt = $dbh->prepare($sql);
            $stmt-> execute($data);

            $dbh=null;

            if ($_POST['btn'] == 'favorite') {
                $return_str = '<input type="hidden" name="btn" value="unfavorite"><button class="btn btn-default btn-md form-control"><i class="fa fa-star star"></i>unfavorite(<span id="Favorite_Count">' . $favorite['cnt'] . '</span>)</button>';
            }
            elseif($_POST['btn'] == 'unfavorite'){
                $return_str = '<input type="hidden" name="btn" value="favorite"><button class="btn btn-primary btn-md form-control"><i class="fa fa-star solid"></i>favorite!(<span id="Favorite_Count">' . $favorite['cnt'] . '</span>)</button>';
            }
        }

        echo $return_str;
    }else{
      echo 'This access is not valid.';
    }

    // ページ遷移
    // header('Location: plan_detail.php?id=' . $_POST['plan_id']);
    // exit();


?>