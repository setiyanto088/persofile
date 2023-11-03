
<script>
		
$( document ).ready(function() {
	
							
});

</script>
			
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		<h3>
			Edit User
		</h3>
	 <div class="card" >
	  <?php  if (isset($message)): ?>
		<script>swal("<?php echo $message['status']; ?>", "<?php echo $message['message']; ?>", "<?php echo $message['status']; ?>")</script>
		<?php endif; ?>
		
		
		
		
		   <div class="body" >
				<div class="col-sm-12">
				<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url()."createuser/edit" ;?>">
					 <input type="hidden" id="id" name="id"  value="<?php echo $id;?>"  />
					<div class="form-group">
					  <label class="col-sm-2 control-label">Role Status:</label>
					   <div class="col-sm-10">
						  <select class="form-control" id="role" name="role">
							<option disabled selected>Select Role..</option>
							<option value="1">Premium</option>
						  </select>
						</div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-2 control-label">Duration:</label>
					   <div class="col-sm-10">
						  <select class="form-control" id="months" name="months">
							<option disabled selected>Select Duration..</option>
							<option value="1">1 Month</option>
							<option value="3">3 Month</option>
							<option value="6">6 Month</option>
							<option value="12">12 Month</option>
						  </select>
						</div>
					</div>
					
					
					<div class="form-group">
					  <label class="col-sm-2 control-label">Upload DOC:</label>
					   <div class="col-sm-10">
						 <input type="file" id="sliders" name="sliders"   />
						
					   </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						  <div class="col-sm-10">
							<button type="submit" class="btn btn-success waves-effect " onclick="saveuser()">Save</button>&nbsp <a href="<?php echo base_url()."createuser"; ?>" class="btn btn-success waves-effect " onclick="window.location.replace('<?php echo base_url()."createuser"; ?>')">Back</a> <br> 
							
						  </div>
					</div>
						
				</form>
				</div>
				
					
			</div>
		
		
	</div>
 </div>

  