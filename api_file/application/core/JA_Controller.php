<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JA_Controller extends CI_Controller {
	public function __construct() {
        parent::__construct();	
		$this->load->library('ClickHouse');	
 
		
		if ((!$this->session->userdata("token")))
		{
			
			
		}
    }
	
	public function Anti_si($string) {
        $string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
        return $string;
    }

    public function _list_profile_2() {
		$query = 'SELECT id, t_profiling_ub.name FROM t_profiling_ub WHERE STATUS IN (1,3,9) order by name';  	 	 	
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	 public function _list_profile() {
		$query = 'SELECT id, t_profiling.name FROM t_profiling WHERE STATUS IN (1,3,9) order by name';  	 	 	
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function _list_channel() {
	 
		
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT(CHANNEL) channel FROM M_CIM_F2A_SUMMARY_CB";			
		$result = $db->select($query);
		return $result->rows();	 
	}

	public function json_result($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function create_nested($data,$type){
		
		$html = '<li class="dd-item" data-id="SECTOR">	
				<div class="dd-handle">'.$type.'</div>
				<ol class="dd-list">';
 		foreach($data as $data){
			
			$html = $html.'<li class="dd-item" data-id="'.$data[$type].'"><div class="dd-handle">'.$data[$type].'</div></li>';
			
		}
		
		$html = $html.'</ol></li>';
		
		return $html;
		
	}
	
	 

	public function _list_subkategori($kategori){
		$kategori = strtoupper($kategori);
		$sql 	= "SELECT DISTINCT(".$kategori.") AS ".$kategori." FROM M_CIM_F2A_SUMMARY_TEST2D
	
		ORDER BY ".$kategori." ASC;";
		
		$query 	=  $this->db->query($sql);
		$this->db->close();
		$this->db->initialize(); 
		
		$return = $query->result_array();
		return $return;
	}
	
	public function _list_subkategori_ptv($kategori){
		$kategori = strtoupper($kategori);
		$sql 	= "SELECT DISTINCT(".$kategori.") AS ".$kategori." FROM PTV_CIM_RATING  
		ORDER BY ".$kategori." ASC;";
		
		$query 	=  $this->db->query($sql);
		$this->db->close();
		$this->db->initialize(); 
		
		$return = $query->result_array();
		return $return;
	}

}