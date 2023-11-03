<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model
 * Model yang berhubungan dengan
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Menu_model extends CI_Model {
		
        public function __construct() {
			parent::__construct();
			
			$this->load->helper('cookie');
			$prefix = $this->config->item('cookie_prefix');
			
			$this->user_id = get_cookie($prefix.'user_id');
			$this->token = get_cookie($prefix.'token');
        }

		public function get_all_menu() {
			$url = base_url().'api_menu/get_all_menu?sess_user_id='.$this->user_id.'&sess_token='.$this->token;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
print_r($output); die;
			return json_decode($output, TRUE);
		}

		public function get_profile_menu($role_id) {
			$url = base_url().'api_menu/get_menu/' .  $role_id . '?sess_user_id='.$this->user_id.'&sess_token='.$this->token;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);

			return json_decode($output, TRUE);
		}

		public function get_roles() {
			$url = base_url().'api_menu/get_roles?sess_user_id='.$this->user_id.'&sess_token='.$this->token;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);

			return json_decode($output, TRUE);
		}

		public function save_menu($data) {
			$url = base_url().'api_menu/save_menu?sess_user_id='.$this->user_id.'&sess_token='.$this->token;
			$json_data = json_encode($data);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				)
			);
			
			$output = curl_exec($ch);
			curl_close($ch);

			return json_decode($output, TRUE);
		}
}
