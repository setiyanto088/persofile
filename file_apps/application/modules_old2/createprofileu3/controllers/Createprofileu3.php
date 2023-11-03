<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createprofileu3 extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('createprofileu_model');
		$this->load->model('audienceresume/audience_model');
	}
	
	public function resume(){
		
		 $data['profile'] = $this->audience_model->list_profile();
		  $data['daypart'] = $this->audience_model->list_daypart(0);
		  $data['channels'] = $this->audience_model->get_channel(); 
		  
		  $typerole = $this->session->userdata('type_role');
		  $data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		  $data['currdate'] = $this->audience_model->current_date();
		  
		  $this->template->load('maintemplate', 'audienceresume/views/audience_view', $data);
		
	}
	
	public function index()
	{
		$data = '';
		
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
		$data['listparent'] = $this->createprofileu_model->listdataprofilenewsss($typerole);
	
		$this->template->load('maintemplate', 'createprofileu3/views/listu_view', $data);
	}
	
	  public function del_jobs(){
	  
	  
		$list = $this->Anti_si($_POST['pid']);
	  
		$command = 'php /var/www/jobs/profiling/ultimate/delete_profile_ptv.php '.$list.' > /var/www/jobs/profiling/ultimate/delete_log_profile_ptv_'.$list.'.log ';  
			
		$pid = shell_exec($command);
	  
	  
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
  }
	
	public function create(){
		
		
        $typerole = $this->session->userdata('type_role');
		$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		
		$this->template->load('maintemplate', 'createprofileu3/views/createprofileu_view', $data);
		
	}
	
	public function detail($id){
		$data['detail'] = $this->createprofileu_model->detailnew($this->Anti_si($id));
		
		
		$this->template->load('maintemplate', 'createprofileu3/views/detailprofileu_view', $data);
		
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
					$ss = "<a style='color:red' href='".base_url()."createprofileu3/detail/".$v['idprofile']."' >".$v['name']."</a>";
			}
			
			
			if($v['user_id_profil'] == 0){
				$sss =	"<span>Done</span>";
			}else{
				if($v['status_job'] == 1){
					$sss =	"<span>Done</span>";
				}elseif($v['status_job'] == 2){
					$sss = "<span>In progress</span>";
				}elseif($v['status_job'] == 3){
					$sss = "<span>On Queue</span>";
				}else{
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
				$done_ph = "<select class='form-control' ><option>Month&nbsp;&nbsp;&nbsp;&nbsp;</option>".$opt."</select>";
			}else{
				
				$done_ph = "<select class='form-control' ><option>Month</option>".$opt."</select>";
			}
			
			
			
			$done_p1 = $this->createprofileu_model->done_p1($v['id']);
			
			$opt1 = "";
			foreach($done_p1 as $kkkk1){
				$opt1 = $opt1."<option>".$kkkk1['PERIODE']."</option>";
			}
			
			if($opt1 == ""){
				$done_ph1 = "<select class='form-control' ><option>Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>".$opt1."</select>";
			}else{
				
				$done_ph1 = "<select class='form-control' ><option>Month</option>".$opt1."</select>";
			}
			
				if($v['user_id_profil'] <> 0){
				
				array_push($data, 
				array(
					"<p style='text-align:left;vertical-align:middle;color:red !Important'>".$ss."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$v['date_create']."</p>",
					"<p style='text-align:right;vertical-align:middle'>".number_format($v['people'], 0, ',', '.')."<p>",
					"<p style='text-align:center;vertical-align:middle'>".$done_ph1."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$done_ph."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$nnn."</p>",
					"<p style='text-align:center;vertical-align:middle'>".$sss."</p>",
					"<span style='text-align:center;vertical-align:middle'><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$v['idprofile']."' onclick='predelete(".$v['idprofile'].")' >Delete</button></span>"
				)
			);
				
			}else{
				
				array_push($data, 
					array(
						"<p style='text-align:left;vertical-align:middle;color:red !Important'>".$ss."</p>",
						"<p style='text-align:center;vertical-align:middle'>".$v['date_create']."</p>",
						"<p style='text-align:right'>".number_format($v['people'], 0, ',', '.')."<p>",
						"<p style='text-align:center;vertical-align:middle'>".$done_ph1."</p>",
						"<p style='text-align:center;vertical-align:middle'>".$done_ph."</p>",
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
		$list = $this->Anti_si($_POST['pid']);
    $periode_list = $this->Anti_si($_POST['val_periode_list']);       
    
		

			
		
		if ( $list !== false ) {

			$curr = $this->createprofileu_model->check_job_user();
			
				
				 $this->createprofileu_model->insert_pid_partial($list,$periode_list);
				 
				$command = 'php /var/www/jobs/profiling/ultimate/profile_jobs_ptv.php '.$list.' > /var/www/jobs/profiling/ultimate/log_profile_n_'.$list.'_ptv_.log 2>&1 & ';  
			
				$this->createprofileu_model->inset_queue2($list,$periode_list,$command);
			
			
        
			
		/*	
				$mystring = '/var/www/jobs/profiling/ultimate/ultimate3.php '.$list;
				exec("ps aux | grep \"${mystring}\" | grep -v grep | awk '{ print $2 }' | head -1", $out);
				
				$this->createprofileu_model->insert_pid($list,"");
				
        */
				
       
				
				

			
		
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
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
	public function searchopval(){
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
		
		$iduser = $this->session->userdata('user_id');
		$id_prof = explode('|',$params['list_combine']);
		$id_cond = explode('|',$params['cond_val']);
		
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
					$qr1 = "SELECT * FROM `PROFILE_CARDNO` WHERE `ID_PROFILE` = '".$id_profile."'";
				}else{
					$qr2 = "SELECT * FROM `PROFILE_CARDNO` WHERE `ID_PROFILE` = '".$id_profile."'";
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
		
		$create_combine = $this->createprofileu_model->create_combine($params,$iduser,$query,'');

        
		
		if ( $create_combine ) {		

			
		
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $create_combine));
			
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

}
