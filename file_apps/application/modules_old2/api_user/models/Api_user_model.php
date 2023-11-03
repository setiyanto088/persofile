<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Api Contact Model
 * Model yang berhubungan dengan data-data contact, termasuk CRUD dan searching
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
class Api_user_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
        }
        
        /**
		 * Mengambil daftar contact dari db
		 *
		 * @param array $params Parameter berupa start, limit, sort column, sort direction
		 * @return array Daftar contact berdasarkan parameter yang diberikan
		 */
        public function list_user($params = array()) {
			$sql 	= 'call user_list(?, ?, ?, ?, ?,   @total_filtered, @total)';
			
			$out = array();
			$query 	=  $this->db->query($sql,
				array(
					$params['limit'],
					$params['offset'],
					$params['order_column'],
					$params['order_dir'],
					$params['filter']
				));
			$result = $query->result_array();
			
			$this->load->helper('db');
			free_result($this->db->conn_id);
			
			$total = $this->db->query('select @total_filtered, @total')->row_array();
			
			$return = array(
				'data' => $result,
				'total_filtered' => $total['@total_filtered'],
				'total' => $total['@total'],
			);
			
			return $return;
		}
		
	
		
		public function create($data) {
		$username = $data['username'];
		$password = $data['pwd'];
		$nama = $data['nama'];
		$tgl_lahir = $data['tgl_lahir'];
		$tempatlahir = $data['tempatlahir'];
		$agama = $data['agama'];
		$role = $data['id_role'];
		$unit = $data['unit'];
		$contact1 = $data['nokontak1'];
		$contact2 = $data['nokontak2'];
		$contact3 = $data['nokontak3'];
		$alamat = $data['alamat'];
		$email = $data['email'];
		$logo = $data['logo'];
		$sql 	= 'call user_create("'.$username.'","'.$password.'","'.$nama.'","'.$tgl_lahir.'","'.$tempatlahir.'","'.$agama.'","'.$role.'","'.$unit.'","'.$contact1.'","'.$contact2.'","'.$contact3.'","'.$alamat.'","'.$email.'","'.$logo.'")';
			
		if ($sql) {
				return $this->db->query($sql);
			} 
			else {
				return false;
			}
		}
		
		public function detail($id) {
			$sql 	= 'call user_detail(?)';
			
			$query 	=  $this->db->query($sql,
				array(
					$id
				));
			$return = $query->row_array();
			
			return $return;
		}
		
		public function change_pwd($data, $id) {

		$password = $data['password'];
			$sql 	= 'call change_password("'.$id.'","'.$password.'")';
			
		if ($sql) {
				return $this->db->query($sql);
			} 
			else {
				return false;
			}
		}
		
		public function delete($id) {
			$this->db->trans_start();
			$this->db->where('id', $id);
			$this->db->delete('pmt_mitra');
			$this->db->trans_complete();
			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				if ($this->db->trans_status() === FALSE) {
					return false;
				}
				return true;
			}
		}
		
		public function edit($data, $id) {

		$username = $data['username'];
		$nama = $data['nama'];
		$role = $data['id_role'];
		$contact1 = $data['nokontak1'];
		$contact2 = $data['nokontak2'];
		$contact3 = $data['nokontak3'];
		$alamat = $data['alamat'];
		$email = $data['email'];
		$image = $data['image'];
			$sql 	= 'call user_update("'.$id.'","'.$username.'","'.$nama.'","'.$role.'","'.$contact1.'","'.$contact2.'","'.$contact3.'","'.$alamat.'","'.$email.'","'.$image.'")';
			
		if ($sql) {
				return $this->db->query($sql);
			} 
			else {
				return false;
			}
		}
		
		
		
		function delete_project($idProject)
		{
			
			$sql 	= 'call user_delete('.$idProject.')';

			$query 	=  $this->db->query($sql);
		
		}
		
		
		function get_tracking_list($id) {
			$sql 	= 'call mitra_map('.$id.')';
			$query = $this->db->query($sql);
			$ra = $query->result_array();
			return $ra;
		}
		
		function list_role()
		{
			$sql 	= 'call shared_list_role()';
			$query 	=  $this->db->query($sql);
			$result = $query->result_array();
			return $result;
		}
		
		function list_all_role()
		{
			$sql 	= 'call shared_list_all_role()';
			$query 	=  $this->db->query($sql);
			$result = $query->result_array();
			return $result;
		}		
		
		function list_unit()
		{
			$sql 	= 'call shared_list_unit_manager()';
			$query 	=  $this->db->query($sql);
			$result = $query->result_array();
			return $result;
		}
		
		function list_agama()
		{
			$sql 	= 'call shared_list_agama()';
			$query 	=  $this->db->query($sql);
			$result = $query->result_array();
			return $result;
		}
		
}
