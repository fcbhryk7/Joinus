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

    if($path[3] == 'register') {
        return $path[4];
    } else {
        return $path[3];
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

?>