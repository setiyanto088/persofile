 
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
	
	.input-daterange input {
		text-align: left;
		font-size: 18px;
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
  
  <div class="content-wrapper" style="overflow:hidden">
      <div class="container-fluid">
          <!-- Content -->
          <!-- Data Set -->
          <div class="row">
              <div class="col-md-5">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">Pay TV</li>
                      <li class="breadcrumb-item">Inhouse Report</li>
                      <li class="breadcrumb-item active">Daypart Performance</li>
                  </ol>
                  <h3 class=""><strong>Day Part</strong></h3>
              </div>       
			  <div class="col-md-7 text-right">
				<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
			</div>
          </div>
          <div class="panel">
              <div class="panel-body" style="height: 200px;">
                  <div class="row">
				  
						<div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Period</label>
									<input type="text"  class="form-control" name="start_date" id="start_date" placeholder="From ..." value="">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>End Date Period</label>
									<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." value="">
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
									  <option value="ALL" >All Days</option>
									 <?php foreach($daypart as $key) { ?>
									  <option value="<?php echo $key['DPART']; ?>" ><?php echo $key['DPART']; ?></option>
									  <?php } ?>
								  </select>
							  </div>
						    </div> 
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Profile</label>
									<select class="form-control urate-select" name="profile" id="profile" title="Please Choose Profile" required >
										  <option value=0 >All People</option>
										  <?php foreach($profile as $key) { ?>
										  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
										  <?php } ?>
									</select>
								</div>
							</div>
							
							<div class="col-lg-3">	
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
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>TV Channel</label>
										<select class="urate-select grid-menu" name="channel" id="channel" title="Please Choose a Channel ..." required>
											  <option value="0" >All Channel</option>
											  <?php foreach($channel as $key) { ?>
											  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
											  <?php } ?>
										  </select>
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Data</label>
									<select class="urate-select" name="datatp" id="datatp" title="Please Choose a Channel ..." required>
									  <option value="audience" >Audience</option>
									  <option value="total_views" >Total Views</option>
									  <option value="duration" >Duration</option> 
									</select>
								</div>
							</div>		
						</div>

                      <!-- WAKTU FIELD --> 
                   
                       
                      <!-- END TV CHANNEL FIELD -->
                      <!-- PROCESS BUTTON -->
                      <div class="col-md-12 text-center" style="top: 365px;position: absolute;width: 96%;">
                          <br />
                          <div class="btn-loader">
                             
                          </div>
                      </div>  
                      <!-- END PROCESS BUTTON -->
                  </div>
              </div>
          </div>
		   <div class="loader" style="display:none">
                                  <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
                              </div>
		   <div class="panel2" id="panel-blank" >
		
			<img alt="img" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
		  
		  </div>
          <!-- /Data Set -->
          <!-- Result -->
          <div class="panel urate-panel urate-panel-results" style="display:none">
				 <div class="panel-headings">
                  <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button class="button_black" onclick="export_excel()" id=''><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
              </div>
              <div class="panel-body" style="margin-top:10px">
 
                  <div class="tab-content">
                      <!-- Tab Table -->
                      <div role="tabpanel" class="tab-pane active" id="table">

                          <div class="result-table">
                             
							  <br/>
							  <div class="row">
								<div class="col-md-6">
								  <table aria-describedby="mydesc"  id="myTable" class="table table-striped example ">
									  <thead>
									  <tr style="">
										 
										  <th scope="row" style="color:red" >Daypart</th>
										  <th id="table_header1" style="color:red" >Audience</th>
										 
									  </tr>
									  </thead>
									  <tbody id="table_1">
										
									  </tbody>
								  
								  </table>  
								</div>
								<div class="col-md-6">
								  <table aria-describedby="mydesc"  id="myTable2" class="table table-striped example ">
									  <thead>
									  <tr style="">
									 
										  <th scope="row" style="color:red">Days</th>
										  <th id="table_header2" style="color:red">Audience</th>
										</tr>
										 <tbody id="table_2">
										
									  </tbody>
									  </thead>
								  
								  </table>  
								</div>
							  </div>
                          </div>
                      </div>
                      <!-- / Tab Table -->
                      <!-- Tab Chart -->
                      
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
          <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
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
                  //startDate: '-1y',
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
              //console.log("SINI!");                       
              $('#genre').next().text($(this).data("real"));
              $('#genre').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
              $(".search-genre-con").remove();
              
              search_channel();     
              
              //$('#channel').val("");
              $('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_channel').html("Please Choose a Channel ...");                   
          });                    
          
          $('.result-control-radio').click(function(){
              $('.result-control .urate-radio').removeClass('active');
              //$(this).parent().addClass('active');
              
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
            		url : "<?php echo base_url().'daypartvir/listchart_tvpc/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup,
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
          
           $("#start_date").on("change",function(){
              $('#profile').empty('');
               var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'daypartvir/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
          var datatp = $('#datatp').val();
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


			if(datatp === null || datatp === ''){  
        			alert('Please, Select Data');
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
		  
		  	 if(datatp == "audience"){
						var data_text = "Audience"; 
					 }else if(datatp == "total_views"){
						 var data_text = "Total Views"; 
					 }else{
						 var data_text = "Duration"; 
					 }
					 
				     $("#table_header1").html(data_text);
				     $("#table_header2").html(data_text);
		  
		   $('.urate-panel-results').show();
		    $('#panel-blank').hide();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
            
		   $.ajax({
              url : "<?php echo base_url().'daypartvir/list_tvpc2/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup + "&genre=" + genre+ "&datatp=" + datatp+ "&daypart=" + daypart,
              success: function(response) {
				  
				  console.log(response)
				  
				     $("#table_1").html('');
					 
				
				     $("#table_1").html(response.table1);
					 
					 $("#table_2").html('');
				     $("#table_2").html(response.table2);
					 
				     $("#loader").hide();
                  $('#processButton').show();
                  $('.loader').css('display','none');
				  
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
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
		
		  else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}
	  
	  
	  
	  function export_excel(group=""){
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
          var datatp = $('#datatp').val();
          var genre = $('#genre').val();          
          var channel = $('#channel').val().replace('&',' AND ');
          var start_time = '';
          var end_time = '';             
          var daypart =  $('#daypart').val();         
          var arrDaypart1 = [];
          var arrDaypart2 = [];
          var listDaypart = [];
          
          if(profile === null || profile === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Profile');
        			return false;
        	} 	 


			if(datatp === null || datatp === ''){  
        			alert('Please, Select Data');
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
		  
		   $('.urate-panel-result').show();
                  $('#processButton').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
            
		   $.ajax({
              url : "<?php echo base_url().'daypartvir/list_tvpc2_export/'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token  + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time + "&cgroup=" + colgroup + "&genre=" + genre+ "&datatp=" + datatp+ "&daypart=" + daypart,
              success: function(response) {
				  
 				  download_file('<?php echo $donwload_base; ?>tmp_doc/daypart.xls','daypart.xls');
				  
					 
				  $("#loader").hide();
                  $('#processButton').show();
                  $('.loader').css('display','none');
				  
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });

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
  
          if(cgroup == 'total_views'){
              col_data = 'total_views : '+parseFloat(array_tvpc[ada].TOTAL_VIEWS).toFixed(2);
          } else if(cgroup == 'tvs'){
              col_data = 'TVS : '+parseFloat(array_tvpc[ada].TVS).toFixed(2);
          } else if(cgroup == 'viewers'){
              col_data = 'Viewers : '+parseFloat(array_tvpc[ada].VIEWERS).toFixed(2);
          } else if(cgroup == 'duration'){
              col_data = 'Duration : '+parseFloat(array_tvpc[ada].DURATION).toFixed(2);
          } else if(cgroup == 'audience'){
              col_data = 'Audience : '+parseFloat(array_tvpc[ada].AUDIENCE).toFixed(2);
          }
          
          mm.push['Chanel : '+array_tvpc[ada].CHANNEL];
          mm.push['Tanggal : '+array_tvpc[ada].DATE];
          mm.push['TOTAL : '+array_tvpc[ada].TVR];
                
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
			  
             
              
              htht = htht+'<div class="col-md-2 col-xs-2" style="border: 1px solid #ffffff; background: '+color_list+'">'+channel_header[i]+'</div>';
              
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
 
              
			if(cgroup == 'viewers'){
                  col_data = data.tvpc[si].VIEWERS;
              } else if(cgroup == 'duration'){
                  col_data = data.tvpc[si].DURATION;
              }else if(cgroup == 'audience'){
                  col_data = data.tvpc[si].AUDIENCE;
              } else{
				  
				   col_data = data.tvpc[si].TOTAL_VIEWS;
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
                      }]
                  },
              }
          });
          
          $('input.toggle-vis').removeAttr('disabled');  	     
  
          if(cgroup == 'viewers'){
              $('#total_views').prop('checked',false);
               $('#viewers').prop('checked',true);
              $('#audience').prop('checked',false);
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
              "ajax": "<?php echo base_url().'daypartvir/list_tvpc'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&channel=" + ch + "&stime=" + start_time + "&etime=" + end_time,
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
                  if(colgroup == 'viewers'){
                      $('#total_views').prop('checked',false);
                     // $('#tvr').prop('checked',false);
                      $('#viewers').prop('checked',true);
                      $('#audience').prop('checked',false);
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
			
						{ $('td', nRow).css('background-color', '#000'); }
			
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
            url		: "<?php echo base_url().'daypartvir/genresearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
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
            url		: "<?php echo base_url().'daypartvir/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
            //data	: JSON.stringify(form_data),			
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
            url		: "<?php echo base_url().'daypartvir/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
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
            url		: "<?php echo base_url().'daypartvir/profilesearch/'; ?>"+"?q="+query+"&f="+period,
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