<?php
    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション
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
    <!-- favicons -->
    <?php include('favicons_link.php'); ?>
    <!-- stylesheet -->
    <?php include('stylesheet_link.php'); ?>

    <!-- HEADER -->
  </head>

  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>

      <!-- Header -->
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- header -->
      <?php include('header.php'); ?>

      <section class="home-section home-full-height bg-dark-30" id="home" data-background="assets/images/section-5.jpg">
        <div class="video-player" data-property="{videoURL:'https://www.youtube.com/watch?v=bNucJgetMjE', containment:'.home-section', startAt:18, mute:false, autoPlay:true, loop:true, opacity:1, showControls:false, showYTLogo:false, vol:25}"></div>
        <div class="video-controls-box">
          <div class="container">
            <div class="video-controls"><a class="fa fa-volume-up" id="video-volume" href="#">&nbsp;</a><a class="fa fa-pause" id="video-play" href="#">&nbsp;</a></div>
          </div>
        </div>
        <div class="titan-caption">
          <div class="caption-content">
            <div class="font-alt mb-40 titan-title-size-4">Joinus!</div>
            <div class="font-alt mb-30 titan-title-size-2">Let's see. How to spend free travel.</div>
            <div class="font-alt mb-30 titan-title-size-1">Experience and event in Cebu<br>Sharing economy service</div>
            <a class="section-scroll btn btn-border-w btn-round" href="#about">About us</a>
          </div>
        </div>
      </section>

        <br>
        <br>
        <h2 class="module-title font-alt">Search</h2>
        <div class="input-group">
          <input type="text" class="form-control" placeholder="何を探しますか？">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary">Search</button>
            </span>
        </div>

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

        <section class="module pb-100" id="works">
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
              </div> <!-- tab-content -->
            </div>
          </div>
        </section>

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

        <!-- footer -->
        <?php include('footer.php'); ?>

      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>

    <!-- JavaScripts -->
    <?php include('javascript_link.php'); ?>

  </body>
</html>