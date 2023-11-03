<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	

	
	public function list_channel() {
 		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS channel FROM  `CHANNEL_PARAM_FINAL` B WHERE CHANNEL_NAME_PROG IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ORDER BY CHANNEL_NAME_PROG ";
		
		$sql	= $db->select($query);
		return $sql->rows();			   
	}          
	
	public function get_profile($iduser,$idrole,$periode) {  
	 
		
		$i0 =  date_format(date_create($periode),"Y-m");
 			
			$sql = "SELECT A.* FROM ( 
					SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a WHERE (STATUS = 1 OR STATUS = 3)  
					AND user_id_profil IN (".$iduser.",0)  ORDER BY `name`
					) A JOIN
					`M_MONTH_PROFILE_PTV`  B ON A.id = B.`PROFILE_ID`
					WHERE B.`PERIODE` = '".$i0."' AND B.`STATUS_PROCESS` = 1
					";
		
		 
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_tahun(){
		
		$query = "SELECT DISTINCT(PERIODE_STR)  TANGGAL FROM T_PERIODE ORDER BY PERIODE DESC";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	public function get_epg_file($param){
		
		$query = " SELECT * FROM FILE_UPLOAD_EPG WHERE ID_USER = '".$param['iduser']."' AND TOKEN = '".$param['token']."' ";
		//echo $query;die;
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_list_channel($date){
		
		$query = "
		SELECT GROUP_CONCAT(A.CHANNEL SEPARATOR ', ') as CLS,COUNT(A.CHANNEL) SD FROM (
		SELECT * FROM CHANNEL_EPG_CONFIG A
		WHERE A.`STATUS` = 1
		) A LEFT JOIN (
			SELECT CHANNEL,COUNT(*) SD, DATE_FORMAT(START_TIME,'%Y-%d-%d') AS DTS FROM (SELECT * FROM EPG_RAW1_TEST GROUP BY `CHANNEL`,`PROGRAM`,`START_TIME`) ec 
			WHERE START_TIME BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59'
			GROUP BY CHANNEL,DTS
		) B ON A.CHANNEL = B.CHANNEL 
		WHERE B.CHANNEL IS NULL OR SD < 10
		ORDER BY A.CHANNEL
		";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function save_file_channel($params){ 

		$sql 	= "INSERT INTO FILE_UPLOAD_EPG(`FILENAME`,`CHANNEL`,`START_TIME`,END_TIME,UPLOAD_DATE,TOKEN,ID_USER,TOTAL_ROW) 
		VALUES('".$params['FILE_NAME']."','".$params['CHANNEL']."','".$params['START_TIME']."',
		'".$params['END_TIME']."','".$params['UPLOADTIME']."','".$params['TOKEN']."','".$params['USERID']."','".$params['TOT_ROW']."')";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   	

	public function delete_data_epg($lis,$params){ 

		$sql 	= "
		DELETE FROM EPG_RAW1_TEST 
		WHERE CHANNEL = '".$lis['CHANNEL']."'
		AND START_TIME BETWEEN '".$lis['START_TIME']."' AND '".$lis['END_TIME']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   

	public function process_data_epg($lis,$params){ 

		$sql 	= "
		INSERT INTO EPG_RAW1_TEST 
		SELECT CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE FROM EPG_RAW1_TEMP
		WHERE CHANNEL = '".$lis['CHANNEL']."'
		AND START_TIME BETWEEN '".$lis['START_TIME']."' AND '".$lis['END_TIME']."'
		AND TOKEN = '".$params['token']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   	
	
	
	
}	
