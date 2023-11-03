<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db_prod', TRUE);
		$this->load->library('ClickHouse');
	}
	
		public function get_file_date(){
		
		 $query = "SELECT * FROM T_PARAM_DATA " ;
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function validate_password($params = array()) {	
	
		$sql 	= 'SELECT id,  token 
						FROM hrd_profile
						WHERE id = ?
						AND id_role = 41';
			
			$query 	=  $this->db->query($sql,
				array(
					$params['uid']
				));
			$result = $query->result_array();
			
			if(isset($result[0]['token'])){
			
				if($params['token'] <> $result[0]['token']){
					
					$res = array(
						'status' => 0,
						'message' => 'Failed Authentication',
					); 
					
				}else{
					$res = array(
						'status' => 1,
						'message' => 'Success',
					); 
				}
			
			}else{
				$res = array(
						'status' => 0,
						'message' => 'Failed Authentication',
					); 
			}
			
			return $res;
	}
	
	public function get_profile($iduser,$idrole) {  

			$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a INNER JOIN hrd_profile b ON a.user_id_profil=b.id WHERE (STATUS = 1 OR STATUS = 3)  AND user_id_profil=".$iduser."  and status_dash_str = 'Done' order by `name` "; 
		
		
		$out		= array();
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_tahun(){
		
		 $query = "SELECT PERIODE_STR AS TANGGAL FROM T_PERIODE_DATA ORDER BY PERIODE DESC" ;
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_bulan(){
		
		$query = "SELECT DISTINCT SUBSTR(TANGGAL,6) bulan FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL, '%Y-%M')";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_week_channel($periode){
		
		$query = "SELECT DISTINCT WEEK as WEEK FROM M_SUM_TV_DASH_CHAN_WEEK WHERE TANGGAL='".$periode."' ORDER BY WEEK";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	public function get_week_program($periode){
		
		$query = "SELECT DISTINCT WEEK as WEEK FROM M_SUM_TV_DASH_PROG_WEEK WHERE TANGGAL='".$periode."' ORDER BY WEEK";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_active_audience($periode){
		
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE_PTV WHERE  TANGGAL= '".$periode."'" ;
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function list_spot_by_program_all_bar($field,$where,$periode,$pilihaudiencebar,$profile) {
		$query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL="'.$periode.'" '.$where.'
					ORDER BY Spot DESC LIMIT 15';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY grp DESC LIMIT 15'; 
			}else {
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY VIEWERS DESC LIMIT 15';  	 
			}
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	public function list_spot_by_program_hari_bar($field,$where,$periode,$week,$pilihaudiencebar,$profile) {
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,GRP AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_WEEK WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC LIMIT 15' ;
				
			}else {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_WEEK 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC LIMIT 15';
			}
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_hari_date($field,$where,$periode,$datef,$pilihaudiencebar,$profile) {
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,GRP AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_DAY WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC LIMIT 15' ;
				
			}else {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC LIMIT 15';
			}
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function daily_filter($periode,$detail_file) {

		if($detail_file == 9){
			$query = 	'SELECT * FROM DAILY_JOBS_REPORT a
					WHERE 1=1 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC';
		}else{
			
			if($detail_file == 0 ){
				
				$query = 	'SELECT * FROM DAILY_JOBS_REPORT a
					WHERE (
					`LOAD_EPG` = '.$detail_file.' OR
					`LOAD_EPG` IS NULL OR					
					`SPLIT_EPG` = '.$detail_file.' OR  
					`SPLIT_EPG` IS NULL OR  
					`LOAD_CDR` = '.$detail_file.' OR  
					`LOAD_CDR` IS NULL OR  
					`CLEANSING_CDR` = '.$detail_file.' OR   
					`CLEANSING_CDR` IS NULL OR   
					`SPLIT_CDR` = '.$detail_file.' OR  
					`SPLIT_CDR` IS NULL OR  
					`JOIN_CDR_EPG` = '.$detail_file.' OR  
					`JOIN_CDR_EPG` IS NULL OR  
					`RATING_PERMINUTES` = '.$detail_file.' OR  
					`RATING_PERMINUTES` IS NULL OR  
					`TVCC` = '.$detail_file.' OR   
					`TVCC` IS NULL OR   
					`MEDIAPLAN` = '.$detail_file.' OR   
					`MEDIAPLAN` IS NULL OR   
					`BEFORE_AFTER` = '.$detail_file.' OR   
					`BEFORE_AFTER` IS NULL OR   
					`MIGRATION`= '.$detail_file.' OR  
					`MIGRATION`IS NULL OR  
					`AUDIENCE` = '.$detail_file.' OR  
					`AUDIENCE` IS NULL OR  
					`DASHBOARD`= '.$detail_file.'  OR  
					`DASHBOARD` IS NULL   )
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC';
				
			}else{
				
			
				$query = 	'SELECT * FROM DAILY_JOBS_REPORT a
					WHERE (
					`LOAD_EPG` = '.$detail_file.' OR  
					`SPLIT_EPG` = '.$detail_file.' OR  
					`LOAD_CDR` = '.$detail_file.' OR  
					`CLEANSING_CDR` = '.$detail_file.' OR   
					`SPLIT_CDR` = '.$detail_file.' OR  
					`JOIN_CDR_EPG` = '.$detail_file.' OR  
					`RATING_PERMINUTES` = '.$detail_file.' OR  
					`TVCC` = '.$detail_file.' OR   
					`MEDIAPLAN` = '.$detail_file.' OR   
					`BEFORE_AFTER` = '.$detail_file.' OR   
					`MIGRATION`= '.$detail_file.' OR  
					`AUDIENCE` = '.$detail_file.' OR  
					`DASHBOARD`= '.$detail_file.' )
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC';
			}
		}
		

		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function daily_filter_7($periode,$detail_file) {

		if($detail_file == 9){
			
			$query = 	'SELECT * FROM DAILY_LOGPROOF_U_JOBS_REPORT_MONTH a
					WHERE 1=1 
					ORDER BY LOG_DATE DESC';
		}else{
			if($detail_file == 0 ){
				
				$query = 	'		SELECT * FROM `DAILY_LOGPROOF_U_JOBS_REPORT_MONTH`
					WHERE (
					`LOAD_LOGPROOF` = '.$detail_file.' OR 
					`LOAD_LOGPROOF` IS NULL OR 
					`SPLIT_LOGPROOF` = '.$detail_file.' OR 
					`SPLIT_LOGPROOF` IS NULL OR 
					`JOIN_LOGPROOF_CDR` = '.$detail_file.' OR 
					`JOIN_LOGPROOF_CDR` IS NULL OR 
					`DETAIL_LOGPROOF` = '.$detail_file.' OR 
					`DETAIL_LOGPROOF` IS NULL OR 
					`PTV_CIM_RATING` = '.$detail_file.' OR 
					`PTV_CIM_RATING` IS NULL OR 
					`REACH_BRAND` = '.$detail_file.' OR 
					`REACH_BRAND`  IS NULL OR 
					`REACH_AGENCY` = '.$detail_file.' OR 
					`REACH_AGENCY`  IS NULL OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`REACH_ADVERTISER`  IS NULL OR  
					`SUB_CAT` = '.$detail_file.' OR 
					`SUB_CAT`  IS NULL  ) 
					
					ORDER BY LOG_DATE DESC
					';
					
			}else{
				
			$query = 	'		SELECT * FROM `DAILY_LOGPROOF_U_JOBS_REPORT_MONTH`
					WHERE (
					`LOAD_LOGPROOF` = '.$detail_file.' OR 
					`SPLIT_LOGPROOF` = '.$detail_file.' OR 
					`JOIN_LOGPROOF_CDR` = '.$detail_file.' OR 
					`DETAIL_LOGPROOF` = '.$detail_file.' OR 
					`PTV_CIM_RATING` = '.$detail_file.' OR 
					`REACH_BRAND` = '.$detail_file.' OR 
					`REACH_AGENCY` = '.$detail_file.' OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`SUB_CAT` = '.$detail_file.'  ) 
					
					ORDER BY LOG_DATE DESC
					';
				
			}
		}
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function daily_filter_8($periode,$detail_file) {

		if($detail_file == 9){
			
			$query = 	'SELECT * FROM DAILY_LOGPROOF_M_JOBS_REPORT_MONTH a
					WHERE 1=1 
					ORDER BY LOG_DATE DESC';
		}else{
			if($detail_file == 0 ){
				
				$query = 	'		SELECT * FROM `DAILY_LOGPROOF_M_JOBS_REPORT_MONTH`
					WHERE (
					`LOAD_LOGPROOF` = '.$detail_file.' OR 
					`LOAD_LOGPROOF` IS NULL OR 
					`SPLIT_LOGPROOF` = '.$detail_file.' OR 
					`SPLIT_LOGPROOF` IS NULL OR 
					`JOIN_LOGPROOF_CDR` = '.$detail_file.' OR 
					`JOIN_LOGPROOF_CDR` IS NULL OR 
					`DETAIL_LOGPROOF` = '.$detail_file.' OR 
					`DETAIL_LOGPROOF` IS NULL OR 
					`PTV_CIM_RATING` = '.$detail_file.' OR 
					`PTV_CIM_RATING` IS NULL OR 
					`REACH_BRAND` = '.$detail_file.' OR 
					`REACH_BRAND`  IS NULL OR 
					`REACH_AGENCY` = '.$detail_file.' OR 
					`REACH_AGENCY`  IS NULL OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`REACH_ADVERTISER`  IS NULL OR  
					`SUB_CAT` = '.$detail_file.' OR 
					`SUB_CAT`  IS NULL  ) 
					
					ORDER BY LOG_DATE DESC
					';
					
			}else{
				
			$query = 	'		SELECT * FROM `DAILY_LOGPROOF_M_JOBS_REPORT_MONTH`
					WHERE (
					`LOAD_LOGPROOF` = '.$detail_file.' OR 
					`SPLIT_LOGPROOF` = '.$detail_file.' OR 
					`JOIN_LOGPROOF_CDR` = '.$detail_file.' OR 
					`DETAIL_LOGPROOF` = '.$detail_file.' OR 
					`PTV_CIM_RATING` = '.$detail_file.' OR 
					`REACH_BRAND` = '.$detail_file.' OR 
					`REACH_AGENCY` = '.$detail_file.' OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`SUB_CAT` = '.$detail_file.'  ) 
					
					ORDER BY LOG_DATE DESC
					';
				
			}
		}
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function daily_filter_2($periode,$detail_file) {

		if($detail_file == 9){
			
			$query = 	'SELECT * FROM DAILY_LOGPROOF_U_JOBS_REPORT a
					WHERE 1=1 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC';
		}else{
			if($detail_file == 0 ){
				
				$query = 	'		SELECT * FROM `DAILY_LOGPROOF_U_JOBS_REPORT`
					WHERE (
					`LOAD_LOGPROOF` = '.$detail_file.' OR 
					`LOAD_LOGPROOF` IS NULL OR 
					`SPLIT_LOGPROOF` = '.$detail_file.' OR 
					`SPLIT_LOGPROOF` IS NULL OR 
					`JOIN_LOGPROOF_CDR` = '.$detail_file.' OR 
					`JOIN_LOGPROOF_CDR` IS NULL OR 
					`DETAIL_LOGPROOF` = '.$detail_file.' OR 
					`DETAIL_LOGPROOF` IS NULL OR 
					`PTV_CIM_RATING` = '.$detail_file.' OR 
					`PTV_CIM_RATING` IS NULL OR 
					`REACH_BRAND` = '.$detail_file.' OR 
					`REACH_BRAND`  IS NULL OR 
					`REACH_AGENCY` = '.$detail_file.' OR 
					`REACH_AGENCY`  IS NULL OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`REACH_ADVERTISER`  IS NULL OR  
					`SUB_CAT` = '.$detail_file.' OR 
					`SUB_CAT`  IS NULL  ) 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC
					';
					
			}else{
				
			$query = 	'		SELECT * FROM `DAILY_LOGPROOF_U_JOBS_REPORT`
					WHERE (
					`LOAD_LOGPROOF` = '.$detail_file.' OR 
					`SPLIT_LOGPROOF` = '.$detail_file.' OR 
					`JOIN_LOGPROOF_CDR` = '.$detail_file.' OR 
					`DETAIL_LOGPROOF` = '.$detail_file.' OR 
					`PTV_CIM_RATING` = '.$detail_file.' OR 
					`REACH_BRAND` = '.$detail_file.' OR 
					`REACH_AGENCY` = '.$detail_file.' OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`SUB_CAT` = '.$detail_file.'  ) 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC
					';
				
			}
		}
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function daily_filter_4($periode,$detail_file) {

		if($detail_file == 9){
			$query = 	'SELECT * FROM DAILY_CIM_JOBS_REPORT a
						WHERE 1=1 
						AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
						ORDER BY LOG_DATE DESC';
		}else{
			if($detail_file == 0 ){
				
					$query = 'SELECT * FROM `DAILY_CIM_JOBS_REPORT`
					WHERE (
					`LOAD_CIM` = '.$detail_file.' OR 
					`LOAD_CIM` IS NULL OR 
					`SPLIT_CIM` = '.$detail_file.' OR 
					`SPLIT_CIM` IS NULL OR 
					`DETAIL_CIM` = '.$detail_file.' OR 
					`DETAIL_CIM` IS NULL OR 
					`CIM_RATING` = '.$detail_file.' OR 
					`CIM_RATING` IS NULL OR 
					`REACH_PRODUCT` = '.$detail_file.' OR 
					`REACH_PRODUCT` IS NULL OR 
					`REACH_SECTOR` = '.$detail_file.' OR 
					`REACH_SECTOR` IS NULL OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`REACH_ADVERTISER` IS NULL OR  
					`REACH_PRODUCT_MONTHLY` = '.$detail_file.' OR  
					`REACH_PRODUCT_MONTHLY` IS NULL OR  
					`REACH_SECTOR_MONTHLY` = '.$detail_file.' OR  
					`REACH_SECTOR_MONTHLY` IS NULL OR  
					`REACH_ADVERTISER_MONTHLY` = '.$detail_file.' OR 
					`REACH_ADVERTISER_MONTHLY` IS NULL OR 
					`SUB_CAT` = '.$detail_file.' OR 
					`SUB_CAT` IS NULL OR 
					`DASHBOARD_POSTBUY`= '.$detail_file.'  OR 
					`DASHBOARD_POSTBUY` IS NULL  ) AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC ';
				
			}else{
				
				$query = 'SELECT * FROM `DAILY_CIM_JOBS_REPORT`
					WHERE (
					`LOAD_CIM` = '.$detail_file.' OR 
					`SPLIT_CIM` = '.$detail_file.' OR 
					`DETAIL_CIM` = '.$detail_file.' OR 
					`CIM_RATING` = '.$detail_file.' OR 
					`REACH_PRODUCT` = '.$detail_file.' OR 
					`REACH_SECTOR` = '.$detail_file.' OR 
					`REACH_ADVERTISER` = '.$detail_file.' OR  
					`REACH_PRODUCT_MONTHLY` = '.$detail_file.' OR  
					`REACH_SECTOR_MONTHLY` = '.$detail_file.' OR  
					`REACH_ADVERTISER_MONTHLY` = '.$detail_file.' OR 
					`SUB_CAT` = '.$detail_file.' OR 
					`DASHBOARD_POSTBUY`= '.$detail_file.'  ) AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC ';
				
			}
		}
		
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function daily_filter_3($periode) {

		$query = 	'SELECT * FROM DAILY_LOGPROOF_M_JOBS_REPORT a
					WHERE 1=1 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC';

		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function daily_filter_5($periode,$detail_file) {

		if($detail_file == 9){
		$query = 	'SELECT * FROM DAILY_RATECARD_JOBS_REPORT a
					WHERE 1=1 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC';
		}else{
			
			if($detail_file == 0 ){
				
				$query = '
				SELECT * FROM `DAILY_RATECARD_JOBS_REPORT`
				WHERE (
				`LOAD_RATECARD` = '.$detail_file.' OR 
				`LOAD_RATECARD` IS NULL OR 
				`CLEANSING_RATECARD` = '.$detail_file.' OR 
				`CLEANSING_RATECARD` IS NULL OR 
				`SPLIT_RATECARD` = '.$detail_file.' OR 
				`SPLIT_RATECARD` IS NULL OR 
				`DETAIL_RATECARD` = '.$detail_file.' OR 
				`DETAIL_RATECARD` IS NULL OR 
				`RATING_PERMINUTES` = '.$detail_file.' OR 
				`RATING_PERMINUTES` IS NULL OR 
				`MEDIAPLAN_RATING` = '.$detail_file.' OR 
				`MEDIAPLAN_RATING` IS NULL OR 
				`TVCC` = '.$detail_file.' OR  
				`TVCC` IS NULL OR  
				`AFTER_BEFORE` = '.$detail_file.' OR  
				`AFTER_BEFORE` IS NULL OR  
				`MIGRATION` = '.$detail_file.' OR  
				`MIGRATION` IS NULL OR  
				`AUDIENCE` = '.$detail_file.' OR 
				`AUDIENCE` IS NULL OR 
				`DASHBOARD_MEDIAPLAN` = '.$detail_file.'  OR
				`DASHBOARD_MEDIAPLAN` IS NULL  ) 
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC
				';
				
			}else{
				
				$query = '
				SELECT * FROM `DAILY_RATECARD_JOBS_REPORT`
				WHERE (
				`LOAD_RATECARD` = '.$detail_file.' OR 
				`CLEANSING_RATECARD` = '.$detail_file.' OR 
				`SPLIT_RATECARD` = '.$detail_file.' OR 
				`DETAIL_RATECARD` = '.$detail_file.' OR 
				`RATING_PERMINUTES` = '.$detail_file.' OR 
				`MEDIAPLAN_RATING` = '.$detail_file.' OR 
				`TVCC` = '.$detail_file.' OR  
				`AFTER_BEFORE` = '.$detail_file.' OR  
				`MIGRATION` = '.$detail_file.' OR  
				`AUDIENCE` = '.$detail_file.' OR 
				`DASHBOARD_MEDIAPLAN` = '.$detail_file.'  ) 
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" 
					ORDER BY LOG_DATE DESC
				';
				
				
			}
			
		}
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function daily($where,$periode,$pilihprog,$profile) {

		$query = 	'SELECT * FROM DAILY_JOBS_REPORT a
					WHERE 1=1 
					AND DATE_FORMAT(LOG_DATE,"%Y-%M")="'.$periode.'" '.$where.' 
					ORDER BY LOG_DATE DESC';

		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all2Ps($field,$where,$periode,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP a
					WHERE 1=1 
					AND TANGGAL="'.$periode.'" '.$where.' 
					AND ID_PROFILE = "'.$profile.'" 
					GROUP BY a.`'.$field.'`
					ORDER BY Spot DESC';
		}else {
					
					
			$query = '
				SELECT A.*, B.STATUS_J,C.CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = 1 
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" '.$where.' 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_CHECK_REPORT` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				LEFT JOIN DAILY_CHECK_CHANNEL C
				ON A.LOG_DATE = C.LOG_DATE
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
		}		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function filter_table($field,$periode,$type) {
		
		if($type == 1){
			$query = '
				SELECT A.*, B.STATUS_J, CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_CHECK_REPORT` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				LEFT JOIN DAILY_CHECK_CHANNEL C
				ON A.LOG_DATE = C.LOG_DATE
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
		}elseif($type == 5){
			
			$query = '
				SELECT A.*, B.STATUS_J, "" AS CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_CHECK_REPORT` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
			
		}elseif($type == 2){
			
			$query = '
				SELECT A.*, B.STATUS_J, "" AS CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_CIM_CHECK` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
			
		}elseif($type == 3){
			
			$query = '
				SELECT A.*, B.STATUS_J, "" AS CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_RATECARD_CHECK` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
			
		}elseif($type == 4){
			
			$query = '
				SELECT A.*, B.STATUS_J, "" AS CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_LOGPROOF_U_CHECK` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
			
		}elseif($type == 6){
			
			$query = '
				SELECT A.*, B.STATUS_J, "" AS CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				AND DATE_FORMAT(LOG_DATE,"%Y-%M")= "'.$periode.'" 
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_LOGPROOF_M_CHECK` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
			
		}elseif($type == 7){
			
			$query = '
				SELECT A.*, B.STATUS_J, "" AS CHANNEL FROM (
				SELECT * FROM DATASOURCE_CDR a
				WHERE DATA_TYPE = "'.$type.'"  
				ORDER BY LOG_DATE DESC
				) A LEFT JOIN 
				`DAILY_LOGPROOF_U_CHECK_MONTH` B 
				ON A.LOG_DATE = B.`LOG_DATE`
				GROUP BY A.LOG_DATE
				ORDER BY LOG_DATE DESC
			';
			
		}
	
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function filter_table2($field,$periode,$type) {
		
			
			if($type == 7){
				$query = '
				SELECT A.*, B.STATUS_J FROM (
	SELECT LOG_DATE AS NLOG_DATE, DATE_FORMAT(LOG_DATE,"%Y-%m") AS LOG_DATE,`FILE_NAME`,`DATA_TYPE`,`ROW_COUNT_FILE`,`ROW_COUNT_LOAD`,`ROW_COUNT_CLEANSING`,`FILESIZE`,`NOTE`,`DATE_LOAD`,`STATUS_FILE`,`FILE_TYPE`
				FROM DATASOURCE_CDR a
						WHERE 1=1 
						AND DATA_TYPE = 21
						ORDER BY LOG_DATE DESC
	) A LEFT JOIN `DAILY_LOGPROOF_U_CHECK_MONTH` B 
					ON A.NLOG_DATE = B.`LOG_DATE`
					ORDER BY LOG_DATE DESC
				';
			}else{
				$query = '
			SELECT A.*, B.STATUS_J FROM (
SELECT LOG_DATE AS NLOG_DATE, DATE_FORMAT(LOG_DATE,"%Y-%m") AS LOG_DATE,`FILE_NAME`,`DATA_TYPE`,`ROW_COUNT_FILE`,`ROW_COUNT_LOAD`,`ROW_COUNT_CLEANSING`,`FILESIZE`,`NOTE`,`DATE_LOAD`,`STATUS_FILE`,`FILE_TYPE`
			FROM DATASOURCE_CDR a
					WHERE 1=1 
					AND DATA_TYPE = 22
					ORDER BY LOG_DATE DESC
) A LEFT JOIN `DAILY_LOGPROOF_M_CHECK_MONTH` B 
				ON A.NLOG_DATE = B.`LOG_DATE`
				ORDER BY LOG_DATE DESC
			';
			}
			

			
	
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function get_file_prop($date_data,$type_jobs){
		
		
		$query = 'SELECT * FROM DATASOURCE_CDR a
					WHERE  LOG_DATE ="'.$date_data.'" AND DATA_TYPE = "'.$type_jobs.'" ';

		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
		
	}
	
	public function insert_queue_rep($date_data,$type_jobs){
		
		
		if($type_jobs == 4){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/fta_postbuy_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/postbuy_'.$date_data.' & ';
			$tpe_job = 2;
			$quo_job = 4;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$tpe_job."'  ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
			$query = "	UPDATE `DAILY_LOGPROOF_U_JOBS_REPORT` SET STATUS_J = 3 WHERE LOG_DATE = '".$date_data."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 5){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/fta_mediaplan_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/mediaplan_'.$date_data.' & ';
			$tpe_job = 3;
			$quo_job = 5;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$tpe_job."'  ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
			$query = "	UPDATE `DAILY_RATECARD_JOBS_REPORT` SET STATUS_J = 3 WHERE LOG_DATE = '".$date_data."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 1){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/daily_jobs_full.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/daily_jobs_full_'.$date_data.' & ';
			$tpe_job = 1;
			$quo_job = 1;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$tpe_job."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
			$query = "	UPDATE `DAILY_JOBS_REPORT` SET STATUS_J = 3 WHERE LOG_DATE = '".$date_data."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 0){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/daily_jobs_full.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/daily_jobs_full_'.$date_data.' & ';
			$tpe_job = 1;
			$quo_job = 0;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$tpe_job."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
			$query = "	UPDATE `DAILY_JOBS_REPORT` SET STATUS_J = 3 WHERE LOG_DATE = '".$date_data."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 2){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_'.$date_data.' & ';
			$tpe_job = 4;
			$quo_job = 2;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$tpe_job."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
			$query = "	UPDATE `DAILY_LOGPROOF_U_JOBS_REPORT` SET STATUS_J = 3 WHERE LOG_DATE = '".$date_data."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 3){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_mh_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_mh_'.$date_data.' & ';
			$tpe_job = 6;
			$quo_job = 3;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$tpe_job."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
			$query = "	UPDATE `DAILY_LOGPROOF_M_JOBS_REPORT` SET STATUS_J = 3 WHERE LOG_DATE = '".$date_data."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}
		
	
		
		$query = "	INSERT INTO JOBS_QUEUE VALUES('".$date_data."','".$desc."',NULL,NULL,2,'".date("Y-m-d H:i:s")."',".$quo_job.",NULL,NULL,2,'')  ";	
		
		
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		
	}
	
	public function insert_queue_check($tahun,$queue_id,$sc_duplicate,$tbs){
		
		$query = "	INSERT INTO JOBS_QUEUE VALUES('".$tahun."','".$sc_duplicate."',NULL,NULL,2,'".date("Y-m-d H:i:s")."',".$queue_id.",NULL,NULL,2,'')  ";	
		
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		
		
		$script_insert_new_date = ' UPDATE '.$tbs.' SET STATUS_J = 4  WHERE LOG_DATE = "'.$tahun.'" ' ; 
		
		
		$sql	= $this->db2->query($script_insert_new_date);
		$this->db2->close();
		$this->db2->initialize(); 
		
	}
	
	public function insert_queue_f($date_data,$type_jobs){
		
		
		if($type_jobs == 2){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/fta_postbuy_jobs_re.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/postbuy__re_'.$date_data.' & ';
			$tpe_job = 2;
			$quo_job = 4;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'  ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 3){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/fta_mediaplan_jobs_re.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/mediaplan_re_'.$date_data.' & ';
			$tpe_job = 3;
			$quo_job = 5;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'  ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 1){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/daily_jobs_cdr_re.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/daily_jobs_cdr_re_'.$date_data.' & ';
			$tpe_job = 1;
			$quo_job = 1;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 5){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/daily_jobs_epg_re.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/daily_jobs_epg_re_'.$date_data.' & ';
			$tpe_job = 1;
			$quo_job = 0;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 4){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_jobs_re.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_re_'.$date_data.' & ';
			$tpe_job = 4;
			$quo_job = 2;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 6){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_mh_jobs_re.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_mh_re_'.$date_data.' & ';
			$tpe_job = 6;
			$quo_job = 3;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}
		
	
		
		$query = "	INSERT INTO JOBS_QUEUE VALUES('".$date_data."','".$desc."',NULL,NULL,2,'".date("Y-m-d H:i:s")."',".$quo_job.",NULL,NULL,2,'')  ";	
		
		
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		
	}
	
	public function insert_queue($date_data,$type_jobs){
		
		
		if($type_jobs == 2){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/fta_postbuy_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/postbuy_'.$date_data.' & ';
			$tpe_job = 2;
			$quo_job = 4;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'  ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 3){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/fta_mediaplan_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/mediaplan_'.$date_data.' & ';
			$tpe_job = 3;
			$quo_job = 5;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'  ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 1){
			
		$desc = ' php /var/www/jobs/steve/JOBS/testing/zte/daily_jobs_cdr_zte.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/daily_jobs_cdr_'.$date_data.' & ';
			
			$tpe_job = 1;
			$quo_job = 1;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."' ";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 5){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/daily_jobs_epg.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/daily_jobs_epg_'.$date_data.' & ';
			$tpe_job = 1;
			$quo_job = 0;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 4){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_'.$date_data.' & ';
			$tpe_job = 4;
			$quo_job = 2;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 6){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_mh_jobs.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_mh_'.$date_data.' & ';
			$tpe_job = 6;
			$quo_job = 3;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 7){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_jobs_month.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_jobs_month_'.$date_data.' & ';
			$tpe_job = 7;
			$quo_job = 7;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}elseif($type_jobs == 8){
			
			$desc = ' php /var/www/jobs/steve/JOBS/fix_jobs/ptv_postbuy_mh_jobs_month.php '.$date_data.' > /var/www/jobs/steve/JOBS/fix_jobs/log_jobs/ptv_postbuy_mh_jobs_month_'.$date_data.' & ';
			$tpe_job = 8;
			$quo_job = 8;
			
			$query = "	Update DATASOURCE_CDR set STATUS_FILE = 4 WHERE LOG_DATE = '".$date_data."' AND DATA_TYPE = '".$type_jobs."'";	

			$sql	= $this->db2->query($query);
			$this->db2->close();
			$this->db2->initialize(); 
			
		}
		
	
		
		$query = "	INSERT INTO JOBS_QUEUE VALUES('".$date_data."','".$desc."',NULL,NULL,2,'".date("Y-m-d H:i:s")."',".$quo_job.",NULL,NULL,2,'')  ";	
		
		
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		
	}
	
	public function list_spot_by_program_all2Ps_hari_date($field,$where,$periode,$tgl,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY a 
			WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$tgl.'" 
			AND ID_PROFILE = "'.$profile.'" 
			ORDER BY Spot DESC ';
		}else {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DAYS a
				WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$tgl.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
		}		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}

	public function list_spot_by_daytime_all2($where,$periode) {
		$query = "SELECT PRIME,VIEWERS FROM M_SUM_TV_DASH_PRIME
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 
					 ORDER BY PRIME DESC	";
								 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_prime_all2($where,$periode) {
		$query = "SELECT PRIME,VIEWERS FROM M_SUM_TV_DASH_PRIME
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 
					 ORDER BY PRIME DESC	";
								 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	

	public function list_spot_by_daypart($where,$periode) {
		$query = "SELECT TIME,VIEWERS FROM M_SUM_TV_DASH_TIME
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 
					 ORDER BY VIEWERS DESC	";
					
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_date_all2($where,$periode) {
		$query = 'SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE
				  WHERE 1=1 AND TANGGAL="'.$periode.'" '.$where.' 
				  
				  ORDER BY DATE';			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}

	public function get_corres(){
		
		$query = "SELECT SUM(WEIGHT) AS CORESSPONDENT FROM SINGLE_SOURCE_VALUE";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
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
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
						
	public function list_spot_by_date_all($where) {
		$query = 'SELECT a.TANGGAL as date,COUNT(a.TANGGAL) AS spot FROM CGI a WHERE 1=1 '.$where.'
					GROUP BY a.TANGGAL
					ORDER BY a.TANGGAL';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	
	public function list_populasi2new() {
		
		$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR_JAN18" ';
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_spot_by_daytime_all($where) {
		$query = "SELECT tb_cgi.htype, COUNT(tb_cgi.htype) AS spot FROM
						(SELECT *, ( CASE WHEN 
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
							 END) AS htype FROM CGI a Where 1=1 ".$where.") AS tb_cgi 
						 GROUP BY tb_cgi.htype
						 ORDER BY spot DESC";  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
					
	public function list_spot_by_adstype_all($where) {
		$query = 'SELECT a.`ads_type`,COUNT(DATE) AS spot FROM CGI_TVR a Where 1=1 '.$where.'
					GROUP BY a.`ads_type`
					ORDER BY spot DESC';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
		
	public function list_spot_by_program_all($field,$where) {
		if ($field=='Product') {
			$query = 'SELECT product as Product,Spot FROM t_spot_by_program_all_new WHERE 1=1 '.$where.' ';  			
		}
		elseif ($field=='Program') {
			$query = 'SELECT program as Program,Spot FROM t_spot_by_program_all_kanan_new WHERE 1=1 '.$where.' ';  			
		}
		else{
			$query = 'SELECT a.'.$field.', COUNT(a.`rate`) AS Spot FROM CGI a Where 1=1 '.$where.'
						GROUP BY a.'.$field.'
						ORDER BY Spot DESC';
		}
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	public function list_spot_by_program_all2($field,$where,$periode) {
		$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL, COUNT(a.GRP) AS Spot FROM M_SUM_TV_DASH a RIGHT JOIN `P_CHANNEL_ADS_USEETV` b ON a.`CHANNEL` = b.`CHANNEL_NAME`
				WHERE 1=1 AND b.`FLAG_TV` = 0 
				
				AND TANGGAL="'.$periode.'" '.$where.'
					GROUP BY a.`'.$field.'`
					ORDER BY Spot DESC';  
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	
	public function list_spot_by_chanel_all2($where) {
		$query = 'SELECT a.`channel`, SUM(tvr) AS spot FROM NEW_MEDIA_PLANNING a 
						where 1=1 '.$where.'
						GROUP BY a.`channel` 
						ORDER BY spot DESC';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
		
	public function list_cost_all2($where) {
		$query = 'SELECT SUM(rate) AS cost FROM NEW_MEDIA_PLANNING where 1=1 '.$where.'';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp($periode) {
		$query = 'SELECT COUNT(GRP) AS grp FROM M_SUM_TV_DASH WHERE TANGGAL="'.$periode.'" ';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function check_stat() {

		$query = 'SELECT val_int AS check_st FROM T_PARAM_UNICS WHERE NAME = "CHECK_FILE" ';

		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	} 

	public function list_populasi2($periode) {
		$date=date_create($periode);
		$pr = strtoupper(date_format($date,"My"));
		
		$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR_'.$pr.'" ';
		
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_populasi() {
		$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM NEW_CDR_LIVE_CLEAN_CS';
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_spot_all2($where,$periode) {
		$query = 'SELECT COUNT(`PROGRAM`) AS spot FROM M_SUM_TV_DASH_PROG WHERE 1=1 AND ID_PROFILE = 0 AND TANGGAL="'.$periode.'" '.$where.' '; 


		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_sector() {
		$query = 'SELECT a.SECTOR FROM t_sector_cgi a ORDER BY a.SECTOR';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function list_category() {
		$query = 'SELECT  a.CATEGORY FROM t_category_cgi a ORDER BY a.CATEGORY';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_advertiser() {
		$query = 'SELECT  a.ADVERTISER FROM t_advertiser_cgi a ORDER BY a.ADVERTISER';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_product() {
		$query = 'SELECT a.PRODUCT FROM t_product_cgi_new a ORDER BY a.PRODUCT LIMIT 500';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function ambildata() {
		
		$query = 'SELECT a.*, b.tvr 
					FROM CGI a
					LEFT JOIN NEW_MEDIA_PLANING b ON a.`program`=b.`program` AND a.`TANGGAL` = b.`TANGGAL` limit 10000
					';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$hasil = $sql->result_array();	 

		foreach($hasil as $new){
			print_r($new); 
		}	
		die;
		
	}
	
	public function list_postbuy($params = array()) {		
		
		$sql		=  ' SELECT COUNT(DISTINCT(pm.USER_ID)) AS rate, pm.channel AS CH_PM, epg.channel AS CH_EPG, epg.program, epg.date, pm.begin_session, pm.end_session  ,
		epg.start_time AS START_EPG ,epg.end_time  AS END_EPG, tcn.product, tcn.start_time AS times, tcn.duration
		FROM t_people_meter AS pm , t_epg AS epg, t_cgi_new AS tcn
		
		ORDER BY tcn.start_time ASC
		LIMIT '.$params['limit'].'
		OFFSET '.$params['offset'].'';
		$out		= array();
		$query		= $this->db2->query($sql,
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
		
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}

		$total_filtered = $this->db2->query('SELECT FOUND_ROWS() AS total_filtered ')->row_array();
		$total 			= $this->db2->query('SELECT 
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
		
		$query 	=  $this->db2->query($sql);
		
		$return = $query->result_array();
		return $return;
	}	

	public function list_grp_by_program_all($field,$where) {
		$query = 'SELECT a.'.$field.',channel, COUNT(DISTINCT (a.`tvr`)) AS GRP FROM CGI_TVR a Where 1=1 '.$where.'
						GROUP BY a.'.$field.'
						ORDER BY GRP DESC';  	

						
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	public function count_channel() {

		$query = 'SELECT COUNT(DISTINCT (CHANNEL_NAME)) jmlch FROM CHANNEL_PARAM WHERE F2A_STATUS = 1 ';  			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
}	
