<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audienceresallp22 extends JA_Controller {
  public function __construct()
	{
      parent::__construct();			
      $this->load->model('audience_model');
	 
	  
	}
	
	public function channelsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->audience_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
	
	public function index(){
      $id = $this->session->userdata('project_id');
      $iduser = $this->session->userdata('user_id');
      
	 $test_prod = $this->audience_model->test_new();
	   
	  
      if($id == null){
          $id = 0;
      }else{
          $id = $this->session->userdata('project_id');
      }
      if(!$this->session->userdata('user_id')) {
          redirect ('/login');
      }
      
      $data['profile'] = $this->audience_model->list_profile($iduser);
      $data['daypart'] = $this->audience_model->list_daypart($iduser);
	  $data['channels'] = $this->audience_model->get_channel(); 
      
	  
      $typerole = $this->session->userdata('type_role');
      $data['listparent'] = $this->audience_model->listdataprofilenew($typerole);
      $data['currdate'] = $this->audience_model->current_date();
	  
	  $menu = array(
				'items' => array(),
				'parents' => array() 
			);
	  
	  $result = $this->audience_model->tree1();
			
			foreach ($result as $items)
				{
				$menu['items'][$items['ID']] = $items;
				$menu['parents'][$items['PARENTID']][] = $items['ID'];
				}
            
            $result["data"] = $menu;
    
			$data['tree_s'] = $this->_build_menu(0, $result["data"]);
			
      
      $this->template->load('maintemplate', 'audienceresallp22/views/audience_view', $data);
	}
	
		function generate_html() {
		return $this->_build_menu(0, $this->menu_data['data']);
	}
	
	function _build_menu($parent, $menu)
	{
	   $html = '';
	   if (isset($menu['parents'][$parent]))
	   {
      $packageSeq = 0;
		   foreach ($menu['parents'][$parent] as $itemId)
		   {                 
			  if( ! isset($menu['parents'][$itemId]))
			  {
				  
				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","id" : "'.$menu['items'][$itemId]['VALUE'].'='.$menu['items'][$itemId]['FIELD'].'='.$menu['items'][$itemId]['PARENTFIELD'].'='.$menu['items'][$itemId]['PARENTDEFAULT'].'='.$menu['items'][$itemId]['LABEL'].'", "state" : { "opened" : false } }';
				
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {                        

				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","state" : { "opened" : false } ,"children" : [ ';
				
				$html .= $this->_build_menu($itemId, $menu);
				
				$html .= ' ] }'; 
				
			  }   
		   }
	   }
	   
	   $htmls =str_replace("}{","},{",$html); 
	   
	   return $htmls;
	}
	
	
	
	public function list_tree_profile(){
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		$id_profile = $this->Anti_si($this->input->post('id_profile',true));
		
		$list = $this->audience_model->get_profile_detail($id_profile);
		
		$grouping = json_decode($list[0]['grouping'],true);
		
		$array_data = [];
		foreach($grouping as $groupings){
			$data = $groupings['Data'];
			foreach($groupings['Data'] as $dataq){
				
				$last_param = $this->audience_model->get_last_param($groupings['Tag'],$dataq);
				
				$id_node = $dataq."=".$groupings['Tag']."=".$groupings['Tag']."=0=".$last_param[0]['LABEL'];
				$array_data[] = $id_node;
			}
		}
		
		 $result = array(
                'success' => true,
                'data' => $array_data
          );
		
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
	public function cr_pp(){
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$data = $_POST['list'];
		$channel = $this->Anti_si($_POST['channel']);

		$start_date = explode('/',$this->Anti_si($_POST['start_date']));
		$end_date = explode('/',$this->Anti_si($_POST['end_date']));
		$program = $this->Anti_si($_POST['program']);
		$daypart = $this->Anti_si($_POST['daypart']);
		
		$time_segment = explode('-',$daypart);
		
		
		$text_w = '  ';
		$text_field = ' ';

		$array_stag['merk_hometht'] = ['',3];
		$array_stag['merk_ac'] = ['',3];
		$array_stag['merk_waterhtr'] = ['',2];
		$array_stag['merk_washmch'] = ['',3];
		$array_stag['merk_mcwave'] = ['',3];
		$array_stag['merk_refri'] = ['',3];
		$array_stag['merk_audio'] = ['',2];
		$array_stag['merk_pc'] = ['',3];
		$array_stag['merk_laptop'] = ['',3];
		$array_stag['merk_tablet'] = ['',3];
		$array_stag['merk_smphone'] = ['',3];
		$array_stag['merk_printer'] = ['',2];
		$array_stag['merk_vidgame'] = ['',3];
		$array_stag['merk_riceckr'] = ['',3];
		$array_stag['merk_dvd'] = ['',3];
		$array_stag['merk_fan'] = ['',3];
		$array_stag['merk_bike'] = ['_',2];
		
		$curr_field = '';
		
		$text_w = '  ';
		$text_field = ' ';
		
		$array_datas = [];
		$data_prov = [];
		$ai = 0;
		
		$datax = $data;
		
		foreach($datax as $kkkx){
			
			$data_dx = explode('=',$kkkx);
			
			IF(ISSET($data_dx[1])){
			
				if($data_dx[1] == 'kabkot'){
					
					 $list = $this->audience_model->get_prof($data_dx[0]);
					 
					 $data_prov[$list[0]['PRNT']] = $list[0]['PRNT']."=prov=prof=0=".$list[0]['PRNT'];
					
				}
			
				
			
			}
			
		}
		
		foreach($data_prov as $data_provs){
			
			$data[] = $data_provs;
			
		}
		
		
		foreach($data as $kkk){
			
			$data_d = explode('=',$kkk);

			IF(ISSET($data_d[1])){
				
					
				
				IF(ISSET($array_stag[$data_d[1]])){
					
					$trunk = $array_stag[$data_d[1]];
					for($iu=1;$iu<=intval($trunk[1]);$iu++){
						
						$ext = $trunk[0].''.$iu;
						if($curr_field == ''){
							$curr_field = $data_d[1].$ext;
							
							$array_datas[$data_d[2]]['FIELD'][] = $data_d[1].$ext;
							$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
							$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[4];
							$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
							
						}else{
							
							if($curr_field == $data_d[1].$ext){
								$array_datas[$data_d[2]]['FIELD'][] = $data_d[1].$ext;
								$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
								$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[4];
								
							}else{
								$curr_field = $data_d[1].$ext;
								$ai++;
								 
								$array_datas[$data_d[2]]['FIELD'][] = $data_d[1].$ext;
								$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
								$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
								$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[4];
							}
							
						}
						
					}
					
				}else{
			
					if($curr_field == ''){
						$curr_field = $data_d[1];
						
						$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
						$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
						$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[4];
						$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
						
					}else{
						
						if($curr_field == $data_d[1]){
							$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
							$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
							$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[4];
							
						}else{
							$curr_field = $data_d[1];
							$ai++;
							
							$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
							$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
							$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
							$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[4];
						}
						
					}
				
				}
			}
		}
		
		  

				
		  
		  
		$array_table = [];
		$table_html2 = '';
		$yp = 0;
		$rmo = 0;
		$sad = 0;
		
		$w_head = '';
		
		foreach($array_datas as $array_datasss){

			
			$val_in = "";
			foreach($array_datasss['VALUE'] as $array_datasssll){
				
				$val_in .= "'".$array_datasssll."',";
				
			}
			
			
			
			IF($daypart == 'ALL'){
				$segment_s = "";
			}else{
				$segment_s = "AND formatDateTime(`BEGIN_PROGRAM`,'%T') BETWEEN '".$time_segment[0]."' AND '".$time_segment[1]."'";
			}
			
			$val_in = substr($val_in, 0, -1);
			
			$w_head .= " ".$array_datasss['FIELD'][0]." IN (".$val_in.") AND ";
			
			if($channel == 'ALL'){
				
				$query_ss = "
				
				SELECT PARENT,`FIELD`, LABEL, COUNT(RESPID) RESP, SUM(WEIGHT) IH, SUM(WEIGHT_ALL) ALLS FROM ( 

				SELECT C.FIELD AS FIELD,PARENT,B.".$array_datasss['FIELD'][0]." AS ffd,C.LABEL as LABEL, A.RESPID as RESPID, WEIGHT , WEIGHT_ALL FROM `CDR_EPG_RES_ALL_STEP2_2022` A
				JOIN (SELECT '".$array_datasss['FIELD'][0]."' as vds,".$array_datasss['FIELD'][0].",RESPID2 as RESPID FROM URBAN_PROFILE_P22
				WHERE ".$array_datasss['FIELD'][0]." IN (".$val_in.")) B ON A.RESPID = B.RESPID
				JOIN (SELECT B.LABEL AS PARENT, A.* FROM `TREE_PROFILING_RES_P22` A
				JOIN TREE_PROFILING_RES_P22 B ON A.PARENTID = B.ID) C ON B.".$array_datasss['FIELD'][0]." = C.VALUE AND C.FIELD = B.vds
				WHERE BEGIN_PROGRAM BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' and '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
				".$segment_s."
				GROUP BY A.RESPID,C.FIELD,PARENT,ffd,C.LABEL, A.RESPID, WEIGHT , WEIGHT_ALL
				)
				GROUP BY ffd,PARENT,`FIELD`, LABEL
				ORDER BY SUM(WEIGHT_ALL) DESC
				";
				
			}else{
			
				if($program == 'ALL,ALL'){
				
				$query_ss = "
				
				SELECT PARENT,`FIELD`, LABEL, COUNT(RESPID) RESP, SUM(WEIGHT) IH, SUM(WEIGHT_ALL) ALLS FROM ( 

				SELECT C.FIELD AS FIELD,PARENT,B.".$array_datasss['FIELD'][0]." AS ffd,C.LABEL as LABEL, A.RESPID as RESPID, WEIGHT , WEIGHT_ALL FROM
				`CDR_EPG_RES_ALL_STEP2_2022` A
				JOIN (SELECT '".$array_datasss['FIELD'][0]."' as vds,".$array_datasss['FIELD'][0].",RESPID2 as RESPID FROM URBAN_PROFILE_P22
				WHERE ".$array_datasss['FIELD'][0]." IN (".$val_in.")) B ON A.RESPID = B.RESPID
				JOIN (SELECT B.LABEL AS PARENT, A.* FROM `TREE_PROFILING_RES_P22` A
				JOIN TREE_PROFILING_RES_P22 B ON A.PARENTID = B.ID) C ON B.".$array_datasss['FIELD'][0]." = C.VALUE AND C.FIELD = B.vds
				WHERE A.CHANNEL = '".$channel."'
				AND BEGIN_PROGRAM BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' and '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
				".$segment_s."
				GROUP BY A.RESPID,C.FIELD,PARENT,ffd,C.LABEL, A.RESPID, WEIGHT , WEIGHT_ALL
				)
				GROUP BY ffd,PARENT,`FIELD`, LABEL
				ORDER BY SUM(WEIGHT_ALL) DESC
				";
				
				}else{
					
				$query_ss = "
				
				SELECT PARENT,`FIELD`, LABEL, COUNT(RESPID) RESP, SUM(WEIGHT) IH, SUM(WEIGHT_ALL) ALLS FROM ( 

				SELECT C.FIELD AS FIELD,PARENT,B.".$array_datasss['FIELD'][0]." AS ffd,C.LABEL as LABEL, A.RESPID as RESPID , WEIGHT , WEIGHT_ALL FROM 
				`CDR_EPG_RES_ALL_STEP2_2022` A
				JOIN (SELECT '".$array_datasss['FIELD'][0]."' as vds, ".$array_datasss['FIELD'][0].",RESPID2 as RESPID FROM URBAN_PROFILE_P22
				WHERE ".$array_datasss['FIELD'][0]." IN (".$val_in.")) B ON A.RESPID = B.RESPID
				JOIN (SELECT B.LABEL AS PARENT, A.* FROM `TREE_PROFILING_RES_P22` A
				JOIN TREE_PROFILING_RES_P22 B ON A.PARENTID = B.ID) C ON B.".$array_datasss['FIELD'][0]." = C.VALUE AND C.FIELD = B.vds
				WHERE A.CHANNEL = '".$channel."'
				AND PROGRAM = '".$program."'
				AND BEGIN_PROGRAM BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' and '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
				".$segment_s."
				GROUP BY A.RESPID,C.FIELD,PARENT,ffd,C.LABEL, A.RESPID, WEIGHT , WEIGHT_ALL
				)
				GROUP BY ffd,PARENT,`FIELD`, LABEL
				ORDER BY SUM(WEIGHT_ALL) DESC
				";	
					
				}
			
			}
			
			//ECHO $query_ss;DIE;
			 $list = $this->audience_model->list_sps($query_ss);
			 
			 if (empty($list)) {
			}else{
				
				 $array_table[$yp]['NAME'] = $list[0]['PARENT'];
			
			
				$tbd = '';
				$no_no = 1;
				$lbl = '';
				$lbl2 = $array_datasss['FIELD'][0];
				
				
				$total_per = 0;
				foreach($list as  $array_tablesw){
					
					
					
					$total_per = $total_per + $array_tablesw['ALLS'];
					
				}
				
				
				$oi = 0;
				
				$lbl_tbd = '';
				
				 foreach($list as  $array_tables){
					 $tbd .= '
						<tr>
							<th>'.$no_no.'.</th>
							<th>'.$array_tables['LABEL'].'</th>
							<th>'.number_format($array_tables['ALLS'],0,',','.').'</th>
							<th>'.number_format(($array_tables['ALLS']/$total_per)*100,2,',','.').'</th>
						</tr>
					 ';
					 
					 
					 
					 if($array_tables['FIELD'] == 'PROV'){
						  $lbl = 'Provinsi';
					 }else if($array_tables['FIELD'] == 'KOTA'){
						  $lbl = 'Kota';
					 }else{
						  $lbl = $array_tables['PARENT'];
					 }
					 
					 $lbl_tbd = $lbl_tbd.''.$no_no.'|'.$array_tables['LABEL'].'|'.number_format($array_tables['ALLS'],0,',','.').'|'.number_format(($array_tables['ALLS']/$total_per)*100,2,',','.').'#';
					
						$array_table[$yp]['DATA'][$oi]['ALLS'] = $array_tables['ALLS'];
						$array_table[$yp]['DATA'][$oi]['IH'] = $array_tables['IH'];
						$array_table[$yp]['DATA'][$oi]['LABEL'] = $array_tables['LABEL'];
						$array_table[$yp]['DATA'][$oi]['PARENT'] = $array_tables['PARENT'];
						$array_table[$yp]['DATA'][$oi]['RESP'] = $array_tables['RESP'];
						$array_table[$yp]['DATA'][$oi]['PROSEN'] = number_format(($array_tables['ALLS']/$total_per)*100,2,',','.');
					
					 $no_no++;
					 $oi++;
				 }
				 
				 
				
				if(fmod($rmo,2) == 0 ){
					$table_html2 .= ' <div class="row">';
				}
				
				$lbl_tbd = 'No.|'.$lbl.'|Audience|Prosentase#'.$lbl_tbd;
				
				$table_html2 .= ' <div class="col-md-6" style="margin-bottom:10px;">
								  <div class="result-table urate-panel" style="padding:10px">
									<div class="row">
										<div class="col-md-5">
											<H4><b>'.$lbl.'</b></h4>
										</div>
										<div class="col-md-7 text-right">
											<button type="button" class="button_black" onClick="export_aud(\''.substr($lbl_tbd, 0, -1).'\')"><i class="fa fa-download"></i> &nbsp Export</button>
										</div>
									</div>
									<br>
									<br>
										<table id="example_'.$lbl2.'" class="hghg table table-striped">
											<thead>
												<tr style="color:red">
													<th>No.</th>
													<th>'.$lbl.'</th>
													<th>Audience</th>
													<th>Prosentase</th>
												</tr>
											</thead>
											<tbody>
											'.$tbd.'
											</tbody>
										</table>
									</div>
							  </div>';
							  
				if(fmod($rmo,2) == 1 ){
					$table_html2 .= ' </div>';
				}
							  
				
				$yp++;
				
				$rmo++;
				$sad++;
				
			}
			 
			 
			
		}
				$f_w_all = substr($w_head, 0, -4);

		
		if($channel == 'ALL'){
		
				  $query_ss_all = "
		  	SELECT  COUNT(RESPID) RESP, SUM(WEIGHT) IH, SUM(WEIGHT_ALL) ALLS FROM ( 

				SELECT C.FIELD AS FIELD,PARENT,B.AGE_GROUP_RESPID AS ffd,C.LABEL as LABEL, A.RESPID as RESPID, WEIGHT , WEIGHT_ALL FROM 
				`CDR_EPG_RES_ALL_STEP2_2022` A
				JOIN (SELECT 'AGE_GROUP_RESPID' as vds,AGE_GROUP_RESPID,RESPID2 as RESPID FROM URBAN_PROFILE_P22
				WHERE ".$f_w_all."
				
				) B 
				ON A.RESPID = B.RESPID
				JOIN (SELECT B.LABEL AS PARENT, A.* FROM `TREE_PROFILING_RES_P22` A
				JOIN TREE_PROFILING_RES_P22 B ON A.PARENTID = B.ID) C ON B.AGE_GROUP_RESPID = C.VALUE AND C.FIELD = B.vds
				
				WHERE BEGIN_PROGRAM BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' and '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
				
				GROUP BY A.RESPID,C.FIELD,PARENT,ffd,C.LABEL, A.RESPID, WEIGHT , WEIGHT_ALL
				)
				ORDER BY SUM(WEIGHT_ALL) DESC
				";
		}ELSE{
			
			if($program == 'ALL,ALL'){
				
			 $query_ss_all = "
		  	SELECT  COUNT(RESPID) RESP, SUM(WEIGHT) IH, SUM(WEIGHT_ALL) ALLS FROM ( 

				SELECT C.FIELD AS FIELD,PARENT,B.AGE_GROUP_RESPID AS ffd,C.LABEL as LABEL, A.RESPID as RESPID, WEIGHT , WEIGHT_ALL FROM 
				`CDR_EPG_RES_ALL_STEP2_2022`  A
				JOIN (SELECT 'AGE_GROUP_RESPID' as vds,AGE_GROUP_RESPID,RESPID2 as RESPID FROM URBAN_PROFILE_P22
				WHERE ".$f_w_all."
				
				) B 
				ON A.RESPID = B.RESPID
				JOIN (SELECT B.LABEL AS PARENT, A.* FROM `TREE_PROFILING_RES_P22` A
				JOIN TREE_PROFILING_RES_P22 B ON A.PARENTID = B.ID) C ON B.AGE_GROUP_RESPID = C.VALUE AND C.FIELD = B.vds
				WHERE A.CHANNEL = '".$channel."'
				AND BEGIN_PROGRAM BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' and '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
				
				GROUP BY A.RESPID,C.FIELD,PARENT,ffd,C.LABEL, A.RESPID, WEIGHT , WEIGHT_ALL
				)
				ORDER BY SUM(WEIGHT_ALL) DESC
				";
			}ELSE{
				
				$query_ss_all = "
		  	SELECT  COUNT(RESPID) RESP, SUM(WEIGHT) IH, SUM(WEIGHT_ALL) ALLS FROM ( 

				SELECT C.FIELD AS FIELD,PARENT,B.AGE_GROUP_RESPID AS ffd,C.LABEL as LABEL, A.RESPID as RESPID, WEIGHT , WEIGHT_ALL FROM 
				`CDR_EPG_RES_ALL_STEP2_2022` A
				JOIN (SELECT 'AGE_GROUP_RESPID' as vds,AGE_GROUP_RESPID,RESPID2 as RESPID FROM URBAN_PROFILE_P22
				WHERE ".$f_w_all."
				
				) B 
				ON A.RESPID = B.RESPID
				JOIN (SELECT B.LABEL AS PARENT, A.* FROM `TREE_PROFILING_RES_P22` A
				JOIN TREE_PROFILING_RES_P22 B ON A.PARENTID = B.ID) C ON B.AGE_GROUP_RESPID = C.VALUE AND C.FIELD = B.vds
				WHERE A.CHANNEL = '".$channel."'
				AND PROGRAM = '".$program."'
				AND BEGIN_PROGRAM BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' and '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
				".$segment_s."
				
				GROUP BY A.RESPID,C.FIELD,PARENT,ffd,C.LABEL, A.RESPID, WEIGHT , WEIGHT_ALL
				)
				ORDER BY SUM(WEIGHT_ALL) DESC
				";
				
			}
		}		
		//ECHO $query_ss_all;DIE;
				
				$list_aa = $this->audience_model->list_sps($query_ss_all);
				
				
						$table_html_all = '<div class="row" style="margin-top:10px;"> 
							
							<div class="col-md-6" style="margin-bottom:10px;">
								  <div class="result-table urate-panel" style="padding:10px">
									<div class="row">
										<div class="col-md-5">
											<H4><b>All Data</b></h4>
										</div>
									</div>
									<br>
									<br>
										<table id="example_aaa" class="table table-striped">
											<thead>
												<tr>
													<th style="color:red">Audience</th>
													<th>'.number_format($list_aa[0]['IH'],0,',','.').'</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
							  </div>
							</div>
							  ';
		
		
		
		 $result["data"]["table"] = $table_html_all.''.$table_html2;	
		 $result["data"]["data"] = $array_table;	
		 $result["data"]["data_all"] = $list_aa[0]['IH'];	
		$this->output->set_content_type('Application/json')->set_output(json_encode($result)); 
		
	}
  
	function audience_export(){
		
		$ads = $this->input->post('ads',true);
		
		$this->load->library('excel');
	   
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	    $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	    $data1 = explode('#',$ads);
	   
	    $it1 = 1;
		foreach($data1 as $data1s){
			
			$frt = explode("|", $data1s);
			
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt[0])
					->setCellValue('B'.$it1, $frt[1])
					->setCellValue('C'.$it1, $frt[2])
					->setCellValue('D'.$it1, $frt[3]);
			
			$it1++;
		}
		
	  
	   

		
		$objPHPExcel->getActiveSheet()->setTitle('Audience Analytics');
		$objPHPExcel->setActiveSheetIndex(0);

		


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_export.xls');
		
		
	}
  
      public function list_program(){
		$_POST = json_decode(file_get_contents("php://input"), true);
        
        if(empty($_POST)){
            $result = array(
                'success' => false,
                'message' => 'Error retrieving list program'
            );
            
            $this->json_result($result);
        }
        
        $param['channel']	= $this->Anti_si($this->input->post('valselect',true));
        $param['date']	= $this->Anti_si($this->input->post('dateselect',true));
        $param['dateend']	= $this->Anti_si($this->input->post('dateend',true));
      
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['dateend']);
          $param['dateend'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['date']);
          $param['date'] = $date->format('Y-m-d');
	  
        
        $list = $this->audience_model->list_program($param);
		
        
        if ( $list ) {
            $result = array(
                'success' => true,
                'data' => $list
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'Data not found'
            );
        } 
        
		 $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }
  
   public function listsearchs(){
        $typerole = $this->session->userdata('type_role');
		
		  
		
        $list = $this->audience_model->listsearch($this->Anti_si($_GET['q']), $typerole);
		
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }  
  
   public function listsearch(){
        $typerole = $this->session->userdata('type_role');
		
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['d']));
          $_GET['d'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['dend']));
          $_GET['dend'] = $date->format('Y-m-d');
		
        $list = $this->audience_model->listsearchs($this->Anti_si($_GET['q']), $typerole); 
		
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }                
  
  public function setdaypart(){
      $typerole = $this->session->userdata('type_role');
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($this->Anti_si($_GET['f'])) ) {
          $from = $this->Anti_si($_GET['f']);
      } else {
          $from = "00:00";
      }
      
      if( ! empty($this->Anti_si($_GET['t'])) ) {
          $to = $this->Anti_si($_GET['t']);
      } else {
          $to = "00:00";
      }
      
      $daypart = $this->audience_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}