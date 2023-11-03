<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Api Auth Model
 * Model yang berhubungan dengan data-data profile user
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Api_profile_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
        }
        
		 public function get_user_detail($params = array()) {
            $sql 	= 'SELECT a.id as user_id, a.username, a.username as user_name, a.nama as user_full_name, a.id_role as role_id, b.role as role_name, a.status_pwd as status_pwd
                          FROM hrd_profile a LEFT JOIN pmt_role b   ON a.id_role = b.id
                        WHERE a.id = ?';
			
			$query 	=  $this->db->query($sql,
				array(
					$params['user_id']
				));
			$return = $query->row_array();
			
			return $return;
		}
		

}
