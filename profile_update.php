<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    // 配列表示
    // echo_var_dump('$_POST',$_POST);
    // echo_var_dump('$_FILES',$_FILES);

    // POSTが空の場合は index.php へ強制遷移
    if (empty($_POST)) {
        header('Location: index.php');
        exit();
    }

    // 変数格納
    $name = htmlspecialchars($_POST['input_name']);
    $gender = htmlspecialchars($_POST['input_gender']);
    $country_name = htmlspecialchars($_POST['input_country']);
    $address = htmlspecialchars($_POST['input_address']);
    $callnumber = htmlspecialchars($_POST['input_callnumber']);
    $time_number = htmlspecialchars($_POST['input_time_number']);
    $time_unit = htmlspecialchars($_POST['input_time_unit']);
    $birthday = htmlspecialchars($_POST['input_birthday']);
    $profile = htmlspecialchars($_POST['input_profile']);

    // 国名ならidを取得する。
    $sql = 'SELECT * FROM countries WHERE name = ?';
    $data = array($country_name);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $country = $stmt->fetch(PDO::FETCH_ASSOC);

    // staying_timeを結合
    $staying_time = $time_number . ' ' . $time_unit;

    // usersテーブルを更新
    $sql = 'UPDATE users SET name = ?, gender = ?, country_id = ?, address = ?, callnumber = ?, staying_time = ?, profile = ?, birthday = ?, updated = NOW() WHERE user_id = ? ';
    $data = array($name, $gender, $country['country_id'], $address, $callnumber, $staying_time, $profile, $birthday, $_SESSION['user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location: profile.php?id=' . $_SESSION['user']['id']);
    exit();

?>