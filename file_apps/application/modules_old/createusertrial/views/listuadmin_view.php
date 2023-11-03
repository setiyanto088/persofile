
<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet">	
	
<!-- Multi Select JS -->
<script src="<?php echo $path;?>plugins/multi-select/js/jquery.multi-select.js"></script>

 <!-- JQuery DataTable Css -->
<link href="<?php echo $path;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo $path;?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $path;?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	
	
	
	
<!-- / Sidebar -->
<div class="content-wrapper">
  <div class="container-fluid">
	<!-- Content -->
	<div class="row">
	  <div class="col-md-5">
		<h3 class="page-title">List User</h3>
	  </div>
	</div>    
	<div class="panel urate-panel urate-panel-result">
		  <div class="panel-heading">
		  </div>
		  <div class="panel-body">
		  
		  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<br/>
							<a type="button" class="btn btn-primary waves-effect" href="<?php echo base_url()?>createuser/createadmin">New Sales/Tech</a>
			</div>
			  
                  <table aria-describedby="mydesc"  id="example" class="table table-striped table-bordered">
					  <thead>
						<tr>
							<th scope="row">Name</th>						  										  
							<th scope="row">Status User</th>					  										  
						</tr>
					  </thead>
					</table>
		  </div>
	  </div>
	
	
 </div>
</div>
	
  
    <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary panel-filled">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <p></p>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <script type="text/javascript">
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	var token = $.cookie(window.cookie_prefix + "token"); 
	
	$(".preloader").hide();
	$(".alert").hide();
	
    function editUser(id){
        $('#panel-modal').removeData('bs.modal');
        $('#panel-modal  .panel-body').html('<i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Loading...');
        $('#panel-modal  .panel-body').load('<?php echo base_url('createuser/edituser');?>'+"/"+id);
        $('#panel-modal  .panel-title').html('<i class="fa fa-user"></i> Tambah/Edit User');
        $('#panel-modal').modal({backdrop:'static',keyboard:false},'show');
    }
	$(document).ready(function() {
		 $("#example").DataTable({
			"processing": true,
			"serverSide": true,
			destroy: true,
			 "order": [[ 0, "desc" ]],
			"ajax": "<?php echo base_url().'createuser/list_user_admin'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			"searchDelay": 700,
			responsive: true,
			"bFilter" : false,
			"bInfo" : false,
			"bLengthChange": false,
			"searching": true
		});
		
	});
	  
	  
  </script>	