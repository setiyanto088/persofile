  		
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
  
	<div class="content-wrapper">
      <div class="container-fluid">  
          <div class="row">
              <div class="col-md-5">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">Pay TV</li>
                      <li class="breadcrumb-item">Inhouse Report</li>
                      <li class="breadcrumb-item active">Audience Profile</li>
                  </ol>
                  <h3 class="page-title-inner"><strong>Audience Profile</strong></h3>
              </div> 
				<div class="col-md-7 text-right">
					<button id="button_filters" onClick="search()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
				</div>				  
          </div>
          <div class="panel urate-panels">
              <div class="panel-body" style="height: 180px;">
                  <div class="row">
				  
				  
						<div class="col-md-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Periode</label>
									<input type="text" class="form-control urate-form-input" name="start_date" id="start_date" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Periode</label>
									<input type="text" class="form-control urate-form-input" name="end_date" id="end_date" value="" placeholder="Please Choose Date ..." style="text-align:left">
								</div>
							</div>
							<div class="col-lg-3">	
								<label>TV Channel</label>
								<div class="select-wrapper">
								  <select class='urate-select' name="channel" id="channel" title='Please Choose Channel ...'>
								  <option value='ALL' >ALL CHANNEL</option>
															<?php 
																foreach($channels as $nhb){
											echo "<option value='".$nhb['CHANNEL_CDR']."' >".$nhb['CHANNEL_CIM']."</option>";
																}
															?>
								  </select>
							  </div> 
							</div>
							<div class="col-lg-3">	
								<label>Program</label>
									<div class="select-wrapper">
									  <img alt="image" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader2" style="display: none;margin: auto;width: 24px;">
									  <select class='urate-select' name="programsss" id="programsss" title='Please Choose Program ...'>
										  <option disabled selected value="">-- Select Program --</option>
									  </select>
								  </div> 
							</div>
						</div>
						<div class="col-md-12">	
							<div class="col-md-3" style="">
							<div class="row">
								<div class="col-md-6" style="margin-left:-10px">
									<label>Day Part</label> 
								</div>
								<div class="col-md-6 text-right" style="margin-right:10px">
								  <a href="#" data-toggle="modal" data-target="#modalNewTime" id="dptriger" style="color:red"><span class="ion-plus"></span> New</a>
								</div>															
									<div class="select-wrapper">
										  <select class='form-control urate-select ' name="daypart" id="daypart" title='Please Choose Time Schedule ...'>
											<option value="ALL" >ALL DAYS</option>
											  <?php foreach($daypart as $key) { ?>
											  <option value="<?php echo $key['DPART']; ?>" ><?php echo $key['DPART']; ?></option>
											  <?php } ?>
										  </select>
									  </div>
							</div>
							</div>
							<div class="col-md-3" style="">	
								<label>Profile</label>
								<div class="select-wrapper">
									<button class="button_black" id="profileButton" data-toggle="modal" data-target="#modalNewProfile"><span class="ion-plus"></span> Choose Profile</button>
								</div>
							</div>
						</div>

                      <!-- END PROCESS BUTTON -->
                  </div>
              </div>
          </div>
		  
		   <div class="loader" style="display:none">
                 <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
            </div>
		  
		<div class="panel2" id="panel-blank" >
		
			<img alt="image" class="gambar" src="<?php echo $path9;?>images/Frame388.png" style=" margin-left: auto;margin-right: auto;display: block;" id="sss">
		  
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

                  <div class="tab-content">                          
                     
                        <div role="tabpanel" class="tab-pane fade in active" id="chart">   

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
          <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_black" onClick="create_daypart()"><em class="fa fa-check"></em> &nbsp Create</button>
				</div>
			</div>
		</div>
	</div>

           <!-- Modal Load Channel -->
	<div class="modal fade modalnewchannel" id="modalloadchannel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Preset List</h4>
				</div>
				<div class="modal-body">
					 <div class="dataset col-md-5" style="z-index: 999;margin-bottom:150px">
						   <div class="dataset-title">
                              <p class="title-text">TV Channel</p>
								
                          </div>
							<div class="select-wrapper" style="margin-top:-10px">
                              <select class="urate-select grid-menu" name="channel_pr" id="channel_pr" title="Please Choose a Channel ..." required>
                                  <option value="0" >All Channel</option>
                                  <?php foreach($channel as $key) { ?>
                                  <option value="<?php echo str_replace("&","AND",$key['channel']); ?>" ><?php echo $key['channel']; ?></option>
                                  <?php } ?> 
                              </select>
							</div> 
						  </div> 
					
					<div class="dataset col-md-4" style="">
						   <div class="dataset-title">
                              <p class="title-text">Preset Name</p>
							
                          </div>
							<div class="select-wrapper" style="margin-top:-10px">
                              <input style="color: #cb3827" type='text' class="form-control urate-form-input" name="save_channel_name" id="save_channel_name" title="" required>
							</div> 
							
							<br>
							 
							<div class="select-wrapper" style="margin-top:0px">
							</div>
							
							 <br>
							 
							 <button style="text-align:right" type="button" class="btn urate-btn" onClick="save_channel_list()">Save</button>
							 
					</div> 	
 
							 
					
					<form action="" class="row">
						<div class="form-group col-md-12">
							<table aria-describedby="table" id="example9" class="table table-striped table-bordered example" style="width: 100%">
							<thead>
								<tr>
									<th scope="row">No </th>
									<th scope="row">Preset</th>
									<th scope="row">Channel List</th>
									<th scope="row">Action</th>
								</tr>

							</thead>
							<tbody id='bd_lod'>
							</tbody>
						</table>
						</div>
						
						
					</form>
          <div class="dayPartMsg"></div>
				</div>
				<div class="modal-footer">                                       
          <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					
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
					<form action="#">
            <div class="col-lg-6 col-md-6">   
    						<!-- Treebox -->
               
								<div class="parameter-box" >
									<div class="panel urate-panel" style="background-color:#F7F7F7"> 
										<div class="panel-headings">
										 
												<div class="form-group" style="padding:15px">
													<label for="">Parameter</label>
													 <div class="form-group">
														  <span class="glyphicon glyphicon-search urate-icon-search" aria-hidden="true"></span>
														  <input type="text" class="form-control urate-form-input urate-form-input-search" id="searchjtree" placeholder="Search">
													  </div>
												</div>
										</div>
										<div class="panel-body" style="height: 370px;margin-top:-40px">
												<div id="jstree2" class="demo" style="margin-top:0px; font-size: 11px; border: 1px solid rgba(0, 0, 0, 0.1);border-radius: 6px;"></div>
										</div>
									</div>
								</div>   
                <!-- / Treebox -->
            </div>
			<div class="col-lg-6 col-md-6">
    						<div class="form-group">
    							<div class="row">
  									<div class="parameter-box result">
  										<div class="panel urate-panel" style="background-color:#F7F7F7">
  											<div class="panel-body" style="height: 450px">
											<label for="">Selected</label>
											<span id="listcr" name="listcr" ></span>
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
  
  function save_channel_list(){
			
			
			var save_channel_name = $('#save_channel_name').val();
			var channel = $('#channel_pr').val();
			var user_id = $.cookie(window.cookie_prefix + "user_id");
			var token = $.cookie(window.cookie_prefix + "token");
			
			
			   var form_data = {
				  sess_user_id     : user_id,
				  sess_token      : token,
				  save_channel_name	 : save_channel_name,
				  channel     : channel
			  };       
			
			
			  $.ajax({
				  url : "<?php echo base_url().'audiencevir/save_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
					
					  var html = '';
					  var html2 = '<option value="0" selected >All Channel</option>';
					  var no = 1;
					  for(var i = 0;i < response.length; i++){
						  
							html2 += '<option value="'+response[i].CHANNEL_NAME+'" >'+response[i].CHANNEL_NAME+'</option>';
						  
						  
							html += '<tr>';
							html += '		<td>'+no+' </td>';
							html += '		<td>'+response[i].CHANNEL_NAME+'</td>';
							html += '		<td>'+response[i].CHANNEL_LIST+'</td>';
							html += '		<td><button type="button" class="btn urate-btn" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\' , \''+response[i].CHANNEL_NAME+'\')">Edit</button><button type="button" class="btn urate-btn" onClick="delete_conf(\''+response[i].CHANNEL_NAME+'\')">Delete</button></td>';
							html += '	</tr>';
						  no++;
						  
					  }
					  $('#bd_lod').html(html);
					  
					  $('#preset').html('');
					  $('#preset').html(html2);
					  
					  $('#preset2').html('');
					  $('#preset2').html(html2); 
					  
						$('[data-for = "channel"]').each(function(){
							$(this).removeClass('checked'); 
						});
								
								
						$('#save_channel_name').val('');
						$('#custom_channel').val('');
						$('#custom_channel').html('Please Choose a Channel ...');
				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
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
				dpart_list += '<li data-for="daypart"><a href="#" data-real="ALL" data-id="daypart">ALL DAYS</a></li>';
                for(i=0; i < response.length; i++){
                    dpart_list += '<li data-for="daypart"><a href="#" data-real="'+response[i].DPART+'" data-id="daypart">'+response[i].DPART+'</a></li>';
                }
                
                $("#custom_daypart").next().html(dpart_list);
                
                $("#modalNewTime").modal('toggle');                      
          
                $('[data-for="daypart"]').on('click',function(){
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
  
  
    //start
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
            return $.get('pivot/listsearch?q=' + query, function (data) {
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
              url		: "<?php echo base_url().'audiencevir/list_program/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
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
	  
	  	function load_modal_load_channel(){
			
				$('[data-for = "channel"]').each(function(){
					$(this).removeClass('checked'); 
				});
				
				$('[data-for = "channelp"]').each(function(){
					$(this).removeClass('checked'); 
				});
						
				$('#save_channel_name').val('');
				$('#custom_channel').html('Please Choose a Channel ...');
				$('#custom_channelp').html('Please Choose a Channel ...');
			
			 var form_data = {
				  sess_user_id     : ''
			  };       
			
			
			  $.ajax({
				  url : "<?php echo base_url().'tvprogramun3tvvir/load_channels'?>",
				  method : "POST",
				  data : form_data,
				  success: function(response) {
					  
					  var html = '';
					  var no = 1;
					  for(var i = 0;i < response.length; i++){
						  
							html += '<tr>';
							html += '		<td>'+no+' </td>';
							html += '		<td>'+response[i].CHANNEL_NAME+'</td>';
							html += '		<td>'+response[i].CHANNEL_LIST+'</td>';
							html += '		<td><button type="button" class="btn urate-btn" onClick="load_channel(\''+response[i].CHANNEL_LIST+'\' , \''+response[i].CHANNEL_NAME+'\')">Edit</button><button type="button" class="btn urate-btn" onClick="delete_conf(\''+response[i].CHANNEL_NAME+'\')">Delete</button></td>';
							html += '	</tr>';
						  no++;
						  
					  }
					  $('#bd_lod').html(html);
					  
		
						$('#modalloadchannel').modal('show');					  
				  },
				  error: function(obj, response) {
					  console.log('ajax list_project error:' + response);
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
          var preset = $('#preset').val();
          var program = $('#programsss').val();
          var daypart = $('#daypart').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");                 
          
          var colgroup = "tvr";
          
          var orderingnya = '0';	
          var by = '';	
          
          $('input.toggle-vis').attr('disabled','disabled');
          
          if(start_date === ''){ // value of a text input cannot be null
              // or zero unless you've changed in with JS
              alert('Please, Select Start Date');
              return false;
          }	           
          
          if(profile === null || profile === ''){ // value of a text input cannot be null
        			// or zero unless you've changed in with JS
        			alert('Please, Select Profile');
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
          

						  $('.loader').show();
          
			
			
                    var form_data = {
                        list		 : crnewdata,
                        end_date		 : end_date,
                        start_date		 : start_date,
                        profile		 : profile,
                        channel		 : channel,
                        preset		 : preset,
                        program		 : program,
                        user_id		 : user_id,
                        token		 : token,
                        daypart		 : daypart
                      
                    }
					
					var urls = "<?php echo base_url();?>audiencevir/cr_pp" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					
					 $.ajax({ 
                        type: "POST",
                        url: urls,
                        data: JSON.stringify(form_data),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
						  
						  $('#body_tbl').html(response.data['table']);
						
						
						 $('.hghg').DataTable();
						 
						 obj =response.data['data'];
						 
						 $('#chart').html('');
						
							  create_chart(obj,form_data);
						 
						 
						
						$('.urate-panel-results').show();
						$('#panel-blank').hide();
						 $('#processButton').delay(1000).fadeIn();
						  $(".loader").hide();
						 $('.loader').css('display','none');
						 $('#processButton').show();
						 $('#profileButton').show();
						  
		
					 }).fail(function(xhr, status, message) {
                        $("#laod").empty();
                        $('#savecr').show();
                    });
           

      }             

	function export_aud(ads){
		
		var form_data = new FormData();  
		form_data.append('ads', ads);
		
		
		$.ajax({
			url: "<?php echo base_url().'audiencevir/audience_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
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
		
		//alert(ads);
		
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

  	    function create_chart(data,form_data){
		  
	
		 
		 for(var rt=0;rt < data.length; rt++){

		 
		 if(data[rt]['DATA'] == undefined){
			 
		 }else{
		 
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
			  
			 tol.push(ssss[si]['ALLS']+'');

			  
          }
		  
		 // alert(si);
		  
		  var heights = (si+1)*70;
		  
		  $('#chart').append('<div id="container'+rt+'" style="width: 900px; height: '+heights+'px; margin: 0 auto"></div><br>');
          


			var tittle =  data[rt]['NAMA']+'-'+form_data['program']+'<br>PERIODE: '+form_data['start_date']+' s.d '+form_data['end_date']+'..DAY PART '+form_data['daypart'];
          
          tgl = tv1tgl;
		  
	
          
		  var textToDisplay = ['First', 'Second', 'some text', 'fourth', 'last column'];
		  
          Highcharts.chart('container'+rt+'', {
              chart: {
                  type: 'bar'
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
                  text: ''//'TVR'
              }
              },
              plotOptions: {
                  series: {
                      dataLabels: {
                          enabled: true,
						   crop: false,
						overflow: true,
						  formatter: function() {
								
								if(tol[this.point.index] == ''){ 
									var totals = '';
								}else{
									  var totals = new Intl.NumberFormat('de-DE', { minimumFractionDigits: 0  }).format(tol[this.point.index]);
								
								}
								
								return totals;
							
						  }
                      },
					  
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: data[rt]['NAMA'],
                  data: tv1data2,
				  color: "#FF0000"
              }]
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	
		 }
		}		  
        
      }
	  
	  	  function load_channel(channel_list,channel_name){ 
		
		
			console.log(channel_list);
			
			$('[data-for = "channel"]').each(function(){
                $(this).removeClass('checked'); 
            });
			
			var arr_channel = channel_list.split(',');

			$('#custom_channel').closest('.grid-menu').find('.hidden-element-for-dropdown').attr('value',channel_list);
			
			var $text ='';
			for(var i = 0;i < arr_channel.length; i++){
				if(i == 0){
					$text += '<span class="menu-item">'+arr_channel[i]+'</span>';
				}else{
					$text += '<span class="menu-item">'+arr_channel[i].substring(1)+'</span>';
				}
				
			}		   
			 
			 
            $('#custom_channel').closest('.grid-menu').children('.urate-custom-button').text('').append($text);
		  
			for(var i = 0;i < arr_channel.length; i++){
				if(i == 0){
					$('[data-real = "'+arr_channel[i]+'"]').parent().addClass('checked');
				}else{
					$('[data-real = "'+arr_channel[i].substring(1)+'"]').parent().addClass('checked');
				}
			}	
			
			$('#save_channel_name').val(channel_name);

		}
      
      function search_program(){
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
            url		: "<?php echo base_url().'audiencevir/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date+ "&dend=" + end_date + "&c=" + channel,
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
								strResult2 = response[i].START_PROGRAM;
								
						   }else{
							    strResult = response[i].PROGRAM;
								strResult2 = '';
								
						   }
                         
                      }
                      
					  if(start_date == end_date){
						  
						  
						   strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+","+strResult2+"' class='urate-select-form-two' data-for='programsss'>"+strResult+" "+strResult2+"</a></li>";  
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_city'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_comm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_persona'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_gender'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_age'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_digi'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_house'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_arpu'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_ses'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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
              "ajax": "<?php echo base_url().'audiencevir/list_audience_web'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
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