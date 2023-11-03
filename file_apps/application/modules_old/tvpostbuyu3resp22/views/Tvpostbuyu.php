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
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/helix-profiling.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/panel.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/box-profile.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tag.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/action-dropdown.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/checkbox.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tree-list.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">

	
   <!-- JQuery DataTable Css -->
    <link href="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
  <style>
	.highcharts-credits{
		display: none;
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
	
	#container6{
		
		overflow: visible !important;
	}
	
	#container5{
		
		overflow: visible !important;
	}
	
	.dt-body-right{
		text-align: right;
	}
  </style>

</head>

<body>

    <!-- / Sidebar -->
    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">                         
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Pay TV</li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Post Buy Dashboard</li>
            </ol>
            <h3 class="page-title">Post Buy Dashboard</h3>
          </div>
          <div class="col-md-7 text-right">
           
			<button data-toggle="modal" href="#addNewWidget" class="button_white"><em class="fa fa-th-large"></em> &nbsp <strong>Edit Widget</strong></button>
			<button onclick="show()" id="exportWidget" class="button_black" data-complete-text="<span class='ion-android-open'></span> Export Now"><em class="fa fa-download"></em> &nbsp <strong>Export</strong></button>
           
            
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
			
				<div class="select-wrapper">
					<select class="form-control" name="tahun" id="tahun" required onChange="viewall()">
						<?php 
 						for ($i=0;$i<count($thn);$i++){
								if ($thn[$i]["tahun"] == $tahunselected) {
									echo "<option value=".$thn[$i]["tahun"]." selected='selected'>".$thn[$i]["tahun"]."</option>";
								}
								else {
									echo "<option value=".$thn[$i]["tahun"]." >".$thn[$i]["tahun"]."</option>";
								}
							}
			 
						?>
					</select>  
				</div>
			</div>				
			<div class="col-lg-2">	
			
				<div class="select-wrapper">
					
					<select class="form-control" name="user" id="user" required onChange="viewall()">
						<?php 
							if($userselected == 0){
								echo "<option value=0 selected='selected'>All People 2021</option>";
							}else{
								echo "<option value=0 >All People 2021</option>";
							}
							
							if($userselected == 1){
								echo "<option value=1 selected='selected'>All People 2022</option>";
							}else{
								echo "<option value=1 >All People 2022</option>";
							}

							foreach($profiless as $profiles){
									if ($profiles['id'] == $userselected) {
										echo "<option value=".$profiles['id']." selected='selected'>".$profiles["name"]."</option>";
									}
									else {
										echo "<option value=".$profiles['id']." >".$profiles["name"]."</option>";
									}
							}
						

						?>
					</select>  
					
					
				</div>
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
              <div class="icon">
                <img alt="image" src="<?php echo $path9;?>images/Frame123.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Number of Spot</span>
                <span class="value"><?php echo number_format(intval($costspot2[0]["SPOT"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon">
                <img alt="image" src="<?php echo $path9;?>images/Frame 123D.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Cost (IDR Millions)</span>
                <span class="value"><?php echo number_format((intval($costspot2[0]["COST"])/1000000),2,',','.'); ?></span>
              </div>
            </div>
          </div>
	  
          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon">
                <img alt="image" src="<?php echo $path9;?>images/Frame 123D2.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Total Views</span>
                <span class="value"><?php echo number_format((intval($costspot2[0]["VIEWERS"])),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon">
                <img alt="image" src="<?php echo $path9;?>images/Frame 125D3.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">CPV</span>
                <span class="value">
				<?php 
				if ($costspot2[0]["VIEWERS"]==0) {
					echo 0;
				} else {
				echo number_format((intval($costspot2[0]["COST"])/intval($costspot2[0]["VIEWERS"])),0,'.','.'); }
				?>
				</span>
              </div>
            </div>
          </div>
        </div>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="" class="row">
 

          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2" data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="navbar">
				
					<div class="col-lg-12">	
							<div class="navbar-left">
								<h4 class="title-periode1" ><strong>Spot by Chanel</strong></h4>
							</div>
							 <div class="navbar-right" style="padding:10px;padding-right:40px" >
							 
								 <div class="col-lg-12">
									<select class="form-control" name="viewby_cont1" id="viewby_cont1" onChange="cont1_view()" required >
										<option value="Spot" selected>Spot</option>
										<option value="Cost" >Cost</option>
										<option value="GRP" >Total Viewers</option>
									</select> 
								</div>
								
							 </div>
							 
					</div>
                  
                </div>
                <div class="widget-content">
					
                 <div id="container" ></div>
                </div>
            </div>
          </div>
 
          
          <div class="grid-stack-item row" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="0" data-gs-y="4" data-gs-width="6" data-gs-height="2"
            data-gs-auto-position="1">
			
			<div class="col-md-6" >	
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                
				<div class="col-lg-12">	
                <div class="navbar-left">
                  <h4><strong>Product Spot</strong></h4>
                </div>
				<div class="navbar-right" style="padding:10px;padding-right:13px" >
						<div class="col-lg-3">	</div>
						<div class="col-lg-5">	
								<select class="form-control" name="product_product" id="product_product" onChange="table1_view()" required >
									<option value="NAMA_BRAND" selected >BRAND</option>
									<option value="ADVERTISER"  >ADVERTISER</option>
									<option value="AGENCY"  >AGENCY</option>
									<option value="PO_NUMBER"  >HOUSE NUMBER</option>
								</select> 
								
							</div>
							<div class="col-lg-4">	
								<select class="form-control" name="viewby_product" id="viewby_product" onChange="table1_view()" required >
									<option value="Spot" selected>Spot</option>
									<option value="Cost" >Cost</option>
									<option value="GRP" >Total Viewers</option>
								</select> 
							</div>
				
				</div>
			  </div>

                <div class="widget-content">
							
					<div id="table_program1">
						<table aria-describedby="table" id="example2" class="table table-striped example" style="color:black">
							<thead style="color:red">
								<tr>
									<th scope="row">NAMA BRAND <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
									<th scope="row">Spot <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								</tr>
										
							</thead>
						</table>
					</div>
                </div>
            </div>
            </div>


<div class="col-md-6" >	
              <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                
				<div class="col-lg-12">	
			   
                <div class="navbar-left">
                  <h4><strong>Product Spot</strong></h4>
                </div>
				<div class="navbar-right" style="padding:10px;padding-right:13px" >
				<div class="col-lg-3">	</div>
				<div class="col-lg-5">	
							<select class="form-control" name="product_program" id="product_program" onChange="table2_view()" required >
									<option value="PROGRAM" selected >Program</option>
								</select> 
								
							</div>
					<div class="col-lg-4">	
								<select class="form-control" name="viewby_program" id="viewby_program" onChange="table2_view()" required >
									<option value="Spot" selected>Spot</option>
									<option value="Cost" >Cost</option>
									<option value="GRP" >Total Viewers</option>
								</select> 
							</div>
				</div>
				</div>

                <div class="widget-content">
							
						 <div id="table_program">
								<table aria-describedby="table" id="example3" class="table table-striped example" style="color:black">
										<thead style="color:red">
											<tr>
												<th scope="row">Program <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
												<th scope="row">Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
												<th scope="row">Spot <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
											</tr>
													
										</thead>
									</table>
						</div>
                </div>
            </div>
            </div>
          </div>
		  
		  <div class="grid-stack-item" data-gs-min-width="12" data-gs-min-height="2" data-gs-x="0" data-gs-y="4" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
			<div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                <div class="col-lg-12">	
                <div class="navbar-left">
                  <h4 class="title-periode21"><strong>Spot by Day Part </strong></h4>
                </div>
				 <div class="navbar-right" style="padding:10px;padding-right:40px" >
							 
								 <div class="col-lg-12">
									<select class="form-control" name="viewby_daypart" id="viewby_daypart" onChange="view_daypart()" required >
										<option value="Spot" selected>Spot</option>
							<option value="Cost" >Cost</option>
							<option value="GRP" >Total Viewers</option>
									</select> 
								</div>
								
				</div>
				
				</div>

                <div class="widget-content">
		

                    <div id="container5" ></div>
                </div>
            </div>
          </div>
		  
          <div class="grid-stack-item" data-gs-min-width="12" data-gs-min-height="2" data-gs-x="12" data-gs-y="12" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
                
				<div class="col-lg-12">	
					<div class="navbar-left">
					  <h4 class="title-periode11"><strong>Spot by Day</strong></h4>
					</div>
					<div class="navbar-right" style="padding:10px;padding-right:13px" >
						<div class="col-lg-12 ">	
								<select class="form-control" name="viewby_daybyday" id="viewby_daybyday" onchange="day_view()" required >
									<option value="Spot" selected>Spot</option>
									<option value="Cost" >Cost</option>
									<option value="GRP" >Total Viewers</option>
								</select>  
					
						</div>
					</div>
				</div>
				

                <div class="widget-content">
				
                    <div id="container6" ></div>  
                  
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
                    <h4>Spot by Channel</h4>
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
                    <h4>Spot by Daypart</h4>
                  </div>
                  <div class="navbar-right">
                    <div class="btn-group btn-action">
                      <div class="checkbox urate-checkbox">
                        <input type="checkbox" class="urate-form-checkbox" id="checkEgiht">
                        <label for="checkEgiht"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div id="widget-4" class="widget selected">
                  <div class="navbar-center">
                    <h4>Product Spot</h4>
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
              <div id="widget-3" class="widget selected">
                <div class="navbar-left">
                  <h4>Program Spot</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkFour">
                      <label for="checkOne"></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div id="widget-5" class="widget selected">
                <div class="navbar-center">
                  <h4>Spot By Day</h4>
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

    <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms_sig.js"></script>
  <script src="<?php echo $path;?>assets/js/table.js"></script>
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
 <script src="<?php echo $path;?>assets/js/widget.js?v=2"></script>
<!-- highcharts -->
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

function viewall(){
	
		var url = '<?php echo base_url(); ?>tvpostbuyu3resp22';
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		var user = $('#user').val();
 		  
		 $("#laod").append(' <img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"<input type='hidden' name='user' value='" + user + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	
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
    var selPeriode = $('#tahun').find('option:selected').text().split('-');
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;color:#FF0000'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    $( ".title-periode11" ).html($(".title-periode11").html()+"<br><span style='font-size: 12px;color:#FF0000'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
    $( ".title-periode21" ).html($(".title-periode21").html()+"<br><span style='font-size: 12px;color:#FF0000'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
	
   Highcharts.chart('container', {
        chart: {
            type: 'column',
			zoomType: 'x',
			height: 450
        },
		
        exporting: {
            enabled: false
        },
        title: {
            text: ''
        },
        lang: {
			numericSymbols: null  
		},
        xAxis: {
            categories: [<?php echo join($json_channel, ',') ?>],
            crosshair: true
        },
        yAxis: {
			min: 0,
            minRange: 20,
            title: {
                text: ''
            }
        },
		tooltip: {
			formatter: function () {
				return 'Spot: <strong>' + this.point.y + '</strong>';
			}
		},

        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Spot',
            data: [<?php echo join($json_spot, ',') ?>],
			color: "#FF0000"
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
            name: 'spot',
            data: [<?php echo join($json_spot_date, ',') ?>],
			color: "#FF0000"
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
            name: 'Spot',
             data: [<?php echo join($json_spot_days, ',') ?>],
			color: "#FF0000"

        }]
    });
	
});

$( document ).ready(function() {				
	
	
var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

       $("#exportWidget").click(function () {
        
          var countPage = 0;

		  var namefile  = '';

           if($("#checkTwo").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }
			
 			
				
				
			setTimeout(function(){
				var chart = $('#container').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Spot By Channel'
				});
			}, 4000);
 
          }


           if($("#checkFive").is(':checked')){
 
				setTimeout(function(){
					var chart = $('#container6').highcharts();
					chart.exportChart({
						type: 'application/pdf',
						filename: 'Spot by Day'
					});
				}, 5000);
   
          }

           if($("#checkSix").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }
			  var doc = new jsPDF();
            doc.text(105, 30, 'Product Spot', null, null, 'center');
           var selPeriode = $('#tahun').find('option:selected').text().split('-');
            doc.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var elem = document.getElementById("example2");
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
			  doc.save('Product Spot.pdf');
			 }, 2000);
          }
		  
		   if($("#checkSeven").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }
			var docs = new jsPDF();
            docs.text(105, 30, 'Program Spot', null, null, 'center');
           var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docs.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
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

			namefile = 'Program Spot';
			
			setTimeout(function(){
			  docs.save('Program Spot.pdf');
			 }, 3000);
			
          }
		   if($("#checkEgiht").is(':checked')){
      
			
				
			setTimeout(function(){
				var chart = $('#container5').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Spot By Daypart'
				});
			}, 6000);
  
          }

 
      });
});

var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';
var data = <?php echo $products; ?>;
var program = <?php echo $programs; ?>;

$(function () {	

 
	
	$('#example2').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"Info" : false,
		"sPaginationType": "simple",
		"processing": true, "searching": true,
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		data: data,
		columns: [
			{ data: 'NAME' },
			{ data: 'spots',"sClass": "right",render: function ( data, type, row ) {
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
		"sPaginationType": "simple",
		"processing": true, "searching": true,
		"Info" : false,
		data: program,
		columns: [
			{ data: 'NAME' },
			{ data: 'CHANNEL' },
			{ data: 'spots' ,"sClass": "right",render: function ( data, type, row ) {
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
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var user = $('#user').val();

 
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('user', user);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
  
  $("#example2_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/cost_by_program2'; ?>", 
		dataType: 'json',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			


			if(type == 'GRP'){
				var nhy = 'Viewers';
			}else{
				var nhy = type;
			}
			
			$('#table_program1').html("");
			$('#table_program1').html('<table aria-describedby="table" id="example2" class="table table-striped example" style="color:black"><thead style="color:red"><tr><th>'+field+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+nhy+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

			$('#example2').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "simple",
				"processing": true, "searching": true,
				"Info" : false,
				data: obj,
				columnDefs: [
					{ targets: [1], className: 'dt-body-right' },
					{ targets: 1,render: $.fn.dataTable.render.number('.', ',', 0, '')
  }
				]
	});	
            
            $(".table th").on("click",function(){                    
                if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
                    $(this).children().css("transform","rotate(180deg)");
                } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
                    $(this).children().css("transform","rotate(0deg)");
                }
            });	
		}
	});	
	
}

function table2_view(){
	
	var form_data = new FormData();  
	var type = $('#viewby_program').val();
	var field = $('#product_program').val();
	var stype = $('#viewby_program').val();
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var user = $('#user').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('user', user);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
  
  $("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');

	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/cost_by_program2nn'; ?>", 
		dataType: 'json',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			if(type == 'GRP'){
				var nhy = 'Viewers';
			}else{
				var nhy = type;
			}
			
			$('#table_program').html("");
			$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped example" style="color:black"><thead style="color:red"><tr><th>'+field+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+nhy+' <img alt="image" class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

			$('#example3').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "simple",
				"processing": true, "searching": true,
				"Info" : false,
				data: obj,
				columnDefs: [
					{ targets: [2], className: 'dt-body-right' },
					{ targets: 2,render: $.fn.dataTable.render.number('.', ',', 0, '') }
				]
	});	
            
            $(".table th").on("click",function(){                    
                if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
                    $(this).children().css("transform","rotate(180deg)");
                } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
                    $(this).children().css("transform","rotate(0deg)");
                }
            });	
		}
	});	
	
}



function view_daypart(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_daypart').val();
	var field = "daypart";
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var user = $('#user').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('type', type);
	form_data.append('user', user);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	var selPeriode = $('#tahun').find('option:selected').text().split('-');
  
  $("#container5").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 60px; width: 100%; height: 400px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/daypart_view'; ?>", 
		dataType: 'text',  
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			if(type == 'GRP'){
				var nhy = 'Viewers';
			}else{
				var nhy = type;
			}
			
			$( ".title-periode21" ).html("<strong>"+nhy+" by daypart</strong><br><span style='font-size: 12px;color:#FF0000'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
			
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
			  text: " "
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
				 text: nhy
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
				 name: nhy,
				 data:data_new,
				 color: "#FF0000"
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
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var user = $('#user').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('user', user);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
  
  var selPeriode = $('#tahun').find('option:selected').text().split('-');
  
  $("#container6").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 60px; width: 100%; height: 400px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/day_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			
			if(type == 'GRP'){
				
				var nyh = 'Viewers';
			}else{
				var nyh = type;
			}
			
			$( ".title-periode11" ).html("<strong>"+nyh+" by Day</strong><br><span style='font-size: 12px;color:#FF0000'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
			
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}
			
			$('#container6').html();

			var title = {
			  text: ""
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
				verticalAlign: 'bottom',
				borderWidth: 0
			};
			var series= [{
				 name: nyh,
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
	var field = "type";
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/ads_view'; ?>", 
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
				 groupPadding: 0.7,
					pointPadding: 1.7
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
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/prime_view'; ?>", 
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
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/pie1_view'; ?>", 
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
	var tahun = $('#tahun').val();
	var bulan = $('#bulan').val();
	var user = $('#user').val();
	form_data.append('cond',"<?php echo $cond; ?>");
	form_data.append('type', type);
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('user', user);
  
  var selPeriode = $('#tahun').find('option:selected').text().split('-');
  
  $("#container").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 60px; width: 100%; height: 400px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu3resp22/cost_by_channel'; ?>", 
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
			}else if(type == "GRP"){
				type = "Total Viewers";
			}
			
			 var selPeriode = $('#tahun').find('option:selected').text().split('-');
			$( ".title-periode1" ).html("<strong>"+type+" by Channel</strong><br><span style='font-size: 12px;color:#FF0000'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}

 			$('#container').html();
			
			var chart= {
				type: 'column'
			};
			var title = {
			  text: ""
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
				 text: ""
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
			     color: "#FF0000"
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