
	<!-- Multiple Select -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/fastselect-master/dist/fastselect.min.css">
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css"> 
  <!-- Timepicker -->
	<link rel="stylesheet" href="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.css">
	
	<style>
		.fstElement { font-size: 9px; }
		.fstToggleBtn { min-width: 13em; }
		
		.submitBtn { display: none; }

		.fstMultipleMode { display: block; }
		.fstMultipleMode .fstControls { width: 100%; }
		.fstResults {max-height: 220px;}
    
    i.material-icons.search {
			margin-top: 40px; 
			margin-right: 29px;
		}

		#line-chart{
			min-height: 250px;
		}	
		
		text.highcharts-credits{
			display:none;
		}
    
    #myChart{
      padding-top: 30px;
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
      top: -13px;
  	} 
    
    .timepicker{
      text-align: center;
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
          <div class="col-md-6">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">Urban Lifestyle Media</li>
                  <li class="breadcrumb-item active">Summary Urban Media</li>
              </ol>
              <h3 class="page-title-inner">Summary Urban Media </h3>
          </div>       
      </div>
      <div class="panel urate-panel"> 
          <div class="panel-body" style="height: 150px;">
              <div class="row">

                  <!-- WAKTU FIELD --> 
                  <div class="dataset col-md-4" style="z-index: 999;">
                      <div class="dataset-title">
                          <h4 class="title-text">Kategori</h4>
                      </div>
                      <!-- <div class="input-group">
                          <input class="form-control urate-form-input timepicker"  type="text" name="start_time" id="start_time" value="20:00" placeholder="From ..." />
                          <div class="input-group-addon">-</div>
                          <input class="form-control urate-form-input timepicker"  type="text" name="end_time" id="end_time" value="22:00" placeholder="To ..." />
                      </div> -->
                      <div class="select-wrapper">
                          <select class='form-control' name="type_summ2" id="type_summ2" title='Please Choose Type Summary' >
                              <option value="Geografi" selected="selected" >Geografi</option>
                              <option value="Demografi" >Demografi</option>
                              <option value="Behaviour" >Behaviour</option>
							  <!--<option value="Financial" >Financial</option>
								<option value="Provider" >Provider Internet</option>-->
								<option value="Kebutuhan" >Barang Kebutuhan Sehari-Hari</option>
                              <option value="Prod_own" >Product Ownership - Barang Elektronik</option>
							  <option value="Transportation" >Product Ownership - Transportation</option>
								<option value="Beauty" >Product Ownership - Beauty Product</option>
								<option value="Habit" >Media Habbit</option>
								<option value="Watchin" >Watching Behaviour</option>
                          </select>
                      </div>
                  </div>
				   <div class="dataset col-md-8" style="z-index: 999; ">
						<a href ='<?php echo base_url();?>cprp22' style="float: right;"><button class="button_black" >Back</button></a>
				   </div>
				  <!--
				  <div class="dataset col-md-4" style="z-index: 999;">
                      <div class="dataset-title">
                          <h4 class="title-text">Urban Helix</h4>
                      </div>
                       <div class="input-group">
                          <input class="form-control urate-form-input timepicker"  type="text" name="start_time" id="start_time" value="20:00" placeholder="From ..." />
                          <div class="input-group-addon">-</div>
                          <input class="form-control urate-form-input timepicker"  type="text" name="end_time" id="end_time" value="22:00" placeholder="To ..." />
                      </div> 
                      <div class="select-wrapper" id='urban'>
                          <select class='form-control' name="type_summ2" id="type_summ2" title='Please Choose Type Summary'>
						    <option value="-" selected="selected" disabled="disabled">Select</option>
                          </select>
                      </div>
                  </div>-->
                  <!-- END WAKTU FIELD -->
  
                  <!-- END TV CHANNEL FIELD -->
                  <!-- PROCESS BUTTON 
                  <div class="col-md-12 text-center" style="top: 225px;position: absolute;width: 96%;">
                      <br />
                      <div class="btn-loader">
                          <button class="btn urate-outline-btn btn-lg toggle-vis2" id="processButton" onclick="search()">Process</button>
                          <img class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loader">
                      </div>
                  </div>
                  END PROCESS BUTTON -->
              </div>
          </div>
      </div>
      <!-- /Data Set -->
      <!-- Result -->
      <div class="panel urate-panel urate-panel-result">
          <div class="panel-heading">
              <h3 class='urate-panel-title'>Result</h3>
          </div>
          <div class="panel-body" id="result_summ">
             
				 <h3>Geografi</h3>
				<!--<img style='height: 100%; width: 100%; object-fit: contain' src="<?php echo base_url();?>img/summary/Geo1.png" />-->
				
				<div id="container"></div>
				<div id="container2"></div>
				
				<br>
			<!--	<h3>Demografi</h3>
				<img style='height: 100%; width: 100%; object-fit: contain' src="<?php echo base_url();?>img/summary/Demo1.png" />
              <!-- / Tab panes -->
          </div>
      </div>
      <!-- / Result -->
      <!-- / Content -->
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
          <img alt="image" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif" id="loaderdp" style="display: none;">
					<button type="button" class="btn urate-outline-grey-btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn urate-btn daypart_create" onClick="create_daypart()">Create</button>
				</div>
			</div>
		</div>
	</div>

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
	<!-- cookie -->


  
  <script src="<?php echo $path;?>assets/ext/highmaps.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/id-all.js"></script>
  
  <script language="javascript">	
    	$(function () {
				// $('.highcharts-name-aceh').bind('mouseover',function(e){
			 // $('.highcharts-name-aceh').attr("fill", "#008977");
			 // //alert('aaaaa');
		// });
			 var mapData = Highcharts.maps['countries/id/id-all'];
			 
			 console.log(mapData);
			 
			 
var data = [
    ['id-3700', 0],
    ['id-ac', 48667],
    ['id-jt', 497657],
    ['id-be', 0],
    ['id-bt', 1211057],
    ['id-kb', 119701],
    ['id-bb', 0],
    ['id-ba', 263094],
    ['id-ji', 1577124],
    ['id-ks', 181462],
    ['id-nt', 0],
    ['id-se', 275365],
    ['id-kr', 0],
    ['id-ib', 0],
    ['id-su', 442594],
    ['id-ri', 262828],
    ['id-sw', 108945],
    ['id-ku', 0],
    ['id-la', 0],
    ['id-sb', 212108],
    ['id-ma', 68035],
    ['id-nb', 95130],
    ['id-sg', 0],
    ['id-st', 0], 
    ['id-pa', 0],
    ['id-jr', 7339265],
    ['id-ki', 680687],
    ['id-1024', 141192],
    ['id-jk', 5380048],
    ['id-go', 0],
    ['id-yo', 111652],
    ['id-sl', 334068],
    ['id-sr', 0],
    ['id-ja', 128713],
    ['id-kt', 0]
];



Highcharts.mapChart('container', {
    chart: {
        map: 'countries/id/id-all'
    },

    title: {
        text: ''
    },

    subtitle: {
        text: ''
    },

    mapNavigation: {
        enabled: true,
        buttonOptions: {
            verticalAlign: 'bottom'
        }
    },

    colorAxis: {
        min: 0
    },
	
	legend: {
        enabled: true
    },

  plotOptions: {
					series: {
					  states: {
						inactive: {
							opacity: 1
						},
						hover: {
						  enabled: false,
						}
					  }
					}
				  },
    series: [{
		// enableMouseTracking: false,
        data:  data,
		series:'RESPID',
        states: {
			color:'#989876',
            hover: {
				enabled: true,
                color: '#BADA55'
            }
        },
        dataLabels: {
            enabled: true,
            format: '{point.name}'
        }
    }]
});


Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Kota'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories:[<?php echo join($kota['label'],','); ?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Populasi'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
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
        name: 'Kota',
		color: 'red',
        data: [<?php echo join($kota['value'],','); ?>]

    }]
});
		
		// $('.highcharts-name-aceh').attr("fill", "#008977");
		
		// $('.highcharts-name-aceh').bind('mouseover',function(e){
			 // $('.highcharts-name-aceh').attr("fill", "#008977");
			 // //alert('aaaaa');
		// });
		
		// $('.highcharts-name-aceh').bind('mouseout',function(e){
			 // $('.highcharts-name-aceh').attr("fill", "#008977");
			 // //alert('bbbbb');
		// });

			
			
			 $('.urate-panel-result').show();
			
          $("#dptriger").on('click',function(){
              $('#loaderdp').hide();
              $(".modal .modal-footer button").show();
          });
          
          $('input.toggle-vis').attr('disabled','disabled');   
          
          var titl = $('title').html();
          $('title').html(titl+' (TVS)');
          
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  //startDate: '-1y',
                  endDate: '0d',
                  defaultDate: new Date()
              });                            
              
              m = moment(new Date());              
              $(this).val(m.format('DD/MM/YYYY')); //"<?php echo $currdate[0]['CURRDATE']; ?>"
          });
          
      		$('.timepicker').bootstrapMaterialDatePicker({
      			date: false,
      			format: 'HH:mm:00'
      		});
          
          $('input.toggle-vis').on( 'click', function (e) {
              var colgroup = $(this).attr('data-column');
			  
              $('input.toggle-vis').attr('disabled','disabled');
              search(colgroup);    
              
              var titl = $('title').html().split("(");
              
              $('title').html(titl[0]+'('+colgroup.toUpperCase()+')');
          }); 
          
          $("#checkall").click(function () {
              $('input:checkbox').not(this).prop('checked', this.checked);
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
          
          $('#from, #to').timepicker({
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
                      url		: "<?php echo base_url().'ressummary/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
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
          
          //AJAXtify profile; profile by start date          
          $("#start_date").on("change",function(){  
              $('#profile').empty('');
              //var strVar = "";
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'ressummary/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                  //data	: JSON.stringify(form_data),			
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
                          
                          //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
              //var strVar = "";
              var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";              
                                          
              $.ajax({
                  type	: "POST",
                  url		: "<?php echo base_url().'ressummary/setprofile/'; ?>"+"?f="+$('#start_date').val(),
                  //data	: JSON.stringify(form_data),			
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
                          
                          //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
		  
		    $('[data-for = "type_summ"]').click(function() {
              
				var values =  $("#type_summ").val();
				$("#type_summ2").parent().removeClass('active'); 
                $("#type_summ2").next().next().html('');       
               // $("#type_summ2").next().next().append(strVar);
        
				var strVar = '';

				strVar = "<li data-for='type_summ2'><a href='javascript:;' data-real='0' data-id='type_summ2'>All Kategori</a></li>";
            
				strVar += "<li data-for='type_summ2'><a href='javascript:;' data-real='ggg' data-for='type_summ2'>ddd</a></li>";   
			 
				$("#type_summ2").next().next().html(strVar);
				
                $('.urate-selects .urate-custom-menu > li:not(.modal-link)').click(function() {
                   var f = $(this).val();
				   
				   alert(f);
                });
				
				
				 // $('[data-for = "type_summ2"]').click(function() {
				  
					// var values =  $("#type_summ2").val();
					
						// alert(values);
						 
				
				// });
			 
          });
		  
		  
		    $('#type_summ2').change(function() {
				
				$('.urate-panel-result').hide(); 
        $('#processButton').hide();
        $('#loader').show();
        $('.loader').css('display','block');
		
		$("#result_summ").html("");
		
		var type_summ =  $('#type_summ2').val(); 
		
		if(type_summ == "Geografi"){ 
			var html = '<h3>Geografi</h3><div id="container"></div><div id="container2"></div><br>';
			
			$("#result_summ").html(html); 
			
			var data = [
				['id-3700', 0],
				['id-ac', 48667],
				['id-jt', 497657],
				['id-be', 0],
				['id-bt', 1211057],
				['id-kb', 119701],
				['id-bb', 0],
				['id-ba', 263094],
				['id-ji', 1577124],
				['id-ks', 181462],
				['id-nt', 0],
				['id-se', 275365],
				['id-kr', 0],
				['id-ib', 0],
				['id-su', 442594],
				['id-ri', 262828],
				['id-sw', 108945],
				['id-ku', 0],
				['id-la', 0],
				['id-sb', 212108],
				['id-ma', 68035],
				['id-nb', 95130],
				['id-sg', 0],
				['id-st', 0], 
				['id-pa', 0],
				['id-jr', 7339265],
				['id-ki', 680687],
				['id-1024', 141192],
				['id-jk', 5380048],
				['id-go', 0],
				['id-yo', 111652],
				['id-sl', 334068],
				['id-sr', 0],
				['id-ja', 128713],
				['id-kt', 0]
			];



			Highcharts.mapChart('container', {
				chart: {
					map: 'countries/id/id-all'
				},

				title: {
					text: ''
				},

				subtitle: {
					text: ''
				},

				mapNavigation: {
					enabled: true,
					buttonOptions: {
						verticalAlign: 'bottom'
					}
				},

				colorAxis: {
					min: 0
				},
				
				legend: {
					enabled: true
				},

			  plotOptions: {
								series: {
								  states: {
									inactive: {
										opacity: 1
									},
									hover: {
									  enabled: false,
									}
								  }
								}
							  },
				series: [{
					// enableMouseTracking: false,
					data:  data,
					series:'RESPID',
					states: {
						color:'#989876',
						hover: {
							enabled: true,
							color: '#BADA55'
						}
					},
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}]
			});


			Highcharts.chart('container2', {
				chart: {
					type: 'column'
				},
				title: {
					text: ''
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					categories:[<?php echo join($kota['label'],','); ?>],
					crosshair: true
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Populasi'
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
					name: 'Kota',
					color: 'red',
					data: [<?php echo join($kota['value'],','); ?>]

				}]
			});

			// $('.highcharts-name-aceh').attr("fill", "#008977");
 
		}else if(type_summ == "Demografi"){
			//var html = '<h3>Demografi</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Slide4.JPG" /><br>';
			
			var html = '<h3>Demografi</h3><br><br><div class"row" id="resuld_div"></div>';
			
			$("#result_summ").html(html); 
			
			$("#resuld_div").append('<div id="containera1" class="col-md-6"></div>');

				Highcharts.chart('containera1', {
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: 'pie'
					},
					title: {
						text: '<b>Gender Responden Survey</b>'
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					accessibility: {
						point: {
							valueSuffix: '%'
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.percentage:.1f} %'
							}
						}
					},
					 series: [{
						name: 'Gender',
						colorByPoint: true,
						data: [{
							name: 'Laki-Laki',
							color: 'red',
							y: 2752,
						}, {
							name: 'Perempuan',
							y: 2383
						}]
					}]
				});
				
				
				$("#resuld_div").append('<div id="containera2" class="col-md-6"></div>');
				
				Highcharts.chart('containera2', {
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: 'pie'
					},
					title: {
						text: '<b>Gender Extended Household</b>'
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					accessibility: {
						point: {
							valueSuffix: '%'
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.percentage:.1f} %'
							}
						}
					},
					 series: [{
						name: 'Gender',
						colorByPoint: true,
						data: [{
							name: 'Laki-Laki',
							color: 'red',
							y: 9721088,
						}, {
							name: 'Perempuan',
							y: 9758106
						}]
					}]
				});
				
				$("#resuld_div").append('<div id="containera3" class="col-md-6"></div>');
				Highcharts.chart('containera3', {
					chart: {
						type: 'column'
					},
					title: {
						text: '<b>Age Group Responden Survey</b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($demografi['AGE GROUP RESPONDEN']['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<b>Laki Laki</b>',
						color: 'red',
						data: [<?php echo join($demografi['AGE GROUP RESPONDEN']['value'],','); ?>]

					}]
				});
				
				$("#resuld_div").append('<div id="containera4" class="col-md-6"></div>');
				Highcharts.chart('containera4', {
					chart: {
						type: 'column'
					},
					title: {
						text: '<b>Age Group Extended Household</b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($demografi['AGE GROUP']['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<b>Laki Laki</b>',
						color: 'red',
						data: [<?php echo join($demografi['AGE GROUP']['value'],','); ?>]

					}]
				});
			
				$("#resuld_div").append('<div id="containera5" class="col-md-12"><hr class="solid"></div>');
				$("#resuld_div").append('<div id="containera5" class="col-md-12" style="text-align: center;margin-bottom:30px"><h3><b>Extended Household</b></h3></div>');
			
			<?php $in_cont = 1; foreach($demografi['index'] as $demografis){ ?>
			
				$("#resuld_div").append('<div id="container<?php echo $in_cont; ?>" class="col-md-6"></div>');
				
				Highcharts.chart('container<?php echo $in_cont; ?>', {
					chart: {
						type: 'column'
					},
					title: {
						text: '<b><?php echo $demografis; ?></b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($demografi[$demografis]['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<?php echo $demografis; ?>',
						color: 'red',
						data: [<?php echo join($demografi[$demografis]['value'],','); ?>]

					}]
				});
			
			<?php $in_cont++; } ?>
			
		}else if(type_summ == "Behaviour"){

			var html = '<h3>Behaviour</h3><br><div class"row" id="resuld_divs"></div>';
			$("#result_summ").html(html); 
			
			<?php $in_cont2 = 1; foreach($watch_b['index'] as $watch_bs){ ?>
			
				$("#resuld_divs").append('<h3><?php echo $watch_bs; ?></h3><br><div id="main_cont_<?php echo $in_cont2; ?>" class="col-md-12" ></div><br>');
				
				<?php $in_conts2 = 1; foreach($watch_b[$watch_bs]['index'] as $watch_bs_sub){  ?>
					
					$("#main_cont_<?php echo $in_cont2; ?>").append('<div id="container<?php echo $in_cont2.'-'.$in_conts2; ?>" class="col-md-4"></div>');
				
					Highcharts.chart('container<?php echo $in_cont2.'-'.$in_conts2; ?>', {
						chart: {
							type: 'column'
						},
						title: {
							text: '<b><?php echo $watch_bs_sub; ?></b>'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories:[<?php echo join($watch_b[$watch_bs][$watch_bs_sub]['label'],','); ?>],
							crosshair: true
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Populasi'
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat: '<tr><td style="color:{series.color};padding:0">Populasi: </td>' +
								'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
							showInLegend:false ,
							name: '<?php echo $watch_bs_sub; ?>',
							color: 'red',
							data: [<?php echo join($watch_b[$watch_bs][$watch_bs_sub]['value'],','); ?>]

						}]
					});
			
				<?php 
					$in_conts2++; 
					}
				$in_cont2++; 
				}
				?>
			
			
			
		}else if(type_summ == "Financial"){
			var html = '<h3>Financial</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Slide11.JPG" /><br>';
		}else if(type_summ == "Provider"){
			var html = '<h3>Provider Internet</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Slide12.JPG" /><br>';
		}else if(type_summ == "Kebutuhan"){
			var html = '<h3>Barang Kebutuhan Sehari-Hari</h3><br><br><div class"row" id="resuld_div"></div>';
			
			$("#result_summ").html(html); 
			
			<?php $in_cont = 1; foreach($FMGC['index'] as $FMGCS){ ?>
			
				$("#resuld_div").append('<div id="container<?php echo $in_cont; ?>" class="col-md-3"></div>');
				
				Highcharts.chart('container<?php echo $in_cont; ?>', {
					chart: {
						type: 'bar'
					},
					title: {
						text: '<b><?php echo $merk_data[$FMGCS]['title']; ?></b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($merk_data[$FMGCS]['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<?php echo $merk_data[$FMGCS]['title']; ?>',
						color: 'red',
						data: [<?php echo join($merk_data[$FMGCS]['value'],','); ?>]

					}]
				});
			
			<?php $in_cont++; } ?>
		}else if(type_summ == "Prod_own"){
			
			var html = '<h3>Product Ownership - Barang Elektronik</h3><br><br><div class"row" id="resuld_div"></div>';
			
			$("#result_summ").html(html); 
			
			<?php $in_cont = 1; foreach($electronic['index'] as $electronics){ ?>
			
				$("#resuld_div").append('<div id="container<?php echo $in_cont; ?>" class="col-md-3"></div>');
				
				Highcharts.chart('container<?php echo $in_cont; ?>', {
					chart: {
						type: 'bar'
					},
					title: {
						text: '<b><?php echo $merk_data[$electronics]['title']; ?></b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($merk_data[$electronics]['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<?php echo $merk_data[$electronics]['title']; ?>',
						color: 'red',
						data: [<?php echo join($merk_data[$electronics]['value'],','); ?>]

					}]
				});
			
			<?php $in_cont++; } ?>
		}else if(type_summ == "Transportation"){
			var html = '<h3>Product Ownership - Transportasi</h3><br><br><div class"row" id="resuld_div"></div>';
			
			$("#result_summ").html(html); 
			
			<?php $in_cont = 1; foreach($transport['index'] as $transports){ ?>
			
				$("#resuld_div").append('<div id="container<?php echo $in_cont; ?>" class="col-md-4"></div>');
				
				Highcharts.chart('container<?php echo $in_cont; ?>', {
					chart: {
						type: 'bar'
					},
					title: {
						text: '<b><?php echo $merk_data[$transports]['title']; ?></b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($merk_data[$transports]['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<?php echo $merk_data[$transports]['title']; ?>',
						color: 'red',
						data: [<?php echo join($merk_data[$transports]['value'],','); ?>]

					}]
				});
			
			<?php $in_cont++; } ?>
		}else if(type_summ == "Beauty"){
			var html = '<h3>Product Ownership - Beauty Product</h3><br><br><div class"row" id="resuld_div"></div>';
			
			$("#result_summ").html(html); 
			
			<?php $in_cont = 1; foreach($beauty['index'] as $beautys){ ?>
			
				$("#resuld_div").append('<div id="container<?php echo $in_cont; ?>" class="col-md-3"></div>');
				
				Highcharts.chart('container<?php echo $in_cont; ?>', {
					chart: {
						type: 'bar'
					},
					title: {
						text: '<b><?php echo $merk_data[$beautys]['title']; ?></b>'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories:[<?php echo join($merk_data[$beautys]['label'],','); ?>],
						crosshair: true
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Populasi'
						}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
						name: '<?php echo $merk_data[$beautys]['title']; ?>',
						color: 'red',
						data: [<?php echo join($merk_data[$beautys]['value'],','); ?>]

					}]
				});
			
			<?php $in_cont++; } ?>
		}else if(type_summ == "Habit"){
			var html = '<h3>Media Habbit</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Slide30.JPG" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Slide31.JPG" /><br>';
			
				var html = '<h3>Media Habbit</h3><br><div class"row" id="resuld_divs"></div>';
			$("#result_summ").html(html); 
			
			<?php $in_cont2 = 1; foreach($media['index'] as $medias){ ?>
			
				$("#resuld_divs").append('<h3><?php echo $medias; ?></h3><br><div id="main_cont_<?php echo $in_cont2; ?>" class="col-md-12" ></div><br>');
				
				<?php $in_conts2 = 1; foreach($media[$medias]['index'] as $medias_sub){  ?>
					
					$("#main_cont_<?php echo $in_cont2; ?>").append('<div id="container<?php echo $in_cont2.'-'.$in_conts2; ?>" class="col-md-4"></div>');
				
					Highcharts.chart('container<?php echo $in_cont2.'-'.$in_conts2; ?>', {
						chart: {
							type: 'column'
						},
						title: {
							text: '<b><?php echo $medias_sub; ?></b>'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories:[<?php echo join($media[$medias][$medias_sub]['label'],','); ?>],
							crosshair: true
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Populasi'
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat: '<tr><td style="color:{series.color};padding:0">Populasi: </td>' +
								'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
							showInLegend:false ,
							name: '<?php echo $medias_sub; ?>',
							color: 'red',
							data: [<?php echo join($media[$medias][$medias_sub]['value'],','); ?>]

						}]
					});
			
				<?php 
					$in_conts2++; 
					}
				$in_cont2++; 
				}
				?>
		}else if(type_summ == "Watchin"){
						
				var html = '<h3>Watching Behaviour</h3><br><div class"row" id="resuld_divs"></div>';
			$("#result_summ").html(html); 
			
			<?php $in_cont2 = 1; foreach($viewers_b['index'] as $viewers_bs){ ?>
			
				$("#resuld_divs").append('<h3><?php echo $viewers_bs; ?></h3><br><div id="main_cont_<?php echo $in_cont2; ?>" class="col-md-12" ></div><br>');
				
				<?php $in_conts2 = 1; foreach($viewers_b[$viewers_bs]['index'] as $viewers_b_sub){  ?>
				
					$("#main_cont_<?php echo $in_cont2; ?>").append('<div id="container<?php echo $in_cont2.'-'.$in_conts2; ?>" class="col-md-4"></div>');
					
					<?php if($viewers_b_sub == 'DAY PART'){ ?>
						
						Highcharts.chart('container<?php echo $in_cont2.'-'.$in_conts2; ?>', {
							chart: {
								type: 'bar'
							},
							title: {
								text: '<b><?php echo $viewers_b_sub; ?></b>'
							},
							subtitle: {
								text: ''
							},
							xAxis: {
								categories:['Malam','Sore','Pagi','Siang','Dini'],
								crosshair: true
							},
							yAxis: {
								min: 0,
								title: {
									text: 'Populasi'
								}
							},
							tooltip: {
								headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
								pointFormat: '<tr><td style="color:{series.color};padding:0">Populasi: </td>' +
									'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
								showInLegend:false ,
								name: 'Weekday',
								color: 'red',
								data: [16871354,15652740,14117466,13663694,9762604]

							},{
								showInLegend:false ,
								name: 'Weekend',
								color: 'grey',
								data: [16574629,16160109,12452686,11624676,8225742]

							}]
						});
						
					<?php }else{ ?>
					
						Highcharts.chart('container<?php echo $in_cont2.'-'.$in_conts2; ?>', {
							chart: {
								type: 'bar'
							},
							title: {
								text: '<b><?php echo $viewers_b_sub; ?></b>'
							},
							subtitle: {
								text: ''
							},
							xAxis: {
								categories:[<?php echo join($viewers_b[$viewers_bs][$viewers_b_sub]['label'],','); ?>],
								crosshair: true
							},
							yAxis: {
								min: 0,
								title: {
									text: 'Populasi'
								}
							},
							tooltip: {
								headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
								pointFormat: '<tr><td style="color:{series.color};padding:0">Populasi: </td>' +
									'<td style="padding:0"><b>{point.y}</b></td></tr>',
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
								showInLegend:false ,
								name: '<?php echo $viewers_b_sub; ?>',
								color: 'red',
								data: [<?php echo join($viewers_b[$viewers_bs][$viewers_b_sub]['value'],','); ?>]

							}]
						});
			
					<?php } ?>
			
				<?php 
					$in_conts2++; 
					}
				$in_cont2++; 
				}
				?>
			
		}
		 
		 
		// if(type_summ == "Geografi" || type_summ == "Demografi"  || type_summ == "Behaviour" || type_summ == "Kebutuhan" || type_summ == "Prod_own" || type_summ == "Transportation" ||  type_summ == "Beauty"  ||  type_summ == "Habit" ){ 
		
		// }else{
			// $("#result_summ").html(html); 
		// }
		
		

		$("#loader").hide();
        $('.loader').css('display','none');
        $('#processButton').show();		
		$('.urate-panel-result').show();
				
				 });
				
				
		  $('#type_summ').change(function() {
              
				var values =  $("#type_summ").val();
				
				var strVar = '<option value="-" selected="selected" disabled="disabled">Select</option>';

				if(values == 'Demografi'){
					strVar += '<option value="Demografi" >Demografi</option>';
				}else if(values == 'Geografi'){
					strVar += '<option value="Geografi" >Geografi</option>';
				}else if(values == 'Behaviour'){
					strVar += '<option value="Behaviour" >Behaviour</option>';
					strVar += '<option value="Financial" >Financial</option>';
					strVar += '<option value="Provider" >Provider Internet</option>';
					strVar += '<option value="Kebutuhan" >Barang Kebutuhan Sehari-Hari</option>';
				}else if(values == 'Prod_own'){
					strVar += '<option value="Prod_own" >Product Ownership</option>';
					strVar += '<option value="Transportation" >Transportation</option>';
					strVar += '<option value="Beauty" >Beauty Product</option>';
				}else if(values == 'Med_cosm'){
					strVar += '<option value="Habit" >Media Habbit</option>';
					strVar += '<option value="Watchin" >Watching Behaviour</option>';
				}

				
				
				 $("#type_summ2").html(strVar); 
					//alert(values);
				
					 
			
          });
		   
		  
    	});             
	</script>

  <script language="javascript">
  
	  $('.urate-panel-result').show();
                  // $('#processButton').hide();
                  // $('#loader').show();
                  // $('.loader').css('display','block');
				  
		  // $("#loader").hide();
                  // $('.loader').css('display','none');
                  // $('#processButton').show();		  
				  
  
    	// //multiple channel
    	$('.multipleSelect').fastselect();

  
      //proses
      function search(group=""){
		
		$('.urate-panel-result').hide(); 
        $('#processButton').hide();
        $('#loader').show();
        $('.loader').css('display','block');
		
		$("#result_summ").html("");
		
		var type_summ =  $('#type_summ2').val(); 
		
		if(type_summ == "Geografi"){ 
			var html = '<h3>Geografi</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Geo1.png" /><br>';
		}else if(type_summ == "Demografi"){
			var html = '<h3>Demografi</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Demo1.png" /><br>';
		}else if(type_summ == "Behaviour"){
			var html = '<h3>Behaviour</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour1.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour2.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour3.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour4.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour5.png" /><br>';
		}else if(type_summ == "Financial"){
			var html = '<h3>Financial</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour6.png" /><br>';
		}else if(type_summ == "Provider"){
			var html = '<h3>Provider Internet</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour7.png" /><br>';
		}else if(type_summ == "Kebutuhan"){
			var html = '<h3>Barang Kebutuhan Sehari-Hari</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour8.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour9.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour10.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour11.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour12.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Behavour13.png" /><br>';
		}else if(type_summ == "Prod_own"){
			var html = '<h3>Product Ownership</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner1.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner2.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner3.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner4.png" /><br>';
		}else if(type_summ == "Transportation"){
			var html = '<h3>Transportation</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner5.png" /><br>';
		}else if(type_summ == "Beauty"){
			var html = '<h3>Beauty Product</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner6.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner7.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner8.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Owner9.png" /><br>';
		}else if(type_summ == "Habit"){
			var html = '<h3>Media Habbit</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Media1.png" /><br>';
			html += '<img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Media2.png" /><br>';
		}else if(type_summ == "Watchin"){
			var html = '<h3>Watching Behaviour</h3><img style="height: 100%; width: 100%; object-fit: contain" src="<?php echo base_url();?>img/summary/Media3.png" /><br>';
		}
		 
		$("#result_summ").html(html);
		

		$("#loader").hide();
        $('.loader').css('display','none');
        $('#processButton').show();		
		$('.urate-panel-result').show();
      }
      
      function create_chart(data,cgroup){
          var channel = $('#channel').val();
          //console.log("channel : "+channel);
          
          /* HANDLE ALL CHANNEL */
          if(channel == "0"){
              channel_header = '<?php foreach($channel as $key) { echo $key['channel'] . ","; } ?>';
              
              channel_header = channel_header.slice(0,-1);
          } else {
              channel_header = channel;
          } 
          
          channel_header=channel_header.split(",");
          var ch = [];
          var tgl;
          var tgls = [];
          var tv1tgl = [];                                                 
          
          if (typeof data.tvcc[1] === 'undefined') {
              $('#dtmsg').css('display','block');    
              $("#myChart").remove();
          } else {
              $('#dtmsg').css('display','none');
          }
          
          //tanggal
          tgl = data.tvcc[0];
         // console.log(data.tvcc);
          
          //channel                           
          for(var i=0; i < data.tvcc[1].length; i++){
              tgls.push(data.tvcc[0][i]+"-"+data.tvcc[1][i]);
          } 
		     // console.log(tgls);
      
          //channel
          for(var i=0; i < channel_header.length; i++){
              ch.push(channel_header[i]);
          }
          console.log(ch);
          
          if (myChart !== null) {
              $('#legend').html("");
          }
          
          // var tgl;
          var tv1tgl = [];
          var tv1isi = [];
          var tv1label = [];
          var tv1data = [];
          var tv2data = [];
          var tv3data = [];
          
          var color_list = [
              '#EBF495'	,'#F9B8DB'	,'#EF7CA8'	,'#F4C4FC'	,'#6DD5E8'	,'#B6FC80'	,'#C5FCA4'	
              ,'#D2C0F9'	,'#C6F8FF'	,'#FF75BC'	,'#9ED8F7'	,'#D2C0F9'	,'#9571DD'	,'#F47ADC'	
              ,'#9571DD'
          ]
          
          var htht = '';
          for(var i=0; i < channel_header.length; i++){
              ch.push(channel_header[i]);
              
              htht += '<div class="col-md-2 col-xs-2" style="border: 1px solid #ffffff; background: '+color_list[i]+'; text-align: center;">'+channel_header[i]+'</div>';
              $('#legend').html(htht);
          }
          
          //console.log("data.tvcc.length = "+data.tvcc.length);
          for(var si=2; si < data.tvcc.length; si++){	
              var ind = si-2;
              //console.log("index"+ind+" "+color_list[ind]);
              
              tv1isi.push({
                  label: ch[ind],
                  data: data.tvcc[si],
                  backgroundColor : color_list[ind],
                  borderColor : color_list[ind],
                  fill: false,
              });       
          }
          //console.log(tv1isi);
          
          // RESET CHART
          $("#myChart").remove();
          $('.result-chart-graph').append('<canvas id="myChart"><canvas>');
          
          var ctx = document.getElementById("myChart").getContext('2d');
          
          myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: tgls,
                  datasets: tv1isi
              },
              options: {
                  tooltips: tv1isi,
                  hover: {
                      mode: 'nearest',
                      intersect: true
                  },
                  legend: {
                      position: 'bottom'
                  },
                  scales: {
                      yAxes: [{
                          display: true,
                          scaleLabel: {
                              display: true,
                              labelString: cgroup.toUpperCase()
                          }
                      }]
                  }
              }
          });
      }	
	  
	  
	  function refreshtablefilter(start_date,end_date,profile,ch,daypart,colgroup){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         var form_data = {
              sess_user_id     : user_id,
              sess_token      : token,
              start_date	 : start_date,
              end_date     : end_date,
              profile     : profile,
              channel     : ch,
              dpart     : daypart,
              cgroup     : colgroup
          };
         
          //display table
          var table = $("#myTable").DataTable({
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
																				   // return column >= 7 && column <= 9 ? data.replace( /[$,.]/g, '' ) : data;
																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									    refreshtablefilter(start_date,end_date,profile,ch,daypart,colgroup);
									}).draw();
								  },
                  title: 'UNICS - Channel Comparison',
                  filename: 'UNICS - Channel Comparison'
								}
						  ],
              "language": {
                  "decimal": ",",
                  "thousands": "."
              },
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "destroy": true,
              "ajax": {
                  "url" : "<?php echo base_url().'ressummary/list_tvcc'?>",
                  "type" : "POST",
                  "data" : form_data           
              },
              "searchDelay": 700, 
              "bFilter" : false, 
              "bInfo" : false,
              "iDisplayLength": 10,
              "scrollY":        "500px",
              columnDefs: [
                  {                                                              
                      render: function ( data, type, row, meta ) {
                          return data;						
                      },
                      targets: 0
                  }
              ],	
              "bLengthChange": false,
              "drawCallback": function() {
                  $('#jmlcolspan1').html(colgroup.toUpperCase());
                  $('input.toggle-vis').removeAttr('disabled');   
                  $('.loader').css('display','none');   
                  if(colgroup == 'tvs'){
                      $('#tvs').prop('checked',true);
                      $('#tvr').prop('checked',false);
                      $('#viewers').prop('checked',false);
                  }     
              }
          });
	  }
    
    function search_channel(){
        //console.log("SINI!");
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "<li data-for='channel'><a href='#' data-real='0' data-id='channel'>All Channel</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'ressummary/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query,
            //data	: JSON.stringify(form_data),			
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response[0].PROGRAM);
                $("#channel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].CHANNEL;
                    }
                    
                    //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
                    strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
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
            url		: "<?php echo base_url().'ressummary/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
            //data	: JSON.stringify(form_data),			
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response);
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
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        });
    }         
    
    function search_profile(){
        //console.log("SINI!");         
        var query = $('#search_profile').val();
        var period = $('#start_date').val(); 
        
        $('#profile').empty('');
        
        var strVar = "<li data-for='profile'><a href='#' data-real='0' class='urate-select-form-two' data-for='profile'>All People</a></li>";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'ressummary/profilesearch/'; ?>"+"?q="+query+"&f="+period,
            //data	: JSON.stringify(form_data),			
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                //console.log("response : "+response[0].PROGRAM);
                $("#profile").next().next().next().empty('');   
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0];         
                          strText = '';
                    } else {
                        strResult = response[i].ID;
                        strText = response[i].NAME;
                    }
                    
                    //<li data-for="channel"><a href="#" data-real="ANTV" data-id="channel">ANTV</a></li>
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
    
    $(document).ready(function(){
        $(".table th").on("click",function(){                    
            if($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc"){
                $(this).children('img').css("transform","rotate(180deg)");
            } else if($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc"){
                $(this).children('img').css("transform","rotate(0deg)");
            }
        });
    });     
  </script>