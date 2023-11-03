 
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
	</style>                         
  
  <div class="content-wrapper">
      <div class="container-fluid">
      <!-- Content -->
      <!-- Data Set -->                    
      <div class="row">
          <div class="col-md-5">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">Pay TV</li>
                  <li class="breadcrumb-item active">Time Segment by Program</li>
              </ol>
              <h3 class="page-title-inner"><strong>Time Segment by Program</strong></h3>
          </div>   
			<div class="col-md-7 text-right">
				<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
			</div>			  
      </div>
      <div class="panel urate-panels">
          <div class="panel-body" style="height: 240px;">
              <div class="row">
                  <!-- PERIODE FIELD -->
				  
				  <div class="col-lg-12">	
						<div class="col-lg-3">	
							<div class="form-group input-daterange">
								<label>Start Date Period</label>
								<input type="text"  class="form-control" name="start_date" id="start_date" placeholder="From ..." value="" style="text-align:left"> 
							</div>
						</div>
						<div class="col-lg-3">	
							<div class="form-group input-daterange">
								<label>End Date Period</label>
								<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." value="" style="text-align:left">
							</div>
						</div>
						<div class="col-lg-3" style="z-index: 999;">	
							<label> Genre </label>
								 <select class="urate-select" name="genre" id="genre" title="Please Choose Genre" required >
									  <option value="0" >All Genre</option>
									  <?php foreach($genre as $key) { ?>
									  <option value="<?php echo str_replace("&","AND",$key['GENRE']); ?>" ><?php echo $key['GENRE']; ?></option>
									  <?php } ?>
								  </select>  
						</div>
						<div class="col-lg-3" style="z-index: 999;">	
							<label> Channel</label>
								<div class="select-wrapper">
								  <select class="urate-select grid-menu " name="channel" id="channel" title="Please choose a Channel..." required>
									  <option value="0" >All Channel</option>
									  <?php foreach($channel as $key) { ?>
									  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
									  <?php } ?>
								  </select>
							  </div> 
						</div>
						<div class="col-lg-3" style="top: 75px;position: absolute;">	
							<label> Program </label>
								<select class="urate-select" name="program" id="program" title="Please Choose Program" required >
								  <option value="" >No Data</option>
								 
							  </select> 
						</div>
						
						
					</div>
				  

              </div>
          </div>
      </div>
      <!-- /Data Set -->
      <!-- Result -->
	  
	   <div class="panel2" id="panel-blank" >
		
		<img alt="image" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
	  
	  </div>
	  
	   <div class="loader" style="display:none">
                              <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
                          </div>
	  
      <div class="panel urate-panel urate-panel-results" style="display:none">
           <div class="panel-headings">
              <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						<button class="button_black" onclick="excel()" id=''><em class="fa fa-download"></em> &nbsp Export</button>
					</div>
				</div>
          </div>
          <div class="panel-body">
                
              <div class="result-control">
                  
              </div>
              <!-- / Nav tabs -->
              <!-- Tab panes -->
              <div class="tab-content">
                  <!-- Tab Table -->
                  <div role="tabpanel" class="tab-pane active" id="table">
                         
						  <br/>
						   <div id="btn_export">
						  
						  </div>
						  <div class="result-chart-graph">
                          <canvas id="myChart" height="100"></canvas>
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
  
   <!-- Highcharts -->

  
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
                  format: 'yyyy-mm-dd',
                  //startDate: '-1y',
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
              //console.log("SINI!");                       
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
                      url		: "<?php echo base_url().'timesegment/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
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
                  url		: "<?php echo base_url().'timesegment/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                  url		: "<?php echo base_url().'timesegment/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                  url		: "<?php echo base_url().'timesegment/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
	  
	  function excel(){
		  
		  var group="";
		  
		    $('.urate-panel-result').show();
                  $('#processButton').hide();
                  $('#processButtonExcell').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
		  
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
		  
		   if(start_date === ''){ 
              alert('Please, Select Date');
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

			if(program === null || program === ''){ 
        			alert('Please, Select Program');
        			return false;
        	} 	  	
			
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
          var pjgcolspan =channel_header.length;   
 		  
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
              url : "<?php echo base_url().'timesegment/export_chart'?>",
              method : "POST",
              data : form_data,
              success: function(response) {
				  
				  	download_file('<?php echo $donwload_base; ?>tmp_doc/time_segment.xls','Time_segment.xls');
                
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
 
          if(start_date === ''){  
              alert('Please, Select Date');
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

			if(program === null || program === ''){  
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
          
           channel_header=channel_header.split(",");
          var pjgcolspan =channel_header.length;   
          $("#jmlcolspan1").attr("colspan", pjgcolspan);
          
          var kolom="";
          var klmch; 
          var panjang=(channel_header.length);
           
          for(var i=0; i < panjang; i++){
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='image' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
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
				  url : "<?php echo base_url().'timesegment/list_charttvcc'?>",
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
				  url : "<?php echo base_url().'timesegment/list_charttvcc2'?>",
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
	  
	  
      function search(group=""){
		  
		   $('.urate-panel-results').show();
		   $('#panel-blank').hide();
                  $('#processButton').hide();
                  $('#processButtonExcell').hide();
                  $('#loader').show();
                  $('.loader').css('display','block');
		  
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
 
          if(start_date === ''){  
              alert('Please, Select Date');
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

			if(program === null || program === ''){  
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
              kolom = kolom+"<th style='width=30px;'><div class='channelname"+i+"'>"+channel_header[i]+"</div> <img alt='image' src='<?php echo $path; ?>assets/images/icon_arrowdown.png'></th>";
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
              url : "<?php echo base_url().'timesegment/list_charttvcc'?>",
              method : "POST",
              data : form_data,
              success: function(response) {
                   
				  var dts = response.data;
				  var gda = response.date;
	 
				  
				  $("#myChart").remove(); 
				  
				  $(".myChart").remove();
				  $(".titmyChart").remove();
				  
 
				   for(var t=0; t < dts.length; t++){
					    
					   create_chart(dts[t],channel,t,gda[t]);
					   
				   }
				   
				   $("#btn_export").html(''); 
                
               },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });       
		  
		  

      }
      
	   function get_tooll(array_tvpc,ada){
	 
          return ['PROGRAM : '+array_tvpc[ada.datasetIndex].FULL_PROG[ada.index], 'CHANNEL : '+array_tvpc[ada.datasetIndex].CHANNEL[ada.index],'TIME : '+array_tvpc[ada.datasetIndex].TIME[ada.index],'VIEWERS : '+array_tvpc[ada.datasetIndex].VIEWER[ada.index]];
      }
	  
	   function create_chart(data,channel,ts,dates){
		  
		  
 		 var dts = data;
		 
		 
		 var ch = [];
		 
		  var ch2 = [];
		 
		 for(var t=0; t < dts.length; t++){
			 var chs = [];
			 
            chs['label'] = 'Viewers';
			chs['data'] = dts[t].VIEWER;
			chs['backgroundColor'] = dts[t].COLOR;
			chs['borderColor'] = dts[t].COLOR;
			chs['borderWidth'] = 2;
			
			ch.push(chs);
         }
		 
 		  
		
          $('.result-chart-graph').append('<div class="titmyChart" ><h3 style="text-align:center">'+dates+'</h3><canvas class="myChart" id="myChart'+ts+'"><canvas></div>');
		  
		  var ctx = document.getElementById("myChart"+ts);
			var myChart = new Chart(ctx, {
			  type: 'bar',
			  
			  data: {
				labels: dts[0].TIME,
				datasets: ch
			  },
			  options: {
				 tooltips: {
                      callbacks: {
                          label: function(t,d) { 
 						  
 							  return ['PROGRAM : '+dts[t.datasetIndex].FULL_PROG[t.index], 'CHANNEL : '+dts[t.datasetIndex].CHANNEL[t.index],'TIME : '+dts[t.datasetIndex].TIME[t.index],'VIEWERS : '+dts[t.datasetIndex].VIEWER[t.index]];
                           }
                      }
                  },
				 legend: {
					display: false
				 },
				scales: {
				  yAxes: [{
					stacked: true,
					ticks: {
					  beginAtZero: false
					}
				  }],
				  xAxes: [{
					stacked: true,
					ticks: {
					  beginAtZero: false,
						fontColor: 'blue',
						maxTicksLimit: 48,
 
					  
					}
				  }]

				}
			  }
			});

			
			$("#loader").hide();
            $('.loader').css('display','none');
			$('#processButton').show();     
        
      }
	  
    
    function search_genre(){
         var query = $('#search_genre').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#genre').empty('');
        
        var strVar = "<li data-for='genre'><a href='#' data-real='0' class='urate-select-form-two' data-for='genre'>All Genre</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'timesegment/genresearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
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
		
		if(res.length > 1 || res == '0' ){
			strVar += "<li data-for='program'><a href='#' data-real='ALL' class='urate-select-form-two' data-for='program'>All Program</a></li>";
			
			$("#program").next().next().next().empty('');
			$("#program").next().next().next().append(strVar); 

			 $('[data-for = "program"]').click(function() {
               $('#program').next().text($(this).data("real"));
              $('#program').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active');  

              $(".search-program-con").remove();          

          });
				
		}else{

			$.ajax({ 
				type	: "POST",
				url		: "<?php echo base_url().'timesegment/programsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + channel + "&d=" + start_date + "&de=" + end_date,
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
            url		: "<?php echo base_url().'timesegment/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query +"&g=" + genre,
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
            url		: "<?php echo base_url().'timesegment/profilesearch/'; ?>"+"?q="+query+"&f="+period,
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