<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends MX_Controller {

    public function __construct()
	{
		parent::__construct();	
		$this->load->model('login_model');
	
	}
	
	public function index()
	{
		
		
		
		if ( ! empty($this->session->userdata('user_id')) ) {
			
			$user_id 	= $this->session->userdata('user_id');
			$token		= $this->session->userdata('token');
			$status 	= $this->session->userdata('status_pwd');
			
					 
					 $query = $this->db->query('SELECT 	COUNT(id) as is_valid
					FROM 	hrd_profile 
					WHERE 	id = ?
					AND id_unit <> 87
					AND 	token = ?;', array($user_id, $token) );
					 $row   = $query->row_array();
					 if ( ! $row['is_valid']) {
						 
						 

					 }
					 else{
							$role		= $user_id 	= $this->session->userdata('role_id');
							if ($role == 10 ){
								redirect(base_url().'dashboardfreetoair'); 
							}
							elseif ($role == 1  ||$role == 6 ||$role == 19  ){
								redirect(base_url().'dashboard');
							}
							elseif ($role == 3 ){
								redirect(base_url().'createuser');
							}
							elseif ($role == 40 ){
								redirect(base_url().'createprofileglobal');
							}
							elseif ($role == 41 || $role == 42 ){
								redirect(base_url().'dashboarddata');
							}
							elseif ($role == 25 ||  $role == 35 ||  $role == 27 ||  $role == 33){
								redirect(base_url().'tvprogramun3');
							}elseif ($role == 645 ){
								redirect(base_url().'tvprogramun3tvsea');
							}
							elseif ($role == 1000001 || $role == 1000000 || $role == 1000002 || $role == 30000001 || $role == 50 || $role == 55 || $role == 74 || $role == 60 || $role == 49 || $role == 5555 || $role == 5566  || $role == 5577 || $role == 5599 ){
								redirect(base_url().'tvprogramun3');
							}elseif ($role == 90 ){
								redirect(base_url().'dashboarduseetv');
							}elseif ($role == 79 ){
								redirect(base_url().'user_usee');
							}elseif ($role == 999 ){
								redirect(base_url().'tvprogramunpro');
							}elseif ($role == 998 ){
								redirect(base_url().'tvpostbuyures');
							}elseif ($role == 656 ){
								redirect(base_url().'respondent');
							}elseif ($role == 969 ){
								redirect(base_url().'tvprogramunres');
							}
							else{
								redirect(base_url().'tvprogramun3');
							}
							
							
							
				    }
		} 
		else {
			
			$this->load->view('login_view');
		}
	}

	function _submitLogin()
	{	
		$uname = $this->input->post('username',TRUE); 
		
		echo $uname;

		
		
	}
	
	
	public function keluar()
	{
		
       $user_id = $this->session->userdata['user_id'];
        $token = $this->session->userdata['token'];	
		$sql2	= 'UPDATE t_curr_user SET status_login = 0, date_logout = NOW() where token = ? and user_id = ?';
	
		$query2 	=  $this->db->query($sql2,
			array(
			   $token,
			   $user_id
			));
		
		
		if($query2 > 0){
			
			
				$this->session->sess_destroy();
				redirect(base_url());
		}
		
		
		
	}
	
}
