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
.dataTable > tbody > tr > .right {
		text-align: right;
	  }
	  .dataTable > thead > tr > th {
		text-align: center;
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
                <li class="breadcrumb-item">Free to Air</li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">TV Program Dashboard</li>
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
			
			<div class="col-lg-4">	
				<span id="laod"></span>
			</div>
		 
		</div>
		
		<br/>
		<br/>
		<br/>
		<br/>
          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_spot.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Number of TV Program</span>
                <span class="value"><?php echo number_format(intval($spots[0]["spot"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_cost.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Number of TV Channel</span>
                <span class="value"><?php echo $jmlchannel[0]["jmlch"]; ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_grp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Active Audience</span>
                <span class="value"><?php echo number_format(intval($aa),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_crp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Universe</span>
                <span class="value"><?php echo number_format(intval($totpopulasi[0]["tot_pop"]),0,',','.'); ?>
                
                </span>
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
                      <label for="checkOne"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Channel">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div class="widget-content">
					<div class="col-lg-12">	
						<div class="col-lg-2">	
							<select class="form-control"  id="tgl1" name="tgl1" >
							  
							  <?php 
								echo '<option value="0"  >'.'All Days</option>';
								foreach($tanggal as $ddd){
									
									echo '<option value='.$ddd.'  >'.'Day '.$ddd.'</option>';
								}
							  ?>
							</select> 
						</div>
						<div class="col-lg-2">
						<select class="form-control"  id="week1" name="week1"  >
						  
						  <?php 
							echo '<option value="0"  >'.'All Weeks</option>';
							for ($i=0;$i<=count($mingguan1)-1;$i++){
								$w=$i+1;
								echo '<option value='.$mingguan1[$i]['WEEK'].'  >'.'Week '.$w.'</option>';
							}
						  ?>
						</select> 
						</div>
						<div class="col-lg-3">
						<select class="form-control" name="audiencebar" id="audiencebar" required >
							<option value="Audience" selected >Audience</option>
							<option value="Reach" >Reach</option>
						</select> 
						</div>
						<div class="col-lg-3">
						<select class="form-control" name="profile_chan" id="profile_chan"  >
							<option value="0" selected >All People</option>
							<?php foreach($profile as $prfs){
								
								echo '<option value='.$prfs['id'].'  >'.$prfs['name'].'</option>';
							} ?>
						</select> 
						</div>
						<div class="col-lg-2">
						<button onClick="audiencebar_view()" class="btn btn-danger">Filter</button>
						<button class="btn btn-danger" id='channel_export'>Export</button>
						</div>
					</div>
					
					<br/>
					<br/>
					<br/>
					<br/>
					<div id="container" ></div>
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
						<div class="col-lg-2">		
							<select  id="tgl2" name="tgl2" class="form-control">
							  
							  <?php 
								echo '<option value="0"  >'.'All Days</option>';
								foreach($tanggal as $ddd){
									
									echo '<option value='.$ddd.'  >'.'Day '.$ddd.'</option>';
								}
							  ?>
							</select> 
						</div>
						<div class="col-lg-2">
							<select  id="week2" name="week2" class="form-control">
							  
							  <?php 
								echo '<option value="0"  >'.'All Weeks</option>';
								for ($i=0;$i<=count($mingguan2)-1;$i++){
									$w=$i+1;
									echo '<option value='.$mingguan2[$i]['WEEK'].'  >'.'Week '.$w.'</option>';
								}
							  ?>
							</select> 
						</div>
						<div class="col-lg-3">
							<select class="form-control" name="product_program" id="product_program"  >
								<option value="Audience" selected >Audience</option>
								<option value="TVR" >TVR</option>
								<option value="Reach" >Reach</option>
							</select>
						</div>						
						<div class="col-lg-3">
							<select class="form-control" name="profile_prog" id="profile_prog"  >
								<option value="0" selected >All People</option>
								<?php foreach($profile as $prfss){
									
									echo '<option value='.$prfss['id'].'  >'.$prfss['name'].'</option>';
								} ?>
							</select>
						</div>
						<div class="col-lg-2">						
							<button id="filter2" type="button" onClick="table2_view()" class="show-tick btn btn-danger">Filter</button>
							<button id="program_export" type="button" class="show-tick btn btn-danger">Export</button>
						</div>
					</div>
					<div id="table_program">
						<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="width: 100%">
							<thead>
								<tr>
									<th scope="row">Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Audience <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
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
                <div class="navbar-center">
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
                <div class="navbar-center">
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
	Highcharts.chart('container', {
        chart: {
            type: 'column',
			zoomType: 'x',
			height: 250
        },
        title: {
            text: ''
        },
		
        exporting: {
            enabled: false
        },
        lang: {
			numericSymbols: null  
		},
        xAxis: {
			 
            categories: [<?php if($json_channel == ""){ echo ""; } else { echo join($json_channel, ','); } ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Audience'
            }
        },
     
		tooltip: {
			formatter: function () {
				return 'Audience: <b>' + this.point.y + '</b>';
			}
		},

        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Audience',
            data: [<?php if($json_spot == ""){ echo ""; } else { echo join($json_spot, ','); } ?>],
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
       
        exporting: {
            enabled: false
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
	
	
	
	
	Highcharts.chart('container6', {
        title: {
            text: '',
            x: -20  
        },

        exporting: {
            enabled: false
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
	
	
	
	
	
	
	
	
	
	
	
	
var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

      $("#exportWidget").click(function () {
          var doc = new jsPDF();
          var countPage = 0;
          var namefile = '';

           if($("#checkOne").is(':checked')){
			  
				
				
			
			setTimeout(function(){
			 var chart = $('#container').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'AudienceByChannel'
				});
			 }, 4000); 	
 
          }
			
			
			
           if($("#checkTwo").is(':checked')){
       
			  var docs = new jsPDF('l', 'mm', [297, 210]);
            docs.text(155, 30, 'Audience by Program', null, null, 'center');
           var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docs.text(155, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var elem = document.getElementById("example3");
            var res = docs.autoTableHtmlToJson(elem);
            docs.autoTable(res.columns, res.data, {
                theme: 'plain',
                margin: {
                  top: 50,
                  left: 50,
                  right: 50
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
			  docs.save('Audience by Program.pdf');
			 }, 0);
          }
        
          if($("#checkThree").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Audience By Time', null, null, 'center');
var selPeriode = $('#tahun').find('option:selected').text().split('-');
            doc.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var canvasWidget1 = document.getElementById('widget-spot-time');
            var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
			
            doc.setFillColor(203, 51, 39);
            doc.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            doc.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
 			
			
			setTimeout(function(){
			  doc.save('Audience by Time.pdf');
			 }, 2000);
          }

 		  
		  
		   if($("#checkFour").is(':checked')){
  
			
			setTimeout(function(){
			 var chart = $('#container5').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'SpotbyDaypart'
				});
			 }, 6000); 	
			
          }
          
          if($("#checkFive").is(':checked')){
     
			
			setTimeout(function(){
			var chart = $('#container6').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'SpotByDay'
				});
			 }, 8000); 	
			
			 
          }

           if($("#checkSix").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Table', null, null, 'center');
           
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
            countPage++;
          }
		  
 
      });

 	
});

var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';

var program = <?php echo $programs; ?>;

$(function () {	

		$('#program_export').on('click', function() {
 	  
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
 		form_data.append('pilihprog', type);
		form_data.append('field', field);
		form_data.append('cond',"<?php echo $cond; ?>");
		form_data.append('periode',"<?php echo $tahunselected ?>");
		form_data.append('profile', profile_prog);	
		form_data.append('tgl', tgl);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun/audiencebar_by_program_export'; ?>", 
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

		$('#channel_export').on('click', function() {
 	  
		var form_data = new FormData();  
		var type = $('#audiencebar').val();
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var week = $('#week1').val();
		var tgl = $('#tgl1').val();
		var profile_chan = $('#profile_chan').val();
		
		var filter = '';
			
		form_data.append('cond',filter);
		form_data.append('type', type);
		form_data.append('tahun', tahun);
		form_data.append('bulan', bulan);
		form_data.append('week', week);
		form_data.append('tgl', tgl);
		form_data.append('profile', profile_chan);
	  
 	  
		$.ajax({
			url: "<?php echo base_url().'tvprogramun/audiencebar_by_channel_export'; ?>", 
			dataType: 'text',   
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

	$('#week1').change(function(){
		$('#tgl1').val(0);	
	});
	
	$('#tgl1').change(function(){
		$('#week1').val(0);	
	});
	
	$('#tgl2').change(function(){
		$('#week2').val(0);	
	});
	
	$('#week2').change(function(){
		$('#tgl2').val(0);	
	});
	
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
	
	$('#example3').DataTable({
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
		data: program,
		columns: [
			{ data: 'Rangking' },
			{ data: 'Program' },
			{ data: 'CHANNEL' },
			{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
          return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
					 
				}
			}
		]
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
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			var obj = jQuery.parseJSON(data);

			console.log(obj);
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
	
		var url = '<?php echo base_url(); ?>tvprogramun';
		var tahun = $('#tahun').val();
		var bulan = "";
 		  
		 $("#laod").append(' <img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	    
}


function audiencebar_view(){
	
	var form_data = new FormData();  
	var type = $('#audiencebar').val();
	var tahun = $('#tahun').val();
	var bulan = "";
 	var week = $('#week1').val();
	var tgl = $('#tgl1').val();
	var profile_chan = $('#profile_chan').val();
 	
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
	form_data.append('profile', profile_chan);
   
  $("#container").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 60px; width: 100%; height: 400px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvprogramun/audiencebar_by_channel'; ?>", 
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
				if(type == "Reach"){
					data_new.push(parseFloat(item));
				}else{
					data_new.push(parseInt(item));
				}
				
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
			  min: 0,
			  minRange: 0.1,
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
			$('#container').highcharts(json);	
		}
	});	
}


function table2_view(){
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
 	var bulan = "";
	var profile_prog = $('#profile_prog').val(); 
	var week = $('#week2').val();
	var tgl = $('#tgl2').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('week', week);
	form_data.append('tgl', tgl);
 	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('profile', profile_prog);	
	var cas  = <?php echo $totpopulasi[0]["tot_pop"];?>;
  
  $("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
  
	$.ajax({
		url: "<?php echo base_url().'tvprogramun/cost_by_program'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
			if(field == "Program"){
				$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> Rank</th><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> '+field+'</th><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> Channel</th><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> '+type+'</th></tr></thead></table>');
			}else{
				$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> Rank</th><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> '+field+'</th><th><img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> '+type+'</th></tr></thead></table>');
			}
			
 			obj = data;
			
			console.log(obj);
				if(type == "Reach"){
					if(field == "Program"){
						
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 10,
							"sPaginationType": "simple_numbers",
							"Info" : false,
		 "searching": true,
							data: obj,
							columns: [
								{ data: 'Rangking' },
								{ data: field },
								{ data: 'CHANNEL' },
								{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat((data/cas)*100).toFixed(2));            
									 
									}
								}
							]
						});	
					}else{
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 10,
							"sPaginationType": "simple_numbers",
							"Info" : false,
		 "searching": true,
							data: obj,
							columns: [
							{ data: 'Rangking' },
								{ data: field },
								{ data: 'CHANNEL' },
								{ data: type ,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat((data/cas)*100).toFixed(2));            
										 
									}
								}
							]
						});	
					}
				}else{
					if(field == "Program"){
						
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 10,
							"sPaginationType": "simple_numbers",
							"Info" : false,
		 "searching": true,
							data: obj,
							columns: [
							{ data: 'Rangking' },
								{ data: field },
								{ data: 'CHANNEL' },
								{ data: 'Spot' ,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));            
										 
									}
								}
							]
						});	
					}else{
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 10,
							"sPaginationType": "simple_numbers",
							"Info" : false,
		 "searching": true,
							data: obj,
							columns: [
							{ data: 'Rangking' },
								{ data: field },
								{ data: 'CHANNEL' },
								{ data: type ,"sClass": "right",render: function ( data, type, row ) {
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));            
										 
									}
								}
							]
						});	
					}
				}
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
    var selPeriode = $('#tahun').find('option:selected').text().split('-');
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    $( ".title-periode3" ).html($(".title-periode3").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    $( ".title-periode4" ).html($(".title-periode4").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
});

function show(){
	$('#hs').html('*check widget first before export');
}

$(document).ready(function(){
    $(".table th").on("click",function(){                    
        if($(this).attr("class") == "sorting_asc"){
            $(this).children().css("transform","rotate(180deg)");
        } else if($(this).attr("class") == "sorting_desc"){
            $(this).children().css("transform","rotate(0deg)");
        }
    });
});
</script>	
    
</body>

</html>