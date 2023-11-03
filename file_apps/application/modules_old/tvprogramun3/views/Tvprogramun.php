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
		font-weight: bold;
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
		<br>
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
					<option value='2022' <?php  if ($tahunselected=='2022') { echo 'selected'; } ?> >2022</option>
						<?php 
						//print_r($thn);
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
              <div class="icon" style="max-width:52px" >
                <img alt="image" src="<?php echo $path9;?>images/Frame123.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles" >Number of TV Program</span><br>
                <span class="values"><?php echo number_format(intval($spots[0]["spot"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:52px" >
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
              <div class="icon" style="max-width:52px" >
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
              <div class="icon" style="max-width:52px" >
                <img alt="image" src="<?php echo $path9;?>images/Frame1234.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Universe</span><br>
				<span class="values"> <?php echo number_format(intval($totpopulasi[0]["tot_pop"]),0,',','.'); ?> </span>
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
									<label>Data</label>
							<select class="form-control" name="audiencebar" id="audiencebar" required >
								<option value="Audience" selected >Audience</option>
								<option value="Reach" >Reach</option>
								<option value="Viewers" >Total Views</option>
								<option value="Duration" >Duration</option>
								<option value="avgtotdur" >AVG Dur/Views</option>
								<option value="share" >Audience Share</option>
								<option value="TVR" >TVR</option>
								<option value="TVS" >TVS</option>
								<option value="viewers2" >Viewers</option>
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
							<div class="form-group">
									<label>Type</label>
							<select class="form-control" name="tipe_filter" id="tipe_filter" required >
								<option value="live" selected >Live</option>
								<option value="ALL" >All</option>
								<option value="TVOD" >TVOD</option>
							</select> 
							</div>
							</div>
							
						</div>
						
					</div>
					
					
					<div class="col-lg-12" style="margin-top:25px">	
					
					<div class="" style="" ><input type="checkbox" value="fta" id="fta_channel" checked='checked' onclick="channel_change();">Include FTA</label></div>
					<div id="table_program2" style="margin-top:-30px">
						<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>

							</thead>
						</table>
					</div>
					
					</div>
                 </div>
            </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
             <div class="panel urate-panel urate-panel-result row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
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
									<label>Day</label>						
							<select  id="tgl2" name="tgl2" class="form-control">
							  
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
							<select  id="week2" name="week2" class="form-control">
							  
							  <?php 
								echo '<option value="ALL"  >'.'All Weeks</option>';
								for ($i=0;$i<=count($mingguan2)-1;$i++){
									$w=$i+1;
									echo '<option value='.$mingguan2[$i]['WEEK'].'  >'.'Week '.$w.'</option>';
								}
							  ?>
							</select> 
							</div>
						</div>
						<div class="col-lg-3">
						<div class="form-group">
									<label>Data</label>
							<select class="form-control" name="product_program" id="product_program"  >
								<option value="Audience" selected >Audience</option>
 								<option value="Reach" >Reach</option>
								<option value="Viewers" >Total Views</option>
								<option value="Duration" >Duration</option>
								<option value="avgtotdur" >AVG Dur/Views</option>
								<option value="avgtotaud" >AVG Dur/Audience</option>
								<option value="Viewers2" >Viewers</option>
								<option value="TVR2" >TVR</option>
								<option value="TVS" >TVS</option>
							</select>
							</div>
						</div>						
						<div class="col-lg-3">
						<div class="form-group">
									<label>Profile</label>
							<select class="form-control" name="profile_prog" id="profile_prog"  >
								<option value="0" selected >All People</option>
								<?php foreach($profile as $prfss){
									
									echo '<option value='.$prfss['id'].'  >'.$prfss['name'].'</option>';
								} ?>
							</select>
							</div>
						</div>
						<div class="col-lg-3">
						<div class="form-group">
									<label>Type</label>
						<select class="form-control" name="tipe_filter_prog" id="tipe_filter_prog" required >
							<option value="live" selected >Live</option>
							<option value="ALL" >All</option>
							<option value="TVOD" >TVOD</option>
						</select> 
						</div>
						</div>

						
					
						<div class="col-lg-3">
							<div class="form-group">
										<label>Channel</label>
							<select class="form-control" name="channel_prog" id="channel_prog" required >
								<option value="All" selected >All Channel</option>
								<?php foreach($channel_list as $channel_lists){
									
									$channel_ff = str_replace("+","_",$channel_lists['CHANNEL']);
									
								echo '<option value="'.$channel_ff.'" >'.$channel_lists['CHANNEL'].'</option>';
								
								 } ?>
							</select> 
							</div>
						</div>
						</div>
					</div>
					
					<div class="col-lg-12" style="margin-top:25px">	
					
						
						<input type="checkbox" value="fta" id="fta_program" checked='checked' onclick="program_change();">Include FTA</label>
						
						<div id="table_program" style="margin-top:-30px">
							<table aria-describedby="table" id="example3" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
										<th scope="row">Program <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
										<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
										<th align="right" scope="row">Audience <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									</tr>

								</thead>
							</table>
						</div>
					
					</div>
                </div>
            </div>
          </div>
		  
		   <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
             <div class="panel urate-panel urate-panel-result row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
			  <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode6" style="font-weight: bold;">Monthly Report</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('monthly')" class="button_white" id="filter_monthly"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
						<button class="button_black" id='channel_export_sum'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
                <div class="widget-content">
				
					<div class="col-lg-12 filter_panel" id="filter_panel_monthly" style="display:none">	
				
					<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view8()" class="button_red">Apply Filter</button>
							 </div>
					</div>
				
					<div class="col-lg-12">	
						<div class="col-lg-3">	
						<div class="form-group">
							<label>Start Periode</label>
							<select class="form-control"  id="tgl1mr" name="tgl1mr" >
							  
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
						</div>
						<div class="col-lg-3">
						<div class="form-group">
							<label>End Periode</label>
						<select class="form-control"  id="tgl2mr" name="tgl2mr"  >
						  
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
						</div>
					
						<div class="col-lg-3">
						<div class="form-group">
							<label>Profile</label>
						<select class="form-control" name="profile_chan8" id="profile_chan8"  >
							<option value="0" selected >All People</option>
							<?php foreach($profile as $prfs){
								
								echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
							} ?>
						</select> 
						</div>
						</div>

					</div>
					 </div>
					
					<div class="col-lg-12" style="margin-top:25px">	
					
					<div class="" style="" ><input type="checkbox" value="fta" id="fta_channel8" checked='checked' onclick="audiencebar_view8();">Include FTA</label></div>
					<div id="table_program28" style="margin-top:-30px">
						<table aria-describedby="table" id="example48" class="table table-striped  example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th rowspan=2  scope="col">Rank <img  class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									<th rowspan=2 scope="col" >Channel <img  class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									<th colspan=5  scope="row"><?PHP ECHO $tahunselected; ?> <img class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									
								</tr>
								<tr>
									<th scope="row">Audience <img  class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									<th scope="row">TVR <img  class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									<th scope="row">TVS <img  class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									<th scope="row">Views <img class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
									<th scope="row">Reach <img  class="cArrowDown" alt="arrow" src="http://localhost/inrate/assets/urate-frontend-master/assets/images/icon_arrowdown.png"></th>
								</tr>

							</thead>
						</table>
					</div>
					
					</div>
					
                   <canvas id="widget-spot-channel" height="100"></canvas>
				  
				 
                </div>
            </div>
          </div>
		  
		  <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
             <div class="panel urate-panel urate-panel-result row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode5" style="font-weight: bold;"> Monthly TVOD</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button class="button_black" id='tvod_export'><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
                <div class="widget-content">

					<div class="col-lg-12" style="margin-top:25px">	
					
				
					<div id="table_program2" style="margin-top:-30px">
						<table aria-describedby="table" id="example5" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Content Name <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Count Distinct Viewer <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Count Viewer <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Duration <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>

							</thead>
						</table>
					</div>
					
					</div>
                 </div>
            </div>
          </div>
          
          <div class="grid-stack-item row" data-gs-min-width="3" data-gs-min-height="2" data-gs-x="0" data-gs-y="2" data-gs-width="3" data-gs-height="2" data-gs-auto-position="1" style="padding:10px">
			<div class="col-md-3" >	
             <div class="panel urate-panel urate-panel-result " style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
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
             <div class="panel urate-panel urate-panel-result" style="border:1px solid #efefef;padding:10px;border-radius: 25px;">
                <div class="navbar-left">
                  <h4 class="title-periode3" style="font-weight:bold">Audience by Daypart</h4>
                </div>
                <div class="widget-content">
                    <div id="container5"></div>                  
                </div>
            </div>
			</div>
			
			
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="12" data-gs-min-height="2" data-gs-x="12" data-gs-y="12" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel urate-panel-result row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
			  
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h4 class="title-periode4">Audience by Day</h4>
							</div>
							 <div class="navbar-right" style="padding:10px;padding-right:10px" >
							 
								 <div class="col-lg-6">
									<select class="form-control" name="audiencebarday" id="audiencebarday" onChange="day_view_f()" required >
										<option value="Audience" selected >Audience</option>
 										<option value="Viewers" >Total Views</option>
										<option value="Duration" >Duration</option> 
									</select> 
								</div>
								<div class="col-lg-6">
									
									<button class="button_black" id='print_days'><em class="fa fa-download"></em>&nbsp Export</button>
									
								</div>
							 </div>
							 
					</div>
			  
			  		
					<br><br> 
                <div class="navbar-center" id='judul_hari'>
                  
                </div>
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
	}else if(type == 'Viewers2'){
		var tpe = 'Viewers';
	}else if(type == 'TVR2'){
		var tpe = 'TVR';
	}else if(type == 'avgtotdur'){
		var tpe = 'Average Duration/Total Views';
	}else{
		var tpe = type;
	}
				
	$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black"><thead style="color:red"><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	
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
		"ajax": "<?php echo base_url().'tvprogramun3/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&tgl2="+tgl+"&week2="+week+"&check="+check+"&tipe_filter_prog="+tipe_filter_prog,
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
		url: "<?php echo base_url().'tvprogramun3/audiencebar_by_channel'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
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
			}else if(type == 'viewers2'){
				var tpe = 'Viewers';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
			}else{
				
				var tpe = type;
			}
					$('#table_program2').html('<table aria-describedby="table" id="example4" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>Rank<img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
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
		//label: 'Spot',
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
var tgl2 = $('#tgl2').val();
var week2 = $('#week2').val();


var tgl1mr = $('#tgl1mr').val();
var tgl2mr = $('#tgl2mr').val();


var search_val = $( "input[aria-controls='example3']" ).val();
var search_val8 = $( "input[aria-controls='example48']" ).val();

 
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
		"ajax": "<?php echo base_url().'tvprogramun3/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl2="+tgl2+"&week2="+week2+"&searchtxt="+search_val+"&check=True",
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});	
	
	
	
	var table34 = $('#example48').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		"processing": true,
        "serverSide": true,
        "destroy": true,
		"ajax": "<?php echo base_url().'tvprogramun3/get_filter_programaud_mr'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl1mr="+tgl1mr+"&tgl2mr="+tgl2mr+"&searchtxt="+search_val8+"&check=True",
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
			{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
					 
				}
			}
		]
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});
	
	var table345 = $('#example5').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		"processing": true,
        "serverSide": true,
        "destroy": true,
		"ajax": "<?php echo base_url().'tvprogramun3/get_filter_programaud_mr_tvod'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+fieldas+ "&tgl1mr="+tgl1mr+"&tgl2mr="+tgl2mr+"&searchtxt="+search_val8+"&check=True",
		"searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        }
	}).on('search.dt', function() {
	  var input = $('.dataTables_filter input')[0];
 	});	
	
	$('#print_days').on('click', function() {
		

		var form_data = new FormData();  
		var tahun = $('#tahun').val();
	
		form_data.append('tahun', tahun);
		
	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3/audiencebar_by_day_export'; ?>", 
			dataType: 'text',   
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_day.xls','Audience_by_day.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
		
	$('#channel_export').on('click', function() {
 	  
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
		var tgl = $('#tgl1').val();
		var tipe_filter = $('#tipe_filter').val();
		var profile_chan = $('#profile_chan').val();
		var check = check;
		
		var filter = table4.search()
			
		form_data.append('cond',filter);
		form_data.append('check', check);
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
		form_data.append('tgl', tgl);
		form_data.append('tipe_filter', tipe_filter);
		form_data.append('profile', profile_chan);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',  
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
	
	$('#channel_export_sum').on('click', function() {
 	  
		if($('#fta_channel8').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var channel_prog = $('#channel_prog').val();
 	var tipe_filter_prog = "live";
	
 	
	var tgl1mr = $('#tgl1mr').val();
	var tgl2mr = $('#tgl2mr').val();
	var profile_prog = $('#profile_chan8').val();
	
		
	var form_data = new FormData();
	
	form_data.append('sess_user_id', user_id);
	form_data.append('sess_token', token);
	form_data.append('periode', '<?php echo $tahunselected ?>');
	form_data.append('pilihprog', type);
	form_data.append('tgl1mr', tgl1mr);
	form_data.append('tgl2mr', tgl2mr);
	form_data.append('check', check);
	form_data.append('channel', channel_prog);
	form_data.append('profile', profile_prog);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3/audiencebar_by_channel_export_sum'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/summary_monthly.xls','summary_monthly.xls');
									
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
		var channel_prog = $('#channel_prog').val();
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
		form_data.append('channel_prog', channel_prog);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3/audiencebar_by_program_export'; ?>", 
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
	
	
	$('#tvod_export').on('click', function() {
 	  
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
		var channel_prog = $('#channel_prog').val();
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
		form_data.append('channel_prog', channel_prog);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun3/audiencebar_by_program_export_tvodm'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_program_tvod.xls','monthly_tvod.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
	  
	});
	
});


function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Hide Filter');
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
			url: "<?php echo base_url().'tvprogramun3/filter_days'; ?>", 
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
						color: "#FF0016"
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
	
		var url = '<?php echo base_url(); ?>tvprogramun3'; 
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
		url: "<?php echo base_url().'tvprogramun3/cost_by_program'; ?>", 
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
	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var tipe_filter = $('#tipe_filter').val();
	var check = check;
	var profile_chan = $('#profile_chan').val();
	//var hariakhir = $('#hariakhir').val();
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('check', check);
	form_data.append('tgl', tgl);
	form_data.append('tipe_filter', tipe_filter);
	form_data.append('profile', profile_chan);
   
  $("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun3/audiencebar_by_channel'; ?>", 
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
			}else if(type == 'Viewers2'){
				var tpe = 'Viewers';
			}else if(type == 'avgtotdur'){
				var tpe = 'Average Duration/Total Views';
			}else if(type == 'share'){
				var tpe = 'Audience Share';
			}else if(type == 'viewers2'){
				var tpe = 'Viewers';
			}else{
				
				var tpe = type;
			}
					$('#table_program2').html('<table aria-describedby="table" id="example4" class="table table-striped example" style="color:black"><thead style="color:red"><tr><th>Rank<img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
		
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

    
    function diff(from, to) {
		
		 var monthNames = [ "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December" ];
			
			
        var arr = [];
        var datFrom = new Date('1 ' + from);
        var datTo = new Date('1 ' + to);
        var fromYear =  datFrom.getFullYear();
        var toYear =  datTo.getFullYear();
        var diffYear = (12 * (toYear - fromYear)) + datTo.getMonth();
    
        for (var i = datFrom.getMonth(); i <= diffYear; i++) {
            arr.push(Math.floor(fromYear+(i/12))+"-"+monthNames[i%12] );
        }        
        
        return arr;
    }

function audiencebar_view8(){

 	if($('#fta_channel8').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var channel_prog = $('#channel_prog').val();
 	var tipe_filter_prog = "live";
	
 	
	var tgl1mr = $('#tgl1mr').val();
	var tgl2mr = $('#tgl2mr').val();
	var profile_prog = $('#profile_chan8').val();
	 
  
	 $("#example48_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	

	var list_array = diff(tgl1mr, tgl2mr);
	 
	 var htl = '';
	 var htl_head = '';
	 var htl_head2 = '';
	for(var ii=0;ii<list_array.length;ii++){
		
		htl_head += '<th colspan=5 >'+list_array[ii]+'<img alt="image" class="cArrowDown" ></th>';
		
		
		htl_head2 += '<th>Audience <img alt="image" class="cArrowDown" ></th><th>TVR <img alt="image" class="cArrowDown" ></th><th>TVS <img alt="image" class="cArrowDown" ></th><th>Views <img alt="image" class="cArrowDown" ></th><th>Reach <img alt="image" class="cArrowDown" ></th>';
		
	}
	
	
	
	var htl = '<table aria-describedby="table" id="example48" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th rowspan=2>Rank <img alt="image" class="cArrowDown" ></th><th rowspan=2 >Channel <img alt="image" class="cArrowDown" ></th>'+htl_head+'</tr><tr>'+htl_head2+'</tr></thead></table>';
	
 	
	$('#table_program28').html('');
	$('#table_program28').html(htl);
	
	var form_data = new FormData();
	
	form_data.append('sess_user_id', user_id);
	form_data.append('sess_token', token);
	form_data.append('periode', '<?php echo $tahunselected ?>');
	form_data.append('pilihprog', type);
	form_data.append('tgl1mr', tgl1mr);
	form_data.append('tgl2mr', tgl2mr);
	form_data.append('check', check);
	form_data.append('channel', channel_prog);
	form_data.append('profile', profile_prog);
	form_data.append('tipe_filter_prog', tipe_filter_prog);

	$.ajax({
		url: "<?php echo base_url().'tvprogramun3/get_filter_programaud_mr2'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			obj = jQuery.parseJSON(data);
			
			var column = [];
			column[0] = { data: 'Rangking' };
			column[1] = { data: 'CHANNEL' };
			var i_d = 2;
				for(var ii=0;ii<list_array.length;ii++){
					
					 column[i_d] =  {data: 'AUDIENCE'+ii,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0))}
					 };
					 i_d++;
					  column[i_d] =  {data: 'TVR'+ii,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))}
					 };
					 i_d++;
					  column[i_d] =  {data: 'TVS'+ii,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))}
					 };
					 i_d++;
					  column[i_d] =  {data: 'VIEWER'+ii,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0))}
					 };
					 i_d++;
					  column[i_d] =  {data: 'REACH'+ii,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))}
					 };
					 i_d++;
					
				}
			
			$('#example48').DataTable({
				  "scrollX": true,
								"bFilter": false,
								"scrollX": true,
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
								columns: column
							});	
			
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
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	var channel_prog = $('#channel_prog').val();
	var tipe_filter_prog = $('#tipe_filter_prog').val();
	
 	
	var bulan = $('#bulan').val();
	var tgl = $('#tgl2').val();
	var profile_prog = $('#profile_prog').val();
	 
	var week = $('#week2').val();
	form_data.append('tahun', tahun);
	form_data.append('channel', channel_prog);
	form_data.append('bulan', bulan);
	form_data.append('tipe_filter_prog', tipe_filter_prog);
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
	}else if(type == 'Viewers2'){
		var tpe = 'Viewers';
	}else if(type == 'TVR2'){
		var tpe = 'TVR';
	}else if(type == 'avgtotaud'){
		var tpe = 'Average Duration/Audience (%)';
	}
	else{
		var tpe = type;
	}

	if(type == 'avgtotaud'){
		$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped example" style="color:black"><thead style="color:red"><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>TVR <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
	}else{
		$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped example" style="color:black"><thead style="color:red"><tr><th>Rank <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+field+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+tpe+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
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
		"ajax": "<?php echo base_url().'tvprogramun3/get_filter_programaud'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&periode=<?php echo $tahunselected ?>&pilihprog="+type+ "&tgl2="+tgl+"&week2="+week+"&check="+check+"&channel="+channel_prog+"&profile="+profile_prog+"&tipe_filter_prog="+tipe_filter_prog,
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
		url: "<?php echo base_url().'tvprogramun3/cost_by_program'; ?>", 
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
		url: "<?php echo base_url().'tvprogramun3/daypart_view'; ?>", 
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
		url: "<?php echo base_url().'tvprogramun3/day_view'; ?>", 
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
		url: "<?php echo base_url().'tvprogramun3/ads_view'; ?>", 
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
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode3" ).html($(".title-periode3").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode4" ).html($(".title-periode4").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
    $( ".title-periode5" ).html($(".title-periode5").html()+"<br><span style='font-size: 12px;color:red'>"+selPeriode+"<span>");
	
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