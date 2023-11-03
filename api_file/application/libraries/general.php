<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class General {
public function __construct() {
		$this->CI =& get_instance();
	}
public function call_procedure($para1,$para2){
	//echo 'ISI CALL PROCEDURE';
	$call_procedure ="CALL TestProcedure('$para1', '$para2', @para3)";
    $this->db->query($call_procedure);
    $call_total = 'SELECT @para3 as Parameter3';
    $query = $this->db->query($call_total);
    return $query->result(); 
}


/* 	public function session_check()
	{
		$CI =& get_instance();
		$CI->user_id	= $CI->session->userdata('id_user');
		$CI->user_name	= $CI->session->userdata('nickname');
		$CI->user_kode	= $CI->session->userdata('kode');
		$CI->user_nama	= $CI->session->userdata('nama_user');
		$CI->user_group	= $CI->session->userdata('profile_user');
		$CI->user_waktu	= $CI->session->userdata('waktu_login');
		$CI->user_ip		= $CI->session->userdata('user_ip'); 
		
		if ($CI->user_id=="") {
			redirect(site_url("login/logout")); 
		}
	}

	public function session_check2()
	{
		$CI =& get_instance();
		$CI->user_id	= $CI->session->userdata('id_user');
		$url = "yahoo.com";
		if ($CI->user_id=="") {
			return $url; 
		}else{
			return $url='';
		}
	}		 */
	function task(){
		// $id_user = $this->CI->session->userdata('id_user');
		// $hak_akses = $this->CI->session->userdata('role_id');
		// $data['username']=$id_user;
		// $data['hak_akses']=$hak_akses;
		$user_id = $_COOKIE["pmis2_user_id"];
		$this->CI->load->model('default_data_model');
		//$data['list_role']              =   $this->CI->default_data_model->list_role($id_user);
		$data['task']            		=   $this->CI->default_data_model->task($user_id);
		$data['list_task']  			 =   $this->CI->default_data_model->list_task($user_id);
		// $data['reschedule_preventif']   =   $this->CI->default_data_model->reschedule_preventif($id_user);
		// $data['reschedule_corrective']  =   $this->CI->default_data_model->reschedule_corrective($id_user);
		// $data['order_preventif']        =   $this->CI->default_data_model->order_preventif($id_user);
		// $data['order_corrective']       =   $this->CI->default_data_model->order_corrective($id_user);
		// $data['order_bbm']    		  	=   $this->CI->default_data_model->order_bbm($id_user);
		// $data['order_mbp']    		    =   $this->CI->default_data_model->order_mbp($id_user);
		// $data['ticket']    		    	=   $this->CI->default_data_model->ticket($id_user);
		return $data;
		
	}
	public function getMenu() {
		// $this->session_check();
		$menu = $this->load->model('api_menu/Api_menu_model','',TRUE);
		$showMainMenu = $menu->getMenu();
		return $showMainMenu;
	}
	
	public function getSubMenu($idmenu) {
		// $this->session_check();
		$menu = $this->CI->load->model('api_menu/Api_menu_model','',TRUE);
		$showSubMenu = $menu->getSubMenu($idmenu);
		return $showSubMenu;
	}	
}
