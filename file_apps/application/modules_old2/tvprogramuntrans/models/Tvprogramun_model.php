<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		 $this->db = $this->load->database('db_prod', TRUE);
		
	}
	
	public function get_profile($iduser,$idrole,$periode) {  
		// if ($idrole==18) {
			// $sql = "SELECT id, `name`, grouping, postbuy_status FROM t_profiling_ub2 WHERE (STATUS = 1 OR STATUS = 3) and postbuy_status = '2'  and status_dash = 3 order by `name`";
		// } else {
			// $sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a INNER JOIN hrd_profile b ON a.user_id_profil=b.id WHERE (STATUS = 1 OR STATUS = 3) and postbuy_status = '2'  AND user_id_profil=".$iduser."  and status_dash = 3 order by `name` ";
		// }	
		
		$i0 =  date_format(date_create($periode),"Y-m");
			//echo $i0;die;
			
			$sql = "SELECT A.* FROM ( 
					SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a WHERE (STATUS = 1 OR STATUS = 3)  
					AND user_id_profil IN (".$iduser.",0)  ORDER BY `name`
					) A JOIN
					`M_MONTH_PROFILE_RES`  B ON A.id = B.`PROFILE_ID`
					WHERE B.`PERIODE` = '".$i0."' AND B.`STATUS_PROCESS` = 1
					";
		
		//echo $sql;die;
		//$sql = "SELECT id,name FROM  t_profiling_ub where postbuy_status <> '' AND postbuy_status <> '1' ";
		//$sql = "SELECT id,name FROM  t_profiling_ub where postbuy_status = '2' ";
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_tahun(){
		
		$query = "SELECT DISTINCT(PERIODE_STR)  TANGGAL FROM T_PERIODE_TRANS WHERE PERIODE > 30 ORDER BY PERIODE DESC";
		// $query = "SELECT DISTINCT(TANGGAL)  TANGGAL FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL,'%Y-%M') DESC";
		  // $query = "SELECT DISTINCT(TANGGAL) FROM M_SUM_TV_DASH_ACTIVE ORDER BY STR_TO_DATE(TANGGAL,'%Y-%M') DESC" ;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	public function get_periode_date($periode){
		
		$query = "SELECT MIN(`DATE`) AS STR_TGL ,MAX(`DATE`) AS END_TGL FROM `M_SUM_TV_DASH_CHAN_DAY_RES` 
					WHERE `TANGGAL` = '".$periode."' ";
		// $query = "SELECT DISTINCT(TANGGAL)  TANGGAL FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL,'%Y-%M') DESC";
		  // $query = "SELECT DISTINCT(TANGGAL) FROM M_SUM_TV_DASH_ACTIVE ORDER BY STR_TO_DATE(TANGGAL,'%Y-%M') DESC" ;
		  //echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_bulan(){
		
		$query = "SELECT DISTINCT SUBSTR(TANGGAL,6) bulan FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL, '%Y-%M')";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function get_week_channel($periode){
		
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_CHAN_PTV_WEEK WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS UNSIGNED )";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	public function channel_list($periode){
		
		$query = "SELECT DISTINCT `CHANNEL` FROM M_SUM_TV_DASH_CHAN_RES WHERE TANGGAL='".$periode."' AND CHANNEL <> '' ORDER BY CHANNEL ";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_week_program($periode){
		
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_PROG_WEEK_PTV WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS UNSIGNED )";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_active_audience($periode){
		
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_OTHER_RES WHERE TANGGAL= '".$periode."' AND TYPE_FIELD = 'ACTIVE AUDIENCE' AND `STATUS` = 1  "  ;
		// $query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE WHERE TANGGAL= '".$periode."'" ;
		
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_active_audience2($periode){
		
		//$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_OTHER_RES WHERE TANGGAL= '".$periode."' AND TYPE_FIELD = 'ACTIVE AUDIENCE2' AND `STATUS` = 1  "  ;
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE_PTV WHERE TANGGAL= '".$periode."'" ;
		
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function list_spot_by_program_all_bar_x($field,$where,$periode,$pilihaudiencebar,$profile) {
		$query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL="'.$periode.'" '.$where.'
					ORDER BY Spot DESC ';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY grp DESC'; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='Duration')	 {

				$query = 'SELECT * FROM ( SELECT RANK() OVER (
				ORDER BY VIEWERS DESC, R.channel ASC
				) rangking , CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" 
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY VIEWERS DESC
					) A WHERE channel LIKE "%'.$where.'%" 
					'; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = '
				SELECT * FROM (
				SELECT RANK() OVER (
				ORDER BY (A.Spot_a/B.tot_spot)*100 DESC, A.channel ASC
				) rangking ,A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM (
				SELECT CHANNEL as channel,VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'"
				 AND R.ID_PROFILE = "'.$profile.'" 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot  FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'"
				 AND R.ID_PROFILE = "'.$profile.'" 
				) B
				 ORDER BY Spot_a DESC
				  ) P WHERE channel LIKE "%'.$where.'%" 
				 '; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = 'SELECT * FROM ( SELECT RANK() OVER (
				ORDER BY B.Spot/A.Spot DESC, A.channel ASC
				) rangking ,A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL="'.$periode.'"
				 AND R.ID_PROFILE = "'.$profile.'" ) A,
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" 
				 AND R.ID_PROFILE = "'.$profile.'" ) B 
				 WHERE A.channel = B.channel
				 GROUP BY A.channel
				 order by  B.Spot/A.Spot DESC
				 ) P WHERE channel LIKE "%'.$where.'%" 
				 '; 

			}else{
				$query = ' SELECT * FROM ( SELECT RANK() OVER (
				ORDER BY VIEWERS DESC, CHANNEL ASC
				) rangking ,CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" 
				 AND R.ID_PROFILE = "'.$profile.'" 
					ORDER BY VIEWERS DESC 
					) A WHERE channel LIKE "%'.$where.'%" 
					';  	
			}
		//echo $query;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
		//Dashboard Audience by Channel
	public function list_spot_by_program_all_bar_alls($field,$where,$periode,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
				
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
					ORDER BY VIEWERS DESC ';  	
				
				
				$query = '
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS2 AS VIEWERS, 
					C.VIEWERS2 AS TVR , 
					D.VIEWERS2 AS TVS,
					E.VIEWERS2 AS `INDEX`,
					F.VIEWERS2 AS REACH  
					FROM (

						SELECT * FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
						 R.TANGGAL="'.$periode.'"  '.$where.' 
						 AND R.ID_PROFILE = '.$profile.'
						 AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
						ORDER BY VIEWERS DESC 
										
					) A LEFT JOIN (

						SELECT * FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
						R.TANGGAL="'.$periode.'"  '.$where.' 
						AND R.ID_PROFILE = '.$profile.'
						AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
						ORDER BY VIEWERS DESC 
					) B ON A.CHANNEL = B.CHANNEL LEFT JOIN (

						SELECT * FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
						R.TANGGAL="'.$periode.'"  '.$where.' 
						AND R.ID_PROFILE = '.$profile.'
						AND `STATUS` = 1 AND DATA_TYPE = "TVR"
						ORDER BY VIEWERS DESC 
					) C ON A.CHANNEL = C.CHANNEL LEFT JOIN (

						SELECT * FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
						R.TANGGAL="'.$periode.'"  '.$where.' 
						AND R.ID_PROFILE = '.$profile.'
						AND `STATUS` = 1 AND DATA_TYPE = "TVS"
						ORDER BY VIEWERS DESC 
					) D ON A.CHANNEL = D.CHANNEL LEFT JOIN (

						SELECT * FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
						R.TANGGAL="'.$periode.'"  '.$where.' 
						AND R.ID_PROFILE = '.$profile.'
						AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
						ORDER BY VIEWERS DESC 
					) E ON A.CHANNEL = E.CHANNEL LEFT JOIN (

						SELECT * FROM M_SUM_TV_DASH_CHAN_TRANS R WHERE 
						R.TANGGAL="'.$periode.'"  '.$where.' 
						AND R.ID_PROFILE = '.$profile.'
						AND `STATUS` = 1 AND DATA_TYPE = "REACH"
						ORDER BY VIEWERS DESC 
					) F ON A.CHANNEL = F.CHANNEL 
					WHERE 1=1 '.$wh_chn.'

					ORDER BY C.VIEWERS2 DESC

				'; 
			
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	//Dashboard Audience by Channel
	public function list_spot_by_program_all_bar($field,$where,$periode,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		$query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL="'.$periode.'" '.$where.' '.$wh_chn.' 
					ORDER BY Spot DESC ';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY grp DESC'; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='Duration')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = '
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM (
				SELECT CHANNEL as channel,VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot  FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				) B
				 ORDER BY Spot_a DESC'; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = 'SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL="'.$periode.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'  ) A,
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'  ) B 
				 WHERE A.channel = B.channel
				 GROUP BY A.channel
				 order by  B.Spot/A.Spot DESC'; 

			}elseif ($pilihaudiencebar=='tvr')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "TVR"
					ORDER BY VIEWERS DESC ';  	

			}elseif ($pilihaudiencebar=='tvs')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "TVS"
					ORDER BY VIEWERS DESC ';  	

			}elseif ($pilihaudiencebar=='audience')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
					ORDER BY VIEWERS DESC ';  	

			}elseif ($pilihaudiencebar=='idx')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
					ORDER BY VIEWERS DESC ';  	

			}elseif ($pilihaudiencebar=='Reach')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "Reach"
					ORDER BY VIEWERS DESC ';  	

			}elseif ($pilihaudiencebar=='audience2'){
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
					ORDER BY VIEWERS DESC ';  	
			}else{
				
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
					ORDER BY VIEWERS DESC ';  	
				
			}
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all_bar_avg($field,$where,$periode,$pilihaudiencebar,$profile,$check,$start_date,$end_date) {
		
		$data_file = $periode;
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		$query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL="'.$periode.'" '.$where.' '.$wh_chn.' 
					ORDER BY Spot DESC ';  
					
			if ($pilihaudiencebar=='tvr')	 {

				$query = 'SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot,AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
				 AND `STATUS` = 1 AND DATA_TYPE = "TVR"
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC ';  	

			}elseif ($pilihaudiencebar=='tvs')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
				 AND `STATUS` = 1 AND DATA_TYPE = "TVS"
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC ';  		

			}elseif ($pilihaudiencebar=='audience')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
				 AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC ';  	  	 

			}elseif ($pilihaudiencebar=='Reach')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
				 AND `STATUS` = 1 AND DATA_TYPE = "REACH"
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC ';  	  	 

			}elseif ($pilihaudiencebar=='idx')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'" 
				 AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC ';  		

			}else{
				
				if($profile == 0){
					$query = "
					SELECT `CHANNEL` AS channel,AVG(Spot) AS Spot,AVG(Spot2) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
						SELECT `CHANNEL` as channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
						SELECT DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, '".$periode."' PERIODE, 0 STS 
						FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2` A
						WHERE 
						(
							A.`BEGIN_PROGRAM` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
							
						)
						GROUP BY A.RESPID,`CHANNEL`	,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
						) O
						GROUP BY `CHANNEL`,HARIS
						) GROUP BY `CHANNEL`
						ORDER BY AVG(Spot) DESC
					";  	 	
				}else{
					
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
					
					$query = "
						
							SELECT `CHANNEL` AS channel,AVG(Spot) AS Spot,AVG(Spot2) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
						SELECT `CHANNEL` as channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
						SELECT DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, '".$periode."' PERIODE, 0 STS 
						FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2` A
						WHERE 
						A.RESPID IN (".$sql_c.") AND 
						(
							A.`BEGIN_PROGRAM` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
						)
						GROUP BY A.RESPID,`CHANNEL`	,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d')
						) O
						GROUP BY `CHANNEL`,HARIS
						) GROUP BY `CHANNEL`
						ORDER BY AVG(Spot) DESC
						
						
					";  	 	
					
				}
			}
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all_bar_avg_alls($field,$where,$periode,$pilihaudiencebar,$profile,$check,$start_date,$end_date) {
		
		$data_file = $periode;
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		// if($profile == 0){
			
			$prof_qr = '
						
						
						SELECT `CHANNEL_NAME` AS CHANNEL,COUNT(DISTINCT(`SUBSCRIBER`)) AS VIEWERS2,
						"'.$periode.'"  AS periode,"AUDIENCE" AS DT, 0 IDPRO, 1 STS 
						FROM `TRANSVISION_RAW_DATA_v2_SPLIT`
						WHERE DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d") BETWEEN "'.$start_date.'" AND "'.$end_date.'"
						'.$where.' '.$wh_chn.' 
						GROUP BY `CHANNEL_NAME`
			
			';
			
		// }else{
			// $sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$profile; 
			// $prof_qr = '
			
						// SELECT `CHANNEL` ,AVG(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
						// SELECT `CHANNEL` AS channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
						// SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$periode.'" PERIODE, 0 STS 
						// FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A
						// WHERE 
						// A.RESPID IN ('.$sql_c.') AND 
						// (
							// A.`BEGIN_PROGRAM` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
							
						// )
						// '.$where.' '.$wh_chn.' 
						
						// GROUP BY A.RESPID,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
						// ) O
						// GROUP BY `CHANNEL`,HARIS
						// ) GROUP BY `CHANNEL`
			
			// ';
			
		// }
		
		$query = '
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS2 AS VIEWERS, 
					C.VIEWERS2 AS TVR , 
					D.VIEWERS2 AS TVS,
					E.VIEWERS2 AS `INDEX`,
					F.VIEWERS2 AS REACH  
					FROM (

						'.$prof_qr.'
					
						) A LEFT JOIN (

							SELECT CHANNEL,AVG(VIEWERS2) VIEWERS2 FROM M_SUM_TV_DASH_CHAN_DAY_TRANS R WHERE 
							R.TANGGAL="'.$periode.'"  
							AND R.ID_PROFILE = 0 '.$where.' '.$wh_chn.' 
							AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
							GROUP BY CHANNEL
						) B ON A.CHANNEL = B.CHANNEL LEFT JOIN (

							SELECT CHANNEL,AVG(VIEWERS2) VIEWERS2 FROM M_SUM_TV_DASH_CHAN_DAY_TRANS R WHERE 
							R.TANGGAL="'.$periode.'"  
							AND R.ID_PROFILE = 0 '.$where.' '.$wh_chn.' 
							AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							AND `STATUS` = 1 AND DATA_TYPE = "TVR"
							GROUP BY CHANNEL
						) C ON A.CHANNEL = C.CHANNEL LEFT JOIN (

							SELECT CHANNEL,AVG(VIEWERS2) VIEWERS2 FROM M_SUM_TV_DASH_CHAN_DAY_TRANS R WHERE 
							R.TANGGAL="'.$periode.'"  
							AND R.ID_PROFILE = 0 '.$where.' '.$wh_chn.' 
							AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							AND `STATUS` = 1 AND DATA_TYPE = "TVS"
							GROUP BY CHANNEL
						) D ON A.CHANNEL = D.CHANNEL LEFT JOIN (

							SELECT CHANNEL,AVG(VIEWERS2) VIEWERS2 FROM M_SUM_TV_DASH_CHAN_DAY_TRANS R WHERE 
							R.TANGGAL="'.$periode.'"  
							AND R.ID_PROFILE = 0 '.$where.' '.$wh_chn.' 
							AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
							GROUP BY CHANNEL
						) E ON A.CHANNEL = E.CHANNEL LEFT JOIN (

							SELECT CHANNEL,AVG(VIEWERS2) VIEWERS2 FROM M_SUM_TV_DASH_CHAN_DAY_TRANS R WHERE 
							R.TANGGAL="'.$periode.'"  
							AND R.ID_PROFILE = 0 '.$where.' '.$wh_chn.' 
							AND R.DATE BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							AND `STATUS` = 1 AND DATA_TYPE = "REACH"
							GROUP BY CHANNEL
						) F ON A.CHANNEL = F.CHANNEL 

						ORDER BY A.VIEWERS2 DESC

		
		';  
					
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all_bar_tvod($field,$where,$periode,$pilihaudiencebar,$profile,$check,$tipe_filter) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
				$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		$query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL="'.$periode.'" '.$where.' '.$wh_chn.' 
					ORDER BY Spot DESC ';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY grp DESC'; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "TOTAL_VIEWS"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='Duration')	 {

					$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "DURATION"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = '
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM (
				SELECT CHANNEL as channel,VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "DURATION"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot  FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "DURATION"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				) B
				 ORDER BY Spot_a DESC'; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = 'SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(

SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "VIEWERS"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 
				 ) A,
(

SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "DURATION"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 
				 ) B
				 
				 WHERE A.channel = B.channel
				 GROUP BY A.channel
				 order by  B.Spot/A.Spot DESC'; 

			}else{
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.'
				 AND R.TIPE_VIEW = "VIEWERS"
				 AND R.TIPE_FILTER = "'.$tipe_filter.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					ORDER BY VIEWERS DESC';
			}
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	//Dashboard Audience Hari by Channel
	public function list_spot_by_program_hari_bar($field,$where,$periode,$week,$pilihaudiencebar,$profile,$check) {
		//echo $start_date;
		//echo $end_date;
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
					
			if 	($pilihaudiencebar=='Reach')	 {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_PTV_WEEK 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
				
				//$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP R WHERE	 R.TANGGAL="'.$periode.'" '.$where.' ORDER BY grp DESC LIMIT 15'; 
			}elseif ($pilihaudiencebar=='Viewers') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='Duration') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='share') {
				$query = '
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM ( 
					SELECT CHANNEL as channel, VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV 
					WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
					AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				) A,
				(
					SELECT SUM(VIEWERS) AS tot_spot FROM M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV 
					WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
					AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				) B
				ORDER BY Spot_a DESC
				';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='avgtotdur') {
				$query = 'SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV R WHERE 
				 R.TANGGAL="'.$periode.'"
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'
					AND WEEK ="'.$week.'" 				 
					) A,
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV R WHERE 
				 R.TANGGAL="'.$periode.'" 
				 AND R.ID_PROFILE = "'.$profile.'"
					AND WEEK ="'.$week.'" '.$wh_chn.'				 ) B 
				 WHERE A.channel = B.channel
				 GROUP BY A.channel
				 order by  B.Spot/A.Spot DESC'; 

			}else {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_PTV_WEEK 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_hari_date($field,$where,$periode,$datef,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		//echo $start_date;
		//echo $end_date;
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel,GRP AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_DAY_PTV a, `CHANNEL_PARAM` B 
				AND a.CHANNEL = B.CHANNEL_NAME
				AND FLAG_TV = 0
				WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z' ;
				
				//$query = 'SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP R WHERE	 R.TANGGAL="'.$periode.'" '.$where.' ORDER BY grp DESC LIMIT 15'; 
			}elseif ($pilihaudiencebar=='Viewers'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='Duration'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='share'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
				( 
					SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM ( 
						SELECT CHANNEL as channel, VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
						WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					) A,
					(
						SELECT SUM(VIEWERS) AS tot_spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
						WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					) B
				) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='avgtotdur'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV R WHERE 
								 R.TANGGAL="'.$periode.'"
								 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
								 AND `DAYS` ="'.$datef.'" ) A,
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
								 R.TANGGAL="'.$periode.'" 
								 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
								 AND `DAYS` ="'.$datef.'" ) B 
								 WHERE A.channel = B.channel
								 GROUP BY A.channel
								 order by  B.Spot/A.Spot DESC
				
				
			) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='tvs'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "TVS" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='tvr'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "TVR" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}elseif ($pilihaudiencebar=='audience2'){
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}else {
				// $query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
				//$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN R WHERE				 R.TANGGAL="'.$periode.'" '.$where.'					ORDER BY VIEWERS DESC LIMIT 15';  	
			}
		// echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all2Ps_hari_date($field,$where,$periode,$tgl,$tgl2,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			$query = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			( 
			SELECT PROGRAM as Program, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
			WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$tgl.'" 
			AND ID_PROFILE = "'.$profile.'" 
			ORDER BY Spot DESC )z';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}elseif ($pilihprog=='Viewers') {
			// $query = 'SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			(
				SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$tgl2.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC )z';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}elseif ($pilihprog=='Duration') {
			// $query = 'SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			(
				SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC 
				)z';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
					WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$tgl2.'" 
					AND ID_PROFILE = "'.$profile.'" 
						
				) A,
				(
					SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
					WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
					AND ID_PROFILE = "'.$profile.'"
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						';
		
		}	else {
			// $query = 'SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
				// WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				// AND ID_PROFILE = "'.$profile.'" 
				// AND FLAG_TV = 0  
				// ORDER BY Spot DESC';
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			(
				SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC )z';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}		
		//echo $query;DIE;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function list_spot_by_program_all2Ps_new_week_x($field,$where,$params,$pilihprog,$profile) {
	
		if($params['check'] == "False"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		$where = "";
		
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
					 $query2 = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
					SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK_PTV a 
					WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
					'.$where.' '.$wh_chn.' 
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					';
		}elseif ($pilihprog=='Viewers') {
	
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC		
						)z 
						
						';
						
		}elseif ($pilihprog=='avgtotdur')	 {
		
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				
						';
		
		}elseif ($pilihprog=='Duration') {
	
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						
						';
						
		}else {
		
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						
						';
		}		
		
		
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
		// print_r($sql->result_array()); die;
		return $sql->result_array();		
	}
	
	public function list_spot_by_program_all2Ps_new_week($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
		if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
				 $query = 	'	
					SELECT COUNT(*) AS jumlah FROM 
					( 
					SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK_PTV a 
					WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
					'.$where.' '.$wh_chn.' '.$wheres.'
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					';
					
					 $query2 = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
					SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK_PTV a 
					WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
					'.$where.' '.$wh_chn.' '.$wheres.'
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					LIMIT '.$params['limit'].' 
					OFFSET '.$params['offset'].' 
					';
		}elseif ($pilihprog=='Viewers') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC					
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC		
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='avgtotaud')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
		//echo $query;die;
		  $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}

	public function list_spot_by_program_all2Ps_new_day_x($field,$where,$params,$pilihprog,$profile) {
		
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		$where = "";
		
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
				
					
					 $query2 = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
					SELECT PROGRAM as Program, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
					'.$where.' '.$wh_chn.'
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					
					';
		}elseif ($pilihprog=='Viewers') {
	
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
					
						';
						
		}elseif ($pilihprog=='avgtotdur')	 {
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'"
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				
						';
		
		}elseif ($pilihprog=='Duration') {
		
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						
						';
						
		}else {
			
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
					
						';
		}		
		
		
		//echo $query;die;
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
		// print_r($sql->result_array()); die;
		return $sql->result_array();	
	}
	
	public function list_spot_by_program_all2Ps_new_day($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
		if($params['check'] == "True"){
				$wh_chn = ''; 
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR2'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
				 $query = 	'	
					SELECT COUNT(*) AS jumlah FROM 
					( 
					SELECT PROGRAM as Program, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tglf'].'" 
					'.$where.' '.$wh_chn.' '.$wheres.'
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					';
					
					 $query2 = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
					SELECT PROGRAM as Program, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tglf'].'" 
					'.$where.' '.$wh_chn.' '.$wheres.'
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					LIMIT '.$params['limit'].' 
					OFFSET '.$params['offset'].' 
					';
		}elseif ($pilihprog=='Viewers') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'"
						ORDER BY Spot DESC 						
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='avgtotaud')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'"
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'"
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'"
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
							
					) A,
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'"
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='TVR') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "TVR" AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "TVR" AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='TVS') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "TVS" AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "TVS"
						AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='Audience2') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "AUDIENCE" AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "AUDIENCE"
						AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM  
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "VIEWERS" AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot, VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
						WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
						AND DATA_TYPE = "VIEWERS"
						AND `DATE` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
		//echo $query;die;
		  $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}

	public function list_spot_by_program_all2Ps_new_x($field,$wheres,$params,$pilihprog,$profile) {
		
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		//var_dump($params);die;
		//$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		$where = " ";
		
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
					$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.'
						AND ID_PROFILE  = "'.$profile.'" 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
					}else{
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
					}
					
		}elseif ($pilihprog=='Viewers') {
	
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						
						)z 
						';
						
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						';
		
		}elseif ($pilihprog=='Duration') {
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}else {
			
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
		}		
		
		
		//echo $query;die;
		
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
		// print_r($sql->result_array()); die;
		return $sql->result_array();			

      //return $result2;
	}
	
	public function list_spot_by_program_all2Ps_new_tvod_x($field,$wheres,$params,$pilihprog,$profile,$tipe_filter) {
		
		$data_file = $params['periode'];
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = '  ' ;
		}
		//var_dump($params);die;
		//$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		$where = " ";
		
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
					$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.'
						AND ID_PROFILE  = "'.$profile.'" 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
					}else{
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
					}
					
		}elseif ($pilihprog=='Viewers') {
	
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "TOTAL_VIEWS"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						
						)z 
						';
						
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z  
						';
		
		}elseif ($pilihprog=='Duration') {
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}else {
			
						$query2 = 	'
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
		}		
		
		
		//echo $query;die;
		
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
		// print_r($sql->result_array()); die;
		return $sql->result_array();			

      //return $result2;
	}
	
		public function list_spot_by_program_all2Ps_new_avg($field,$wheres,$params,$pilihprog,$profile,$start_date,$end_date) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
		$data_file = $params['periode'];
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		
		if($params['check2'] == "True"){
				$wh_chn = ''; 
		}else{
				$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		if($params['check'] == "True"){
		
			if ($pilihprog=='TVR') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].'  
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='TVS') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='IDX') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='Audience2') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='Audience') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='Reach') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}else {
				
				if($profile == 0){
				
						$query = 	'
						SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
									SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
									FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
									WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
									OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
									GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
									SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
									FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
									WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
									OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
									GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
				
				}else{
					
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
						
					
					$query = 	'
				SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
					
				}
			}		
		
		}else{
			
			if ($pilihprog=='TVR') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].'  
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='TVS') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='IDX') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='Audience2') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='Audience') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS_S" 
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}elseif ($pilihprog=='Reach') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
							
			}else {
				
				if($profile == 0){
				
						$query = 	'
				SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
				
				}else{
					
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
						
					
					$query = 	'
				SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							LIMIT '.$params['limit'].' 
							OFFSET '.$params['offset'].' 
							';
					
				}
			}
			
		}
		
		
		//echo $query;die;
		  $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	
	public function list_spot_by_program_all2Ps_new_avg_print($field,$wheres,$params,$pilihprog,$profile,$start_date,$end_date) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
		$data_file = $params['periode'];
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		// if($params['check'] == "True"){
				$wh_chn = ''; 
			// }else{
					// $wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							// LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							// WHERE B.`FLAG_TV` = 0) ' ;
			// }
		
		if($params['check'] == "True"){
		
			if ($pilihprog=='TVR') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='TVS') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='IDX') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
						
							';
							
			}elseif ($pilihprog=='Audience2') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='Audience') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='Reach') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
						
							';
							
			}else {
				
				if($profile == 0){
				
						$query = 	'
						SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
									SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
									FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
									WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
									OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
									GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
									SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
									FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
									WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
									OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
									GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							
							';
				
				}else{
					
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
						
					
					$query = 	'
				SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,CONCAT(PROGRAM," ",BEGIN_PROGRAM) AS PROG,A.CARDNO, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.CARDNO,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							
							';
					
				}
			}		
		
		}else{
			
			if ($pilihprog=='TVR') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVR_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='TVS') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "TVS_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='IDX') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "INDEX_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='Audience2') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "AUDIENCE_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='Audience') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "VIEWERS_S" 
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}elseif ($pilihprog=='Reach') {
			$query = 	'
				SELECT COUNT(*) AS jumlah FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH_S" AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
							( 
							SELECT PROGRAM as Program, CHANNEL , AVG(VIEWERS) AS Spot,  AVG(VIEWERS2) AS Spot2 FROM M_SUM_TV_DASH_PROG_DAY_RES 
							WHERE TANGGAL ="'.$params['periode'].'" AND `STATUS` = 1 
							AND DATA_TYPE = "REACH_S"
							AND `DATE` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
							'.$where.' '.$wh_chn.' '.$wheres.'
							AND ID_PROFILE = "'.$profile.'" 
							GROUP BY CHANNEL, PROGRAM
							ORDER BY AVG(VIEWERS) DESC 
							)z 
							
							';
							
			}else {
				
				if($profile == 0){
				
						$query = 	'
				SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							
							';
				
				}else{
					
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
						
					
					$query = 	'
				SELECT COUNT(*) AS jumlah FROM  
							( 
								SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							';
							
							$query2 = 	'
				SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
							SELECT `CHANNEL`,PROG AS Program,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM AS PROG,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM `CDR_EPG_RES_'.$name_tbs_new.'_STEP2` A 
								WHERE (A.`USER_BEGIN_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								OR A.`USER_END_SESSION` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59")
								A.CARDNO IN ('.$sql_c.')
								GROUP BY A.RESPID,`CHANNEL`	
								) O
								GROUP BY `CHANNEL`,PROG
								ORDER BY SUM(WEIGHT) DESC 
							)z 
							
							';
					
				}
			}
			
		}
		
		
		//echo $query;die;
		  // $out		= array();
		  // $querys		= $this->db->query($query);
		  // $result = $querys->row();
		  
		  // $total_filtered = $result->jumlah;
		  // $total 			= $result->jumlah;
	  
			// if(($params['offset']+10) > $total_filtered){
			// $limit_data = $total_filtered - $params['offset'];
		  // }else{
			// $limit_data = $params['limit'] ;
		  // }
	  
	
	  
	  //echo $query;die;
		//echo $query2;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2
      );
      return $return;
	}
	
	public function list_spot_by_program_all2Ps_new_print($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
			if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' ' ;
			}
		
		if($params['check'] == "True"){
		
		
		if ($pilihprog=='TVR2'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'"  
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
					$arr_per = explode("-",$params['periode']); 
					
					if(count($arr_per) == 2){
					
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
					}else{
						
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
					}
					
		}elseif ($pilihprog=='Viewers') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						
						)z 
						
						';
						
		}elseif ($pilihprog=='avgtotaud')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL,TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						AND DURASI_PROGRAM > DURASI_USER
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY TVR DESC
						)z 
						';
						
			$query2 = 	' 
			SELECT z.*, rank() over ( ORDER BY TVR DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						AND DURASI_PROGRAM > DURASI_USER
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY TVR DESC
						
						)z 
						
						';
		
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
				
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}elseif ($pilihprog=='TVR') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
						
		}elseif ($pilihprog=='IDX') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}elseif ($pilihprog=='TVS') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
						
		}elseif ($pilihprog=='Audience2') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}elseif ($pilihprog=='Reach') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
		}

		}else{
			
			
		
		
			if ($pilihprog=='TVR') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
						
		}elseif ($pilihprog=='IDX') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
						
		}elseif ($pilihprog=='TVS') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}elseif ($pilihprog=='Audience2') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
					
						';
						
		}elseif ($pilihprog=='Reach') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						
						';
		}

		
			
		}		
		
		
	//echo $query2;die;
		
		  // $out		= array();
		  // $querys		= $this->db->query($query);
		  // $result = $querys->row();
		  
		  // $total_filtered = $result->jumlah;
		  // $total 			= $result->jumlah;
	  
			// if(($params['offset']+10) > $total_filtered){
			// $limit_data = $total_filtered - $params['offset'];
		  // }else{
			// $limit_data = $params['limit'] ;
		  // }
	  
	
	  
	  //echo $query;die;
		//echo $query2;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2
          //'total_filtered' => $total_filtered,
          //'total' => $total,
      );
      return $return; 
	}
	
	public function list_spot_by_program_all2Ps_new_avg_alls_print($field,$wheres,$params,$pilihprog,$profile) { 
		
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if($params['check'] == "True"){
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_DAY_RES a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
					SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS AUDIENCE FROM `M_SUM_TV_DASH_PROG_DAY_RES` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_DAY_RES` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVR FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVS FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS REACH FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS `INDEX` FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				
				WHERE 1=1 '.$wh_chn.'
				ORDER BY A.VIEWERS DESC
				';
			
		}else{
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_DAY_RES a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
					SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS AUDIENCE FROM `M_SUM_TV_DASH_PROG_DAY_RES` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_DAY_RES` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS_S"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVR FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR_S"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVS FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS_S"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS REACH FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH_S"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS `INDEX` FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX_S"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY A.VIEWERS DESC
				';
		}
		
		//echo $query2;die; 
		 $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
		
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
		
	}
	
	public function list_spot_by_program_all2Ps_new_avg_alls($field,$wheres,$params,$pilihprog,$profile) { 
		
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if($params['check'] == "False"){
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
					SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS AUDIENCE FROM `M_SUM_TV_DASH_PROG_DAY_TRANS` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_DAY_TRANS` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVR FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVS FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS REACH FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS `INDEX` FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				
				WHERE 1=1 '.$wh_chn.'
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'  
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
				';
			
		}else{
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
					SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS AUDIENCE FROM `M_SUM_TV_DASH_PROG_DAY_TRANS` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_DAY_TRANS` a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS_S"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVR FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR_S"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVS FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS_S"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS REACH FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH_S"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS `INDEX` FROM M_SUM_TV_DASH_PROG_DAY_TRANS a
				WHERE 1=1 AND ID_PROFILE = "0" AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX_S"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'  
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
				';
		}
		
		//echo $query2;die; 
		 $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
		
	}
	
	public function list_spot_by_program_all2Ps_new_alls_print($field,$wheres,$params,$pilihprog,$profile) {
		
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if($params['check'] == "True"){
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
				SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS VIEWERS FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVR FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVS FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS REACH FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS `INDEX` FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY AUDIENCE DESC
				';
			
		}else{
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
				SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS VIEWERS FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS_S"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVR FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR_S"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVS FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS_S"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS REACH FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH_S"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS `INDEX` FROM M_SUM_TV_DASH_PROG_RES a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX_S"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY AUDIENCE DESC
				';
		}
		
		//echo $query2;die; 
		 $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  

	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
		
	}
	
	public function list_spot_by_program_all2Ps_new_alls($field,$wheres,$params,$pilihprog,$profile) {
		
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if($params['check'] == "False"){
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_TRANS a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
				SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS VIEWERS FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVR FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVS FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS REACH FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS `INDEX` FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'  
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
				';
			
		}else{
			
			$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_TRANS a
						WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
						AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
						GROUP BY CHANNEL,PROGRAM
						)z 
						';
			
			$query2 = '
				SELECT A.PROGRAM, A.CHANNEL, AUDIENCE, VIEWERS,TVR, TVS, REACH, `INDEX` FROM (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS VIEWERS FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS_S"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVR FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR_S"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS TVS FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS_S"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS REACH FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH_S"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS `INDEX` FROM M_SUM_TV_DASH_PROG_TRANS a
				WHERE 1=1 AND ID_PROFILE = "'.$profile.'" AND TANGGAL="'.$params['periode'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX_S"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'  
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
				';
		}
		
		//echo $query2;die; 
		 $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
		
	}
	
	
	public function list_spot_by_program_all2Ps_new($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if($params['check'] == "True"){
		
		
		if ($pilihprog=='TVR2'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'"  
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
					$arr_per = explode("-",$params['periode']); 
					
					if(count($arr_per) == 2){
					
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
					}else{
						
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
					}
					
		}elseif ($pilihprog=='Viewers') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='avgtotaud')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL,TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						AND DURASI_PROGRAM > DURASI_USER
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY TVR DESC
						)z 
						';
						
			$query2 = 	' 
			SELECT z.*, rank() over ( ORDER BY TVR DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						AND DURASI_PROGRAM > DURASI_USER
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY TVR DESC
						
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='TVR') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='IDX') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='TVS') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='Audience2') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='Reach') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}

		}else{
			
			
		
		
			if ($pilihprog=='TVR') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVR_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='IDX') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "INDEX_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='TVS') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "TVS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='Audience2') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "AUDIENCE_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='Reach') {
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "REACH_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND DATA_TYPE = "VIEWERS_S" AND `STATUS` = 1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}

		
			
		}		
		
		
	//echo $query2;die;
		
		  $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}	
	
	public function list_spot_by_program_all2Ps_new_tvod($field,$wheres,$params,$pilihprog,$profile,$tipe_filter) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
			if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
					$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wheres.'
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wheres.'
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
					}else{
						
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' '.$wheres.'
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'	
						SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' '.$wheres.'
						AND ID_PROFILE  = "'.$profile.'" '.$wh_chn.' 
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
					}
					
		}elseif ($pilihprog=='Viewers') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "TOTAL_VIEWS"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "TOTAL_VIEWS"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='avgtotaud')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL,TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						AND DURASI_PROGRAM > DURASI_USER
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY TVR DESC
						)z 
						';
						
			$query2 = 	' 
			SELECT z.*, rank() over ( ORDER BY TVR DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						AND DURASI_PROGRAM > DURASI_USER
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY TVR DESC
						
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
							AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "DURATION"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "DURATION"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "DURATION"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "DURATION"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}else {
			$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wheres.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
	//	echo $query;die;
		
		  $out		= array();
		  $querys		= $this->db->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	  
	  //echo $query;die;
		//echo $query;die;
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	
	//Dashboard Tabel PROGRAM
	public function list_spot_by_program_all2Ps($field,$where,$periode,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			// $query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					// WHERE 1=1 
					// AND TANGGAL="'.$periode.'" '.$where.' 
					// AND ID_PROFILE = "'.$profile.'" 
					// GROUP BY a.`'.$field.'`
					// ORDER BY Spot DESC';
					
				 $query = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
			( 
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
					WHERE 1=1 
					AND TANGGAL="'.$periode.'" '.$where.' 
					AND ID_PROFILE  = "'.$profile.'" 
					GROUP BY CHANNEL,a.`'.$field.'`
					ORDER BY Spot DESC
					)z 
					';
		}elseif ($pilihprog=='Viewers') {
		$query = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$periode.'" '.$where.'
						GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
				SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$periode.'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$periode.'" '.$where.'
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$periode.'" '.$where.'
						GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
		}else {
		$query = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_PROG_RES a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$periode.'" '.$where.'
						AND `STATUS` = 1
						AND DATA_TYPE = "VIEWERS"
						GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
		}		
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		// print_r($sql->result_array()); die;
		return $sql->result_array();	   
	}
	//Dashboard Tabel PROGRAM HARI
	public function list_spot_by_program_all2Ps_hari($field,$where,$periode,$week,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK_PTV a 
			WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
			AND ID_PROFILE = "'.$profile.'" 
			ORDER BY Spot DESC ';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}else if ($pilihprog=='Viewers') {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}else if ($pilihprog=='Duration') {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}else if ($pilihprog=='avgtotdur') {
			$query = '
			SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
					WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
					AND ID_PROFILE = "'.$profile.'" 
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
					WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
					AND ID_PROFILE = "'.$profile.'" 
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
			';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}	else {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
			//$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG a					WHERE 1=1 					AND TANGGAL="'.$periode.'" '.$where.'					GROUP BY a.`'.$field.'`					ORDER BY Spot DESC';
		}		
		//echo $query;die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	//Dashboard Pie Audience by Time
	public function list_spot_by_daytime_all2($where,$periode) {
			$query = "SELECT TIME_PERIODE2 PRIME,`VALUE` VIEWERS FROM M_SUM_TV_DASH_TRANS_OTHER
					 WHERE 1=1 AND TIME_PERIODE='".$periode."' ".$where."
					 ORDER BY TIME_PERIODE2 DESC	";
		// $query = "SELECT tb_cgi.htype, SUM(tb_cgi.tvr) AS spot 
							// FROM
							// (
								// SELECT a.*, b.tvr, ( 
									 // CASE WHEN 
							// a.`START_TIME` 
							// >= CAST('00:00:00' AS TIME) AND 
							// a.END_TIME 
							// < CAST('06:00:00' AS TIME)
							// THEN '00:00 - 06:00'
							// WHEN 
							// a.`START_TIME` 
							// >= CAST('06:00:00' AS TIME) AND 
							// a.`END_TIME` 
							// < CAST('08:00:00' AS TIME)
							// THEN '06:00 - 08:00'
							// WHEN 
							// a.`START_TIME` 
							// >= CAST('08:00:00' AS TIME) AND 
							// a.`END_TIME` 
							// < CAST('12:00:00' AS TIME)
							// THEN '08:00 - 12:00'
							// WHEN 
							// a.`START_TIME` 
							// >= CAST('12:00:00' AS TIME) AND 
							// a.`END_TIME` 
							// < CAST('18:00:00' AS TIME)
							// THEN '12:00 - 18:00'
							// WHEN 
							// a.`START_TIME` 
							// >= CAST('18:00:00' AS TIME) AND 
							// a.`END_TIME` 
							// < CAST('22:00:00' AS TIME)
							// THEN '18:00 - 22:00'
							// WHEN 
							// a.`START_TIME` 
							// >= CAST('22:00:00' AS TIME) AND 
							// a.`END_TIME` 
							// < CAST('23:59:59' AS TIME) 
							// THEN '22:00 - 00:00' ELSE '00:00 - 06:00'
							 // END) AS htype 
								 // FROM t_epg a 
									// LEFT JOIN NEW_MEDIA_PLANNING b ON a.`program` = b.`program`	
								 // WHERE 1=1 ".$where.") AS tb_cgi 
								 // GROUP BY tb_cgi.htype
								 // ORDER BY spot DESC";  			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	

	//Dashboard Audience by Daypart
	public function list_spot_by_daypart($where,$periode) {
		$query = "SELECT TIME_PERIODE2 TIME,`VALUE` VIEWERS FROM M_SUM_TV_DASH_TRANS_OTHER
					 WHERE TYPE_PERIODE = 'TIME_VIEWERS' AND TIME_PERIODE='".$periode."' ".$where."
					 ORDER BY `VALUE` DESC	";
					
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	//Dashboard Audience by Day
	public function day_filters($params) {
		
			if($params['channel_d'] == 'ALL'){
				IF($params['interval'] == 'day'){
					$TYPE_FIELD = 'DAYS';
					$WHERE_DATE = ' AND FIELD BETWEEN "'.$params['start_date_d'].'" AND "'.$params['end_date_d'].'"';
					$GROUP_BY = ' DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d")';
				}else{
					$TYPE_FIELD = 'RESP ALL';
					$WHERE_DATE = ' AND FIELD BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"';
					$GROUP_BY = ' SPLIT_MINUTES';
				}
				
				$WHERE_CH = ' AND CHANNEL = "ALL" ';
				$WHERE_CH2 = ' ';
			}ELSE{
				IF($params['interval'] == 'day'){
					$TYPE_FIELD = 'DAYS CHANNEL';
					$WHERE_DATE = ' AND FIELD BETWEEN "'.$params['start_date_d'].'" AND "'.$params['end_date_d'].'"';
					$GROUP_BY = 'DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d")';
				}else{
					$TYPE_FIELD = 'RESP CHAN';			
					$WHERE_DATE = ' AND FIELD BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"';	
					$GROUP_BY = ' SPLIT_MINUTES';					
				}

				
				$WHERE_CH = ' AND CHANNEL = "'.$params['channel_d'].'"';
				$WHERE_CH2 = ' AND CHANNEL = "'.$params['channel_d'].'"';
			}
			
			
			// if($params['respondent'] == 'VIEWERS2'){
				// $resp = 'VIEWERS_A';
			// }else{
				// $resp = $params['respondent'];
				// $resp = 'VIEWERS_A';
			// }
			
			if($params['audiencebar_2'] == 'AUDIENCE'){
				
				//IF($params['interval'] == 'day'){
					
					IF($params['respondent'] == 'RESP'){
					
						$query = 'SELECT `FIELD` AS `date`, RESP AS spot FROM M_SUM_TV_DASH_DATE_RES
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH.'
						 '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}ELSE IF($params['respondent'] == 'VIEWERS'){
					
					
						$query = 'SELECT `FIELD` AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_RES
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH.'
						  '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}ELSE IF($params['respondent'] == 'VIEWERS2'){
					
					
						$query = 'SELECT `FIELD` AS `date`, VIEWERS2 AS spot FROM M_SUM_TV_DASH_DATE_RES
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH.'
						  '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}
				
			}else{
				
					IF($params['respondent'] == 'RESP'){
					
						$query = 'SELECT `FIELD` AS `date`, RESP AS spot FROM M_SUM_TV_DASH_DATE_RES
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH2.'
						 '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}ELSE IF($params['respondent'] == 'VIEWERS'){
					
					
					$query = '
							SELECT '.$GROUP_BY.' AS `date`, AVG(VIEWERS) AS spot FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
							'.$WHERE_CH2.'
							GROUP BY '.$GROUP_BY.'
							ORDER BY '.$GROUP_BY.'
							';
				
					}ELSE IF($params['respondent'] == 'VIEWERS2'){
					
					
						$query = '
							SELECT '.$GROUP_BY.' AS `date`, AVG(VIEWERS_A) AS spot FROM `SUMMARY_PER_MINUTES_RES_V2`
							WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
							'.$WHERE_CH2.'
							GROUP BY '.$GROUP_BY.'
							ORDER BY '.$GROUP_BY.'
							';
				
					}
				
			}
			
			// IF($params['interval'] == 'day'){
			
				// if($params['audiencebar_2'] == 'AUDIENCE'){
				
					// // $query = 'SELECT `FIELD` AS `date`, '.$params['respondent'].' AS spot FROM M_SUM_TV_DASH_DATE_RES
						  // // WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						  // // AND CHANNEL = "'.$params['channel_d'].'"
						  // // AND FIELD BETWEEN "'.$params['start_date_d'].'" AND "'.$params['end_date_d'].'"
						  // // ORDER BY `FIELD`';
						  
						  
						  // $query = 'SELECT `FIELD` AS `date`, RESP AS spot FROM M_SUM_TV_DASH_DATE_RES
						  // WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						  // '.$WHERE_CH.'
						  // AND FIELD BETWEEN "'.$params['start_date_d'].'" AND "'.$params['end_date_d'].'"
						  // ORDER BY `FIELD`';	
				
				// }else{
					
					
					// $query = '
					// SELECT DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d") AS `date`, AVG('.$resp.') AS spot FROM `SUMMARY_PER_MINUTES_RES_V2`
					// WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
					// '.$WHERE_CH.'
					// GROUP BY DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d")
					// ORDER BY DATE_FORMAT(SPLIT_MINUTES,"%Y-%m-%d")
					// ';
				
					
				// }
			
			// }else{
				
				// IF($params['respondent'] == 'RESP'){ 
				
					// IF($params['interval'] == 'day'){
						// $query = '
							// SELECT SPLIT_MINUTES AS `date`, AVG('.$resp.') AS spot FROM `SUMMARY_PER_MINUTES_RES_V2`
							// WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
							// '.$WHERE_CH.'
							// GROUP BY SPLIT_MINUTES
							// ORDER BY SPLIT_MINUTES
							// ';
					// }else{
						
						// $query = 'SELECT `FIELD` AS `date`, RESP AS spot FROM M_SUM_TV_DASH_DATE_RES
						  // WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD2.'" AND `STATUS` = 1 
						 // '.$WHERE_CH.'
						  // AND FIELD BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
						  // ORDER BY `FIELD`';	
						
					// }
				// }else{
				
					// if($params['audiencebar_2'] == 'VIEWERS' ){
						
						// $query = '
						// SELECT SPLIT_MINUTES AS `date`, AVG('.$resp.'/1000) AS spot FROM `SUMMARY_PER_MINUTES_RES_V2`
						// WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
						// '.$WHERE_CH.'
						// GROUP BY SPLIT_MINUTES
						// ORDER BY SPLIT_MINUTES
						// ';
						 
					// }ELSE{
						
						// $query = '
						// SELECT SPLIT_MINUTES AS `date`, AVG('.$resp.') AS spot FROM `SUMMARY_PER_MINUTES_RES_V2`
						// WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date_d'].' 00:00:00" AND "'.$params['end_date_d'].' 23:59:59"
						// '.$WHERE_CH.'
						// GROUP BY SPLIT_MINUTES
						// ORDER BY SPLIT_MINUTES
						// ';
						
					// }
				// }
			// }
		
		
			//ECHO $query;die;
				  
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
		
	}
		
		
		
	public function list_spot_by_date_all2($where,$periode) {
		$query = 'SELECT TIME_PERIODE2 AS `date`, `VALUE` AS spot FROM M_SUM_TV_DASH_TRANS_OTHER
				  WHERE TYPE_DATA = "AUDIENCE" AND TYPE_PERIODE = "DAY_VIEWERS" AND TIME_PERIODE="'.$periode.'" '.$where.' 
				  ORDER BY TIME_PERIODE2';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
		public function list_spot_by_date_all2_viewer($where,$periode) {
		$query = 'SELECT TIME_PERIODE2 AS `date`, `VALUE` AS spot FROM M_SUM_TV_DASH_TRANS_OTHER
				  WHERE TYPE_DATA = "TOTAL_VIEWS" AND TYPE_PERIODE = "DAY_VIEWERS" AND TIME_PERIODE="'.$periode.'" '.$where.' 
				  ORDER BY TIME_PERIODE2';					
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function list_spot_by_date_all2_duration($where,$periode) {
		$query = 'SELECT TIME_PERIODE2 AS `date`, `VALUE` AS spot FROM M_SUM_TV_DASH_TRANS_OTHER
				  WHERE TYPE_DATA = "DURATION" AND TYPE_PERIODE = "DAY_VIEWERS" AND TIME_PERIODE="'.$periode.'" '.$where.' 
				  ORDER BY TIME_PERIODE2';				
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
		//print_r($query);die;
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
		// $query = 'SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				// WHERE 1=1 AND L.`FLAG_TV` = 0 
				// AND R.TANGGAL="'.$periode.'" '.$where.'
					// GROUP BY L.`'.$field.'`
					// ORDER BY Spot DESC';  
		//echo $query;
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
		//$query = 'SELECT COUNT(*) AS tot_pop FROM ALL_UNIVERSE';  
		//$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR" ';
		$date=date_create($periode);
		$pr = strtoupper(date_format($date,"My"));
		
		$query = 'SELECT VIEWERS AS tot_pop FROM M_SUM_TV_DASH_OTHER_RES WHERE TYPE_FIELD = "UNIVERSE"  AND `STATUS` = 1 ';
		
		//$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR_MAR18"' ;
		//$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM M_CDR_LIVE_SPLIT_2';  		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_populasi2a($periode) {
		//$query = 'SELECT COUNT(*) AS tot_pop FROM ALL_UNIVERSE';  
		//$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR" ';
		$date=date_create($periode);
		$pr = strtoupper(date_format($date,"My"));
		
		//$query = 'SELECT VIEWERS AS tot_pop FROM M_SUM_TV_DASH_OTHER_RES WHERE TYPE_FIELD = "UNIVERSE ALL"  AND `STATUS` = 1 ';
		
		$query = 'SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR_SEP20" AND TYPE_DATA = 24' ;
		//$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM M_CDR_LIVE_SPLIT_2';  		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_populasi() {
		//$query = 'SELECT COUNT(*) AS tot_pop FROM ALL_UNIVERSE';  
		$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM NEW_CDR_LIVE_CLEAN_CS';
		//$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM M_CDR_LIVE_SPLIT_2';  		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_all2($where,$periode) {
		$query = 'SELECT COUNT(`PROGRAM`) AS spot FROM (
		SELECT DISTINCT a.`PROGRAM`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_RES a 
		WHERE `ID_PROFILE` = 0 AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS" AND TANGGAL="'.$periode.'" '.$where.' 
		GROUP BY CHANNEL,a.`PROGRAM`
		
		) P ';  			
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
					// echo $query; die;
		$sql	= $this->db->query($query);
		$this->db->close();
		$hasil = $sql->result_array();	 

		foreach($hasil as $new){
			// print_r($new); 
			// $query = 'INSERT INTO CGI_TVR (id, `date`, channel, program, level1, level2, sector, category, advertiser, product, `position`, start_time, end_time, duration, rate, ads_type, tvr)
						// VALUES("'.$new['id'].'","'.$new['date'].'","'.$new['channel'].'","'.$new['program'].'","'.$new['level1'].'","'.$new['level2'].'","'.$new['sector'].'","'.$new['category'].'","'.$new['advertiser'].'","'.$new['product'].'",
						// "'.$new['position'].'","'.$new['start_time'].'","'.$new['end_time'].'","'.$new['duration'].'","'.$new['rate'].'","'.$new['ads_type'].'","'.$new['tvr'].'")';  			
			// $sql	= $this->db->query($query);
			// if($sql){
				// return true;
			// }else{
				// return false;
			// }
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
		// print_r($sql);die;
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
	//	$id = $_COOKIE["sab_user_id"];
		$sql 	= 'SELECT product_name, video_name FROM t_product_video WHERE product_name = '.$tex.'';
		
		$query 	=  $this->db->query($sql);
		
		$return = $query->result_array();
		//var_dump($return);
		return $return;
	}		
	
	function get_year_int($periode)
	{
	//	$id = $_COOKIE["sab_user_id"];
		$sql 	= 'SELECT product_name, video_name FROM t_product_video WHERE product_name = '.$tex.'';
		
		$query 	=  $this->db->query($sql);
		
		$return = $query->result_array();
		//var_dump($return);
		return $return;
	}	

	public function list_grp_by_program_all($field,$where) {
		$query = 'SELECT a.'.$field.',channel, COUNT(DISTINCT (a.`tvr`)) AS GRP FROM CGI_TVR a Where 1=1 '.$where.'
						GROUP BY a.'.$field.'
						ORDER BY GRP DESC';  	

		//echo $query;die;
						
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	public function count_channel($periode) {
		
		$name_tbs = strtoupper(date_format(date_create($periode),"My"));
		// $query = 'SELECT COUNT(DISTINCT (b.CHANNEL_CDR)) jmlch FROM `P_CHANNEL_ADS_USEETV` b 
// WHERE 1=1 AND b.`FLAG_TV` = 1 ';  

//$query = 'SELECT COUNT(DISTINCT(SUBSCRIBER)) jmlch FROM `TRANSVISION_RAW_DATA_v3` ';  		 			
$query = 'SELECT * FROM (
SELECT COUNT(DISTINCT(SUBSCRIBER)) jmlch FROM `TRANSVISION_RAW_DATA_v3`
) A,(
 SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = "UNIVERSE_CDR_'.$name_tbs.'" AND type_data = 24 
)  UNIVERSE ';  		 			
		//$query = 'SELECT COUNT(CHANNEL_NAME) jmlch FROM P_CHANNEL_ADS_USEETV a Where 1=1 AND FLAG_TV=0';  			 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
}	
