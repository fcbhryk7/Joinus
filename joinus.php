<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    echo_var_dump('$_POST',$_POST);

    // 遷移前URLの取得
    $url = get_page_name();

    // $_POSTが未定義の場合は、plan_detail.phpへ強制遷移
    if(empty($_POST)){
      header('Location: signin.php');
      exit();
    }

    // SQL(JOINUS登録)
    if ($_POST['btn'] == 'joinus') {
        $sql = 'INSERT INTO matches SET user_id=?, plan_id=?, created=NOW()';
        $data = array($_SESSION['user']['id'], $_POST['plan_id']);
        $stmt = $dbh->prepare($sql);
        $stmt-> execute($data);

        // フラッシュメッセージ
        flash('success', 'Welcome joinus!!');
    }
    // SQL(JOINUS削除)
    elseif($_POST['btn'] == 'notjoinus'){
        $sql = 'DELETE FROM matches where user_id=? AND plan_id=?';
        $data = array($_SESSION['user']['id'], $_POST['plan_id']);
        $stmt = $dbh->prepare($sql);
        $stmt-> execute($data);

        // フラッシュメッセージ
        flash('info', 'Cancel joinus...');
    }

    // JOIN数をカウント
    $sql = 'SELECT count(*) as cnt FROM matches where plan_id=?';
        $data = array($_POST['plan_id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $joinus_count = $stmt->fetch(PDO::FETCH_ASSOC);


    // plans tableのfavorite_countカラムへ更新
    $sql = 'UPDATE plans SET match_count=?, updated=NOW() where plan_id=?';
    $data = array($joinus_count['cnt'], $_POST['plan_id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    $dbh=null;

    // ページ遷移
    header('Location: ' . $url);
    exit();


?>