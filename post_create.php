<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);

    // SESSIONが空の場合は index.php へ強制遷移
    if (!isset($_SESSION['post'])) {
        header('Location: index.php');
        exit();
    }

    // 変数格納
    $request_type = $_SESSION['post']['request_type'];
    $title = $_SESSION['post']['title'];
    $content = $_SESSION['post']['content'];
    $place = $_SESSION['post']['place'];
    $start_datetime = $_SESSION['post']['start_datetime'];
    $end_datetime = $_SESSION['post']['end_datetime'];
    $location = $_SESSION['post']['location'];
    $time = $_SESSION['post']['time'];
    $person = $_SESSION['post']['person'];
    $cost = $_SESSION['post']['cost'];
    $entry_field = $_SESSION['post']['entry_field'];

    // plansテーブルからidのMAX値を取得
    $sql = 'SELECT MAX(plan_id) AS max_plan_id FROM plans';
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // plan_idの設定
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    $plan_id = $id['max_plan_id'] + 1;

    // request_typeの設定
    if ($request_type == 'plan') {
        $plan_flg = 0;
    } elseif ($request_type == 'request') {
        $plan_flg = 1;
    }

    // plansテーブルを登録
    $sql = 'INSERT INTO plans SET plan_id = ?, user_id = ?, request_type = ?, title = ?, content = ?, place = ?, start_datetime = ?, end_datetime = ?,location = ?, time = ?, person = ?, cost = ?, entry_field = ? , created = NOW()';
    $data = array($plan_id, $_SESSION['user']['id'], $plan_flg, $title, $content, $place, $start_datetime, $end_datetime, $location, $time, $person, $cost, $entry_field);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // imagesテーブルの登録
    if(isset($_SESSION['images'])) {
        // 登録した画像が存在する場合は全て登録する
        foreach ($_SESSION['images'] as $key => $value) {
          // 画像表示順
          $image_order = $key + 1;

          $sql = 'INSERT INTO images SET plan_id = ?, image_name = ?, image_order = ?';
          $data = array($plan_id, $_SESSION['images'][$key], $image_order);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
        }
    } else {
          // 登録画像がない場合は、no imageを登録する
          $sql = 'INSERT INTO images SET plan_id = ?, image_name = "no_image_available.png", image_order = 1';
          $data = array($plan_id);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
    }

    // tagsテーブルに登録
    $tag_id = 0; //初期化
    if(isset($_SESSION['tags'])) {
        foreach ($_SESSION['tags'] as $key => $value) {
            // 同名のタグが存在しないか確認する。
            $sql = 'SELECT * FROM tags WHERE name = ?';
            $data = array($value);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $tag = $stmt->fetch(PDO::FETCH_ASSOC);

            // 存在しない場合
            if($tag == false) {
                // tagsテーブルに登録する。
                $sql = 'INSERT INTO tags SET name = ?';
                $data = array($value);
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);

                // 最後に登録したtag_idを取得する
                $sql = 'SELECT LAST_INSERT_ID() AS tag_id';
                $data = array();
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $tag = $stmt->fetch(PDO::FETCH_ASSOC);

                // 変数に格納する
                $tag_id = $tag['tag_id'];
            // 存在する場合
            } else {
                // 変数に格納する
                $tag_id = $tag['tag_id'];
            }

            // plans_tagsに登録する
            $sql = 'INSERT INTO plans_tags SET plan_id = ?, tag_id = ?';
            $data = array($plan_id, $tag_id);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
        }
    }

    // SESSION削除
    unset($_SESSION['post']);
    unset($_SESSION['images']);
    unset($_SESSION['tags']);

    // フラッシュメッセージ
    flash('success', 'You completed create!!');
    header('Location: ' . $request_type . '_detail.php?id=' . $plan_id);
    exit();

?>