 
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
	
		.dataTable{
    table-layout: fixed;
    width: 100%;            
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
                      <li class="breadcrumb-item active">Channel Evaluation</li>
                  </ol>
                  <h3 class="page-title-inner"><strong>Channel Evaluation<strong></h3>
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
							
							<label>Periode</label>
							  <div class="form-group">
								  <select class='form-control urate-select' name="profile" id="profile" title='Choose Periode ...'>
									 
									  <?php 
										foreach($thn as $periode){
									
										echo "<option value=".$periode['TANGGAL']." >".$periode['TANGGAL']."</option>";

									}
									  ?>
								  </select>
							  </div>                                    
					  
						</div>
					  </div>
                      <!-- END PROFILE FIELD -->
                     
                  </div>
              </div>
          </div>
		  
		   <div class="panel2" id="panel-blank" >
		
			<img alt="img" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
		  
		  </div>
          <div class="panel urate-panel urate-panel-results" style="display:none">
            <div class="panel-headings">
                   <div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode2" style="font-weight: bold;">Result</h4>
					</div>
					 <div class="navbar-right" style="padding-right:20px;padding-top:10px;">
						
					</div>
				</div>
              </div>
              <div class="panel-body">
                  <!-- Nav tabs -->
                  <!-- / Nav tabs -->
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="table">
                            <div class="result-table">
                                <table aria-describedby="mydesc"  id="example" style="border:none;" class="table table-striped">
                                    <thead style="color:red">
                                        <tr style="color:red">
                                            <th style="border:none;color:red" scope="row">Channel Name</th>
                                            <th style="border:none;color:red" scope="row">Channel No</th>
                                            <th style="border:none;color:red" scope="row">Quality</th>
                                            <th style="border:none;color:red" scope="row">Rank</th>
                                            <th style="border:none;color:red" scope="row">Rank Growth</th>
                                            <th style="border:none;color:red" scope="row">Traffic UV</th>
                                            <th style="border:none;color:red" scope="row">Unique Viewer</th>
                                            <th style="border:none;color:red" scope="row">Viewers Share</th>
                                            <th style="border:none;color:red" scope="row">Share Growth</th>
                                            <th style="border:none;color:red" scope="row">Traffic TV</th>
                                            <th style="border:none;color:red" scope="row">Total Viewers</th>
                                            <th style="border:none;color:red" scope="row">Total Duration</th>
                                            <th style="border:none;color:red" scope="row">AVG Hours</th>
											<th style="border:none;color:red" scope="row">Packages</th>
                                            <th style="border:none;color:red" scope="row">Category</th>
                                            <th style="border:none;color:red" scope="row">Genre</th>
											<th style="border:none;color:red" scope="row">Region</th>                                                                                                                                                                                
                                        </tr style="color:red">
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="chart">
                         
                                                                
                            <div id="container" style="width: 900px; height: 400px; margin: 0 auto"></div>
                            
                            <div class="col-lg-12">
          
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
              
           
              var strVar = "";              
                                          
             
          });
          
             
          $("#start_date").on("change",function(){
              $('#profile').empty('');
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'channelevaluation/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeypress='search_channel()' paceholder='Search Channel'></div>"; 
              
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
          
          var form_data = {			
              valselect : channel,
              dateselect : sdate,
              profile : prof
          };                                                                                                    
          var strVar = "";
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'channelevaluation/list_program/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
              data	: JSON.stringify(form_data),			
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) { 
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
      
      function search(){
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $('[data-for="programsss"]').parent().parent().removeClass("active");
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var profile = $('#profile').val();
        
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");                 
          
          var colgroup = "tvr";
          
          var orderingnya = '0';	
          var by = '';	
          
          $('input.toggle-vis').attr('disabled','disabled');
                          
          
          if(profile === null || profile === ''){ 
        			alert('Please, Select Periode');
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
									   refreshtablefilter( profile);
									}).draw();
								  },
                  filename: 'UNICS - Channel Evaluation'+ start_date
								}
						  ],      
                                     
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'channelevaluation/list_migration'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false
              /*,"drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              },*/
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
          
          tgl = tv1tgl;
          
          Highcharts.chart('container', {
              chart: {
                  type: 'line'
              },
              title: {
                  text: channel
              },
              subtitle: {
                  text: '('+currdate+', '+channel+' - '+program.replace('`ht`','#')+')'
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
              url		: "<?php echo base_url().'channelevaluation/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
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
              url		: "<?php echo base_url().'channelevaluation/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date + "&c=" + channel + "&p=" + profile,
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
									  var start_date = $('#start_date').val();
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
                  filename: 'UNICS - Channel Evaluation'+ start_date
								}
						  ],
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
        	});
        
	  }
	  
	  function refreshtablefilter(profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var start_date = $('#start_date').val();
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
									   refreshtablefilter( profile);
									}).draw();
								  },
                  filename: 'UNICS - Channel Evaluation'+ start_date
								}
						  ],                      
             
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'channelevaluation/list_migration'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
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
    
  
  </script>