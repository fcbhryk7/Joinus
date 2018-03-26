<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    if(!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
        header('Location: index.php');
        exit();
    }

    // plan / request を削除する

    // plansテーブルから削除
    $sql = 'DELETE FROM plans WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    // imagesテーブルから削除
    $sql = 'DELETE FROM images WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    // plans_tagsテーブルから削除
    $sql = 'DELETE FROM plans_tags WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    // favoritesテーブルから削除
    $sql = 'DELETE FROM favorites WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    // commentsテーブルから削除
    $sql = 'DELETE FROM comments WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    // historiesテーブルから削除
    $sql = 'DELETE FROM histories WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    // matchesテーブルから削除
    $sql = 'DELETE FROM matches WHERE plan_id = ?';
    $data = array($_REQUEST['id']);
    $stmt = $dbh->prepare($sql);
    $stmt-> execute($data);

    header('Location: index.php');
    exit();

?>