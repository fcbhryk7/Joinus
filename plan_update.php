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

    // plansテーブルを更新
    $sql = 'UPDATE plans SET title = ?, content = ?, place = ?, start_datetime = ?, end_datetime = ?,location = ?, time = ?, person = ?, cost = ?, entry_field = ? , updated = NOW() WHERE plan_id = ? AND user_id = ? ';
    $data = array($title, $content, $place, $start_datetime, $end_datetime, $location, $time, $person, $cost, $entry_field, $plan_id, $_SESSION['user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: plan_detail.php?id=' . $plan_id);
    exit();


?>