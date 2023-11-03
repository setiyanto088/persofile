<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs_man extends JA_Controller {
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
		$data['token'] = $this->session->userdata('token');
		
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		if(!$this->session->userdata('user_id') || $this->session->userdata('role_id') <> 41) {
			redirect ('/login');
		}
		$data['listprofile'] = $this->createprofileu_model->listprofile($iduser,$idrole);
		
		
		$typerole = $this->session->userdata('type_role');
		$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		$data['listperiode'] = $this->createprofileu_model->listperiode();
		$data['min_row'] = $this->createprofileu_model->min_row($typerole);
    
		$data['arr_hours'] = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];
		
		$data['arr_min'] = ['00','05','10','15','20','25','30','35','40','45','50','55'];
		$data['notyet'] = $this->createprofileu_model->listnotyet($iduser,$idrole);
	
		$this->template->load('maintemplate', 'jobs_man/views/listu_view', $data);
	}
	
	public function create(){
		
		
        $typerole = $this->session->userdata('type_role');
		$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		
		$this->template->load('maintemplate', 'jobs_man/views/createprofileu_view', $data);
		
	}
	
	public function detail($id){
		$data['detail'] = $this->createprofileu_model->detailnew($id);
		$this->template->load('maintemplate', 'jobs_man/views/detailprofileu_view', $data);
		
	}
	
	
		
	public function list_job_set() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('a.id', 'name', 'people');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		$arr_hours = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];
		
		$arr_min = ['00','15','30','45'];
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		$params['iduser'] 		= $iduser;
		$params['idrole'] 		= $idrole;
		$list = $this->createprofileu_model->list_jobs_set($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		
		$data = array();			
		$array_jobs_name = array('MANUAL RUN','AUTO RUN');
		foreach ( $list['data'] as $k => $v ) {
				$ss = '';
				
				if($v['JOBS_STATUS'] == "0"){
					$done_ph = "<select class='sel_set form-control urate-form-input' onchange='getval(this);' name = 'sel_run_".$v['JOBS_ID']."' id = 'sel_run_".$v['JOBS_ID']."'><option value = '0-".$v['JOBS_ID']."' SELECTED = 'SELECTED'>MANUAL RUN</option><option value = '1-".$v['JOBS_ID']."'>AUTO RUN</option></select>";
					
					$hl = '<button id="time_'.$v['JOBS_ID'].'" type="button" onClick="change_time('.$v['JOBS_ID'].',&apos;'.substr($v['TIME_S'],0,-3).'&apos;)" class="button_black" disabled="disabled" style="background-color:#E5E5E5" >'.substr($v['TIME_S'],0,-3).'</button>';
				}else{
					
					$done_ph = "<select class='sel_set form-control urate-form-input' onchange='getval(this);' name = 'sel_run_".$v['JOBS_ID']."' id = 'sel_run_".$v['JOBS_ID']."'><option value = '0-".$v['JOBS_ID']."' >MANUAL RUN</option><option value = '1-".$v['JOBS_ID']."' SELECTED = 'SELECTED'>AUTO RUN </options></select>";
					
					$hl = '<button id="time_'.$v['JOBS_ID'].'" type="button" onClick="change_time('.$v['JOBS_ID'].',&apos;'.substr($v['TIME_S'],0,-3).'&apos;)" class="button_black" >'.substr($v['TIME_S'],0,-3).'</button>';
				}
				
				
				
				
				$html_sel = 
				array_push($data, 
					array(
						"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_NAME']."</p>",
						"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_LOC']."</p>",
						"<p style='text-align:center'>".$done_ph."<p>",
						"<p style='text-align:center'>".$hl."<p>"
					)
				);
				

			

		}
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function list_periode(){
		
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('id', 'name');
		
		$search = $this->input->get_post('search');
		
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
		$list = $this->createprofileu_model->list_periode($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		
		$data = array();		
		foreach ( $list['data'] as $k => $v ) {
			
			$periode = explode('_',$v['name']);
			$dates=date_create($periode[2]);
			$date_name = date_format($dates,"F Y");
			
			array_push($data, 
					array(
						'<p style="text-align:left;vertical-align:middle">'.$date_name.'</p>',
						'<button id="time_'.$v['id'].'" type="button" onClick="change_univ('.$v['id'].',&apos;'.$v['val_int'].'&apos;,&apos;'.$v['name'].'&apos;)" class="button_black" >'.$v['val_int'].'</button>'
					)
				);
			
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
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
		
		$search = $this->input->get_post('search');
		
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
		$array_jobs_st = array('DONE','ON PROGRESS','ON QUEQUE');
		$array_jobs_name = array('DAILY JOBS EPG','DAILY JOBS CDR','LOGPROOF USEETV JOBS','LOGPROOF MEDIAHUB JOBS','POSTBUY JOBS','MEDIAPLAN JOBS','CHECKING DATA DAILY','CHECKING DATA LOGPROOF','CHECKING DATA LOGPROOF MEDIAHUB','CHECKING DATA MEDIAPLAN','CHECKING POSTBUY','PROCESS LOGPROOF USEETV MONTHLY','PROCESS LOGPROOF MEDIAHUB MONTHLY','DAILY PROFILING FTA','DAILY PROFILING PTV','PROFILING FTA','PROFILING PTV','ANALYZE TABLE','EXTERNAL SCRIPT' );
		foreach ( $list['data'] as $k => $v ) {
				$ss = '';
				
				if($v['STATUS_JOBS'] == 1){
					
					$dad = "<p style='text-align:left;vertical-align:middle;color:green'>".$array_jobs_st[$v['STATUS_JOBS']]."</p>";
					
				}else{
					$dad = "<p style='text-align:left;vertical-align:middle;color:red'>".$array_jobs_st[$v['STATUS_JOBS']]."</p>";
				}
				
				if($v['QUEUE'] == 66 || $v['QUEUE'] == 61){
					array_push($data, 
					array(
						$dad,
						"<p style='text-align:left;vertical-align:middle'>Treg Jobs</p>",
						"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_DATE']."</p>",
						"<p style='text-align:left'>".$v['JOBS_DESC']."<p>"
					)
				);
				}else{
					array_push($data, 
					array(
						$dad,
						"<p style='text-align:left;vertical-align:middle'>".$array_jobs_name[$v['QUEUE']]."</p>",
						"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_DATE']."</p>",
						"<p style='text-align:left'>".$v['JOBS_DESC']."<p>"
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
		$list = $this->createprofileu_model->listsearch($_GET['q'], $typerole);
        if ( $list ) {			
			
			$this->output->set_content_type('application/json')->set_output(json_encode($list));
		} else {
			$result = array( 'Value not found!' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	public function searchfav(){
		$list = $this->createprofileu_model->searchfav($_POST);
        if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => true, 'message' => 'data null', 'data' => array('hasil' => array())  );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	
	public function change_min_row(){
		

		$set_min = $_POST['set_min'];
		$token = $_POST['tokens'];
		
		$params['token']= $token;
		$params['uid']= $this->session->userdata('user_id');
		
		$validate = $this->tvprogramun_model->validate_password($params);
		
		if($validate['status'] == 0){
			
			$result = array(
				'success' => true,
				'status' => 'error',
				'message' => $validate['message'],
				'data' => array('hasil' => 'aaaa')
			);
		}else{
			$curr = $this->createprofileu_model->change_min_row($set_min);
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}		
	
	public function change_npr(){
		

		$str = $_POST['str'];
		$token = $_POST['tokens'];
		
		$dates=date_create($str);
		$date_name = date_format($dates,"Ym");
		
		$params['token']= $token;
		$params['uid']= $this->session->userdata('user_id');
		
		$validate = $this->tvprogramun_model->validate_password($params);
		
		if($validate['status'] == 0){
			$result = array(
					 'success' => true,
					'status' => 'error',
					'message' => $validate['message'],
					'data' => array('hasil' => 'aaaa')
				);
		
		}else{
			$command = 'php /var/www/jobs/steve/JOBS/testing/zte/nper_jobs.php '.$date_name;
			$pid = shell_exec($command);
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}	
	
	
	
	public function change_time_jobs(){
		
		$str = $_POST['id'];
		$set_hours = $_POST['set_hours'];
		$set_min = $_POST['set_min'];
		
		$token = $_POST['tokens'];
		
		$params['token']= $token;
		$params['uid']= $this->session->userdata('user_id');
		
		$validate = $this->tvprogramun_model->validate_password($params);
		
		if($validate['status'] == 0){
			$result = array(
					 'success' => true,
					'status' => 'error',
					'message' => $validate['message'],
					'data' => array('hasil' => 'aaaa')
				);
		
		}else{
			$curr = $this->createprofileu_model->change_jobs_time($str,$set_hours,$set_min);
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}
	
	public function change_univ_jobs(){
		
		$str = $_POST['id'];
		$set_name = $_POST['set_name'];
		$set_univ = $_POST['set_univ'];
		$token = $_POST['tokens'];
		
		$params['token']= $token;
		$params['uid']= $this->session->userdata('user_id');
		$validate = $this->tvprogramun_model->validate_password($params);
		
		if($validate['status'] == 0){
			$result = array(
				'success' => true,
				'status' => 'error',
				'message' => $validate['message'],
				'data' => array('hasil' => 'aaaa')
			);
		}else{
			$curr = $this->createprofileu_model->change_jobs_univ($str,$set_name,$set_univ);
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}
	
	public function change_jobs(){
		
		$str = $_POST['str'];
		
		
		$ar_str = explode("-",$str);
		
		$curr = $this->createprofileu_model->change_jobs($ar_str);
		
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}
	
	public function run_jobs(){
		$list = $_POST['pid'];
		$periode_list = $_POST['val_periode_list'];                
		
	
		
		if ( $list !== false ) {

			$curr = $this->createprofileu_model->check_job_user();
			
			if($curr[0]['RUNNING_JOB'] < 1 ){
				
				$this->createprofileu_model->insert_pid_partial($list,$periode_list); 
                      
				
				$command = 'php /var/www/jobs/profiling/ultimate/profile_jobs_fta.php '.$list.' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$list.'test1.log 2>&1 & ';  	
			
				$mystring = '/var/www/jobs/profiling/ultimate/profile_jobs_fta.php '.$list;
				
        
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
	  
	  
		$list = $_POST['pid'];
	  
		$command = 'php /var/www/jobs/profiling/ultimate/delete_profile_fta.php '.$list.' > /var/www/jobs/profiling/ultimate/delete_log_profile_'.$list.'.log 2>&1 & ';  

		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
  }
	
	public function create_profiling(){
		$list = $this->createprofileu_model->create($_POST);
		
		
		

			
		
		if ( $list !== false ) {

			
				
			
			
			
				
				
				

			
		
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function create_pav(){
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
		$list = $this->createprofileu_model->searchopval($_POST['name'], $_POST['user_id']);
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => $list );
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error load data' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function searchopval(){
		$list = $this->createprofileu_model->searchopval($_POST['name']);
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => $list );
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error load data' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function ceksearchfav(){
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
		$count_name = $this->createprofileu_model->checkname($iduser,$_GET['q']);
    
		if ( $count_name != "1" ) {
      $result = array( 'success' => true, 'message' => 'Vacant', 'data' => array('hasil' => $count_name));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Exist', 'data' => array('hasil' => $count_name));
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}	
	}
  
  public function listnotyet(){
      $list = $this->createprofileu_model->listnotyet($_GET['profid']);
      
      if ( $list ) {			
          $result = array( 'success' => true, 'message' => 'Exist', 'data' => $list);
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }

}
