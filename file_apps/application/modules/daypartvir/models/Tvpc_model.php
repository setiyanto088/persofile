<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvpc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		 $this->load->library('ClickHouse');
		
	}
  
	public function list_profile($iduser,$idrole,$period) {
 
    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
    
    $query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
    
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function get_week($param){

		 $db = $this->clickhouse->db();

		$query = " SELECT * FROM WEEK_PARAM_DATE WHERE START_DATE = '".$param['start_date']."' AND EMD_DATE = '".$param['end_date']."' ";
	  
		
		$result = $db->select($query);
		return $result->rows();	 

	}

	public function list_channel() {
		
		 $db = $this->clickhouse->db();
		
		$query = " SELECT CHANNEL_NAME_PROG AS channel FROM `CHANNEL_PARAM_FINAL` C
	  GROUP BY CHANNEL_NAME_PROG
	   ORDER BY UPPER(C.`CHANNEL_NAME_PROG`)";
		
		$result = $db->select($query);
		return $result->rows();	 
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
  
  	public function list_tvpc_all($param) {
		
		if($param['datatp'] == 'audience') {
			$huk = 'COUNT(DISTINCT(CARDNO))';
		}elseif($param['datatp'] == 'total_views') {
			$huk = 'SUM(TOTAL_VIEWS)';
		}else{
			$huk = 'SUM(DURATION)';
		}
		
		if($param['daypart'] == 'ALL' ){
			$query = "
			
				SELECT ".$huk." AS VIEWERS FROM 
				CARDNO_DAYPART A JOIN RIS_DAYPART B ON A.DAYPART = B.DAYPART
				WHERE `DATE` BETWEEN '".$param['start_date']."' AND '".$param['end_date']."'
				AND CHANNEL IN (".$param['channel'].")
				GROUP BY A.DAYPART, B.TEXT
				
			";
		}else{
			
			$dt = explode('-',$param['daypart']);
			
			$query = "
			
				SELECT  ".$huk." AS VIEWERS FROM 
				RIS_DAYPART B LEFT JOIN CARDNO_DAYPART A ON A.DAYPART = B.DAYPART
				WHERE `DATE` BETWEEN '".$param['start_date']."' AND '".$param['end_date']."'
				AND CHANNEL IN (".$param['channel'].")
				AND B.BEGIN_TIME BETWEEN '".$dt[0]."' AND '".$dt[1]."'
				
			
				
			";
		}
		$db = $this->clickhouse->db();
		
		
		
		$result = $db->select($param['query_s']);
		
		
		return $result->rows();	 
	}  
  
	public function list_tvpc2($param) {
		
		
		
		if($param['datatp'] == 'audience') {
			$huk = "COUNT(DISTINCT(CARDNO))";
		}elseif($param['datatp'] == 'total_views') {
			$huk = "SUM(TOTAL_VIEWS)";
		}else{
			$huk = "SUM(DURATION)";
		}
		
		if($param['daypart'] == 'ALL' ){
			$query = "
			
				SELECT A.DAYPART, B.TEXT, ".$huk." AS VIEWERS FROM 
				CARDNO_DAYPART A JOIN RIS_DAYPART B ON A.DAYPART = B.DAYPART
				WHERE `DATE` BETWEEN '".$param['start_date']."' AND '".$param['end_date']."'
				AND CHANNEL IN (".$param['channel'].")
				GROUP BY A.DAYPART,B.TEXT
				ORDER BY B.TEXT
				
			";
		}else{
			
			$dt = explode('-',$param['daypart']);
			
			$query = "
			
			SELECT B.DAYPART,A.DAYPART,A.TEXT,IF(VIEWERS IS NULL,0,VIEWERS) VIEWERS FROM RIS_DAYPART A LEFT JOIN (
				SELECT A.DAYPART AS DAYPART, B.TEXT AS TEXT, ".$huk." AS VIEWERS FROM 
				RIS_DAYPART B LEFT JOIN CARDNO_DAYPART A ON A.DAYPART = B.DAYPART
				WHERE `DATE` BETWEEN '".$param['start_date']."' AND '".$param['end_date']."'
				AND CHANNEL IN (".$param['channel'].")
				AND B.BEGIN_TIME BETWEEN '".$dt[0]."' AND '".$dt[1]."'
				GROUP BY A.DAYPART,B.TEXT
			) B ON A.DAYPART = B.DAYPART 
			ORDER BY A.TEXT
				
			";
		}
		
		$db = $this->clickhouse->db();
		
		$out		= array();
		
		
		
		$result = $db->select($query);
		
		
		return $result->rows();	 
	}  
	
	public function list_tvpc3($param) {
		
		if($param['datatp'] == 'audience') {
			$huk = 'COUNT(DISTINCT(CARDNO))';
		}elseif($param['datatp'] == 'total_views') {
			$huk = 'SUM(TOTAL_VIEWS)';
		}else{
			$huk = 'SUM(DURATION)';
		}
		
		if($param['daypart'] == 'ALL' ){
		
			$query = "
				
				SELECT formatDateTime(A.DATE,'%w') AS DAYPART,  ".$huk." AS VIEWERS FROM 
				CARDNO_DAYPART A JOIN RIS_DAYPART B ON A.DAYPART = B.DAYPART
				WHERE `DATE` BETWEEN '".$param['start_date']."' AND '".$param['end_date']."'
				AND CHANNEL IN (".$param['channel'].")
				GROUP BY formatDateTime(A.DATE,'%w')
				ORDER BY ".$huk." DESC
				
			";
		
		}else{
			
			$dt = explode('-',$param['daypart']);
			
			$query = "
				
				SELECT formatDateTime(A.DATE,'%w') AS DAYPART, '.$huk.' AS VIEWERS FROM 
				CARDNO_DAYPART A JOIN RIS_DAYPART B ON A.DAYPART = B.DAYPART
				WHERE `DATE` BETWEEN '".$param['start_date']."' AND '".$param['end_date']."'
				AND CHANNEL IN (".$param['channel'].")
				AND B.BEGIN_TIME BETWEEN '".$dt[0]."' AND '".$dt[1]."'
				GROUP BY formatDateTime(A.DATE,'%w') 
				ORDER BY ".$huk." DESC
				
			";
		}
		
			$db = $this->clickhouse->db();
		
		$out		= array();
		
		
		
		$result = $db->select($query);
		
		
		return $result->rows();	 
	}  
	
	public function list_daypart($userid) {
		$query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$userid.'" AND MENUS="0" ORDER BY DAYPART1 ';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
  
  public function list_channel_genre() {
	  
	  $query = " SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1
      ORDER BY C.`GENRE`";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
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
		
		$sql = 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
		AND BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
		AND END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
		AND TIME_PERIODE = "TVPC" 
		AND PROFILE_ID = '.$params['profile'];
    
	
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();

		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}

		$total_filtered = $this->db->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= count($result);
		
		if(($params['offset']+10) > $total_filtered['ROWS']){
			$limit_data = $total_filtered['ROWS'] - $params['offset']; 
		}else{
			$limit_data = $params['limit'] ;
		}
						
						
						
						$sql2		= 'SELECT 0 AS rank, * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
					AND BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
					AND END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
					AND TIME_PERIODE = "TVPC" 
					AND PROFILE_ID = '.$params['profile'].'
						ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
						LIMIT '.$params['offset'].','.$limit_data;				
    
		$query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();

		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
		
		return $return;
	}

	public function listchart_tvpc($params = array()) {	
				
				
				$sql		= 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
				AND END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
				AND TIME_PERIODE = "TVPC" 
				AND PROFILE_ID = '.$params['profile'].'
				ORDER BY '.$params['cgroup'].' DESC
				LIMIT 4000 ';
						
		$out		= array();
		
		$query		= $this->db->query($sql);
		$result = $query->result_array();
		
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
 
	  
	  $db = $this->clickhouse->db();
	  
      if($strGenre == "0"){
          $strWhere = "AND UPPER(C.`CHANNEL_NAME_PROG`) LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND UPPER(C.`CHANNEL_NAME_PROG`) LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND GENRE = '".$strGenre."' AND UPPER(C.`CHANNEL_NAME_PROG`) LIKE '%".strtoupper($strSearch)."%' ";
      }
      
      $sql = "SELECT CHANNEL_NAME_PROG AS CHANNEL FROM `CHANNEL_PARAM_FINAL` C
      WHERE 1=1 ".$strWhere."  
      GROUP BY C.CHANNEL_NAME_PROG
      ORDER BY UPPER(C.`CHANNEL_NAME_PROG`)";
      $out		= array();
      
	  
	$result = $db->select($sql);
	return $result->rows();	 
	  
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
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":00','0')";
            
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