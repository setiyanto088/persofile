
  		
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
                      <li class="breadcrumb-item">Smart Profiling</li>
                      <li class="breadcrumb-item active">Smart Profile Summary</li>
                  </ol>
                  <h3 class="page-title-inner"><strong>Smart Profile Summary November 2021</strong></h3>
              </div>  
			<div class="col-md-7 text-right">
				<a href ='<?php echo base_url();?>createprofileu3' style="color:#000"><button id="button_filters" onClick="search()" class="button_white" ><em class="fa fa-arrow-left"></em> &nbsp Back</button></a>
			</div>				  
          </div>
		
          <div class="panel urate-panel urate-panel-result">
              <div class="panel-body">
			  <br>
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
   
                  <div class="tab-content" style="margin-top:60px">
                      <div role="tabpanel" class="tab-pane fade in active" id="table">
					   <div class="row">
						  <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
										<H2>Regional</h2>
											<table aria-describedby="mydesc"  id="example21" class="table table-striped">
												<thead style="color:red">
													<tr>
														<th scope="row">No.</th>
														<th scope="row">Regional</th>
														<th scope="row">Viewer</th>
														
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
						  </div>
						  <div class="col-md-6" >
						  	<div class="row" style="padding:10px">
									<div class="col-lg-12" >
							<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Witel</h2>
                                <table aria-describedby="mydesc"  id="example22" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Witel</th>
                                            <th scope="row">Viewer</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
							</div>
								</div>
						  </div>
					</div>

					  <div class="row">
						 <div class="col-md-6" >
							<div class="row" style="padding:10px">
								<div class="col-lg-12" >
									<div class="result-tables urate-panel" style="padding:10px" >
							  <H2>Province</h2>
									<table aria-describedby="mydesc"  id="example" class="table table-striped ">
										<thead style="color:red">
											<tr>
												<th scope="row">No.</th>
												<th scope="row">Province</th>
												<th scope="row">Viewer</th>
												
											</tr>
										</thead>
									</table>
								</div>
						  </div>
						  </div>
						  </div>
							<div class="col-md-6" >
							<div class="row" style="padding:10px">
								<div class="col-lg-12" >
									<div class="result-tables urate-panel" style="padding:10px" >
									<H2>City</h2>
										<table aria-describedby="mydesc"  id="example1" class="table table-striped ">
											<thead style="color:red">
												<tr>
													<th scope="row">No.</th>
													<th scope="row">City</th>
													<th scope="row">Viewer</th>
													
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
							</div>
					</div>
					 <div class="row">
							<div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
										<H2>Helix Comm</h2>
											<table aria-describedby="mydesc"  id="example2" class="table table-striped ">
												<thead style="color:red">
													<tr>
														<th scope="row">No.</th>
														<th scope="row">Helix Comm</th>
														<th scope="row">Viewers</th>
														
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
						  
						  <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Personas</h2>
                                <table aria-describedby="mydesc"  id="example3" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Personas</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div>  
						  </div>
						  </div>
					</div>
					 <div class="row">
						  <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Gender</h2>
                                <table aria-describedby="mydesc"  id="example4" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Gender</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div>
						  </div>
						  </div>
						  
						   <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Age Group</h2>
                                <table aria-describedby="mydesc"  id="example5" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Age Group</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div>
						  </div>
						  </div>
					</div>
					 <div class="row">
						   <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Digital Segment</h2>
                                <table aria-describedby="mydesc"  id="example6" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Digital Segment</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div> 
						  </div>
						  </div>
						  
						<div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Household Profile</h2>
                                <table aria-describedby="mydesc"  id="example8" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Household Pofile</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div>
						  </div>
						  </div>
						  					</div>
					 <div class="row">
						 <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Household Comm Expense</h2>
                                <table aria-describedby="mydesc"  id="example9" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Household Comm Expense</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div> 
						  </div>
						  </div>
						  
						 <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Ses Segment</h2>
                                <table aria-describedby="mydesc"  id="example10" class="table table-striped">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Ses Segment</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div>
						  </div> 
						  </div>
						  </div>
						  
						   <div class="row">
						  
						 <div class="col-md-6">
								<div class="row" style="padding:10px">
									<div class="col-lg-12" >
										<div class="result-tables urate-panel" style="padding:10px" >
							<H2>Web Interest</h2>
                                <table aria-describedby="mydesc"  id="example11" class="table table-striped ">
                                    <thead style="color:red">
                                        <tr>
                                            <th scope="row">No.</th>
                                            <th scope="row">Web Interest</th>
                                            <th scope="row">Viewers</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                            </div>
						  </div>
						  </div>
						  </div>
						  </div>
					 
					  </div>
                            
                     
                        <div role="tabpanel" class="tab-pane fade" id="chart">   
                           
                                                                
                          <div class="row">
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px">     
									<div class="result-table urate-panel" style="padding:20px">							
										<div id="container21" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px">     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container22" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px">     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container1" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container2" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container3" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container4" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container5" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container6" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container8" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container9" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container10" style="width: 900px;"></div>
									</div>
								</div>
								
								<div class="col-md-12" style="margin-bottom:10px;padding:20px" >     
									<div class="result-table urate-panel" style="padding:10px">							
										<div id="container11" style="width: 900px;"></div>
									</div>
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
     
  <!-- Highcharts -->
	<script src="<?php echo $path5;?>plugins/highcharts/highcharts.js"></script>
  
  <script language="javascript">
      $(document).ready(function(){      
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
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
          
        
          
          $('#custom_channel').click(function() {   
              $(".search-channel-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);   
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          });  
		  
		  
		  search();
      });
      
      $(document).ready(function(){
        
          $("#custom_programsss").on("click",function(){  
              $(".search-channel-con").remove();
              $("#custom_channel").parent().removeClass('active');
          });
          
          $('#custom_channel').click(function() {   
              $("#custom_programsss").parent().removeClass('active');
              $(".search-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeypress='search_channel()' paceholder='Search Channel'></div>";
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();     
                  $("#custom_channel").after(searchElement);     
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
                  
              $("[data-id='channel']").click(function(){    	     
                
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
          
          $("#custom_programsss").on("click",function(){
              $("#custom_channel").parent().removeClass('active');
          }); 
      });   
          
      function generate_program (channel, sdate, sprofile){
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
                  
          $('#programsss').empty('');
          
          var form_data = {			
              valselect : channel,
              dateselect : sdate
          };                                                                                                    
          var strVar = ""; 
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'audienceresume/list_program/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
              data	: JSON.stringify(form_data),			
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                   if(response.data != undefined){    
                      $('#custom_programsss').hide();
                      $('#loader2').fadeIn(500).delay(1500).fadeOut(500);
                      $('#custom_programsss').delay(3000).fadeIn(500);
              
                      var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid;' class='search-con'><input type='text' name='search_program' id='search_program' class='form-control urate-form-input' value='' onkeypress='search_program()' paceholder='Search Program'></div>";
                      
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
                       
    				   strVar += "<li><a href='javascript:void(0)' data-real='ALL,ALL' class='urate-select-form-two' data-for='programsss'>ALL</a></li>"
    				   
                      for(i=0; i < response.data.length; i++){
                          strVar += "<li><a href='javascript:void(0)' data-real='"+response.data[i].PROGRAM+","+response.data[i].START_PROGRAM+"' class='urate-select-form-two' data-for='programsss'>"+response.data[i].PROGRAM+" - "+response.data[i].START_PROGRAM+"</a></li>";                          
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
                  } else {
					  strVar += "<li><a href='javascript:void(0)' data-real='ALL,ALL' class='urate-select-form-two' data-for='programsss'>ALL</a></li>"
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
                  }                             
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          });     
      }
      
      function search(){                                    
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $('[data-for="programsss"]').parent().parent().removeClass("active");  
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          var profile = $('#profile').val();
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");                 
          
          var colgroup = "tvr";
          
          var orderingnya = '0';	
          var by = '';	
          
          $('input.toggle-vis').attr('disabled','disabled');
          
       
          
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
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
																					return data.replace('.', '');
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Province' 
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter1(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false
             
              ,"fnPreDrawCallback":function(){
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
              },
              "fnInitComplete":function(){
                  $('#processButton').delay(1000).fadeIn();
                  $("#loader").hide();
                  $('.loader').css('display','none');
                  $('#processButton').show();
              }
          });
          
          table.ajax.reload();


                var table21 = $("#example21").DataTable({
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
																					return data.replace('.', '');
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - City'
									     };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter2(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_reg'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
			   "scrollX": false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table21.ajax.reload();

var table22 = $("#example22").DataTable({
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
																					return data.replace('.', '');
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - City'
									     };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter2(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_witel'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table22.ajax.reload();

                var table2 = $("#example1").DataTable({
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
																					return data.replace('.', '');
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - City'
									     };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter2(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_city'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table2.ajax.reload();
		  
		  
		    var table3 = $("#example2").DataTable({
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
																				   var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Helix Comm' 
									    };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter3(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_comm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table3.ajax.reload();
		  
		  
		    var table4 = $("#example3").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Personas'
									  	 };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter4(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_persona'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table4.ajax.reload();
		  
		      var table5 = $("#example4").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Gender'
										  };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter5(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_gender'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table5.ajax.reload();
		  
		      var table6 = $("#example5").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Age Group'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter6(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_age'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table6.ajax.reload();
		  
    var table7 = $("#example6").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Digital Segment'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter7(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_digi'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table7.ajax.reload();
		  
		      var table8 = $("#example8").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Household Profile'
										 };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter8(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_house'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table8.ajax.reload();
		  
		  var table9 = $("#example9").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Household Comm Expense'
										  };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter9(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_arpu'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table9.ajax.reload();
		  
		   var table10 = $("#example10").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Ses Segment'
									  };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter10(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_ses'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table10.ajax.reload();
		  
		  	var table11 = $("#example11").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Web Interest' };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter11(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_web'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table11.ajax.reload();
		  

		  
		   $.ajax({
              
              url : "<?php echo base_url().'audienceresume/list_chart_audience_witel'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                 
                  create_chart_witel(response.data);
                
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		   $.ajax({
             
              url : "<?php echo base_url().'audienceresume/list_chart_audience_reg'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                
                  create_chart_reg(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  
          $.ajax({
           
              url : "<?php echo base_url().'audienceresume/list_chart_audience'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                 
                  create_chart(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		      $.ajax({
            
              url : "<?php echo base_url().'audienceresume/list_chart_audience_city'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
               
                  create_chart_city(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  $.ajax({
            
              url : "<?php echo base_url().'audienceresume/list_chart_audience_comm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                
                  create_chart_comm(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  $.ajax({
            
              url : "<?php echo base_url().'audienceresume/list_chart_audience_personas'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
               
                  create_chart_personas(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  
		   $.ajax({
               
              url : "<?php echo base_url().'audienceresume/list_chart_audience_gender'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                
                  create_chart_gender(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  		   $.ajax({
            
              url : "<?php echo base_url().'audienceresume/list_chart_audience_age'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
               
                  create_chart_age(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  		  		   $.ajax({
              
              url : "<?php echo base_url().'audienceresume/list_chart_audience_digi'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
              
                  create_chart_digi(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  		  		  		   $.ajax({
            
              url : "<?php echo base_url().'audienceresume/list_chart_audience_house'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
               
                  create_chart_house(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
          
		  
		  		  		  		   $.ajax({
             
              url : "<?php echo base_url().'audienceresume/list_chart_audience_arpu'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                  
                  create_chart_arpu(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  		  		  		  		   $.ajax({
           
              url : "<?php echo base_url().'audienceresume/list_chart_audience_ses'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
                 
                  create_chart_ses(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });
		  
		  		  		  		  		  		   $.ajax({
             
              url : "<?php echo base_url().'audienceresume/list_chart_audience_web'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date  + "&channel=" + channel + "&program=" + program + "&cgroup=" + colgroup,
              success: function(response) {
               
                  create_chart_web(response.data);
              },
              error: function(obj, response) {
                  console.log('ajax list_project error:' + response);
              }
          });

      }             



  	    function create_chart_web(data){
		  
		 
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container11', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: "<strong>Top Web Interest Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Web Interest :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }

	  	    function create_chart_ses(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container10', {
              chart: {
                  type: 'column'
              },
              title: {
                   text: "<strong>Top Ses Segment Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Ses Segment :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  

	  
	  	    function create_chart_arpu(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container9', {
              chart: {
                  type: 'column'
              },
              title: {
                   text: "<strong>Top Household Comm Expense Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Household Comm Expense :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	  

	  	    function create_chart_house(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container8', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: "<strong>Top Household Profile Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Household Profile :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	  	    function create_chart_digi(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container6', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: "<strong>Top Digital Segment Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Digital Segment :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	  	    function create_chart_age(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container5', {
              chart: {
                  type: 'column'
              },
              title: {
                    text: "<strong>Top Age Group Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Age Group :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	    function create_chart_gender(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container4', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: "<strong>Top Gender Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Gender :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	  function create_chart_personas(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container3', {
              chart: {
                  type: 'column'
              },
              title: {
                  text: "<strong>Top Personas Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Personas :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	  function create_chart_comm(data){
		  
          var channel = $('#channel').val();
          var program = $('#programsss').val();
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container2', {
              chart: {
                  type: 'column'
              },
              title: {
                   text: "<strong>Top Helix Comm Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Helix Comm :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }

function create_chart_sto(data){
		  
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container24', {
              chart: {
                  type: 'column'
              },
              title: {
				    text: "<strong>Top STO Viewers</strong>",
				   align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>STO :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }

function create_chart_datel(data){
		  
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container23', {
              chart: {
                  type: 'column'
              },
              title: {
				    text: "<strong>Top Datel Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Datel :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
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

function create_chart_witel(data){
		  
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container22', {
              chart: {
                  type: 'column'
              },
              title: {
				    text: "<strong>Top Witel Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Witel :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	
	function create_chart_reg(data){
		  
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push('0'+data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container21', {
              chart: {
                  type: 'column'
              },
              title: {
				   text: "<strong>Top Regional Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Regional :</strong> 0' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
	function create_chart_city(data){
		  
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

             col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container1', {
              chart: {
                  type: 'column'
              },
              title: {
				   text: "<strong>Top City Viewers</strong>",
				  align: 'left'
				  
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>City :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
	  
      function create_chart(data){
		  
         
          var ch = [];
          var tgl;
          var tv1tgl = [];
          var tv1data = [];    
          
          for(var si=0; si < data.length; si++){

              col_data = data[si][2]; 

              tv1tgl.push(data[si][1]);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
          }
          

          
          tgl = tv1tgl;
          
          Highcharts.chart('container', {
              chart: {
                  type: 'column'
              },
              title: {
				   text: "<strong>Top Province Viewers</strong>",
				  align: 'left'
              },
              subtitle: {
                  text: ""
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: ''
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
                  name: "Viewers",
                  data: tv1data,
				  color: "#FF0000"
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
                          '<strong>Province :</strong> ' + data[idx][1] + '<br>' +
                          '<strong>Viewers :</strong> ' + parseFloat(data[idx][2]).toFixed(0) + '<br>';
                      });
                      
                      return s;
                  }
              }
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	     
        
      }
      
      function search_program(){
          var start_date = $('#start_date').val();
          var channel = $('#channel').val();
          var query = $('#search_program').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#programsss').empty('');
          
          var strVar = "";
          
          $.ajax({
              type	: "POST",
            url		: "<?php echo base_url().'audienceresume/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date + "&c=" + channel,
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                  $("#programsss").next().next().next().empty('');
                  
                  for(i=0; i < response.length; i++){                   
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
                          strResult = response[i].PROGRAM;
						  strResult2 = response[i].START_TIME;
                      }
                      
                      strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+","+strResult2+"' class='urate-select-form-two' data-for='programsss'>"+strResult+" "+strResult2+"</a></li>";                          
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
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable();
									}).draw();
								  }
								}
						  ],
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
        	});
        
	  }
	  
	  function refreshtablefilter1(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
         
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
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Province' 
									    };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter1(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table.ajax.reload();
	  }
	  function refreshtablefilter2(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
             var table2 = $("#example1").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - City'
									     };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter2(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_city'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table2.ajax.reload();
		  
          
	  }
	  function refreshtablefilter3(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		  
		    var table3 = $("#example2").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Helix Comm' 
									    };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter3(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_comm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table3.ajax.reload();
		  
		  
          
	  }
	  function refreshtablefilter4(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
         
		    var table4 = $("#example3").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Personas'
									  	 };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter4(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_persona'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table4.ajax.reload();
		  
          
	  }
	  function refreshtablefilter5(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		      var table5 = $("#example4").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Gender'
										  };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter5(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_gender'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table5.ajax.reload();
		  
          
	  }
	  function refreshtablefilter6(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
		      var table6 = $("#example5").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Age Group'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter6(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_age'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table6.ajax.reload();
		  
          
	  }
	  function refreshtablefilter7(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
    var table7 = $("#example6").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Digital Segment'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter7(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_digi'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table7.ajax.reload();
		  
          
	  }
	  function refreshtablefilter8(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
		      var table8 = $("#example8").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Household Profile'
										 };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter8(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_house'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table8.ajax.reload();
		  
          
	  }
	  function refreshtablefilter9(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
		  var table9 = $("#example9").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Household Comm Expense'
										   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter9(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_arpu'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table9.ajax.reload();
		  
          
	  }
	  function refreshtablefilter10(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		   var table10 = $("#example10").DataTable({
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
																					  var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Ses Segment'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter10(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_ses'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table10.ajax.reload();
		  
          
	  }
	  function refreshtablefilter11(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		  	var table11 = $("#example11").DataTable({
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
																					 var data1 = data.replace('.', '');
																				   var data2 = data1.replace('.', '');
																				   var data3 = data2.replace('.', '');
																					return data3;
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Web Interest' };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter11(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'audienceresume/list_audience_web'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table11.ajax.reload();
		  
          
	  }
    
    
    function search_channel(){
         var start_date = $('#start_date').val();
        var profile = $('#profile').val();
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'channelmigration3/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date + "&p=" + profile,
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
                    
                    strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#channel").next().next().next().append(strVar);   
                                
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
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
  </script>