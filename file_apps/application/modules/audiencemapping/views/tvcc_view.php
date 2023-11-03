
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
	
	.dt-buttons {
		margin-top:19px !important; 
		
	}
	
	 td.details-control {
		background: url('<?php echo base_url();?>img/png/chevron-arrow-down.png') no-repeat center left;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('<?php echo base_url();?>img/png/chevron-arrow-up.png') no-repeat center left;
	}
	</style>                          
  
  <div class="content-wrapper">
      <div class="container-fluid">
      <!-- Content -->
      <!-- Data Set -->                    
      <div class="row">
          <div class="col-md-5">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">Pay TV</li>
                  <li class="breadcrumb-item active">Audience Mapping</li>
              </ol>
              <h3 class="page-title-inner"><strong>Audience Mapping</strong></h3>
          </div>     
			<div class="col-md-7 text-right">
				<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
			</div>		  
      </div>
      <div class="panel urate-panels">
          <div class="panel-body" style="height: 170px;">
              <div class="row">
			  
				<div class="col-lg-12" style="z-index: 1000;">	
						<div class="col-lg-3">	
							<div class="form-group input-daterange">
								<label>Start Date Period</label>
								<input type="text"  class="form-control" name="start_date" id="start_date" placeholder="From ..." style="text-align:left" value="">
							</div>
						</div>
						<div class="col-lg-3" style="z-index: 1000;">	
							<div class="form-group input-daterange">
								<label>End Date Period</label>
								<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." style="text-align:left" value="">
							</div>
						</div>
						<div class="col-lg-3" style="">	
							<label> Genre </label>
								<div class="select-wrapper">
								 <select class="urate-select" name="genre" id="genre" title="Please Choose Genre" required >
									  <option value="0" >All Genre</option>
									  <?php foreach($genre as $key) { ?>
									  <option value="<?php echo str_replace("&","AND",$key['GENRE']); ?>" ><?php echo $key['GENRE']; ?></option>
									  <?php } ?>
								  </select>  
							  </div>
						</div>
						<div class="col-lg-3" style="">	
							<label> TV Channel </label>
								 <div class="select-wrapper">
									   <select class="urate-select grid-menu " name="channel" id="channel" title="Please choose a Channel..." required>
										  <option value="0" >All Channel</option>
										  <?php foreach($channel as $key) { ?>
										  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
										  <?php } ?>
									  </select>
								  </div>
						</div>
						<div class="col-lg-3" style="position: absolute;top: 65px;z-index: 999;">	
							<label> TV Program </label>
								 <div class="select-wrapper">
									   <select class="urate-select" name="program" id="program" title="Please Choose Program" required >
                          <option value="" >No Data</option>
                         
                      </select>  
								  </div>
						</div>
					</div>
			  
			  
                  <!-- PERIODE FIELD -->
                
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
      <!-- Result -->
      <div class="panel urate-panel urate-panel-results" style="display:none">
          <div class="panel-headings">
              <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button class="button_black" onclick="expor_province()" id=''><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
          </div>
          <div class="panel-body">
              <!-- Nav tabs -->
              <div class="col-md-2">
 								<div class="row" style="background-color:#F2F2F2;padding:5px;color:#000;border: none;border-radius:5px">
									 <div class="col-md-6" id="tabs_table" style="border: none;background-color:#fff;border-radius:5px;">
										<button id="tab_table" style="border: none;background-color:#fff;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('table')" href="#table" aria-controls="table" role="tab" data-toggle="tab"><strong>Table</strong></button>
									</div>
									<div class="col-md-6" id="tabs_chart" style="border: none;border-radius:5px;">
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Chart</strong></button>
									</div>
								</div>
                              </div>               
              <div class="result-control">
               
              </div>
              <!-- / Nav tabs -->
              <!-- Tab panes -->
              <div class="tab-content">
                  <!-- Tab Table -->
                  <div role="tabpanel" class="tab-pane active" id="table" style="margin-top:50px;">
                          <div class="loader" style="display:none">
                              <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
                          </div>
						  <br/>
                          <div class="row">
							  <div class="col-md-12">
							  <h2>Province</h2 >
								  <div class="result-table" >
								  
										<table aria-describedby="mydesc"  id="myTable" class="table table-striped">
											<thead style="color:red">
												<tr>
													<!--<th style='width:10%'>Detail</th>-->
													<th  scope="row">Province</th>
													<th text-align="right" scope="row">Viewers</th>
													<th text-align="right" scope="row">Total Views</th>
													<th text-align="right" scope="row">Duration</th>
													<th text-align="right" scope="row">Action</th>
													
												</tr>
											</thead>
										</table>
									</div>
							  </div>
							 
						</div>
                  </div>
                  <!-- / Tab Table -->
                  <!-- Tab Chart -->
                  <div role="tabpanel" class="tab-pane" id="chart">
		 
                      <div class="result-chart">
					  
                          <p id="dtmsg" style="text-align: center;font-size: 24px;display:none;">No data available<p>
                          <div class="result-chart-graph">
								              
							  
							  <div id="container1" style="width: 900px; height: 400px; margin: 0 auto"></div>
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
          <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
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
 
   <!-- Highcharts -->
	<script src="<?php echo $path; ?>assets/ext/proj4.js"></script>
	<script src="<?php echo $path; ?>assets/ext/highcharts.src.js"></script>
	<script src="<?php echo $path; ?>assets/ext/highcharts-more.src.js"></script>
	<script src="<?php echo $path; ?>assets/ext/map.src.js"></script>
	<script src="<?php echo $path; ?>assets/ext/id-all.js"></script>
   
  <script language="javascript">	
  
  function format ( d ) {
    return  '<div class="row"><div class="col-md-12"><div class="result-table" ><table aria-describedby="mydesc"  id="myTable1" class="table table-striped " style="margin-top:50px;width:100%"><thead style="color:red"><tr><th align="left">City</th><th align="right">Viewers</th><th align="right">Total Views</th><th align="right">Duration</th></tr></thead></table></div></div></div>';
}
  
  
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
                  format: 'yyyy-mm-dd',
                   endDate: '0d',
                  defaultDate: new Date()
              });                            
              
              m = moment(new Date());              
              $(this).val(m.format('YYYY-MM-DD')); 
          });
          
      		$('.timepicker').bootstrapMaterialDatePicker({
      			date: false,
      			format: 'HH:mm:00'
      		});
          
          $('input.toggle-vis').on( 'click', function (e) {
			  
			  //alert('aaa');
              var colgroup = $(this).attr('data-column');
			  
              $('input.toggle-vis').attr('disabled','disabled');
              search_chart(colgroup);                           
              
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
               $('#genre').next().text($(this).data("real"));
              $('#genre').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
              $(".search-genre-con").remove();          
              
              $('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value', '');
              $('#custom_channel').html("Please Choose a Channel ...");
			   $('#custom_program').html("Please Choose Program ...");
              
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

		  $('#custom_program').click(function() {   
              $(".search-program-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-program-con'><input type='text' name='search_program' id='search_program' class='form-control urate-form-input' value='' onkeyup='search_program()' paceholder='Search Program'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-program-con").remove();
                  $("#custom_program").after(searchElement);  
                  $("#search_program").focus();
              } else {
                  $(".search-program-con").remove();
              }
 
			  search_program();
	 
			  
          });          
		  
		   $('[data-for = "channel"]').click(function() {
			   
 			   
			    $('#custom_program').html("Please Choose Program");
			   
		});
		  
		   $('[data-for = "program"]').click(function() {
              //console.log("SINI!");                       
              $('#program').next().text($(this).data("real"));
              $('#program').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  
              
			  
			  
              $(".search-program-con").remove();          
 
          });
		  
          
          /* TO HANDLE ALL CHANNEL*/
          /* IF ALL CHANNEL CHECKED THE ANY OTHER CHANNEL THAN ALL CHANNEL WILL BE UN-CHECKED*/
          $('.channel-list .urate-custom-menu > li > a').on('click',function(){
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
                      url		: "<?php echo base_url().'audiencemapping/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
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
               var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'audiencemapping/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
 			   $('#custom_program').html("Please Choose Program ...");
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'audiencemapping/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
		  
		  $("#end_date").on("change",function(){  
              $('#profile').empty('');
 			   $('#custom_program').html("Please Choose Program ...");
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'audiencemapping/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
     	$('.multipleSelect').fastselect();
  
      //proses
	   function search_chart(group=""){
		   
		    $('input.toggle-vis').attr('disabled','disabled');
          
			  if(group==""){
				  colgroup = $('input.toggle-vis').attr('data-column');
			  } else {
				  colgroup = group;
			  }
			  
			     var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
    
         
          var genre = $('#genre').val();
          var channel = $('#channel').val();
		  var program = $('#program').val();
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

			if(program === null || program === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Program');
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
          
          //header table
          channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch;
          var panjang=(channel_header.length);
           
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='img' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
          }
          
          $("#colchannel").html(""); 
          $("#colchannel").html(kolom);     
           
          var ch = [];   
          if(channel == "0"){
              ch = "0";
          } else {
              for(var i=0; i < channel_header.length; i++){
                  ch.push("'"+channel_header[i]+"'");
              }	      
          }
			    
          var form_data = {
              sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup
          };       
			  
			    $.ajax({
				  url : "<?php echo base_url().'audiencemapping/list_charttvcc'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
 					  
 					 create_chart_province(response.data,colgroup);
 				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
				  }
			  });       
			  
 			  $.ajax({
				  url : "<?php echo base_url().'audiencemapping/list_charttvcc2'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
 					  
 					 create_chart_city(response.data,colgroup);
 				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
				  }
			  });     
		   
	   }
	  
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
	  
	  function export_city(province){
		 var group="" ;
 		  $('[data-for="genre"]').parent().parent().removeClass("active");
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
   
         
          var genre = $('#genre').val();
          var channel = $('#channel').val();
		  var program = $('#program').val();
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

			if(program === null || program === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Program');
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
          
          //header table
          channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch;
          var panjang=(channel_header.length);
           
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='img' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
          }
          
          $("#colchannel").html(""); 
          $("#colchannel").html(kolom);     
           
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
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup,
			  province	 : province
          };       
		  
		     $.ajax({
              url : "<?php echo base_url().'audiencemapping/export_city'?>",
              method : "POST",
              data : form_data,
              success: function(response) {
				  
				  	download_file('<?php echo $donwload_base; ?>tmp_doc/export_city.xls','export_city.xls');
                
				$("#loader").hide();
				$('.loader').css('display','none');
				$('#processButton').show();     
				$('#processButtonExcell').show();     
				
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });   
		  
	  }
	  
	  function expor_province(){
		 var group="" ;
 		  $('[data-for="genre"]').parent().parent().removeClass("active");
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
   
         
          var genre = $('#genre').val();
          var channel = $('#channel').val();
		  var program = $('#program').val();
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

			if(program === null || program === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Program');
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
          
          //header table
          channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch;
          var panjang=(channel_header.length);
           
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='img' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
          }
          
          $("#colchannel").html(""); 
          $("#colchannel").html(kolom);     
           
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
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup
          };       
		  
		     $.ajax({
              url : "<?php echo base_url().'audiencemapping/export_province'?>",
              method : "POST",
              data : form_data,
              success: function(response) {
				  
				  	download_file('<?php echo $donwload_base; ?>tmp_doc/export_province.xls','export_province.xls');
                
				$("#loader").hide();
				$('.loader').css('display','none');
				$('#processButton').show();     
				$('#processButtonExcell').show();     
				
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
	  
      function search(group=""){
          $('[data-for="genre"]').parent().parent().removeClass("active");
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val(); 
         
          var genre = $('#genre').val();
          var channel = $('#channel').val();
		  var program = $('#program').val();
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

			if(program === null || program === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Program');
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
          
          //header table
          channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch;
          var panjang=(channel_header.length);
           
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='img' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
          }
          
          $("#colchannel").html(""); 
          $("#colchannel").html(kolom);     
           
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
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup
          };       
          
           var table = $("#myTable").DataTable({
			   
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": {
                  "url" : "<?php echo base_url().'audiencemapping/list_tvcc'?>",
                  "type" : "POST",
                  "data" : form_data           
              },
			   "columns": [
				{
					"className":      'details-control',
					"orderable":      false,
					"data":           "0",
					"defaultContent": ''
				},
				{ "data": "1" },
				{ "data": "2" },
				{ "data": "3" },
				{ "data": "4" }
			],
              "searchDelay": 700, 
              "bFilter" : false, 
              "bInfo" : false,
              "iDisplayLength": 10,
              "scrollY":        "500px",

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
                  
                   $('input.toggle-vis').removeAttr('disabled');   
                  if(colgroup == 'viewers'){
                      $('#total_views').prop('checked',false);
                      $('#durasi').prop('checked',false);
                      $('#viewers').prop('checked',true);
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
		  
		  
		  			
 
 $('#myTable').on('click', 'tr td.details-control', function () {
	 
 	 
		 var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
			
			   var genre = $('#genre').val();
          var channel = $('#channel').val();
		  var program = $('#program').val();
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

			if(program === null || program === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Program');
        			return false;
        	} 	  			
          
          /* HANDLE ALL CHANNEL */
          var channel_header = "";                                                                    
          if(channel == "0"){
              /* READ CHANNEL FROM AFTER CHOOSE GENRE */
              $('#custom_channel').next().children().each(function(){
                  if($(this).children().html() != "All Channel"){
                      channel_header += $(this).children().html()+",";
					  
					  //alert($(this).children().html());
                  }
              })
              
              channel_header = channel_header.slice(0,-1);
          } else {
              channel_header = channel;
          }      
          
          //header table
          channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch;
          var panjang=(channel_header.length);
           
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='img' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
          }
          
          $("#colchannel").html(""); 
          $("#colchannel").html(kolom);     
           
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
          
		  var data_pr = row.data();
		  
		  var cl_data_pr = data_pr[0].replace("<p style='margin-left:20px'>", "");
		  var cl_data_pr2 = cl_data_pr.replace("</p>", "");
		  
          var form_data = {
              sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup,
			  province	 : cl_data_pr2
          };       
			
             // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
			
			 var table1 = $("#myTable1").DataTable({
			 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": {
                  "url" : "<?php echo base_url().'audiencemapping/list_tvcc_city'?>",
                  "type" : "POST",
                  "data" : form_data           
              },
              "searchDelay": 700, 
              "bFilter" : false, 
              "bInfo" : false,
              "iDisplayLength": 10,
              "scrollY":        "500px",

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
                  
                   $('input.toggle-vis').removeAttr('disabled');   
                  if(colgroup == 'viewers'){
                      $('#total_views').prop('checked',false);
                      $('#durasi').prop('checked',false);
                      $('#viewers').prop('checked',true);
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
			
        }
        
    } );
		  
		 
          $.ajax({
              url : "<?php echo base_url().'audiencemapping/list_charttvcc2'?>",
              method : "POST",
              data : form_data,
              success: function(response) {
                      
					create_chart_city_map(response.data,colgroup);
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
	  
	  function create_chart_city_map(data,colgroup){
		  
			Highcharts.wrap(Highcharts.seriesTypes.pie.prototype, 'getCenter', function(p) {
			var centerOptions = this.options.center,
			  centerLatLonOptions = this.options.centerLatLon,
			  chart = this.chart,
			  slicedOffset = this.options.slicedOffset,
			  pos,
			  lat,
			  lon;

			if (centerLatLonOptions && chart.fromLatLonToPoint) {
			  pos = chart.fromLatLonToPoint({
				lat: centerLatLonOptions[0],
				lon: centerLatLonOptions[1]
			  });

			  centerOptions[0] = chart.xAxis[0].toPixels(pos.x, true) - 2 * slicedOffset;
			  centerOptions[1] = chart.yAxis[0].toPixels(pos.y, true) - 2 * slicedOffset;
			}

			return p.call(this);
		  });
		  
 		  
		  var iterantion = data.length;
		  
		 
		  
			var arr_series = [];
		  
			var chs2 = [];
		    chs2['mapData'] = Highcharts.maps['countries/id/id-all'];
			chs2['name'] = 'Basemap';
			chs2['borderColor'] = '#A0A0A0';
			chs2['nullColor'] = 'rgba(200, 200, 200, 0.3)';
			chs2['showInLegend'] = false;
		  arr_series.push(chs2);
		  
		  var chs3 = [];
		    chs3['data'] = Highcharts.geojson(Highcharts.maps['countries/id/id-all'], 'mapline');
			chs3['type'] = 'mapline';
			chs3['name'] = 'Separators';
			chs3['color'] = '#707070';
			chs3['enableMouseTracking'] = false;
			chs3['showInLegend'] = false;
		  arr_series.push(chs3);
		  
			for (i = 0; i < iterantion; i++) { 
				var chs_city = [];
		  
				var chs4 = [];
 				chs4['lat'] = data[i][3];
				chs4['lon'] = data[i][2];
 				
				chs_city.push(chs4);
			}
			
			var chs5 = [];
			chs5['type'] = 'mappoint';
			chs5['name'] = 'Cities';
			chs5['data'] = chs_city;
			
			arr_series.push(chs5);
			
			for (ik = 0; ik < iterantion; ik++) { 
			
				var chs_citys = [];
			  
				var chs6 = [];
				chs6['type'] = 'pie';
				chs6['name'] = data[ik][0];
				chs6['data'] = [data[ik][1]];
				chs6['centerLatLon'] =  [data[ik][3], data[ik][2]];
				chs6['size'] = ''+[data[ik][5]]+' %';
 				chs6['colors'] = [data[ik][4]];
				
				arr_series.push(chs6);
			
			}
		 
		 console.log(arr_series);
		 
		   var chart = Highcharts.Map({
			chart: {
			  renderTo: 'container1',
			  events: {
				load: function() {
				  this.centeringPies = false;
				},
				redraw: function() {
				  if (!this.centeringPies) {
					this.centeringPies = true;

					this.series.forEach(function(serie) {
					  if (serie.type === 'pie' && serie.options.centerLatLon) {
						serie.update({
						  center: serie.getCenter()
						}, false);
					  }
					});

					this.redraw(false);
					this.centeringPies = false;
				  }
				},
			  }
			},

			title: {
			  text: 'Viewers Map'
			},

			mapNavigation: {
			  enabled: true
			},

			tooltip: {
				 
			},

			plotOptions: {
			  pie: {
				
				dataLabels: {
				  enabled: false
				}
			  }
			},
			series: arr_series
			
			 
		  });
		  
	  }
	  
	  function create_chart_city(data,colgroup){
 
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

              col_data = data[si][1]; 

              tv1tgl.push(data[si][0]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          
			if(colgroup == 'viewers'){
			  
			  var lblg = 'Viewers';
		  }else if(colgroup == 'total_views'){
			   var lblg = 'Total Views';
		  }else{
			   var lblg = 'Duration';
		  }
           
          tgl = tv1tgl;
          
          Highcharts.chart('container1', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: "Top City "+ lblg
              },
              subtitle: {
               },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: lblg 
              }
              },
              plotOptions: {
                  line: {
                      dataLabels: {
                          enabled: false 
                      },
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: lblg, 
                  data: tv1data
              }],
              tooltip: {
                  backgroundColor: {
                      linearGradient: [0, 0, 0, 60],
                      stops: [
                          [0, '#FFFFFF'],
                          [1, '#E0E0E0']
                      ]
                  },
                  borderWidth: 1,
                  borderColor: '#AAA',
                  formatter: function() {
                      var s;
                      var idx = this.series.data.indexOf(this.point);
                      
                      $.each(data, function() {
                          s = 
                          '<strong>City :</strong> ' + data[idx][0] + '<br>' +
                          '<strong>'+lblg+' :</strong> ' + parseFloat(data[idx][1]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
      function create_chart(data,cgroup){
          var channel = $('#channel').val();
           
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
           
          //channel                           
          for(var i=0; i < data.tvcc[1].length; i++){
              tgls.push(data.tvcc[0][i]+"-"+data.tvcc[1][i]);
          } 
       
          //channel
          for(var i=0; i < channel_header.length; i++){
              ch.push(channel_header[i]);
          }
           
          if (myChart !== null) {
              $('#legend').html("");
          }
          
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
          
           for(var si=2; si < data.tvcc.length; si++){	
              var ind = si-2;
               
              tv1isi.push({
                  label: ch[ind],
                  data: data.tvcc[si],
                  backgroundColor : color_list[ind],
                  borderColor : color_list[ind],
                  fill: false,
              });       
          }
           
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
	  
	    function   refreshtablefilter2(user_id,token,start_date,end_date,genre,ch,program,colgroup){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var form_data = {
               sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup
          };
         
           var table = $("#myTable1").DataTable({
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
 																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									     refreshtablefilter2(user_id,token,start_date,end_date,genre,ch,program,colgroup);
									}).draw();
								  },
                  title: 'UNICS - Audience Mapping City',
                  filename: 'UNICS - Audience Mapping City'
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
                  "url" : "<?php echo base_url().'audiencemapping/list_tvcc_city'?>",
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
                   $('input.toggle-vis').removeAttr('disabled');   
                  $('.loader').css('display','none');   
                  if(colgroup == 'viewers'){
                      $('#durasi').prop('checked',false);
                      $('#total_views').prop('checked',false);
                      $('#viewers').prop('checked',true);
                  }     
              }
          });
	  }
	  
	  function   refreshtablefilter(user_id,token,start_date,end_date,genre,ch,program,colgroup){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var form_data = {
               sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              genre     : genre,
              channel     : ch,
              program     : program,
              cgroup     : colgroup
          };
         
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
 																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									     refreshtablefilter(user_id,token,start_date,end_date,genre,ch,program,colgroup);
									}).draw();
								  },
                  title: 'UNICS - Audience Mapping Province',
                  filename: 'UNICS - Audience Mapping Province'
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
                  "url" : "<?php echo base_url().'audiencemapping/list_tvcc'?>",
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
                   $('input.toggle-vis').removeAttr('disabled');   
                  $('.loader').css('display','none');   
                  if(colgroup == 'viewers'){
                      $('#durasi').prop('checked',false);
                      $('#total_views').prop('checked',false);
                      $('#viewers').prop('checked',true);
                  }     
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
            url		: "<?php echo base_url().'audiencemapping/genresearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
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
    
	function search_program(){
       
			
		var channel =  $("#channel").val();
		var start_date =  $("#start_date").val();
		var end_date =  $("#end_date").val();
		
		var res = channel.split(",");

        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#program').empty('');
        
		
         var strVar = "";
		
		if(res.length > 1 || channel =='0'){
			strVar += "<li data-for='program'><a href='#' data-real='ALL' class='urate-select-form-two' data-for='program'>All Program</a></li>";
			
			$("#program").next().next().next().empty('');
			$("#program").next().next().next().append(strVar); 

			 $('[data-for = "program"]').click(function() {
              //console.log("SINI!");                       
              $('#program').next().text($(this).data("real"));
              $('#program').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  

              $(".search-program-con").remove();          

          });
				
		}else{

			$.ajax({ 
				type	: "POST",
				url		: "<?php echo base_url().'audiencemapping/programsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + channel + "&d=" + start_date + "&de=" + end_date,
 				dataType: 'json',
				contentType: 'application/json; charset=utf-8',
				success	: function(response) {
 					$("#program").next().next().next().empty('');
					
					strVar += "<li data-for='program'><a href='#' data-real='ALL' class='urate-select-form-two' data-for='program'>All Program</a></li>";
					
					for(i=0; i < response.length; i++){                       
						if(response[0] == "Value not found!"){
							strResult = response[0]; 
							strVar = '';
						} else {
							strResult = response[i].PRG;
						}
						
 						strVar += "<li data-for='program'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='program'>"+strResult+"</a></li>";                          
					} 
										  
					$("#program").next().next().next().append(strVar);   
									
					$('[data-for = "program"]').click(function() { 
						$('#program').next().text($(this).data("real"));
						$('#program').attr('value',$(this).data("real"));
						
						$(this).closest('.default').removeClass('active'); 
					  
						var chnl = $("#program").val(); 
						var datesel = $("#start_date").val(); 
						var profile = $("#profile").val();
						
						$(".search-program-con").remove();   
						$(".search-con").remove();
					  
 					});                                 
				}, error: function(obj, response) {
					console.log('ajax list detail error:' + response);	
				} 
			}); 
		}
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
            url		: "<?php echo base_url().'audiencemapping/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
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
              
			   $('[data-for = "channel"]').click(function() {

						$('#custom_program').html("Please Choose Program");
					   
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
            url		: "<?php echo base_url().'tvcc/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
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
            url		: "<?php echo base_url().'audiencemapping/profilesearch/'; ?>"+"?q="+query+"&f="+period,
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