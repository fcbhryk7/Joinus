<?php
    // ユーザーのセッションが存在している確認する
    // もしセッションが切れている場合は signin.phpへ強制遷移
    // $_SESSION['user']['id']=1;
    if (!isset($_SESSION['user'])) {
        header('Location: signin.php');
        exit();
    }
?>