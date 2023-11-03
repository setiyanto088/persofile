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
	   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">  
    
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
		
		color: #cb3827;
		
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
                <li class="breadcrumb-item">Inhouse Report</li>
                <li class="breadcrumb-item active">Channel & Program</li>
            </ol>
            <h3 class="page-titles"><strong>Channel & Program</strong></h3>
          </div>
          <div class="col-md-7 text-right">
		  
			<h6 id="hs"></h6>
          </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row">
		
		<div class="col-lg-12">	
			
			<div class="col-lg-4">	
				<span id="laod"></span>
			</div>
			 
		</div>



        </div>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
             <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="navbar-left" style="padding-left:10px;">
                  <h4 class="title-periode1"><strong>Weekly Channel Growth</strong></h4>
                </div>	
				<div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button onClick="filter_panel('channel')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				<br>
                <div class="widget-content">
				
					<div class="col-lg-12 filter_panel" id="filter_panel_channel" style="display:none">	
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
							
							
							<div class="col-lg-3">
								<div class="form-group">
								<label>Data</label>	
									<select class="form-control" name="audiencebar" id="audiencebar" required >
										<option value="AUDIENCE" selected >Audience</option>
 										<option value="TOTAL_VIEWS" >Total Views</option>
										<option value="DURATION" >Duration</option>
									 
									</select>
								</div>
							</div>

						 </div>
						 <br>
						 <br>
					</div>
				
					
						 
				</div>
					<br/>
					<div class="col-lg-12">	
				
					<div class="col-lg-8">	
						 
					</div>
					
					</div>
					

 					<div id="table_program2" >
						<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th rowspan = "0"  scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th rowspan = "0"  scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<?php $k = 1; foreach($weekdt as $weekdts){ ?>
									<th  scope="row"><?php echo "Week ".$weekdts['WEEK_MONTH']." <br>".$weekdts['PER']; ?></th>
									<?php  $k++; } ?>
									<th rowspan = "0"  scope="row">Growth <?php echo 'W'.$weekdt[2]['WEEK_MONTH'].' Ke W'.$weekdt[3]['WEEK_MONTH']  ?> <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th rowspan = "0"  scope="row">% Growth <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>


							</thead>
						</table>
					</div> 
                   <canvas id="widget-spot-channel" height="100"></canvas>
              </div>
            </div>

          <br>
        
			    <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                  <div class="navbar-left" style="padding-left:10px;">
				  <h4 class="title-periode2"><strong>Audience By Channel</strong></h4>
                </div>
				<div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button onClick="filter_panel('channels')" class="button_white" id="filter_channels"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" onClick="chanel_export2()" id="export_channel42"><em class="fa fa-download"></em> &nbsp Export</button>
				</div>
				<br>
                <div class="widget-content">
					
					<div class="col-lg-12 filter_panel" id="filter_panel_channels" style="display:none">	
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view2()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						 
						  <div class="col-lg-12">
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Year</label>	
									 <select class="form-control" name="start_date42" id="start_date42" class="preset2" > 
										<option value="2023" selected >2023</option>	
										<option value="2022"  >2022</option>
										<option value="2021"  >2021</option>
										<option value="2020"  >2020</option>
										<option value="2019"  >2019</option>
										<option value="2018"  >2018</option>
										<option value="2017"  >2017</option>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Month</label>	
									<select class="form-control" name="end_date42" id="end_date42" class="preset2" >  
										<option value="All" Selected >All Month</option>
										<option value="01"  >January</option>
										<option value="02"  >February</option>
										<option value="03"  >March</option>
										<option value="04"  >April</option>
										<option value="05"  >May</option>
										<option value="06"  >June</option>
										<option value="07"  >July</option>
										<option value="08"  >August</option>
										<option value="09"  >September</option>
										<option value="10"  >October</option>
										<option value="11"  >November</option>
										<option value="12"  >December</option>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Data</label>	
									<select class="form-control" name="audiencebar2" id="audiencebar2" required >
										<option value="AUDIENCE" selected >Audience</option>
 										<option value="TOTAL_VIEWS" >Total Views</option>
										<option value="DURATION" >Duration</option>
										 
									</select> 
							
								</div>
							</div>
							
						  </div>
						 
					</div>
					
				</div>
					<br/>
					<div class="col-lg-12">	
				
					<div class="col-lg-8">	
						 
					</div>
					
					</div>
					
					
 					<div id="table_program42" >
						<table aria-describedby="table" id="example42" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th rowspan = "0"  scope="row">Rankss <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th rowspan = "0"  scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<?php $k = 1; foreach($monthdt as $monthdts){ ?>
									<th  scope="row"><?php echo $monthdts['PERIODE']; ?></th>
									<?php  $k++; } ?>
									<th rowspan = "0"  scope="row">Total<img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>


							</thead>
						</table>
					</div> 
                   <canvas id="widget-spot-channel" height="100"></canvas>
			  
            </div>
          </div>

		  <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="navbar-left" style="padding-left:10px;">
                  <h4 class="title-periode3"><strong>Audience by Program</strong></h4>
                </div>
				<div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button onClick="filter_panel('program')" class="button_white" id="filter_program"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id="program_export"><em class="fa fa-download"></em> &nbsp Export</button>
				</div>
                <div class="widget-content">
				
					<div class="col-lg-12 filter_panel" id="filter_panel_program" style="display:none">	
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="table2_view()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						 
						 <div class="col-lg-12">
						
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Year</label>	
									 <select class="form-control" name="start_date3" id="start_date3" class="preset2" >  
										 <option value="2023" selected >2023</option>
										<option value="2022"  >2022</option>
										<option value="2021"  >2021</option>
										<option value="2020"  >2020</option>
										<option value="2019"  >2019</option>
										<option value="2018"  >2018</option>
										<option value="2017"  >2017</option>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Month</label>	
									<select class="form-control" name="end_date3" id="end_date3" class="preset2" >  
										<option value="All" Selected >All Month</option>
										<option value="01"  >January</option>
										<option value="02"  >February</option>
										<option value="03"  >March</option>
										<option value="04"  >April</option>
										<option value="05"  >May</option>
										<option value="06"  >June</option>
										<option value="07"  >July</option>
										<option value="08"  >August</option>
										<option value="09"  >September</option>
										<option value="10"  >October</option>
										<option value="11"  >November</option>
										<option value="12"  >December</option>
									</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Data</label>	
									<select class="form-control" name="audiencebar3" id="audiencebar3" required >
										<option value="AUDIENCE" selected >Audience</option>
 										<option value="TOTAL_VIEWS" >Total Views</option>
										<option value="DURATION" >Duration</option>
										 
									</select> 
							
								</div>
							</div>

						 </div>
					</div>
				
					
					<div class="col-lg-12">	
					<div class="col-lg-2" style="" >
					 
					</div>

					</div>
					<div id="table_program">
						<table aria-describedby="table" id="example3" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Program <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<?php $k = 1; foreach($monthdt as $monthdts){ ?>
									<th  scope="row"><?php echo $monthdts['PERIODE']; ?></th>
									<?php  $k++; } ?>	
									<th rowspan = "0"  scope="row">Total<img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>									
								</tr>

							</thead>
						</table>
					</div>
                </div>
            </div>
          </div>
		  
	
            
             <!-- Modal Load Channel -->
	<div class="modal fade modalnewchannel" id="modalloadchannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Preset List</h4>
				</div>
				<div class="modal-body">
					 <div class="dataset col-md-5" style="z-index: 999;margin-bottom:150px">
						   <div class="dataset-title">
                              <p class="title-text">TV Channel</p>
 
                          </div>
							<div class="select-wrapper" style="margin-top:-10px">
                              <select class="urate-select grid-menu" name="channel" id="channel" title="Please Choose a Channel ..." required>
                                  <option value="0" >All Channel</option>
                                  <?php foreach($channel as $key) { ?>
                                  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
                                  <?php } ?> 
                              </select>
							</div> 
						  </div> 
					
					<div class="dataset col-md-4" style="">
						   <div class="dataset-title">
                              <p class="title-text">Preset Name</p>
							 
                          </div>
							<div class="select-wrapper" style="margin-top:-10px">
                              <input style="color: #cb3827" type='text' class="form-control urate-form-input" name="save_channel_name" id="save_channel_name" title="" required>
							</div> 
							
							<br>
							 
							<div class="select-wrapper" style="margin-top:0px">
							</div>
							
							 <br>
							 
							 <button type="button" class="btn urate-btn" onClick="save_channel_list()">Save</button>
							 
					</div> 	
 
							 
					
					<form action="" class="row">
						<div class="form-group col-md-12">
							<table aria-describedby="table" id="example9" class="table table-striped table-bordered example" style="width: 100%">
							<thead>
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
          <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					
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
			var token = $.cookie(window.cookie_prefix + "token");
			
 			
			   var form_data = {
				  sess_user_id     : user_id,
				  sess_token      : token,
				  save_channel_name	 :  $('#preset_name_del').val()
			  };       
			
			
 			  $.ajax({
				  url : "<?php echo base_url().'tvprogramun3tvsea/delete_channels'?>",
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
			var token = $.cookie(window.cookie_prefix + "token");
			
 			
			   var form_data = {
				  sess_user_id     : user_id,
				  sess_token      : token,
				  save_channel_name	 : save_channel_name,
				  channel     : channel
			  };       
			
			
 			  $.ajax({
				  url : "<?php echo base_url().'tvprogramun3tvsea/save_channels'?>",
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
				  url : "<?php echo base_url().'tvprogramun3tvsea/load_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
					  //console.log(response);
					  
					  var html = '';
					  var no = 1;
					  for(var i = 0;i < response.length; i++){
						  
							html += '<tr>';
							html += '		<td>'+no+' </td>';
							html += '		<td>'+response[i].CHANNEL_NAME+'</td>';
							html += '		<td>'+response[i].CHANNEL_LIST+'</td>';
 							html += '		<td><button type="button" class="btn urate-btn" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\' , \''+response[i].CHANNEL_NAME+'\')">Edit</button><button type="button" class="btn urate-btn" onClick="delete_conf(\''+response[i].CHANNEL_NAME+'\')">Delete</button></td>';
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
        var chnn = $('#channel').val();
        var query = "";
        
 		console.log(chnn);
		
        if($('#search_channel').val() != undefined){
            query = $('#search_channel').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "";
        
         
            strVar = "<li data-for='channel'><a href='#' data-real='0' data-id='channel'>All Channel</a></li>";
        
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvprogramun3tvsea/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
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
                    
                     strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two checked' data-for='channel'>"+strResult+"</a></li>";                          
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
              
			  var chnns = chnn.split(',');
              
			   for (var i = 0; i < chnns.length; i++) {
				   $('[data-real = "'+chnns[i]+'"]').parent().addClass('checked');
                    $text += '<span class="menu-item">'+chnns[i]+'</span>'
                  }
				  
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
             } 
        }); 
    }

function selectAll(){
	
	var tahun = $('#tahun').val();
	var tpe_f = $('#tpe_f').val();
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	form_data.append('tahun', tahun);	
	form_data.append('tpe_f', tpe_f);
	
	$("#laod").append(' <img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3tvsea/header_change'; ?>", 
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
    var token = $.cookie(window.cookie_prefix + "token");   
	
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
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$('#table_program').html("");
	
	if(type == 'Viewers'){
		var tpe = 'Total Views';
	}else if(type == 'avgtotdur'){
		var tpe = 'Average Duration/Total Views';
	}else{
		var tpe = type;
	}
				
	$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	
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
		"ajax": "<?php echo base_url().'tvprogramun3tvsea/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&tgl2="+tgl+"&week2="+week+"&check="+check+"&tipe_filter_prog="+tipe_filter_prog,
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
   
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3tvsea/audiencebar_by_channel'; ?>", 
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
					$('#table_program2').html('<table aria-describedby="table" id="example4" class="table table-striped example" style="color:red"><thead><tr><th>Rank<img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
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

	 
	
});



var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';
var data = '';
var program = ''; 
var audiencebychannel = <?php echo $audiencebychannel; ?>;
var audiencebychannel2 = <?php echo $audiencebychannel2; ?>;


$(function () {	
var fieldas = $('#audiencebar3').val();
var tgl2 = $('#start_date3').val();
var week2 = $('#end_date3').val();

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
		"ajax": "<?php echo base_url().'tvprogramun3tvsea/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl2="+tgl2+"&week2="+week2+"&searchtxt="+search_val+"&check=True",
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
		'iDisplayLength': 11,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		data: audiencebychannel,
		"searching": true,
		"language": { 
            "decimal": ",",
            "thousands": "."
        },
		"scrollX": true,
		 fixedColumns:   {
            leftColumns: 2
        },
		columns: [
			{ data: 'Rangking' },
			{ data: 'channel' },
			<?php $sd = 1; foreach($weekdt as $weekdtss){ ?>
			{ data: 'w<?php echo $sd; ?>' ,"sClass": "right" },
			<?php $sd++; } ?>
			{ data: 'growth' ,"sClass": "right"},
			{ data: 'pros' ,"sClass": "right"}
			

		]
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});	
	
	
	var table42 = $('#example42').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		data: audiencebychannel2,
		"searching": true,
		"language": { 
            "decimal": ",",
            "thousands": "."
        },
		"scrollX": true,
		 fixedColumns:   {
            leftColumns: 2
        },
		columns: [
			{ data: 'Rangking' },
			{ data: 'channel' },
			<?php $sd = 1; foreach($monthdt as $monthdtss){ ?>
			{ data: 'V<?php echo $sd; ?>' ,"sClass": "right" },
			<?php $sd++; } ?>
			{ data: 'TOTAL' ,"sClass": "right"}
			

		]
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});
	
	$('#channel_export').on('click', function() {
	 
	  
	  $("#channel_export").attr("disabled", true);
	  
		var check = "True";
	  
		var form_data = new FormData();  
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = "";
 		var week = "";
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var tipe_filter = 'live';
		var preset ="0";
		var check = check;
		var profile_chan = "0";
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
		
		
 					var listDate = [];
					var dateMove = new Date(start_date);
					var strDate = start_date;

					while (strDate < end_date){
					  var strDate = dateMove.toISOString().slice(0,10);
					  listDate.push(strDate);
					  dateMove.setDate(dateMove.getDate()+1);
					};
				
 				
					if(listDate.length > 61){
						
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
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3tvsea/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',   
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				 $("#channel_export").attr("disabled", false);
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel_growth.xls','audience_by_channel_growth.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
	$('#program_export').on('click', function() {
 		$("#program_export").attr("disabled", true);
		
		var check = "True";
	  
		var form_data = new FormData();  
			var type = $('#audiencebar3').val();
	var preset3 = $('#preset3').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var tipe_filter_prog = $('#tipe_filter3').val();
	
 	
	var bulan = $('#bulan').val();
	var tgl = $('#start_date3').val();
	var profile_prog = $('#profile_chan3').val(); 
	var week = $('#end_date3').val();
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('check', check);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('week', week); 
	form_data.append('type', type);
	form_data.append('preset', preset3);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	form_data.append('tgl', tgl);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3tvsea/audiencebar_by_program_export'; ?>", 
			dataType: 'text',   
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_program.xls','Audience_by_program.xls');
				$("#program_export").attr("disabled", false);
									
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
		
		 $("#loader_days").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
			
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
			url: "<?php echo base_url().'tvprogramun3tvsea/filter_days'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
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
							series: [{
								name: audiencebarday,
								 data: obj.json_spot_date,
								color: "#4a4d54"
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
									x: -20 //center
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
		dataType: 'json',  // what to expect back from the PHP script, if anything
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
	
		var url = '<?php echo base_url(); ?>tvprogramun3tvsea'; 
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
		url: "<?php echo base_url().'tvprogramun3tvsea/cost_by_program'; ?>", 
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

function chanel_export2(){
	
	
	$("#export_channel42").attr("disabled", true);
 	
	var check = "True";
	
	
	var form_data = new FormData();  
	var type = $('#audiencebar2').val();
	var tahun = $('#tahun').val();
	var bulan = "";
 	var week = "";
	var start_date = $('#start_date42').val();
	var end_date = $('#end_date42').val();
	var tipe_filter = "live";
	var preset = "0";
	var check = check;
	var profile_chan = "0";
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
 

	$.ajax({
			url: "<?php echo base_url().'tvprogramun3tvsea/audiencebar_by_channel_export2'; ?>", 
			dataType: 'text',   
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				 $("#export_channel42").attr("disabled", false);
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel.xls','audience_by_channel.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
}


function audiencebar_view2(){
	
 	
	var check = "True";
	
	
	var form_data = new FormData();  
	var type = $('#audiencebar2').val();
	var tahun = $('#tahun').val();
	var bulan = "";
 	var week = "";
	var start_date = $('#start_date42').val();
	var end_date = $('#end_date42').val();
	var tipe_filter = 'live';
	var preset = '0';
	var check = check;
	var profile_chan = $('#profile_chan2').val();
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
   
  $("#example42_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 750px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading2" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3tvsea/audiencebar_by_channel42'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			obj = jQuery.parseJSON(data);
			
 			
			$('#table_program42').html("");

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
			
			var array_month_3 = ['0','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; 
			
			if(end_date == 'All'){
			
				var column = [];
				column[0] = { data: 'Rangking' };
				column[1] = { data: 'channel' };
 
				var i_d = 2;
				for(i=1;i<=obj['monthdt'].length;i++){
					
									 
					 column[i_d] =  {data: "V"+i,"sClass": "right" };
					 
					 i_d++;
					 
				}
				column[i_d] = { data: 'TOTAL',"sClass": "right" };
				
			 
				$('#table_program42').html(obj['table']);
			
				

 				
				if(type == "Reach"){
					$('#example42').DataTable({
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 110,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						"searching": true,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj['data'],
						columns: column
					});	
				}else{
					$('#example42').DataTable({
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 110,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						
						"searching": true,
						data: obj['data'], 
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
			
			}else{
				
				$('#table_program42').html("");
				
				var column = [];
				column[0] = { data: 'Rangking' }; 

				var i_d = 1;
				for(i=1;i<=obj['monthdt'].length;i++){
					
					 column[i_d] =  {data: "channel"+i };
					 i_d++;				 
					 column[i_d] =  {data: "w"+i,"sClass": "right" };
					 i_d++;
					 
				}
			 
				$('#table_program42').html(obj['table']);
			
				  
					$('#example42').DataTable({
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 11,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						
						"searching": true,
						data: obj['data'], 
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						"scrollX": true,
						 
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
 	var week = "";
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
 	var tipe_filter = "live";
 	var preset = 0;
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
	
 				var listDate = [];
				var dateMove = new Date(start_date);
				var strDate = start_date;

				while (strDate < end_date){
				  var strDate = dateMove.toISOString().slice(0,10);
				  listDate.push(strDate);
				  dateMove.setDate(dateMove.getDate()+1);
				};
			
 			
				if(listDate.length > 61){
					
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
   
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3tvsea/audiencebar_by_channel'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			obj = jQuery.parseJSON(data);
			
 			
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
 			
			 
			var array_month_3 = ['0','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; 
			
			var i_d = 2;
			for(i=1;i<=obj['weekdt'].length;i++){
				
								 
				 column[i_d] =  {data: "w"+i,"sClass": "right" };
				 
				 i_d++;
				 
			}
			column[i_d] = { data: 'growth',"sClass": "right" };
			column[i_d+1] = { data: 'pros',"sClass": "right" };
			
			$('#table_program2').html(obj['table']);
		
 
			
			if(type == "Reach"){
				$('#example4').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 11,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					"searching": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: obj['data'],
					columns: column
				});	
			}else{
				$('#example4').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 11,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					
					"searching": true,
					data: obj['data'], 
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
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	var type = $('#audiencebar3').val();
	var preset3 = $('#preset3').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var tipe_filter_prog = $('#tipe_filter3').val();
	
 	
	var bulan = $('#bulan').val();
	var tgl = $('#start_date3').val();
	var profile_prog = $('#profile_prog').val(); 
	var week = $('#end_date3').val();
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('week', week);
 	form_data.append('type', type);
	form_data.append('preset', preset3);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	form_data.append('tgl', tgl);
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	
		
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3tvsea/get_header_tbl'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
	 
			
			$('#table_program').html("");
			 
			if(type == 'avgtotaud'){
				$('#table_program').html(data['table']);
			}else{
				$('#table_program').html(data['table']);
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
				"ajax": "<?php echo base_url().'tvprogramun3tvsea/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&tgl2="+tgl+"&week2="+week+"&check="+check+"&profile="+profile_prog+"&tipe_filter_prog="+tipe_filter_prog+"&preset="+preset3,
				"searching": true,
				"language": {
					"decimal": ",",
					"thousands": "."
				}
			});	
			
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
		url: "<?php echo base_url().'tvprogramun3tvsea/cost_by_program'; ?>", 
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
		url: "<?php echo base_url().'tvprogramun3tvsea/daypart_view'; ?>", 
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
		url: "<?php echo base_url().'tvprogramun3tvsea/day_view'; ?>", 
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
		url: "<?php echo base_url().'tvprogramun3tvsea/ads_view'; ?>", 
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

$( document ).ready(function() {
   
	
	var selPeriode = $('#tahun').val();
    
    
	
});

function show(){
	$('#hs').html('*check widget first before export');
}               

$(document).ready(function(){
	
	audiencebar_view2();
	
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