 
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
        	top: 13px;
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
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/video-thumbnail.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/panel.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/box-profile.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tag.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/action-dropdown.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/checkbox.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tree-list.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/helix-profiling.css">

  <!-- Multi Select Css -->
  <link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	
  <!-- Multi Select Plugin Js -->
  <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/jstree.min.js"></script>
  <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/src/jstree.search.js"></script>
	
  <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/vendors/jstree/themes/default/style.min.css">   
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css">
	<!-- Timepicker -->
	<link rel="stylesheet" href="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.css">
	
	<link href="<?php echo $path; ?>assets/ext/select2.min.css" rel="stylesheet" />
<script src="<?php echo $path; ?>assets/ext/select2.min.js"></script>
  
	<div class="content-wrapper">
      <div class="container-fluid">  
          <div class="row">
              <div class="col-md-6">
                  <ol class="breadcrumb">
                      <!--<li class="breadcrumb-item">Urban Lifestyle Media</li>-->
                      <li class="breadcrumb-item active">Audience Analytics</li>
                  </ol>
                  <h3 class="page-title-inner">Audience Analytics</h3>
              </div>     
<div class="col-md-6 text-right">
					<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
				</div>					  
          </div>
          <div class="panel urate-panels">
              <div class="panel-body" style="height: 180px;">
                  <div class="row">
						
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
							
							<div class="col-lg-3">	
								<div class="form-group">
									<label>TV Channel</label>
									<div class="select-wrapper">
									  <select class='urate-select' name="channel" id="channel" title='Please Choose Channel ...'>
                                                 <option value='ALL' >All Channel</option>
																<?php
																	foreach($channels as $nhb){
												echo "<option value='".$nhb['CHANNEL_CDR']."' >".$nhb['CHANNEL_CIM']."</option>";
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
					
						<div class="col-lg-12" style="top: 210px;position: absolute;">	
							
							<div class="col-lg-3" style="z-index: 1;padding-right:20px">
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
							
							<div class="col-lg-3" style="margin-left:-10px;padding-right:20px">	
								<div class="form-group">
									<label>Profile</label>
									<div class="select-wrapper">
									  <button class="button_black form-control" id="profileButton" data-toggle="modal" data-target="#modalNewProfile"><span class="ion-plus"></span> Choose Profile</button>
								  </div> 
								</div>
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
										<button id="tab_chart" style="border: none;border-radius:5px;padding:3px 15px 3px 15px" onclick="tab_filter('chart')" href="#chart" aria-controls="chart" role="tab" data-toggle="tab"><strong>Chart</strong></button>
									</div>
								</div>
                              </div>
                  <!-- / Nav tabs -->
                  <div class="tab-content" style="margin-top:60px" >
                      <div role="tabpanel" class="tab-pane fade in active" id="table">
					  
					  <div class="row" id="body_tbl">
					
					</div>

					  </div>
                            
                     
                        <div role="tabpanel" class="tab-pane fade" id="chart">   
							<br>
							<br>
							
                      
                      </div>
                  </div>
              </div>
          </div>
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

<!-- Modal New Profile -->
	<div class="modal fade" id="modalNewProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Profile</h4>
				</div>
				<div class="modal-body">
				
				<div class="col-lg-12 col-md-12">	
					<div class="col-lg-6 col-md-6" style="margin-left:-15px">	
								<div class="form-group">
									<label>Profile</label>
									<div class="select-wrapper">
									  <select class="form-control urate-form-input" name="profile" id="profile" onChange="select_profile()" title="Please Choose Profile" required >
										  <option value=0 >All People</option>
										  <?php foreach($profile as $key) { ?>
										  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
										  <?php } ?>
									  </select>  
									</div>
								</div>
					</div>
				</div>
				
				<form action="#">
            <div class="col-lg-6 col-md-6" >   
			
			
    						<!-- Treebox -->
                <label for="">Parameter</label>
								<div class="parameter-box" id="box_tree">
									<div class="panel urate-panel">
										<div class="panel-heading">
												<div class="form-group">
													 <div class="form-group">
														  <span class="glyphicon glyphicon-search urate-icon-search" aria-hidden="true"></span>
														  <input type="text" class="form-control urate-form-input urate-form-input-search" id="searchjtree" placeholder="Search">
													  </div>
												</div>
										</div>
										<div class="panel-body" style="height: 370px;">
												<div id="jstree2" class="demo" style="margin-top:0px; font-size: 11px;"></div>
										</div>
									</div>
								</div>   
                <!-- / Treebox -->
            </div>
			<div class="col-lg-6 col-md-6">
    						<div class="form-group">
    							<div class="row">
  									<label for="">Selected</label>
  									<div class="parameter-box result">
  										<div class="panel urate-panel">
  											<div class="panel-body" >
											<span id="listcr" name="listcr"></span>
  											    <span id="option" name="option"></span>
  											</div>
  										</div>
  									</div>
                  </div>
    						</div>
				      </div>   
					</form>
        </div>
				<div class="modal-footer">
				
													
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
  <!-- Timepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.js"></script>
  <!-- Cookie -->

  <!-- Highcharts -->
	<script src="<?php echo $path5;?>plugins/highcharts/highcharts.js"></script>
  
  <script language="javascript">
  
  
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
				dpart_list += '<li data-for="daypart"><a href="#" data-real="ALL" data-id="daypart">ALL DAYS</a></li>';
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
				
				 $('#loaderdp').hide();
				 $(".modal .modal-footer button").show();
				 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        });
    }   
  
  
        var optVal1 = [];
        var tempVal1 = [];
        var optVal = [];
        var tempVal = [];
		var crcroptVal1 = [];
		var crcrtempVal1 = [];
		var croptVal = [];
		var crtempVal = [];
		var crfavdata = [];
		var crstar = 0;
	    var crnewdata = [];
		

	
	$('#searchjtree').on('typeahead:select', function (e, datum) {
     
    });
	

			  
		
							
							function arraypush(datas){
	crnewdata = [];
	 crnewdata = datas;
}
  
      $(document).ready(function(){ 

	  
	  		 $('#searchjtree').typeahead({
        source: function (query, process) {
            return $.get('audienceresallp22/listsearchs?q=' + query, function (data) {
                return process(data);
            });
        },
        updater: function(selection){
             $('#jstree2').jstree('search', selection.name);
            
        }
    });
	
					$('#jstree2').jstree({'plugins':["checkbox","search"], 'core' : {
                                "themes" : { "stripes" : true },
                'data' : [
                      <?php 
                $html = '';
                $htmls = ''; 
 
                $html .=  $tree_s; 

                echo $html; 
                ?> 
                ]
              }, "search": {}});
			  
			  
			  	  	$('#jstree2').on("changed.jstree", function (e, data) {
								
							$('#listcr').empty();
							$('#list_1').empty();
							  var crnewdata = data.selected;
							  var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
                               console.log(crnewdata);
							  for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("_");
                                  
                                  if(ss[0].length > 2 ){
                                      var ssa = crnewdata[i].split("=");
                                      dd.push(ssa);
                                      ddf.push(ssa);
                                  }else{
                                      
                                  }
																	
							  };
                                
							  dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var crcrtempVal1 = $("#profile_"+index).val();

                                                if(crcrtempVal1.indexOf(val) >= 0 && crcroptVal1.indexOf(val) < 0) {
                                                    crcroptVal1.push(val);
                                                } else if(crcrtempVal1.indexOf(val) < 0 && crcroptVal1.indexOf(val) >= 0) {
                                                    crcroptVal1.splice(crcroptVal1.indexOf(val) , 1);
                                                }

                                            })

                                        });
                              });      
                                
                            var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                console.log(ddsh); 
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak_'+index+'"></span>';
                                      $('#listcr').append(text);
                                      $('#list_1').append(text);
                                      ddf.forEach(function(entry, index) {

                                          if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                              $('#anak_'+ix).append(texta);
                                          }


                                      });
                                     }
                                  
                                  
							  });
							  
                                
                                
                                
									
							  arraypush(data.selected);
							  
							});
							
							
							
			  
	  
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  endDate: '0d',
                  defaultDate: new Date()
              });                     
              
              $(this).val("<?php echo date('d/m/Y') ?>");
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

		  
      });
      
      $(document).ready(function(){
       
	  
	        $('#from').timepicker({
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
                      url		: "<?php echo base_url().'msbc/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
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
                      url		: "<?php echo base_url().'msbc/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
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
				  var dateend = $("#end_date").val(); 
                  var profile = $("#profile").val();
                  
                  $(".search-channel-con").remove();
                  $(".search-con").remove(); 
                  
                  generate_program(chnl,datesel,dateend,profile);
              });
          });
          
          $("#custom_programsss").on("click",function(){
              $("#custom_channel").parent().removeClass('active');
          }); 
      });   
	  
	  
	  function select_profile(){
		  
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
		  var id_profile = $('#profile').val();
		  
		  var form_data = {			
              id_profile : id_profile
          };    
		  
		  if(id_profile == 0){
			  
			$('#listcr').empty();
			$('#list_1').empty();
			$("#box_tree").css({'pointer-events':'auto'}); 

			  
		  }else{
			  
			   $.ajax({
				  type	: "POST",
				  url		: "<?php echo base_url().'audienceresallp22/list_tree_profile/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
				  data	: JSON.stringify(form_data),			
				  dataType: 'json',
				  contentType: 'application/json; charset=utf-8',
				  success	: function(response) { 
				  
						
						  $('#listcr').empty();
						  $('#list_1').empty();
						 
						$("#box_tree").css({'pointer-events':'none'}); 
						
						
						obj = response['data'];
						
						 var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
							 
							 var crnewdata = obj;
							for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("_");
                                  
                                  if(ss[0].length > 2 ){
                                      var ssa = crnewdata[i].split("=");
                                      dd.push(ssa);
                                      ddf.push(ssa);
                                  }else{
                                      
                                  }
																	
							  };
							  
							   dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var crcrtempVal1 = $("#profile_"+index).val();

                                                if(crcrtempVal1.indexOf(val) >= 0 && crcroptVal1.indexOf(val) < 0) {
                                                    crcroptVal1.push(val);
                                                } else if(crcrtempVal1.indexOf(val) < 0 && crcroptVal1.indexOf(val) >= 0) {
                                                    crcroptVal1.splice(crcroptVal1.indexOf(val) , 1);
                                                }

                                            })

                                        });
                              }); 

							var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                console.log(ddsh); 
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak_'+index+'"></span>';
                                      $('#listcr').append(text);
                                      $('#list_1').append(text);
                                      ddf.forEach(function(entry, index) {

                                          if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                              $('#anak_'+ix).append(texta);
                                          }


                                      });
                                     }
                                  
                                  
							  });		

								arraypush(crnewdata);
						
					
				  
				  }, error: function(obj, response) {
					  console.log('ajax list detail error:' + response);	
				  } 
			  });    
		  
		  }

	  }
          
      function generate_program (channel, sdate,dateend, sprofile){
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
                  
          $('#programsss').empty('');
          
          var form_data = {			
              valselect : channel,
              dateselect : sdate,
              dateend : dateend
          };                                                                                                    
          var strVar = ""; 
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'audienceresallp22/list_program/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
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
    				   
					   if(sdate == dateend){
						  for(i=0; i < response.data.length; i++){

							  strVar += "<li><a href='javascript:void(0)' data-real='"+response.data[i].PROGRAM+"' class='urate-select-form-two' data-for='programsss'>"+response.data[i].PROGRAM+"</a></li>";                          
						  } 
					   }else{
						     for(i=0; i < response.data.length; i++){

								strVar += "<li><a href='javascript:void(0)' data-real='"+response.data[i].PROGRAM+"' class='urate-select-form-two' data-for='programsss'>"+response.data[i].PROGRAM+"</a></li>";                             
							} 
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
          var daypart = $('#daypart').val();
          
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
          
			$('.urate-panel-results').show();
			$('#panel-blank').hide();
						  $('#profileButton').hide();
						  $('#processButton').hide();
						  $('#loader').show();
          
			
			
                    var form_data = {
                        list		 : crnewdata,
                        end_date		 : end_date,
                        start_date		 : start_date,
                        profile		 : profile,
                        channel		 : channel,
                        program		 : program,
                        user_id		 : user_id,
                        token		 : token,
                        daypart		 : daypart
                      
                    }
					
					var urls = "<?php echo base_url();?>audienceresallp22/cr_pp" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					
					 $.ajax({ 
                        type: "POST",
                        url: urls,
                        data: JSON.stringify(form_data),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
						  
						  $('.urate-panel-results').show();
							$('#panel-blank').hide();
			
						  $('#body_tbl').html(response.data['table']);
						
						
						 $('.hghg').DataTable({
							"bLengthChange": false
						});
						 
						 obj =response.data['data'];
						 obj_2 =response.data['data_all'];
						 
						 $('#chart').html('');
						 create_chart(obj,obj_2);
						
						 $('#processButton').delay(1000).fadeIn();
						 $('#profileButton').delay(1000).fadeIn();
						  $("#loader").hide();
						 $('.loader').css('display','none');
						 $('#processButton').show();
						 $('#profileButton').show();
						  
						  

					
					 }).fail(function(xhr, status, message) {
                        $("#laod").empty();
                        $('#savecr').show();
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

	function export_aud(ads){
		
		var form_data = new FormData();  
		form_data.append('ads', ads);
		
		
		$.ajax({
			url: "<?php echo base_url().'audienceresallp22/audience_export'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_export.xls','Audience_export.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
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

    // for IE < 11
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}

  	    function create_chart(data,data_all){
			
			arr_all = [];
			arr_all.push(parseInt(data_all));

		  
		 console.log(arr_all);
			$('#chart').append('<div class="col-md-12" style="margin-bottom:10px;margin-top:10px"> <div class="result-table urate-panel" style="padding:10px"> <div id="container_all" style="width: 900px; height: 400px; margin: 0 auto"></div></div></div>');
		 
		Highcharts.chart('container_all', {
			chart: {
				type: 'column'
			},
			title: {
				text: "<strong>All Data</strong>",
				  align: 'left'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
					'All Data'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: ''
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table aria-describedby="mydesc" >',
				pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
					'<td style="padding:0"><strong>{point.y}</strong></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Population All',
				data: arr_all,
				 color: "#FF0000"
			}]
		});
		
		 
		 for(var rt=0;rt < data.length; rt++){

		 $('#chart').append('<div class="col-md-12" style="margin-bottom:10px;"> <div class="result-table urate-panel" style="padding:10px"> <div id="container'+rt+'" style="width: 900px; height: 400px; margin: 0 auto"></div></div></div>');
		 
		 
		 var ssss = data[rt]['DATA'];
		 

          var tv1tgl = [];
          var tv1data = [];    
          var tv1data1 = [];    
          var tv1data2 = [];    
		  var tol = [];
          
          for(var si=0; si < ssss.length; si++){
			 var tv1datad = [];   
             col_data = ssss[si]['RESP']; 
             col_data1 = ssss[si]['IH']; 
             col_data2 = ssss[si]['ALLS']; 
			 
			 col_per = ssss[si]['PROSEN']; 
			 

              tv1tgl.push(ssss[si]['LABEL']);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
              tv1data1.push(parseFloat(parseFloat(col_data1).toFixed(0)));
              tv1data2.push(parseFloat(parseFloat(col_data2).toFixed(0)));
			  
			 tol.push(ssss[si]['PROSEN']+' %');

			  
          }
          
		  if(ssss[0]['FIELD'] == 'prov'){
			  var tittle = 'Provinsi';
		  }else  if(ssss[0]['FIELD'] == 'kabkot'){
			  var tittle = 'Kota';
		  }else{
			  var tittle = ssss[0]['PARENT'] 
		  }

		
          
          tgl = tv1tgl;
          
		  var textToDisplay = ['First', 'Second', 'some text', 'fourth', 'last column'];
		  
          Highcharts.chart('container'+rt+'', {
              chart: {
                  type: 'column'
              },
              title: {
                   text: "<strong>"+tittle+"</strong>",
				   align: 'left'
              },
              subtitle: {
                  text: ''
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
                  column: {
                      dataLabels: {
                          enabled: true, 
							formatter: function() {

							  return tol[this.point.index];
							}
                      },
					  
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: "Population All",
                  data: tv1data2,
				  color: "#FF0000"
              }]
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	

		}		  
        
      }
      
      function search_program(){
          //console.log("SINI!");
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          var channel = $('#channel').val();
          var query = $('#search_program').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#programsss').empty('');
          
		  
		  
          var strVar = "";
          
          $.ajax({
              type	: "POST",
            url		: "<?php echo base_url().'audienceresallp22/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date+ "&dend=" + end_date + "&c=" + channel,
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                  $("#programsss").next().next().next().empty('');
                  
				  
				  
                  for(i=0; i < response.length; i++){                   
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
						   if(start_date == end_date){
							    strResult = response[i].PROGRAM;
								strResult2 = '';
								
						   }else{
							    strResult = response[i].PROGRAM;
								strResult2 = '';
								
						   }
                         
                      }
                      
					  if(start_date == end_date){
						  
						   strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='programsss'>"+strResult+"</a></li>";  
						   
					  }else{
						   strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='programsss'>"+strResult+"</a></li>";  
					  }
					  
                                             
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_city'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_comm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_persona'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_gender'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_age'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_digi'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_house'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_arpu'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_ses'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audienceresallp22/list_audience_web'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
        var end_date = $('#end_date').val();
        var profile = $('#profile').val();
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'channelmigration3/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date+ "&ed=" + end_date + "&p=" + profile,
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
                    var dateend = $("#end_date").val(); 
                    var profile = $("#profile").val();
                    
                    $(".search-channel-con").remove();   
                    $(".search-con").remove();
                  
                    generate_program(chnl,datesel,dateend,profile);                     
                });                                 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
  </script>