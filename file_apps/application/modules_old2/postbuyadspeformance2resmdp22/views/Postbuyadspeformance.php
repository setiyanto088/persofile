 
  		  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
		    <script src="<?php echo $path;?>assets/ext/select2.min.js"></script>
  <style>
  
  .multiselect-dropdown {
    height: 35px !important;
}
  
  .btn .dropdown-toggle .btn-default .bs-placeholder {
  width: 100%;
  padding: 0px 20px;
  padding-right: 40px;
  height: 34px;
  border: 1px solid #9b9b9b;
  border-radius: 5px;
  background: #fff;
  background-image: url("../images/form_icon_dropdown_arrow.png");
  background-size: 18px 18px;
  background-repeat: no-repeat;
  background-position: calc(100% - 10px) 50%;
  overflow: hidden;
  text-align: left;
  text-overflow: ellipsis;
  white-space: nowrap;
}
  
      i.material-icons.search {
  			margin-top: 40px;
  			margin-right: 29px;
  		}
  
  		.card .header {
  			margin-left: -30px;
  			margin-right: -30px;
  			padding-top: 15px;
  			padding-bottom: 3px;			
  		}
  
  		#line-chart{
  			min-height: 250px;
  		}	
  		
  		text.highcharts-credits{
  			display:none;
  		}	
  		
  		.pointer{
  			cursor : pointer;
  			color:blue;
  		}
      
  		.selected {
  			color: white;
  			 background-color: red !important;
  		}
  		
  		.unselected {
  			color: white;
  			 background-color: #1f91f3 !important;
  		}
  		
  		.test_btn {
  			 color: white;
  			 background-color: #1f91f3 !important;
  		}
  		
  		video::-webkit-media-controls {
  		  display:none !important;
  			top: 0px;
  			left: 0px; /* fixed to left. Replace it by right if you want.*/
  			min-width: 100%;
  			min-height: 100%;
  			width: auto;
  			height: auto;
  		}
  		
  		.tp-video-play-button {display: none !important}
      
      .urate-wrapper{
          width: 100%;
          padding: 5px 30px;
          height: 44px;
          border: 1px solid #9b9b9b;
          box-shadow: 0 0 3px #ccc;
          border-radius: 18px;
          background: #fff;
          background-repeat: no-repeat;
          overflow: hidden;
          text-align: left;
          text-overflow: ellipsis;
          white-space: nowrap;
      
      }
      .urate-control {
          width: 100%;
          padding-right: 60px;
          height: 34px;
          border: none;
          background: #fff;
          color: #aaa;
      }
      
      table.dataTable thead .sorting:after,
      table.dataTable thead .sorting_asc:after,
      table.dataTable thead .sorting_desc:after,
      table.dataTable thead .sorting_asc_disabled:after,
      table.dataTable thead .sorting_desc_disabled:after {
          position: absolute;
          bottom: 8px;
          right: 8px;
          display: block;
          font-family: 'Glyphicons Halflings';
          opacity: 0.5;
          color: red;
      }
      
      table.dataTable th {
          min-width: 130px;
      }
      
      .loaders {
          border: 16px solid #f3f3f3; /* Light grey */
          border-top: 16px solid #3498db; /* Blue */
          border-radius: 50%;
          width: 60px;
          height: 60px;
          animation: spin 2s linear infinite;
      }
      
      @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
      }
      
      .modals {
          display:    none;
          position:   fixed;
          z-index:    1000;
          top:        0;
          left:       0;
          height:     100%;
          width:      100%;
      }
      
      .infront{
          z-index: 99 !important;
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
  
  <div class="content-wrapper">
      <div class="container-fluid">
      <!-- Content -->
      <!-- Data Set -->
          <div class="row">
                  <div class="col-md-5">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">Urban</li>
                      <li class="breadcrumb-item active"><strong>Post Buy Analytics</strong></li>
                  </ol>
                  <h3 class="page-title-inner"><strong>Post Buy Analytics</strong></h3>
              </div>  
				<div class="col-md-7 text-right">
					<button id="button_filters" onClick="filter_adspeformance()" class="button_black"><em class="fa fa-refresh"></em> &nbsp Process</button>
				</div>	     
          </div>
          <div class="panel urate-panels">
              <div class="panel-body" style="height: 180px;">
                  <div class="row">
				  
					<div class="col-lg-12">	
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
							
							<div class="col-lg-3" style="z-index: 99;">	
								<div class="form-group">
									<label>Profile</label>
									  <select class='urate-select' name="profile" id="profile" title='Please Choose Profile ...' >
										  <option value="0" >All People 2021</option>
										  <option value="1" >All People 2022</option>
										  <?php foreach($profile as $key) { ?>
										  <option value="<?php echo $key['id']; ?>" ><?php echo $key['name']; ?></option>
										  <?php } ?>
									  </select>
								</div>
							</div>
							
							<div class="col-lg-3" style="margin-left:-10px;padding-right:20px;z-index: 1000;">
								<div class="form-group">
									<label>Channel</label>
									<div class="select-wrapper">
									  <select class="urate-select grid-menu" name="get_chnl" id="get_chnl" title="Please choose a Channel..." required>
										<option value="0" >All Channel</option>
										 <option value="1" >All UseeTV</option>
										<option value="2" >All Mediahub</option>
										<?php $i = 0; foreach($channels as $key) { ?>
										<option value="<?php echo $key['channel']; ?>" ><?php echo $key['channel']; ?></option>
										<?php } ?>
									  </select>
								  </div>
								</div>
							</div>

						</div>
				  

                      	<div class="col-lg-12" style="top: 210px;position: absolute;">		
							
							<div class="col-lg-3" style="" id="">
								<div class="form-group">
									<label>Program</label>
									<div class="select-wrapper">
									 
									  <div id='prog_selsss'>
											<select style="width:100%;height:35px;" name="programss" id="programss" ><option value="all" Selected="selected" >All Program</option></select>
									  </div>
										
									</div>
								</div>
							</div>
							
							<div class="col-lg-3" style="margin-left:-15px;">	
								<div class="form-group">
									<label>Category</label>
									<div class="select-wrapper">
									   <select class="urate-select hidden-element-for-dropdown" name="kategori_by" id="kategori_by" title="Please Choose Category" required >
										  <option value="" selected disabled >-- Category ---</option>
										   <option value="NAMA_BRAND" >BRAND</option>
										  <option value="ADVERTISER" >ADVERTISER</option>
										  <option value="AGENCY" >AGENCY</option>
 										  <option value="PO_NUMBER" >PO Number</option>                 
									  </select> 
									</div> 
								</div>
							</div>
							
							<div class="col-lg-3" style="z-index: 1;padding-right:20px">
								<div class="form-group">
									<label>Sub Category</label>
									<div class="select-wrapper">
									  <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader2" style="display: none;margin: auto;width: 24px;">
									  <select class="urate-select hidden-element-for-dropdown" name="get_kategori" id="get_kategori" title="Please Choose Subcategory" required >
										  <option value="" selected disabled >-- Subcategori ---</option>
									  </select> 
									</div>
								</div>
							</div>
							
							<div class="col-lg-3" style="z-index: 1;display:none;margin-left:-15px;" id="div_product">
								<div class="form-group">
									<label>Product</label>
									<div class="select-wrapper">
									  <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader2" style="display: none;margin: auto;width: 24px;">
									  <div id='prod_sel'>
									  </div>
										
									</div>
								</div>
							</div>
							
							
							
							
						</div> 
                      <!-- END TV CHANNEL FIELD -->
                      <!-- PROCESS BUTTON -->
                      
                      <!-- END PROCESS BUTTON -->
                  </div>
              </div>
          </div>
          <!-- /Data Set -->
          <!-- Result 1 -->
		  <div class="panel urate-panel urate-panel-result">
              <div class="panel-headings">
                  <h3 class='urate-panel-title'>Result</h3>
              </div>
              <div class="panel-body">
                  <!-- Nav tabs -->
                 
                  <!-- / Nav tabs -->
                        <div class="row" style="display:none">
						  <div class="col-md-12">
							  <div class="result-table">
								  <table aria-describedby="mydesc"  width="100%" id="example" class="table table-striped">
									  <thead style="color:red">
										  <tr>
											  <th style="" scope="row">Channel </th>
											  <th style="" scope="row">Program </th>
											  <th style="" scope="row">Date </th>
											  <th style="" scope="row">Time </th>
											  <th style="" scope="row">Total Views </th>
											  <th style="" scope="row">Spot </th>
										  </tr>
									  </thead>
								  </table>
							  </div>
						  </div>
					
						</div>
                           
						   
                       
						<div class="row">
							<div class="col-md-12" style="text-align:right">
							
								<button id="button_excel" onClick="export_excel()" class="button_black"><em class="fa fa-download"></em> &nbsp Excel</button>
								<button id="button_pdf" onClick="export_pdf()" class="button_black"><em class="fa fa-download"></em> &nbsp Pdf</button>
							
							</div>
						  <div class="col-md-12">
							  <div class="result-table">
								  <table aria-describedby="mydesc"  width="100%" id="example2" class="table table-striped">
									  <thead style='color:red'>
										  <tr>
										    <th style="width: 150px;" scope="row">Date </th>
										    <th style="width: 150px;" scope="row">Day of Week </th>
										    <th style="width: 150px;" scope="row">ISO Week </th>
											  <th style="width: 150px;" scope="row">Channel </th>
											  <th style="width: 150px;" scope="row">Program </th>
											  <th style="width: 150px;" scope="row">Brand </th>
											  <th style="width: 150px;" scope="row">Advertiser </th>
											  <th style="width: 150px;" scope="row">Agency </th>
											  <th style="width: 150px;" scope="row">PO Number </th>
											  <th style="width: 150px;" scope="row">Start Time </th>
											  <th style="" scope="row">Spot </th>
											  <th style="width: 150px;" scope="row">Duration </th>
											  <th style="width: 150px;" scope="row">TVR </th>
											  <th style="width: 150px;" scope="row">Total Views </th>
											  <th style="width: 150px;" scope="row">Reach 000s </th>
											  <th style="width: 150px;" scope="row">Reach 1+ </th>
											  <th style="width: 150px;" scope="row">Index </th>
 										  </tr>
									  </thead>
								  </table>
							  </div>
						  </div>
						   
						   
							<div class="col-md-6" id="summ_odo2">
								
							</div>
							 <div class="col-md-6" id="summ_odo3">
							 
							</div>
							
							
							<div class="col-md-6">
							  <div class="result-table" >
								<div id='summ_tab_1' style="margin-top:47px">
								  
								</div>
								
								<div id='summ_tab_2' style="margin-top:47px">
								  
								</div>
								
							  </div>
						  </div>
						  <div class="col-md-6">
							  <div class="result-table" >
								
								<div id='summ_chart_1' style="margin-top:47px">
								   <div id="container" style=" margin: 0 auto"></div>
								</div>
							
							  </div>
						  </div> 

							
					  </div> 
              </div>
          </div>

                    
      </div>
  </div>
  
  <!-- Modal Play Video -->
	<div class="modal fade" id="modal_video_program1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  		<div class="modal-dialog" role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        					<h4 class="modal-title" id="my_program1"></h4>
      				</div>
      				<div class="modal-body">
        					<div id="video_url" style="object:fit: fill;" ></div>
      				</div>
      				<div class="modal-footer">        
                  <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader3" style="display: none;margin: auto;width: 36px;float:left;">
                  <a class="btn urate-download-btn urate-outline-btn" style="width: 150px; float: left;">&nbsp;&nbsp;&nbsp;Download Video</a>
                  <button type="button" class="btn urate-outline-btn" data-dismiss="modal">Close</button>
      				</div>
    			</div>
  		</div>
	</div>
	<!-- / Modal -->

  <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms_sig.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path;?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  
  
	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>
  
  <script language="javascript">
      $(document).ready(function(){
		  

		 
		  
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          // var table = $("#example").DataTable({		
			   // dom: 'Bfrtip',
              // 'buttons': [
                  // {
					  // text: 'Export Excel',
					  // action: function (e, dt, button, config)
					  // {
						// dt.one('preXhr', function (e, s, data)
						// {
						  // data.length = 18446744073709551610 ;
						// }).one('draw', function (e, settings, json, xhr)
						// {
						  // var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
						  // var addOptions = { exportOptions: { 'columns': ':visible'} };
					 
						  // $.extend(true, excelButtonConfig, addOptions);
						  // excelButtonConfig.action(e, dt, button, excelButtonConfig);
						   // refreshtable();
						// }).draw();
					  // }
					// }
              // ],
              // "scrollX": true,
              // "processing": true,
              // "serverSide": true,
              // "destroy": true,
              // "ajax": "<?php echo base_url().'postbuyadspeformance2resmdp22/get_list_adspeformance'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
              // "searchDelay": 700,
              // "responsive": true,
              // "bSort": true,
              // "order": [[ 0, "asc"]],
              // "orderable": true,
              // "bFilter" : false,
              // "bInfo" : false,
              // "bLengthChange": false
          // });
          
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                   endDate: '0d',
                  defaultDate: new Date()
              });          
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY'));  
          });
         
          /* TO HANDLE ALL CHANNEL*/
          /* IF ALL CHANNEL CHECKED THE ANY OTHER CHANNEL THAN ALL CHANNEL WILL BE UN-CHECKED*/
          $('.urate-custom-menu > li > a').on('click',function(){
			  
			  if($(this).data('id') == 'get_chnl'){
			  
              if($(this).data('real') == "0" || $(this).data('real') == "1" || $(this).data('real') == "2"){
                  $('[data-for = "'+$(this).data('id')+'"]').each(function(){
                      $(this).removeClass('checked');
                  });
              }
              
			  
              if($(this).data('real') != "0"){
                  $('[data-real = "0"]').parent().removeClass('checked');
              }
              if($(this).data('real') != "1"){
                  $('[data-real = "1"]').parent().removeClass('checked');
              }
              if($(this).data('real') != "2"){
                  $('[data-real = "2"]').parent().removeClass('checked');
              }

				  var get_chnl = $('#get_chnl').val();  
				  var array_chn = get_chnl.split(',');
				  var array_sel = [];
				  var array_sel_fin = [];
				  
				  var err = 0;
				  var err_idx = 0;
				   for(i=0; i < array_chn.length; i++){

						   if($(this).data('real') == array_chn[i] ){
							   err = 1;
						   }else{
							   array_sel[err_idx] = array_chn[i];
							   err_idx++;
						   }

				   }
				   
 				   
				   
				   
				   if(err == 0){
					   array_sel[err_idx] = $(this).data('real');
				   }
				   
				   var err_idx_fin = 0;
				    for(ii=0; ii < array_sel.length; ii++){
						
						if(array_sel[ii] == "2" || array_sel[ii] == "1" || array_sel[ii] == "0"){
						
						}else{
						
							array_sel_fin[err_idx_fin] = array_sel[ii];
							err_idx_fin++;
						
						}
					}
					
					if(err_idx_fin == 0 || $(this).data('real') == "2" || $(this).data('real') == "1" || $(this).data('real') == "0"){
						
						$('#prog_selsss').html('');
						$('#prog_selsss').html(' <select style="width:100%;height:35px;" name="programss" id="programss" multiple ><option value="all" Selected="selected" >All Program</option>');
						
						$("#programss").select2({
								placeholder: "Silahkan Pilih"
						});
						
						
					}else{
						
						var form_data = {			
							  valselect : array_sel_fin,
							  start_date : $('#start_date').val(),
							  end_date : $('#end_date').val(),
							  profile : $('#profile').val()
						  };
						  
						   $.ajax({
							  type	: "POST",
							  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/list_program/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
							  data	: JSON.stringify(form_data),			
							  dataType: 'json',
							  contentType: 'application/json; charset=utf-8',
							  success	: function(response) {

								  
								  $('#prog_selsss').html('');
								  $('#prog_selsss').html(response.html);
								  
								$("#programss").select2({

									placeholder: "Silahkan Pilih"

								});
								
								
								const valuss = ['all'];

								
								$('#programss').on('select2:unselect', function(e) {
								 
								}).on('select2:select', function(e){
 								   if(e.params.data.id == 'all'){
									   
									   $('#programss').val('all').trigger('change');
									  //valuss[0] = "all";
								   }else{
									   var val = $("#programss").val();
									   
									   const valuss = [];
									   var ints = 0;
										for(i=0; i < val.length; i++){  
											if(val[i] == 'all'){
												
											}else{
												valuss[ints] = val[i];
											}
											
										ints++;
										}
										
										$('#programss').val(valuss).trigger('change');
									   
									   
								   }  
								});
								
							 
								 
							  }, error: function(obj, response) {
								  console.log('ajax list detail error:' + response);	
							  } 
						  });
						
					}
					
				
			  }
				   
 			  
			 
			  
          });
          /* END - TO HANDLE ALL CHANNEL*/                      
          
          $('#custom_get_chnl').click(function() {   
		  
               $(".search-channel-con").remove();                  
              
              var currChecked = $("#get_chnl").val();
			  
			 console.log($(this).parent());
              
              if(currChecked != ""){
                  $("[data-real='"+currChecked+"']").parent().addClass('checked');
              }
              
			 
			  
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_get_chnl").after(searchElement);       
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          });         
          
          $(".urate-close-modal").click(function() {
              $("#vload0")[0].pause();                 
              $("#vload1")[0].pause();                 
              $("#vload2")[0].pause();                 
              $("#vload3")[0].pause();                 
              $("#vload4")[0].pause();                 
              $("#vload5")[0].pause();                 
              $("#vload6")[0].pause();                 
              $("#vload7")[0].pause();                 
              $("#vload8")[0].pause();                 
              $("#vload9")[0].pause();                 
              $("#vload10")[0].pause();                 
              $("#vload11")[0].pause();                 
              $("#vload12")[0].pause();                 
              $("#vload13")[0].pause();                 
              $("#vload14")[0].pause();                 
              $("#vload15")[0].pause();                 
              $("#vload16")[0].pause();                 
              $("#vload17")[0].pause();                 
              $("#vload18")[0].pause();                 
              $("#vload19")[0].pause();                 
          });             
          
          $('[data-id="kategori_by"]').click(function() {
              $('.urate-select-dropdown').each(function(){
                  $(this).removeClass('active');
                  $(".search-channel-con").remove();        
              });
          });  
          
          $('[data-for="get_kategori"]').click(function() {
              $('.urate-select-dropdown').each(function(){
				  
 				  
                  $(this).removeClass('active');
                  $(".search-channel-con").remove();
                                                        
                  if($(this).closest('.urate-select-dropdown').hasClass('active')){
                      $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                  } else {
                      $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                  }        
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
               var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People 2021</a></li><li data-for='profile'><a href='#' data-real='1' class='urate-select-form-two' data-for='profile'>All People 2022</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                   dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
                       $("#profile").next().next().next().empty('');   
                      
                      for(i=0; i < response.length; i++){                       
                          if(response[0] == "Value not found!"){
                              strResult = response[0]; 
                              strText = response[0];
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
          
          //AJAXtify profile; profile by start date          
          $("#start_date").on("change",function(){
              $('#profile').empty('');
               var strVar = "<li data-for='profile'><a href='#' data-real='1' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                   dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
                       $("#profile").next().next().next().empty('');   
                      
                      for(i=0; i < response.length; i++){                       
                          if(response[0] == "Value not found!"){
                              strResult = response[0];
                              strText = response[0]; 
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
      $(document).ready(function(){
          $("#checkall").click(function () {
              $('input:checkbox').not(this).prop('checked', this.checked);
          });
      });
  </script>
 
  <script>
 
		function select_product(){
			
			var vals = $('#productss').val();
			console.log(vals);
			
			if(vals.length == 1){
				
			} else {
				if(vals[0] == 'all'){
					$("#strings").val(["Test", "Prof", "Off"]);
				}
			}
			alert(vals[0]);
			alert(vals.length);
			
		}
	  
		function generate_product (product) 
        {
            var user_id = $.cookie(window.cookie_prefix + "user_id");
			var token = $.cookie(window.cookie_prefix + "token");    
		  
			 var form_data = {			
                  valselect : product,
                  start_date : $('#start_date').val(),
                  end_date : $('#end_date').val(),
				  profile : $('#profile').val()
              };
			  
			   $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/list_product/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
                  data	: JSON.stringify(form_data),			
                  dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
					  
					  console.log(response);
					  
					  $('#div_product').show();
					  
					  $('#prod_sel').html('');
					  $('#prod_sel').html(response.html);
					  
					$("#productss").select2({

						placeholder: "Silahkan Pilih"

					});
					
				 
					const valuss = ['all'];

					
					$('#productss').on('select2:unselect', function(e) {
					  
					}).on('select2:select', function(e){
 					   if(e.params.data.id == 'all'){
						   
						   $('#productss').val('all').trigger('change');
 					   }else{
						   var val = $("#productss").val();
						   
						   const valuss = [];
						   var ints = 0;
						    for(i=0; i < val.length; i++){  
								if(val[i] == 'all'){
									
								}else{
									valuss[ints] = val[i];
								}
								
							ints++;
							}
							
							$('#productss').val(valuss).trigger('change');
						   
						   
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
           
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformance2resmdp22/get_list_adspeformance'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
              "searchDelay": 700,
              "responsive": true,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "orderable": true,
              "bFilter" : false,
              "bInfo" : false,
              "bLengthChange": false
          });
	  }
	  
	  
	  
	  
	  function refreshtablefilter(start_date, end_date, profile, get_kategori, kategori_by, get_chnl){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var table = $("#example").DataTable({
              
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformance2resmdp22/get_filter_adspeformance'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl,
              "searchDelay": 700,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "bInfo" : false,
              "orderable": true,
              "bLengthChange": false 
          });
	  }
	  
	  
      $(document).ready(function() {	
          $(".close").click(function() {
              $("#vload0")[0].pause();                 
              $("#vload1")[0].pause();                 
              $("#vload2")[0].pause();                 
              $("#vload3")[0].pause();                 
              $("#vload4")[0].pause();                 
              $("#vload5")[0].pause();                 
              $("#vload6")[0].pause();                 
              $("#vload7")[0].pause();                 
              $("#vload8")[0].pause();                 
              $("#vload9")[0].pause();                 
              $("#vload10")[0].pause();                 
              $("#vload11")[0].pause();                 
              $("#vload12")[0].pause();                 
              $("#vload13")[0].pause();                 
              $("#vload14")[0].pause();                 
              $("#vload15")[0].pause();                 
              $("#vload16")[0].pause();                 
              $("#vload17")[0].pause();                 
              $("#vload18")[0].pause();                 
              $("#vload19")[0].pause();                 
          });
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          
          // var table = $("#example").DataTable({
             // dom: 'Bfrtip',
              // 'buttons': [
                  // {
					  // text: 'Export Excel',
					  // action: function (e, dt, button, config)
					  // {
						// dt.one('preXhr', function (e, s, data)
						// {
						  // data.length = 18446744073709551610 ;
						// }).one('draw', function (e, settings, json, xhr)
						// {
						  // var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
						  // var addOptions = { exportOptions: { 'columns': ':visible'} };
					 
						  // $.extend(true, excelButtonConfig, addOptions);
						  // excelButtonConfig.action(e, dt, button, excelButtonConfig);
						   // refreshtable();
						// }).draw();
					  // }
					// }
              // ],
			 // "drawCallback": function( settings ) {
					// var api = this.api();
			 
 					 // api.rows( {page:'current'} ).data()
				// },			  
              // "scrollX": true,
              // "processing": true,
              // "serverSide": true,
              // "destroy": true,
              // "ajax": "<?php echo base_url().'postbuyadspeformance2resmdp22/get_list_adspeformance'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
              // "searchDelay": 700,
              // "responsive": true,
              // "bSort": true,
              // "order": [[ 0, "asc"]],
              // "orderable": true,
              // "bFilter" : false,
              // "bInfo" : false,
              // "bLengthChange": false
          // });
          
          $('button.showHideColumn').on( 'click', function (e) {
              e.preventDefault();
               var tableColumn = table.column( $(this).attr('data-columnindex') );
              console.log(tableColumn);
              tableColumn.visible( ! tableColumn.visible() );
          });
          
          /* show hide use checkbox */
          $('#showHideColumn').on( 'click', function (e) {
              e.preventDefault();
              $(this).is(":checked");
               var tableColumn = table.column( $(this).attr('data-columnindex') );
              console.log(tableColumn);
              tableColumn.visible( ! tableColumn.visible() );
          });
          
          //table.ajax.reload();
      
      });
  
      // get_kategori	
      $( document ).ready(function() {   
          $('#processButton').on('click', function() { 
		   
              filter_adspeformance();  
          });
          
          $("#custom_get_kategori").on("click",function(){
              $("#custom_kategori_by").parent().removeClass('active');
			  
          });
          
          function generate_category (cat) 
          {
              var user_id = $.cookie(window.cookie_prefix + "user_id");
              var token = $.cookie(window.cookie_prefix + "token");    
              
              $('#get_kategori').empty('');
              
              var form_data = {			
                  valselect : cat,
                  start_date : $('#start_date').val(),
                  end_date : $('#end_date').val()
              };
			  
 			  
				$('#div_product').hide();	
 				const valuss = ['all'];
				$('#productss').val(valuss).trigger('change');				
 
              
              var profile = $('#profile').val();
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/list_subkategori/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
                  data	: JSON.stringify(form_data),			
                  dataType: 'json',
                  contentType: 'application/json; charset=utf-8',
                  success	: function(response) {
					  
					  console.log(response);
					 
					  
                      $('#custom_get_kategori').hide();
                      $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                      $('#custom_get_kategori').delay(3000).fadeIn(500);
                                          
                      var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid; background: #fff;' class='search-con'><input type='text' name='search_subcat' id='search_subcat' class='form-control urate-form-input' value='' onkeyup='search_subcat()' paceholder='Search Sub Category'></div>";
                      
					  
					  
                      $("#custom_get_kategori").on("click",function(){
                          $("#custom_kategori_by").parent().removeClass('active');
                          
                          if($(this).parent().hasClass('active')){
                              $(".search-con").remove();
                              $("#custom_get_kategori").after(searchElement);   
                              $("#search_subcat").focus();
                          } else {
                              $(".search-con").remove();
                          }
                      });
					  
					  
					  
					   
                       $("#get_kategori").next().next().html("<li><a href='javascript:void(0)' data-real='All' class='urate-select-form-two' data-for='get_kategori'>All</a></li>");
					  
					  $('[data-real = "All"]').click(function() { 
								

                                  $('#get_kategori').next().html('All');
                                  $('#get_kategori').attr('value','All');
                                  
                                  $(this).closest('.default').removeClass('active');     
                                  $(".search-con").remove();  
                                  
                                  $('.urate-select-dropdown').each(function(){
                                      $(this).removeClass('active');
                                      $(".search-channel-con").remove();
									  
									 
                                                        
                                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                                      } else {
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                                      }        
                                  });
                              });
							  
							  
                      $.each(response.data, function (index, value) {
						   
                               var strVar="";
                               strVar += '<li><a href="javascript:void(0)" data-real="'+value.SUBCAT+'" class="urate-select-form-two" data-for="get_kategori">'+value.SUBCAT+'</a></li>';
                              $("#get_kategori").next().next().append(strVar); 
                              
                              $("[data-real = '"+value.SUBCAT+"']").click(function() { 
								
 								if(cat == 'NAMA_BRAND'){
								 
									generate_product(value.SUBCAT); 
									
								}else{
									
									 $('#div_product').hide();
								}
							  
                                  $('#get_kategori').next().html(value.SUBCAT);
                                  $('#get_kategori').attr('value',value.SUBCAT);
                                  
                                  $(this).closest('.default').removeClass('active');     
                                  $(".search-con").remove();  
                                  
                                  $('.urate-select-dropdown').each(function(){
                                      $(this).removeClass('active');
                                      $(".search-channel-con").remove();
									  
									 
                                                        
                                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                                      } else {
                                          $('#custom_get_kategori').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                                      }        
                                  });
                              });
                      });
                  }, error: function(obj, response) {
                      console.log('ajax list detail error:' + response);	
                  } 
              });
          }
          
          $('#custom_kategori_by').click(function() {
              $("#custom_get_kategori").parent().removeClass('active');
              $(".search-con").remove();
              
              $("[data-real='NAMA_BRAND'").click(function(){  
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                  
                  $('#get_kategori').next().text('Please Choose Product ...');
                  $('#get_kategori').next().next().html(' '); 
				  
                  generate_category('NAMA_BRAND');
               }); 
              
              $("[data-real='ADVERTISER'").click(function(){
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                  
                  $('#get_kategori').next().text('Please Choose Advertiser ...');
                  $('#get_kategori').next().next().html(' '); 
                  generate_category('ADVERTISER');
              });
              
              $("[data-real='AGENCY'").click(function(){
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                  
                  $('#get_kategori').next().text('Please Choose Agency ...');
                  $('#get_kategori').next().next().html(' '); 
                  generate_category('AGENCY');
              });
			  
              $("[data-real='PO_NUMBER'").click(function(){
                  $('#custom_get_kategori').hide();
                  $('#loader2').fadeIn(500).delay(500).fadeOut(500);
                  $('#custom_get_kategori').delay(3000).fadeIn(500);
                                    
                  $('#get_kategori').next().text('Please Choose HOUSE NUMBER ...');
                  $('#get_kategori').next().next().html(' '); 
                  generate_category('PO_NUMBER');
              });
          });         
      });	   
      
       $( document ).ready(function() {

		  	$("#programss").select2({
						placeholder: "Silahkan Pilih"
			});
			
			
			$("multiselect-dropdown").hide();
			
			
          $('.urate-download-btn').on('click', function(){
  
              $(this).hide();
              $('#loader3').fadeIn(500).delay(500).fadeOut(500);
              $(this).delay(3000).fadeIn(500);
          });
      });                
  	
		function hhh(){
			var chart = $('#container').highcharts();
			
		 
							chart.exportChart({
								type: 'image/png',
								filename: 'Audience By Day'
							});
							
							
			
		}
	
	function export_excel(){
		
		 var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var profile = $('#profile').val();
          if(profile === ''){			
              alert('Please, Select Profile');
              return false;
          }
          
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
          
          var kategori_by = $('#kategori_by').val(); 
          var get_kategori = $('#get_kategori').val();    
          var get_chnl = $('#get_chnl').val();  
		   var get_product = $('#productss').val();  
		    var get_program = $('#programss').val();  
          
          if(kategori_by === ''){			
              alert('Please, Select Category');
              return false;
          }
          
          if(get_kategori === ''){			
              alert('Please, Select Sub Category');
              return false;
          }
          
          if(get_chnl === ''){			
              alert('Please, Select Channel');
              return false;
          }
		  
		   var form_data = {			
								  start_date : start_date,
								  end_date : end_date,
								  get_kategori : get_kategori,
								  profile : profile,
								  kategori_by : kategori_by,
								  get_chnl : get_chnl,
								  get_product : get_product,
								  get_program : get_program
							  };
							  
							  	$.ajax({
								  type	: "POST",
								  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/print_excel/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
								  data	: JSON.stringify(form_data),			
								  dataType: 'json',
								  contentType: 'application/json; charset=utf-8',
								  success	: function(response) {
									  
									  download_file('<?php echo $donwload_base; ?>tmp_doc/Postbuy_analytics.xls','Postbuy_analytics.xls');
								
									}, error: function(obj, response) {
									  console.log('ajax list detail error:' + response);	
									} 
								});
		  
		  
		
	}
	
	function export_pdf(){
		
		 var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var profile = $('#profile').val();
          if(profile === ''){			
              alert('Please, Select Profile');
              return false;
          }
          
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
          
          var kategori_by = $('#kategori_by').val(); 
          var get_kategori = $('#get_kategori').val();    
          var get_chnl = $('#get_chnl').val();  
		    var get_product = $('#productss').val(); 
 var get_program = $('#programss').val();  			
          
          if(kategori_by === ''){			
              alert('Please, Select Category');
              return false;
          }
          
          if(get_kategori === ''){			
              alert('Please, Select Sub Category');
              return false;
          }
          
          if(get_chnl === ''){			
              alert('Please, Select Channel');
              return false;
          }
		  
		  var chart = $('#container').highcharts();
		  
		  	let svgString = chart.getSVG();

							let parser = new DOMParser(); 
							let svgElem = parser.parseFromString(svgString, "image/svg+xml").documentElement;
							
 							var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
							
							var canvas = document.createElement( "canvas" );
							var ctx = canvas.getContext( "2d" );

							var img = document.createElement( "img" );
							
							img.setAttribute( "src",svgData );

							img.onload = function() {
								
								canvas.width = img.width;
								canvas.height = img.height;
								ctx.drawImage( img, 0, 0 );
								
								var pngm = canvas.toDataURL( "image/png" ) 
								
								 var form_data = {			
								  start_date : start_date,
								  end_date : end_date,
								  get_kategori : get_kategori,
								  profile : profile,
								  kategori_by : kategori_by,
								  get_chnl : get_chnl,
								  svg : pngm,
								  get_product : get_product,
								  get_program : get_program
							  };
							  
							 
							  	$.ajax({
								  type	: "POST",
								  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/print_pdf_2/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
								  data	: JSON.stringify(form_data),			
								  dataType: 'json',
								  contentType: 'application/json; charset=utf-8',
								  success	: function(response) {
									  
									  download_file('<?php echo $donwload_base; ?>tmp_doc/Report_Postbuy_urban.pdf','Report_Postbuy_urban.pdf');
								
									}, error: function(obj, response) {
									  console.log('ajax list detail error:' + response);	
									} 
								});
							  
							 };							

		  
		  
		
	}
	
      /* filtering searching */
      function filter_adspeformance(){
          $('[data-for="get_chnl"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $('[data-for="kategori_by"]').parent().parent().removeClass("active");
          $('[data-for="get_kategori"]').parent().parent().removeClass("active");
          
          $("#loader_summary").css("display","block");
          $(".urate-panel-title").html("Result");  
          $("#textket").html("<h3>Summary</h3>");
          $("#spot").html("");
          $("#sumcost").html("");
          $("#sumviewers").html("");
          $("#sumtvr").html("");
          $("#cprp").html("");
          $("#maxtvr").html("");
          $("#mintvr").html("");
          $("#avgtvr").html("");
          $("#costpview").html("");
          
          $("#loader_reach").css("display","block");
          $("#textketr").html("<h3>Reach & Frequency</h3>");
          $("#r0").html("");
          $("#r2").html("");
          $("#r3").html("");
          $("#r7").html("");
          $("#r13").html("");
          $("#r21").html(""); 
          $("#avgfreq").html("");
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
          var profile = $('#profile').val();
          if(profile === ''){			
              alert('Please, Select Profile');
              return false;
          }
          
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
          
          var kategori_by = $('#kategori_by').val(); 
          var get_kategori = $('#get_kategori').val();    
          var get_chnl = $('#get_chnl').val();  
          var get_product = $('#productss').val();  
          var get_program = $('#programss').val();  
          
          if(kategori_by === ''){			
              alert('Please, Select Category');
              return false;
          }
          
          if(get_kategori === ''){			
              alert('Please, Select Sub Category');
              return false;
          }
          
          if(get_chnl === ''){			
              alert('Please, Select Channel');
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
								
								 var form_data = {			
								  start_date : start_date,
								  end_date : end_date,
								  get_kategori : get_kategori,
								  profile : profile,
								  kategori_by : kategori_by,
								  get_chnl : get_chnl,
								  get_product : get_product,
								  get_program : get_program
							  };
							  
							  	$.ajax({
								  type	: "POST",
								  url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/print_excel/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token + "&profile=" + profile,
								  data	: JSON.stringify(form_data),			
								  dataType: 'json',
								  contentType: 'application/json; charset=utf-8',
								  success	: function(response) {
									  
									  download_file('<?php echo $donwload_base; ?>tmp_doc/Postbuy_analytics.pdf','Postbuy_analytics.pdf');
								
									}, error: function(obj, response) {
									  console.log('ajax list detail error:' + response);	
									} 
								});
							  
													

					  }
					},
				 
              ],
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformance2resmdp22/get_filter_adspeformance'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&chnl=" + get_chnl+ "&get_program=" + get_program + "&get_product=" + get_product ,
              "searchDelay": 700,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "bInfo" : false,
              "orderable": true,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-result').show();
                 
              },
              "fnDrawCallback":function(){
                  
              },
              "fnInitComplete":function(){
                  
					  var x = document.getElementsByClassName("buttons-excel");
					  
					  if (x.length > 0){
						  x = x[0];
					  }
					  
					  var excelButton = $(".buttons-excel").detach();
					  
					  $(".buttonExcel").append( excelButton );
					  $(".buttonExcel").show();
 					  
					  /* show hide use href */
					  $('button.showHideColumn').on( 'click', function (e) {
						  e.preventDefault();
						  var tableColumn = table.column( $(this).attr('data-columnindex') );
						  console.log(tableColumn);
						  tableColumn.visible( ! tableColumn.visible() );
					  });
					  
					  /* show hide use checkbox */
					  $('#showHideColumn').on( 'click', function (e) {
						  e.preventDefault();
						  $(this).is(":checked");
						  var tableColumn = table.column( $(this).attr('data-columnindex') );
						  console.log(tableColumn);
						  tableColumn.visible( ! tableColumn.visible() );
					  });
					  
					  table.ajax.reload();
					  
					  /* grand total */      

					 $.ajax({
						  url : "<?php echo base_url().'postbuyadspeformance2resmdp22/get_filter_grandtotal_adspeformance_summ'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by +"&get_program=" + get_program +  "&chnl=" + get_chnl+ "&get_product=" + get_product ,
						  success: function(response) {
							 
							  $("#summ_tab_1").html(response.data[0]);
							  
				 
						    $("#summ_tab_2").html(response.data[1]);
						   
						Highcharts.chart('container', {
						  chart: {
							  type: 'column'
						  },
						  exporting: { enabled: false } ,
						  title: {
							   text: "<strong>Campaign " + get_kategori +"</strong>",
								align: 'left'
						  },
						  subtitle: {
 						  },
						  xAxis: {
							  categories: response.data[2]
						  },
						  yAxis: {
							  title: {
								  text: 'Views' 
							  }
						  },
						  plotOptions: {
							  line: {
								  dataLabels: {
									  enabled: false // true
								  },
								  enableMouseTracking: true
							  }
						  },
						  series: [{
							  name: 'Views', 
							  data: response.data[3],
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
							  borderColor: '#AAA'
						  }
					  });
						
 
							
						  },
						  error: function(obj, response) {
						  console.log('ajax list_project error:' + response);
 
						  }					
					  });	
 
              },  
          });
                    
					
		var table = $("#example2").DataTable({
              
              "scrollX": true,			   
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": "<?php echo base_url().'postbuyadspeformance2resmdp22/get_filter_adspeformance2'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&get_program=" + get_program + "&chnl=" + get_chnl+ "&get_product=" + get_product ,
              "searchDelay": 700,
              "responsive": true,
              "bFilter" : false,
              "bSort": true,
              "order": [[ 0, "asc"]],
              "bInfo" : false,
              "orderable": true,
              "bLengthChange": false,
              "fnPreDrawCallback":function(){
                  $('.urate-panel-result').show();
 
              },
              "fnDrawCallback":function(){
    
              },
              "fnInitComplete":function(){
 
					  var x = document.getElementsByClassName("buttons-excel");
					  
					  if (x.length > 0){
						  x = x[0];
					  }
					  
					  var excelButton = $(".buttons-excel").detach();
					  
					  $(".buttonExcel").append( excelButton );
					  $(".buttonExcel").show();
					  //end export button excel                    
					  
					  /* show hide use href */
					  $('button.showHideColumn').on( 'click', function (e) {
						  e.preventDefault();
						  var tableColumn = table.column( $(this).attr('data-columnindex') );
						  console.log(tableColumn);
						  tableColumn.visible( ! tableColumn.visible() );
					  });
					  
					  /* show hide use checkbox */
					  $('#showHideColumn').on( 'click', function (e) {
						  e.preventDefault();
						  $(this).is(":checked");
						  var tableColumn = table.column( $(this).attr('data-columnindex') );
						  console.log(tableColumn);
						  tableColumn.visible( ! tableColumn.visible() );
					  });
					  
					  table.ajax.reload();
					  
					  /* grand total */      

					 $.ajax({
						  url : "<?php echo base_url().'postbuyadspeformance2resmdp22/get_filter_grandtotal_adspeformance_summ2'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&end_date=" + end_date + "&profile=" + profile + "&get_kategori=" + get_kategori + "&kategori_by=" + kategori_by + "&get_program=" + get_program + "&chnl=" + get_chnl+ "&get_product=" + get_product ,
						  success: function(response) {
							 
							
							$("#summ_odo2").html(response.data['tbl']);
							$("#summ_odo3").html(response.data['tbl2']);
 
					  
					  
						$('#processButton').delay(1000).fadeIn();
							  $("#loader").hide();
							  $('.loader').css('display','none');
							  $('#processButton').show();
							
						  },
						  error: function(obj, response) {
						  console.log('ajax list_project error:' + response);
 
						  
						  }					
					  });	
 
              },  
          });
  	  
          
      }
  	
      /* destroy all datatable */
      function destroy_databale(){
          $( "#example" ).empty();
          $( "#example_paginate").empty();
          $( ".dataTables_paginate paging_simple_numbers").empty();
          $( "#textket" ).empty();
          $( "#sumcost" ).empty();
          $( "#sumviewers" ).empty();
          $( "#sumtvr" ).empty();
      }
      
      function vid_program(video, title, filename, stvid, duration){
          $.ajax({
              url:filename,
              type:'HEAD',
              error: function()
              {
                  $("#video_url").html('<img alt="img" src="img/novid.png" style="display:block; margin-left:auto; margin-right:auto; padding-top:30px;"><p style="text-align:center; font-size:24px; padding-left:100px; padding-right:100px; padding-top:30px; padding-bottom:30px;">Ooppss! Video is unavailable</p>');
                  $(".urate-download-btn").hide();
              },
              success: function()
              {
                  $("#video_url").html('<video autoplay  id= "vload0" width="100%" height="240" controls preload="none" data-flname="'+filename+'" data-stvid="'+stvid+'" data-duration="'+duration+'"><source src="'+video+'"> type="video/mp4">Your browser does not support the video tag.</video>');
                  $(".urate-download-btn").show();
              }
          });
 
          $("#modal_video_program1").modal();
          $("#my_program1").html( title );
          $(".urate-download-btn").attr('href','<?php echo site_url("postbuyadspeformance/download_video/?f='+filename+'&s='+stvid+'&d='+duration+'") ?>');
          
          var vids = $("video"); 
          $.each(vids, function(){
              this.controls = false; 
          }); 
      }
  
      function vid_iklan(id){
          switch (id) {
              case 0:
                  $("#modal_video_iklan1").modal();
                  break;
              case 1:
                  $("#modal_video_iklan2").modal();
                  break;
              case 2:
                  $("#modal_video_iklan3").modal();
                  break;
              case 3:
                  $("#modal_video_iklan4").modal();
                  break;
              case 4:
                  $("#modal_video_iklan5").modal();
                  break;
              case 5:
                  $("#modal_video_iklan6").modal();
                  break;
              case 6:
                  $("#modal_video_iklan7").modal();
                  break;
              case 7:
                  $("#modal_video_iklan8").modal();
                  break;
              case 8:
                  $("#modal_video_iklan9").modal();
                  break;
              case 9:
                  $("#modal_video_iklan10").modal();
                  break;
          }
      }
  
      // /* show video program */
      $(document).on("click", ".get_video", function () {
          var myBookId = $(this).data('id');
          $("#my_program1").html( myBookId );
      });
      
      // /* show video iklan */
      $(document).on("click", ".get_video_iklan", function () {
          var myBookId = $(this).data('id');
          $("#my_program1").html( myBookId );
      });
  
      /* change color show hide datatable */
      $(document).ready(function(){
          $('.test_btn').click(function(){
              if(!$(this).hasClass('selected')){
                  $(this).addClass('selected');
                  $(this).removeClass('test_btn');
              } else if(!$(this).hasClass('test_btn')) {
                  $(this).addClass('test_btn');
                  $(this).removeClass('selected');
              }
          });
      });           
      
      function search_subcat(){
           var cat = $('#kategori_by').val();
          var query = $('#search_subcat').val();
		    
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#get_kategori').empty('');
          
          var strVar = "";
          var strResult = "";
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&c=" + cat + "&start_date=" + start_date + "&end_date=" + end_date ,
               dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                   $("#get_kategori").next().next().next().empty('');
                  
                  for(i=0; i < response.length; i++){
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
                          strResult = response[i].SEARH_RESULT;
                      }
                           
                      strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='get_kategori'>"+strResult+"</a></li>";                          
                  } 
                                        
                  $("#get_kategori").next().next().next().append(strVar);   
                                    
                  $('[data-for = "get_kategori"]').click(function() {
                       $('#get_kategori').next().text($(this).data("real"));
                      $('#get_kategori').attr('value',$(this).data("real"));
                      
                      $(this).closest('.default').removeClass('active');  
                      
                      $(".search-con").remove();                        
                  });                                         
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          }); 
      }   
      
      function search_channel(){
        //console.log("SINI!");
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "<li data-for='channel'><a href='#' data-real='0' class='urate-select-form-two' data-for='channel'>All Channel</a></li><li data-for='channel'><a href='#' data-real='1' class='urate-select-form-two' data-for='channel'>All UseeTV</a></li><li data-for='channel'><a href='#' data-real='2' class='urate-select-form-two' data-for='channel'>All Mediahub</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#get_chnl").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].CHANNEL;
                    }
                    
                     strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#get_chnl").next().next().next().append(strVar);   
                
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
	
    function search_profile(){
         var query = $('#search_profile').val(); 
        var period = $('#start_date').val();
        
        $('#profile').empty('');
        
        var strVar = "<li data-for='profile'><a href='#' data-real='1' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'postbuyadspeformance2resmdp22/profilesearch/'; ?>"+"?q="+query+"&f="+period,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#profile").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
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
	
	function svgString2Image(svgString, width, height, format, callback) {
    // set default for format parameter
    format = format ? format : 'png';
    // SVG data URL from SVG string
    var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
    // create canvas in memory(not in DOM)
    var canvas = document.createElement('canvas');
    // get canvas context for drawing on canvas
    var context = canvas.getContext('2d');
    // set canvas size
    canvas.width = width;
    canvas.height = height;
    // create image in memory(not in DOM)
    var image = new Image();
    // later when image loads run this
    image.onload = function () { // async (happens later)
        // clear canvas
        context.clearRect(0, 0, width, height);
        // draw image with SVG data to canvas
        context.drawImage(image, 0, 0, width, height);
        // snapshot canvas as png
        var pngData = canvas.toDataURL('image/' + format);
        // pass png data URL to callback
        callback(pngData);
    }; // end async
    // start loading SVG data into in memory image
    image.src = svgData;
	
	return 
}
	
  </script>	
  
  <script type="text/javascript">
 

SVGElement.prototype.toDataURL = function(type, options) {
	var _svg = this;
	
	function debug(s) {
		console.log("SVG.toDataURL:", s);
	}

	function exportSVG() {
		var svg_xml = XMLSerialize(_svg);
		var svg_dataurl = base64dataURLencode(svg_xml);
		debug(type + " length: " + svg_dataurl.length);

		// NOTE double data carrier
		if (options.callback) options.callback(svg_dataurl);
		return svg_dataurl;
	}

	function XMLSerialize(svg) {
 
		function XMLSerializerForIE(s) {
			var out = "";
			
			out += "<" + s.nodeName;
			for (var n = 0; n < s.attributes.length; n++) {
				out += " " + s.attributes[n].name + "=" + "'" + s.attributes[n].value + "'";
			}
			
			if (s.hasChildNodes()) {
				out += ">\n";

				for (var n = 0; n < s.childNodes.length; n++) {
					out += XMLSerializerForIE(s.childNodes[n]);
				}

				out += "</" + s.nodeName + ">" + "\n";

			} else out += " />\n";

			return out;
		}

		
		if (window.XMLSerializer) {
 			return (new XMLSerializer()).serializeToString(svg);
		} else {
 			return XMLSerializerForIE(svg);
		}
	
	}

	function base64dataURLencode(s) {
		var b64 = "data:image/svg+xml;base64,";

 		if (window.btoa) {
 			b64 += btoa(s);
		} else {
 			b64 += Base64.encode(s);
		}
		
		return b64;
	}

	function exportImage(type) {
		var canvas = document.createElement("canvas");
		var ctx = canvas.getContext('2d');

 
		var svg_img = new Image();
		var svg_xml = XMLSerialize(_svg);
		svg_img.src = base64dataURLencode(svg_xml);

		svg_img.onload = function() {
			debug("exported image size: " + [svg_img.width, svg_img.height])
			canvas.width = svg_img.width;
			canvas.height = svg_img.height;
			ctx.drawImage(svg_img, 0, 0);

 			var png_dataurl = canvas.toDataURL(type);
			debug(type + " length: " + png_dataurl.length);

			if (options.callback) options.callback( png_dataurl );
			else debug("WARNING: no callback set, so nothing happens.");
		}
		
		svg_img.onerror = function() {
			console.log(
				"Can't export! Maybe your browser doesn't support " +
				"SVG in img element or SVG input for Canvas drawImage?\n" +
				"http://en.wikipedia.org/wiki/SVG#Native_support"
			);
		}

 	}

	function exportImageCanvg(type) {
		var canvas = document.createElement("canvas");
		var ctx = canvas.getContext('2d');
		var svg_xml = XMLSerialize(_svg);
 

		var keepBB = options.keepOutsideViewport;
		if (keepBB) var bb = _svg.getBBox();

 		canvg(canvas, svg_xml, { 
			ignoreMouse: true, ignoreAnimation: true,
			offsetX: keepBB ? -bb.x : undefined, 
			offsetY: keepBB ? -bb.y : undefined,
			scaleWidth: keepBB ? bb.width+bb.x : undefined,
			scaleHeight: keepBB ? bb.height+bb.y : undefined,
			renderCallback: function() {
				debug("exported image dimensions " + [canvas.width, canvas.height]);
				var png_dataurl = canvas.toDataURL(type);
				debug(type + " length: " + png_dataurl.length);
	
				if (options.callback) options.callback( png_dataurl );
			}
		});

 		return canvas.toDataURL(type);
	}

	// BEGIN MAIN

	if (!type) type = "image/svg+xml";
	if (!options) options = {};

	if (options.keepNonSafe) debug("NOTE: keepNonSafe is NOT supported and will be ignored!");
	if (options.keepOutsideViewport) debug("NOTE: keepOutsideViewport is only supported with canvg exporter.");
	
	switch (type) {
		case "image/svg+xml":
			return exportSVG();
			break;

		case "image/png":
		case "image/jpeg":

			if (!options.renderer) {
				if (window.canvg) options.renderer = "canvg";
				else options.renderer="native";
			}

			switch (options.renderer) {
				case "canvg":
					debug("using canvg renderer for png export");
					return exportImageCanvg(type);
					break;

				case "native":
					debug("using native renderer for png export. THIS MIGHT FAIL.");
					return exportImage(type);
					break;

				default:
					debug("unknown png renderer given, doing noting (" + options.renderer + ")");
			}

			break;

		default:
			debug("Sorry! Exporting as '" + type + "' is not supported!")
	}
}
</script>