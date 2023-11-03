 
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
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css">
  
	<div class="content-wrapper">
      <div class="container-fluid">      
          <div class="row">
              <div class="col-md-5">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">Pay TV</li>
                      <li class="breadcrumb-item">Sea Today Report</li>
                      <li class="breadcrumb-item active">Channel Migration</li>
                  </ol>
                  <h3 class="page-title-innes"><strong>Channel Migration</strong></h3>
              </div>  
				  <div class="col-md-7 text-right">
					<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
				</div>				  
          </div>
          <div class="panel urate-panels">
              <div class="panel-body" style="height: 150px;">
                  <div class="row">
				  
					<div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Date</label>
									<input type="text" class="form-control urate-form-input" name="start_date" id="start_date" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Channel</label>
									<div class="select-wrapper">
									  <select class='urate-select' name="channel" id="channel" title='Please Choose Channel ...'>
																<?php 
																	foreach($channels as $nhb){
												echo "<option value='".$nhb['CHANNEL_CIM']."' >".$nhb['CHANNEL_CIM']."</option>";
																	}
																?>
									  </select>
									</div> 
								</div>
							</div>
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>Program</label>
									<div class="select-wrapper">
									  <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader2" style="display: none;margin: auto;width: 24px;">
									  <select class='urate-select' name="programsss" id="programsss" title='Please Choose Program ...'>
										  <option disabled selected value="">-- Select Program --</option>
										  
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
		  
          <div class="panel urate-panel urate-panel-results" style="display:none">
               <div class="panel-headings">
                   <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
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
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px;background-color:#F2F2F2" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Chart</strong></button>
									</div>
								</div>
                              </div>
                  <!-- / Nav tabs -->
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="table">
                            <div class="result-table">
                                <table aria-describedby="mydesc"  id="example" class="table table-striped example urate-table">
                                    <thead style="color:red">
                                        <tr>
                                            <th style="color: #EF0000;" scope="row">Split Minutes</th>
                                            <th style="color: #EF0000;" scope="row">Channel</th>
                                            <th style="color: #EF0000;" scope="row">Program</th>
                                            <th style="color: #EF0000;" scope="row">TVR</th>
                                            <th style="color: #EF0000;" scope="row">Gain</th>
                                            <th style="color: #EF0000;" scope="row">Loss</th>
                                            <th style="color: #EF0000;" scope="row">Net</th>
                                            <th style="color: #EF0000;" scope="row">Main Contributors</th>
                                            <th style="color: #EF0000;" scope="row">Main Beneficiaries</th>
                                            <th style="color: #EF0000;" scope="row">Main Contributors Channel</th>
                                            <th style="color: #EF0000;" scope="row">Main Contributors Program</th>
                                            <th style="color: #EF0000;" scope="row">Main Beneficiaries Channel</th>
                                            <th style="color: #EF0000;" scope="row">Main Beneficiaries Program</th>                                                                                                                                                                                
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="chart" style="margin-top:80px">
                        
							 <div class="col-lg-12">
                                <div id="texted_hh"><h2>Summary</h2></div>
							</div>
                            
							<div class="col-lg-12">							
								<div id="container" style="width: 1100px; height: 400px; margin: auto"></div>
                            </div>
							
							
								<div class="col-lg-12 panel urate-panel" style="background-color:#F3F3F3">
									<div id="texted"><h2>Summary</h2></div>
									<div class="col-lg-3">
										<div id="summ-tvr"></div>
										<div id="summ-loss"></div>
									</div>	
									 <div class="col-lg-3">
										<div id="summ-gain"></div>
										<div id="summ-net"></div>
									</div>	
									<div class="col-lg-6">
															<div id="summ-contributor"></div>
																		<div id="summ-beneficial"></div>											
									</div>
								</div> 
								<div class="clearfix"></div>   

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>                                    
  
  <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms_sig.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path;?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Cookie -->

  <!-- Highcharts -->
	<script src="<?php echo $path5;?>plugins/highcharts/highcharts.js"></script>
  
  <script language="javascript">
      $(document).ready(function(){      
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  //startDate: '-1y',
                  endDate: '0d',
                  defaultDate: new Date()
              });         
              
              $(this).val("<?php echo $currdate[0]['CURRDATE']; ?>");
          });
      
          var table = $("#myTable").DataTable({ 
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
        	});		
          
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
								  },
                  title: 'UNICS - Channel Migration',
                  filename: 'UNICS - Channel Migration'
								}
						  ],
						  "columnDefs": [
                  { "visible": false, "targets": [9,10,11,12] }                                              
              ],         
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
        	});
        
        	var table = $("#example1").DataTable({
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
        	});
        
        	var table = $("#example2").DataTable({
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
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
                  url		: "<?php echo base_url().'channelmigration3sea/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                  url		: "<?php echo base_url().'channelmigration3sea/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
      
      $(document).ready(function(){
        
          $("#custom_programsss").on("click",function(){
              $("#custom_channel").parent().removeClass('active');  
              $(".search-channel-con").remove();
          });
          
          $('#custom_channel').click(function() {   
              $("#custom_programsss").parent().removeClass('active');
              $(".search-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);   
                  $("#search_channel").focus();   
              } else {
                  $(".search-channel-con").remove();
              }
                  
              $("[data-id='channel']").click(function(){                            
                  //console.log("SANA!");
                  $('#programsss').next().text('Please Choose Program ...');
                  $('#programsss').next().next().html(' ');
                  
                  var chnl = $(this).data("real");
                  var datesel = $("#start_date").val();
                  var profile = $("#profile").val();
                  
                  $(".search-channel-con").remove();
                  $(".search-con").remove(); 
                  
                  generate_program(chnl,datesel,profile);
              });
          });       
          
          $('[data-for = "channel"]').click(function() { 
              $('#channel').next().text($(this).data("real"));
              $('#channel').attr('value',$(this).data("real"));
              
              $(this).closest('.default').removeClass('active'); 
            
              var chnl = $("#channel").val(); 
              var datesel = $("#start_date").val(); 
              var profile = $("#profile").val();
              
              $(".search-channel-con").remove();   
              $(".search-con").remove();
            
              generate_program(chnl,datesel,profile);                     
          });
          
          $("#custom_programsss").on("click",function(){
              $("#custom_channel").parent().removeClass('active');
          });         
      });         
          
      function generate_program(channel, sdate, prof){
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
                  
          $('#programsss').empty('');
          var form_data = new FormData();  
		  	form_data.append('valselect', channel);
			form_data.append('dateselect', sdate);
			form_data.append('profile', prof);
                                                                                     
          var strVar = "";
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'channelmigration3sea/list_program';?>",
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
              success	: function(response) { 
			  
			  response = jQuery.parseJSON(response);
			  
                  $('#custom_programsss').hide();
                  $('#loader2').fadeIn(500).delay(1500).fadeOut(500);
                  $('#custom_programsss').delay(3000).fadeIn(500);
                      
                  var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-con'><input type='text' name='search_program' id='search_program' class='form-control urate-form-input' value='' onkeypress='search_program()' paceholder='Search Program'></div>";
                  
                  $("#custom_programsss").on("click",function(){
                      $("#custom_channel").parent().removeClass('active');
                          
                      if($(this).parent().hasClass('active')){
                          $(".search-channel-con").remove();
                          $(".search-con").remove();
                          $("#custom_programsss").after(searchElement);          
                          $("#search_program").focus();
                      } else {
                          $(".search-con").remove();
                      }
                  }); 
                  
                  if(response.data != undefined){
					  
					  strVar = "<li><a href='javascript:void(0)' data-real='All Program' class='urate-select-form-two' data-for='programsss'>All Program</a></li>";
					  
                      for(i=0; i < response.data.length; i++){
                          strVar += "<li><a href='javascript:void(0)' data-real='"+response.data[i].PROGRAM+"' class='urate-select-form-two' data-for='programsss'>"+response.data[i].PROGRAM+"</a></li>";                          
                      } 
                  } else {
                      strVar += "<li style='padding-left:20px; padding-bottom:5px; padding-top:10px; font-size:11px;'>Value not found!</li>";
                  }
                                        
                  $("#programsss").next().next().html(strVar);   
                                    
                  $('[data-for = "programsss"]').click(function() { 
                      $('#programsss').next().text($(this).data("real"));
                      $('#programsss').attr('value',$(this).data("real"));
                      
                      $(this).closest('.default').removeClass('active');
                      
                      $(".search-con").remove();    
                                                        
                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                          $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                      } else {
                          $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                      }                          
                  });                           
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
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
      
      function search(){
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $('[data-for="programsss"]').parent().parent().removeClass("active");
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var profile = "0";
          var channel = $('#channel').val();
          var program = $('#programsss').val().replace('#','`ht`');
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");                 
          
          var colgroup = "tvr";
          
          var orderingnya = '0';	
          var by = '';	
          
          $('input.toggle-vis').attr('disabled','disabled');
          
          if(start_date === ''){ 
              alert('Please, Select Start Date');
              return false;
          }	                             
          
          if(profile === null || profile === ''){ 
        			alert('Please, Select Profile');
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
			                         console.log("SINI!");
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
									  var addOptions = { exportOptions: { 'columns': [0,1,2,3,4,5,6,9,10,11,12]} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter(start_date,channel, program, profile);
									}).draw();
								  },
                  title: 'UNICS - Channel Migration',
                  filename: 'UNICS - Channel Migration'
								}
						  ],   
              "columnDefs": [
                  { "visible": false, "targets": [9,10,11,12] }                                              
              ],                            
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'channelmigration3sea/list_migration'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
             
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
			  "autoWidth": false,
              "bLengthChange": false
            
              ,"fnPreDrawCallback":function(){
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
              },
              "fnInitComplete":function(){
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
              }
          });
          
          table.ajax.reload();
          
          var table2 = $("#example2").DataTable({
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'channelmigration3sea/list_migration_sub'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              'buttons': [
                  {extend: "excel",className: "btn-sm"}
              ],		
              "orderable": false,
              "ordering": false,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              },
              
              "fnPreDrawCallback":function(){  
                  $('.urate-panel-result').show();
              }
          });
          
          table2.ajax.reload();
          
       
          //CHART  
          $.ajax({
             
              url : "<?php echo base_url().'channelmigration3sea/list_chartcm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                 
                  create_chart(response.data,response.st_rt,start_date,colgroup);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
          
          // SUMMARY       
          $.ajax({
              url : "<?php echo base_url().'channelmigration3sea/list_summarycm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel + "&program=" + program+ "&profile=" + profile,
              success: function(response) {      
                  if(parseFloat(response.data.summ[0].START_TVR) > parseFloat(response.data.summ[0].END_TVR)){                                                                                                                        
                      var tvr_sl = "min";                                                                                                                                                                                                 
                                                                                                                                                                                                                                          
                      if(parseFloat(response.data.summ[0].AVG_GAIN)-parseFloat(response.data.summ[0].AVG_LOSS) < 0 ){                                                                                                                                                                                   
                          var net_all = (parseFloat(response.data.summ[0].AVG_GAIN)-parseFloat(response.data.summ[0].AVG_LOSS));                                                                                                              
                          var gain = parseFloat(response.data.summ[0].AVG_GAIN);                                                                                                                                                              
                          var lost = parseFloat(response.data.summ[0].AVG_LOSS);                                                                                                                                                              
                      }else{                                                                                                                                                                                                              
                          var net_all = ((parseFloat(response.data.summ[0].AVG_GAIN)-parseFloat(response.data.summ[0].AVG_LOSS)))*-1;                                                                                                         
                          var gain = parseFloat(response.data.summ[0].AVG_LOSS);                                                                                                                                                              
                          var lost = parseFloat(response.data.summ[0].AVG_GAIN);                                                                                                                                                              
                      }                                                                                                                                                                                                                
                  } else {                                                                                                                                                                                                             
                      var tvr_sl = "plus";                                                                                                                                                                                                
                                                                                                                                                                                                                                          
                      if(parseFloat(response.data.summ[0].AVG_GAIN)-parseFloat(response.data.summ[0].AVG_LOSS) < 0 ){                                                                                                                                                     
                          var net_all = (parseFloat(response.data.summ[0].AVG_GAIN)-parseFloat(response.data.summ[0].AVG_LOSS))*-1;                                                                                                           
                          var gain = parseFloat(response.data.summ[0].AVG_LOSS);                                                                                                                                                              
                          var lost = parseFloat(response.data.summ[0].AVG_GAIN);                                                                                                                                                              
                      } else {                                                                                                                                                                                                              
                          var net_all = ((parseFloat(response.data.summ[0].AVG_GAIN)-parseFloat(response.data.summ[0].AVG_LOSS)));                                                                                                            
                          var gain = parseFloat(response.data.summ[0].AVG_GAIN);                                                                                                                                                              
                          var lost = parseFloat(response.data.summ[0].AVG_LOSS);                                                                                                                                                              
                      }                                                                                                                                                                                                               
                  }          
                  
                  var split_program = program.split("|");
                     
					if(split_program[split_program.length - 1] == 'All Program' ){
						 $('#texted').html('<h4><strong>Summary '+channel+' - '+program.replace('`ht`','#')+'</strong></h4><h4 style="color:red"><strong>All Program '+response.data.summ[0].MINSP+' - '+response.data.summ[0].MAXSP+'</strong></h4>');
					}else{
						 $('#texted').html('<h4><strong>Summary '+channel+' - '+program.replace('`ht`','#')+'</strong></h4><h4 style="color:red"><strong>'+split_program[split_program.length - 1]+' - '+response.data.summ[0].MAXSP+'</strong></h4>');
					}
					 
                 
                  $('#summ-tvr').html('<h4 style="color: #000000;"><strong>Average TVR</strong></h4><h4 style="">'+parseFloat(response.data.summ[0].AVG_TVR).toFixed(2)+'</h4>');                                                      
                  $('#summ-gain').html('<h4 style="color: #000000;"><strong>Total Gain</strong></h4><h4 style="">'+gain+'</h4>');                                                                                                     
                  $('#summ-loss').html('<h4 style="color: #000000;"><strong>Total Loss</strong></h4><h4 style="">'+lost+'</h4>');                                                                                                     
                  $('#summ-net').html('<h4 style="color: #000000;"><strong>Total Net</strong></h4><h4 style="">'+net_all+'</h4>');                                                                                                    
                  $('#summ-beneficial').html('<h4 style="color: #000000;"><strong>Most Beneficiaries</strong></h4><h4 style="">'+response.data.summ_beneficial[0].CHANNEL+' - '+response.data.summ_beneficial[0].PROGRAM+'</h4>');       
                  $('#summ-contributor').html('<h4 style="color: #000000;"><strong>Most Contributors</strong></h4><h4 style="">'+response.data.summ_contributor[0].CHANNEL_BEFORE+' - '+response.data.summ_contributor[0].PROGRAM_BEFORE+'</h4>');
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });    
      }               
      
      function create_chart(data,st_rt,currdate,cgroup){
          var channel = $('#channel').val();
          var program = $('#programsss').val().replace('#','`ht`');
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.chartcm.length; si++){
                  col_data = data.chartcm[si].TVR;   
            
              
              tv1tgl.push(data.chartcm[si].SPLIT_MINUTES);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(2)));
          }
          
          for(var i=0; i < channel.length; i++){
              ch.push(channel[i]);
          }
		  
		  $('#texted_hh').html('<h4><strong>'+channel+'</strong></h4><h5 style="color:red"><strong>('+currdate+', '+channel+' - '+program.replace('`ht`','#')+')</strong></h5>');
          
          tgl = tv1tgl;
          
          Highcharts.chart('container', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: ''
              },
              subtitle: {
                  text: ''
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: cgroup.toUpperCase()
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
                  name: cgroup.toUpperCase(),
                  data: tv1data,
				  color: "#EF0000"
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
                      
                      $.each(data.chartcm, function() {
                          s = '<strong>Channel :</strong> ' + data.chartcm[idx].CHANNEL + '<br>' +  
                          '<strong>Program :</strong> ' + data.chartcm[idx].PROGRAM + '<br>' +
                          '<strong>TVR :</strong> ' + parseFloat(data.chartcm[idx].TVR).toFixed(2) + '<br>' +
                          '<strong>Gain :</strong> ' + data.chartcm[idx].GAIN + '<br>' +
                          '<strong>Loss :</strong> ' + data.chartcm[idx].LOSS + '<br>' +
                          '<strong>Net :</strong> ' + (parseInt(data.chartcm[idx].GAIN)-parseInt(data.chartcm[idx].LOSS)) + '<br>' +
                          '<strong>Main Contributors :</strong> ' + data.chartcm[idx].CONT_PROGRAM + '<br>' +
                          '<strong>Main Beneficiaries :</strong> ' + data.chartcm[idx].BEN_PROGRAM + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
          
          if(cgroup == 'tvr'){
              $('#tvr').prop('checked',true);
              $('#gain').prop('checked',false);
              $('#loss').prop('checked',false);
              $('#net').prop('checked',false);
          }
      }
      
      function search_channel(){
          var query = $('#search_channel').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#channel').empty('');
          
          var strVar = "";
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'channelmigration3sea/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                  $("#channel").next().next().next().empty('');
                  
                  for(i=0; i < response.length; i++){                       
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
                          strResult = response[i].CHANNEL_CIM;
                      }
                      
                      strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                  } 
                                        
                  $("#channel").next().next().next().append(strVar);   
                                    
                  $('[data-for = "channel"]').click(function() { 
                      $('#channel').next().text($(this).data("real"));
                      $('#channel').attr('value',$(this).data("real"));
                      
                      $(this).closest('.default').removeClass('active');  
                      
                      $('#programsss').next().text('Please Choose Program ...');
                      $('#programsss').next().next().html(' ');
                      
                      var chnl = $(this).data("real");
                      var datesel = $("#start_date").val();
                      var profile = $("#profile").val();
                      
                      $(".search-channel-con").remove(); 
                      
                      generate_program(chnl,datesel,profile);                        
                  }); 
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          }); 
      }
      
      function search_program(){
          var start_date = $('#start_date').val();
          var channel = $('#channel').val();
          var profile = $('#profile').val();           
          var query = $('#search_program').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#programsss').empty('');
          
          var strVar = "";
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'channelmigration3sea/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date + "&c=" + channel + "&p=" + profile,
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                  $("#programsss").next().next().next().empty('');
                  
                  for(i=0; i < response.length; i++){                            
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
                          strResult = response[i].PROGRAM;
                      }
                      
                      strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='programsss'>"+strResult+"</a></li>";                          
                  } 
                                        
                  $("#programsss").next().next().next().append(strVar);   
                                    
                  $('[data-for = "programsss"]').click(function() { 
                      $('#programsss').next().text($(this).data("real"));
                      $('#programsss').attr('value',$(this).data("real"));
                      
                      $(this).closest('.default').removeClass('active');  
                      
                      $(".search-con").remove();     
                                                        
                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                          $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                      } else {
                          $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                      }                       
                  });            
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          }); 
      }
	  
	  
	  
	  
	  function refreshtable(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
			                         console.log("SANA!");
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
								  },
                  title: 'UNICS - Channel Migration',
                  filename: 'UNICS - Channel Migration'
								}
						  ],
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
        	});
        
	  }
	  
	  function refreshtablefilter(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
			                         console.log("SONO!");
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
									   refreshtablefilter(start_date,channel, program, profile);
									}).draw();
								  },
                  title: 'UNICS - Channel Migration',
                  filename: 'UNICS - Channel Migration'
								}
						  ],                      
              "columnDefs": [
                  { "visible": false, "targets": [9,10,11,12] }                                              
              ], 
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'channelmigration3sea/list_migration'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,	
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
	  }                       
    
    function search_profile(){
        var query = $('#search_profile').val(); 
        
        $('#profile').empty('');
        
        var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'channelmigration3sea/profilesearch/'; ?>"+"?q="+query,
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