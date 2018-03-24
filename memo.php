<?php
// てるさんの
// $word_data = array();

//        $text1 = $_POST[‘search_term’];
//        $sql = ‘SELECT d.*, a.area_name,t.tag_id,c.country_name,p.comment FROM dialies AS d INNER JOIN areas_dialies AS ad ON d.dialy_id = ad.dialies_id INNER JOIN areas AS a ON ad.area_id = a.area_id INNER JOIN dialies_tags AS dt ON d.dialy_id = dt.dialy_id  INNER JOIN tags AS t ON dt.tag_id = t.tag_id INNER JOIN countries AS c ON a.country_id=c.country_id INNER JOIN pictures AS p ON d.dialy_id = p.dialy_id ‘;

//        // $sql = “SELECT d.*, a.area_name,t.tag_id,c.country_name,co.comment FROM dialies AS d INNER JOIN areas_dialies AS ad ON d.dialy_id = ad.dialies_id INNER JOIN areas AS a ON ad.area_id = a.area_id INNER JOIN dialies_tags AS dt ON d.dialy_id = dt.dialy_id INNER JOIN tags AS t ON dt.tag_id = t.tag_id INNER JOIN countries AS c ON a.country_id=c.country_id INNER JOIN comments AS co ON d.dialy_id = co.dialy_id WHERE ((d.title_comment LIKE ‘%旅行%‘) OR (co.comment LIKE ‘%旅行%‘)) AND ((d.title_comment LIKE ‘%写真%‘) OR (co.comment LIKE ‘%写真%‘))“;

//        // キーワードが入力されているときはwhere以下を組み立てる
//        if (strlen($text1)>0){

//            // 受け取ったキーワードの全角スペースを半角スペースに変換する
//            $text2 = str_replace(”　“, ” “, $text1);

//            // キーワードを空白で分割する
//            $array = explode(” ” ,$text2);

//            // 分割された個々のキーワードをSQLの条件where句に反映する
//            $where = “WHERE “;

//            // SQLインジェクション対策で?を使う
//            for($i = 0; $i <count($array);$i++){
//                $where = $where . “( d.title_comment LIKE ? OR p.comment LIKE ?) ” ;
//                $word_data[] = ‘%’ . $array[$i] . ‘%’;
//                $word_data[] = ‘%’ . $array[$i] . ‘%’;

//                if ($i <count($array) -1){
//                    $where .= ” AND “;
//                }
//            }
//            $sql = $sql . $where;
       // }





    // セッションスタート
    // session_start();
    // require('dbconnect.php'); //DB接続

    // $data = array();

    // $sql = 'SELECT p.* 
    // FROM plans AS p, tags AS t, plans_tags AS pt 
    // WHERE p.plan_id = pt.plan_id AND t.tag_id = pt.tag_id AND p.request_type = pt.tag_id AND t.name = "%?%"
    // ORDER BY p.created DESC'

    // $data = array();

    // //  WHERE句にrequest_type


    // $stmt = $dbh->prepare($sql);
    // $stmt -> execute();

    // $dbh = null;


  ?>
  <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]?>">
    <table>
      <tr>
        <td><input type="text" name="text1"></td>
        <td><input type="submit" value="検索" name="sub1"></td>
      </tr>
    </table>
  </form>

  <?php
  //組み立てたSQL分を表示する
  // echo "<p>組み立てたSQL分: ".$sql.@$where;

  ?>









 ?>
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

      <!-- Header -->
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>
      <!--ヘッダーりくワイヤ -->
      <?php
          require('header.php');
      ?>



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

      <?php
          echo '<pre>';
          echo '$_GET=';
          echo var_dump($_GET);
          echo '</pre>';
       ?>


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

        <!-- plan/requestリスト -->

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
                            <h4 class="shop-item-title font-alt"><a href="">Leather belt</a></h4>£12.00
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
        <!-- フッターりくワイヤ⇩ -->
        <?php
            require('footer.php');
        ?>
      </div>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>
    <?php
        require('javascript_link.php');
    ?>
  </body>
</html>