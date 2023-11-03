<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pivotp22 extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('createprofileu_model');
	}
	
	public function index()
	{
		
 		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
 		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
 		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		$data['listprofile'] = $this->createprofileu_model->listprofile($iduser,$idrole);
		
 		
		$typerole = $this->session->userdata('type_role');
 		
		
		
			$menu = array(
				'items' => array(),
				'parents' => array()
			);
			
			// Builds the array lists with data from the menu table
			
			$result = $this->createprofileu_model->tree1();
			
			foreach ($result as $items)
				{
				// Creates entry into items array with current menu item id ie. $menu['items'][1]
				$menu['items'][$items['ID']] = $items;
				// Creates entry into parents array. Parents array contains a list of all items with children
				$menu['parents'][$items['PARENTID']][] = $items['ID'];
				}
             
            $result["data"] = $menu;
    
			$data['tree_s'] = $this->_build_menu(0, $result["data"]);
		 
		$this->template->load('maintemplate', 'pivotp22/views/listu_view', $data);
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
	
	public function create(){
		
		
        $typerole = $this->session->userdata('type_role');
		$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		
 		$this->template->load('maintemplate_res2', 'pivotp22/views/createprofileu_view', $data);
		
	}
	
	public function detail($id){
		$data['detail'] = $this->createprofileu_model->detailnew($this->Anti_si($id));
		$this->template->load('maintemplate_res2', 'pivotp22/views/detailprofileu_view', $data);
		
	}
	
	
	public function list_profile() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('a.id', 'name', 'people');
		
		$search = $this->Anti_si($this->input->get_post('search'));
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
 		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		$params['iduser'] 		= $iduser;
		$params['idrole'] 		= $idrole;
		$list = $this->createprofileu_model->list_profile($params);
				
 		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		
		$data = array();			
		foreach ( $list['data'] as $k => $v ) {
				$ss = '';
			if($v['status'] == 2){
				$ss = $v['name'];
			}else{
					$ss = "<a href='".base_url()."pivotp22/detail/".$v['idprofile']."' >".$v['name']."</a>";
			}
			
			if($v['user_id_profil'] == 0){
				$sss =	"<span>Done</span>";
			}else{
				if($v['status_job'] == 1){
					$sss =	"<span>In Queue</span>";
				}elseif($v['status_job'] == 2){
					$sss = "<span>In progress</span>";
				}elseif($v['status_job'] == 3){
					$sss = "<span>On Queue</span>";
				}else{
					$sss = "<span style='text-align:center;vertical-align:middle'><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$v['idprofile']."' onclick='prerun(".$v['idprofile'].")' >Process</button></span>"; 
 				}
			}
			
			if($v['status_job'] == 2){
				$nnn1 = str_replace("%","",$v['global_progress']);
				$nnn2 = str_replace(" ","",$nnn1);
				$nnn3 = str_replace(",",".",$nnn2);
				$as = (float)$nnn3;
				$nnn =	number_format($as,2,".",",")." %";
			}else{
				$nnn =	"<span>No Process</span>";
			}
			
			$done_p = $this->createprofileu_model->done_p($v['id']);
			
			$opt = "";
			foreach($done_p as $kkkk){
				$opt = $opt."<option>".$kkkk['PERIODE']."</option>";
			}
			
			if($opt == ""){
				$done_ph = "<select><option>Month&nbsp;&nbsp;&nbsp;&nbsp;</option>".$opt."</select>";
			}else{
				
				$done_ph = "<select><option>Month</option>".$opt."</select>";
			}
			
			
			
			$done_p1 = $this->createprofileu_model->done_p1($v['id']);
			
			$opt1 = "";
			foreach($done_p1 as $kkkk1){
				$opt1 = $opt1."<option>".$kkkk1['PERIODE']."</option>";
			}
			
			if($opt1 == ""){
				$done_ph1 = "<select><option>Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>".$opt1."</select>";
			}else{
				
				$done_ph1 = "<select><option>Month</option>".$opt1."</select>";
			}
			
			
			
			if($v['user_id_profil'] <> 0){
				
				array_push($data, 
				array(
					"<p style='text-align:left;vertical-align:middle'>".$ss."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$v['date_create']."</p>",
					"<p style='text-align:right;vertical-align:middle'>".number_format($v['people'], 0, ',', '.')."<p>",
					"<p style='text-align:right;vertical-align:middle'>".number_format($v['respondents'], 0, ',', '.')."<p>",
					"<p style='text-align:right;vertical-align:middle'>".number_format($v['respondents_all'], 0, ',', '.')."<p>",
					"<p style='text-align:center;vertical-align:middle'>".$done_ph1."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$nnn."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$sss."</p>",
					"<span style='text-align:center;vertical-align:middle'><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$v['idprofile']."' onclick='predelete(".$v['idprofile'].")' >Delete</button></span>"
				)
			);
				
			}else{
				
				array_push($data, 
					array(
						"<p style='text-align:left;vertical-align:middle'>".$ss."</p>",
						"<p style='text-align:center;vertical-align:middle'>".$v['date_create']."</p>",
						"<p style='text-align:right'>".number_format($v['people'], 0, ',', '.')."<p>",
						"<p style='text-align:right'>".number_format($v['respondents'], 0, ',', '.')."<p>",
						"<p style='text-align:right'>".number_format($v['respondents_all'], 0, ',', '.')."<p>",
						"<p style='text-align:center;vertical-align:middle'>".$done_ph1."</p>",
						"<p style='text-align:center;vertical-align:middle'>".$nnn."</p>",
						"<p style='text-align:center;vertical-align:middle'>Default</p>", 
						"<p style='text-align:center;vertical-align:middle'>Profile</p>"
					)
				);
				
			}
			

		}
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function fe_view($kkk){
		
		if($kkk == "0"){
			
			$rtr = "<span'>Not Process<span>";
			
		}elseif($kkk == "1"){
			
			$rtr = "<span'>0 %<span>";
			
		}else{
			
			$rtr = "<span>".$kkk."<span>";
		}
		
		return $rtr;
		
	}
	
	public function listsearch(){
           $typerole = $this->session->userdata('type_role');
		$list = $this->createprofileu_model->listsearch($this->Anti_si($_GET['q']), $typerole);
        if ( $list ) {			
			
			$this->output->set_content_type('application/json')->set_output(json_encode($list));
		} else {
			$result = array( 'Value not found!' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	public function searchfav(){
        $_POST = json_decode(file_get_contents("php://input"), true);
		$list = $this->createprofileu_model->searchfav($_POST);
        if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => true, 'message' => 'data null', 'data' => array('hasil' => array())  );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	
	public function run_jobs(){
		$_POST = json_decode(file_get_contents("php://input"), true);
 		$list = $_POST['pid'];
		$periode_list = $_POST['val_periode_list'];                
 		
 		 
		if ( $list !== false ) {

			$curr = $this->createprofileu_model->check_job_user();
 			
			if($curr[0]['RUNNING_JOB'] < 1 ){
				
				$this->createprofileu_model->insert_pid_partial($list,$periode_list); 
                      
				 
				$command = 'php /var/www/jobs/profiling/ultimate/profile_jobs_res.php '.$list.' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$list.'res.log 2>&1 & ';  
			
				 
                
				
				$pid = shell_exec($command);
			
			
				 
			
			}else{
				$this->createprofileu_model->inset_queue($list,$periode_list);
			}
			
		 
		
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	
  public function del_jobs(){
	  
	  $_POST = json_decode(file_get_contents("php://input"), true);
 	  
		$list = $_POST['pid'];
	  
		$command = 'php /var/www/jobs/profiling/ultimate/delete_profile_res.php '.$list.' > /var/www/jobs/profiling/ultimate/delete_log_profile_res_'.$list.'.log 2>&1 & ';  
			
 		$pid = shell_exec($command); 
	  
 	  
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
  }
	
	public function create_pivot(){
		
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		
		$data1 = $_POST['list'];
		$data2 = $_POST['list2'];
		$notab = $_POST['notab'];
		
		$age_kon = 0;
		$age_kon33 = 0;
		
		foreach($data1 as $gut){
			$data_d = explode('=',$gut);
			IF(ISSET($data_d[1])){
				if($data_d[1] == 'gender'){
					
					$age_kon = 1;
					
					foreach($data1 as $guts){
						$data_ds = explode('=',$guts);
						IF(ISSET($data_ds[1])){
							if($data_ds[1] == 'age_group' || $data_ds[1] == 'age'){
								$age_kon33 = 1;
								$data[] = $data_d[0]."-".$data_ds[0]."=".$data_d[1]."_".$data_ds[1]."=".$data_d[2]."_".$data_ds[2]."=0=".$data_d[4]." ".$data_ds[4]."";
 							}else if($data_ds[1] == 'gender'){
								
							}ELSE{
								$data[] = $gut;
							}
							
							
						}
						
						
						
					}
				}else{
					if($data_d[1] == 'gender' || $data_d[1] == 'age' || $data_d[1] == 'age_group'){
						
					}else{
						$data[] = $gut;
					}
				}
			}
		}
		

					foreach($data1 as $guts){
						$data_ds = explode('=',$guts);
						IF(ISSET($data_ds[1])){
							if($data_ds[1] == 'age_group' || $data_ds[1] == 'age'){
								
								if($age_kon == 0){
									$data[] = $guts;
								}
 							}else if($data_ds[1] == 'gender'){
								
								if($age_kon33 == 0){
									$data[] = $guts;
								}
 							}
						}
					}
			
	
		
 
		$text_w = '  ';
		$text_field = ' SELECT * FROM `TREE_PROFILING_RES_P22` WHERE `FIELD` NOT IN (';

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
		$ai = 0;
		foreach($data as $kkk){
			
			$data_d = explode('=',$kkk);

			IF(ISSET($data_d[1])){
				
					
				 
			
					if($curr_field == ''){
						$curr_field = $data_d[1];
						
						$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
						$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
						$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
						$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
						
					}else{
						
						if($curr_field == $data_d[1]){
							$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
							$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
							$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
							
						}else{
							$curr_field = $data_d[1];
							$ai++;
							
							$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
							$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
							$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
							$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
						}
						
					}
				
 			}
		}

 
		
		$array_datas2 = [];
		$ai = 0;
		$curr_field = '';
		foreach($data as $kkk2){
			
			$data_d = explode('=',$kkk2);
			
 
			
			IF(ISSET($data_d[1])){
			
				 
					if($curr_field == ''){
						$curr_field = $data_d[1];
						
						$array_datas2[$ai]['FIELD'] = $data_d[1];
						$array_datas2[$ai]['VALUE'][] = $data_d[0];
						$array_datas2[$ai]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
						
					}else{
						
						if($curr_field == $data_d[1]){
							
							$array_datas2[$ai]['VALUE'][] = $data_d[0];
							$array_datas2[$ai]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
							
						}else{
							$curr_field = $data_d[1];
							$ai++;
							
							$array_datas2[$ai]['FIELD'] = $data_d[1];
							$array_datas2[$ai]['VALUE'][] = $data_d[0];
							$array_datas2[$ai]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
						}
						
					}
					
					
 			}
		}
		
	
 
		$curr_field2 = '';
		
 		$text_w2 = '  ';
		$text_field2 = ' ';
		
		$array_datas21 = [];
		$ai2 = 0;
		foreach($data2 as $kkk2){
			
			$data_d2 = explode('=',$kkk2);
			
			
			IF(ISSET($data_d2[1])){
				
				 
			
					if($curr_field2 == ''){
						$curr_field2 = $data_d2[1];
						
						$array_datas21[$data_d2[2]]['FIELD'][] = $data_d2[1];
						$array_datas21[$data_d2[2]]['VALUE'][] = $data_d2[0];
						$array_datas21[$data_d2[2]]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
						$array_datas21[$data_d2[2]]['DEFAULT'][] = $data_d2[3];
						
					}else{
						
						if($curr_field2 == $data_d2[1]){
							$array_datas21[$data_d2[2]]['FIELD'][] = $data_d2[1];
							$array_datas21[$data_d2[2]]['VALUE'][] = $data_d2[0];
							$array_datas21[$data_d2[2]]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
							
						}else{
							$curr_field2 = $data_d2[1];
							$ai2++;
							
							$array_datas21[$data_d2[2]]['FIELD'][] = $data_d2[1];
							$array_datas21[$data_d2[2]]['VALUE'][] = $data_d2[0];
							$array_datas21[$data_d2[2]]['DEFAULT'][] = $data_d2[3];
							$array_datas21[$data_d2[2]]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
						}
						
					}
					
 				
				
			}
		}

		

 		$array_datas22 = [];
		$ai2 = 0;
		$curr_field21 = '';
		foreach($data2 as $kkk22){
			
			$data_d2 = explode('=',$kkk22);
			
			
			IF(ISSET($data_d2[1])){
			
				 
					
					if($curr_field21 == ''){
						$curr_field21 = $data_d2[1];
						
						$array_datas22[$ai2]['FIELD'] = $data_d2[1];
						$array_datas22[$ai2]['VALUE'][] = $data_d2[0];
						$array_datas22[$ai2]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
						
					}else{
						
						if($curr_field21 == $data_d2[1]){
							
							$array_datas22[$ai2]['VALUE'][] = $data_d2[0];
							$array_datas22[$ai2]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
							
						}else{
							$curr_field21 = $data_d2[1];
							$ai2++;
							
							$array_datas22[$ai2]['FIELD'] = $data_d2[1];
							$array_datas22[$ai2]['VALUE'][] = $data_d2[0];
							$array_datas22[$ai2]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
						}
						
					}
					
 				
			}
		}
		
 		 
		$array_all = [];
		
		 
		
		foreach($array_datas22 as $array_datas22h){
			$wq = 0;
			foreach($array_datas2 as $array_datas2h){
				$array_nnn = [];
				//print_r($array_datas2h);die;
				foreach($array_datas22h['VALUE'] as $rrr){
					
					foreach($array_datas2h['VALUE'] as $rrr2){
						
						$exp_1 = explode('_',$array_datas2h['FIELD']);
						$exp_2 = explode('_',$array_datas22h['FIELD']);
						
						if($exp_1[0] == 'merk'){
							
							$where1 = "".$array_datas2h['FIELD']." LIKE '%".$rrr2."%'";
							
						}ELSE{
							$where1 = "".$array_datas2h['FIELD']." = '".$rrr2."'";
						}
						
						if($exp_2[0] == 'merk'){
							
							$where2 = "".$array_datas22h['FIELD']." LIKE '%".$rrr."%'";
							
						}ELSE{
							$where2 = "".$array_datas22h['FIELD']." = '".$rrr."'";
						}
					
						$query = "
						SELECT CONCAT('".$array_datas22h['FIELD']."|',".$array_datas22h['FIELD'].") AS F1,".$array_datas22h['FIELD']." 
						AS `".$array_datas22h['FIELD']."|".$rrr2."`, SUM(toInt32(WEIGHT)) AS VIEWERS 
						FROM `URBAN_PROFILE_P22` 
						WHERE ".$where1."
						AND ".$where2."
						GROUP BY ".$array_datas2h['FIELD'].",".$array_datas22h['FIELD']."
						";

 						$list = $this->createprofileu_model->pivot_data($query); 

						IF(COUNT($list) > 0){
						if($list[0]['F1'] == ''){
							
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2]['F1'] = $array_datas2h['FIELD'].'|'.$rrr2;
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2][$array_datas22h['FIELD'].'|'.$rrr] = 0;
						
						}else{
						
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2]['F1'] = $array_datas2h['FIELD'].'|'.$rrr2;
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2][$list[0]['F1']] = $list[0]['VIEWERS'];
						
						}
						
						}
						
					}

				}
				
				
				
				foreach($array_nnn as $array_nnnf){
					
					$array_all[$wq][] = $array_nnnf;
					
				}
				
				$wq++;
			}
			
			
		}

		$array_final = [];
		foreach($array_all as $array_alls){
			
			foreach($array_alls as $array_alls2){
			
					$r = array_keys($array_alls2);
					$rt = 0;
					foreach($array_alls2 as $array_alls3){
						
						$array_final[$array_alls2['F1']][$r[$rt]] =  $array_alls3;
						
						$rt++;
					}
			} 
			
		}
		
 
			$raa = array_keys($array_final);

			$index =  array_keys($array_final[$raa[0]]);
			
 			
			$array_lp = [];
			$uja = 0;
			foreach($array_final as $array_finals){
				$uj =0;
				foreach($array_finals as $array_finals2){
					
					$array_lp[$uj][$uja] = $array_finals2;
					
					$uj++;
				}
			
			$uja++;
			}
			
 
			$label2 = []; 
			
			
			$arr_lbl = [];
			$arr_lbl_2 = [];
			$list_l = $this->createprofileu_model->pivot_data_label(); 
			foreach($list_l as $list_lss){
				
				$arr_lbl[$list_lss['FIELD'].'|'.$list_lss['VALUE']]['LABEL'] = $list_lss['LABEL'];

			}


			$html_btn = '<button class = "btn urate-outline-btn" onclick="getExport()">Export</button><br><br>';
			$html = '<div style="width: 100%;overflow-x:auto;">';
			$html .= '<table id="myTable" class="table table-striped table-bordered example urate-table" style="">
                                  <thead>
                                  <tr style=""> <th style="color: red; border: 1px solid black;">Profile</th>';
								  
								  foreach($raa as $raas){
									  
 									  $html .= ' <th style="color: red; border: 1px solid black;">'.$arr_lbl[$raas]['LABEL'].'</th>';
									  
								  }
								  
								  for($t=1;$t<count($index);$t++){
									  
									   $html .= '<tr>
												
												<td style="color: red;">'.$arr_lbl[$index[$t]]['LABEL'].'</td>';
												
 												 
												 for($tk=0;$tk<count($array_lp[0]);$tk++){
													 if(isset($array_lp[$t][$tk])){
														$html .='<td style="text-align:right">'.number_format($array_lp[$t][$tk],0,",",".").'</td> ';
													 }else{
														$html .='<td style="text-align:right">0</td> ';
													 }
													 
												 }

										 $html .='</tr>';
									  
								  }
								  
                                     
            $html .= '  </tr></thead></table>   </div>';
		
		
		
		
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('tabel' => $html));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
	public function export_table(){
		
 
		
		$data =  $this->Anti_si($this->input->post('tab_cnt'));
		
		$data = str_replace('<div style="width: 100%;overflow-x:auto;"><table id="myTable" class="table table-striped table-bordered example urate-table" style="">','',$data);
		$data = str_replace('<thead>                                  <tr style=""> <th style="color: red; border: 1px solid black;">','<th>',$data);
		$data = str_replace('<thead>','',$data);
		$data = str_replace('<tr style=""> <th>','',$data);
		$data = str_replace('<tr style=""> ','<th>',$data);
		$data = str_replace('<th style="color: red; border: 1px solid black;">','<th>',$data);
		$data = str_replace('</th><th>','|',$data);
		$data = str_replace('</th> <th>','|',$data);
		$data = str_replace('</td> </tr><tr>','<bl>',$data);
		$data = str_replace('<tr style=""><th>','',$data);
		$data = str_replace('<tr style=""><th>','',$data);
		$data = str_replace('<th>','',$data);
		$data = str_replace('</th><tr>','<bl>',$data);
		$data = str_replace('

<tr style=""> <th>','',$data);
		$data = str_replace('</td><td style="text-align:right">','|',$data);
		$data = str_replace('</th><tr>																								<td>','<bl>',$data);
		$data = str_replace('</th><tr>
												
												<td>','<bl>',$data);
		$data = str_replace('</td> <td style="text-align:right">','|',$data); 
		$data = str_replace('</td> </tr><tr>																								<td>','<bl>',$data);
		$data = str_replace('</td> </tr>  </tr></thead></table>','<bl>',$data);
		$data = str_replace('                                  <th>','',$data);
		$data = str_replace('<br>',' ',$data);
		$data = str_replace('<td>',' ',$data);
		$data = str_replace('  ','',$data);
		$data = str_replace('   ','',$data);
		$data = str_replace('	<td style="color: red;">','',$data);
		$data = str_replace(' </div','',$data);
		$data = str_replace('  ','',$data);
		$data = substr($data, 0, -1);
 		$data = explode('<bl>',$data);
		
		
		
		$this->load->library('excel');
	   
		$objPHPExcel = new PHPExcel();
	   
	   $array_cell = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	   
		$objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
									 
			$cell = 1;
			foreach($data as $datas){ 
				$datass = explode('|',trim($datas));
 				if(count($datass) > 0 ){
					$rw = 0;
					
					foreach($datass as $datasst){ 
 						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$rw].''.$cell, str_replace('.','',$datasst)); 
 						
						$rw++;
					 
					}
					$cell++;
				}
					
			}							 
			
			
			 
			
			
			$objPHPExcel->getActiveSheet()->setTitle('Table');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
		
		$objWriter->save('/var/www/html/tmp_doc/pivot_table_print.xls');
									 
									 
		 
	}
	
	public function create_pivot_bar(){
		
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		
		$data = $this->Anti_si($_POST['list']);
		$data2 = $this->Anti_si($_POST['list2']);
		$notab = $this->Anti_si($_POST['notab']);
		
 		
		$text_w = '  ';
		$text_field = ' SELECT * FROM `TREE_PROFILING_RES_P22` WHERE `FIELD` NOT IN (';

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
		$ai = 0;
		foreach($data as $kkk){
			
			$data_d = explode('=',$kkk);
			
			
			IF(ISSET($data_d[1])){
			
				if($curr_field == ''){
					$curr_field = $data_d[1];
					
					$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
					$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
					$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
					$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
					
				}else{
					
					if($curr_field == $data_d[1]){
						$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
						$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
						$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
						
					}else{
						$curr_field = $data_d[1];
						$ai++;
						
						$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
						$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
						$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
						$array_datas[$data_d[2]]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
					}
					
				}
				
				
			}
		}

 		
		
		$array_datas2 = [];
		$ai = 0;
		$curr_field = '';
		foreach($data as $kkk2){
			
			$data_d = explode('=',$kkk2);
			
			
			IF(ISSET($data_d[1])){
			
				if($curr_field == ''){
					$curr_field = $data_d[1];
					
					$array_datas2[$ai]['FIELD'] = $data_d[1];
					$array_datas2[$ai]['VALUE'][] = $data_d[0];
					$array_datas2[$ai]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
					
				}else{
					
					if($curr_field == $data_d[1]){
						
						$array_datas2[$ai]['VALUE'][] = $data_d[0];
						$array_datas2[$ai]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
						
					}else{
						$curr_field = $data_d[1];
						$ai++;
						
						$array_datas2[$ai]['FIELD'] = $data_d[1];
						$array_datas2[$ai]['VALUE'][] = $data_d[0];
						$array_datas2[$ai]['LABEL'][$data_d[0]] = $data_d[1].'<br>'.$data_d[4];
					}
					
				}
				
				
			}
		}
		
 		$curr_field2 = '';
		
 		$text_w2 = '  ';
		$text_field2 = ' ';
		
		$array_datas21 = [];
		$ai2 = 0;
		foreach($data2 as $kkk2){
			
			$data_d2 = explode('=',$kkk2);
			
			
			IF(ISSET($data_d2[1])){
			
				if($curr_field2 == ''){
					$curr_field2 = $data_d2[1];
					
					$array_datas21[$data_d2[2]]['FIELD'][] = $data_d2[1];
					$array_datas21[$data_d2[2]]['VALUE'][] = $data_d2[0];
					$array_datas21[$data_d2[2]]['DEFAULT'][] = $data_d2[3];
					$array_datas21[$data_d2[2]]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
					
				}else{
					
					if($curr_field2 == $data_d2[1]){
						$array_datas21[$data_d[2]]['FIELD'][] = $data_d2[1];
						$array_datas21[$data_d[2]]['VALUE'][] = $data_d2[0];
						$array_datas21[$data_d2[2]]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
						
					}else{
						$curr_field2 = $data_d2[1];
						$ai2++;
						
						$array_datas21[$data_d2[2]]['FIELD'][] = $data_d2[1];
						$array_datas21[$data_d2[2]]['VALUE'][] = $data_d2[0];
						$array_datas21[$data_d2[2]]['DEFAULT'][] = $data_d2[3];
						$array_datas21[$data_d2[2]]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
					}
					
				}
				
				
			}
		}

		
		$array_datas22 = [];
		$ai2 = 0;
		$curr_field21 = '';
		foreach($data2 as $kkk22){
			
			$data_d2 = explode('=',$kkk22);
			
			
			IF(ISSET($data_d2[1])){
			
				if($curr_field21 == ''){
					$curr_field21 = $data_d2[1];
					
					$array_datas22[$ai2]['FIELD'] = $data_d2[1];
					$array_datas22[$ai2]['VALUE'][] = $data_d2[0];
					$array_datas22[$ai2]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
					
				}else{
					
					if($curr_field21 == $data_d2[1]){
						
						$array_datas22[$ai2]['VALUE'][] = $data_d2[0];
						$array_datas22[$ai2]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
						
					}else{
						$curr_field21 = $data_d2[1];
						$ai2++;
						
						$array_datas22[$ai2]['FIELD'] = $data_d2[1];
						$array_datas22[$ai2]['VALUE'][] = $data_d2[0];
						$array_datas22[$ai2]['LABEL'][$data_d2[0]] = $data_d2[1].'<br>'.$data_d2[4];
					}
					
				}
				
				
			}
		}
		
 		$array_all = [];
		
		foreach($array_datas22 as $array_datas22h){
			$wq = 0;
			foreach($array_datas2 as $array_datas2h){
				$array_nnn = [];
				//print_r($array_datas2h);die;
				foreach($array_datas22h['VALUE'] as $rrr){
					
					foreach($array_datas2h['VALUE'] as $rrr2){
					
						$exp_1 = explode('_',$array_datas2h['FIELD']);
						$exp_2 = explode('_',$array_datas22h['FIELD']);
						
						if($exp_1[0] == 'merk'){
							
							$where1 = "".$array_datas2h['FIELD']." LIKE '%".$rrr2."%'";
							
						}ELSE{
							$where1 = "".$array_datas2h['FIELD']." = '".$rrr2."'";
						}
						
						if($exp_2[0] == 'merk'){
							
							$where2 = "".$array_datas22h['FIELD']." LIKE '%".$rrr."%'";
							
						}ELSE{
							$where2 = "".$array_datas22h['FIELD']." = '".$rrr."'";
						}
					
						$query = "
						SELECT CONCAT('".$array_datas22h['FIELD']."|',".$array_datas22h['FIELD'].") AS F1,".$array_datas22h['FIELD']." 
						AS `".$array_datas22h['FIELD']."|".$rrr2."`, SUM(toInt32(WEIGHT)) AS VIEWERS 
						FROM `URBAN_PROFILE_P22` 
						WHERE ".$where1."
						AND ".$where2."
						GROUP BY ".$array_datas2h['FIELD'].",".$array_datas22h['FIELD']."
						";

						$list = $this->createprofileu_model->pivot_data($query); 

						IF(COUNT($list) > 0){
						if($list[0]['F1'] == ''){
							
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2]['F1'] = $array_datas2h['FIELD'].'|'.$rrr2;
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2][$array_datas22h['FIELD'].'|'.$rrr] = 0;
						
						}else{
						
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2]['F1'] = $array_datas2h['FIELD'].'|'.$rrr2;
							$array_nnn[$array_datas2h['FIELD'].'|'.$rrr2][$list[0]['F1']] = $list[0]['VIEWERS'];
						
						}
						}
						
					}

				}
				
				
				
				foreach($array_nnn as $array_nnnf){
					
					$array_all[$wq][] = $array_nnnf;
					
				}
				
				$wq++;
			}
			
			
		}
		
		 
		$array_final = [];
		foreach($array_all as $array_alls){
			
			foreach($array_alls as $array_alls2){
			
					$r = array_keys($array_alls2);
					$rt = 0;
					foreach($array_alls2 as $array_alls3){
						
						$array_final[$array_alls2['F1']][$r[$rt]] =  $array_alls3;
						
						$rt++;
					}
			} 
			
		}
		
			$raa = array_keys($array_final);

			$index =  array_keys($array_final[$raa[0]]);
			
 			
			$array_lp = [];
			$uja = 0;
			foreach($array_final as $array_finals){
				$uj =0;
				foreach($array_finals as $array_finals2){
					
					$array_lp[$uj][$uja] = $array_finals2;
					
					$uj++;
				}
			
			$uja++;
			}
			
			$label2 = [];
			
		 
			
			$arr_lbl = [];
			$arr_lbl_2 = [];
			$list_l = $this->createprofileu_model->pivot_data_label(); 
			
 			
			foreach($list_l as $list_lss){
				
				$arr_lbl[$list_lss['FIELD'].'|'.$list_lss['VALUE']]['LABEL'] = $list_lss['LABEL'];
				
				// $arr_lbl[$list_lss['FIELD']]['FIELD'] = $list_lss['FIELD'];
				// $arr_lbl[$list_lss['FIELD']]['VALUE'] = $list_lss['VALUE'];
				// $arr_lbl[$list_lss['FIELD']]['LABEL'] = $list_lss['LABEL'];
				
			}
			
			
			
			$catr = array_keys($array_final);
			
			$categories = [];
			for($h=0;$h<count($catr);$h++){
				
				$categories[] = $arr_lbl[$catr[$h]]['LABEL']; 
				
			}
		 
			$arr_cat = [];
			$arr_cat_main = []; 
			foreach($array_final as $array_finalpp){
				
				$uo = 0;
				$tu = 0;
				
				$catr2 = array_keys($array_finalpp);
				
 				foreach($array_finalpp as $array_ff){
				
					if($uo>0){
						
						$arr_cat[$tu][] =  intval($array_ff);
						$arr_cat_main[$tu] =  $catr2[$tu+1];
						$tu++;
						
					}

					$uo++;
				}
				 
				
				
			}
			
 			$categories_val = [];
 			$h=0;
			for($t=1;$t<count($index);$t++){
				
 				$categories_val[$h]['name'] = $arr_lbl[$index[$t]]['LABEL'];
				$categories_val[$h]['data'] = $arr_cat[$h];
				$h++;
			}
			
			$html = '';
			
			for($t=1;$t<count($index);$t++){
				
				for($tk=0;$tk<count($array_lp[0]);$tk++){
					if(isset($array_lp[$t][$tk])){
						$html .='<td style="text-align:right">'.number_format($array_lp[$t][$tk],0,",",".").'</td> ';
					}else{
						$html .='<td style="text-align:right">0</td> ';
					}
				}
				
			}
			
		
 
		
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('categories' => $categories,'categories_val' => $categories_val));
			
 			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
	
	public function create_profiling(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		
		$data = $_POST['list'];
		
		
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
		$text_field = ' SELECT * FROM `TREE_PROFILING_RES` WHERE `FIELD` NOT IN (';
		
		$array_datas = [];
		$ai = 0;
		foreach($data as $kkk){
			
			$data_d = explode('=',$kkk);
			
			
			IF(ISSET($data_d[1])){
			
				if($curr_field == ''){
					$curr_field = $data_d[1];
					
					$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
					$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
					$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
					
				}else{
					
					if($curr_field == $data_d[1]){
						$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
						$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
						
					}else{
						$curr_field = $data_d[1];
						$ai++;
						
						$array_datas[$data_d[2]]['FIELD'][] = $data_d[1];
						$array_datas[$data_d[2]]['VALUE'][] = $data_d[0];
						$array_datas[$data_d[2]]['DEFAULT'][] = $data_d[3];
					}
					
				}
				
				
			}
		}
		

		
		$array_datas2 = [];
		$ai = 0;
		$curr_field = '';
		foreach($data as $kkk2){
			
			$data_d = explode('=',$kkk2);
			
			
			IF(ISSET($data_d[1])){
			
				if($curr_field == ''){
					$curr_field = $data_d[1];
					
					$array_datas2[$ai]['FIELD'] = $data_d[1];
					$array_datas2[$ai]['VALUE'][] = $data_d[0];
					
				}else{
					
					if($curr_field == $data_d[1]){
						
						$array_datas2[$ai]['VALUE'][] = $data_d[0];
						
					}else{
						$curr_field = $data_d[1];
						$ai++;
						
						$array_datas2[$ai]['FIELD'] = $data_d[1];
						$array_datas2[$ai]['VALUE'][] = $data_d[0];
					}
					
				}
				
				
			}
		}
		
		
 		
		$grouping = '['; 
		
		foreach($array_datas2 as $array_datass){
			
 			$grouping .= '{"Header":"'.$array_datass['FIELD'].'","Tag":"'.$array_datass['FIELD'].'","Data":[ ';

				$text_val = '';
				foreach($array_datass['VALUE'] as $val){
					
					$text_val .= '"'.$val.'",';
					
				}
				
				$SS = substr($text_val,0,-1);
				$grouping .= $SS.']},';

		}	
		$grouping = substr($grouping,0,-1);
		
		$grouping .= ']';
		
 		
		$sop = '';
		foreach($array_datas as $array_datass4){
			 
 
			
			$icont = count($array_datass4['FIELD']);
			
			$rr = ' AND ( ';
			
			for($iu=0;$iu<$icont;$iu++){
				
				if(isset($array_stag[$array_datass4['FIELD'][$iu]])){
					
					$ii = $array_stag[$array_datass4['FIELD'][$iu]][1];
					for($ii = 1;$ii <= $array_stag[$array_datass4['FIELD'][$iu]][1];$ii++){
						$rr .= ' '.$array_datass4['FIELD'][$iu].''.$array_stag[$array_datass4['FIELD'][$iu]][0].''.$ii.' = "'.$array_datass4['VALUE'][$iu].'" OR';
					}
					
					
				}else{
					$rr .= ' '.$array_datass4['FIELD'][$iu].' = "'.$array_datass4['VALUE'][$iu].'" OR';
				}

			}
			
			$rr = substr($rr,0,-2);
			 
			$text_w .= $rr.' ) ';
		}
		
		
 		
		$text_field = substr($text_field,0,-1);
		
 		$text_field .=  ' ) AND STATUS_TREE = 1 AND `VALUE` = 1 AND IS_CHILD = 1 ';
		
	 
		
		$list = $this->createprofileu_model->create($_POST,$text_w,$grouping);
		 
		
		if ( $list !== false ) {

		 
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function create_pav(){
		$_POST = json_decode(file_get_contents("php://input"), true);
 		$list = $this->createprofileu_model->create_pav($_POST);
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => true, 'message' => 'data null', 'data' => array('hasil' => array()) );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	} 
	public function searchopvalold(){
		$_POST = json_decode(file_get_contents("php://input"), true);
 		$list = $this->createprofileu_model->searchopval($_POST['name'], $this->Anti_si($_POST['user_id']));
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => $list );
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error load data' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function searchopval(){
		$_POST = json_decode(file_get_contents("php://input"), true);
 		$list = $this->createprofileu_model->searchopval($this->Anti_si($_POST['name']));
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => $list );
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error load data' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function ceksearchfav(){
		$_POST = json_decode(file_get_contents("php://input"), true);
 		$list = $this->createprofileu_model->ceksearchfav($_POST);
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => $list );
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error load data' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function redirect_halaman()
	{
		$this->load->helper('url');
        redirect(base_url('createprofile'));
	}

	 public function data_people() 
	 {
		$json = file_get_contents('php://input');
		$params = json_decode($json, TRUE);
		$ss = array();
		$profile = array();
		$push_count = array();
		$ssaa = array();
		$textja =array();
		$kota ='';
		$helix= '';
		$addgroup = '';
		$digitalsegment ='';
		$demgender ='';
		$katarpu ='';
		$householdprofile='';
		$sessegment = '';
		$myquery = '';

		foreach($params['andor'] as $new){
			array_push($ss, explode("_",$new));
		}
		
		$query = '';
		$no = 0;
		foreach($params['profile'] as $new1){
			$var = explode("_",$new1);
			$id_profile = $var[1];
			
			
			    $grouping_json = $this->createprofileu_model->content_grouping($id_profile);
				$res = json_decode($grouping_json['grouping']);
 				$values = [];
				$values1 = '';

				$strsql='';
				$strsql2='';
				$sa='';
				
				
				foreach($res as $mydata)
				{
					if ($mydata->Header=='KOTA') {
						$col = 'KOTA';	
					}
					else{
						$col = 'PERSONAS_TRIM';
					}
 					foreach ($mydata->Data as $k1 => $v1) {
						if ($mydata->Header=='KOTA') {
							$kota .= '"'.$v1.'",';	
						}
						elseif ($mydata->Header=='HELIX_COMM') {
							$helix .= '"'.$v1.'",';
						}
						elseif ($mydata->Header=='DEMOGRAFI') {
							if ($mydata->Tag=='AGE_GROUP') {
								$addgroup .= '"'.$v1.'",'; 
							}
							elseif ($mydata->Tag=='DIGITAL_SEGMENT') {
								$digitalsegment .= '"'.$v1.'",';
							}
							elseif ($mydata->Tag=='DEM_GENDER_PRED') {
								$demgender .= '"'.$v1.'",';
							}							
							elseif ($mydata->Tag=='KAT_ARPU') {
								$katarpu .= '"'.$v1.'",';
							}
							elseif ($mydata->Tag=='HOUSEHOLD_PROFILE') {
								$householdprofile .= '"'.$v1.'",';
							}
							elseif ($mydata->Tag=='SES_SEGMENT') {
								$sessegment .= '"'.$v1.'",';
							}
						}
						
					}

 
                 	
				}
				
				$kota = substr($kota, 0, -1);
				$helix = substr($helix, 0, -1);
				$addgroup = substr($addgroup, 0, -1);
				$digitalsegment = substr($digitalsegment, 0, -1);
				$demgender = substr($demgender, 0, -1);
				$katarpu = substr($katarpu, 0, -1);
				$householdprofile = substr($householdprofile, 0, -1);
				$sessegment = substr($sessegment, 0, -1);

				if ($helix) {
					$myquery = $myquery . 'PERSONAS_TRIM IN('.$helix.') AND ';
				}
				if ($addgroup) {
					$myquery = $myquery . 'AGE_GROUP IN('.$addgroup.') AND ';
				}
				if ($demgender) {
					$myquery = $myquery . 'DEM_GENDER_PRED IN('.$demgender.') AND ';
				}				
				if ($digitalsegment) {
					$myquery = $myquery . 'DIGITAL_SEGMENT IN('.$digitalsegment.') AND ';
				}				
				if ($sessegment) {
					$myquery = $myquery . 'SES_SEGMENT IN('.$sessegment.') AND ';
				}				
				if ($householdprofile) {
					$myquery = $myquery . 'HOUSEHOLD_PROFILE IN('.$householdprofile.') AND ';
				}				
				if ($katarpu) {
					$myquery = $myquery . 'KAT_ARPU IN('.$katarpu.') AND ';
				}
				if ($kota) {					
					$myquery = $myquery . 'KOTA_CLEAN IN('.$kota.') AND ';
				}

				
				$myquery .= '.';
				$myquery = str_replace('AND .', '', $myquery);
 				$textja[$no] = $myquery;
				$kota ='';
				$helix ='';
				$addgroup ='';
				$digitalsegment ='';
				$demgender = '';
				$sessegment= '';
				$householdprofile = '';
				$katarpu = '';
				$myquery = '';

				$no++;
		}
 
		$onlyconsonants = "WHERE (".$textja[0].") ".$ss[0][1]." (".$textja[1].")";

 
		$get_userid = $this->createprofileu_model->get_userid3($onlyconsonants);
		
		
		$totalnya  = 0;
		foreach($get_userid as $ab){
				
			$totalnya  =$ab['people'];
	
		}
		
			// die;
			
		if ( $get_userid ) {
			$result = array(
				'success' => true,
				'data' => $totalnya,
				'message' => 'Success retrieving'
			);
		} else {
			$result = array(
				'success' => false,
				'message' => 'Error retrieving'
			);
		} 
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
				
    }

    public function create_statistic(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$json = file_get_contents('php://input');
		$params = json_decode($json, TRUE);
		
 		
		$profile_cnt = count($params['list']);
		
		$new_grp = "[";
		
		for($o = 0; $o < $profile_cnt; $o++ ){
			
			$id_profile = explode("_",$params['list'][$o]);
			
			
			$grouping_json = $this->createprofileu_model->content_grouping($id_profile[1]);
			$statusgrpup = $grouping_json['status'];
			$res = json_decode($grouping_json['grouping']);
 			
			$new_grp = $new_grp."".$grouping_json['grouping'];
			
			if($o <  $profile_cnt -1){
				
				$andor = explode("_",$params['isi'][$o]);
				$new_grp = $new_grp.',[{"ANDOR":"'.$andor[1].'"}],';
				
			}
			
		}
		
		$new_grp = $new_grp."]";
		
		$ress = json_decode($new_grp);
 
		
		$i = 0;
		$myquery = '';
		$textja =array();	
		foreach($ress as $new1){
			
			if ($i % 2 == 0) {
			 
			 
				$ss = array();
				$profile = array();
				$push_count = array();
				$grouping = array();
				$grouping2 = array();
		
				$kota = '';
				$helixv ='';
 				$helix ='';
						$addgroup = '';
				$digitalsegment ='';
				$demgender ='';
				$katarpu ='';
				$householdprofile='';
				$sessegment = '';
				$web_interest = '';
				$myquery .= '(';
			 
				foreach($new1 as $mydata)
					{
						if ($mydata->Header=='KOTA') {
							$col = 'KOTA';	
						}
						else{
							$col = 'PERSONAS';
						}
						foreach ($mydata->Data as $k1 => $v1) {
							if ($mydata->Header=='KOTA') {
								$kota .= '"'.$v1.'",';	
							}
							elseif ($mydata->Header=='HELIX_COMM') {
								$helix .= '"'.$v1.'",';
							}
							elseif ($mydata->Header=='DEMOGRAFI') {
								if ($mydata->Tag=='AGE_GROUP') {
									$addgroup .= '"'.$v1.'",'; 
								}
								elseif ($mydata->Tag=='DIGITAL_SEGMENT') {
									$digitalsegment .= '"'.$v1.'",';
								}
								elseif ($mydata->Tag=='DEM_GENDER_PRED') {
									$demgender .= '"'.$v1.'",';
								}							
								elseif ($mydata->Tag=='KAT_ARPU') {
									$katarpu .= '"'.$v1.'",';
								}
								elseif ($mydata->Tag=='HOUSEHOLD_PROFILE') {
									$householdprofile .= '"'.$v1.'",';
								}
								elseif ($mydata->Tag=='SES_SEGMENT') {
									$sessegment .= '"'.$v1.'",';
								}
								elseif ($mydata->Tag=='WEB_INTEREST') {
									$web_interest .= '"'.$v1.'",';
								}
							}
							
						}

 
						
						
					}	
					
					
				$ss = array();
				$profile = array();
				$push_count = array();
				$grouping = array();
				$grouping2 = array();
				
				$kota = substr($kota, 0, -1);
				$helix = substr($helix, 0, -1);
				$addgroup = substr($addgroup, 0, -1);
				$digitalsegment = substr($digitalsegment, 0, -1);
				$demgender = substr($demgender, 0, -1);
				$katarpu = substr($katarpu, 0, -1);
				$householdprofile = substr($householdprofile, 0, -1);
				$sessegment = substr($sessegment, 0, -1);
				$web_interest = substr($web_interest, 0, -1);
 				if ($helix) {
					$myquery = $myquery . 'PERSONAS IN('.$helix.') AND ';
				}
				if ($addgroup) {
					$myquery = $myquery . 'AGE_GROUP IN('.$addgroup.') AND ';
				}
				if ($demgender) {
					$myquery = $myquery . 'DEM_GENDER_PRED IN('.$demgender.') AND ';
				}				
				if ($digitalsegment) {
					$myquery = $myquery . 'DIGITAL_SEGMENT IN('.$digitalsegment.') AND ';
				}				
				if ($sessegment) {
					$myquery = $myquery . 'SES_SEGMENT IN('.$sessegment.') AND ';
				}				
				if ($householdprofile) {
					$myquery = $myquery . 'HOUSEHOLD_PROFILE IN('.$householdprofile.') AND ';
				}				
				if ($katarpu) {
					$myquery = $myquery . 'KAT_ARPU IN('.$katarpu.') AND ';
				}
				if ($kota) {					
					$myquery = $myquery . 'KOTA IN('.$kota.') AND ';
				}
				if ($web_interest) {					
					$myquery = $myquery . 'WEB_INTEREST IN('.$web_interest.') AND ';
				}
				
				$myquery .= '.';
				$myquery = str_replace('AND .', '', $myquery);
				
				$myquery .= ')';
				
 				
				
				$textja[$i] = $myquery;
				$kota ='';
				$helix ='';
				$addgroup ='';
				$digitalsegment ='';
				$demgender = '';
				$sessegment= '';
				$householdprofile = '';
				$katarpu = '';
				$myquery = '';
				$web_interest = '';
				
			 
			}else{
				
				$textja[$i] = " ".$new1[0]->ANDOR." ";
 
				
			}

			$i++;
		}
		
 
       
		$onlyconsonants = "WHERE ";
		foreach($textja as $qry){
			
			$onlyconsonants .= $qry;
			
		} 
		
 
          $data = json_encode($textja);
    	
 		$get_userid = $this->createprofileu_model->get_userid3($onlyconsonants);
 		$list = $this->createprofileu_model->create_statistic($params['name'],$new_grp, $get_userid[0]['people'], $get_userid[0]['USER_ID'],$onlyconsonants);
        
 		
		if ( $list ) {		

 
		
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}     
  
  public function chkname(){
     $iduser = $this->session->userdata('user_id');
		$count_name = $this->createprofileu_model->checkname($iduser,$this->Anti_si($_GET['q']));
    
		if ( $count_name != "1" ) {
      $result = array( 'success' => true, 'message' => 'Vacant', 'data' => array('hasil' => $count_name));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Exist', 'data' => array('hasil' => $count_name));
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}	
	}
  
  public function listnotyet(){
      $list = $this->createprofileu_model->listnotyet($this->Anti_si($_GET['profid']));
      
      if ( $list ) {			
          $result = array( 'success' => true, 'message' => 'Exist', 'data' => $list);
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }

}
