<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		//$this->db2 = $this->load->database('db_prod', TRUE);
		$this->load->library('ClickHouse');
		
	}
	
	  public function list_daypart($userid) {
		$query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$userid.'" AND MENUS="0" ORDER BY DAYPART1 ';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize();  
		return $sql->result_array();	   
	}
	
	
	public function get_profile($iduser,$idrole,$periode,$tbl3) {  
	
		
		$i0 =  date_format(date_create($periode),"Y-m");
			
			$sql = "SELECT A.* FROM ( 
					SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a WHERE (STATUS = 1 OR STATUS = 3)  
					AND user_id_profil IN (".$iduser.",0)  ORDER BY `name`
					) A JOIN
					`".$tbl3."`  B ON A.id = B.`PROFILE_ID`
					WHERE B.`PERIODE` = '".$i0."' AND B.`STATUS_PROCESS` = 1
					";
		
		
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_profile_id($id_profile){
		
		$query = "SELECT * FROM t_profiling_ub_res WHERE id = '".$id_profile."' ";
	
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	
	public function get_tahun(){
		
		$query = "SELECT DISTINCT(PERIODE_STR)  TANGGAL FROM T_PERIODE_RES WHERE PERIODE > 30 ORDER BY PERIODE DESC";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	public function get_periode_date($periode){
		
		$db = $this->clickhouse->db();
		$query = "SELECT MIN(`DATE`) AS STR_TGL ,MAX(`DATE`) AS END_TGL FROM `M_SUM_TV_DASH_CHAN_DAY_RES` 
					WHERE `TANGGAL` = '".$periode."' ";
		  //echo $query;die;
		$result = $db->select($query);
		return $result->rows();				
	}
	
	public function get_periode_date_n($periode){
		$db = $this->clickhouse->db();
		$query = "SELECT MIN(`DATE`) AS STR_TGL ,MAX(`DATE`) AS END_TGL FROM `M_SUM_TV_DASH_CHAN_DAY_RES` 
					WHERE `TANGGAL` = '".$periode."' ";
					
					//echo $query;die;
		// $query = "SELECT MIN(`DATE`) AS STR_TGL ,MAX(`DATE`) AS END_TGL FROM `M_SUM_TV_DASH_CHAN_DAY_RES` 
					// WHERE `TANGGAL` = DATE_FORMAT('".$periode."','%Y-%M') ";
		$result = $db->select($query);
		return $result->rows();		
	}
	
	public function get_bulan(){
		
		$query = "SELECT DISTINCT SUBSTR(TANGGAL,6) bulan FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL, '%Y-%M')";
		 
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function get_week_channel($periode){
		
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_CHAN_PTV_WEEK WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS Int32 )";
		 
		$result = $db->select($query);
		return $result->rows();					
	}	
	
	public function channel_list($periode){
		
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `CHANNEL` FROM M_SUM_TV_DASH_CHAN_RES WHERE TANGGAL='".$periode."' AND CHANNEL <> '' ORDER BY CHANNEL ";
		 
		$result = $db->select($query);
		return $result->rows();			
	}
	
	public function get_week_program($periode){
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_PROG_WEEK_PTV WHERE TANGGAL='".$periode."' ORDER BY CAST(`WEEK` AS Int32 )";
		 
		$result = $db->select($query);
		return $result->rows();			
	}
	
	public function get_active_audience($periode,$tb1){
		
		$db = $this->clickhouse->db();
		$query = "SELECT VIEWERS FROM ".$tb1." WHERE TANGGAL= '".$periode."' AND TYPE_FIELD = 'ACTIVE AUDIENCE' AND `STATUS` = 1  "  ;
		
		// ECHO $query;DIE;
		$result = $db->select($query);
		return $result->rows();				
	}
	
	public function get_active_audience2($periode,$tb1){
		
		$db = $this->clickhouse->db();
		$query = "SELECT VIEWERS FROM ".$tb1." WHERE TANGGAL= '".$periode."' AND TYPE_FIELD = 'ACTIVE AUDIENCE2' AND `STATUS` = 1  "  ;

		$result = $db->select($query);
		return $result->rows();					
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
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_all_bar_alls($field,$where,$periode,$pilihaudiencebar,$profile,$check,$daypart) {
		$db = $this->clickhouse->db();
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
				
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
					ORDER BY VIEWERS DESC ';  	
				
				 

				if($daypart == 'ALL' || $daypart == '' ){

					// $query = '
					// SELECT A.CHANNEL as channel, 
					// A.AUDIENCE AS AUDIENCE, 
					// A.VIEWERS AS VIEWERS, 
					// A.TVR AS TVR , 
					// A.TVS AS TVS,
					// A.INDEX AS `INDEX`,
					// A.REACH AS REACH from M_SUM_TV_DASH_CHAN_RES_FULL A 
					// WHERE 1=1 AND TANGGAL="'.$periode.'"  '.$where.' 
					// AND A.ID_PROFILE = '.$profile.'
					// AND `STATUS` = 1  '.$wh_chn.'
					// ORDER BY A.AUDIENCE DESC
					// ';	
					
					
					$query = "
					SELECT A.CHANNEL as channel, 
					A.AUDIENCE AS AUDIENCE, 
					A.VIEWERS AS VIEWERS, 
					A.TVR AS TVR , 
					A.TVS AS TVS,
					A.INDEX AS `INDEX`,
					A.REACH AS REACH from M_SUM_TV_DASH_CHAN_RES_FULL A 
					WHERE 1=1 AND TANGGAL='".$periode."'  ".$where." 
					AND A.ID_PROFILE = ".$profile."
					AND `STATUS` = 1  ".$wh_chn."
					ORDER BY A.AUDIENCE DESC
					";	
					
					//ECHO $query;DIE;
					
					$sql	= $db->select($query);
					return $sql->rows();		   
				
				}else{
					
					$query = "
					SELECT A.CHANNEL as channel, 
					A.AUDIENCE AS AUDIENCE, 
					A.VIEWERS AS VIEWERS, 
					A.TVR AS TVR , 
					A.TVS AS TVS,
					A.INDEX AS `INDEX`,
					A.REACH AS REACH from M_SUM_TV_DASH_CHAN_RES_DAYPART_FULL A 
					WHERE 1=1 AND TANGGAL='".$periode."'  ".$where." 
					AND A.ID_PROFILE = ".$profile."
					AND A.DAYPART = '".$daypart."'
					AND `STATUS` = 1  ".$wh_chn."
					ORDER BY A.AUDIENCE DESC
					";
					
					$sql	= $db->select($query);
					$datad = $sql->rows();  
					
 					
					// if(count($datad) == 0){
						
						// $name_tbs_new = strtoupper(date_format(date_create($periode),"Ym"));
						
						// $time_segment = explode('-',$daypart);
		
						// $start_time = $time_segment[0];
						
						// if($time_segment[1] == '00:00:00'){
							// $end_time = '23:59:59';
						// }else{
							// $end_time = $time_segment[1];
						// }
						
						// if($profile == 1 || $profile == 0){
							
							// $query = "
							
								// INSERT INTO `M_SUM_TV_DASH_CHAN_RES_DAYPART_FULL`
								// SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,'".$daypart."' DAYPART,AUDIENCE,TVR2,TVS2,
								// (AUDIENCE/19479194)*100 REACH, 100 AS IDX,
								// A.ID_PROFILE,1 AS STS FROM (
									// SELECT CHANNEL,SUM(WEIGHT) AS AUDIENCE,SUM(WEIGHT_ALL) AS AUDIENCE_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS,1 ID_PROFILE  FROM (
										// SELECT *,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`  A
										// JOIN (SELECT * FROM `DAYPART`)
										// WHERE DATE_FORMAT(`BEGIN_PROGRAM`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
										// GROUP BY RESPID,CHANNEL
									// ) P GROUP BY CHANNEL
								// ) A JOIN (
									// SELECT `CHANNEL`,
									// AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
									// AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
									// AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2
									// FROM `SUMMARY_PER_MINUTES_RES_V2`
									// WHERE PERIODE = '".$periode."'
									// AND PROFILE_ID = 1
									// AND DATE_FORMAT(`SPLIT_MINUTES`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
									// GROUP BY CHANNEL
								// ) B ON A.CHANNEL = B.CHANNEL ;
							
							// ";
							// $this->db2->query($query);
							
							
							
						// }else{
							
							
							// $query = " 
									
							// INSERT INTO `M_SUM_TV_DASH_CHAN_RES_DAYPART_FULL`
								// SELECT A.CHANNEL,VIEWERS,VIEWERS AS VIEWERSALL,'".$periode."' PERIODE,'".$daypart."' DAYPART,AUDIENCE,TVR2,TVS2,
								// (AUDIENCE/19479194)*100 REACH, (TVR2/TVR2A)*100  AS IDX,
								// A.ID_PROFILE,1 AS STS FROM (
									// SELECT CHANNEL,SUM(WEIGHT) AS AUDIENCE,SUM(WEIGHT_ALL) AS AUDIENCE_ALL,PERIODE,HARIS,'AUDIENCE' AS DT,0 AS IDPRO, STS,".$profile." ID_PROFILE  FROM (
										// SELECT A.*,'".$periode."' PERIODE,DATE_FORMAT(BEGIN_PROGRAM,'%Y-%m-%d') HARIS, 0 STS  FROM `CDR_EPG_RES_".$name_tbs_new."_STEP2_2022`  A
										// JOIN (SELECT * FROM `PROFILE_CARDNO_RES` WHERE ID_PROFILE = '".$profile."') B ON A.RESPID = B.`CARDNO`
										// JOIN (SELECT * FROM `DAYPART`)
										// WHERE DATE_FORMAT(`BEGIN_PROGRAM`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
										// GROUP BY RESPID,CHANNEL
									// ) P GROUP BY CHANNEL
								// ) A JOIN (
									// SELECT `CHANNEL`,
									// AVG(VIEWERS) AS VIEWERS, AVG(VIEWERS_A) AS VIEWERS2,
									// AVG(TVR)*100 AS TVR,AVG(TVR_A)*100 AS TVR2,
									// AVG(TVS)*100 AS TVS,AVG(TVS_A)*100 AS TVS2
									// FROM `SUMMARY_PER_MINUTES_RES_V2`
									// WHERE PERIODE = '".$periode."'
									// AND PROFILE_ID = ".$profile."
									// AND DATE_FORMAT(`SPLIT_MINUTES`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
									// GROUP BY CHANNEL
								// ) B ON A.CHANNEL = B.CHANNEL
								// JOIN (
									// SELECT `CHANNEL`,
									// AVG(TVR)*100 AS TVRA,AVG(TVR_A)*100 AS TVR2A
									// FROM `SUMMARY_PER_MINUTES_RES_V2`
									// WHERE PERIODE = '".$periode."'
									// AND PROFILE_ID = 1
									// AND DATE_FORMAT(`SPLIT_MINUTES`,'%H:%i:%s') BETWEEN '".$start_time."' AND '".$end_time."'
									// GROUP BY CHANNEL
								// ) C ON B.CHANNEL = C.CHANNEL								
								// ;

							// "; 
							// $this->db2->query($query);
							
							
						// }
						
 						// $query = "
						// SELECT A.CHANNEL as channel, 
						// A.AUDIENCE AS AUDIENCE, 
						// A.VIEWERS AS VIEWERS, 
						// A.TVR AS TVR , 
						// A.TVS AS TVS,
						// A.INDEX AS `INDEX`,
						// A.REACH AS REACH from M_SUM_TV_DASH_CHAN_RES_DAYPART_FULL A 
						// WHERE 1=1 AND TANGGAL='".$periode."'  ".$where." 
						// AND A.ID_PROFILE = ".$profile."
						// AND A.DAYPART = '".$daypart."'
						// AND `STATUS` = 1  ".$wh_chn."
						// ORDER BY A.AUDIENCE DESC
						// ";
						
						
						
						// $sql	= $this->db2->query($query);
						// $this->db2->close();
						// $this->db2->initialize(); 
						// $datad = $sql->result_array();	   
						
					// }					
				}
 		return $datad;
		
	}
	
	
	public function list_spot_by_program_all_bar_alls_exp($field,$where,$periode,$pilihaudiencebar,$profile,$check,$order,$search,$daypart) {
		
 		$db = $this->clickhouse->db();
		
		if($search == ""){
			$wh_sch = '';
		}else{
			$wh_sch = " AND (CHANNEL LIKE '%".$search."%' )";
		}
		
		if($order == ''){
			$wh_order = "ORDER BY A.VIEWERS2 DESC";
		}else{
			
			$ordering = explode(',',$order);
			$array_filed = ['Rangking','channel','AUDIENCE','VIEWERS','TVR','TVS','INDEX','REACH'];
			
			$wh_order = "ORDER BY ".$array_filed[$ordering[0]]." ".$ordering[1];
		}
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
				
				$query = 'SELECT CHANNEL as channel,VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_RES R WHERE 
				 R.TANGGAL="'.$periode.'" '.$where.' 
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
					ORDER BY VIEWERS DESC ';  	


				
				if($daypart == 'ALL' || $daypart == ''){

					$query = "
					SELECT A.CHANNEL as channel, 
					A.AUDIENCE AS AUDIENCE, 
					A.VIEWERS AS VIEWERS, 
					A.TVR AS TVR , 
					A.TVS AS TVS,
					A.INDEX AS `INDEX`,
					A.REACH AS REACH from M_SUM_TV_DASH_CHAN_RES_FULL A 
					WHERE 1=1 AND TANGGAL='".$periode."'  ".$where." 
					AND A.ID_PROFILE = ".$profile."
					AND `STATUS` = 1  ".$wh_chn."
					ORDER BY A.AUDIENCE DESC
					";	
				
				}else{
					
					$query = "
					SELECT A.CHANNEL as channel, 
					A.AUDIENCE AS AUDIENCE, 
					A.VIEWERS AS VIEWERS, 
					A.TVR AS TVR , 
					A.TVS AS TVS,
					A.INDEX AS `INDEX`,
					A.REACH AS REACH from M_SUM_TV_DASH_CHAN_RES_DAYPART_FULL A 
					WHERE 1=1 AND TANGGAL='".$periode."'  ".$where." 
					AND A.ID_PROFILE = ".$profile."
					AND A.DAYPART = '".$daypart."'
					AND `STATUS` = 1  ".$wh_chn."
					ORDER BY A.AUDIENCE DESC
					";
					
				}
			
				$sql	= $db->select($query);
				return $sql->rows();		   
	}
	
 	public function list_spot_by_program_all_bar($field,$where,$periode,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
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
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function get_univ($params){ 

 		   
      $sql = " SELECT * FROM t_profiling_ub_res where `id` = ".$params;
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
	}        
	
	public function list_spot_by_program_all_bar_avg_alls_exp($daypart,$where,$periode,$pilihaudiencebar,$profile,$check,$start_date,$end_date,$order,$search,$survey) {
		$db = $this->clickhouse->db();
		$data_file = $periode;
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		
		$get_profile = $this->get_profile_id($profile);
		
		$time_segment = explode('-',$daypart);
			
			$params['start_time'] = $time_segment[0];
			$params['end_time'] = $time_segment[1];
			
			if($params['end_time'] == '00:00:00' && $params['start_time'] <> '00:00:00'){
				$params['end_time'] = '23:59:59';
			}
		
		if($search == ""){
			$wh_sch = '';
		}else{
			$wh_sch = " AND (A.CHANNEL LIKE '%".$search."%' )";
		}
		
		if($order == ''){
			$wh_order = "ORDER BY A.VIEWERS2 DESC";
		}else{
			
			$ordering = explode(',',$order);
			$array_filed = ['Rangking','channel','AUDIENCE','VIEWERS','TVR','TVS','INDEX','REACH'];
			
			$wh_order = "ORDER BY ".$array_filed[$ordering[0]]." ".$ordering[1];
		}
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		if($survey == '2022'){
			$tbl_m = 'CDR_EPG_RES_ALL_STEP2_2022';
		}else{
			$tbl_m = 'CDR_EPG_RES_ALL_STEP2_2021';
		}
		
		if($daypart == 'ALL'  || $daypart == '' ){
			$where_time = " ";
		}ELSE{
			$where_time = " AND formatDateTime(A.BEGIN_PROGRAM,'%T') BETWEEN '".$params['start_time']."' AND '".$params['end_time']."' ";
		}
		
		if($survey == '2022'){
			
			if($profile == 1 || $profile == 0){
 				
					$prof_qr = "
				
							SELECT `CHANNEL`,SUM(WEIGHT) AS VIEWERS2,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
							SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, '".$periode."' PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
							CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
							WHERE 
							(
								A.`BEGIN_PROGRAM` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
								
							)
							".$where." ".$wh_chn." ".$where_time."
							
							GROUP BY A.RESPID,`CHANNEL`,WEIGHT,WEIGHT_ALL
							) GROUP BY `CHANNEL`,PERIODE,STS
				
				";
				
			}else{
				$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
				
				$prof_qr = "
				
							SELECT `CHANNEL`,SUM(WEIGHT) AS VIEWERS2,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
							SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, '".$periode."' PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
							CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
							WHERE A.RESPID IN (".$sql_c.") AND 
							(
								A.`BEGIN_PROGRAM` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
								
							)
							".$where." ".$wh_chn." ".$where_time."
							
							GROUP BY A.RESPID,`CHANNEL`,WEIGHT,WEIGHT_ALL
							) GROUP BY `CHANNEL`,PERIODE,STS
				
				";
				
			}
		
		}else{
			
			if($profile == 1 || $profile == 0){
 				
				$prof_qr = '
				
							SELECT `CHANNEL` ,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT `CHANNEL` AS channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$periode.'" PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2021 A
							WHERE 
							(
								A.`BEGIN_PROGRAM` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								
							)
							'.$where.' '.$wh_chn.' '.$where_time.'
							
							GROUP BY A.RESPID,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
							) O
							GROUP BY `CHANNEL`,HARIS
							) GROUP BY `CHANNEL`
				
				';
				
			}else{
				$sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$profile; 
				$prof_qr = '
				
							SELECT `CHANNEL` ,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT `CHANNEL` AS channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$periode.'" PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2021 A
							WHERE 
							A.RESPID IN ('.$sql_c.') AND 
							(
								A.`BEGIN_PROGRAM` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								
							)
							'.$where.' '.$wh_chn.' '.$where_time.'
							
							GROUP BY A.RESPID,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
							) O
							GROUP BY `CHANNEL`,HARIS
							) GROUP BY `CHANNEL`
				
				';
				
			}
			
		}
		
		if($daypart == 'ALL' || $daypart == '' ){
			$where_time = '';
			
			if($profile == 1 || $profile == 0){
			
				$qry_ends = "
				SELECT A.CHANNEL,'' `DATES`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1 
								AND `ID_PROFILE` = ".$profile." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
								GROUP BY `CHANNEL`
				";
			
			}ELSE{
				
				if($profile > 8000504){
					
					$qry_ends = "
					SELECT A.CHANNEL, A.DATES, A.AUDIENCE,A.VIEWERS, A.TVR, A.TVS, (A.TVR/B.TVR)*100 AS `INDEX`, A.REACH FROM (
					
						SELECT CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = ".$profile." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
									
					) A JOIN (
						
						SELECT A.CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = 1 ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
					) B ON A.CHANNEL = B.CHANNEL
					";
				
				}else{
					
					$qry_ends = "
					
					SELECT A.CHANNEL, A.DATES, A.AUDIENCE,A.VIEWERS, A.TVR, A.TVS, (A.TVR/B.TVR)*100 AS `INDEX`, A.REACH FROM (
					
						SELECT CHANNEL_NAME_PROG CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = ".$profile." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
									
					) A JOIN (
						
						SELECT A.CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = 1 ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
					) B ON A.CHANNEL = B.CHANNEL
					";
					
				}
			}
			
			$query = "
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							".$qry_ends."
						) B ON A.CHANNEL = B.CHANNEL
						ORDER BY A.VIEWERS2 DESC

		
			";  
			
		}else{

			$where_time = " AND formatDateTime(A.SPLIT_MINUTES,'%T') BETWEEN '".$params['start_time']."' AND '".$params['end_time']."' ";
			
			if($profile == 0 || $profile == 1){
			
				$qry_ends = "
					SELECT CHANNEL_NAME_PROG CHANNEL,'' `DATE`, 
								AVG(A.VIEWERS) AS AUDIENCE, 
								CEIL(AVG(A.VIEWERS)) AS VIEWERS, 
								AVG((A.VIEWERS/A.UNIVERSE)*100) AS TVR , 
								AVG((A.VIEWERS/A.ALL_VIEWS)*100) AS TVS,
								100 AS `INDEX`,
								100 AS REACH,
								`UNIVERSE_A`							
								FROM `SUMMARY_PER_MINUTES_RES_V2` A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
									WHERE 1=1  
									AND `PROFILE_ID` = '".$profile."' ".$where." ".$wh_chn." ".$where_time." 
									AND  SPLIT_MINUTES BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
									GROUP BY `CHANNEL_NAME_PROG`,UNIVERSE_A
				";
				
				$query = "
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					(A.VIEWERS2/B.UNIVERSE_A)*100 AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							".$qry_ends."
						) B ON A.CHANNEL = B.CHANNEL
						ORDER BY A.VIEWERS2 DESC

		
			";  
			
			}else{
			
				$qry_ends = "
				
				SELECT * FROM (
					SELECT A.CHANNEL,'' `DATE`, 
								AVG(A.VIEWERS) AS AUDIENCE, 
								CEIL(AVG(A.VIEWERS)) AS VIEWERS, 
								AVG(A.TVRR) AS TVR , 
								AVG(A.TVSS) AS TVS,
								MAX(IDEX) AS `INDEX`,
								100 AS REACH,
								`UNIVERSE_A`							
								FROM (
									SELECT A.*,(A.TVR/B.TVR)*100 AS IDEX, (A.VIEWERS/A.UNIVERSE)*100 AS TVRR,(A.VIEWERS/A.ALL_VIEWS)*100 AS TVSS FROM (
										SELECT * FROM `SUMMARY_PER_MINUTES_RES_V2` A
										WHERE A.`PROFILE_ID` = '".$profile."'    
										".$where." ".$wh_chn." 
										AND  A.`SPLIT_MINUTES` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
										".$where_time."
									) A JOIN (
										SELECT * FROM `SUMMARY_PER_MINUTES_RES_V2` A
										WHERE A.`PROFILE_ID` = '1'    
										".$where." ".$wh_chn." 
										AND  A.`SPLIT_MINUTES` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
										".$where_time."
										
									) B ON A.CHANNEL = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTES
							
								) A
								GROUP BY `CHANNEL`,UNIVERSE_A
				) A JOIN
				CHANNEL_PARAM_FINAL C ON A.CHANNEL = C.CHANNEL_NAME 
	
				";
				
				$query = "
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					(A.VIEWERS2/B.UNIVERSE_A)*100 AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							".$qry_ends."
						) B ON A.CHANNEL = B.CHANNEL_NAME_PROG
						ORDER BY A.VIEWERS2 DESC

		
			";  

			}
			
			
			
		}
		
		
	 
		$result = $db->select($query);
		return $result->rows();	
	}
	
	public function list_spot_by_program_all_bar_avg_alls($daypart,$where,$periode,$pilihaudiencebar,$profile,$check,$start_date,$end_date,$survey) {
		$db = $this->clickhouse->db();
		$data_file = $periode;
		$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
		$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
		$name_tbs_new = strtoupper(date_format(date_create($data_file),"Ym")); //201811
		$huawei_date = strtoupper(date_format(date_create($data_file),"Ymd")); //20181102
		$periode =date_format(date_create($data_file),"Y-F"); //2018-March
		
		$get_profile = $this->get_profile_id($profile);
		
		$time_segment = explode('-',$daypart);
			
			$params['start_time'] = $time_segment[0];
			$params['end_time'] = $time_segment[1];
			
			if($params['end_time'] == '00:00:00' && $params['start_time'] <> '00:00:00'){
				$params['end_time'] = '23:59:59';
			}
			
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		
		
		if($survey == '2022'){
			$tbl_m = 'CDR_EPG_RES_ALL_STEP2_2022';
		}else{
			$tbl_m = 'CDR_EPG_RES_ALL_STEP2_2021';
		}
		
		if($daypart == 'ALL' || $daypart == '' ){
			$where_time = " ";
		}ELSE{
			$where_time = " AND formatDateTime(A.BEGIN_PROGRAM,'%T') BETWEEN '".$params['start_time']."' AND '".$params['end_time']."' ";
		}

		if($survey == '2022'){

			if($profile == 1 || $profile == 0){
 				
				$prof_qr = "
				
							SELECT `CHANNEL`,SUM(WEIGHT) AS VIEWERS2,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
							SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, '".$periode."' PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
							CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
							WHERE 
							(
								A.`BEGIN_PROGRAM` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
								
							)
							".$where." ".$wh_chn." ".$where_time."
							
							GROUP BY A.RESPID,`CHANNEL`,WEIGHT,WEIGHT_ALL
							) GROUP BY `CHANNEL`,PERIODE,STS
				
				";
				
			}else{
				$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$profile; 
				
				$prof_qr = "
				
							SELECT `CHANNEL`,SUM(WEIGHT) AS VIEWERS2,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
							SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, '".$periode."' PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
							CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
							WHERE A.RESPID IN (".$sql_c.") AND 
							(
								A.`BEGIN_PROGRAM` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
								
							)
							".$where." ".$wh_chn." ".$where_time."
							
							GROUP BY A.RESPID,`CHANNEL`,WEIGHT,WEIGHT_ALL
							) GROUP BY `CHANNEL`,PERIODE,STS
				
				";

				
			}
		
		}else{
			
			if($profile == 1 || $profile == 0){
				$tbl_m = 'CDR_EPG_RES_'.$name_tbs_new.'_STEP2_2021';
				
				$prof_qr = '
				
							SELECT `CHANNEL` ,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT `CHANNEL` AS channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$periode.'" PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2021 A
							WHERE 
							(
								A.`BEGIN_PROGRAM` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								
							)
							'.$where.' '.$wh_chn.' '.$where_time.'
							
							GROUP BY A.RESPID,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
							) O
							GROUP BY `CHANNEL`,HARIS
							) GROUP BY `CHANNEL`
				
				';
				
			}else{
				$sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$profile; 
				$prof_qr = '
				
							SELECT `CHANNEL` ,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT `CHANNEL` AS channel,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
							SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$periode.'" PERIODE, 0 STS 
							FROM CDR_EPG_RES_ALL_STEP2_2021 A
							WHERE 
							A.RESPID IN ('.$sql_c.') AND 
							(
								A.`BEGIN_PROGRAM` BETWEEN "'.$start_date.' 00:00:00" AND "'.$end_date.' 23:59:59"
								
							)
							'.$where.' '.$wh_chn.' '.$where_time.'
							
							GROUP BY A.RESPID,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
							) O
							GROUP BY `CHANNEL`,HARIS
							) GROUP BY `CHANNEL`
				
				';
				
			}
			
		}
		
		if($daypart == 'ALL' || $daypart == '' ){
			$where_time = '';
			
			if($profile == 1 || $profile == 0){
			
				$qry_ends = "
				SELECT A.CHANNEL,'' `DATES`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1 
								AND `ID_PROFILE` = ".$profile." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
								GROUP BY `CHANNEL`
				";
			
			}ELSE{
				
				if($profile > 8000504){
				
					$qry_ends = "
					
					SELECT A.CHANNEL, A.DATES, A.AUDIENCE,A.VIEWERS, A.TVR, A.TVS, (A.TVR/B.TVR)*100 AS `INDEX`, A.REACH FROM (
					
						SELECT CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = ".$profile." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
									
					) A JOIN (
						
						SELECT A.CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = 1 ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
					) B ON A.CHANNEL = B.CHANNEL
					";
				}else{
										$qry_ends = "
					
					SELECT A.CHANNEL, A.DATES, A.AUDIENCE,A.VIEWERS, A.TVR, A.TVS, (A.TVR/B.TVR)*100 AS `INDEX`, A.REACH FROM (
					
						SELECT CHANNEL_NAME_PROG CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = ".$profile." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
									
					) A JOIN (
						
						SELECT A.CHANNEL,'' `DATES`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_CHAN_DAY_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1 
									AND `ID_PROFILE` = 1 ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$start_date."' AND '".$end_date."'
									GROUP BY `CHANNEL`
					) B ON A.CHANNEL = B.CHANNEL
					";

				}
			}
			
			$query = "
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							".$qry_ends."
						) B ON A.CHANNEL = B.CHANNEL
						ORDER BY A.VIEWERS2 DESC

		
			";  
			
		}else{
			
			
			$where_time = " AND formatDateTime(A.SPLIT_MINUTES,'%T') BETWEEN '".$params['start_time']."' AND '".$params['end_time']."' ";
			
			if($profile == 1 || $profile == 0){    
			
				$qry_ends = "
					SELECT CHANNEL_NAME_PROG AS CHANNEL,'' `DATE`, 
								AVG(A.VIEWERS) AS AUDIENCE, 
								CEIL(AVG(A.VIEWERS)) AS VIEWERS, 
								AVG((A.VIEWERS/A.UNIVERSE)*100) AS TVR , 
								AVG((A.VIEWERS/A.ALL_VIEWS)) AS TVS,
								100 AS `INDEX`,
								100 AS REACH,
								`UNIVERSE_A`							
								FROM `SUMMARY_PER_MINUTES_RES_V2` A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
									WHERE 1=1  
									AND `PROFILE_ID` = '".$profile."' ".$where." ".$wh_chn." ".$where_time."
									AND  SPLIT_MINUTES BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
									GROUP BY `CHANNEL_NAME_PROG`,UNIVERSE_A
				";
				
				$query = "
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					(A.VIEWERS2/B.UNIVERSE_A)*100 AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							".$qry_ends."
						) B ON A.CHANNEL = B.CHANNEL
						ORDER BY A.VIEWERS2 DESC

		
			";  
			
			}else{
				
				$qry_ends = "
				
				SELECT * FROM (
					SELECT A.CHANNEL,'' `DATE`, 
								AVG(A.VIEWERS) AS AUDIENCE, 
								CEIL(AVG(A.VIEWERS)) AS VIEWERS, 
								AVG(A.TVRR) AS TVR , 
								AVG(A.TVSS) AS TVS,
								MAX(IDEX) AS `INDEX`,
								100 AS REACH,
								`UNIVERSE_A`							
								FROM (
									SELECT A.*,(A.TVR/B.TVR)*100 AS IDEX, (A.VIEWERS/A.UNIVERSE)*100 AS TVRR,(A.VIEWERS/A.ALL_VIEWS)*100 AS TVSS FROM (
										SELECT * FROM `SUMMARY_PER_MINUTES_RES_V2` A
										WHERE A.`PROFILE_ID` = '".$profile."'   
										".$where." ".$wh_chn." 
										AND  A.`SPLIT_MINUTES` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
										".$where_time."
									) A JOIN (
										SELECT * FROM `SUMMARY_PER_MINUTES_RES_V2` A
										WHERE A.`PROFILE_ID` = '1'    
										".$where." ".$wh_chn." 
										AND  A.`SPLIT_MINUTES` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
										".$where_time."
										
									) B ON A.CHANNEL = B.CHANNEL AND A.SPLIT_MINUTES = B.SPLIT_MINUTES
							
								) A
								GROUP BY `CHANNEL`,UNIVERSE_A
				) A JOIN
				CHANNEL_PARAM_FINAL C ON A.CHANNEL = C.CHANNEL_NAME 
				";
				
				$query = "
		
					SELECT A.CHANNEL as channel, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					(A.VIEWERS2/B.UNIVERSE_A)*100 AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							".$qry_ends."
						) B ON A.CHANNEL = B.CHANNEL_NAME_PROG
						ORDER BY A.VIEWERS2 DESC

		
			";  

			}
			
			
			
		}
		
		//ECHO $query;die;
					
 		$result = $db->select($query);
		return $result->rows();		  
	}
	
	public function list_spot_by_program_all_bar_tvod($field,$where,$periode,$pilihaudiencebar,$profile,$check,$tipe_filter) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
				$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
 	public function list_spot_by_program_hari_bar($field,$where,$periode,$week,$pilihaudiencebar,$profile,$check) {
 
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
					
			if 	($pilihaudiencebar=='Reach')	 {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_PTV_WEEK 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
				
 			}elseif ($pilihaudiencebar=='Viewers') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
 			}elseif ($pilihaudiencebar=='Duration') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
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
 			}
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_hari_date($field,$where,$periode,$datef,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
	 
					
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
				
 			}elseif ($pilihaudiencebar=='Viewers'){
			 
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='Duration'){
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='share'){
			 
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
 			}elseif ($pilihaudiencebar=='avgtotdur'){
			 
				
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
 			}elseif ($pilihaudiencebar=='tvs'){
				 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "TVS" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='tvr'){
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "TVR" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='audience2'){
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
 			}else {
				 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot,VIEWERS2 AS Spot2 FROM M_SUM_TV_DASH_CHAN_DAY_RES 
				WHERE TANGGAL ="'.$periode.'" AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS" AND `DATE` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
 			}
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
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
 		}elseif ($pilihprog=='Viewers') {
		 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			(
				SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAY` ="'.$tgl2.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC )z';
			 
		}elseif ($pilihprog=='Duration') {
		 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			(
				SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC 
				)z';
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
		 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,Program DESC) AS Rangking FROM 
			(
				SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$tgl2.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC )z';
 		}		
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}

	public function list_spot_by_program_all2Ps_new_week_x($field,$where,$params,$pilihprog,$profile) {
	
		if($params['check'] == "False"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		
		if ($pilihprog=='TVR'){
 
					
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
		
		
		 $sql	= $this->db2->query($query2);
		$this->db2->close();
		$this->db2->initialize(); 
 		return $sql->result_array();		
	}
	
	public function list_spot_by_program_all2Ps_new_week($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
		if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR'){
			 
					
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
		
		
 		  $out		= array();
		  $querys		= $this->db2->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	 
		 $query2s		= $this->db2->query($query2);
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
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		
		if ($pilihprog=='TVR'){
			 
					
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
		
		
 		 $sql	= $this->db2->query($query2);
		$this->db2->close();
		$this->db2->initialize(); 
 		return $sql->result_array();	
	}
	
	public function list_spot_by_program_all2Ps_new_day($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
		if($params['check'] == "True"){
				$wh_chn = ''; 
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR2'){
			 
					
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
		
		
 		  $out		= array();
		  $querys		= $this->db2->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
 
		 $query2s		= $this->db2->query($query2);
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
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
	 
		$where = " ";
		
		if ($pilihprog=='TVR'){
			 
					
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
		
		
 		
		 $sql	= $this->db2->query($query2);
		$this->db2->close();
		$this->db2->initialize(); 
 		return $sql->result_array();			

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
		 
		$where = " ";
		
		if ($pilihprog=='TVR'){
		 
					
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
		
		
 		
		 $sql	= $this->db2->query($query2);
		$this->db2->close();
		$this->db2->initialize(); 
 		return $sql->result_array();			

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
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
		
		
 		  $out		= array();
		  $querys		= $this->db2->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
	 
		 $query2s		= $this->db2->query($query2);
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
 				$wh_chn = ''; 
			 
		
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
		
		
		 
		 $query2s		= $this->db2->query($query2);
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
		
		
 
		 $query2s		= $this->db2->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2
          
      );
      return $return; 
	}
	
	public function list_spot_by_program_all2Ps_new_avg_alls_print($field,$wheres,$params,$pilihprog,$profile) { 
		$db = $this->clickhouse->db();
		
		$where = " AND (PROGRAM LIKE '%".$params['search_t']."%' OR CHANNEL LIKE '%".$params['search_t']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
		
		if($params['check'] == "True"){

			IF($params['survey_data'] == '2022'){
			
			
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = "
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM,' ',toString(BEGIN_PROGRAM)) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,BEGIN_PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL,BEGIN_PROGRAM
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS,BEGIN_PROGRAM
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS,BEGIN_PROGRAM
					
					";
					
				}else{
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$params['profile']; 
					$prof_qr = "
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM,' ',toString(BEGIN_PROGRAM)) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,BEGIN_PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE A.RESPID IN (".$sql_c.") AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL,BEGIN_PROGRAM
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS,BEGIN_PROGRAM
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS,BEGIN_PROGRAM
					
					";
					
				}
				
			}else{
				
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = '
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM," ",BEGIN_PROGRAM) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,SUM(WEIGHT) AS Spot,BEGIN_PROGRAM,PROGRAM,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,BEGIN_PROGRAM,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,PROGRAM,BEGIN_PROGRAM,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM
					
					';
					
				}else{
					$sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$params['profile']; 
					$prof_qr = '
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM," ",BEGIN_PROGRAM) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,BEGIN_PROGRAM,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,PROGRAM,BEGIN_PROGRAM,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								A.RESPID IN ('.$sql_c.') AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,BEGIN_PROGRAM,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM
					
					';
					
				}
				
			}
			
				if($profile == 0 || $profile == 1){
				
						$query2 = "
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT A.CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 1 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']."  
			";
				
				
				$query = "
				SELECT COUNT(*) AS jumlah  from (
						SELECT A.CHANNEL,A.PROGRAM, 
						A.VIEWERS2 AS AUDIENCE, 
						B.VIEWERS AS VIEWERS, 
						B.TVR AS TVR , 
						B.TVS AS TVS,
						B.INDEX AS `INDEX`,
						B.REACH AS REACH  
						FROM (

							".$prof_qr."
						
							) A LEFT JOIN (
								SELECT A.CHANNEL,`PROGRAM`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1
									AND TYPE = 1 								
									AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
									GROUP BY `CHANNEL`,PROGRAM
							) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
									ORDER BY ".$params['order_column']." ".$params['order_dir']." 
									) a
				";
				
			}else{
				
				$query2 = "
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT B.CHANNEL_NAME_PROG CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`  A JOIN
							CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 1 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']."  
			";
				
				
				$query = "
				SELECT COUNT(*) AS jumlah  from (
						SELECT B.CHANNEL_NAME_PROG CHANNEL,A.PROGRAM, 
						A.VIEWERS2 AS AUDIENCE, 
						B.VIEWERS AS VIEWERS, 
						B.TVR AS TVR , 
						B.TVS AS TVS,
						B.INDEX AS `INDEX`,
						B.REACH AS REACH  
						FROM (

							".$prof_qr."
						
							) A LEFT JOIN (
								SELECT A.CHANNEL,`PROGRAM`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`  A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
									WHERE 1=1  
									AND `STATUS` = 1
									AND TYPE = 1 								
									AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
									GROUP BY `CHANNEL`,PROGRAM
							) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
									ORDER BY ".$params['order_column']." ".$params['order_dir']." 
									) a
				";
				
			}
			
		}else{
			
			IF($params['survey_data'] == '2022'){
				
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = "
					
								SELECT `CHANNEL` ,PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS
					
					";
					
				}else{
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$params['profile']; 
					$prof_qr = "
					
								SELECT `CHANNEL` , PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE A.RESPID IN (".$sql_c.") AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS
					
					";
					
				}
				
			}else{
				
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = '
					
								SELECT `CHANNEL` ,PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,PROGRAM
					
					';
					
				}else{
					$sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$params['profile']; 
					$prof_qr = '
					
								SELECT `CHANNEL` ,PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								A.RESPID IN ('.$sql_c.') AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,PROGRAM
					
					';
					
				}
				
			}
		
				
					$query2 = "
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT A.CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 0 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']."  
			";
			
			$query = "
			SELECT COUNT(*) AS jumlah  from (
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT A.CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 0 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']." 
								) a
			";
			
			}
		
		//ECHO $query2;die;
	
 		  $query2s		= $db->select($query2);
		  $result2 = $query2s->rows();

		 // $query2s		= $this->db2->query($query2);
		// $result2 = $query2s->result_array();	
 
		  
      $return = array(
          'data' => $result2,
          'total_filtered' => count($result2),
          'total' => count($result2),
      );
      return $return;
		
	}
	
	public function list_spot_by_program_all2Ps_new_avg_alls($field,$wheres,$params,$pilihprog,$profile) { 
		$db = $this->clickhouse->db();
		
		$where = " AND (UPPER(PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
		
		if($params['check'] == "True"){

			IF($params['survey_data'] == '2022'){
			
			
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = "
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM,' ',toString(BEGIN_PROGRAM)) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,BEGIN_PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL,BEGIN_PROGRAM
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS,BEGIN_PROGRAM
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS,BEGIN_PROGRAM
					
					";
					
				}else{
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$params['profile']; 
					$prof_qr = "
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM,' ',toString(BEGIN_PROGRAM)) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,BEGIN_PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,BEGIN_PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE A.RESPID IN (".$sql_c.") AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL,BEGIN_PROGRAM
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS,BEGIN_PROGRAM
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS,BEGIN_PROGRAM
					
					";
					
				}
				
			}else{
				
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = '
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM," ",BEGIN_PROGRAM) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,SUM(WEIGHT) AS Spot,BEGIN_PROGRAM,PROGRAM,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,BEGIN_PROGRAM,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,PROGRAM,BEGIN_PROGRAM,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM
					
					';
					
				}else{
					$sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$params['profile']; 
					$prof_qr = '
					
								SELECT `CHANNEL` ,CONCAT(PROGRAM," ",BEGIN_PROGRAM) PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,BEGIN_PROGRAM,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,PROGRAM,BEGIN_PROGRAM,`CHANNEL`,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								A.RESPID IN ('.$sql_c.') AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,BEGIN_PROGRAM,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,BEGIN_PROGRAM,PROGRAM
					
					';
					
				}
				
			}
			
			if($profile == 0 || $profile == 1){
				
						$query2 = "
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT A.CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 1 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']."  
								LIMIT ".$params['limit']." 
								OFFSET ".$params['offset']." 
			";
				
				
				$query = "
				SELECT COUNT(*) AS jumlah  from (
						SELECT A.CHANNEL,A.PROGRAM, 
						A.VIEWERS2 AS AUDIENCE, 
						B.VIEWERS AS VIEWERS, 
						B.TVR AS TVR , 
						B.TVS AS TVS,
						B.INDEX AS `INDEX`,
						B.REACH AS REACH  
						FROM (

							".$prof_qr."
						
							) A LEFT JOIN (
								SELECT A.CHANNEL,`PROGRAM`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
									WHERE 1=1  
									AND `STATUS` = 1
									AND TYPE = 1 								
									AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
									GROUP BY `CHANNEL`,PROGRAM
							) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
									ORDER BY ".$params['order_column']." ".$params['order_dir']." 
									) a
				";
				
			}else{
				
				$query2 = "
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT B.CHANNEL_NAME_PROG CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`  A JOIN
							CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 1 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']."  
								LIMIT ".$params['limit']." 
								OFFSET ".$params['offset']." 
			";
				
				
				$query = "
				SELECT COUNT(*) AS jumlah  from (
						SELECT  A.CHANNEL,A.PROGRAM, 
						A.VIEWERS2 AS AUDIENCE, 
						B.VIEWERS AS VIEWERS, 
						B.TVR AS TVR , 
						B.TVS AS TVS,
						B.INDEX AS `INDEX`,
						B.REACH AS REACH  
						FROM (

							".$prof_qr."
						
							) A LEFT JOIN (
								SELECT A.CHANNEL,`PROGRAM`, 
								AVG(A.AUDIENCE) AS AUDIENCE, 
								AVG(A.VIEWERS) AS VIEWERS, 
								AVG(A.TVR) AS TVR , 
								AVG(A.TVS) AS TVS,
								AVG(A.INDEX) AS `INDEX`,
								AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL`  A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME  
									WHERE 1=1  
									AND `STATUS` = 1
									AND TYPE = 1 								
									AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
									AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
									GROUP BY `CHANNEL`,PROGRAM
							) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
									ORDER BY ".$params['order_column']." ".$params['order_dir']." 
									) a
				";
				
			}
			
		}else{
			
			IF($params['survey_data'] == '2022'){
				
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = "
					
								SELECT `CHANNEL` ,PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS
					
					";
					
				}else{
					$sql_c = " SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = ".$params['profile']; 
					$prof_qr = "
					
								SELECT `CHANNEL` , PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,'AUDIENCE' AS DT,0 AS IDPRO, STS FROM (
								SELECT '' HARIS,CHANNEL_NAME_PROG `CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, '".$params['periode']."' PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2022 A JOIN
								CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
								WHERE A.RESPID IN (".$sql_c.") AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
									
								)
								".$where." ".$wh_chn." 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,WEIGHT,WEIGHT_ALL
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS,PERIODE,STS
								) GROUP BY `CHANNEL`,PROGRAM,PERIODE,STS
					
					";
					
				}
				
			}else{
				
				if($profile == 0 || $profile == 1){
					$tbl_m = 'CDR_EPG_RES__STEP2_2021';
					
					$prof_qr = '
					
								SELECT `CHANNEL` ,PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,PROGRAM,`CHANNEL`,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,PROGRAM
					
					';
					
				}else{
					$sql_c = ' SELECT `CARDNO` AS people FROM PROFILE_CARDNO_RES WHERE M_TYPE = 0 AND ID_PROFILE = '.$params['profile']; 
					$prof_qr = '
					
								SELECT `CHANNEL` ,PROGRAM,MAX(Spot2) AS VIEWERS2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT `CHANNEL`,PROGRAM,SUM(WEIGHT) AS Spot,SUM(WEIGHT_ALL) AS Spot2,PERIODE,"AUDIENCE" AS DT,0 AS IDPRO, STS FROM (
								SELECT DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d") HARIS,`CHANNEL`,PROGRAM,A.RESPID, WEIGHT,WEIGHT_ALL, "'.$params['periode'].'" PERIODE, 0 STS 
								FROM CDR_EPG_RES_ALL_STEP2_2021 A
								WHERE 
								A.RESPID IN ('.$sql_c.') AND 
								(
									A.`BEGIN_PROGRAM` BETWEEN "'.$params['start_date'].' 00:00:00" AND "'.$params['end_date'].' 23:59:59"
									
								)
								'.$where.' '.$wh_chn.' 
								
								GROUP BY A.RESPID,PROGRAM,CHANNEL,DATE_FORMAT(BEGIN_PROGRAM,"%Y-%m-%d")
								) O
								GROUP BY `CHANNEL`,PROGRAM,HARIS
								) GROUP BY `CHANNEL`,PROGRAM
					
					';
					
				}
				
			}
		
				
					$query2 = "
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT A.CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 0 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']."  
								LIMIT ".$params['limit']." 
								OFFSET ".$params['offset']." 
			";
			
			$query = "
			SELECT COUNT(*) AS jumlah  from (
					SELECT A.CHANNEL,A.PROGRAM, 
					A.VIEWERS2 AS AUDIENCE, 
					B.VIEWERS AS VIEWERS, 
					B.TVR AS TVR , 
					B.TVS AS TVS,
					B.INDEX AS `INDEX`,
					B.REACH AS REACH  
					FROM (

						".$prof_qr."
					
						) A LEFT JOIN (
							SELECT A.CHANNEL,`PROGRAM`, 
							AVG(A.AUDIENCE) AS AUDIENCE, 
							AVG(A.VIEWERS) AS VIEWERS, 
							AVG(A.TVR) AS TVR , 
							AVG(A.TVS) AS TVS,
							AVG(A.INDEX) AS `INDEX`,
							AVG(A.REACH) AS REACH FROM `M_SUM_TV_DASH_PROG_DAYE_RES_FULL` A 
								WHERE 1=1  
								AND `STATUS` = 1
								AND TYPE = 0 								
								AND `ID_PROFILE` = ".$params['profile']." ".$where." ".$wh_chn." 
								AND  DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
								GROUP BY `CHANNEL`,PROGRAM
						) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								ORDER BY ".$params['order_column']." ".$params['order_dir']." 
								) a
			";
			
			}
		
		//ECHO $query2;DIE;
	
		
 		 //$out		= array();
		  $querys		= $db->select($query);
		  $result = $querys->rows();
		  
		  // $sql	= $db->select($query);
		// return $sql->rows();		
		  // $total_filtered = $result->jumlah;
		  // $total 			= $result->jumlah;
		  
		   $total_filtered = $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];
		 
	  
		  if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	 
		 $query2s		= $db->select($query2);
      $result2 = $query2s->rows();	

		  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
		
	}
	
	public function list_spot_by_program_all2Ps_new_avg_alls_bckp($field,$wheres,$params,$pilihprog,$profile) { 
		
		
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_DAY_RES` a
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVR FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVS FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS REACH FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS `INDEX` FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX"
				AND ID_PROFILE = "'.$profile.'"
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
				WHERE 1=1  AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "AUDIENCE_S"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) A LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_DAY_RES` a
				WHERE 1=1  AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS_S"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVR FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1 AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVR_S"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS TVS FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1  AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "TVS_S"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) D ON A.CHANNEL = D.CHANNEL AND A.PROGRAM = D.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS REACH FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1  AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "REACH_S"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) E ON A.CHANNEL = E.CHANNEL AND A.PROGRAM = E.PROGRAM LEFT JOIN (

				SELECT DISTINCT `PROGRAM`,CHANNEL, AVG(VIEWERS2) AS `INDEX` FROM M_SUM_TV_DASH_PROG_DAY_RES a
				WHERE 1=1  AND TANGGAL="'.$params['periode'].'"
				AND `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND `STATUS` = 1 AND DATA_TYPE = "INDEX_S"
				AND ID_PROFILE = "'.$profile.'"
				GROUP BY CHANNEL,PROGRAM

				) F ON A.CHANNEL = F.CHANNEL AND A.PROGRAM = F.PROGRAM
				WHERE 1=1 '.$wh_chn.'
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'  
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
				';
		}
		
 		 $out		= array();
		  $querys		= $this->db2->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
 
		 $query2s		= $this->db2->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
		
	}
	
	public function list_spot_by_program_all2Ps_new_alls_print($field,$wheres,$params,$pilihprog,$profile) {
		$db = $this->clickhouse->db();
		
		$where = " AND (A.PROGRAM LIKE '%".$params['search_t']."%' OR A.CHANNEL LIKE '%".$params['search_t']."%') AND TANGGAL = '".$params['periode']."'";
			
			if($params['check2'] == "True"){
				$wh_chn = "";
			}else{
					$wh_chn = " AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
			
			if($params['check'] == "True"){
				$wh_chn2 = " AND TYPE = 0 " ;
			}else{
				$wh_chn2 = " AND TYPE = 1 " ;
			}
		
		if($params['check'] == "True"){
			
			$query = 	"	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES_FULL A
						WHERE 1=1 AND ID_PROFILE = '".$profile."' AND TANGGAL='".$params['periode']."'
						AND `STATUS` = 1 AND `TYPE` = 1
						AND `ID_PROFILE` = ".$params['profile']."
						".$wh_chn." ".$where."
						GROUP BY CHANNEL,PROGRAM
						)z 
						";
			
			$query2 = "
			SELECT A.CHANNEL,A.PROGRAM, 
			A.AUDIENCE AS AUDIENCE, 
			A.VIEWERS AS VIEWERS, 
			A.TVR AS TVR , 
			A.TVS AS TVS,
			A.INDEX AS `INDEX`,
			A.REACH AS REACH from M_SUM_TV_DASH_PROG_RES_FULL A 
				WHERE 1=1 ".$wh_chn." ".$where."
				AND `STATUS` = 1 AND `TYPE` = 1 
				AND `ID_PROFILE` = ".$profile."
				ORDER BY ".$params['order_column']." ".$params['order_dir']."  
				";
			
		}else{
			
			$query = 	"	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, VIEWERS2 AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES_FULL A
						WHERE 1=1 AND ID_PROFILE = '".$profile."' AND TANGGAL='".$params['periode']."'
						AND `STATUS` = 1 AND `TYPE` = 0
						AND `ID_PROFILE` = ".$params['profile']."
						".$wh_chn." ".$where."
						GROUP BY CHANNEL,PROGRAM
						)z 
						";
			
			$query2 = "
			SELECT A.CHANNEL,A.PROGRAM, 
			A.AUDIENCE AS AUDIENCE, 
			A.VIEWERS AS VIEWERS, 
			A.TVR AS TVR , 
			A.TVS AS TVS,
			A.INDEX AS `INDEX`,
			A.REACH AS REACH from M_SUM_TV_DASH_PROG_RES_FULL A 
				WHERE 1=1 ".$wh_chn." ".$where."
				AND `TYPE` = 0 AND `STATUS` = 1 
				AND `ID_PROFILE` = ".$profile."
				ORDER BY ".$params['order_column']." ".$params['order_dir']."  
				";
		}
		
		 $querys		= $db->select($query2);
		  $result = $querys->rows();
		  
 		 // $out		= array();
		  // $querys		= $this->db2->query($query2);
		  // $result = $querys->result_array();
		  
		  
		 $return = array(
          'data' => $result,
          'total_filtered' => count($result),
          'total' => count($result)
		);

      return $return;
		
		
	}
	
	public function list_spot_by_program_all2Ps_new_alls($field,$wheres,$params,$pilihprog,$profile) {
		
		$db = $this->clickhouse->db();
		
		$where = " AND (UPPER(A.PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(A.CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') AND TANGGAL = '".$params['periode']."'";
			
			if($params['check2'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND A.CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
			
			if($params['check'] == "True"){
				$wh_chn2 = ' AND TYPE = 0 ' ;
			}else{
				$wh_chn2 = ' AND TYPE = 1 ' ;
			}
		
		if($params['check'] == "True"){
			
			$query = 	"	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, MAX(VIEWERS2) AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES_FULL A
						WHERE 1=1 AND ID_PROFILE = '".$profile."' AND TANGGAL='".$params['periode']."'
						AND `STATUS` = 1 AND `TYPE` = 1
						AND `ID_PROFILE` = ".$params['profile']."
						".$wh_chn." ".$where."
						GROUP BY CHANNEL,PROGRAM
						)z 
						";
			
			$query2 = "
			SELECT A.CHANNEL,A.PROGRAM, 
			A.AUDIENCE AS AUDIENCE, 
			A.VIEWERS AS VIEWERS, 
			A.TVR AS TVR , 
			A.TVS AS TVS,
			A.INDEX AS `INDEX`,
			A.REACH AS REACH from M_SUM_TV_DASH_PROG_RES_FULL A 
				WHERE 1=1 ".$wh_chn." ".$where."
				AND `TYPE` = 1 AND `STATUS` = 1 
				AND `ID_PROFILE` = ".$profile."
				ORDER BY ".$params['order_column']." ".$params['order_dir']."  
				LIMIT ".$params['limit']."
				OFFSET ".$params['offset']." 
				";
			
		}else{
			
			$query = 	"	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT `PROGRAM`,CHANNEL, MAX(VIEWERS2) AS AUDIENCE FROM M_SUM_TV_DASH_PROG_RES_FULL A
						WHERE 1=1 AND ID_PROFILE = '".$profile."' AND TANGGAL='".$params['periode']."'
						AND `STATUS` = 1 AND `TYPE` = 0
						AND `ID_PROFILE` = ".$params['profile']."
						".$wh_chn." ".$where."
						GROUP BY CHANNEL,PROGRAM
						)z 
						";
			
			$query2 = "
			SELECT A.CHANNEL,A.PROGRAM, 
			A.AUDIENCE AS AUDIENCE, 
			A.VIEWERS AS VIEWERS, 
			A.TVR AS TVR , 
			A.TVS AS TVS,
			A.INDEX AS `INDEX`,
			A.REACH AS REACH from M_SUM_TV_DASH_PROG_RES_FULL A 
				WHERE 1=1 ".$wh_chn." ".$where."
				AND `TYPE` = 0 AND `STATUS` = 1 
				AND `ID_PROFILE` = ".$profile."
				ORDER BY ".$params['order_column']." ".$params['order_dir']."  
				LIMIT ".$params['limit']."
				OFFSET ".$params['offset']." 
				";
		}
		
		//ECHO $query2;DIE;
		
 		 $querys		= $db->select($query);
		  $result = $querys->rows();
		  
		  $total_filtered = $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];	
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	 
		 $query2s		= $db->select($query2);
      $result2 = $query2s->rows();	
	  
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
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if($params['check'] == "True"){
		
		
		if ($pilihprog=='TVR2'){
		 
					
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
		
		
 		
		  $out		= array();
		  $querys		= $this->db2->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
 
		 $query2s		= $this->db2->query($query2);
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
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR'){
		 
					
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
		
		
 		
		  $out		= array();
		  $querys		= $this->db2->query($query);
		  $result = $querys->row();
		  
		  $total_filtered = $result->jumlah;
		  $total 			= $result->jumlah;
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
	
 
		 $query2s		= $this->db2->query($query2);
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
		
		$db = $this->clickhouse->db();
		
		if ($pilihprog=='TVR'){
		 
					
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
						
						$query ="
							SELECT a.`".$field."`,CHANNEL, MAX(VIEWERS) AS Spot,MAX(VIEWERS2) AS Spot2 
						FROM M_SUM_TV_DASH_PROG_RES a 
						WHERE 1=1 AND ID_PROFILE = '".$profile."' AND TANGGAL='".$periode."' ".$where."
						AND `STATUS` = 1 AND DATA_TYPE = 'VIEWERS' 
						GROUP BY CHANNEL,a.`".$field."` ORDER BY Spot DESC 
						";
		}		
		
		//echo $query;die;
		
 		$sql	= $db->select($query);
		return $sql->rows();	 
	}
	//Dashboard Tabel PROGRAM HARI
	public function list_spot_by_program_all2Ps_hari($field,$where,$periode,$week,$pilihprog,$profile) {
		if ($pilihprog=='TVR'){
			$query = 	'SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK_PTV a 
			WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
			AND ID_PROFILE = "'.$profile.'" 
			ORDER BY Spot DESC ';
 		}else if ($pilihprog=='Viewers') {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
 		}else if ($pilihprog=='Duration') {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
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
 		}	else {
			$query = 'SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC';
 		}		
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}

	//Dashboard Pie Audience by Time
	public function list_spot_by_daytime_all2($where,$periode,$tb1) {
		$db = $this->clickhouse->db();
		$query = "SELECT `FIELDS` AS TIME,VIEWERS FROM ".$tb1."
					 WHERE 1=1 AND `STATUS` = 1 AND TYPE_FIELD = 'PRIME' AND TANGGAL='".$periode."' ".$where."
					 ORDER BY `FIELDS` DESC	";
		  			
		$result = $db->select($query);
		return $result->rows();		   
	}
	

	//Dashboard Audience by Daypart
	public function list_spot_by_daypart($where,$periode,$tb1) {
		$db = $this->clickhouse->db();
		$query = "SELECT `FIELDS` TIME ,VIEWERS FROM ".$tb1."
					 WHERE 1=1 AND `STATUS` = 1 AND TYPE_FIELD = 'DAYPART' AND TANGGAL='".$periode."' ".$where."
					 ORDER BY VIEWERS DESC	";
					
		$result = $db->select($query);
		return $result->rows();		   
	}
	
	public function list_default_daypart($iduser,$periode) {
		$query = "SELECT * FROM RSCH_DAYPART_MAN
					 WHERE 1=1 AND ID_PROFILE IN (0,".$iduser.")
					 AND STS = 1
					 GROUP BY TEXT
					 ORDER BY TEXT 	";
					
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}	
	
	public function list_default_daypart_all($iduser,$periode) {
		$query = "SELECT * FROM RSCH_DAYPART_MAN
					 WHERE 1=1 AND ID_PROFILE IN (0,".$iduser.")
					 GROUP BY TEXT
					 ORDER BY TEXT 	";
					
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
			
 
			
			if($params['audiencebar_2'] == 'AUDIENCE'){
				
				//IF($params['interval'] == 'day'){
					
					IF($params['respondent'] == 'RESP'){
					
						$query = 'SELECT `FIELD` AS `date`, RESP AS spot FROM '.$params['tbl'].'
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH.'
						 '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}ELSE IF($params['respondent'] == 'VIEWERS'){
					
					
						$query = 'SELECT `FIELD` AS `date`, VIEWERS AS spot FROM '.$params['tbl'].'
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH.'
						  '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}ELSE IF($params['respondent'] == 'VIEWERS2'){
					
					
						$query = 'SELECT `FIELD` AS `date`, VIEWERS2 AS spot FROM '.$params['tbl'].'
						  WHERE 1=1 AND TYPE_FIELD = "'.$TYPE_FIELD.'" AND `STATUS` = 1 
						 '.$WHERE_CH.'
						  '.$WHERE_DATE.'
						  ORDER BY `FIELD`';
				
					}
				
			}else{
				
					IF($params['respondent'] == 'RESP'){
					
						$query = 'SELECT `FIELD` AS `date`, RESP AS spot FROM '.$params['tbl'].'
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
			
			 
				  
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
		
	}
		
		
		
	public function list_spot_by_date_all2($where,$periode,$tbl2) {
		
		$db = $this->clickhouse->db();
		
		$query = "SELECT `FIELD` AS `date`, RESP AS spot FROM ".$tbl2."
				  WHERE 1=1 AND TYPE_FIELD = 'DAYS' AND `STATUS` = '1' AND TANGGAL='".$periode."' ".$where." 
				  ORDER BY `FIELD`";			
		//ECHO $query;DIE;
		
		$sql	= $db->select($query);
		return $sql->rows();	
	}
	
		public function list_spot_by_date_all2_viewer($where,$periode) {
		$query = 'SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV_VIEWERS
				  WHERE 1=1 AND TANGGAL="'.$periode.'" '.$where.' 
				  ORDER BY DATE';			
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}

	public function list_spot_by_date_all2_duration($where,$periode) {
		$query = 'SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV_DURATION
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
	
	public function list_populasi2($periode,$tb1) {
		$db = $this->clickhouse->db();
		 
		$date=date_create($periode);
		$pr = strtoupper(date_format($date,"My"));
		
		$query = "SELECT VIEWERS AS tot_pop FROM ".$tb1." WHERE TYPE_FIELD = 'UNIVERSE'  AND `STATUS` = 1 ";
		//ECHO $query;DIE;
		
		 
		$sql	= $db->select($query);
		return $sql->rows();	   
	} 
	
	public function list_populasi2a($periode,$tb1) { 
		$db = $this->clickhouse->db();
		$date=date_create($periode);
		$pr = strtoupper(date_format($date,"My"));
		
		$query = "SELECT VIEWERS AS tot_pop FROM ".$tb1." WHERE TYPE_FIELD = 'UNIVERSE ALL'  AND `STATUS` = 1 AND TANGGAL='".$periode."' ";
		
	 	
		$sql	= $db->select($query);
		return $sql->rows();		   
	} 
	
	public function list_populasi() {
 		$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM NEW_CDR_LIVE_CLEAN_CS';
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_all2($where,$periode) {
		
		$db = $this->clickhouse->db();
		// $query = 'SELECT COUNT(`PROGRAM`) AS spot FROM (
		// SELECT DISTINCT a.`PROGRAM`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_RES a 
		// WHERE `ID_PROFILE` = 0 AND `STATUS` = 1 AND DATA_TYPE = "VIEWERS" AND TANGGAL="'.$periode.'" '.$where.' 
		// GROUP BY CHANNEL,a.`PROGRAM`
		
		// ) P ';  	
		
		$query = "
		SELECT COUNT(`PROGRAM`) AS spot FROM (
		SELECT DISTINCT a.`PROGRAM`,CHANNEL, MAX(VIEWERS) AS Spot FROM M_SUM_TV_DASH_PROG_RES a 
		WHERE `ID_PROFILE` ='1' AND `STATUS` = '1' AND DATA_TYPE = 'VIEWERS' AND TANGGAL='".$periode."' ".$where." 
		GROUP BY CHANNEL,a.`PROGRAM`
		
		) P 
		";
		
		$sql	= $db->select($query);
		return $sql->rows();	
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
	public function count_channel($periode) {
	 
$db = $this->clickhouse->db();
 	$query = "SELECT COUNT(RESPID) jmlch FROM `URBAN_PROFILE_2022` WHERE tv_genre IS NOT NULL ";  	

			
 		$sql	= $db->select($query);
		return $sql->rows();	  
	}
	
	
	public function save_daypart($data){ 
      $sql 	= "INSERT INTO RSCH_DAYPART_MAN
	  VALUES('".$data['new_from']."','".$data['new_to']."','".$data['new_time']."','".$data['new_time']."',".$data['user_id'].",0)";
             
      if ($sql) {
          $this->db2->query($sql);
          
          $query = "SELECT * FROM RSCH_DAYPART_MAN
					 WHERE 1=1 AND ID_PROFILE IN (0,".$data['user_id'].")
					 AND STS = 1
					 GROUP BY TEXT
					 ORDER BY TEXT 	";		
      		$sql	= $this->db2->query($query);
      		$this->db2->close();
      		$this->db2->initialize(); 
      		return $sql->result_array();	
      } 
      else {
          return false;
      }
  }
  
  	public function apply_daypart($data){ 
	
	
	$sqlD = "DELETE FROM RSCH_DAYPART_MAN_TEM WHERE ID_PROFILE = '".$data['user_id']."' ";
	$this->db2->query($sqlD);
	
 	$text_where = '';
	for($it=1;$it < 7; $it++){
		
		$dtime = explode("-",$data['dplist_'.$it]);
		$new_to =  date("H:i:s", strtotime($dtime[1].":00") - 1);
		$new_from = $dtime[0].':00';
		$new_time = $dtime[0].'-'.$dtime[1];
		$sts = $data['vis_val_'.$it];
		
		if( date("H:i:s", strtotime($dtime[1].":00")) < date("H:i:s", strtotime($dtime[0].":00")) ){
			$text_where .= "('".$new_from."','23:59:59','".$new_time."','".$new_time."',".$data['user_id'].",".$sts.",0),";
			$text_where .= "('00:00:00','".$new_to."','".$new_time."','".$new_time."',".$data['user_id'].",".$sts.",0),";
		}else{
			$text_where .= "('".$new_from."','".$new_to."','".$new_time."','".$new_time."',".$data['user_id'].",".$sts.",0),";
		}
		
		
		
	}
	
		$text_f = substr($text_where, 0, -1);

	
      $sql 	= "INSERT INTO RSCH_DAYPART_MAN_TEM VALUES ".$text_f;
             
      if ($sql) {
          $this->db2->query($sql);
          
          $query = "
					
						SELECT `TEXT`,FIELD_TYPE,SUM(WEIGHT) AS AUD,PERIODE,STS FROM (
						SELECT C.`TEXT`,'DAYPART' AS FIELD_TYPE, A.CARDNO, WEIGHT, '".$data['periode']."' PERIODE, 0 STS 
						FROM `CDR_EPG_RES_".$data['periode_num']."_STEP2_".$data['survey_data']."` A 
						JOIN `RSCH_DAYPART_MAN_TEM` C ON DATE_FORMAT(A.BEGIN_PROGRAM,'%H:%i:%s') BETWEEN C.`BEGIN_TIME` AND C.`END_TIME`
						WHERE C.STS = 1
						AND C.ID_PROFILE = ".$data['user_id']."
						GROUP BY A.CARDNO,C.`TEXT`	
						) O
						GROUP BY `TEXT`
						ORDER BY SUM(WEIGHT) DESC
					
					 ";		
      		$sql	= $this->db2->query($query);
      		$this->db2->close();
      		$this->db2->initialize(); 
      		return $sql->result_array();	
      } 
      else {
          return false;
      }
  }
	
}	
