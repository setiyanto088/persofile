<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?php echo $path;?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?php echo $path;?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet">	
<link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	

<style>
.jstree-themeicon{
	 display: none !important;
}

    
    
    .dropdown-menu{
        margin-top: 0px !important;
    }
</style>
<script>
$(function () {	
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });	
});
	
</script>
	<div class="container-fluid">
			<div class="block-header">
				<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
						<h5>CREATE USER</h5>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
					
					</div>
					
				</div>
			</div>
			
        
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <div class="card" >
                        <div class="header bg-blue-grey">
                            <h2>
                                 Input Data User
                            </h2>
                        </div>
				        <div class="body" >
							<div class="col-sm-12">
							<form class="form-horizontal" method="POST" action="<?php echo base_url()."createuser/saveuser" ;?>">
								<div class="form-group">
									<label class="col-sm-2 control-label">User Name</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="User Name" id="username" name="username" required />
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Password</label>
									  <div class="col-sm-10">
										<input type="password" class="form-control" placeholder="Password" id="pwd" name="pwd" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nama</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="Nama" id="nama" name="nama" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Tempat Lahir</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="Tempat Lahir" id="tmplahir" name="tmplahir" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Tanggal Lahir</label>
									  <div class="col-sm-10">
										<input type="text" class="datepicker form-control" placeholder="Tanggal Lahir" id="tgllahir" name="tgllahir" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Alamat</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="Alamat" id="alamat" name="alamat" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">No Kontak</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="No Kontak" id="nokontak1" name="nokontak1" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Email</label>
									  <div class="col-sm-10">
										<input type="email" class="form-control" placeholder="Email" id="email" name="email" required/>
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									  <div class="col-sm-10">
										<button type="submit" class="btn btn-success waves-effect " onclick="saveuser()">Save</button>&nbsp <a href="<?php echo base_url()."createuser"; ?>" class="btn btn-success waves-effect " onclick="window.location.replace('<?php echo base_url()."createuser"; ?>')">Back</a> <br> 
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
  