 
  <style>
      i.material-icons.search {
  			margin-top: 40px;
  			margin-right: 29px;
  		}
  
  		.card .header {
  			margin-left: -30px;
  			margin-right: -30px;
  			padding-top: 15px;
  			padding-bottom: 3px;			
  		}
  
  		#line-chart{
  			min-height: 250px;
  		}	
  		
  		text.highcharts-credits{
  			display:none;
  		}	
  		
  		.pointer{
  			cursor : pointer;
  			color:blue;
  		}
      
  		.selected {
  			color: white;
  			 background-color: red !important;
  		}
  		
  		.unselected {
  			color: white;
  			 background-color: #1f91f3 !important;
  		}
  		
  		.test_btn {
  			 color: white;
  			 background-color: #1f91f3 !important;
  		}
  		
  		video::-webkit-media-controls {
  		  display:none !important;
  			top: 0px;
  			left: 0px; /* fixed to left. Replace it by right if you want.*/
  			min-width: 100%;
  			min-height: 100%;
  			width: auto;
  			height: auto;
  		}
  		
  		.tp-video-play-button {display: none !important}
      
      .urate-wrapper{
          width: 100%;
          padding: 5px 30px;
          height: 44px;
          border: 1px solid #9b9b9b;
          box-shadow: 0 0 3px #ccc;
          border-radius: 18px;
          background: #fff;
          background-repeat: no-repeat;
          overflow: hidden;
          text-align: left;
          text-overflow: ellipsis;
          white-space: nowrap;
      
      }
      .urate-control {
          width: 100%;
          padding-right: 60px;
          height: 34px;
          border: none;
          background: #fff;
          color: #aaa;
      }
      
      table.dataTable thead .sorting:after,
      table.dataTable thead .sorting_asc:after,
      table.dataTable thead .sorting_desc:after,
      table.dataTable thead .sorting_asc_disabled:after,
      table.dataTable thead .sorting_desc_disabled:after {
          position: absolute;
          bottom: 8px;
          right: 8px;
          display: block;
          font-family: 'Glyphicons Halflings';
          opacity: 0.5;
          color: red;
      }               
      
      table.dataTable th {
          min-width: 130px;
      }
      
      .loaders {
          border: 16px solid #f3f3f3; /* Light grey */
          border-top: 16px solid #3498db; /* Blue */
          border-radius: 50%;
          width: 60px;
          height: 60px;
          animation: spin 2s linear infinite;
      }
      
      @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
      }
      
      .modals {
          display:    none;
          position:   fixed;
          z-index:    1000;
          top:        0;
          left:       0;
          height:     100%;
          width:      100%;
      }
      
      .infront{
          z-index: 99 !important;
      }    
      
      .dt-buttons{
          height: 30px;
      }

       div.dt-buttons{
		position:relative;
		float:right;
		background-color:#000;
		border-radius:5px;
		padding: 3px 15px 3px 15px; 
		color:#fff;
		margin-bottom:30px;
		margin-left:10px;
		font-family: 'Lato', sans-serif; 
	}
	
	div.dt-buttons a{
		
		color:#fff;
	}
	
	div.dt-button{
		
		font-family: 'Lato', sans-serif; 
		
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
  </style>  
  
  <div class="content-wrapper">
      <div class="container-fluid">
      <!-- Content -->
      <!-- Data Set -->
          <div class="row">
              <div class="col-md-5">
                  <ol class="breadcrumb">
                      <!--<li class="breadcrumb-item"></li>-->
                      <li class="breadcrumb-item active">Post Buy Analytics</li>
                  </ol>
                  <h3 class="page-title-inner"><strong>Post Buy Analytics</strong></h3>
              </div>  
<div class="col-md-7 text-right">
					<button id="button_filters" onClick="filter_adspeformance()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
				</div>				  
          </div>
          <div class="panel urate-panels">
              <div class="panel-body" style="height: 180px;">
                  <div class="row">
                      
					  <div class="col-lg-12">	
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
								<div class="form-group">
									<label>Profile</label>
									  <select class='urate-select' name="profile" id="profile" title='Please Choose Profile ...'>
										  <option value="0" >All People</option>
										  <?php foreach($profile as $key) { ?>
										  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
										  <?php } ?>
									  </select>
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Category</label>
									<div class="select-wrapper">
									   <select class="urate-select hidden-element-for-dropdown" name="kategori_by" id="kategori_by" title="Please Choose Category" required >
										   <option value="" selected disabled >-- Category ---</option>
										  <option value="product" >Product</option>
										  <option value="advertiser" >Advertiser</option>
										  <option value="sector" >Sector</option>
									  </select> 
									</div> 
								</div>
							</div>
							
						</div>
					
						<div class="col-lg-12" style="top: 200px;position: absolute;">	
							
							<div class="col-lg-3" style="padding-right:20px;">	
								<div class="form-group">
									<label>Sub Category</label>
									<div class="select-wrapper">
									  <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader2" style="display: none;margin: auto;width: 24px;">
									  <select class="urate-select hidden-element-for-dropdown" name="get_kategori" id="get_kategori" title="Please Choose Subcategory" required >
										  <option value="" selected disabled >-- Subcategori ---</option>
									  </select> 
									</div>
								</div>
							</div>
							
							<div class="col-lg-3" style="margin-left:-10px;padding-right:20px">	
								<div class="form-group">
									<label>Channel</label>
									<div class="select-wrapper">
									  <select class="urate-select grid-menu" name="get_chnl" id="get_chnl" title="Please choose a Channel..." required>
										<option value="0" >All Channel</option>
										<?php $i = 0; foreach($channel as $key) { ?>
										<option value="<?php echo $key['channel']; ?>" ><?php echo $key['channel']; ?></option>
										<?php } ?>
									  </select>
								  </div>
								</div>
							</div>
					</div>
					  
                      <!-- END PROCESS BUTTON -->
                  </div>
              </div>
          </div>
		  
		  		  <div class="panel2" id="panel-blank" >
		
			<img alt="img" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
		  
		  </div>
		   <div class="loader" style="display:none">
                 <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
            </div>
          <!-- /Data Set -->
          <!-- Result 1 -->
         <div class="panel urate-panel urate-panel-results" style="display:none">
              <div class="panel-headings">
                   <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
					
				</div>
              </div>
              <div class="panel-body">
			  
				  <div class="col-md-2">
                                  <div class="row" style="background-color:#F2F2F2;padding:5px;color:#000;border: none;border-radius:5px">
									 <div class="col-md-6" id="tabs_table" style="border: none;background-color:#fff;border-radius:5px;">
										<button id="tab_table" style="border: none;background-color:#fff;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('table')" href="#table" aria-controls="table" role="tab" data-toggle="tab"><strong>Table</strong></button>
									</div>
									<div class="col-md-6" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px;background-color:#F2F2F2" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Summary</strong></button>
									</div>
								</div>
                              </div>
							  
                  <!-- Tab panes -->
                  <div class="tab-content" style="margin-top:60px">
                      <!-- Tab Table -->
                      <div role="tabpanel" class="tab-pane active" id="table">
                          <div class="result-table">
                              <table aria-describedby="mydesc"  id="example" class="table table-striped">
                                  <thead style="color:red">
                                      <tr>
                                          <th align="center" scope="row"></th>
                                          <th style="" scope="row">Date </th>
                                          <th style="" scope="row">Channel </th>
                                          <th width="" style="" scope="row">Program </th>
                                          <th style="" scope="row">Product </th>
                                          <th style="" scope="row">Advertiser </th>
                                          <th style="" scope="row">Sector </th>
                                          <th style="" scope="row">StartTime </th>
                                          <th style="" scope="row">Duration </th>
                                          <th style="" scope="row">Type </th>
                                          <th style="" scope="row">TVR </th>
                                          <th style="" scope="row">Viewers </th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
					  
					  <div role="tabpanel" class="tab-pane" id="chart">  
					  
							    <div class="summary-table">
                                    <div class="row">
                                        <div class="col-md-6">
											<div class="row" style="padding:5px;margin-left:-5px !important">
												<div class="col-lg-12 urate-panel">
													<h4><strong>Summary Program</strong></h4>
													<table aria-describedby="mydesc"  id="example1summ" class="table table-striped">
														<thead style="color:red">
															  <tr>
																  <th scope="row">Channel</th>
																  <th scope="row">Program</th>
																  <th scope="row">Spot</th>
																  <th scope="row">Cost</th>
																  <th scope="row">TVR</th>
															  </tr>
														</thead>
													</table>
												</div>
											</div>
                                        </div>
                                        <div class="col-md-6 " >
											<div class="row" style="padding:5px;margin-left:-5px !important">
												<div class="col-lg-12 urate-panel">
												<h4><strong>Summary Channel</strong></h4>
												<table aria-describedby="mydesc"  id="example2summ" class="table table-striped">
													<thead style="color:red">
														<tr>
															<th scope="row">Channel</th>
															<th scope="row">Spot</th>
															<th scope="row">Cost</th>
															<th scope="row">TVR</th>
														</tr>
													</thead>
												</table>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
								
								<div class="summary-table2 urate-panel" style="padding:5px;margin-top:20px">
								  <!-- Tab panes -->
								  <h4><strong>Grand Total</strong></h4>
								  
								  <div class="row">
								   <div class="col-md-6 " >
									<h4><strong>Summary</strong></h4>
									<table aria-describedby="mydesc"  class="table table-striped">
										<thead>
											<th scope="row">Total Spot</th>
											<th scope="row"></th>
										</thead>
										<tr>
											<td scope="row" id="r0t">Total Spot</td>
											<td scope="row" id="spot" align="right"></td>
										</tr>
										<tr>										
											<td id="r2t">Total Cost</td>
											<td id="sumcost" align="right"></td>
										</tr>
										<tr>	
											<td id="r3t">GRP</td>
											<td id="sumtvr" align="right"></td>
										</tr>
										<tr>	
											<td id="r7t">CPRP</td>
											<td id="cprp" align="right"></td>
										</tr>
										<tr>	
											<td id="r13t">Max TVR</td>
											<td id="maxtvr" align="right"></td>
										</tr>
										<tr>	
											<td id="r21t">Min TVR</td>
											<td id="mintvr" align="right"></td>
										</tr>
										<tr>	
											<td id="avgfreqt">AVG TVR</td> 
											<td id="avgtvr" align="right"></td> 
										</tr>
										</table>
								   
								   </div>
								   
								    <div class="col-md-6 " >
										<h4><strong>Reach & Frequency</strong></h4>
										<table aria-describedby="mydesc"  class="table table-striped">
										<th scope="col">1</th>
										<th scope="col">2</th>
										<tr>
											<td id="r0t">Reach 1+</td>
											<td id="r0" align="right"></td>
										</tr>
										<tr>										
											<td id="r2t">Reach 2+</td>
											<td id="r2" align="right"></td>
										</tr>
										<tr>	
											<td id="r3t">Reach 3+</td>
											<td id="r3" align="right"></td>
										</tr>
										<tr>	
											<td id="r7t">Reach 7+</td>
											<td id="r7" align="right"></td>
										</tr>
										<tr>	
											<td id="r13t">Reach 13+</td>
											<td id="r13" align="right"></td>
										</tr>
										<tr>	
											<td id="r21t">Reach 21+</td>
											<td id="r21" align="right"></td>
										</tr>
										<tr>	
											<td id="avgfreqt">Avg Freq</td> 
											<td id="avgfreq" align="right"></td> 
										</tr>
										</table>
									
								   </div>
								  </div>
							  </div>
					  
					  </div>
                      <!-- / Tab Table -->
                  </div>
                  <!-- / Tab panes -->
              </div>
          </div>
      <!-- / Result 1 -->
	  
      <!-- Result 2 -->
      
      <!-- / Result 2 -->
      <!-- / Content -->
      </div>
  </div>
  
  <!-- Modal Play Video -->
	<div class="modal fade" id="modal_video_program1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h4 class="modal-title" id="my_program1"></h4>
      				</div>
      				<div class="modal-body">
        					<div id="video_url" style="object:fit: fill;" ></div>
      				</div>
      				<div class="modal-footer">
                  <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader3" style="display: none;margin: auto;width: 36px;float:left;">
                  <a class="btn urate-download-btn urate-outline-btn" style="width: 150px; float: left;">&nbsp;&nbsp;&nbsp;Download Video</a>
                  <button type="button" class="btn urate-outline-btn urate-close-modal" data-dismiss="modal">Close</button>
      				</div>
    			</div>
  		</div>
	</div>
	<!-- / Modal -->

  <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms_sig.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path;?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  
  <script language="javascript">
      $(document).ready(function(){
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
           
          
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                //  startDate: '-1y',
                  endDate: '0d',
                  defaultDate: new Date()
              });               
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY')); //"<?php echo $currdate[0]['CURRDATE']; ?>"
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
          
          $('#custom_get_chnl').click(function() {   
              $(".search-channel-con").remove();                
              
              var currChecked = $("#get_chnl").val();
              
              if(currChecked != ""){
                  $("[data-real='"+currChecked+"']").parent().addClass('checked');
              }
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_get_chnl").after(searchElement);       
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          });           
          
          $(".urate-close-modal").click(function() {
              $("#vload0")[0].pause();                 
              $("#vload1")[0].pause();                 
              $("#vload2")[0].pause();                 
              $("#vload3")[0].pause();                 
              $("#vload4")[0].pause();                 
              $("#vload5")[0].pause();                 
              $("#vload6")[0].pause();                 
              $("#vload7")[0].pause();                 
              $("#vload8")[0].pause();                 
              $("#vload9")[0].pause();                 
              $("#vload10")[0].pause();                 
              $("#vload11")[0].pause();                 
              $("#vload12")[0].pause();                 
              $("#vload13")[0].pause();                 
              $("#vload14")[0].pause();                 
              $("#vload15")[0].pause();                 
              $("#vload16")[0].pause();                 
              $("#vload17")[0].pause();                 
              $("#vload18")[0].pause();                 
              $("#vload19")[0].pause();                 
          });
                    
          $('[data-id="kategori_by"]').click(function() {
              $('.urate-select-dropdown').each(function(){
                  $(this).removeClass('active');
                  $(".search-channel-con").remove();        
              });
          });  
          
          $('[data-for="get_kategori"]').click(function() {
              $('.urate-select-dropdown').each(function(){
                  $(this).removeClass('active');
                  $(".search-channel-con").remove();
                                                        
                  if($(this).closest('.urate-select-dropdown').hasClass('active')){
                      $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                  } else {
                      $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                  }        
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
               var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'postbuyadspeformanceftares/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                   dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
                       $("#profile").next().next().next().empty('');   
                      
                      for(i=0; i < response.length; i++){                       
                          if(response[0] == "Value not found!"){
                              strResult = response[0]; 
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
                  url		: "<?php echo base_url().'postbuyadspeformanceftares/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
  </script>
  
  <script language="javascript">
      $(document).ready(function(){
          $("#checkall").click(function () {
              $('input:checkbox').not(this).prop('checked', this.checked);
          });
      });
  </script>
  
  <script language="javascript">
       
  </script>
	
  <script>
      /* get datatable first */
      $(document).ready(function() {	
          $(".close").click(function() {
              $("#vload0")[0].pause();                 
              $("#vload1")[0].pause();                 
              $("#vload2")[0].pause();                 
              $("#vload3")[0].pause();                 
              $("#vload4")[0].pause();                 
              $("#vload5")[0].pause();                 
              $("#vload6")[0].pause();                 
              $("#vload7")[0].pause();                 
              $("#vload8")[0].pause();                 
              $("#vload9")[0].pause();                 
              $("#vload10")[0].pause();                 
              $("#vload11")[0].pause();                 
              $("#vload12")[0].pause();                 
              $("#vload13")[0].pause();                 
              $("#vload14")[0].pause();                 
              $("#vload15")[0].pause();                 
              $("#vload16")[0].pause();                 
              $("#vload17")[0].pause();                 
              $("#vload18")[0].pause();                 
              $("#vload19")[0].pause();                 
          });
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          
         
          $('button.showHideColumn').on( 'click', function (e) {
              e.preventDefault();
               var tableColumn = table.column( $(this).attr('data-columnindex') );
              console.log(tableColumn);
              tableColumn.visible( ! tableColumn.visible() );
          });
          
          /* show hide use checkbox */
          $('#showHideColumn').on( 'click', function (e) {
              e.preventDefault();
              $(this).is(":checked");
               var tableColumn = table.column( $(this).attr('data-columnindex') );
              console.log(tableColumn);
              tableColumn.visible( ! tableColumn.visible() );
          });
          
       
      });
  
      // get_kategori	
      $( document ).ready(function() {   
          $('#processButton').on('click', function() { 
              filter_adspeformance();  
          });
          
          $("#custom_get_kategori").on("click",function(){
              $('#custom_kategori_by').parent().removeClass('active');
          });             
          
          function generate_category (cat) 
          {
              var user_id = $.cookie(window.cookie_prefix + "user_id");
              var token = $.cookie(window.cookie_prefix + "token");    
              
              $('#get_kategori').empty('');
              
              var form_data = {			
                  valselect : cat,       
                  start_date : $('#start_date').val(),
                  end_date : $('#end_date').val()
              };
              
              var profile = $('#profile').val();
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'postbuyadspeformanceftares/list_subkategori/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
                  data	: JSON.stringify(form_data),			
                  dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {              
                      $('#custom_get_kategori').hide();
                      $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                      $('#custom_get_kategori').delay(3000).fadeIn(500);
                                          
                      var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-con'><input type='text' name='search_subcat' id='search_subcat' class='form-control urate-form-input' value='' onkeypress='search_subcat()' paceholder='Search Sub Category'></div>";
                      
                      $("#custom_get_kategori").on("click",function(){
                          $('#custom_kategori_by').parent().removeClass('active');
                          
                          if($(this).parent().hasClass('active')){
                              $(".search-con").remove();
                              $("#custom_get_kategori").after(searchElement);
                              $("#search_subcat").focus();
                          } else {
                              $(".search-con").remove();
                          }
                      });
                                            
                      $.each(response.data, function (index, value) {
                          if (value.PRODUCT){                          
                              var strVar="";
                              strVar += "<li><a href='javascript:void(0)' data-real='"+value.PRODUCT+"' class='urate-select-form-two' data-for='get_kategori'>"+value.PRODUCT+"</a></li>";
                              $("#get_kategori").next().next().append(strVar); 
                              
                              $('[data-real = "'+value.PRODUCT+'"]').click(function() { 
                                  $('#get_kategori').next().html(value.PRODUCT);
                                  $('#get_kategori').attr('value',value.PRODUCT);
                                  
                                  $(this).closest('.default').removeClass('active');
                                  $(".search-con").remove(); 
                                  
                                  $('.urate-select-dropdown').each(function(){
                                      $(this).removeClass('active');
                                      $(".search-channel-con").remove();
                                      
                                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                                      } else {
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                                      }    
                                  });                                                                    
                              });
                          } else if (value.SECTOR){  
                              var strVar="";
                              strVar += "<li><a href='javascript:void(0)' data-real='"+value.SECTOR+"' class='urate-select-form-two' data-for='get_kategori'>"+value.SECTOR+"</a></li>";
                              $("#get_kategori").next().next().append(strVar); 
                              
                              $('[data-real = "'+value.SECTOR+'"]').click(function() { 
                                  $('#get_kategori').next().html(value.SECTOR);
                                  $('#get_kategori').attr('value',value.SECTOR);
                                  
                                  $(this).closest('.default').removeClass('active');
                                  $(".search-con").remove();   
                                  
                                  $('.urate-select-dropdown').each(function(){
                                      $(this).removeClass('active');
                                      $(".search-channel-con").remove();
                                      
                                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                                      } else {
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                                      }        
                                  });                                                                                                      
                              });
                          } else {                  
                              var strVar="";
                              strVar += "<li><a href='javascript:void(0)' data-real='"+value.ADVERTISER+"' class='urate-select-form-two' data-for='get_kategori'>"+value.ADVERTISER+"</a></li>";
                              $("#get_kategori").next().next().append(strVar); 
                              
                              $('[data-real = "'+value.ADVERTISER+'"]').click(function() { 
                                  $('#get_kategori').next().html(value.ADVERTISER);
                                  $('#get_kategori').attr('value',value.ADVERTISER);
                                  
                                  $(this).closest('.default').removeClass('active');
                                  $(".search-con").remove();    
                                  
                                  $('.urate-select-dropdown').each(function(){
                                      $(this).removeClass('active');
                                      $(".search-channel-con").remove();
                                      
                                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                                      } else {
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                                      }        
                                  });                                                                                                      
                              });
                          }     
                      });
                  }, error: function(obj, response) {
                      console.log('ajax list detail error:' + response);	
                  } 
              });
          }
          
          $('#custom_kategori_by').click(function() {
              $("#custom_get_kategori").parent().removeClass('active');
              $(".search-con").remove();                        
                  	    
              $("[data-real='product'").click(function(){       
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                      
                  $('#get_kategori').next().text('Please Choose Product ...');
                  $('#get_kategori').next().next().html(' '); 
                  generate_category('product');
              });
              
              $("[data-real='advertiser'").click(function(){        
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                  
                  $('#get_kategori').next().text('Please Choose Advertiser ...');
                  $('#get_kategori').next().next().html(' '); 
                  generate_category('advertiser');
              });
              
              $("[data-real='sector'").click(function(){
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                                    
                  $('#get_kategori').next().text('Please Choose Sector ...');
                  $('#get_kategori').next().next().html(' '); 
                  generate_category('sector');
              });
          });
      });
      
       $( document ).ready(function() {
          $('.urate-download-btn').on('click', function(){
              
              $(this).hide();
              $('#loader3').fadeIn(500).delay(500).fadeOut(500);
              $(this).delay(3000).fadeIn(500);
          });
      }); 	     

	 function tab_filter(tabs){
	
			if(tabs == 'chart'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#fff');
				$('#tabs_chart').css('background-color','#fff');
			
			}else{
				
				$('#tab_table').css('background-color','#fff');
				$('#tabs_table').css('background-color','#fff');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				
			
			}
			
		 }	  
  	
       function filter_adspeformance(){    
          $('[data-for="get_chnl"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $('[data-for="kategori_by"]').parent().parent().removeClass("active");
          $('[data-for="get_kategori"]').parent().parent().removeClass("active");
        
          $("#loader_summary").css("display","block");
          $(".urate-panel-title").html("Grand Total");  
          $("#textket").html("<h3>Summary</h3>");
          $("#spot").html("");
          $("#sumcost").html("");
          $("#sumviewers").html("");
          $("#sumtvr").html("");
          $("#cprp").html("");
          $("#maxtvr").html("");
          $("#mintvr").html("");
          $("#avgtvr").html("");
          $("#costpview").html("");
          
          $("#loader_reach").css("display","block");
          $("#textketr").html("<h3>Reach & Frequency</h3>");
          $("#r0").html("");
          $("#r2").html("");
          $("#r3").html("");
          $("#r7").html("");
          $("#r13").html("");
          $("#r21").html(""); 
          $("#avgfreq").html("");
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var profile = $('#profile').val();
          if(profile === ''){			
              alert('Please, Select Profile');
              return false;
          }
          
          var start_date = $('#start_date').val();
          if(start_date === ''){			
              alert('Please, Select Start Date');
              return false;
          }
          
          var end_date = $('#end_date').val();
          if(end_date === ''){			
              alert('Please, Select End Date');
              return false;
          }
          
          var kategori_by = $('#kategori_by').val();
          var get_kategori = $('#get_kategori').val();    
          var get_chnl = $('#get_chnl').val(); 
          
          if(kategori_by === ''){			
              alert('Please, Select Category');
              return false;
          }
          
          if(get_kategori === ''){			
              alert('Please, Select Sub Category');
              return false;
          }
          
          if(get_chnl === ''){			
              alert('Please, Select Channel');
              return false;
          }
          
          var table = $("#example").DataTable({
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
						   refreshtablefilter(start_date, end_date, profile, get_kategori, kategori_by, get_chnl);
						}).draw();
					  }
					}
              ],
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformanceftares/get_filter_adspeformance'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
			  "searching": true,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "bInfo" : false,
              "orderable": true,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-results').show();
				$('#panel-blank').hide();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
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
		  
		  
		     var table = $("#example1summ").DataTable({
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
						   refreshtablefilter1summ(start_date, end_date, profile, get_kategori, kategori_by, get_chnl);
						}).draw();
					  }
					}
              ],
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformanceftares/get_filter_summ1'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
			  "searching": true,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "desc"]],
              "bInfo" : false,
              "orderable": false,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-result').show();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
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
		  
		    var table = $("#example2summ").DataTable({
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
						   refreshtablefilter2summ(start_date, end_date, profile, get_kategori, kategori_by, get_chnl);
						}).draw();
					  }
					}
              ],
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformanceftares/get_filter_summ2'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
			  "searching": true,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "desc"]],
              "bInfo" : false,
              "orderable": false,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-result').show();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
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
                    
           var x = document.getElementsByClassName("buttons-excel");
          
          if (x.length > 0){
              x = x[0];
          }
          
          var excelButton = $(".buttons-excel").detach();
          
          $(".buttonExcel").append( excelButton );
          $(".buttonExcel").show();
          
          $('button.showHideColumn').on( 'click', function (e) {
              e.preventDefault();
              var tableColumn = table.column( $(this).attr('data-columnindex') );
              console.log(tableColumn);
              tableColumn.visible( ! tableColumn.visible() );
          });
          
           $('#showHideColumn').on( 'click', function (e) {
              e.preventDefault();
              $(this).is(":checked");
              var tableColumn = table.column( $(this).attr('data-columnindex') );
              console.log(tableColumn);
              tableColumn.visible( ! tableColumn.visible() );
          });
          
          table.ajax.reload();
          
           $.ajax({
              url : "<?php echo base_url().'postbuyadspeformanceftares/get_filter_grandtotal_adspeformance_summ'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              success: function(response) {
                  $("#loader_summary").css("display","none");
                  $("#textket").html("<h3>Summary</h3>");
                  $("#spot").html(response.data.spot);
                  $("#sumcost").html(response.data.sumcost);
                   $("#sumtvr").html(response.data.sumtvr);
                  $("#cprp").html(response.data.cprp);
                  $("#maxtvr").html(response.data.maxtvr);
                  $("#mintvr").html(response.data.mintvr);
                  $("#avgtvr").html(response.data.avgtvr);
 				  
				  $("#loader_summary").css("display","none");
                   $("#spotn").html(response.data2.spot);
                  $("#sumcostn").html(response.data2.sumcost);
                   $("#sumtvrn").html(response.data2.sumtvr);
                  $("#cprpn").html(response.data2.cprp);
                  $("#maxtvrn").html(response.data2.maxtvr);
                  $("#mintvrn").html(response.data2.mintvr);
                  $("#avgtvrn").html(response.data2.avgtvr);
				  
                  var val_costpview = response.data.costpview;
                  
                  if(response.data.spot == 0){
                      $("#textketr").html("<h3>Reach & Frequency</h3>");
                      $("#r0").html("0" ); 
                      $("#r2").html("0");
                      $("#r3").html("0");
                      $("#r7").html("0");
                      $("#r13").html("0" );
                      $("#r21").html("0" );
                      $("#avgfreq").html("0");
                      $("#loader_reach").css("display","none");
					  
					  $("#r0n").html("0" ); 
                      $("#r2n").html("0");
                      $("#r3n").html("0");
                      $("#r7n").html("0");
                      $("#r13n").html("0" );
                      $("#r21n").html("0" );
                      $("#avgfreqn").html("0");
					  
                  } else {  
                      $.ajax({
                      url : "<?php echo base_url().'postbuyadspeformanceftares/get_filter_grandtotal_adspeformance'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
                      success: function(response) {
                          $("#loader_reach").css("display","none");
                          $("#textketr").html("<h3>Reach & Frequency</h3>");
                          $("#r0").html(response.data.r0); 
                          $("#r2").html(response.data.r2);
                          $("#r3").html(response.data.r3);
                          $("#r7").html(response.data.r7);
                          $("#r13").html(response.data.r13);
                          $("#r21").html(response.data.r21);
                          $("#avgfreq").html(response.data.fr);
						  
						  
						  $("#r0n").html(response.data2.r0); 
                          $("#r2n").html(response.data2.r2);
                          $("#r3n").html(response.data2.r3);
                          $("#r7n").html(response.data2.r7);
                          $("#r13n").html(response.data2.r13);
                          $("#r21n").html(response.data2.r21);
                           },
                          error: function(obj, response) {
                              console.log('ajax list_project error:' + response);
                          }					
                      });	
                  }
              },
              error: function(obj, response) {
              console.log('ajax list_project error:' + response);
              }					
          });
      }
  	
      /* destroy all datatable */
      function destroy_databale(){
          $( "#example" ).empty();
          $( "#example_paginate").empty();
          $( ".dataTables_paginate paging_simple_numbers").empty();
          $( "#textket" ).empty();
          $( "#sumcost" ).empty();
          $( "#sumviewers" ).empty();
          $( "#sumtvr" ).empty();
      }
      
      function vid_program(video, title, filename, stvid, duration){
          $.ajax({
              url:filename,
              type:'HEAD',
              error: function()
              {
                  $("#video_url").html('<img alt="img" src="img/novid.png" style="display:block; margin-left:auto; margin-right:auto; padding-top:30px;"><p style="text-align:center; font-size:24px; padding-left:100px; padding-right:100px; padding-top:30px; padding-bottom:30px;">Ooppss! Video is unavailable</p>');
                  $(".urate-download-btn").hide();
              },
              success: function()
              {
                  $("#video_url").html('<video autoplay  id= "vload0" width="100%" height="240" controls preload="none" data-flname="'+filename+'" data-stvid="'+stvid+'" data-duration="'+duration+'"><source src="'+video+'"> type="video/mp4">Your browser does not support the video tag.</video>');
                  $(".urate-download-btn").show();
              }
          });
      
          $("#modal_video_program1").modal();
          $("#my_program1").html( title );
          $(".urate-download-btn").attr('href','<?php echo site_url("postbuyadspeformanceftares/download_video/?f='+filename+'&s='+stvid+'&d='+duration+'") ?>');
          
          var vids = $("video"); 
          $.each(vids, function(){
              this.controls = false; 
          }); 
      }
  
      function vid_iklan(id){
          switch (id) {
              case 0:
                  $("#modal_video_iklan1").modal();
                  break;
              case 1:
                  $("#modal_video_iklan2").modal();
                  break;
              case 2:
                  $("#modal_video_iklan3").modal();
                  break;
              case 3:
                  $("#modal_video_iklan4").modal();
                  break;
              case 4:
                  $("#modal_video_iklan5").modal();
                  break;
              case 5:
                  $("#modal_video_iklan6").modal();
                  break;
              case 6:
                  $("#modal_video_iklan7").modal();
                  break;
              case 7:
                  $("#modal_video_iklan8").modal();
                  break;
              case 8:
                  $("#modal_video_iklan9").modal();
                  break;
              case 9:
                  $("#modal_video_iklan10").modal();
                  break;
          }
      }
  
       $(document).on("click", ".get_video", function () {
          var myBookId = $(this).data('id');
          $("#my_program1").html( myBookId );
      });
      
       $(document).on("click", ".get_video_iklan", function () {
          var myBookId = $(this).data('id');
          $("#my_program1").html( myBookId );
      });
  
       $(document).ready(function(){
          $('.test_btn').click(function(){
              if(!$(this).hasClass('selected')){
                  $(this).addClass('selected');
                  $(this).removeClass('test_btn');
              } else if(!$(this).hasClass('test_btn')) {
                  $(this).addClass('test_btn');
                  $(this).removeClass('selected');
              }
          });
      }); 
      
      function search_subcat(){
           var cat = $('#kategori_by').val();
          var query = $('#search_subcat').val();
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#get_kategori').empty('');
          
          var strVar = "";
          var strResult = "";
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'postbuyadspeformanceftares/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&c=" + cat + "&sd=" + start_date + "&ed=" + end_date,
               dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                   $("#get_kategori").next().next().next().empty('');
                  
                  for(i=0; i < response.length; i++){     
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
                          strResult = response[i].SEARH_RESULT;
                      }
                      
                      strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='get_kategori'>"+strResult+"</a></li>";                          
                  } 
                                        
                  $("#get_kategori").next().next().next().append(strVar);   
                                    
                  $('[data-for = "get_kategori"]').click(function() {
                       $('#get_kategori').next().text($(this).data("real"));
                      $('#get_kategori').attr('value',$(this).data("real"));
                      
                      $(this).closest('.default').removeClass('active');  
                      
                      $(".search-con").remove();                        
                  });                                         
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          }); 
      }
	  
	  
	  
	  
	  
	  function refreshtable(){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var table = $("#example").DataTable({
              dom: 'Bfrtip',
              'buttons': [
                  {
					  text: 'Export Excel',
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
						   refreshtable();
						}).draw();
					  }
					}
              ],	  
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformance2/get_list_adspeformance'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
              "searchDelay": 700,
              "responsive": true,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "orderable": true,
              "bFilter" : false,
              "bInfo" : false,
              "bLengthChange": false
          });
	  }
	  
	   function refreshtablefilter1summ(start_date, end_date, profile, get_kategori, kategori_by, get_chnl){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          
          var table = $("#example1summ").DataTable({
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
						   refreshtablefilter1summ(start_date, end_date, profile, get_kategori, kategori_by, get_chnl);
						}).draw();
					  }
					}
              ],
             "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformanceftares/get_filter_summ1'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
			  "searching": true,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "desc"]],
              "bInfo" : false,
              "orderable": false,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-result').show();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
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
                    
	  }
	  
	  
	    function refreshtablefilter2summ(start_date, end_date, profile, get_kategori, kategori_by, get_chnl){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          
          var table = $("#example2summ").DataTable({
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
						   refreshtablefilter2summ(start_date, end_date, profile, get_kategori, kategori_by, get_chnl);
						}).draw();
					  }
					}
              ],
             "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformanceftares/get_filter_summ2'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
			  "searching": true,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "desc"]],
              "bInfo" : false,
              "orderable": false,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-result').show();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
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
                    
	  }
	  
	  
	  function refreshtablefilter(start_date, end_date, profile, get_kategori, kategori_by, get_chnl){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          
          var table = $("#example").DataTable({
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
						   refreshtablefilter(start_date, end_date, profile, get_kategori, kategori_by, get_chnl);
						}).draw();
					  }
					}
              ],
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformanceftares/get_filter_adspeformance'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
			   "searching": true,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "bInfo" : false,
              "orderable": true,
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
                    
	  }                   
    
    function search_channel(){
         var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'postbuyadspeformanceftares/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#get_chnl").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].CHANNEL;
                    }
                    
                     strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#get_chnl").next().next().next().append(strVar);   
                
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
            url		: "<?php echo base_url().'postbuyadspeformanceftares/profilesearch/'; ?>"+"?q="+query+"&f="+period,
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