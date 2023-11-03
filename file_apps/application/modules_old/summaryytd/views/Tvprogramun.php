    <?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
    <?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home Tv Program TVV Dashboard</title>

  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/bootstrap.css">

  <!-- Styles -->
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/widget.css?v=1.0.1">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/table.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/gridstack-extra.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/grid.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/chart.css">
   <!-- JQuery DataTable Css -->
    <link href="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
	 <script src="<?php echo $path;?>assets/ext/dataTables.fixedColumns.min.js"></script>
	   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">  
    
	 <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Timepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.js"></script> 
  <!-- Multiple Select -->
	<script src="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.standalone.js"></script>
	
  <style>
  .highcharts-credits{
		display: none;
	}
	
	#example3_filter{
		margin-top: 10px;
	}
	.dataTable > tbody > tr > .right {
		text-align: right;
	  }
	  .dataTable > thead > tr > th {
		text-align: center;
	  }
	.highcharts-button{
		display: none;
	}
	#container{
			width: 100%;
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

	.cArrowDown {
	  width: 12px;
	  float: right;
	  margin-right: -25px;
	}
	.highcharts-title{
		color: #4a4d54 !important; 
	}
	
	table.dataTable {
		clear: both;
		margin-top: -1px !important;
		margin-bottom: 0px !important;
		max-width: none !important;
	}
	 
	.even {
		background:#E0E0E0;
	}
	
	    .loader{
      display: block;
      text-align: center;
      padding-top: 10px;
      font-size: 16px;
      font-weight: bold;
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
      bottom: 6px;
  	}    
	
	.urate-form-input{
		
		color: #cb3827;
		
	}
	
  </style>

</head>

<body>


  <!-- Main Container -->
  <div class="main-container">
   
    <!-- / Sidebar -->
    <div class="content-wrapper" style="">
      <div class="container-fluid">
        <!-- Content -->
        <div class="row">
          <div class="col-md-5">                                   
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Pay TV</li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">TV Program TVV Dashboard</li>
            </ol>
            <h3 class="page-title" style="font-weight:bold">TV Program TVV Dashboard</h3>
          </div>
          <div class="col-md-7 text-right">
				<button id="button_filters" onClick="selectAll()" class="button_black"><em class="fa fa-check"></em> &nbsp &nbsp Apply Filter</button>
			<br/>
			
          </div>
		  <div class="col-lg-12">	
				<hr />
			</div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row">
		
		<div class="col-lg-12">	
				<div class="col-lg-12">	
					<div class="col-lg-2">	
						<div class="form-group">
							<label>Start Date Period</label>
							<input type="text"  class="form-control" name="start_date" id="start_date" placeholder="From ..." value="">
						</div>
					</div>
					<div class="col-lg-2">	
						<div class="form-group">
							<label>End Date Period</label>
							<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." value="">
						</div>
					</div>
					<div class="col-lg-2">	
						<label> Data</label>
							<select class="form-control" name="tpe_f" id="tpe_f" > required >
							<option value='ALL' selected  >All</option>
							<option value='Live' >Live</option>
							<option value='TVOD' >TVOD</option>
							
				
							</select>   
					</div>
				</div>   
			
		
			<div class="col-lg-4">	
				<span id="laod"></span>
			</div>
			
		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		 <div class="row" style="margin-right:0px;margin-left:0px;">
          <div class="col-md-4">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path9;?>images/Frame 12311.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Number of TV Program</span>
                <span class="value" id="no_prog" style="color:#000"><?php echo number_format(intval($spots[0]["jmlpr"]),0,',','.'); ?></span>
              </div>
            </div>
          </div> 

          <div class="col-md-4">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path9;?>images/Frame 12312.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Number of TV Channel</span>
                <span class="value" id="no_channel" style="color:#000"><?php echo $spots[0]["jmlchn"]; ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path9;?>images/Frame 12313.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Active Audience</span>
                <span class="value" id="active" style="color:#000"><?php echo number_format(intval($aa),0,',','.'); ?></span>
              </div>
            </div>
          </div>


		  
		  </div>
		  <div class="row" style="margin-right:0px;margin-left:0px;">


          <div class="col-md-4">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path9;?>images/Frame 12314.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Total Views</span>
                <span class="value" id="tot_viw" style="color:#000"><?php echo number_format($total_views[0]["TOTAL_VIEWS"],0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path9;?>images/Frame 12315.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Duration (Hour)</span>
                <span class="value"  id="dur_h" style="color:#000"><?php echo number_format(intval($duration[0]['DURATION'])/60,0,',','.'); ?></span>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="urate-stats">
              <div class="icon" style="max-width:70px" >
                <img src="<?php echo $path9;?>images/Frame 12316.png" alt="urate-stat">
              </div>
              <div class="content">
                <span class="titles">Dur/Views (Min)</span>
                <span class="value" id="dur_view" style="color:#000"><?php echo number_format(($duration[0]['DURATION']/$total_views[0]["TOTAL_VIEWS"]),2,',','.'); ?>
                
                </span>
              </div>
            </div>
          </div>
		 </div>
        </div>
        <!-- / Dashboard Stats -->

        <!-- Dashboard Widget -->
        
          <br>
          
            
             <!-- Modal Load Channel -->
	
        </div>
        <!-- / Dashboard Widget -->
        <!-- / Content -->
      </div>
    </div>
  </div>
  <!-- / Main Contaner -->

  <!-- Modal New Widget -->
  


<!-- Modal Error -->
  <div class="modal fade" id="errorm" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Error </h4>
        </div>
        <div class="modal-body" id="body_error">
          <h5>Maximal Duration is 30 Days !!!! </h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete Widget -->
  <div class="modal fade" id="deleteWidget" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="clearchannel()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Widget</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to delete ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-delete" onClick="clearchannel()" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>
  
  
    <div class="modal fade" id="deletepreset" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Delete Preset ?</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure want to delete ?</p>
		  <input type="hidden" id="preset_name_del" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-delete" data-dismiss="modal" onClick="delete_channel()">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- script type="text/javascript" src="<?php //echo $path;?>assets/js/chart.js"></script -->
  <script src="<?php echo $path;?>assets/js/table.js"></script>
  <script src="<?php echo $path;?>assets/js/gridstack.js"></script>
 <script src="<?php echo $path;?>assets/js/widget.js?v=2"></script>
<!-- highcharts -->
	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>
	 
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo $paths;?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $paths;?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>

<script async >

		


function selectAll(){
	
	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	var tpe_f = $('#tpe_f').val();
	var user_id = $.cookie(window.cookie_prefix + "user_id");
    var token = $.cookie(window.cookie_prefix + "token");   
	
	var form_data = new FormData();  
	form_data.append('end_date', end_date);	
	form_data.append('start_date', start_date);	
	form_data.append('tpe_f', tpe_f);
	
	$('#button_filter').prop( "disabled", true );
	$("#laod").append(' <img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
	
	$.ajax({
		url: "<?php echo base_url().'summaryytd/header_change'; ?>", 
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(data){
			obj = jQuery.parseJSON(data);
			
			console.log(obj);
			
			$('#no_prog').html(obj['jmlprogram']);
			$('#no_channel').html(obj['jmlchannel']);
			$('#active').html(obj['active_audience']);
			$('#tot_viw').html(obj['total_views']);
			$('#dur_h').html(obj['duration']);
			$('#dur_view').html(obj['durmin']);
			
			$("#laod").html('');
			$('#button_filter').prop( "disabled", false );
		}
	});
}



$(function () { 
	
$('#start_date').change(function(){
 
});

$('#end_date').change(function(){
  
});
	
	       $('#start_date').each(function() {
              $('#start_date').datepicker({
                  format: 'yyyy-mm-dd',
                   endDate: '0d',
                  defaultDate: new Date() ,
				    onSelect: function (date) {
						 $(this).change();
					},
					
              }); 
              
              m = moment(new Date());              
 			    $(this).val('<?php echo $last_day; ?>');
          });
		  
		  $('#end_date').each(function() {
              $(this).datepicker({
                  format: 'yyyy-mm-dd',
                  //startDate: '-1y',
                  endDate: '0d',
                  defaultDate: new Date() ,
				    onSelect: function (date) {
						 $(this).change();
					},
              });
              
              m = moment(new Date());              
 			    $(this).val('<?php echo $last_day; ?>');
          });
		  
}
    );	  	
	     
		 
		 
	
	
var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

      

	
	
window.chartColors = {
	red: '#ff5f5f',
	orange: 'rgb(220, 99, 70)',
	yellow: 'rgb(255, 205, 86)',
	green: '#a7d14b',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	white: 'rgb(255, 255, 255)'
};
    

  
$( document ).ready(function() {


	$('#week1').change(function(){
		$('#tgl1').val(0);	
	});
	
	$('#tgl1').change(function(){
		$('#week1').val("ALL");	
	});
	
	$('#tgl2').change(function(){
		$('#week2').val("ALL");	
	});
	
	$('#week2').change(function(){
		$('#tgl2').val(0);	
	});

	
	
	
	
	
	
});


function viewall(){
	
		var url = '<?php echo base_url(); ?>tvprogramun3tvv'; 
		var tahun = $('#tahun').val();
		var bulan = $('#bulan').val();
		//  console.log(tahun);
		  
		 $("#laod").append(' <img id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
		  var form = $("<form action='" + url + "' method='post'>" +
			"<input type='hidden' name='tahun' value='" + tahun + "' />" +
			"<input type='hidden' name='bulan' value='" + bulan + "' />" +
			"</form>");
		  $('body').append(form);
		  form.submit();
		  
	
}
          

$( document ).ready(function() {
  
	
	var selPeriode = $('#tahun').val();
    
    $( ".title-periode1" ).html($(".title-periode1").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
    $( ".title-periode2" ).html($(".title-periode2").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
    $( ".title-periode3" ).html($(".title-periode3").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
    $( ".title-periode4" ).html($(".title-periode4").html()+"<br><span style='font-size: 12px;'>"+selPeriode+"<span>");
	
});

function show(){
	$('#hs').html('*check widget first before export');
}               

$(document).ready(function(){
    $(".table th").on("click",function(){                    
        if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
            $(this).children().css("transform","rotate(180deg)");
        } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
            $(this).children().css("transform","rotate(0deg)");
        }
    });
});
</script>	
    
</body>

</html>