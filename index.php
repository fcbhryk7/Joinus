<?php 
  session_start();
  require('dbconnect.php');
  require('functions.php');


 ?>


<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  
    Document Title
    =============================================
    -->
    <title>Joinus!</title>
    <!--  
    Favicons
    =============================================
    -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!--  
    Stylesheets
    =============================================
    
    -->
    <!-- Default stylesheets-->
    <link href="assets/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template specific stylesheets-->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Volkhov:400i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="assets/lib/animate.css/animate.css" rel="stylesheet">
    <link href="assets/lib/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/lib/et-line-font/et-line-font.css" rel="stylesheet">
    <link href="assets/lib/flexslider/flexslider.css" rel="stylesheet">
    <link href="assets/lib/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="assets/lib/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link href="assets/lib/simple-text-rotator/simpletextrotator.css" rel="stylesheet">

    <!-- Main stylesheet and color file-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link id="color-scheme" href="assets/css/colors/default.css" rel="stylesheet">

    <!-- HEADER -->
  </head>

  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>

      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- Header -->
      <?php //include('header.php'); ?>

      <!-- スライダー -->
      <section class="home-section home-full-height photography-page" id="home">
        <div class="hero-slider">
          <ul class="slides">
            <li class="bg-dark" style="background-image:url(assets/images/main1.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt caption-text"><!-- コメント/画像urlの最初と最後に&quot; --></div>
                </div>
              </div>
            </li>
            <li class="bg-dark" style="background-image:url(assets/images/main2.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt caption-text"><!-- コメント/ --></div>
                </div>
              </div>
            </li>
            <li class="bg-dark" style="background-image:url(assets/images/main3.jpg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt caption-text"><!-- コメント/ --></div>
                </div>
              </div>
            </li>
            <li class="bg-dark" style="background-image:url(assets/images/main4.jpgg);">
              <div class="container">
                <div class="image-caption">
                  <div class="font-alt caption-text"><!-- コメント/ --></div>
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

                    <div class="owl-carousel text-center" data-items="5" data-pagination="false" data-navigation="false">
                      <div class="owl-item">
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
                      </div>
                      <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product"><a href="#"><img src="assets/images/shop/product-4.jpg" alt="Leather belt"/></a>
                            <h4 class="shop-item-title font-alt"><a href="#">Leather belt</a></h4>£14.00
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="tab-pane" id="sales">

                    <div class="owl-carousel text-center" data-items="5" data-pagination="false" data-navigation="false">
                      <div class="owl-item">
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
                      </div>
                      <div class="owl-item">
                        <div class="col-sm-12">
                          <div class="ex-product"><a href="#"><img src="assets/images/shop/product-4.jpg" alt="Leather belt"/></a>
                            <h4 class="shop-item-title font-alt"><a href="#">Leather belt</a></h4>£14.00
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

        <!-- サービス使い方 -->
        <hr class="divider-w">
        <section class="module" id="team">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">How to use</h2>
                <div class="module-subtitle font-serif">You can easily share the local experiences and events in Cebu.</div>
              </div>
            </div>
            <div class="row">
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="features-icon"><span class="icon-lightbulb"></span></div>
                  <div class="team-descr font-alt">
                    <div class="team-name">STEP 1</div>
                    <div class="team-name">Search for plans</div>
                    <div class="team-role">Guests select favorite plan.</div>
                    <div class="team-role">Guests can request plan.</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="features-icon"><span class="icon-lightbulb"></span></div>
                  <div class="team-descr font-alt">
                    <div class="team-name">STEP 2</div>
                    <div class="team-name">Confirm reservation</div>
                    <div class="team-role">Host a pproves.</div>
                    <div class="team-role">The guest and the host will move to detailed communication.</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="features-icon"><span class="icon-lightbulb"></span></div>
                  <div class="team-descr font-alt">
                    <div class="team-name">STEP 3</div>
                    <div class="team-name">Decision plan details</div>
                    <div class="team-role">Guests and hosts can decide the details of the trip.</div>
                    <div class="team-role">Chat is not necessary.</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="features-icon"><span class="icon-lightbulb"></span></div>
                  <div class="team-descr font-alt">
                    <div class="team-name">STEP 4</div>
                    <div class="team-name">On the day of plan</div>
                    <div class="team-role">Guests will gather at the meeting place and enjoy the plan.</div>
                    <div class="team-role">Host will show you the plan.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- サービスの特徴 -->
        <section class="module" id="services">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Our Services</h2>
                <div class="module-subtitle font-serif">There are 4 features.</div>
              </div>
            </div>
            <div class="row multi-columns-row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="features-item">
                  <div class="features-icon"><span class="icon-lightbulb"></span></div>
                  <h3 class="features-title font-alt">Host plan posting function.</h3>
                  <p></p>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="features-item">
                  <div class="features-icon"><span class="icon-bike"></span></div>
                  <h3 class="features-title font-alt">Guest request function.</h3>
                  <p></p>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="features-item">
                  <div class="features-icon"><span class="icon-tools"></span></div>
                  <h3 class="features-title font-alt">Plan creation without chat function.</h3>
                  <p></p>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="features-item">
                  <div class="features-icon"><span class="icon-gears"></span></div>
                  <h3 class="features-title font-alt">Comment function.</h3>
                  <p></p>
                </div>
              </div>
              </div>
            </div>
          </div>
        </section>
      </div>

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