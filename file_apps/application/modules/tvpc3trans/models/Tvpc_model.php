<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvpc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
  
	public function list_profile($iduser,$idrole,$period) {
    /*
		if ($idrole==18) {
			$query = "SELECT id, `name`, grouping, postbuy_status FROM t_profiling_ub WHERE STATUS = 1 OR STATUS = 3 ";
		} else {
			$query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a INNER JOIN hrd_profile b ON a.user_id_profil=b.id WHERE (STATUS = 1 OR STATUS = 3) AND user_id_profil=".$iduser;
		}	
    */
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
	
	public function list_channel() {
		//$query = 'SELECT CHANNEL_NAME as channel, COLOR FROM CHANNEL_PARAM WHERE F2A_STATUS IN (0,-99) order by CHANNEL_NAME';  	 		
		//$query = 'SELECT CHANNEL_NAME_PROG as channel, COLOR FROM CHANNEL_PARAM_FINAL WHERE FLAG_TV = 1 GROUP BY CHANNEL_NAME_PROG order by CHANNEL_NAME_PROG';  	 		
		$query = 'SELECT CHANNEL as channel,"" COLOR FROM M_SUMMARY_MEDIA_PLAN_D_TRANS  GROUP BY CHANNEL order by CHANNEL';  	 		
		$sql	= $this->db->query($query);
		$this->db->close();	
		return $sql->result_array();	   
	}          
  
  public function list_channel_by_genre($strGenre) {     
    if($strGenre == "0"){
        $strWhere = "";
    } else {
        $strWhere = "AND GENRE = '".$strGenre."' ";
    }
    
		//$query = 'SELECT channel_cim as channel FROM P_CHANNEL_ADS_USEETV WHERE FLAG_TV=1 and CHANNEL_NAME not in ("GTV","RCTI","INEWSTV","RCTI","MNCTV") order by channel ';
    // $query = "SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM` C
      // WHERE C.`F2A_STATUS` IN (0,-99) ".$strWhere."  
      // ORDER BY C.`CHANNEL_NAME`";		

// $query = " SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM_FINAL` C
      // WHERE C.`GENRE_SHOW` = 1 ".$strWhere."  
      // ORDER BY C.`CHANNEL_NAME`";
	  $query = 'SELECT CHANNEL as channel,"" COLOR FROM M_SUMMARY_MEDIA_PLAN_D_TRANS  GROUP BY CHANNEL order by CHANNEL';  	 		
	  
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
		// $query = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      // WHERE C.`F2A_STATUS` IN (0,-99)    
      // ORDER BY C.`GENRE`";
	  
	  $query = " SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1
      ORDER BY C.`GENRE`";
    //print_r($query);			
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
  
	public function list_tvpc_export($params = array()) {
		
			$sql = 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_TRANS A
		JOIN `CHANNEL_PARAM_FINAL` B ON A.`CHANNEL` = B.`CHANNEL_NAME` WHERE B.`CHANNEL_NAME_PROG` IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
		AND (DATE_FORMAT(BEGIN_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
		OR DATE_FORMAT(END_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'" )
		AND TIME_PERIODE = "TVPC" 
		AND PROFILE_ID = '.$params['profile'].'
		ORDER BY VIEWERS DESC';
		
		//echo $sql;die;
		
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
		
		return $result;
	}
		
		
	public function list_tvpc($params = array()) {
		// $sql		= 'SELECT DATE AS tanggal,CHANNEL AS channel, PROGRAM AS program,LEVEL1 AS genre, START_TIME as begin_time,END_TIME as end_time,TVS*100 AS TVS,TVR*100 AS TVR,VIEWER as viewers   FROM M_SUMMARY_MEDIA_PLAN_D 
						// WHERE CHANNEL IN ('.$params['channel'].')
						// AND DATE_FORMAT(STR_TO_DATE(DATE, "%d/%m/%Y"),"%Y-%m-%d") BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						// AND START_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
						// AND END_TIME BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
						// AND PROFILE_ID = '.$params['profile'];
		//print_r($sql); die();
		
		// $sql = 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
		// AND BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
		// AND END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
		// AND TIME_PERIODE = "TVPC" 
		// AND PROFILE_ID = '.$params['profile'];
		
		$sql = 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_TRANS A
		
		WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
		AND (DATE_FORMAT(BEGIN_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
		OR DATE_FORMAT(END_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'" )
		AND TIME_PERIODE = "TVPC" 
		AND PROFILE_ID = '.$params['profile'];
    
   // print_r($sql); die();
	
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();

		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}

		//$total_filtered = $this->db->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
		if(($params['offset']+10) > $total_filtered['ROWS']){
			$limit_data = $total_filtered['ROWS'] - $params['offset']; 
		}else{
			$limit_data = $params['limit'] ;
		}
		$sql2		= 'SELECT  *,0 AS rank FROM M_SUMMARY_MEDIA_PLAN_D_TRANS  A
		WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND (DATE_FORMAT(BEGIN_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
						OR DATE_FORMAT(END_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'" )
					AND TIME_PERIODE = "TVPC" 
					AND PROFILE_ID = '.$params['profile'].'
						ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
						LIMIT '.$params['offset'].','.$limit_data;				
		//print_r($sql2); die();
    
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
			$sql		= 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_TRANS WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
					AND (DATE_FORMAT(BEGIN_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'"
					OR DATE_FORMAT(END_PROGRAM,"%H:%i:%s") BETWEEN "'.$params['starttime'].'" AND "'.$params['endtime'].'" )
				AND TIME_PERIODE = "TVPC" 
				AND PROFILE_ID = '.$params['profile'].'
				ORDER BY '.$params['cgroup'].' DESC
				LIMIT 2000
				';
    //print_r($sql); die();            					
						
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
		//print_r($sql);die;
     
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
      //print_r($sql);
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  } 
  
  public function genresearch($strSearch,$role){ 
      $sql = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` IN (0,-99) AND GENRE LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`GENRE`";               
      //print_r($sql);
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                          
    
  public function channelsearch($strSearch,$strGenre,$role){
      /* 
      $sql = "SELECT CHANNEL_CIM AS CHANNEL FROM `P_CHANNEL_ADS_USEETV` C
      WHERE C.`FLAG_TV` = 1 AND CHANNEL_CIM LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`CHANNEL_NAME`";
      */
      if($strGenre == "0"){
          $strWhere = "AND CHANNEL LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND CHANNEL LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND D.GENRE = '".$strGenre."' AND CHANNEL LIKE '%".strtoupper($strSearch)."%' ";
      }
      
      // $sql = "SELECT CHANNEL_NAME_PROG AS CHANNEL FROM `CHANNEL_PARAM_FINAL` C
      // WHERE C.`FLAG_TV` = 1 ".$strWhere."  
	  // GROUP BY CHANNEL_NAME_PROG
      // ORDER BY C.`CHANNEL_NAME`";\
	  
			  $sql = "SELECT CHANNEL AS CHANNEL, '' COLOR  FROM `M_SUMMARY_TVCC_30_TRANS` C
		  LEFT JOIN CDR_EPG_PARAM_TRANS D ON C.CHANNEL = D.CHANNEL_CDR
		  WHERE 1=1 ".$strWhere."  
		  GROUP BY C.CHANNEL 
		  ORDER BY C.`CHANNEL`";	  	
		
     // print_r($sql);
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }             
  
  public function checkdaypart($user_id,$daypart){ 
      $query 	= "SELECT COUNT(DAYPART1) AS CODAP FROM DAYPART WHERE USERID = '".$user_id."' AND DAYPART1 = '".$daypart."'";
      //print_r($sql);
            
      $sql	= $this->db->query($query);
  		$this->db->close();
  		$this->db->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CODAP'];
  }                                 
  
  public function setdaypart($user_id,$start_time,$end_time){ 
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":00','0')";
      //print_r($sql);
            
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