<?php

	$path5 = base_url() . 'assets/jQuery.Gantt-master/';
	 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>URATE</title>
	<link rel="icon" type="image/png" href="<?php echo base_url();?>img/logo.png" width="30px" height="15px" >
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=IE8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		
		
		
    <!-- Bootstrap -->
    <link href="<?php echo $path;?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $path;?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo $path;?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="<?php echo $path;?>vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Custom styling plus plugins -->
    <link href="<?php echo $path;?>build/css/custom.min.css" rel="stylesheet">
	<!-- iCheck -->
    <link href="<?php echo $path;?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-progressbar -->
    <link href="<?php echo $path;?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- JQVMap -->
    <link href="<?php echo $path;?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

	
	
	<!-- Jquery Cookie -->
		<script src="<?php echo $path;?>jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
	
	
	
	
	
	
	
	
	<!-- Font Awesome Icons -->
    <link href="<?php echo $path2;?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
	<!-- Ionicons -->
    <link href="<?php echo $path3;?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
   
   
   <link href="<?php echo $path5;?>css/style.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo $path5;?>css/prettify.min.css" rel="stylesheet" type="text/css" />
	
	<!-- Select2 -->
    <link href="<?php echo base_url();?>assets/select2-4.0.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    

	
    <script src="<?php echo $path5;?>js/jquery.fn.gantt.min.js" type="text/javascript"></script>
    <script src="<?php echo $path5;?>js/moment.min.js" type="text/javascript"></script>
	
	<!-- Emodal 1.0.1 -->
	<script src="<?php echo base_url();?>assets/eModal-master/dist/eModal.js"  type="text/javascript" ></script>
    
	
	
	
	
	
	<!-- Select2 -->
    <script src="<?php echo base_url();?>assets/select2-4.0.0/dist/js/select2.full.min.js" type="text/javascript"></script>

	<!-- sweet alert -->
	<script src="<?php echo base_url();?>assets/sweetalert/sweetalert.min.js"></script> 
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/sweetalert/sweetalert.css">

	<?php 
$id_role = $this->session->userdata('id_role');
$image = $this->session->userdata('image');

?>
  <script>
		$(document).ready(function () {
			
			// handle invalid token
			$( document ).ajaxSuccess(function( event, request, settings ) {
				//console.log(request);
				if (typeof request.responseJSON.success != 'undefined') {
					if (request.responseJSON.success == false && request.responseJSON.message == 'Invalid Token') {
						swal({   
							title: "Invalid Session",   
							text: "This user logged in from different device or session expired.",   
							type: "warning",   
							showCancelButton: false,   
							confirmButtonColor: "#DD6B55",   
							confirmButtonText: "OK",   
							closeOnConfirm: false 
							}, 
						function(){   
							swal("Redirecting..", "Redirecting to login page.", "success"); 
							$( "#btn_sign_out" ).trigger( "click" );
						});
						//sweetAlert('Invalid Token.', 'This user logged in from different device or session expired.', 'error');
						
					}
				}
			});
			
		  //var user_id = $.cookie(window.cookie_prefix + "user_id");
			//var token = $.cookie(window.cookie_prefix + "token");
			cookie_prefix = '<?php echo $this->config->item('cookie_prefix');?>';
			
			/* jadinya dicek di hooks
			if ( $.cookie(cookie_prefix + "user_id") == undefined) {
			  location.href = "<?php echo base_url();?>login/";
		    }*/
		    
			$("#btn_profile").on("click", function() {
				location.replace("<?php echo base_url().'users/profile/'.$id_role;?>");
			});
			
		    $("#btn_sign_out").on("click", function() {
				// alert('im out');
				var cookies = $.cookie();
				for(var cookie in cookies) {				   
					if (cookie.substring(0,6) == cookie_prefix) {						
						
						/* $.ajax({
							// url : '<?php echo base_url().'api_auth/logout/';?>' + '?sess_user_id=' + user_id + '&sess_token=' + token,
							// url : '<?php echo base_url().'api_auth/logout/';?>',
							// success: function(response) {								
								// location.replace("<?php echo base_url();?>");
							// },
							// error: function(obj, response) {
								// $("#main_message").html(response);
							// }							
						// }); */
						///Remove Cookie
						console.log('removing cookie:');
						console.log(cookie);
						$.removeCookie(cookie, {path: '/'});
					}
				}
				location.replace("<?php echo base_url();?>");
			});			
	});			
		
		var user_id = $.cookie(window.cookie_prefix + "user_id");
		var token = $.cookie(window.cookie_prefix + "token");
			
	  // function getNotif() {
		  // $.ajax({
		    // url: "<?php echo base_url().'api_activity/get_notif_box'; ?>" + '?sess_user_id=' + user_id + '&sess_token=' + token,
		    // success: function(response) {
		    	// var stat = 0;
		    	// var stat2 = 0;
		    	
		    	// if(response.data[0].Inbox != "0"){
		    	   // stat = 1;
		    	// }
		    	
		    	// if(response.data[0].Worklog != "0"){
		    	   // stat2 = 1;
		    	// }
		    	
		    	// if(stat == 1 && stat2 == 1 ){
		    		// document.getElementById("notif").innerHTML = "2";
		      // }else if(stat == 0 && stat2 == 1){
		      	// document.getElementById("notif").innerHTML = "1";
		      // }else if(stat == 1 && stat2 == 0){
		      	// document.getElementById("notif").innerHTML = "1";
		      // }else{
		      	// document.getElementById("notif").innerHTML = "";
		      // }
		      
		     	// document.getElementById("notif_inbox").innerHTML = response.data[0].Inbox;
		     	// document.getElementById("notif_worklog").innerHTML = response.data[0].Worklog;
		    // }
		  // });
		// }
					
		// getNotif();
		
		// });
    </script>
	
  </head>
 
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          
      
			<?php include(APPPATH . 'views/menu2.php');?>
    
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><em class="fa fa-bars"></em></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				  
				 
                    <img src=" <?php  
						if(isset($image)){
							$gambar = base_url().'img/'.$image;
						}else{
							$gambar = base_url().'img/person.jpg';
						}
						echo $gambar;
					?>" alt="">
					
					 <?php echo get_cookie($this->config->item('cookie_prefix').'user_full_name');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li> 
						<div class="pull-right">
							<button class="btn btn-default btn-flat" id="btn_sign_out">Sign out</button>
						</div> 
					</li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <em class="fa fa-envelope-o"></em>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <em class="fa fa-angle-right"></em>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
