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
	
	
	#container6{
		
		overflow: visible !important;
	}
	
	#container5{
		
		overflow: visible !important;
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
                <li class="breadcrumb-item">Free to Air</li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">Post Buy Dashboard</li>
            </ol>
            <h3 class="page-title">Post Buy Dashboard</h3>
          </div>
          <div class="col-md-7 text-right">
            <a href="#addNewWidget" class="btn urate-outline-btn btn-lg" data-toggle="modal">
                <span class="ion-edit"></span> Edit Widget
            </a>
            <button type="button" class="btn urate-btn btn-lg" onclick="show()" id="exportWidget" data-complete-text="<span class='ion-android-open'></span> Export Now">
              <span class="ion-android-open"></span> Export
            </button>
			
			
            <button type="button" class="btn urate-outline-btn btn-lg btn-cancel hidden" onclick="unckel()">Cancel</button>
			<br/>
			<h6 id="hs"></h6>
          </div>
		  
        </div>

        <!-- Dashboard Stats -->
        <div class="row">
		
		<div class="col-lg-12">	
			<div class="col-lg-4">	
				<label>Periode: </label>
					<select class="form-control" name="tahun" id="tahun" required onChange="viewall()">
						<?php 
						//print_r($thn);
							for ($i=0;$i<count($thn);$i++){
								if ($thn[$i]["tahun"]==$tahunselected) {
									echo "<option value=".$thn[$i]["tahun"]." selected>".$thn[$i]["tahun"]."</option>";
								}else {
									echo "<option value=".$thn[$i]["tahun"]." >".$thn[$i]["tahun"]."</option>";
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
                <span class="title">Number of Spot</span>
                <span class="value"><?php echo number_format(intval($header[0]["SPOT"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_cost.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">Cost (IDR Billions)</span>
                <span class="value"><?php echo number_format((intval($header[0]["COST"])/1000000),2,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_grp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">GRP</span>
                <span class="value"><?php echo number_format(intval($header[0]["GRP"]),0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path;?>assets/images/stats_icon_crp.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="title">CPRP</span>
                <span class="value">
				<?php 
					if ($header[0]["GRP"]==0) {
						echo 0;
					} else {
					echo number_format((intval($header[0]["COST"])/intval($header[0]["GRP"]))*1000,0,',','.'); }
				?>
				</span>
              </div>
            </div>
          </div>
        </div>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        <div id="widgets" class="row grid-stack">
          <div class="grid-stack-item" data-gs-min-width="3" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="3" data-gs-height="1" data-gs-auto-position="1">                    
            <div class="grid-stack-item-content">
              <div data-widget="widget-1" class="widget inverse">
                <div class="navbar-center">
                  <h4>Spot by Time</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkOne">
                      <label for="checkOne"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Time">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div id="js-legend" class="chart-legend"></div>
                <div class="widget-content" style="height: 80%;">
                  <canvas id="widget-spot-time" ></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="0" data-gs-y="0" data-gs-width="9" data-gs-height="2" data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-2" class="widget">
                <div class="navbar-center">
				
					<div class="col-md-2 col-md-offset-10">
						<select class="form-control" style="margin-top: -5px" name="viewby_cont1" id="viewby_cont1" onChange="cont1_view()" required >
							<option value="Spot" selected>Spot</option>
							<option value="Cost" >Cost</option>
							<option value="GRP" >GRP</option>
						</select>
					</div>
                  
		  <br/>
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
					
                 <div id="container" ></div>
                </div>
              </div>
            </div>
          </div>

          <div class="grid-stack-item" data-gs-min-width="3" data-gs-min-height="1" data-gs-x="9" data-gs-y="0" data-gs-width="3" data-gs-height="1" data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-3" class="widget inverse">
                <div class="navbar-center">
                  <h4>Spot by Type</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkThree">
                      <label for="checkThree"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Rating">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div id="js-legend-type" class="chart-legend"></div>
                <div class="widget-content" style="height: 80%;">
                  <canvas id="widget-spot-type" ></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="grid-stack-item" data-gs-min-width="12" data-gs-min-height="2" data-gs-x="12" data-gs-y="12" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-5" class="widget">
                
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
				<div class="col-md-2 col-md-offset-10">	
							<select class="form-control" name="viewby_daybyday" id="viewby_daybyday" onchange="day_view()" required >
								<option value="Spot" selected>Spot</option>
								<option value="Cost" >Cost</option>
								<option value="GRP" >GRP</option>
							</select>  
				
		  <br/>
				</div>
                    <div id="container6" ></div>  
                  
                </div>
              </div>
            </div>
          </div>
                        
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="0" data-gs-y="4" data-gs-width="6" data-gs-height="2" data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-4" class="widget">
                <div class="navbar-left">
                  <h4>Spot by Ads Type</h4>
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
					<div class="col-md-3 col-md-offset-10">
						<select class="form-control" name="viewby_ads_type" id="viewby_ads_type"  onChange="ads_type_view()" required >
							<option value="Spot" selected>Spot</option>
							<option value="Cost" >Cost</option>
							<option value="GRP" >GRP</option>
						</select>   
					</div>
					
		  <br/>
		  <br/>
				    <div id="container3" style="height:370px;margin-bottom:50px" ></div>
					
                </div>
              </div>
            </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="0" data-gs-y="4" data-gs-width="6" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-7" class="widget">
                <div class="navbar-left">
                  <h4>Product Spot</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkSix">
                      <label for="checkSix"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Daypart">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div class="widget-content">
				
							<div class="col-lg-4">	
								<select class="form-control" name="product_product" id="product_product" onChange="table1_view()" required >
									<option value="Product" selected >Product</option>
									<option value="Advertiser" >Advertiser</option>
									<option value="Category" >Category</option>
									<option value="Sector" >Sector</option>
								</select> 
								
							</div>
							<div class="col-lg-3">	
								<select class="form-control" name="viewby_product" id="viewby_product" onChange="table1_view()" required >
									<option value="Spot" selected>Spot</option>
									<option value="Cost" >Cost</option>
									<option value="GRP" >GRP</option>
								</select> 
							</div>
							
		  <br/>
                 <div id="table_program1">
					<table aria-describedby="table" id="example2" class="table table-striped table-bordered example" style="color:black">
						<thead>
							<tr>
								<th scope="row">Product <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
								<th scope="row">Spot <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
							</tr>
									
						</thead>
					</table>
					</div>
                </div>
              </div>
            </div>
          </div>
          
        <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="0" data-gs-y="4" data-gs-width="6" data-gs-height="2"
            data-gs-auto-position="1">
              <div class="grid-stack-item-content">
              <div data-widget="widget-6" class="widget">
                <div class="navbar-left">
                  <h4>Program Spot</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkEight">
                      <label for="checkEight"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Daypart">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div class="widget-content">
					<div class="col-lg-4">	
								<select class="form-control" name="product_program" id="product_program" onChange="table2_view()" required >
									<option value="Program" selected >Program</option>
									<option value="Level1" >Level 1</option>
									<option value="Level2" >Level 2</option>
								</select> 
								
							</div>
							<div class="col-lg-3">	
								<select class="form-control" name="viewby_program" id="viewby_program" onChange="table2_view()" required >
									<option value="Spot" selected>Spot</option>
									<option value="Cost" >Cost</option>
									<option value="GRP" >GRP</option>
								</select> 
							</div>
							
							
		  <br/>
						 <div id="table_program">
								<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black">
										<thead>
											<tr>
												<th scope="row">Program <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
												<th scope="row">Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
												<th scope="row">Spot <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png" alt="arrow"></th>
											</tr>
													
										</thead>
									</table>
						</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="2" data-gs-x="0" data-gs-y="4" data-gs-width="6" data-gs-height="2" data-gs-auto-position="1">
            <div class="grid-stack-item-content">
              <div data-widget="widget-8" class="widget">
                <div class="navbar-left">
                  <h4>Spot by Day Part</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkSeven">
                      <label for="checkSeven"></label>
                    </div>
                    <button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Daypart">
                      <span class="ion-close-round"></span>
                    </button>
                  </div>
                </div>
                <div class="widget-content">
					<div class="col-md-3 col-md-offset-10">
						<select class="form-control" name="viewby_daypart" id="viewby_daypart" onchange="view_daypart()" required >
							<option value="Spot" selected>Spot</option>
							<option value="Cost" >Cost</option>
							<option value="GRP" >GRP</option>
						</select> 
					</div>			

		  <br/>
                    <div id="container5" ></div>
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
                <div id="widget-1" class="widget selected">
                  <div class="navbar-center">
                    <h4>Spot by Time</h4>
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
                <div id="widget-3" class="widget selected">
                  <div class="navbar-center">
                    <h4>Spot by Type</h4>
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
                  <h4>Spot by Ads Type</h4>
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
            <div class="col-md-4">
              <div id="widget-6" class="widget selected">
                <div class="navbar-left">
                  <h4>Program Spot</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkEight">
                      <label for="checkEight"></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div id="widget-7" class="widget selected">
                <div class="navbar-left">
                 <h4>Product Spot</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkSix">
                      <label for="checkSix"></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <div id="widget-8" class="widget selected">
                <div class="navbar-left">
                  <h4>Spot By Daypart</h4>
                </div>
                <div class="navbar-right">
                  <div class="btn-group btn-action">
                    <div class="checkbox urate-checkbox">
                      <input type="checkbox" class="urate-form-checkbox" id="checkSeven">
                      <label for="checkSeven"></label>
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

function unckel(){
 	$('.urate-form-checkbox').removeAttr('checked');
 	
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

 $("#tooltip").text("18:00 - 22:00");
var ssao = encodeURI('18:00 - 22:00')
var percentageDoughnutChart = <?php echo number_format(($prime/($prime+$nprime))*100,2,".",",") ?>;    
    
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
    
var percentageDoughnutChartDataType = <?php echo number_format(($loose[0]['Loose']/($loose[0]['Loose']+$loose[0]['No_Loose']))*100,2,".",",") ?>;     
    
var DoughnutChartDataType = {
	labels: [
		"Loose Spot",
    "Non Loose Spot"
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
			percentageDoughnutChartDataType,
			(100-percentageDoughnutChartDataType).toPrecision(4)
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
var BarChartAdsData = {
	labels:  ["LOOSE SPOT ", "TEMPLATE ", "CREDIT TITLE ", "PLASMA ", "SUPER IMPOSE ", "BUILT IN ", "SQUEEZE FRAME ", "OBB ", "CBB ", "VIRTUAL ADS ", "BUILT IN SEGMEN ", "MOVING IMPOSE ", "ADLIPS ", "QUIZ ", "RUNNING TEXT ", "TVC BETWEEN PROGRAM ", "BUILT IN ", "ASSALAAMUALAIKUM USTADZ ", "Q CARD ", "INFO QUIZ"],
	datasets: [{
 		backgroundColor: window.chartColors.red,
		borderWidth: 0,
		data: [
            <?php echo join($json_spot_ads, ',') ?>
		]
	}]

};
var BarChartDaypart = {
	labels:  [<?php echo join($json_days, ',') ?>],
	datasets: [{
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
					fontSize : 10  
				},
				position: 'bottom',
				display: true,
				onClick: (e) => e.stopPropagation()
			},
      elements: {
				center: {
					text: percentageDoughnutChart.toLocaleString('id') + "%",
					color: '#FFF',
					fontStyle: 'Lato',
				}
			}      
		}  
	}); 
 	var canvasSpotByType = document.getElementById("widget-spot-type").getContext("2d");
	window.widgetSpotByType = new Chart(canvasSpotByType, {
		type: 'doughnut',
		data: DoughnutChartDataType,
		options: {
      cutoutPercentage: 90,
			maintainAspectRatio: false,
			legend: {
				labels: {
					usePointStyle : true,
					fontColor: 'white',
					fontSize : 10
				},
				position: 'bottom',
				display: true,
				onClick: (e) => e.stopPropagation()
			},
      elements: {
				center: {
					text: percentageDoughnutChartDataType.toLocaleString('id') + "%",
					color: '#FFF',
					fontStyle: 'Lato',
				}
			}
		}
	});
});

$( document ).ready(function() {
var selPeriode = $('#tahun').find('option:selected').text().split('-');
$( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>");












	
	var chart1 = Highcharts.chart('container', {
        chart: {
            type: 'column',
			zoomType: 'x',
			height: 450
        },
		
        exporting: {
            enabled: false
        },
        title: {
            text: 'Spot by Channel<br><span style="font-size: 12px;">'+selPeriode[1]+' - '+selPeriode[0]+'<span>'
        },
        lang: {
			numericSymbols: null  
		},
        xAxis: {
			// labels: {
           
            categories: [<?php echo join($json_channel, ',') ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Spot'
            }
        },
       
		tooltip: {
			formatter: function () {
				return 'Spot: <b>' + this.point.y + '</b>';
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
			color: "#4a4d54"
         }]
    });
	
	
	Highcharts.chart('container3', {
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
            categories:[<?php echo join($json_ads, ',') ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Spot'
            }
        },
         
		tooltip: {
			formatter: function () {
				return 'Spot: <b>' + this.point.y + '</b>';
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
            data: [<?php echo join($json_spot_ads, ',') ?>],
			groupPadding: 0.7,
			pointPadding: 1.7,
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
                text: 'Spot'
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
			color: "#4a4d54"

        }]
    });
	
	
	Highcharts.chart('container6', {
        title: {
            text: 'Spot By Day'+"<br><span style='font-size: 9px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>",
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
            name: 'spot',
            data: [<?php echo join($json_spot_date, ',') ?>],
			color : '#4a4d54'
        }]
    });
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

       $("#exportWidget").click(function () {
         
          var countPage = 0;
		  var namefile  = '';

           if($("#checkOne").is(':checked')){
			  
			var doc = new jsPDF();
			doc.text(105, 30, 'Spot by Time', null, null, 'center');
			var selPeriode = $('#tahun').find('option:selected').text().split('-');
            doc.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var canvasWidget1 = document.getElementById('widget-spot-time');
            var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
			
            doc.setFillColor(203, 51, 39);
            doc.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            doc.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
            countPage1 = 1;
			
			namefile1 = 'Spot by Time';
			 setTimeout(function(){
			  doc.save('Spot by Time.pdf');
			 }, 2000);
			
			
			
          }

           if($("#checkTwo").is(':checked')){
 
           	 setTimeout(function(){
				var chart = $('#container').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Spot by Channel'
				});
			 }, 6000);
 
          }
 
           if($("#checkThree").is(':checked')){
        
			var docs = new jsPDF();
			docs.text(105, 30, 'Spot by Type', null, null, 'center');
			var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docs.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
         
            var canvasWidget1 = document.getElementById('widget-spot-type');
            var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
			
            docs.setFillColor(203, 51, 39);
            docs.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            docs.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
            countPage2 = 1;
			
			namefile2 = 'Spot by Type';
			 
			  
			  
           	 setTimeout(function(){
				docs.save('Spot by Type.pdf');
			 }, 3000);
          }

           if($("#checkFour").is(':checked')){
   
           	 setTimeout(function(){
				var chart = $('#container3').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Spot by Ads Type'
				});
			 }, 10000);
        
          }

           if($("#checkFive").is(':checked')){
   
           	 setTimeout(function(){
				var chart = $('#container6').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Spot By Day'
				});
			 }, 8000);
      
          }

           if($("#checkSix").is(':checked')){
        
			var docsa = new jsPDF();
            docsa.text(105, 30, 'Product Spot', null, null, 'center');
           var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docsa.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
           
            var elem = document.getElementById("example2");
            var res = docsa.autoTableHtmlToJson(elem);
            docsa.autoTable(res.columns, res.data, {
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
				docsa.save('Product Spot.pdf');
			 }, 4000);
           }
           if($("#checkEight").is(':checked')){
           
			
			var docsaaa = new jsPDF();
            docsaaa.text(105, 30, 'Program Spot', null, null, 'center');
			var selPeriode = $('#tahun').find('option:selected').text().split('-');
            docsaaa.text(105, 40, selPeriode[1]+" - "+selPeriode[0], null, null, 'center');
           
            var elem = document.getElementById("example3");
            var res = docsaaa.autoTableHtmlToJson(elem);
            docsaaa.autoTable(res.columns, res.data, {
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
				docsaaa.save('Program Spot.pdf');
			 }, 5000);
           }
		  
		   if($("#checkSeven").is(':checked')){
         
			
				
				
				
           	 setTimeout(function(){
				var chart = $('#container5').highcharts();
				chart.exportChart({
					type: 'application/pdf',
					filename: 'Spot by Daypart'
				});
			 }, 9000);
           
          }

          
      });
 
 
});

 

function save_chart(chart, filename) {
    var render_width = 1000;
    var render_height = render_width * chart.chartHeight / chart.chartWidth

    var svg = chart.getSVG({
        exporting: {
            sourceWidth: chart.chartWidth,
            sourceHeight: chart.chartHeight
        }
    });

    var canvas = document.createElement('canvas');
    canvas.height = render_height;
    canvas.width = render_width;

    var image = new Image;
    image.onload = function() {
        canvas.getContext('2d').drawImage(this, 0, 0, render_width, render_height);
        var data = canvas.toDataURL("image/png")
        download(data, filename + '.png');
    };
    image.src = 'data:image/svg+xml;base64,' + window.btoa(svg);
	
}

function download(data, filename) {
    var a = document.createElement('a');
    a.download = filename;
    a.href = data
    document.body.appendChild(a);
    a.click();
    a.remove();
}

 
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
			{ data: 'fld',"sClass": "right",render: function ( data, type, row ) {
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
		"language": {
            "decimal": ",",
            "thousands": "."
        },
		"Info" : false,
		data: program,
		columns: [
			{ data: 'name' },
			{ data: 'CHANNEL' },
			{ data: 'val' ,"sClass": "right",render: function ( data, type, row ) {
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
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
  
  $("#example2_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/cost_by_program2'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program1').html("");
			$('#table_program1').html('<table aria-describedby="table" id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
			obj = jQuery.parseJSON(data);

			$('#example2').DataTable({
				"bFilter": false,
				"aaSorting": [],
				"bLengthChange": false,
				'iDisplayLength': 10,
				"sPaginationType": "simple",
				"processing": true, "searching": true, 
    		"language": {
                "decimal": ",",
                "thousands": "."
            },
				"Info" : false,
				data: obj,
				columns: [
					{ data: 'name' },
					{ data: 'val',"sClass": "right",render: function ( data, type, row ) {
						console.log(data);
							if(stype == "SPOT"){
                return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
								 
							}else if(stype == "COST"){
                return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
								 
							}else{
                return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));                                                        
							 
							}
						}
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
	
	form_data.append('tahun', tahun);
	form_data.append('bulan', bulan);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
  
  $("#example3_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/cost_by_program3'; ?>", 
		dataType: 'json',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			$('#table_program').html("");
			
			if(field == "Program"){
							
				$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>Channel</th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
				obj = jQuery.parseJSON(data);

				$('#example3').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 10,
					"sPaginationType": "simple",
					"processing": true, "searching": true,     
					"language": {
						"decimal": ",",
						"thousands": "."
					},
						"Info" : false,
						data: obj,
						columns: [
								{ data: 'name' },
							{ data: 'CHANNEL' },
							{ data: 'val',"sClass": "right",render: function ( data, type, row ) {
									
									if(stype == "Spot"){
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
										 
									}else if(stype == "Cost"){
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
										 
									}else{
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));                                                      
									 
									}
									
								}
							}
					]
				});	
			}else{
				
				$('#table_program').html('<table aria-describedby="table" id="example3" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>'+field+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th>'+type+' <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th></tr></thead></table>');
				obj = jQuery.parseJSON(data);

				$('#example3').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 10,
					"sPaginationType": "simple",
					"processing": true, "searching": true,     
					"language": {
						"decimal": ",",
						"thousands": "."
					},
						"Info" : false,
						data: obj,
						columns: [
							{ data: 'name' },
							{ data: 'val',"sClass": "right",render: function ( data, type, row ) {
									
									if(stype == "Spot"){
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
										 
									}else if(stype == "Cost"){
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
									 
									}else{
						return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));                                                      
										 
									}
									
								}
							}
					]
				});	
			}
            
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
	form_data.append('tahun', tahun);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
  
  $("#container5").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 510px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/daypart_view'; ?>", 
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
			var exporting= {
				enabled: false
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
	var tahun = $('#tahun').val();
	form_data.append('tahun', tahun);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
  
  $("#container6").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 610px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');	
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/day_view'; ?>", 
		dataType: 'text',   
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			 var selPeriode = $('#tahun').find('option:selected').text().split('-');
			var obj = jQuery.parseJSON(data);
			var data_new = [];
			
			obj['data'].forEach(myFunction);
			
			function myFunction(item, index) {
				data_new.push(parseInt(item));
			}
			
			$('#container6').html();

			var title = {
			  text: type+" by Days"+"<br><span style='font-size: 12px;'>"+selPeriode[1]+" - "+selPeriode[0]+"<span>"
			};
			
			var exporting= {
				enabled: false
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
	var tahun = $('#tahun').val();
	form_data.append('tahun', tahun);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/ads_view'; ?>", 
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
			
			var exporting= {
				enabled: false
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

function pie2_view(){
	
	
	var form_data = new FormData();  
	var type = $('#viewby_time').val();
	var field = "ads_type";
	var tahun = $('#tahun').val();
	form_data.append('tahun', tahun);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/prime_view'; ?>", 
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
			
			var exporting= {
				enabled: false
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
                }],
			color: "#4a4d54"
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
	form_data.append('tahun', tahun);
	form_data.append('type', type);
	form_data.append('field', field);
	form_data.append('cond',"<?php echo $cond; ?>");	
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/pie1_view'; ?>", 
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
			
			var exporting= {
				enabled: false
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
                }],
				color: "#4a4d54"
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
	var tahun = $('#tahun').val();
	form_data.append('tahun', tahun);
  
  $("#container").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 400px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/cost_by_channel'; ?>", 
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
			
			var exporting= {
				enabled: false
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

function getNest(){
	
 
	
	$('#filter_text').val(JSON.stringify(nest));
	
	$('#filter_form').submit();
	
	
}             


function viewall(){
	
		var url = '<?php echo base_url(); ?>tvpostbuyu';
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		
		 $("#laod").append(' <img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
 		  
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	
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
  
  $("#container3").append('<div class="highcharts-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 610px;"><span class="highcharts-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
	
	$.ajax({
		url: "<?php echo base_url().'tvpostbuyu/ads_view'; ?>", 
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
			
			var exporting= {
				enabled: false
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
				 groupPadding: 0.7,
				 pointPadding: 1.7,
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