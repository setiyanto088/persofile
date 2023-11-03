<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Api Auth Model
 * Model yang berhubungan dengan data-data autentikasi user
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Api_auth_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
				$this->load->library('ClickHouse');
        }
		
		
		public function check_user($params) {
			$query = "SELECT count(id) as totaluser 
							FROM hrd_profile
							WHERE id = 3
							AND token = '".$params['token']."' " ;
		
			$sql	= $this->db->query($query);
			$this->db->close();
			$this->db->initialize(); 
			return $sql->result_array();		
			
	    }
		
		public function viewers_get($params) {
			$db = $this->clickhouse->db();
			$query = " 	SELECT A.* FROM `RATING_PER_MINUTES_".$params['periode']."` A
						JOIN CHANNEL_PARAM_FINAL  B ON A.CHANNEL = B.CHANNEL_NAME 
						WHERE SPLIT_MINUTES = '".$params['time']."'
						AND CHANEL_URI = '".$params['channel']."' " ;
		
			$sql	= $db->select($query);
			return $sql->rows();	
			
	    }
		
	
}
