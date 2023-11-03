<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	function get_login($nickname,$password) {
		$sql = "select a.id_user,a. nickname, a.nama_user,a. profile_user,b.nama_profile,a.status_akses,a.image
		from pmt_user a,pmt_profile b 
		where a.nickname = '$nickname' and a.pwd = '".password_hash($password, PASSWORD_BCRYPT)."';
		and b.idprofile=a.profile_user ";
 		$hasil = $this->db->query($sql);
		return $hasil->result(); 
	}
	
			
	
	public function keluar(){	
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