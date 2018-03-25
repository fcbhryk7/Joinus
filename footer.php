<!-- フッター -->
<!-- アバウトtemecharlotte -->
        <div class="module-small bg-dark">
          <div class="container">
            <div class="row">
              <!-- <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">About charlotte</h5>
                  <p>The languages only differ in their grammar, their pronunciation and their most common words.</p>
                  <p>Phone: +1 234 567 89 10</p>
                  <p>Fax: +1 234 567 89 10</p>
                  <p>Email: <a href="#">info@joinus.com</a></p>
                </div>
              </div> -->


<!-- サイトマップ設定 -->
              <div class="col-sm-3">
                <div class="widget">
                  <h5 class="widget-title font-alt">Site map</h5>
                  <ul class="icon-list">
                    <?php if(isset($_SESSION['user']['id'])) { ?>
                    <li><a href="<?php $root_dir; ?>profile.php?id=<?php echo $_SESSION['user']['id']; ?>">My page</a></li>
                    <li><a href="<?php $root_dir; ?>index.php#works">List plan / request</a></li>
                    <li><a href="<?php $root_dir; ?>post.php">Create plan / request</a></li>
                    <li><a href="<?php $root_dir; ?>help.php">Help</a></li>
                    <li><a href="<?php $root_dir; ?>signout.php">Signout</a></li>
                    <?php } else { ?>
                    <li><a href="<?php $root_dir; ?>signin.php">Signin</a></li>
                    <li><a href="<?php $root_dir; ?>index.php#works">List plan / request</a></li>
                    <li><a href="<?php $root_dir; ?>help.php">Help</a></li>
                    <li><a href="<?php $root_dir; ?>signout.php">Signout</a></li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>


<!-- コピーライト等 -->
        <hr class="divider-d">
        <footer class="footer bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <p class="copyright font-alt">&copy; 2018&nbsp;<a href="/index.php">Joinus!</a>, All Rights Reserved</p>
              </div>
<!-- snsボタン -->
              <div class="col-sm-6">
                <div class="footer-social-links"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a>
                </div>
              </div>
            </div>
          </div>
        </footer>