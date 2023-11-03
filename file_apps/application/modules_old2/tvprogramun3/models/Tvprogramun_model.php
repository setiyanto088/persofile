<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		
	}
	
	public function get_profile($iduser,$idrole,$periode) {  
 
		
		$i0 =  date_format(date_create($periode),"Y-m");
 			
			$sql = "SELECT A.* FROM ( 
					SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a WHERE (STATUS = 1 OR STATUS = 3)  
					AND user_id_profil IN (".$iduser.",0)  ORDER BY `name`
					) A JOIN
					`M_MONTH_PROFILE_PTV`  B ON A.id = B.`PROFILE_ID`
					WHERE B.`PERIODE` = '".$i0."' AND B.`STATUS_PROCESS` = 1
					";
		
	 
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_tahun(){
		
		$query = "SELECT DISTINCT(PERIODE_STR)  TANGGAL FROM T_PERIODE ORDER BY PERIODE DESC";
		 
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
		
			$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_CHAN_PTV_WEEK WHERE TANGGAL='".$periode."' ORDER BY `WEEK`";
		 
	 

		$result = $db->select($query);
		return $result->rows();				
	}	
	
	public function channel_list($periode){
		
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `CHANNEL` FROM M_SUM_TV_DASH_CHAN_PTV WHERE TANGGAL='".$periode."' AND CHANNEL <> '' ORDER BY CHANNEL ";
		 
	 	
		$result = $db->select($query);
		return $result->rows();			
	}
	
	public function get_week_program($periode){
		
	 

$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `WEEK` as `WEEK` FROM M_SUM_TV_DASH_PROG_WEEK_PTV WHERE TANGGAL='".$periode."' ORDER BY `WEEK` ";
		 
		$result = $db->select($query);
		return $result->rows();				
	}
	
	public function get_active_audience($periode){
		$db = $this->clickhouse->db();
		
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE_PTV WHERE TANGGAL= '".$periode."'" ;
 		
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
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	
	public function list_spot_by_program_all_bar_tvod_month($field,$where,$periode,$pilihaudiencebar,$profile,$check) {
		$db = $this->clickhouse->db();
	
		
		$query = "

			SELECT A.CHANNEL AS CHANNEL,A.PROGRAM AS PROGRAM, A.VIEWERS AS VIEWERS,TOTAL_VIEWS,DURATION FROM (
			SELECT CHANNEL,PROGRAM , VIEWERS AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
				 R.TANGGAL='".$periode."'
				 AND R.TIPE_VIEW = 'VIEWERS'
				 AND R.TIPE_FILTER = 'TVOD'
				 AND R.ID_PROFILE = '0' 
				 
				 ) A JOIN (
				 
				 SELECT CHANNEL,PROGRAM , VIEWERS AS TOTAL_VIEWS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
				 R.TANGGAL='".$periode."'
				 AND R.TIPE_VIEW = 'TOTAL_VIEWS'
				 AND R.TIPE_FILTER = 'TVOD'
				 AND R.ID_PROFILE = '0' 
				 
				 ) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
				JOIN (
				  SELECT CHANNEL,PROGRAM , VIEWERS AS DURATION FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
				 R.TANGGAL='".$periode."'
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.TIPE_FILTER = 'TVOD'
				 AND R.ID_PROFILE = '0' 
				 
				 ) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM
					ORDER BY A.VIEWERS DESC

		";  
					
			
		$result = $db->select($query);
			return $result->rows();	   
		
	}
	
 	public function list_spot_by_program_all_bar($field,$where,$periode,$pilihaudiencebar,$profile,$check) {
		$db = $this->clickhouse->db();
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = "SELECT DISTINCT L.`".$field."` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL= ".$this->db->escape($periode)." ".$where." ".$wh_chn." 
					ORDER BY Spot DESC ";  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)." ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)." ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='viewers2')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)."
				 AND TPE = 'VIEWERS2' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='TVR')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)."
				 AND TPE = 'TVR' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='TVS')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)."
				 AND TPE = 'TVS' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='Duration')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)." ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = "
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM (
				SELECT CHANNEL as channel,VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)." ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot  FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)." ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) B
				 ORDER BY Spot_a DESC"; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = "SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."  ) A,
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL='".$periode."' 
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."  ) B 
				 WHERE A.channel = B.channel
				 
				 order by  B.Spot/A.Spot DESC"; 

			}else{
				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_PTV R WHERE 
				 R.TANGGAL= ".$this->db->escape($periode)." ".$where." 
				 AND R.ID_PROFILE = ".$this->db->escape($profile)." ".$wh_chn." 
					ORDER BY VIEWERS DESC ";  	
			}
	 
		$result = $db->select($query);
			return $result->rows();	   
		
	}
	
	public function list_spot_by_program_all_bar_tvod($field,$where,$periode,$pilihaudiencebar,$profile,$check,$tipe_filter) {
		
		$db = $this->clickhouse->db();
		
		if($check == "True"){
				$wh_chn = '';
		}else{
				$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = "SELECT DISTINCT L.`".$field."` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL='".$periode."' ".$where." ".$wh_chn." 
					ORDER BY Spot DESC ";  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY Spot DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'TOTAL_VIEWS'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY Spot DESC"; 

			}elseif ($pilihaudiencebar=='Duration')	 {

					$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY Spot DESC"; 

			}elseif ($pilihaudiencebar=='TVR')	 {

				if($tipe_filter == 'ALL'){
					$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
					 R.TANGGAL='".$periode."'
					 AND TPE = 'TVR' ".$where."
					 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY Spot DESC"; 
				}else{
					$query = "SELECT CHANNEL as channel,0 AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
					 R.TANGGAL='".$periode."'
					 AND TPE = 'TVR' ".$where."
					 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY Spot DESC";
				}

			}elseif ($pilihaudiencebar=='TVS')	 {
				if($tipe_filter == 'ALL'){
					$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
					 R.TANGGAL='".$periode."'
					 AND TPE = 'TVS' ".$where."
					 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
						ORDER BY Spot DESC"; 
				}else{
					$query = "SELECT CHANNEL as channel,0 AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_PTV R WHERE 
					 R.TANGGAL='".$periode."'
					 AND TPE = 'TVS' ".$where."
					 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
						ORDER BY Spot DESC"; 
				}

			}elseif ($pilihaudiencebar=='share')	 {

				$query = "
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM (
				SELECT CHANNEL as channel,VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot  FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) B
				 ORDER BY Spot DESC"; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = "SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(

SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'VIEWERS'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 
				 ) A,
(

SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 
				 ) B
				 
				 WHERE A.channel = B.channel
				order by  B.Spot/A.Spot DESC"; 

			}else{
				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.TIPE_VIEW = 'VIEWERS'
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC";
			}
	 rray();	 

			$result = $db->select($query);
			return $result->rows();	  
		
	}
 	public function list_spot_by_program_hari_bar($field,$where,$periode,$week,$pilihaudiencebar,$profile,$check) {
	 
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
 			}elseif ($pilihaudiencebar=='viewers2') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND TPE = "VIEWERS2" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
 			}elseif ($pilihaudiencebar=='TVR') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND TPE = "TVR" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				ORDER BY Spot DESC';
 			}elseif ($pilihaudiencebar=='TVS') {
				$query = 'SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_WEEK_PTV 
				WHERE TANGGAL ="'.$periode.'" AND TPE = "TVS" AND WEEK ="'.$week.'" 
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
			 
				$query = '
				SELECT CHANNEL AS channel, MAX(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_PTV_WEEK 
				WHERE TANGGAL ="'.$periode.'" AND WEEK ="'.$week.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				GROUP BY CHANNEL
				ORDER BY Spot DESC
				';
				
			}
 		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_hari_date_tvod_all($field,$where,$periode,$datef,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" AND TIPE_VIEW = "TOTAL_VIEWS" AND TIPE_FILTER = "ALL"
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='viewers2'){
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND TPE = "VIEWERS2" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='TVR'){
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND TPE = "TVR" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='TVS'){
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ="'.$periode.'" AND TPE = "TVS" AND `DAYS` ="'.$datef.'" 
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='Duration'){
			 
				
			$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" AND TIPE_VIEW = "DURATION" AND TIPE_FILTER = "ALL"
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}elseif ($pilihaudiencebar=='share'){
				 
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
				( 
					SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM ( 
						SELECT CHANNEL as channel, VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
						WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" AND TIPE_VIEW = "DURATION" AND TIPE_FILTER = "ALL"
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					) A,
					(
						SELECT SUM(VIEWERS) AS tot_spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
						WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" AND TIPE_VIEW = "DURATION" AND TIPE_FILTER = "ALL"
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
					) B
				) z';
 			}elseif ($pilihaudiencebar=='avgtotdur'){
				 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
								 R.TANGGAL="'.$periode.'" AND TIPE_VIEW = "VIEWERS" AND TIPE_FILTER = "ALL"
								 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
								 AND `DAYS` ="'.$datef.'" ) A,
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
								 R.TANGGAL="'.$periode.'" AND TIPE_VIEW = "DURATION" AND TIPE_FILTER = "ALL"
								 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
								 AND `DAYS` ="'.$datef.'" ) B 
								 WHERE A.channel = B.channel
								 GROUP BY A.channel
								 order by  B.Spot/A.Spot DESC
				
				
			) z';
 			}else {
			 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" AND TIPE_VIEW = "VIEWERS" AND TIPE_FILTER = "TVOD"
				AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				ORDER BY Spot DESC ) z';
 			}
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_by_program_hari_date_tvod($field,$where,$periode,$datef,$pilihaudiencebar,$profile,$check,$tipe_filter) {
		
		$db = $this->clickhouse->db();
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
	 
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel,GRP AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_DAY_PTV a, `CHANNEL_PARAM` B 
				AND a.CHANNEL = B.CHANNEL_NAME
				AND FLAG_TV = 0
				WHERE TANGGAL ='".$periode."' AND `DAY` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z" ;
				
 			}elseif ($pilihaudiencebar=='Viewers'){
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
				WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' AND TIPE_VIEW = 'TOTAL_VIEWS' AND TIPE_FILTER = '".$tipe_filter."'
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='viewers2'){
				 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'VIEWERS2' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='TVR'){
			 
				if($tipe_filter == 'ALL'){
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'TVR' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
				
				}ELSE{
					
					$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, 0 AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'TVR' AND `DAYS` = '".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
					
				}
 			}elseif ($pilihaudiencebar=='TVS'){
				 
				
				if($tipe_filter == 'ALL'){
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'TVS' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
				
				}ELSE{
				
					$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, 0 AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'TVS' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
				
					
				}
 			}elseif ($pilihaudiencebar=='Duration'){
			 
				
			$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
				WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' AND TIPE_VIEW = 'DURATION' AND TIPE_FILTER = '".$tipe_filter."'
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='share'){
			 
				
				$query = "
				SELECT z.* FROM 
				( 
					SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM ( 
						SELECT CHANNEL as channel, VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
						WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' AND TIPE_VIEW = 'DURATION' AND TIPE_FILTER = '".$tipe_filter."'
						AND ID_PROFILE = '".$profile."' ".$wh_chn." 
					) A,
					(
						SELECT SUM(VIEWERS) AS tot_spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
						WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' AND TIPE_VIEW = 'DURATION' AND TIPE_FILTER = '".$tipe_filter."'
						AND ID_PROFILE = '".$profile."' ".$wh_chn." 
					) B
				) z
				ORDER BY Spot DESC
				";
 			}elseif ($pilihaudiencebar=='avgtotdur'){
			 
				$query = "
				SELECT z.* FROM 
			( 
				SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
								 R.TANGGAL='".$periode."' AND TIPE_VIEW = 'VIEWERS' AND TIPE_FILTER = '".$tipe_filter."'
								 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
								 AND `DAYS` ='".$datef."' ) A,
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
								 R.TANGGAL='".$periode."' AND TIPE_VIEW = 'DURATION' AND TIPE_FILTER = '".$tipe_filter."'
								 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
								 AND `DAYS` ='".$datef."' ) B 
								 WHERE A.channel = B.channel
								
								 order by  B.Spot/A.Spot DESC
				
				
			) z";
 			}else {
				 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
				WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' AND TIPE_VIEW = 'VIEWERS' AND TIPE_FILTER = '".$tipe_filter."'
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}
		 

		$results2 = $db->select($query);
		$result2 = $results2->rows();		

return $result2;	 		
	}
	
	public function list_spot_by_program_hari_date($field,$where,$periode,$datef,$pilihaudiencebar,$profile,$check) {
		
		if($check == "True"){
				$wh_chn = '';
		}else{
						$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
	 
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel,GRP AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_DAY_PTV a, `CHANNEL_PARAM` B 
				AND a.CHANNEL = B.CHANNEL_NAME
				AND FLAG_TV = 0
				WHERE TANGGAL ='".$periode."' AND `DAY` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z" ;
				
 			}elseif ($pilihaudiencebar=='Viewers'){
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='viewers2'){
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'VIEWERS2' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='TVR'){
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'TVR' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='TVS'){
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_EXT_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND TPE = 'TVS' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='Duration'){
			 
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
				WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' 
				AND ID_PROFILE = '".$profile."' ".$wh_chn." 
				ORDER BY Spot DESC ) z";
 			}elseif ($pilihaudiencebar=='share'){
			 
				
				$query = "
				SELECT z.* FROM 
				( 
					SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM ( 
						SELECT CHANNEL as channel, VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
						WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." 
					) A,
					(
						SELECT SUM(VIEWERS) AS tot_spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV 
						WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." 
					) B
				) z";
 			}elseif ($pilihaudiencebar=='avgtotdur'){
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV R WHERE 
								 R.TANGGAL='".$periode."'
								 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
								 AND `DAYS` ='".$datef."' ) A,
				(
				SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
								 R.TANGGAL='".$periode."' 
								 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
								 AND `DAYS` ='".$datef."' ) B 
								 WHERE A.channel = B.channel
								 order by  B.Spot/A.Spot DESC
				
				
			) z";
 			}else {
			 
				
				$query = "
				SELECT z.* FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				WHERE TANGGAL ='".$periode."' AND `DAYS` ='".$datef."' ".$wh_chn." 
				AND ID_PROFILE = '".$profile."'
				ORDER BY Spot DESC ) z";
 			}
 			$db = $this->clickhouse->db();
			
			
			$results2 = $db->select($query);
		$result2 = $results2->rows();	 
		
		return $result2;	 
		
	 
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
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

	public function list_spot_by_program_all2Ps_new_week_x($field,$wheres,$params,$pilihprog,$profile) {
	
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		if($params['channel_prog'] == "All"){
				$wh_chn .= '';
		}else{
				$wh_chn .= ' AND CHANNEL ="'.$params['channel_prog'].'" ' ;
		}
		
		$where = "";
		
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
		
		
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
 		return $sql->result_array();		
	}
	
	public function list_spot_by_program_all2Ps_new_week($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (UPPER(PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') ";
		
		if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
						
		}elseif ($pilihprog=='Viewers2') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND TPE="VIEWERS2" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC					
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND TPE="VIEWERS2" AND WEEK ="'.$params['week'].'" 
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
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND TPE="TVS" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC					
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND TPE="TVS" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC		
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
						
		}elseif ($pilihprog=='TVR2') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND TPE="TVR" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' '.$wheres.'
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC					
						)z  
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND TPE="TVR" AND WEEK ="'.$params['week'].'" 
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

	public function list_spot_by_program_all2Ps_new_day_x($field,$wheres,$params,$pilihprog,$profile) {
		
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		if($params['channel_prog'] == "All"){
				$wh_chn .= '';
		}else{
				$wh_chn .= ' AND CHANNEL ="'.$params['channel_prog'].'" ' ;
		}
		
		$where = "";
		
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
		
		
 		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
 		return $sql->result_array();	
	}
	
	
	public function mr_get($field,$wheres,$params,$pilihprog,$profile) {
		$db = $this->clickhouse->db();
 		
		if($params['check'] == "True"){
				$wh_chn = ""; 
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
		

					
				 $query = 	"	
					SELECT COUNT(*) AS jumlah FROM 
					( 
					SELECT A.CHANNEL, B.VIEWERS AS AUDIENCE, C.`VIEWERS` AS TVR, D.`VIEWERS` AS TVS, E.`VIEWERS` AS VIEWER, B.VIEWERS AS REACH FROM (

					SELECT CHANNEL FROM `M_SUM_TV_DASH_CHAN_PTV`
					WHERE TANGGAL = '".$params['tgl1mr']."'
					GROUP BY CHANNEL

					) A LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_PTV` WHERE TANGGAL = '".$params['tgl1mr']."' ) B
					ON A.CHANNEL = B.CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$params['tgl1mr']."' AND `TPE` = 'TVR' ) C
					ON A.CHANNEL = C.CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$params['tgl1mr']."' AND `TPE` = 'TVS' ) D
					ON A.CHANNEL = D.CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_VIEWERS_PTV` WHERE TANGGAL = '".$params['tgl1mr']."'  ) E
					ON A.CHANNEL = E.CHANNEL 
					ORDER BY B.VIEWERS DESC

					)z 
					";
					
					//echo $query;die;
					
					
					 $query2 = 	"	
					SELECT z.* FROM 
					( 
						SELECT A.CHANNEL AS CHANNEL, B.VIEWERS AS AUDIENCE, C.`VIEWERS` AS TVR, D.`VIEWERS` AS TVS, E.`VIEWERS` AS VIEWER, C.VIEWERS AS REACH FROM (

						SELECT CHANNEL FROM `M_SUM_TV_DASH_CHAN_PTV`
						WHERE TANGGAL = '".$params['tgl1mr']."'
						GROUP BY CHANNEL

						) A LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_PTV` WHERE TANGGAL = '".$params['tgl1mr']."' ) B
						ON A.CHANNEL = B.CHANNEL 
						LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$params['tgl1mr']."' AND `TPE` = 'TVR' ) C
						ON A.CHANNEL = C.CHANNEL 
						LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$params['tgl1mr']."' AND `TPE` = 'TVS' ) D
						ON A.CHANNEL = D.CHANNEL 
						LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_VIEWERS_PTV` WHERE TANGGAL = '".$params['tgl1mr']."'  ) E
						ON A.CHANNEL = E.CHANNEL 
						ORDER BY B.VIEWERS DESC

					)z 
					LIMIT ".$params['limit']." 
					OFFSET ".$params['offset']." 
					";
		
		
		  $querys	= $db->select($query);
		  $result = $querys->rows();	  
		  
		  //print_r($result);die;
		  
		  $total_filtered = count($result[0]['jumlah']);
		  $total 			= count($result[0]['jumlah']);
	  
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
	
	public function mr_get2($field,$wheres,$params,$pilihprog,$profile,$query) {
		$db = $this->clickhouse->db();
 		
		if($params['check'] == "True"){
				$wh_chn = ""; 
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}

 		 $querys	= $db->select($query);
		 return $querys->rows();	  

	}
	
	
	public function list_spot_by_program_all2Ps_new_day_tvodm($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (UPPER(PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') ";
		
		
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT A.CHANNEL AS CHANNEL,A.PROGRAM AS PROGRAM, A.VIEWERS AS VIEWERS,TOTAL_VIEWS,DURATION FROM (
							SELECT CHANNEL,PROGRAM , VIEWERS AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'VIEWERS'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) A JOIN (
								 
								 SELECT CHANNEL,PROGRAM , VIEWERS AS TOTAL_VIEWS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'TOTAL_VIEWS'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								JOIN (
								  SELECT CHANNEL,PROGRAM , VIEWERS AS DURATION FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'DURATION'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM
					
						)z 
						";
						
						$query2 = 	"
				SELECT z.* FROM 
				( 
						SELECT A.CHANNEL AS CHANNEL,A.PROGRAM AS PROGRAM, A.VIEWERS AS VIEWERS,TOTAL_VIEWS,DURATION FROM (
							SELECT CHANNEL,PROGRAM , VIEWERS AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'VIEWERS'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) A JOIN (
								 
								 SELECT CHANNEL,PROGRAM , VIEWERS AS TOTAL_VIEWS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'TOTAL_VIEWS'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								JOIN (
								  SELECT CHANNEL,PROGRAM , VIEWERS AS DURATION FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'DURATION'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM
								
						)z 
						ORDER BY z.".$params['order_column']." ".$params['order_dir']."
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
				
		
 		$db = $this->clickhouse->db();
		
 		  $out		= array();
		 
		  $results = $db->select($query);
		  $result = $results->rows();	 
		  
		  $total_filtered	= $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];
	  
		  if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	   
		$results2 = $db->select($query2);
		$result2 = $results2->rows();	 
	  
		$return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
		);
		return $return;
	}
	
	
	public function list_spot_by_program_all2Ps_new_day($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (UPPER(PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') ";
		
		if($params['check'] == "True"){
				$wh_chn = ''; 
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
		
		 
		if ($pilihprog=='TVR'){
			 
				 $query = 	"	
					SELECT COUNT(*) AS jumlah FROM 
					( 
					SELECT PROGRAM, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ='".$params['periode']."' AND `DAY` ='".$params['tglf']."' 
					".$where." ".$wh_chn." ".$wheres."
					AND ID_PROFILE = '".$profile."' 
					ORDER BY Spot DESC
					)z 
					";
					
					 $query2 = 	"	
					SELECT z.* FROM 
					( 
					SELECT PROGRAM, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ='".$params['periode']."' AND `DAY` ='".$params['tglf']."' 
					".$where." ".$wh_chn." ".$wheres."
					AND ID_PROFILE = '".$profile."' 
					ORDER BY Spot DESC
					)z 
					LIMIT ".$params['limit']." 
					OFFSET ".$params['offset']." 
					";
		}elseif ($pilihprog=='Viewers') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAY` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
						ORDER BY Spot DESC 						
						)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
						( 
						SELECT PROGRAM, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAY` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC 
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='Viewers2') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' AND TPE = 'VIEWERS2' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
						ORDER BY Spot DESC 						
						)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
						( 
						SELECT PROGRAM, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' AND TPE = 'VIEWERS2' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC 
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='TVS') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' AND TPE = 'TVS' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
						ORDER BY Spot DESC 						
						)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
						( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' AND TPE = 'TVS' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC 
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='TVR2') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' AND TPE = 'TVR' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
						ORDER BY Spot DESC 						
						)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
						( 
						SELECT PROGRAM, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' AND TPE = 'TVR' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC 
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='avgtotaud'){
		
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
					SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
							
					) A,
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
				( 
					SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
							
					) A,
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT ".$params['limit']." 
				OFFSET ".$params['offset']." 
						";
		
		}elseif ($pilihprog=='avgtotdur'){
		
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
					SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAY` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
							
					) A,
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
					SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAY` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
							
					) A,
					(
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."'
					) B WHERE A.CHANNEL = B.CHANNEL
					 AND A.PROGRAM = B.PROGRAM
					 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT ".$params['limit']." 
				OFFSET ".$params['offset']." 
						";
		
		}elseif ($pilihprog=='Duration') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC 
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
						( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC 
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
			";
		
		}else {
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
						SELECT PROGRAM , CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ='".$params['periode']."' AND `DAYS` ='".$params['tgl']."' 
						".$where." ".$wh_chn." ".$wheres."
						AND ID_PROFILE = '".$profile."' 
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
		}		
		
 		$db = $this->clickhouse->db();
		
 		  $out		= array();
 
		  $results = $db->select($query);
		  $result = $results->rows();	 
		  
		  $total_filtered	= $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];
	  
		  if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	   

		$results2 = $db->select($query2);
		$result2 = $results2->rows();	 
	  
		$return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
		);
		return $return;
	}
	
	public function list_spot_by_program_all2Ps_new_x_tvodm($field,$wheres,$params,$pilihprog,$profile) {

		$where = " ";
		

							$query2 = 	"	
						SELECT z.* FROM 
						( 
						SELECT A.CHANNEL AS CHANNEL,A.PROGRAM AS PROGRAM, A.VIEWERS AS VIEWERS,TOTAL_VIEWS,DURATION FROM (
							SELECT CHANNEL,PROGRAM , VIEWERS AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'VIEWERS'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) A JOIN (
								 
								 SELECT CHANNEL,PROGRAM , VIEWERS AS TOTAL_VIEWS FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'TOTAL_VIEWS'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) B ON A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM
								JOIN (
								  SELECT CHANNEL,PROGRAM , VIEWERS AS DURATION FROM M_SUM_TV_DASH_PROG_TVOD R WHERE 
								 R.TANGGAL='".$params['periode']."'
								 AND R.TIPE_VIEW = 'DURATION'
								 AND R.TIPE_FILTER = 'TVOD'
								 AND R.ID_PROFILE = '0' 
								 
								 ) C ON A.CHANNEL = C.CHANNEL AND A.PROGRAM = C.PROGRAM
								ORDER BY A.VIEWERS DESC
						)z  
						";
					
 		$db = $this->clickhouse->db();
		
		$results = $db->select($query2);
		  $result = $results->rows();	 
	

		return $result;
	}

	public function list_spot_by_program_all2Ps_new_x($field,$wheres,$params,$pilihprog,$profile) {
		
		if($params['check'] == "True"){
				$wh_chn = "";
		}else{
				$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		
		if($params['channel_prog'] == "All"){
				$wh_chn .= '';
		}else{
				$wh_chn .= " AND CHANNEL = '".$params['channel_prog']."' " ;
		} 
		$where = " ";
		
		if ($pilihprog=='TVR'){
			 
					
					$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						
							$query2 = 	"	
						SELECT z.* FROM 
						( 
						SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL='".$params['periode']."' ".$where." 
						AND ID_PROFILE  = '".$profile."' ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z  
						";
					}else{
						
						$query2 = 	"	
						SELECT z.* FROM 
						( 
						SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)='".$params['periode']."' ".$where." 
						AND ID_PROFILE  = '".$profile."' ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z 
						";
						
					}
					
		}elseif ($pilihprog=='Viewers') {
	
		 
							$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						ORDER BY Spot DESC
						)z  
						";
						
						
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query2 = 	"
			SELECT z.* FROM 
				( 
				SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where." 
						
				) A,
				(
					SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						";
		
		}elseif ($pilihprog=='Duration') {
						
							$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
		}elseif ($pilihprog=='Viewers2') {

						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						AND TPE = 'VIEWERS2' ".$where."
						ORDER BY Spot DESC
						)z  
						";
						
		}elseif ($pilihprog=='TVS') {
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						AND TPE = 'TVS' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
		} elseif ($pilihprog=='TVR2') {

						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						AND TPE = 'TVR' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
		} else {
			
					$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
						ORDER BY Spot DESC
						)z 
						";
		}		
 		$db = $this->clickhouse->db();
		
		$results = $db->select($query2);
		$result2 = $results->rows();	 

		return $result2;
	}
	
	public function list_spot_by_program_all2Ps_new_tvod_x($field,$wheres,$params,$pilihprog,$profile,$tipe_filter) {
		
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
		}
		
		if($params['channel_prog'] == "All"){
				$wh_chn .= '';
		}else{
				$wh_chn .= ' AND CHANNEL ="'.$params['channel_prog'].'" ' ;
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
		
		
 		
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
 		return $sql->result_array();			

 	}
	
	public function list_spot_by_program_all2Ps_new($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (UPPER(PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') ";
		
			if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
		
		if ($pilihprog=='TVR'){
			 
					
					$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						$query = 	"	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL='".$params['periode']."' ".$where." 
						AND ID_PROFILE  = '".$profile."' ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"	
						SELECT z.* FROM 
						( 
						SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL='".$params['periode']."' ".$where." 
						AND ID_PROFILE  = '".$profile."' ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
					}else{
						
						$query = 	"	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)='".$params['periode']."' ".$where." 
						AND ID_PROFILE  = '".$profile."' ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"	
						SELECT z.* FROM 
						( 
						SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND SUBSTRING(TANGGAL, 1, 4)='".$params['periode']."' ".$where." 
						AND ID_PROFILE  = '".$profile."' ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
					}
					
		}elseif ($pilihprog=='Viewers') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$params['periode']."' ".$where." ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$params['periode']."' ".$where." ".$wh_chn." ".$wheres."
						ORDER BY Spot DESC
						
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='avgtotaud')	 {
		
		 
		
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL,TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$params['periode']."' ".$where." ".$wh_chn." ".$wheres."
						AND DURASI_PROGRAM > DURASI_USER
						ORDER BY TVR DESC
						)z 
						";
						
			$query2 = 	" 
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, TVR, (DURASI_USER/DURASI_PROGRAM)*100 AS Spot FROM M_SUM_TV_DASH_PROG_AUDI_DURA_TVR a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$params['periode']."' ".$where." ".$wh_chn." ".$wheres."
						AND DURASI_PROGRAM > DURASI_USER
						ORDER BY TVR DESC
						
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
			
		
		}elseif ($pilihprog=='avgtotdur')	 {
		
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
				SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$params['periode']."' ".$where." ".$wh_chn." ".$wheres."
						
				) A,
				(
					SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$params['periode']."' ".$where." ".$wh_chn." ".$wheres."
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
						";
						
			$query2 = 	"
			SELECT z.* FROM 
				( 
				SELECT A.CHANNEL,A.PROGRAM,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
				(
					SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where." 
						
				) A,
				(
					SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
				) B WHERE A.CHANNEL = B.CHANNEL
				 AND A.PROGRAM = B.PROGRAM
				 order by B.Spot/A.Spot DESC 
				)z 
				LIMIT ".$params['limit']." 
				OFFSET ".$params['offset']." 
						";
		
		}elseif ($pilihprog=='Duration') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='Viewers2') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."'
						AND TPE = 'VIEWERS2' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						AND TPE = 'VIEWERS2' ".$where."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='TVS') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."'
						AND TPE = 'TVS' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						AND TPE = 'TVS' ".$where."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}elseif ($pilihprog=='TVR2') {
		$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."'
						AND TPE = 'TVR' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' 
						AND TPE = 'TVR' ".$where."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
						
		}else {
			$query = 	"
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
						ORDER BY Spot DESC
						)z 
						";
						
						$query2 = 	"
			SELECT z.* FROM 
				( 
			SELECT DISTINCT a.`".$field."`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' ".$wh_chn." ".$wheres."
						AND TANGGAL='".$params['periode']."' ".$where."
						ORDER BY Spot DESC
						)z 
						LIMIT ".$params['limit']." 
						OFFSET ".$params['offset']." 
						";
		}		
		
		$db = $this->clickhouse->db();
 		
		  $out		= array();
		 
		  
		  $results = $db->select($query);
		  $result = $results->rows();	 
		  
		  $total_filtered = $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];
	  
			if(($params['offset']+10) > $total_filtered){
			$limit_data = $total_filtered - $params['offset'];
		  }else{
			$limit_data = $params['limit'] ;
		  }
	  
 

	$results2 = $db->select($query2);
	 $result2 = $results2->rows();	 
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}	
	
	public function list_spot_by_program_all2Ps_new_tvod($field,$wheres,$params,$pilihprog,$profile,$tipe_filter) {
		
		$where = " AND (UPPER(PROGRAM) LIKE '%".strtoupper($params['searchtxt'])."%' OR UPPER(CHANNEL) LIKE '%".strtoupper($params['searchtxt'])."%') ";
		
			if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) ' ;
			}
		
		if ($pilihprog=='TVR2'){
			 
					
					IF($tipe_filter == 'ALL'){
					
					$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'"
						AND TPE = "TVR" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_EXT_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' '.$wheres.'
						AND TANGGAL="'.$params['periode'].'" 
						AND TPE = "TVR" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						'; 
					
					}ELSE{
						
							$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, 0 AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
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
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, 0 AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
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
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, 0 AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
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
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, 0 AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
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
		$query = 	"
			SELECT z.* from 
				( 
			SELECT DISTINCT a.`".strtoupper($field)."`,CHANNEL, MAX(VIEWERS) AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = '".$profile."' 
						AND TANGGAL='".$periode."' ".$where."
						GROUP BY CHANNEL,a.`".strtoupper($field)."`
						ORDER BY Spot DESC
						)z 
						";
		}		
 

$result = $db->select($query);
		return $result->rows();	   		
	}
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
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}

 	public function list_spot_by_daytime_all2($where,$periode) {
		 
					 
					 $db = $this->clickhouse->db();
		$query = "SELECT PRIME,VIEWERS FROM M_SUM_TV_DASH_PRIME_PTV
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 ORDER BY PRIME DESC	";
					 
		   
		$result = $db->select($query);
		return $result->rows();		
	}
	

 	public function list_spot_by_daypart($where,$periode) {
		 
		
		$db = $this->clickhouse->db();
		$query = "SELECT TIME,VIEWERS FROM M_SUM_TV_DASH_TIME_PTV
					 WHERE 1=1 AND TANGGAL='".$periode."' ".$where."
					 ORDER BY VIEWERS DESC	";
					
		$result = $db->select($query);
		return $result->rows();	      
	}

 	public function list_spot_by_date_all2($where,$periode) {
		 

$db = $this->clickhouse->db();
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV
				  WHERE 1=1 AND TANGGAL='".$periode."' ".$where." 
				  ".$where." 
				  ORDER BY DATE";			
		$result = $db->select($query);
		return $result->rows();	   	   
		
	}
	
		public function list_spot_by_date_all2_viewer($where,$periode) {
	 

		$db = $this->clickhouse->db();
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV_VIEWERS
				  WHERE 1=1 AND TANGGAL='".$periode."' ".$where." 
				  ".$where." 
				  ORDER BY DATE";			
		$result = $db->select($query);
		return $result->rows();	   
		
	}

	public function list_spot_by_date_all2_duration($where,$periode) {
		$db = $this->clickhouse->db();
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV_DURATION
				  WHERE 1=1 AND TANGGAL='".$periode."' ".$where." 
				  ".$where." 
				  ORDER BY DATE";			
		$result = $db->select($query);
		return $result->rows();	   
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
		 
		
		$db = $this->clickhouse->db();
		
		$query = "SELECT val_int AS tot_pop FROM T_PARAM_UNICS WHERE name = 'UNIVERSE_CDR_".$pr."'  AND type_data = 2 ";
		
	 
		$result = $db->select($query);
		return $result->rows();	 
		
	} 
	
	public function list_populasi() {
 		$query = 'SELECT COUNT(DISTINCT(CARDNO)) AS tot_pop FROM NEW_CDR_LIVE_CLEAN_CS';
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_spot_all2($where,$periode) {
		
		$db = $this->clickhouse->db();
		 
		
		$query = "SELECT COUNT(`PROGRAM`) AS spot FROM (
		SELECT DISTINCT a.`PROGRAM`,CHANNEL FROM M_SUM_TV_DASH_PROG_PTV a 
		WHERE `ID_PROFILE` = 0   AND TANGGAL='".$periode."' ".$where." 
		GROUP BY CHANNEL,a.`PROGRAM`
		
		) P ";  			
		 
		
		$result = $db->select($query);
		return $result->rows();	 
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
	public function count_channel($periode) {
		 
		$db = $this->clickhouse->db();
	$query = "SELECT COUNT(CHANNEL) jmlch FROM `M_SUM_TV_DASH_CHAN_PTV`
	WHERE `TANGGAL` = '".$periode."' AND ID_PROFILE = 0 ";  		

		 			
		$result = $db->select($query);
		return $result->rows();
		
	}
}	
