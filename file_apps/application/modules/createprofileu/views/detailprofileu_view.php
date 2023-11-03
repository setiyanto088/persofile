
<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet">	
<link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	
    <!-- Multi Select Plugin Js -->
    <script src="<?php echo $path;?>plugins/multi-select/js/jquery.multi-select.js"></script>
    <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/jstree.min.js"></script>
<style>
.jstree-themeicon{
	 display: none !important;
}

</style>
<script>
		
$( document ).ready(function() {
	
							
});

</script>
  <div class="content-wrapper">
      <div class="container-fluid">
      <div class="row">
          <div class="col-md-6">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">Free to Air</li>
                  <li class="breadcrumb-item">Helix & Smart Profiling</li>
                  <li class="breadcrumb-item active">Detil Profile</li>
              </ol>
              <h3>
                  Detil Profile :
                  <?php
                      if(isset($detail[0])){
                          echo $detail[0]['name'];
                      }
                  ?>
              </h3>
          </div>  
          <div class="col-md-6">
              <button class="btn urate-outline-btn btn-lg" style="float: right;" onClick="window.history.back();">Back</button>
          </div>     
      </div>
<!-- Combine Profile -->
	<div class="panel urate-panel">

		<div class="panel-body">
			<div class="menu " style="height:400px;overflow-y: scroll;">
								<?php 
								
								if(isset($detail[0])){
										foreach(json_decode($detail[0]['grouping']) as $new2){
											if(isset($new2->Tag)){
												if($new2->Tag != 4){
													if($new2->Data[0] != 'j1'){
														echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" > <div class="body" ><h4 >'.$new2->Tag.'</h4>';
														foreach($new2->Data as $k=>$v){
															if($v != "j1"){
																echo "<h4 ><span class='label label-success'>".$v."</span></h4>";
															}

														}
														echo '</div></div>';
													}

												}
											}else{
												
												foreach($new2 as $new4){
													
													
														if(isset($new4->ANDOR)){
															
															
															
														}ELSE{
															
															echo '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" > <div class="body" ><h4 >'.$new4->Tag.'</h4>';
															foreach($new4->Data as $k=>$v){
																
																
																	echo "<h4 ><span class='label label-success'>".$v."</span></h4>";

															}
															echo '</div></div>';
														}
															
														
																
																


												}
										
												
											}
												
											
											
										}
									}
									
									
								?>				
									

								</div>
		</div>
	</div>

	</div>
	</div>


  