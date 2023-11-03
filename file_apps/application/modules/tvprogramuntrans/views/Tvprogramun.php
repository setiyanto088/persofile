    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html>

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
	.form-control{
		border:none !important;
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
                <!--<li class="breadcrumb-item">Urban Lifestyle Media</li>-->
                <li class="breadcrumb-item active">TV Program Dashboard Transvision</li>
            </ol>
            <h3 class="page-title">TV Program Dashboard</h3>
          </div>
          <div class="col-md-7 text-right">
            <a href="#addNewWidget" class="btn urate-outline-btn btn-lg" data-toggle="modal">
                <span class="ion-edit"></span> Edit Widget
            </a>
            <button type="button" class="btn urate-btn btn-lg" onclick="show()" id="exportWidget" data-complete-text="<span class='ion-android-open'></span> Export Now">
              <span class="ion-android-open"></span> Export
            </button>
            <button type="button" class="btn urate-outline-btn btn-lg btn-cancel hidden">Cancel</button>
			<br/>
			<h6 id="hs"></h6>
          </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row">
		
		<div class="col-lg-12">	
			<div class="col-lg-4">	
				<label>Period: </label>
					<select class="form-control" name="tahun" id="tahun" required onChange="viewall()">
					<!--<option value='2018' <?php  if ($tahunselected=='2018') { echo 'selected'; } ?> >2018</option>
					<option value='2019' <?php  if ($tahunselected=='2019') { echo 'selected'; } ?> >2019</option>-->
						<?php 
						//print_r($thn);
							foreach($thn as $periode){
								
								//if ($periode['TANGGAL']==$tahunselected) {
								if ($periode['TANGGAL']==$tahunselected) {
									echo "<option value=".$periode['TANGGAL']." selected>".$periode['TANGGAL']."</option>";
								}else {
									echo "<option value=".$periode['TANGGAL']." >".$periode['TANGGAL']."</option>";
								}
								
							
								
							}
						
							// for ($i=0;$i<count($thn);$i++){
								// if ($thn[$i]["tahun"]==$tahunselected) {
									// echo "<option value=".$thn[$i]["tahun"]." selected>".$thn[$i]["tahun"]."</option>";
								// }else {
									// echo "<option value=".$thn[$i]["tahun"]." >".$thn[$i]["tahun"]."</option>";
								// }
							// }
						?>
					</select>   
			</div>
			
			<div class="col-lg-4">	
				<span id="laod"></span>
			</div>
			<!--<div class="col-lg-4">	
			<label>Month: </label>
					<select class="form-control" name="bulan" id="bulan" required onChange="viewall()">
						<?php 
						//print_r($bln);
							for ($i=0;$i<count($bln);$i++){
										
									//if ($bln[$i]["bulan"]==$bulanselected) {
									if ($bln[$i]["bulan"]=="2020-September") {
										echo "<option value=".$bln[$i]["bulan"]." Selected>".$bln[$i]["bulan"]."</option>";
									}else {
										echo "<option value=".$bln[$i]["bulan"]." >".$bln[$i]["bulan"]."</option>";
									}

							}
						?>
					</select>  
			</div> -->
		</div>
		<br/>
		<br/>
		<br/>
		<br/>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_cost.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Number of Respondent</span>
                <span class="value"><?php echo number_format($jmlchannel[0]["UNIVERSE"],0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_grp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Active Respondent</span>
                <!--<span class="value"><?php echo number_format(intval($aa),0,',','.'); ?></span>-->
				<span class="value"><?php echo number_format($jmlchannel[0]["UNIVERSE"],0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_crp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Active Audience</span>
                <span class="value"><?php echo number_format(intval($jmlchannel[0]["UNIVERSE"]),0,',','.'); ?>
                
                </span>
              </div>
            </div>
          </div>
		  
		  <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_spot.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Universe</span>
                <span class="value"><?php echo number_format(intval($jmlchannel[0]["UNIVERSE"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>
		  
        </div>
		
		  
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="widgets" class="row grid-stack">
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-2" class="widget">
                <div class="navbar-center">
                  <h4 class="title-periode1">Audience by Channel</h4>
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
					<div class="col-lg-12">	
						<div class="col-lg-4">	
						  <div class="dataset col-md-12" style="z-index: 999;margin-top: -30px">
							 <div class="dataset-title" >
									<p class="title-text">From to Period</p>
								</div>
							  <div class="input-group input-daterange" style="margin-top:-10px">
								  <input type="text" class="form-control urate-form-input" name="start_date" id="start_date" placeholder="From ..." value="">
								  <div class="input-group-addon">-</div>
								  <input type="text" class="form-control urate-form-input" name="end_date" id="end_date" placeholder="To ..." value="">
							  </div>
						  </div>    
						</div>
						<div class="col-lg-2">
						<select class="form-control" name="profile_chan" id="profile_chan"  >
							<option value="0" selected >All People</option>
							<?php foreach($profile as $prfs){
								
								echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
							} ?>
						</select> 
						</div>
						<div class="col-lg-2">
						<!--<select class="form-control" name="audiencebar" id="audiencebar" required >
							<option value="audience2" selected >Audience</option>
							<option value="audience" >Viewers</option>
							<option value="tvr" >TVR</option>
							<option value="tvs" >TVS</option>
							<option value="idx" >INDEX</option>
							<option value="Reach" >Reach</option>
							<option value="Viewers" >Total Views</option>
							<option value="Duration" >Duration</option>
							<option value="avgtotdur" >AVG Dur/Views</option>
							<option value="share" >Audience Share</option>
						</select> -->
						</div>
						
						<div class="col-lg-2">
						<!--<select class="form-control" name="tipe_filter" id="tipe_filter" required >
							<option value="live" selected >Live</option>
							<option value="ALL" >All</option>
							<option value="TVOD" >TVOD</option>
						</select> -->
						</div>
						<div class="col-lg-2">
						<button onClick="audiencebar_view()" class="btn btn-danger">Filter</button>
						<button class="btn btn-danger" id='channel_export'>Export</button>
						</div>
					</div>
					
					<br/>
					<br/>
					
					<div class="" style="" ><input type="checkbox" value="fta" id="fta_channel" checked='checked' onclick="channel_change();">Include FTA</label></div>
					<div id="table_program2">
						<table id="example4" class="table table-striped table-bordered example" style="width: 100%">
							<thead>
								<!--<tr>
									<th>Rank</th>
									<th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
								</tr>-->
								<tr>
									<th>Rank</th>
									<th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
								</tr>
							</thead>
						</table>
					</div>
					<!--div id="container" ></div-->
                  <canvas id="widget-spot-channel" height="100"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-1" class="widget">
                <div class="navbar-center">
                  <h4 class="title-periode2">Audience by Program</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkTwo">
                      <label for="checkTwo"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Channel">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div class="widget-content">
				
					<div class="col-lg-12">	
						<div class="col-lg-4">	
						  <div class="dataset col-md-12" style="z-index: 999;margin-top: -30px">
							 <div class="dataset-title" >
									<p class="title-text">From to Period</p>
								</div>
							  <div class="input-group input-daterange" style="margin-top:-10px">
								  <input type="text" class="form-control urate-form-input" name="start_date2" id="start_date2" placeholder="From ..." value="">
								  <div class="input-group-addon">-</div>
								  <input type="text" class="form-control urate-form-input" name="end_date2" id="end_date2" placeholder="To ..." value="">
							  </div>
						  </div>    
						</div>
						<div class="col-lg-2">
							<select class="form-control" name="profile_prog" id="profile_prog"  >
								<option value="0" selected >All People</option>
								<?php foreach($profile as $prfss){
									
									echo '<option value='.$prfss['id'].'  >'.$prfss['name'].'</option>';
								} ?>
							</select>
						</div>
						<div class="col-lg-2">
							<!--<select class="form-control" name="product_program" id="product_program"  >
								<option value="Audience2" selected >Audience</option>
								<option value="Audience" >Viewers</option>
								<option value="TVR" >TVR</option>
								<option value="TVS" >TVS</option>
								<option value="IDX" >INDEX</option>
								<option value="Reach" >Reach</option>
								<option value="Viewers" >Total Views</option>
								<option value="Duration" >Duration</option>
								<option value="avgtotdur" >AVG Dur/Views</option>
								<option value="avgtotaud" >AVG Dur/Audience</option>
							</select>-->
						</div>						
						
						<div class="col-lg-2">
						<!--<select class="form-control" name="tipe_filter_prog" id="tipe_filter_prog" required >
							<option value="live" selected >Live</option>
							<option value="ALL" >All</option>
							<option value="TVOD" >TVOD</option>
						</select> -->
						</div>

						<div class="col-lg-2">						
							<button id="filter2" type="button" onClick="table2_view()" class="show-tick btn btn-danger">Filter</button>
							<button id="program_export" type="button" class="show-tick btn btn-danger">Export</button>
						</div>
					</div>
					<div class="col-lg-12">	
					<div class="col-lg-6" style="" >
					<input type="checkbox" value="fta" id="fta_program" onclick="program_change();">Include Begin Time</label> 
					<input type="checkbox" value="fta" id="fta_program_2" checked='checked' onclick="program_change();">Include FTA</label>
					
					</div>
						<div class="col-lg-2">
							<!--	<select class="form-control" name="channel_prog" id="channel_prog" required >
							<option value="All" selected >All Channel</option>
							<?php foreach($channel_list as $channel_lists){
							echo '<option value="'.$channel_lists['CHANNEL'].'" >'.$channel_lists['CHANNEL'].'</option>';
							
							 } ?>
						</select>  -->
						</div>
					</div>
					<div id="table_program">
						<table id="example3" class="table table-striped table-bordered example" style="width: 100%">
							<thead>
								<!--<tr>
									<th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
													</tr>-->
													
													<tr>
									<th>Rank</th>
									<th>Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
									<th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th>
								</tr>

							</thead>
						</table>
					</div>
                </div>
              </div>
            </div>
          </div>
          
                    <div class="grid-stack-item" data-gs-min-width="3" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="3" data-gs-height="2" data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-3" class="widget inverse">
                <div class="navbar-center">
                  <h4>Audience by Time</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkThree">
                      <label for="checkThree"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Time">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div id="js-legend-time" class="chart-legend"></div>                
                <div class="widget-content" style="height: 70%;">
                  <canvas id="widget-spot-time" style="margin-top: -15px;"></canvas>
                </div>
              </div>
            </div>
          </div>
          
          
                    <div class="grid-stack-item" data-gs-min-width="9" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="9" data-gs-height="2" data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-4" class="widget">
                <div class="navbar-left">
                  <h4 class="title-periode3">Audience by Daypart</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkFour">
                      <label for="checkFour"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Daypart">
                      <span class="ion-close-round"></span>
                    </button>
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
            <div class="grid-stack-item-content">
              <div data-widget="widget-5" class="widget">
			  		<div class="col-lg-12">	
						<div class="col-lg-2">
						<!--<button id="print_days" class="btn btn-danger">Export</button>-->
						</div>
						<div class="col-lg-6"></div>
						<div class="col-lg-2">
						<select class="form-control" name="audiencebarday" id="audiencebarday" required >
							<option value="Audience" selected >Audience</option>
						<!--	<option value="Reach" >Reach</option> -->
							<option value="Viewers" >Total Views</option>
							<option value="Duration" >Duration</option>
						<!--		<option value="avgtotdur" >AVG Dur/Views</option> -->
						<!--		<option value="share" >Audience Share</option> -->
						</select> 
						</div>

						<div class="col-lg-2">
						<button onClick="day_view_f()" class="btn btn-danger">Filter</button>
						</div>
					</div>
					<br><br> 
                <div class="navbar-center" id='judul_hari'>
                  <h4 class="title-periode4">Audience by Day</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkFive">
                      <label for="checkFive"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Day">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div class="widget-content">
                  <div id="container6"></div>
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
                        <!--input type="checkbox" class="urate-form-checkbox" id="checkTwo">
                        <label for="checkTwo"></label-->
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
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
 <script src="<?php echo $path;?>assets/js/widget.js?v=2"></script>
<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
	 
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo $paths;?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	
	
	
	
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.2/jspdf.plugin.autotable.js"></script>
    
<script async >

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
	
	//alert(tipe_filter_prog);
	
	var bulan = $('#bulan').val();
	var start_date2 = $('#start_date2').val();
	var end_date2 = $('#end_date2').val();
	var profile_prog = $('#profile_prog').val();
	// var hariawal = $('#hariawal2').val();
	// var hariakhir = $('#hariakhir2').val();
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('channel', channel_prog);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('end_date2', end_date2);
	// form_data.append('hariakhir', hariakhir);
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
		$('#table_program').html('<table id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}else{
		$('#table_program').html('<table id="example3" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>'); 
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
		"ajax": "<?php echo base_url().'tvprogramuntrans/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&start_date2="+start_date2+"&end_date2="+end_date2+"&check="+check+"&check2="+check2+"&channel="+channel_prog+"&profile="+profile_prog+"&tipe_filter_prog="+tipe_filter_prog,
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	});	
	
}

function channel_change(){
	
	//var tpe = $('#type_o').val();
	
	if($('#fta_channel').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	//var week = $('#week1').val();
	//var tgl = $('#tgl1').val();
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var tipe_filter = "live";
	var check = check;
	var profile_chan = $('#profile_chan').val();
	//var hariakhir = $('#hariakhir').val();
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('start_date', start_date);
	form_data.append('check', check);
	form_data.append('end_date', end_date);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
	//form_data.append('hariakhir', hariakhir);
  
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramuntrans/audiencebar_by_channel'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			// console.log(data); return false;
			//$('#table_program').html("");
			$('#table_program2').html("");
			//$('#table_program2').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rangking</th><th>CHANNEL</th></tr></thead></table>');
			//alert("asasasas");
			// if(field == "Program"){
				// $('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			// }else{
				// $('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			// }
			
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
						$('#table_program2').html('<table id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Rank</th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);

			//console.log(obj);
			
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
								//return  parseFloat(data).toFixed(2);
								//var x = parseFloat(data).toFixed(2);
								//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
							}
						},
						{ data: 'Spot2' ,"sClass": "right",render: function ( data, type, row ) {
							return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								//return  parseFloat(data).toFixed(2);
								//var x = parseFloat(data).toFixed(2);
								//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
				  //console.log(input.value)
				});	
			}
			
			
			
			// var obj = jQuery.parseJSON(data);
			// var data_new = [];
			
			// obj['data'].forEach(myFunction);
			
			
			// function myFunction(item, index) {
				// if(type == "Reach"){
					// data_new.push(parseFloat(item));
				// }else{
					// data_new.push(parseInt(item));
				// }
				
			// }

			// //console.log(data_new);
			// $('#container').html();
			
			// var chart= {
				// type: 'column'
			// };
			// var title = {
			  // text: type+" by Channel"
			// };
			// var subtitle = {
			  // text: ""
			// };
			// var xAxis = {
			  // categories: obj['cat'],
			  // crosshair: true
			// };
			// var yAxis = {
			  // min: 0,
			  // minRange: 0.1,
			  // title: {
				 // text: type
			  // },
			 
			// };
			// var tooltip= {
				// formatter: function () {
					// return type+': <b>' + this.point.y + '</b>';
				// }
			// };
			// var  plotOptions= {
				// column: {
					// pointPadding: 0.2,
					// borderWidth: 0
				// }
			// };
			// var series= [{
				 // name: type,
				 // data:data_new,
				 // color: "#4a4d54"
			  // }
			// ];
			// console.log(data_new);
			// var json = {};

			// json.chart = chart;
			// json.title = title;
			// json.subtitle = subtitle;
			// json.xAxis = xAxis;
			// json.yAxis = yAxis;  
			// json.series = series;
			// json.plotOptions = plotOptions;
			// $('#container').highcharts(json);	
		}
	});	
	
}

function timesec(id){
	
	//alert(id);
	document.getElementById("modal_filter").focus();
	
	$("#id_time").val(id);
	$("#modal_time").modal("show");
	
	
}

function settime(){
	
	//alert(id);
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
	
	
	  $('#start_date').each(function() {
              $('#start_date').datepicker({
                  format: 'yyyy-mm-dd',
                  startDate: '<?php echo $STR_TGL; ?>',
                  endDate: '<?php echo $END_TGL; ?>',
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
                  startDate: '<?php echo $STR_TGL; ?>',
                  endDate: '<?php echo $END_TGL; ?>',
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
                  startDate: '<?php echo $STR_TGL; ?>',
                  endDate: '<?php echo $END_TGL; ?>',
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $END_TGL; ?>'));
          });
		  
		  $('#end_date_d').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd',
                  startDate: '<?php echo $STR_TGL; ?>',
                  endDate: '<?php echo $END_TGL; ?>',
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $END_TGL; ?>'));
          });
		  
		  
		    $('#start_date2').each(function() {
              $('#start_date2').datepicker({
                  format: 'yyyy-mm-dd',
                  startDate: '<?php echo $STR_TGL; ?>',
                  endDate: '<?php echo $END_TGL; ?>',
                  defaultDate: new Date() ,
				    onSelect: function (date) {
						alert('aaa');
					} 
              }); 
              
              m = moment(new Date());              
              $(this).val(m.format('<?php echo $STR_TGL; ?>'));
          });
		  
		  $('#end_date2').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd',
                  startDate: '<?php echo $STR_TGL; ?>',
                  endDate: '<?php echo $END_TGL; ?>',
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
            // countPage++;
			// namefile = 'Audience by Channel';
			 
			setTimeout(function(){
			  docs.save('Audience by Channel.pdf');
			  // doc.destroy();
			 }, 0); 
			  // var chart = $('#container').highcharts();
				// chart.exportChart({
					// type: 'application/pdf',
					// filename: 'AudienceByChannel'
				// });
            // doc.text(105, 30, 'Spot by Time', null, null, 'center');

            // var canvasWidget1 = document.getElementById('widget-spot-channel');
            // var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
			
            // doc.setFillColor(203, 51, 39);
            // doc.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            // doc.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
            // countPage++;
          }
			
			
			
          // Widget-2
          if($("#checkTwo").is(':checked')){
            // if (countPage != 0){
              // doc.addPage();
            // }
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
            // countPage++;
			// namefile = 'Audience by Program';
			
			setTimeout(function(){
			  docc.save('Audience by Program.pdf');
			 }, 4000); 
          }
          // Widget-2
          // if($("#checkTwo").is(':checked')){
            // if (countPage != 0){
              // doc.addPage();
            // }
			
			// var chart = $('#container').highcharts();
				// chart.exportChart({
					// type: 'application/pdf',
					// filename: 'spotbychannel'
				// });

          // }

          // Widget-3
          if($("#checkThree").is(':checked')){
            // if (countPage != 0){
              // doc.addPage();
            // }
			var doca = new jsPDF();  
            doca.text(105, 30, 'Audience by Time', null, null, 'center');
  var selPeriode = $('#tahun').find('option:selected').text().split('-');
            doca.text(155, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var canvasWidget1 = document.getElementById('widget-spot-time');
            var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
			
            doca.setFillColor(203, 51, 39);
            doca.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            doca.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
            // countPage++;
			
			
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
          // if($("#checkFour").is(':checked')){
            // if (countPage != 0){
              // doc.addPage();
            // }
			 // var chart = $('#container3').highcharts();
				// chart.exportChart({
					// type: 'application/pdf',
					// filename: 'SpotbyAdsType'
				// });
          // }

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
                  // columnWidth: 'auto',
                  // bottomLineColor: [44, 62, 80],
                  // lineWidth: 0.1
                },
                columnStyles: {
                  text: {
                    // columnWidth: 'auto'
                  }
                }
            });
			
			
			setTimeout(function(){
			  doc.save('Audience by Time.pdf');
			 }, 4000); 
            // countPage++;
          }
		  

          // Save into pdf
          // if(countPage > 0){
            // doc.save(namefile+'.pdf');
          // }
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
			window.chartColors.white,
			window.chartColors.purple
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
    
    
    
//var DoughnutChartDataType = {
//	labels: [
//		"Loose Spot",
//		"Non Loose Spot"
//	],
//	datasets: [{
//		backgroundColor: [
//			window.chartColors.white,
//			window.chartColors.orange
//		],
//		label: 'Dataset 1',
//		borderWidth: 0,
//		cutoutPercentage: 75,
//		data: [
//			<?php //echo $loose[0]['Loose'] ?>,
//			<?php //echo $loose[0]['No_Loose'] ?>
//		]
//	}]
//};
//    
//    
var color = Chart.helpers.color;
var BarChartData = {
	labels: ["RCTI ", "TRANS7 ", "MNCTV ", "IVM ", "ANTV ", "SCTV ", "TRANS ", "GTV ", "TVONE ", "METRO ", "RTV ", "KOMPASTV ", "INEWSTV ", "NET ", "OCHNL"],
	datasets: [{
		//label: 'Spot',
		backgroundColor: window.chartColors.red,
		borderWidth: 0,
		data: [
            <?php echo join($json_spot, ',') ?>
		]
	}]

};
//var BarChartAdsData = {
//	labels:  ["LOOSE SPOT ", "TEMPLATE ", "CREDIT TITLE ", "PLASMA ", "SUPER IMPOSE ", "BUILT IN ", "SQUEEZE FRAME ", "OBB ", "CBB ", "VIRTUAL ADS ", "BUILT IN SEGMEN ", "MOVING IMPOSE ", "ADLIPS ", "QUIZ ", "RUNNING TEXT ", "TVC BETWEEN PROGRAM ", "BUILT IN ", "ASSALAAMUALAIKUM USTADZ ", "Q CARD ", "INFO QUIZ"],
//	datasets: [{
//		label: 'Spot',
//		backgroundColor: window.chartColors.red,
//		borderWidth: 0,
//		data: [
//            <?php //echo join($json_spot_ads, ',') ?>
//		]
//	}]
//
//};
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
    
    // var canvasSpotByDay = document.getElementById("widget-spot-day").getContext("2d");
	// var widgetSpotByDay = new Chart(canvasSpotByDay, config);

	// Chart type: Bar
	// var canvasSpotByChannel = document.getElementById("widget-spot-channel").getContext("2d");
	// window.widgetSpotByChannel = new Chart(canvasSpotByChannel, {
		// type: 'bar',
		// data: BarChartData,
		// options: {
			// scales: {
		        // xAxes: [{
		            // barPercentage: 0.2,
		            // gridLines: {
	                    // display:false
	                // }   
		        // }]
		    // },
			// responsive: true,
			// legend: {
				// display: false
        // //,position: 'top'
			// }
		// }
	// });
	// Chart type: Bar Horizontal
//	var canvasSpotAdsByChannel = document.getElementById("widget-spotads-channel").getContext("2d");
//	window.widgetSpotAdsByChannel = new Chart(canvasSpotAdsByChannel, {
//		type: 'horizontalBar',
//		data: BarChartAdsData,
//		options: {
//			responsive: true,
//			legend: {
//				position: 'top',
//			}
//		}
//	});
//    
	// Chart type: Bar Horizontal
	// var canvasSpotAdsByChannel = document.getElementById("widget-spot-daypart").getContext("2d");
	// window.widgetSpotAdsByChannel = new Chart(canvasSpotAdsByChannel, {
		// type: 'horizontalBar',
		// data: BarChartDaypart,
		// options: {
			// scales: {
		        // yAxes: [{
		            // barPercentage: 0.5,
		            // gridLines: {
	                    // display:false
	                // }   
		        // }]
		    // },
			// responsive: true,
			// legend: {
				// display: false
        // //,position: 'top'
			// }
		// }
	// });
    
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
					fontColor: 'white',
					fontSize : 14 
				},
				position: 'bottom',
				display: true,
				onClick: (e) => e.stopPropagation()
			},
      elements: {
				center: {
					text: Math.round(percentageDoughnutChart).toLocaleString('id') + "%",
					color: '#FFF',
					fontStyle: 'Lato',
				}
			}      
		}
	});
	
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
var data = ''<?php //echo $products; ?>;
var program = <?php echo $programs; ?>;
var audiencebychannel = <?php echo $audiencebychannel; ?>;




$(function () {	
var fieldas = $('#product_program').val();
var start_date2 = $('#start_date2').val();
var end_date2 = $('#end_date2').val();

var search_val = $( "input[aria-controls='example3']" ).val();

//alert(search_val);

  var user_id = $.cookie(window.cookie_prefix + "user_id");
              var token = $.cookie(window.cookie_prefix + "token");    
//console.log(program); 
	// $('.dd').nestable('collapseAll');

    // $('.datepicker').bootstrapMaterialDatePicker({
        // format: 'DD/MM/YYYY',
        // clearButton: true,
        // weekStart: 1,
        // time: false
    // });
	
	

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
				{ data: 'TVR' ,"sClass": "right"},
						{ data: 'TVS' ,"sClass": "right"},
						{ data: 'VIEWERS' ,"sClass": "right"},
						{ data: 'AUDIENCE' ,"sClass": "right"},
						{ data: 'REACH' ,"sClass": "right"},
						{ data: 'INDEX' ,"sClass": "right"}
		]
	}).on('order.dt search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
	  
	   table4.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1; 
        } );
	  //console.log(input.value)
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
		"ajax": "<?php echo base_url().'tvprogramuntrans/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&start_date2="+start_date2+"&end_date2="+end_date2+"&searchtxt="+search_val+"&check=False"+"&check2=True",
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
	  //console.log(input.value)
	});	
	
		Highcharts.chart('container6', {
        title: {
            text: '',
            x: -20 //center
        },

        xAxis: {
            categories: [<?php echo join($json_date, ',') ?>],
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
            name: 'Audience',
            data: [<?php echo join($json_spot_date, ',') ?>],
			color: "#4a4d54"
        }]
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
                text: 'Audience'
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
			color: "#4a4d54"

        }]
    });
	
	$('#channel_export').on('click', function() {
	  //alert(table4.search())
	  
		if($('#fta_channel').is(':checked')){
		
			var check = "True";
		}else{
			var check = "False";
		
		}
	  
		var form_data = new FormData();  
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		//var week = $('#week1').val();
		//var tgl = $('#tgl1').val();
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var tipe_filter = "live";
		var check = check;
		var profile_chan = $('#profile_chan').val();
		//var hariakhir = $('#hariakhir').val();
		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('start_date', start_date);
		form_data.append('check', check);
		form_data.append('end_date', end_date);
		form_data.append('tipe_filter', tipe_filter);
		form_data.append('profile', profile_chan);
	  
	  //console.log(form_data);
	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramuntrans/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('https://inrate.id/tmp_doc/Audience_by_channel.xls','Audience_by_channel.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
	$('#program_export').on('click', function() {
	  //alert(table4.search())
	  
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
		
		//alert(tipe_filter_prog);
		
		var bulan = $('#bulan').val();
		var start_date2 = $('#start_date2').val();
		var end_date2 = $('#end_date2').val();
		var profile_prog = $('#profile_prog').val();
		// var hariawal = $('#hariawal2').val(); 
		// var hariakhir = $('#hariakhir2').val();
		var week = $('#week2').val();
		form_data.append('tahun', tahun);
		form_data.append('check', check);
		form_data.append('check2', check2);
		form_data.append('channel', channel_prog);
		form_data.append('bulan', bulan);
		form_data.append('tipe_filter_prog', tipe_filter_prog);
		form_data.append('end_date', end_date2);
		form_data.append('start_date', start_date2);
		// form_data.append('hariakhir', hariakhir);
		form_data.append('type', type);
		form_data.append('field', field);
		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('profile', profile_prog);	
		//form_data.append('tgl', tgl);
		
		var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
	  
		//$("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
		
		//$('#table_program').html("");
		
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
	  
	  //console.log(form_data);
	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramuntrans/audiencebar_by_program_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('https://inrate.id/tmp_doc/Audience_by_program.xls','Audience_by_program.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
});

function day_filter(){
	
	//alert($('#channel_ds').val()); 
	
	var start_date_d = $('#start_date_d').val();
	var end_date_d = $('#end_date_d').val();
	var channel_d = $('#channel_ds').val();
	var audiencebar_2 = $('#audiencebar_2').val();
	var interval = $('#interval').val();
	var respondent = $('#respondent').val();
	
	var form_data = new FormData();  
		form_data.append('start_date_d',start_date_d);
		form_data.append('end_date_d',end_date_d);
		form_data.append('channel_d', channel_d);	
		form_data.append('audiencebar_2', audiencebar_2);
		form_data.append('interval', interval);
		form_data.append('respondent', respondent);
		
	
	
	$.ajax({
			url: "<?php echo base_url().'tvprogramuntrans/day_filter'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
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
							name: audiencebar_2,
							data: obj.json_spot_date,
							color: "#4a4d54"
						}]
					});
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	

	
}

function day_view_f(){
	
		var periode = "<?php echo $tahunselected ?>";
		var form_data = new FormData();  
		var audiencebarday = $('#audiencebarday').val();
		form_data.append('audiencebarday', audiencebarday);
		form_data.append('periode',"<?php echo $tahunselected ?>");
		
		$.ajax({
			url: "<?php echo base_url().'tvprogramuntrans/filter_days'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
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
				
				//console.log(obj);
				
				Highcharts.chart('container6', {
					title: {
						text: '',
						x: -20 //center
					},

					xAxis: {
						categories: obj.json_date,
						//categories: ['a','b','c'],
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
								//return  parseFloat(data).toFixed(0);
								//var x = parseFloat(data).toFixed(0);
								//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
							}else{
                return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								//return  parseFloat(data).toFixed(2);
								//var x = parseFloat(data).toFixed(2);
								//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
							}
						}
					}
				]
	});	
		}
	});	
	
}

// function table2_view(){
	
	// var form_data = new FormData();  
	// var type = $('#viewby_program').val();
	// var field = $('#product_program').val();
	// var stype = $('#viewby_program').val();
	
	// form_data.append('type', type);
	// form_data.append('field', field);
	// form_data.append('cond',"<?php echo $cond; ?>");	
	
	// $.ajax({
		// url: "<?php echo base_url().'home/cost_by_program'; ?>", 
		// dataType: 'json',  // what to expect back from the PHP script, if anything
		// cache: false,
		// contentType: false,
		// processData: false,
		// data: form_data,                         
		// type: 'post',
		// success: function(data){
			// $('#table_program').html("");
			// $('#table_program').html('<table id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
			// obj = jQuery.parseJSON(data);

			// $('#example3').DataTable({
				// "bFilter": false,
				// "aaSorting": [],
				// "bLengthChange": false,
				// 'iDisplayLength': 10,
				// "sPaginationType": "simple_numbers",
				// "processing": true,
				// "Info" : false,
				// data: obj,
				// columns: [
					// { data: field },
					// { data: type,"sClass": "right",render: function ( data, type, row ) {
							
							// if(stype == "Spot"){
                // return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
								// //return  parseFloat(data).toFixed(0);
								// //var x = parseFloat(data).toFixed(0);
								// //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
							// }else{
                // return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								// //return  parseFloat(data).toFixed(2);
								// //var x = parseFloat(data).toFixed(2);
								// //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
							// }
							
						// }
					// }
				// ]
	// });	
		// }
	// });	
	
// }



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

			//console.log(data_new);
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

			//console.log(data_new);
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

			//console.log(obj);
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

			//console.log(obj[0]["Loose"]);
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

			//console.log(data_new);
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
	
	// var nest =  $('.dd').nestable('serialize');
	//console.log(JSON.stringify(nest));
	
	$('#filter_text').val(JSON.stringify(nest));
	
	$('#filter_form').submit();
	
	
} 


function viewall(){
	
	

		 
		var tahun = $('#tahun').val();
		
		if(tahun == '2020-September' || tahun == '2020-October' || tahun == '2020-November' || tahun == '2020-December'){
			var url = '<?php echo base_url(); ?>tvprogramuntrans';
		}else{
			var url = '<?php echo base_url(); ?>tvprogramunres2';
		}
		
		var bulan = $('#bulan').val();
		//  console.log(tahun);
		
		  
		 $("#laod").append(' <img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
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
		url: "<?php echo base_url().'tvprogramuntrans/cost_by_program'; ?>", 
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
	//var hariakhir = $('#hariakhir').val();
	
	// var table = $('#example4').DataTable({
	// }).on('search.dt', function() {
	  // var input = $('.dataTables_filter input')[0];
	  // //console.log(input.value)
	// });
	
	//var table = $('#example4').val();
	var filter = table4.search()
	
	//alert(filter);
	
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
	form_data.append('profile', profile_chan);
	
	// $.ajax({
		// url: "<?php echo base_url().'tvprogramuntrans/audiencebar_by_channel_export'; ?>", 
		// dataType: 'text',  // what to expect back from the PHP script, if anything
		// cache: false,
		// contentType: false,
		// processData: false,
		// data: form_data,                         
		// type: 'post',
		// success: function(data){
			
			// download_file('https://inrate.id/tmp_doc/Audience_by_channel.xls','Audience_by_channel.xls');
								
		// }, error: function(obj, response) {
			// console.log('ajax list detail error:' + response);	
		// } 
	// });	
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
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	//var week = $('#week1').val();
	//var tgl = $('#tgl1').val();
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var tipe_filter = "live";
	var check = check;
	var profile_chan = $('#profile_chan').val();
	//var hariakhir = $('#hariakhir').val();
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('start_date', start_date);
	form_data.append('check', check);
	form_data.append('end_date', end_date);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
	//form_data.append('hariakhir', hariakhir);
  
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramuntrans/audiencebar_by_channel'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			// console.log(data); return false;
			//$('#table_program').html("");
			$('#table_program2').html("");
			//$('#table_program2').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rangking</th><th>CHANNEL</th></tr></thead></table>');
			//alert("asasasas");
			// if(field == "Program"){
				// $('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			// }else{
				// $('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			// }
			
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
					$('#table_program2').html('<table id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Rank </th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);

			//console.log(obj);
			
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
						{ data: 'TVR' ,"sClass": "right"},
						{ data: 'TVS' ,"sClass": "right"},
						{ data: 'VIEWERS' ,"sClass": "right"},
						{ data: 'AUDIENCE' ,"sClass": "right"},
						{ data: 'REACH' ,"sClass": "right"},
						{ data: 'INDEX' ,"sClass": "right"}
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
						{ data: 'TVR' ,"sClass": "right"},
						{ data: 'TVS' ,"sClass": "right"},
						{ data: 'VIEWERS' ,"sClass": "right"},
						{ data: 'AUDIENCE' ,"sClass": "right"},
						{ data: 'REACH' ,"sClass": "right"},
						{ data: 'INDEX' ,"sClass": "right"}
					]
				}).on('order.dt search.dt', function() {
				  var input = $('.dataTables_filter input')[0];
				  
				   table4.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
						cell.innerHTML = i+1; 
					} );
				  //console.log(input.value)
				});	
			}
			
			
			
			// var obj = jQuery.parseJSON(data);
			// var data_new = [];
			
			// obj['data'].forEach(myFunction);
			
			
			// function myFunction(item, index) {
				// if(type == "Reach"){
					// data_new.push(parseFloat(item));
				// }else{
					// data_new.push(parseInt(item));
				// }
				
			// }

			// //console.log(data_new);
			// $('#container').html();
			
			// var chart= {
				// type: 'column'
			// };
			// var title = {
			  // text: type+" by Channel"
			// };
			// var subtitle = {
			  // text: ""
			// };
			// var xAxis = {
			  // categories: obj['cat'],
			  // crosshair: true
			// };
			// var yAxis = {
			  // min: 0,
			  // minRange: 0.1,
			  // title: {
				 // text: type
			  // },
			 
			// };
			// var tooltip= {
				// formatter: function () {
					// return type+': <b>' + this.point.y + '</b>';
				// }
			// };
			// var  plotOptions= {
				// column: {
					// pointPadding: 0.2,
					// borderWidth: 0
				// }
			// };
			// var series= [{
				 // name: type,
				 // data:data_new,
				 // color: "#4a4d54"
			  // }
			// ];
			// console.log(data_new);
			// var json = {};

			// json.chart = chart;
			// json.title = title;
			// json.subtitle = subtitle;
			// json.xAxis = xAxis;
			// json.yAxis = yAxis;  
			// json.series = series;
			// json.plotOptions = plotOptions;
			// $('#container').highcharts(json);	
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
	
	//alert(tipe_filter_prog);
	
	var bulan = $('#bulan').val();
	var start_date2 = $('#start_date2').val();
	var end_date2 = $('#end_date2').val();
	var profile_prog = $('#profile_prog').val();
	// var hariawal = $('#hariawal2').val();
	// var hariakhir = $('#hariakhir2').val();
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('channel', channel_prog);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	form_data.append('end_date2', end_date2);
	// form_data.append('hariakhir', hariakhir);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	//form_data.append('tgl', tgl);
	
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
		$('#table_program').html('<table id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}else{
		$('#table_program').html('<table id="example3" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"><th>TVR<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVS<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Viewers<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>REACH<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>INDEX<img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>'); 
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
		"ajax": "<?php echo base_url().'tvprogramuntrans/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&start_date2="+start_date2+"&end_date2="+end_date2+"&check="+check+"&check2="+check2+"&channel="+channel_prog+"&profile="+profile_prog+"&tipe_filter_prog="+tipe_filter_prog,
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
	// var hariawal = $('#hariawal2').val();
	// var hariakhir = $('#hariakhir2').val();
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	// form_data.append('hariakhir', hariakhir);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	form_data.append('tgl', tgl);
	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
	
	$.ajax({
		url: "<?php echo base_url().'tvprogramuntrans/cost_by_program'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
			// if(field == "Program"){
				// $('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			// }else{
				// $('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			// }
					$('#table_program').html('<table id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
			obj = jQuery.parseJSON(data);
			
			//console.log(obj);
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
											//return  parseFloat(data).toFixed(2);
											//var x = parseFloat(data).toFixed(2);
											//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
											//return  parseFloat(data).toFixed(2);
											//var x = parseFloat(data).toFixed(2);
											//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
		url: "<?php echo base_url().'tvprogramuntrans/daypart_view'; ?>", 
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

			//console.log(data_new);
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
		url: "<?php echo base_url().'tvprogramuntrans/day_view'; ?>", 
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
		url: "<?php echo base_url().'tvprogramuntrans/ads_view'; ?>", 
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

			//console.log(data_new);
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
  
	// document.getElementById('js-legend-time').innerHTML = window.widgetSpotByTime.generateLegend();
};                                  

$( document ).ready(function() {
    // var selPeriode = $('#tahun').find('option:selected').text().split('-');
    
    // $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    // $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    // $( ".title-periode3" ).html($(".title-periode3").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    // $( ".title-periode4" ).html($(".title-periode4").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
	
	var selPeriode = $('#tahun').val();
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
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