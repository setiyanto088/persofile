<?php
    $image = base_url() . 'assets/images/';
    $api   = base_url() . 'api/';
    $path  = base_url() . 'assets/gentelella-master/';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>Log in</title>
    <link rel="icon" type="image/png" href="<?php echo $image;?>faviconlos.png" />

    <!-- jQuery -->
    <script src="<?php echo $path;?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link href="<?php echo $path;?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="<?php echo $path;?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <link href="<?php echo $path;?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- NProgress -->
    <link href="<?php echo $path;?>vendors/nprogress/nprogress.css" rel="stylesheet" />
    <script src="<?php echo $path;?>vendors/nprogress/nprogress.js"></script>
    <!-- Animate.css -->
    <link href="<?php echo $path;?>vendors/animate.css/animate.min.css" rel="stylesheet" />
    <!-- Sweet Alert css -->
    <link href="<?php echo $path;?>vendors/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $path;?>vendors/sweetalert/sweetalert.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $path;?>vendors/fastclick/lib/fastclick.js"></script>
    
    <!-- Custom Theme Style -->
    <link href="<?php echo $path;?>build/css/custom.min.css" rel="stylesheet" />
    <script src="<?php echo $path;?>build/js/custom.min.js "></script>
   
    <script>
      $(document).ready(function () { 
        $("#loader").hide();
        $("#loader2").hide();
        $("#login").on("click", function () {
          $("#loader").show();
          var vid_role    = $('#id_role').val();
          var vusername   = $('#username').val();
          var vpassword   = $('#password').val();
          
          var datapost={
            "appkey"    :   "123456",
            "username"  :   vusername,
            "password"  :   vpassword,
            "id_role"   :   vid_role,
          };

          $.ajax({
            type: "POST",
            url: "login/get_login",
            data : JSON.stringify(datapost),   
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success: function(response) {
              if (response.status == "success") {
                swal("Success!", "Log in Sukses", "success");
                window.location.href = "<?php echo base_url();?>home"; 
                $("#loader").hide();
              } else{
                swal("Failed!", response.message, "error");
                $("#loader").hide();
              } 
            }
          });
        });

        $("#sign_up").on("click", function () {
          $("#loader2").show();
          var vusername   = $('#newusername').val();
          var vemail      = $('#newemail').val();
          var vpassword   = $('#newpassword').val();
          var vpassword2  = $('#confirm-password').val();
          
          if (vpassword !== "" && vpassword2 !== "" && vpassword != vpassword2){
            swal("Failed!", "password not match", "error");
            $("#loader2").hide();
          } else if (vpassword !== "" && vpassword2 !== "" && vpassword == vpassword2){
 
            var datapost={
              "username"  :   vusername,
              "email"     :   vemail,
              "password"  :   vpassword,
              "id_role"   :   11 //default as CMO
            };
            
            $.ajax({
              type: "POST",
              url: "<?php echo $api;?>register",
              data : JSON.stringify(datapost),   
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success: function(response) {
                if (response.success) {
                  window.location.href = "<?php echo base_url();?>";
                  swal("Success", "Account Has been created", "success"); 
                  $("#loader2").hide();
                } else{
                  swal("Failed!", response.message, "error");
                  $("#loader2").hide();
                } 
              }
            });
          }
        });
      });
    </script>
  </head>

  <body class="login" style="background: url('<?php echo $image;?>bg3.jpg'); background-size: 110%;">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <div class="panel panel-default" style="background: rgba(255,255,255,.7);">
              <div class="panel-body">
                <form>
                  <h1>Login to LOS</h1>
                  <div class="form-group has-feedback">
                      <input type="text" class="form-control" id="username" placeholder="username">
                      <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input type="password" class="form-control" id="password" placeholder="Password">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="form-group">
                      <label class="pull-left">log in as</label>
                      <Select id="id_role" class="form-control">
                        <option selected value="21" >CMO</option>
                        <option value="27">Marketing Leader</option>
                        <option value="22">Surveyor</option>
                        <option value="23">Credit Analyst</option>
                        <option value="24">Ka. Divisi</option>
                        <option value="25">Ka. Cabang</option>
                        <option value="26">Direksi</option>
                        <option value="28">Komisaris</option>
                        <option value="1">Admin</option>
                      </select>
                  </div>
                  <div>
                    <a class="reset_pass" href="#">Forgot password</a>
                    <button type="button" id="login" class="btn btn-info">Log in</button>
                    <img alt="img" id="loader" src="<?php echo $image;?>loading.gif" style="width: 27px; height: 27px">
                  </div>

                  <div class="separator">
                    <p class="change_link">New to site?
                      <a href="#signup" class="to_register"> Create Account as CMO</a>
                    </p>

                    <div>
                      <h1><em class="fa fa-institution"></em> LOS</h1>
                      <strong>&copy; 2017</strong> All rights reserved. <a href="http://www.swamedia.co.id/">PT. Swamedia.</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <div class="panel panel-default" style="background: rgba(255,255,255,.8);">
              <div class="panel-body">
                <form>
                  <h1>Create Account</h1>
                  <div class="form-group has-feedback">
                      <input type="text" class="form-control" id="newusername" placeholder="Username" value="" required="" />
                      <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input type="email" class="form-control" id="newemail" placeholder="Email" value="" required="" />
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input type="password" class="form-control" id="newpassword" placeholder="Password" value="" required="" />
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div>
                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" value="" required="" />
                  </div>
                  <div>
                    <button type="button" id="sign_up" class="btn btn-info">Sign Up</button>
                    <img alt="img" id="loader2" src="<?php echo $image;?>loading.gif" style="width: 27px; height: 27px">
                  </div>

                  <div class="separator">
                    <p class="change_link">Already a member ?
                      <a href="#signin" class="to_register"> Log in </a>
                    </p>

                    <div>
                          <h1><em class="fa fa-institution"></em> LOS</h1>
                          <strong>&copy; 2017</strong> All rights reserved. <a href="http://www.swamedia.co.id/">PT. Swamedia.</a>
                        </div>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
