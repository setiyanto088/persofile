
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

				var form_data = JSON.stringify({
					iduser   : $("#iduser").val(),
					username   : $("#username").val(),			
					nama   : $("#nama").val(),			
					tmplahir   : $("#tmplahir").val(),			
					tgllahir   : $("#tgllahir").val(),			
					alamat   : $("#alamat").val(),			
					nokontak1   : $("#nokontak1").val(),			
					email   : $("#email").val(),			
					pwd   : $("#pwd").val(),			
					cmfpwd   : $("#cmfpwd").val(),			
				})
				
				
				 $.ajax({
					type: "POST",
					url: "<?php echo base_url()."createuser/editself" ;?>",
					data : form_data,
					dataType: 'json',
					contentType: 'application/json; charset=utf-8',
					success: function(response) {
					  if (response.status == "success") {
						  swal({
							  title: 'Success!',
							  text: response.message
							}).then((result) => {
							    window.location.href = "<?php echo base_url();?>";
							})
						  
						
					  } else{
						swal("Failed!", response.message, "error");
						$("#loader").hide();
					  }
					}
				  });
			});
	





















		
});


	function cek(val){
		if(val  == ''){
			$('#bns').prop('disabled', false);
		}else{
			if(val  == $('#pwd').val()){
				$('#bns').prop('disabled', false);
				$('#ceksas').html('<h6 style="color: blue">Password Valid</h6>');
			}else{
				$('#bns').prop('disabled', true);
				$('#ceksas').html('<h6 style="color: red">Password Tidak Valid</h6>');
			}
		}
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
								<input type="hidden" class="form-control" placeholder="User Name" id="iduser" name="iduser" value="<?php echo $detailuser[0]['id']; ?>" required />
								<input type="hidden" class="form-control" placeholder="User Name" id="username" name="username" value="<?php echo $detailuser[0]['username']; ?>" required />
								<input type="hidden" class="form-control" placeholder="Nama" id="nama" name="nama" value="<?php echo $detailuser[0]['nama']; ?>" required/>
								<input type="hidden" class="form-control" placeholder="Tempat Lahir" id="tmplahir" name="tmplahir" value="<?php echo $detailuser[0]['tmplahir']; ?>" required/>
								<input type="hidden" class="datepicker form-control" placeholder="Tanggal Lahir" id="tgllahir" name="tgllahir" value="<?php echo $detailuser[0]['tgllahir']; ?>" required/>
								<input type="hidden" class="form-control" placeholder="Alamat" id="alamat" name="alamat" value="<?php echo $detailuser[0]['alamat']; ?>" required/>
								<input type="hidden" class="form-control" placeholder="No Kontak" id="nokontak1" name="nokontak1" value="<?php echo $detailuser[0]['nokontak1']; ?>" required/>
								<input type="hidden" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo $detailuser[0]['email']; ?>" required/>
														 
							 </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Password</label>
							  <div class="col-sm-10">
								<!--input type="password" class="form-control urate-form-input " placeholder="Password" id="pwd" name="pwd" value=""/-->
								
								
								<input id="pwd" name="pwd" type="password" class="form-control urate-form-input"  placeholder="Password">
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

  