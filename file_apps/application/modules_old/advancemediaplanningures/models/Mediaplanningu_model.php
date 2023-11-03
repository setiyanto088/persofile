<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mediaplanningu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		$this->db2 = $this->load->database('db_prod', TRUE);
	}
		
	public function get_channel(){

    $sql = "SELECT CHANNEL_NAME AS CHANNEL_CIM FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` = 1
	  GROUP BY CHANNEL_NAME
      ORDER BY C.`CHANNEL_NAME`";
      
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
     
		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a JOIN M_MONTH_PROFILE_RES c ON a.`id` = c.`PROFILE_ID` 
		WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND flag = 1 AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' 
		ORDER BY `name`
		";
    
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
	
	public function list_ads($params,$array_summ2ggg){
		
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
		
		$db = $this->clickhouse->db();
		
		$query = " 
							SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`RATE`,
							`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,
							`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`*100 AS TVR_A,`TVS_A`*100 AS TVS_A,`IDX_A`,`PROFILE_ID`
							,(RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH  FROM M_SUMMARY_MEDIA_PLAN_D_RES
							WHERE PROFILE_ID = ".$params['profiles']."
							AND toDate(`SPLIT_MINUTES`)   BETWEEN '".$params['start_date_ads']."' 
							AND '".$params['end_date_ads']."' AND `TYPE` IS NOT NULL AND RATE > 0 ".$add_where." 
							AND CHANNEL = '".$array_summ2ggg['CHANNEL']."' AND PROGRAM = '".$array_summ2ggg['PROGRAM']."'
							AND `TYPE` = '".$array_summ2ggg['ADSTYPE']."' ORDER BY TVR DESC
							LIMIT 0,".$array_summ2ggg['SPOT']."
						
				";
		
		$result = $db->select($query);
		return $result->rows();
		
	}
	
	public function list_ads_ext($params,$array_summ2ggg){
		
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
		
		$db = $this->clickhouse->db();
		$query = " 
							SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`RATE`,
							`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,
							`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`*100 AS TVR_A,`TVS_A`*100 AS TVS_A,`IDX_A`,`PROFILE_ID`
							,(RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH  FROM M_SUMMARY_MEDIA_PLAN_D_RES
							WHERE PROFILE_ID = ".$params['profiles']."
							AND toDate(`SPLIT_MINUTES`)  BETWEEN '".$params['start_date_ads']."'  
							AND '".$params['end_date_ads']."' AND `TYPE` IS NOT NULL AND RATE > 0 ".$add_where." 
							AND CHANNEL = '".$array_summ2ggg['CHANNEL']."' AND PROGRAM = '".$array_summ2ggg['PROGRAM']."' AND RATE = ".$array_summ2ggg['RATE']."
							AND `TYPE` = '".$array_summ2ggg['ADSTYPE']."' ORDER BY TVR DESC
							LIMIT ".$array_summ2ggg['SPOT'].",1
						
				";
				
				
		
		$result = $db->select($query);
		return $result->rows();
		
	}
	
	public function list_ads_ext_new($params,$slays){
		
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
			SELECT RANK() OVER (PARTITION BY CHANNEL,PROGRAM,`TYPE`,RATE ORDER BY TVR_A DESC) RN, * FROM (
							SELECT (RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH ,* FROM M_SUMMARY_MEDIA_PLAN_D_RES
							WHERE PROFILE_ID = ".$params['profiles']."
							AND STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date_ads']."', '%d/%m/%Y')  
							AND STR_TO_DATE('".$params['end_date_ads']."', '%d/%m/%Y') AND `TYPE` IS NOT NULL AND RATE > 0 ".$add_where." 
							AND CONCAT(CHANNEL,'|',PROGRAM,'|',`TYPE`,'|',`RATE`) IN (".$slays.")
			) F			
				";
				
				
		print_r($query);die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	
		
	}
	
		public function list_ads_ext2($params,$channel,$rate,$cnt_array,$program,$adstype){
		
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
		
		$db = $this->clickhouse->db();
		$query = " 
							SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`RATE`,
							`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,
							`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`*100 AS TVR_A,`TVS_A`*100 AS TVS_A,`IDX_A`,`PROFILE_ID`,(RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH  FROM M_SUMMARY_MEDIA_PLAN_D_RES
							WHERE PROFILE_ID = ".$params['profiles']."
							AND toDate(`SPLIT_MINUTES`)  BETWEEN '".$params['start_date_ads']."'
							AND '".$params['end_date_ads']."' AND `TYPE` IS NOT NULL AND RATE > 0 AND `TYPE` IS NOT NULL ".$add_where."  AND RATE = ".$rate."
							AND CHANNEL = '".$channel."' AND `TYPE` = '".$adstype."' AND PROGRAM NOT IN (".$program.")
							ORDER BY TVR DESC
							LIMIT 0,".$cnt_array." 
						
				";
		
		$result = $db->select($query);
		return $result->rows();
		
	}
	
		public function list_ads_ext3($params,$channel,$rate,$cnt_array,$program,$adstype){
		
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
		
		$db = $this->clickhouse->db();
		$query = " 
							SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`RATE`,
							`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,
							`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`*100 AS TVR_A,`TVS_A`*100 AS TVS_A,`IDX_A`,`PROFILE_ID`,(RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH  FROM M_SUMMARY_MEDIA_PLAN_D_RES
							WHERE PROFILE_ID = ".$params['profiles']."
							AND toDate(`SPLIT_MINUTES`)  BETWEEN '".$params['start_date_ads']."'
							AND '".$params['end_date_ads']."' AND `TYPE` IS NOT NULL AND RATE > 0 ".$add_where."  
							AND CHANNEL = '".$channel."' AND `TYPE` = '".$adstype."'  AND PROGRAM NOT IN (".$program.")
							ORDER BY TVR DESC
							LIMIT 0,".$cnt_array." 
						
				";
		
			
		$result = $db->select($query);
		return $result->rows();
		
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
		$query_ads		= $this->db->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db->conn_id)){
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
	
		
    $query2		= $this->db->query($sql2);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db->conn_id)){
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
	
		
    $query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();
		
		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered,
			'total' => $total
		);
		
		return $return;
	}
		
	public function list_planning($params = array()) {					
		$hightvr = $params['high_tvr'];
		$maxspot = $params['maximum_cost'];
		$mincprp = $params['minimum_cprp'];
		$index = $params['index']; 
		$maximum_reach = $params['maximum_reach'];  
		
		if ($hightvr == 1) {
			$order_sort = " TVR_A DESC";
			$add_where = "";
		}
		
		if ($maxspot == 1) {
			$order_sort = " (RATE * ".$params['discount']." / 100 ) ASC";
			$add_where = "";
		}
		
		if ($mincprp == 1) {
			$order_sort = " CPRP ASC";
			$add_where = "AND (RATE * ".$params['discount']." / 100 )/TVR_A > 0 ";
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
    
    		
				$db = $this->clickhouse->db();
				
				$sql = "  SELECT  *,1 as RANK FROM (
							SELECT `DATE`,`CHANNEL`,`PROGRAM`,`TITTLE`,`TYPE`,`STATUS`,`START_TIME`,`END_TIME`,`DURATION`,`RATE`,
							`LEVEL1`,`LEVEL2`,`SPLIT_MINUTES`,`FLAG_TV`,`PERIODE`,`TIME_PERIODE`,`VIEWER`,`VIEWER_ALL`,`UNIVERSE`,
							`TVR`,`TVS`,`IDX`,`VIEWER_A`,`VIEWER_ALL_A`,`UNIVERSE_A`,`TVR_A`*100 AS TVR_A,`TVS_A`*100 AS TVS_A,`IDX_A`,`PROFILE_ID`,
							(RATE * ".$params['discount']." / 100 ) AS RATE_D, ((RATE * ".$params['discount']." / 100 )*1000)/(TVR*100) AS CPRP, 
							((RATE * ".$params['discount']." / 100 )*1000)/(`VIEWER`) AS REACH  FROM M_SUMMARY_MEDIA_PLAN_D_RES
							WHERE PROFILE_ID = ".$params['profiles']."
							AND toDate(`SPLIT_MINUTES`)  BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' AND `TYPE` IS NOT NULL AND RATE > 0 ".$add_where." ".$where_channel." 
						) PO 
						ORDER BY ".$order_sort.", `DATE` ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out		= array();
		
		$result = $db->select($sql);
		return $result->rows();
		
		
			
		
		
    
	
		
		
		
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db->conn_id)){
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
              
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
              
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
			WHERE  
			STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
			GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
            
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db->conn_id)){
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
            
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
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
                  
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db->conn_id)){
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
                  
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE 
				STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
		WHERE 
		STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel."
		GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
		ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
		LIMIT 0,".$cost_count;
    
		$query3	= $this->db->query($sql3);
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
				`PROFILE_ID` FROM M_SUMMARY_MEDIA_PLAN_D_NEW
				WHERE PROFILE_ID = ".$params['profiles']."
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				) PO 
				WHERE STR_TO_DATE(`DATE`, '%d/%m/%Y') BETWEEN STR_TO_DATE('".$params['start_date']."', '%d/%m/%Y')  AND STR_TO_DATE('".$params['end_date']."', '%d/%m/%Y')  AND RATE > 0 ".$add_where." ".$where_channel." 
				GROUP BY `DATE`,CHANNEL,PROGRAM ,`TYPE`
				ORDER BY ".$order_sort.", STR_TO_DATE(`DATE`, '%d/%m/%Y') ASC,CHANNEL ASC,PROGRAM ASC
				";
		
		$out_ads		= array();
		$query_ads		= $this->db->query($sql_ads);
		$result_ads = $query_ads->result_array();
		
		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
		if($l_result_ads = mysqli_store_result($this->db->conn_id)){
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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
				AVG(`VIEWER_ALL`) AS VIEWER_ALL,`UNIVERSE`,AVG(`TVR`)*100 AS TVR,AVG(`TVS`)*100 AS TVS,AVG(`IDX`) AS IDX ,
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