
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
		border: 4px solid #ddd;
		
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
                      <li class="breadcrumb-item">Free to Air</li>
                      <li class="breadcrumb-item active">Helix & Smart Profiling</li>
                  </ol>
                  <h3 class="page-title-inner">Helix & Smart Profiling</h3>
              </div>       
          </div>
                
      <span id="alertini"></span>
				<!-- List Profile -->
				<div class="list-profile-head">
					<div class="pull-left">
						<h3>List Profile</h3>
					</div>
					<div class="pull-right">
						<div class="text-right">
							<button class="btn urate-outline-btn" data-toggle="modal" data-target="#modalNewProfile"><span class="ion-plus"></span> Create New</button>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="row" >
                    
						<table aria-describedby="mydesc"   id="example" class="table table-striped table-bordered urate-table">
						  <thead>
							<tr>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center'>Profile Name</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Date Created</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Population</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Done</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Not Yet</p></th>	
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Progres Meter</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Status</p></th>
								<th style="padding:10px 0 10px 0" scope="row"><p style='text-align:center' >Delete</p></th>
							</tr>
						  </thead>
						</table>
				</div>        
        
				<!-- Combine Profile -->
				<div class="panel urate-panel">
					<div class="panel-heading">
						<h3 class='urate-panel-title'>Combine Profile</h3>
					</div>
					<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<div class="profile-selector">
										<select class='selectpicker urate' data-actions-box="true"  multiple title='Select Data Profile ...'  id="profile" name="profile">
											 <?php foreach($listprofile as $new){
													echo "<option  value='".$new['name']."_".$new['id']."'>".$new['name']."</option>";	
											  };?>
											 
											 
										</select>
									</div>
								</div>
								<div class="col-md-9">
									<div class="urate-tag-panel" id="combinePanel">
										<div class="panel-header">
											<h4 class="tag-panel-title">Selected Profile</h4>
										</div>
										<div class="panel-body">
                                                <span id="list" name="list"></span>
										</div>
									</div>
								</div>
								<div class="col-md-12 text-center">
                                   <button class="btn urate-outline-btn" data-toggle="modal"  data-target="#modalCombineProfile">Combine</button>
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
                <label for="">Parameter</label>
								<div class="parameter-box">
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
    								<div class="form-group">
        							<label>Profile Name</label>
        							<input type="text" class="form-control urate-form-input" placeholder="Profile Name" id="crname" name="crname">
        						</div>
        						<div class="form-group">
        							<label>Favorite</label>
        								<div class="favorite-box result">
        									<div class="panel urate-panel">
        										<div class="panel-body" style="height: 50px">
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
					</form>
        </div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-btn" id="savecr" onclick="getCreateCr()">Save</button>
                    
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn" id="savecombine" onclick="getCreate()">Combine</button>
                    <span id="laodCombine"></span>
									
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
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn">Delete</button>
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
		"ajax": "<?php echo base_url().'createprofileu/list_profile'?>" + "?sess_user_id=" + user_id + "&sess_token=" + token,
		"searchDelay": 700,
		responsive: true,
		"bFilter" : false,
		"bInfo" : false,
		"bLengthChange": false,
    "searching": true
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
        url: "<?php echo base_url();?>createprofileu/searchfav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
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
            return $.get('createprofileu/listsearch?q=' + query, function (data) {
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
                                     text ='<h3 id="crstar_'+datas+'">'+datas+' <a href="javascript:void(0)"  onclick="favorite(1,&#34;'+datas+'&#34;)" ><i class="glyphicon glyphicon-star-empty"></i></a></h3><span id="anak_'+index+'"></span>';
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
        
    function prerun(id){
        $("#modalProcessJob").modal();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>createprofileu/listnotyet" + "?profid=" + id,
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
        url: "<?php echo base_url();?>createprofileu/run_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) {
        if (response.success) {
            location.href = "<?php echo base_url();?>createprofileu/";
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
        url: "<?php echo base_url();?>createprofileu/del_jobs" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) {
        if (response.success) {
            location.href = "<?php echo base_url();?>createprofileu/";
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
						url: "<?php echo base_url();?>createprofileu/create_statistic" + "?sess_user_id=" + user_id + "&sess_token=" + token,
						data: JSON.stringify(form_data),
						dataType: 'json',
						contentType: 'application/json; charset=utf-8'
					}).done(function(response) {
						$(".alert").hide();
						if (response.success) {
							
							location.href = "<?php echo base_url();?>createprofileu/";
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
				url: "<?php echo base_url();?>createprofileu/searchopval" + "?sess_user_id=" + user_id + "&sess_token=" + token,
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
            url: "<?php echo base_url();?>createprofileu/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
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
            url: "<?php echo base_url();?>createprofileu/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
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
            url: "<?php echo base_url();?>createprofileu/chkname" + "?sess_user_id=" + user_id + "&sess_token=" + token + "&q=" + nas,

            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            if(response['data'].hasil == "0"){
                if(nas){
                    var form_data = {
                        list		 : crnewdata,
                        isi			 : crcroptVal1,
                        name	 	 : $("#crname").val()
                    }
                    
                    console.log(form_data);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>createprofileu/create_profiling" + "?sess_user_id=" + user_id + "&sess_token=" + token,
                        data: JSON.stringify(form_data),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
                        $("#laod").empty();
                        $('#savecr').show();
                        $('#modalNewProfile').modal('hide');
                        
                        $('#alertini').append('<div class="alert alert-success alert-dismissible" role="alert" id="suksescr">'
                        +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        +'<i class="fa fa-info-circle"></i> Profile successfuly create</div>');
                        
                        if (response.success) {
                            location.href = "<?php echo base_url();?>createprofileu/";

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
                    +'<i class="fa fa-info-circle"></i> Name not be empty!</div>');
                    
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

