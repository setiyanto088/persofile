  <?php
    error_reporting(0);
    ini_set('display_errors', 0);
  ?>
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
      top: -13px;
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
                  <li class="breadcrumb-item">Transvision</li>
                  <li class="breadcrumb-item active">Channel Comparison</li>
              </ol>
              <h3 class="page-title-inner">Channel Comparison</h3>
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
                          <input class="form-control urate-form-input" type="text" name="start_date" id="start_date" value="01/09/2020" placeholder="From ..." />
                          <div class="input-group-addon">-</div>
                          <input class="form-control urate-form-input" type="text" name="end_date" id="end_date" value="30/09/2020" placeholder="To ..." />
                      </div>
                  </div>
                  <!-- END PERIODE FIELD -->
                  <!-- WAKTU FIELD --> 
                  <div class="dataset col-md-4" style="z-index: 1000;">
                      <div class="dataset-title">
                          <h4 class="title-text">Day Part</h4>
                          <a href="#" data-toggle="modal" data-target="#modalNewTime" id="dptriger"><span class="ion-plus"></span> New</a>
                      </div>
                      <!-- <div class="input-group">
                          <input class="form-control urate-form-input timepicker"  type="text" name="start_time" id="start_time" value="20:00" placeholder="From ..." />
                          <div class="input-group-addon">-</div>
                          <input class="form-control urate-form-input timepicker"  type="text" name="end_time" id="end_time" value="22:00" placeholder="To ..." />
                      </div> -->
                      <div class="select-wrapper">
                          <select class='form-control urate-select ' name="daypart" id="daypart" title='Please Choose Time Schedule ...'>
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
                  <!-- GENRE FIELD -->
                  <div class="dataset col-md-4" style="position: absolute;top: 255px;width: 352px;">
                      <div class="dataset-title">
                          <h4 class="title-text">Genre</h4>
                      </div>
                      <select class="urate-select" name="genre" id="genre" title="Please Choose Genre" required >
                          <option value="0" >All Genre</option>
                          <?php foreach($genre as $key) { ?>
                          <option value="<?php echo str_replace("&","AND",$key['GENRE']); ?>" ><?php echo $key['GENRE']; ?></option>
                          <?php } ?>
                      </select>  
                  </div>
                  <!-- END GENRE FIELD -->
                  <!-- TV CHANNEL FIELD -->
                  <div class="dataset col-md-4" style="position: absolute;top: 255px;width: 352px;left: 375px;z-index: 999;">
                      <div class="dataset-title">
                          <h4 class="title-text">TV Channel</h4>
                      </div>
                      <div class="select-wrapper">
                          <select class="urate-select grid-menu" name="channel" id="channel" title="Please choose a Channel..." required>
                              <option value="0" >All Channel</option>
                              <?php foreach($channel as $key) { ?>
                              <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>   
                  <!-- END TV CHANNEL FIELD -->
                  <!-- PROCESS BUTTON -->
                  <div class="col-md-12 text-center" style="top: 365px;position: absolute;width: 96%;">
                      <br />
                      <div class="btn-loader">
                          <button class="btn urate-outline-btn btn-lg toggle-vis2" id="processButton" onclick="search()">Process</button>
                          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader">
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
              <!-- / Nav tabs -->
              <!-- Tab panes -->
              <div class="tab-content">
                  <!-- Tab Table -->
                  <div role="tabpanel" class="tab-pane active" id="table">
                      <div class="result-table">
                          <div class="loader" style="display:none">
                              <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
                          </div>
						  <br/>
                          <table id="myTable" class="table table-striped table-bordered example urate-table">
                              <thead>
                                  <tr>
                                    <th rowspan="2">Date</th>
                                    <th rowspan="2">Time <img src="<?php echo $path; ?>assets/images/icon_arrowdown.png"></th>
                                    <th id="jmlcolspan1"  style="text-align:center;color:#cc3300;">TVS</th>
                                  </tr>
                                  <tr id="colchannel" style=""></tr>									                    					
                              </thead>
                          </table>   
                      </div>
                  </div>
                  <!-- / Tab Table -->
                  <!-- Tab Chart -->
                  <div role="tabpanel" class="tab-pane" id="chart">
                      <div class="result-chart">
                          <p id="dtmsg" style="text-align: center;font-size: 24px;display:none;">No data available<p>
                          <div class="result-chart-graph">
								              <!-- <div style="position:center" id="chart_header"></div> -->
                              <canvas id="myChart" width="900px" height="400px"></canvas>
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
          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
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
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>    
  
  <script language="javascript">	
    	$(function () {                   
          $("#dptriger").on('click',function(){
              $('#loaderdp').hide();
              $(".modal .modal-footer button").show();
          });
          
          $('input.toggle-vis').attr('disabled','disabled');         
          
          var titl = $('title').html();
          $('title').html(titl+' (TVS)');
          
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  //startDate: '-1y',
                  endDate: '0d',
                 // defaultDate: new Date()
              });                            
              
              // m = moment(new Date());              
              // $(this).val(m.format('DD/MM/YYYY')); //"<?php echo $currdate[0]['CURRDATE']; ?>"
          });
          
      		$('.timepicker').bootstrapMaterialDatePicker({
      			date: false,
      			format: 'HH:mm:00'
      		});
          
          $('input.toggle-vis').on( 'click', function (e) {
              var colgroup = $(this).attr('data-column');
			  
              $('input.toggle-vis').attr('disabled','disabled');
              search(colgroup);                           
              
              var titl = $('title').html().split("(");
              
              $('title').html(titl[0]+'('+colgroup.toUpperCase()+')');
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
              
              $('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_channel').html("Please Choose a Channel ...");
              
              search_channel();                   
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
              //console.log("SONO!");
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
              //defaultTime: 'now',
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
                      url		: "<?php echo base_url().'tvcc3trans/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
                      //data	: JSON.stringify(form_data),			
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
              //var strVar = "";
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'tvcc3trans/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                  //data	: JSON.stringify(form_data),			
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
                          
                          //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
          
          //AJAXtify profile; profile by start date          
          $("#start_date").on("change",function(){  
              $('#profile').empty('');
              //var strVar = "";
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'tvcc3trans/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                  //data	: JSON.stringify(form_data),			
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
                          
                          //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
    	//multiple channel
    	$('.multipleSelect').fastselect();
  
      //proses
      function search(group=""){
          $('[data-for="genre"]').parent().parent().removeClass("active");
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          //var start_time = $('#start_time').val();
          //var end_time =  $('#end_time').val();
          var daypart =  $('#daypart').val();
          var profile = $('#profile').val();
          var genre = $('#genre').val();
          var channel = $('#channel').val();
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");                                         
          var colgroup;
          
          $('input.toggle-vis').attr('disabled','disabled');
          
          if(group==""){
              colgroup = $('input.toggle-vis').attr('data-column');
          } else {
              colgroup = group;
          }
          
          //validasi 
          if(start_date === ''){ // value of a text input cannot be null
              // or zero unless you've changed in with JS
              alert('Please, Select Date');
              return false;
          }
  	      /*
        	if(start_time === '' || end_time === ''){ // value of a text input cannot be null
        		// or zero unless you've changed in with JS
        		alert('Please, Select Time');
        		return false;
        	}	  
          */
          if(daypart === ''){ // value of a text input cannot be null
        		// or zero unless you've changed in with JS
        		alert('Please, Select Daypart');
        		return false;
        	}	 
          
          if(profile === null || profile === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Profile');
        			return false;
        	}
        	
        	if(genre === null || genre === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Genre');
        			return false;
        	} 	
        	
        	if(channel === null || channel === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Channel');
        			return false;
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
		  
		  $('#myTable').DataTable().clear().destroy();
          
		  var mytable_html = '<thead><tr><th rowspan="2">Date</th><th rowspan="2">Time <img src="<?php echo $path; ?>assets/images/icon_arrowdown.png"></th><th id="jmlcolspan1"  style="text-align:center;color:#cc3300;">TVS</th></tr><tr id="colchannel" style=""></tr></thead>';
		  console.log(channel_header);
		  $("#myTable").html(mytable_html); 
		  
		  
          //header table
          channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch;
          var panjang=(channel_header.length);
          console.log(panjang);
          
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
          }
          
          $("#colchannel").html(""); 
          $("#colchannel").html(kolom);     
          console.log(kolom);
          
          var ch = [];   
		  

          if(channel == "0"){
              ch = "0";
          } else {
              for(var i=0; i < channel_header.length; i++){
                  ch.push("'"+channel_header[i]+"'");
              }	      
          }
          
          if (channel.length < 1) {
              alert('Please, Select Channel');
              return false;	
          }	        
          
          var form_data = {
              sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              profile     : profile,
              genre     : genre,
              channel     : ch,
              dpart     : daypart,
              cgroup     : colgroup
          };     
          
          //display table
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
																				   // return column >= 7 && column <= 9 ? data.replace( /[$,.]/g, '' ) : data;
																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									 // ORIG // refreshtablefilter(start_date,end_date,profile,channel,ch,start_time,end_time,colgroup);
                   refreshtablefilter(user_id,token,start_date,end_date,profile,ch,daypart,colgroup,genre);
									}).draw();
								  },
                  title: 'UNICS - Channel Comparison',
                  filename: 'UNICS - Channel Comparison'
								}
						  ],
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": {
                  "url" : "<?php echo base_url().'tvcc3trans/list_tvcc'?>",
                  "type" : "POST",
				   "data" : form_data          
              },
              "searchDelay": 700, 
              "bFilter" : false, 
              "bInfo" : false,
              "iDisplayLength": 10,
              "scrollY":        "500px",
              columnDefs: [
                  {                                                              
                      render: function ( data, type, row, meta ) {
                          return data;						
                      },
                      targets: 0
                  },
                  {
                      orderable: false,
                      targets: [0]
                  }
              ],	
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
                  
                  $('#jmlcolspan1').html(colgroup.toUpperCase());
                  $('input.toggle-vis').removeAttr('disabled');   
                  if(colgroup == 'tvs'){
                      $('#tvs').prop('checked',true);
                      $('#tvr').prop('checked',false);
                      $('#viewers').prop('checked',false);
                  }
              },
              "fnInitComplete":function(){
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
                  
                  $(".table th").on("click",function(){                    
                      if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
                          $(this).children('img').css("transform","rotate(180deg)");
                      } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
                          $(this).children('img').css("transform","rotate(0deg)");
                      }
                  });
              }
          });
          //console.log(ch);
          
		  
		  
          //display chart
          $.ajax({
              url : "<?php echo base_url().'tvcc3trans/list_charttvcc'?>",
              method : "POST",
              data : form_data,
              success: function(response) {
                  console.log(response.data);
                  
                  //chart          
                  create_chart(response.data,colgroup);
                  //end chart		
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });       
    
          $('.dataTables_scrollHead').css('width','100%');
          $('.dataTables_scrollHeadInner').css('width','100%');
          $('.dataTables_scrollBody').css({'width':'100%','height':'auto'});
          $('.dataTable').css('width','100%');
          
          table.ajax.reload();
      }
      
      function create_chart(data,cgroup){
		  console.log(data);
          var channel = $('#channel').val();
          //console.log("channel : "+channel);
          
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
          
          channel_header=channel_header.split(",");
          var ch = [];
          var tgl;
          var tgls = [];
          var tv1tgl = [];                                                 
          
          if (typeof data.tvcc[1] === 'undefined') {
              $('#dtmsg').css('display','block'); 
              $("#myChart").remove();   
          } else {
              $('#dtmsg').css('display','none');
          }
          
          //tanggal
          tgl = data.tvcc[0];
         console.log(data.tvcc);
          
          //channel                           
          for(var i=0; i < data.tvcc[1].length; i++){
              tgls.push(data.tvcc[0][i]+"-"+data.tvcc[1][i]);
          } 
		     // console.log(tgls);
      
          //channel
          for(var i=0; i < channel_header.length; i++){
              ch.push(channel_header[i]);
          }
          //console.log(ch);
          
          if (myChart !== null) {
              $('#legend').html("");
          }
          
          // var tgl;
          var tv1tgl = [];
          var tv1isi = [];
          var tv1label = [];
          var tv1data = [];
          var tv2data = [];
          var tv3data = [];
          
          var color_list = [
              '#EBF495'	,'#F9B8DB'	,'#EF7CA8'	,'#F4C4FC'	,'#6DD5E8'	,'#B6FC80'	,'#C5FCA4'	
              ,'#D2C0F9'	,'#C6F8FF'	,'#FF75BC'	,'#9ED8F7'	,'#D2C0F9'	,'#9571DD'	,'#F47ADC'	
              ,'#9571DD'	,'#DBFFB2'	,'#A4C8F2'	,'#F7F97F'	,'#95F4C3'	,'#E19BEF'	,'#D48AF2'	
              ,'#E68DFC'	,'#D8EF7A'	,'#B6FC8D'	,'#6BEF81'	,'#F7F97F'	,'#EEFFB2'	,'#F2A48C'	
              ,'#84F992'	,'#BFF99A'	,'#FCA4CA'	,'#99F7A4'	,'#DB93F9'	,'#D19EEF'	,'#F7DA8C'	
              ,'#97F49A'	,'#D17FF4'	,'#B7E8F7'	,'#E4F785'	,'#CDB9F7'	,'#9A93F9'	,'#9EF6FF'	
              ,'#AEFCC9'	,'#88A8EA'	,'#A0BDEF'	,'#A7E1F2'	,'#75F4B9'	,'#6DEDCD'	,'#93F7FF'	
              ,'#C2DBFC'	,'#F7EF7B'	,'#FFF0C4'	,'#A6FCB9'	,'#8FEAEF'	,'#B8E0FC'	,'#FFF6B7'	
              ,'#CAFFAF'	,'#8EF771'	,'#B2FFB5'	,'#D7F9A4'	,'#A985E2'	,'#EFC4FF'	,'#A674F2'	
              ,'#A8C0F4'	,'#FFE68C'	,'#F282C5'	,'#F2C4FC'	,'#F9D190'	,'#EF90F9'	,'#FC9CBA'	
              ,'#EF94CB'	,'#B2FFB7'	,'#7CF995'	,'#F9D9A9'	,'#AAD7FF'	,'#FFAABF'	,'#8ADBF2'	
              ,'#FF7FF4'	,'#6ACAED'	,'#F47ADC'	,'#F9B3D2'	,'#FFA8C9'	,'#C6F28C'	,'#8EACF9'	
              ,'#9571DD'	,'#EF7CA8'	,'#B99FF9'	,'#A5FFDF'	,'#F99AF1'	,'#FFCCD7'	,'#9BFFB4'	
              ,'#B9FCAE'	,'#FB96FF'	,'#7B8AE0'	,'#C7C0F9'	,'#F78480'	,'#D7FF7A'	,'#F9B08B'	
              ,'#A0FFD2'	,'#F99FA7'	,'#AEEF86'	,'#6282DB'	,'#A4C8F2'	,'#C6C9FF'	,'#8973EF'	
              ,'#F9CCA7'	,'#ABF998'	,'#FFB7D5'	,'#F4948B'	,'#F7A385'	,'#9AF9CD'	,'#F9A2C8'	
              ,'#F9C0E7'	,'#B0BBF2'	,'#6CA5DD'	,'#F99C95'	,'#F296C2'	,'#C6F8FF'	,'#7EFCEF'	
              ,'#F7A3C4'	,'#99FFFB'	,'#F7ADBF'	,'#F8FFAD'	,'#FCAEAF'	,'#FD93FF'	,'#99F7B8'	
              ,'#B6FC80'	,'#A4ADF9'	,'#DBFCA6'	,'#F0A0F7'	,'#D4FFB2'	,'#C1E1FF'	,'#DBFFB2'	
              ,'#88E1F7'	,'#AFABF4'	,'#C7FFA5'	,'#7685F2'	,'#B0CAF4'	,'#AFFFC6'	,'#BDD5FC'	
              ,'#FF75BC'	,'#81FF7C'	,'#F4C4FC'	,'#ADFFBC'	,'#A6F291'	,'#9ED8F7'	,'#C98FE8'	
              ,'#ACC3F9'	,'#79A9FC'	,'#91CCEA'	,'#C5FCA4'	,'#E39BF2'	,'#FFCCEF'	,'#6695DD'	
              ,'#B1B0F4'	,'#EBF495'	,'#D2C0F9'	,'#A9F285'	,'#FEC9FF'	,'#95F4C3'	,'#E6FC9F'	
              ,'#F78FA7'	,'#FFA3F7'	,'#FFC6D7'	,'#6DD5E8'	,'#ADF497'	,'#F9F289'	,'#C4F477'	
              ,'#EDFFAD'	,'#FF84CE'	,'#F9B8DB'	,'#C98FE8'	,'#F47ADC'	,'#B2FFB5'	,'#FFC6D7'	
              ,'#A9F285'
          ]
          
          var htht = '';
          for(var i=0; i < channel_header.length; i++){
              ch.push(channel_header[i]);
              
              htht += '<div class="col-md-2 col-xs-2" style="border: 1px solid #ffffff; background: '+color_list[i]+'; text-align: center;">'+channel_header[i]+'</div>';
              $('#legend').html(htht);
          }
          
          //console.log("data.tvcc.length = "+data.tvcc.length);
          for(var si=2; si < data.tvcc.length; si++){	
              var ind = si-2;
              //console.log("index"+ind+" "+color_list[ind]);
              
              tv1isi.push({
                  label: ch[ind],
                  data: data.tvcc[si],
                  backgroundColor : color_list[ind],
                  borderColor : color_list[ind],
                  fill: false,
              });       
          }
          //console.log(tv1isi);
          
          // RESET CHART
          $("#myChart").remove();
          $('.result-chart-graph').append('<canvas id="myChart"><canvas>');
		  
          var ctx = document.getElementById("myChart").getContext('2d');
          
          myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: tgls,
                  datasets: tv1isi
              },
              options: {
                  tooltips: tv1isi,
                  hover: {
                      mode: 'nearest',
                      intersect: true
                  },
                  legend: {
                      position: 'bottom'
                  },
                  scales: {
                      yAxes: [{
                          display: true,
                          scaleLabel: {
                              display: true,
                              labelString: cgroup.toUpperCase()
                          }
                      }]
                  }
              }
          });
      }	
	  
	  
	  function   refreshtablefilter(user_id,token,start_date,end_date,profile,ch,daypart,colgroup,genre){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var form_data = {
              sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              profile     : profile,
              genre     : genre,
              channel     : ch,
              dpart     : daypart,
              cgroup     : colgroup
          };
         
          //display table
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
																				   // return column >= 7 && column <= 9 ? data.replace( /[$,.]/g, '' ) : data;
																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									     refreshtablefilter(user_id,token,start_date,end_date,profile,ch,daypart,colgroup,genre);
									}).draw();
								  },
                  title: 'UNICS - Channel Comparison',
                  filename: 'UNICS - Channel Comparison'
								}
						  ],
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": {
                  "url" : "<?php echo base_url().'tvcc3trans/list_tvcc'?>",
                  "type" : "POST",
                  "data" : form_data           
              },
              "searchDelay": 700, 
              "bFilter" : false, 
              "bInfo" : false,
              "iDisplayLength": 10,
              "scrollY":        "500px",
              columnDefs: [
                  {                                                              
                      render: function ( data, type, row, meta ) {
                          return data;						
                      },
                      targets: 0
                  }
              ],	
              "bLengthChange": false,
              "drawCallback": function() {
                  $('#jmlcolspan1').html(colgroup.toUpperCase());
                  $('input.toggle-vis').removeAttr('disabled');   
                  $('.loader').css('display','none');   
                  if(colgroup == 'tvs'){
                      $('#tvs').prop('checked',true);
                      $('#tvr').prop('checked',false);
                      $('#viewers').prop('checked',false);
                  }     
              }
          });
	  }
    
    function search_genre(){
        //console.log("SINI!");
        var query = $('#search_genre').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#genre').empty('');
        
        var strVar = "<li data-for='genre'><a href='#' data-real='0' class='urate-select-form-two' data-for='genre'>All Genre</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvcc3trans/genresearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
            //data	: JSON.stringify(form_data),			
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
                    
                    //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
                    strVar += "<li data-for='genre'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='genre'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#genre").next().next().next().append(strVar);   
                
                $('[data-for = "genre"]').click(function() {
                    //console.log("SINI!");                       
                    $('#genre').next().text($(this).data("real"));
                    $('#genre').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active');  
                    
                    $(".search-genre-con").remove();     
              
                    $('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', '');
                    $('#custom_channel').html("Please Choose a Channel ...");
                    
                    search_channel();                         
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
        
        //if(genre == "0"){
            //strVar = "";
        //} else {
            strVar = "<li data-for='channel'><a href='#' data-real='0' data-id='channel'>All Channel</a></li>";
        //}
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvcc3trans/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
            //data	: JSON.stringify(form_data),			
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response[0].CHANNEL);
                $("#channel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].CHANNEL;
                    }
                    
                    //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
                      //console.log("SANA!");
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
            url		: "<?php echo base_url().'tvcc/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
            //data	: JSON.stringify(form_data),			
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response);
                for(i=0; i < response.length; i++){
                    dpart_list += '<li data-for="daypart"><a href="#" data-real="'+response[i].DPART+'" data-id="daypart">'+response[i].DPART+'</a></li>';
                }
                
                $("#custom_daypart").next().html(dpart_list);
                
                $("#modalNewTime").modal('toggle');                      
          
                $('[data-for="daypart"]').on('click',function(){
                    //console.log("sini!"+$(this).children().data('real')+" - "+from);
                    $('#custom_daypart').html($(this).children().data('real'));
                    $(this).closest('.urate-select-dropdown').find('.hidden-element-for-dropdown').attr('value', $(this).children().data('real'));
                });
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        });
    }           
    
    function search_profile(){
        //console.log("SINI!");         
        var query = $('#search_profile').val();
        var period = $('#start_date').val(); 
        
        $('#profile').empty('');
        
        var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvcc3trans/profilesearch/'; ?>"+"?q="+query+"&f="+period,
            //data	: JSON.stringify(form_data),			
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response[0].PROGRAM);
                $("#profile").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                        strText = '';
                    } else {
                        strResult = response[i].ID;
                        strText = response[i].NAME;
                    }
                    
                    //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
    
    $(document).ready(function(){
        $(".table th").on("click",function(){                    
            if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
                $(this).children('img').css("transform","rotate(180deg)");
            } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
                $(this).children('img').css("transform","rotate(0deg)");
            }
        });
    }); 
  </script>