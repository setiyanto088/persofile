<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvpc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		error_reporting(E_ALL);
	}
  
	public function list_profile($iduser,$idrole,$period) {
                                                               
    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
    
    $query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a JOIN M_MONTH_PROFILE c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
    
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channel() {
     $query = 'SELECT DISTINCT CHANNEL_RC as channel, COLOR FROM CHANNEL_PARAM WHERE F2A_STATUS=1 order by CHANNEL_RC';  			
		$sql	= $this->db->query($query);
		$this->db->close();	
		return $sql->result_array();	   
	}
  
  public function list_channel_col() {
     $query = 'SELECT DISTINCT CHANNEL_RC as channel, COLOR FROM CHANNEL_PARAM WHERE F2A_STATUS=1 order by CHANNEL_RC';			
		$sql	= $this->db->query($query);
		$this->db->close();	
		return $sql->result_array();	   
	}                                            
  
  public function list_daypart($userid) {
		$db = $this->clickhouse->db();
		$query = "SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID='".$userid."' AND MENUS=0 ORDER BY DAYPART1";			
		$result = $db->select($query);
		
		return $result->rows();	   
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
		$query = "SELECT DATE_FORMAT(TVPC_FTA,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
	public function list_tvpc($params = array()) {
    if($params['channel'] == "0"){
        $f = $this->list_channel();
        $cin = "";
    
        foreach($f as $channel_f){
            $cin = $cin."'".$channel_f['channel']."',";
        }
        
        $new_cin = substr($cin, 0, -1);
    } else {
        $new_cin = $params['channel'];
    }
    
 
				
		$sql = 'SELECT `DATE` AS tanggal, CHANNEL AS channel, PROGRAM AS program, LEVEL1 AS genre,START_TIME AS begin_time,
				END_TIME AS end_time, TVS,  TVR,VIEWER AS viewers   
				FROM M_SUMMARY_MEDIA_PLAN_D 
				WHERE CHANNEL IN ('.$new_cin.')
					AND DATE_FORMAT(STR_TO_DATE(DATE, "%d/%m/%Y"),"%Y-%m-%d") BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND START_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
						AND END_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
					AND PROFILE_ID = '.$params['profile'].' 
				';
    
	
 		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();

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
    
    if($limit_data >= 9223372036854775807){
        $strLimit = '';
    } else {
        $strLimit = ' LIMIT '.$params['offset'].','.$limit_data;
    }
    
		$sql2		= 'SELECT 0 AS rank, `DATE` AS tanggal, CHANNEL AS channel, PROGRAM AS program, LEVEL1 AS genre,START_TIME AS begin_time,
				END_TIME AS end_time, TVS,  TVR,VIEWER AS viewers 
				FROM M_SUMMARY_MEDIA_PLAN_D 
				WHERE CHANNEL IN ('.$new_cin.')
					AND DATE_FORMAT(STR_TO_DATE(DATE, "%d/%m/%Y"),"%Y-%m-%d") BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND START_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
						AND END_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
					AND PROFILE_ID = '.$params['profile'].' 
				
						ORDER BY '.$params['order_column'].' '.$params['order_dir'].$strLimit;				
     
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
    if($params['channel'] == "0"){
        $f = $this->list_channel();
        $cin = "";
    
        foreach($f as $channel_f){
            $cin = $cin."'".$channel_f['channel']."',";
        }
        
        $new_cin = substr($cin, 0, -1);
    } else {
        $new_cin = $params['channel'];
    }
    
    $sql		= 'SELECT `DATE` AS tanggal, CHANNEL AS channel, PROGRAM AS program, LEVEL1 AS genre,START_TIME AS begin_time,
				END_TIME AS end_time, TVS*100 as TVS,  TVR*100 as TVR ,VIEWER AS viewers   
				FROM M_SUMMARY_MEDIA_PLAN_D 
				WHERE CHANNEL IN ('.$new_cin.')
					AND DATE_FORMAT(STR_TO_DATE(DATE, "%d/%m/%Y"),"%Y-%m-%d") BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND START_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
						AND END_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
					AND PROFILE_ID = '.$params['profile'].' 
				
            ORDER BY '.$params['cgroup'].' DESC';
 						
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
      
 
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub a JOIN M_MONTH_PROFILE c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }    
    
  public function channelsearch($strSearch,$role){ 
 
      $sql = "SELECT CHANNEL_RC as CHANNEL FROM CHANNEL_PARAM 
      WHERE F2A_STATUS=1 AND CHANNEL_RC LIKE '%".strtoupper($strSearch)."%'   
      ORDER BY CHANNEL_RC";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
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