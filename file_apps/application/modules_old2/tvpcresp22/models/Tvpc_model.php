<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvpc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		//$this->db2 = $this->load->database('db_prod', TRUE);
		
	}
  
	public function list_profile($iduser,$idrole,$period) {
 
    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
    
    $query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a JOIN M_MONTH_PROFILE_RES_P22 c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS IN (1,2,3)) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
    
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channel() {

		$db = $this->clickhouse->db();

		 
		$sql = "
			SELECT A.*,B.GENRE, B.COLOR FROM (
 			SELECT DISTINCT(CHANNEL) as channel FROM M_SUMMARY_TVCC_30_RES 
			 order by channel
		 ) A LEFT JOIN CHANNEL_PARAM_FINAL B ON A.channel = B.CHANNEL_NAME 
		 where 1=1 
		 ORDER BY A.channel
		";	  		
	 	
		$query2 = $db->select($sql);
		$result = $query2->rows();	  
		
		return $result;
	}          
  
  public function list_channel_by_genre($strGenre) {     
    if($strGenre == "0"){
        $strWhere = "";
    } else {
        $strWhere = "AND GENRE = '".$strGenre."' ";
    }
 	

$query = " SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1 ".$strWhere."  
      ORDER BY C.`CHANNEL_NAME`";
	  
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}                               
  
  public function list_daypart($userid) {
	  
		$query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$userid.'" AND MENUS="0" ORDER BY DAYPART1 ';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
  
  public function list_channel_genre() {
 
	  $db = $this->clickhouse->db();
	  
	  $query = " SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1
      ORDER BY C.`GENRE`";
 		$sql	= $this->db->query($query);
	 
		$query2 = $db->select($query);
		$result = $query2->rows();	  
		
		return $result;
		
	}
	
	public function content_grouping($profile) {
		$query = 'SELECT grouping
					FROM t_profiling_ub
					WHERE id = '.$profile.'
					AND STATUS = 1;';  			
		$sql	= $this->db->query($query,array($profile));
		$this->db->close();
		$this->db->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT USERID	FROM SINGLE_SOURCE_VALUE"." ".$data;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(TVPC_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
	public function list_tvpc($params = array()) {
		
		$db = $this->clickhouse->db();
		 
		
		$sql = "SELECT * FROM TVPC_RES WHERE CHANNEL IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
		AND (formatDateTime(BEGIN_PROGRAM,'%T') BETWEEN '".$params['starttime']."' AND '".$params['endtime']."'
		OR formatDateTime(END_PROGRAM,'%T') BETWEEN '".$params['starttime']."' AND '".$params['endtime']."' )
		AND PROFILE_ID = ".$params['profile'];
    
 	
		$out		= array();
	 
		
		$query = $db->select($sql);
		$result = $query->rows();	   

		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}

 		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
		if(($params['offset']+10) > $total_filtered['ROWS']){
			$limit_data = $total_filtered['ROWS'] - $params['offset']; 
		}else{
			$limit_data = $params['limit'] ;
		}
		$sql2		= "SELECT  *, 0 AS rank FROM TVPC_RES WHERE CHANNEL IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
						AND (formatDateTime(BEGIN_PROGRAM,'%T') BETWEEN '".$params['starttime']."' AND '".$params['endtime']."'
						OR formatDateTime(END_PROGRAM,'%T') BETWEEN '".$params['starttime']."' AND '".$params['endtime']."' )
					AND PROFILE_ID = ".$params['profile']."
						ORDER BY ".$params['order_column']." ".$params['order_dir']."
						LIMIT ".$params['offset'].','.$limit_data;				
 
		
		$query2 = $db->select($sql2);
		$result2 = $query2->rows();	  

		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
		
		return $return;
	}

	public function listchart_tvpc($params = array()) {	
	
		$db = $this->clickhouse->db();
	
 
				
				IF($params['starttime'] == 'alltime'){
					$sql = "SELECT * FROM TVPC_RES WHERE CHANNEL IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
					AND PROFILE_ID = ".$params['profile']."
					ORDER BY ".$params['cgroup']." DESC
				LIMIT 2000
		";
				}ELSE{
					$sql = "SELECT * FROM TVPC_RES WHERE CHANNEL IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
					AND (formatDateTime(BEGIN_PROGRAM,'%T') BETWEEN '".$params['starttime']."' AND '".$params['endtime']."'
					OR formatDateTime(END_PROGRAM,'%T') BETWEEN '".$params['starttime']."' AND '".$params['endtime']."' )
					AND PROFILE_ID = ".$params['profile']."
					ORDER BY ".$params['cgroup']." DESC
							LIMIT 2000
					";
				}
				
				
				
 						
		$out		= array();
 
		
		$query2 = $db->select($sql);
		$result = $query2->rows();	  
		
		return $result;
	}
  
	public function list_tvpc_allviwers($params = array()) {	
		$sql = 'SELECT 
								SQL_CALC_FOUND_ROWS 
									
								COUNT(DISTINCT pm.USER_ID) AS all_viewers
							      FROM t_people_meter AS pm , t_epg AS epg
							      WHERE epg.channel = pm.channel
									DATE_FORMAT(epg.tanggal, "%Y-%m-%d") BETWEEN CAST("'.$params['start_date'].'" AS DATE) AND CAST("'.$params['end_date'].'" AS DATE)
									AND epg.date = DATE_FORMAT(pm.begin_session, "%Y-%m-%d")
									AND epg.user_id "'.$params['profile'].'"
									
							GROUP BY epg.start_time
							ORDER BY epg.start_time ASC';
      
		$out		= array();
		$query		= $this->db->query($sql,
			array(
				$params['limit'],
				$params['offset'],
				$params['order_column'],
				$params['order_dir'],
				$params['filter'],
				$params['start_date'],
				$params['end_date']
			));
    $result = $query->result_array();
    
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		$total_filtered = $this->db->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= $this->db->query('SELECT COUNT(a.id) as total
											FROM t_people_meter a')->row_array();
		
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total['total'],
		);
		
		return $return;
	}
	
	public function universe($profile) {
		$query = "SELECT COUNT(pm.USER_ID) AS universe 
				FROM t_people_meter AS pm 
				WHERE pm.user_id"." ".$profile;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	
  }                                 
    
  public function profilesearch($strSearch,$iduser,$period){
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1]; 
      }
            
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  } 
  
  public function genresearch($strSearch,$role){ 
      $sql = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` IN (0,-99) AND GENRE LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`GENRE`";               
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                          
    
  public function channelsearch($strSearch,$strGenre,$role){
    
      if($strGenre == "0"){
          $strWhere = "AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND GENRE = '".$strGenre."' AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }
	  
	  $db = $this->clickhouse->db();
      
      $sql = "SELECT CHANNEL_NAME AS CHANNEL FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` IN (0,-99) ".$strWhere."  
      ORDER BY C.`CHANNEL_NAME`";
       $out		= array();
    
	  
	  $query2 = $db->select($sql);
		$result = $query2->rows();	  
		
		return $result;
  }             
  
  public function checkdaypart($user_id,$daypart){ 
      $query 	= "SELECT COUNT(DAYPART1) AS CODAP FROM DAYPART WHERE USERID = '".$user_id."' AND DAYPART1 = '".$daypart."'";
             
      $sql	= $this->db->query($query);
  		$this->db->close();
  		$this->db->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CODAP'];
  }                                 
  
  public function setdaypart($user_id,$start_time,$end_time){ 
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":59','0')";
             
      if ($sql) {
          $this->db->query($sql);
          
          $query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$user_id.'" AND MENUS="0" ORDER BY DAYPART1 ';			
      		$sql	= $this->db->query($query);
      		$this->db->close();
      		$this->db->initialize(); 
      		return $sql->result_array();	
      } 
      else {
          return false;
      }
  }
}	