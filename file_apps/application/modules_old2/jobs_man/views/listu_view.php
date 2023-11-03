
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
	  
	.table {
        margin-left:10px !important;
	
		
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
        padding-left: 20px;
        padding-right: 20px;
        color: #CC3300;
        font-weight: bold;
        text-align: center;
        display: none;
      }
	  
	  
	  
  </style>
		
		<!-- / Sidebar -->
		<div class="content-wrapper">
			<div class="container-fluid">
          <div class="row">
              <div class="col-md-6">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">JOBS</li>
                      
                  </ol>
              </div>       
          </div>
                
      <span id="alertini"></span>
				<!-- List Profile -->
				<div class="list-profile-head">
					<div class="pull-left">
						<h3>Jobs</h3>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="row" >
                    
						<table aria-describedby="mydesc"   id="example" class="table table-striped">
						  <thead style="color:red">
							<tr>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:left'>Status Jobs</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:left'>Jobs Name</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:left'>Date Data</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:left'>Jobs Desc</p></th>
								
							</tr>
						  </thead>
						</table>
				</div>        
        
				<!-- Combine Profile -->
				<div class="panel urate-panel">
					<div class="panel-headings">
						<h3 class='urate-panel-title'>Jobs Detail</h3>
					</div>
					<div class="panel-body">
								<table aria-describedby="mydesc"   id="example_h" class="table table-striped">
								  <thead style="color:red">
									<tr>
										<th style="" scope="row"><p style='text-align:left'>Jobs Name</p></th>
										<th style="" scope="row"><p style='text-align:left'>Jobs File</p></th>
										<th style="" scope="row"><p style='text-align:left'>Jobs Status </p></th>
										<th style="" scope="row"><p style='text-align:left'>Jobs Time Proccess </p></th>
										
										
									</tr>
								  </thead>
								</table>
					</div>
				</div>
				
				<div class="panel urate-panel">
					<div class="panel-body">
								<table aria-describedby="mydesc"   id="example_hs" class="table table-striped">
								  <thead style="color:red">
									<tr style="border:none">
										<th style="border:none;" scope="row"><p style='text-align:left'>Minimum Rows</p></th>
										<th style="border:none;" colspan="2" scope="row"><p style='text-align:center'><button id="min_rows" type="button" onClick="change_min('<?php echo $min_row[0]['MIN_ROW']; ?>')" class="button_black" ><?php echo number_format($min_row[0]['MIN_ROW'],0,',','.') ?></button></p></th>
									</tr>
									<tr style="background-color:#F3F3F3;">
										<th style=";background-color:#F3F3F3;" scope="row"><p style='text-align:left'>Smart Offering nba Tools</p></th>
										<th style="width:20%;background-color:#F3F3F3;" scope="row"><p style='text-align:center'>
										<select class='sel_set form-control urate-form-input' onchange='' name = 'per_nper' ID = 'per_nper'>
										<option value = '0' SELECTED = 'SELECTED' disabled>Periode</option>
										<?php foreach($listperiode as $listperiodes){ 
										echo "<option value = '".$listperiodes['PERIODE_STR']."'>".$listperiodes['PERIODE_STR']."</option>";
										 } ?>
										</select></p></th>
										<th style="" scope="row"><p style='text-align:center'><button id="nper" type="button" onClick="process_nper()" class="button_black" >Process</button></p></th>
									</tr>
								  </thead>
								</table>
					</div>
				</div>
				
					<div class="panel urate-panel">
					<div class="panel-headings">
						<h3 class='urate-panel-title'>Universe</h3>
					</div>
					<div class="panel-body">
								<table aria-describedby="mydesc"   id="example_univ" class="table table-striped">
								  <thead style="color:red">
									<tr>
										<th style="" scope="row"><p style='text-align:left'>Periode</p></th>
										<th style="" scope="row"><p style='text-align:left'>Universe</p></th>
										
										
									</tr>
								  </thead>
								</table>
					</div>
				</div>
				
				<!-- / Combine Profile -->
				<!-- /List Profile -->
				<!-- / Content -->
			</div>
		</div>
	
	<!-- Modal New Profile -->
	<!-- / Modal -->
	<!-- Modal Combine Profile -->

	<div class="modal fade" id="modalChangeTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					
					<h4 class="modal-titles" id="myModalLabel"><strong>Process Time</strong></h4>
					<input type='hidden' id='hid_val2' name='hid_val2' />
				</div>
				<div class="modal-body">
				<p id = 'text_mdlsss'>Select specific hour and minute to start the process automatically. </p> <br>
					<p id = 'text_mdls'> </p> <br>
					
					<div class="col-md-6">
					
						<select class='sel_set form-control urate-form-input' name = 'set_hours' id = 'set_hours' >
						<?php foreach($arr_hours as $arr_hourss){ ?>
							
							
							<option value = '<?php echo $arr_hourss ?>'  ><?php echo $arr_hourss ?></option>
						
							
						<?php } ?>
						
						
						</select>
						
					
					</div>
					
					<div class="col-md-6">
					
						<select class='sel_set form-control urate-form-input' name = 'set_min' id = 'set_min' >
						<?php foreach($arr_min as $arr_mins){ ?>
							
							
							<option value = '<?php echo $arr_mins ?>'  ><?php echo $arr_mins ?></option>
						
							
						<?php } ?>
						
						
						</select>
						
					
					</div>
					
					<br>
					<br>
					<br>
					<p> 
					If After 2 Hours file not found, the Process Must be Proceed Manually
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="button_white" data-dismiss="modal" onClick='changesettimecancel()'><em class="fa fa-times"></em>&nbsp Cancel</button>
					<button type="button" class="button_black" onClick='changeset_time()' ><em class="fa fa-check"></em>&nbsp Create</button>
					
				</div>
			</div>
		</div>
	</div>	
	
	<div class="modal fade" id="modalChangeUniv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					
					<h4 class="modal-titles" id="myModalLabel"><strong>Change Universe</strong></h4>
					<input type='hidden' id='hid_univ' name='hid_univ' />
					<input type='hidden' id='hid_univ_name' name='hid_univ_name' />
				</div>
				<div class="modal-body">
					<p id = 'text_mdlss'><strong>Set Universe</strong> </p> <br>
					
					<div class="col-md-12">
					
						<input type="text" class='sel_set form-control urate-form-input' name = 'set_universe' id = 'set_universe' />

					
					</div>
					

					
					<br><br>
					<p> 
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="button_white" data-dismiss="modal" onClick='changesettimecancel()'><em class="fa fa-times"></em>&nbsp Cancel</button>
					<button type="button" class="button_black" onClick='changeset_univ()' ><em class="fa fa-check"></em>&nbsp Create</button>
				</div>
			</div>
		</div>
	</div>
	
	
		<div class="modal fade" id="modalMin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					
					<h4 class="modal-titles" id="myModalLabel"><strong>Change Minimum Row</strong></h4>
					
				</div>
				<div class="modal-body">
					<p id = 'text_mdls'>Set Minimum Row </p> <br>
					
				<br>
					<div class="col-md-12">
					
						<input type='input' id='hid_val2min' name='hid_val2min' class='form-control urate-form-input' value='<?php echo $min_row[0]['MIN_ROW']; ?>' />
					
					</div>
					
					<br><br>
					<p> 
					Jobs Will Insert into Queue List if the total row over the minimum row,If total row under minimum row, The Process Must be Proceed Manually
					</p>
				</div>
				<br>
				<div class="modal-footer">
					<button type="button" class="button_white" data-dismiss="modal" onClick='changesetmin()'><em class="fa fa-times"></em>&nbsp Cancel</button>
					<button type="button" class="button_black" onClick='changeset_min()' ><em class="fa fa-check"></em>&nbsp Create</button>
				</div>
			</div>
		</div>
	</div>
	
	
  <!-- Modal Delete Profile -->
	<div class="modal fade" id="modalDeleteProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					
					<h4 class="modal-title" id="myModalLabel">Change Jobs Status</h4>
					<input type='hidden' id='hid_val' name='hid_val' />
				</div>
				<div class="modal-body">
					<p id = 'text_mdl'>Are you sure want to change Job Status into Manual ? <br> 
					Manual Run Must be Process From Backend Dashboard Menu 
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal" onClick='changesetcancel()'>Cancel</button>
					<button type="button" class="btn urate-btn" onClick='changeset()' >Change</button>
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
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn" id="runjobprocess">Process</button>
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
					<button type="button" class="btn urate-outline-grey-btn" id="deljobprocess">Yes</button>
					<button type="button" class="btn urate-btn"  data-dismiss="modal" >No</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo $path;?>assets/js/list-grid.js"></script>
	<script type="text/javascript" src="<?php echo $path;?>assets/js/tag.js"></script>
	<script type="text/javascript" src="<?php echo $path;?>assets/js/forms.js"></script>

 




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
         $(".preloader").hide();
         $(".alert").hide();
          var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token");

      $(document).ready(function() {
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
	 
	 $("#example").DataTable({
		"processing": true,
		"serverSide": true,
		destroy: true,
		"ajax": "<?php echo base_url().'jobs_man/list_profile'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
		"searchDelay": 700,
		responsive: true,
		"bFilter" : false,
		"bInfo" : false,
		"bLengthChange": false,
		"searching": true,
		"pageLength": 5
	});		
	
	
	$("#example_h").DataTable({
		"processing": true,
		"serverSide": false,
		destroy: true,
		"ajax": "<?php echo base_url().'jobs_man/list_job_set'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
		"searchDelay": 700,
		responsive: true,
		"bFilter" : false,
		"bInfo" : false,
		"bPaginate": false,
		"bLengthChange": false
	});	

	
	$("#example_univ").DataTable({
		"processing": true,
		"serverSide": true,
		destroy: true,
		"ajax": "<?php echo base_url().'jobs_man/list_periode'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
		"searchDelay": 700,
		responsive: true,
		"bFilter" : false,
		"bInfo" : false,
		"bLengthChange": false,
		"searching": true,
		"pageLength": 6
	});		
	
      /* list data table statistic */
      
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
        url: "<?php echo base_url();?>jobs_man/searchfav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
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

        console.log('ajax create error:' + message);
    });
 
    
     $('#searchjtree').typeahead({
        source: function (query, process) {
            return $.get('jobs_man/listsearch?q=' + query, function (data) {
                 return process(data);
            });
        },
        updater: function(selection){
             $('#jstree2').jstree('search', selection.name);
            
        }
    });
    
    $('#searchjtree').on('typeahead:select', function (e, datum) {
         console.log(datum);
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
	var dass = '';
 
							$('#jstree2').jstree({'plugins':["checkbox","search"], 'core' : {
                                "themes" : { "stripes" : true },
                'data' : [
                      <?php 
                $html = '';
                $htmls = '';
 
                $html .=  '{ "text" : "GEOGRAFI", "state" : { "opened" : false }, "children" : [';
                foreach ($listparent[0] as $k1 => $v1) {
                    foreach ($v1['GEOGRAFI'] as $k2 => $v2) {
                        $html .=  ' { "text" : "'.$v2['ANAK1'].'", "state" : { "opened" : false },  "children" : [';
                            foreach ($v2['ANAK2'] as $k3 => $v3) {
                                $html .=  ' { "text" : "'.$v3['ANAK2'].'", id:"'.$v3['ANAK2'].'='.$v2['ANAK1'].'=GEOGRAFI" },';
                            }
                            $html = substr($html, 0, -1);

                            $html .= '] },';

                    }
                    $html = substr($html, 0, -1);
                    $html .=  '] }';

                }

                $html .=  '{ "text" : "HELIX PERSONAS", "state" : { "opened" : false }, "children" : [';
                foreach ($listparent[0] as $k1 => $v1) {
                    foreach ($v1['HELIX PERSONAS'] as $k2 => $v2) {
                        $html .=  ' { "text" : "'.$v2['ANAK1'].'", "state" : { "opened" : false },  "children" : [';
                            foreach ($v2['ANAK2'] as $k3 => $v3) {
                                $html .=  ' { "text" : "'.$v3['ANAK2'].'", id:"'.$v3['ANAK2'].'='.$v2['ANAK1'].'=HELIX PERSONAS" },';
                            }
                            $html = substr($html, 0, -1);

                            $html .= '] },';

                    } 
                    $html = substr($html, 0, -1);
                    $html .=  '] }';

                }
				
				$html .=  '{ "text" : "DEMOGRAFI", "state" : { "opened" : false }, "children" : [';
                foreach ($listparent[0] as $k1 => $v1) {
                    foreach ($v1['DEMOGRAFI'] as $k2 => $v2) {
                         $html .=  ' { "text" : "'.$v2['ANAK1'].'", "state" : { "opened" : false },  "children" : [';
                            foreach ($v2['ANAK2'] as $k3 => $v3) {
                                $html .=  ' { "text" : "'.$v3['ANAK2'].'", id:"'.$v3['ANAK2'].'='.$v2['ANAK1'].'=DEMOGRAFI" },';
                            }
                            $html = substr($html, 0, -1);

                            $html .= '] },';
  
                    }
                    $html = substr($html, 0, -1);
                    $html .=  '] }';

                }
				
                $htmls.=str_replace("}{","},{",$html); 
                echo $htmls; 
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
                                
							   console.log(dd);
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
                                             texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
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
        
	function change_time(id,time){
		
		
		var time_split = time.split(":");
		
		$('#set_universe').val(time_split[0]);
		$('#set_min').val(time_split[1]);
		$('#hid_val2').val(id);
		
		$('#modalChangeTime').modal({
			backdrop: 'static',
			keyboard: false  
		})
		
		$('#modalChangeTime').modal('show');
		
 		
	}	
	
	function change_univ(id,univ,name){
		
		$('#hid_univ').val(hid_univ);
		$('#hid_univ_name').val(name);
		$('#set_universe').val(univ);
		
		
		$('#modalChangeUniv').modal({
			backdrop: 'static',
			keyboard: false   
		})
		
		$('#modalChangeUniv').modal('show');
		
	}
	
	
	function changeset_min(){
		

		var set_min = $('#hid_val2min').val();
		
		 var form_data = {
			set_min	 : set_min,
			tokens	 : '<?php echo $token; ?>'
		}
			   
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>jobs_man/change_min_row" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			data: JSON.stringify(form_data),
 			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) {
		 
			if (response.success) {
				location.href = "<?php echo base_url();?>jobs_man/";
			} else {
			}
		}).fail(function(xhr, status, message) {
 			console.log('ajax create error:' + message);
		});
		
	}
	
	
	function changeset_time(){
		
		var id = $('#hid_val2').val();
		var set_hours = $('#set_hours').val();
		var set_min = $('#set_min').val();
		
		 var form_data = {
			id		 : id,
			set_hours: set_hours,
			set_min	 : set_min,
			tokens	 : '<?php echo $token; ?>'
		}
			   
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>jobs_man/change_time_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			data: JSON.stringify(form_data),
 			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) {
		 
			if (response.success) {
				location.href = "<?php echo base_url();?>jobs_man/";
			} else {
			}
		}).fail(function(xhr, status, message) {
 			console.log('ajax create error:' + message);
		});
		
	}	
	
	function changeset_univ(){
		
		var id = $('#hid_univ').val();
		var hid_univ_name = $('#hid_univ_name').val();
		var set_universe = $('#set_universe').val();
		
		 var form_data = {
			id		 : id,
			set_name: hid_univ_name,
			set_univ	 : set_universe,
			tokens	 : '<?php echo $token; ?>'
		}
			   
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>jobs_man/change_univ_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			data: JSON.stringify(form_data),
 			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) { 
			if (response.success) {
				location.href = "<?php echo base_url();?>jobs_man/";
			} else {
			}
		}).fail(function(xhr, status, message) {
 			console.log('ajax create error:' + message);
		});
		
	}
		
	function changeset(){
		
		var str = $('#hid_val').val();
		
		 var form_data = {
			str		 : str
		}
			   
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>jobs_man/change_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			data: JSON.stringify(form_data),
 			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) { 
			if (response.success) {
				location.href = "<?php echo base_url();?>jobs_man/";
			} else {
			}
		}).fail(function(xhr, status, message) {
 			console.log('ajax create error:' + message);
		});
		
	}	
	
	
	function process_nper(){

		$('#nper').attr('disabled',true);
		
		var str = $('#per_nper').val();
		
		 var form_data = {
			str		 : str,
			tokens	 : '<?php echo $token; ?>'
		}
			   
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>jobs_man/change_npr" + "?sess_user_id=" + user_id + "&sess_token=" + token,
			data: JSON.stringify(form_data),
 			dataType: 'json',
			contentType: 'application/json; charset=utf-8'
		}).done(function(response) { 
 
			
			$('#nper').attr('disabled',false);
		}).fail(function(xhr, status, message) {
 			console.log('ajax create error:' + message);
		});
		
	}	
	
	function change_min(vall){
		
 		
		$('#modalMin').modal('show');
		
	}
	
	function changesetcancel(){
		
		var str = $('#hid_val').val();
 		var res = str.split("-");
		
 		if(res[0] == 1){
			var valll = 0;
		}else{
			var valll = 1;
		}
		
		$('#sel_run_'+res[1]).val(valll+'-'+res[1]);
 		
	}
	
	function getval(val){
		
		$('#hid_val').val(val.value);
 		var str = val.value;
		var res = str.split("-");
		
		if(res[0] == 0){
			$('#text_mdl').html('Are you sure want to change Job Status into Manual Run ? <br> Manual Run Must be Process From Backend Dashboard Menu');
		}else{
			$('#text_mdl').html('Are you sure want to change Job Status into Auto Run ? <br> An Auto Run Jobs Check File Every 15 Minutes from Choosed Time, and Run Process into Queue When the File is Valid, If After 2 Hours file not Valid, the Process Must be Proceed Manually');
		}
		
		$('#modalDeleteProfile').modal({
			backdrop: 'static',
			keyboard: false  // 
		})
		
		$('#modalDeleteProfile').modal('show');
		
	}	
	
    function prerun(id){
        $("#modalProcessJob").modal();
        
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>jobs_man/listnotyet" + "?profid=" + id,
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
    
    function predelete(id){
        $("#modalDeleteJob").modal(); 
        
        $("#deljobprocess").attr("onclick","delete_job('"+id+"')");
    }        
        
function run(pid){
    //alert(pid);
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
        url: "<?php echo base_url();?>jobs_man/run_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
         dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) { 
        if (response.success) {
            location.href = "<?php echo base_url();?>jobs_man/";
        } else {
        }
    }).fail(function(xhr, status, message) {
         console.log('ajax create error:' + message);
    });
    /* END RUN JOB PROCESS*/
	
	 
	}
  
  function delete_job(pid){
     var form_data = {
        pid		 : pid
    }
					
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>jobs_man/del_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
         dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) { 
        if (response.success) {
            location.href = "<?php echo base_url();?>jobs_man/";
        } else {
        }
    }).fail(function(xhr, status, message) {
         console.log('ajax create error:' + message);
    });
	}
		
		
function getCreate(){
    
    $('#savecombine').hide();

    $("#laodCombine").append('<img alt="img" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
    $('.alert').hide();
	var user_id = $.cookie(window.cookie_prefix + "user_id");
		  if(optVal.length != 1){
				$(".preloader").show();
				$('.alert').hide();
				var form_data = {
						list		 : optVal,
						isi			 : optVal1,
						user_id	 	 : user_id,
						name		 :  $("#name").val()
					}
					
					console.log(form_data);
					  $.ajax({
						type: "POST",
						url: "<?php echo base_url();?>jobs_man/create_statistic" + "?sess_user_id=" + user_id + "&sess_token=" + token,
						data: JSON.stringify(form_data),
 						dataType: 'json',
						contentType: 'application/json; charset=utf-8'
					}).done(function(response) {
 						$(".alert").hide();
						if (response.success) {
							
							location.href = "<?php echo base_url();?>jobs_man/";
						} else {
						}
					}).fail(function(xhr, status, message) {
 						console.log('ajax create error:' + message);
					});
					
		  }else{
			   $('.alert').show();
			    $('#alser').html("<strong>Warning!</strong> Minimum 2 Profile.");
			  setTimeout(function(){ 
				 
			 	$('.alert').hide();
			 
				}, 3000);
			 
		  }
	}
 
        
        Array.prototype.inArray = function(comparer) { 
    for(var i=0; i < this.length; i++) { 
        if(comparer(this[i])) return true; 
    }
    return false; 
}; 

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
				url: "<?php echo base_url();?>jobs_man/searchopval" + "?sess_user_id=" + user_id + "&sess_token=" + token,
				data: JSON.stringify(selection),
 				dataType: 'json',
				contentType: 'application/json; charset=utf-8'
			}).done(function(response) {
				 
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
            url: "<?php echo base_url();?>jobs_man/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
             dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
             console.log(response.data.hasil);
            if (response.success) {
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    console.log(entry);
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><img alt="img" src="<?php echo $path; ?>assets/images/icon_star.png"></button>');
                });
                    
            } else {

            }
        }).fail(function(xhr, status, message) {

            console.log('ajax create error:' + message);
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
            url: "<?php echo base_url();?>jobs_man/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
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

            console.log('ajax create error:' + message);
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
            url: "<?php echo base_url();?>jobs_man/chkname" + "?sess_user_id=" + user_id + "&sess_token=" + token + "&q=" + nas,
       
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
                        url: "<?php echo base_url();?>jobs_man/create_profiling" + "?sess_user_id=" + user_id + "&sess_token=" + token,
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
                             location.href = "<?php echo base_url();?>jobs_man/";

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

