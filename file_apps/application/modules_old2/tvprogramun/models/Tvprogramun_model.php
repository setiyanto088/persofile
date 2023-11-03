<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('db_prod', TRUE);
		
	}
	
	public function get_profile($iduser,$idrole,$periode) {  
		 
			$i0 =  date_format(date_create($periode),"Y-m");
 			
			$sql = "SELECT A.* FROM ( 
					SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a WHERE (STATUS = 1 OR STATUS = 3)  
					AND user_id_profil IN (".$iduser.",0)  ORDER BY `name`
					) A JOIN
					`M_MONTH_PROFILE`  B ON A.id = B.`PROFILE_ID`
					WHERE B.`PERIODE` = '".$i0."' AND B.`STATUS_PROCESS` = 1
					";
 
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_tahun(){
		
 		 $query = "SELECT DISTINCT(TANGGAL) FROM M_SUM_TV_DASH_ACTIVE ORDER BY STR_TO_DATE(TANGGAL,'%Y-%M') DESC" ;
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_bulan(){
		
		$query = "SELECT DISTINCT SUBSTR(TANGGAL,6) bulan FROM M_SUM_TV_DASH_ACTIVE ORDER BY STR_TO_DATE(TANGGAL, '%Y-%M')";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_week_channel($periode){
		
		$query = "SELECT DISTINCT WEEK as WEEK FROM M_SUM_TV_DASH_CHAN_WEEK WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS UNSIGNED )";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	public function get_week_program($periode){
		
		$query = "SELECT DISTINCT WEEK as WEEK FROM M_SUM_TV_DASH_PROG_WEEK WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS UNSIGNED )";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_active_audience($periode){
		
 		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE WHERE  TANGGAL= '".$periode."'" ;
 		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function list_spot_by_program_all_bar_excel($field,$where,$periode,$pilihaudiencebar,$profile) {
		$query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL="'.$periode.'" '.$where.'
					ORDER BY Spot DESC ';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY grp DESC '; 
			}else {
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY VIEWERS DESC ';  	 
			}
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
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
  		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
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
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
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
		$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a
					WHERE 1=1 
					AND ID_PROFILE = "'.$profile.'" 
					AND TANGGAL="'.$periode.'" '.$where.' 
					GROUP BY a.`'.$field.'`
					ORDER BY Spot DESC';
		}		
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
 	public function list_spot_by_program_all2Ps_hari($field,$where,$periode,$week,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK a 
			WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
			AND ID_PROFILE = "'.$profile.'" 
			ORDER BY Spot DESC ';
 		}else {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
 		}		
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
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
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	

 	public function list_spot_by_daytime_all2($where,$periode) {
		$query = "SELECT PRIME,VIEWERS FROM M_SUM_TV_DASH_PRIME
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 
					 ORDER BY PRIME DESC	";
		 	 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	

 	public function list_spot_by_daypart($where,$periode) {
		$query = "SELECT TIME,VIEWERS FROM M_SUM_TV_DASH_TIME
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 
					 ORDER BY VIEWERS DESC	";
		
 					
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
 	public function list_spot_by_date_all2($where,$periode) {
		$query = 'SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE
				  WHERE 1=1 AND TANGGAL="'.$periode.'" '.$where.' 
				  
				  ORDER BY DATE';
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function get_corres(){
		
		$query = "SELECT SUM(WEIGHT) AS CORESSPONDENT FROM SINGLE_SOURCE_VALUE";
		 
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
						
	public function list_spot_by_date_all($where) {
		$query = 'SELECT a.TANGGAL as date,COUNT(a.TANGGAL) AS spot FROM CGI a WHERE 1=1 '.$where.'
					GROUP BY a.TANGGAL
					ORDER BY a.TANGGAL';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	
	
	public function list_populasi2new($dateftr) {
		 
			
				$data_file =$dateftr;
				$date_epg = str_replace("-","",$data_file);
				
				$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
				$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
				$name_cim_file = date_format(date_create($data_file),"d M Y"); //01 Mar 2018
				$periode =date_format(date_create($data_file),"Y-F"); //2018-March
				$my =date_format(date_create($data_file),"Y-m");
		
		$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE name = "UNIVERSE_CDR_'.$name_tbs.'" AND type_data = 0  ';
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
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
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	
					
	public function list_spot_by_adstype_all($where) {
		$query = 'SELECT a.`ads_type`,COUNT(DATE) AS spot FROM CGI_TVR a Where 1=1 '.$where.'
					GROUP BY a.`ads_type`
					ORDER BY spot DESC';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
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
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	public function list_spot_by_program_all2($field,$where,$periode) {
		$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL, COUNT(a.GRP) AS Spot FROM M_SUM_TV_DASH a RIGHT JOIN `P_CHANNEL_ADS_USEETV` b ON a.`CHANNEL` = b.`CHANNEL_NAME`
				WHERE 1=1 AND b.`FLAG_TV` = 0 
				
				AND TANGGAL="'.$periode.'" '.$where.'
					GROUP BY a.`'.$field.'`
					ORDER BY Spot DESC';  
	 
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
		
	public function list_cost_all2($where) {
		$query = 'SELECT SUM(rate) AS cost FROM NEW_MEDIA_PLANNING where 1=1 '.$where.'';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_grp($periode) {
		$query = 'SELECT COUNT(GRP) AS grp FROM M_SUM_TV_DASH WHERE TANGGAL="'.$periode.'" ';  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function list_populasi2($periode) {
	 
		$date=date_create($periode);
		$pr = strtoupper(date_format($date,"My"));
		
		$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR_'.$pr.'" AND TYPE_DATA = 0 ';
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_populasi() {
 		$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM NEW_CDR_LIVE_CLEAN_CS';
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_spot_all2($where,$periode) {
		$query = 'SELECT COUNT(`PROGRAM`) AS spot FROM M_SUM_TV_DASH_PROG WHERE 1=1 AND ID_PROFILE = 0 AND TANGGAL="'.$periode.'" '.$where.' '; 
	 
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

	public function list_grp_by_program_all($field,$where) {
		$query = 'SELECT a.'.$field.',channel, COUNT(DISTINCT (a.`tvr`)) AS GRP FROM CGI_TVR a Where 1=1 '.$where.'
						GROUP BY a.'.$field.'
						ORDER BY GRP DESC';  	

 						
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	public function count_channel() {
 

		$query = 'SELECT COUNT(DISTINCT (CHANNEL_NAME)) jmlch FROM CHANNEL_PARAM WHERE F2A_STATUS = 1 ';  			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
}	
