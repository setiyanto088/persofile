    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Data Dashboard</title>

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
	
	.td {
		font-size: 8px !important;
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
      
        <!-- Dashboard Stats -->
        <!-- / Dashboard Stats -->
		
			  
			   <div class="row">
			   <div class="col-lg-12" style="margin-bottom:10px" >	
									<div class="col-lg-2" >	
										
										<select class="form-control" name="tahun" id="tahun">
											<?php 
												$er = 0;
												foreach($thn as $periode){
													
													if($er < 2){
														if ($periode['TANGGAL']==$tahunselected) {
															echo "<option value=".$periode['TANGGAL']." selected>".$periode['TANGGAL']."</option>";
														}else {
															echo "<option value=".$periode['TANGGAL']." >".$periode['TANGGAL']."</option>";
														}
													}
													
													$er++;
													
												}
											
											?>
										</select>   
								
									</div> 
									<div class="col-lg-3">						
										<button id="filter2" type="button" onClick="filter_period('0')" class="show-tick btn btn-danger">Filter</button>
									</div>
									<div class="col-lg-2">	
										<span><h3>Nasional</h3></span> <label>
									</div>
									<div class="col-lg-5" >						
										<button id="filter2" type="button" onClick="regional('07')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 7</button>
										<button id="filter2" type="button" onClick="regional('06')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 6</button>
										<button id="filter2" type="button" onClick="regional('05')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 5</button>
										<button id="filter2" type="button" onClick="regional('04')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 4</button>
										<button id="filter2" type="button" onClick="regional('03')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 3</button>
										<button id="filter2" type="button" onClick="regional('02')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 2</button>
										<button id="filter2" type="button" onClick="regional('01')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Reg 1</button>
									</div>
								</div>
								  <div class="col-lg-12" style="margin-bottom:10px" >	
									<div class="col-lg-2" >	
										
									
									</div> 
									<div class="col-lg-3">						
									</div>
									<div class="col-lg-2">	
									</div>
									<div class="col-lg-5" >						
										<button id="graph_btn" type="button" onClick="graph_sel()" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">Graph</button>
										<button id="table_btn" type="button" onClick="table_sel()" class="show-tick btn btn-danger pull-right" style="margin-right:5px;"  >Table</button>
										
									
									</div>
								</div>
			   </div>
		
		 <div class="row">
			   <div class="col-lg-6" >	
			   
		    <div class="panel urate-panel urate-panel-result">
              <div class="panel-heading">
                  <h5 class='urate-panel-title'>Top 10 Rank Channel</h5> <div class="pull-right" ><input type="checkbox" value="fta" id="fta_channel" checked='checked' onclick="channel_change();">Include FTA</label></div>
              </div>
              <div class="panel-body">
                  <!-- Nav tabs -->
             
				<div class="result-table" style="overflow-x:hidden">

								<div id="table_program_channel">
									<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="width: 100%; font-size:8px !important;table-layout:fixed;">
										<thead>
											<tr>
												<th style="width:15px" scope="row">Rank <img alt="img" class="cArrowDown" alt="arrow" ></th>
												<th scope="row">Regional 1 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 2 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 3 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 4 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 5 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 6 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 7 <img alt="img" class="cArrowDown" ></th>
											</tr>

										</thead>
									</table>
								</div>
								<div id="table_program_channel_graph" style="display:none">
									<canvas id="myChart1"><canvas>
								</div>
									<button id="filter2" type="button" onClick="detail_channel('channel')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">More Detail</button>
								
                </div>
			 
                  <!-- / Nav tabs -->
              </div>
          </div>
		   
		  </div>
		  
		   <div class="col-lg-6" >	
			   
		    <div class="panel urate-panel urate-panel-result">
              <div class="panel-heading">
                  <h5 class='urate-panel-title'>Top 10 Minipack (by Viewership)</h5>
              </div>
              <div class="panel-body">
                  <!-- Nav tabs -->
             
				<div class="result-table" style="overflow-x:hidden">

								<div id="table_program">
									<table aria-describedby="mydesc"  id="example32" class="table table-striped table-bordered example" style="width: 100%; font-size:8px !important;table-layout:fixed;">
										<thead>
											<tr>
												<th style="width:15px" scope="row">Rank <img alt="img" class="cArrowDown"  alt="arrow"  ></th>
												<th scope="row">Regional 1 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 2 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 3 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 4 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 5 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 6 <img alt="img" class="cArrowDown" ></th>
												<th scope="row">Regional 7 <img alt="img" class="cArrowDown" ></th>
											</tr>

										</thead>
									</table>
								</div>
								<div id="table_program_pack_graph" style="display:none">
										<canvas id="myChart2"><canvas>
									</div>
									<button id="filter2" type="button" onClick="detail_channel('minipack')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">More Detail</button>
                </div>
			 
                  <!-- / Nav tabs -->
              </div>
          </div>
		  
		  </div>
		  
		   <div class="col-lg-12" >	
			   
		    <div class="panel urate-panel urate-panel-result">
              <div class="panel-heading">
                  <h5 class='urate-panel-title' >Top 10 Programs </h5> <div class="pull-right"  ><input type="checkbox" value="fta" id="fta_channel_program" checked='checked' onclick="program_change();">Include FTA</label></div>
              </div>
              <div class="panel-body">
                  <!-- Nav tabs -->
             
				<div class="result-table" style="overflow-x:hidden">

								<div id="table_program_program">
									<table aria-describedby="mydesc"  id="example34" class="table table-striped table-bordered example" style=" font-size:11px !important;table-layout:fixed;">
										<thead>
											<tr>
												<th rowspan="2" scope="col">Rank <img alt="img" class="cArrowDown"  alt="arrow" ></th>
												<th colspan="2" scope="row">Regional 1 <img alt="img" class="cArrowDown" ></th>
												
												<th colspan="2" scope="row">Regional 2 <img alt="img" class="cArrowDown"  alt="arrow" ></th>
												<th colspan="2" scope="row">Regional 3 <img alt="img" class="cArrowDown" ></th>
												<th colspan="2" scope="row">Regional 4 <img alt="img" class="cArrowDown" ></th>
												<th colspan="2" scope="row">Regional 5 <img alt="img" class="cArrowDown" ></th>
												<th colspan="2" scope="row">Regional 6 <img alt="img" class="cArrowDown" ></th>
												<th colspan="2" scope="row">Regional 7 <img alt="img" class="cArrowDown" ></th>
												
											</tr>
											<tr>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Program<img alt="img" class="cArrowDown" ></th>
												<th scope="row">Channel<img alt="img" class="cArrowDown" ></th>
											</tr>

										</thead>
									</table>
									
								</div>
									<div id="table_program_program_graph" style="display:none">
										  <div class="col-lg-3" >	
										  </div>
										   <div class="col-lg-6" >	
											<canvas id="myChart3"><canvas>
										  </div>
										   <div class="col-lg-3" >	
										  </div>
										
									</div>
									 <div class="col-lg-12" >	
								<button id="filter2" type="button" onClick="detail_channel('program')" class="show-tick btn btn-danger pull-right" style="margin-right:5px;">More Detail</button>
								</div>
                </div>
			 
                  <!-- / Nav tabs -->
              </div>
          </div>
		  
		  </div>
		  
		  </div>
		
        <!-- Dashboard Widget -->
      
        <!-- / Dashboard Widget -->
        <!-- / Content -->
      </div>
    </div>
  </div>
  <!-- / Main Contaner -->


 
  <script src="<?php echo $path;?>assets/js/table.js"></script>
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
  <script src="<?php echo $path;?>assets/js/widget.js"></script>
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

function graph_sel(){
	
		
		document.getElementById('table_program_channel').style.display = 'none';
		document.getElementById('table_program').style.display = 'none';
		document.getElementById('table_program_program').style.display = 'none';
		document.getElementById('table_program_channel_graph').style.display = 'block';
		document.getElementById('table_program_pack_graph').style.display = 'block';
		document.getElementById('table_program_program_graph').style.display = 'block';
		

		  
         
	
	
}

function table_sel(){
	

	document.getElementById('table_program_channel').style.display = 'block';
	document.getElementById('table_program').style.display = 'block';
	document.getElementById('table_program_program').style.display = 'block';
	document.getElementById('table_program_channel_graph').style.display = 'none';
	document.getElementById('table_program_pack_graph').style.display = 'none';
	document.getElementById('table_program_program_graph').style.display = 'none';
	
}


function timesec(id){
	
	document.getElementById("modal_filter").focus();
	
	$("#id_time").val(id);
	$("#modal_time").modal("show");
	
	
}

function program_change(){
	
	
	if($('#fta_channel_program').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	 $("#table_program_program").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
			var form_data = new FormData();  
			var tahun = $('#tahun').val();
			
			form_data.append('tahun', tahun);
			form_data.append('check', check);
			form_data.append('reg', "0");
			
			$.ajax({
				url: "<?php echo base_url().'dashboarduseetv/filter_program'; ?>", 
				dataType: 'json',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(data){
					$('#table_program_program').html("");
					
					var table_html = '<table aria-describedby="mydesc"  id="example34" class="table table-striped table-bordered example" style=" font-size:11px !important;table-layout:fixed;"><thead><tr><th rowspan="2">Rank <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 1 <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 2 <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 3 <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 4 <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 5 <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 6 <img alt="img" class="cArrowDown" ></th><th colspan="2">Regional 7 <img alt="img" class="cArrowDown" ></th></tr><tr><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th><th>Program<img alt="img" class="cArrowDown" ></th><th>Channel<img alt="img" class="cArrowDown" ></th></tr></thead></table>';
					
					$('#table_program_program').html(table_html);
					
					$('#example34').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"bPaginate": false,
					"Info" : false,
					"bInfo" : false,
					 "searching": false,
					 "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: data.table,
					columns: [
						{ data: 'RANK' },
						{ data: '01_PROGRAM' },
						{ data: '01_CHANNEL' },
						{ data: '02_PROGRAM' },
						{ data: '02_CHANNEL' },
						{ data: '03_PROGRAM' },
						{ data: '03_CHANNEL' },
						{ data: '04_PROGRAM' },
						{ data: '04_CHANNEL' },
						{ data: '05_PROGRAM' },
						{ data: '05_CHANNEL' },
						{ data: '06_PROGRAM' },
						{ data: '06_CHANNEL' },
						{ data: '07_PROGRAM' },
						{ data: '07_CHANNEL' }

					]
				});	

				
				 var ctx3 = document.getElementById("myChart3").getContext('2d');
          
				var options3 = {
				  scaleShowLabels : false,
				  type: 'horizontalBar',
				  data: {
					labels: data.field_prog,
					datasets: [
						{
						  
						  data: data.value_prog,
						  backgroundColor: "#85C1E9", 
						borderWidth: 1
						}
						]
				  },
				  options: {
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
						ticks: {
									reverse: false,
									
						}
					  }],
					  xAxes: [{
						ticks: {
									reverse: false,
									display:false
						}
					  }]
					}
				  }
				}

				new Chart(ctx3, options3);
				
				
				}
		
			});	
	
	
	
}

function channel_change(){
	
	
	if($('#fta_channel').is(':checked')){
		
		var check = "True";
	}else{
		var check = "False";
	
	}
	
	 $("#table_program_channel").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
			var form_data = new FormData();  
			var tahun = $('#tahun').val();
			
			form_data.append('tahun', tahun);
			form_data.append('check', check);
			form_data.append('reg', "0");
			
			$.ajax({
				url: "<?php echo base_url().'dashboarduseetv/filter_channel'; ?>", 
				dataType: 'json',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(data){
					
					
					$('#table_program_channel').html("");
					
					var table_html = '<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="width: 100%; font-size:8px !important;table-layout:fixed;"><thead><tr><th class="sorting" style="width: 51.0104px !important;">Rank <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px;" class="sorting">Regional 1 <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px !important;" class="sorting">Regional 2 <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px; !important" class="sorting">Regional 3 <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px; !important" class="sorting">Regional 4 <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px; !important" class="sorting">Regional 5 <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px; !important" class="sorting">Regional 6 <img alt="img" class="cArrowDown" ></th><th style="width: 51.0104px; !important" class="sorting">Regional 7 <img alt="img" class="cArrowDown" ></th></tr></thead></table>';
					 
					$('#table_program_channel').html(table_html);
					
					$('#example3').DataTable({
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 16,
						"bPaginate": false,
						"Info" : false,
						"bInfo" : false,
						 "searching": false,
						 "scrollX": true,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: data.table,
						columns: [
							{ data: 'RANK' },
							{ data: '01' },
							{ data: '02' },
							{ data: '03' },
							{ data: '04' },
							{ data: '05' },
							{ data: '06' },
							{ data: '07' }
						]
					});	
					
					
						var ctx = document.getElementById("myChart1").getContext('2d');
          
						var options = {
						  scaleShowLabels : false,
						  type: 'horizontalBar',
						  data: {
							labels: data.field_channel,
							datasets: [
								{
								  
								  data: data.value_channel,
								  backgroundColor: "#85C1E9", 
								borderWidth: 1
								}
								]
						  },
						  options: {
							legend: {
								display: false
							},
							scales: {
								yAxes: [{
								ticks: {
											reverse: false,
											
								}
							  }],
							  xAxes: [{
								ticks: {
											reverse: false,
											display:false
								}
							  }]
							}
						  }
						}

						new Chart(ctx, options);
					
					
				}
		
			});	
	
	
	
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





    

  

});

$( document ).ready(function() {				

 var location_type = '<?php echo $this->session->userdata('id_unit') ?>';
 
if(location_type == 0 ){
	
	$('#example3').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 16,
		"bPaginate": false,
		"Info" : false,
		"bInfo" : false,
		 "searching": false,
		 "scrollX": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		data: program,
		columns: [
			{ data: 'RANK' },
			{ data: '01' },
			{ data: '02' },
			{ data: '03' },
			{ data: '04' },
			{ data: '05' },
			{ data: '06' },
			{ data: '07' }
		]
	});	
	
	$('#example32').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 16,
		"bPaginate": false,
		"Info" : false,
		"bInfo" : false,
		 "searching": false,
		 "scrollX": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		data: minipack,
		columns: [
			{ data: 'RANK' },
			{ data: '01' },
			{ data: '02' },
			{ data: '03' },
			{ data: '04' },
			{ data: '05' },
			{ data: '06' },
			{ data: '07' }
			
		]
	});	
	
	
	$('#example34').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 16,
		"bPaginate": false,
		"Info" : false,
		"bInfo" : false,
		 "searching": false,
		 "scrollX": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		data: prg,
		columns: [
			{ data: 'RANK' },
			{ data: '01_PROGRAM' },
			{ data: '01_CHANNEL' },
			{ data: '02_PROGRAM' },
			{ data: '02_CHANNEL' },
			{ data: '03_PROGRAM' },
			{ data: '03_CHANNEL' },
			{ data: '04_PROGRAM' },
			{ data: '04_CHANNEL' },
			{ data: '05_PROGRAM' },
			{ data: '05_CHANNEL' },
			{ data: '06_PROGRAM' },
			{ data: '06_CHANNEL' },
			{ data: '07_PROGRAM' },
			{ data: '07_CHANNEL' }

		]
	});	
	
}else{
	
	var url = '<?php echo base_url(); ?>dashboarduseetv/regional';
		var tahun = $('#tahun').val();
		var bulan = "";
		  
		 $("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='regional' value='0<?php echo $this->session->userdata('id_unit') ?>' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();

}


 var ctx3 = document.getElementById("myChart3").getContext('2d');
          
		var options3 = {
		  scaleShowLabels : false,
		  type: 'horizontalBar',
		  data: {
			labels: <?php echo $field_prog ?>,
			datasets: [
				{
				  
				  data: <?php echo $value_prog ?>,
				  backgroundColor: "#85C1E9", 
				borderWidth: 1
				}
				]
		  },
		  options: {
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
				ticks: {
							reverse: false,
							
				}
			  }],
			  xAxes: [{
				ticks: {
							reverse: false,
							display:false
				}
			  }]
			}
		  }
		}

		new Chart(ctx3, options3);



 var ctx2 = document.getElementById("myChart2").getContext('2d');
          
		var options2 = {
		  scaleShowLabels : false,
		  type: 'horizontalBar',
		  data: {
			labels: <?php echo $field_pact ?>,
			datasets: [
				{
				  
				  data: <?php echo $value_pact ?>,
				  backgroundColor: "#85C1E9", 
				borderWidth: 1
				}
				]
		  },
		  options: {
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
				ticks: {
							reverse: false,
							
				}
			  }],
			  xAxes: [{
				ticks: {
							reverse: false,
							display:false
				}
			  }]
			}
		  }
		}

		new Chart(ctx2, options2);


 var ctx = document.getElementById("myChart1").getContext('2d');
          
		var options = {
		  scaleShowLabels : false,
		  type: 'horizontalBar',
		  data: {
			labels: <?php echo $field_channel ?>,
			datasets: [
				{
				  
				  data: <?php echo $value_channel ?>,
				  backgroundColor: "#85C1E9", 
				borderWidth: 1
				}
				]
		  },
		  options: {
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
				ticks: {
							reverse: false,
							
				}
			  }],
			  xAxes: [{
				ticks: {
							reverse: false,
							display:false
				}
			  }]
			}
		  }
		}

		new Chart(ctx, options);

	
var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

});

var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';

var program = <?php echo $channels_rank; ?>;
var minipack = <?php echo $minipack_rank; ?>;
var prg = <?php echo $program_rank; ?>;


$(function () {	

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
		"sPaginationType": "full_numbers",
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
	
	
	
	
	$('#example4').DataTable({
		"rowCallback": function(row, data, index){
						
					
						if(data['LOAD_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['LOAD_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['CLEANSING_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_CDR_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['RATING_PERMINUTES'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['TVCC'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MEDIAPLAN'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DASHBOARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['BEFORE_AFTER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MIGRATION'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AUDIENCE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 16,
		"sPaginationType": "simple_numbers",
		"Info" : false,
		 "searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		"scrollX": true,
		data: daily,
		columns: [
			{ data: 'LOG_DATE' },
			{ data: 'LOAD_EPG' },
			{ data: 'SPLIT_EPG' },
			{ data: 'LOAD_CDR' },
			{ data: 'CLEANSING_CDR' },
			{ data: 'SPLIT_CDR' },
			{ data: 'JOIN_CDR_EPG' },
			{ data: 'RATING_PERMINUTES' },
			{ data: 'TVCC' },
			{ data: 'MEDIAPLAN' },
			{ data: 'DASHBOARD' },
			{ data: 'BEFORE_AFTER' },
			{ data: 'MIGRATION' },
			{ data: 'AUDIENCE' },
			{ data: 'SUCC' }
			
		]
	});	


});

function color(types,field){
	
	
	
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
			$('#table_program1').html('<table aria-describedby="mydesc"  id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+'</th><th>'+type+'</th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

			$('#example2').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "full_numbers",
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

function detail_channel(filter){
	
		var url = '<?php echo base_url(); ?>dashboarduseetv/detail';
		var tahun = $('#tahun').val();
		var bulan = "";
		  
		 $("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='filter' value='" + filter + "' />" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='regional' value='0' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	    
}


function regional(reg){
	
		var url = '<?php echo base_url(); ?>dashboarduseetv/regional';
		var tahun = $('#tahun').val();
		var bulan = "";
		  
		 $("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='regional' value='" + reg + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	    
}

function filter_period(regional){
	
		var url = '<?php echo base_url(); ?>dashboarduseetv';
		var tahun = $('#tahun').val();
		var bulan = "";
		  
		 $("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='regional' value='" + regional + "' />" +
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
  
  $("#container").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 60px; width: 100%; height: 400px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/audiencebar_by_channel'; ?>", 
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

function checkdata_day(date_file,type){
	
	var form_data = new FormData();  
	
	form_data.append('date_file', date_file);
	form_data.append('type', type);
	
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/checkdata_day'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			window.location.href = "<?php echo base_url();?>dashboarduseetv/";
		}
	});
	
}

function check(){
	
	var form_data = new FormData();  
	var types = $('#product_program2').val();
	var tahun = $('#periode_nn').val();
	var detail_file = $('#detail_file').val();
	
	form_data.append('tahun', tahun);
	form_data.append('type', types);
	form_data.append('detail_file', detail_file);
	
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/checkdata'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			window.location.href = "<?php echo base_url();?>dashboarduseetv/";
		}
	});
	
}

function table2_view2(){
	
	var form_data = new FormData();  
	var types = $('#product_program2').val();
	var tahun = $('#tahun2').val();
	var detail_file = $('#detail_file').val();
	
	$('#periode_nn').val(tahun);
	form_data.append('tahun', tahun);
	form_data.append('type', types);
	form_data.append('detail_file', detail_file);


	 $.ajax({
		url: "<?php echo base_url().'dashboarduseetv/datadash'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program2').html("");

			if(types == "1"){
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_EPG <img alt="img" class="cArrowDown" ></th><th>SPLIT_EPG<img alt="img" class="cArrowDown" ></th><th>LOAD_CDR<img alt="img" class="cArrowDown" ></th><th>CLEANSING_CDR <img alt="img" class="cArrowDown" ></th><th>SPLIT_CDR<img alt="img" class="cArrowDown" ></th><th>JOIN_CDR_EPG<img alt="img" class="cArrowDown" ></th><th>RATING_PERMINUTES <img alt="img" class="cArrowDown" ></th><th>TVCC<img alt="img" class="cArrowDown" ></th><th>MEDIAPLAN<img alt="img" class="cArrowDown" ></th><th>DASHBOARD<img alt="img" class="cArrowDown" ></th><th>BEFORE_AFTER<img alt="img" class="cArrowDown" ></th><th>MIGRATION <img alt="img" class="cArrowDown" ></th><th>AUDIENCE<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');

				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['LOAD_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['CLEANSING_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_CDR_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['RATING_PERMINUTES'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['TVCC'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MEDIAPLAN'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DASHBOARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['BEFORE_AFTER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MIGRATION'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AUDIENCE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
						}
						
					
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_EPG' },
						{ data: 'SPLIT_EPG' },
						{ data: 'LOAD_CDR' },
						{ data: 'CLEANSING_CDR' },
						{ data: 'SPLIT_CDR' },
						{ data: 'JOIN_CDR_EPG' },
						{ data: 'RATING_PERMINUTES' },
						{ data: 'TVCC' },
						{ data: 'MEDIAPLAN' },
						{ data: 'BEFORE_AFTER' },
						{ data: 'DASHBOARD' },
						{ data: 'MIGRATION' },
						{ data: 'AUDIENCE' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "2" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>SPLIT_LOGPROOF<img alt="img" class="cArrowDown" ></th><th>JOIN_LOGPROOF_CDR<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>PTV_CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_BRAND<img alt="img" class="cArrowDown" ></th><th>REACH_AGENCY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['PTV_CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['PTV_CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_BRAND'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_BRAND'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_AGENCY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_AGENCY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_LOGPROOF' },
						{ data: 'SPLIT_LOGPROOF' },
						{ data: 'JOIN_LOGPROOF_CDR' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'PTV_CIM_RATING' },
						{ data: 'REACH_BRAND' },
						{ data: 'REACH_AGENCY' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "3" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>SPLIT_LOGPROOF<img alt="img" class="cArrowDown" ></th><th>JOIN_LOGPROOF_CDR<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>PTV_CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_BRAND<img alt="img" class="cArrowDown" ></th><th>REACH_AGENCY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['PTV_CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['PTV_CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_BRAND'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_BRAND'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_AGENCY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_AGENCY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_LOGPROOF' },
						{ data: 'SPLIT_LOGPROOF' },
						{ data: 'JOIN_LOGPROOF_CDR' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'PTV_CIM_RATING' },
						{ data: 'REACH_BRAND' },
						{ data: 'REACH_AGENCY' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "4" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_CIM <img alt="img" class="cArrowDown" ></th><th>SPLIT_CIM<img alt="img" class="cArrowDown" ></th><th>DETAIL_CIM<img alt="img" class="cArrowDown" ></th><th>CIM_RATING<img alt="img" class="cArrowDown" ></th><th>DASHBOARD<img alt="img" class="cArrowDown" ></th><th>REACH_PRODUCT<img alt="img" class="cArrowDown" ></th><th>REACH_SECTOR<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>REACH_PRODUCT_MONTHLY<img alt="img" class="cArrowDown" ></th><th>REACH_SECTOR_MONTHLY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER_MONTHLY<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_CIM'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_CIM'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_CIM'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_CIM'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_CIM'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_CIM'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						
						if(data['DASHBOARD_POSTBUY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DASHBOARD_POSTBUY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_PRODUCT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_PRODUCT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_SECTOR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_SECTOR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_PRODUCT_MONTHLY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_PRODUCT_MONTHLY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_SECTOR_MONTHLY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_SECTOR_MONTHLY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER_MONTHLY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(11)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER_MONTHLY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
						}
						
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_CIM' },
						{ data: 'SPLIT_CIM' },
						{ data: 'DETAIL_CIM' },
						{ data: 'CIM_RATING' },
						{ data: 'DASHBOARD_POSTBUY' },
						{ data: 'REACH_PRODUCT' },
						{ data: 'REACH_SECTOR' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'REACH_PRODUCT_MONTHLY' },
						{ data: 'REACH_SECTOR_MONTHLY' },
						{ data: 'REACH_ADVERTISER_MONTHLY' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "5" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_RATECARD <img alt="img" class="cArrowDown" ></th><th>CLEANSING_RATECARD<img alt="img" class="cArrowDown" ></th><th>SPLIT_RATECARD<img alt="img" class="cArrowDown" ></th><th>DETAIL_RATECARD<img alt="img" class="cArrowDown" ></th><th>RATING_PERMINUTES<img alt="img" class="cArrowDown" ></th><th>MEDIAPLAN_RATING<img alt="img" class="cArrowDown" ></th><th>TVCC<img alt="img" class="cArrowDown" ></th><th>DASHBOARD_MEDIAPLAN<img alt="img" class="cArrowDown" ></th><th>AFTER_BEFORE<img alt="img" class="cArrowDown" ></th><th>MIGRATION<img alt="img" class="cArrowDown" ></th><th>AUDIENCE<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						 
						if(data['LOAD_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_RATECARD'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6'); 
						}
						
						if(data['CLEANSING_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['CLEANSING_RATECARD'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_RATECARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_RATECARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['RATING_PERMINUTES'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['RATING_PERMINUTES'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MEDIAPLAN_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['MEDIAPLAN_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['TVCC'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['TVCC'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
							
						if(data['DASHBOARD_MEDIAPLAN'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DASHBOARD_MEDIAPLAN'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AFTER_BEFORE'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['AFTER_BEFORE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MIGRATION'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['MIGRATION'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AUDIENCE'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(11)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['AUDIENCE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
					
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_RATECARD' },
						{ data: 'CLEANSING_RATECARD' },
						{ data: 'SPLIT_RATECARD' },
						{ data: 'DETAIL_RATECARD' },
						{ data: 'RATING_PERMINUTES' },
						{ data: 'MEDIAPLAN_RATING' },
						{ data: 'TVCC' },
						{ data: 'DASHBOARD_MEDIAPLAN' },
						{ data: 'AFTER_BEFORE' },
						{ data: 'MIGRATION' },
						{ data: 'AUDIENCE' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "7" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>SPLIT_LOGPROOF<img alt="img" class="cArrowDown" ></th><th>JOIN_LOGPROOF_CDR<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>PTV_CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_BRAND<img alt="img" class="cArrowDown" ></th><th>REACH_AGENCY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['PTV_CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['PTV_CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_BRAND'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_BRAND'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_AGENCY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_AGENCY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_LOGPROOF' },
						{ data: 'SPLIT_LOGPROOF' },
						{ data: 'JOIN_LOGPROOF_CDR' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'PTV_CIM_RATING' },
						{ data: 'REACH_BRAND' },
						{ data: 'REACH_AGENCY' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "8" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>SPLIT_LOGPROOF<img alt="img" class="cArrowDown" ></th><th>JOIN_LOGPROOF_CDR<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>PTV_CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_BRAND<img alt="img" class="cArrowDown" ></th><th>REACH_AGENCY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['PTV_CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['PTV_CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_BRAND'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_BRAND'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_AGENCY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_AGENCY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_LOGPROOF' },
						{ data: 'SPLIT_LOGPROOF' },
						{ data: 'JOIN_LOGPROOF_CDR' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'PTV_CIM_RATING' },
						{ data: 'REACH_BRAND' },
						{ data: 'REACH_AGENCY' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else{
				alert('ssssdsds');
			}

		}
	});	
	
}

function onreproc_f(date_data,type_jobs){
	
	var form_data = new FormData();  
	var tahun = $('#tahun').val();
	
	form_data.append('date_data', date_data);
	form_data.append('type_jobs', type_jobs);
	
	var types = type_jobs;
	
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/insert_queue_rep_f'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
		$('#table_program').html("");
			
			$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>File Name <img alt="img" class="cArrowDown" s></th><th>Size <img alt="img" class="cArrowDown" ></th><th>Row File Count <img alt="img" class="cArrowDown" ></th><th>Row Load<img alt="img" class="cArrowDown" ></th><th>Row Cleansing<img alt="img" class="cArrowDown" ></th><th>Date Load<img alt="img" class="cArrowDown" ></th><th>File Type<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table>');
			
			obj = data;
						
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 16,
							"sPaginationType": "full_numbers",
							"Info" : false,
							"searching": true,
							data: obj,
							columns: [
								{ data: 'Date' },
								{ data: 'file_name' },
								{ data: 'file_size' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
									
									}
								},
								{ data: 'row_file' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
									
									}
								},
								{ data: 'row_load' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
									
									}
								},
								{ data: 'row_cleansing' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
									
									}
								},
								{ data: 'date_load' },
								{ data: 'file_type' },
								{ data:'status'},
								{ data:'check_data'}
							]
						});	

		}
});	

}


function onreproc(date_data,type_jobs){
	
	var form_data = new FormData();  
	var tahun = $('#tahun').val();
	
	form_data.append('date_data', date_data);
	form_data.append('type_jobs', type_jobs);
	
	var types = type_jobs;
	
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/insert_queue_rep'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			
			$('#table_program2').html("");

			if(types == "1"){
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_EPG <img alt="img" class="cArrowDown" ></th><th>SPLIT_EPG<img alt="img" class="cArrowDown" ></th><th>LOAD_CDR<img alt="img" class="cArrowDown" ></th><th>CLEANSING_CDR <img alt="img" class="cArrowDown" ></th><th>SPLIT_CDR<img alt="img" class="cArrowDown" ></th><th>JOIN_CDR_EPG<img alt="img" class="cArrowDown" ></th><th>RATING_PERMINUTES <img alt="img" class="cArrowDown" ></th><th>TVCC<img alt="img" class="cArrowDown" ></th><th>MEDIAPLAN<img alt="img" class="cArrowDown" ></th><th>BEFORE_AFTER<img alt="img" class="cArrowDown" ></th><th>MIGRATION <img alt="img" class="cArrowDown" ></th><th>AUDIENCE<img alt="img" class="cArrowDown" ></th><th>DASHBOARD<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');

				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['LOAD_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['CLEANSING_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_CDR_EPG'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['RATING_PERMINUTES'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['TVCC'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MEDIAPLAN'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['BEFORE_AFTER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MIGRATION'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AUDIENCE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DASHBOARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(14)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
						}
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_EPG' },
						{ data: 'SPLIT_EPG' },
						{ data: 'LOAD_CDR' },
						{ data: 'CLEANSING_CDR' },
						{ data: 'SPLIT_CDR' },
						{ data: 'JOIN_CDR_EPG' },
						{ data: 'RATING_PERMINUTES' },
						{ data: 'TVCC' },
						{ data: 'MEDIAPLAN' },
						{ data: 'DASHBOARD' },
						{ data: 'BEFORE_AFTER' },
						{ data: 'MIGRATION' },
						{ data: 'AUDIENCE' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "2" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>SPLIT_LOGPROOF<img alt="img" class="cArrowDown" ></th><th>JOIN_LOGPROOF_CDR<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>PTV_CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_BRAND<img alt="img" class="cArrowDown" ></th><th>REACH_AGENCY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['PTV_CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['PTV_CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_BRAND'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_BRAND'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_AGENCY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_AGENCY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_LOGPROOF' },
						{ data: 'SPLIT_LOGPROOF' },
						{ data: 'JOIN_LOGPROOF_CDR' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'PTV_CIM_RATING' },
						{ data: 'REACH_BRAND' },
						{ data: 'REACH_AGENCY' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "3" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>SPLIT_LOGPROOF<img alt="img" class="cArrowDown" ></th><th>JOIN_LOGPROOF_CDR<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>PTV_CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_BRAND<img alt="img" class="cArrowDown" ></th><th>REACH_AGENCY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_LOGPROOF'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['JOIN_LOGPROOF_CDR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_LOGPROOF'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['PTV_CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['PTV_CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_BRAND'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_BRAND'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_AGENCY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_AGENCY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_LOGPROOF' },
						{ data: 'SPLIT_LOGPROOF' },
						{ data: 'JOIN_LOGPROOF_CDR' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'PTV_CIM_RATING' },
						{ data: 'REACH_BRAND' },
						{ data: 'REACH_AGENCY' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "4" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_CIM <img alt="img" class="cArrowDown" ></th><th>SPLIT_CIM<img alt="img" class="cArrowDown" ></th><th>DETAIL_CIM<img alt="img" class="cArrowDown" ></th><th>DETAIL_LOGPROOF <img alt="img" class="cArrowDown" ></th><th>CIM_RATING<img alt="img" class="cArrowDown" ></th><th>REACH_PRODUCT<img alt="img" class="cArrowDown" ></th><th>REACH_SECTOR<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER<img alt="img" class="cArrowDown" ></th><th>REACH_PRODUCT_MONTHLY<img alt="img" class="cArrowDown" ></th><th>REACH_SECTOR_MONTHLY<img alt="img" class="cArrowDown" ></th><th>REACH_ADVERTISER_MONTHLY<img alt="img" class="cArrowDown" ></th><th>SUB_CAT<img alt="img" class="cArrowDown" ></th><th>DASHBOARD<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						
						if(data['LOAD_CIM'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_CIM'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_CIM'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_CIM'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_CIM'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_CIM'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['CIM_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['CIM_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_PRODUCT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_PRODUCT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_SECTOR'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_SECTOR'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_PRODUCT_MONTHLY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_PRODUCT_MONTHLY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_SECTOR_MONTHLY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_SECTOR_MONTHLY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['REACH_ADVERTISER_MONTHLY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['REACH_ADVERTISER_MONTHLY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SUB_CAT'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(11)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SUB_CAT'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DASHBOARD_POSTBUY'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(13)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DASHBOARD_POSTBUY'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(13)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_CIM' },
						{ data: 'SPLIT_CIM' },
						{ data: 'DETAIL_CIM' },
						{ data: 'DETAIL_LOGPROOF' },
						{ data: 'CIM_RATING' },
						{ data: 'DASHBOARD_POSTBUY' },
						{ data: 'REACH_PRODUCT' },
						{ data: 'REACH_SECTOR' },
						{ data: 'REACH_ADVERTISER' },
						{ data: 'REACH_PRODUCT_MONTHLY' },
						{ data: 'REACH_SECTOR_MONTHLY' },
						{ data: 'REACH_ADVERTISER_MONTHLY' },
						{ data: 'SUB_CAT' },
						{ data: 'SUCC' }
						
					]
				});	
			}else if(types == "5" ){
				
				$('#table_program2').html('<div id="table_program2"><table aria-describedby="mydesc"  id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>LOAD_RATECARD <img alt="img" class="cArrowDown" ></th><th>CLEANSING_RATECARD<img alt="img" class="cArrowDown" ></th><th>SPLIT_RATECARD<img alt="img" class="cArrowDown" ></th><th>DETAIL_RATECARD<img alt="img" class="cArrowDown" ></th><th>RATING_PERMINUTES<img alt="img" class="cArrowDown" ></th><th>MEDIAPLAN_RATING<img alt="img" class="cArrowDown" ></th><th>TVCC<img alt="img" class="cArrowDown" ></th><th>AFTER_BEFORE<img alt="img" class="cArrowDown" ></th><th>MIGRATION<img alt="img" class="cArrowDown" ></th><th>AUDIENCE<img alt="img" class="cArrowDown" ></th><th>DASHBOARD_MEDIAPLAN<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table></div>');
				
				daily = data;

				$('#example4').DataTable({
					"rowCallback": function(row, data, index){
						 
						if(data['LOAD_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(1)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['LOAD_RATECARD'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(1)', row).css('background-color', '#fdbdc6'); 
						}
						
						if(data['CLEANSING_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(2)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['CLEANSING_RATECARD'] == 'Not Process' ){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(2)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['SPLIT_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(3)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['SPLIT_RATECARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(3)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DETAIL_RATECARD'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(4)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DETAIL_RATECARD'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(4)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['RATING_PERMINUTES'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(5)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['RATING_PERMINUTES'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(5)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MEDIAPLAN_RATING'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(6)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['MEDIAPLAN_RATING'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(6)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['TVCC'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(7)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['TVCC'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(7)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AFTER_BEFORE'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(8)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['AFTER_BEFORE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(8)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['MIGRATION'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(9)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['MIGRATION'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(9)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['AUDIENCE'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(10)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['AUDIENCE'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(10)', row).css('background-color', '#fdbdc6');
						}
						
						if(data['DASHBOARD_MEDIAPLAN'] == 'Failed' ){
							
							$('td:eq(0)', row).css('background-color', '#CDA8D9');
							$('td:eq(12)', row).css('background-color', '#CDA8D9');
							$('td:eq(11)', row).css('background-color', '#CDA8D9');
						}
						
						if(data['DASHBOARD_MEDIAPLAN'] == 'Not Process'){
							
							$('td:eq(0)', row).css('background-color', '#fdbdc6');
							$('td:eq(12)', row).css('background-color', '#fdbdc6');
							$('td:eq(11)', row).css('background-color', '#fdbdc6');
						}
						
						
					},
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 16,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					 "searching": true,
					  "scrollX": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: daily,
					columns: [
						{ data: 'LOG_DATE' },
						{ data: 'LOAD_RATECARD' },
						{ data: 'CLEANSING_RATECARD' },
						{ data: 'SPLIT_RATECARD' },
						{ data: 'DETAIL_RATECARD' },
						{ data: 'RATING_PERMINUTES' },
						{ data: 'MEDIAPLAN_RATING' },
						{ data: 'TVCC' },
						{ data: 'DASHBOARD_MEDIAPLAN' },
						{ data: 'AFTER_BEFORE' },
						{ data: 'MIGRATION' },
						{ data: 'AUDIENCE' },
						{ data: 'SUCC' }
						
					]
				});	
			}else{
				alert('ssssdsds');
			}

		
			
		}
	});	
}

function onqueue(date_data,type_jobs){
	
	var form_data = new FormData();  
var tahun = $('#tahun').val();
	
	form_data.append('date_data', date_data);
	form_data.append('type_jobs', type_jobs);
	form_data.append('tahun', tahun);
	
  $("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 100%;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 100%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
  
	
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/insert_queue'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
			$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>File Name <img alt="img" class="cArrowDown" s></th><th>Size <img alt="img" class="cArrowDown" ></th><th>Row File Count <img alt="img" class="cArrowDown" ></th><th>Row Load<img alt="img" class="cArrowDown" ></th><th>Row Cleansing<img alt="img" class="cArrowDown" ></th><th>Date Load<img alt="img" class="cArrowDown" ></th><th>File Type<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th></tr></thead></table>');
			
			obj = data;

						
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 16,
							"sPaginationType": "full_numbers",
							"Info" : false,
							"searching": true,
							data: obj,
							columns: [
								{ data: 'Date' },
								{ data: 'file_name' },
								{ data: 'file_size' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										//return  parseFloat(data).toFixed(2);
										//var x = parseFloat(data).toFixed(0);
										//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
									}
								},
								{ data: 'row_file' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										//return  parseFloat(data).toFixed(2);
										//var x = parseFloat(data).toFixed(0);
										//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
									}
								},
								{ data: 'row_load' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										//return  parseFloat(data).toFixed(2);
										//var x = parseFloat(data).toFixed(0);
										//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
									}
								},
								{ data: 'row_cleansing' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										//return  parseFloat(data).toFixed(2);
										//var x = parseFloat(data).toFixed(0);
										//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
									}
								},
								{ data: 'date_load' },
								{ data: 'file_type' },
								{ data:'status'},
								{ data:'check_data'}
							]
						});	

		
		}
	});	
			
}

function table2_view(){
	
	var form_data = new FormData();  
	var type = $('#product_program').val();
	var field = "Program";
	var tahun = $('#tahun').val();
	
	form_data.append('tahun', tahun);
	form_data.append('type', type);
	form_data.append('field', field);
	
  
  $("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
  
	$.ajax({
		url: "<?php echo base_url().'dashboarduseetv/cost_by_program'; ?>", 
		dataType: 'json',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
			if(field == "Program"){
				$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th>Date <img alt="img" class="cArrowDown" ></th><th>File Name <img alt="img" class="cArrowDown" s></th><th>Size <img alt="img" class="cArrowDown" ></th><th>Row File Count <img alt="img" class="cArrowDown" ></th><th>Row Load<img alt="img" class="cArrowDown" ></th><th>Row Cleansing<img alt="img" class="cArrowDown" ></th><th>Date Load<img alt="img" class="cArrowDown" ></th><th>File Type<img alt="img" class="cArrowDown" ></th><th>Status<img alt="img" class="cArrowDown" ></th><th>Checking Data<img alt="img" class="cArrowDown" ></th></tr></thead></table>');
			}else{
				$('#table_program').html('<table aria-describedby="mydesc"  id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th><img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> Rangking</th><th><img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> '+field+'</th><th><img alt="img" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"> '+type+'</th></tr></thead></table>');
			}
			
			obj = data;

						
						$('#example3').DataTable({
							"bFilter": false,
							"aaSorting": [],
							"bLengthChange": false,
							'iDisplayLength': 16,
							"sPaginationType": "full_numbers",
							"Info" : false,
							"searching": true,
							data: obj,
							columns: [
								{ data: 'Date' },
								{ data: 'file_name' },
								{ data: 'file_size' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										
									}
								},
								{ data: 'row_file' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
								
									}
								},
								{ data: 'row_load' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										
									}
								},
								{ data: 'row_cleansing' ,"sClass": "right",render: function ( data, type, row ) {
							  return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));            
										
									}
								},
								{ data: 'date_load' },
								{ data: 'file_type' },
								{ data:'status'},
								{ data: 'check_data' }
							]
						});	

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

</script>	
    
</body>

</html>