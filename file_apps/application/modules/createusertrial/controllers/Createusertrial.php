<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Createusertrial extends JA_Controller {
  public function __construct()
	{
		parent::__construct();	
   $this->load->helper(array('form', 'url'));		
		$this->load->model('createuser_model');
	}
	
	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}

		$data['listuser'] = $this->createuser_model->listuser();
	
		$this->template->load('maintemplate', 'createusertrial/views/listu_view', $data);
	}
	
	public function create(){
        $typerole = $this->session->userdata('type_role');
		
		$data['status']	  = "";
		$data['msg']	  = "";
		$data['listroleall'] = $this->createuser_model->listroleall();
		
		$this->template->load('maintemplate', 'createusertrial/views/createuser_view', $data);
		
	}
	
	public function createadmin(){
        $typerole = $this->session->userdata('type_role');
		
		
		$this->template->load('maintemplate', 'createusertrial/views/createadmin_view');
		
	}
	public function detail($id){
		$data['status']	  = "";
		$data['msg']	  = "";
		$data['idUser']=$id;
		$data['listroleall'] = $this->createuser_model->listroleall();
		$data['listrole'] = $this->createuser_model->listrole($id);
		$this->template->load('maintemplate', 'createusertrial/views/detailuser_view', $data);
		
	}
	
	
	public function saveuseradmin() {
		
		$params['username'] =$this->input->get_post('username');
		$params['nama']=$this->input->get_post('nama');
		$params['password']=$this->input->get_post('password');
		$params['email']=$this->input->get_post('email');
		$params['role']=$this->input->get_post('role');
		
		$data['status'] = $this->createuser_model->save_user_admin($params);
		
		
		if ($data['status']==1) {
			$data['msg'] = "Insert User Berhasil";
		} else {
			$data['msg'] = "Insert User Gagal";
		}
		
		
		$this->redirect_halaman_admin();
	}
	
	public function edituser($id)
	{
        $data['id'] = $id;
		$data['listroleall'] = $this->createuser_model->listroleall();
		
        $data['detailuser'] = $this->createuser_model->detailuser($id);        
        $this->load->view('edituser_view', $data );
		
	}
	
	public function edituserself($id)
	{
        $data['id'] = $id;
        $data['detailuser'] = $this->createuser_model->detailuser($id);        
        $this->load->view('edituserself_view', $data );
		
	}
	
	public function saverole() {
		
		$params['idUser'] =$this->input->get_post('idUser');
		$params['role'] =$this->input->get_post('role');
		
		
		$data['status'] = $this->createuser_model->update_role($params);
		if ($data['status']==1) {
			$data['msg'] = "Set Role Berhasil";
			$data['listroleall'] = $this->createuser_model->listroleall();
			$data['listrole'] = $this->createuser_model->listrole($params['idUser']);
		} else {
			$data['msg'] = "Set Role Gagal";
		}
		$data['idUser'] =$this->input->get_post('idUser');
		
		$this->template->load('maintemplate', 'createusertrial/views/detailuser_view', $data);
	}
	
	public function saveuser() {
		
		$params['username'] =$this->input->get_post('username');
		$params['password']=$this->input->get_post('password');
		$params['statuss']=$this->input->get_post('status');
		$params['role']=$this->input->get_post('role');
		$params['duration']=$this->input->get_post('duration');
		
		$data['status'] = $this->createuser_model->save_user($params);

		if ($data['status']==1) {
			$data['msg'] = "Insert User Berhasil";
		} else {
			$data['msg'] = "Insert User Gagal";
		}
		
		
		$this->redirect_halaman();
	}
	
	public function rdn() {
		
		$rand = 0;
		$length = 10;
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$rand = $i + 16;
			$randomString .= $characters[$rand];
		}
		
		
		echo json_encode($randomString,true);
	}
	
	public function edit() {
		
		
		$params['id'] =$this->input->get_post('id');
		$params['role']=$this->input->get_post('role');
		$params['months']=$this->input->get_post('months');
		
		
		
		
		
			$config =  array(
			  'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/uploaded/",
			  'upload_url'      => base_url()."uploaded/",
			  'allowed_types'   => 'gif|jpg|png|jpeg|pdf|doc|docx',
			  'max_width'		=> '2024',
			  'max_height'      => '2024',
			  'overwrite'       => FALSE,
			  'remove_spaces' 	=> TRUE,
			  'max_size'        => "100000 KB",
			);
					
			$this->load->library('upload', $config);	
			
			
		
			{
				$result = $this->upload->data();		
				
					$resizeParams = array
					(
						'source_image'	=> $result['full_path'],
						'new_image'		=> $result['full_path'],
						'width'			=> 2000,
						'height'		=> 800
					);
					
					$this->load->library('image_lib', $resizeParams);
					
					$this->image_lib->resize();			
				
					$params['images'] =  base_url()."uploaded/".$result['file_name'];
					$data['status'] = $this->createuser_model->edit_user($params);
		
				
			}
		
		
		
		
		
		
		
		
	
		if ($data['status']==1) {
			$data['msg'] = "Insert User Berhasil";
		} else {
			$data['msg'] = "Insert User Gagal";
		}
		
		
		$this->redirect_halaman();
		
	}
	public function editselfbak() {
		
		$params['username'] =$this->input->get_post('username');
		$params['pwd'] =$this->input->get_post('pwd');
		$params['nama']=$this->input->get_post('nama');
		$params['tmplahir']=$this->input->get_post('tmplahir');
		$params['tgllahir']=$this->input->get_post('tgllahir');
		$params['alamat']=$this->input->get_post('alamat');
		$params['nokontak1']=$this->input->get_post('nokontak1');
		$params['email']=$this->input->get_post('email');
		$params['iduser']=$this->input->get_post('iduser');
		
		$data['status'] = $this->createuser_model->edit_userself($params);
		
		$this->redirect_halamanself();
	}
	public function editself() {
	
		$params['username'] = $_POST['username'];
		$params['pwd'] = $_POST['pwd'];
		$params['nama']= $_POST['nama'];
		$params['tmplahir']= $_POST['tmplahir'];
		$params['tgllahir']= $_POST['tgllahir'];
		$params['alamat']= $_POST['alamat'];
		$params['nokontak1']= $_POST['nokontak1'];
		$params['email']= $_POST['email'];
		$params['iduser']=$_POST['iduser'];
		
		$hasil = $this->createuser_model->edit_pass($params);
		
		if($hasil > 0){
			 $res = array(
				'status' => 'success',
				'message' => 'Change Password Success!',
			);
		}else{
			$res = array(
				'status' => 'error',
				'message' => 'Change Password Failed!'
			);
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
		
	}
	
	public function list_user() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('id', 'username', 'nama');
		
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
		
		$list = $this->createuser_model->list_user($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();			
		foreach ( $list['data'] as $k => $v ) {
				$ss = "<a href='javascript:void(0)' onClick='editUser(".$v['id'].")' ><button class='btn btn-info waves-effect' >Update User</button></a>"
						."<a href='".base_url()."createusertrial/detail/".$v['id']."' ><button class='btn btn-success waves-effect' >Update Role Menu</button></a>";
			 
			array_push($data, 
				array(
					$v['id'], 
					$v['username'], 
					$v['nama'] ,
					$ss
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	
	public function list_user2() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('id', 'username', 'nama');
		
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
		
		$list = $this->createuser_model->list_user($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();			
		foreach ( $list['data'] as $k => $v ) {
				$ss = "<a href='javascript:void(0)' onClick='editUser(".$v['id'].")' ><button class='btn btn-info waves-effect' >Update User</button></a>"
						."<a href='".base_url()."createusertrial/detail/".$v['id']."' ><button class='btn btn-success waves-effect' >Update Role Menu</button></a>";
			 
			array_push($data, 
				array(
					$v['username'], 
					$v['nama'] ,
					$v['tmplahir'] ,
					$v['tgllahir'] ,
					$v['alamat'] ,
					$v['email']
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	
	public function listsearch(){
          $typerole = $this->session->userdata('type_role');
		$list = $this->createuser_model->listsearch($_GET['q'], $typerole);
        if ( $list ) {			
			
			$this->output->set_content_type('application/json')->set_output(json_encode($list));
		} else {
			$result = array( 'Value not found!' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	public function searchfav(){
		$list = $this->createuser_model->searchfav($_POST);
        if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => true, 'message' => 'data null', 'data' => array('hasil' => array())  );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	
	public function create_profiling(){
		$list = $this->createuser_model->create($_POST);
		
		
		if ( $list !== false ) {			
			
			$command = 'nohup php /var/www/html/steve/test_jobs.php '.$list.' > /var/www/html/steve/postbuy_sum.log 2>&1 ';  
			exec($command ,$pross);
		
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function create_pav(){
		$list = $this->createuser_model->create_pav($_POST);
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => true, 'message' => 'data null', 'data' => array('hasil' => array()) );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function searchopval(){
		$list = $this->createuser_model->searchopval($_POST['name']);
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => $list );
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error load data' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	public function ceksearchfav(){
		$list = $this->createuser_model->ceksearchfav($_POST);
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
        redirect(base_url('dashboard'));
	}

	public function redirect_halaman_admin()
	{
		$this->load->helper('url');
        redirect(base_url('createusertrial/adminlist'));
	}

	public function redirect_halamanself()
	{
		$this->load->helper('url');
        redirect(base_url());
	}

	 public function data_people() 
	 {
		$params = json_decode($json, TRUE);
		$ss = array();
		$profile = array();
		$push_count = array();
		$ssaa = array();
		
		foreach($params['andor'] as $new){
			array_push($ss, explode("_",$new));
		}
		
		$query = '';
		
		foreach($params['profile'] as $new1){
			$var = explode("_",$new1);
			$id_profile = $var[1];
			
			
			    $grouping_json = $this->createuser_model->content_grouping($id_profile);
				$res = json_decode($grouping_json['grouping']);
				$values = [];
				$values1 = '';

				$strsql='';
				$strsql2='';
				$sa='';
				
				
				foreach($res as $mydata)
				{
					if ($mydata->Tag=='KOTA') {
						$col = 'KOTA';	
					}
					else{
						$col = 'PERSONAS_TRIM';
					}
					$query .= ''.$col.' IN (';
					foreach ($mydata->Data as $k1 => $v1) {
						$query .= '"'.$v1.'",';
					}

					$query = substr($query,'0','-1');

					$query .= ')';

					foreach($ss as $nn){
							$query .=' '.$nn[1].' ';

					}
                 	
					
				}	
				
		}
		$query .= '.';

		foreach($ss as $nn){
			$vowels = array('AND .', 'OR .');
			$vowelsss = array("","");
		
			$query1 = "WHERE 1=1 AND ".$query;
			$onlyconsonants = str_replace($vowels,$vowelsss,$query1);			
		}
		$get_userid = $this->createuser_model->get_userid3($onlyconsonants);
		
		
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
        $ss = array();
		$profile = array();
		$push_count = array();
		$grouping = array();
		$grouping2 = array();
		foreach($params['isi'] as $new){
			array_push($ss, explode("_",$new));
		}
		$query = '';
        
        $namaprofile = $params['name'];
        $category = array("Tag"=>array(), "Data"=>array(),  "AND/OR" => array());
	
      	foreach($params['list'] as $new1){
			$var = explode("_",$new1);
			$id_profile = $var[1];
			
			
			    $grouping_json = $this->createuser_model->content_grouping($id_profile);
				$res = json_decode($grouping_json['grouping']);
				$values = [];
				$values1 = '';
				
				$strsql='';
				$strsql2='';
				$sa='';
				
				
				foreach($res as $mydata)
				{
					if ($mydata->Tag=='KOTA') {
						$col = 'KOTA';	
					}
					else{
						$col = 'PERSONAS_TRIM';
					}
					$query .= ''.$col.' IN (';
					foreach ($mydata->Data as $k1 => $v1) {
						$query .= '"'.$v1.'",';
					}

					$query = substr($query,'0','-1');

					$query .= ')';

					foreach($ss as $nn){
							$query .=' '.$nn[1].' ';

					}
                 	
					
				}	
           				
			array_push($grouping, $res);
				
		}
        
        $query .= '.';
        foreach($ss as $nn){        
			$vowels = array('AND .', 'OR .');
			$vowelsss = array("","");
			$query1 = "WHERE 1=1 AND ".$query;
			$onlyconsonants = str_replace($vowels,$vowelsss,$query1);			
		}

        foreach($grouping as $sas){
            foreach($sas as $asu){
                 foreach($ss as $nna){
                     $asu->ANDOR = $nna[1];
		               
                 }
                    
               
            }
            array_push($grouping2, $sas);
        }


         $data = json_encode($grouping2);
    	
		
        $get_userid = $this->createuser_model->get_userid3($onlyconsonants);
		$list = $this->createuser_model->create_statistic($namaprofile,$data, $get_userid[0]['people'], $get_userid[0]['USER_ID']);
        
		if ( $list ) {			
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => $list));
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error when inserting to database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
		
		
	}
	
	
	
	
	public function list_user_new() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('a.id', 'a.nama', 'activation', 'status_activation', 'expiredday');
		
		$search = $this->input->get_post('search');
		$iduser = $this->session->userdata('user_id');
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		$params['limit'] 		= (int) $length;
		$params['id'] 		= $iduser;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->createuser_model->list_user_new($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();
		$ss = '';		
		$sa = '';		
		foreach ( $list['data'] as $k => $v ) {
				if($v['activation'] == 0){
					$ss = "Not Registed";
				}elseif($v['activation'] == 1){
					$ss = "Paid";
				}elseif($v['activation'] == 2){
					$ss = "Trial";
				}
				
				if($v['status_activation'] == 0){
					$sa = "Waiting Approved Trial";
				}elseif($v['status_activation'] == 1){
					$sa = "Approved Trial";
				}elseif($v['status_activation'] == 2){
					$sa = "Waiting Approved Paid";
				}elseif($v['status_activation'] == 3){
					$sa = "Rejected";
				}elseif($v['status_activation'] == 4){
					$sa = "Approved Paid";
				}
				
				if($v['expiredday']){
					$sas = $v['expiredday']." days";
				}else{
					$sas = "0 days";
				}
				
				
					$sss = "<a href='javascript:void(0)' onClick='editUser(".$v['id'].")' ><button class='btn btn-info waves-effect' >Upgrade</button></a>";
			 
		
			array_push($data, 
				array(
					$v['nama'] ,
					$ss ,
					$sa,
					$sas,
					$v['reason'],
					$sss
					
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function adminlist()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}

		$data['listuser'] = $this->createuser_model->listuser();
	
		$this->template->load('maintemplate', 'createusertrial/views/listuadmin_view', $data);
	}
	
	
	
	
	public function list_user_admin() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('nama', 'status_user');
		
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
		
		$list = $this->createuser_model->list_user_admin($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();
		$sss = '';
		
		foreach ( $list['data'] as $k => $v ) {
			
			$sss = "<a href='javascript:void(0)' onClick='editUser(".$v['id'].")' ><button class='btn btn-info waves-effect' >Edit</button></a>";
			 
		
			array_push($data, 
				array(
					$v['nama'] ,
					$v['status_user'],
					
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	

}
