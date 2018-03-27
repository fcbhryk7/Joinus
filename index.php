<?php 
  session_start();
  require('dbconnect.php');
  require('functions.php');

  // リクエストがある場合は、検索する
  if(!empty($_REQUEST) && $_REQUEST['input_word'] != '') {
      // プラン/リクエスト検索一覧表示
      $sql = 'SELECT p.title, p.plan_id, i.image_name, u.name, p.request_type FROM plans AS p, images AS i, users AS u, plans_tags AS pt, tags AS t WHERE p.plan_id = i.plan_id AND p.user_id = u.user_id AND p.plan_id = pt.plan_id AND pt.tag_id = t.tag_id AND i.image_order = 1 AND t.name LIKE ? ORDER BY p.created DESC';
      $target_str = '%' . h($_REQUEST['input_word']) . '%';
      $data = array($target_str);
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

      $plan_cnt = count($plans);

  } else {
      // プラン/リクエスト一覧表示
      $sql = 'SELECT p.title, p.plan_id, i.image_name, u.name, p.request_type FROM plans AS p, images AS i, users AS u WHERE p.plan_id = i.plan_id AND p.user_id = u.user_id AND i.image_order = 1 ORDER BY p.created DESC';
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

      $plan_cnt = count($plans);
  }


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

      <!-- 画像スライダー -->
      <section class="home-section home-fade home-full-height" id="home">
        <div class="hero-slider">
          <ul class="slides">

            <li class="bg-dark-30 bg-dark shop-page-header" style="background-image:url(images/main1.jpg);">
              <div class="titan-caption">
                <div class="caption-content">
                  <div class="font-alt mb-30 titan-title-size-4">Joinus!</div>
                  <div class="font-alt mb-40 titan-title-size-2">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1">Experience and event in Cebu<br>Sharing economy service</div>
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
                  <div class="font-alt mb-30 titan-title-size-4">Joinus!</div>
                  <div class="font-alt mb-40 titan-title-size-2">Let's see. How to spend free travel.</div>
                  <div class="font-alt mb-30 titan-title-size-1">Experience and event in Cebu<br>Sharing economy service</div>
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

      <!-- プランとリクエスト一覧 -->
      <div id="PlanRequest"></div>
      <section class="module" >
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                <h4 class="font-alt mb-0">Plan / Request list</h4>
                <hr class="divider-w mt-10 mb-20">
                <div role="tabpanel">
                  <ul class="nav nav-tabs font-alt" role="tablist">
                    <li class="active"><a href="#support" data-toggle="tab"><span class="icon-tools-2"></span>Plan</a></li>
                    <li><a href="#sales" data-toggle="tab"><span class="icon-tools-2"></span>Request</a></li>
                  </ul>
                   
                  <div class="tab-content">
                    <div class="tab-pane active" id="support">
                      <div class="row">
                        <?php for($i=0;$i<$plan_cnt;$i++) { if($plans[$i]['request_type'] == 0) { ?>
                          <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="plan_detail.php?id=<?php echo $plans[$i]['plan_id']; ?>">
                              <img src="images/<?php echo $plans[$i]['image_name']; ?>">
                              <div class="panel panel-default">
                                <div class="panel-heading">
                                  <?php echo $plans[$i]['title']; ?>
                                </div>
                                <div class="panel-body">
                                  <?php echo $plans[$i]['name']; ?>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php } } ?>
                      </div>
                    </div>

                    <div class="tab-pane" id="sales">
                     <div class="row">
                        <?php
                          for($i=0;$i<$plan_cnt;$i++){
                            if($plans[$i]['request_type'] == 1) {
                        ?>
                          <div class="col-lg-4 col-md-6 col-sm-12">
                            <a href="request_detail.php?id=<?php echo $plans[$i]['plan_id']; ?>">
                              <img src="images/<?php echo $plans[$i]['image_name']; ?>">
                              <div class="panel panel-default">
                                <div class="panel-heading">
                                  <?php echo $plans[$i]['title']; ?>
                                </div>
                                <div class="panel-body">
                                  <?php echo $plans[$i]['name']; ?>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php 
                          }
                            } 
                        ?>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
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

        <!-- チーム紹介 -->
        <hr class="divider-w">
        <section class="module" id="team">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">About us</h2>
                <div class="module-subtitle font-serif">We are team charlotte!!<br>Simple self-introduction and favorite things...</div>
              </div>
            </div>
            <div class="row">
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-1.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">Flirting guy</h5>
                      <p class="font-serif">My name is "SHOW".<br>Nice to meet you.</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Shoichi Chikushi</div>
                    <div class="team-role">Engineer</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-2.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">Crazy in love</h5>
                      <p class="font-serif">I am Ika.</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Reika Izumi</div>
                    <div class="team-role">Crazy</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-3.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">I love cebu</h5>
                      <p class="font-serif">I like to take pictures!<br>I can speak Japanese,English,Spanish and...Cebuano.haha<br>I will continue to study programming.</p>
                      <div class="team-social"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a></div>
                    </div>
                  </div>
                  <div class="team-descr font-alt">
                    <div class="team-name">Hiroyuki Hasuike</div>
                    <div class="team-role">English Teacher</div>
                  </div>
                </div>
              </div>
              <div class="mb-sm-20 wow fadeInUp col-sm-6 col-md-3" onclick="wow fadeInUp">
                <div class="team-item">
                  <div class="team-image"><img src="images/team-4.jpg" alt="Member Photo"/>
                    <div class="team-detail">
                      <h5 class="font-alt">Only Fukuoka</h5>
                      <p class="font-serif">I am interested only in Fukuoka!</p>
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

    <?php include('javascript_link.php'); ?> 
    
  </body>
</html>