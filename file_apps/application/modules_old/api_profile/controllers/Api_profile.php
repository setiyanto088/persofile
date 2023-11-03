<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Contact
 * Controller berhubungan dengan data-data profile
 *
 * @author rizalhaibar.rh@gmail.com
 * @copyright (c) 2017 PT. Swamedia Informatika
 */
class Api_profile extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_profile/api_profile_model');
	}
	
	
	public function get_user_detail($user_id) {
        echo 123123;

	}
}

