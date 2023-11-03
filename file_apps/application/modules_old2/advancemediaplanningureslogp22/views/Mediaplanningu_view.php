  		
  <style> 
      .grandItemTit {
          color: #cc3300; 
          font-size: 22px;
      }
                
      .grandItemCon {
          color: #000000; 
          font-size: 26px;
      }
                
      .buttonExcel {
          float: right;
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
      
      .table > thead > tr > th > img {
        width: 16px;
        float: right;
      }
      
      .dt-buttons{
          height: 40px;
      }

	  
	         div.dt-buttons{
		position:relative;
		float:right;
		background-color:#000;
		border-radius:5px;
		padding:6px 18px 6px 18px; 
		color:#fff;
		margin-top:-30px;
		margin-bottom:30px;
		font-family: 'Lato', sans-serif; 
	}
	
	div.dt-buttons a{
		
		color:#fff;
	}
	
	div.dt-button{
		
		font-family: 'Lato', sans-serif; 
		
	}
	</style>
 <link href="<?php echo $path;?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" /> 

<!-- Bootstrap Material Datetime Picker Plugin Js -->
 <script src="<?php echo $path;?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script> 

<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet">	
<link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	

<style>
.jstree-themeicon{
	 display: none !important;
}

    
    
    .dropdown-menu{
        margin-top: 0px !important;
    }
</style>
<script>
$(function () {	
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });	
});
	
</script>

	<div class="content-wrapper">
      <div class="container-fluid">      
          <div class="row">
              <div class="col-md-6">                    
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">UrbanRate</li>
                      <li class="breadcrumb-item active">Media Planning</li>
                  </ol>
                  <h3 class="page-title-inner">Channel Pay TV</h3>
              </div>  
				<div class="col-md-6 text-right">
					<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
				</div>				  
          </div>
          <div class="panel urate-panels">
              <div class="panel-body" style="height: 280px;">
                  <div class="row">
				  
					<div class="col-lg-12" style="z-index: 999;">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Periode</label>
									<input type="text" class="form-control urate-form-input" name="start_date" id="start_date" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>End Date Periode</label>
									<input type="text" class="form-control urate-form-input" name="end_date" id="end_date" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Ads Placement Start Date</label>
									<input type="text" class="form-control urate-form-input" name="start_date_ads" id="start_date_ads" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Ads Placement End Date</label>
									<input type="text" class="form-control urate-form-input" name="end_date_ads" id="end_date_ads" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
					</div>
					<div class="col-lg-12" style="z-index: 998;">	
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Profile</label>
									  <select class='urate-select' name="profile" id="profile" title='Please Choose Profile ...'>
										  <option value="0" >All People 2021</option>
										  <option value="1" >All People 2022</option>
										  <?php foreach($profile as $key) { ?>
										  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
										  <?php } ?>
									  </select>
								</div>
							</div>
							<div class="col-lg-3" >	
								<div class="form-group">
									<div class="col-md-6" style="">
										<label> TV Channel </label>
									</div>
									<div class="col-md-6 text-right" style="">
										<a href="#" data-toggle="modal" onClick="load_modal_save_channel()" id="dctriger" style="color:red"><span class="ion-upload"></span> Save</a>
										<a href="#" data-toggle="modal" onClick="load_modal_load_channel()" id="ldctriger" style="color:red"><span class="ion-android-download"></span> Load</a>
									</div>
									<div class="select-wrapper">
									  <select class='urate-select grid-menu' name="channel" id="channel" title='Please Choose Channel ...'>
										  <option value="0" >All Channel</option>     
												<?php 
												foreach($channels as $nhb){
													echo "<option value='".$nhb['CHANNEL']."' >".$nhb['CHANNEL']."</option>";
												}
												?>
									  </select>
									</div> 
								</div>
							</div>
							<div class="col-lg-3" style="">	
								<div class="form-group">
									<label>Objective</label>
									<div class="select-wrapper">
									  <select class='urate-select' name="setting" id="setting" title='Please Choose Objective ...'>
										  <option value="high_tvr" >High TVR</option>
										  <option value="maximum_cost" >Maximum Spot</option>
										  <option value="minimum_cprp" >Minimum CPRP</option>
										  <option value="index" >High Index</option>
										  <option value="minimum_cprp" >Maximum GRP</option>
										  <option value="maximum_reach" >Maximum Reach</option>
									  </select>
									</div>
								</div>
							</div>
					</div>
					<div class="col-lg-12" style="position: absolute;top: 285px;margin-left: -10px;">			

							
							<div class="col-lg-3" style="">	
								<div class="form-group">
									<label>Cost</label>
									<input type="text" class="form-input urate-form-input rupiah" id="cost" placeholder="Please Submit Cost ..." value="1000000000" style="padding: 6px 12px;">
								</div>
							</div>
							
							<div class="col-lg-3" style="">	
								<div class="form-group">
									<label>Discount</label>
									<div class="select-wrapper">
									    <select class='urate-select' name="discount" id="discount" title='Please Choose discount ...'>
											<?php for($i = 0;$i<15;$i++){ ?>
											  <option value="<?php echo $i*5; ?>" ><?php echo $i*5; ?> %</option>
											<?php } ?>  
										  </select>
									</div>
								</div>
							</div>
					</div>
				  
                      <!-- PERIODE FIELD -->
                     
                  </div>
              </div>
          </div>

		  		  <div class="panel2" id="panel-blank" >
		
			<img class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;"  alt="image" id="sss">
		  
		  </div>
		   <div class="loader" style="display:none">
                 <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" alt="image">
            </div>
		  
          <div class="panel urate-panel urate-panel-results" style="display:none">
             <div class="panel-headings">
                   <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
					
				</div>
              </div>
			  
			   <div class="panel-body">
				
					  <div class="col-md-8">
                                <div class="row" style="background-color:#F2F2F2;padding:5px;color:#000;border: none;border-radius:5px">
									 <div class="col-md-3" id="tabs_table" style="border: none;background-color:#fff;border-radius:5px;">
										<button id="tab_table" style="border: none;background-color:#fff;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('table')" href="#table" aria-controls="table" role="tab" data-toggle="tab"><strong>Mediaplan</strong></button>
									</div>
									<div class="col-md-3" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Summary Mediaplan</strong></button>
									</div>
									<div class="col-md-3" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_ads" style="border: none;border-radius:5px;padding:3px 15px 3px 15px" onclick="cal()" href="#ads" aria-controls="ads" role="tab" data-toggle="tab"><strong>Placement Ads</strong></button>
									</div>
									<div class="col-md-3" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_summ_ads" style="border: none;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('summ_ads')" href="#summ_ads" aria-controls="summ_ads" role="tab" data-toggle="tab"><strong>Summary Placement Ads</strong></button>
									</div>
	
								</div>
                              </div>
			  

                  </ul>
                  <!-- / Nav tabs -->
                  <div class="tab-content" style="margin-top:70px;">
 
                      <div role="tabpanel" class="tab-pane fade in active" id="table">
                            <div class="result-table" id='result-table'>
                                <table id="myTable" class="table table-striped " aria-describedby="mydesc" style=""> 
  							                    <thead style="color:red">
                                    <tr>
                                        <th align="center" scope="row">Tanggal</th>
                                        <th align="center" scope="row">Channel</th>
                                        <th align="center" scope="row">Program</th>
                                        <th align="center" scope="row">Ads Type</th>
                                        <th align="right" scope="row">TVR</th>
                                        <th align="right" scope="row">Share</th>
                                        <th align="right" scope="row">CPRP</th>
                                        <th align="right" scope="row">Cost</th>
                                        <th align="right" scope="row">Cost / Audience</th>
                                        <th align="right" scope="row">Index</th>
                                    </tr>
                                    </thead>             
                                </table>   
                            </div>
                          
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="chart" style="margin-top:50px">
                            <div class="result-summary panel-body">
                                <div class="summary-panel" style="background-color:#F6F6F6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div id="spoted">
					</div>
                                            <br><br>
                                            <div id="costed"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="tvred"></div>
					    <br><br>
                                            <div id="grpps"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="maxtvr"></div>
                                            <br><br>
                                            <div id="mintvr"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="avgtvr"></div>
                                            <br><br>
                                            <div id="cprp1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="summary-table">
                                    <div class="row">
									
										   <div class="col-md-6">
											 <div class="row" style="padding:5px">
									
												<div class="col-lg-12 urate-panel" id="summ_prog1">
													<h4>Summary Program</h4>
													<table id="example1" aria-describedby="mydesc" class="table table-striped table-bordered example" style="table-layout:fixed ">
														<thead>
															  <tr>
																  <th scope="row">Channel</th>
																  <th scope="row">Program</th>
																  <th scope="row">Ads Type</th>
																  <th scope="row">Spot</th>
																  <th scope="row">Cost/Spot</th>
																  <th scope="row">GRP</th>
															  </tr>
														</thead>
													</table>
												</div>
										
											</div>
                                        </div>
										
										 <div class="col-md-6">
											 <div class="row" style="padding:5px">
												
												<div class="col-lg-12 urate-panel" id="summ_prog2" >
													<h4>Summary Channel</h4>
													<table id="example2" class="table table-striped table-bordered example" style="table-layout:fixed " aria-describedby="mydesc">
														<thead>
															<tr>
																<th scope="row">Channel</th>
																<th scope="row">Ads Type</th>
																<th scope="row">Spot</th>
																<th scope="row">Cost/Spot</th>
																  <th scope="row">GRP</th>
															</tr>
														</thead>
													</table>
												</div>
										
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
					
						
						  <div role="tabpanel" class="tab-pane fade" id="summ_compare" >
                            <div class="result-summary" >
							
                                <div class="summary-panel" >
									<input type='hidden' id='spot_com' /> 
									<input type='hidden' id='spot_com2' /> 
									
									<input type='hidden' id='cost_com' /> 
									<input type='hidden' id='cost_com2' /> 
									
										<input type='hidden' id='tvred_com' /> 
									<input type='hidden' id='tvred_com2' /> 
									
										<input type='hidden' id='maxtvr_com' /> 
									<input type='hidden' id='maxtvr_com2' /> 
									 
										<input type='hidden' id='mintvr_com' /> 
									<input type='hidden' id='mintvr_com2' /> 
									
										<input type='hidden' id='avgtvr_com' /> 
									<input type='hidden' id='avgtvr_com2' /> 
									
										<input type='hidden' id='cprp1_com' /> 
									<input type='hidden' id='cprp1_com2' /> 
									
									<input type='hidden' id='cpv_com' /> 
									<input type='hidden' id='cpv_com2' /> 
									
									<input type='hidden' id='count_data_cal' /> 
									<input type='hidden' id='data_cal' /> 
									
                                   
									
									<div class="row">
										<div class="col-md-6"> 
											 <div id="texted_ads2" ><h3><strong>Summary</strong></h3></div> 
										</div>
										<div class="col-md-6" align="right"> 
											<button class='button_black' href='#' onclick='print_summary()' style="top:0px !important;"> <span style="font-size:12px !important" ><em class="fa fa-download"></em> &nbsp Export</span></button>
										</div>
									</div>
									<br>
									
                                    <div class="row">
									
										<table id="myTable_result" aria-describedby="mydesc" class="table table-striped " style="table-layout:fixed "> <!-- id="example" -->
											<thead >
											<tr style="color:red">
												<th align="left" scope="row"><strong>Deskripsi</strong></th>
												<th align="right" scope="row"><strong>Mediaplan</strong></th>
												<th align="right" scope="row"><strong>Placement Ads</strong></th>
												<th align="right" scope="row"><strong>Selisih</strong></th>
												<th align="right" scope="row"><strong>Performansi (%)</strong></th>
											</tr>
											<tr id="spoted_summ" style="background-color:#F3F3F3">
												
											</tr>
											<tr id="costed_summ">
												
											</tr>
											<tr id="totvr_summ" style="background-color:#F3F3F3">
												
											</tr>
											<tr id="maxtvr_summ">
												
											</tr>
											<tr id="mintvr_summ" style="background-color:#F3F3F3">
												
											</tr>
											<tr id="avgtvr_summ">
												
											</tr>
											<tr id="cprp_summ" style="background-color:#F3F3F3">
												
											</tr>
											<tr id="cpv_summ">
												
											</tr>
											</thead>             
										</table>   
									
                                        <div class="col-md-3">
                                            <div id="spoted_ads2"></div>
                                            <br><br>
                                            <div id="costed_ads2"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="tvred_ads2"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="maxtvr_ads2"></div>
                                            <br><br>
                                            <div id="mintvr_ads2"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="avgtvr_ads2"></div>
                                            <br><br>
                                            <div id="cprp1_ads2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>

					
					  <div role="tabpanel" class="tab-pane fade" id="summ_ads">
                            <div class="result-summary">
                                <div class="summary-panel" style="background-color:#F6F6F6">
                                    <div id="texted_ads"></div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div id="spoted_ads"></div>
                                            <br><br>
                                            <div id="costed_ads"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="tvred_ads"></div>
											 <br><br>
                                            <div id="cprp1_ads"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="maxtvr_ads"></div>
                                            <br><br>
                                            <div id="mintvr_ads"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="avgtvr_ads"></div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="summary-table">
                                    <div class="row">
									
										<div class="col-md-6">
											 <div class="row" style="padding:5px">
									
												<div class="col-lg-12 urate-panel" id="summ_prog1ads" >
													<h4>Summary Program</h4>
													<table id="example1_ads" class="table table-striped table-bordered example"  aria-describedby="mydesc">
														<thead>
															  <tr>
																  <th scope="row">Channel</th>
																  <th scope="row">Program</th>
																  <th scope="row">Ads Type</th>
																  <th scope="row">Spot</th>
																  <th scope="row">Cost/Spot</th>
																  <th scope="row">GRP</th>
															  </tr>
														</thead>
													</table>
												</div>
										
											</div>
                                        </div>
										
										<div class="col-md-6">
											 <div class="row" style="padding:5px">
										
												<div class="col-lg-12 urate-panel" id="summ_prog2ads">
													<h4>Summary Channel</h4>
													<table id="example2_ads" class="table table-striped table-bordered example" aria-describedby="mydesc">
														<thead>
															<tr>
																<th scope="row">Channel</th>
																<th scope="row">Ads Type</th>
																<th scope="row">Spot</th>
																<th scope="row">Cost/Spot</th>
																<th scope="row">GRP</th>
															</tr>
														</thead>
													</table>
												</div>
										
											</div>
                                        </div>
										
                                    </div>
                                </div>
                            </div>
                      </div>
					  
					  <div role="tabpanel" class="tab-pane fade" id="ads">
							<button class='button_black' href='#' onclick='print_cal()'> <span><em class="fa fa-download"></em> &nbsp Export</span></button>
						<br><br><br>
						<div id='calendar'></div>
					   
					   
					  </div>
					  
                  </div>
              </div>
			  
              
          </div>
      </div>
  </div>                                    
  
    <!-- calendar modal -->
    <div id="CalenderModalNew_a" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary antosubmit">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Detail</h4>
          </div>
          <div class="modal-body">

            <div id="testmodal2" style="padding: 5px 20px;">
              <form id="antoform2" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Program</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title2" name="title2" readOnly>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Ads Type</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="ads" name="ads" readOnly>
                  </div>
                </div>
				
				                <div class="form-group">
                  <label class="col-sm-3 control-label">Start Time</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="start" name="start" readOnly>
                  </div>
                </div>
				
				                <div class="form-group">
                  <label class="col-sm-3 control-label">End Time</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="end" name="end" readOnly>
                  </div>
                </div>
				
				  <div class="form-group">
                  <label class="col-sm-3 control-label">Cost</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="rate_ads" name="rate_ads" readOnly>
                  </div>
                </div>
				
								  <div class="form-group">
                  <label class="col-sm-3 control-label">TVR</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="tvr_ads" name="tvr_ads" readOnly>
                  </div>
                </div>
				
								  <div class="form-group">
                  <label class="col-sm-3 control-label">Share</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="tvs_ads" name="tvs_ads" readOnly>
                  </div>
                </div>
              
				  <div class="form-group">
                  <label class="col-sm-3 control-label">CPRP</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="cprp_ads" name="cprp_ads" readOnly>
                  </div>
                </div>
				
				 <div class="form-group">
                  <label class="col-sm-3 control-label">Cost per Audience</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="cpv_ads" name="cpv_ads" readOnly>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
	
	<!-- Modal Load Channel -->
	<div class="modal fade modalnewchannel" id="modalloadchannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Load Channel List</strong></h4>
					<h6 class="modal-titles" id="myModalLabel">Load previously saved channel list</h6>
				</div>
				<div class="modal-body">
					<form action="" class="row">
						<div class="form-group col-md-12">
							<table id="example9" class="table table-striped " style="width: 100%" aria-describedby="mydesc">
							<thead style="color:red">
								<tr>
									<th scope="row">No. </th>
									<th scope="row">List Name</th>
									<th scope="row">Channel</th>
									<th width="140px" scope="row">Action</th>
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
          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" alt="img" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel </button>
					
				</div>
			</div>
		</div>
	</div>
	
	
		<div class="modal fade modalnewchannel" id="modalnewchannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Save Channel list</strong></h4>
					<h6 class="modal-titles" id="myModalLabel">Save currently selected channel as a preset</h6>
				</div>
				<div class="modal-body">
					<form action="" class="row">
						<div class="form-group col-md-12">
							<label for="">Save Name</label>
							<input type="text" class="form-control urate-form-input" name="save_channel_name" id="save_channel_name" placeholder="Save Name">
						</div>
						<div class="form-group col-md-12">
							<label for="">Channel</label>
							<textarea class="form-control urate-form-input" name="save_channel_list" id="save_channel_list" placeholder="Save Name" readOnly='readOnly'></textarea>
						</div>
						
					</form>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" alt="img" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_black" onClick="save_channel_list()"><em class="fa fa-check"></em> &nbsp Save</button>
				</div>
			</div>
		</div>
	</div>
	
	
	  <!-- Modal Load Channel -->
	<div class="modal fade modalnewchannel" id="modalloadorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog modal-lg" role="document" style="width:200px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Sort Order</strong></h4>
				</div>
				<div class="modal-body">
					<form action="" class="row">
						<div class="form-group col-md-12">
							<textarea id='sort_text' class='form-control urate-form-input'  ></textarea>
						
							<input type="checkbox" class='cbs' id="AUDIENCE_SORT" name="sort1" value="AUDIENCE"> AUDIENCE<br>
							<input type="checkbox" class='cbs' id="TYPE_SORT" name="sort1" value="CHANNEL"> CHANNEL<br>
							<input type="checkbox" class='cbs' id="TVR_SORT" name="sort2" value="TVR"> TVR<br>
							<input type="checkbox" class='cbs' id="TVS_SORT" name="sort3" value="TVS" > TVS<br>
							<input type="checkbox" class='cbs' id="TOTAL_VIEWS_SORT" name="sort4" value="TOTAL_VIEWS" > TOTAL VIEWS<br>
							<input type="checkbox" class='cbs' id="REACH_SORT" name="sort5" value="REACH" > REACH<br>
						</div>
						
						
					</form>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" alt="img" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal">Close</button>
					
				</div>
			</div>
		</div>
	</div>

    <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
    <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
  
  <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>    
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  
    <link href="<?php echo $path8; ?>vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo $path8; ?>vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
	
	<script src="<?php echo $path8; ?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo $path8; ?>vendors/fullcalendar/dist/fullcalendar.min.js"></script>
  
  <script language="javascript">
      $(document).ready(function(){     

          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  endDate: '0d',
                  defaultDate: new Date()
              });               
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY')); 
          });
          
          $('.rupiah').priceFormat({
          		prefix: 'Rp ',
          		centsSeparator: '',
          		centsLimit: 0,
          		thousandsSeparator: '.'
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
          
          $('#custom_channel').click(function() {   
              $(".search-channel-con").remove();
              
              var currChecked = $("#channel").val();
              
              if(currChecked != ""){
                  $("[data-real='"+currChecked+"']").parent().addClass('checked');
              }
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);       
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          });
          
          $('[data-id="setting"]').click(function() {
              $('.urate-select-dropdown').each(function(){
                  $(this).removeClass('active');
                  $(".search-channel-con").remove();        
              });
          });       
          
          $('#custom_profile').click(function() {   
              $(".search-profile-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-profile-con'><input type='text' name='search_profile' id='search_profile' class='form-control urate-form-input' value='' onkeypress='search_profile()' paceholder='Search Profile'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-profile-con").remove();
                  $("#custom_profile").after(searchElement);   
                  $("#search_profile").focus();
              } else {
                  $(".search-profile-con").remove();
              }     
              
              $('[data-for = "profile"]').click(function() { 
                  $('#profile').next().text($(this).text());
                  $('#profile').attr('value',$(this).data("real"));
                  
                  $(this).closest('.default').removeClass('active');
                  
                  $(".search-profile-con").remove();                       
              });
              
              $('#profile').empty('');
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People 2021</a></li><li data-for='profile'><a href='#' data-real='1' class='urate-select-form-two' data-for='profile'>All People 2022</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'advancemediaplanningureslogp22/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                  dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
                      $("#profile").next().next().next().empty('');   
                      
                      for(i=0; i < response.length; i++){                       
                          if(response[0] == "Value not found!"){
                              strResult = response[0]; 
							  strText = '';
                          } else {
                              strResult = response[i].id;
                              strText = response[i].name;
                          }
                          
                          strVar += "<li data-for='profile'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='profile'>"+strText+"</a></li>";                          
                      } 
                                            
                      $("#profile").next().next().next().append(strVar);   
                                      
                      $('[data-for = "profile"]').click(function() { 
                          $('#profile').next().text($(this).text());
                          $('#profile').attr('value',$(this).data("real"));
                          
                          $(this).closest('.default').removeClass('active');
                          
                          $(".search-profile-con").remove();                       
                      });                                                    
                  }, error: function(obj, response) {
                      console.log('ajax list detail error:' + response);	
                  } 
              });
          });
          
          $("#start_date").on("change",function(){
              $('#profile').empty('');
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'advancemediaplanningureslogp22/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                  dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
                      $("#profile").next().next().next().empty('');   
                      
                      for(i=0; i < response.length; i++){                       
                          if(response[0] == "Value not found!"){
                              strResult = response[0]; 
							  strText = '';
                          } else {
                              strResult = response[i].id;
                              strText = response[i].name;
                          }
                          
                          strVar += "<li data-for='profile'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='profile'>"+strText+"</a></li>";                          
                      } 
                                            
                      $("#profile").next().next().next().append(strVar);   
                                      
                      $('[data-for = "profile"]').click(function() { 
                          $('#profile').next().text($(this).text());
                          $('#profile').attr('value',$(this).data("real"));
                          
                          $(this).closest('.default').removeClass('active');
                          
                          $(".search-profile-con").remove();                       
                      });                                                    
                  }, error: function(obj, response) {
                      console.log('ajax list detail error:' + response);	
                  } 
              });                            
          });
      });
                 

		
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
				  url : "<?php echo base_url().'audiencemeasurement/save_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
					  
						$('#modalnewchannel').modal('hide');					  
				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
				  }
			  });    
			
		}
		
		function load_channel(channel_list){
			
			$('[data-for = "channel"]').each(function(){
                $(this).removeClass('checked');
            });
			
			var arr_channel = channel_list.split(',');

			$('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value',channel_list);
			
			var $text ='';
			for(var i = 0;i < arr_channel.length; i++){
				$text += '<span class="menu-item">'+arr_channel[i]+'</span>';
			}		   
			 
            $('#custom_channel').closest('.grid-menu').children('.urate-custom-button').text('').append($text);
		  
			for(var i = 0;i < arr_channel.length; i++){
				$('[data-real = "'+arr_channel[i]+'"]').parent().addClass('checked');
			}	
			
			$('#modalloadchannel').modal('hide');

		}
		
		function load_modal_save_channel(){
			
			
			 var channel = $('#channel').val();
			 $('#save_channel_name').val('');
			
			$('#modalnewchannel').modal('show');
			$('#save_channel_list').val(channel);
			
			
		}
		
		function load_modal_load_channel(){
						
			 var form_data = {
				  sess_user_id     : ''
			  };       
			
			
			  $.ajax({
				  url : "<?php echo base_url().'audiencemeasurement/load_channels'?>",
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
							html += '		<td><button type="button" class="button_black" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\')"><i class="fa fa-refresh"></i> &nbsp Load</button></td>';
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
		
		function formatNumber(number)
		{
			number = number.toFixed(2) + '';
			x = number.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + '.' + '$2');
			}
			return x1;
		}
		
		function numberWithCommas(x) {
			var parts = x.toString().split(".");
			parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			return parts.join(",");
		}
		
		function sum_all(){
			
			$('.nav-tabs a[href="#compare"]').tab('show');
			
			
			var spot_com = $('#spot_com').val();
			var spot_com2 = $('#spot_com2').val();
			var cost_com = $('#cost_com').val();
			var cost_com2 = $('#cost_com2').val();
			var tvred_com = $('#tvred_com').val();
			var tvred_com2 = $('#tvred_com2').val();
			var maxtvr_com = $('#maxtvr_com').val();     
			var maxtvr_com2 = $('#maxtvr_com2').val();  
			var mintvr_com = $('#mintvr_com').val(); 
			var mintvr_com2 = $('#mintvr_com2').val(); 
			var avgtvr_com = $('#avgtvr_com').val(); 
			var avgtvr_com2 = $('#avgtvr_com2').val(); 
			var cprp1_com = $('#cprp1_com').val(); 
			var cprp1_com2 = $('#cprp1_com2').val(); 
			var cpv_com = $('#cpv_com').val(); 
			var cpv_com2 = $('#cpv_com2').val(); 

			var sel_spot = spot_com2-spot_com;
			var aku_spot = (spot_com2/spot_com)*100;
			var aku_spot = aku_spot.toFixed(2);
			
			var costa1 = cost_com2.replace(".", "");
			var costa2 = costa1.replace(".", "");
			var costa3 = costa2.replace(".", "");
			
			var costb1 = cost_com.replace(".", "");
			var costb2 = costb1.replace(".", "");
			var costb3 = costb2.replace(".", "");
			
			var cprpa1 = cprp1_com2.replace(".", "");
			var cprpa2 = cprpa1.replace(".", "");
			var cprpa3 = cprpa2.replace(".", "");
			
			var cprpb1 = cprp1_com.replace(".", "");
			var cprpb2 = cprpb1.replace(".", "");
			var cprpb3 = cprpb2.replace(".", "");
			
			var apva1 = cpv_com.replace(".", "");
			var apva2 = apva1.replace(".", "");
			var apva3 = apva2.replace(".", "");
			
			var apvb1 = cpv_com2.replace(".", "");
			var apvb2 = apvb1.replace(".", "");
			var apvb3 = apvb2.replace(".", "");
			

			
			
			var sel_cost = formatNumber(parseInt(costb3)-parseInt(costa3));
			var aku_cost = (parseInt(costb3)/parseInt(costa3))*100;
			var aku_cost = '000000000';
 
			var sel_cprp = formatNumber(parseInt(cprpb3)-parseInt(cprpa3));
			var aku_cprp = (parseInt(cprpb3)/parseInt(cprpa3))*100;
			var aku_cprp = aku_cprp.toFixed(2);
			
			var sel_tottvr = parseFloat(tvred_com2.replace(",", "."))-parseFloat(tvred_com.replace(",", "."));
			var sel_tottvr = sel_tottvr.toFixed(2);
			var aku_tottvr = (parseFloat(tvred_com2.replace(",", "."))/parseFloat(tvred_com.replace(",", ".")))*100;
			var aku_tottvr = aku_tottvr.toFixed(2);
			
			var sel_apv = parseFloat(apvb3.replace(",", "."))-parseFloat(apva3.replace(",", "."));
			var sel_apv = numberWithCommas(sel_apv.toFixed(2));
			var aku_apv = (parseFloat(apvb3.replace(",", "."))/parseFloat(apva3.replace(",", ".")))*100;
			var aku_apv = aku_apv.toFixed(2);
			
			var sel_maxtvr = parseFloat(maxtvr_com2.replace(",", "."))-parseFloat(maxtvr_com.replace(",", "."));
			var sel_maxtvr = sel_maxtvr.toFixed(2);
			var aku_maxtvr = (parseFloat(maxtvr_com2.replace(",", "."))/parseFloat(maxtvr_com.replace(",", ".")))*100;
			var aku_maxtvr = aku_maxtvr.toFixed(2);
			
			var sel_mintvr = parseFloat(mintvr_com2.replace(",", "."))-parseFloat(mintvr_com.replace(",", "."));
			var sel_mintvr = sel_mintvr.toFixed(2);
			if(mintvr_com == 0){
					var aku_mintvr = 0;
				var aku_mintvr = aku_mintvr.toFixed(2);
			}else{
				var aku_mintvr = (parseFloat(mintvr_com2.replace(",", "."))/parseFloat(mintvr_com.replace(",", ".")))*100;
			
				var aku_mintvr = aku_mintvr.toFixed(2);
			}
			
			
			var sel_avgtvr = parseFloat(avgtvr_com2.replace(",", "."))-parseFloat(avgtvr_com.replace(",", "."));
			var sel_avgtvr = sel_avgtvr.toFixed(2);
			var aku_avgtvr = (parseFloat(avgtvr_com2.replace(",", "."))/parseFloat(avgtvr_com.replace(",", ".")))*100;
			var aku_avgtvr = aku_avgtvr.toFixed(2);

			
			$('#spoted_summ').html('<td align="center">Total Spot</td><td align="right">'+spot_com+'</td><td align="right">'+spot_com2+'</td><td align="right">'+sel_spot+'</td><td align="right">'+aku_spot.replace(".", ",")+'</td>'); 
			
			$('#costed_summ').html('<td align="center">Total Cost</td><td align="right">'+cost_com+'</td><td align="right">'+cost_com2+'</td><td align="right">'+sel_cost+'</td><td align="right">'+aku_cost.replace(".", ",")+'</td>'); 
			
			$('#totvr_summ').html('<td align="center">Total TVR</td><td align="right">'+tvred_com+'</td><td align="right">'+tvred_com2+'</td><td align="right">'+sel_tottvr.replace(".", ",")+'</td><td align="right">'+aku_tottvr.replace(".", ",")+'</td>'); 
			
			$('#maxtvr_summ').html('<td align="center">Maximum TVR</td><td align="right">'+maxtvr_com+'</td><td align="right">'+maxtvr_com2+'</td><td align="right">'+sel_maxtvr.replace(".", ",")+'</td><td align="right">'+aku_maxtvr.replace(".", ",")+'</td>'); 
			
			$('#mintvr_summ').html('<td align="center">Minimum TVR</td><td align="right">'+mintvr_com+'</td><td align="right">'+mintvr_com2+'</td><td align="right">'+sel_mintvr.replace(".", ",")+'</td><td align="right">'+aku_mintvr.replace(".", ",")+'</td>'); 
			
			$('#avgtvr_summ').html('<td align="center">Average TVR</td><td align="right">'+avgtvr_com+'</td><td align="right">'+avgtvr_com2+'</td><td align="right">'+sel_avgtvr.replace(".", ",")+'</td><td align="right">'+aku_avgtvr.replace(".", ",")+'</td>'); 
			
			$('#cprp_summ').html('<td align="center">CPRP</td><td align="right">'+cprp1_com+'</td><td align="right">'+cprp1_com2+'</td><td align="right">'+sel_cprp+'</td><td align="right">'+aku_cprp.replace(".", ",")+'</td>'); 
			
			$('#cpv_summ').html('<td align="center">Cost per Audience</td><td align="right">'+cpv_com+'</td><td align="right">'+cpv_com2+'</td><td align="right">'+sel_apv+'</td><td align="right">'+aku_apv.replace(".", ",")+'</td>'); 
			
			
			

			
			
		}
		
		
		
		function print_summary(){
			
			
			
			var spot_com = $('#spot_com').val();
			var spot_com2 = $('#spot_com2').val();
			var cost_com = $('#cost_com').val();
			var cost_com2 = $('#cost_com2').val();
			var tvred_com = $('#tvred_com').val();
			var tvred_com2 = $('#tvred_com2').val();
			var maxtvr_com = $('#maxtvr_com').val();     
			var maxtvr_com2 = $('#maxtvr_com2').val();  
			var mintvr_com = $('#mintvr_com').val(); 
			var mintvr_com2 = $('#mintvr_com2').val(); 
			var avgtvr_com = $('#avgtvr_com').val(); 
			var avgtvr_com2 = $('#avgtvr_com2').val(); 
			var cprp1_com = $('#cprp1_com').val(); 
			var cprp1_com2 = $('#cprp1_com2').val(); 
			var cpv_com = $('#cpv_com').val(); 
			var cpv_com2 = $('#cpv_com2').val(); 

			var sel_spot = spot_com2-spot_com;
			var aku_spot = (spot_com2/spot_com)*100;
			var aku_spot = aku_spot.toFixed(2);
			
			var costa1 = cost_com2.replace(".", "");
			var costa2 = costa1.replace(".", "");
			var costa3 = costa2.replace(".", "");
			
			var costb1 = cost_com.replace(".", "");
			var costb2 = costb1.replace(".", "");
			var costb3 = costb2.replace(".", "");
			
			var cprpa1 = cprp1_com2.replace(".", "");
			var cprpa2 = cprpa1.replace(".", "");
			var cprpa3 = cprpa2.replace(".", "");
			
			var cprpb1 = cprp1_com.replace(".", "");
			var cprpb2 = cprpb1.replace(".", "");
			var cprpb3 = cprpb2.replace(".", "");
			
			var apva1 = cpv_com.replace(".", "");
			var apva2 = apva1.replace(".", "");
			var apva3 = apva2.replace(".", "");
			
			var apvb1 = cpv_com2.replace(".", "");
			var apvb2 = apvb1.replace(".", "");
			var apvb3 = apvb2.replace(".", "");
			

			var sel_cost = formatNumber(parseInt(costa3)-parseInt(costb3));
			var aku_cost = (parseInt(costa3)/parseInt(costb3))*100;
			var aku_cost = aku_cost.toFixed(2);

			var sel_cprp = formatNumber(parseInt(cprpb3)-parseInt(cprpa3));
			var aku_cprp = (parseInt(cprpb3)/parseInt(cprpa3))*100;
			var aku_cprp = aku_cprp.toFixed(2);
			
			var sel_tottvr = parseFloat(tvred_com2.replace(",", "."))-parseFloat(tvred_com.replace(",", "."));
			var sel_tottvr = sel_tottvr.toFixed(2);
			var aku_tottvr = (parseFloat(tvred_com2.replace(",", "."))/parseFloat(tvred_com.replace(",", ".")))*100;
			var aku_tottvr = aku_tottvr.toFixed(2);
			
			var sel_apv = parseFloat(apvb3.replace(",", "."))-parseFloat(apva3.replace(",", "."));
			var sel_apv = numberWithCommas(sel_apv.toFixed(2));
			var aku_apv = (parseFloat(apvb3.replace(",", "."))/parseFloat(apva3.replace(",", ".")))*100;
			var aku_apv = aku_apv.toFixed(2);
			
			var sel_maxtvr = parseFloat(maxtvr_com2.replace(",", "."))-parseFloat(maxtvr_com.replace(",", "."));
			var sel_maxtvr = sel_maxtvr.toFixed(2);
			var aku_maxtvr = (parseFloat(maxtvr_com2.replace(",", "."))/parseFloat(maxtvr_com.replace(",", ".")))*100;
			var aku_maxtvr = aku_maxtvr.toFixed(2);
			
			var sel_mintvr = parseFloat(mintvr_com2.replace(",", "."))-parseFloat(mintvr_com.replace(",", "."));
			var sel_mintvr = sel_mintvr.toFixed(2);
			var aku_mintvr = (parseFloat(mintvr_com2.replace(",", "."))/parseFloat(mintvr_com.replace(",", ".")))*100;
			var aku_mintvr = aku_mintvr.toFixed(2);
			
			var sel_avgtvr = parseFloat(avgtvr_com2.replace(",", "."))-parseFloat(avgtvr_com.replace(",", "."));
			var sel_avgtvr = sel_avgtvr.toFixed(2);
			var aku_avgtvr = (parseFloat(avgtvr_com2.replace(",", "."))/parseFloat(avgtvr_com.replace(",", ".")))*100;
			var aku_avgtvr = aku_avgtvr.toFixed(2);

			
			var form_data = new FormData();  
			form_data.append('spot_com',spot_com);
			form_data.append('spot_com2', spot_com2);
			form_data.append('cost_com', cost_com);
			form_data.append('cost_com2', cost_com2);
			form_data.append('tvred_com', tvred_com);
			form_data.append('tvred_com2', tvred_com2);
			form_data.append('maxtvr_com', maxtvr_com);
			form_data.append('maxtvr_com2', maxtvr_com2);		
			form_data.append('mintvr_com', mintvr_com);
			form_data.append('mintvr_com2', mintvr_com2);
			form_data.append('avgtvr_com', avgtvr_com);
			form_data.append('avgtvr_com2', avgtvr_com2);
			form_data.append('cprp1_com', cprp1_com);
			form_data.append('cprp1_com2', cprp1_com2);
			form_data.append('cpv_com', cpv_com);
			form_data.append('cpv_com2', cpv_com2);
			
			form_data.append('aku_spot', aku_spot);
			form_data.append('sel_spot', sel_spot);
			form_data.append('sel_cost', sel_cost);
			form_data.append('sel_cprp', sel_cprp);
			form_data.append('costa3', costa3);
			form_data.append('costb3', costb3);
			form_data.append('cprpa3', cprpa3);
			form_data.append('cprpb3', cprpb3);
			form_data.append('aku_cost', aku_cost);
			form_data.append('aku_cprp', aku_cprp);
			form_data.append('sel_tottvr', sel_tottvr);
			form_data.append('aku_tottvr', aku_tottvr);
			form_data.append('sel_maxtvr', sel_maxtvr);
			form_data.append('aku_maxtvr', aku_maxtvr);
			form_data.append('sel_mintvr', sel_mintvr);
			form_data.append('aku_mintvr', aku_mintvr);
			form_data.append('sel_avgtvr', sel_avgtvr);
			form_data.append('aku_avgtvr', aku_avgtvr);
			
			form_data.append('sel_apv', sel_apv);
			form_data.append('aku_apv', aku_apv.replace(".", ","));
		
		
			$.ajax({
				url: "<?php echo base_url().'advancemediaplanningureslogp22/print_summary'; ?>", 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(data){
					
					 $("#channel_export").attr("disabled", false);
					
										
				}, error: function(obj, response) {
					console.log('ajax list detail error:' + response);	
				} 
			});	
			
			

			
			
		}
		
			function download_file(fileURL, fileName) { 
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_target';
        var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
        save.download = fileName || filename;
	       if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
				document.location = save.href; 
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

    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}
				function print_cal(){
			
			$('.nav-tabs a[href="#creative"]').tab('show');

var start_date_ads = $('#start_date_ads').val();
			var count_data = parseInt($("#count_data_cal").val());
			var cr_data = $("#data_cal").val();
  
		var form_data = new FormData();  
		form_data.append('start_date',start_date_ads);
		form_data.append('count_data', count_data);
		form_data.append('cr_data', cr_data);
        		
		
		
			$.ajax({
				url: "<?php echo base_url().'advancemediaplanningureslogp22/print_calender'; ?>", 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(data){
					
					 $("#channel_export").attr("disabled", false);
					
										
				}, error: function(obj, response) {
					console.log('ajax list detail error:' + response);	
				} 
			});	
			
			
		}
		
		
		function cal2(){
			
var start_date_ads = $('#start_date_ads').val();
			var count_data = parseInt($("#count_data_cal").val());
			var cr_data = $("#data_cal").val();
  
		var form_data = new FormData();  
		form_data.append('start_date',start_date_ads);
		form_data.append('count_data', count_data);
		form_data.append('cr_data', cr_data);
        		
			

			$.ajax({
      			url : "<?php echo base_url().'advancemediaplanningureslogp22/list_calander2'?>",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post', 
      			success: function(responses) {
					
					response = jQuery.parseJSON(responses); 
					var data_date = [];
					
					var count_data = response.recordsFiltered;
					var r_data = response.data;
					
					for(ii=0;ii < count_data; ii ++){
						
						var rows = {ads_type:r_data[ii][6],tvr:r_data[ii][7],tvs:r_data[ii][8],cprp:r_data[ii][9],cost:r_data[ii][10],title:r_data[ii][2]+' - '+r_data[ii][3], start:r_data[ii][4], end:r_data[ii][5], allDay:false,start_data:r_data[ii][4],end_data:r_data[ii][5],color:'#'+r_data[ii][13],textColor:'#000000',cpv:r_data[ii][11]};

						
						data_date.push(rows);
						
					}

					
					
					
		
			 var date = new Date('2019-09-01'),
            d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear(),
            started,
            categoryClass;

        var calendar = $('#calendar').fullCalendar({
			  header: {
				left: 'prev,next ',
				center: 'title',
				right: ''
			  },
			  selectable: true,
			  selectHelper: true,
			  select: function(start, end, allDay) {
				$('#fc_create').click();

				started = start;
				ended = end;

				$(".antosubmit").on("click", function() {
				  var title = $("#title").val();
				  if (end) {
					ended = end;
				  }

				  categoryClass = $("#event_type").val();

				  if (title) {
					calendar.fullCalendar('renderEvent', {
						title: title,
						start: started,
						end: end,
						allDay: allDay
					  },
					);
				  }

				  $('#title').val('');

				  calendar.fullCalendar('unselect');

				  $('.antoclose').click();

				  return false;
				});
			  },
			  eventClick: function(calEvent, jsEvent, view) {
				$('#fc_edit').click();
				$('#title2').val(calEvent.title);
				$('#ads').val(calEvent.ads_type);
				$('#start').val(calEvent.start_data);
				$('#end').val(calEvent.end_data);
				$('#rate_ads').val(calEvent.cost);
				$('#tvr_ads').val(calEvent.tvr); 
				$('#tvs_ads').val(calEvent.tvs);
				$('#cprp_ads').val(calEvent.cprp);
				$('#cpv_ads').val(calEvent.cpv);

				categoryClass = $("#event_type").val();

				$(".antosubmit2").on("click", function() {
				  calEvent.title = $("#title2").val();

				  calendar.fullCalendar('updateEvent', calEvent);
				  $('.antoclose2').click();
				});

				calendar.fullCalendar('unselect');
			  },
			  editable: false,
			  events: data_date
			});
			
			var parts =start_date_ads.split('/');
			
			var stdate = parts[2]+'-'+parts[1]+'-'+parts[0]; 
			
			
			
				datez = moment(stdate, "YYYY-MM-DD");
				$("#calendar").fullCalendar( 'gotoDate', datez );
					


				



				$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource', data_date);
      			},
      				error: function(obj, response) {
      					console.log('ajax list_project error:' + response);
      			}					
      		});	

			
			
			
					
				
		}
			
		function cal_tab(){
			
			$('#calendar').fullCalendar('render');
			
		}
		
		function cal(){
			
			$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				$('#tab_summ_ads').css('background-color','#F2F2F2');
				$('#tabs_summ_ads').css('background-color','#F2F2F2');
				$('#tab_summ_compare').css('background-color','#F2F2F2');
				$('#tabs_summ_compare').css('background-color','#F2F2F2');
				$('#tab_ads').css('background-color','#fff');
				$('#tabs_ads').css('background-color','#fff');
			
			$('.nav-tabs a[href="#creative"]').tab('show');

			var start_date_ads = $('#start_date_ads').val();
			var count_data = parseInt($("#count_data_cal").val());
			var cr_data = $("#data_cal").val();
  
		var form_data = new FormData();  
		form_data.append('start_date',start_date_ads);
		form_data.append('count_data', count_data);
		form_data.append('cr_data', cr_data);
        		
			

			$.ajax({
      			url : "<?php echo base_url().'advancemediaplanningureslogp22/list_calander2'?>",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
      			success: function(responses) {
					
					response = jQuery.parseJSON(responses); 
					var data_date = [];
					
					var count_data = response.recordsFiltered;
					var r_data = response.data;
					
					for(ii=0;ii < count_data; ii ++){
						
						var rows = {ads_type:r_data[ii][6],tvr:r_data[ii][7],tvs:r_data[ii][8],cprp:r_data[ii][9],cost:r_data[ii][10],title:r_data[ii][2]+' - '+r_data[ii][3], start:r_data[ii][4], end:r_data[ii][5], allDay:false,start_data:r_data[ii][4],end_data:r_data[ii][5],color:'#'+r_data[ii][13],textColor:'#000000',cpv:r_data[ii][11]};

						
						data_date.push(rows);
						
					}

					
					
					
		
			 var date = new Date('2019-09-01'),
            d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear(),
            started,
            categoryClass;

        var calendar = $('#calendar').fullCalendar({
			  header: {
				left: 'prev,next ',
				center: 'title',
				right: ''
			  },
			  selectable: true,
			  selectHelper: true,
			  select: function(start, end, allDay) {
				$('#fc_create').click();

				started = start;
				ended = end;

				$(".antosubmit").on("click", function() {
				  var title = $("#title").val();
				  if (end) {
					ended = end;
				  }

				  categoryClass = $("#event_type").val();

				  if (title) {
					calendar.fullCalendar('renderEvent', {
						title: title,
						start: started,
						end: end,
						allDay: allDay
					  },
					);
				  }

				  $('#title').val('');

				  calendar.fullCalendar('unselect');

				  $('.antoclose').click();

				  return false;
				});
			  },
			  eventClick: function(calEvent, jsEvent, view) {
				$('#fc_edit').click();
				$('#title2').val(calEvent.title);
				$('#ads').val(calEvent.ads_type);
				$('#start').val(calEvent.start_data);
				$('#end').val(calEvent.end_data);
				$('#rate_ads').val(calEvent.cost);
				$('#tvr_ads').val(calEvent.tvr); 
				$('#tvs_ads').val(calEvent.tvs);
				$('#cprp_ads').val(calEvent.cprp);
				$('#cpv_ads').val(calEvent.cpv);

				categoryClass = $("#event_type").val();

				$(".antosubmit2").on("click", function() {
				  calEvent.title = $("#title2").val();

				  calendar.fullCalendar('updateEvent', calEvent);
				  $('.antoclose2').click();
				});

				calendar.fullCalendar('unselect');
			  },
			  editable: false,
			  events: data_date
			});
			
			var parts =start_date_ads.split('/');
			
			var stdate = parts[2]+'-'+parts[1]+'-'+parts[0]; 
			
			
			
				datez = moment(stdate, "YYYY-MM-DD");
				$("#calendar").fullCalendar( 'gotoDate', datez );
					


				



				$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource', data_date);
      			},
      				error: function(obj, response) {
      					console.log('ajax list_project error:' + response);
      			}					
      		});	

			
			
			
		}
	
	function export_mp(){
		
		alert('dfdfed');
		
	}
	
	 function tab_filter(tabs){
	
			if(tabs == 'chart'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#fff');
				$('#tabs_chart').css('background-color','#fff');
				$('#tab_summ_ads').css('background-color','#F2F2F2');
				$('#tabs_summ_ads').css('background-color','#F2F2F2');
				$('#tab_summ_compare').css('background-color','#F2F2F2');
				$('#tabs_summ_compare').css('background-color','#F2F2F2');
				$('#tab_ads').css('background-color','#F2F2F2');
				$('#tabs_ads').css('background-color','#F2F2F2');
			
			}else if(tabs == 'summ_ads'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				$('#tab_summ_ads').css('background-color','#fff');
				$('#tabs_summ_ads').css('background-color','#fff');
				$('#tab_summ_compare').css('background-color','#F2F2F2');
				$('#tabs_summ_compare').css('background-color','#F2F2F2');
				$('#tab_ads').css('background-color','#F2F2F2');
				$('#tabs_ads').css('background-color','#F2F2F2');
			
			}else if(tabs == 'summ_compare'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				$('#tab_summ_ads').css('background-color','#F2F2F2');
				$('#tabs_summ_ads').css('background-color','#F2F2F2');
				$('#tab_summ_compare').css('background-color','#fff');
				$('#tabs_summ_compare').css('background-color','#fff');
				$('#tab_ads').css('background-color','#F2F2F2');
				$('#tabs_ads').css('background-color','#F2F2F2');
			
			}else if(tabs == 'ads'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				$('#tab_summ_ads').css('background-color','#F2F2F2');
				$('#tabs_summ_ads').css('background-color','#F2F2F2');
				$('#tab_summ_compare').css('background-color','#F2F2F2');
				$('#tabs_summ_compare').css('background-color','#F2F2F2');
				$('#tab_ads').css('background-color','#fff');
				$('#tabs_ads').css('background-color','#fff');
				
			}else{
				
				$('#tab_table').css('background-color','#fff');
				$('#tabs_table').css('background-color','#fff');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				$('#tab_summ_ads').css('background-color','#F2F2F2');
				$('#tabs_summ_ads').css('background-color','#F2F2F2');
				$('#tab_summ_compare').css('background-color','#F2F2F2');
				$('#tabs_summ_compare').css('background-color','#F2F2F2');
				$('#tab_ads').css('background-color','#F2F2F2');
				$('#tabs_ads').css('background-color','#F2F2F2');
				
			
			}
			
		 }
	
      function search(){                 

		
		
	  
        $('[data-for="channel"]').parent().parent().removeClass("active");
        $('[data-for="profile"]').parent().parent().removeClass("active");
        $('[data-for="setting"]').parent().parent().removeClass("active");   
        $(".search-channel-con").remove();
          
      	var start_date = $('#start_date').val();
      	var start_date_ads = $('#start_date_ads').val();
      	var end_date_ads = $('#end_date_ads').val();
      	var end_date = $('#end_date').val();
      	var profile = $('#profile').val();
        var setting = $('#setting').val();
      	var cost = $('#cost').unmask();     
        var channel = $('#channel').val();  
        var discount = $('#discount').val();  
		
        
      	var user_id = $.cookie(window.cookie_prefix + "user_id");
      	var token = $.cookie(window.cookie_prefix + "token");
      	var high_tvr = '0';	
      	var maximum_cost = '0';	
      	var minimum_cprp = '0';	
      	var maximum_reach = '0';	
      	var minimum_cpv = '0';	
      	var index = '0';
      	var orderingnya = '0';	
      	var by = '';	
        var ch = [];                            
          
        if(profile === null || profile === ''){ 
      			alert('Please, Select Profile');
      			return false;
      	} 	
      	
      	if(channel === null || channel === ''){ 
      			alert('Please, Select Channel');
      			return false;
      	} 	
      	
      	if(setting === null || setting === ''){ 
      			alert('Please, Select Objective');
      			return false;
      	}
      	
      	if (setting == "high_tvr") {  
      		high_tvr = '1'; 
      		orderingnya = '4';	
      		by = 'DESC';	
      	}
      	
      	if (setting == "maximum_cost") {  
      		maximum_cost = '1'; 
      		orderingnya = '5';	
      		by = 'ASC';	
      	}
      
      	if (setting == "minimum_cprp") {  
      		minimum_cprp = '1';
      		orderingnya = '6';	
      		by = 'ASC';			
      	}      

		if (setting == "minimum_cpv") {  
      		minimum_cprp = '1';
      		orderingnya = '7';	
      		by = 'ASC';			
      	}
      	
      	if (setting == "index") {  
      		index  = '1';
      		orderingnya = '4';	
      		by = 'DESC';			
      	}	
		
		if (setting == "maximum_reach") {  
      		maximum_reach  = '1';
      		orderingnya = '4';	
      		by = 'ASC';			
      	}
      	
      	if(start_date === ''){ 
      		alert('Please, Select Start Date');
      		return false;
      	}	
      	
      	if(end_date === ''){ 
      		alert('Please, Select End Date');
      		return false;
      	}	
      	
      	if(cost === ''){ 
      		alert('Please, Input Cost');
      		return false;
      	}		
        
        /* HANDLE ALL CHANNEL */         
        if(channel == "0"){
            channel = '.IDKU,AFN,ANIMAX,AXN,BEIN SPORT 1,BEIN SPORT 2,BEIN SPORT 3,CARTOON NETWORK,CELESTIAL MOVIES,CHANNEL [V],CNBC,CNN INDONESIA,CNN INTERNATIONAL,DISCOVERY CHANNEL,EGG,FIGHT SPORTS,FOX,FOX ACTION MOVIES,FOX CRIME,FOX FAMILY MOVIES,FOX LIFE,FOX MOVIES PREMIUM,FOX SPORT 1,FOX SPORT 2,FOX SPORT 3,FX,GALAXY TV,GEM,IMC,K-PLUS,KIX,NATIONAL GEOGRAPHIC CHANNEL,NATIONAL GEOGRAPHIC PEOPLE,NATIONAL GEOGRAPHIC WILD,RUANG TRAMPIL,S-ONE,SONY ENTERTAINMENT CHANNEL,STAR CHINESE CHANNEL,THRILL,USEE INFO,USEE PRIME,WAKUWAKU JAPAN'; 
            
            channel = channel.slice(0,-1);
        }
        
        channel=channel.split(",");
        for(var i=0; i < channel.length; i++){
            ch.push("'"+channel[i]+"'");
        }
        
        if (channel.length < 1) { 
            alert('Please, Select Channel');
            return false;	 
        }	
      	                           
								   
        var dtcounter = 0;                                   
		
		var form_data = new FormData();  
		form_data.append('start_date',start_date);
		form_data.append('end_date', end_date);
		form_data.append('start_date_ads', start_date_ads);
		form_data.append('end_date_ads', end_date_ads);
		form_data.append('profile', profile);
		form_data.append('cost', cost);
		form_data.append('high_tvr', high_tvr);
		form_data.append('maximum_cost', maximum_cost);		
		form_data.append('discount', discount);
		form_data.append('minimum_cprp', minimum_cprp);
		form_data.append('minimum_cpv', minimum_cpv);
		form_data.append('maximum_reach', maximum_reach); 
		form_data.append('index', index);
		form_data.append('channel', channel);
		
		 $('.urate-panel-result').show();
					 $('#processButton').hide();
					 $('#loader').show(); 
		
		$.ajax({
			url: "<?php echo base_url().'advancemediaplanningureslogp22/list_planning'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){

				obj = jQuery.parseJSON(data);

				$('#result-table').html("");
				$('#result-table').html('<table id="myTable" class="table table-striped" style = "width : 100%"><thead style="color:red"> <tr><th align="center">Tanggal</th><th align="center">Channel</th> <th align="center">Program</th> <th align="center">Ads Type</th><th align="right">TVR</th><th align="right">Share</th><th align="right">CPRP</th><th align="right">Cost</th> <th align="right">Cost / Audience</th> <th align="right">Index</th> </tr> </thead> </table>');
		
				
		
					$('#myTable').DataTable({
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								   extend: 'collection',
								autoClose: 'true',
								text: ' &nbsp ',
								tag: 'i',
								className: 'fa fa-download',
								  text: ' &nbsp Export',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										var table = $('#myTable').DataTable();
										var info = table.page.info();
										 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ], 
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						
						"searching": false,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj.data,
						columns: [ 
							{ data: 'DATE' },
							{ data: 'CHANNEL' },
							{ data: 'PROGRAM' },
							{ data: 'TYPE' },
							{ data: 'TVR' ,className: "text-right","sClass": "right",render: function ( data, type, row ) {
								return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								}
							},
							{ data: 'TVS' ,className: "text-right","sClass": "right",render: function ( data, type, row ) {
								return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								}
							},
							{ data: 'CPRP',className: "text-right" ,"sClass": "right",render: function ( data, type, row ) {
								return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0));
								}
							},
							{ data: 'RATE_D',className: "text-right","sClass": "right",render: function ( data, type, row ) {
								return new Intl.NumberFormat('id-ID').format(parseFloat(data*1000).toFixed(2));
								}
							},
							{ data: 'REACH' ,className: "text-right","sClass": "right",render: function ( data, type, row ) {
								return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								}
							},
							{ data: 'IDX' ,className: "text-right","sClass": "right",render: function ( data, type, row ) {
								return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								}
							}
						]
					});	
					
					
				$('#summ_prog1').html("");
				$('#summ_prog1').html('<h4><strong>Summary Program</strong></h4> <table id="example1" class="table table-striped "><thead style="color:red"><tr><th>Channel</th> <th>Program</th><th>Ads Type</th> <th>Spot</th><th>Cost/Spot</th><th>GRP</th></tr></thead></table>');
		
				
		
					$('#example1').DataTable({
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								   extend: 'collection',
								autoClose: 'true',
								text: ' &nbsp ',
								tag: 'i',
								className: 'fa fa-download',
								  text: ' &nbsp Export',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										var table = $('#myTable').DataTable();
										var info = table.page.info();
										 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ], 
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						 "scrollX": true,
						"searching": false,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj.data_2,
						columns: [
							{ data: 'CHANNEL' },
							{ data: 'PROGRAM' },
							{ data: 'ADSTYPE' },
							{ data: 'SPOT' },
							{ data: 'COST'},
							{ data: 'TVR'}
						]
					});	
					
					
				$('#summ_prog2').html("");
				$('#summ_prog2').html('<h4><strong>Summary Channel</strong></h4> <table id="example2" class="table table-striped "><thead style="color:red"><tr><th>Channel</th><th>Ads Type</th> <th>Spot</th><th>Cost/Spot</th><th>GRP</th></tr></thead></table>');
		
				
		
					$('#example2').DataTable({
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								   extend: 'collection',
								autoClose: 'true',
								text: ' &nbsp ',
								tag: 'i',
								className: 'fa fa-download',
								  text: ' &nbsp Export',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										var table = $('#myTable').DataTable();
										var info = table.page.info();
										 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ], 
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						 "scrollX": true,
						"searching": false,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj.data_3,
						columns: [
							{ data: 'CHANNEL' },
							{ data: 'ADSTYPE' },
							{ data: 'SPOT' },
							{ data: 'COST'},
							{ data: 'TVR'}
						]
					});	
					
					
				$('#summ_prog1ads').html("");
				$('#summ_prog1ads').html('<h4><strong>Summary Program</strong></h4> <table id="example1_ads" class="table table-striped "><thead style="color:red"><tr><th>Channel</th> <th>Program</th><th>Ads Type</th> <th>Spot</th><th>Cost/Spot</th><th>GRP</th></tr></thead></table>');
		
				
		
					$('#example1_ads').DataTable({
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								   extend: 'collection',
								autoClose: 'true',
								text: ' &nbsp ',
								tag: 'i',
								className: 'fa fa-download',
								  text: ' &nbsp Export',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										var table = $('#myTable').DataTable();
										var info = table.page.info();
										 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ], 
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						 "scrollX": true,
						"searching": false,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj.data_21,
						columns: [
							{ data: 'CHANNEL' },
							{ data: 'PROGRAM' },
							{ data: 'ADSTYPE' },
							{ data: 'SPOT' },
							{ data: 'COST'},
							{ data: 'TVR'}
						]
					});	
					
					
				$('#summ_prog2ads').html("");
				$('#summ_prog2ads').html('<h4><strong>Summary Channel</strong></h4> <table id="example2_ads" class="table table-striped "><thead style="color:red"><tr><th>Channel</th><th>Ads Type</th> <th>Spot</th><th>Cost/Spot</th><th>GRP</th></tr></thead></table>');
		
				
		
					$('#example2_ads').DataTable({
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								   extend: 'collection',
								autoClose: 'true',
								text: ' &nbsp ',
								tag: 'i',
								className: 'fa fa-download',
								  text: ' &nbsp Export',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										var table = $('#myTable').DataTable();
										var info = table.page.info();
										 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ], 
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info" : false,
						 "scrollX": true,
						"searching": false,
						"language": {
							"decimal": ",",
							"thousands": "."
						}, 
						data: obj.data_31,
						columns: [
							{ data: 'CHANNEL' },
							{ data: 'ADSTYPE' },
							{ data: 'SPOT' },
							{ data: 'COST'},
							{ data: 'TVR'}
						]
					});	
				
				
							
      						$("#spoted").html("<div class='grandItemTit'>Total Spot</div><div class='grandItemCon'>" + obj.spot + "</div>");
      						$("#costed").html("<div class='grandItemTit'>Total Cost</div><div class='grandItemCon'>" + obj.cost + "</div>");
      						$("#tvred").html("<div class='grandItemTit'>Total Viewers</div><div class='grandItemCon'>" + obj.tvr + "</div>");
						$("#grpps").html("<div class='grandItemTit'>CPV</div><div class='grandItemCon'>" + obj.cprp1 + "</div>");
							
						$("#maxtvr").html("<div class='grandItemTit'>GRP</div><div class='grandItemCon'>" + obj.grp + "</div>");
      						$("#mintvr").html("<div class='grandItemTit'>CPRP</div><div class='grandItemCon'>" + obj.cprpp + "</div>");
      						$("#avgtvr").html("<div class='grandItemTit'>Reach</div><div class='grandItemCon'>" + obj.reach_r + "</div>");
							
							
      						$("#spoted_ads").html("<div class='grandItemTit'>Total Spot</div><div class='grandItemCon'>" + obj.spot9 + "</div>");
      						$("#costed_ads").html("<div class='grandItemTit'>Total Cost</div><div class='grandItemCon'>" + obj.cost9 + "</div>");
      						$("#tvred_ads").html("<div class='grandItemTit'>Total Viewers</div><div class='grandItemCon'>" + obj.tvr9 + "</div>");
							
							$("#maxtvr_ads").html("<div class='grandItemTit'>GRP</div><div class='grandItemCon'>" + obj.maxtvr9 + "</div>");
      						$("#mintvr_ads").html("<div class='grandItemTit'>CPRP</div><div class='grandItemCon'>" + obj.mintvr9 + "</div>");
      						$("#avgtvr_ads").html("<div class='grandItemTit'>Reach</div><div class='grandItemCon'>" + obj.avgtvr9 + "</div>");
      						$("#cprp1_ads").html("<div class='grandItemTit'>CPV</div><div class='grandItemCon'>" + obj.cprp19 + "</div>");
							
							$("#spot_com").val(obj.spot);
      						$("#cost_com").val(obj.cost);
      						$("#tvred_com").val(obj.tvr);
							$("#maxtvr_com").val(obj.maxtvr);
      						$("#mintvr_com").val(obj.mintvr);
      						$("#avgtvr_com").val(obj.avgtvr);
      						$("#cprp1_com").val(obj.cprp1);
      						$("#cpv_com").val(obj.cpv1);
							
							$("#spot_com2").val(obj.spot9);
      						$("#cost_com2").val(obj.cost9);
      						$("#tvred_com2").val(obj.tvr9);
							$("#maxtvr_com2").val(obj.maxtvr9);
      						$("#mintvr_com2").val(obj.mintvr9);
      						$("#avgtvr_com2").val(obj.avgtvr9);
      						$("#cprp1_com2").val(obj.cprp19);
      						$("#cpv_com2").val(obj.cpv19);
					  
					  var spot_com = $('#spot_com').val();
			var spot_com2 = $('#spot_com2').val();
			var cost_com = $('#cost_com').val();
			var cost_com2 = $('#cost_com2').val();
			var tvred_com = $('#tvred_com').val();
			var tvred_com2 = $('#tvred_com2').val();
			var maxtvr_com = $('#maxtvr_com').val();     
			var maxtvr_com2 = $('#maxtvr_com2').val();  
			var mintvr_com = $('#mintvr_com').val(); 
			var mintvr_com2 = $('#mintvr_com2').val(); 
			var avgtvr_com = $('#avgtvr_com').val(); 
			var avgtvr_com2 = $('#avgtvr_com2').val(); 
			var cprp1_com = $('#cprp1_com').val(); 
			var cprp1_com2 = $('#cprp1_com2').val(); 
			var cpv_com = $('#cpv_com').val(); 
			var cpv_com2 = $('#cpv_com2').val(); 

			var sel_spot = spot_com2-spot_com;
			var aku_spot = (spot_com2/spot_com)*100;
			var aku_spot = aku_spot.toFixed(2);
			
			tvred_com = tvred_com.replace(".", "");
			tvred_com = tvred_com.replace(".", "");
			tvred_com = tvred_com.replace(".", "");
			
			tvred_com2 = tvred_com2.replace(".", "");
			tvred_com2 = tvred_com2.replace(".", "");
			tvred_com2 = tvred_com2.replace(".", "");
			
				
			maxtvr_com = maxtvr_com.replace(".", "");
			maxtvr_com = maxtvr_com.replace(".", "");
			maxtvr_com = maxtvr_com.replace(".", "");
			
			maxtvr_com2 = maxtvr_com2.replace(".", "");
			maxtvr_com2 = maxtvr_com2.replace(".", "");
			maxtvr_com2 = maxtvr_com2.replace(".", "");
			
			mintvr_com = mintvr_com.replace(".", "");
			mintvr_com = mintvr_com.replace(".", "");
			mintvr_com = mintvr_com.replace(".", "");
			
			mintvr_com2 = mintvr_com2.replace(".", "");
			mintvr_com2 = mintvr_com2.replace(".", "");
			mintvr_com2 = mintvr_com2.replace(".", "");
			
			
			avgtvr_com = avgtvr_com.replace(".", "");
			avgtvr_com = avgtvr_com.replace(".", "");
			avgtvr_com = avgtvr_com.replace(".", "");
			
			avgtvr_com2 = avgtvr_com2.replace(".", "");
			avgtvr_com2 = avgtvr_com2.replace(".", "");
			avgtvr_com2 = avgtvr_com2.replace(".", "");
			
			
			var costa1 = cost_com2.replace(".", "");
			var costa2 = costa1.replace(".", "");
			var costa3 = costa2.replace(".", "");
			
			var costb1 = cost_com.replace(".", "");
			var costb2 = costb1.replace(".", "");
			var costb3 = costb2.replace(".", "");
			
			var cprpa1 = cprp1_com2.replace(".", "");
			var cprpa2 = cprpa1.replace(".", "");
			var cprpa3 = cprpa2.replace(".", "");
			
			var cprpb1 = cprp1_com.replace(".", "");
			var cprpb2 = cprpb1.replace(".", "");
			var cprpb3 = cprpb2.replace(".", "");
			
			var apva1 = cpv_com.replace(".", "");
			var apva2 = apva1.replace(".", "");
			var apva3 = apva2.replace(".", "");
			
			var apvb1 = cpv_com2.replace(".", "");
			var apvb2 = apvb1.replace(".", "");
			var apvb3 = apvb2.replace(".", "");
			

			
			var sel_cost = formatNumber(parseInt(costb3)-parseInt(costa3));
			var aku_cost = (parseInt(costb3)/parseInt(costa3))*100;
			var aku_cost = aku_cost.toFixed(2);

			var sel_cprp = formatNumber(parseInt(cprpb3)-parseInt(cprpa3));
			var aku_cprp = (parseInt(cprpb3)/parseInt(cprpa3))*100;
			var aku_cprp = aku_cprp.toFixed(2);
			
			var sel_tottvr = parseFloat(tvred_com2.replace(",", "."))-parseFloat(tvred_com.replace(",", "."));
			var sel_tottvr = formatNumber(sel_tottvr);
			var aku_tottvr = (parseFloat(tvred_com2.replace(",", "."))/parseFloat(tvred_com.replace(",", ".")))*100;
			var aku_tottvr = aku_tottvr.toFixed(2);
			
			
			var sel_apv = formatNumber(parseFloat(apva3)-parseFloat(apvb3));
			var aku_apv = (parseFloat(apva3)/parseFloat(apvb3))*100;
			var aku_apv = aku_apv.toFixed(2);
			
			var sel_maxtvr = parseFloat(maxtvr_com2.replace(",", "."))-parseFloat(maxtvr_com.replace(",", "."));
			var sel_maxtvr = formatNumber(sel_maxtvr);
			var aku_maxtvr = (parseFloat(maxtvr_com2.replace(",", "."))/parseFloat(maxtvr_com.replace(",", ".")))*100;
			var aku_maxtvr = aku_maxtvr.toFixed(2);
			
			var sel_mintvr = parseFloat(mintvr_com2.replace(",", "."))-parseFloat(mintvr_com.replace(",", "."));
			var sel_mintvr = formatNumber(sel_mintvr);
			
			
			if(mintvr_com == '0,00'){
					var aku_mintvr = 0;
				var aku_mintvr = formatNumber(aku_mintvr);
			}else{
				var aku_mintvr = (parseFloat(mintvr_com2.replace(",", "."))/parseFloat(mintvr_com.replace(",", ".")))*100;	
				var aku_mintvr = aku_mintvr.toFixed(2);
			}
			
			
			var sel_avgtvr = parseFloat(avgtvr_com2.replace(",", "."))-parseFloat(avgtvr_com.replace(",", "."));
			var sel_avgtvr = formatNumber(sel_avgtvr);
			
			if(mintvr_com == '0,00'){
				var aku_avgtvr = 0;
				var aku_avgtvr = aku_avgtvr.toFixed(2);
			}else{
				var aku_avgtvr = (parseFloat(avgtvr_com2.replace(",", "."))/parseFloat(avgtvr_com.replace(",", ".")))*100;
				var aku_avgtvr = aku_avgtvr.toFixed(2);
			}
			
					  
			$('#spoted_summ').html('<td align="center">Total Spot</td><td align="right">'+obj.spot+'</td><td align="right">'+obj.spot9+'</td><td align="right">'+sel_spot+'</td><td align="right">'+aku_spot.replace(".", ",")+'</td>'); 
			
			$('#costed_summ').html('<td align="center">Total Cost</td><td align="right">'+obj.cost+'</td><td align="right">'+obj.cost9+'</td><td align="right">'+sel_cost+'</td><td align="right">'+aku_cost.replace(".", ",")+'</td>'); 
			
			$('#totvr_summ').html('<td align="center">Total Views</td><td align="right">'+obj.tvr+'</td><td align="right">'+obj.tvr9+'</td><td align="right">'+sel_tottvr+'</td><td align="right">'+aku_tottvr.replace(".", ",")+'</td>'); 
			
			$('#maxtvr_summ').html('<td align="center">Maximum Viewers</td><td align="right">'+obj.maxtvr+'</td><td align="right">'+obj.maxtvr9+'</td><td align="right">'+sel_maxtvr+'</td><td align="right">'+aku_maxtvr.replace(".", ",")+'</td>'); 
			
			$('#mintvr_summ').html('<td align="center">Minimum Viewers</td><td align="right">'+obj.mintvr+'</td><td align="right">'+obj.mintvr9+'</td><td align="right">'+sel_mintvr+'</td><td align="right">'+aku_mintvr.replace(".", ",")+'</td>'); 
			
			$('#avgtvr_summ').html('<td align="center">Average Viewers</td><td align="right">'+obj.avgtvr+'</td><td align="right">'+obj.avgtvr9+'</td><td align="right">'+sel_avgtvr+'</td><td align="right">'+aku_avgtvr.replace(".", ",")+'</td>'); 
			
			$('#cprp_summ').html('<td align="center">Cost per Views</td><td align="right">'+obj.cprp1+'</td><td align="right">'+obj.cprp19+'</td><td align="right">'+sel_cprp+'</td><td align="right">'+aku_cprp.replace(".", ",")+'</td>'); 
			
			$('#cpv_summ').html('<td align="center">Cost per Audience</td><td align="right">'+obj.cpv1+'</td><td align="right">'+obj.cpv19+'</td><td align="right">'+sel_apv+'</td><td align="right">'+aku_apv.replace(".", ",")+'</td>'); 
			
					  
					  	$("#count_data_cal").val(obj.recordsFiltered);
						
						
						 var sss = JSON.stringify(obj.data_4); 
					  	$("#data_cal").val(sss); 
					  
					  
					  cal2();
					
					
						

						
						

					
					
					
		













			
			
			
			
			
					


				



					  
					  
					 $('.urate-panel-results').show();
			$('#panel-blank').hide();
					   $("#loader").hide();
					  $('.loader').css('display','none');
					  $('#processButton').show();

			}
		});	
      	
      	
	
		
      	var x = document.getElementsByClassName("buttons-excel");
        
        if (x.length > 0)
        {
            x = x[0];
        }
        
      	var excelButton = $(".buttons-excel").detach();
        $(".buttonExcel").show();
      	$(".buttonExcel").append( excelButton );   
        
										
										 

								 
                  
          	
		
										
										 

								 
                  
          	
		
										 

								 
                        
                            
                                
				  
                  
          	
                  
										 

								 
                        
                            
                                
                  
          	
        
      						
			
      						
          
							
      						
			
						
						
      						


			
      }
      
      function refreshtable1(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         var table1 = $("#example1").DataTable({   
			 dom: 'Bfrtip',
						  'buttons': [
							  {
								 extend: 'collection',
								autoClose: 'true',
								text: ' &nbsp ',
								tag: 'i',
								className: 'fa fa-download',
								  text: ' &nbsp Export',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										 

									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable1();
									}).draw();
								  },
                  title: 'UNICS - Media Planning Summary Channel',
                  filename: 'UNICS - Media Planning Summary Channel'
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
          		"ordering": false,		
          		"processing": true,
          		"serverSide": true,
          		destroy: true,
          		"ajax": "<?php echo base_url().'advancemediaplanningureslogp22/list_planning_sub'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost+ "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&minimum_cpv=" + minimum_cpv+"&maximum_reach=" + maximum_reach+"&index=" + index+"&channel=" + channel,
          		"searchDelay": 700,
          		"bFilter" : false,
          		"bInfo" : false,
          		"bLengthChange": false,  
              "fnPreDrawCallback":function(){
                  $('#processButton').hide();
                  $('#loader').show();
              },
              "fnDrawCallback":function(){
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
              },
              "fnInitComplete":function(){
                  /*
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
                  */
                  
              },         
          	});
          	
          	table1.ajax.reload();    
	  }
      function refreshtable2(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         	var table2 = $("#example2").DataTable({
				 dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  title: 'Media Planning - Summary Channel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										 

									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable2();
									}).draw();
								  }
                  
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
          		"ordering": false,
          		"processing": true,
          		"serverSide": true,
          		destroy: true,
          		"ajax": "<?php echo base_url().'advancemediaplanningureslogp22/list_planning_total'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost+ "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&minimum_cpv=" + minimum_cpv+"&maximum_reach=" + maximum_reach+"&index=" + index+"&channel=" + channel,
          		"searchDelay": 700,
          		"bFilter" : false,
          		"bInfo" : false,
          		"iDisplayLength": 100,
          		"bLengthChange": false,  
              "fnPreDrawCallback":function(){
                  $('#processButton').hide();
                  $('#loader').show();
              },
              "fnDrawCallback":function(){
                        
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
                            
              },
              "fnInitComplete":function(){
                                
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
                  
              },         
          	});
          	
          	table2.ajax.reload();	
	  }
      function refreshtable(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var table = $("#myTable").DataTable({ 
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									 var table = $('#myTable').DataTable();
										var info = table.page.info();
										 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable();
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ],
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
        	});
        
	  }
	  
	  function refreshtablefilter(start_date,end_date,profile,cost,high_tvr,maximum_cost,minimum_cprp,minimum_cpv,maximum_reach,index,ch,orderingnya,by){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
        
      	var table = $("#myTable").DataTable({ 
			  dom: 'Bfrtip',
			  'buttons': [
				  {
					  text: 'Export Excel',
					  action: function (e, dt, button, config)
					  {
						dt.one('preXhr', function (e, s, data)
						{
						 var table = $('#myTable').DataTable();
							var info = table.page.info();
							 

						  data.length = info.recordsDisplay ;
						}).one('draw', function (e, settings, json, xhr)
						{
						  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
						  var addOptions = { exportOptions: { 'columns': ':visible'} };
					 
						  $.extend(true, excelButtonConfig, addOptions);
						  excelButtonConfig.action(e, dt, button, excelButtonConfig);
						   refreshtablefilter(start_date,end_date,profile,cost,high_tvr,maximum_cost,minimum_cprp,minimum_cpv,index,ch);
						}).draw();
					  },
            title: 'UNICS - Media Planning',
            filename: 'UNICS - Media Planning'
					}
			  ],
      		"processing": true,
      		"serverSide": true,
      		destroy: true,			
      		"ajax": "<?php echo base_url().'advancemediaplanningureslogp22/list_planning'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost+ "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&minimum_cpv=" + minimum_cpv+"&maximum_reach=" + maximum_reach+"&index=" + index+"&channel=" + ch,
      		"searchDelay": 700,
      		"bFilter" : false,		
      		 "order": [[ orderingnya, by]],
      		"orderable": true,
      		"bInfo" : false,
      		"bLengthChange": false
      	});
	  }
      
      function search_channel(){
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "<li data-for='channel'><a href='#' data-real='0' class='urate-select-form-two' data-for='channel'>All Channel</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'advancemediaplanningureslogp22/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
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
                    
                    strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel' data-id='channel'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#channel").next().next().next().append(strVar);   
                
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
                });
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }                     
    
    function search_profile(){
        var query = $('#search_profile').val(); 
        var period = $('#start_date').val();
        
        $('#profile').empty('');
        
        var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'advancemediaplanningureslogp22/profilesearch/'; ?>"+"?q="+query+"&f="+period,
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                $("#profile").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0];            
                        strText = response[0];
                    } else {
                        strResult = response[i].ID;
                        strText = response[i].NAME;
                    }
                    
                    strVar += "<li data-for='profile'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='profile'>"+strText+"</a></li>";                          
                } 
                                      
                $("#profile").next().next().next().append(strVar);   
                                
                $('[data-for = "profile"]').click(function() { 
                    $('#profile').next().text($(this).text());
                    $('#profile').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active');
                    
                    $(".search-profile-con").remove();                       
                });                                 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
    
  </script>
  <script language="javascript">
      $(document).ready(function(){
          $('#cost').keyup(function(){
              $(this).val(function(index, value) {
                 return value
                 .replace(/\D/g, "")
                 .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                 ;
               });
          });
      });
  </script>
  
  <!-- UNTUK FUNGSI SORT -->
  <script>
  function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc"; 
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      switching = false;
      rows = table.getElementsByTagName("TR");
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch= true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount ++;       
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }
  </script>