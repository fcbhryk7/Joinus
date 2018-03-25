
<?php
  // // プランリクエスト一覧表示&検索機能
  //   // ①使うテーブルを把握
  //   // ②テーブルのid同士を繋ぐ
  //   // ③タグ部分を繋ぐ
  //   // ④ORDER BY 最新順に並び替え


//if (!empty($_REQUEST)) {

  // session_start();
  // require('dbconnect.php');
  require('functions.php');

  // $sql = 'SELECT p.*
  // FROM `plans` AS `p`, `tags` AS `t`, `plans_tags` AS `pt`
  // WHERE `p`.plan_id = `pt`.plan_id
  // AND `t`.tag_id = `pt`.tag_id
  // AND `t`.name LIKE ?
  // ORDER BY `p`.created DESC';

  // if (!empty($_POST)) {
  //     // XSS攻撃対策
  //     $target = '%' . h($_POST['input_word']) . '%';
  //     // echo $target;
  //     $data = array($target);
  //     // connectこれはおっけー
  //     $stmt = $dbh->prepare($sql);
  //     $stmt -> execute($data);

  //     // $plans:配列を定義する
  //     $plans = array();

  //     // while文でループする
  //     while (true){
  //         // データ1件をフェッチする
  //         $plan = $stmt->fetch(PDO::FETCH_ASSOC);

  //         // もしデータが存在しない場合は、ループ文を抜ける
  //         if($plan == false) {
  //             //とめる
  //             break;
  //         }

  //         // 配列$plansにデータを追加する
  //         $plans[] = $plan;
  //     }
  // }






      //変数へ格納していく
      // $plans[] = $plan;



    //  WHERE句にrequest_type
//     echo '<pre>';
//     echo var_dump($_POST);
//     echo '</pre>';

    // echo '<pre>';
    // echo var_dump($plans);
    // echo '</pre>';
    // die();

 // echo $plan["title"];

 ?>


<!DOCTYPE html>

<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Joinus!</title>
    <?php
      require('favicons_link.php');
      require('stylesheet_link.php');

    ?>
  </head>

  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>

      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- Header -->
      <?php
      include('header.php');
       ?>
      <!-- スライダー -->
      <section class="home-section home-full-height photography-page" id="home">
        <div class="hero-slider">
          <ul class="slides">
            <li class="bg-dark" style="background-image:url(images/main1.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt mb-40 titan-title-size-4" style="color:black">Joinus!</div>
                  <div class="font-alt mb-30 titan-title-size-2" style="color:black">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1" style="color:black">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>
            <li class="bg-dark" style="background-image:url(images/main2.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt mb-40 titan-title-size-4">Joinus!</div>
                  <div class="font-alt mb-30 titan-title-size-2">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>
            <li class="bg-dark" style="background-image:url(images/main3.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt mb-40 titan-title-size-4" style="color:black">Joinus!</div>
                  <div class="font-alt mb-30 titan-title-size-2" style="color:black">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1" style="color:black">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>
            <li class="bg-dark" style="background-image:url(images/main4.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt mb-40 titan-title-size-4">Joinus!</div>
                  <div class="font-alt mb-30 titan-title-size-2">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </section>

      <!-- 検索機能 -->
      <br>
      <br>
      <h2 class="module-title font-alt">Search</h2>
        <div class="row mb-60">
          <div class="col-sm-8 col-sm-offset-2">
            <form role="form">
              <div class="search-box">
                <input class="form-control" type="text" placeholder="Search..."/>
                <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>

        <!-- プランとリクエストタブ -->
        <section class="module pb-0" id="works">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Plan / Request list</h2>
                <div class="module-subtitle font-serif"></div>
              </div>
            </div>
          </div>

          <!-- プラン、リクエスト -->
          <div class="col-sm-8 col-sm-offset-2">
            <h4 class="font-alt mb-0"><!-- タイトル --></h4>
            <hr class="divider-w mt-10 mb-20">
              <div role="tabpanel">
                <ul class="nav nav-tabs font-alt" role="tablist">
                  <li class="active">
                    <a href="#support" data-toggle="tab">
                      <span class="icon-tools-2">
                      </span>Plan
                    </a>
                  </li>
                  <li>
                    <a href="#sales" data-toggle="tab">
                      <span class="icon-tools-2">
                      </span>Request
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="support">
                    <div class="owl-carousel text-center" data-items="5" data-pagination="false" data-navigation="false">

                      <!-- プランたち -->
                      <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product">
                            <a href="plan_detail.php?id=<?php echo $plans[0]["plan_id"]; ?>">
                              <img src="assets/images/shop/product-3.jpg" alt="Derby shoes"/>
                            </a>
                              <h4 class="shop-item-title font-alt">
                                <a href="plan_detail.php?id=<?php echo $plans[0]["plan_id"]; ?>"><?php echo $plans[0]["title"]; ?></a>
                              </h4><?php echo "$" . $plans[0]["cost"]; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- リクエストたち -->
                  <div class="tab-pane" id="sales">
                    <div class="owl-carousel text-center" data-items="5" data-pagination="false" data-navigation="false">
                      <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product">
                            <a href="#">
                              <img src="assets/images/shop/product-1.jpg" alt="Leather belt"/>
                            </a>
                            <h4 class="shop-item-title font-alt">
                              <a href="#">Leather belt
                              </a>
                            </h4>£12.00
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
          </div>

          <div class="container"></div>
        </section>
      </div>

      <!-- Footer -->
      <?php include('footer.php'); ?>

      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <?php
        require('javascript_link.php');
    ?>
  </body>
</html>