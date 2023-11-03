<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvpostbuyu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		
	}
	
	public function get_tahun(){
		 
		
		$query = "SELECT * FROM TABLE_IPERIODE WHERE FLAG_TV = 0 AND FLAG_MENU = 0 ORDER BY `DATE` DESC ";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_bulan(){
		
	 
		
		$db = $this->clickhouse->db();
		$query = "SELECT toDate(DATE_UNICS, '%m') as bulan FROM M_CIM_F2A_N_SPLIT ORDER BY toDate(DATE_UNICS, '%m') ";			
		$result = $db->select($query);
		
		return $result->rows();	  
	}
	
	public function get_corres(){
		
		$query = "SELECT COUNT(NO) AS CORESSPONDENT FROM M_SINGLE_SOURCE";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}

	public function list_profile(){
		$query = 'SELECT id, name FROM t_profiling_ub WHERE STATUS IN (1,3,9) AND flag = 1 order by name';  	 		
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
	
	public function proc_get_segment_f($segment,$field,$where,$periode) {
		$query = 'SELECT '.$field.' as val, NAME AS name FROM PB_DASH_SEGMENT WHERE PERIODE = "'.$periode.'" AND SEGMENT = "'.$segment.'" ORDER BY CAST('.$field.' AS UNSIGNED) DESC ';  			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function proc_get_segment2_f($segment,$field,$where,$periode) {
		$query = 'SELECT '.$field.' as val, CHANNEL, NAME AS name FROM PB_DASH_SEGMENT2 WHERE PERIODE = "'.$periode.'" AND SEGMENT = "'.$segment.'" ORDER BY CAST('.$field.' AS UNSIGNED) DESC ';  			
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
		public function proc_get_segment2_fn($segment,$field,$where,$periode) {
		$query = 'SELECT SUM(CAST('.$field.' AS UNSIGNED)) as val,  NAME AS name FROM PB_DASH_SEGMENT2 WHERE PERIODE = "'.$periode.'" AND SEGMENT = "'.$segment.'" group BY NAME ORDER BY CAST('.$field.' AS UNSIGNED) DESC ';  			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
		
	
	public function proc_get_segment($segment,$field,$where,$periode) {
		$query = 'SELECT '.$field.' as fld, NAME FROM PB_DASH_SEGMENT WHERE PERIODE = "'.$periode.'" AND SEGMENT = "'.$segment.'" ORDER BY CAST('.$field.' AS UNSIGNED) DESC ';  			
	 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function proc_get_cost_by_program_all($field,$where,$periode) {
		$query = 'SELECT '.$field.', ADS_TYPE FROM PB_DASH_ADSTYPE WHERE PERIODE = "'.$periode.'" ORDER BY CAST('.$field.' AS UNSIGNED) DESC ';  			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function proc_get_cost_by_channel_all($field,$periode) {
	   	

		$query = 'SELECT '.$field.',CHANNEL FROM PB_DASH_CHANNEL WHERE PERIODE = "'.$periode.'" AND FLAG_TV = 0 ORDER BY CAST('.$field.' AS UNSIGNED) DESC ';  						
					
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_chanel_all($where,$periode) {
		$query = 'SELECT a.`channel`,SUM(a.`tvr`) AS grp FROM M_CIM_F2A_SUMMARY_CB a WHERE 1=1 AND ID_PROFILE = 0 AND sector <> "NON-COMMERCIAL ADVERTISEMENT"  AND ID_PROFILE = 0  AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'
					GROUP BY a.`channel`
					ORDER BY grp DESC';  			
		$sql	= $this->db->query($query);
 		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_date_all($where,$periode) {
		$query = 'SELECT a.date, SUM(a.tvr) AS grp FROM M_CIM_F2A_SUMMARY_CB a WHERE 1=1 AND ID_PROFILE = 0 AND sector <> "NON-COMMERCIAL ADVERTISEMENT"  AND ID_PROFILE = 0  AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'
					GROUP BY DATE_UNICS
					ORDER BY DATE_UNICS';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_by_date_all($where,$periode) {
		$query = 'SELECT a.date,SUM(a.cost) AS cost FROM M_CIM_F2A_SUMMARY_CB a WHERE 1=1  AND ID_PROFILE = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'
					GROUP BY DATE_UNICS
					ORDER BY DATE_UNICS';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_date_all($field,$periode) {
		 
					
		$query = 'SELECT `DATE` as `date` ,'.$field.' AS val FROM PB_DASH_DAYS  WHERE 1=1 AND PERIODE ="'.$periode.'" ORDER BY `DATE`'; 

 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
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
	
	public function list_spot_by_daytime_all($where,$periode) {
		$query = "SELECT DAYPART AS htype,SPOT AS spot FROM PB_DASH_DAYPART WHERE PERIODE = '".$periode."' AND FLAG_TV = 0 ORDER BY SPOT DESC";  			   
	                       
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function filtered_daytime_all($field,$periode) {
		$query = "SELECT DAYPART AS htype,".$field." FROM PB_DASH_DAYPART WHERE PERIODE = '".$periode."' AND FLAG_TV = 0 ORDER BY  CAST(".$field." AS UNSIGNED)  DESC";  			   
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
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
						SELECT a.cost tvr, ( 
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
						 FROM M_CIM_F2A_N_SPLIT a 
						 WHERE 1=1 AND DATE_FORMAT(DATE_UNICS, '%Y-%M')='".$periode."' ".$where.") AS tb_cgi 
						 GROUP BY tb_cgi.htype
						 ORDER BY cost DESC";  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_daytime_all($where,$periode) {
		$query = "SELECT tb_cgi.htype, SUM(tb_cgi.tvr) AS grp FROM
					(SELECT *, (  CASE WHEN 
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
							 END) AS htype FROM M_CIM_F2A_SUMMARY_CB a Where 1=1 AND ID_PROFILE = 0 AND DATE_FORMAT(DATE_UNICS, '%Y-%M')='".$periode."' ".$where.") AS tb_cgi 
						 GROUP BY tb_cgi.htype
						 ORDER BY grp DESC";  			
		$sql	= $this->db->query($query);
 		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_loose_all($where,$periode) {
 
	$query = 'SELECT *,LOOSE AS Loose, NO_LOOSE AS No_Loose FROM PB_DASH_LOOSE WHERE PERIODE ="'.$periode.'" ';
					           			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_by_loose_all($where,$periode) {
		$query = 'SELECT 
					SUM(CASE WHEN a.TYPE = "LOOSE SPOT" THEN a.cost END) AS Loose,
					SUM(CASE WHEN a.TYPE <> "LOOSE SPOT" THEN a.cost END) AS No_Loose
					FROM M_CIM_F2A_SUMMARY_CB a WHERE 1=1 AND ID_PROFILE = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.' ';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_loose_all($where,$periode) {
		$query = 'SELECT 
						SUM(CASE WHEN a.type = "LOOSE SPOT" THEN a.tvr END) AS Loose,
						SUM(CASE WHEN a.type <> "LOOSE SPOT" THEN a.tvr END) AS No_Loose
						FROM M_CIM_F2A_SUMMARY_CB a WHERE 1=1 AND ID_PROFILE = 0 AND sector <> "NON-COMMERCIAL ADVERTISEMENT"   AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'';  			
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
	
	public function list_spot_by_program_all($where,$periode) {

		$query = 'SELECT * FROM PB_DASH_ADSTYPE a Where 1=1 AND PERIODE ="'.$periode.'"  ORDER BY SPOT DESC LIMIT 15';
			
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp_by_program_all($field,$where,$periode) {
		
		$query = 'SELECT a.'.$field.', SUM(a.`TVR`) AS GRP FROM M_CIM_F2A_SUMMARY_CB a Where 1=1 AND ID_PROFILE = 0  AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'
						GROUP BY a.'.$field.'
						ORDER BY GRP DESC'; 
		
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all2($field,$where,$periode) {
		$query = 'SELECT a.`'.$field.'`,CHANNEL, SUM(a.tvr) AS GRP FROM M_CIM_F2A_SUMMARY_CB a Where 1=1 AND ID_PROFILE = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'
					GROUP BY a.`'.$field.'`
					ORDER BY GRP DESC';  

 					
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_chanel_all($where,$periode) {
		 

	$query = 'SELECT * FROM PB_DASH_CHANNEL WHERE PERIODE = "'.$periode.'" and FLAG_TV = 0 ORDER BY SPOT DESC';  
	            								
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
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
 		
		$query = 'SELECT SUM(COST) AS cost FROM M_CIM_F2A_N_SPLIT where 1=1 AND CHANNEL IN("ANTV", "IVM", "KOMPASTV", "METRO", "NET","RTV", "SCTV", "TRANS", "TRANS7", "TVONE") AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.' ';
 		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	    
	}
	
	
	public function list_cost_alls($where,$periode) {
 		
		$query = 'SELECT COUNT(PRODUCT) AS spot FROM M_CIM_F2A_N_SPLIT where 1=1 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.' ';  
		 
 		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	    
	}
	
	public function list_header_dash($periode) {
		$query = 'SELECT * FROM PB_DASH_SPOTCOST where 1=1 AND PERIODE = "'.$periode.'" ';  			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_cost_all2($where) {
		$query = 'SELECT SUM(rate) AS cost FROM M_CIM_F2A_N_SPLIT where 1=1 '.$where.'';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_all($where,$periode) {
		$query = 'SELECT SUM(TVR) AS grp FROM M_CIM_F2A_SUMMARY_CB where 1=1 AND ID_PROFILE = 0 AND DATE_FORMAT(DATE_UNICS, "%Y-%M")="'.$periode.'" '.$where.'';  		

 		$sql	= $this->db->query($query);
		$this->db->close(); 
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function list_grp() {
		$query = 'SELECT SUM(TVR) AS grp FROM SUMMARY_MP_NEW WHERE ID_PROFILEING = 8';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_all2($where) {
		$query = 'SELECT COUNT(`TANGGAL`) AS spot, SUM(tvr) AS grp  FROM M_CIM_F2A_SUMMARY_CB WHERE 1=1 AND ID_PROFILE = 0 AND sector <> "NON-COMMERCIAL ADVERTISEMENT"  AND ID_PROFILE = 0  '.$where.'';  			
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
		
		$sql		=  ' SELECT COUNT(DISTINCT(pm.USER_ID)) AS rate, pm.channel AS CH_PM, epg.channel AS CH_EPG, epg.program, epg.date, pm.begin_session, pm.end_session  ,
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
