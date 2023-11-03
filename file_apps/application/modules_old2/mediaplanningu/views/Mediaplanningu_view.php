 
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
      
      .dt-buttons{
          height: 40px;
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
          top: 15px;
      }
	</style>
  <link href="<?php echo $path;?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?php echo $path;?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet">	
<link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	

<style>
.jstree-themeicon{
	 display: none !important;
}

    
    
    .dropdown-menu{
        margin-top: 0px !important;
    }
</style>
<script>
$(function () {	
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD/MM/YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });	
});
	
</script>

	<div class="content-wrapper">
      <div class="container-fluid">      
          <div class="row">
              <div class="col-md-6">                    
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">Free to Air</li>
                      <li class="breadcrumb-item active">Media Planning</li>
                  </ol>
                  <h3 class="page-title-inner">Media Planning</h3>
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
                              <input type="text" class="form-control urate-form-input" name="start_date" id="start_date" value="" placeholder="From ..." />
                              <div class="input-group-addon">-</div>
                              <input type="text" class="form-control urate-form-input" name="end_date" id="end_date" value="" placeholder="To ..." />
                          </div>
                      </div>  
                      <!-- END PERIODE FIELD -->
                      <!-- PROFILE FIELD -->       
                      <div class="dataset col-md-4" style="z-index: 999;">
                          <div class="dataset-title">
                              <h4 class="title-text">Profile</h4>
                          </div>
                          <div class="select-wrapper">
                              <select class='urate-select' name="profile" id="profile" title='Please Choose Profile ...'>
                                  <option value="0" >All People</option>
                                  <?php foreach($profile as $key) { ?>
                                  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>                                    
                      </div>
                      <!-- END PROFILE FIELD -->
                      <!-- CHANNEL FIELD -->       
                      <div class="dataset col-md-4" style="z-index: 999;">
                          <div class="dataset-title">
                              <h4 class="title-text">TV Channel</h4>
                          </div>
                          <div class="select-wrapper">
                              <select class='urate-select grid-menu' name="channel" id="channel" title='Please Choose Channel ...'>
                                  <option value="0" >All Channel</option>  
          												<?php 
          													foreach($channels as $nhb){
                                        echo "<option value='".$nhb['CHANNEL_CIM']."' >".$nhb['CHANNEL_CIM']."</option>";
          													}
          												?>
                              </select>
                          </div>                                    
                      </div>
                      <!-- END CHANNEL FIELD -->    
                      <!-- OBJECTIVE FIELD -->
                      <div class="dataset col-md-4" style="position: absolute;top: 255px;width: 352px;">
                          <div class="dataset-title">
                              <h4 class="title-text">Objective</h4>
                          </div>
                          <div class="select-wrapper">
                              <select class='urate-select' name="setting" id="setting" title='Please Choose Objective ...'>
                                  <option value="high_tvr" >High TVR</option>
                                  <option value="maximum_cost" >Maximum Spot</option>
                                  <option value="minimum_cprp" >Minimum CPRP</option>
                                  <option value="index" >High Index</option>
                                  <option value="minimum_cprp" >Maximum GRP</option>
                              </select>
                          </div>
                      </div>
                      <!-- END OBJECTIVE FIELD -->     
                      <!-- COST FIELD -->
                      <div class="dataset col-md-4" style="position: absolute;top: 255px;width: 352px;left: 375px;">
                          <div class="dataset-title">
                              <h4 class="title-text">Cost</h4>
                          </div>
                          <div class="select-wrapper">
                              <input type="text" class="form-input urate-form-input rupiah" id="cost" placeholder="Please Submit Cost ..." value="1000000000">
                          </div>
                      </div>
					  
					   <div class="dataset col-md-4" style="position: absolute;top: 255px;width: 352px;left: 725px;">
                          <div class="dataset-title">
                              <h4 class="title-text">Discount</h4>
                          </div>
                          <div class="select-wrapper">
                              <select class='urate-select' name="discount" id="discount" title='Please Choose discount ...'>
								<?php for($i = 0;$i<15;$i++){ ?>
                                  <option value="<?php echo $i*5; ?>" ><?php echo $i*5; ?> %</option>
								<?php } ?>  
                               </select>
                          </div>
                      </div>
                      <!-- END COST FIELD -->
                      <!-- PROCESS BUTTON -->
                      <div class="col-md-12 text-center" style="top: 365px;position: absolute;width: 96%;">
                          <br />
                          <div class="btn-loader">
                              <button class="btn urate-outline-btn btn-lg" id="processButton" onclick="search()">Process</button>
                              <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader">
                          </div>
                      </div>
                      <!-- END PROCESS BUTTON -->
                  </div>
              </div>
          </div>
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
                          <a href="#chart" aria-controls="summary" role="tab" data-toggle="tab">Summary</a>
                      </li>
                  </ul>
                  <!-- / Nav tabs  alt="arrow"  -->
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="table">
                            <div class="result-table">
                                <table aria-describedby="mydesc"  id="myTable" class="table table-striped table-bordered example urate-table" aria-describedby="Table Process">  
  							                    <thead>
                                    <tr>
                                        <th align="center" scope="row">Tanggal</th>
                                        <th align="center" scope="row">Channel</th>
                                        <th align="center" scope="row">Program</th>
                                        <th align="center" scope="row">TVR</th>
                                        <th align="center" scope="row">Share</th>
                                        <th align="center" scope="row">CPRP</th>
                                        <th align="center" scope="row">Cost</th>
                                        <th align="center" scope="row">Index</th>
                                    </tr>
                                    </thead>             
                                </table>   
                            </div>
                            
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="chart">
                            <div class="result-summary">
                                <div class="summary-panel">
                                    <div id="texted"></div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div id="spoted"></div>
                                            <br><br>
                                            <div id="costed"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="tvred"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="maxtvr"></div>
                                            <br><br>
                                            <div id="mintvr"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="avgtvr"></div>
                                            <br><br>
                                            <div id="cprp1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="summary-table">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Summary Program</h4>
                                            <table aria-describedby="mydesc"  id="example1" class="table table-striped table-bordered example">
                                                <thead>
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
                                        <div class="col-md-6">
                                            <h4>Summary Channel</h4>
                                            <table aria-describedby="mydesc"  id="example2" class="table table-striped table-bordered example">
                                                <thead>
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
                  </div>
              </div>
          </div>
      </div>
  </div>                                    
  
  <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>    
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  
  <script language="javascript">
      $(document).ready(function(){              
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                   endDate: '0d',
                  defaultDate: new Date()
              });               
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY'));  
          });
          
          $('.rupiah').priceFormat({
          		prefix: 'Rp ',
          		centsSeparator: '',
          		centsLimit: 0,
          		thousandsSeparator: '.'
        	});	
                                
          var table = $("#myTable").DataTable({  
						 dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
										
										var table = $('#myTable').DataTable();
										var info = table.page.info();
										 
 
									  data.length = info.recordsDisplay ;
 									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable();
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ],       
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
        	});
        
        	var table = $("#example1").DataTable({
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
                  title: 'UNICS - Media Planning Summary Program',
                  filename: 'UNICS - Media Planning Summary Program'
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
        	});
        
        	var table = $("#example2").DataTable({
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
                  title: 'UNICS - Media Planning Summary Channel',
                  filename: 'UNICS - Media Planning Summary Channel'
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
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
          
          $('#custom_channel').click(function() {   
              $(".search-channel-con").remove();
              
              var currChecked = $("#channel").val();
              
              if(currChecked != ""){
                  $("[data-real='"+currChecked+"']").parent().addClass('checked');
              }
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);       
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          });
          
          $('[data-id="setting"]').click(function() {
              $('.urate-select-dropdown').each(function(){
                  $(this).removeClass('active');
                  $(".search-channel-con").remove();        
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
                  url		: "<?php echo base_url().'mediaplanningu/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                  url		: "<?php echo base_url().'mediaplanningu/setprofile/'; ?>"+"?f="+$('#start_date').val(),
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
                 
      function search(){                  
        $('[data-for="channel"]').parent().parent().removeClass("active");
        $('[data-for="profile"]').parent().parent().removeClass("active");
        $('[data-for="setting"]').parent().parent().removeClass("active");   
        $(".search-channel-con").remove();
          
      	var start_date = $('#start_date').val();
      	var end_date = $('#end_date').val();
      	var profile = $('#profile').val();
        var setting = $('#setting').val();
      	var cost = $('#cost').unmask();     
        var channel = $('#channel').val();  
        var discount = $('#discount').val();  
		
        
      	var user_id = $.cookie(window.cookie_prefix + "user_id");
      	var token = $.cookie(window.cookie_prefix + "token");
      	var high_tvr = '0';	
      	var maximum_cost = '0';	
      	var minimum_cprp = '0';	
      	var index = '0';
      	var orderingnya = '0';	
      	var by = '';	
        var ch = [];                            
          
        if(profile === null || profile === ''){  
      			alert('Please, Select Profile');
      			return false;
      	} 	
      	
      	if(channel === null || channel === ''){  
      			alert('Please, Select Channel');
      			return false;
      	} 	
      	
      	if(setting === null || setting === ''){  
      			alert('Please, Select Objective');
      			return false;
      	}
      	
      	if (setting == "high_tvr") {  
      		high_tvr = '1'; 
      		orderingnya = '4';	
      		by = 'DESC';	
      	}
      	
      	if (setting == "maximum_cost") {  
      		maximum_cost = '1'; 
      		orderingnya = '5';	
      		by = 'ASC';	
      	}
      
      	if (setting == "minimum_cprp") {  
      		minimum_cprp = '1';
      		orderingnya = '6';	
      		by = 'ASC';			
      	}
      	
      	if (setting == "index") {  
      		index  = '1';
      		orderingnya = '4';	
      		by = 'DESC';			
      	}
      	
      	if(start_date === ''){  
      		alert('Please, Select Start Date');
      		return false;
      	}	
      	
      	if(end_date === ''){  
      		alert('Please, Select End Date');
      		return false;
      	}	
      	
      	if(cost === ''){  
      		alert('Please, Input Cost');
      		return false;
      	}		
        
        /* HANDLE ALL CHANNEL */         
        if(channel == "0"){
            channel = '<?php foreach($channels as $nhb) { echo $nhb['CHANNEL_CIM'] . ","; } ?>';
            
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
      	                           
        var dtcounter = 0;                                   
        var table = $("#myTable").DataTable({ 
			  dom: 'Bfrtip',
			  'buttons': [
				  {
					  text: 'Export Excel',
					  action: function (e, dt, button, config)
					  {
						dt.one('preXhr', function (e, s, data)
						{
							
							var table = $('#myTable').DataTable();
							var info = table.page.info();
							 
						 

						  data.length = info.recordsDisplay ;
						}).one('draw', function (e, settings, json, xhr)
						{
						  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
						  var addOptions = { exportOptions: { 'columns': ':visible'} };
					 
						  $.extend(true, excelButtonConfig, addOptions);
						  excelButtonConfig.action(e, dt, button, excelButtonConfig);
						   refreshtablefilter(start_date,end_date,profile,cost,high_tvr,maximum_cost,minimum_cprp,index,ch,orderingnya,by);
						}).draw();
					  },
            title: 'UNICS - Media Planning',
            filename: 'UNICS - Media Planning'
					}
			  ],
      		"processing": true,
      		"serverSide": true,
      		"destroy": true,			
      		"ajax": "<?php echo base_url().'mediaplanningu/list_planning'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost + "&discount=" + discount+ "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + ch,
      		"searchDelay": 700,
      		"bFilter" : false,		
      		 "order": [[ orderingnya, by]],
      		"orderable": true,
      		"bInfo" : false,
      		"bLengthChange": false,  
          "fnPreDrawCallback":function(){
              $('.urate-panel-result').show();
              $('#processButton').hide();
              $('#loader').show();
          },
          "fnDrawCallback":function(){
              $("#loader").hide();
              $('.loader').css('display','none');
              $('#processButton').show();
          },
          "fnInitComplete":function(){
             
                
              do_datatable_2();                    
          },         
      	});
      	
      	table.ajax.reload();                                   
      	
      	var x = document.getElementsByClassName("buttons-excel");
        
        if (x.length > 0)
        {
            x = x[0];
        }
        
      	var excelButton = $(".buttons-excel").detach();
        $(".buttonExcel").show();
      	$(".buttonExcel").append( excelButton );   
        
        function do_datatable_2(){
          	var table1 = $("#example1").DataTable({   
			 dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  title: 'Media Planning - Summary Channel',
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
									   do_datatable_2();
									}).draw();
								  }
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
          		"ordering": false,		
          		"processing": true,
          		"serverSide": true,
          		destroy: true,
          		"ajax": "<?php echo base_url().'mediaplanningu/list_planning_sub'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost + "&discount=" + discount+ "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + channel,
          		"searchDelay": 700,
          		"bFilter" : false,
          		"bInfo" : false,
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
                
                  
                  do_datatable_3();    
              },         
          	});
          	
          	table1.ajax.reload();    
        }          
                  
        function do_datatable_3(){                  
          	var table2 = $("#example2").DataTable({
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
									   do_datatable_3();
									}).draw();
								  },
                  title: 'Media Planning - Summary Channel',
                  filename: 'Media Planning - Summary Channel'
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
          		"ordering": false,
          		"processing": true,
          		"serverSide": true,
          		destroy: true,
          		"ajax": "<?php echo base_url().'mediaplanningu/list_planning_total'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost + "&discount=" + discount+ "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + channel,
          		"searchDelay": 700,
          		"bFilter" : false,
          		"bInfo" : false,
          		"iDisplayLength": 100,
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
          	
          	table2.ajax.reload();	 
        }
        
      		$.ajax({
      			url : "<?php echo base_url().'mediaplanningu/list_planning_grandtotal'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost + "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + channel,
      			success: function(response) {
      				if (response.success) {
      						$("#texted").html("<h3>Grand Total</h3>");
      						$("#spoted").html("<div class='grandItemTit'>Total Spot</div><div class='grandItemCon'>" + response.data.spot + "</div>");
      						$("#costed").html("<div class='grandItemTit'>Total Cost</div><div class='grandItemCon'>" + response.data.cost + "</div>");
      						$("#tvred").html("<div class='grandItemTit'>Total TVR</div><div class='grandItemCon'>" +response.data.tvr + "</div>");
      					} else {
      						
      					}
      			},
      				error: function(obj, response) {
      					console.log('ajax list_project error:' + response);
      			}					
      		});	
          
      		$.ajax({
      			url : "<?php echo base_url().'mediaplanningu/list_planning_rest'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost + "&discount=" + discount+ "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + channel,
      			success: function(response) {
      				if (response.success) {
      						$("#maxtvr").html("<div class='grandItemTit'>Max TVR</div><div class='grandItemCon'>" + response.data.maxtvr + "</div>");
      						$("#mintvr").html("<div class='grandItemTit'>Min TVR</div><div class='grandItemCon'>" + response.data.mintvr + "</div>");
      						$("#avgtvr").html("<div class='grandItemTit'>Avg TVR</div><div class='grandItemCon'>" + response.data.avgtvr + "</div>");
      						$("#cprp1").html("<div class='grandItemTit'>CPRP</div><div class='grandItemCon'>" + response.data.cprp1 + "</div>");
      					} else {
      						
      					}
      			},
      				error: function(obj, response) {
      					console.log('ajax list_project error:' + response);
      			}					
      		});         
      }
      
      function refreshtable1(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         var table1 = $("#example1").DataTable({   
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
									   refreshtable1();
									}).draw();
								  },
                  title: 'UNICS - Media Planning Summary Channel',
                  filename: 'UNICS - Media Planning Summary Channel'
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
          		"ordering": false,		
          		"processing": true,
          		"serverSide": true,
          		destroy: true,
          		"ajax": "<?php echo base_url().'mediaplanningu/list_planning_sub'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost+ "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + channel,
          		"searchDelay": 700,
          		"bFilter" : false,
          		"bInfo" : false,
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
                  
              },         
          	});
          	
          	table1.ajax.reload();    
	  }
      function refreshtable2(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         	var table2 = $("#example2").DataTable({
				 dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  title: 'Media Planning - Summary Channel',
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
									   refreshtable2();
									}).draw();
								  }
                  
								}
						  ], 
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
          		"ordering": false,
          		"processing": true,
          		"serverSide": true,
          		destroy: true,
          		"ajax": "<?php echo base_url().'mediaplanningu/list_planning_total'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost+ "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + channel,
          		"searchDelay": 700,
          		"bFilter" : false,
          		"bInfo" : false,
          		"iDisplayLength": 100,
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
          	
          	table2.ajax.reload();	
	  }
      function refreshtable(){
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
									 var table = $('#myTable').DataTable();
										var info = table.page.info();
										 
									 

									  data.length = info.recordsDisplay ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible'} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable();
									}).draw();
								  },
                  title: 'UNICS - Media Planning',
                  filename: 'UNICS - Media Planning'
								}
						  ],
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
        	});
        
	  }
	  
	  function refreshtablefilter(start_date,end_date,profile,cost,high_tvr,maximum_cost,minimum_cprp,index,ch,orderingnya,by){
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
						 var table = $('#myTable').DataTable();
							var info = table.page.info();
							 
						 

						  data.length = info.recordsDisplay ;
						}).one('draw', function (e, settings, json, xhr)
						{
						  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
						  var addOptions = { exportOptions: { 'columns': ':visible'} };
					 
						  $.extend(true, excelButtonConfig, addOptions);
						  excelButtonConfig.action(e, dt, button, excelButtonConfig);
						   refreshtablefilter(start_date,end_date,profile,cost,high_tvr,maximum_cost,minimum_cprp,index,ch);
						}).draw();
					  },
            title: 'UNICS - Media Planning',
            filename: 'UNICS - Media Planning'
					}
			  ],
      		"processing": true,
      		"serverSide": true,
      		destroy: true,			
      		"ajax": "<?php echo base_url().'mediaplanningu/list_planning'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&cost=" + cost + "&high_tvr=" + high_tvr + "&maximum_cost=" + maximum_cost+ "&discount=" + discount + "&minimum_cprp=" + minimum_cprp+"&index=" + index+"&channel=" + ch,
      		"searchDelay": 700,
      		"bFilter" : false,		
      		 "order": [[ orderingnya, by]],
      		"orderable": true,
      		"bInfo" : false,
      		"bLengthChange": false
      	});
	  }
      
      function search_channel(){
        
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "<li data-for='channel'><a href='#' data-real='0' class='urate-select-form-two' data-for='channel'>All Channel</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'mediaplanningu/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
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
                    
                     strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel' data-id='channel'>"+strResult+"</a></li>";                          
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
    
    function search_profile(){
         var query = $('#search_profile').val(); 
        var period = $('#start_date').val();
        
        $('#profile').empty('');
        
        var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'mediaplanningu/profilesearch/'; ?>"+"?q="+query+"&f="+period,
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
  <script language="javascript">
      $(document).ready(function(){
          $('#cost').keyup(function(){
              $(this).val(function(index, value) {
                 return value
                 .replace(/\D/g, "")
                 .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                 ;
               });
          });
      });
  </script>
  
  <!-- UNTUK FUNGSI SORT -->
  <script>
  function sortTable(n) {
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
      rows = table.getElementsByTagName("TR");
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
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
        switchcount ++;       
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }
  </script>