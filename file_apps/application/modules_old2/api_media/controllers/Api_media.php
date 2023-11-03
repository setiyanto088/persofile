<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Contact
 * Controller berhubungan dengan data-data contact
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Api_media extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_media/api_auth_model');
	}
	
	public function Anti_si($string) {
        $string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
        return $string;
    }
	
	public function get_viewers_get() {

		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		$param['channel']=  $this->Anti_si($this->uri->segment(4)); 
		$param['times'] =  $this->Anti_si($this->uri->segment(5)); 
		
		$data = $this->api_auth_model->check_user($param);
		
		if($data[0]['totaluser'] == 1){
			$datat = explode("-",$param['times']);
			
			$param['time'] = $datat[0].'-'.$datat[1].'-'.$datat[2].' '.$datat[3];
			$param['periode'] = strtoupper(date_format(date_create($param['time']),"yM"));
			
			//print_r($param);die;
			
			$data2 = $this->api_auth_model->viewers_get($param);
			
			IF(count($data2) > 0){
			
				$res = array(
					'status' => 'success',
					'data' => array(
						'CHANNEL' => $data2[0]['CHANNEL'],
						'VIEWERS' => $data2[0]['VIEWERS']
					),
					'message' => ''
				);
			
			}else{
				$res = array(
					'status' => 'error',
					'data' => array(),
					'message' => 'Data Not Found'
				);
			}
			
		}else{
			$res = array(
				'status' => 'error',
				'data' => array(),
				'message' => 'Token Authentication Failed'
			);
		}
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}
	
	
}

