<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function logout(){	
		$user_id = $this->session->userdata['user_id'];
        $token = $this->session->userdata['token'];	
		$sql2	= 'UPDATE t_curr_user SET status_login = 0, date_logout = NOW() where token = ? and user_id = ?';
	
 		$query2 	=  $this->db->query($sql2,
			array(
			   $token,
			   $user_id
			));
			
		return $query2;
	}
	
			
				
	
}	