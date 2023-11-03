<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cprp22 extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('createprofileu_model');
	}
	
	public function index()
	{
		
		//echo "asasasa";die;
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		//echo $idrole;die; 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		//cek session login
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		$data['listprofile'] = $this->createprofileu_model->listprofile($iduser,$idrole);
		
		//print_r($data['listprofile']);die;
		
		$typerole = $this->session->userdata('type_role');
		//$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		
		
		
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
			//echo 'menu: ';		var_dump($menu);
            
            $result["data"] = $menu;
    
			$data['tree_s'] = $this->_build_menu(0, $result["data"]);
		//print_r($data['tree_s']);die; 
	
		//$data['notyet'] = $this->createprofileu_model->listnotyet($iduser,$idrole);
	
		// print_r($data['listparent']); die; 
		$this->template->load('maintemplate_urban', 'cprp22/views/listu_view', $data);
	}
	
	function generate_html() {
		return $this->_build_menu(0, $this->menu_data['data']);
	}
	
	function _build_menu($parent, $menu)
	{
	   $html = '';
	   //htmls = '';
	   if (isset($menu['parents'][$parent]))
	   {
		  //$html .= '<li class="treeview">';
      $packageSeq = 0;
		   foreach ($menu['parents'][$parent] as $itemId)
		   {                 
			  if( ! isset($menu['parents'][$itemId]))
			  {
				  
				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","id" : "'.$menu['items'][$itemId]['VALUE'].'='.$menu['items'][$itemId]['FIELD'].'='.$menu['items'][$itemId]['PARENTFIELD'].'='.$menu['items'][$itemId]['PARENTDEFAULT'].'='.$menu['items'][$itemId]['LABEL'].'", "state" : { "opened" : false } }';
				
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {                        
//				$menu['items'][$itemId]['icon']  

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
		
		//var_dump($data['listparent']);die; 
		$this->template->load('maintemplate_res2', 'cprp22/views/createprofileu_view', $data);
		
	}
	
	public function detail($id){
		$data['detail'] = $this->createprofileu_model->detailnew($id);
		$this->template->load('maintemplate', 'cprp22/views/detailprofileu_view', $data);
		
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
		
		// Build params for calling model 
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
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		
		$data = array();			
		$tr = 0;
		foreach ( $list['data'] as $k => $v ) {
			if($v['flag'] == 1){
					$strik = '*';
				}else{
					$strik = '';
				}
			
				$ss = '';
			if($v['status'] == 2){
				$ss = $v['name'].$strik;
			}else{
					$ss = "<a style='color:red'  href='".base_url()."cprp22/detail/".$v['idprofile']."' >".$v['name']."".$strik."</a>";
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
					$sss = "<span style='text-align:center;vertical-align:middle'><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$v['idprofile']."' onclick='prerun(".$v['idprofile'].")' >Process</button></span>"; // onclick='run(".$v['idprofile'].")' // data-toggle='modal' data-target='#modalProcessJob'
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
				$done_ph = "<select class='form-control'><option>Month&nbsp;&nbsp;&nbsp;&nbsp;</option>".$opt."</select>";
			}else{
				
				$done_ph = "<select class='form-control'><option>Month</option>".$opt."</select>";
			}
			
			
			
			$done_p1 = $this->createprofileu_model->done_p1($v['id']);
			
			$opt1 = "";
			foreach($done_p1 as $kkkk1){
				$opt1 = $opt1."<option>".$kkkk1['PERIODE']."</option>";
			}
			
			if($opt1 == ""){
				$done_ph1 = "<select class='form-control' id='done_".$tr."' name='done_".$tr."'><option>Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>".$opt1."</select>";
				$excel_button = "<span style='text-align:center;vertical-align:middle'><p>Not Yet Process</p></span>";
			}else{
				
				$done_ph1 = "<select class='form-control' id='done_".$tr."' name='done_".$tr."'><option>Month</option>".$opt1."</select>";
				$excel_button = "<span style='text-align:center;vertical-align:middle'><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$v['idprofile']."' onclick='exports(".$v['idprofile'].")' >Export</button></span>";
			}
			
			// $done_ph1 = "<div class='urate-select-dropdown default' >
				// <input type='text' class='hidden-element-for-dropdown' id='done' name='done' style='display: none;' >
				// <button class='urate-custom-button' id='custom_done' style='background-image: url('assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png');' >Done</button>
				// <ul class='urate-custom-menu'>
					// <li data-for='done' ><a href='javascript:;' data-real='high_tvr' data-real='high_tvr'> saaa </a></li>
				// </ul>
			// </div>";
			
			if($v['user_id_profil'] <> 0){
				
				array_push($data, 
				array(
					"<p style='text-align:left;vertical-align:middle'>".$ss."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$v['date_create']."</p>",
					"<p style='text-align:right;vertical-align:middle'>".number_format($v['people'], 0, ',', '.')."<p>",
					"<p style='text-align:right;vertical-align:middle'>".number_format($v['respondents'], 0, ',', '.')."<p>",
					"<p style='text-align:center;vertical-align:middle'>".$done_ph1."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$nnn."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$sss."</p>",
					"<span style='text-align:center;vertical-align:middle'><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$v['idprofile']."' onclick='predelete(".$v['idprofile'].")' >Delete</button></span>",
					$excel_button
				)
			);
				
			}else{
				
				array_push($data, 
					array(
						"<p style='text-align:left;vertical-align:middle'>".$ss."</p>",
						"<p style='text-align:center;vertical-align:middle'>".$v['date_create']."</p>",
						"<p style='text-align:right'>".number_format($v['people'], 0, ',', '.')."<p>",
						"<p style='text-align:right'>".number_format($v['respondents'], 0, ',', '.')."<p>",
						"<p style='text-align:center;vertical-align:middle'>".$done_ph1."</p>",
						"<p style='text-align:center;vertical-align:middle'>".$nnn."</p>",
						"<p style='text-align:center;vertical-align:middle'>Default</p>", 
						"<p style='text-align:center;vertical-align:middle'>Profile</p>",
						$excel_button
					)
				);
				
			}
			
			$tr++;
		}
		
		//print_r($data);die;
		
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
		$list = $this->Anti_si($_POST['pid']);
		$periode_list = $this->Anti_si($_POST['val_periode_list']);                

		 
		if ( $list !== false ) {

			$curr = $this->createprofileu_model->check_job_user();
			
			if($curr[0]['RUNNING_JOB'] < 1 ){
				
				$this->createprofileu_model->insert_pid_partial($list,$periode_list); 
                      
			
				$command = 'php /var/www/jobs/profiling/ultimate/profile_jobs_res_p22_temp.php '.$list.' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$list.'res_p22.log 2>&1 & ';  

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
	  
		$list = $this->Anti_si($_POST['pid']);
	  
		$command = 'php /var/www/jobs/profiling/ultimate/delete_profile_res.php '.$list.' > /var/www/jobs/profiling/ultimate/delete_log_profile_res_'.$list.'.log 2>&1 & ';  
			
		$pid = shell_exec($command); 
	  
	  
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
  }
	
	public function create_profiling(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		
		$data = $_POST['list'];
		
		$array_stag = [];
		
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

				$command = 'php /var/www/jobs/profiling/ultimate/profile_jobs_res_p22_temp.php '.$list.' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$list.'res_2022.log 2>&1 & ';  
			
				$pid = shell_exec($command);

		
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
//		 print_r($_POST); die;
		$list = $this->createprofileu_model->searchopval($this->Anti_si($_POST['name']), $this->Anti_si($_POST['user_id']));
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
//		 print_r($_POST); die;
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
//		 print_r($_POST); die;
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
				//print_r($res);
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
					//$query .= ''.$col.' IN (';
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


	public function combine_profile(){
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$json = file_get_contents('php://input');
		$params = json_decode($json, TRUE);
		
		
		$iduser = $this->session->userdata('user_id');
		$count_name = $this->createprofileu_model->checkname($iduser,$params['name']);
		
		if ( $count_name == "1" ) {
			
			$result = array( 'error' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
			
		} else {
			
			$iduser = $this->session->userdata('user_id');
			$id_prof = explode('|',$params['list_combine']);
			$id_cond = explode('|',$params['cond_val']);
			
			
		$tpe_profile = substr($id_prof[0], -1);	
		
		$array_cond = ['AND','OR'];
		$str_group = '';
		
		$profile_cnt = count($id_prof);
		
		$txt_ngrp = array();
		$intr = 0;
		
		$new_grp = "[";
		
		$qr1 = '';
		
		for($o = 0; $o < $profile_cnt; $o++ ){
			$id_profile = $id_prof[$o];
			
			$grouping_json = $this->createprofileu_model->content_grouping($id_profile);
			
			$statusgrpup = $grouping_json['status'];
			$res = json_decode($grouping_json['grouping']);
			
			$new_grp = $new_grp."".$grouping_json['grouping'];
			
			if($o <  $profile_cnt -1){

				$new_grp = $new_grp.',[{"ANDOR":"'.$array_cond[$id_cond[$o]].'"}],';
				
			}
			
				if($qr1 == ''){
					$qr1 = "SELECT * FROM `PROFILE_CARDNO_RES` WHERE `ID_PROFILE` = '".$id_profile."'";
				}else{
					$qr2 = "SELECT * FROM `PROFILE_CARDNO_RES` WHERE `ID_PROFILE` = '".$id_profile."'";
						if($array_cond[$id_cond[$o-1]] == 'AND'){
							
								$query = 
								"
								SELECT A.* FROM (
									".$qr1."
								) A JOIN (
									".$qr2."
								) B ON A.CARDNO = B.CARDNO
								";
								
								$qr1 = $query;
							
						}else{
								$query = 
								"
								SELECT * FROM (
								".$qr1."
								UNION ALL 
								".$qr2."
								) AS D GROUP BY CARDNO
								";
								
								$qr1 = $query;
						}
						
				}
			
			
		}
		
		
		$new_grp = $new_grp."]";
		
		
		$params['ress'] = json_decode($new_grp);
			
			
			
			$create_combine = $this->createprofileu_model->create_combine($params,$iduser,$query,$tpe_profile);
			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $create_combine));
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
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
  
  	public function Anti_sql_injection($string) {
		$string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
		return $string;
	}
  
function returnBetweenDates( $startDate, $endDate ){
    $startStamp = strtotime(  $startDate );
    $endStamp   = strtotime(  $endDate );

    if( $endStamp >= $startStamp ){
        while( $endStamp >= $startStamp ){

            $dateArr[] = date( 'Y-m-d', $startStamp );

            $startStamp = strtotime( ' +1 day ', $startStamp );

        }
        return $dateArr;    
    }else{
        return $startDate;
    }

}
  
  public function exportss(){ 
	   
    $id_prof = $this->Anti_sql_injection($this->input->post('id', TRUE));
    $start_date = $this->Anti_sql_injection($this->input->post('start_date', TRUE));
    $end_date = $this->Anti_sql_injection($this->input->post('end_date', TRUE));
	
	$date_start = explode('/',$start_date);
	$date_end = explode('/',$end_date);
	
	$arr_date = $this->returnBetweenDates("".$date_start[2]."-".$date_start[1]."-".$date_start[0]."","".$date_end[2]."-".$date_end[1]."-".$date_end[0]."");
	
	//print_r($arr_date);die;
	//echo  $start_date;die;
	$this->load->library('excel');
	   
	$objPHPExcel = new PHPExcel();
	$arr_alf = ["C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ","BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ","CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ"];
	
	$page_periode = 0;
	foreach($arr_date as $arr_dates){
	
	
			if($page_periode == 0){
				
			}else{
				$objPHPExcel->createSheet($page_periode);
			}
		
		$list = $this->createprofileu_model->get_mbm($id_prof,$arr_dates,$arr_dates);
	

	   
		$objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");

		$objPHPExcel->setActiveSheetIndex($page_periode)
					->setCellValue('A1', 'Date')
					->setCellValue('B1', 'Channel')
					->setCellValue('C1', 'Time')
					->setCellValue('D1', 'TVR')
					->setCellValue('E1', 'IH 000s')
					->setCellValue('F1', 'ALL 000s');
	   
	   $it1 = 2;
		 foreach($list as $frt){
			
			 $objPHPExcel->setActiveSheetIndex($page_periode)
					->setCellValue('A'.$it1, $frt['tgl'])
					->setCellValue('B'.$it1, $frt['CHANNEL'])
					->setCellValue('C'.$it1, $frt['dd1'].' - '.$frt['dd2'])
					->setCellValue('D'.$it1, number_format($frt['TVR']*100,2,'.',',') )
					->setCellValue('E'.$it1, $frt['VIEWERS'])
					->setCellValue('F'.$it1, $frt['VIEWERS_A']);

			$it1++;
		}
		
		//$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
		
		$objPHPExcel->getActiveSheet()->setTitle($arr_dates);
			
		$page_periode++;
	}
			
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		
		// Redirect output to a client’s web browser (Excel2007)
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		// header('Cache-Control: max-age=0');
		// // If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');

		// // If you're serving to IE over SSL, then the following may be needed
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		//$objWriter->save('php://output');
		
		 //ob_end_clean();
		
		$objWriter->save('/var/www/html/urbanrate/tmp_doc/aaaa.xls');	

  }

}
