<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MX_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('logout/logout_model');
	}

	public function index()
	{
        $user_id = $this->session->userdata['user_id'];
        $token = $this->session->userdata['token'];
		
		$hasilnya = $this->logout_model->logout();
		if($hasilnya){
 
			
			    log_activity('Logout','ID user '.$user_id.'.');
				$this->session->sess_destroy();
				redirect(base_url());
		}else{
			
  		}
		
		
		
	}



}
