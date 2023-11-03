<?php 
 $path = base_url() . 'assets/login/';
$path2 = base_url() . 'assets/font-awesome/';
$path3 = base_url() . 'assets/ionicons-2.0.1/';
$path9 = base_url() . 'assets/2022_design/';
$path7 = base_url() . 'assets/urate-frontend-master/';
?>





<!DOCTYPE html>
<html lang="en">
<head>
	<title>INRATE - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================
	 <link rel="icon" href="https://inrate.id/wp-content/themes/jupiter/assets/images/favicon.png?ver=2.1.0" type="image/x-icon">-->	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel=">stylesheet" type="text/css" href="<?php echo $path;?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>css/unics-login.css">
	   
    <link rel="stylesheet" type="text/css" href="<?php echo $path7;?>assets/css/style_ext.css">  
<!--===============================================================================================-->
  <style>
      #loader{
          display: none;
          text-align: center;
          padding-top: 10px;
          font-size: 16px;
          font-weight: bold;   
      }
  </style>
</head>
<body>

	
	<div class="limiter">
	<!--	<div class="container-login100" style="background-image: url('https://inrate.id/imgs/images1s.png');">
		<div class="container-login100" style="background-image: url('https://inrate.id/imgs/Frame 448a.png');"> -->
		<div class="container-login100" style="background-image: #fff');"> 
			<div class="wrap-login100">
				
			<form action="<?php echo base_url();?>api_auth/login" class="login100-form validate-form" method="post" id="form_login">
			
					<br><br><br><br><br><br><br><br>
			
					<span class="login100-form-titles" style="margin-bottom:50px">
						<img alt="img" src="<?php echo $path9;?>images/Group 12.png" alt="IMG">
					</span>
					
					<br><br><br><br>
					
				<div class="alert alert-danger alert-dismissible" role="alert">
                    <div class="content">
                    </div>
                </div>
					<p>Fill in your username and password to login</p><br>
				
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" id="username" placeholder="Username" style="color: black;">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" id="password" placeholder="Password" style="color: black;">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					
					
					<div class="container-login100-form-btns">
						
						<button class="login100-form-btn">
							Login
						</button>
            <img alt="img" class="gambar" src="<?php echo $path.'images/icon_loader.gif'; ?>" id="loader">
					</div>

					<div class="text-center p-t-12">
						&nbsp;
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?php echo $path;?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $path;?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo $path;?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $path;?>vendor/select2/select2.min.js"></script>
	
	<!-- Jquery Cookie -->
	<script src="<?php echo base_url();?>assets/cookie/jquery.cookie.js" type="text/javascript"></script>
<!--===============================================================================================-->
	<script src="<?php echo $path;?>vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	
	
		<script>
		$(document).ready(function () {
			$(".alert").hide();
			cookie_prefix = '<?php echo $this->config->item('cookie_prefix');?>';
			$("#form_login").submit(function(e) {
 				e.preventDefault();
 				$(".alert").hide();
				$(".alert-info").show();
				$(".alert-info .content").html('Signing in...');

				var form_data = JSON.stringify({
					username   : $("#username").val(),
					password   : $("#password").val(),
					remember_me   : $("#remember_me").prop('checked'),					
				})
						
        
        $('.login100-form-btn').hide();
        $('#loader').show();

 				$.ajax({
					type: "POST",
 					url: $(this).attr('action'),
					data: form_data,
 					dataType: 'json',
					contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
					
				}).done(function(response) {
					
					// handle a successful response
					$(".alert").hide();
					if (response.success) {
              $('.login100-form-btn').hide();
              $('#loader').show();
 							$.cookie(cookie_prefix + "token", response.data.token, {path: '/'});
					 
						location.href = "<?php echo base_url();?>home/";
						location.reload();
                        
                        
                        
                        
					} else {                                   
            $('.login100-form-btn').show();
            $('#loader').hide();
						$("#btn_login").removeAttr('disabled');
						$(".alert-danger").show();
						$(".alert-danger .content").html(response.message);
                        
                        setTimeout(function(){ $(".alert").hide(); }, 3000);
                        
                        
					}
				}).fail(function(xhr, status, message) {
					// handle a failure response            
          $('.login100-form-btn').show();
          $('#loader').hide();
					$("#btn_login").removeAttr('disabled');
					console.log('ajax login error:' + message);
				});
			});
		});

		function get_user_detail(user_id, token) {
			console.log('calling detail');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url();?>api_profile/get_user_detail/"+user_id+"?sess_user_id="+user_id+"&sess_token="+token,
				dataType: 'json',
				contentType: 'application/json; charset=utf-8'
			}).done(function(response) {
				console.log(response);
				if (response.success) {
					
						$.cookie(cookie_prefix + "role_id", response.data.role_id, { path: '/'});
						$.cookie(cookie_prefix + "role_name", response.data.role_name, { path: '/'});
						$.cookie(cookie_prefix + "user_name", response.data.user_name, { path: '/'});
						$.cookie(cookie_prefix + "user_full_name", response.data.user_full_name, { path: '/'});
						$.cookie(cookie_prefix + "status_pwd", response.data.status_pwd, { path: '/'});
				} else {
					console.log(response.message);
				}
			}).fail(function(xhr, status, message) {
				// handle a failure response
				console.log('ajax detail error: ' + message);
			});
			console.log('done calling detail');
		}

		</script>
<!--===============================================================================================-->
	<script src="<?php echo $path;?>js/main.js"></script>

</body>
</html>
