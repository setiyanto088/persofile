
<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet">	
<link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	
    <!-- Multi Select Plugin Js -->
    <script src="<?php echo $path;?>plugins/multi-select/js/jquery.multi-select.js"></script>
    <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/jstree.min.js"></script>
<style>
.jstree-themeicon{
	 display: none !important;
}

</style>
<script>
		
$( document ).ready(function() {
	
							
});

</script>
	<div class="container-fluid">
			<div class="block-header">
				<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
						<h5>ROLE</h5>
					</div>
					
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <div class="card" >
                        <div class="header bg-blue-grey">
                            <h2>
								SET ROLE
							</h2>
                                
                            
                        </div>
						<div class="body">
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<form class="form-horizontal" method="POST" action="<?php echo base_url()."createuser/saverole" ;?>">
								<?php
										echo '<input type="hidden" value="'.$idUser.'" id="idUser" name="idUser"/>';
										echo '<select class="form-control" id="role" name="role">';
										foreach($listroleall as $myrole){
											if ($listrole[0]['role'] == $myrole['id']) {
												echo '<option value="'.$myrole['id'].'" selected>'.$myrole['role'].'</option>';
											} else {
												echo '<option value="'.$myrole['id'].'" >'.$myrole['role'].'</option>';
											}
											
										}
										echo '</select>';
									?>
								<br><br>
								<button type="submit" class="btn btn-success waves-effect ">Save</button>&nbsp <a href="<?php echo base_url()."createuser" ?>" class="btn btn-success waves-effect " onclick="window.location.replace('<?php echo base_url()."createuser" ?>')">Back</a> <br>
								<?php 
											if ($status==1){
												$warna="green";
											}else {
												$warna="red";
											}
										echo '<center><span><font size="6px" color="'.$warna.'"><sub>'.$msg.'</sub></font></span></center>'; 
								?> 
								</form>			
							</div>	
                        </div>
						</div>
                    </div>
             </div>
			
  </div>
  