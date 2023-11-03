<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvpostbuyu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		
	}
	
	public function get_tahun(){
		
	 	
 
	$db = $this->clickhouse->db();
 		$query = "SELECT DISTINCT formatDateTime(`TANGGAL`, '%Y-%m') tahun FROM M_CIM_PTV_New_DTV2_F WHERE tahun IS NOT NULL ORDER BY `TANGGAL` DESC";
		 
	 

		$result = $db->select($query);
		return $result->rows();	   		
	}
	
	public function get_bulan(){
		
 
		
		
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT toDate(DATE, '%M') as bulan FROM PTV_CIM_RATING_DTV2 ORDER BY toDate(DATE, '%M')";			
		$result = $db->select($query);
		return $result->rows();	   
		
	}
	
	public function get_curr_bulan(){
		
		$query = "SELECT DISTINCT DATE_FORMAT(`DATE`, '%M') bulan FROM PTV_CIM_RATING_DTV2 order by DATE_FORMAT(`DATE`, '%m') DESC Limit 1";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_corres(){
		
		$query = "SELECT COUNT(NO) AS CORESSPONDENT FROM M_SINGLE_SOURCE";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}

	public function list_profile(){
		$query = 'SELECT id, name FROM t_profiling_u WHERE STATUS IN (1,3,9) AND flag = 1 order by name';  	 		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();
	}
	
	public function list_cgi_field($field) {
		if ($field=='CHANNEL') {
			$query = 'SELECT a.'.$field.' FROM t_channel a ORDER BY a.'.$field.' ';
		}
		elseif($field=='LEVEL1'){
			$query = 'SELECT a.'.$field.' FROM t_level1_cgi a ORDER BY a.'.$field.' ';
		}
		elseif($field=='LEVEL2'){
			$query = 'SELECT a.'.$field.' FROM t_level2_cgi a ORDER BY a.'.$field.' ';
		}
		elseif($field=='PROGRAM'){
			$query = 'SELECT a.'.$field.' FROM t_program_cgi_new a ORDER BY a.'.$field.' ';
		}
		elseif($field=='ADS_TYPE'){
			$query = 'SELECT a.'.$field.' FROM t_ads_type_cgi a ORDER BY a.'.$field.' ';
		}
		else{
			$query = 'SELECT DISTINCT(a.'.$field.') FROM CGI a ORDER BY a.'.$field.' ';
		} 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function proc_get_cost_by_program_all($field,$where,$periode) {
    if($field == "PROGRAM"){
      $query = 'SELECT 
                	a.PROGRAM, SUM(a.NET_PRICE) AS Cost ,a.CHANNEL
                FROM 
                	PTV_CIM_RATING_DTV2 a 
                WHERE 
                	1=1 AND 
                	ID_PROFILE  = 0 AND 
                	DATE_FORMAT(`DATE`, "%Y-%M")="'.$periode.'" '.$where.'
    					 GROUP BY a.'.$field.' 
    					 ORDER BY Cost DESC';
    } else {
  		$query = 'SELECT 
                	a.NAMA_BRAND, SUM(a.NET_PRICE) AS Cost 
                FROM 
                	PTV_CIM_RATING_DTV2 a 
                WHERE 
                	1=1 AND 
                	ID_PROFILE  = 0 AND 
                	DATE_FORMAT(`DATE`, "%Y-%M")="'.$periode.'" '.$where.'
    					 GROUP BY a.'.$field.' 
    					 ORDER BY Cost DESC';
    }      			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function proc_get_cost_by_channel_all($where,$periode) {
	 	
			$query = 'SELECT 
                	a.`CHANNEL`,SUM(a.`NET_PRICE`) AS rt 
                FROM 
                	PTV_CIM_RATING_DTV2 a 
                WHERE 
                	1=1 AND DATE_FORMAT(a.DATE, "%Y-%M")="'.$periode.'" '.$where.'
					GROUP BY a.`CHANNEL`
					ORDER BY rt DESC';  	
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_chanel_all($where,$periode) {
	 			
					
					$query = '
		 SELECT CHANNEL, COUNT(CARDNO) AS grp, 1 AS SPOT 
		FROM (

		SELECT * FROM `PTV_DETAIL_LOGPROOF_DTV2`
		WHERE 1=1 
		AND DATE_FORMAT(`TANGGAL`, "%Y-%M") = "'.$periode.'" 
		GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

		) P
		GROUP BY CHANNEL
		ORDER BY grp DESC
		';  			
		
		$sql	= $this->db->query($query);
 		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_date_all($where,$periode) {
		 
		
			$query = '
		 SELECT TANGGAL AS `DATE`, COUNT(CARDNO) AS grp, 1 AS SPOT 
		FROM (

		SELECT * FROM `PTV_DETAIL_LOGPROOF_DTV2`
		WHERE 1=1 
		AND DATE_FORMAT(`TANGGAL`, "%Y-%M") = "'.$periode.'" 
		GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

		) P
		GROUP BY TANGGAL
		ORDER BY TANGGAL
		';  			
						
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_by_date_all($where,$periode) {
		$query = 'SELECT a.DATE,SUM(a.NET_PRICE) AS cost 
              FROM PTV_CIM_RATING_DTV2 a 
              WHERE 
              	1=1  AND 
              	ID_PROFILE  = 0 AND 
              	DATE_FORMAT(`DATE`, "%Y-%M")="'.$periode.'" '.$where.'
    					GROUP BY a.`DATE`
    					ORDER BY a.`DATE`';  
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_date_all($ORDERS,$where,$periode) {
	 
					
		 $db = $this->clickhouse->db();
		 $query = "SELECT ".$ORDERS." AS spot,`DATE` FROM PB_DASH_DAYS_DTV 
						 WHERE PERIODE = '".$periode."' 
						ORDER BY `DATE`
						";				 
 
$result = $db->select($query);
		return $result->rows();	   		
	}
	public function list_spot_by_date_all2($where) {
		$query = 'SELECT a.TANGGAL as date,SUM(a.TVR) AS spot FROM NEW_MEDIA_PLANNING a WHERE 1=1 '.$where.'
					GROUP BY a.TANGGAL
					ORDER BY a.TANGGAL';  	

 		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_daytime_all($ORDERS,$where,$periode) {
	 
						 
		$db = $this->clickhouse->db();				 
		 $query = "SELECT ".$ORDERS." AS spot,DAYPART FROM PB_DASH_DAYPART_DTV 
						 WHERE PERIODE = '".$periode."' 
						ORDER BY ".$ORDERS." DESC
						";				 

  
		
		$result = $db->select($query);
		return $result->rows();	 
	}
	
	public function list_spot_by_daytime_all2($where) {
		$query = "SELECT tb_cgi.htype, SUM(tb_cgi.tvr) AS spot 
							FROM
							(
								SELECT a.*, b.tvr, ( 
									 CASE WHEN 
							a.`START_TIME` 
							>= CAST('00:00:00' AS TIME) AND 
							a.END_TIME 
							< CAST('06:00:00' AS TIME)
							THEN '00:00 - 06:00'
							WHEN 
							a.`START_TIME` 
							>= CAST('06:00:00' AS TIME) AND 
							a.`END_TIME` 
							< CAST('08:00:00' AS TIME)
							THEN '06:00 - 08:00'
							WHEN 
							a.`START_TIME` 
							>= CAST('08:00:00' AS TIME) AND 
							a.`END_TIME` 
							< CAST('12:00:00' AS TIME)
							THEN '08:00 - 12:00'
							WHEN 
							a.`START_TIME` 
							>= CAST('12:00:00' AS TIME) AND 
							a.`END_TIME` 
							< CAST('18:00:00' AS TIME)
							THEN '12:00 - 18:00'
							WHEN 
							a.`START_TIME` 
							>= CAST('18:00:00' AS TIME) AND 
							a.`END_TIME` 
							< CAST('22:00:00' AS TIME)
							THEN '18:00 - 22:00'
							WHEN 
							a.`START_TIME` 
							>= CAST('22:00:00' AS TIME) AND 
							a.`END_TIME` 
							< CAST('23:59:59' AS TIME)
							THEN '22:00 - 00:00' ELSE '00:00 - 06:00'
							 END) AS htype 
								 FROM t_epg a 
									LEFT JOIN NEW_MEDIA_PLANNING b ON a.`program` = b.`program`	
								 WHERE 1=1 ".$where.") AS tb_cgi 
								 GROUP BY tb_cgi.htype
								 ORDER BY spot DESC";  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_by_daytime_all($where,$periode) {
		$query = "SELECT tb_cgi.htype, SUM(tb_cgi.tvr) AS cost 
              FROM
              (
              	SELECT a.NET_PRICE tvr, 			
				( CASE WHEN a.START_TIME BETWEEN '00:00:00' AND '05:59:59'  THEN '00:00 - 06:00'
			 WHEN a.START_TIME BETWEEN '06:00:00' AND '07:59:59'  THEN '06:00 - 08:00'
			 WHEN a.START_TIME BETWEEN '08:00:00' AND '11:59:59'  THEN '06:00 - 12:00'
			 WHEN a.START_TIME BETWEEN '12:00:00' AND '17:59:59'  THEN '12:00 - 18:00'
			 WHEN a.START_TIME BETWEEN '18:00:00' AND '21:59:59'  THEN '18:00 - 22:00'
			ELSE '22:00 - 00:00'
              	 END) AS htype 
              	 FROM PTV_CIM_RATING_DTV2 a 
              	 WHERE 1=1 
              	 AND DATE_FORMAT(a.DATE, '%Y-%M')='".$periode."' ".$where.") AS tb_cgi 
						 GROUP BY tb_cgi.htype
						 ORDER BY cost DESC";  	      	    
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_daytime_all($where,$periode) {
		$query = "SELECT tb_cgi.htype, COUNT(CARDNO) AS grp FROM (

SELECT TANGGAL AS `DATE`, 
( CASE WHEN a.START_TIME BETWEEN '00:00:00' AND '05:59:59'  THEN '00:00 - 06:00'
			 WHEN a.START_TIME BETWEEN '06:00:00' AND '07:59:59'  THEN '06:00 - 08:00'
			 WHEN a.START_TIME BETWEEN '08:00:00' AND '11:59:59'  THEN '06:00 - 12:00'
			 WHEN a.START_TIME BETWEEN '12:00:00' AND '17:59:59'  THEN '12:00 - 18:00'
			 WHEN a.START_TIME BETWEEN '18:00:00' AND '21:59:59'  THEN '18:00 - 22:00'
			ELSE '22:00 - 00:00'
              	 END) AS htype ,
* FROM `PTV_DETAIL_LOGPROOF_DTV2` a
					WHERE 1=1  AND NET_PRICE > 0 
					AND DATE_FORMAT(`TANGGAL`, '%Y-%M') = '".$periode."' 
					GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND
					
					) tb_cgi
					 GROUP BY tb_cgi.htype
					ORDER BY grp DESC";		
		$sql	= $this->db->query($query);       
 		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_loose_all($where,$periode) {
		$query = 'SELECT 
						COUNT(CASE WHEN TYPE = "LOOSE SPOT" THEN 1 END) AS Loose,
						COUNT(CASE WHEN TYPE <> "LOOSE SPOT" THEN 1 END) AS No_Loose 
						FROM PTV_CIM_RATING2 WHERE 1=1 AND ID_PROFILE  = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.' ';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_by_loose_all($where,$periode) {
		$query = 'SELECT 
					SUM(CASE WHEN a.TYPE = "LOOSE SPOT" THEN a.cost END) AS Loose,
					SUM(CASE WHEN a.TYPE <> "LOOSE SPOT" THEN a.cost END) AS No_Loose
					FROM PTV_CIM_RATING2 a WHERE 1=1 AND ID_PROFILE  = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.' ';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_loose_all($where,$periode) {
		$query = 'SELECT 
						SUM(CASE WHEN a.type = "LOOSE SPOT" THEN a.tvr END) AS Loose,
						SUM(CASE WHEN a.type <> "LOOSE SPOT" THEN a.tvr END) AS No_Loose
						FROM PTV_CIM_RATING2 a WHERE 1=1 AND ID_PROFILE  = 0 AND sector <> "NON-COMMERCIAL ADVERTISEMENT"   AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_adstype_all($where) {
		$query = 'SELECT a.`TYPE`,COUNT(DATE) AS spot FROM CGI_TVR a Where 1=1 '.$where.'
					GROUP BY a.`TYPE`
					ORDER BY spot DESC';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_product_all() {
		$query = 'SELECT product,spot FROM t_product_cgi_new
					ORDER BY spot DESC';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all2n($segment,$ORDERS,$where,$periode) {

	 
				
			 $db = $this->clickhouse->db();
			 $query = "SELECT NAME, CHANNEL,".$ORDERS." as spots FROM PB_DASH_SEGMENT2_DTV 
						 WHERE PERIODE = '".$periode."' 
						 AND SEGMENT = '".$segment."'
						ORDER BY toFloat32(".$ORDERS.") DESC
						";
   
		$result = $db->select($query);
		return $result->rows();	 
	}
	
	public function list_spot_by_program_all($segment,$ORDERS,$where,$periode) {
 
						
								$db = $this->clickhouse->db();
			 $query = "SELECT NAME, ".$ORDERS." as spots FROM PB_DASH_SEGMENT_DTV 
						 WHERE PERIODE = '".$periode."' 
						 AND SEGMENT = '".$segment."'
						ORDER BY toFloat32(".$ORDERS.")	 DESC
						";
 
		$result = $db->select($query);
		return $result->rows();	   
	}
	
	public function list_grp_by_program_all($field,$where,$periode) {
		
			$query = 'SELECT a.'.$field.', COUNT(a.`DATE`) AS GRP FROM PTV_CIM_RATING_DTV2 a Where 1=1 AND ID_PROFILE  = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'
						GROUP BY a.'.$field.'
						ORDER BY GRP DESC';
		
		
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all2($field,$where,$periode) {
	  			
					
					$query = '
		 SELECT '.$field.',CHANNEL, COUNT(CARDNO) AS GRP, 1 AS SPOT 
		FROM (

		SELECT * FROM `PTV_DETAIL_LOGPROOF_DTV2`
		WHERE 1=1 
		AND DATE_FORMAT(`TANGGAL`, "%Y-%M") = "'.$periode.'" 
		GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

		) P
		GROUP BY '.$field.'
		ORDER BY GRP DESC
		';  			
		
					
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_chanel_all($ORDERS,$where,$periode) {
		 
						$db = $this->clickhouse->db();	
						 $query = "SELECT * FROM PB_DASH_CHANNEL_DTV 
						 WHERE PERIODE = '".$periode."' 
						ORDER BY ".$ORDERS." DESC
						LIMIT 30";
    
		$result = $db->select($query);
		return $result->rows();	 
	}
	public function list_spot_by_chanel_all2($where) {
		$query = 'SELECT a.`channel`, SUM(tvr) AS spot FROM NEW_MEDIA_PLANNING a 
						where 1=1 '.$where.'
						GROUP BY a.`channel` 
						ORDER BY spot DESC';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_all($where,$periode) {
 		
		$query = 'SELECT SUM(NET_PRICE) AS cost FROM `M_CIM_PTV_New_DTV2` WHERE 1=1 
AND DATE_FORMAT(STR_TO_DATE(TANGGAL,"%d/%m/%Y"), "%Y-%M") = "'.$periode.'" '.$where.' ';   
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	    
	}
	
	
	public function list_cost_alls($where,$periode) {
 		
		$query = 'SELECT COUNT(CHANNEL) AS spot FROM M_CIM_PTV_New_DTV2 where 1=1 AND DATE_FORMAT(STR_TO_DATE(TANGGAL,"%d/%m/%Y"), "%Y-%M")="'.$periode.'" '.$where.' ';  
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	    
	}
	
	public function list_cost_all2($where) {
		$query = 'SELECT SUM(PRICE) AS cost FROM M_CIM_F2A_N where 1=1 '.$where.'';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	
	
	public function list_spot_all($where,$periode) {
		$query = 'SELECT SUM(TVR) AS grp FROM PTV_CIM_RATING_DTV2 where 1=1 AND ID_PROFILE  = 0 AND DATE_FORMAT(`DATE`, "%Y-%M")="'.$periode.'" '.$where.'';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_alls_dtv($where,$periode) {
		$db = $this->clickhouse->db();
		
		$query = "

		SELECT * FROM `PB_DASH_SPOTCOST_DTV`
		WHERE 1=1 
		AND PERIODE = '".$periode."' 

		";  			
		$result = $db->select($query);
		return $result->rows();	 
	}
	
	public function list_spot_all_v($where,$periode) {
		$query = '
		 SELECT COUNT(CARDNO) AS TOTAL_VIEW, 1 AS SPOT 
		FROM (

		SELECT * FROM `PTV_DETAIL_LOGPROOF_DTV2`
		WHERE 1=1 
		AND DATE_FORMAT(`TANGGAL`, "%Y-%M") = "'.$periode.'" 
		GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

		) P
		';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function list_grp() {
		$query = 'SELECT SUM(TVR) AS grp FROM SUMMARY_MP_NEW WHERE ID_PROFILE ING = 8';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_all2($where) {
		$query = 'SELECT COUNT(`DATE`) AS spot, SUM(TVR) AS grp  FROM PTV_CIM_RATING_DTV2 WHERE 1=1 AND ID_PROFILE  = 0 '.$where.'';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channel() {
		$query = 'SELECT DISTINCT(channel) FROM CGI';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_sector() {
		$query = 'SELECT a.SECTOR FROM t_sector_cgi a ORDER BY a.SECTOR';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function list_category() {
		$query = 'SELECT  a.CATEGORY FROM t_category_cgi a ORDER BY a.CATEGORY';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_advertiser() {
		$query = 'SELECT  a.ADVERTISER FROM t_advertiser_cgi a ORDER BY a.ADVERTISER';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_product() {
		$query = 'SELECT a.PRODUCT FROM t_product_cgi_new a ORDER BY a.PRODUCT LIMIT 500';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function ambildata() {
		
		$query = 'SELECT a.*, b.tvr 
					FROM CGI a
					LEFT JOIN NEW_MEDIA_PLANING b ON a.`program`=b.`program` AND a.`TANGGAL` = b.`TANGGAL` limit 10000
					';  			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$hasil = $sql->result_array();	 
 
		
	}
	
	public function content_grouping($profile) {
		$query = 'SELECT grouping
					FROM t_profiling
					WHERE id = $profile
					AND STATUS = 1 
          AND flag = 1';  			
		$sql	= $this->db->query($query,array($profile));
		$this->db->close();
		$this->db->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT UserID	FROM t_single_source"." ".$data;
	 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	
	
	public function list_postbuy($params = array()) {		
		
		$sql		=  ' SELECT COUNT(DISTINCT(pm.USER_ID)) AS PRICE, pm.channel AS CH_PM, epg.channel AS CH_EPG, epg.program, epg.date, pm.begin_session, pm.end_session  ,
		epg.start_time AS START_EPG ,epg.end_time  AS END_EPG, tcn.product, tcn.start_time AS times, tcn.duration
		FROM t_people_meter AS pm , t_epg AS epg, t_cgi_new AS tcn
		
		ORDER BY tcn.start_time ASC
		LIMIT '.$params['limit'].'
		OFFSET '.$params['offset'].'';
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

		$total_filtered = $this->db->query('SELECT FOUND_ROWS() AS total_filtered ')->row_array();
		$total 			= $this->db->query('SELECT 
												COUNT(DISTINCT USERID) AS total 
												FROM NEW_PEOPLE_METER a')->row_array();
		
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $total['total'],
		);
		
		return $return;
	}
	
	function getvid($text)
	{
 		$sql 	= 'SELECT product_name, video_name FROM t_product_video WHERE product_name = '.$text.'';
		
		$query 	=  $this->db->query($sql);
		
		$return = $query->result_array();
 		return $return;
	}	

		
	
}	
