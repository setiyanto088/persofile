<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inratereport_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db_prod', TRUE);
		
	}
	
	public function get_genre() {  
		$query = "SELECT genre FROM INRATE_CHANNEL_GENRE GROUP BY `genre` ORDER BY `genre`";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();
	}
	
	public function get_tahun(){
		$query = "SELECT DISTINCT(PERIODE_STR)  TANGGAL FROM T_PERIODE ORDER BY PERIODE DESC";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_bulan(){
		$query = "SELECT DISTINCT SUBSTR(TANGGAL,6) bulan FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL, '%Y-%M')";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_week_channel($periode){
		
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_CHAN_PTV_WEEK WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS UNSIGNED )";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}	
	
	public function channel_list($periode){
		
		$query = "SELECT DISTINCT `CHANNEL` FROM M_SUM_TV_DASH_CHAN_PTV WHERE TANGGAL='".$periode."' AND CHANNEL <> '' ORDER BY CHANNEL ";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_week_program($periode){
		
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_PROG_WEEK_PTV WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS UNSIGNED )";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_active_audience($periode){
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE_PTV WHERE TANGGAL= '".$periode."'" ;
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}

	public function get_reports($query) {
		

		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 

		return $sql->result_array();	 
	}
	
}	
