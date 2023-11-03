    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home Post Buy Dashboard</title>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">

  <!-- Multiple Select -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.min.css">       
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css">  
  
  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/widget.css?v=1.0.1">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/data-set.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/table.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack-extra.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/grid.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/chart.css">
   <!-- JQuery DataTable Css -->
    <link href="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.standalone.js"></script>
	<!-- cookie -->
 
  <style>
  .highcharts-credits{
		display: none;
	}
	
	#example3_filter{
		margin-top: 10px;
	}
	.dataTable > tbody > tr > .right {
		text-align: right;
	  }
	  .dataTable > thead > tr > th {
		text-align: center;
	  }
	.highcharts-button{
		display: none;
	}
	#container{
			width: 100%;
	}

	table.dataTable thead .sorting_desc::after {
	  content: "";
	}
	table.dataTable thead .sorting_asc::after {
	  content: "";
	}
	table.dataTable thead .sorting::after {
	  content: "";
	}

	.cArrowDown {
	  width: 12px;
	  float: right;
	  margin-right: -25px;
	}
	.highcharts-title{
		color: #4a4d54 !important; 
	}
  </style>

</head>

<body>


  <!-- Main Container -->
  <div class="main-container">
   
    <!-- / Sidebar -->
    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">                                   
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Pay TV</li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">TV Program Dashboard TREG</li>
            </ol>
            <h3 class="page-title">TV Program Dashboard TREG</h3>
          </div>
          <div class="col-md-7 text-right">
           
			<button data-toggle="modal" href="#addNewWidget" class="button_white"><em class="fa fa-th-large"></em> &nbsp <strong>Edit Widget</strong></button>
			<button onclick="show()" id="exportWidget" class="button_black" data-complete-text="<span class='ion-android-open'></span> Export Now"><em class="fa fa-download"></em><strong> &nbsp Export</strong></button>
           
            
			<button  class="btn-cancel button_black hidden"><strong>Cancel</strong></button>
			<br/>
			<h6 id="hs">
          </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row">
		
		<div class="col-lg-12">	
			<div class="col-lg-2">	
				<h4 id="shs">Showing data from</h4>
			</div>
			<div class="col-lg-2">	
					<select class="form-control" name="tahun" id="tahun" required onChange="viewall()">
					<option value='2018' <?php  if ($tahunselected=='2018') { echo 'selected'; } ?> >2018</option>
					<option value='2019' <?php  if ($tahunselected=='2019') { echo 'selected'; } ?> >2019</option>
					<option value='2020' <?php  if ($tahunselected=='2020') { echo 'selected'; } ?> >2020</option>
					<option value='2021' <?php  if ($tahunselected=='2021') { echo 'selected'; } ?> >2021</option>
						<?php 
 							foreach($thn as $periode){
								
								if ($periode['TANGGAL']==$tahunselected) {
									echo "<option value=".$periode['TANGGAL']." selected>".$periode['TANGGAL']."</option>";
								}else {
									echo "<option value=".$periode['TANGGAL']." >".$periode['TANGGAL']."</option>";
								}
								
							
								
							}
		 
						?>
					</select>   
			</div>
			
			<div class="col-lg-8">	
				<hr />
			</div>
			 
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img alt="image" src="<?php echo $path9;?>images/Frame123.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Number of TV Program</span><br>
                <span class="values"><?php echo number_format(intval($spots[0]["spot"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img alt="image" src="<?php echo $path9;?>images/Frame1232.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Number of TV Channel</span><br>
                <span class="values"><?php echo $jmlchannel[0]["jmlch"]; ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img alt="image" src="<?php echo $path9;?>images/Frame1233.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Active Audience</span><br>
                <span class="values"><?php echo number_format(intval($aa),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img alt="image" src="<?php echo $path9;?>images/Frame1234.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Universe</span><br>
                <span class="values"><?php echo number_format(intval($totpopulasi[0]["tot_pop"]),0,',','.'); ?>
                
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
             <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="navbar-left" style="padding-left:20px;">
                  <h4 class="title-periode1" style="font-weight: bold;">Audience by Channel</h4>
                </div>
				<div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('channel')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
              
                <div class="widget-content">
				
					<div class="col-lg-12 filter_panel" id="filter_panel_channel" style="display:none">	
						
						<div class="col-lg-12">	
							<div class="navbar-left" >
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							<div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view()" class="button_red">Apply Filter</button>
							</div>
						</div>
						
						<div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Day</label>	
									<select class="form-control"  id="tgl1" name="tgl1" >
									  
									  <?php 
										echo '<option value="0"  >'.'All Days</option>';
										foreach($tanggal as $ddd){
											
											echo '<option value='.$ddd.'  >'.'Day '.$ddd.'</option>';
										}
									  ?>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label>Week</label>
								<select class="form-control"  id="week1" name="week1"  >
								  
								  <?php 
									echo '<option value="ALL"  >'.'All Weeks</option>';
									for ($i=0;$i<=count($mingguan1)-1;$i++){
										$w=$i+1;
										echo '<option value='.$mingguan1[$i]['WEEK'].'  >'.'Week '.$w.'</option>';
									}
								  ?>
								</select> 
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label>Genre</label>
									 <select class="urate-select" name="genre" id="genre" title="Genre" required>
										   <option value="0" >All Genre</option>
										  <?php foreach($genre as $key) { ?>
										  <option value="<?php echo str_replace("&","AND",$key['GENRE']); ?>" ><?php echo $key['GENRE']; ?></option>
										  <?php } ?>
									  </select>
								</div>
							</div>
							<div class="col-lg-3">
							
								<input type='hidden' id='witel_txt' value='0' />
								<input type='hidden' id='datel_txt' value='0' />
								<input type='hidden' id='sto_txt' value='0' />
								<input type="hidden" name="profile_chan" id="profile_chan" value="0" />
							
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Regional</label>
									<select class="urate-select" name="regional" id="regional" title="Regional" required>
									  <option value="0" >Nasional </option>
									  <option value="01" >Regional 1</option>
									  <option value="02" >Regional 2</option>
									  <option value="03" >Regional 3</option>
									  <option value="04" >Regional 4</option>
									  <option value="05" >Regional 5</option>
									  <option value="06" >Regional 6</option>
									  <option value="07" >Regional 7</option>
									
									</select>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Witel</label>
									<select class="urate-select" name="witel" id="witel" title="Witel" required>
										<option value="0" >All Witel</option>
									</select>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Datel</label>
									<select class="urate-select" name="datel" id="datel" title="Datel" required>
										<option value="0" >All Datel</option>
									</select>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>STO</label>
									<select class="urate-select" name="sto" id="sto" title="STO" required>
										<option value="0" >All STO</option>
									</select>
								</div>
							</div>
							
						</div>
						
					</div>
				
					
					
     <!-- TV CHANNEL FIELD -->
					<div class="col-lg-12">	
                     
					  
					</div>
					
					<div id="table_program2" style="margin-top:25px">
						<table aria-describedby="table" id="example4" class="table table-striped  example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Reach <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Total Viewers <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Duration <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">AVG Duration/Views <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Audience Share <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>

							</thead>
						</table>
					</div>
                   <canvas id="widget-spot-channel" height="100"></canvas>
                </div>
            </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
             <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="navbar-left" style="padding-left:20px;">
                  <h4 class="title-periode2" style="font-weight: bold;">Audience by Program</h4>
                </div>
				<div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('program')" class="button_white" id="filter_program"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='program_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
               
                <div class="widget-content">
				
					<div class="col-lg-12 filter_panel" id="filter_panel_program" style="display:none">	
						<div class="col-lg-12">	
							<div class="navbar-left" >
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							<div class="navbar-right" style="padding:10px" >
								<button onClick="table2_view()" class="button_red">Apply Filter</button>
							</div>
						</div>
						
						<div class="col-lg-3">	
								<div class="form-group">
									<label>Day</label>	
									<select class="form-control"  id="tgl2" name="tgl2" >
									  
									  <?php 
										echo '<option value="0"  >'.'All Days</option>';
										foreach($tanggal as $ddd){
											
											echo '<option value='.$ddd.'  >'.'Day '.$ddd.'</option>';
										}
									  ?>
									</select> 
								</div>
						</div>
						
						<div class="col-lg-3">
								<div class="form-group">
									<label>Week</label>
								<select class="form-control"  id="week2" name="week2"  >
								  
								  <?php 
									echo '<option value="ALL"  >'.'All Weeks</option>';
									for ($i=0;$i<=count($mingguan1)-1;$i++){
										$w=$i+1;
										echo '<option value='.$mingguan1[$i]['WEEK'].'  >'.'Week '.$w.'</option>';
									}
								  ?>
								</select> 
								</div>
							</div>
					
						<div class="col-lg-3">
								<div class="form-group">
									<label>Genre</label>
									 <select class="urate-select" name="genre2" id="genre2" title="Genre" required>
										   <option value="0" >All Genre</option>
										  <?php foreach($genre as $key) { ?>
										  <option value="<?php echo str_replace("&","AND",$key['GENRE']); ?>" ><?php echo $key['GENRE']; ?></option>
										  <?php } ?>
									  </select>
								</div>
							</div>
							
						<div class="col-lg-3">		
							
							<input type='hidden' id='witel_txt2' value='0' />
							<input type='hidden' id='datel_txt2' value='0' />
							<input type='hidden' id='sto_txt2' value='0' />
							<input type="hidden" name="profile_prog" id="profile_prog" value="0" />
						
						</div>
						
							<div class="col-lg-3">
								<div class="form-group">
								<label>Regional</label>
									<select class="urate-select" name="regional2" id="regional2" title="Regional" required>
									  <option value="0" >Nasional </option>
									  <option value="01" >Regional 1</option>
									  <option value="02" >Regional 2</option>
									  <option value="03" >Regional 3</option>
									  <option value="04" >Regional 4</option>
									  <option value="05" >Regional 5</option>
									  <option value="06" >Regional 6</option>
									  <option value="07" >Regional 7</option>
									
									</select>
								</div>
							</div>  
						
						<div class="col-lg-3">
								<div class="form-group">
								<label>Witel</label>
									<select class="urate-select" name="witel2" id="witel2" title="Witel" required>
										<option value="0" >All Witel</option>
									</select>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Datel</label>
									<select class="urate-select" name="datel2" id="datel2" title="Datel" required>
										<option value="0" >All Datel</option>
									</select>
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>STO</label>
									<select class="urate-select" name="sto2" id="sto2" title="STO" required>
										<option value="0" >All STO</option>
									</select>
								</div>
							</div>
						
					</div>
				
					<div class="col-lg-12">	
						
						
					</div>

					
					<div id="table_program">
						<table aria-describedby="table" id="example3" class="table table-striped  example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Program <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th align="right" scope="row">Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th align="right" scope="row">Reach <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Total Viewers <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Duration <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">AVG Duration/Views <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>

							</thead>
						</table>
					</div>
                </div>
            </div>
          </div>
          
          
          
          
          
    
            
            
        </div>
        <!-- / Dashboard Widget -->
        <!-- / Content -->
      </div>
    </div>
  </div>
  <!-- / Main Contaner -->

  <!-- Modal New Widget -->
  <div class="modal fade" id="addNewWidget" tabindex="-1" role="dialog" aria-labelledby="addNewWidgetLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="addNewWidgetLabel">Edit Widget</h4>
        </div>
        <div class="modal-body" style="min-height:30vh;">
          <div class="row">
		  
              <div class="col-md-4">
                <div id="widget-2" class="widget selected">
                  <div class="navbar-center">
                    <h4>Audience By Channel</h4>
                  </div>
                  <div class="navbar-right">
                    <div class="btn-group btn-action">
                      <div class="checkbox urate-checkbox">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			  
              <div class="col-md-4">
                <div id="widget-1" class="widget selected">
                  <div class="navbar-center">
                    <h4>Audience By Program</h4>
                  </div>
                  <div class="navbar-right">
                    <div class="btn-group btn-action">
                      <div class="checkbox urate-checkbox">
                        <input type="checkbox" class="urate-form-checkbox" id="checkOne">
                        <label for="checkOne"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
           
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete Widget -->
  <div class="modal fade" id="deleteWidget" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Widget</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to delete ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-delete" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>

   <script src="<?php echo $path;?>assets/js/table.js"></script>
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
 <script src="<?php echo $path;?>assets/js/widget.js?v=2"></script>
<!-- highcharts -->
	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>
	 
	   <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo $paths;?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>

<script async >

function timesec(id){
	
 	document.getElementById("modal_filter").focus();
	
	$("#id_time").val(id);
	$("#modal_time").modal("show");
	
	
}

function settime(){
	
 	$("#modal_time").modal("hide");
	
	var hours = $("#hours").val();
	var minutes = $("#minutes").val();
	var seconds = $("#seconds").val();
	var id_time = $("#id_time").val();
	
	var time = hours+":"+minutes+":"+seconds;
	
	 $("#"+id_time).val(time);
	 
	$("#minutes").val("00").change();
	$("#seconds").val("00").change();
	$("#hours").val("00").change();
	
}

$(function () {
	
	
	
	
	
	
	
var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

      $("#exportWidget").click(function () {
          var doc = new jsPDF();
          var countPage = 0;
          var namefile = '';

          // Widget-1
          if($("#checkOne").is(':checked')){
			  
			  var docs = new jsPDF('l', 'mm', [297, 210]);  
            docs.text(155, 30, 'Audience by Channel', null, null, 'center');
           var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docs.text(155, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
 
            var elem = document.getElementById("example4");
            var res = docs.autoTableHtmlToJson(elem);
            docs.autoTable(res.columns, res.data, {
                theme: 'plain',
                margin: {
                  top: 50,
                  left: 20,
                  right: 20
                },
                  headerStyles: {
                  fontStyle: 'bold',
				  lineWidth: 0.1,
				  lineColor: [44, 62, 80]
                },
                bodyStyles: {
                  bottomLineColor: [0, 0, 0],
                },
                 styles: {
                  columnWidth: 'auto',
                  bottomLineColor: [44, 62, 80],
                  lineWidth: 0.1
                },
                columnStyles: {
                  text: {
                   }
                }
            });
            
			 
			setTimeout(function(){
			  docs.save('Audience by Channel.pdf');
 			 }, 0); 
			 
          }
			
			
			
          // Widget-2
          if($("#checkTwo").is(':checked')){
          
			var docc = new jsPDF('l', 'mm', [297, 210]);  
            docc.text(155, 30, 'Audience by Program', null, null, 'center');
             var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docc.text(155, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var elem1 = document.getElementById("example3");
            var res1 = docc.autoTableHtmlToJson(elem1);
            docc.autoTable(res1.columns, res1.data, {
                theme: 'plain',
                margin: {
                  top: 50,
                  left: 20,
                  right: 20
                },
                headerStyles: {
                  fontStyle: 'bold',
				  lineWidth: 0.1,
				  lineColor: [44, 62, 80]
                },
                bodyStyles: {
                  bottomLineColor: [0, 0, 0],
                },
                styles: {
                  columnWidth: 'auto',
                  bottomLineColor: [44, 62, 80],
                  lineWidth: 0.1
                },
                columnStyles: {
                  text: {
                   }
                }
            });
          
			setTimeout(function(){
			  docc.save('Audience by Program.pdf');
			 }, 4000); 
          }
         
          // Widget-3
          if($("#checkThree").is(':checked')){
             
			var doca = new jsPDF();  
            doca.text(105, 30, 'Audience by Time', null, null, 'center');
  var selPeriode = $('#tahun').find('option:selected').text().split('-');
            doca.text(155, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var canvasWidget1 = document.getElementById('widget-spot-time');
            var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
			
            doca.setFillColor(203, 51, 39);
            doca.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            doca.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
 			
			
			setTimeout(function(){
			  doca.save('Audience by Time.pdf');
			 }, 4000); 
          }

 		  
		  
		   if($("#checkFour").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }
			
			
			
			setTimeout(function(){
			 var chart = $('#container5').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Audience By Daypart'
				});
			 }, 10000); 
			 
          }
        
          // Widget-5
          if($("#checkFive").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

			setTimeout(function(){
			
			 var chart = $('#container6').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Audience By Day'
				});
				
				
			 }, 9000); 
			 
          }

          // Widget-6
          if($("#checkSix").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Table', null, null, 'center');
            var selPeriode = $('#tahun').find('option:selected').text().split('-');
            doc.text(155, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
 
            var elem = document.getElementById("example3");
            var res = doc.autoTableHtmlToJson(elem);
            doc.autoTable(res.columns, res.data, {
                theme: 'plain',
                margin: {
                  top: 50,
                  left: 50,
                  right: 50
                },
                headerStyles: {
                  fontStyle: 'bold'
                },
                bodyStyles: {
                  bottomLineColor: [0, 0, 0],
                },
                styles: {
                 
                },
                columnStyles: {
                  text: {
                   }
                }
            });
			
			
			setTimeout(function(){
			  doc.save('Audience by Time.pdf');
			 }, 4000); 
           }
		  

          
      });

	
	
window.chartColors = {
	red: '#ff5f5f',
	orange: 'rgb(220, 99, 70)',
	yellow: 'rgb(255, 205, 86)',
	green: '#a7d14b',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	white: 'rgb(255, 255, 255)'
};

var color = Chart.helpers.color;


});

	  function search_sto2(){
        var genre = $('#regional2').val();
		var witel = $('#witel2').val();
		var datel = $('#datel2').val();
        var query = "";
        
        if($('#search_datel2').val() != undefined){
            query = $('#search_datel2').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#sto2').empty('');
        
        var strVar = "";
      
            strVar = "<li data-for='sto2'><a href='javascript:;' data-real='0' data-for='sto2'>All STO</a></li>";
         
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3treg/stosearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre+"&w=" + witel+"&d=" + datel,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#sto2").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                     } else {
                        strResult = response[i].STO;
						
						  strVar += "<li data-for='sto2'><a href='javascript:;' data-real='"+strResult+"' class='urate-select-form-two'  data-for='sto2'>"+strResult+"</a></li>";
                    }
                    
                                             
                } 
                
                if(query == ""){  
                    $("#sto2").parent().removeClass('active'); 
                    $(".search-sto2-con").remove();                            
                    $("#sto2").next().next().html('');       
                    $("#sto2").next().next().append(strVar);
                } else {
                    $("#sto2").next().next().next().append(strVar);
                }  
				
				  $("#profile").next().next().next().append(strVar);   
                                
                $('[data-for = "sto2"]').click(function() { 
					 var huhu = $('#sto2').val();
				
					$('#sto_txt2').val(huhu);
				
                    $('#sto2').next().text($(this).text());
                    $('#sto2').attr('value',$(this).data("real"));
                    
					
					
                    $(this).closest('.default').removeClass('active');
                    
                    $(".search-sto2-con").remove();                       
                });        
                
				
				 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }


	  function search_sto(){
        var genre = $('#regional').val();
		var witel = $('#witel').val();
		var datel = $('#datel').val();
        var query = "";
        
        if($('#search_datel').val() != undefined){
            query = $('#search_datel').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#sto').empty('');
        
        var strVar = "";
        
         
            strVar = "<li data-for='sto'><a href='javascript:;' data-real='0' data-for='sto'>All STO</a></li>";
         
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3treg/stosearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre+"&w=" + witel+"&d=" + datel,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#sto").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                     } else {
                        strResult = response[i].STO;
						
						  strVar += "<li data-for='sto'><a href='javascript:;' data-real='"+strResult+"' class='urate-select-form-two'  data-for='sto'>"+strResult+"</a></li>";
                    }
                    
                                             
                } 
                
                if(query == ""){  
                    $("#sto").parent().removeClass('active'); 
                    $(".search-sto-con").remove();                            
                    $("#sto").next().next().html('');       
                    $("#sto").next().next().append(strVar);
                } else {
                    $("#sto").next().next().next().append(strVar);
                }  
				
				  $("#profile").next().next().next().append(strVar);   
                                
                $('[data-for = "sto"]').click(function() { 
				
				 var huhu = $('#sto').val();
				
					$('#sto_txt').val(huhu);
				
                    $('#sto').next().text($(this).text());
                    $('#sto').attr('value',$(this).data("real"));
                    
					
					
                    $(this).closest('.default').removeClass('active');
                    
                    $(".search-sto-con").remove();                       
                });        
                
				
				 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }

   function search_datel(){
        var genre = $('#regional').val();
		var witel = $('#witel').val();
        var query = "";
        
        if($('#search_witel').val() != undefined){
            query = $('#search_witel').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#datel').empty('');
        
        var strVar = "";
        
       
            strVar = "<li data-for='datel'><a href='javascript:;' data-real='0' data-for='datel'>All Datel</a></li>";
         
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3treg/datelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre+"&w=" + witel,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#datel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                     } else {
                        strResult = response[i].DATEL;
						
						  strVar += "<li data-for='datel'><a href='javascript:;' data-real='"+strResult+"' class='urate-select-form-two'  data-for='datel'>"+strResult+"</a></li>";
                    }
                    
                                             
                } 
                
                if(query == ""){  
                    $("#datel").parent().removeClass('active'); 
                    $(".search-datel-con").remove();                            
                    $("#datel").next().next().html('');       
                    $("#datel").next().next().append(strVar);
                } else {
                    $("#datel").next().next().next().append(strVar);
                }  
				
                                 
                $('[data-for = "datel"]').click(function() { 
				
					 var huhu = $('#datel').val();
				
					$('#datel_txt').val(huhu);
				
                    $('#datel').next().text($(this).text());
                    $('#datel').attr('value',$(this).data("real"));
                    
					 $(this).closest('.default').removeClass('active');
					 
					 search_sto(); 
					
                   $('#custom_sto').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
					$('#custom_sto').html("STO");                 
					
					if($('#datel').val() == '0' || $('#datel').val() == ''   ){			  
						$('#sto_txt').val('0');	
					}		
					
                });        
                
                 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
	
	function search_datel2(){
        var genre = $('#regional2').val();
		var witel = $('#witel2').val();
        var query = "";
        
 		
        if($('#search_witel2').val() != undefined){
            query = $('#search_witel2').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#datel2').empty('');
        
        var strVar = "";
        
         
            strVar = "<li data-for='datel2'><a href='javascript:;' data-real='0' data-for='datel2'>All Datel</a></li>";
         
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3treg/datelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre+"&w=" + witel,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#datel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                     } else {
                        strResult = response[i].DATEL;
						
						  strVar += "<li data-for='datel2'><a href='javascript:;' data-real='"+strResult+"' class='urate-select-form-two'  data-for='datel2'>"+strResult+"</a></li>";
                    }
                    
                                             
                } 
                
                if(query == ""){  
                    $("#datel2").parent().removeClass('active'); 
                    $(".search-datel2-con").remove();                            
                    $("#datel2").next().next().html('');       
                    $("#datel2").next().next().append(strVar);
                } else {
                    $("#datel2").next().next().next().append(strVar);
                }  
				
                                 
                $('[data-for = "datel2"]').click(function() { 
				
					var huhu = $('#datel2').val();
				
					$('#datel_txt2').val(huhu);
				
                    $('#datel2').next().text($(this).text());
                    $('#datel2').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active');
                    
                     search_sto2(); 
					
                   $('#custom_sto2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
					$('#custom_sto2').html("STO");                 
					
					if($('#datel2').val() == '0' || $('#datel2').val() == ''   ){			  
						$('#sto_txt2').val('0');	
					}		                   
                });        
                
                 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }

	
	   function search_witel2(){
        var genre = $('#regional2').val();
        var query = "";
        
        if($('#search_witel2').val() != undefined){
            query = $('#search_witel2').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#witel2').empty('');
        
        var strVar = "";
        
        
            strVar = "<li data-for='witel2'><a href='javascript:;' data-real='0' data-for='witel2'>All Witel</a></li>";
         
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3treg/witelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#witel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                     } else {
                        strResult = response[i].WITEL;
                    }
                    
                     strVar += "<li data-for='witel2'><a href='javascript:;' data-real='"+strResult+"' class='urate-select-form-two'  data-for='witel2'>"+strResult+"</a></li>";                          
                } 
                
                if(query == ""){  
                    $("#witel2").parent().removeClass('active'); 
                    $(".search-witel2-con").remove();                            
                    $("#witel2").next().next().html('');       
                    $("#witel2").next().next().append(strVar);
                } else {
                    $("#witel2").next().next().next().append(strVar);
                }  
				
                                 
                $('[data-for = "witel2"]').click(function() { 
				
					 var huhu = $('#witel2').val();
				
					$('#witel_txt2').val(huhu);
				
                    $('#witel2').next().text($(this).text());
                    $('#witel2').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active');
                    
					 search_datel2(); 
					
					$('#custom_datel2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
					$('#custom_datel2').html("Datel");  
			  
					$('#custom_sto2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
					$('#custom_sto2').html("STO"); 
					
					if($('#witel2').val() == '0' || $('#witel2').val() == ''   ){			  
						$('#datel_txt2').val('0');			  
						$('#sto_txt2').val('0');	
					}		
					
                 });        
               
                 
	    $('[data-for = "regional2"]').click(function() {
			
			
               $('#regional2').next().text($(this).data("real"));
              $('#regional2').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
			  
			  
              $(".search-regional2-con").remove();
             
              search_witel2();     
              
               $('#custom_witel2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_witel2').html("Witel");   
			  
			  $('#custom_datel2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_datel2').html("Datel");   

				$('#custom_sto2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_sto2').html("STO");   

			if($('#regional2').val() == '0' || $('#regional2').val() == ''  ){
				$('#witel_txt2').val('0');			  
				$('#datel_txt2').val('0');			  
				$('#sto_txt2').val('0');	
			}
			 		  
          }); 
		  
                 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
	
   function search_witel(regional){
        var genre = regional;
        var query = "";
        
        if($('#search_witel').val() != undefined){
            query = $('#search_witel').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#witel').empty('');
        
        var strVar = "";
        
        
            strVar = "<li data-for='witel'><a href='javascript:;' data-real='0' data-for='witel'>All Witel</a></li>";
         
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3treg/witelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#witel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                     } else {
                        strResult = response[i].WITEL;
                    }
                    
                     strVar += "<li data-for='witel'><a href='javascript:;' data-real='"+strResult+"' class='urate-select-form-two'  data-for='witel'>"+strResult+"</a></li>";                          
                } 
                
                if(query == ""){  
                    $("#witel").parent().removeClass('active'); 
                    $(".search-witel-con").remove();                            
                    $("#witel").next().next().html('');       
                    $("#witel").next().next().append(strVar);
                } else {
                    $("#witel").next().next().next().append(strVar);
                }  
				
                                 
                $('[data-for = "witel"]').click(function() { 
				 var huhu = $('#witel').val();
				
					$('#witel_txt').val(huhu);
				
                    $('#witel').next().text($(this).text());
                    $('#witel').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active');
                    
					  $(".search-witel-con").remove();
					  
					 search_datel(); 
					
					$('#custom_datel').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
					$('#custom_datel').html("Datel");  
					
					$('#custom_sto').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
					$('#custom_sto').html("STO"); 
					
					if($('#witel').val() == '0' || $('#witel').val() == ''   ){			  
						$('#datel_txt').val('0');			  
						$('#sto_txt').val('0');	
					}	
						
                 });        
               
                   
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }

$( document ).ready(function() {
	
 	
	$('.urate-select-dropdown a').each(function () {
    var $this = $(this),
        href = $this.attr('href');
    $this.attr('href', "javascript:;" + href);
})
	
	      
      
	    $('[data-for = "regional2"]').click(function() {
			
			
               $('#regional2').next().text($(this).data("real"));
              $('#regional2').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
			  
			  
              $(".search-regional2-con").remove();
             
              search_witel2();     
              
               $('#custom_witel2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_witel2').html("Witel");   
			  
			  $('#custom_datel2').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_datel2').html("Datel");   

		 		  
          }); 
		  
		    

          $('[data-for = "regional"]').click(function() {
              
			
              $('#regional').next().text($(this).data("real"));
              $('#regional').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
              $(".search-regional-con").remove();
              
              search_witel($('#regional').val());     
              
               $('#custom_witel').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_witel').html("Witel");  
			  

			  $('#custom_datel').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_datel').html("Datel");   

			  $('#custom_sto').closest('.urate-select').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_sto').html("STO");   

			if($('#regional').val() == '0' || $('#regional').val() == ''   ){
				$('#witel_txt').val('0');			  
				$('#datel_txt').val('0');			  
				$('#sto_txt').val('0');	
			}
							  
          }); 
		  
		    

	$('#week1').change(function(){
		$('#tgl1').val(0);	
	});
	
	$('#tgl1').change(function(){
		$('#week1').val("ALL");	
	});
	
	$('#tgl2').change(function(){
		$('#week2').val("ALL");	
	});
	
	$('#week2').change(function(){
		$('#tgl2').val(0);	
	});


	
});

var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';
var data = '' ;
var program = <?php echo $programs; ?>;
var audiencebychannel = <?php echo $audiencebychannel; ?>;

$(function () {	
var fieldas = $('#product_program').val();
var tgl2 = $('#tgl2').val();
var week2 = $('#week2').val();
var genre2 = $('#genre2').val();
var regional2 = $('#regional2').val();
var witel2 = $('#witel2').val();
var datel2 = $('#datel2').val();

var search_val = $( "input[aria-controls='example3']" ).val();

  var user_id = $.cookie(window.cookie_prefix + "user_id");
              var token = $.cookie(window.cookie_prefix + "token");    
 
	
	$('#example2').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"Info" : false,
		"sPaginationType": "simple_numbers",
		"processing": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		data: data,
		columns: [
			{ data: 'Product' },
			{ data: 'Spot',"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
				 
				}
			}
		]
	});	
	
	var table3 = $('#example3').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		"processing": true,
        "serverSide": true,
        "destroy": true,
		"ajax": "<?php echo base_url().'tvprogramun3treg/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl2="+tgl2+"&week2="+week2+"&searchtxt="+search_val+ "&genre2="+genre2+ "&regional2="+regional2+ "&witel2="+witel2+ "&datel2="+datel2,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});	
	
	 

	var table4 = $('#example4').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		data: audiencebychannel,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		columns: [
			{ data: 'Rangking' },
			{ data: 'channel' },
			{ data: 'AUDIENCE' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
					 
				}
			},
			{ data: 'REACH' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
					 
				}
			},
			{ data: 'TOTAL_VIEW' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
					 
				}
			},
			{ data: 'DURATION' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
					 
				}
			},
			{ data: 'AVGTOTDUR' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
					 
				}
			},
			{ data: 'SHARE' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
					 
				}
			}
		]
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});


	$('#export_m').on('click', function() {
 	  
		var form_data = new FormData();  
		
		var tahun = $('#tahun').val();
		
		var filter = table4.search()
		form_data.append('tahun', tahun);
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3treg/audiencebar_by_channel_export_m'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel_treg.xls','Audience_by_channel_month_'+tahun+'.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
	$('#channel_export').on('click', function() {
 	  
		var form_data = new FormData();  
		
		 var genre = $('#genre').val();
	  var regional = $('#regional').val();
	   var witel = $('#witel_txt').val();
	    var datel = $('#datel_txt').val();
	    var sto = $('#sto_txt').val();
		
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var week = $('#week1').val();
		var tgl = $('#tgl1').val();
		var profile_chan = $('#profile_chan').val();
		
		var filter = table4.search()
		form_data.append('genre', genre);
		form_data.append('regional', regional);
		form_data.append('witel', witel);
		form_data.append('sto', sto);
		form_data.append('datel', datel);
		form_data.append('cond',filter);
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
		form_data.append('tgl', tgl);
		form_data.append('profile', profile_chan);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3treg/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel.xls','Audience_by_channel.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
	$('#program_export').on('click', function() {
 	  
		var form_data = new FormData();  
		var genre2 = $('#genre2').val();
		var regional2 = $('#regional2').val();
		var witel2 = $('#witel_txt2').val();
		var datel2 = $('#datel_txt2').val();
		var sto2 = $('#sto_txt2').val();
		
		var type = $('#product_program').val();
		var field = "Program";
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var tgl = $('#tgl2').val();
		var profile_prog = $('#profile_prog').val();
		
		var filter = table3.search()
			
		var week = $('#week2').val();
		form_data.append('genre', genre2);
		form_data.append('regional', regional2);
		form_data.append('witel', witel2);
		form_data.append('datel', datel2);
		form_data.append('sto', sto2);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
 		form_data.append('pilihprog', type);
		form_data.append('field', field);
		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('periode',"<?php echo $tahunselected ?>");
		form_data.append('profile', profile_prog);	
		form_data.append('tgl', tgl);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3treg/audiencebar_by_program_export'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_program.xls','Audience_by_program.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
});

function table1_view(){
	
	var form_data = new FormData();  
	var type = $('#viewby_product').val();
	var field = $('#product_product').val();
	var stype = $('#viewby_product').val();
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'home/cost_by_program'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program1').html("");
			$('#table_program1').html('<table aria-describedby="table" id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

			$('#example2').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "simple_numbers",
				"processing": true,
				"Info" : false,
				data: obj,
				columns: [
					{ data: field },
					{ data: type,"sClass": "right",render: function ( data, type, row ) {
							if(stype == "Spot"){
                return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
							 
							}else{
                return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								 
							}
						}
					}
				]
	});	
		}
	});	
	
}

 
function view_daypart(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_daypart').val();
	var field = "daypart";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'home/daypart_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}

 			$('#container5').html();
			
			var chart= {
				type: 'bar'
			};
			var title = {
			  text: type+" by Daypart"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				formatter: function () {
					return type+': <strong>' + this.point.y + '</strong>';
				}
			};
			var  plotOptions= {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			};
			var series= [{
				 name: type,
				 data:data_new
			  }
			];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container5').highcharts(json);	
		}
	});	
}

function day_view(){
	
	var form_data = new FormData();  
	var type = $('#viewby_daybyday').val();
	var field = "ads_type";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'home/day_view'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}
			
			$('#container6').html();

			var title = {
			  text: type+" by Days"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			};
			var tooltip= {
				
			};
			var legend= {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			};
			var series= [{
				 name: type,
				 data:data_new
			  }
			];

			var json = {};

			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			$('#container6').highcharts(json);	
			
			document.getElementById("container6").focus();
		}
	});	
	
}

function ads_type_view(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_ads_type').val();
	var field = "ads_type";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'homes/ads_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}

 			$('#container3').html();
			
			var chart= {
				type: 'bar'
			};
			var title = {
			  text: type+" by Ads Type"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				formatter: function () {
					return type+': <strong>' + this.point.y + '</strong>';
				}
			};
			var  plotOptions= {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			};
			var series= [{
				 name: type,
				 data:data_new
			  }
			];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container3').highcharts(json);	
		}
	});	
}

function pie2_view(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_time').val();
	var field = "ads_type";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'home/prime_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);

 			$('#container4').html();
			
			var chart= {
				plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
			};
			var title = {
			  text: type+" By Type"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				pointFormat: '{series.name}: <strong>{point.percentage:.1f}%</strong>'
			};
			var  plotOptions= {
				pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
			};
			var series= [{
                name: 'Prime time',
                colorByPoint: true,
                data: [{
                    name: 'Prime Time '+type,
                    y: parseInt(obj["prime"])
                }, {
                    name: 'Not Prime Time '+type,
                    y: parseInt(obj["nprime"])
                }]
            }];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container4').highcharts(json);	
		}
	});	
}

function pie1_view(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_loose').val();
	var field = "ads_type";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'home/pie1_view'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);

 			$('#container2').html();
			
			var chart= {
				plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
			};
			var title = {
			  text: type+" By Type"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				pointFormat: '{series.name}: <strong>{point.percentage:.1f}%</strong>'
			};
			var  plotOptions= {
				pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
			};
			var series= [{
                name: 'Loose',
                colorByPoint: true,
                data: [{
                    name: 'Loose '+type,
                    y: parseInt(obj[0]["Loose"])
                }, {
                    name: 'Non Loose '+type,
                    y: parseInt(obj[0]["No_Loose"])
                }]
            }];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container2').highcharts(json);	
		}
	});	
}

function cont1_view(){
	
	var form_data = new FormData();  
	var type = $('#viewby_cont1').val();
	
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
			
	$.ajax({
		url: "<?php echo base_url().'home/cost_by_channel'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			if(type == "Cost"){
				type = "Ads Expenditure";
			}
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}

 			$('#container').html();
			
			var chart= {
				type: 'column'
			};
			var title = {
			  text: type+" by Channel"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				formatter: function () {
					return type+': <strong>' + this.point.y + '</strong>';
				}
			};
			var  plotOptions= {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			};
			var series= [{
				 name: type,
				 data:data_new
			  }
			];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container').highcharts(json);	
		}
	});	
}

function getNest(){
	 
	
	$('#filter_text').val(JSON.stringify(nest));
	
	$('#filter_form').submit();
	
	
} 


function viewall(){
	
		var url = '<?php echo base_url(); ?>tvprogramun3treg'; 
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
 		  
		 $("#laod").append(' <img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	
}

function table1_view(){
	
	var form_data = new FormData();  
	var type = $('#viewby_product').val();
	var field = $('#product_product').val();
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3treg/cost_by_program'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program1').html("");
			$('#table_program1').html('<table aria-describedby="table" id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

 			
			$('#example2').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "simple_numbers",
				"Info" : false,
				data: obj,
				columns: [
					{ data: field },
					{ data: type ,"sClass": "right",render: function ( data, type, row ) {
              return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
							 
						}
					}
				]
	});	
		}
	});	
	
}

function print_excel(){
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var profile_chan = $('#profile_chan').val();
	 
	var filter = table4.search()
	
	alert(filter);
	
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
	form_data.append('profile', profile_chan);
	
	 
}

	function download_file(fileURL, fileName) {
    // for non-IE
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_target';
        var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
        save.download = fileName || filename;
	       if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
				document.location = save.href; 
// window event not working here
			}else{
		        var evt = new MouseEvent('click', {
		            'view': window,
		            'bubbles': true,
		            'cancelable': false
		        });
		        save.dispatchEvent(evt);
		        (window.URL || window.webkitURL).revokeObjectURL(save.href);
			}	
    }

    // for IE < 11
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}

function audiencebar_view(){
	
 	
	 var genre = $('#genre').val();
	  var regional = $('#regional').val();
	   var witel = $('#witel_txt').val();
	    var datel = $('#datel_txt').val();
	    var sto = $('#sto_txt').val();
	
	
 	
	var form_data = new FormData();  
 	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var profile_chan = $('#profile_chan').val();
 	form_data.append('cond',"<?php echo $cond; ?>");
 	form_data.append('genre', genre);
	form_data.append('regional', regional);
	form_data.append('witel', witel);
	form_data.append('datel', datel);
	form_data.append('sto', sto);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
	form_data.append('profile', profile_chan);
   
 $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3treg/audiencebar_by_channel'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(datas){
 
			
			obj = jQuery.parseJSON(datas);
			
 			
			var table = $('#example4').DataTable();
 
			table.destroy();
			
			$('#table_program2').html("");
			
			$('#table_program2').html('<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Reach <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Total Viewers <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Duration <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>AVG Duration/Views <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience Share <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			
		
	
			$('#example4').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "simple_numbers",
				"Info" : false,
				data: obj,
				"searching": true,
				"language": {
					"decimal": ",",
					"thousands": "."
				},
				columns: [
					{ data: 'Rangking' },
					{ data: 'channel' },
					{ data: 'AUDIENCE' ,"sClass": "right",render: function ( data, type, row ) {
				  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
							 
						}
					},
					{ data: 'REACH' ,"sClass": "right",render: function ( data, type, row ) {
				  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
							 
						}
					},
					{ data: 'TOTAL_VIEW' ,"sClass": "right",render: function ( data, type, row ) {
				  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
							 
						}
					},
					{ data: 'DURATION' ,"sClass": "right",render: function ( data, type, row ) {
				  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
							 
						}
					},
					{ data: 'AVGTOTDUR' ,"sClass": "right",render: function ( data, type, row ) {
				  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
							 
						}
					},
					{ data: 'SHARE' ,"sClass": "right",render: function ( data, type, row ) {
				  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
							 
						}
					}
				]
			}).on('search.dt', function() {
			  var input = $('.dataTables_filter input')[0];
 			});
			
		}
	});	
}

function table2_view(){
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	var fieldas = $('#product_program').val();
	
	
	
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var tgl2 = $('#tgl2').val();
	var genre2 = $('#genre2').val();
	var regional2 = $('#regional2').val();
	var witel2 = $('#witel_txt2').val();
	var datel2 = $('#datel_txt2').val();
	var sto2 = $('#sto_txt2').val();
	var profile_prog = $('#profile_prog').val();
 
	var week2 = $('#week2').val();
	
 	var search_val = $( "input[aria-controls='example3']" ).val();
	
	 
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$('#table_program').html("");
				
	$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Program <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th align="right">Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th align="right">Reach <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Total Viewers <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Duration <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>AVG Duration/Views <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	
	$('#example3').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		"processing": true,
        "serverSide": true,
        "destroy": true,
		"ajax": "<?php echo base_url().'tvprogramun3treg/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl2="+tgl2+"&week2="+week2+"&searchtxt="+search_val+ "&genre2="+genre2+ "&regional2="+regional2+ "&witel2="+witel2+ "&datel2="+datel2+ "&sto2="+sto2,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	});	
	
}


function table4_view(){
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var tgl = $('#tgl2').val();
	var profile_prog = $('#profile_prog').val(); 
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week); 
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	form_data.append('tgl', tgl);
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3treg/cost_by_program'; ?>", 
		dataType: 'json',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
			 
					$('#table_program').html('<table aria-describedby="table" id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);
			
 						if(type == "Reach"){
							$('#example4').DataTable({
								"bFilter": false,
								"aaSorting": [],
								"bLengthChange": false,
								'iDisplayLength': 10,
								"sPaginationType": "simple_numbers",
								"Info" : false,
								
		"searching": true,
								"language": {
									"decimal": ",",
									"thousands": "."
								},
								data: obj,
								columns: [
									{ data: 'Rangking' },
									{ data: 'CHANNEL' },
									{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
										return new Intl.NumberFormat('id-ID').format(parseFloat((data/cas)*100).toFixed(2));
										 
										}
									}
								]
							});	
						}else{
							$('#example4').DataTable({
								"bFilter": false,
								"aaSorting": [],
								"bLengthChange": false,
								'iDisplayLength': 10,
								"sPaginationType": "simple_numbers",
								"Info" : false,
								
		"searching": true,
								"language": {
									"decimal": ",",
									"thousands": "."
								},
								data: obj,
								columns: [
									{ data: 'Rangking' },
									{ data: 'CHANNEL' },
									{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
							return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
										 
										}
									}
								]
							});	
						}
			
		}
	});	
	
}



function view_daypart(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_daypart').val();
	var field = "daypart";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3treg/daypart_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}

 			$('#container5').html();
			
			var chart= {
				type: 'bar'
			};
			var title = {
			  text: type+" by Daypart"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				formatter: function () {
					return type+': <strong>' + this.point.y + '</strong>';
				}
			};
			var  plotOptions= {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			};
			var series= [{
				 name: type,
				 data:data_new,
				 color: "#4a4d54"
			  }
			];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container5').highcharts(json);	
		}
	});	
}

function day_view(){
	
	var form_data = new FormData();  
	var type = $('#viewby_daybyday').val();
	var field = "ads_type";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3treg/day_view'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}
			
			$('#container6').html();

			var title = {
			  text: type+" by Days"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			};
			var tooltip= {
				
			};
			var legend= {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			};
			var series= [{
				 name: type,
				 data:data_new,
				 color: "#4a4d54"
			  }
			];

			var json = {};

			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			$('#container6').highcharts(json);	
			
			document.getElementById("container6").focus();
		}
	});	
	
}

function ads_type_view(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_ads_type').val();
	var field = "ads_type";
	
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3treg/ads_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}

 			$('#container3').html();
			
			var chart= {
				type: 'bar'
			};
			var title = {
			  text: type+" by Ads Type"
			};
			var subtitle = {
			  text: ""
			};
			var xAxis = {
			  categories: obj['cat'],
			  crosshair: true
			};
			var yAxis = {
			  title: {
				 text: type
			  }
			};
			var tooltip= {
				formatter: function () {
					return type+': <strong>' + this.point.y + '</strong>';
				}
			};
			var  plotOptions= {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			};
			var series= [{
				 name: type,
				 data:data_new,
				 color: "#4a4d54"
			  }
			];

			var json = {};

			json.chart = chart;
			json.title = title;
			json.subtitle = subtitle;
			json.xAxis = xAxis;
			json.yAxis = yAxis;  
			json.series = series;
			json.plotOptions = plotOptions;
			$('#container3').highcharts(json);	
		}
	});	
}
 


window.onload = function () {
	Chart.pluginService.register({
		beforeDraw: function (chart) {
			if (chart.config.options.elements.center) {
		        //Get ctx from string
		        var ctx = chart.chart.ctx;
		        
				//Get options from the center object in options
		        var centerConfig = chart.config.options.elements.center;
		      	var fontStyle = centerConfig.fontStyle || 'Arial';
				var txt = centerConfig.text;
		        var color = centerConfig.color || '#000';
		        var sidePadding = centerConfig.sidePadding || 20;
		        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
		        
		        //Start with a base font of 30px
		        ctx.font = "50px " + fontStyle;
		        
				//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
		        var stringWidth = ctx.measureText(txt).width;
		        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

		        // Find out how much the font can grow in width.
		        var widthRatio = elementWidth / stringWidth;
		        var newFontSize = Math.floor(30 * widthRatio);
		        var elementHeight = (chart.innerRadius * 2);

		        // Pick a new font size so it will not be larger than the height of label.
		        var fontSizeToUse = Math.min(newFontSize, elementHeight);

				//Set font settings to draw it correctly.
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'middle';
		        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
		        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
		        ctx.font = fontSizeToUse + "px " + fontStyle;
		        ctx.fillStyle = color;
		        
		        //Draw text in center
		        ctx.fillText(txt, centerX, centerY);
			}
		}
	});
  
 };     

function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Hide Filter');
	}

	$('#filter_panel_'+part).slideToggle(500);
	
}                             

$( document ).ready(function() {
    
	
	var selPeriode = $('#tahun').val();
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode3" ).html($(".title-periode3").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
    $( ".title-periode4" ).html($(".title-periode4").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
	
});

function show(){
	$('#hs').html('*check widget first before export');
}               

$(document).ready(function(){
    $(".table th").on("click",function(){                    
        if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
            $(this).children().css("transform","rotate(180deg)");
        } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
            $(this).children().css("transform","rotate(0deg)");
        }
    });
});
</script>	
    
</body>

</html>