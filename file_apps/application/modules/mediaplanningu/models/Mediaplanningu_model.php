<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mediaplanningu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
		
	public function get_channel(){

    $sql = "SELECT CHANNEL_RC AS CHANNEL_CIM FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` = 1
      ORDER BY C.`CHANNEL_RC`";
      
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}	
		
	public function get_profile3($iduser,$idrole,$period) {
    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
     
		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a JOIN M_MONTH_PROFILE c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
    
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
		
	public function content_grouping($profile) {
		$query = 'SELECT grouping
				FROM t_profiling
				WHERE id = '.$profile.'
				AND STATUS = 1
        AND flag = 1;';  			
		$sql	= $this->db->query($query,array($profile));
		$this->db->close();
		$this->db->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT DISTINCT(USERID) FROM SINGLE_SOURCE_VALUE "." ".$data;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(MEDIAPLAN_FTA,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
		
	public function list_planning($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		
		if ($hightvr == 1) {
			$order_sort = " TVR DESC";
			$add_where = "";
		}
		
		if ($maxspot == 1) {
			$order_sort = " (RATE * ".$params['discount']." / 100 ) ASC";
			$add_where = "";
		}
		
		if ($mincprp == 1) {
			$order_sort = " CPRP ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/TVR > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
      $where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
    		
		$sql = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + str_replace(",","",$data_pl['RATE_D']*1000);
			
			if($total_cost > $params['cost']){
				break;
			} 
			$cost_count++;
		}
		
		$total_filtered = $cost_count;
		$total 			= count($result);
		
		if(($params['offset']+10) > $cost_count){
			$limit_data = $cost_count - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    
		$sql2		= " SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM 
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$params['offset'].",".$limit_data;
	
		
    $query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();
		
		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered,
			'total' => $total
		);
		
		return $return;
	}
  
	 public function list_planning_sub($params = array()) {					
    $hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 
		
		if ($hightvr == 1) {			
			$order_sort = " TVR DESC";
			$add_where = "";
		}
		
		if ($maxspot == 1) {
			$order_sort = " (RATE * ".$params['discount']." / 100 ) ASC";
			$add_where = "";
		}
		
		if ($mincprp == 1) {
			$order_sort = " CPRP ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/TVR > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		}
		
		if ($params['channel'] == "0") {
			$where_channel = "";
		}else{
      $f = explode(",",$params['channel']);
			$cin = "";
			
			foreach($f as $channel_f){
				
				$cin = $cin."'".$channel_f."',";
				
			}
			$new_cin = substr($cin, 0, -1);
      
			$where_channel = " AND CHANNEL IN (".$new_cin.") ";
		}
				
		$sql = "	SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM 
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
    
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		  if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + str_replace(",","",$data_pl['RATE']*1000);
			
			if($total_cost > $params['cost']){
				break;
			}
			
			$cost_count++;
		}
    							
		$sql3		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
						SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM 
						(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
						WHERE 
						STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
						GROUP BY `DATE`,CHANNEL,PROGRAM 
						ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT 0,".$cost_count." 
					) AS B GROUP BY CHANNEL,PROGRAM
					ORDER BY ".$order_sort;
              
		$query3	= $this->db->query($sql3);
		$result3 = $query3->result_array();
		
		if(($params['offset']+10) > count($result3)){
			$limit_data = count($result3) - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    					
		$sql2		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
							SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX,((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
							WHERE 
							STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
							GROUP BY `DATE`,CHANNEL,PROGRAM 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT 0,".$cost_count." 
						) AS B GROUP BY CHANNEL,PROGRAM
						ORDER BY ".$order_sort." 
						LIMIT ".$params['offset'].",".$limit_data;
    
		$query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();
    
		$total_filtered = count($result3);
		$total 			= count($result3);
		
		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered,
			'total' => $total
		);
		
		return $return;
	}
	
	
	public function list_planning_total($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 
		
    if ($hightvr == 1) {			
			$order_sort = " TVR DESC";
			$add_where = "";
		}
		
		if ($maxspot == 1) {
			$order_sort = " (RATE * ".$params['discount']." / 100 ) ASC";
			$add_where = "";
		}
		
		if ($mincprp == 1) {
			$order_sort = " CPRP ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/TVR > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		}
		
		if ($params['channel'] == "0") {
			$where_channel = "";
		}else{
      $f = explode(",",$params['channel']);
			$cin = "";
			
			foreach($f as $channel_f){
				
				$cin = $cin."'".$channel_f."',";
				
			}
			$new_cin = substr($cin, 0, -1);
      
			$where_channel = " AND CHANNEL IN (".$new_cin.") ";
		}
    
		$sql		=  "SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
			WHERE  
			STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
			GROUP BY `DATE`,CHANNEL,PROGRAM 
			ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
          
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		  if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + str_replace(",","",$data_pl['RATE']*1000);
      
			if($total_cost > $params['cost']){
				break;
			}
			$cost_count++;
		}
		

		$sql3		= "SELECT *, SUM(SPOTS) AS SPOT,SUM(TVR) AS TVRS,SUM(RATE) AS COSTS  FROM ( 
									SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR,IDX, AVG(TVS) AS TVS,1 as SPOTS, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
							WHERE 
							STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
							GROUP BY `DATE`,CHANNEL,PROGRAM 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT 0,".$cost_count." 
				) AS B GROUP BY CHANNEL
				ORDER BY ".$order_sort."
				LIMIT 0,".$cost_count;
            
		$query3	= $this->db->query($sql3);
		$result3 = $query3->result_array();
		
		if(($params['offset']+10) > count($result3)){
			$limit_data = count($result3) - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    					
    $sql2		= "SELECT *, SUM(SPOTS) AS SPOT,SUM(TVR) AS TVRS,SUM(RATE) AS COSTS  FROM ( 
							SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
					WHERE 
					STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
					GROUP BY `DATE`,CHANNEL,PROGRAM 
					ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				LIMIT 0,".$cost_count." 
		) AS B GROUP BY CHANNEL
		ORDER BY ".$order_sort."
		LIMIT ".$params['offset'].",".$limit_data;
    
		$query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();
		$total_filtered = count($result3);
		$total 			= count($result3);
		
		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered,
			'total' => $total
		);
		
		return $return;
	}	
	
	
	public function list_planning_grandtotal($params = array()) {					
    $hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 

		if ($hightvr == 1) {			
			$order_sort = " TVR DESC";
			$add_where = "";
		}
		
		if ($maxspot == 1) {
			$order_sort = " (RATE * ".$params['discount']." / 100 ) ASC";
			$add_where = "";
		}
		
		if ($mincprp == 1) {
			$order_sort = " CPRP ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/TVR > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		}
		
    if ($params['channel'] == "0") {
			$where_channel = "";
		}else{
      $f = explode(",",$params['channel']);
			$cin = "";
			
			foreach($f as $channel_f){			
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);
      
			$where_channel = " AND CHANNEL IN (".$new_cin.") ";
		}
    
		$sql		=  "SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS, IDX,((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
		GROUP BY `DATE`,CHANNEL,PROGRAM 
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
				 
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		  if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + str_replace(",","",$data_pl['RATE']);
			
			if($total_cost >= ($params['cost']/1000)){
				$total_cost = $total_cost - (str_replace(",","",$data_pl['RATE']));
				break;
			}
			$cost_count++;
		} 

    $sql3		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
								SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
								WHERE  
                 RATE <= 200000
								AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
								GROUP BY `DATE`,CHANNEL,PROGRAM 
								ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
								LIMIT 0,".$cost_count." 
							) AS B GROUP BY `DATE`,CHANNEL,PROGRAM
							ORDER BY ".$order_sort;
                  
		$query3	= $this->db->query($sql3);
		$result3 = $query3->result_array();
		
		return $result3;
	}	
	public function list_planning_rest($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		
    if ($hightvr == 1) {			
    	$order_sort = " TVR DESC";
    	$add_where = "";
    }
    
    if ($maxspot == 1) {
    	$order_sort = " (RATE * ".$params['discount']." / 100 ) ASC";
    	$add_where = "";
    }
    
    if ($mincprp == 1) {
    	$order_sort = " CPRP ASC";
    	$add_where = "AND (RATE * ".$params['discount']." / 100 )/TVR > 0 ";
    }
    
    if ($index == 1) {
    	$order_sort = " `IDX` DESC";
			$add_where = " ";
    }
    
    if ($params['channel'] == "0") {
    	$where_channel = "";
    }else{
      $f = explode(",",$params['channel']);
    	$cin = "";
    	
    	foreach($f as $channel_f){				
    		$cin = $cin."'".$channel_f."',";				
    	}
    	$new_cin = substr($cin, 0, -1);
      
    	$where_channel = " AND CHANNEL IN (".$new_cin.") ";
    }
				
    $sql = "SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
				WHERE 
				STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
		
    $out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		  if($l_result = mysqli_store_result($this->db->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + str_replace(",","",$data_pl['RATE']*1000);
      
			if($total_cost > $params['cost']){
				break;
			}
			$cost_count++; 
		}
    	
		$sql3		= "SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM 
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
		GROUP BY `DATE`,CHANNEL,PROGRAM 
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
		LIMIT 0,".$cost_count;
    
		$query3	= $this->db->query($sql3);
		$result3 = $query3->result_array();
    
		return $result3;
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
    
      $sql = "SELECT CHANNEL_RC AS CHANNEL FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` = 1 AND CHANNEL_RC LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`CHANNEL_RC`";
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }
}	