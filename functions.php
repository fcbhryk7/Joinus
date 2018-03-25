<?php

  // 定数
  define('DEBUG', true);

  // var_dump表示関数　デバッグ用
  function echo_var_dump($var_name,$var) {
    if (DEBUG) {
      echo '<pre>';
      echo $var_name . '=';
      echo var_dump($var);
      echo '</pre>';
    }
  }

  // htmlspecialcharsの独自関数
  function h($var) {
      return htmlspecialchars($var);
  }

  // 遷移前のURLを取得する関数
  function get_page_name() {
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return '';
    }

    $url = parse_url($_SERVER['HTTP_REFERER']);
    $path = explode('/', $url['path']);

    // registerフォルダが存在するかの場合わけ
    if($path[3] == 'register') {
        // クエリ(パラメータ)が存在するかの場合わけ
        if(!empty($url['query'])) {
            return $path[4] . '?' . $url['query'];
        }
        else {
            return $path[4];
        }
    } else {
        // クエリ(パラメータ)が存在するかの場合わけ
        if(!empty($url['query'])) {
            return $path[3]  . '?' . $url['query'];
        }
        else {
            return $path[3];
        }
    }
  }

  // 国名取得
  function get_country_name() {
      require('dbconnect.php'); //DB接続

      $sql = 'SELECT * FROM countries';
      $data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

        // すべての行を取得する
      $countries = $stmt->fetchAll();

      // DB切断
      $dbh = null;

      return $countries;
  }

  // assetsディレクトリを指定する関数
  function search_assets($full_path) {
      // 読み込み元のフルパスを取得
      // $full_path=debug_backtrace();
      // 各ディレクトリ名を分割
      $separate_dir = explode('/', $full_path[0]['file']);
      // カレントディレクトリを取得
      $current_dir = $separate_dir[count($separate_dir)-2];

      // ディレクトリの階層別にファイルパスを変更
      if ($current_dir == 'register') {
          $root_dir = '../';
      } else {
          $root_dir = '';
      }
      // echo $root_dir;

      return $root_dir;
  }

?>