 
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
	
	  .dt-button{
  		position:relative;
  		left: 1%;
  		background-color: transparent;
  		color: #cb3827;
  		border-radius: 30px;
  		border: 1px solid #cb3827;
  		padding: 6px;
  		padding-left: 30px;
  		padding-right: 30px;
      bottom: 6px;
  	}                             
    
    .timepicker{
      text-align: center;
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
              <div class="col-md-6">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">Free to Air</li>
                      <li class="breadcrumb-item">View Behaviour</li>
                      <li class="breadcrumb-item active">Program Comparison</li>
                  </ol>
                  <h3 class="page-title-inner">Program Comparison</h3>
              </div>       
          </div>
          <div class="panel urate-panel">
              <div class="panel-body" style="height: 350px;">
                  <div class="row">
                      <!-- PERIODE FIELD -->
                      <div class="dataset col-md-4" style="z-index: 999;">
                          <div class="dataset-title">
                              <h4 class="title-text">From To Period</h4>
                          </div>
                          <div class="input-group input-daterange">
                              <input type="text" class="form-control urate-form-input" name="start_date" id="start_date" placeholder="From ..." value="">
                              <div class="input-group-addon">-</div>
                              <input type="text" class="form-control urate-form-input" name="end_date" id="end_date" placeholder="To ..." value="">
                          </div>
                      </div>      
                      <!-- END PERIODE FIELD -->
                      <!-- WAKTU FIELD --> 
                      <div class="dataset col-md-4" style="z-index: 999;">
                          <div class="dataset-title">
                              <h4 class="title-text">Day Part</h4>
                              <a href="#" data-toggle="modal" data-target="#modalNewTime" id="dptriger"><span class="ion-plus"></span> New</a>
                          </div>
                        
                          <div class="select-wrapper">
                              <select class='form-control urate-select' name="daypart" id="daypart" title='Please Choose Time Schedule ...'>
                                  <?php foreach($daypart as $key) { ?>
                                  <option value="<?php echo $key['DPART']; ?>" ><?php echo $key['DPART']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>  
                      <!-- END WAKTU FIELD -->
                      <!-- PROFILE FIELD -->
                      <div class="dataset col-md-4" style="z-index: 999;">
                          <div class="dataset-title">
                              <h4 class="title-text">Profile</h4>
                          </div>
                          <div class="select-wrapper">
                              <select class="urate-select" name="profile" id="profile" title="Please Choose Profile" required >
                                  <option value=0 >All People</option>
                                  <?php foreach($profile as $key) { ?>
                                  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
                                  <?php } ?>
                              </select> 
                          </div>
                      </div>  
                      <!-- END PROFILE FIELD -->
                      <!-- TV CHANNEL FIELD -->
                      <div class="dataset col-md-4" style="position: absolute;top: 255px;width: 352px;">
                          <div class="dataset-title">
                              <h4 class="title-text">TV Channel</h4>
                          </div>
                          <div class="select-wrapper">
                              <select class="urate-select grid-menu" title='Please Choose TV Channel ...' name="channel" id="channel" >
                                  <option value="0" >All Channel</option>
                                  <?php foreach($channel as $key) { ?>
                                  <option value="<?php echo $key['channel']; ?>" ><?php echo $key['channel']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>   
                      <!-- END TV CHANNEL FIELD -->
                      <!-- PROCESS BUTTON -->
                      <div class="col-md-12 text-center" style="top: 365px;position: absolute;width: 96%;">
                          <br />
                          <div class="btn-loader">
                              <button class="btn urate-outline-btn btn-lg" id="processButton" onclick="search()">Process</button>
                              <img alt="image" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader">
                          </div>
                      </div>  
                      <!-- END PROCESS BUTTON -->
                  </div>
              </div>
          </div>
          <!-- /Data Set -->
          <!-- Result -->
          <div class="panel urate-panel urate-panel-result">
              <div class="panel-heading">
                  <h3 class='urate-panel-title'>Result</h3>
              </div>
              <div class="panel-body">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active">
                          <a href="#table" aria-controls="table" role="tab" data-toggle="tab">Table</a>
                      </li>
                      <li role="presentation">
                          <a href="#chart" aria-controls="chart" role="tab" data-toggle="tab">Chart</a>
                      </li>
                  </ul>
                  <!-- / Nav tabs -->
                  <!-- Tab panes -->
                  <div class="tab-content">
                      <!-- Tab Table -->
                      <div role="tabpanel" class="tab-pane active" id="table">
                          <div class="row result-action">
                              <div class="col-md-6">
                                  <button class="btn urate-outline-btn" value="Hide Selected" onclick="compare();"><img alt="image" src="<?php echo $path; ?>assets/images/icon_compare.png"> Compare</button>
                              </div>
                              <div class="col-md-6 text-right">
                                  &nbsp;
                              </div>
                          </div>
                          <div class="result-table">
                              <div class="loader" style="display:none">
                                  <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
                              </div>
							  <br/>
                              <table aria-describedby="table" id="myTable" class="table table-striped table-bordered example urate-table">
                                  <thead>
                                  <tr style="">
                                    
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Rank</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Date</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Program</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Channel</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Genre</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Begin Time</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">End Time</th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">TVS <img alt="image" src="<?php echo $path; ?>assets/images/icon_arrowdown.png" alt="arrow"></th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">TVR <img alt="image" src="<?php echo $path; ?>assets/images/icon_arrowdown.png" alt="arrow"></th>
                                      <th style="color: #000000; border: 1px solid black;" scope="row">Viewer <img alt="image" src="<?php echo $path; ?>assets/images/icon_arrowdown.png" alt="arrow"></th>
                                  </tr>
                                  </thead>
                              
                              </table>   
                          </div>
                      </div>
                      <!-- / Tab Table -->
                      <!-- Tab Chart -->
                      <div role="tabpanel" class="tab-pane" id="chart">  
                          <div class="result-control">
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
                                  <div style="text-align: center;"><span id="legend"></span></div>
                              </div>
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
					<h4 class="modal-title" id="myModalLabel">Create Day Part</h4>
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
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn daypart_create" onClick="create_daypart()">Create</button>
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
            	var channel = $('#channel').val();
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
              if(channel == "0"){
                  channel = '<?php foreach($channel as $key) { echo $key['channel'] . ","; } ?>';
                  
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
            		url : "<?php echo base_url().'tvpc/listchart_tvpc/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup,
            		success: function(response) {
                     
                     create_chart(response.data,colgroup);
             		},
            		error: function(obj, response) {
                    console.log('ajax list_project error:' + response);
            		}
            			
            	});
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
          
          $('#from, #to').timepicker({
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
          
           $("#start_date").on("change",function(){
              $('#profile').empty('');
              //var strVar = "";
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'tvpc/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
               var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'tvpc/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                   dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
                       $("#profile").next().next().next().empty('');   
                      
                      for(i=0; i < response.length; i++){                       
                          if(response[0] == "Value not found!"){
                              strResult = response[0]; 
							  strText  = '';
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
      
       function search(group=""){         

 	  
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
          var channel = $('#channel').val();
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
              arrDaypart1 = listDaypart[0].split("-");
              start_time = arrDaypart1[0];
              end_time = arrDaypart1[1];
              
              arrDaypart2 = [];
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
          if(channel == "0"){
              channel = '<?php foreach($channel as $key) { echo $key['channel'] . ","; } ?>';
              
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
           
          var table = $("#myTable").DataTable({
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
              "ajax": "<?php echo base_url().'tvpc/list_tvpc'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&flag_proc=1",
              "searchDelay": 700,
              "bFilter" : false,
               "bInfo" : false,
              "iDisplayLength": 10,
			  "order": [[ 8, "desc" ]],
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
			  
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
              "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {       
                  <?php foreach($channel_col as $channelas) { ?>
        						if ( aData[3] == "<?php echo $channelas['channel']; ?>" ){  
        							
        						  $('td', nRow).css({'background-color':'#<?php echo $channelas['COLOR']; ?>','color':'black','border':'1px solid black'});
        					  } else
        				<?php } ?>
        			      { $('td', nRow).css({'background-color':'#949fbf','color':'black','border':'1px solid black'}); }
        			
        			  }              
               
          });
          
          table.ajax.reload();
          
          $.ajax({
              url : "<?php echo base_url().'tvpc/listchart_tvpc/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup,
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
      
      function get_tooll(array_tvpc,ada,cgroup){
          var mm = ['Program : '+array_tvpc[ada].program];  
  
          if(cgroup == 'tvr'){
              col_data = 'TVR : '+parseFloat(array_tvpc[ada].TVR).toFixed(2);
          } else if(cgroup == 'tvs'){
              col_data = 'TVS : '+parseFloat(array_tvpc[ada].TVS).toFixed(2);
          } else if(cgroup == 'viewers'){
              col_data = 'Viewers : '+parseFloat(array_tvpc[ada].viewers).toFixed(2);
          }
          
          mm.push['Chanel : '+array_tvpc[ada].channel];
          mm.push['Tanggal : '+array_tvpc[ada].tanggal];
          mm.push['TVR : '+array_tvpc[ada].TVR];
                
          return ['Program : '+array_tvpc[ada].program,'Channel : '+array_tvpc[ada].channel,'Tanggal : '+array_tvpc[ada].tanggal,col_data];
      }
      
      var myChart = null;
      
      function create_chart(data,cgroup){
          if (myChart !== null) {
               myChart.destroy(); 
               $('#legend').html("");
          }
           
          var channel = $('#channel').val();			 
          
          /* HANDLE ALL CHANNEL */
          if(channel == "0"){
              channel = '<?php foreach($channel as $key) { echo $key['channel'] . ","; } ?>';
              
              channel = channel.slice(0,-1);
          }
          
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
                 
          channel=channel.split(",");
          
          for(var i=0; i < channel.length; i++){
              ch.push(channel[i]);
              <?php foreach($channel_col as $channelas) { ?>
        						if ( channel[i] == "<?php echo $channelas['channel']; ?>" ){
        							
        						  color_list='#<?php echo $channelas['COLOR']; ?>';
        					  } else
        				<?php } ?>
        			
        						{ color_list= '#d891d8' }
              
              htht = htht+'<div class="col-md-2 col-xs-2" style="border: 1px solid #ffffff; background: '+color_list+'">'+channel[i]+'</div>';
              
              $('#legend').html(htht);
          }
          
          for(var si=0; si < data.tvpc.length; si++){
              <?php foreach($channel_col as $channelas) { ?>
    						if ( data.tvpc[si].channel == "<?php echo $channelas['channel']; ?>" ){
    							
    						  color_list='#<?php echo $channelas['COLOR']; ?>';
    					  } else
        			<?php } ?>
        			
              { color_list= '#d891d8' }	
              
              tv1tgl.push([data.tvpc[si].program,data.tvpc[si].channel]);
              tv1label.push(data.tvpc[si].channel);
              tv2data.push(color_list);
              
              if(cgroup == 'tvr'){
                  col_data = data.tvpc[si].TVR;
              } else if(cgroup == 'tvs'){
                  col_data = data.tvpc[si].TVS;
              } else if(cgroup == 'viewers'){
                  col_data = data.tvpc[si].viewers;
              }
              
              tv1data.push(parseFloat(col_data));
              
              tv1isi.push({
                  label: data.tvpc[si].channel,
                  data: [parseFloat(col_data)],
                  backgroundColor : color_list,
                  borderColor : color_list,
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
                      borderWidth: 1
                  }]
              },
              options: {
                  tooltips: {
                      callbacks: {
                          label: function(tooltipItem) { 
                              return get_tooll(data.tvpc,tooltipItem.index,cgroup);
                              //console.log(tooltipItem);
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
								  text: 'Export Excel',
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
              "ajax": "<?php echo base_url().'tvpc/list_tvpc'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time+ "&flag_proc=0",
              "searchDelay": 700,
              "bFilter" : false,
              "bInfo" : false,
              "iDisplayLength": 10,
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
                  $('.loader').css('display','none');
                  $('#processButton').show();
              },
              "fnInitComplete":function(){
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
              },
              "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {       
                  <?php foreach($channel_col as $channelas) { ?>
        						if ( aData[3] == "<?php echo $channelas['channel']; ?>" ){ 
        							
        						  $('td', nRow).css({'background-color':'#<?php echo $channelas['COLOR']; ?>','color':'black','border':'1px solid black'});
        					  } else
        				<?php } ?>
        			      { $('td', nRow).css({'background-color':'#949fbf','color':'black','border':'1px solid black'}); }
        			
        			  }              
              
          });
          
	  }      
    
    function search_channel(){
         var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "<li data-for='channel'><a href='#' data-real='0' data-id='channel'>All Channel</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvpc/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
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
            url		: "<?php echo base_url().'tvpc/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
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
        
        var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvpc/profilesearch/'; ?>"+"?q="+query+"&f="+period,
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