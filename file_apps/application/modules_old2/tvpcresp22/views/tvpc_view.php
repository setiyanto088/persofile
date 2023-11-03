 
	<!-- Multiple Select -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.min.css">       
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css">  
  <!-- Timepicker -->
	<link rel="stylesheet" href="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.css">
	
	<style>
		.fstElement { font-size: 9px; }
		.fstToggleBtn { min-width: 13em; }
		
		.submitBtn { display: none; }

		.fstMultipleMode { display: block; }
		.fstMultipleMode .fstControls { width: 100%; }
		.fstResults {max-height: 220px;}
    
    i.material-icons.search {
			margin-top: 40px; 
			margin-right: 29px;
		}

		#line-chart{
			min-height: 250px;
		}	
		
		text.highcharts-credits{
			display:none;
		}
    
    #myChart{
      padding-top: 30px;
    }
    
    .loader{
      display: block;
      text-align: center;
      padding-top: 10px;
      font-size: 16px;
      font-weight: bold;
    }
    
	
       div.dt-buttons{
		position:relative;
		float:right;
		background-color:#000;
		border-radius:5px;
		padding:6px 18px 6px 18px; 
		color:#fff;
		margin-left:5px;
		margin-bottom:30px;
		font-family: 'Lato', sans-serif; 
	}
	
	div.dt-buttons a{
		
		color:#fff;
	}
	
	div.dt-button{
		
		font-family: 'Lato', sans-serif; 
		
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
                       <li class="breadcrumb-item">View Behaviour</li>
                      <li class="breadcrumb-item active">Program Comparison</li>
                  </ol>
                  <h3 class="page-title-inners"><strong>Program Comparison</strong></h3>
              </div>   
 <div class="col-md-7 text-right">
				<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
			</div>				  
          </div>
          <div class="panel urate-panel">
              <div class="panel-body" style="height: 180px;">
                  <div class="row">
                      <!-- PERIODE FIELD -->
					  
                      <div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Period</label>
									<input type="text"  class="form-control" name="start_date" id="start_date" placeholder="From ..." style="text-align:left" value="">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>End Date Period</label>
									<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." style="text-align:left" value="">
								</div>
							</div>
							
							<div class="col-lg-3" style="z-index: 1000;">
							  <div class="dataset-title">
								<div class="col-md-6" style="margin-left:-10px">
									<label>Day Part</label> 
								</div>
								<div class="col-md-6 text-right" style="margin-right:10px">
								  <a href="#" data-toggle="modal" data-target="#modalNewTime" id="dptriger" style="color:red"><span class="ion-plus"></span> New</a>
								</div>
							  </div>
							  <div class="select-wrapper">
								  <select class='form-control urate-select ' name="daypart" id="daypart" title='Please Choose Time Schedule ...'>
									  <option value="alltime" >All Days</option>
									 <?php foreach($daypart as $key) { ?>
									  <option value="<?php echo $key['DPART']; ?>" ><?php echo $key['DPART']; ?></option>
									  <?php } ?>
								  </select>
							  </div>
						    </div> 
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Profile</label>
									<div class="select-wrapper">
									  <select class="urate-select" name="profile" id="profile" title="Please Choose Profile" required >
										  <option value=0 >All People 2021</option>
										  <option value=1 >All People 2022</option>
										  <?php foreach($profile as $key) { ?>
										  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
										  <?php } ?>
									  </select>  
									</div>
								</div>
							</div>
							
					 </div>
					
						<div class="col-lg-12" style="top: 200px;position: absolute;">	
							
							<div class="col-lg-3" style="padding-right:20px;">	
								<div class="form-group">
									<label>Genre</label>
									   <select class="urate-select" name="genre" id="genre" title="Please Choose Genre" required >
										  <option value="0" >All Genre</option>
										  <?php foreach($genre as $key) { ?>
										  <option value="<?php echo str_replace("&","AND",$key['GENRE']); ?>" ><?php echo $key['GENRE']; ?></option>
										  <?php } ?>
									  </select>  
								</div>
							</div>
							
							<div class="col-lg-3" style="margin-left:-10px;padding-right:20px">	
								<div class="form-group">
									<label>TV Channel</label>
									<div class="select-wrapper">
									  <select class="urate-select grid-menu" name="channel" id="channel" title="Please Choose a Channel ..." required>
										  <option value="0" >All Channel</option>
										  <?php foreach($channel as $key) { ?>
										  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
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
		
			<img alt="image" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
		  
		</div>
		<div class="loader" style="display:none">
            <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
        </div>
          <!-- /Data Set -->
          <!-- Result -->
          <div class="panel urate-panel urate-panel-results" style="display:none">
               <div class="panel-headings">
                   <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
				 
				</div>
              </div>
              <div class="panel-body" style="margin-top:10px">
                  <!-- Nav tabs -->
                   <div class="col-md-2">
                                  <div class="row" style="background-color:#F2F2F2;padding:5px;color:#000;border: none;border-radius:5px">
									 <div class="col-md-6" id="tabs_table" style="border: none;background-color:#fff;border-radius:5px;">
										<button id="tab_table" style="border: none;background-color:#fff;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('table')" href="#table" aria-controls="table" role="tab" data-toggle="tab"><strong>Table</strong></button>
									</div>
									<div class="col-md-6" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px;background-color:#F2F2F2" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Chart</strong></button>
									</div>
								</div>
                              </div>
                  <!-- / Nav tabs -->
                  <!-- Tab panes -->
                  <div class="tab-content" >
                      <!-- Tab Table -->
                      <div role="tabpanel" class="tab-pane active" id="table">
                          <div class="row result-action">
                          
                              <div class="col-md-6 text-right">
                                  &nbsp;
                              </div>
                          </div>
                          <div class="result-table">
                              <div class="loader" style="display:none">
                                  <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
                              </div>
							  <br/>
                              <table aria-describedby="table" id="myTable" class="table table-striped">
                                  <thead>
                                  <tr style="color:red">
                                   
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Rank</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Date</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Program</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Channel</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Genre</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Begin Time</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">End Time</th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">TVS <img alt="image" src="<?php echo $path; ?>assets/images/icon_arrowdown.png" alt="arrow"></th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">TVR <img alt="image" src="<?php echo $path; ?>assets/images/icon_arrowdown.png" alt="arrow"></th>
                                      <th style="color: red; border-bottom: 1px solid black;" scope="row">Viewer <img alt="image" src="<?php echo $path; ?>assets/images/icon_arrowdown.png" alt="arrow"></th>
                                  </tr>
                                  </thead>
                              
                              </table>   
                          </div>
                      </div>
                      <!-- / Tab Table -->
                      <!-- Tab Chart -->
                      <div role="tabpanel" class="tab-pane" id="chart">  
                          <div class="result-control" style="margin-top:60px">
                              <div id="viswitch">
                        					<label class="result-control-radio" for="tvs">
                                      <input name="setting" id="tvs" class="toggle-vis" data-column="tvs" checked="" type="radio">
                                      <span class="label-text"> TVS </span>
                        					</label>
                                  <label class="result-control-radio" for="tvr">
                                      <input name="setting" id="tvr" class="toggle-vis" data-column="tvr" checked="" type="radio">
                                      <span class="label-text"> TVR </span>
                        					</label>
                                  <label class="result-control-radio" for="viewers">
                                      <input name="setting" id="viewers" class="toggle-vis" data-column="viewers" checked="" type="radio">
                                      <span class="label-text"> Viewers </span>
                                  </label>
                      				</div>
                          </div>
                          <div class="result-chart">
                              <p id="dtmsg" style="text-align: center;font-size: 24px;display:none;">No data available<p>
                              <div class="result-chart-graph">
                                  <canvas id="myChart" width="900px" height="400px"></canvas>
                                  
                              </div>
							  <div style="text-align: center;"><span id="legend"></span></div>
                          </div>
                      </div> 
                      <!-- / Tab Chart -->
                  </div>
                  <!-- / Tab panes -->
              </div>
          </div>
          <!-- / Result -->
          <!-- / Content -->
      </div>
  </div>                   
  
  <!-- Modal New Time -->
	<div class="modal fade modalDaypart" id="modalNewTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titles" id="myModalLabel"><strong>Create Day Part</strong></h4>
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
          <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em>&nbsp Cancel</button>
					<button type="button" class="button_black" onClick="create_daypart()"><em class="fa fa-check"></em>&nbsp Create</button>
				</div>
			</div>
		</div>
	</div>
  
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
	<!-- cookie -->


  <script language="javascript">
      $(document).ready(function(){           
          $("#dptriger").on('click',function(){
              $('#loaderdp').hide();
              $(".modal .modal-footer button").show();
          });
          
          $('input.toggle-vis').attr('disabled','disabled');
          
          $('.timepicker').bootstrapMaterialDatePicker({
              date: false,
              format: 'HH:mm:00'
          });
          
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                   endDate: '0d',
                  defaultDate: new Date() 
              });
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY'));  
          });
          
          $("#checkall").click(function () {
              $('input:checkbox').not(this).prop('checked', this.checked);
          });   
          
          $('#custom_genre').click(function() {   
              $(".search-genre-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-genre-con'><input type='text' name='search_genre' id='search_genre' class='form-control urate-form-input' value='' onkeypress='search_genre()' paceholder='Search Genre'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-genre-con").remove();
                  $("#custom_genre").after(searchElement);  
                  $("#search_genre").focus();
              } else {
                  $(".search-genre-con").remove();
              }
          });            
          
          $('[data-for = "genre"]').click(function() {
               $('#genre').next().text($(this).data("real"));
              $('#genre').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
              $(".search-genre-con").remove();
              
              search_channel();     
              
               $('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_channel').html("Please Choose a Channel ...");                   
          });                    
          
          $('.result-control-radio').click(function(){
              $('.result-control .urate-radio').removeClass('active');
               
              $('.urate-table-head').text($(this).attr('for').toUpperCase());
          });
          
          $('input.toggle-vis').on( 'click', function (e) {
              $('input.toggle-vis').attr('disabled','disabled');
              
              var start_date = $('#start_date').val();
              	
          		if(start_date === ''){			
          			alert('Please, Select Date');
          			return false;
          		}
                
            	var end_date = $('#end_date').val();
            	var profile = $('#profile').val();
            	var channel = $('#channel').val().replace('&',' AND ');
              var start_time = '';
            	var end_time = '';     
              var daypart =  $('#daypart').val();
              var user_id = $.cookie(window.cookie_prefix + "user_id");
      	      var token = $.cookie(window.cookie_prefix + "token");
              var colgroup = $(this).attr('data-column');
              var ch = [];  
              var arrDaypart1 = [];
              var arrDaypart2 = [];
              var listDaypart = [];
              
              /* HANDLE ALL CHANNEL */
              var channel_header = "";                                                                    
              if(channel == "0"){
                  /* READ CHANNEL FROM AFTER CHOOSE GENRE */
                  $('#custom_channel').next().children().each(function(){
                      if($(this).children().html() != "All Channel"){
                          channel_header += $(this).children().html()+",";
                      }
                  })
                  
                  channel_header = channel_header.slice(0,-1);
              } else {
                  channel_header = channel;
              }  

            	channel_header = channel_header.split(",");
              for(var i=0; i < channel_header.length; i++){
                  ch.push("'"+channel_header[i].replace('&',' AND ')+"'");
              }
              
              if (channel.length < 1) {
                  alert('Please, Select Channel');
                  return false;	 
              }	
             
              
              if(daypart === ''){  
            		alert('Please, Daypart');
            		return false;
            	}                   
          
              /* HANDLING DAYPART EITHER SINGLE OR MULTIPLE BY SPLITING IT BY "," (FOR MULTIPLE) AND/OR BY "-" (FOR SINGLE) */
              listDaypart = daypart.split(",");
              if(listDaypart.length > 1){
                  arrDaypart1 = listDaypart[0].split("-");
                  start_time = arrDaypart1[0];
                  
                  arrDaypart2 = listDaypart[listDaypart.length - 1].split("-");
                  end_time = arrDaypart2[1]; 
              } else {
                  arrDaypart1 = listDaypart[0].split("-");
                  start_time = arrDaypart1[0];
                  end_time = arrDaypart1[1];
                  
                  arrDaypart2 = [];
              }
              /* END - HANDLING DAYPART EITHER SINGLE OR MULTIPLE BY SPLITING IT BY "," (FOR MULTIPLE) AND/OR BY "-" (FOR SINGLE) */
              
              $.ajax({
            		url : "<?php echo base_url().'tvpcresp22/listchart_tvpc/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup,
            		success: function(response) {
              			 
                    create_chart(response.data,colgroup);
             		},
            		error: function(obj, response) {
                    console.log('ajax list_project error:' + response);
            		}
            			
            	});
          });                                        
          
          $('#custom_channel').click(function() {   
              $(".search-channel-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);  
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
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
                  
                  $.ajax({
                      type	: "POST",
                      url		: "<?php echo base_url().'tvcc/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
                       dataType: 'json',
                      contentType: 'application/json; charset=utf-8',
                      success	: function(response) {
                          if(response['data'].hasil == "1"){
                              $(".dayPartMsg").html("Day part is already exist, choose another Day part.");
                              $(".daypart_create").attr("disabled","disabled");
                          } else {                  
                              if($('#to').val() <= $('#from').val()){ 
                                  $(".dayPartMsg").html("The end time must be greater than the start time!");
                                  $(".daypart_create").attr("disabled","disabled");
                              } else {
                                  $(".dayPartMsg").html("");
                                  $(".daypart_create").removeAttr("disabled");
                              } 
                          }                                                      
                      }, error: function(obj, response) {
                          console.log('ajax list detail error:' + response);	
                      } 
                  }); 
              }
          });    
		  
		  $('#to').timepicker({
              timeFormat: 'HH:mm',
              interval: 30,
              minTime: '00:29',
              maxTime: '23:59',
               startTime: '00:29',
              dynamic: false,
              dropdown: true,
              scrollbar: true,
              zindex: 9999  
              
              ,change: function(time){
                  if($('#from').val() == ""){
                      $('#from').val("00:00");
                  }
                  
                  $.ajax({
                      type	: "POST",
                      url		: "<?php echo base_url().'tvcc/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
                       dataType: 'json',
                      contentType: 'application/json; charset=utf-8',
                      success	: function(response) {
                          if(response['data'].hasil == "1"){
                              $(".dayPartMsg").html("Day part is already exist, choose another Day part.");
                              $(".daypart_create").attr("disabled","disabled");
                          } else {                  
                              if($('#to').val() <= $('#from').val()){ 
                                  $(".dayPartMsg").html("The end time must be greater than the start time!");
                                  $(".daypart_create").attr("disabled","disabled");
                              } else {
                                  $(".dayPartMsg").html("");
                                  $(".daypart_create").removeAttr("disabled");
                              } 
                          }                                                      
                      }, error: function(obj, response) {
                          console.log('ajax list detail error:' + response);	
                      } 
                  }); 
              }
          });   
          
           $("#start_date").on("change",function(){
              $('#profile').empty('');
               var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People 2021</a></li><li data-for='profile'><a href='#' data-real='1' class='urate-select-form-two' data-for='profile'>All People 2022</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'tvpcresp22/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                  url		: "<?php echo base_url().'tvpcresp22/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                     
          $(".table th").on("click",function(){                    
              if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
                  $(this).children().css("transform","rotate(180deg)");
              } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
                  $(this).children().css("transform","rotate(0deg)");
              }
          });
      });
  
       $('.multipleSelect').fastselect();
      
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
		 
      // proses
      function search(group=""){
          $('[data-for="genre"]').parent().parent().removeClass("active");                                                              
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active"); 
          $(".search-channel-con").remove();
     
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
          
          var profile = $('#profile').val();
          var genre = $('#genre').val();          
          var channel = $('#channel').val().replace('&',' AND ');
          var start_time = '';
          var end_time = '';             
          var daypart =  $('#daypart').val();         
          var arrDaypart1 = [];
          var arrDaypart2 = [];
          var listDaypart = [];
          
          if(profile === null || profile === ''){  
        			alert('Please, Select Profile');
        			return false;
        	} 	     
          
          if(genre === null || genre === ''){  
        			alert('Please, Select Genre');
        			return false;
        	}                     
        	
        	if(channel === null || channel === ''){  
        			alert('Please, Select Channel');
        			return false;
        	}                           
              
          if(daypart === ''){ 
        		alert('Please, Daypart');
        		return false;
        	}     
          
          /* HANDLING DAYPART EITHER SINGLE OR MULTIPLE BY SPLITING IT BY "," (FOR MULTIPLE) AND/OR BY "-" (FOR SINGLE) */
          listDaypart = daypart.split(",");
          if(listDaypart.length > 1){
              arrDaypart1 = listDaypart[0].split("-");
              start_time = arrDaypart1[0];
              
              arrDaypart2 = listDaypart[listDaypart.length - 1].split("-");
              end_time = arrDaypart2[1]; 
          } else {
			  
			  if(daypart == 'alltime'){
 				start_time = '00:00:00';
				end_time = '23:59:59';
              
              arrDaypart2 = [];
			  }else{
				  arrDaypart1 = listDaypart[0].split("-");
				  start_time = arrDaypart1[0];
				  end_time = arrDaypart1[1];
				  
				  arrDaypart2 = [];
				  
			  }
              
          }
          /* END - HANDLING DAYPART EITHER SINGLE OR MULTIPLE BY SPLITING IT BY "," (FOR MULTIPLE) AND/OR BY "-" (FOR SINGLE) */                            
          
          var colgroup;
          
          $('input.toggle-vis').attr('disabled','disabled');
          
          if(group==""){
              colgroup = $('input.toggle-vis').attr('data-column');
          } else {
              colgroup = group;
          }
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var test = [];
          var test1 = [];
          var test2 = [];
          var bb = [];
          var datagrid = [];
          var ch = [];
          
          /* HANDLE ALL CHANNEL */
          var channel_header = "";                                                                    
          if(channel == "0"){
              /* READ CHANNEL FROM AFTER CHOOSE GENRE */
              $('#custom_channel').next().children().each(function(){
                  if($(this).children().html() != "All Channel"){
                      channel_header += $(this).children().html()+",";
                  }
              })
              
              channel_header = channel_header.slice(0,-1);
          } else {
              channel_header = channel;
          }  
          
          channel_header = channel_header.split(",");
          for(var i=0; i < channel_header.length; i++){
              ch.push("'"+channel_header[i].replace('&',' AND ')+"'");
          }
          
          if (channel.length < 1) {
              alert('Please, Select Channel');
              return false;	 
          }	
           
          var table = $("#myTable").DataTable({
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
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.toString().replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter(start_date,end_date,profile,ch,start_time,end_time);
									}).draw();
								  },
                  title: 'UNICS - Program Comparison',
                  filename: 'UNICS - Program Comparison'
								}
						  ],
              "serverSide": true,
              "processing": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'tvpcresp22/list_tvpc'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&genre=" + genre,
              "searchDelay": 700,
              "bFilter" : false,
              "aaSorting": [],
              "bInfo" : false,
              "iDisplayLength": 10,
              "order": [[ 8, "desc" ]],
              columnDefs: [{
                  render: function ( data, type, row, meta ) {								 
                       return data;
                  },
                  targets: 0
              },
              {
                  orderable: false,
                  targets: [0,1,2,3,4,5,6]
              }],		
              
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');   
                  $('.loader').css('display','none');   
                  if(colgroup == 'tvs'){
                      $('#tvs').prop('checked',true);
                      $('#tvr').prop('checked',false);
                      $('#viewers').prop('checked',false);
                  }     
              },
              
              "fnPreDrawCallback":function(){  
                  $('.urate-panel-results').show();
				  $('#panel-blank').hide();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
              },
              "fnDrawCallback":function(){
                  $("#loader").hide();
                  $('#processButton').show();
                  $('.loader').css('display','none');
              },
              "fnInitComplete":function(){
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('#processButton').show();
                  $('.loader').css('display','none');
              },
             
			   "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			  
				<?php foreach($channel as $channelas) { ?>
						if ( aData[3] == "<?php echo $channelas['channel']; ?>" ){  
							
						  $('td', nRow).css('background-color', '#<?php echo $channelas['COLOR']; ?>');
					  } else
				<?php } ?>
			
						{ $('td', nRow).css('background-color', '#949fbf'); }
			
			  }
			 
             
          });
          
          table.ajax.reload();
          
          $.ajax({
              url : "<?php echo base_url().'tvpcresp22/listchart_tvpc/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup + "&genre=" + genre,
              success: function(response) {
                   
                   create_chart(response.data,colgroup);
               },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
          
           var x = document.getElementsByClassName("buttons-excel");
          
          if (x.length > 0){
              x = x[0];
          }
          
          var excelButton = $(".buttons-excel").detach();
          
          $(".buttonExcel").append( excelButton );
          $(".buttonExcel").show();
       }	
      
	  function getRandomColor() {
		  var letters = '0123456789ABCDEF';
		  var color = '#';
		  for (var i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 16)];
		  }
		  return color;
		}
	  
      function get_tooll(array_tvpc,ada,cgroup){
		  
 		  
          var mm = ['Program : '+array_tvpc[ada].PROGRAM];  
  
          if(cgroup == 'tvr'){
              col_data = 'TVR : '+parseFloat(array_tvpc[ada].TVR).toFixed(2);
          } else if(cgroup == 'tvs'){
              col_data = 'TVS : '+parseFloat(array_tvpc[ada].TVS).toFixed(2);
          } else if(cgroup == 'viewers'){
              col_data = 'Viewers : '+parseFloat(array_tvpc[ada].VIEWERS).toFixed(2);
          }
          
          mm.push['Chanel : '+array_tvpc[ada].CHANNEL];
          mm.push['Tanggal : '+array_tvpc[ada].DATE];
          mm.push['TVR : '+array_tvpc[ada].TVR];
                
          return ['Program : '+array_tvpc[ada].PROGRAM,'Channel : '+array_tvpc[ada].CHANNEL,'Tanggal : '+array_tvpc[ada].DATE,col_data];
      }
      
      var myChart = null;
      
      function create_chart(data,cgroup){
          if (myChart !== null) {
               myChart.destroy(); 
               $('#legend').html("");
          }
           
          var channel = $('#channel').val().replace('&',' AND ');			 
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1isi = [];
          var tv1label = [];
          var tv1data = [];
          var tv2data = [];
          var tv3data = [];
          var color_list;
          var htht = '';
          
          if (typeof data.tvpc[1] === 'undefined') {
              $('.result-chart-graph').hide();
              $('#dtmsg').css('display','block'); 
          } else {
              $('.result-chart-graph').show();
              $('#dtmsg').css('display','none');  
          }      
                 
          /* HANDLE ALL CHANNEL */
          var channel_header = "";                                                                    
          if(channel == "0"){
              /* READ CHANNEL FROM AFTER CHOOSE GENRE */
              $('#custom_channel').next().children().each(function(){
                  if($(this).children().html() != "All Channel"){
                      channel_header += $(this).children().html()+",";
                  }
              })
              
              channel_header = channel_header.slice(0,-1);
          } else {
              channel_header = channel;
          }  
                           
          channel_header = channel_header.split(",");          
          for(var i=0; i < channel_header.length; i++){
            ch.push(channel_header[i].replace('&',' AND '));
              
			      <?php foreach($channel as $channelasS) { ?>
						if ( channel_header[i] == "<?php echo $channelasS['channel']; ?>" ){
							
						 color_list= "#<?php echo $channelasS['COLOR']; ?>";
					  } else
			      <?php } ?>
			
						{  color_list= 'red'; }
			      console.log("color_list :"+color_list);
			  
            
              
               htht += '<div class="col-md-2 col-xs-2"> <span class="dot" style="height: 10px;width: 10px;background-color: '+color_list+';border-radius: 50%;display: inline-block;"></span> '+channel_header[i]+'</div>';
              
              $('#legend').html(htht);
          }
          
          for(var si=0; si < data.tvpc.length; si++){

			      <?php foreach($channel as $channelasSS) { ?>
    						if ( data.tvpc[si].CHANNEL == "<?php echo $channelasSS['channel']; ?>" ){
    							
    						 color_list= "#<?php echo $channelasSS['COLOR']; ?>";
    					  } else
			      <?php } ?>
			
						{  color_list= 'red'; }

		  
              
              
              tv1tgl.push([data.tvpc[si].PROGRAM,data.tvpc[si].CHANNEL]);
              tv1label.push(data.tvpc[si].CHANNEL);
              tv2data.push(color_list);
              
              if(cgroup == 'tvr'){
                  col_data = data.tvpc[si].TVR;
              } else if(cgroup == 'tvs'){
                  col_data = data.tvpc[si].TVS;
              } else if(cgroup == 'viewers'){
                  col_data = data.tvpc[si].VIEWERS;
              }
              
              tv1data.push(parseFloat(col_data));
              
               
              tv1isi.push({
                  label: data.tvpc[si].CHANNEL,
                  data: [parseFloat(col_data)],
                  backgroundColor : color_list[si],
                  borderColor : color_list[si],
                  borderWidth : 1
              });
          }
           
          tgl = tv1tgl;
          
          var series = [];
          
          for(var ss=0; ss < data.tvpc.length; ss++){		
              series.push({
              name: tv1tgl[ss],
              data: [tv1data[ss]]
              });
          }
          
         // RESET CHART
          $("#myChart").remove();
          $('.result-chart-graph').append('<canvas id="myChart"><canvas>');
          
          var ctx = document.getElementById("myChart").getContext('2d');
       
          myChart = new Chart(ctx, {
              type: 'bar',   
              data: {
                  labels: tv1tgl,
                  datasets: [{
                      label: tv1label,
                      data: tv1data,
                      backgroundColor: tv2data,
                      borderColor: tv2data,
                      borderWidth: 1,
                      fill: false,
                  }]
              },
              options: {
                  tooltips: {
                      callbacks: {
                          label: function(tooltipItem) { 
                              return get_tooll(data.tvpc,tooltipItem.index,cgroup);
                           }
                      }
                  },
                  legend: {
                      display: false
                   },
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero:false
                          }
                      }],
						xAxes: [{
							ticks: {
 								maxRotation: 90,
								minRotation: 90,
								autoSkipPadding: 30
							}
						}]
                  },
              }
          });
          
          $('input.toggle-vis').removeAttr('disabled');  	     
  
          if(cgroup == 'tvs'){
              $('#tvs').prop('checked',true);
              $('#tvr').prop('checked',false);
              $('#viewers').prop('checked',false);
          }
      }	
      
      function sortTable(n,el) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("myTable");
          switching = true;
          
          //Set the sorting direction to ascending:
          dir = "asc";
          
          /*Make a loop that will continue until
          no switching has been done:*/
          while (switching) {
              //start by saying: no switching is done:
              switching = false;
              rows = table.getElementsByTagName("tr");
              
              /*Loop through all table rows (except the
              first, which contains table headers):*/
              for (i = 1; i < (rows.length - 1); i++) {
                  //start by saying there should be no switching:
                  shouldSwitch = false;
                  /*Get the two elements you want to compare,
                  one from current row and one from the next:*/
                  x = rows[i].getElementsByTagName("td")[n];
                  y = rows[i + 1].getElementsByTagName("td")[n];
                  
                  /*check if the two rows should switch place,
                  based on the direction, asc or desc:*/
                  if (dir == "asc") {
                      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                          //if so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                      }
                  } else if (dir == "desc") {
                      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                          //if so, mark as a switch and break the loop:
                          shouldSwitch = true;
                          break;
                      }
                  }
              }
              
              if (shouldSwitch) {
                  /*If a switch has been marked, make the switch
                  and mark that a switch has been done:*/
                  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                  switching = true;
                  //Each time a switch is done, increase this count by 1:
                  switchcount++;
              } else {
                  /*If no switching has been done AND the direction is "asc",
                  set the direction to "desc" and run the while loop again.*/
                  if (switchcount == 0 && dir == "asc") {
                      dir = "desc";
                      switching = true;
                  }
              }
          }                  
          
          if(dir == "asc"){
              $(el).children().css("transform","rotate(180deg)");
          } else if(dir == "desc"){
              $(el).children().css("transform","rotate(0deg)");
          }
      }
	  
	  
	  
	  function refreshtablefilter(start_date,end_date,profile,ch,start_time,end_time){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
         
          var table = $("#myTable").DataTable({
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
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.toString().replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter(start_date,end_date,profile,ch,start_time,end_time);
									}).draw();
								  },
                  title: 'UNICS - Program Comparison',
                  filename: 'UNICS - Program Comparison'
								}
						  ],
              "serverSide": true,
              "processing": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'tvpcresp22/list_tvpc'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time,
              "searchDelay": 700,
              "bFilter" : false,
              "bInfo" : false,
              "iDisplayLength": 10,
			   "order": [[ 8, "desc" ]],
              columnDefs: [{
                  render: function ( data, type, row, meta ) {								 
                       return data;
                  },
                  targets: 0
              },
              {
                  orderable: false,
                  targets: [0,1,2,3,4,5,6]
              }],		
              
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');   
                  $('.loader').css('display','none');   
                  if(colgroup == 'tvs'){
                      $('#tvs').prop('checked',true);
                      $('#tvr').prop('checked',false);
                      $('#viewers').prop('checked',false);
                  }     
              },
              
              "fnPreDrawCallback":function(){
                  $('#processButton').hide();
                  $('#loader').show();
              },
              "fnDrawCallback":function(){
                  $("#loader").hide();
                  $('#processButton').show();
                  $('.loader').css('display','none');
              },
              "fnInitComplete":function(){
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('#processButton').show();
                  $('.loader').css('display','none');
              },
             
			   "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			  
				<?php foreach($channel as $channelas) { ?>
						if ( aData[3] == "<?php echo $channelas['channel']; ?>" ){  
							
						  $('td', nRow).css('background-color', '#<?php echo $channelas['COLOR']; ?>');
					  } else
				<?php } ?>
			
						{ $('td', nRow).css('background-color', '#949fbf'); }
			
			  }
			 
             
          });
	  }               
    
    function search_genre(){
         var query = $('#search_genre').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#genre').empty('');
        
        var strVar = "<li data-for='genre'><a href='#' data-real='0' class='urate-select-form-two' data-for='genre'>All Genre</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvpcresp22/genresearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response[0].PROGRAM);
                $("#genre").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].GENRE;
                    }
                    
                     strVar += "<li data-for='genre'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='genre'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#genre").next().next().next().append(strVar);   
                
                $('[data-for = "genre"]').click(function() {
                    //console.log("SINI!");                       
                    $('#genre').next().text($(this).data("real"));
                    $('#genre').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active');  
                    
                    $(".search-genre-con").remove();
                    
                    search_channel();     
              
                     $('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', '');
                    $('#custom_channel').html("Please Choose a Channel ...");                         
                });                           
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }       
    
    function search_channel(){
        var genre = $('#genre').val();
        var query = "";
        
        if($('#search_channel').val() != undefined){
            query = $('#search_channel').val(); 
        } else {
            query = "";
        }
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "";
       
            strVar = "<li data-for='channel'><a href='#' data-real='0' data-id='channel'>All Channel</a></li>";
         
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvpcresp22/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
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
                    
                     strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                } 
                
                if(query == ""){  
                    $("#channel").parent().removeClass('active'); 
                    $(".search-channel-con").remove();                            
                    $("#channel").next().next().html('');       
                    $("#channel").next().next().append(strVar);
                } else {
                    $("#channel").next().next().next().append(strVar);
                }  
                
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
                });
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
    
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
            url		: "<?php echo base_url().'tvpcresp22/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 for(i=0; i < response.length; i++){
                    dpart_list += '<li data-for="daypart"><a href="#" data-real="'+response[i].DPART+'" data-id="daypart">'+response[i].DPART+'</a></li>';
                }
                
                $("#custom_daypart").next().html(dpart_list);
                
                $("#modalNewTime").modal('toggle');           
          
                $('[data-for="daypart"]').on('click',function(){
                     $('#custom_daypart').html($(this).children().data('real'));
                    $(this).closest('.urate-select-dropdown').find('.hidden-element-for-dropdown').attr('value', $(this).children().data('real'));
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
        
        var strVar = "<li data-for='profile'><a href='#' data-real='1' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvpcresp22/profilesearch/'; ?>"+"?q="+query+"&f="+period,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#profile").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
						strText = ''; 
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