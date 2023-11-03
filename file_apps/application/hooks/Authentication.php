<?php  if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

/**
 * 
 *
 */

class Authentication
{
	
    function check_token() {
		
		$this->ci =& get_instance();
		$current_controller = $this->ci->router->fetch_class();
		
		$exceptions = array(
			'api_menu' => 1, // doesn't need auth ,
			'api_auth' => 1, // doesn't need auth ,
			'api_media' => 1, // doesn't need auth ,
			'logout' => 1, // doesn't need auth ,
			'absen' => 1 
			
		);
		
		if ( ! isset($exceptions[$current_controller]) ) { // if controller is not in exception list, then do check auth
		
			if ( preg_match("/^api_.*\$/", $current_controller) ) { // check only in Api_* controllers
				$user_id = $this->ci->session->userdata['user_id'];
				$id_role = $this->ci->session->userdata['id_role'];
				$token = $this->ci->session->userdata['token'];
	
				if ( ! empty($user_id) && $user_id != 'undefined') {
					$query = $this->ci->db->query('SELECT 	COUNT(id) as is_valid
                                                    FROM 	hrd_profile 
                                                    WHERE 	id = ?
                                                    AND 	token = ?;', array($user_id, $token) );
					$row   = $query->row_array();
					if (  $row['is_valid'] != 0 ) {
						
						log_message('error', "Invalid Token. User ID: $user_id, Token: $token");
						$data['message'] = 'Invalid Token';
						$data['data'] = array('user_id' => $user_id, 'token' => $token);
						$this->show_error($data);
					}
				} else {
					
					$data['message'] = 'Invalid User ID';
					$data['data'] = array('user_id' => $user_id, 'token' => $token);
					$this->show_error($data);
					
					
				}
			}else{
				
			
				
				
				if(isset($this->ci->session->userdata['user_id'])){
					$user_id = $this->ci->session->userdata['user_id'];
					$token = $this->ci->session->userdata['token'];
					
					$query1 = $this->ci->db->query('SELECT  status_login FROM t_curr_user
													WHERE user_id = ? AND token = ?;', array($user_id, $token) );
						$row1   = $query1->row_array();
						
						if (  $row1['status_login'] == 0 ) {
							$this->ci->session->sess_destroy();
							
							redirect(base_url());		
						}
				}
				
				
				
			}
		}
		
	}
	
	function show_error($params) {
		$result = array(
			'success' => false,
			'message' => $params['message'],
			'data'=> array(
				$params['data']
			)
		);
 		header('Content-type: Application/json');
		echo json_encode($result);
		exit();
	}
	
	function check_login() {
		
		$this->ci =& get_instance();
		
		$this->ci->load->helper('cookie');
		$this->ci->load->helper('url');
		
		$current_controller = $this->ci->router->fetch_class();
		
		if ( ! preg_match("/^api_.*\$/", $current_controller) && ! preg_match("/^absen.*\$/", $current_controller) ) { // check only in web (non api) controllers
			if ( ! preg_match("/^login\$/", $current_controller) ) { // check selain login
				$prefix = $this->ci->config->item('cookie_prefix');
				if ( empty($this->ci->session->userdata['user_id']) ) {
					redirect(base_url().'login');
					 
				 }

			}
		}
	}
}

?>
