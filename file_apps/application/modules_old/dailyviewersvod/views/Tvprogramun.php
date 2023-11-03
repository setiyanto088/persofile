    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home Tv Program TVV Dashboard</title>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/widget.css?v=1.0.1">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/table.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack-extra.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/grid.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/chart.css">
   <!-- JQuery DataTable Css -->
    <link href="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
	 <script src="<?php echo $path;?>assets/ext/dataTables.fixedColumns.min.js"></script>
	   <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/ext/fixedColumns.dataTables.min.css">  
    
	 <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Timepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.js"></script> 
  <!-- Multiple Select -->
	<script src="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.standalone.js"></script>
	
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
	
	table.dataTable {
		clear: both;
		margin-top: -1px !important;
		margin-bottom: 0px !important;
		max-width: none !important;
	}
	 
	.even {
		background:#E0E0E0;
	}
	
	    .loader{
      display: block;
      text-align: center;
      padding-top: 10px;
      font-size: 16px;
      font-weight: bold;
    }
    
	  .dt-button{
  		position:relative;
  		left: 1%;
  		background-color: transparent;
  		color: #cb3827;
  		border-radius: 30px;
  		border: 1px solid #cb3827;
  		padding: 6px;
  		padding-left: 30px;
  		padding-right: 30px;
      bottom: 6px;
  	}    
	
	.urate-form-input{
		
		color: #000;
		
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
                <li class="breadcrumb-item">Dashboard VOD</li>
                <li class="breadcrumb-item active">Daily Viewers</li>
            </ol>
            <h3 class="page-title"><strong>Daily Viewers</strong></h3>
          </div>
          <div class="col-md-7 text-right">

			<br/>
			<h6 id="hs"></h6>
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
			<input type="hidden" name="tpe_f" id="tpe_f" value="ALL" />

			<div class="col-lg-8">	
				<span id="laod"></span><hr />
			</div>

						<?php 
							for ($i=0;$i<count($bln);$i++){
										
									if ($bln[$i]["bulan"]==$bulanselected) {
										echo "<option value=".$bln[$i]["bulan"]." Selected>".$bln[$i]["bulan"]."</option>";
									}else {
										echo "<option value=".$bln[$i]["bulan"]." >".$bln[$i]["bulan"]."</option>";
									}

							}
						?>
					</select>  
			</div> 
		</div>
		<br/>

		
		  
        </div>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">Daily Viewers by Category</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button onClick="filter_panel('channel')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_channel" style="display:none;padding: 10px;">	
				
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
				
						<div class="col-lg-12">	
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Start date period</label>	
									 <input type="text" class="form-control" name="start_date" id="start_date" placeholder="From ..." value="">
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>End date period</label>	
									<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." value="">
								</div>
							</div>
							<input type="hidden" class="form-control" name="week1" id="week1" placeholder="To ..." value="ALL">
							<input type="hidden" class="form-control" name="tipe_filter" id="tipe_filter" placeholder="To ..." value="live">
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Data</label>	
									<select class="form-control" name="audiencebar" id="audiencebar" required >
										<option value="Audience" selected >Audience</option>
										<option value="Viewers" >Total Views</option>
										<option value="Duration" >Duration</option>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label>Profile</label>	
									<select class="form-control" name="profile_chan" id="profile_chan"  >
										<option value="0" selected >All People</option>
										<?php foreach($profile as $prfs){
											
											echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
										} ?>
									</select> 
								</div>
							</div>
							
							
							<div class="col-lg-3">
								<label>Preset: <a href="#" data-toggle="modal" onClick="load_modal_load_channel()" id="ldctriger" style="color:red">Make New Preset</a> </label>
								<select class="form-control" name="preset" id="preset" class="preset" >  
									<option value="0" selected >All Category</option>
									<?php foreach($preset as $prfs){
										
										echo '<option value="'.$prfs['CHANNEL_NAME'].'"  >'.$prfs['CHANNEL_NAME'].'</option>';
									} ?>
								</select> 
							</div>
							
							
						</div>
						 
					</div>	 
						 
					</div>

					
					<div class="col-lg-12" style="margin-top:25px">	
					
					
						<div id="table_program2" >
							<table aria-describedby="mydesc"  id="example4" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "2"  scope="col">Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
										<th rowspan = "2"  scope="col">Category <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow">></th>
										<th colspan = "<?php echo count($day_dates); ?>"  scope="row">Audience </th>
									</tr>
									<tr>
									<?php foreach($day_dates as $day_datess){ ?>
										<th  scope="row"><?php $dated=date_create($day_datess);
											echo date_format($dated,"d-M"); ?></th>
									<?php } ?>
									</tr>

								</thead>
							</table>
						</div> 
					
					</div>
                  <canvas id="widget-spot-channel" height="100"></canvas>
              </div>
            </div>
			
			<div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Daily Viewers by Title</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button onClick="filter_panel('channel2')" class="button_white" id="filter_channel2"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_channel2" style="display:none;padding: 10px;">	
				
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view_t()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
				
						<div class="col-lg-12">	
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Start date period</label>	
									 <input type="text" class="form-control" name="start_date2" id="start_date2" placeholder="From ..." value="">
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>End date period</label>	
									<input type="text" class="form-control" name="end_date2" id="end_date2" placeholder="To ..." value="">
								</div>
							</div>
							<input type="hidden" class="form-control" name="week1" id="week1" placeholder="To ..." value="ALL">
							<input type="hidden" class="form-control" name="tipe_filter" id="tipe_filter" placeholder="To ..." value="live">
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Data</label>	
									<select class="form-control" name="audiencebart" id="audiencebart" required >
										<option value="Audience" selected >Audience</option>
										<option value="Viewers" >Total Views</option>
										<option value="Duration" >Duration</option>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label>Profile</label>	
									<select class="form-control" name="profile_chant" id="profile_chant"  >
										<option value="0" selected >All People</option>
										<?php foreach($profile as $prfs){
											
											echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
										} ?>
									</select> 
								</div>
							</div>
							
							
							<div class="col-lg-3">
								<label>Preset: <a href="#" data-toggle="modal" onClick="load_modal_load_channel()" id="ldctriger" style="color:red">Make New Preset</a> </label>
								<select class="form-control" name="preset2" id="preset2" class="preset" >  
									<option value="0" selected >All Category</option>
									<?php foreach($preset as $prfs){
										
										echo '<option value="'.$prfs['CHANNEL_NAME'].'"  >'.$prfs['CHANNEL_NAME'].'</option>';
									} ?>
								</select> 
							</div>
							
							
						</div>
						 
					</div>	 
						 
					</div>

					
					<div class="col-lg-12" style="margin-top:25px">	
					
					
						<div id="table_program22" >
							<table aria-describedby="mydesc"  id="example42" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "2" scope="col" >Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow">></th>
										<th rowspan = "2"  scope="col">Title <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow">></th>
										<th rowspan = "2"  scope="col">Category <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow">></th>
										<th colspan = "<?php echo count($day_dates); ?>"  scope="row">Audience </th>
									</tr>
									<tr>
									<?php foreach($day_dates as $day_datess){ ?>
										<th  scope="row"><?php $dated=date_create($day_datess);
											echo date_format($dated,"d-M"); ?></th>
									<?php } ?>
									</tr>

								</thead>
							</table>
						</div> 
					
					</div>
                  <canvas id="widget-spot-channel" height="100"></canvas>
              </div>
            </div>
			
          </div>
         <br>
		   <div id="widgets" class="row grid-stack" style="display:none">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-2" class="widget">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Audience by Day</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button onClick="filter_panel('day')" class="button_white" id="filter_day"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_day'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkOne">
                      <label for="checkTwo"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Channel">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
				
                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_day" style="display:none">	
				
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="day_view_f()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
				
						<div class="col-lg-12">	
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Start date period</label>	
									 <input type="text" class="form-control" name="start_date2" id="start_date2" placeholder="From ..." value="">
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>End date period</label>	
									<input type="text" class="form-control" name="end_date2" id="end_date2" placeholder="To ..." value="">
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label>Data</label>	
										<select class="form-control" name="audiencebarday" id="audiencebarday" required >
											<option value="Audience" selected >Audience</option>
											<option value="Viewers" >Total Views</option>
											<option value="Duration" >Duration</option>
										</select> 
								</div>
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
									<label>Preset: <a href="#" data-toggle="modal" onClick="load_modal_load_channel()" id="ldctriger" style="color:red">Make New Preset</a> </label>
									<select class="form-control" name="preset2" id="preset2" class="preset" >  
										<option value="0" selected >All Channel</option>
										<?php foreach($preset as $prfs){
											
											echo '<option value="'.$prfs['CHANNEL_NAME'].'"  >'.$prfs['CHANNEL_NAME'].'</option>';
										} ?>
									</select> 
								</div>	
							</div>
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Channel</label>	
								<div class="select-wrapper">
								  <select class="urate-select grid-menu" name="channelp" id="channelp" title="Please Choose a Channel ..." required>
									  <option value="0" >All Channel</option>
									  <?php foreach($channel as $key) { ?>
									  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
									  <?php } ?> 
								  </select>
								</div>
								</div>							
							</div>

						</div>
						 
					</div>	 
						 
				</div>

					
					<div class="col-lg-12" style="margin-top:25px">	
					
					  <div class="widget-content" id="loader_days">
						  <div id="container6"></div>
						</div>
					
					</div>
                  <canvas id="widget-spot-channel" height=""></canvas>
                </div>
              </div>
            </div>
          </div>
		  
          
            
             <!-- Modal Load Channel -->
	<div class="modal fade modalnewchannel" id="modalloadchannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Preset</strong></h4>
				</div>
				<div class="modal-body" style="height:400px">
					 <div class="form-group dataset col-md-5" style="z-index: 999;margin-bottom:20px">
							<label for="">Kategory</label>
							<div class="select-wrapper" style="">
                              <select class="urate-select grid-menu" name="channel" id="channel" title="Please Choose a Channel ..." required>
                                  <option value="0" >All Kategory</option>
                                  <?php foreach($channel as $key) { ?>
                                  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
                                  <?php } ?> 
                              </select>
							</div> 
					</div> 
					
					<div class="form-group dataset col-md-4" style="">
						<label for="">Preset Name</label>
							<div class="select-wrapper" style="">
                              <input style="color: #cb3827" type='text' class="form-control" name="save_channel_name" id="save_channel_name" title="" required>
							</div> 
					</div> 	
					
					<div class="form-group dataset col-md-3" style="">
						<label for=""> &nbsp  </label>
						<div class="select-wrapper" style="">
							<button type="button" class="button_black" onClick="save_channel_list()"><em class="fa fa-check"></em> &nbsp Save</button>
						</div>
					</div> 	
							 
					
					<form action="" class="row">
						<div class="form-group col-md-12">
						<table aria-describedby="mydesc"  id="example9" class="table table-striped" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">No </th>
									<th scope="row">Preset</th>
									<th scope="row">Channel List</th>
									<th scope="row">Action</th>
								</tr>

							</thead>
							<tbody id='bd_lod'>
							</tbody>
						</table>
						</div>
						
						
					</form>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel</button>
					
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
              <div class="col-md-4">
                <div id="widget-3" class="widget selected">
                  <div class="navbar-center">
                    <h4>Audience By Time</h4>
                  </div>
                  <div class="navbar-right">
                    <div class="btn-group btn-action">
                      <div class="checkbox urate-checkbox">
                        <input type="checkbox" class="urate-form-checkbox" id="checkThree">
                        <label for="checkThree"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div id="widget-4" class="widget selected">
                <div class="navbar-left">
                  <h4>Audience By Daypart</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkFour">
                      <label for="checkFour"></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div id="widget-5" class="widget selected">
                <div class="navbar-center" id='judul_hari'>
                  <h4>Audience By Day</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkFive">
                      <label for="checkFive"></label>
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


<!-- Modal Error -->
  <div class="modal fade" id="errorm" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Error </h4>
        </div>
        <div class="modal-body" id="body_error">
          <h5>Maximal Duration is 30 Days !!!! </h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete Widget -->
  <div class="modal fade" id="deleteWidget" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="clearchannel()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Widget</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to delete ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-delete" onClick="clearchannel()" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>
  
  
    <div class="modal fade" id="deletepreset" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Preset ?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to delete ?</p>
		  <input type="hidden" id="preset_name_del" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-delete" data-dismiss="modal" onClick="delete_channel()">Delete</button>
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

		function delete_conf(save_channel_name){
			
			 $('#deletepreset').modal('show');
			 $('#preset_name_del').val(save_channel_name);
			
			
			 
		}


		function delete_channel(){
			
			
			var user_id = $.cookie(window.cookie_prefix + "user_id");
			
			
			   var form_data = {
				  sess_user_id     : user_id,
				  save_channel_name	 :  $('#preset_name_del').val()
			  };       
			
			
			  $.ajax({
				  url : "<?php echo base_url().'dailyviewersvod/delete_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {


					  var html = '';
					  var html2 = '<option value="0" selected >All Channel</option>';
					  var no = 1;
					  for(var i = 0;i < response.length; i++){
						  
							html2 += '<option value="'+response[i].CHANNEL_NAME+'" >'+response[i].CHANNEL_NAME+'</option>';
						  
						  
							html += '<tr>';
							html += '		<td>'+no+' </td>';
							html += '		<td>'+response[i].CHANNEL_NAME+'</td>';
							html += '		<td>'+response[i].CHANNEL_LIST+'</td>';
							html += '		<td><button type="button" class="btn urate-btn" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\' , \''+response[i].CHANNEL_NAME+'\')">Edit</button><button type="button" class="btn urate-btn" onClick="delete_conf(\''+response[i].CHANNEL_NAME+'\')">Delete</button></td>';
							html += '	</tr>';
						  no++;
						  
					  }
					  $('#bd_lod').html(html);
					  
					  
					  $('#preset').html('');
					  $('#preset').html(html2);   
					  
					  $('#preset2').html('');
					  $('#preset2').html(html2); 
					  
						$('[data-for = "channel"]').each(function(){
							$(this).removeClass('checked'); 
						});
								
						$('#save_channel_name').val('');
						$('#custom_channel').html('Please Choose a Channel ...');
					  
						
				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
				  }
			  });    
			
		}

		function save_channel_list(){
			
			
			var save_channel_name = $('#save_channel_name').val();
			var channel = $('#channel').val();
			var user_id = $.cookie(window.cookie_prefix + "user_id");

			   var form_data = {
				  sess_user_id     : user_id,
				  save_channel_name	 : save_channel_name,
				  channel     : channel
			  };       
			
			
			//$('#save_channel_list').val(channel);
			  $.ajax({
				  url : "<?php echo base_url().'dailyviewersvod/save_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {


					  var html = '';
					  var html2 = '<option value="0" selected >All Channel</option>';
					  var no = 1;
					  for(var i = 0;i < response.length; i++){
						  
							html2 += '<option value="'+response[i].CHANNEL_NAME+'" >'+response[i].CHANNEL_NAME+'</option>';
						  
						  
							html += '<tr>';
							html += '		<td>'+no+' </td>';
							html += '		<td>'+response[i].CHANNEL_NAME+'</td>';
							html += '		<td>'+response[i].CHANNEL_LIST+'</td>';
							html += '		<td><button type="button" class="btn urate-btn" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\' , \''+response[i].CHANNEL_NAME+'\')">Edit</button><button type="button" class="btn urate-btn" onClick="delete_conf(\''+response[i].CHANNEL_NAME+'\')">Delete</button></td>';
							html += '	</tr>';
						  no++;
						  
					  }
					  $('#bd_lod').html(html);
					  
					  $('#preset').html('');
					  $('#preset').html(html2);
					  
					  $('#preset2').html('');
					  $('#preset2').html(html2); 
					  
						$('[data-for = "channel"]').each(function(){
							$(this).removeClass('checked'); 
						});
								
								
						$('#save_channel_name').val('');
						$('#custom_channel').val('');
						$('#custom_channel').html('Please Choose a Channel ...');
				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
				  }
			  });    
			
		}

	  	function load_channel(channel_list,channel_name){ 
		
		
			console.log(channel_list);
			
			$('[data-for = "channel"]').each(function(){
                $(this).removeClass('checked'); 
            });
			
			var arr_channel = channel_list.split(',');

			$('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value',channel_list);
			
			var $text ='';
			for(var i = 0;i < arr_channel.length; i++){
				if(i == 0){
					$text += '<span class="menu-item">'+arr_channel[i]+'</span>';
				}else{
					$text += '<span class="menu-item">'+arr_channel[i].substring(1)+'</span>';
				}
				
			}		   
			 
			 
            $('#custom_channel').closest('.grid-menu').children('.urate-custom-button').text('').append($text);
		  
			for(var i = 0;i < arr_channel.length; i++){
				if(i == 0){
					$('[data-real = "'+arr_channel[i]+'"]').parent().addClass('checked');
				}else{
					$('[data-real = "'+arr_channel[i].substring(1)+'"]').parent().addClass('checked');
				}
			}	
			
			$('#save_channel_name').val(channel_name);

		}

	function load_modal_load_channel(){
			
				$('[data-for = "channel"]').each(function(){
					$(this).removeClass('checked'); 
				});
				
				$('[data-for = "channelp"]').each(function(){
					$(this).removeClass('checked'); 
				});
						
				$('#save_channel_name').val('');
				$('#custom_channel').html('Please Choose a Channel ...');
				$('#custom_channelp').html('Please Choose a Channel ...');
			
			 var form_data = {
				  sess_user_id     : ''
			  };       
			
			
			  $.ajax({
				  url : "<?php echo base_url().'dailyviewersvod/load_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
					  
					  var html = '';
					  var no = 1;
					  for(var i = 0;i < response.length; i++){
						  
							html += '<tr>';
							html += '		<td>'+no+' </td>';
							html += '		<td>'+response[i].CHANNEL_NAME+'</td>';
							html += '		<td>'+response[i].CHANNEL_LIST+'</td>';
							html += '		<td width="200px"><button type="button" class="button_black" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\' , \''+response[i].CHANNEL_NAME+'\')">Edit</button><button type="button" class="button_black" onClick="delete_conf(\''+response[i].CHANNEL_NAME+'\')">Delete</button></td>';
							html += '	</tr>';
						  no++;
						  
					  }
					  $('#bd_lod').html(html);
					  
				
						$('#modalloadchannel').modal('show');					  
				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
				  }
			  });    			
						
			

			
			
		}

   function search_channel(){
        var genre = $('#genre').val();
        var query = "";
        
        if($('#search_channel').val() != undefined){
            query = $('#search_channel').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        
        $('#channel').empty('');
        
        var strVar = "";
        

            strVar = "<li data-for='channel'><a href='#' data-real='0' data-id='channel'>All Channel</a></li>";
        
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'dailyviewersvod/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&q=" + query +"&g=" + genre,
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                $("#channel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].CHANNEL;
                    }
                    
                    strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                } 
                
                if(query == ""){  
                    $("#channel").parent().removeClass('active'); 
                    $(".search-channel-con").remove();                            
                    $("#channel").next().next().html('');       
                    $("#channel").next().next().append(strVar);
                } else {
                    $("#channel").next().next().next().append(strVar);
                }  
                
                $('.grid-menu .urate-custom-menu > li:not(.modal-link)').click(function() {
                  $(this).toggleClass('checked');
              
                  var $strArr = [];
                  var $str = [];
                  var $text ='';
              
                  $('.grid-menu .urate-custom-menu > li').each(function() {
                    if ($(this).hasClass('checked')) {
                      $strArr.push($(this).children('a').attr('data-real'));
                      $str.push($(this).children('a').text());
                    }
                  });
              
              
                  for (var i = 0; i < $str.length; i++) {
                    $text += '<span class="menu-item">'+$str[i]+'</span>'
                  }
              
                  $(this).closest('.grid-menu').children('.urate-custom-button').text('').append($text);
                  $(this).closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', $strArr);
                  
                  /* TO HANDLE ALL CHANNEL*/
                  /* IF ALL CHANNEL CHECKED THE ANY OTHER CHANNEL THAN ALL CHANNEL WILL BE UN-CHECKED*/
                  $('.urate-custom-menu > li > a').on('click',function(){
                      if($(this).data('real') == "0"){
                          $('[data-for = "'+$(this).data('id')+'"]').each(function(){
                              $(this).removeClass('checked');
                          });
                      }
                      
                      if($(this).data('real') != "0"){
                          $('[data-real = "0"]').parent().removeClass('checked');
                      }
                  });
                  /* END - TO HANDLE ALL CHANNEL*/ 
                });
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }

function selectAll(){
	
	var tahun = $('#tahun').val();
	var tpe_f = $('#tpe_f').val();
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	
	var form_data = new FormData();  
	form_data.append('tahun', tahun);	
	form_data.append('tpe_f', tpe_f);
	
	$("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
	
	$.ajax({
		url: "<?php echo base_url().'dailyviewersvod/header_change'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			obj = jQuery.parseJSON(data);
			
			console.log(obj);
			
			$('#no_prog').html(obj['jmlprogram']);
			$('#no_channel').html(obj['jmlchannel']);
			$('#active').html(obj['active_audience']);
			$('#active_user').html(obj['active_user']);
			$('#tot_viw').html(obj['total_views']);
			$('#dur_h').html(obj['duration']);
			$('#dur_view').html(obj['durmin']);
			
			$("#laod").html('');
		}
	});
}

function program_change(){
	
	if($('#fta_program').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tipe_filter_prog = $('#tipe_filter_prog').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var check = check;
	var tgl = $('#tgl2').val();
	var profile_prog = $('#profile_prog').val();
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	form_data.append('tgl', tgl);
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$('#table_program').html("");
	
	if(type == 'Viewers'){
		var tpe = 'Total Views';
	}else if(type == 'avgtotdur'){
		var tpe = 'Average Duration/Total Views';
	}else{
		var tpe = type;
	}
				
	$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	
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
		"ajax": "<?php echo base_url().'Tvprogramun3tvv/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&tgl2="+tgl+"&week2="+week+"&check="+check+"&tipe_filter_prog="+tipe_filter_prog,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	});	
	
	
}

function channel_change(){
	
	
	if($('#fta_channel').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var tipe_filter = $('#tipe_filter').val();
	var bulan = $('#bulan').val();
	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var profile_chan = $('#profile_chan').val();
	var check = check;
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
	form_data.append('check', check);
	form_data.append('profile', profile_chan);
  
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'Tvprogramun3tvv/audiencebar_by_channel'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			

			$('#table_program2').html("");

			
			if(type == 'Viewers'){
				
				var tpe = 'Total Views';
				
			}else if(type == 'Duration'){
				var tpe = 'Duration ';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
			}else{
				
				var tpe = type;
			}
					$('#table_program2').html('<table aria-describedby="mydesc"  id="example4" class="table table-striped  example" style="color:black"><thead style="color:red"><tr><th>Rank<img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
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
						{ data: 'channel' },
						{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
							return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
							
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
					data: obj,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					columns: [
						{ data: 'Rangking' },
						{ data: 'channel' },
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

function clearchannel(){
	
				$('[data-for = "channel"]').each(function(){
					$(this).removeClass('checked'); 
				});
				
				$('[data-for = "channelp"]').each(function(){
					$(this).removeClass('checked'); 
				});
				
	$('#custom_channelp').html('Please Choose a Channel ...');
	$('#custom_channel').html('Please Choose a Channel ...');
	
}

$(function () { 
	
	 $('#custom_channel').click(function() {   
	
	 
              $(".search-channel-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);  
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          });    
		  
		  
		  	 $('#custom_channelp').click(function() {   
	 
	 
              $(".search-channel-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channelp-con'><input type='text' name='search_channel' id='search_channelp' class='form-control urate-form-input' value='' onkeyup='search_channelp()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channelp-con").remove();
                  $("#custom_channelp").after(searchElement);  
                  $("#search_channelp").focus();
              } else {
                  $(".search-channelp-con").remove();
              }
          });    
          
          /* TO HANDLE ALL CHANNEL*/
          /* IF ALL CHANNEL CHECKED THE ANY OTHER CHANNEL THAN ALL CHANNEL WILL BE UN-CHECKED*/
          $('.urate-custom-menu > li > a').on('click',function(){

			  
              if($(this).data('real') == "0"){
                  $('[data-for = "'+$(this).data('id')+'"]').each(function(){
                      $(this).removeClass('checked');
                  });
              }
              
              if($(this).data('real') != "0"){
                  $('[data-real = "0"]').parent().removeClass('checked');
              }
          });
          /* END - TO HANDLE ALL CHANNEL*/
	
	       $('#start_date').each(function() {
              $('#start_date').datepicker({
                  format: 'yyyy-mm-dd',
                  endDate: '0d',
                  defaultDate: new Date() ,
				    onSelect: function (date) {
						alert('aaa');
					} 
              }); 
              
              m = moment(new Date());              
			    $(this).val('<?php echo $first_day; ?>');
          });
		  
		  $('#end_date').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd',
                  endDate: '0d',
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
			    $(this).val('<?php echo $this_day; ?>');
          });
		  
		  	
	       $('#start_date2').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd',
                  endDate: '0d',
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val('<?php echo $first_day; ?>');
          });
		  
		  $('#end_date2').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd',
                  endDate: '0d',
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
			   $(this).val('<?php echo $this_day; ?>');
          });
	
	
	
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

          // Widget-4
		  
		  
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
    

  var config = {
	type: 'line',
	data: {
		labels: [<?php echo join($json_date, ',') ?>],
		datasets: [{
			label: "Spot",
			backgroundColor: window.chartColors.red,
			borderColor: window.chartColors.red,
			data: [
                <?php echo join($json_spot_date, ',') ?>
			],
			fill: false,
		}]
	},
	options: {
		responsive: true,
		tooltips: {
			mode: 'index',
			intersect: false,
		},
		hover: {
			mode: 'nearest',
			intersect: true
		},
		scales: {
			xAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Day'
				}
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Spot'
				}
			}]
		},
		legend: {
				display: false
		}
	}
};


});

$( document ).ready(function() {


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

	

	
	Highcharts.chart('container6', {
        title: {
            text: '',
            x: -20
        },

        xAxis: {
            categories: [<?php echo join($json_date, ',') ?>],
        },
        yAxis: {
            title: {
								text: '',
							   },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0 
        },
        series: [{
            name: 'Audience',
            data: [<?php echo join($json_spot_date, ',') ?>],
			color: "#FF0000"
        }]
    });
	
});



var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';
var data = '';
var program = '';
var audiencebychannel = <?php echo $audiencebychannel; ?>;


$(function () {	
var fieldas = $('#product_program').val();
var tgl2 = $('#tgl2').val();
var week2 = $('#week2').val();

var search_val = $( "input[aria-controls='example3']" ).val();


  var user_id = $.cookie(window.cookie_prefix + "user_id");

	
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
		"ajax": "<?php echo base_url().'Tvprogramun3tvv/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl2="+tgl2+"&week2="+week2+"&searchtxt="+search_val+"&check=True",
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }


	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
	});	


	audiencebar_view();
	audiencebar_view_t();

	
	$('#channel_day').on('click', function() {
	
			var periode = "<?php echo $tahunselected ?>";
		var form_data = new FormData();  
		var audiencebarday = $('#audiencebarday').val();
		var start_date2 = $('#start_date2').val();
		var end_date2 = $('#end_date2').val();
		var preset2 = $('#preset2').val();
		var channelp = $('#channelp').val();
		form_data.append('audiencebarday', audiencebarday);
		form_data.append('start_date', start_date2);
		form_data.append('end_date', end_date2);
		form_data.append('preset', preset2);
		form_data.append('channelp', channelp);
		form_data.append('periode',"<?php echo $tahunselected ?>");
		
			var listDate = [];
				var dateMove = new Date(start_date2);
				var strDate = start_date2;

				while (strDate < end_date2){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};

				if(listDate.length > 31){
					
					$('#errorm').modal('show');
					$('#body_error').html('<h5>Maximal Duration is 31 Days !!!! </h5>');
					throw '';
				}
				
				if(channelp == ''){
					
					channelp = "0";
					form_data.append('channelp', channelp);
				
				}
				
				
				$.ajax({
					url: "<?php echo base_url().'dailyviewersvod/filter_days_export'; ?>", 
					dataType: 'text',  
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(data){
						
						 $("#channel_export").attr("disabled", false);
						
						download_file('<?php echo $donwload_base; ?>tmp_doc/filter_days_export.xls','channel_by_day.xls');
											
					}, error: function(obj, response) {
						console.log('ajax list detail error:' + response);	
					} 
				});	
		
	
	});
		
	$('#channel_export').on('click', function() {
		
	
	  
	  $("#channel_export").attr("disabled", true);
	  
		if($('#fta_channel').is(':checked')){
		
			var check = "True";
		}else{
			var check = "False";
		
		}
	  
		var form_data = new FormData();  
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var week = $('#week1').val();
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var tipe_filter = $('#tipe_filter').val();
		var preset = $('#preset').val();
		var profile_chan = $('#profile_chan').val();
		var check = check;
		
		
		if(week == 'ALL'){
				var listDate = [];
				var dateMove = new Date(start_date);
				var strDate = start_date;

				while (strDate < end_date){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};
			
			}

			
				if(listDate.length > 31){
					
					$('#errorm').modal('show');
					$('#body_error').html('<h5>Maximal Duration is 31 Days !!!! </h5>');
					$("#channel_export").attr("disabled", false);
					throw '';
				}

		var filter = '';
			
		form_data.append('cond',filter);
		form_data.append('check', check);
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
		form_data.append('start_date', start_date);
		form_data.append('end_date', end_date);		
		form_data.append('tipe_filter', tipe_filter);
		form_data.append('profile', profile_chan);
		form_data.append('preset', preset);
	  
	  
		$.ajax({
			url: "<?php echo base_url().'dailyviewersvod/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				 $("#channel_export").attr("disabled", false);
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel.xls',type+'_by_channel.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
	$('#program_export').on('click', function() {
	  
	  	if($('#fta_program').is(':checked')){
		
			var check = "True";
		}else{
			var check = "False";
		
		}
	  
		var form_data = new FormData();  
		var type = $('#product_program').val();
		var field = "Program";
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var tgl = $('#tgl2').val();
		var tipe_filter = $('#tipe_filter_prog').val();
		
		
		var profile_prog = $('#profile_prog').val();
		var check = check;
		
		var filter = table3.search()
			
		var week = $('#week2').val();
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
		form_data.append('pilihprog', type);
		form_data.append('field', field);
		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('periode',"<?php echo $tahunselected ?>");
		form_data.append('profile', profile_prog);	
		form_data.append('tgl', tgl);
		form_data.append('check', check);
		form_data.append('tipe_filter', tipe_filter);
	  
	  
		$.ajax({
			url: "<?php echo base_url().'Tvprogramun3tvv/audiencebar_by_program_export'; ?>", 
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

function day_view_f(){
	
		
	
		var periode = "<?php echo $tahunselected ?>";
		var form_data = new FormData();  
		var audiencebarday = $('#audiencebarday').val();
		var start_date2 = $('#start_date2').val();
		var end_date2 = $('#end_date2').val();
		var preset2 = $('#preset2').val();
		var channelp = $('#channelp').val();
		form_data.append('audiencebarday', audiencebarday);
		form_data.append('start_date', start_date2);
		form_data.append('end_date', end_date2);
		form_data.append('preset', preset2);
		form_data.append('channelp', channelp);
		form_data.append('periode',"<?php echo $tahunselected ?>");
		
		 $("#loader_days").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
			
				var listDate = [];
				var dateMove = new Date(start_date2);
				var strDate = start_date2;

				while (strDate < end_date2){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};

				if(listDate.length > 31){
					
					$('#errorm').modal('show');
					$('#body_error').html('<h5>Maximal Duration is 31 Days !!!! </h5>');
					throw '';
				}
				
				if(channelp == ''){
					
					channelp = "0";
					form_data.append('channelp', channelp);
	
				}
				
		
		$.ajax({
			url: "<?php echo base_url().'dailyviewersvod/filter_days'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				
				if(channelp == "0"){
					
					 if(preset2 == "0"){
					
						if (audiencebarday == 'Viewers'){
							$('#judul_hari').html('<h4>Total Viewers By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
						}else if(audiencebarday == 'Duration'){
							$('#judul_hari').html('<h4>Duration By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
						}else{
							$('#judul_hari').html('<h4>Audience By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
						}
						
						obj = jQuery.parseJSON(data);
						
						
						
						Highcharts.chart('container6', {
							title: {
								text: '',
								x: -20 
							},

							xAxis: {
								categories: obj.json_date,
							},
							yAxis: {
							   title: {
								text: '',
							   },
								plotLines: [{
									value: 0,
									width: 1,
									color: '#FF0000'
								}]
							},
							tooltip: {
								
							},
							legend: {
								layout: 'vertical',
								align: 'center',
								verticalAlign: 'bottom',
								borderWidth: 0
							},
							series: [{
								name: audiencebarday,
								 data: obj.json_spot_date,
								color: "#FF0000"
							}]
						});
					
					 }else{
						 
						 	if (audiencebarday == 'Viewers'){
								$('#judul_hari').html('<h4>Total Viewers By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
							}else if(audiencebarday == 'Duration'){
								$('#judul_hari').html('<h4>Duration By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
							}else{
								$('#judul_hari').html('<h4>Audience By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
							}
							
							obj = jQuery.parseJSON(data);
							
							
							var data_d = obj.date;
							
							var column = [];
							for(i=0;i<data_d.length;i++){
								
								var array_val = [];
								for(il=0;il<listDate.length;il++){
									
									console.log(data_d[i][listDate[il]]); 
									if(typeof data_d[i][listDate[il]] == 'undefined'){
										array_val[il] = 0;
									}else{
										
										if(audiencebarday == 'Duration'){
											array_val[il] = parseFloat(data_d[i][listDate[il]]);
										}else{
											array_val[il] = parseInt(data_d[i][listDate[il]]);
										}
									}
									
									
								}
								
								
								column[i] = {name: data_d[i].CHANNEL, data: array_val,color: data_d[i].COLOR }
								
							}
							
							Highcharts.chart('container6', {
								title: {
									text: '',
									x: -20 
								},

								xAxis: {
									categories: obj.json_date,
								},
								yAxis: {
								   
									plotLines: [{
										value: 0,
										width: 1,
										color: '#808080'
									}]
								},
								tooltip: {
									
								},
								legend: {
									layout: 'vertical',
									align: 'right',
									verticalAlign: 'middle',
									borderWidth: 0
								},
								series: column
							});
						 
					 }
					
				}else{
				
				
					if (audiencebarday == 'Viewers'){
						$('#judul_hari').html('<h4>Total Viewers By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
					}else if(audiencebarday == 'Duration'){
						$('#judul_hari').html('<h4>Duration By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
					}else{
						$('#judul_hari').html('<h4>Audience By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
					}
					
					obj = jQuery.parseJSON(data);
					
					
					var data_d = obj.date;
					
					var column = [];
					for(i=0;i<data_d.length;i++){
						
						var array_val = [];
						for(il=0;il<listDate.length;il++){
							
							console.log(data_d[i][listDate[il]]); 
							if(typeof data_d[i][listDate[il]] == 'undefined'){
								array_val[il] = 0;
							}else{
								
								if(audiencebarday == 'Duration'){
									array_val[il] = parseFloat(data_d[i][listDate[il]]);
								}else{
									array_val[il] = parseInt(data_d[i][listDate[il]]);
								}
							}
							
							
						}
						
						
						column[i] = {name: data_d[i].CHANNEL, data: array_val,color: data_d[i].COLOR }
						
					}
					
					Highcharts.chart('container6', {
						title: {
							text: '',
							x: -20 //center
						},

						xAxis: {
							categories: obj.json_date,
						},
						yAxis: {
						   
							plotLines: [{
								value: 0,
								width: 1,
								color: '#FF0000'
							}]
						},
						tooltip: {
							
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: column
					});
				
				
				}
				$(".datatable-loading").remove();
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
		
	
	
	
}

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
			$('#table_program1').html('<table aria-describedby="mydesc"  id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
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
			
			var excelButton = $(".buttons-excel").detach();
			$(".buttonExcel").show();
			$(".buttonExcel").append( excelButton );   
		
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
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
		dataType: 'json',  // what to expect back from the PHP script, if anything
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
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
	
		var url = '<?php echo base_url(); ?>dailyviewersvod'; 
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		  
		 $("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
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
		url: "<?php echo base_url().'Tvprogramun3tvv/cost_by_program'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program1').html("");
			$('#table_program1').html('<table aria-describedby="mydesc"  id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

			console.log(obj);
			
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

function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Hide Filter');
	}

	$('#filter_panel_'+part).slideToggle(500);
	
}

function audiencebar_view_t(){
	
	
	var check = "True";
	
	
	var form_data = new FormData();  
	var type = $('#audiencebart').val();
	var tahun = $('#tahun').val();
	var bulan = "";
	var week = $('#week1').val();
	var start_date = $('#start_date2').val();
	var end_date = $('#end_date2').val();
	var tipe_filter = $('#tipe_filter').val();
	var preset = $('#preset2').val();
	var check = check;
	var profile_chan = $('#profile_chant').val();
	var channel = $('#channel').val().replace('&',' AND ');
	 var ch = []; 
	     /* HANDLE ALL CHANNEL */
          var channel_header = "";                                                                    
          if(channel == "0"){
              /* READ CHANNEL FROM AFTER CHOOSE GENRE */
              $('#custom_channel').next().children().each(function(){
                  if($(this).children().html() != "All Channel"){
                      channel_header += $(this).children().html()+",";
                  }
              })
              
              channel_header = channel_header.slice(0,-1);
          } else {
              channel_header = channel;
          }  
          
          channel_header = channel_header.split(",");
          for(var i=0; i < channel_header.length; i++){
              ch.push("'"+channel_header[i].replace('&',' AND ')+"'");
          }
	
	
			if(week == 'ALL'){
				var listDate = [];
				var dateMove = new Date(start_date);
				var strDate = start_date;

				while (strDate < end_date){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};
			
			}
			
				if(listDate.length > 31){
					
					$('#errorm').modal('show');
					$('#body_error').html('<h5>Maximal Duration is 31 Days !!!! </h5>');
					throw '';
				}

	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('channel', ch);
	form_data.append('week', week);
	form_data.append('check', check); 
	form_data.append('start_date', start_date);
	form_data.append('end_date', end_date);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
	form_data.append('preset', preset);
  
  $("#example42_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'dailyviewersvod/audiencebar_by_channel_t'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			obj = jQuery.parseJSON(data);
			
			if(week == 'ALL'){
				var listDate = [];
				var dateMove = new Date(start_date);
				var strDate = start_date;

				while (strDate < end_date){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};
			
			}else{
				
				var listDate = obj.day_dates;
				
			}
			
			$('#table_program22').html("");

			if(type == 'Viewers'){
				
				var tpe = 'Total Views';
				
			}else if(type == 'Duration'){
				var tpe = 'Duration ';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
			}else{
				
				var tpe = type;
			}
			
			var column = [];
			column[0] = { data: 'Rangking' };
			column[1] = { data: 'channel' };
			column[2] = { data: 'channel2' };
			
			var clmn = '<tr>';
			 
			var array_month_3 = ['0','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; 
			
			var i_d = 3;
			for(i=0;i<listDate.length;i++){
				
				var new_data_a = listDate[i].split("-");
				
				 clmn =  clmn+'<th >'+new_data_a['2']+'-'+array_month_3[parseInt(new_data_a['1'])]+'</th>';
				 
				 column[i_d] =  {data: listDate[i],"sClass": "right",render: function ( data, type, row ) {
				 return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))}
				 };
				 
				 i_d++;
				 
			}
			clmn =  clmn+'</tr>';
			
			$('#table_program22').html('<table aria-describedby="mydesc"  id="example42" class="table table-striped  example" style="width: 100%"><thead style="color:red"><tr><th rowspan = "2" >Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th rowspan = "2" >Title <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th rowspan = "2" >Category <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th colspan = "'+listDate.length+'">'+tpe+' </th></tr>'+clmn+'</thead></table>');
		
			

			console.log(obj);
			
			if(type == "Reach"){
				$('#example42').DataTable({
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
					data: obj.table,
					columns: column
				});	
			}else{
				$('#example42').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 10,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					
					"searching": true,
					data: obj.table,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					"scrollX": true,
					 fixedColumns:   {
						leftColumns: 3
					},
					columns: column
				});	
			}
			
			
			
		
		}
	});	
}

function audiencebar_view(){
	
	
	var check = "True";
	
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = "";
	var week = $('#week1').val();
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var tipe_filter = $('#tipe_filter').val();
	var preset = $('#preset').val();
	var check = check;
	var profile_chan = $('#profile_chan').val();
	var channel = $('#channel').val().replace('&',' AND ');
	 var ch = []; 
	     /* HANDLE ALL CHANNEL */
          var channel_header = "";                                                                    
          if(channel == "0"){
              /* READ CHANNEL FROM AFTER CHOOSE GENRE */
              $('#custom_channel').next().children().each(function(){
                  if($(this).children().html() != "All Channel"){
                      channel_header += $(this).children().html()+",";
                  }
              })
              
              channel_header = channel_header.slice(0,-1);
          } else {
              channel_header = channel;
          }  
          
          channel_header = channel_header.split(",");
          for(var i=0; i < channel_header.length; i++){
              ch.push("'"+channel_header[i].replace('&',' AND ')+"'");
          }
	
	
			if(week == 'ALL'){
				var listDate = [];
				var dateMove = new Date(start_date);
				var strDate = start_date;

				while (strDate < end_date){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};
			
			}
			
				if(listDate.length > 31){
					
					$('#errorm').modal('show');
					$('#body_error').html('<h5>Maximal Duration is 31 Days !!!! </h5>');
					throw '';
				}
				

	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('channel', ch);
	form_data.append('week', week);
	form_data.append('check', check); 
	form_data.append('start_date', start_date);
	form_data.append('end_date', end_date);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
	form_data.append('preset', preset);
  
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'dailyviewersvod/audiencebar_by_channel'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			obj = jQuery.parseJSON(data);
			
			if(week == 'ALL'){
				var listDate = [];
				var dateMove = new Date(start_date);
				var strDate = start_date;

				while (strDate < end_date){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};
			
			}else{
				
				var listDate = obj.day_dates;
				
			}
			
			$('#table_program2').html("");

			if(type == 'Viewers'){
				
				var tpe = 'Total Views';
				
			}else if(type == 'Duration'){
				var tpe = 'Duration ';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
			}else{
				
				var tpe = type;
			}
			
			var column = [];
			column[0] = { data: 'Rangking' };
			column[1] = { data: 'channel' };
			
			var clmn = '<tr>';
			 
			var array_month_3 = ['0','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; 
			
			var i_d = 2;
			for(i=0;i<listDate.length;i++){
				
				var new_data_a = listDate[i].split("-");
				
				 clmn =  clmn+'<th >'+new_data_a['2']+'-'+array_month_3[parseInt(new_data_a['1'])]+'</th>';
				 
				 column[i_d] =  {data: listDate[i],"sClass": "right",render: function ( data, type, row ) {
				 return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))}
				 };
				 
				 i_d++;
				 
			}
			clmn =  clmn+'</tr>';
			
			
			$('#table_program2').html('<table aria-describedby="mydesc"  id="example4" class="table table-striped  example" style="width: 100%"><thead style="color:red"><tr><th rowspan = "2" >Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th rowspan = "2" >Category <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th colspan = "'+listDate.length+'">'+tpe+' </th></tr>'+clmn+'</thead></table>');
		
			

			console.log(obj);
			
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
					data: obj.table,
					columns: column
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
					data: obj.table,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					"scrollX": true,
					 fixedColumns:   {
						leftColumns: 2
					},
					columns: column
				});	
			}
			
			
			
		
		}
	});	
}

function table2_view(){
	
	if($('#fta_program').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var tipe_filter_prog = $('#tipe_filter_prog').val();
	
	
	var bulan = $('#bulan').val();
	var tgl = $('#tgl2').val();
	var profile_prog = $('#profile_prog').val();
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('week', week);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	form_data.append('tgl', tgl);
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$('#table_program').html("");
	
	if(type == 'Viewers'){
		var tpe = 'Total Views';
	}else if(type == 'avgtotdur'){
		var tpe = 'Average Duration/Total Views';
	}else if(type == 'avgtotaud'){
		var tpe = 'Average Duration/Audience (%)';
	}
	else{
		var tpe = type;
	}

	if(type == 'avgtotaud'){
		$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}else{
		$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}
	
	
	
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
		"ajax": "<?php echo base_url().'Tvprogramun3tvv/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&tgl2="+tgl+"&week2="+week+"&check="+check+"&profile="+profile_prog+"&tipe_filter_prog="+tipe_filter_prog,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	});	
	
}


function table4_view(){
	
	if($('#fta_channel').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var tgl = $('#tgl2').val();
	var fta = check;
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
		url: "<?php echo base_url().'Tvprogramun3tvv/cost_by_program'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			

					$('#table_program').html('<table aria-describedby="mydesc"  id="example4" class="table table-striped example" style="color:black"><thead color:red><tr><th>Rank <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Category <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
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
		url: "<?php echo base_url().'Tvprogramun3tvv/daypart_view'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
		url: "<?php echo base_url().'Tvprogramun3tvv/day_view'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
					color: '#FF0000'
				}]
			};
			var tooltip= {
				
			};
			var legend= {
				layout: 'vertical',
				align: 'center',
				verticalAlign: 'botton',
				borderWidth: 0
			};
			var series= [{
				 name: type,
				 data:data_new,
				 color: "#FF0000"
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
		url: "<?php echo base_url().'Tvprogramun3tvv/ads_view'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
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

$( document ).ready(function() {

	var selPeriode = $('#tahun').val();
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;color:red;'>"+selPeriode+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;color:red;'>"+selPeriode+"<span>");
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