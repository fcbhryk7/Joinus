<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    // 配列表示
    // echo_var_dump('$_POST',$_POST);

    // debug
    // $_SESSION['user']['id']=1;

    // $_POSTが未定義の場合は、plan_detail.phpへ強制遷移
    if(empty($_POST)){
      header('Location: plan_detail.php?id=' . $_POST['plan_id']);
      exit();
    }

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

    // ページ遷移
    header('Location: plan_detail.php?id=' . $_POST['plan_id']);
    exit();


?>