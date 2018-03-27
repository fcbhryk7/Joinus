<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
    require('user_session.php'); //セッション確認

    echo_var_dump('$_FILES', $_FILES);
    // echo_var_dump('$_POST', $_POST);

    // type=fileの情報を受け取るには$_FILESスーパーグローバル変数が必要
    if (isset($_FILES['input_img_name']['name'])) {
        $file_name = $_FILES['input_img_name']['name'];
    }

    // $file_name = $_FILES['input_img_name']['name'];
    if(!empty($file_name)){
        // '.'で分割
        $file_sep = explode('.', $file_name);
        // file_nameをjpg形式で書き換え
        // $file_name = $file_sep[0];
        // ファイル拡張子を取得
        // $file_type = substr($file_name,-3);
        $file_type = $file_sep[1];
        // 大文字→小文字
        $file_type = strtolower($file_type);
        // jpg / png / gif のチェック
        // if($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif'){
        //       $errors['img_name'] = 'type';
        // }

        // 日付取得
        $date_str = date('YmdHis');
        // 日付+ファイル名
        $submit_file_name = $date_str . $file_name;


        try {
            // ファイルアップロードする関数
            move_uploaded_file($_FILES['input_img_name']['tmp_name'], 'user_profile_img/' . $submit_file_name);

            // トリミングの値設定
            $profileImageX = $_POST['profileImageX'];
            $profileImageY = $_POST['profileImageY'];
            $profileImageW = $_POST['profileImageW'];
            $profileImageH = $_POST['profileImageH'];


            // $file = 'images/20180308081536kumamon.jpeg';
            $file = 'user_profile_img/' . $submit_file_name;

            //元の画像のサイズを取得する
            // list($w, $h) = getimagesize($file);

            //サムネイルのサイズ
            $thumbW = 300;
            $thumbH = 300;

            //サムネイルになる土台の画像を作る
            $thumbnail = imagecreatetruecolor($thumbW, $thumbH);

            //元の画像を読み込む
            if($file_type == 'jpg' || $file_type == 'jpeg'){
                $baseImage = imagecreatefromjpeg($file);
            }
            elseif($file_type == 'png'){
                $baseImage = imagecreatefrompng($file);
            }
            elseif($file_type == 'gif'){
                $baseImage = imagecreatefromgif($file);
            }

            //サムネイルになる土台の画像に合わせて元の画像を縮小しコピーペーストする
            imagecopyresampled($thumbnail, $baseImage, 0, 0, $profileImageX, $profileImageY, $thumbW, $thumbH, $profileImageW, $profileImageH);

            //圧縮率60で保存する
            if($file_type == 'jpg' || $file_type == 'jpeg'){
                imagejpeg($thumbnail, $file, 60);
            }
            elseif($file_type == 'png'){
                imagepng($thumbnail, $file, 6);
            }
            elseif($file_type == 'gif'){
                imagegif($thumbnail, $file);
            }

            // usersテーブルを更新
            $sql = 'UPDATE users SET image = ?, updated = NOW() WHERE user_id = ? ';
            $data = array($submit_file_name, $_SESSION['user']['id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            // フラッシュメッセージ
            flash('success', 'You completed setting image');

        } catch (Exception $e) {

            // フラッシュメッセージ
            flash('danger', $e->getMessage());

        } finally {
            header('Location: profile_edit.php?id=' . $_SESSION['user']['id']);
            exit();
        }
    }


?>