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
		   
		   
							<div class="col-sm-12">
							<form class="form-horizontal" method="post" action="<?php echo base_url()."createuser/saveuseradmin" ;?>">
								<div class="form-group">
									<label class="col-sm-2 control-label">Username</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="Username" id="username" name="username" required />
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Name</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="Name" id="nama" name="nama" required />
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Password</label>
									  <div class="col-sm-10">
										<input type="text" class="form-control" placeholder="Password" id="password" name="password" required />
									  </div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Email</label>
									  <div class="col-sm-10">
										<input type="email" class="form-control" placeholder="Email" id="email" name="email" required />
									  </div>
								</div>
								
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Role Status:</label>
								   <div class="col-sm-10">
									  <select class="form-control" id="role" name="role">
										<option disabled selected>Pilih..</option>
										<option value="3">Tech</option>
										<option value="2">Sales</option>
									  </select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									  <div class="col-sm-10">
										<button type="submit" class="btn btn-success waves-effect " >Save</button> 
										
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
				
			