<?php 
require('../header_after.php');
 ?>

<!-- register↓ -->
        <section class="module">
          <div class="container">
            <div class="row">


              <div class="col-sm-5">
                <h4 class="font-alt">Signup</h4>
                <hr class="divider-w mb-10">
                <form class="form">

                  <div class="form-group">
                    <input class="form-control" id="E-mail" type="text" name="email" placeholder="Email"/>
                  </div>

                  <div class="form-group">
                    <input class="form-control" id="name" type="text" name="username" placeholder="Username"/>
                  </div>

                  <div class="form-group">
                    <input class="form-control" id="password" type="password" name="password" placeholder="Password"/>
                  </div>

                  <div class="form-group">
                    <input class="form-control" id="re-password" type="password" name="re-password" placeholder="Re-enter Password"/>
                  </div>

                  <label for="salutation">Select gender</label>
                  <select name="salutation" id="salutation">
                    <option disabled selected>Please pick one</option>
                    <option>female</option>
                    <option>male</option>
                    <option>other</option>
                  </select>
                  <br> 

                  <div class="form-group">
                    <button class="btn btn-block btn-round btn-b">Signup</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>

<?php 
require('../footer.php');
 ?>