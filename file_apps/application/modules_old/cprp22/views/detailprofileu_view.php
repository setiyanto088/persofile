
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
                  <li class="breadcrumb-item">Smart Profiling</li>
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
              <button class="button_white" style="float: right;" onClick="window.history.back();"><em class="fa fa-arrow-left"></em> &nbsp </button>
          </div>     
      </div>
<!-- Combine Profile -->
	<div class="panel urate-panel">
		<!-- <div class="panel-heading">
			<h3 class='urate-panel-title'> <?php
                               ?><!-- </h3> -->
		<!-- </div> -->
		<div class="panel-body">
			<div class="menu " style="height:400px;">
								<?php 
								 if($detail[0]['grouping'] == 'null' ){
									 
									 echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;border-top: 1px solid rgba(0, 0, 0, 0.2);"> <div class="body" ><h4 ><b>Detail Not Found</b></h4></div></div>';
									 
								 }else{
									 
								if(isset($detail[0])){
										foreach(json_decode($detail[0]['grouping']) as $new2){
											if(isset($new2->Tag)){
												if($new2->Tag != 4){
													if($new2->Data[0] != 'j1'){
														echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;border-top: 1px solid rgba(0, 0, 0, 0.2);"> <div class="body" ><h4 ><b>'.$new2->Tag.'</b></h4>';
														foreach($new2->Data as $k=>$v){
															if($v != "j1"){
																echo " ".$v.",";
															}

														}
														echo '</div></div>';
													}

												}
											}else{
												
												$frd = json_decode(json_encode($new2), true);
												
												foreach($frd as $new4){
														
														if(isset($new4[0])){
															
															foreach($new4 as $new4s){
														
																if(isset($new4s[0])){
																	
																	
																}else{
																
																
																	if(isset($new4s['ANDOR'])){
																		
																		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;border-top: 1px solid rgba(0, 0, 0, 0.2);"> <div class="body" ><h4 ><b style="color:#FF0000">'.$new4s['ANDOR'].'</b></h4></div></div>';
																		
																	}ELSE{
																		
																		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;border-top: 1px solid rgba(0, 0, 0, 0.2);"> <div class="body" ><h4 ><b>'.$new4s['Tag'].'</b></h4>';
																		foreach($new4s['Data'] as $ks=>$vs){
																				echo " ".$vs.",";
																		}
																		echo '</div></div>';
																	}
																	
																}
																
												}
															
														}else{
														
														
															if(isset($new4['ANDOR'])){
																
																echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;border-top: 1px solid rgba(0, 0, 0, 0.2);"> <div class="body" ><h4 ><b style="color:#FF0000">'.$new4['ANDOR'].'</b></h4></div></div>';
																
															}ELSE{
																
																echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;border-top: 1px solid rgba(0, 0, 0, 0.2);"> <div class="body" ><h4 ><b>'.$new4['Tag'].'</b></h4>';
																foreach($new4['Data'] as $k=>$v){
																		echo " ".$v.",";
																}
																echo '</div></div>';
															}
															
														}
														
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


  