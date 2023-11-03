
<!-- / Sidebar -->
<div class="content-wrapper">
  <div class="container-fluid">
	<!-- Content -->
	<div class="row">
	  <div class="col-md-5">
		<h3 class="page-title">Create User</h3>
	  </div>
	</div>    
	<div class="panel urate-panel urate-panel-result">
		  <div class="panel-heading">
		  </div>
		  <div class="panel-body">
		  
		   <div class="body" >
							<div class="col-sm-12"><br>
							<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url()."createusertrial/saveuser" ;?>">
								<div class="form-group">
									<label class="col-sm-2 control-label">User Name</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="User Name" id="username" name="username" required />
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Password</label>
									  <div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Name" id="password" name="password" required/>
									  </div>
									  <div class="col-sm-2">
									   <button class="btn urate-outline-btn btn-sm" id="processButton" onclick="event.preventDefault(); generate()">Generate</button>
									  </div>
								</div>
							
								<div class="form-group">
								  <label class="col-sm-2 control-label">Status:</label>
								   <div class="col-sm-10">
									 <?php
										echo '<select class="form-control" id="status" name="status">';
										
											echo '<option value="1" >Free Trial</option><option value="6" >Dinas</option>';
											
										
										echo '</select>';
									?>
									</div>
								</div>
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Type:</label>
								   <div class="col-sm-10">
									 <?php
										echo '<select class="form-control" id="role" name="role">';
										foreach($listroleall as $myrole){
											echo '<option value="'.$myrole['id'].'" >'.$myrole['role'].'</option>';
											
										}
										echo '</select>';
									?>
									</div>
								</div>
							
								</div-->
								<div class="form-group">
								  <label class="col-sm-2 control-label">Days Activation:</label>
								   <div class="col-sm-10">
									 <input type="text" class="form-control rupiah" id="duration"  name='duration' placeholder="" value="30">
									</div>
									
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									  <div class="col-sm-10">
										<button type="submit" class="btn btn-success waves-effect " >Create</button>&nbsp <a href="<?php echo base_url()."createusertrial"; ?>" class="btn btn-success waves-effect " onclick="window.location.replace('<?php echo base_url()."Createusertrial"; ?>')">Back</a> <br> 
										<?php 
											if ($status==1){
												$warna="green";
											}else {
												$warna="red";
											}
										echo '<center><span><font size="6px" color="'.$warna.'"><sub>'.$msg.'</sub></font></span></center>';  
										?> 
									  </div>
								</div>
									
							</form>
							</div>
							
                                
                        </div>
						<span id="facs" class="btn "></span>
		  </div>
	  </div>
	
	
 </div>
</div>
	
		<script language="javascript">
      $(document).ready(function(){              

          
          $('.rupiah').priceFormat({
          		prefix: '',
          		centsSeparator: '',
          		centsLimit: 0,
          		thousandsSeparator: '.'
        	});	

	  });		
	  
	  
	  function generate(){
		  
		  
		 var form_data = new FormData();  

		form_data.append('menu','kkk');
		
		$.ajax({
			url: "<?php echo base_url().'createusertrial/rdn'; ?>", 
			dataType: 'json',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){

				console.log(data);
				$('#password').val(data);
				

			}
		});	
		  
		  
	  }

</script>	  
				
			
		<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Save Profile</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" />
                                            <span id="dang" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                             <div class="preloader">
                                    <div class="spinner-layer pl-red-grey">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            <button type="button" class="btn btn-link waves-effect" id="toggler" onclick="getCreate()">SAVE</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>	
				
			