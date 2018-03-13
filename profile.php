<?php

    session_start(); //セッションスタート
    require('dbconnect.php'); //DB接続
    require('functions.php'); //ファンクション

    // 配列表示
    echo_var_dump('$_POST',$_POST);

    // debug
    $_SESSION['id']=1;
    $user_id = $_SESSION['id'];

    $sql = 'SELECT u.*, c.name AS country_name FROM users AS u, countries AS c WHERE u.country_id = c.country_id AND u.user_id = ?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <title>Titan | Multipurpose HTML5 Template</title>
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

    <!-- tab -->
    <link rel="stylesheet" type="text/css" href="assets/css/tab.css">
  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>

      <!-- header -->
      <?php //include('header.php'); ?>

      <div class="main">
        <section class="module-small">
          <div class="container">
            <div class="row">
              <div class="col-xs-offset-1 col-xs-3" style="text-align: center;">
                <img class="img-thumbnail" width="150" src="images/<?php echo $profile['image']; ?>">
              </div>
              <div class="col-xs-7">
                <div class="well-small">
                  <label class="control-label">Entry</label>
                  <div class="well-small">
                    <?php echo $profile['created'] ?>
                  </div>
                  <label class="control-label">Name</label>
                  <div class="well-small">
                    <?php echo $profile['name'] ?>
                    <!-- user_name -->
                  </div>
                  <label class="control-label">Country</label>
                  <div class="well-small">
                    <?php echo $profile['country_name'] ?>
                    <!-- country_name -->
                  </div>
                  <label class="control-label">Gender</label>
                  <div class="well-small">
                    <?php echo $profile['gender'] ?>
                    <!-- gender -->
                  </div>
                  <div class="form-group">
                    <!-- <div class="col-xs-3 col-xs-offset-9"> -->
                    <div style="text-align: right;">
                      <!-- <button type="reset" class="btn btn-default">Cancel</button> -->
                      <a class="btn btn-primary btn-lg" href="profile_edit.php">Edit</a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <hr class="divider-w"> -->
              <div class="col-xs-offset-1 col-xs-10">
                <div class="well-small bs-component">
                  <form method="POST" action="check.php" class="form-horizontal">
                    <fieldset>
                      <legend>Profile</legend>
                      <!-- <label class="control-label">Name</label> -->
                      <div class="well-small">
                        <?php echo $profile['profile'] ?>
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>

              <div class="col-xs-offset-1 col-xs-10">
                <legend>Favorite</legend>
                <div role="tabpanel">
                  <ul class="nav nav-tabs font-alt" role="tablist">
                    <li class="active"><a href="#plan" data-toggle="tab"><span class="icon-tools-2"></span>plan</a></li>
                    <li><a href="#request" data-toggle="tab"><span class="icon-tools-2"></span>request</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="plan">The European languages are members of the same family. Their separate existence is a myth.

                      <div class="row">
                        <a href="">
                        <!-- <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp"> -->
                          <div class="mb-sm-20 col-sm-6 col-md-3">
                            <div class="team-item">
                              <div class="team-image"><img src="assets/images/elephant.jpg" alt="Member Photo" class="img-thumbnail" />
                                <div class="team-detail">
                                  <h5 class="font-alt">Hi all</h5>
                                  <p class="font-serif">Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a&amp;nbsp;iaculis diam.</p>
                                </div>
                              </div>
                              <div class="team-descr font-alt">
                                <div class="team-name">Jim Stone</div>
                                <div class="team-role">Art Director</div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div> <!-- row -->
                    </div>
                    <div class="tab-pane" id="request">To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.

                      <div class="row">
                        <a href="">
                          <!-- <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp"> -->
                          <div class="mb-sm-20 col-sm-6 col-md-3">
                            <div class="team-item">
                              <div class="team-image"><img src="assets/images/kumamon2.png" alt="Member Photo" class="img-thumbnail"/>
                                <div class="team-detail">
                                  <h5 class="font-alt">Hello</h5>
                                  <p class="font-serif">Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a&amp;nbsp;iaculis diam.</p>
                                </div>
                              </div>
                              <div class="team-descr font-alt">
                                <div class="team-name">Adele Snow</div>
                                <div class="team-role">Account manager</div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div> <!-- row -->
                    </div>
                  </div>
                </div> <!-- tabpanel -->
              </div>

            </div> <!-- row -->
          </div> <!-- container -->
        </section>

        <div class="module-small bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">About Titan</h5>
                  <p>The languages only differ in their grammar, their pronunciation and their most common words.</p>
                  <p>Phone: +1 234 567 89 10</p>Fax: +1 234 567 89 10
                  <p>Email:<a href="#">somecompany@example.com</a></p>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Recent Comments</h5>
                  <ul class="icon-list">
                    <li>Maria on <a href="#">Designer Desk Essentials</a></li>
                    <li>John on <a href="#">Realistic Business Card Mockup</a></li>
                    <li>Andy on <a href="#">Eco bag Mockup</a></li>
                    <li>Jack on <a href="#">Bottle Mockup</a></li>
                    <li>Mark on <a href="#">Our trip to the Alps</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Blog Categories</h5>
                  <ul class="icon-list">
                    <li><a href="#">Photography - 7</a></li>
                    <li><a href="#">Web Design - 3</a></li>
                    <li><a href="#">Illustration - 12</a></li>
                    <li><a href="#">Marketing - 1</a></li>
                    <li><a href="#">Wordpress - 16</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Popular Posts</h5>
                  <ul class="widget-posts">
                    <li class="clearfix">
                      <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-1.jpg" alt="Post Thumbnail"/></a></div>
                      <div class="widget-posts-body">
                        <div class="widget-posts-title"><a href="#">Designer Desk Essentials</a></div>
                        <div class="widget-posts-meta">23 january</div>
                      </div>
                    </li>
                    <li class="clearfix">
                      <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-2.jpg" alt="Post Thumbnail"/></a></div>
                      <div class="widget-posts-body">
                        <div class="widget-posts-title"><a href="#">Realistic Business Card Mockup</a></div>
                        <div class="widget-posts-meta">15 February</div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr class="divider-d">
        <footer class="footer bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <p class="copyright font-alt">&copy; 2017&nbsp;<a href="index.html">TitaN</a>, All Rights Reserved</p>
              </div>
              <div class="col-sm-6">
                <div class="footer-social-links"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a>
                </div>
              </div>
            </div>
          </div>
        </footer>
      </div>
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
    <!-- <script src="assets/lib/smoothscroll.js"></script> -->
    <script src="assets/lib/magnific-popup/dist/jquery.magnific-popup.js"></script>
    <script src="assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>