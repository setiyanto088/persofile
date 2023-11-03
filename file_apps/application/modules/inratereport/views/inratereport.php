<?php $paths = base_url() . 'assets/AdminBSBMaterialDesign-master/'; ?>
<?php $pathx = base_url() . 'assets/urate-frontend-master/'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Home Post Buy Dashboard</title>

	<!-- Meta Data -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Google Fonts -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/bootstrap.css">

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/buttons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/stats.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/ionicons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/widget.css?v=1.0.1">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/modal.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/alert.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/forms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/table.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/gridstack.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/gridstack-extra.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/scrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/css/chart.css">
	<!-- JQuery DataTable Css -->
	<link href="<?php echo $paths; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

	<style>
		.highcharts-credits {
			display: none;
		}

		#example3_filter {
			margin-top: 10px;
		}

		.dataTable>tbody>tr>.right {
			text-align: right;
		}

		.dataTable>thead>tr>th {
			text-align: center;
		}

		.highcharts-button {
			display: none;
		}

		#container {
			width: 100%;
		}

		.form-control {
			border: none !important;
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

		.highcharts-title {
			color: #4a4d54 !important;
		}
	</style>

</head>

<body>
	<div class="main-container">
		<div class="content-wrapper">
			<div class="container-fluid">
				<!-- Content -->
				<div class="row">
					<div class="col-md-5">
						<ol class="breadcrumb">
							<li class="breadcrumb-item active">Inrate Report</li>
						</ol>
						<h3 class="page-title">Inrate Report</h3>
					</div>
					<div class="col-md-7 text-right">
						<a href="#addNewWidget" class="btn urate-outline-btn btn-lg" data-toggle="modal">
							<span class="ion-edit"></span> Edit Widget
						</a>
						<button type="button" class="btn urate-btn btn-lg" onclick="show()" id="exportWidget" data-complete-text="<span class='ion-android-open'></span> Export Now">
							<span class="ion-android-open"></span> Export
						</button>
						<button type="button" class="btn urate-outline-btn btn-lg btn-cancel hidden">Cancel</button>
						<br />
						<h6 id="hs"></h6>
					</div>
				</div>

				<!-- Dashboard Stats -->
				<!-- / Dashboard Stats -->

				<!-- Dashboard Widget -->
				<div id="widgets" class="row grid-stack">
					<div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2" data-gs-auto-position="1">
						<div class="grid-stack-item-content">
							<div data-widget="widget-2" class="widget">
								<div class="navbar-center">
									<h4 class="title-periode35">Monthly Report</h4>
								</div>
								<div class="navbar-right">
									<div class="btn-group btn-action">
										<div class="checkbox urate-checkbox">
											<input type="checkbox" class="urate-form-checkbox" id="checkOne">
											<label for="checkTwo"></label>
										</div>
										<button type="button" class="btn btn-default" data-target="#deleteWidget" data-toggle="modal" data-widget="Spot by Channel">
											<span class="ion-close-round"></span>
										</button>
									</div>
								</div>
								<div class="widget-content">
									<div class="col-lg-12">
										<div class="col-lg-2">
											<select class="form-control" id="tgl1mr" name="tgl1mr">
												<?php
												foreach ($thn as $periode) {
													if ($periode['TANGGAL'] == $tahunselected) {
														echo "<option value=" . $periode['TANGGAL'] . " selected>" . $periode['TANGGAL'] . "</option>";
													} else {
														echo "<option value=" . $periode['TANGGAL'] . " >" . $periode['TANGGAL'] . "</option>";
													}
												}
												?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control" id="tgl2mr" name="tgl2mr">
												<?php
												foreach ($thn as $periode) {

													if ($periode['TANGGAL'] == $tahunselected) {
														echo "<option value=" . $periode['TANGGAL'] . " selected>" . $periode['TANGGAL'] . "</option>";
													} else {
														echo "<option value=" . $periode['TANGGAL'] . " >" . $periode['TANGGAL'] . "</option>";
													}
												}
												?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control" name="genre_chan" id="genre_chan">
												<option value="ALL" selected>ALL GENRE</option>
												<?php foreach ($genre as $gen) {
													echo '<option value="' . $gen['genre'] . '">' . $gen['genre'] . '</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<button onClick="getInrateReport()" class="btn btn-danger">Filter</button>
 										</div>
									</div>

									<br />
									<br />

									<div class="" style=""><input type="checkbox" value="fta" id="fta_channel8" checked='checked' onclick="getInrateReport();">Include FTA</label></div>

									<div id="inrateReportWrapper" style="width: 100%">
										<table aria-describedby="mydesc"  id="inrateReport" class="table table-striped table-bordered example" style="width: 100%">
											<thead>
												<tr>
													<th rowspan=2 scope="col">Rank <img alt="img" class="cArrowDown" alt="arrow" ></th>
													<th rowspan=2 scope="col">Channel <img alt="img" class="cArrowDown"></th>
													<th rowspan=2 scope="col">Genre <img alt="img" class="cArrowDown"></th>
													<th colspan=5 scope="row"><?PHP echo $tahunselected; ?> <img alt="img" class="cArrowDown"></th>
												</tr>
												<tr>
													<th scope="row">Audience <img alt="img" class="cArrowDown" alt="arrow" ></th>
													<th scope="row">TVR <img alt="img" class="cArrowDown"></th>
													<th scope="row">TVS <img alt="img" class="cArrowDown"></th>
													<th scope="row">Views <img alt="img" class="cArrowDown"></th>
													<th scope="row">Reach <img alt="img" class="cArrowDown"></th>
												</tr>

											</thead>
										</table>
									</div>
 									<canvas id="widget-spot-channel" height="100"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- / Dashboard Widget -->
				<!-- / Content -->
			</div>
		</div>
	</div>
	<!-- / Main Contaner -->

	<!-- Modal New Widget -->
	<div class="modal fade" id="addNewWidget" tabindex="-1" role="dialog" aria-labelledby="addNewWidgetLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="addNewWidgetLabel">Edit Widget</h4>
				</div>
				<div class="modal-body" style="min-height:30vh;">
					<div class="row">

						<div class="col-md-4">
							<div id="widget-2" class="widget selected">
								<div class="navbar-center">
									<h4>Inrate Report</h4>
								</div>
								<div class="navbar-right">
									<div class="btn-group btn-action">
										<div class="checkbox urate-checkbox">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Delete Widget -->
	<div class="modal fade" id="deleteWidget" tabindex="-1">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Delete Widget</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure want to delete ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-delete" data-dismiss="modal">Delete</button>
				</div>
			</div>
		</div>
	</div>

 
	<script src="<?php echo $path; ?>assets/js/table.js"></script>
	<script src="<?php echo $path; ?>assets/js/gridstack.js"></script>
	<script src="<?php echo $path; ?>assets/js/widget.js?v=2"></script>
	<!-- highcharts -->
	<script src="<?php echo $path;?>assets/ext/highcharts.js"></script>
<script src="<?php echo $path;?>assets/ext/exporting.js"></script>
<script src="<?php echo $path;?>assets/ext/offline-exporting.js"></script>

	<!-- Jquery DataTable Plugin Js -->
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
	<script src="<?php echo $paths; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>


	<script async>
		function timesec(id) {
			document.getElementById("modal_filter").focus();

			$("#id_time").val(id);
			$("#modal_time").modal("show");

		}

		function settime() {

 			$("#modal_time").modal("hide");

			var hours = $("#hours").val();
			var minutes = $("#minutes").val();
			var seconds = $("#seconds").val();
			var id_time = $("#id_time").val();

			var time = hours + ":" + minutes + ":" + seconds;

			$("#" + id_time).val(time);

			$("#minutes").val("00").change();
			$("#seconds").val("00").change();
			$("#hours").val("00").change();

		}

		$(function() {
			var elementHandlers = {
				'#editor': function(element, renderer) {
					return true;
				}
			};

			$("#exportWidget").click(function() {
				var doc = new jsPDF();
				var countPage = 0;
				var namefile = '';

 				if ($("#checkOne").is(':checked')) {

					var docs = new jsPDF('l', 'mm', [297, 210]);
					docs.text(155, 30, 'Audience by Channel', null, null, 'center');
					var selPeriode = $('#tahun').find('option:selected').text().split('-');
					docs.text(155, 40, selPeriode[1] + " - " + selPeriode[0], null, null, 'center');

					var elem = document.getElementById("example4");
					var res = docs.autoTableHtmlToJson(elem);
					docs.autoTable(res.columns, res.data, {
						theme: 'plain',
						margin: {
							top: 50,
							left: 20,
							right: 20
						},
						headerStyles: {
							fontStyle: 'bold',
							lineWidth: 0.1,
							lineColor: [44, 62, 80]
						},
						bodyStyles: {
							bottomLineColor: [0, 0, 0],
						},
						styles: {
							columnWidth: 'auto',
							bottomLineColor: [44, 62, 80],
							lineWidth: 0.1
						},
						columnStyles: {
							text: {
 							}
						}
					});

					setTimeout(function() {
						docs.save('Audience by Channel.pdf');
					}, 0);
				}

 				if ($("#checkTwo").is(':checked')) {
		 
					var docc = new jsPDF('l', 'mm', [297, 210]);
					docc.text(155, 30, 'Audience by Program', null, null, 'center');
					var selPeriode = $('#tahun').find('option:selected').text().split('-');
					docc.text(155, 40, selPeriode[1] + " - " + selPeriode[0], null, null, 'center');

					var elem1 = document.getElementById("example3");
					var res1 = docc.autoTableHtmlToJson(elem1);
					docc.autoTable(res1.columns, res1.data, {
						theme: 'plain',
						margin: {
							top: 50,
							left: 20,
							right: 20
						},
						headerStyles: {
							fontStyle: 'bold',
							lineWidth: 0.1,
							lineColor: [44, 62, 80]
						},
						bodyStyles: {
							bottomLineColor: [0, 0, 0],
						},
						styles: {
							columnWidth: 'auto',
							bottomLineColor: [44, 62, 80],
							lineWidth: 0.1
						},
						columnStyles: {
							text: {
 							}
						}
					});

					setTimeout(function() {
						docc.save('Audience by Program.pdf');
					}, 4000);
				}

 				if ($("#checkThree").is(':checked')) {
			 
					var doca = new jsPDF();
					doca.text(105, 30, 'Audience by Time', null, null, 'center');
					var selPeriode = $('#tahun').find('option:selected').text().split('-');
					doca.text(155, 40, selPeriode[1] + " - " + selPeriode[0], null, null, 'center');

					var canvasWidget1 = document.getElementById('widget-spot-time');
					var imgData = canvasWidget1.toDataURL("image/png", 1.0);

					doca.setFillColor(203, 51, 39);
					doca.roundedRect(83, 46, 15.9 * 2.7, 12.2 * 3 + 5, 3, 3, "F");
					doca.addImage(imgData, 'PNG', 83, 50, 15.9 * 2.7, 12.2 * 2.7);
 

					setTimeout(function() {
						doca.save('Audience by Time.pdf');
					}, 4000);
				}

 				if ($("#checkFour").is(':checked')) {
					if (countPage != 0) {
						doc.addPage();
					}



					setTimeout(function() {
						var chart = $('#container5').highcharts();
						chart.exportChart({
							type: 'application/pdf',
							filename: 'Audience By Daypart'
						});
					}, 10000);

				}

 				if ($("#checkSix").is(':checked')) {
					if (countPage != 0) {
						doc.addPage();
					}

					doc.text(105, 30, 'Table', null, null, 'center');
					var selPeriode = $('#tahun').find('option:selected').text().split('-');
					doc.text(155, 40, selPeriode[1] + " - " + selPeriode[0], null, null, 'center');

					var elem = document.getElementById("example3");
					var res = doc.autoTableHtmlToJson(elem);
					doc.autoTable(res.columns, res.data, {
						theme: 'plain',
						margin: {
							top: 50,
							left: 50,
							right: 50
						},
						headerStyles: {
							fontStyle: 'bold'
						},
						bodyStyles: {
							bottomLineColor: [0, 0, 0],
						},
						styles: {
							 
						},
						columnStyles: {
							text: {
								 
							}
						}
					});


					setTimeout(function() {
						doc.save('Audience by Time.pdf');
					}, 4000);
 				}

			});
		});


		$(document).ready(function() {
			$('#week1').change(function() {
				$('#tgl1').val(0);
			});

			$('#tgl1').change(function() {
				$('#week1').val("ALL");
			});

			$('#tgl2').change(function() {
				$('#week2').val("ALL");
			});

			$('#week2').change(function() {
				$('#tgl2').val(0);
			});
		});

		var data = [],
			totalPoints = 110;
		var updateInterval = 320;
		var realtime = 'on';
		var data = ''

		$(function() {
			var fieldas = $('#product_program').val();
			var tgl2 = $('#tgl2').val();
			var week2 = $('#week2').val();

			var tgl1mr = $('#tgl1mr').val();
			var tgl2mr = $('#tgl2mr').val();

			var search_val = $("input[aria-controls='example3']").val();
			var search_val8 = $("input[aria-controls='inrateReport']").val();

			var user_id = $.cookie(window.cookie_prefix + "user_id");
			var token = $.cookie(window.cookie_prefix + "token");

			getInrateReport();

			$('#print_days').on('click', function() {
				var form_data = new FormData();
				var tahun = $('#tahun').val();

				form_data.append('tahun', tahun);


				$.ajax({
					url: "<?php echo base_url() . 'tvprogramun3/audiencebar_by_day_export'; ?>",
					dataType: 'text', 
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function(data) {

						download_file('<?php echo $donwload_base; ?>Audience_by_day.xls', 'Audience_by_day.xls');

					},
					error: function(obj, response) {
						console.log('ajax list detail error:' + response);
					}
				});

			});

			$('#channel_export').on('click', function() {
	 
				if ($('#fta_channel').is(':checked')) {

					var check = "True";
				} else {
					var check = "False";

				}

				var form_data = new FormData();
				var type = $('#audiencebar').val();
				var tahun = $('#tahun').val();
				var bulan = $('#bulan').val();
				var week = $('#week1').val();
				var tgl = $('#tgl1').val();
				var tipe_filter = $('#tipe_filter').val();
				var profile_chan = $('#profile_chan').val();
				var check = check;

				var filter = table4.search()

				form_data.append('cond', filter);
				form_data.append('check', check);
				form_data.append('type', type);
				form_data.append('tahun', tahun);
				form_data.append('bulan', bulan);
				form_data.append('week', week);
				form_data.append('tgl', tgl);
				form_data.append('tipe_filter', tipe_filter);
				form_data.append('profile', profile_chan);

 
				$.ajax({
					url: "<?php echo base_url() . 'tvprogramun3/audiencebar_by_channel_export'; ?>",
					dataType: 'text', 
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function(data) {

						download_file('<?php echo $donwload_base; ?>Audience_by_channel.xls', 'Audience_by_channel.xls');

					},
					error: function(obj, response) {
						console.log('ajax list detail error:' + response);
					}
				});

			});

			$('#channel_export_sum').on('click', function() {
 
				if ($('#fta_channel8').is(':checked')) {

					var check = "True";
				} else {
					var check = "False";

				}

				var user_id = $.cookie(window.cookie_prefix + "user_id");
				var token = $.cookie(window.cookie_prefix + "token");

				var form_data = new FormData();
				var type = $('#product_program').val();
				var field = "Program";
				var tahun = $('#tahun').val();
				var channel_prog = $('#channel_prog').val();
 				var tipe_filter_prog = "live";

 
				var tgl1mr = $('#tgl1mr').val();
				var tgl2mr = $('#tgl2mr').val();
				var genre_prog = $('#genre_chan').val();


				var form_data = new FormData();

				form_data.append('sess_user_id', user_id);
				form_data.append('sess_token', token);
				form_data.append('periode', '<?php echo $tahunselected ?>');
				form_data.append('pilihprog', type);
				form_data.append('tgl1mr', tgl1mr);
				form_data.append('tgl2mr', tgl2mr);
				form_data.append('check', check);
				form_data.append('channel', channel_prog);
				form_data.append('profile', profile_prog);
				form_data.append('tipe_filter_prog', tipe_filter_prog);

 
				$.ajax({
					url: "<?php echo base_url() . 'tvprogramun3/audiencebar_by_channel_export_sum'; ?>",
					dataType: 'text',  
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function(data) {

						download_file('<?php echo $donwload_base; ?>tmp_doc/summary_monthly.xls', 'summary_monthly.xls');

					},
					error: function(obj, response) {
						console.log('ajax list detail error:' + response);
					}
				});

			});

			$('#program_export').on('click', function() {
 
				if ($('#fta_program').is(':checked')) {

					var check = "True";
				} else {
					var check = "False";

				}

				var form_data = new FormData();
				var type = $('#product_program').val();
				var field = "Program";
				var tahun = $('#tahun').val();
				var bulan = $('#bulan').val();
				var tgl = $('#tgl2').val();
				var channel_prog = $('#channel_prog').val();
				var tipe_filter = $('#tipe_filter_prog').val();


				var profile_prog = $('#profile_prog').val();
				var check = check;

				var filter = table3.search()

				var week = $('#week2').val();
				form_data.append('tahun', tahun);
				form_data.append('bulan', bulan);
				form_data.append('week', week);
 				form_data.append('pilihprog', type);
				form_data.append('field', field);
				form_data.append('cond', "<?php echo $cond; ?>");
				form_data.append('periode', "<?php echo $tahunselected ?>");
				form_data.append('profile', profile_prog);
				form_data.append('tgl', tgl);
				form_data.append('check', check);
				form_data.append('tipe_filter', tipe_filter);
				form_data.append('channel_prog', channel_prog);

				//console.log(form_data);

				$.ajax({
					url: "<?php echo base_url() . 'tvprogramun3/audiencebar_by_program_export'; ?>",
					dataType: 'text',  
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function(data) {

						download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_by_program.xls', 'Audience_by_program.xls');

					},
					error: function(obj, response) {
						console.log('ajax list detail error:' + response);
					}
				});

			});

		});

		function getNest() {
			$('#filter_text').val(JSON.stringify(nest));
			$('#filter_form').submit();
		}


		function viewall() {
			var url = '<?php echo base_url(); ?>tvprogramun3';
			var tahun = $('#tahun').val();
			var bulan = $('#bulan').val();
			//  console.log(tahun);

			$("#laod").append(' <img alt="img" id="loading" src="<?php echo base_url(); ?>assets/urate-frontend-master/assets/images/icon_loader.gif">');
			var form = $("<form action='" + url + "' method='post'>" +
				"<input type='hidden' name='tahun' value='" + tahun + "' />" +
				"<input type='hidden' name='bulan' value='" + bulan + "' />" +
				"</form>");
			$('body').append(form);
			form.submit();
		}

		function table1_view() {
			var form_data = new FormData();
			var type = $('#viewby_product').val();
			var field = $('#product_product').val();

			form_data.append('type', type);
			form_data.append('field', field);
			form_data.append('cond', "<?php echo $cond; ?>");

			$.ajax({
				url: "<?php echo base_url() . 'tvprogramun3/cost_by_program'; ?>",
				dataType: 'json',  
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(data) {
					$('#table_program1').html("");
					$('#table_program1').html('<table aria-describedby="mydesc"  id="example2" class="table table-striped table-bordered example" style="color:black"><thead><tr><th>' + field + '</th><th>' + type + '</th></tr></thead></table>');
					obj = jQuery.parseJSON(data);

					console.log(obj);

					$('#example2').DataTable({
						"bFilter": false,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info": false,
						data: obj,
						columns: [{
								data: field
							},
							{
								data: type,
								"sClass": "right",
								render: function(data, type, row) {
									return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2));
								}
							}
						]
					});
				}
			});

		}

		function print_excel() {

			var form_data = new FormData();
			var type = $('#audiencebar').val();
			var tahun = $('#tahun').val();
			var bulan = $('#bulan').val();
			var week = $('#week1').val();
			var tgl = $('#tgl1').val();
			var profile_chan = $('#profile_chan').val();
			var filter = table4.search()

			form_data.append('cond', "<?php echo $cond; ?>");
			form_data.append('type', type);
			form_data.append('tahun', tahun);
			form_data.append('bulan', bulan);
			form_data.append('week', week);
			form_data.append('tgl', tgl);
			form_data.append('profile', profile_chan);

		}

		function download_file(fileURL, fileName) {
			// for non-IE
			if (!window.ActiveXObject) {
				var save = document.createElement('a');
				save.href = fileURL;
				save.target = '_target';
				var filename = fileURL.substring(fileURL.lastIndexOf('/') + 1);
				save.download = fileName || filename;
				if (navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
					document.location = save.href;
					// window event not working here
				} else {
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
			else if (!!window.ActiveXObject && document.execCommand) {
				var _window = window.open(fileURL, '_blank');
				_window.document.close();
				_window.document.execCommand('SaveAs', true, fileName || fileURL)
				_window.close();
			}
		}

		function diff(from, to) {

			var monthNames = ["January", "February", "March", "April", "May", "June",
				"July", "August", "September", "October", "November", "December"
			];


			var arr = [];
			var datFrom = new Date('1 ' + from);
			var datTo = new Date('1 ' + to);
			var fromYear = datFrom.getFullYear();
			var toYear = datTo.getFullYear();
			var diffYear = (12 * (toYear - fromYear)) + datTo.getMonth();

			for (var i = datFrom.getMonth(); i <= diffYear; i++) {
				arr.push(Math.floor(fromYear + (i / 12)) + "-" + monthNames[i % 12]);
			}

			return arr;
		}

		function getInrateReport() {
			if ($('#fta_channel8').is(':checked')) {
				var check = "True";
			} else {
				var check = "False";
			}
			var user_id = $.cookie(window.cookie_prefix + "user_id");
			var token = $.cookie(window.cookie_prefix + "token");

			var form_data = new FormData();
			var type = $('#product_program').val();
			var field = "Program";
			var tahun = $('#tahun').val();
			var channel_prog = $('#channel_prog').val();
			var tipe_filter_prog = "live";

			var tgl1mr = $('#tgl1mr').val();
			var tgl2mr = $('#tgl2mr').val();
			var genre_chan = $('#genre_chan').val();

			$('#inrateReportWrapper').html('');
			$("#inrateReportWrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="img" id="loading" src="<?php echo base_url(); ?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');

			var list_array = diff(tgl1mr, tgl2mr);

			var htl = '';
			var htl_head = '';
			var htl_head2 = '';
			for (var ii = 0; ii < list_array.length; ii++) {
				htl_head += '<th colspan=5 >' + list_array[ii] + '<img alt="img" class="cArrowDown" ></th>';
				htl_head2 += '<th>Audience <img alt="img" class="cArrowDown" ></th><th>TVR <img alt="img" class="cArrowDown" ></th><th>TVS <img alt="img" class="cArrowDown" ></th><th>Views <img alt="img" class="cArrowDown" ></th><th>Reach <img alt="img" class="cArrowDown" ></th>';
			}

			var htl = '<table aria-describedby="mydesc"  id="inrateReport" class="table table-striped table-bordered example" style="width: 100%">' +
				'<thead>' +
				'<tr>' +
				'<th rowspan=2>Rank <img alt="img" class="cArrowDown" ></th>' +
				'<th rowspan=2>Channel <img alt="img" class="cArrowDown" ></th>' +
				'<th rowspan=2>Genre <img alt="img" class="cArrowDown" ></th>' +
				htl_head +
				'</tr>' +
				'<tr>' + htl_head2 + '</tr>' +
				'</thead>' +
				'</table>';

			var form_data = new FormData();

			form_data.append('sess_user_id', user_id);
			form_data.append('sess_token', token);
			form_data.append('periode', '<?php echo $tahunselected ?>');
			form_data.append('pilihprog', type);
			form_data.append('tgl1mr', tgl1mr);
			form_data.append('tgl2mr', tgl2mr);
			form_data.append('check', check);
			form_data.append('channel', channel_prog);
			form_data.append('genre', genre_chan);
			form_data.append('tipe_filter_prog', tipe_filter_prog);

			$.ajax({
				url: "<?php echo base_url() . 'inratereport/get_report'; ?>",
				dataType: 'text',  
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(data) {
					$('#inrateReportWrapper').html(htl);

					obj = jQuery.parseJSON(data);
					var column = [];
					column[0] = {
						data: 'Rangking'
					};
					column[1] = {
						data: 'CHANNEL'
					};
					column[2] = {
						data: 'GENRE'
					};
					var i_d = 3;
					for (var ii = 0; ii < list_array.length; ii++) {
						column[i_d] = {
							data: 'AUDIENCE' + ii,
							"sClass": "right",
							render: function(data, type, row) {
								if(data){
									return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0))
								}else{
									return parseInt(0);
								}
							}
						};
						i_d++;
						column[i_d] = {
							data: 'TVR' + ii,
							"sClass": "right",
							render: function(data, type, row) {
								if(data){
									return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))
								}else{
									return '0.00';
								}
							}
						};
						i_d++;
						column[i_d] = {
							data: 'TVS' + ii,
							"sClass": "right",
							render: function(data, type, row) {
								if(data){
									return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(2))
								}else{
									return '0.00';
								}
							}
						};
						i_d++;
						column[i_d] = {
							data: 'VIEWS' + ii,
							"sClass": "right",
							render: function(data, type, row) {
								if(data){
									return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0))
								}else{
									return parseInt(0);
								}
							}
						};
						i_d++;
						column[i_d] = {
							data: 'REACH' + ii,
							"sClass": "right",
							render: function(data, type, row) {
								if(data){
									return new Intl.NumberFormat('id-ID').format(parseFloat(data).toFixed(0))
								}else{
									return parseInt(0);
								}
							}
						};
						i_d++;

					}

					$('#inrateReport').DataTable({
						"scrollX": true,
						"bFilter": false,
						"scrollX": true,
						"aaSorting": [],
						"bLengthChange": false,
						'iDisplayLength': 10,
						"sPaginationType": "simple_numbers",
						"Info": false,
						"searching": true,
						"language": {
							"decimal": ",",
							"thousands": "."
						},
						data: obj,
						columns: column
					});
				}
			});
		}

		$(document).ready(function() {

			var selPeriode = $('#tahun').val();

			$(".title-periode1").html($(".title-periode1").html() + "<br><span style='font-size: 12px;'>" + selPeriode + "<span>");
			$(".title-periode2").html($(".title-periode2").html() + "<br><span style='font-size: 12px;'>" + selPeriode + "<span>");
			$(".title-periode3").html($(".title-periode3").html() + "<br><span style='font-size: 12px;'>" + selPeriode + "<span>");
			$(".title-periode4").html($(".title-periode4").html() + "<br><span style='font-size: 12px;'>" + selPeriode + "<span>");

		});

		function show() {
			$('#hs').html('*check widget first before export');
		}

		$(document).ready(function() {
			$(".table th").on("click", function() {
				if ($(this).attr("class") == "sorting_asc" || $(this).attr("class") == "right sorting_asc") {
					$(this).children().css("transform", "rotate(180deg)");
				} else if ($(this).attr("class") == "sorting_desc" || $(this).attr("class") == "right sorting_desc") {
					$(this).children().css("transform", "rotate(0deg)");
				}
			});
		});
	</script>

</body>

</html>