<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mediaplanningu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db_prod', TRUE);
		
	}
		
	public function get_channel(){
		
		$sql = "SELECT CHANNEL FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
		GROUP BY CHANNEL";
    
      
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
			
		return $result;
	}		
	
	public function get_profile($params){
		
		$sql = "SELECT * FROM t_profiling_ub_res WHERE id = '".$params['profiles']."' ";
    
      
		$out		= array();
		$query		= $this->db2->query($sql);
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
     
		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a JOIN M_MONTH_PROFILE_RES_P22 c ON a.`id` = c.`PROFILE_ID` WHERE STATUS IN(1,2,3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
    
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
		
	public function content_grouping($profile) {
		$query = 'SELECT grouping
				FROM t_profiling
				WHERE id = '.$profile.'
				AND STATUS = 1
        AND flag = 1;';  			
		$sql	= $this->db2->query($query,array($profile));
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT DISTINCT(USERID) FROM SINGLE_SOURCE_VALUE "." ".$data;
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	   
	}	
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(MEDIAPLAN_FTA,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db2->query($query); 
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	   
	}
	
	
	
	public function list_ads($params,$array_summ2ggg){
		
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
      $where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
		
		$query = " 
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV,
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." 
							AND CHANNEL = '".$array_summ2ggg['CHANNEL']."' AND PROGRAM = '".$array_summ2ggg['PROGRAM']."'
							AND `TYPE` = '".$array_summ2ggg['ADSTYPE']."' ORDER BY TVR DESC
							LIMIT 0,".$array_summ2ggg['SPOT']."
						
				";
				
				
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
		
	}	
	
	public function get_audience_ads($params){
		
		
		$start_date = explode('/',$params['start_date_ads']);

		$end_date = explode('/',$params['end_date_ads']);

		
		$get_profile = $this->get_profile_id($params['profiles']);
		
		if($params['profiles'] == 0){
		
			$query = " 
					SELECT SUM(WEIGHT) AUDIENCE FROM (
					SELECT `GENDER`,`WEIGHT`,`WEIGHT_ALL` FROM `CDR_EPG_RES_ALL_STEP2_2021` A
					WHERE `BEGIN_PROGRAM` BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' AND '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
					GROUP BY `RESPID`
					) OP
						
				";
				
		}else{
			
			if($get_profile[0]['flag'] == '1'){
				$tbl_m = 'CDR_EPG_RES_ALL_STEP2_2021';
			}else{
				$tbl_m = 'CDR_EPG_RES_ALL_STEP2';
			}
			
				$query = " 
					SELECT SUM(WEIGHT) AUDIENCE FROM (
					SELECT A.`GENDER`,A.`WEIGHT`,A.`WEIGHT_ALL` FROM `".$tbl_m."` A
					JOIN `PROFILE_CARDNO_RES` B ON A.RESPID = B.`CARDNO`
					WHERE `BEGIN_PROGRAM` BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' AND '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
					AND B.`ID_PROFILE` = ".$params['profiles']."
					GROUP BY `RESPID`
					) OP
						
				";
			
		}
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
		
	}	
	
	public function get_profile_id($id_profile){
		
		$query = "SELECT * FROM t_profiling_ub_res WHERE id = '".$id_profile."' ";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}	
	
	
	public function get_audience($params){
		
		
			$start_date = explode('/',$params['start_date']);

		$end_date = explode('/',$params['end_date']);

		
		if($params['profiles'] == 0){
		
			$query = " 
					SELECT SUM(WEIGHT) AUDIENCE FROM (
					SELECT `GENDER`,`WEIGHT`,`WEIGHT_ALL` FROM `CDR_EPG_RES_ALL_STEP2_2021` A
					WHERE `BEGIN_PROGRAM` BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' AND '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
					GROUP BY `RESPID`
					) OP
						
				";
				
		}else{
			
				$query = " 
					SELECT SUM(WEIGHT) AUDIENCE FROM (
					SELECT A.`GENDER`,A.`WEIGHT`,A.`WEIGHT_ALL` FROM `CDR_EPG_RES_ALL_STEP2_2021` A
					JOIN `PROFILE_CARDNO_RES` B ON A.RESPID = B.`CARDNO`
					WHERE `BEGIN_PROGRAM` BETWEEN '".$start_date[2]."-".$start_date[1]."-".$start_date[0]." 00:00:00' AND '".$end_date[2]."-".$end_date[1]."-".$end_date[0]." 23:59:59'
					AND B.`ID_PROFILE` = ".$params['profiles']."
					GROUP BY `RESPID`
					) OP
						
				";
			
		}
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
		
	}
	
	public function list_ads_ext($params,$array_summ2ggg){
		
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
			$where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
		
		$query = " 
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP,
							((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV,							
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." 
							AND CHANNEL = '".$array_summ2ggg['CHANNEL']."' AND PROGRAM = '".$array_summ2ggg['PROGRAM']."' AND RATE = ".$array_summ2ggg['RATE']."
							AND `TYPE` = '".$array_summ2ggg['ADSTYPE']."' ORDER BY TVR DESC
							LIMIT ".$array_summ2ggg['SPOT'].",1
						
				";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
		
	}
	
	public function list_ads_ext2($params,$channel,$rate,$cnt_array,$program){
		
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = ""; 
		} else {
      $where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
		
		$query = " 
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV,
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  AND RATE = ".$rate."
							AND CHANNEL = '".$channel."' AND PROGRAM NOT IN (".$program.")
							ORDER BY TVR DESC
							LIMIT 0,".$cnt_array." 
						
				";
				
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
		
	}
	
public function print_list_planning_cal($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
      $where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
	
	
				
				
		$sql_ads = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db2->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result_ads);
			}
		}
		
		$total_cost_ads = 0;
		$cost_count_ads = 0;
		foreach($result_ads as $data_pl_ads){
			$total_cost_ads = $total_cost_ads + intval(str_replace(",","",$data_pl_ads['RATE_D']*1000));
			
			if($total_cost_ads > $params['cost']){
				break;
			} 
			$cost_count_ads++;
		}
		
		$total_filtered_ads = $cost_count_ads;
		$total_ads 			= count($result_ads);
		
			$limit_data_ads = $cost_count_ads ;
    
	
	
		$sql2_ads		= " SELECT VIEWER,CHANNEL,PROGRAM,`TYPE` FROM ( SELECT VIEWER, COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM M_SUMMARY_MEDIA_PLAN_D_NEW A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data_ads." ) P GROUP BY CHANNEL,PROGRAM,`TYPE` ";
	
	
	
    		
				
				$sql = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE_D']*1000));
			
			if($total_cost > $params['cost']){
				break;
			} 
			$cost_count++;
		}
		
		$total_filtered = $cost_count;
		$total 			= count($result);
		
			$limit_data = $cost_count ;
    
	
	$sql2		= " 
	SELECT * FROM (
	SELECT COLOR,VIEWER,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data."
	)OP ORDER BY `DATE`, START_TIME
	";
	
		
    $query2		= $this->db2->query($sql2);
		$result2 = $query2->result_array();
		
		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered,
			'total' => $total
		);
		
		return $return;
	}

	public function list_planning_cal($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
      $where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
	
	
				
				
		$sql_ads = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db2->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result_ads);
			}
		}
		
		$total_cost_ads = 0;
		$cost_count_ads = 0;
		foreach($result_ads as $data_pl_ads){
			$total_cost_ads = $total_cost_ads + intval(str_replace(",","",$data_pl_ads['RATE_D']*1000));
			
			if($total_cost_ads > $params['cost']){
				break;
			} 
			$cost_count_ads++;
		}
		
		$total_filtered_ads = $cost_count_ads;
		$total_ads 			= count($result_ads);
		
			$limit_data_ads = $cost_count_ads ;
    
	
	
		$sql2_ads		= " SELECT VIEWER,CHANNEL,PROGRAM,`TYPE` FROM ( SELECT VIEWER,COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM M_SUMMARY_MEDIA_PLAN_D_NEW A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data_ads." ) P GROUP BY CHANNEL,PROGRAM,`TYPE` ";
	
	
	
    		
				
				$sql = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE_D']*1000));
			
			if($total_cost > $params['cost']){
				break;
			} 
			$cost_count++;
		}
		
		$total_filtered = $cost_count;
		$total 			= count($result);
		
			$limit_data = $cost_count ;
    
	
	$sql2		= " SELECT VIEWER,COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data;
	
		
    $query2		= $this->db2->query($sql2);
		$result2 = $query2->result_array();
		
		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered,
			'total' => $total
		);
		
		return $return;
	}
		
		
	public function get_epg($params = array(),$array_epg_channel_v) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		

		$where_channel = " AND CHANNEL_NAME IN (".$array_epg_channel_v.") ";


				
				$sql = "  	SELECT DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') AS DATESF,
							DATE_FORMAT(BEGIN_PROGRAM,'%d/%m/%Y') AS DATES,
							DATE_FORMAT(BEGIN_PROGRAM,'%H:%i:%s') AS START_DATES,
							DATE_FORMAT(END_PROGRAM,'%H:%i:%s') AS END_DATES,
							SEC_TO_TIME(TIMESTAMPDIFF(SECOND,BEGIN_PROGRAM,END_PROGRAM)) AS DURATION,
							A.*,`CHANNEL_NAME_PROG` FROM EPG_CLEAN A 
							JOIN `CDR_EPG_PARAM` B ON A.CHANNEL = B.`CHANNEL_EPG`
							JOIN `CHANNEL_PARAM_FINAL` C ON B.`CHANNEL_CDR` = C.`CHANNEL_NAME` WHERE 
							BEGIN_PROGRAM BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y') ".$where_channel." 
							ORDER BY CHANNEL,BEGIN_PROGRAM
				";
	
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
		

		
		return $result;
	}
	
	public function list_planning_ads_channel($params = array(),$channel) {	
	
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
			$where_channel = " AND CHANNEL ='".$channel['CHANNEL']."' ";
		}
		
		$sql = "  SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,DATE_FORMAT(STR_TO_DATE(`DATE`, '%d/%m/%Y') , '%Y-%m-%d')  DATE ,`CHANNEL`,`PROGRAM`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`,`TVS_A`,`IDX_A`,`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
						) PO 
						ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT ".$channel['SPOT']."
				";
	
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
    
		return $result;
	
	}
	
	public function list_planning_ads($params = array(),$day_diff) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
			$where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
    		
				
				
				$sql = "  SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,DATE_FORMAT(STR_TO_DATE(`DATE`, '%d/%m/%Y') , '%Y-%m-%d')  DATE ,`CHANNEL`,`PROGRAM`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`,`TVS_A`,`IDX_A`,`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
						) PO 
						ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
	
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
		
		
			
		
		
    
	
		
		
		
		return $result;
	}
		
		
	public function list_planning($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
			$where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
    		
				
				
				$sql = "  
				SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
						) PO 
						ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
		
		
			
		
		
    
	
		
		
		
		return $result;
	}
	
	public function list_planning_reach_adsn($params = array(),$limit,$profile_data) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		$start_date_r = DateTime::createFromFormat('d/m/Y', $params['start_date_ads'])->format('Y-m-d');
		$end_date_r = DateTime::createFromFormat('d/m/Y', $params['end_date_ads'])->format('Y-m-d');
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
			$where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
 				
				if($params['profiles'] == 0 ){
				
					$sql = "  
					SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
							SELECT RESPID,WEIGHT,UNIVERSE_A FROM 
							(
									SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
									SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
									((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
									((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
									WHERE PROFILE_ID = ".$params['profiles']."
									AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
									AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
								) PO 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT ".$limit."
							) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
							ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
							GROUP BY RESPID
							
					) AS FD
					";
					 
				}elseif($params['profiles'] == 1){
				
					$sql = "  
					SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
							SELECT RESPID,WEIGHT,UNIVERSE_A FROM 
							(
									SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
									SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
									((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
									((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
									WHERE PROFILE_ID = ".$params['profiles']."
									AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
									AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
								) PO 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT ".$limit."
							) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2022` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
							ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
							GROUP BY RESPID
							
					) AS FD
					";
				 
				}else{
					
					if($profile_data[0]['flag'] == 2){
						$sql = "  
						SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
								SELECT RESPID,A.WEIGHT,UNIVERSE_A FROM 
								(
										SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
										SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
										((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
										((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
										WHERE PROFILE_ID = ".$params['profiles']."
										AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
										AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
									) PO 
								ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
								LIMIT ".$limit."
								) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2022` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
								ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
								JOIN `PROFILE_CARDNO_RES` C ON A.RESPID = C.`CARDNO`
								WHERE `ID_PROFILE` = ".$params['profiles']."
								GROUP BY RESPID
								
						) AS FD
						";
					}else{
						$sql = "  
						SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
								SELECT RESPID,A.WEIGHT,UNIVERSE_A FROM 
								(
										SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
										SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
										((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
										((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
										WHERE PROFILE_ID = ".$params['profiles']."
										AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
										AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
									) PO 
								ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
								LIMIT ".$limit."
								) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
								ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
								JOIN `PROFILE_CARDNO_RES` C ON A.RESPID = C.`CARDNO`
								WHERE `ID_PROFILE` = ".$params['profiles']."
								GROUP BY RESPID
								
						) AS FD
						";
					}
					
					
					
				}
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
		
		
		return $result;
	}
	
	public function list_planning_reach($params = array(),$limit,$profile_data) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$mincpv = $params['minimum_cpv'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		$start_date_r = DateTime::createFromFormat('d/m/Y', $params['start_date'])->format('Y-m-d');
		$end_date_r = DateTime::createFromFormat('d/m/Y', $params['end_date'])->format('Y-m-d');
		
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
		
		if ($mincpv == 1) {
			$order_sort = " CPV ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/VIEWER > 0 ";
		}
		
		if ($index == 1) {
			$order_sort = " `IDX` DESC";
			$add_where = " ";
		} 
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = "";
		} else {
			$where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
    
 				
				if($params['profiles'] == 0 ){
				
					$sql = "  
					SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
							SELECT RESPID,WEIGHT,UNIVERSE_A FROM 
							(
									SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
									SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
									((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
									((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
									WHERE PROFILE_ID = ".$params['profiles']."
									AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  
									AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
								) PO 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT ".$limit."
							) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
							ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
							GROUP BY RESPID
							
					) AS FD
					";
					 
				}elseif($params['profiles'] == 1){
				
					$sql = "  
					SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
							SELECT RESPID,WEIGHT,UNIVERSE_A FROM 
							(
									SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
									SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
									((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
									((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
									WHERE PROFILE_ID = ".$params['profiles']."
									AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  
									AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
								) PO 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT ".$limit."
							) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2022` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
							ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
							GROUP BY RESPID
							
					) AS FD
					";
				 
				}else{
					
					if($profile_data[0]['flag'] == 2){
						$sql = "  
						SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
								SELECT RESPID,A.WEIGHT,UNIVERSE_A FROM 
								(
										SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
										SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
										((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
										((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
										WHERE PROFILE_ID = ".$params['profiles']."
										AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  
										AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
									) PO 
								ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
								LIMIT ".$limit."
								) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2022` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
								ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
								JOIN `PROFILE_CARDNO_RES` C ON A.RESPID = C.`CARDNO`
								WHERE `ID_PROFILE` = ".$params['profiles']."
								GROUP BY RESPID
								
						) AS FD
						";
					}else{
						$sql = "  
						SELECT (SUM(WEIGHT)/UNIVERSE_A)*100 AS REACH_S FROM (
								SELECT RESPID,A.WEIGHT,UNIVERSE_A FROM 
								(
										SELECT RANK() OVER (ORDER BY REACH ASC) AS RANK, * FROM (
										SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
										((RATE * ".$params['discount']." / 100 )*1000)/VIEWER AS CPV, 
										((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
										WHERE PROFILE_ID = ".$params['profiles']."
										AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  
										AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
									) PO 
								ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
								LIMIT ".$limit."
								) B LEFT JOIN (SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021` WHERE BEGIN_PROGRAM BETWEEN '".$start_date_r." 00:00:00' AND '".$end_date_r." 23:59:59') A 
								ON A.CHANNEL = B.CHANNEL AND A.PROGRAM =B.PROGRAM AND CONCAT(STR_TO_DATE(DATE, '%d/%m/%Y'),' ',START_TIME) BETWEEN A.BEGIN_PROGRAM AND A.END_PROGRAM
								JOIN `PROFILE_CARDNO_RES` C ON A.RESPID = C.`CARDNO`
								WHERE `ID_PROFILE` = ".$params['profiles']."
								GROUP BY RESPID
								
						) AS FD
						";
					}
					
					
					
				}
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
		
		
		return $result;
	}
	
	public function list_planning_reach_ads($params = array(),$limit,$array_date_reach,$array_epg_channel_v,$profile_data) {					
	

			$where_channel = " AND CHANNEL IN (".$array_epg_channel_v.") ";
		
    
 				
				if($params['profiles'] == 0 ){
				
				$sql = "  
				SELECT (SUM(WEIGHT)/17328363)*100 AS REACH_S FROM (
						SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021` 
						WHERE BEGIN_PROGRAM BETWEEN '".$array_date_reach['start']." 00:00:00' AND '".$array_date_reach['end']." 23:59:59' 
						".$where_channel."
						GROUP BY RESPID
						
				) AS FD
				";
				
				}elseif($params['profiles'] == 1 ){
				
				$sql = "  
				SELECT (SUM(WEIGHT)/19479194)*100 AS REACH_S FROM (
						SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2022` 
						WHERE BEGIN_PROGRAM BETWEEN '".$array_date_reach['start']." 00:00:00' AND '".$array_date_reach['end']." 23:59:59' 
						".$where_channel."
						GROUP BY RESPID
						
				) AS FD
				";
				
				}else{
					
					if($profile_data[0]['flag'] == 2){
					
						$sql = "  
						
							SELECT (SUM(WEIGHT)/".$profile_data[0]['respondents_all'].")*100 AS REACH_S FROM (
								SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2022` A
								JOIN `PROFILE_CARDNO_RES` C ON A.RESPID = C.`CARDNO`
								WHERE `ID_PROFILE` = ".$params['profiles']." 
								AND BEGIN_PROGRAM BETWEEN '".$array_date_reach['start']." 00:00:00' AND '".$array_date_reach['end']." 23:59:59' 
								".$where_channel."
								GROUP BY RESPID
								
							) AS FD
						
						";
				
					}else{
						
						$sql = "  
						
							SELECT (SUM(WEIGHT)/".$profile_data[0]['respondents_all'].")*100 AS REACH_S FROM (
								SELECT * FROM `CDR_EPG_RES_ALL_STEP2_2021` A
								JOIN `PROFILE_CARDNO_RES` C ON A.RESPID = C.`CARDNO`
								WHERE `ID_PROFILE` = ".$params['profiles']." 
								AND BEGIN_PROGRAM BETWEEN '".$array_date_reach['start']." 00:00:00' AND '".$array_date_reach['end']." 23:59:59' 
								".$where_channel."
								GROUP BY RESPID
								
							) AS FD
						
						";
						
					}
					
				}
				
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array(); 
		
		
		return $result;
	}
	
	public function list_ads_ext3($params,$channel,$rate,$cnt_array,$program){
		
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
		} 
    
		if ($params['channel'] == "0") {
			$where_channel = ""; 
		} else {
      $where_channel = " AND CHANNEL IN (".$params['channel'].") ";
		}
		
		$query = " 
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES_P
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y') AND `TYPE` IS NOT NULL AND RATE > 0 ".$add_where."  
							AND CHANNEL = '".$channel."' AND PROGRAM NOT IN (".$program.")
							ORDER BY TVR DESC
							LIMIT 0,".$cnt_array." 
						
				";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
		
	}

	 public function list_planning_sub_mp($params = array()) {					
    $hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 
	$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
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
		
		
	
	
		$sql_ads = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db2->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result_ads);
			}
		}
		
		$total_cost_ads = 0;
		$cost_count_ads = 0;
		foreach($result_ads as $data_pl_ads){
			$total_cost_ads = $total_cost_ads + intval(str_replace(",","",$data_pl_ads['RATE_D']*1000));
			
			if($total_cost_ads > $params['cost']){
				break;
			} 
			$cost_count_ads++;
		}
		
		$total_filtered_ads = $cost_count_ads;
		$total_ads 			= count($result_ads);
		
			$limit_data_ads = $cost_count_ads ;
    
	
	$sql2_ads		= " SELECT VIEWER,CHANNEL,PROGRAM,`TYPE` FROM ( SELECT VIEWER,COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM M_SUMMARY_MEDIA_PLAN_D_NEW A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data_ads." ) P GROUP BY CHANNEL,PROGRAM,`TYPE` ";
	
	
		
				
		$sql = "	SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
    
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE']*1000));
			
			if($total_cost > $params['cost']){
				break;
			}
			
			$cost_count++;
		}
    							
		$sql3		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
						SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,`TYPE`,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM 
						(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
						WHERE 
						STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
						GROUP BY `DATE`,CHANNEL,PROGRAM 
						ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT 0,".$cost_count." 
					) AS B GROUP BY CHANNEL,PROGRAM,`TYPE`
					ORDER BY ".$order_sort;
              
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
		
		if(($params['offset']+10) > count($result3)){
			$limit_data = count($result3) - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    					
		$sql2		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
							SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,`TYPE`,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX,((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
							WHERE 
							STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
							GROUP BY `DATE`,CHANNEL,PROGRAM 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT 0,".$cost_count." 
						) AS B GROUP BY CHANNEL,PROGRAM,`TYPE`
						ORDER BY ".$order_sort." 
						LIMIT ".$params['offset'].",".$limit_data;
    
		$query2		= $this->db2->query($sql2);
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
  
	 public function list_planning_sub($params = array()) {					
    $hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 
	$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
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
				
		$sql = "	SELECT `DATE`,VIEWER,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
    
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE']*1000));
			
			if($total_cost > $params['cost']){
				break;
			}
			
			$cost_count++;
		}
    							
		$sql3		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
						SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,`TYPE`,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM 
						(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
						WHERE 
						STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
						GROUP BY `DATE`,CHANNEL,PROGRAM 
						ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT 0,".$cost_count." 
					) AS B GROUP BY CHANNEL,PROGRAM,`TYPE`
					ORDER BY ".$order_sort;
              
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
		
		if(($params['offset']+10) > count($result3)){
			$limit_data = count($result3) - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    					
		$sql2		= "SELECT *, SUM(SPOTS) AS SPOT FROM (
							SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,`TYPE`,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX,((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
							WHERE 
							STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
							GROUP BY `DATE`,CHANNEL,PROGRAM 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
							LIMIT 0,".$cost_count." 
						) AS B GROUP BY CHANNEL,PROGRAM,`TYPE`
						ORDER BY ".$order_sort." 
						LIMIT ".$params['offset'].",".$limit_data;
    
		$query2		= $this->db2->query($sql2);
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
	$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
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
    
		$sql		=  "SELECT VIEWER,`DATE`,`TYPE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
			WHERE  
			STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
			GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
			ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
          
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE']*1000));
      
			if($total_cost > $params['cost']){
				break;
			}
			$cost_count++;
		}
		

		$sql3		= "SELECT *, SUM(SPOTS) AS SPOT,SUM(TVR) AS TVRS,SUM(RATE) AS COSTS  FROM ( 
									SELECT VIEWER,`DATE`,`TYPE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR,IDX, AVG(TVS) AS TVS,1 as SPOTS, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
							WHERE 
							STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
							GROUP BY `DATE`,CHANNEL,PROGRAM 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT 0,".$cost_count." 
				) AS B GROUP BY CHANNEL,`TYPE`
				ORDER BY ".$order_sort."
				LIMIT 0,".$cost_count;
            
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
		
		if(($params['offset']+10) > count($result3)){
			$limit_data = count($result3) - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    					
    $sql2		= "SELECT *, SUM(SPOTS) AS SPOT,SUM(TVR) AS TVRS,SUM(RATE) AS COSTS  FROM ( 
							SELECT VIEWER,`DATE`,`TYPE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
					WHERE 
					STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
					GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
					ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				LIMIT 0,".$cost_count." 
		) AS B GROUP BY CHANNEL,`TYPE`
		ORDER BY ".$order_sort."
		LIMIT ".$params['offset'].",".$limit_data;
    
		$query2		= $this->db2->query($sql2);
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
	
	public function list_planning_total_ads($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 
	$maximum_reach = $params['maximum_reach'];  
		
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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
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
    
	
	
	
				
				$sql_ads = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db2->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result_ads);
			}
		}
		
		$total_cost_ads = 0;
		$cost_count_ads = 0;
		foreach($result_ads as $data_pl_ads){
			$total_cost_ads = $total_cost_ads + intval(str_replace(",","",$data_pl_ads['RATE_D']*1000));
			
			if($total_cost_ads > $params['cost']){
				break;
			} 
			$cost_count_ads++;
		}
		
		$total_filtered_ads = $cost_count_ads;
		$total_ads 			= count($result_ads);
		
			$limit_data_ads = $cost_count_ads ;
    
	
	$sql2_ads		= " SELECT VIEWER,CHANNEL,PROGRAM,`TYPE` FROM ( SELECT VIEWER,COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM M_SUMMARY_MEDIA_PLAN_D_NEW A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']."  
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data_ads." ) P GROUP BY CHANNEL,PROGRAM,`TYPE` ";
	
	
	
	
		$sql		=  "SELECT VIEWER,`DATE`,`TYPE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
			WHERE  
			STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
			GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
			ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
          
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE']*1000));
      
			if($total_cost > $params['cost']){
				break;
			}
			$cost_count++;
		}
		

		$sql3		= "SELECT *, SUM(SPOTS) AS SPOT,SUM(TVR) AS TVRS,SUM(RATE) AS COSTS  FROM ( 
									SELECT VIEWER,`DATE`,`TYPE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR,IDX, AVG(TVS) AS TVS,1 as SPOTS, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
							WHERE 
							STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
							GROUP BY `DATE`,CHANNEL,PROGRAM 
							ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
						LIMIT 0,".$cost_count." 
				) AS B GROUP BY CHANNEL,`TYPE`
				ORDER BY ".$order_sort."
				LIMIT 0,".$cost_count;
            
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
		
		if(($params['offset']+10) > count($result3)){
			$limit_data = count($result3) - $params['offset'];
		}else{
			$limit_data = $params['limit'] ;
		}
    					
    $sql2		= "SELECT *, SUM(SPOTS) AS SPOT,SUM(TVR) AS TVRS,SUM(RATE) AS COSTS  FROM ( 
							SELECT VIEWER,`DATE`,`TYPE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH   FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
					WHERE 
					STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
					GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
					ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				LIMIT 0,".$cost_count."  
		) AS B GROUP BY CHANNEL,`TYPE`
		ORDER BY ".$order_sort."
		LIMIT ".$params['offset'].",".$limit_data;
    
		$query2		= $this->db2->query($sql2);
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
	$maximum_reach = $params['maximum_reach'];  

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
		
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER  > 0 ";
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
    
		$sql		=  "SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
				 
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
	foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE_D']*1000));
			
			if($total_cost > $params['cost']){
				break;
			} 
			$cost_count++;
		}

    $sql3		= " SELECT  1 as SPOT,VIEWER, `DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT 0,".$cost_count;
                  
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
		
		return $result3;
	}
	
	public function list_planning_grandtotal_ads($params = array()) {					
    $hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
    $index = $params['index']; 
	$maximum_reach = $params['maximum_reach'];  

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
		
			if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER  > 0 ";
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
		
		
	
	
				
				$sql_ads = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db2->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result_ads);
			}
		}
		
		$total_cost_ads = 0;
		$cost_count_ads = 0;
		foreach($result_ads as $data_pl_ads){
			$total_cost_ads = $total_cost_ads + intval(str_replace(",","",$data_pl_ads['RATE_D']*1000));
			
			if($total_cost_ads > $params['cost']){
				break;
			} 
			$cost_count_ads++;
		}
		
		$total_filtered_ads = $cost_count_ads;
		$total_ads 			= count($result_ads);
		
			$limit_data_ads = $cost_count_ads ;
    
	
	$sql2_ads		= " SELECT VIEWER,CHANNEL,PROGRAM,`TYPE` FROM ( SELECT VIEWER,COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM M_SUMMARY_MEDIA_PLAN_D_NEW A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data_ads." ) P GROUP BY CHANNEL,PROGRAM,`TYPE` ";
	
	
		
    
		$sql		=  "SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM  
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
				 
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
	foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE_D']*1000));
			
			if($total_cost > $params['cost']){
				break;
			} 
			$cost_count++;
		}

    $sql3		= " SELECT  1 as SPOT,VIEWER, `DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT 0,".$cost_count;
                  
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
		
		return $result3;
	}	
	public function list_planning_rest($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
	
		if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
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
				
    $sql = "SELECT `DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE 
				STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
		
    $out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE']*1000));
      
			if($total_cost > $params['cost']){
				break;
			}
			$cost_count++; 
		}
    	
		$sql3		= "SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
		LIMIT 0,".$cost_count;
    
		$query3	= $this->db2->query($sql3);
		$result3 = $query3->result_array();
    
		return $result3;
	}	
	
	public function list_planning_rest_ads($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
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
	
	if ($maximum_reach == 1) {
			$order_sort = " `REACH` ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 ) / VIEWER > 0 ";
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
	

	
	
				
			$sql_ads = " SELECT *,(RATE * ".$params['discount']." / 100 ) as RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM 
				(
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db2->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result_ads);
			}
		}
		
		$total_cost_ads = 0;
		$cost_count_ads = 0;
		foreach($result_ads as $data_pl_ads){
			$total_cost_ads = $total_cost_ads + intval(str_replace(",","",$data_pl_ads['RATE_D']*1000));
			
			if($total_cost_ads > $params['cost']){
				break;
			} 
			$cost_count_ads++;
		}
		
		$total_filtered_ads = $cost_count_ads;
		$total_ads 			= count($result_ads);
		
			$limit_data_ads = $cost_count_ads ;
    
	
		$sql2_ads		= " SELECT VIEWER,CHANNEL,PROGRAM,`TYPE` FROM ( SELECT VIEWER,COLOR,`DATE`,CHANNEL,`TYPE`,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,A.`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID`,COLOR FROM M_SUMMARY_MEDIA_PLAN_D_NEW A
				LEFT JOIN `CHANNEL_PARAM` B ON A.CHANNEL = B.`CHANNEL_RC`
				WHERE PROFILE_ID = ".$params['profiles']." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where."  ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
    LIMIT ".$limit_data_ads." ) P GROUP BY CHANNEL,PROGRAM,`TYPE` ";
	
	

	
    $sql = "SELECT `DATE`,VIEWER,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE 
				STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC";
		
    $out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		  if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		
		$total_cost = 0;
		$cost_count = 0;
		foreach($result as $data_pl){
			$total_cost = $total_cost + intval(str_replace(",","",$data_pl['RATE']*1000));
      
			if($total_cost > $params['cost']){
				break;
			}
			$cost_count++; 
		}
    	
		$sql3		= "SELECT VIEWER,`DATE`,CHANNEL,PROGRAM,START_TIME,END_TIME,DURATION,(RATE * ".$params['discount']." / 100 ) as RATE,LEVEL1,LEVEL2,AVG(TVR) AS TVR, AVG(TVS) AS TVS,1 as SPOTS, IDX, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
		((RATE * ".$params['discount']." / 100 )*1000)/(VIEWER) AS REACH  FROM (
				SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,
				`RATE`,`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,AVG(`VIEWER`) AS VIEWER,
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`) AS TVR,AVG(`TVS`) AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM ( SELECT A.* FROM 
				M_SUMMARY_MEDIA_PLAN_D_NEW A, ( ".$sql2_ads." ) B WHERE A.`CHANNEL` = B.CHANNEL AND A.`PROGRAM` =B.PROGRAM AND A.`TYPE` = B.TYPE 
				) A
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_mp']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date_mp']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
		LIMIT 0,".$cost_count;
    
		$query3	= $this->db2->query($sql3);
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
      $query		= $this->db2->query($sql);
      $result = $query->result_array();
      
      return $result;
  }             
    
  public function channelsearch($strSearch,$role){ 

      $sql = "SELECT CHANNEL AS CHANNEL FROM `CHANNEL_PARAM_PROVIDER` C
      WHERE CHANNEL LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`CHANNEL`";
      $out		= array();
      $query		= $this->db2->query($sql);
      $result = $query->result_array(); 
      
      return $result;
  }

	
}	