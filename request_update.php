<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);

    // POSTが空の場合は signin.php へ強制遷移
    if (empty($_POST)) {
        header('Location: signin.php');
        exit();
    }

    // 変数格納
    $plan_id = htmlspecialchars($_POST['input_plan_id']);
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
    $history = htmlspecialchars($_POST['input_history']);

    // 変更履歴がない場合は、強制遷移
    if ($history == '') {
        header('Location: request_edit.php?id=' . $plan_id . '&action=rewrite');
        exit();
    }

    // タグをセッションに追加する
    $tags = array(); // 初期化
    if(!empty($_POST['tags'])){
        foreach ($_POST['tags'] as $key => $value) {
            $tags[] = h($value);
        }
    }

    // plansテーブルを更新
    $sql = 'UPDATE plans SET title = ?, content = ?, place = ?, start_datetime = ?, end_datetime = ?,location = ?, time = ?, person = ?, cost = ?, entry_field = ? , updated = NOW() WHERE plan_id = ?';
    $data = array($title, $content, $place, $start_datetime, $end_datetime, $location, $time, $person, $cost, $entry_field, $plan_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // historiesテーブルに登録
    $sql = 'INSERT INTO histories SET user_id = ?, plan_id = ?, comment = ?, created = NOW()';
    $data = array($_SESSION['user']['id'], $plan_id, $history);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // imagesテーブルの登録
    if(isset($_SESSION['images'])) {
        // 一旦imagesテーブルからレコードを削除する。
        $sql = 'DELETE FROM images WHERE plan_id = ?';
        $data = array($plan_id);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // 登録した画像が存在する場合は全て登録する
        foreach ($_SESSION['images'] as $key => $value) {
          // 画像表示順
          $image_order = $key + 1;

          $sql = 'INSERT INTO images SET plan_id = ?, image_name = ?, image_order = ?';
          $data = array($plan_id, $_SESSION['images'][$key], $image_order);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
        }

        // セッション削除
        unset($_SESSION['images']);
    } else {
        // 登録画像がない場合は、no imageを登録する
        $sql = 'INSERT INTO images SET plan_id = ?, image_name = "no_image_available.png", image_order = 1';
        $data = array($plan_id);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // セッション削除
        unset($_SESSION['images']);
    }

    // tagsテーブルに登録
    $tag_id = 0; //初期化
    if(!empty($tags)) {
        // 一旦plans_tagsテーブルからレコードを削除する。
        $sql = 'DELETE FROM plans_tags WHERE plan_id = ?';
        $data = array($plan_id);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        foreach ($tags as $key => $value) {
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

    // フラッシュメッセージ
    flash('success', 'You completed update!!');
    header('Location: request_detail.php?id=' . $plan_id);
    exit();


?>