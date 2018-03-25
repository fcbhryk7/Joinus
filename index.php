<?php 
  session_start();
  require('dbconnect.php');
  require('functions.php');

  // メモ
    // ①使うテーブルを把握
    // ②テーブルのid同士を繋ぐ
    // ③タグ部分を繋ぐ
    // ④ORDER BY 最新順に並び替え 

  // 検索機能
  // $sql = 'SELECT p.*, i.* FROM plans AS p, images AS i, plans_tags AS pt, tags AS t WHERE p.plan_id = i.plan_id AND p.plan_id = pt.plan_id AND pt.tag_id = t.tag_id AND i.image_order = 1 AND t.name = ? ORDER BY p.created DESC';
  // $data = array();
  // $stmt = $dbh->prepare($sql);
  // $stmt->execute($data);

  // $plans = $stmt->fetch(PDO::FETCH_ASSOC);


  // プランリクエスト一覧表示
  // $sql = 'SELECT p.*, i.* FROM plans AS p, images AS i, plans_tags AS pt, tags AS t WHERE p.plan_id = i.plan_id AND p.plan_id = pt.plan_id ORDER BY p.created DESC';
  $sql = 'SELECT p.title, i.image_name, u.name FROM plans AS p, images AS i, users AS u WHERE p.plan_id = i.plan_id AND p.user_id = u.user_id AND i.image_order = 1 ORDER BY p.created DESC';
  $data = array();
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $plans = array();
  while (true) {
    $plan = $stmt->fetch(PDO::FETCH_ASSOC);
      if($plan == false){
        break;
      }
      $plans[] = $plan;
    }

  $c = count($plans);

  // echo_var_dump('$plans',$plans);
  // echo $c;  
  // die();

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
      <?php include('header.php'); ?>

      <!-- スライダー -->
      <section class="home-section home-fade home-full-height" id="home">
        <div class="hero-slider">
          <ul class="slides">
            <li class="bg-dark-30 bg-dark shop-page-header" style="background-image:url(images/main1.jpg);">
              <div class="titan-caption">
                <div class="caption-content">
                  <div class="font-alt mb-30 titan-title-size-4" style="color:black">Joinus!</div>
                  <div class="font-alt mb-40 titan-title-size-2" style="color:black">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1" style="color:black">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>

            <li class="bg-dark-30 bg-dark shop-page-header" style="background-image:url(images/main2.jpg);">
              <div class="titan-caption">
                <div class="caption-content">
                  <div class="font-alt mb-30 titan-title-size-4">Joinus!</div>
                  <div class="font-alt mb-40 titan-title-size-2">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>

            <li class="bg-dark-30 bg-dark shop-page-header" style="background-image:url(images/main3.jpg);">
              <div class="titan-caption">
                <div class="caption-content">
                  <div class="font-alt mb-30 titan-title-size-4" style="color:black">Joinus!</div>
                  <div class="font-alt mb-40 titan-title-size-2" style="color:black">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1" style="color:black">Experience and event in Cebu<br>Sharing economy service</div>
                </div>
              </div>
            </li>

            <li class="bg-dark-30 bg-dark shop-page-header" style="background-image:url(images/main4.jpg);">
              <div class="titan-caption">
                <div class="caption-content">
                  <div class="font-alt mb-30 titan-title-size-4">Joinus!</div>
                  <div class="font-alt mb-40 titan-title-size-2">Let's see. How to spend free travel.</div>
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

        <!-- プランとリクエスト一覧 -->
        <section class="module pb-0" id="works">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Plan / Request list</h2>
                <div class="module-subtitle font-serif"></div>
              </div>
            </div>
          </div>

          <div class="col-sm-8 col-sm-offset-2">
            <h4 class="font-alt mb-0"><!-- タイトル --></h4>
            <hr class="divider-w mt-10 mb-20">
              <div role="tabpanel">
                <ul class="nav nav-tabs font-alt" role="tablist">
                  <li class="active"><a href="#support" data-toggle="tab"><span class="icon-tools-2"></span>Plan</a></li>
                  <li><a href="#sales" data-toggle="tab"><span class="icon-tools-2"></span>Request</a></li>
                  </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="support">

                    <!-- <div class="text-center" data-items="4" data-pagination="false" data-navigation="false"> -->
                      <div class="row">
                            <?php for($i=0;$i<$c;$i++){ ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">

                      <!-- プラン一覧 -->
                          <!-- <div> -->
                              <img src="images/<?php echo $plans[$i]['image_name']; ?>">
                              <div class="panel panel-default"">
                                <div class="panel-heading">
                                  <?php echo $plans[$i]['title']; ?>
                                </div>
                                <div class="panel-body">
                                  <?php echo $plans[$i]['name']; ?>
                                </div>
                              </div>
                          <!-- </div> -->
                          
                        </div>
                            <?php } ?>
                      </div>
                    <!-- </div> -->

                  <div class="tab-pane" id="sales">
                    <div class="owl-carousel text-center" data-items="5" data-pagination="false" data-navigation="false">
                      <!-- <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product"><a href="#"><img src="assets/images/shop/product-1.jpg" alt="Leather belt"/></a>
                            <h4 class="shop-item-title font-alt"><a href="#">Leather belt</a></h4>£12.00
                          </div>
                        </div>
                      </div>

                      <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product"><a href="#"><img src="assets/images/shop/product-3.jpg" alt="Derby shoes"/></a>
                            <h4 class="shop-item-title font-alt"><a href="#">Derby shoes</a></h4>£54.00
                          </div>
                        </div>
                      </div>

                      <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product"><a href="#"><img src="assets/images/shop/product-2.jpg" alt="Leather belt"/></a>
                            <h4 class="shop-item-title font-alt"><a href="#">Leather belt</a></h4>£19.00
                          </div>
                        </div>
                      </div> -->

                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="container"></div>
        </section>

        <!-- チーム紹介 -->
        <hr class="divider-w">
        <section class="module" id="team">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Team charlotte</h2>
                <div class="module-subtitle font-serif">We are team charlotte!!<br>Simple self-introduction and favorite things...</div>
              </div>
            </div>
            <div class="row">
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-1.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">Hi all</h5>
                      <p class="font-serif">Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a&amp;nbsp;iaculis diam.</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Shoichi Chikushi</div>
                    <div class="team-role">Guitar</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-2.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">Good day</h5>
                      <p class="font-serif">Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a&amp;nbsp;iaculis diam.</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Reika Izumi</div>
                    <div class="team-role">Comedy</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-3.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">I love cebu.</h5>
                      <p class="font-serif">I like to take pictures!<br>I can speak Japanese,English,Spanish and...Cebuano!</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Hiroyuki Hasuike</div>
                    <div class="team-role">Photographer</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-4.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">Yes, it's me</h5>
                      <p class="font-serif">Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a&amp;nbsp;iaculis diam.</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Kodai Egoshi</div>
                    <div class="team-role">Ikemen</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>


      <!-- Footer -->
      <?php include('footer.php'); ?>  

      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>

    <!--  
    JavaScripts
    =============================================
    -->
    <script src="assets/lib/jquery/dist/jquery.js"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/lib/wow/dist/wow.js"></script>
    <script src="assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js"></script>
    <script src="assets/lib/isotope/dist/isotope.pkgd.js"></script>
    <script src="assets/lib/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="assets/lib/flexslider/jquery.flexslider.js"></script>
    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="assets/lib/smoothscroll.js"></script>
    <script src="assets/lib/magnific-popup/dist/jquery.magnific-popup.js"></script>
    <script src="assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>