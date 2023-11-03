<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Contact
 * Controller berhubungan dengan data-data contact
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Api_auth extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_auth/api_auth_model');
	}
	
	public function Anti_si($string) {
        $string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
        return $string;
    }
	
	public function login() {
		
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		
		$newdata = array();
		if ($this->form_validation->run() == FALSE)  {
			$result = array( 'success' => false, 'message' => validation_errors() );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else if ($this->form_validation->run() == TRUE)  {
			$data = array (
				'username' 		=> $this->Anti_si($this->input->post('username', true)),
				'password' 		=> $this->Anti_si($this->input->post('password', true)),
			);
			$login_result = $this->api_auth_model->login($data);
			
         	if ( $login_result['message']== 'Success') {
			
				$hasilnya = $this->api_auth_model->get_profile($data);
              
                 
                if(isset($hasilnya[0])){
                  
                    if($hasilnya[0]['role_id'] == 1 || $hasilnya[0]['role_id'] == 3 || $hasilnya[0]['role_id'] == 6 || $hasilnya[0]['role_id'] == 19 || $hasilnya[0]['role_id'] == 79 || $hasilnya[0]['role_id'] == 90 || $hasilnya[0]['role_id'] == 40 || $hasilnya[0]['role_id'] == 999 || $hasilnya[0]['role_id'] == 74 ){
                        
                            foreach($hasilnya as $newhasil){
                                $newdata = array
                                        (
                                            'user_id'		=> $newhasil['user_id'],
                                            'token'		    => $newhasil['token'],
                                            'username' 		=> $newhasil['username'],
                                            'nama' 			=> $newhasil['nama'],					
                                            'id_role' 		=> $newhasil['id_role'],
                                            'user_name' 		=> $newhasil['user_name'],
                                            'user_full_name' 		=> $newhasil['user_full_name'],
                                            'role_id' 		=> $newhasil['role_id'],
                                            'role_name' 		=> $newhasil['role_name'],
                                            'status_pwd' 		=> $newhasil['status_pwd'],
                                            'type_role' 		=> $newhasil['type_role'],
                                            'day_activation' 		=> '0',
                                            'id_unit'		=> $newhasil['id_unit'],
                                            'nokontak2'		=> $newhasil['nokontak2'],
                                            'nokontak3'		=> $newhasil['nokontak3'],
                                            'id_profile'	=> $newhasil['id_profile'],
                                            'id_profile2'	=> $newhasil['id_profile2'],
                                            'id_profile3'	=> $newhasil['id_profile3'],
											'id_profile4'	=> $newhasil['id_profile4']


                                );
                            }
                             $this->session->set_userdata($newdata);

                         $return = array(
                            'success' => true,
                            'message' => 'Success',
                            'data' => $newdata
                            );
                    }else{
                          $aktivasi = $this->api_auth_model->get_activation($data, $hasilnya);
                        if(isset($aktivasi[0])){
							
                            if(!$aktivasi){
                              
                                     $return = array('success' => false, 'message' => 'Your account has been expired!', 'data' => array());
                            }else{
                                    if($aktivasi[0]['activation_id'] == 2){

                                            foreach($hasilnya as $newhasil){
                                                $newdata = array
                                                        (
                                                            'user_id'		=> $newhasil['user_id'],
                                                            'token'		    => $newhasil['token'],
                                                            'username' 		=> $newhasil['username'],
                                                            'nama' 			=> $newhasil['nama'],					
                                                            'id_role' 		=> $newhasil['id_role'],
                                                            'user_name' 		=> $newhasil['user_name'],
                                                            'user_full_name' 		=> $newhasil['user_full_name'],
                                                            'role_id' 		=> $newhasil['role_id'],
                                                            'role_name' 		=> $newhasil['role_name'],
                                                            'status_pwd' 		=> $newhasil['status_pwd'],
                                                            'type_role' 		=> $aktivasi[0]['activation_id'],
                                                            'day_activation' 		=> $aktivasi[0]['expiredday'],
                                                           'id_unit'		=> $newhasil['id_unit'],
															'nokontak2'		=> $newhasil['nokontak2'],
															'nokontak3'		=> $newhasil['nokontak3'],
															'id_profile'	=> $newhasil['id_profile'],
															'id_profile2'	=> $newhasil['id_profile2'],
															'id_profile3'	=> $newhasil['id_profile3'],
															'id_profile4'	=> $newhasil['id_profile4']
        
        
                                                );
                                            }
                                             $this->session->set_userdata($newdata);
        
                                         $return = array(
                                            'success' => true,
                                            'message' => 'Success',
                                            'data' => $newdata
                                            );
                                    }elseif($aktivasi[0]['activation_id'] == 3){
                                        $return = array('success' => false, 'message' => 'Your account has been expired!', 'data' => array());
                                    }else{
										$return = array('success' => false, 'message' => 'Your account has been suspended!', 'data' => array());
									}
                            }
                            
                        }else{
                            $return = array('success' => false, 'message' => 'Your account has been expired!', 'data' => array());
                        }
                        // die;
                        
                    }
                }
                
                
            }elseif($login_result['message']== 'OVERLIMIT') {
                $return = array('success' => false, 'message' => 'User Limit Reach 10 !', 'data' => array());
            }else{
                $return = array('success' => false, 'message' => 'Username and Password Incorrect', 'data' => array());
            }

			$this->output->set_content_type('application/json')->set_output(json_encode($return));
			
		}
	}
	
	public function check_user($id){
		
		$newdata = array();
		$hasilnya = $this->api_auth_model->check_user($id);
		if($hasilnya){
			
			foreach($hasilnya as $newhasil){
				$newdata = array
						(
							'user_login'		=> $newhasil['totaluser']


				);
			}
			
			
			$return = array(
				'success' => true,
				'message' => 'Success',
				'data' => $newdata
			);
		}else{
			 $return = array('success' => false, 'message' => 'User No Have Logged', 'data' => array());
		}
               
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	public function check_profile($id){
		
		$newdata = array();
		$notif = 0;
		$hasilnya = $this->api_auth_model->check_profile($id);
		if($hasilnya){
			
			foreach($hasilnya as $newhasil){
				
				if(isset($newhasil['STATUS_READ'])){
					if($newhasil['STATUS_READ'] == 1){
						$notif += count($newhasil['STATUS_READ']); 
					}
					
				}
				
			}
			
			
			$return = array(
				'success' => true,
				'message' => 'Success',
				'data' => $hasilnya,
				'totalnotifaktif' => $notif
			);
		}else{
			 $return = array('success' => false, 'message' => 'User No Have Logged', 'data' => array());
		}
               
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	
	public function update_read($id){
		
		$hasilnya = $this->api_auth_model->update_read($id);
		if($hasilnya){	
			$return = array(
				'success' => true,
				'message' => 'Success'
			);
		}else{
			 $return = array('success' => false, 'message' => 'User No Have Logged', 'data' => array());
		}
               
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
	
	
	public function logoout(){
		
		$hasilnya = $this->api_auth_model->logout();
		if($hasilnya){
			$return = array(
				'success' => true,
				'message' => 'Success'
			);
		}else{
			 $return = array('success' => false, 'message' => 'User No Have Logged');
		}
               
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}

	
	public function logouts()
	{
        $user_id = $this->session->userdata['user_id'];
        $token = $this->session->userdata['token'];
		
		$hasilnya = $this->api_auth_model->logout();
		if($hasilnya){

			
			    log_activity('Logout','ID user '.$user_id.'.');
				$this->session->sess_destroy();
				redirect(base_url());
		}
		
		
		
      
	}
	
	public function send_email()
	{
     
		$hasilnya = $this->api_auth_model->send_email();
		if($hasilnya > 0){
			
			
			$return = array(
				'success' => true,
				'message' => 'Success'
			);
			   
			
		}else{
		
			 $return = array('success' => false, 'message' => 'Email Not Be Send');
			
		}
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
      
	}
	
	public function cekuseractivity()
	{ 
        
		$hasilnya = $this->api_auth_model->cekuseractivity();
		if(!empty($hasilnya)){
			$return = array('success' => false, 'message' => 'User Active;', 'data' => $hasilnya);
		}else{
			$return = array('success' => true, 'message' => 'User Logout;');
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
		
      
	}
	
	public function cekuseractivity2()
	{ 
        
		$hasilnya = $this->api_auth_model->cekuseractivity();
		if(!empty($hasilnya)){
			$return = array('success' => false, 'message' => 'User Active;', 'data' => $hasilnya);
		}else{
			$return = array('success' => true, 'message' => 'User Logout;');
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
		
      
	}
}

