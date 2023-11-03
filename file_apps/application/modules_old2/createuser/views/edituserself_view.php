
<script>
		
$( document ).ready(function() {
	if($('#pwd').val()){
		$('#bns').prop('disabled', true);
	}else{
		$('#bns').prop('disabled', false);
	}
	
		$(".toggle-password").click(function() {

		  $(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
			input.attr("type", "text");
		  } else {
			input.attr("type", "password");
		  }
		});		
		
		$(".toggle-passwords").click(function() {

		  $(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
			input.attr("type", "text");
		  } else {
			input.attr("type", "password");
		  }
		});		

			$("#form_login").submit(function(e) {
				e.preventDefault();
				
				var er_in = 0;
				
				if($("#pwd").val().length < 8){
					$('#ceksas').html('<h6 style="color: red">password must 8 character or more</h6>');	
					er_in = er_in+1;
				}
				
				if($("#cmfpwd").val() !== $("#pwd").val()){
					$('#ceksas').html('<h6 style="color: red">Confirm password must be same with new Password </h6>');	
					er_in = er_in+1;
				}
				
				if($("#cmfpwd").val() == ''){
					$('#ceksas').html('<h6 style="color: red">Confirm password cannot be empty</h6>');	
					er_in = er_in+1;
				}
				
				if($("#pwd").val() == ''){
					$('#ceksas').html('<h6 style="color: red">New password cannot be empty</h6>');	
					er_in = er_in+1;
				}

				if($("#oldpwd").val() == ''){
					$('#ceksas').html('<h6 style="color: red">Old password cannot be empty</h6>');	
					er_in = er_in+1;
				}


				if(er_in == 0){
					var form_data = new FormData();  
						form_data.append('oldpwd', $("#oldpwd").val());
						form_data.append('pwd', $("#pwd").val());
						form_data.append('cmfpwd', $("#cmfpwd").val());
						form_data.append('token', '<?php echo $token; ?>');
					
					 $.ajax({
						type: "POST",
						url: "<?php echo base_url()."createuser/editself" ;?>",
						data : form_data,
						dataType: 'text',  // what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						success: function(response) {
						  response = jQuery.parseJSON(response);
						  if (response.status == "success") {
			
								
								$('#ceksas').html('<h6 style="color: green">Password Change Success</h6>');
							  
							
						  } else{
							swal("Failed!", response.message, "error");
							$("#loader").hide();
						  }
						}
					  });
				}
			});
	





















		
});


	function cek(val){
		// if(val  == ''){
			// $('#bns').prop('disabled', false);
		// }else{
			// if(val  == $('#pwd').val()){
				// $('#bns').prop('disabled', false);
				// $('#ceksas').html('<h6 style="color: blue">Password Valid</h6>');
			// }else{
				// $('#bns').prop('disabled', true);
				// $('#ceksas').html('<h6 style="color: red">Password Tidak Valid</h6>');
			// }
		// }
	}

</script>
<style>
	.field-icon {
	  float: right;
	  margin-top: -25px;
	  position: relative;
	  
	  z-index: 2;
	}	
</style>			
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		<h3>
			Change Password
		</h3>
	  <?php  if (isset($message)): ?>
		<script>swal("<?php echo $message['status']; ?>", "<?php echo $message['message']; ?>", "<?php echo $message['status']; ?>")</script>
		<?php endif; ?>
	 
					<div class="col-lg-12">
					<form class="form-horizontal" id="form_login" name="form_login" method="POST" >
						<div class="form-group">
							<label class="col-sm-2 control-label">Name </label>
							  <div class="col-sm-10" style="margin-top: 7px">
							   <?php echo $detailuser[0]['nama']; ?>
								
														 
							 </div>
						</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Old Password</label>
							  <div class="col-sm-10">
								<!--input type="password" class="form-control urate-form-input " placeholder="Password" id="pwd" name="pwd" value=""/-->
								
								
								<input id="oldpwd" name="oldpwd" type="password" class="form-control urate-form-input"  placeholder="Old Password">
								<span toggle="#oldpwd" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							  </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">New Password</label>
							  <div class="col-sm-10">
								<!--input type="password" class="form-control urate-form-input " placeholder="Password" id="pwd" name="pwd" value=""/-->
								
								
								<input id="pwd" name="pwd" type="password" class="form-control urate-form-input"  placeholder="New Password">
								<span toggle="#pwd" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							  </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Confrim Password</label>
							  <div class="col-sm-10">
							  <input id="cmfpwd" name="cmfpwd"  type="password" class="form-control urate-form-input"  placeholder="Password" onkeyup="cek(this.value)">
								<span toggle="#cmfpwd" class="fa fa-fw fa-eye field-icon toggle-passwords"></span>
							  
								<span id="ceksas"></span>
							  </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							  <div class="col-sm-10">
								<button type="submit" id="bns" class="btn btn-success waves-effect " >Save</button>&nbsp <a href="javascript:void(0)" class="btn btn-success waves-effect "  data-dismiss="modal" aria-hidden="true">Back</a> <br> 
								
							  </div>
						</div>
						
					</form>
					</div>
					
						
			
 </div>

  