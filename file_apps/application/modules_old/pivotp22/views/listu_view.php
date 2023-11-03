
	<!-- Google Fonts -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/video-thumbnail.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/panel.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/box-profile.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tag.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/action-dropdown.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/checkbox.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tree-list.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/helix-profiling.css">

  <!-- Multi Select Css -->
  <link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	
  <!-- Multi Select Plugin Js -->
  <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/jstree.min.js"></script>
  <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/src/jstree.search.js"></script>
	
  <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/vendors/jstree/themes/default/style.min.css">  
  
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css"> 
  
  <style>
      .jstree-themeicon{
          display: none !important;
      }
      
      .dropdown-menu{
          margin-top: 0px !important;
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
      .dataTables_filter {
          margin-right: 15px;
      }
      
      .table > thead > tr > th > img {
          width: 16px;
          float: right;
      }              
      
      .table th {
        background: #ffffff !important;
		 padding: 0 0 0 0;
      }        
	  
	  p {
		  
		  margin: 0 0 0 0;
		  padding: 0 0 0 0;
		  
	  }
	  
	.table {
        margin-left:10px !important;
		border: 4px solid #ddd;
		
      }   
      
      .checkbox .label-text {
        margin-left: 30px;
        width: 300px;
        text-align: left;
      }     
      
      #viswitch label {
        width: 100%;
      }
      
      #menusoptmsg{
        border-radius: 20px;
        border: 1px solid #CC3300;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-right: 10px;
        padding-left: 10px;
        padding-left: 20px;
        padding-right: 20px;
        color: #CC3300;
        font-weight: bold;
        text-align: center;
        display: none;
      }
  </style>
		<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 100%;
  left: 50%;
  margin-left: -60px;
  
  /* Fade in tooltip - takes 1 second to go from 0% to 100% opac: */
  opacity: 0;
  transition: opacity 1s;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
		<!-- / Sidebar -->
		<div class="content-wrapper">
			<div class="container-fluid">
          <div class="row">
              <div class="col-md-6">
                  <ol class="breadcrumb">
                       <li class="breadcrumb-item active">Pivot Profiling</li>
                  </ol>
                  <h3 class="page-title-inner"><strong>Pivot Profiling</strong></h3>
              </div>  
				<div class="col-md-6 text-right">
				<button id="button_filters" onClick="getCreateCr()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
			</div>			  
          </div>
                
      <span id="alertini"></span>
				<!-- List Profile -->
 
				<div class="panel urate-panels">
					<div class="panel-body">
							<div class="row" style="margin-bottom:40px;">
									<div class="col-md-12">
										<h4 style=""><strong>Output Type</strong></h4>
									</div>
									<div class="col-md-12" style="">
										<span id='table_dex' class='dexs'  style="padding:10px;background:#877678;border: solid 1px #E5E5E5;"><a href="#" data-toggle="tooltip" title="Table" onClick="setType('table')"  ><span class="menu-icon"><img alt="img" height="25px" style="" src="https://inrate.id/app2/img/newsource/carbon_table-split.png" ></span></a></span>&nbsp &nbsp 
										<span id='line_dex' class='dexs' style="padding:10px;border: solid 1px #E5E5E5;margin-left:-12px;" ><a href="#" data-toggle="tooltip" title="Line Chart" onClick="setType('line')" ><span class="menu-icon"><img alt="img" height="25px" src="https://inrate.id/app2/img/newsource/carbon_chart-line.png" ></span></a></span>&nbsp &nbsp 
										<span id='column_dex' class='dexs' style="padding:10px;border: solid 1px #E5E5E5;margin-left:-12px;" ><a href="#" data-toggle="tooltip" title="Column Chart" onClick="setType('column')" ><span class="menu-icon"><img alt="img" height="25px" src="https://inrate.id/app2/img/newsource/carbon_chart-column.png" ></span></a></span>&nbsp &nbsp 
										<span id='bar_dex' class='dexs' style="padding:10px;border: solid 1px #E5E5E5;margin-left:-12px;" ><a href="#" data-toggle="tooltip" title="Bar Chart" onClick="setType('bar')" ><span class="menu-icon"><img alt="img" height="25px" src="https://inrate.id/app2/img/newsource/carbon_chart-bar.png" ></span></a></span>&nbsp &nbsp 
										<span id='area_dex' class='dexs' style="padding:10px;border: solid 1px #E5E5E5;margin-left:-12px;" ><a href="#" data-toggle="tooltip" title="Area Chart" onClick="setType('area')" ><span class="menu-icon"><img alt="img"  height="25px" src="https://inrate.id/app2/img/newsource/carbon_chart-area.png" ></span></a></span>&nbsp &nbsp 
										<span id='scatter_dex' class='dexs' style="padding:10px;border: solid 1px #E5E5E5;margin-left:-12px;" ><a href="#" data-toggle="tooltip" title="Scatter Chart" onClick="setType('scatter')" ><span class="menu-icon"><img alt="img" height="25px" src="https://inrate.id/app2/img/newsource/carbon_chart-scatter.png" ></span></a></span>&nbsp &nbsp 
									</div>
									<div class="col-md-2 text-right" > 
									<input type='hidden' id='tbl1' name='tbl1' value='' />
									<input type='hidden' id='tbl2' name='tbl2' value='' />
									<input type='hidden' id='tbl3' name='tbl3' value='' />
									<input type='hidden' id='tbl4' name='tbl4' value='' />
									
									<input type='hidden' id='output' name='output' value='table' />
									<input type='hidden' id='num_s' name='num_s' value=0 />
                                   
								   </div> 
							</div>
					
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6 text-left">
											<p class="page-title-inner" style="font-size: 20px;"><strong>X-Axis</strong></p>
										</div>
										<div class="col-md-6 text-right">
											<button class="button_red_2" data-toggle="modal" data-target="#modalNewProfile" style="margin-top;10px;"> Choose Profile</button>
										</div><br>
										<div class="col-md-12">
											<div class="urate-tag-panel" id="combinePanel">
												<div class="panel-body">
 														<span id="list_1" name="list_1"></span>
 												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6 text-left">
											<p class="page-title-inner" style="font-size: 20px;"><strong>Y-Axis</strong></p>
										</div>
										<div class="col-md-6 text-right">
											<button class="button_red_2" data-toggle="modal" data-target="#modalNewProfile2"> Choose Profile</button>
										</div><br>
										<div class="col-md-12">
											<div class="urate-tag-panel" id="combinePanel">

												<div class="panel-body">
 														<span id="list_2" name="list_2"></span>
 												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
					</div>
				</div>				
        
				<div class="panel2" id="panel-blank" >
		
			<img alt="img" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
		  
		  </div>
		   <div class="loader" style="display:none">
                 <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
            </div>
		
				<!-- Combine Profile --> 
				<div class="panel urate-panel urate-panel-results" style="display:none">
					 <div class="panel-headings">
					   <div class="col-lg-12">	
						<div class="navbar-left" style="padding-left:10px;">
						  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
						</div>
						
					</div>
				  </div>
					    <div class="panel-body" id="result-panel" >
						
							<div class="col-md-8">
                                <div class="row" style="">
									 <div class="col-md-12 active" id="tabs_1" style="">
										<button id="tab_1" style="border: solid 5px #E5E5E5;;background-color:#fff;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('1')" href="#tabsr_1" aria-controls="table" role="tab" data-toggle="tab"><strong>Result 1</strong></button>
										<button id="tab_2" style="border: solid 5px #E5E5E5;;background-color:#E5E5E5;border-radius:5px;padding:3px 15px 3px 15px;margin-left:-10px;display:none;" onclick="tab_filter('2')" href="#tabsr_2" aria-controls="table" role="tab" data-toggle="tab"><strong>Result 2</strong></button>
										<button id="tab_3" style="border: solid 5px #E5E5E5;;background-color:#E5E5E5;border-radius:5px;padding:3px 15px 3px 15px;margin-left:-10px;display:none;" onclick="tab_filter('3')" href="#tabsr_3" aria-controls="table" role="tab" data-toggle="tab"><strong>Result 3</strong></button>
										<button id="tab_4" style="border: solid 5px #E5E5E5;;background-color:#E5E5E5;border-radius:5px;padding:3px 15px 3px 15px;margin-left:-10px;display:none;" onclick="tab_filter('4')" href="#tabsr_4" aria-controls="table" role="tab" data-toggle="tab"><strong>Result 4</strong></button>
									</div>

								</div>
                              </div>
						
						 
						  
							<div class="tab-content" style="margin-top:100px">
 
								<div role="tabpanel" class="tab-pane active" id="tabsr_1">
								
									<div id="result_process_01"></div>
								
								</div>
								<div role="tabpanel" class="tab-pane" id="tabsr_2">
								
									<div id="result_process_02"></div>
								
								</div>
								<div role="tabpanel" class="tab-pane" id="tabsr_3">
								
									<div id="result_process_03"></div>
								
								</div>
								<div role="tabpanel" class="tab-pane" id="tabsr_4">
								
									<div id="result_process_04"></div>
								
								</div>
							</div>
						  
						</div>
				</div>
				<!-- / Combine Profile -->
				<!-- /List Profile -->
				<!-- / Content -->
			</div>
		</div>
	
	<!-- Modal New Profile -->
	<div class="modal fade" id="modalNewProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Profile</h4>
				</div>
				<div class="modal-body">
					<form action="#">
            <div class="col-lg-6 col-md-6">   
    						<!-- Treebox -->
                <label for="">Parameter</label>
								<div class="parameter-box">
									<div class="panel urate-panel">
										<div class="panel-heading">
												<div class="form-group">
													 <div class="form-group">
														  <span class="glyphicon glyphicon-search urate-icon-search" aria-hidden="true"></span>
														  <input type="text" class="form-control urate-form-input urate-form-input-search" id="searchjtree" placeholder="Search">
													  </div>
												</div>
										</div>
										<div class="panel-body" style="height: 370px;">
												<div id="jstree2" class="demo" style="margin-top:0px; font-size: 11px;"></div>
										</div>
									</div>
								</div>   
                <!-- / Treebox -->
            </div>
			<div class="col-lg-6 col-md-6">
    						<div class="form-group">
    							<div class="row">
  									<label for="">Selected</label>
  									<div class="parameter-box result">
  										<div class="panel urate-panel">
  											<div class="panel-body" >
											<span id="listcr" name="listcr"></span>
  											    <span id="option" name="option"></span>
  											</div>
  										</div>
  									</div>
                  </div>
    						</div>
				      </div>   
					</form>
        </div>
				<div class="modal-footer">
				 
				</div>
			</div>
		</div>
	</div>
	<!-- / Modal -->
	
		<!-- Modal New Profile -->
	<div class="modal fade" id="modalNewProfile2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
		<div class="modal-dialog modal-lg " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Profile</h4>
				</div>
				<div class="modal-body">
					<form action="#">
            <div class="col-lg-6 col-md-6">   
    						<!-- Treebox -->
                <label for="">Parameter</label>
								<div class="parameter-box">
									<div class="panel urate-panel">
										<div class="panel-heading">
												<div class="form-group">
													 <div class="form-group">
														  <span class="glyphicon glyphicon-search urate-icon-search" aria-hidden="true"></span>
														  <input type="text" class="form-control urate-form-input urate-form-input-search" id="searchjtree2" placeholder="Search">
													  </div>
												</div>
										</div>
										<div class="panel-body" style="height: 370px;">
												<div id="jstree2b" class="demo" style="margin-top:0px; font-size: 11px;"></div>
										</div>
									</div>
								</div>   
                <!-- / Treebox -->
            </div>
            <div class="col-lg-6 col-md-6">
    						<div class="form-group">
    							<div class="row">
  									<label for="">Selected</label>
  									<div class="parameter-box result">
  										<div class="panel urate-panel">
  											<div class="panel-body" >
											<span id="listcr2" name="listcr2"></span>
  											    <span id="option" name="option"></span>
  											</div>
  										</div>
  									</div>
                  </div>
    						</div>
				      </div>        
					</form>
        </div>
				<div class="modal-footer">
                     
					<span id="laod"></span>
													
				</div>
			</div>
		</div>
	</div>
	<!-- / Modal -->
	
	<!-- Modal Combine Profile -->
	<div class="modal fade" id="modalCombineProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Combine Profile</h4>
				</div>
				<div class="modal-body">
					<form action="">
						<div class="form-group">
							<input type="text" class="form-control urate-form-input" placeholder="Profile Name" id="name" name="name">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn" id="savecombine" onclick="getCreate()">Combine</button>
                    <span id="laodCombine"></span>
									
				</div>
			</div>
		</div>
	</div>

  <!-- Modal Tab -->
	<div class="modal fade" id="modalTab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					
					<h4 class="modal-title" id="myModalLabel">Warning !</h4>
				</div>
				<div class="modal-body">
					<p id="err_msg">Maximal 4 Tabs</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="button_black" data-dismiss="modal">Closa</button>
				</div>
			</div>
		</div>
	</div>


  <!-- Modal Delete Profile -->
	<div class="modal fade" id="modalDeleteProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Delete Profile</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to delete?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn">Delete</button>
				</div>
			</div>
		</div>
	</div>
  
  <!-- Modal Process Job -->
	<div class="modal fade" id="modalProcessJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Process Job Option</h4>
				</div>
				<div class="modal-body">
          <!-- Periode to Proccess Option -->
          <p style="font-weight: bold;">Periode to Proccess</p>
          <div id="periodelist"></div>
          <div id="menusoptmsg">Choose periode to proccess!</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn" id="runjobprocess" >Process</button>
          <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader" >
				</div>
			</div>
		</div>
	</div>
  
  <!-- Modal Delete Job -->
	<div class="modal fade" id="modalDeleteJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Delete Profile</h4>
				</div>
				<div class="modal-body">
          <!-- Periode to Proccess Option -->
          <p style="font-weight: bold;">Are you sure want to Delete Profile ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-grey-btn" id="deljobprocess">Yes</button>
					<button type="button" class="btn urate-btn"  data-dismiss="modal" >No</button>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>
<!-- highcharts -->
	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>
 




    <script type="text/javascript">
        //start
        var optVal1 = [];
        var tempVal1 = [];
        var optVal = [];
        var tempVal = [];
		var crcroptVal1 = [];
		var crcrtempVal1 = [];
		var croptVal = [];
		var crtempVal = [];
		var crfavdata = [];
		var crstar = 0;
	    var crnewdata = [];
		
		 var optVal12 = [];
        var tempVal12 = [];
        var optVal2 = [];
        var tempVal2 = [];
		var crcroptVal12 = [];
		var crcrtempVal12 = [];
		var croptVal2 = [];
		var crtempVal2 = [];
		var crfavdata2 = [];
		var crstar2 = 0;
	    var crnewdata2 = [];
		
         $(".preloader").hide();
         $(".alert").hide();
          var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token");

      $(document).ready(function() {
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	var token = $.cookie(window.cookie_prefix + "token"); 
	 
	 
      
        $('#profile').selectpicker({
          liveSearch: true,
          maxOptions: 0
        });
     
          
    var form_data = {
        user_id			 : user_id
    }

    
    
     $('#searchjtree').typeahead({
        source: function (query, process) {
            return $.get('pivotp22/listsearch?q=' + query, function (data) {
                return process(data);
            });
        },
        updater: function(selection){
             $('#jstree2').jstree('search', selection.name);
            
        }
    });
	
	$('#searchjtree2').typeahead({
        source: function (query, process) {
            return $.get('pivotp22/listsearch?q=' + query, function (data) {
                return process(data);
            });
        },
        updater: function(selection){
             $('#jstree2b').jstree('search', selection.name);
            
        }
    });
    
    $('#searchjtree').on('typeahead:select', function (e, datum) {
     
    });
	
	$('#searchjtree2').on('typeahead:select', function (e, datum) {
     
    });

	var dass = '';

			$('#jstree2b').jstree({'plugins':["checkbox","search"], 'core' : {
                                "themes" : { "stripes" : true },
                'data' : [
                      <?php 
                $html = '';
                $htmls = ''; 
 
                $html .=  $tree_s; 

                echo $html; 
                ?> 
                ]
              }, "search": {}});
			

			$('#jstree2').jstree({'plugins':["checkbox","search"], 'core' : {
                                "themes" : { "stripes" : true },
                'data' : [
                      <?php 
                $html = '';
                $htmls = ''; 
 
                $html .=  $tree_s; 

                echo $html; 
                ?> 
                ]
              }, "search": {}});

							$('#jstree2').on("changed.jstree", function (e, data) {
 								
							$('#listcr').empty();
							$('#list_1').empty();
							  var crnewdata = data.selected;
							  var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
 							  for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("_");
                                  
                                  if(ss[0] != 'j2'){
                                      var ssa = crnewdata[i].split("=");
                                      dd.push(ssa);
                                      ddf.push(ssa);
                                  }else{
                                      
                                  }
																	
							  };
                                
 							  dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var crcrtempVal1 = $("#profile_"+index).val();

                                                if(crcrtempVal1.indexOf(val) >= 0 && crcroptVal1.indexOf(val) < 0) {
                                                    crcroptVal1.push(val);
                                                } else if(crcrtempVal1.indexOf(val) < 0 && crcroptVal1.indexOf(val) >= 0) {
                                                    crcroptVal1.splice(crcroptVal1.indexOf(val) , 1);
                                                }

                                            })
 
                                        });
                              });      
                                
                             var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                console.log(uniqueNames); 
                                
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak1_'+index+'"></span>';
                                     text2 ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak2_'+index+'"></span>';
                                      $('#listcr').append(text);
                                      $('#list_1').append(text2);
                                      ddf.forEach(function(entry, index) {
                                           if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[4]+"</span>, ";
                                              $('#anak1_'+ix).append(texta); 
                                              $('#anak2_'+ix).append(texta); 
                                          }


                                      });
                                     }
                                  
                                  
							  });
							  
                                
                                
                                
									
							  arraypush(data.selected);
							  
							});
							
							
								$('#jstree2b').on("changed.jstree", function (e, data) {
								console.log(data);
								
							$('#listcr2').empty();
							$('#list_2').empty();
							  var crnewdata = data.selected;
							  var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
 							  for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("_");
                                  
                                  if(ss[0] != 'j1'){
                                      var ssa = crnewdata[i].split("=");
                                      dd.push(ssa);
                                      ddf.push(ssa);
                                  }else{
                                      
                                  }
																	
							  };
                                
 							  dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var crcrtempVal12 = $("#profile_"+index).val();

                                                if(crcrtempVal12.indexOf(val) >= 0 && crcroptVal12.indexOf(val) < 0) {
                                                    crcroptVal12.push(val);
                                                } else if(crcrtempVal12.indexOf(val) < 0 && crcroptVal12.indexOf(val) >= 0) {
                                                    crcroptVal12.splice(crcroptVal12.indexOf(val) , 1);
                                                }

                                            })
 
                                        });
                              });      
                                
                             var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                console.log(uniqueNames); 
                                
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="crstar2_'+datas+'">'+datas+'</h3><span id="anak11_'+index+'"></span>';
                                     text2 ='<h3 id="crstar2_'+datas+'">'+datas+'</h3><span id="anak12_'+index+'"></span>';
                                      $('#listcr2').append(text);
                                      $('#list_2').append(text2);
                                      ddf.forEach(function(entry, index) {

                                          if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[4]+"</span>, ";
                                              $('#anak11_'+ix).append(texta);
                                              $('#anak12_'+ix).append(texta);
                                          }


                                      });
                                     }
                                  
                                  
							  });
							  
                                
                                
                                
									
							  arraypush2(data.selected);
							  
							});
							
          
          
        
          
    });


      function toRp(angka){
        var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2    = '';
        for(var i = 0; i < rev.length; i++){
            rev2  += rev[i];
            if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
                rev2 += '.';
            }
        }
        return  rev2.split('').reverse().join('') ;
    }

        Array.prototype.inArray = function(comparer) { 
    for(var i=0; i < this.length; i++) { 
        if(comparer(this[i])) return true; 
    }
    return false; 
}; 

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

function clear(){
    $("#slec option:selected").removeAttr("selected");
}    
 function addleft(id, dex, val){
    
     var bn = document.getElementById('btn_'+dex);
    if(bn.disabled == false) { 
          $("#btn_"+dex).attr('disabled', 'disabled');
    }else{
        alert('gagal');
    }
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var selection = {
            name	 	 : val,
			user_id : user_id 
        }
    
     $.ajax({
				type: "POST",
				url: "<?php echo base_url();?>pivotp22/searchopval" + "?sess_user_id=" + user_id + "&sess_token=" + token,
				data: JSON.stringify(selection),
 				dataType: 'json',
				contentType: 'application/json; charset=utf-8'
			}).done(function(response) {
				// handle a successful response
                console.log(response);
				if (response.success) {
                var data = response.data;
//                       
//                    
					data.forEach(function(entry, index) {
                       
                        
                        $('#list').empty();
				        var sc =  JSON.parse(entry.child);
                        sc.forEach(function(entry, index) {
                            crnewdata.push(entry);
                        
                        });
                         console.log(crnewdata);
							  var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
							  for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("=");
                                  
                                  if(ss[0] != 'j1'){
                                       dd.push(ss);
                                       ddf.push(ss);
                                  }
																	
							  };
                                
 							  dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var crcrtempVal1 = $("#profile_"+index).val();

                                                if(crcrtempVal1.indexOf(val) >= 0 && crcroptVal1.indexOf(val) < 0) {
                                                    crcroptVal1.push(val);
                                                } else if(crcrtempVal1.indexOf(val) < 0 && crcroptVal1.indexOf(val) >= 0) {
                                                    crcroptVal1.splice(crcroptVal1.indexOf(val) , 1);
                                                }

                                            })
 
                                        });
                              });      
                        
                            var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                console.log(uniqueNames);
                                
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  
                                  if(datas){
                                       var ix = index;
                                  text ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak_'+index+'"></span>';
                                     $('#listcr').append(text);
                                  ddf.forEach(function(entry, index) {
                                      
                                      if(datas == entry[1]){
                                         texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                          $('#anak_'+ix).append(texta);
                                      }
                                        

                                  });
                                  }
                                 
                                  
							  });
                    });
				} else {
					
				}
			}).fail(function(xhr, status, message) {
				
				console.log('ajax create error:' + message);
			});
        
}
function favorite(id, val){
    var databawa = [];
    for(var i = 0; i < crnewdata.length; i++){
         var ss = crnewdata[i].split("=");

          if(ss[0] != 'j1'){
                 
              if(ss[1] == val){
                  databawa.push(ss[0]+'='+ss[1]+'='+ss[2]+'='+ss[3]);
                  
              }
          }

      };
    
    var valuedata = JSON.stringify(databawa);
    
 
    user_id = $.cookie(window.cookie_prefix + "user_id");
    token = $.cookie(window.cookie_prefix + "token");
    crstar = id;
    if(crstar == 1){
        
        $("#facs").empty();
 
        var form_data = {
            status			 : crstar,
            user_id			 : user_id,
            name	 	 : val,
            child : valuedata
        }
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>pivotp22/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
             dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            // handle a successful response
            console.log(response.data.hasil);
            if (response.success) {
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    console.log(entry);
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><img alt="img" src="<?php echo $path; ?>assets/images/icon_star.png"></button>');
                });
                    
            } else {

            }
        }).fail(function(xhr, status, message) {

            console.log('ajax create error:' + message);
        });
        
        
    }else{
         $("#facs").empty();
         var form_data = {
            status			 : crstar,
            user_id			 : user_id,
            name	 	 : val,
            child : valuedata
        }
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>pivotp22/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
             dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            // handle a successful response
            console.log(response);
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><img alt="img" src="<?php echo $path; ?>assets/images/icon_star.png"></button>');
                });

        }).fail(function(xhr, status, message) {

            console.log('ajax create error:' + message);
        });
    }
    
    
         
}    
    
function masuk(val){
   
    $('#list').empty();
    var sc = [];
    sc.push(val);
    console.log(val); 
    console.log(sc); 
    return false;
      var crnewdata = sc;
      var dd = [];
        var text = '';
                            for(var i = 0; i < crnewdata.length; i++){
								 
								  
								 var ss = crnewdata[i].split("=");
								 
 										dd.push(ss);
 									
									
							  };
  


}    
    
function arraypush(datas){
	crnewdata = [];
	 crnewdata = datas;
}

function arraypush2(datas){
	crnewdata2 = [];
	 crnewdata2 = datas;
}

function setType(tch){
	
	$("#output").val(tch); 
	
	$(".dexs").css("background", "#fff");
	$(".dexs").css("padding", "10px");
	$("#"+tch+"_dex").css("background", "#877678");
	$("#"+tch+"_dex").css("color", "#fff");
	$("#"+tch+"_dex").css("padding", "10px");
	
	
}

function getExport(tab){
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	var token = $.cookie(window.cookie_prefix + "token");
	var tab_cnt = $("#tbl"+tab).val();
	
	var form_data = new FormData();  
	
	form_data.append('tab_cnt',tab_cnt);
 
	
	var urls = "<?php echo base_url();?>pivotp22/export_table" + "?sess_user_id=" + user_id + "&sess_token=" + token;
	
	$.ajax({
			url: urls, 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/pivot_table_print.xls','pivot_table_print.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
}

 function tab_filter(tabs){

				$('#tab_1').css('background-color','#E5E5E5');
				$('#tab_2').css('background-color','#E5E5E5');
				$('#tab_3').css('background-color','#E5E5E5');
				$('#tab_4').css('background-color','#E5E5E5');
				$('#tab_'+tabs).css('background-color','#fff');
			
			
		 }

function getCreateCr(){
 
	
	var err_int = 0;
	var err_msg = '';
	
	if(crnewdata == ''){
 		err_int++;
		err_msg += 'X-axis harus diisi<br>';
 	}
	if(crnewdata2 == ''){
 		err_int++;
		err_msg += 'Y-axis harus diisi<br>';
 	}
	
	  var tab_cnt = parseInt($("#num_s").val());
 
	
		if(tab_cnt < 4 && err_int == 0){
			
			$('.urate-panel-results').show();
			$('#result-panel').show();
			$('#panel-blank').hide();
			
			 $('#loaderss').append('<img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif"  >');
			$('#btn_pro').hide();
	
		var user_id = $.cookie(window.cookie_prefix + "user_id");
		var token = $.cookie(window.cookie_prefix + "token");
		    $('#savecr').hide();
		var output = $('#output').val();
         
						var tab_no = $("#num_s").val();
						var new_tab_no_old = parseInt(tab_no);
						var new_tab_no = parseInt(tab_no) + 1;
						var html_tb = 'pr0'+new_tab_no;
						var html_tb_old = 'pr0'+tab_no;
						var html_tb2 = 'result_process_0'+new_tab_no;
						var html_cont = 'container'+new_tab_no;
 
                    var form_data = {
                        list		 : crnewdata,
                        list2		 : crnewdata2,
                        isi			 : crcroptVal1,
                        output		 : output,
                         name	 	 : $("#crname").val(),
						notab 		 : new_tab_no						
                    }
                    
					if(output == 'table'){
						var urls = "<?php echo base_url();?>pivotp22/create_pivot" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}else if(output == 'column'){
						var urls = "<?php echo base_url();?>pivotp22/create_pivot_bar" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}else if(output == 'bar'){
						var urls = "<?php echo base_url();?>pivotp22/create_pivot_bar" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}else if(output == 'line'){
						var urls = "<?php echo base_url();?>pivotp22/create_pivot_bar" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}else if(output == 'area'){
						var urls = "<?php echo base_url();?>pivotp22/create_pivot_bar" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}else if(output == 'scatter'){
						var urls = "<?php echo base_url();?>pivotp22/create_pivot_bar" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}else{
						var urls = "<?php echo base_url();?>pivotp22/create_pivot" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					}
                   
 
                    $.ajax({
                        type: "POST",
                        url: urls,
                        data: JSON.stringify(form_data),
                         dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
                      
						$("#num_s").val(new_tab_no);
						
 						 $("#"+html_tb).show();
						 $("#tbl"+new_tab_no).val(response.data['tabel']);
 						
						 $('#loaderss').html('');
						$('#btn_pro').show();
						
						if(output == 'table'){
							
 							
							var button_html = '<div class="row"><div class="col-md-12" align="right"> <button class = " button_black" onclick="getExport('+new_tab_no+')"><em class="fa fa-download"></em> &nbsp Export</button><br><br></div></div>';
						 
							$("#"+html_tb2).html(button_html+''+response.data['tabel']);
 
							
						}else if(output == 'column'){
							$("#"+html_tb2).html('<div id="'+html_cont+'" ></div>');
                       
							var chart= {
								type: 'column'
							};
							var title = {
							  text: "Population by Profile" 
							};
							var subtitle = {
							  text: ""
							};
							var xAxis = {
							  categories: response.data['categories'],
							  crosshair: true
							};
							var yAxis = {
							  title: {
								 text: 'Population'
							  }
							};
							var tooltip= {
								formatter: function () {
									return ': <strong>' + this.point.y + '</strong>';
								}
							};
							var  plotOptions= {
								column: {
									pointPadding: 0.2, 
									borderWidth: 0
								}
							};
							var series= response.data['categories_val'];

							var json = {};

							json.chart = chart;
							json.title = title;
							json.subtitle = subtitle;
							json.xAxis = xAxis;
							json.yAxis = yAxis;  
							json.series = series;
							json.plotOptions = plotOptions;
							$('#'+html_cont+'').highcharts(json);	
						}else if(output == 'bar'){
							$("#"+html_tb2).html('<div id="'+html_cont+'" ></div>');
                       
							var chart= {
								type: 'bar'
							};
							var title = {
							  text: "Population by Profile"
							};
							var subtitle = {
							  text: ""
							};
							var xAxis = {
							  categories: response.data['categories'],
							  crosshair: true
							};
							var yAxis = {
							  title: {
								 text: 'Population'
							  }
							};
							var tooltip= {
								formatter: function () {
									return ': <strong>' + this.point.y + '</strong>';
								}
							};
							var  plotOptions= {
								column: {
									pointPadding: 0.2, 
									borderWidth: 0
								}
							};
							var series= response.data['categories_val'];

							var json = {};

							json.chart = chart;
							json.title = title;
							json.subtitle = subtitle;
							json.xAxis = xAxis;
							json.yAxis = yAxis;  
							json.series = series;
							json.plotOptions = plotOptions;
							$('#'+html_cont+'').highcharts(json);	
						}else if(output == 'line'){
							$("#"+html_tb2).html('<div id="'+html_cont+'" ></div>');
                       
							var chart= {
								type: 'line'
							};
							var title = {
							  text: "Population by Profile"
							};
							var subtitle = {
							  text: ""
							};
							var xAxis = {
							  categories: response.data['categories'],
							  crosshair: true
							};
							var yAxis = {
							  title: {
								 text: 'Population',
								  plotLines: [{
									value: 0,
									width: 1,
									color: '#808080'
								}]
							  }
							};
							var tooltip= {
								formatter: function () {
									return ': <strong>' + this.point.y + '</strong>';
								}
							};
							var  plotOptions= {
								column: {
									pointPadding: 0.2, 
									borderWidth: 0
								}
							};
							var series= response.data['categories_val'];

							var json = {};

							json.chart = chart;
							json.title = title;
							json.subtitle = subtitle; 
							json.xAxis = xAxis;
							json.yAxis = yAxis;  
							json.series = series;
							json.plotOptions = plotOptions;
							$('#'+html_cont+'').highcharts(json);	
						}else if(output == 'area'){
							$("#"+html_tb2).html('<div id="'+html_cont+'" ></div>');
                       
							var chart= {
								type: 'area'
							};
							var title = {
							  text: "Population by Profile"
							};
							var subtitle = {
							  text: ""
							};
							var xAxis = {
							  categories: response.data['categories'],
							  crosshair: true
							};
							var yAxis = {
							  title: {
								 text: 'Population',
								  plotLines: [{
									value: 0,
									width: 1,
									color: '#808080'
								}]
							  }
							};
							var tooltip= {
								formatter: function () {
									return ': <strong>' + this.point.y + '</strong>';
								}
							};
							var  plotOptions= {
								column: {
									pointPadding: 0.2, 
									borderWidth: 0
								}
							};
							var series= response.data['categories_val'];

							var json = {};

							json.chart = chart;
							json.title = title;
							json.subtitle = subtitle;
							json.xAxis = xAxis;
							json.yAxis = yAxis;  
							json.series = series;
							json.plotOptions = plotOptions;
							$('#'+html_cont+'').highcharts(json);	
						}else if(output == 'scatter'){
							$("#"+html_tb2).html('<div id="'+html_cont+'" ></div>');
                       
							var chart= {
								type: 'scatter'
							};
							var title = {
							  text: "Population by Profile"
							};
							var subtitle = {
							  text: ""
							};
							var xAxis = {
							  categories: response.data['categories'],
							  crosshair: true
							};
							var yAxis = {
							  title: {
								 text: 'Population',
								  plotLines: [{
									value: 0,
									width: 7, 
									color: '#808080'
								}]
							  }
							};
							var tooltip= {
								formatter: function () {
									return ': <strong>' + this.point.y + '</strong>';
								}
							};
							var  plotOptions= {
								column: {
									pointPadding: 0.2, 
									borderWidth: 0
								}
							};
							var series= response.data['categories_val'];

							var json = {};

							json.chart = chart;
							json.title = title;
							json.subtitle = subtitle;
							json.xAxis = xAxis;
							json.yAxis = yAxis;  
							json.series = series;
							json.plotOptions = plotOptions;
							$('#'+html_cont+'').highcharts(json);	
						}else{
							$("#"+html_tb2).html('<div class="col-md-12 text-right"><button class="btn urate-outline-btn" onClick="export()" >Export</button></div>'+response.data['tabel']);
						}
						
						 $("#pr01").removeClass("active"); 
						 $("#pr02").removeClass("active"); 
						 $("#pr03").removeClass("active"); 
						 $("#pr04").removeClass("active"); 
					   $("#"+html_tb).addClass("active"); 
 					   $("#result-panel").show();
					   $("#tabsr_1").removeClass("active"); 
					   $("#tabsr_2").removeClass("active"); 
					   $("#tabsr_3").removeClass("active"); 
					   $("#tabsr_4").removeClass("active"); 
					   $("#tabsr_"+new_tab_no).addClass("active"); 
					   $("#tab_"+new_tab_no).show(); 
					   	$('#tab_1').css('background-color','#E5E5E5');
						$('#tab_2').css('background-color','#E5E5E5');
						$('#tab_3').css('background-color','#E5E5E5');
						$('#tab_4').css('background-color','#E5E5E5');
						$('#tab_'+new_tab_no).css('background-color','#fff');
					   
					   
					    

                    }).fail(function(xhr, status, message) {
                        $("#laod").empty();
                        $('#savecr').show();
                    });
		}else{
			
			if(tab_cnt >= 4){
				err_msg += 'Maximal 4 Tabs<br>';
			}
			
			 $('#err_msg').html(err_msg);
			 $('#modalTab').modal('show');
			
			
		}
	} 
        
        function toObject(arr) {
          var rv = {};
          for (var i = 0; i < arr.length; ++i)
            rv[i] = arr[i];
          return rv;
        }
    </script>	

