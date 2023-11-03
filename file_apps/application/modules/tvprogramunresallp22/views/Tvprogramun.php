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
    
	<!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Timepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.js"></script> 
  
  	<link rel="stylesheet" href="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.css">
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
	#container{
			width: 100%;
	}
	  .timepicker{
      text-align: left;
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
                 <li class="breadcrumb-item active">TV Program Dashboard</li>
            </ol>
            <h4 class="page-title"><strong>TV Program Dashboard</strong></h4>
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
			
			<div class="col-lg-2">	
				<select class="form-control" name="survey" id="survey" required onChange="viewall()">
					<option value='2021' <?php if($survey_data == '2021'){ echo 'selected'; } ?>>Survey 2021</option>
					<option value='2022' <?php if($survey_data == '2022'){ echo 'selected'; } ?>>Survey 2022</option>
				</select>
			</div>
			
			<div class="col-lg-6">	
				<hr />
			</div>
			 
		</div>
		<br/>
		<br/>
		<br/>
		<br/>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:52px" >
                <img src="<?php echo $path9;?>images/Frame123.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Number of Respondent</span>
                <span class="value"><?php echo $no_respondent; ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:52px" >
                <img src="<?php echo $path9;?>images/Frame1232.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Active Respondent</span>
                <span class="value"><?php echo number_format(intval($aa),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:52px" >
                <img src="<?php echo $path9;?>images/Frame1233.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Active Audience</span>
                <span class="value"><?php echo number_format(intval($aa2),0,',','.'); ?>
                
                </span>
              </div>
            </div>
          </div>
		  
		  <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:52px" >
                <img src="<?php echo $path9;?>images/Frame1234.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Universe</span>
                <span class="value"><?php echo number_format(intval($totpopulasi_a[0]["tot_pop"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>
		  
        </div>
		
		  
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
         <div id="" class="row">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">Audience by Channel</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('channel')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
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
									<label>Profile</label>
							<select class="form-control" name="profile_chan" id="profile_chan"  >
								<option value="<?php echo $id_profile_all; ?>" selected >All People</option>
								<?php foreach($profile as $prfs){
									
									echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
								} ?>
							</select> 
							</div>
							</div>
							
							<div class="col-lg-3" style="">
							  <div class="dataset-title">
								<div class="col-md-6" style="margin-left:-10px">
									<label>Day Part</label> 
								</div>
								<div class="col-md-6 text-right" style="margin-right:10px">
								  <a href="#" data-toggle="modal" data-target="#modalNewTimeOLD" id="dptriger" style="color:red"><span class="ion-plus"></span> New</a>
								</div>
							  </div>
							  <div class="select-wrapper">
								  <select class='form-control urate-select ' name="daypart" id="daypart" title='Please Choose Time Schedule ...'>
									  <option value="ALL" selected >All Days</option>
									 <?php foreach($dayparts as $key) { ?>
									  <option value="<?php echo $key['DPART']; ?>" ><?php echo $key['DPART']; ?></option>
									  <?php } ?>
								  </select>
							  </div>
						    </div> 
							
							
						</div>
						
					</div>
					<br>				
					<br>				
					<input type="hidden" id="search_ps4" name="search_ps4" />
					<input type="hidden" id="order_ps4" name="order_ps4" />
					<div class="" style="margin-bottom:-20px" ><input type="checkbox" value="fta" id="fta_channel" checked='checked' onclick="channel_change();">Include FTA</label></div>
					<div id="table_program2">
						<table id="example4" aria-describedby="Table Result" class="table table-striped" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Rank</th>
									<th scope="row">Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>

							</thead>
						</table>
					</div>
                   <canvas id="widget-spot-channel" height="100"></canvas>
                </div>
            </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Audience by Program</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('program')" class="button_white" id="filter_program"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='program_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
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
									<label>Profile</label>
							<select class="form-control" name="profile_prog" id="profile_prog"  >
								<option value="<?php echo $id_profile_all; ?>" selected >All People</option>
								<?php foreach($profile as $prfs){
									
									echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
								} ?>
							</select> 
							</div>
							</div>
							
							
						</div>
						
					</div>
					<br>				
					<br>
				
					
					<div class="col-lg-12" style="margin-bottom:-20px">	
						<div class="col-lg-6" style="" >
						<input type="checkbox" value="fta" id="fta_program" onclick="program_change();">Include Begin Time</label> 
						<input type="checkbox" value="fta" id="fta_program_2" checked='checked' onclick="program_change();">Include FTA</label>
						</div>
						<div class="col-lg-2">
						 
						</div>
					</div>
					
					<input type="hidden" id="search_ps" name="search_ps" />
					<input type="hidden" id="order_ps" name="order_ps" />
					<div id="table_program">
						<table id="example3" class="table table-striped " style="width: 100%" aria-describedby="Table Result 2" >
							<thead style="color:red">
								<tr>
									<th scope="row">Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"  alt="arrow"></th>
									<th scope="row">Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
													</tr>

							</thead>
						</table>
					</div>
                </div>
            </div>
          </div>
          
          <div class="grid-stack-item row" data-gs-min-width="3" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="3" data-gs-height="2" data-gs-auto-position="1">
			<div class="col-md-3" >	
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                 <div class="navbar-left" >
                  <h4 style="font-weight:bold">Audience by Time</h4>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-time" style="margin-top: -15px;"></canvas>
                </div>
            </div>
          </div>
		  <div class="col-md-9" >	
		    <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="navbar-left">
                  <h4 class="title-periode3" ><strong>Audience by Daypart</strong></h4>
                </div>
                <div class="navbar-right">
					<div style="margin-left:-150px">
						<button class="button_black" id='custom_time' data-toggle="modal" data-target="#modalNewTime"><em class="fa fa-align-left"></em> &nbsp Update</button>
					</div>
                </div>
                <div class="widget-content">
                    <div id="container5"></div>                  
                </div>
            </div>
           </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="12" data-gs-min-height="2" data-gs-x="12" data-gs-y="12" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
			   <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode4" style="font-weight: bold;">Respondent by Day</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('day')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
					</div>
				</div>
					<div class="col-lg-12 filter_panel" id="filter_panel_day" style="display:none">	
					
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="day_filter()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						<div class="col-lg-12">	

							<div class="col-lg-3">	
								<div class="form-group">
									<label>Start date period</label>	
									 <input type="text" class="form-control" name="start_date_d" id="start_date_d" placeholder="From ..." value="">
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>End date period</label>	
									<input type="text" class="form-control" name="end_date_d" id="end_date_d" placeholder="To ..." value="">
								</div>
							</div>
						
							<div class="col-lg-3">
								<div class="form-group">
										<label>Channel</label>
									<select class="form-control" name="channel_ds" id="channel_ds"  >
							<option value="ALL" selected >All Channel</option>
							<?php foreach($channel_list as $channel_lists){ 
								
								echo '<option value="'.$channel_lists['CHANNEL'].'" >'.$channel_lists['CHANNEL'].'</option>';
								
							} ?>
						</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Data</label>	
										<select class="form-control" name="audiencebar_2" id="audiencebar_2" required >
											<option value="AUDIENCE" selected >Audience</option>
											<option value="VIEWERS" >Viewers</option>
										 
										</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Interval</label>	
										<select class="form-control" name="interval" id="interval" required >
											<option value="day" selected >By Days</option>
											 
										</select> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Respondent</label>	
										<select class="form-control" name="respondent" id="respondent" required >
											<option value="RESP" selected >Respondent</option>
 											<option value="VIEWERS2" >Population</option>
											 
										</select> 
								</div>
							</div>
							
						</div>
						
					</div>
			  
			  		
					<br><br> 
				 

                <div class="widget-content">
                  <div id="container6"></div>
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
                  <h4>Respondent By Day</h4>
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
  
  	<div class="modal fade modalDaypart" id="modalNewTimeOLD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Create Day Part</h4>
				</div>
				<div class="modal-body">
					<form action="" class="row">
						<div class="form-group col-md-6">
							<label for="">From</label>
							<input type="text" class="form-control urate-form-input daypart" name="from" id="from" placeholder="00:00" maxlength="5">
						</div>
						<div class="form-group col-md-6">
							<label for="">To</label>
							<input type="text" class="form-control urate-form-input daypart" name="to" id="to" placeholder="00:00" maxlength="5">
						</div>
					</form>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" alt="loader" id="loaderdp" style="display: none;">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn daypart_create" onClick="create_daypart()">Create</button>
				</div>
			</div>
		</div>
	</div>
  
  <div class="modal fade modalDaypart" id="modalNewTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Audience by Day Part</strong></h4>
				</div>
				<div class="modal-body">
					<hr>
					<div class="row">
						<div class="col-lg-12">	
							<h4>Create New Daypart</h4>
							<form action="" class="row">
								<div class="form-group col-md-4">
									<label for="">From</label>
									<input type="text" class="form-control urate-form-input daypart" name="from" id="from" placeholder="00:00" maxlength="5">
								</div>
								<div class="form-group col-md-4">
									<label for="">To</label>
									<input type="text" class="form-control urate-form-input daypart" name="to" id="to" placeholder="00:00" maxlength="5">
								</div>
								<div class="form-group col-md-4">
									<em id="load_save" style="display:none" class="fa fa-spinner fa-spin fa-2x fa-fw"></em>
									<label for="">  </label>
									<button style="margin-top:27px" type="button" id="save_dp" class="button_white" onClick="save_daypart()"><em class="fa fa-check"></em>&nbsp Save</button>
								</div>
							</form>
						</div>
						<div class="col-lg-12">
							
							<p id="msg_note" style="color:green"> &nbsp </p>
						
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg-12">	
							<table id="exampless" class="table table-striped " style="width: 100%" aria-describedby="Table Daypart">
								<thead style="color:red">
									<tr>
										<th scope="col">>Daypart </th>
										<th scope="col">>Action </th>
									</tr>
								</thead>
								<tbody>
								
								<?php $tr = 1; foreach($daypart_list as $daypart_lists){ ?>
								
									<tr>
										<td> 
											<select class="form-control" name="dplist_<?php echo $tr; ?>" id="dplist_<?php echo $tr; ?>"  >
												<?php foreach($daypart_list_all as $dpall){
													IF($dpall['TEXT'] == $daypart_lists['TEXT']){
														echo '<option value='.str_replace(" ","",$dpall['TEXT']).' selected="selected" >'.$dpall['TEXT'].'</option>';
													}ELSE{
														echo '<option value='.str_replace(" ","",$dpall['TEXT']).'  >'.$dpall['TEXT'].'</option>';
													}
												} ?>
											</select>  
										</td>
										<td> 
										<?php 
										
										echo '<input type="hidden" value="1" id="vis_val_'.$tr.'" />';
										
										if($daypart_lists['STS'] == 1){
											echo '<div id="btn_vs_'.$tr.'" ><button type="button" id="btn_con_'.$tr.'" class="button_black" onClick="change_vis('.$tr.',0)"><i class="fa fa-times"></i>&nbsp Hide</button></div>';
										}else{
											echo '<div id="btn_vs_'.$tr.'" ><button type="button" id="btn_con_'.$tr.'" class="button_white" onClick="change_vis('.$tr.',1)"><i class="fa fa-check"></i>&nbsp Show</button></div>';
										}
										
										?> 
										
										</td>
									</tr>
								
								<?php $tr++; } ?>								
								
								</tbody>
							</table>
						</div>
					</div>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" alt="loader" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em>&nbsp Cancel</button>
					<button type="button" class="button_black" onClick="apply_daypart()"><em class="fa fa-check"></em>&nbsp Apply</button>
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

  <!-- script type="text/javascript" src="<?php //echo $path;?>assets/js/chart.js"></script -->
  <script src="<?php echo $path;?>assets/js/table.js"></script>

<!-- highcharts -->
<script src="<?php echo $pathx;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $pathx;?>assets/ext/exporting.js"></script>
<script src="<?php echo $pathx;?>assets/ext/offline-exporting.js"></script>
	 
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

 function create_daypart(){       
        $(".modal .modal-footer button").hide();           
        $('#loaderdp').show();
                
        var from = $('#from').val();
        var to = $('#to').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token");
        
        var dpart_list = ""; 
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvcc/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
 				dpart_list += '<li data-for="daypart"><a href="#" data-real="ALL" data-id="daypart">ALL DAYS</a></li>';
                for(i=0; i < response.length; i++){
                    dpart_list += '<li data-for="daypart"><a href="#" data-real="'+response[i].DPART+'" data-id="daypart">'+response[i].DPART+'</a></li>';
                }
                
                $("#custom_daypart").next().html(dpart_list);
                
                $("#modalNewTimeOLD").modal('toggle');                      
          
                $('[data-for="daypart"]').on('click',function(){
                     $('#custom_daypart').html($(this).children().data('real'));
                    $(this).closest('.urate-select-dropdown').find('.hidden-element-for-dropdown').attr('value', $(this).children().data('real'));
                });
				
				 $('#loaderdp').hide();
				 $(".modal .modal-footer button").show();
				 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        });
    }

function program_change(){
	
	if($('#fta_program').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False"; 
	
	}	
	
	if($('#fta_program_2').is(':checked')){
		
		var check2 = "True";
	}else{
		var check2 = "False";  
	
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var channel_prog = $('#channel_prog').val();
	var tipe_filter_prog = "live";
	var survey_data = $('#survey').val();
	
 	
	var bulan = $('#bulan').val();
	var start_date2 = $('#start_date2').val();
	var end_date2 = $('#end_date2').val();
	var profile_prog = $('#profile_prog').val(); 
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('channel', channel_prog);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('end_date2', end_date2);
 	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$('#table_program').html("");
	
	if(type == 'Viewers'){
		var tpe = 'Total Views';
	}else if(type == 'avgtotdur'){
		var tpe = 'Average Duration/Total Views';
	}else if(type == 'avgtotaud'){
		var tpe = 'Average Duration/Audience (%)';
	}else if(type == 'TVR'){
		var tpe = "TVR IH";
		var tpe2 = "TVR ALL";
	}else if(type == 'TVS'){
		var tpe = "TVS IH";
		var tpe2 = "TVS ALL";
	}else if(type == 'IDX'){
		var tpe = "INDEX IH";
		var tpe2 = "INDEX ALL";
	}else if(type == 'Audience2'){
		var tpe = "Audience IH";
		var tpe2 = "Audience ALL";
	}else if(type == 'Reach'){
		var tpe = "Reach IH";
		var tpe2 = "Reach ALL";
	}else{
		var tpe = "'000s IH";
		var tpe2 = "'000s ALL";
	}
				
	if(type == 'avgtotaud'){
		$('#table_program').html('<table id="example3" class="table table-striped" style="color:black"><thead style="color:red"><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}else{
		$('#table_program').html('<table id="example3" class="table table-striped" style="width: 100%"><thead style="color:red"><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
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
		"ajax": "<?php echo base_url().'tvprogramunresallp22/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&start_date2="+start_date2+"&end_date2="+end_date2+"&check="+check+"&check2="+check2+"&channel="+channel_prog+"&profile="+profile_prog+"&survey_data="+survey_data+"&tipe_filter_prog="+tipe_filter_prog,
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
	var bulan = $('#bulan').val();
	var survey = $('#survey').val(); 
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var tipe_filter = "live";
	var check = check;
	var profile_chan = $('#profile_chan').val();
	var dayparts = $('#daypart').val();
 	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('survey', survey);
	form_data.append('start_date', start_date);
	form_data.append('check', check);
	form_data.append('end_date', end_date);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
	form_data.append('dayparts', dayparts);
   
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramunresallp22/audiencebar_by_channel'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			 
			$('#table_program2').html("");
			 
			
			if(type == 'Viewers'){
				
				var tpe = "'000s IH";
				var tpe2 = "'000s ALL";
				
			}else if(type == 'audience2'){
				var tpe = "Audience IH";
				var tpe2 = "Audience ALL";
			}else if(type == 'Reach'){
				var tpe = "Reach IH";
				var tpe2 = "Reach ALL";
			}else if(type == 'tvr'){
				var tpe = "TVR IH";
				var tpe2 = "TVR ALL";
			}else if(type == 'tvs'){
				var tpe = "TVS IH";
				var tpe2 = "TVS ALL";
			}else if(type == 'idx'){
				var tpe = "INDEX IH";
				var tpe2 = "INDEX ALL";
			}else if(type == 'Duration'){
				var tpe = 'Duration ';
				var tpe2 = 'Duration ';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
				var tpe2 = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
				var tpe2 = 'Audience Share';
			}else{
				
				var tpe = "'000s IH";
				var tpe2 = "'000s ALL";
			}
						$('#table_program2').html('<table id="example4" class="table table-striped " style="width: 100%"><thead style="color:red"><tr><th>Rank</th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);

 			
			if(type == "Reachss"){
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
						},
						{ data: 'Spot2' ,"sClass": "right",render: function ( data, type, row ) {
							return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								 
							}
						}
					]
				});	
			}else{
			var table4 = $('#example4').DataTable({
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
						{ data: 'AUDIENCE' ,"sClass": "right"},
						{ data: 'VIEWERS' ,"sClass": "right"},
						{ data: 'TVR' ,"sClass": "right"},
						{ data: 'TVS' ,"sClass": "right"},
						{ data: 'INDEX' ,"sClass": "right"},
						{ data: 'REACH' ,"sClass": "right"}
					]
				}).on('order.dt search.dt', function() {
				  var input = $('.dataTables_filter input')[0];
				  
				   table4.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
						cell.innerHTML = i+1; 
					} );
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


function save_daypart(){
	
	$("#load_save").show();
	$("#save_dp").hide();
	
	var from = $("#from").val();
	var to = $("#to").val();
	
	var new_time = from+' - '+to ;
	
	var form_data = new FormData();
	form_data.append('new_time', new_time);
	form_data.append('from', from);
	form_data.append('to', to);
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramunresallp22/save_daypart'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
				for(var i=1;i<7;i++){
					$('#dplist_'+i).append('<option value="'+new_time+'">'+new_time+'</option>');
				}
				
				$("#load_save").hide();
				$("#save_dp").show();
				$("#msg_note").html("Successfull Save Daypart");
				
				function myMessage() {
				  $("#msg_note").html(" &nbsp ");
				}
				
				setTimeout(myMessage, 3000);
							
		}
	});	
		
}

function change_vis(idx,cond){
	
	 
	
	if(cond == 0){
		$("#vis_val_"+idx).val('0');
		$("#btn_vs_"+idx).html('<button type="button" id="btn_con_'+idx+'" class="button_white" onClick="change_vis('+idx+',1)"><i class="fa fa-check"></i>&nbsp Show</button>');
	}else{
		$("#vis_val_"+idx).val('1');
		$("#btn_vs_"+idx).html('<button type="button" id="btn_con_'+idx+'" class="button_black" onClick="change_vis('+idx+',0)"><i class="fa fa-times"></i>&nbsp Hide</button>');
	}
	
}

function apply_daypart(){
	
	var form_data = new FormData();
	form_data.append('vis_val_1', $("#vis_val_1").val());
	form_data.append('vis_val_2', $("#vis_val_2").val());
	form_data.append('vis_val_3', $("#vis_val_3").val());
	form_data.append('vis_val_4', $("#vis_val_4").val());
	form_data.append('vis_val_5', $("#vis_val_5").val());
	form_data.append('vis_val_6', $("#vis_val_6").val());
	form_data.append('dplist_1', $("#dplist_1").val());
	form_data.append('dplist_2', $("#dplist_2").val());
	form_data.append('dplist_3', $("#dplist_3").val());
	form_data.append('dplist_4', $("#dplist_4").val());
	form_data.append('dplist_5', $("#dplist_5").val());
	form_data.append('dplist_6', $("#dplist_6").val());
	form_data.append('survey_data', $("#survey").val());
	form_data.append('periode', '<?php echo $tahunselected ?>');

	
	$.ajax({
		url: "<?php echo base_url().'tvprogramunresallp22/apply_daypart'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			obj = jQuery.parseJSON(data);
			
 			var data_num = obj['data_num'];
			
			for(var i=0; i<data_num.length;i++){
				data_num[i] = parseInt(data_num[i]);
			}
						
					$('#container5').html('');
	
					Highcharts.chart('container5', {
					chart: {
						type: 'bar'
					},
					title: {
						text: ''
					},
				   
					xAxis: {
						categories: obj['data_label'],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: ''
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: {point.y}</td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [{
						name: 'Audience',
						data: data_num,
						color: "#FF0000"

					}]
				});
				
 				
			
		}
	});	
		
}

$(function () {
	
	
	  $('#start_date').each(function() {
              $('#start_date').datepicker({
                  format: 'yyyy-mm-dd', 
                  defaultDate: new Date() ,
				    onSelect: function (date) {
						alert('aaa');
					} 
              }); 
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $STR_TGL; ?>'));
          });	  
		  
		  $('#start_date_d').each(function() {
              $('#start_date_d').datepicker({
                  format: 'yyyy-mm-dd', 
                  defaultDate: new Date() ,
				    onSelect: function (date) {
						alert('aaa');
					} 
              }); 
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $STR_TGL; ?>'));
          });
		  
		  $('#end_date').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd', 
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $END_TGL; ?>'));
          });
		  
		  $('#end_date_d').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd', 
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $END_TGL; ?>'));
          });
		  
 
		  
		  		  $('#start_date2').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd', 
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $STR_TGL; ?>'));
          });
		  
		  $('#end_date2').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd', 
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $END_TGL; ?>'));
          });
	
		$('#start_date_d').change(function(){
		 //Change code!
			if( $('#start_date_d').val() == $('#end_date_d').val() ){
				$("#interval").html('<option value="day" selected >By Days</option><option value="minute"  >By Minutes</option>');
			}else{
				$("#interval").html('<option value="day" selected >By Days</option>');
			}
		});
		
		$('#end_date_d').change(function(){ 
		 //Change code!
			if( $('#start_date_d').val() == $('#end_date_d').val() ){
				$("#interval").html('<option value="day" selected >By Days</option><option value="minute"  >By Minutes</option>');
			}else{
				$("#interval").html('<option value="day" selected >By Days</option>');
			}
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
                    // columnWidth: 'auto'
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
                    // columnWidth: 'auto'
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

var percentageDoughnutChart = <?php echo number_format(($prime/($prime+$nprime))*100,2) ?>;    
    
var DoughnutChartData = {
	labels: [
		"Prime Time",
    "Non Prime Time"
	],
	datasets: [{
		backgroundColor: [
			'#FF0000',
			'#FFDEDE'
		],
		label: 'Dataset 1',
		borderWidth: 0,
		cutoutPercentage: 75,
		data: [
			percentageDoughnutChart,
			100-percentageDoughnutChart
		]
	}]
};
    
 
var color = Chart.helpers.color;
var BarChartData = {
	labels: ["RCTI ", "TRANS7 ", "MNCTV ", "IVM ", "ANTV ", "SCTV ", "TRANS ", "GTV ", "TVONE ", "METRO ", "RTV ", "KOMPASTV ", "INEWSTV ", "NET ", "OCHNL"],
	datasets: [{
 		backgroundColor: window.chartColors.red,
		borderWidth: 0,
		data: [
            <?php echo join($json_spot, ',') ?>
		]
	}]

};
 
var BarChartDaypart = {
	labels:  [<?php echo join($json_days, ',') ?>],
	datasets: [{
		//label: 'Spot',
		backgroundColor: window.chartColors.red,
		borderWidth: 0,
		data: [
            <?php echo join($json_spot_days, ',') ?>
		]
	}]

};
    
   
	// Chart type: Doughnut
	var canvasSpotByTime = document.getElementById("widget-spot-time").getContext("2d");
	window.widgetSpotByTime = new Chart(canvasSpotByTime, {
		type: 'doughnut',
		data: DoughnutChartData,
		options: {             
      cutoutPercentage: 90,    
			maintainAspectRatio: false,
			legend: {
				labels: {
					usePointStyle : true,
					fontColor: 'black',
					fontSize : 14 
				},
				position: 'bottom',
				align: "center",
				display: true,
				onClick: (e) => e.stopPropagation()
			},
      elements: {
				center: {
					text: Math.round(percentageDoughnutChart).toLocaleString('id') + "%",
					color: '#000',
					fontStyle: 'Lato',
				}
			}      
		}
	});
});

$( document ).ready(function() {
   

	$('.timepicker').bootstrapMaterialDatePicker({
      			date: false,
      			format: 'HH:mm:00'
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


	 $('#from').timepicker({
              timeFormat: 'HH:mm',
              interval: 30,
              minTime: '00:00',
              maxTime: '23:59',
               startTime: '00:00',
              dynamic: false,
              dropdown: true,
              scrollbar: true,
              zindex: 9999  
              
              ,change: function(time){
                  if($('#from').val() == ""){
                      $('#from').val("00:00");
                  }
                  
                  
              }
          });       
		  
		   $('#to').timepicker({
              timeFormat: 'HH:mm',
              interval: 30,
              minTime: '00:00',
              maxTime: '23:59',
               startTime: '00:00',
              dynamic: false,
              dropdown: true,
              scrollbar: true,
              zindex: 9999  
              
              ,change: function(time){
                  if($('#from').val() == ""){
                      $('#from').val("00:00");
                  }
                  
                 
              }
          });    
		  
		  
	
	 
	
	
	Highcharts.chart('container5', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
       
        xAxis: {
            categories: [<?php echo join($json_days, ',') ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: {point.y}</td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Audience',
            data: [<?php echo join($json_spot_days, ',') ?>],
			color: "#FF0000"

        }]
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
           title: '',
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
			color: "#FF0016"
        }]
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
var start_date2 = $('#start_date2').val();
var end_date2 = $('#end_date2').val();
var profile_prog = $('#profile_prog').val();
var survey_data = $('#survey').val();

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
		"ajax": "<?php echo base_url().'tvprogramunresallp22/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&start_date2="+start_date2+"&end_date2="+end_date2+"&profile="+profile_prog+"&survey_data="+survey_data+"&searchtxt="+search_val+"&check=False"+"&check2=True",
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	}).on('search.dt', function() {
	  var input = $('#example3_filter input')[0];
	  
 	  $('#search_ps').val(input.value);
	  
	}).on('order.dt', function() {
		 var order = table3.order();
		  $('#order_ps').val(order);
	  
	});	;	
	
 

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
		 "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
		columns: [
			{ data: 'Rangking' },
			{ data: 'channel' },
			{ data: 'AUDIENCE' ,"sClass": "right"},
			{ data: 'VIEWERS' ,"sClass": "right"},
			{ data: 'TVR' ,"sClass": "right"},
			{ data: 'TVS' ,"sClass": "right"},
			{ data: 'INDEX' ,"sClass": "right"},
			{ data: 'REACH' ,"sClass": "right"}
		]
	}).on('order.dt search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
	  
	   table4.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1; 
        } );
 	});
	
	$('#channel_export').on('click', function() {
		var search = $('#search_ps4').val();
		var order = $('#order_ps4').val();
		
 	
		
		$('#channel_export').attr('disabled','disabled');
	 
	  
		if($('#fta_channel').is(':checked')){
		
			var check = "True";
		}else{
			var check = "False";
		
		}
	  
		var form_data = new FormData();  
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var survey = $('#survey').val(); 
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var tipe_filter = "live";
		var check = check;
		var profile_chan = $('#profile_chan').val();
		var dayparts = $('#daypart').val();
		
 		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('survey', survey);
		form_data.append('start_date', start_date);
		form_data.append('check', check);
		form_data.append('end_date', end_date);
		form_data.append('tipe_filter', tipe_filter);
		form_data.append('profile', profile_chan);
		form_data.append('search', search);
		form_data.append('order', order);
		form_data.append('dayparts', dayparts);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramunresallp22/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				$('#channel_export').removeAttr('disabled');
 				
 				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_channel.xls','Audience_by_channel.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
	$('#program_export').on('click', function() {
	 
	 var order = table3.order();

	  
	  	if($('#fta_program').is(':checked')){
		
			var check = "True";
		}else{
			var check = "False";
		
		}
		
		if($('#fta_program_2').is(':checked')){
			
			var check2 = "True";
		}else{
			var check2 = "False";
		
		}
	  
		var form_data = new FormData();  
		var type = $('#product_program').val();
		var field = "Program";
		var tahun = $('#tahun').val();
		var channel_prog = $('#channel_prog').val();
		var tipe_filter_prog = "live";
		var search_t = $('#search_ps').val();
		var order_t = $('#order_ps').val();
		var survey_data = $('#survey').val();
		
 		
		var bulan = $('#bulan').val();
		var start_date2 = $('#start_date2').val();
		var end_date2 = $('#end_date2').val();
		var profile_prog = $('#profile_prog').val(); 
		var week = $('#week2').val();
		form_data.append('tahun', tahun);
		form_data.append('check', check);
		form_data.append('check2', check2);
		form_data.append('channel', channel_prog);
		form_data.append('bulan', bulan);
		form_data.append('tipe_filter_prog', tipe_filter_prog);
		form_data.append('end_date', end_date2);
		form_data.append('start_date', start_date2); 
		form_data.append('type', type);
		form_data.append('field', field);
		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('profile', profile_prog);	
		form_data.append('search_t', search_t);	
		form_data.append('order_t', order_t);	
		form_data.append('survey_data', survey_data);	
 		
		var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
 
		
		if(type == 'Viewers'){
			var tpe = 'Total Views';
		}else if(type == 'avgtotdur'){
			var tpe = 'Average Duration/Total Views';
		}else if(type == 'avgtotaud'){
			var tpe = 'Average Duration/Audience (%)';
		}else if(type == 'TVR'){
			var tpe = "TVR IH";
			var tpe2 = "TVR ALL";
		}else if(type == 'TVS'){
			var tpe = "TVS IH";
			var tpe2 = "TVS ALL";
		}else if(type == 'IDX'){
			var tpe = "INDEX IH";
			var tpe2 = "INDEX ALL";
		}else if(type == 'Audience2'){
			var tpe = "Audience IH";
			var tpe2 = "Audience ALL";
		}else if(type == 'Reach'){
			var tpe = "Reach IH";
			var tpe2 = "Reach ALL";
		}else{
			var tpe = "'000s IH";
			var tpe2 = "'000s ALL";
		}
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramunresallp22/audiencebar_by_program_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				$('#program_export').removeAttr('disabled');
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_program.xls','Audience_by_program.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
});

function day_filter(){
	
 	
	var start_date_d = $('#start_date_d').val();
	var end_date_d = $('#end_date_d').val();
	var channel_d = $('#channel_ds').val();
	var audiencebar_2 = $('#audiencebar_2').val();
	var interval = $('#interval').val();
	var respondent = $('#respondent').val();
	var survey_data = $('#survey').val();
	
	var form_data = new FormData();  
		form_data.append('start_date_d',start_date_d);
		form_data.append('end_date_d',end_date_d);
		form_data.append('channel_d', channel_d);	
		form_data.append('audiencebar_2', audiencebar_2);
		form_data.append('interval', interval);
		form_data.append('respondent', respondent);
		form_data.append('survey_data', survey_data);
		
	
	
	$.ajax({
			url: "<?php echo base_url().'tvprogramunresallp22/day_filter'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
					obj = jQuery.parseJSON(data);
						
					$('#container6').html('');
	
					Highcharts.chart('container6', {
						title: {
							text: '',
							x: -20  
						},

						xAxis: {
							categories: obj.json_date,
						},
						yAxis: {
						   title: '',
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
							name: audiencebar_2,
							data: obj.json_spot_date,
							color: "#FF0016"
						}]
					});
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	

	
}

function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<i class="fa fa-filter"></i> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<i class="fa fa-filter"></i> &nbsp Hide Filter');
	}

	$('#filter_panel_'+part).slideToggle(500);
	
}

function day_view_f(){
	
		var periode = "<?php echo $tahunselected ?>";
		var form_data = new FormData();  
		var audiencebarday = $('#audiencebarday').val();
		form_data.append('audiencebarday', audiencebarday);
		form_data.append('periode',"<?php echo $tahunselected ?>");
		
		$.ajax({
			url: "<?php echo base_url().'tvprogramunresallp22/filter_days'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				if (audiencebarday == 'Viewers'){
					$('#judul_hari').html('<h4>Total Viewers By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
				}else if(audiencebarday == 'Duration'){
					$('#judul_hari').html('<h4>Duration By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
				}else{
					$('#judul_hari').html('<h4>Respondent By Day</h4><span style ="font-size: 12px;" > '+periode+'</span>');
				}
				
				obj = jQuery.parseJSON(data);
				
 				
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
					series: [{
						name: audiencebarday,
						 data: obj.json_spot_date,
						color: "#4a4d54"
					}]
				});
									
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
			$('#table_program1').html('<table id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
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
					return type+': <b>' + this.point.y + '</b>';
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
					return type+': <b>' + this.point.y + '</b>';
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
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
					return type+': <b>' + this.point.y + '</b>';
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

		var url = '<?php echo base_url(); ?>tvprogramunresallp22'; 
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var survey = $('#survey').val();
 		  
		 $("#laod").append(' <img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"<input type='hidden' name='survey' value='" + survey + "' />" +
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
		url: "<?php echo base_url().'tvprogramunresallp22/cost_by_program'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program1').html("");
			$('#table_program1').html('<table id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
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
							//return  parseFloat(data).toFixed(2);
							//var x = parseFloat(data).toFixed(2);
							//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

function audiencebar_view(){
	
	
	if($('#fta_channel').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	if( $('#daypart').val() == '' ){
		
		var dpy = "ALL";
	}else{
		var dpy = $('#daypart').val() ;
	
	}
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var survey = $('#survey').val();
	var dayparts = dpy; 
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var tipe_filter = "live";
	var check = check;
	var profile_chan = $('#profile_chan').val(); 
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('survey', survey);
	form_data.append('start_date', start_date);
	form_data.append('check', check);
	form_data.append('end_date', end_date);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
	form_data.append('dayparts', dayparts); 
  
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramunresallp22/audiencebar_by_channel'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			 
			$('#table_program2').html("");
		 
			if(type == 'Viewers'){
				
				var tpe = "'000s IH";
				var tpe2 = "'000s ALL";
				
			}else if(type == 'audience2'){
				var tpe = "Audience IH";
				var tpe2 = "Audience ALL";
			}else if(type == 'Reach'){
				var tpe = "Reach IH";
				var tpe2 = "Reach ALL";
			}else if(type == 'tvr'){
				var tpe = "TVR IH";
				var tpe2 = "TVR ALL";
			}else if(type == 'tvs'){
				var tpe = "TVS IH";
				var tpe2 = "TVS ALL";
			}else if(type == 'idx'){
				var tpe = "INDEX IH";
				var tpe2 = "INDEX ALL";
			}else if(type == 'Duration'){
				var tpe = 'Duration ';
				var tpe2 = 'Duration ';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
				var tpe2 = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
				var tpe2 = 'Audience Share';
			}else{
				
				var tpe = "'000s IH";
				var tpe2 = "'000s ALL";
			}
					$('#table_program2').html('<table id="example4" class="table table-striped " style="width: 100%"><thead><tr><th>Rank </th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);

 			
			if(type == "Reachss"){
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
						{ data: 'AUDIENCE' ,"sClass": "right"},
						{ data: 'VIEWERS' ,"sClass": "right"},
						{ data: 'TVR' ,"sClass": "right"},
						{ data: 'TVS' ,"sClass": "right"},
						{ data: 'INDEX' ,"sClass": "right"},
						{ data: 'REACH' ,"sClass": "right"}
					]
				});	
			}else{
				var table4 = $('#example4').DataTable({
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
						{ data: 'AUDIENCE' ,"sClass": "right"},
						{ data: 'VIEWERS' ,"sClass": "right"},
						{ data: 'TVR' ,"sClass": "right"},
						{ data: 'TVS' ,"sClass": "right"},
						{ data: 'INDEX' ,"sClass": "right"},
						{ data: 'REACH' ,"sClass": "right"}
					]
				}).on('order.dt search.dt', function() {
				  var input = $('.dataTables_filter input')[0];
				  $('#search_ps4').val(input.value);
				  var order = table4.order();
		  		  $('#order_ps4').val(order);


				   table4.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
						cell.innerHTML = i+1; 
					} );
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
	
	if($('#fta_program_2').is(':checked')){
		
		var check2 = "True";
	}else{
		var check2 = "False";
	
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var channel_prog = $('#channel_prog').val();
	var tipe_filter_prog = "live";
	var survey_data = $('#survey').val();
	
 	
	var bulan = $('#bulan').val();
	var start_date2 = $('#start_date2').val();
	var end_date2 = $('#end_date2').val();
	var profile_prog = $('#profile_prog').val(); 
	var week = $('#week2').val();
	if(start_date2 == ''){
		
		alert('Tanggal Harus Diisi');
		throw new Error("Tanggal Harus Diisi");
		
	} 
	
	if(end_date2 == ''){
		
		alert('Tanggal Harus Diisi');
		throw new Error("Tanggal Harus Diisi");
		
	} 

	form_data.append('tahun', tahun);
	form_data.append('channel', channel_prog);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('end_date2', end_date2);
 	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
 	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
	$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$('#table_program').html("");
	
	if(type == 'Viewers'){
		var tpe = 'Total Views';
	}else if(type == 'avgtotdur'){
		var tpe = 'Average Duration/Total Views';
	}else if(type == 'avgtotaud'){
		var tpe = 'Average Duration/Audience (%)';
	}else if(type == 'TVR'){
		var tpe = "TVR IH";
		var tpe2 = "TVR ALL";
	}else if(type == 'TVS'){
		var tpe = "TVS IH";
		var tpe2 = "TVS ALL";
	}else if(type == 'IDX'){
		var tpe = "INDEX IH";
		var tpe2 = "INDEX ALL";
	}else if(type == 'Audience2'){
		var tpe = "Audience IH";
		var tpe2 = "Audience ALL";
	}else if(type == 'Reach'){
		var tpe = "Reach IH";
		var tpe2 = "Reach ALL";
	}else{
		var tpe = "'000s IH";
		var tpe2 = "'000s ALL";
	}

	if(type == 'avgtotaud'){
		$('#table_program').html('<table id="example3" class="table table-striped" style="color:black"><thead style="color:red"><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}else{
		$('#table_program').html('<table id="example3" class="table table-striped" style="width: 100%"><thead style="color:red"><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}
	
	
	
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
		"ajax": "<?php echo base_url().'tvprogramunresallp22/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&start_date2="+start_date2+"&end_date2="+end_date2+"&check="+check+"&check2="+check2+"&channel="+channel_prog+"&profile="+profile_prog+"&survey_data="+survey_data+"&tipe_filter_prog="+tipe_filter_prog,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	}).on('search.dt', function() {
	  var input = $('#example3_filter input')[0];
	  
	  $('#search_ps').val(input.value);
 
	}).on('order.dt', function() {
		 var order = table3.order();
		  $('#order_ps').val(order);
 
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
		url: "<?php echo base_url().'tvprogramunresallp22/cost_by_program'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
		 
					$('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
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
		url: "<?php echo base_url().'tvprogramunresallp22/daypart_view'; ?>", 
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
					return type+': <b>' + this.point.y + '</b>';
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
		url: "<?php echo base_url().'tvprogramunresallp22/day_view'; ?>", 
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
		url: "<?php echo base_url().'tvprogramunresallp22/ads_view'; ?>", 
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
					return type+': <b>' + this.point.y + '</b>';
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
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode3" ).html($(".title-periode3").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode4" ).html($(".title-periode4").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
	
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
