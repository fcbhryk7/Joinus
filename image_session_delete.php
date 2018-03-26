<?php

    session_start(); //セッションスタート
    require('functions.php'); //ファンクション

    // 遷移前のURLを取得
    $url = get_page_name();

    // $_REQUEST['id'] が空の場合は signin.php へ強制遷移
    if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '' ) {
        header('Location: signin.php');
        exit();
    }

    // セッションから指定の番号の要素を削除する
    // echo_var_dump('$_SESSION["images"]', $_SESSION['images']);
    $split = array_splice($_SESSION['images'],$_REQUEST['id']-1,1);
    // echo_var_dump('$split', $split);
    // echo_var_dump('$_SESSION["images"]', $_SESSION['images']);

    // フラッシュメッセージ
    flash('success', 'You completed delete image');

    if ($url == 'post.php') {
        header('Location: ' . $url);
        exit();
    }
    else {
        header('Location: ' . $url . '&image=true');
        exit();
    }
?>