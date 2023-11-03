
	<!-- Google Fonts -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

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
  
  <style>
      .jstree-themeicon{
          display: none !important;
      }
      
      .dropdown-menu{
          margin-top: 0px !important;
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
      .dataTables_filter {
          margin-right: 15px;
      }
      
      .table > thead > tr > th > img {
          width: 16px;
          float: right;
      }              
      
      .table th {
        background: #ffffff !important;
		 padding: 0 0 0 0;
      }        
	  
	  p {
		  
		  margin: 0 0 0 0;
		  padding: 0 0 0 0;
		  
	  }
	  

      .checkbox .label-text {
        margin-left: 30px;
        width: 300px;
        text-align: left;
      }     
      
      #viswitch label {
        width: 100%;
      }
      
      #menusoptmsg{
        border-radius: 20px;
        border: 1px solid #CC3300;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-right: 10px;
        padding-left: 10px;
        padding-left: 20px;
        padding-right: 20px;
        color: #CC3300;
        font-weight: bold;
        text-align: center;
        display: none;
      }
	  
	   .parameter-box .urate-panel {
		  
		  border-radius:5px;
	  }
	  
	    .parameter-box.result .urate-panel .panel-body {
			height: 180px;
		}
  </style>
		
		<!-- / Sidebar -->
		<div class="content-wrapper">
			<div class="container-fluid">
          <div class="row">
              <div class="col-md-5">
                  <ol class="breadcrumb">
                  </ol>
                  <h3 class="page-title-inner"><strong>Urban Profiling</strong></h3>
              </div>      
			<div class="col-md-7 text-right">
					<button class="button_white" onclick="location.href='<?php echo base_url();?>ressummary'"  ><a class="fa fa-list-alt" style="color:black;"></a>&nbsp Profiling Summary </button>
					<button class="button_black" data-toggle="modal" data-target="#modalNewProfile"><span class="ion-plus"></span> Create Profile </button>
				</div>					  
          </div>
                
      <span id="alertini"></span>
				<!-- List Profile -->
				<div class="list-profile-head">
					<div class="pull-left">
						<h3><strong>Profile List</strong></h3>
					</div>
					<div class="pull-right">
						<div class="text-right">

						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="row" >
                     <div class="col-md-12" style="margin-top:-30px">
						<table aria-describedby="mydesc"   id="example" class="table table-striped" style="margin-top:-20px;border:none">
						  <thead style="color:red">
							<tr>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Profile Name</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Date Created</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Respondent</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Population</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Done</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Progres Meter</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Status</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Delete</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Export</p></th>
							</tr>
						  </thead>
						</table>
					</div>        
				</div>        
        
				<!-- Combine Profile -->
				<div class="panel urate-panel">
					<div class="panel-headings">
						<div class="col-lg-12" style="margin-bottom:20px;">	
							<div class="urate-panel">
								<div class="navbar-left" style="padding-left:10px;">
									<h4 class="title-periode2" style="font-weight: bold;">Combine Profile</h4>
								</div>
								<div class="navbar-right" style="padding-right:20px;padding-top:10px;">
									<button class="button_black" data-toggle="modal"  onClick="load_combine()" ><em class="fa fa-hourglass-o" aria-hidden="true"></em> &nbsp Combine</button>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel-body" >
							<div class="row">
								<div class="col-md-5">
									<div class="profile-selector">
									
									</div>
									<div class="urate-tag-panel" style="background-color:#F7F7F7;" id="combinePanel">
										<div class="panel-header">
											<div class="rows" style="float:left:width:100%">
												<div class="col-lg-6">	
												<h4 class="title-periode2" style="font-weight: bold;">Profile List</h4>
												</div>
												<div class="col-lg-6" >	
												<button onClick="all_profile('channels')" id="btn_all" class="button_white" style="background-color:#EF0000;border:none;color:#fff;float: right;margin-top:5px" id="all_profile">Select All</button>
												</div>
											</div>
											
										</div>
							
										<input id="list_combine" type="hidden"></input>
											<input id="list_combine_text" type="hidden"></input>
										<div class="col-lg-12">	
											<hr />
										</div>

										
										<div class="panel-body" style="margin-top:30px">
										<?php 
											 foreach($listprofile as $new){
													echo '<button class="button_white" id="profile_'.$new['id'].'" style="margin-right:10px;margin-bottom:5px;border:solid 2px #E5E5E5" onclick="sel_profile(\''.$new['name'].'|'.$new['id'].'\')" >'.$new['name'].' &nbsp  <em class="fa fa-list-alt" style="color:#fff;"></em></button>';		
											  };?>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="urate-tag-panel" style="background-color:#F7F7F7" id="combinePanel">
										<div class="panel-header">
											<h4 class="tag-panel-titles" style="margin-left: 15px;"><strong>Selected Profile</strong></h4>
										</div>
										<div class="col-lg-12">	
											<hr id="hrr" />
										</div>
										<div class="panel-body">
                                                <div class="row" id="listrt"></div>
										</div>
									</div>
								</div>
								
							</div>
					</div>

				</div>
				<!-- / Combine Profile -->
				<!-- /List Profile -->
				<!-- / Content -->
			</div>
		</div>
	
	<!-- Modal New Profile -->
	<div class="modal fade" id="modalNewProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Create Profile</h4>
				</div>
				<div class="modal-body">
					<form action="#">
            <div class="col-lg-6 col-md-6">   
    						<!-- Treebox -->
                <div class="parameter-box" >
												<div class="panel urate-panel" style="background-color:#F6F6F6">
													<div class="panel-headings">
													 
															<div class="form-group" style="padding:15px">
																<label for="" style="margin-bottom:10px">Parameter</label><br>
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
  										<div class="panel urate-panel" style="background-color:#F6F6F6">
											<div class="panel-body" style="height: 450px">
												<label for="" style="margin-bottom:10px"><strong>Profile Id</strong></label>
												<div class="form-group">
													<label>Name</label>
													<input type="text" class="form-control urate-form-input" style="border: 1px solid #9b9b9b;" placeholder="Profile Name" id="crname" name="crname">
												</div>
												<div class="form-group">
													<label>Favorite</label>
														<div class="favorite-box result">
															<div class="panel urate-panel">
																<div class="panel-body" style="height: 40px">
																	 <span id="facs"></span>
																</div>
															</div>
														</div>									
												</div>
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
								</div>
    						</div>
				      </div>        
					</form>
        </div>
				<div class="modal-footer">
					<button type="button" class="button_white" data-dismiss="modal" aria-label="Close"><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_black" id="savecr" onclick="getCreateCr()"><em class="fa fa-check"></em>&nbsp Save New Profile</button>
                    
					<span id="laod"></span>
													
				</div>
			</div>
		</div>
	</div>
	<!-- / Modal -->
	<!-- Modal Combine Profile -->
	<div class="modal fade" id="modalCombineProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Combine Profile</h4>
				</div>
				<div class="modal-body">
					<form action="">
						<div class="form-group">
							<input type="text" class="form-control urate-form-input" placeholder="Profile Name" id="name" name="name">
						</div>
					</form>
					
					<div id='error_body2'></div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="button_black" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_white" id="savecombine" onclick="getCreate()"><em class="fa fa-check"></em> &nbsp Combine</button>
                    <span id="laodCombine"></span>
									
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="errormodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title center" id="myModalLabel">Error</h4>
				</div>
				<div class="modal-body" id='error_body'>
					
				</div>
				<div class="modal-footer">
					
									
				</div>
			</div>
		</div>
	</div>


  <!-- Modal Delete Profile -->
	<div class="modal fade" id="modalDeleteProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Delete Profile</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to delete?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_black"><em class="fa fa-check"></em> &nbsp Delete</button>
				</div>
			</div>
		</div>
	</div> 
	
	  <!-- Modal Export Profile -->
	<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Export</h4>
				</div>
				<div class="modal-body">
                  <div class="row">
                      <!-- PERIODE FIELD -->
                      <div class="dataset col-md-12" >
                          <div class="dataset-title">
                              <h4 class="title-text">From To Period</h4>
                          </div>
                          <div class="input-group input-daterange">
                              <input type="text" style=" z-index: 10000 !important;" class="form-control " name="start_date" id="start_date" value="" placeholder="From ..." autocomplete="off" />
                              <div class="input-group-addon">-</div>
                              <input type="text" style=" z-index: 10000 !important;" class="form-control " name="end_date" id="end_date" value="" placeholder="To ..." autocomplete="off" />
                          </div>
                      </div>  
				   </div>
				   
				</div>
				<div class="modal-footer">
					<button type="button" class="button_white"  data-dismiss="modal" ><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_black" id="expjobprocess"><em class="fa fa-download"></em> &nbsp Export</button>
				</div>
			</div>
		</div>
	</div>
  
  <!-- Modal Process Job -->
	<div class="modal fade" id="modalProcessJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Process Job Option</h4>
				</div>
				<div class="modal-body">
          <!-- Periode to Proccess Option -->
          <p style="font-weight: bold;">Periode to Proccess</p>
          <div id="periodelist"></div>
          <div id="menusoptmsg">Choose periode to proccess!</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="button_white" data-dismiss="modal"><em class="fa fa-times"></em> &nbsp Cancel</button>
					<button type="button" class="button_black" id="runjobprocess"><em class="fa fa-check"></em> &nbsp Process</button>
          <img alt="img" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader" >
				</div>
			</div>
		</div>
	</div>
  
  <!-- Modal Delete Job -->
	<div class="modal fade" id="modalDeleteJob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Delete Profile</h4>
				</div>
				<div class="modal-body">
          <!-- Periode to Proccess Option -->
          <p style="font-weight: bold;">Are you sure want to Delete Profile ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="button_black" id="deljobprocess"><em class="fa fa-check"></em> &nbsp Yes</button>
					<button type="button" class="button_white"  data-dismiss="modal" ><em class="fa fa-times"></em> &nbsp No</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo $path;?>assets/js/list-grid.js"></script>
	<script type="text/javascript" src="<?php echo $path;?>assets/js/tag.js"></script>
	<script type="text/javascript" src="<?php echo $path;?>assets/js/forms.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  
    <link href="<?php echo $path8; ?>vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo $path8; ?>vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
	
	<script src="<?php echo $path8; ?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo $path8; ?>vendors/fullcalendar/dist/fullcalendar.min.js"></script>





    <script type="text/javascript">
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
         $(".loader_exp").hide();
         $(".preloader").hide();
         $(".alert").hide();
          var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token");

		function load_table_profile(){
			
			

			
			
		}


      $(document).ready(function() {
		  
		            $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  //startDate: '-1y',
                  endDate: '0d',
                  defaultDate: new Date()
              });               
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY')); 
          });
		  
		  $('#modalNewProfile').on('hidden.bs.modal', function () {
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
					 $('#listcr').empty();
					 $('#jstree2').jstree("deselect_all");
			});
		
			  
		  
	var user_id = $.cookie(window.cookie_prefix + "user_id");
	var token = $.cookie(window.cookie_prefix + "token"); 
	 
	 var tabel_profile = $("#example").DataTable({
		"processing": false,
		"serverSide": true,
		destroy: true,
		"ajax": "<?php echo base_url().'cprp22/list_profile'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
		"searchDelay": 700,
		responsive: true,
		"bFilter" : false,
		"bInfo" : false,
		"bLengthChange": false,
    "searching": true,
	"initComplete": function(settings, json) {
	  }
	});		
	
	
	setInterval( function () {
		tabel_profile.ajax.reload();
	}, 20000 );
      
        $('#profile').selectpicker({
          liveSearch: true,
          maxOptions: 0
        });

          
      
        $("#profile").change(function() {
            $('#list').empty();
            $(".alert").hide();
            $("#profile option").each(function() {
                var val = $(this).val();
                var tempVal = $("#profile").val();
                if(tempVal){
                    if(tempVal.indexOf(val) >= 0 && optVal.indexOf(val) < 0) {
                        optVal.push(val);
                    } else if(tempVal.indexOf(val) < 0 && optVal.indexOf(val) >= 0) {
                        optVal.splice(optVal.indexOf(val) , 1);
                    }
                }else{
                    optVal.splice(optVal.indexOf(val) , 1);
                }
                

            })

            optVal.forEach(function(data, index) {
                    var res = data.split("_");
                console.log(res[0]);
                if(index > 0){
                    text = 
                            '<div class="col-md-2" ><select class="urate-tag urate-profile-tag" id="profile_'+index+'" name="profile_'+index+'" >'
                                +'  <option disabled selected>Select AND/OR</option> <option select value="'+res[1]+'_AND" >AND</option>  <option  value="'+res[1]+'_OR">OR</option> </select></div>'
                            +"<div class='col-md-4' style='margin-left:7%'><span class='urate-tag urate-profile-tag'>"+res[0]+"</span></div>";	

                }else{
                    text = "<div class='col-md-3 urate-tag urate-profile-tag'>"+res[0]+"</div>";		
                } 



                $('#list').append(text);




                    $("#profile_"+index).change(function() {
                        $("#profile_"+index+" option").each(function() {
                            var val = $(this).val();
                            var tempVal1 = $("#profile_"+index).val();
                            if(tempVal1.indexOf(val) >= 0 && optVal1.indexOf(val) < 0) {
                                optVal1.push(val);
                            } else if(tempVal1.indexOf(val) < 0 && optVal1.indexOf(val) >= 0) {
                                optVal1.splice(optVal1.indexOf(val) , 1);
                            }

                        })


                    });




            });
        })



          
          
          
    var form_data = {
        user_id			 : user_id
    }
     $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>cprp22/searchfav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) {
        console.log(response);
        if (response.success) {
            var dda = response.data.hasil;
            dda.forEach(function(entry, index) {
               $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><img alt="img" src="<?php echo $path; ?>assets/images/icon_star.png"></button>');
                });
 
        } else {

        }
    }).fail(function(xhr, status, message) {

    });
    
   
    
    
    
     $('#searchjtree').typeahead({
        source: function (query, process) {
            return $.get('cprp22/listsearch?q=' + query, function (data) {
                return process(data);
            });
        },
        updater: function(selection){
             $('#jstree2').jstree('search', selection.name);
            
        }
    });
    
    $('#searchjtree').on('typeahead:select', function (e, datum) {

    });
    
    
    
    
    
    
    
    
    
    
    
    
    
	var dass = '';

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
              },
                            "search": {




                            }});
    


    
							$('#jstree2').on("changed.jstree", function (e, data) {
								console.log(data);
								
							$('#listcr').empty();
							  var crnewdata = data.selected;
							  var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
							  for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("_");
                                  
                                  if(ss[0] != 'j1'){
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
                                console.log(uniqueNames); 
                                
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="crstar_'+datas+'">'+datas+' <a href="javascript:void(0)"  onclick="favorite(1,&#34;'+datas+'&#34;)" ><em class="glyphicon glyphicon-star-empty"></em></a></h3><span id="anak_'+index+'"></span>';
                                      $('#listcr').append(text);
                                      ddf.forEach(function(entry, index) {
                                          if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[4]+"</span>, ";
                                              $('#anak_'+ix).append(texta);
                                          }


                                      });
                                     }
                                  
                                  
							  });
							  
                                
                                
                                
									
							  arraypush(data.selected);
							  
							});
							
							
          
          
        
          
    });


      function toRp(angka){
        var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2    = '';
        for(var i = 0; i < rev.length; i++){
            rev2  += rev[i];
            if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
                rev2 += '.';
            }
        }
        return  rev2.split('').reverse().join('') ;
    }
        
	function all_profile(){
		
		
		var btn_sts = $("#btn_all").html();
		
		if(btn_sts == 'Select All'){
		$("#list_combine").val('');
		$("#list_combine_text").val('');
		$("#btn_all").html('Deselect All');
			<?php 
				foreach($listprofile as $new){
					echo 'sel_profile(\''.$new['name'].'|'.$new['id'].'\');';		
			 };?>
		
		}else{
			$("#btn_all").html('Select All');
				<?php 
				foreach($listprofile as $new){
					echo 'sel_profile(\''.$new['name'].'|'.$new['id'].'\');';		
			 };?>
		}
	}
	
	function sel_profile(val_profile){
		
		
		var val = val_profile.split("|");
		var text_html = $("#profile_"+val[1]).html();
		
		$("#profile_"+val[1]).html(val[0]+' &nbsp  <em class="fa fa-check" style="color:red;"></em> ');
		$("#profile_"+val[1]).css("border", "solid 2px red");
		
		var val_sel = $("#list_combine").val();
		var val_sel_name = $("#list_combine_text").val();
		var val_sel_cur = val_sel.split("|");
		var val_sel_name_cur = val_sel_name.split("|");
		var exist = 0;
		var text_exist = '';
		var text_exist_name = '';
		
			for (let i = 0; i < val_sel_cur.length; i++) {
				if(val_sel_cur[i] == ''){
					
				}else{
					
					if(val_sel_cur[i] == val[1]){
						exist++;
					}
					
					text_exist += val_sel_cur[i]+'|';
					text_exist_name += ''+val_sel_name_cur[i]+'|';
				}
			}

			text_exist += val[1]+'|';
			text_exist_name += val[0]+'|';

		str = text_exist.slice(0, -1); 
		str_name = text_exist_name.slice(0, -1); 
		
		
		$("#list_combine").val(str);
		$("#list_combine_text").val(str_name);

		var val_sel_curss = str.split("|");
		var val_sel_curss_name = str_name.split("|");
		var text_existss = '';
		var text_existss_name = '';
		
		var spot = '';
		if(exist > 0){
			for (let is = 0; is < val_sel_curss.length; is++) {
				if(val_sel_curss[is] == val[1]){
					
				}else{
					text_existss += val_sel_curss[is]+'|';
					
					text_existss_name += ''+val_sel_curss_name[is]+'|';
					
				}
			}
			
			strs = text_existss.slice(0, -1); 
			strss = text_existss_name.slice(0, -1); 
			$("#btn_all").html('Select All');
			
			$("#profile_"+val[1]).html(val[0]+' &nbsp  <em class="fa fa-check" style="color:#fff;"></em> ');
			$("#profile_"+val[1]).css("border", "solid 2px #E5E5E5");
			$("#list_combine").val(strs);
			$("#list_combine_text").val(strss);

		}
		
			$("#listrt").html('');
		
			var nhd = $("#list_combine_text").val();	
			var val_sel_ss = nhd.split("|");
			
			
			var srs = $("#list_combine_text").val();
			
			
			var html_sless = '';
			
			if(srs == ''){
				$("#listrt").html('');
			}else{
				for (let is = 0; is < val_sel_ss.length; is++) {
					
					var cntn = (val_sel_ss.length)-1;
					html_sless += '<div class="col-md-3 button_white" style="border:solid 2px #E5E5E5" >'+val_sel_ss[is]+'</div>';	
					
					if(is == cntn){
						
					}else{
						html_sless += '<div class="col-md-3" style="margin-bottom:5px"><div class="menu-filter" style="background-color:#F7F7F7;color:#000;border: solid 1px #F7F7F7;border-radius:5px" onClick="cond_filter('+is+')"><button id="btn_and_'+is+'" style="border-radius: 5px 0px 0px 5px;border: solid 1px #E5E5E5;background-color:#000;color:#fff;padding:5px">And</button><button id="btn_or_'+is+'" style="border-radius: 0px 5px 5px 0px;border: solid 1px #E5E5E5;background-color:#fff;padding:5px">Or &nbsp </button><input id="cond_val_'+is+'" type="hidden" value="0"></input></div></div>';
					}
				}
				$("#listrt").html(html_sless);
			}
			
			
			 
			
	}
	
	 function cond_filter(id){
		 
		var srs = $("#cond_val_"+id).val();
		
		if(srs == "0"){
			$("#cond_val_"+id).val('1');
			
			$('#btn_and_'+id).css('background-color','#fff');
			$('#btn_or_'+id).css('background-color','#000');
			
			$('#btn_and_'+id).css('color','#000');
			$('#btn_or_'+id).css('color','#fff');
			
		}else{
			$("#cond_val_"+id).val('0');
			
			$('#btn_and_'+id).css('background-color','#000');
			$('#btn_or_'+id).css('background-color','#fff');
			
			$('#btn_and_'+id).css('color','#fff');
			$('#btn_or_'+id).css('color','#000');
		}
		
	 }
		
    function prerun(id){
        $("#modalProcessJob").modal();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>cprp22/listnotyet" + "?profid=" + id,
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            var ischeckall = false; 
            if (response.success) {
                var periodelistcontent = '<div class="checkbox urate-checkbox" align="center">'+
          						'<input class="urate-form-checkbox" name="periodtoproc" id="checkAll" type="checkbox" value="all">'+
          						'<label for="checkAll"><div class="label-text">All</div></label></div>';
                for(i=0; i < response.data.length; i++){
                    periodelistcontent += '<div class="checkbox urate-checkbox cucl" align="center">'+
          						'<input class="urate-form-checkbox" name="periodtoproc" id="check'+response.data[i].PERIODE+'" type="checkbox" value="'+response.data[i].PERIODE+'">'+
          						'<label for="check'+response.data[i].PERIODE+'" style="background: #cb3827;"><div class="label-text">'+response.data[i].PERIODE+'</div></label></div>';
                }
                
                $("#periodelist").html(periodelistcontent);
                
                $("#checkAll").on("click",function(){            
                    if(ischeckall == false){                                 
                        $('input:checkbox').not(this).prop('disabled', true);
                        $('.cucl label').not(this).css({'border':'1px solid gray','background':'gray'});
                        
                        ischeckall = true;
                    } else {
                        $('input:checkbox').not(this).prop('disabled', false);
                        $('.cucl label').not(this).css({'border':'1px solid #cb3827','background':'#cb3827'});
                        
                        ischeckall = false;
                    }
                })      
            } else {
    
            }
        })        
        $(".modal-footer #loader").hide();
        
        $("#runjobprocess").attr("onclick","run('"+id+"')");
    }
    
	function load_combine(){
		
		var list_combine = $('#list_combine').val();
		var optVal = list_combine.split("|");

		
		 if(optVal.length > 1){

			var nu = 0;
			var old = 0;
			for(i=0;i<optVal.length;i++){
				
				var vrd = optVal[i].split("_");
				var dsd = vrd[0].substr(-1, 1);
				if(dsd == '*'){
					nu++;
				}else{
					old++;
				}
			}
			
			var op = 1;
			
			if(nu == optVal.length || old == optVal.length){
				
				
				
				for(i=1;i<optVal.length;i++){
					
					var ops = $("#profile_"+i).val();
					
					console.log(ops);
					if(ops == null){
						op++;
					}
					
				}
				

					$("#error_body2").html('');
					$("#modalCombineProfile").modal('show');

			}else{
				$("#errormodal").modal('show');
				$("#error_body").html('Profile Harus Menggunakan Data Yang Sama !!!');
			}
			
		 }else{
			 $("#errormodal").modal('show');
			 $("#error_body").html('Minimum 2 Profile !!!');
		 }
		
	}
	
    function predelete(id){
        $("#modalDeleteJob").modal();
        
        $("#deljobprocess").attr("onclick","delete_job('"+id+"')");
    }    
	
	function exports(id){
        $("#modalExport").modal();
        
        $("#expjobprocess").attr("onclick","export_job('"+id+"')");
    }        
        
function run(pid){
    $(".modal-footer .btn").hide();
    $(".modal-footer #loader").show();
    
    var val_periode = [];
    $(':checkbox:checked').each(function(i){
        val_periode[i] = $(this).val();
    });
    
    if(val_periode.length == 0){
      $("#menusoptmsg").css("display","block");
      $(".modal-footer .btn").show();
      $(".modal-footer #loader").hide();
      
      return;
    } else {
      $("#menusoptmsg").css("display","none");
    }
        
    /* BEGIN RUN JOB PROCESS*/
    var form_data = {
        pid		 : pid,
        val_periode_list : val_periode
    }
           
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>cprp22/run_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) {
        if (response.success) {
            location.href = "<?php echo base_url();?>cprp22/";
        } else {
        }
    }).fail(function(xhr, status, message) {
        console.log('ajax create error:' + message);
    });
    /* END RUN JOB PROCESS*/
	
	
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
 
  function delete_job(pid){
    var form_data = {
        pid		 : pid
    }
					
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>cprp22/del_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) {
        if (response.success) {
            location.href = "<?php echo base_url();?>cprp22/";
        } else {
        }
    }).fail(function(xhr, status, message) {
        console.log('ajax create error:' + message);
    });
	}
		
		
function getCreate(){
    

	var list_combine = $('#list_combine').val();
	var list_combine_text = $('#list_combine_text').val();
	
	var val_sel_cur = list_combine.split("|");
	var cond_val = '';
	
	for (let i = 0; i < (val_sel_cur.length)-1; i++) {
		var now_val = $('#cond_val_'+i).val();
		cond_val += now_val+'|';
		
	}
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
		  if($("#name").val() !== ""){
				$(".preloader").show();
				
				var form_data = {
						list_combine : list_combine,
						list_combine_text : list_combine_text,
						cond_val : cond_val,
						user_id	 	 : user_id,
						name		 :  $("#name").val()
					}
					
					  $.ajax({
						type: "POST",
						url: "<?php echo base_url();?>cprp22/combine_profile" + "?sess_user_id=" + user_id + "&sess_token=" + token,
						data: JSON.stringify(form_data),
						dataType: 'json',
						contentType: 'application/json; charset=utf-8'
					}).done(function(response) {
						$(".alert").hide();
						if (response.success) {
							
							location.href = "<?php echo base_url();?>cprp22/";
						} else {
							
							$("#error_body2").html('Nama Profile Sudah ada !!!');
							$("#loading").remove();
							$('#savecombine').show();
							
						}
					}).fail(function(xhr, status, message) {
						console.log('ajax create error:' + message);
					});
					
		  }else{
				$("#error_body2").html('Nama Profile Harus Diisi !!!');
				
				$("#loading").remove();
				$('#savecombine').show();
			 
		  }
	}

        
        
        Array.prototype.inArray = function(comparer) { 
    for(var i=0; i < this.length; i++) { 
        if(comparer(this[i])) return true; 
    }
    return false; 
}; 

  function export_job(id) {

	var start_date = $("#start_date").val();
	var end_date = $("#end_date").val();
var user_id = $.cookie(window.cookie_prefix + "user_id");
    var url = '<?php echo base_url(); ?>cprp22/exportss'+ "?sess_user_id=" + user_id + "&sess_token=" + token;


var form_data = new FormData(); 
	form_data.append('id',id);
		form_data.append('start_date', start_date);
		form_data.append('end_date', end_date);

	 $('#expjobprocess').prop('disabled', true); 
	
	
		$.ajax({
			url: "<?php echo base_url().'cprp22/exportss'; ?>", 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/aaaa.xls','MBM_'+start_date+'.xls');
				
				$('#expjobprocess').prop('disabled', false);
				$("#loader_exp").hidden();
				
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	


  }  

function clear(){
    $("#slec option:selected").removeAttr("selected");
}    
function addleft(id, dex, val){
    console.log(dex);
     var bn = document.getElementById('btn_'+dex);
    if(bn.disabled == false) { 
          $("#btn_"+dex).attr('disabled', 'disabled');
    }else{
        alert('gagal');
    }
	
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var selection = {
            name	 	 : val,
			user_id : user_id 
        }
    
     $.ajax({
				type: "POST",
				url: "<?php echo base_url();?>cprp22/searchopval" + "?sess_user_id=" + user_id + "&sess_token=" + token,
				data: JSON.stringify(selection),
				dataType: 'json',
				contentType: 'application/json; charset=utf-8'
			}).done(function(response) {
                console.log(response);
				if (response.success) {
                var data = response.data;

					data.forEach(function(entry, index) {
                       
                        
                        $('#list').empty();
				        var sc =  JSON.parse(entry.child);
                        sc.forEach(function(entry, index) {
                            crnewdata.push(entry);
                        
                        });
                         console.log(crnewdata);
							  var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
							  for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("=");
                                  
                                  if(ss[0] != 'j1'){
                                       dd.push(ss);
                                       ddf.push(ss);
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
                                console.log(uniqueNames);
                                
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  
                                  if(datas){
                                       var ix = index;
                                  text ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak_'+index+'"></span>';
                                     $('#listcr').append(text);
                                  ddf.forEach(function(entry, index) {
                                      
                                      if(datas == entry[1]){
                                         texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                          $('#anak_'+ix).append(texta);
                                      }
                                        

                                  });
                                  }
                                 
                                  
							  });
							  
                        
                        
                        

                        
                    });
				} else {
					
				}
			}).fail(function(xhr, status, message) {
				
				console.log('ajax create error:' + message);
			});
        
}
function favorite(id, val){
    var databawa = [];
    for(var i = 0; i < crnewdata.length; i++){
         var ss = crnewdata[i].split("=");

          if(ss[0] != 'j1'){
                 
              if(ss[1] == val){
                  databawa.push(ss[0]+'='+ss[1]+'='+ss[2]+'='+ss[3]);
                  
              }
          }

      };
    
    var valuedata = JSON.stringify(databawa);
    
 
    user_id = $.cookie(window.cookie_prefix + "user_id");
    token = $.cookie(window.cookie_prefix + "token");
    crstar = id;
    if(crstar == 1){
        
        $("#facs").empty();

        var form_data = {
            status			 : crstar,
            user_id			 : user_id,
            name	 	 : val,
            child : valuedata
        }
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>cprp22/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            // handle a successful response
            console.log(response.data.hasil);
            if (response.success) {
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><img alt="img" src="<?php echo $path; ?>assets/images/icon_star.png"></button>');
                });
                    
            } else {

            }
        }).fail(function(xhr, status, message) {

        });
        
        
    }else{
         $("#facs").empty();
         var form_data = {
            status			 : crstar,
            user_id			 : user_id,
            name	 	 : val,
            child : valuedata
        }
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>cprp22/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            console.log(response);
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><img alt="img" src="<?php echo $path; ?>assets/images/icon_star.png"></button>');
                });

        }).fail(function(xhr, status, message) {

        });
    }
    
    
         
}    
    
function masuk(val){
   
    $('#list').empty();
    var sc = [];
    sc.push(val);
    console.log(val); 
    console.log(sc); 
    return false;
      var crnewdata = sc;
      var dd = [];
        var text = '';
                            for(var i = 0; i < crnewdata.length; i++){
								 
								  
								 var ss = crnewdata[i].split("=");
								 
										dd.push(ss);
									
									
							  };
 console.log(dd);
      dd.forEach(function(entry, index) {

            if(entry[0] != "j1"){


                    text = "<h4 id='"+entry[1]+"'><span class='label label-success'>"+entry[0]+"</span></h4>";

            $('#list').append(text);
            }



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




}    
    
function arraypush(datas){
	crnewdata = [];
	 crnewdata = datas;
}
function getCreateCr(){
		var user_id = $.cookie(window.cookie_prefix + "user_id");
		var token = $.cookie(window.cookie_prefix + "token");
		    $('#savecr').hide();
		    $("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
        
        var nas = $("#crname").val();	
	 
		    $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>cprp22/chkname" + "?sess_user_id=" + user_id + "&sess_token=" + token + "&q=" + nas,

            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            //console.log(response['data'].hasil);
            if(response['data'].hasil == "0"){
                if(nas){
                    var form_data = {
                        list		 : crnewdata,
                        isi			 : crcroptVal1,
                        name	 	 : $("#crname").val()
                    }
                    
      
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>cprp22/create_profiling" + "?sess_user_id=" + user_id + "&sess_token=" + token,
                        data: JSON.stringify(form_data),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
                        $("#laod").empty();
                        $('#savecr').show();
                        $('#modalNewProfile').modal('hide');
                        
                        $('#alertini').append('<div class="alert alert-success alert-dismissible" role="alert" id="suksescr">'
                        +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        +'<em class="fa fa-info-circle"></em> Profile successfuly create</div>');
                        
                        if (response.success) {
                            location.href = "<?php echo base_url();?>cprp22/";

                        }
                    }).fail(function(xhr, status, message) {
                        $("#laod").empty();
                        $('#savecr').show();
                    });
                }else{
                    $("#laod").empty();
                    $('#savecr').show();
                    $('#alertini').html('<div class="alert alert-danger alert-dismissible" role="alert" id="suksescr">'
                    +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    +'<em class="fa fa-info-circle"></em> Name not be empty!</div>');
                    
                    setTimeout(function(){  $('#suksescr').hide(); }, 7000);
                }
            } else {              
                $("#laod").empty();
                $('#savecr').show();
                        
                $('#crname').css('color','red');
                $('#crname').parent().append('<div id="name_message" style="color:red;">The name is already taken. Please use other name.</div>');
                
                $('#crname').on('focus', function(){
                    $('#crname').css('color','#9b9b9b');
                    $('#name_message').html('');                    
                });
            }
        
        });
			
	}
        
        function toObject(arr) {
          var rv = {};
          for (var i = 0; i < arr.length; ++i)
            rv[i] = arr[i];
          return rv;
        }
    </script>	

