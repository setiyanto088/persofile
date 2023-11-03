<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		
	}
	
	  public function channelsearch($strSearch,$strGenre,$role){
     
      if($strGenre == "0"){
          $strWhere = "AND CHANNEL_NAME_PROG LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND CHANNEL_NAME_PROG LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }
      
      
	  
	   $sql = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS CHANNEL FROM  `CHANNEL_PARAM_FINAL` B  
	  WHERE B.`F2A_STATUS` in (0,-99) ".$strWhere."   ORDER BY CHANNEL_NAME_PROG ";  
	  
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }       
	
	public function list_channel() {
 		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS channel FROM  `CHANNEL_PARAM_FINAL` B WHERE F2A_STATUS <> 1 ORDER BY CHANNEL_NAME_PROG ";
		
		$result = $db->select($query);
		return $result->rows();	      
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
	
	public function get_total_views($periode){

		$db = $this->clickhouse->db();
		
		$query = "SELECT SUM(VIEWERS) as TOTAL_VIEWS FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV WHERE TANGGAL = '".$periode."' " ;
		
		$result = $db->select($query);
		return $result->rows();	 		
	
	}
	
	public function get_duration($periode){
		
		
		$db = $this->clickhouse->db();
		
		
		$query = "SELECT SUM(VIEWERS) as DURATION FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV`
		WHERE `TANGGAL` = '".$periode."'" ;
		 
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
	
 	public function list_spot_by_program_all_bar($field,$where,$periode,$pilihaudiencebar,$profile,$check) {
		$db = $this->clickhouse->db();
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = "SELECT DISTINCT L.`'.$field.'` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL='".$periode."' ".$where." ".$wh_chn." 
					ORDER BY Spot DESC ";  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='Duration')	 {

				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = "
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS Spot FROM (
				SELECT CHANNEL as channel,VIEWERS AS Spot_a FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot  FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) B
				 ORDER BY Spot_a DESC"; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = "SELECT A.channel,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV R WHERE 
				 R.TANGGAL='".$periode."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."  ) A,
(
SELECT CHANNEL AS channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_DURATION_PTV R WHERE 
				 R.TANGGAL='".$periode."' 
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."  ) B 
				 WHERE A.channel = B.channel
				 GROUP BY A.channel
				 order by  B.Spot/A.Spot DESC"; 

			}else{
				$query = "SELECT CHANNEL as channel,VIEWERS AS Spot FROM M_SUM_TV_DASH_CHAN_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where." 
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY VIEWERS DESC ";  	
			}
 		$result = $db->select($query);
			return $result->rows();	   
		   
	}
	
	
	public function list_spot_by_program_all_bar_fix_exp($field,$where,$periode,$pilihaudiencebar,$profile,$check,$first_day,$this_day,$where_k) {
		
		$db = $this->clickhouse->db();

		if($check == "True"){
				$wh_chn = "";
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = "SELECT DISTINCT L.`".$field."` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = '0' 
				AND R.TANGGAL='".$periode."' ".$where." ".$wh_chn." 
					ORDER BY Spot DESC ";  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where." 
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {
 
					
					
				$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot,SUM(VIEWERS) AS VIEWERS_TOTAL FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  	
							
 
			}elseif ($pilihaudiencebar=='Duration')	 {

			 
					
					$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot,SUM(VIEWERS) AS VIEWERS_TOTAL FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  

			}
			elseif ($pilihaudiencebar=='share')	 {

				$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  

			}
			elseif ($pilihaudiencebar=='avgtotdur')	 {

					$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC"; 

			}
			else{
				 

					$query = "SELECT R.CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND R.CHANNEL IS NOT NULL 
							GROUP BY R.CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  				
			}
   

		$result = $db->select($query);
		return $result->rows();	 
	}
	
	
	public function list_spot_by_program_all_bar_fix($field,$where,$periode,$pilihaudiencebar,$profile,$check,$first_day,$this_day) {
		
		$db = $this->clickhouse->db();

		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = "SELECT DISTINCT L.`".$field."` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	
		LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL='".$periode."' ".$where." ".$wh_chn." 
					ORDER BY Spot DESC ";  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where." 
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

	 
					
					
				$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  	
							
 
			}elseif ($pilihaudiencebar=='Duration')	 {

		 
					
					$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  

			}
			elseif ($pilihaudiencebar=='share')	 {

				$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  

			}
			elseif ($pilihaudiencebar=='avgtotdur')	 {

					$query = "SELECT CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							GROUP BY CHANNEL
							ORDER BY AVG(VIEWERS) DESC"; 

			}
			else{
		  

				$query = "SELECT R.CHANNEL AS channel,AVG(VIEWERS) AS Spot FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND R.CHANNEL IS NOT NULL 
							GROUP BY R.CHANNEL
							ORDER BY AVG(VIEWERS) DESC";  					
			}
   

		$result = $db->select($query);
		return $result->rows();	 
	}

	
		public function save_channels($params){ 
      
	  $sql 	= "DELETE FROM CHANNEL_SAVE WHERE `CHANNEL_NAME` = '".$params['save_channel_name']."'";
     $this->db->query($sql);
	 
	  $sql 	= "INSERT INTO CHANNEL_SAVE(`USERID`,`CHANNEL_NAME`,`CHANNEL_LIST`,MENUS) VALUES('".$params['user_id']."','".$params['save_channel_name']."','".$params['channel']."','0')";
             
      if ($sql) {
          $this->db->query($sql);
          
 
      } 
      else {
          return false;
      }
  }   		
  
  
  public function delete_channels($params){ 
      
	  $sql 	= "DELETE FROM CHANNEL_SAVE WHERE `CHANNEL_NAME` = '".$params['save_channel_name']."'";
	  
	   $this->db->query($sql);
              
      if ($sql) {
         
      } 
      else {
          return false;
      }
  }   
  
    public function load_channels($params){ 
          
          $query = 'SELECT * FROM CHANNEL_SAVE WHERE USERID="'.$params['user_id'].'" AND MENUS="0" ORDER BY CHANNEL_NAME ';			
      		$sql	= $this->db->query($query);
      		$this->db->close();
      		$this->db->initialize(); 
      		return $sql->result_array();	
    
  }    
  
  public function channel_set($preset,$userid){ 
          
          $query = 'SELECT * FROM CHANNEL_SAVE WHERE USERID="'.$userid.'" AND MENUS="0" AND CHANNEL_NAME = "'.$preset.'" ORDER BY CHANNEL_NAME ';		

 		  
      		$sql	= $this->db->query($query);
      		$this->db->close();
      		$this->db->initialize(); 
      		return $sql->result_array();	
    
  }
	
 	public function list_spot_all_days_exp($field,$where,$periode,$pilihaudiencebar,$profile,$check,$first_day,$this_day) {
		
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

 
					
					$query = 'SELECT * FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							'.$where.'
							AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC';  	

			}elseif ($pilihaudiencebar=='Duration')	 {

 
					
					$query = 'SELECT * FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` R
							WHERE 1=1 
							'.$where.'
							AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = '
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS VIEWERS FROM (
				SELECT CHANNEL ,VIEWERS AS Spot_a,DAYS FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
				 1=1 '.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot,DAYS  FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
				 1=1 
				'.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
				 GROUP BY DAYS 
				) B WHERE A.DAYS = B.DAYS
				 ORDER BY Spot_a DESC'; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = 'SELECT A.CHANNEL,A.DAYS,A.VIEWERS AS TOTAL_VIEWS,B.VIEWERS AS DURATION, B.VIEWERS/A.VIEWERS AS VIEWERS FROM 
(
SELECT CHANNEL ,VIEWERS, DAYS FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV R WHERE 
				 1=1 
				'.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'  ) A,
(
SELECT CHANNEL ,VIEWERS, DAYS FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
				 1=1 
				'.$where.'
				 AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'  ) B 
				 WHERE A.CHANNEL = B.CHANNEL AND A.DAYS = B.DAYS
				 GROUP BY A.CHANNEL,A.DAYS
				 order by  B.VIEWERS/A.VIEWERS DESC'; 

			}elseif ($pilihaudiencebar=='Reach')	 {

				$query = '
				SELECT R.CHANNEL, (R.VIEWERS / B.`VIEWERS`)*100 AS VIEWERS,DAYS FROM `PTV_M_SUM_TV_DASH_CHAN_DAYS` R,
				(SELECT * FROM `M_SUM_TV_DASH_DATE_PTV`) B
				WHERE R.DAYS = B.`DATE`
				'.$where.'
				AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				AND CHANNEL IS NOT NULL 
				ORDER BY DAYS,VIEWERS DESC
				'; 

			}else{
				
 

				$query = '
				SELECT R.*,S.VIEWERS_TOTAL FROM `PTV_M_SUM_TV_DASH_CHAN_DAYS` R 
				JOIN (
					SELECT `CHANNEL_NAME_PROG` AS CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS_TOTAL
					FROM `NEW_CDR_LIVE_CLEAN_CS` A
					,`CHANNEL_PARAM_FINAL` B 
					WHERE A.CHANNEL = B.`CHANNEL_NAME`
					AND USER_BEGIN_SESSION BETWEEN "'.$first_day.' 00:00:00" AND "'.$this_day.' 23:59:59"
					GROUP BY B.CHANNEL_NAME_PROG
				) S 
				WHERE R.CHANNEL = S.CHANNEL
				'.$where.'
				AND R.ID_PROFILE = "'.$profile.'" '.$wh_chn.'
				AND R.CHANNEL IS NOT NULL 
				ORDER BY DAYS,VIEWERS DESC
				';  

				
			}
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}	
	
	
	public function list_spot_all_days($field,$wheres,$periode,$pilihaudiencebar,$profile,$check,$first_day,$this_day) {
		$db = $this->clickhouse->db();
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$where = " AND TANGGAL = '".$periode."' ";
		
		$query = "SELECT DISTINCT L.`".$field."` as channel, CHANNEL_NAME as CHANNEL,VIEWERS AS Spot FROM P_CHANNEL_ADS_USEETV L  	LEFT JOIN M_SUM_TV_DASH2 R ON L.`CHANNEL_NAME`= R.CHANNEL 
				WHERE 1=1 and `FLAG_TV` = 0 
				AND R.TANGGAL='".$periode."' ".$where." ".$wh_chn." 
					ORDER BY Spot DESC ";  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

  
					$query = "SELECT * FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC";  	

			}elseif ($pilihaudiencebar=='Duration')	 {
 
					
					$query = "SELECT * FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = "
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS VIEWERS FROM (
				SELECT CHANNEL ,VIEWERS AS Spot_a,DAYS FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
				 1=1 ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot,DAYS  FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
				 1=1 
				".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY DAYS 
				) B WHERE A.DAYS = B.DAYS
				 ORDER BY Spot_a DESC"; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

				$query = "SELECT A.CHANNEL,A.DAYS,A.VIEWERS AS TOTAL_VIEWS,B.VIEWERS AS DURATION, B.VIEWERS/A.VIEWERS AS VIEWERS FROM 
(
SELECT CHANNEL ,VIEWERS, DAYS FROM M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV R WHERE 
				 1=1 
				".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."  ) A,
(
SELECT CHANNEL ,VIEWERS, DAYS FROM M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV R WHERE 
				 1=1 
				".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."  ) B 
				 WHERE A.CHANNEL = B.CHANNEL AND A.DAYS = B.DAYS
				 GROUP BY A.CHANNEL,A.DAYS,A.VIEWERS,B.VIEWERS
				 order by  B.VIEWERS/A.VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='Reach')	 {

				$query = "
				SELECT R.CHANNEL, (R.VIEWERS / B.`VIEWERS`)*100 AS VIEWERS,DAYS FROM `PTV_M_SUM_TV_DASH_CHAN_DAYS` R,
				(SELECT * FROM `M_SUM_TV_DASH_DATE_PTV` WHERE TANGGAL = '".$periode."'  ) B
				WHERE R.DAYS = toDate(B.`DATE`)
				".$where."
				AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
				AND CHANNEL IS NOT NULL 
				ORDER BY DAYS,VIEWERS DESC
				"; 

			}else{
				
				$query = "SELECT * FROM `PTV_M_SUM_TV_DASH_CHAN_DAYS` R
							WHERE 1=1 
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC";  	
			}
 		$result = $db->select($query);
		return $result->rows();	   
	}
	
	
	public function list_spot_all_days_tvod($field,$where,$periode,$pilihaudiencebar,$profile,$check,$first_day,$this_day,$tipe_filter) {
		
		$db = $this->clickhouse->db();
		
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = '';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' '.$wh_chn.' 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

			 
					
					$query = "SELECT * FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS` R
							WHERE R.TIPE_FILTER = '".$tipe_filter."'
							 AND R.TIPE_VIEW = 'TOTAL_VIEWS'
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='Duration')	 {

							
							$query = "SELECT * FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS` R
							WHERE R.TIPE_FILTER = '".$tipe_filter."'
							 AND R.TIPE_VIEW = 'DURATION'
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC"; 

			}
			elseif ($pilihaudiencebar=='share')	 {

			 
							
				$query = "
				SELECT A.*,B.tot_spot,(A.Spot_a/B.tot_spot)*100 AS VIEWERS FROM (
				SELECT CHANNEL ,VIEWERS AS Spot_a,DAYS FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 1=1 ".$where."
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				) A,(	
				SELECT SUM(VIEWERS) AS tot_spot,DAYS  FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 1=1 
				".$where."
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY DAYS 
				) B WHERE A.DAYS = B.DAYS
				 ORDER BY Spot_a DESC"; 

			}
			elseif ($pilihaudiencebar=='avgtotdur')	 {

			 
							
							
				$query = "SELECT A.CHANNEL,A.DAYS,A.VIEWERS AS TOTAL_VIEWS,B.VIEWERS AS DURATION, B.VIEWERS/A.VIEWERS AS VIEWERS FROM 
				(
				SELECT CHANNEL ,VIEWERS, DAYS FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 1=1 
				'.$where.'
				AND R.TIPE_VIEW = 'TOTAL_VIEWS'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."   ) A,
				(
				SELECT CHANNEL ,VIEWERS, DAYS FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 1=1 
				'.$where.'
				 AND R.TIPE_VIEW = 'DURATION'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn."   ) B 
				 WHERE A.CHANNEL = B.CHANNEL AND A.DAYS = B.DAYS
				 GROUP BY A.CHANNEL,A.DAYS
				 order by  B.VIEWERS/A.VIEWERS DESC"; 

			}elseif ($pilihaudiencebar=='Reach')	 {

				$query = "
				SELECT R.CHANNEL, (R.VIEWERS / B.`VIEWERS`)*100 AS VIEWERS,DAYS FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS` R,
				(SELECT * FROM `M_SUM_TV_DASH_DATE_PTV`) B
				WHERE R.DAYS = B.`DATE`
				AND R.TIPE_FILTER = '".$tipe_filter."'
				AND R.TIPE_VIEW = 'VIEWERS'
				'.$where.'
				AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				AND CHANNEL IS NOT NULL 
				ORDER BY DAYS,VIEWERS DESC
				";  

			}
			else{

				$query = "SELECT * FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS` R
							WHERE R.TIPE_FILTER = '".$tipe_filter."'
							 AND R.TIPE_VIEW = 'VIEWERS'
							".$where."
							AND R.ID_PROFILE = '".$profile."' ".$wh_chn."
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC"; 							
			}
 		
		$result = $db->select($query);
		return $result->rows();	 		
	}
	
	
	public function get_week_days($where){
	
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT(DAYS) FROM `PTV_M_SUM_TV_DASH_CHAN_DAYS` R
							WHERE 1=1 
							".$where."
							
							AND CHANNEL IS NOT NULL 
							ORDER BY DAYS,VIEWERS DESC";   
		
 							
		$result = $db->select($query);
		return $result->rows();
	
	}
	
	public function list_spot_by_program_all_bar_tvod_exp($field,$where,$periode,$pilihaudiencebar,$profile,$check,$tipe_filter,$first_day,$this_day) {

		$db = $this->clickhouse->db();
		
		if($check == "True"){
				$wh_chn = "";
		}else{
				$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0)" ;
		}
		
		$query = '';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot,SUM(VIEWERS) AS VIEWERS_TOTAL FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'TOTAL_VIEWS' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}elseif ($pilihaudiencebar=='Duration')	 {

					$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot,SUM(VIEWERS) AS VIEWERS_TOTAL FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'DURATION' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}elseif ($pilihaudiencebar=='share')	 {

				$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'DURATION'  ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

			$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'TOTAL_VIEWS' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}else{
				
				$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'VIEWERS' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 
			}
 		$result = $db->select($query);
		return $result->rows();	 	   
	}
	
	public function list_spot_by_program_all_bar_tvod($field,$where,$periode,$pilihaudiencebar,$profile,$check,$tipe_filter,$first_day,$this_day) {
		
		$db = $this->clickhouse->db();
		
		if($check == "True"){
				$wh_chn = "";
		}else{
				$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
		$query = '';  
					
			if 	($pilihaudiencebar=='GRP')	 {
				$query = "SELECT CHANNEL as channel,grp AS Spot FROM M_SUM_TV_DASH_CHAN_GRP_PTV R WHERE 
				 R.TANGGAL='".$periode."' ".$where."
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
					ORDER BY grp DESC"; 
			}elseif ($pilihaudiencebar=='Viewers')	 {

				$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'TOTAL_VIEWS' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 


			}elseif ($pilihaudiencebar=='Duration')	 {
					
					$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'DURATION' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}elseif ($pilihaudiencebar=='share')	 {

					
					$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'DURATION' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}elseif ($pilihaudiencebar=='avgtotdur')	 {

			$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'TOTAL_VIEWS' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 

			}else{
					
						$query = "SELECT CHANNEL as channel,AVG(VIEWERS) AS Spot FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS R WHERE 
				 R.TIPE_VIEW = 'VIEWERS' ".$where."
				 AND R.TIPE_FILTER = '".$tipe_filter."'
				 AND R.ID_PROFILE = '".$profile."' ".$wh_chn." 
				 GROUP BY CHANNEL
					ORDER BY AVG(VIEWERS) DESC"; 
			}
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
 			}else {
				 
				
				$query = '
				SELECT z.*, rank() over ( ORDER BY Spot DESC,channel DESC) AS Rangking FROM 
			( 
				SELECT CHANNEL as channel, VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_CHAN_DAYS 
				WHERE TANGGAL ="'.$periode.'" AND `DAYS` ="'.$datef.'" '.$wh_chn.' 
				AND ID_PROFILE = "'.$profile.'" 
				ORDER BY Spot DESC ) z';
 			}
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
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
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
					'.$where.' '.$wh_chn.' 
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					';
					
					 $query2 = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
					SELECT DISTINCT a.`'.$field.'`,CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_WEEK_PTV a 
					WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
					'.$where.' '.$wh_chn.' 
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
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC					
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' 
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
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
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
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' 
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
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_WEEK_PTV a
						WHERE TANGGAL ="'.$params['periode'].'" AND WEEK ="'.$params['week'].'" 
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
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
 
		 $query2s		= $this->db->query($query2);
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
	
	public function list_spot_by_program_all2Ps_new_day($field,$wheres,$params,$pilihprog,$profile) {
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
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
					SELECT PROGRAM as Program, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tglf'].'" 
					'.$where.' '.$wh_chn.' 
					AND ID_PROFILE = "'.$profile.'" 
					ORDER BY Spot DESC
					)z 
					';
					
					 $query2 = 	'	
					SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
					( 
					SELECT PROGRAM as Program, CHANNEL,GRP AS Spot FROM M_SUM_TV_DASH_PROG_GRP_DAY_PTV a
					WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tglf'].'" 
					'.$where.' '.$wh_chn.' 
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
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'"
						ORDER BY Spot DESC 						
						)z 
						';
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAY` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' 
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
						
			$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
					SELECT A.CHANNEL,A.Program,A.Spot AS TOTAL_VIEWS,B.Spot AS DURATION, B.Spot/A.Spot AS Spot FROM 
					(
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
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
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC 
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
						( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_DAY_PTV 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' 
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
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						';
						
						$query2 = 	'
			SELECT z.*, rank() over ( ORDER BY Spot DESC,'.$field.' DESC) AS Rangking FROM 
				( 
						SELECT PROGRAM as Program, CHANNEL , VIEWERS AS Spot FROM PTV_M_SUM_TV_DASH_PROG_DAYS 
						WHERE TANGGAL ="'.$params['periode'].'" AND `DAYS` ="'.$params['tgl'].'" 
						'.$where.' '.$wh_chn.' 
						AND ID_PROFILE = "'.$profile.'" 
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
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
		
		
 		
		 $sql	= $this->db->query($query2);
		$this->db->close();
		$this->db->initialize(); 
 		return $sql->result_array();			

 	}
	
	public function list_spot_by_program_all2Ps_new_tvod_x($field,$wheres,$params,$pilihprog,$profile,$tipe_filter) {
		
		if($params['check'] == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
		
		$where = " AND (PROGRAM LIKE '%".$params['searchtxt']."%' OR CHANNEL LIKE '%".$params['searchtxt']."%') ";
		
			if($params['check'] == "True"){
				$wh_chn = '';
			}else{
					$wh_chn = ' AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
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
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
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
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
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
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_VIEWERS_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
				LIMIT '.$params['limit'].' 
				OFFSET '.$params['offset'].' 
						';
		
		}elseif ($pilihprog=='Duration') {
		$query = 	'
			SELECT COUNT(*) AS jumlah FROM 
				( 
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_DURATION_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
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
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
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
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
						
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
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
 		
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
	 
					
					$arr_per = explode("-",$params['periode']);
					
					if(count($arr_per) == 2){
					
						$query = 	'	
						SELECT COUNT(*) AS jumlah FROM 
						( 
						SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_GRP_PTV a 
						WHERE 1=1 
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' 
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
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
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
						AND SUBSTRING(TANGGAL, 1, 4)="'.$params['periode'].'" '.$where.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
							AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
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
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
						AND a.`TIPE_FILTER` = "'.$tipe_filter.'"
						AND a.`TIPE_VIEW` = "VIEWERS"
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						
				) A,
				(
					SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_TVOD a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.' '.$wh_chn.' 
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
						AND TANGGAL="'.$params['periode'].'" '.$where.'
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
						AND TANGGAL="'.$params['periode'].'" '.$where.'
						#GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						LIMIT '.$params['limit'].' 
						OFFSET '.$params['offset'].' 
						';
		}		
		
		
 		
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
	  
	 
		 $query2s		= $this->db->query($query2);
      $result2 = $query2s->result_array();						
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	
 	public function list_spot_by_program_all2Ps($field,$where,$periode,$pilihprog,$profile) {
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
			SELECT DISTINCT a.`'.$field.'`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a
						WHERE 1=1 
						AND ID_PROFILE = "'.$profile.'" 
						AND TANGGAL="'.$periode.'" '.$where.'
						GROUP BY CHANNEL,a.`'.$field.'`
						ORDER BY Spot DESC
						)z 
						';
		}		
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
 		return $sql->result_array();	   
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
	
 	public function list_spot_by_date_all2($where,$periode,$start_date,$end_date,$preset) {
		$db = $this->clickhouse->db();
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV
				  WHERE 1=1 AND DATE BETWEEN '".$start_date."' AND '".$end_date."' 
				  ".$where." 
				  ORDER BY DATE";			
		$result = $db->select($query);
		return $result->rows();	   	   
	}
	
	public function list_spot_by_date_all2_preset($where,$periode,$start_date,$end_date,$preset) {
		$query = "
		SELECT COUNT(DISTINCT(CARDNO)) AS `spot`, DATE_FORMAT(`USER_BEGIN_SESSION`,'%Y-%m-%d') AS `date` FROM `NEW_CDR_LIVE_CLEAN_CS` A
		LEFT JOIN `CHANNEL_PARAM_FINAL` B ON A.CHANNEL = B.`CHANNEL_NAME`
		WHERE `USER_BEGIN_SESSION` BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'
		".$preset."
		GROUP BY DATE_FORMAT(`USER_BEGIN_SESSION`,'%Y-%m-%d') 
		ORDER BY DATE_FORMAT(`USER_BEGIN_SESSION`,'%Y-%m-%d') 
		";			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize();  
		return $sql->result_array();	   
	}
	
		public function list_spot_by_date_all2_viewer($where,$periode,$start_date,$end_date,$preset) {
			$db = $this->clickhouse->db();
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV_VIEWERS
				  WHERE 1=1 AND DATE BETWEEN '".$start_date."' AND '".$end_date."'
				  ".$where." 
				  ORDER BY DATE";			
		 
		
		$result = $db->select($query);
		return $result->rows();	   
	}	
	
	public function list_spot_by_date_all2_preset_s($where,$periode,$start_date,$end_date,$preset) {
		$db = $this->clickhouse->db();

		$query = "
		SELECT CHANNEL, VIEWERS AS `spot`, DAYS AS `date` FROM `PTV_M_SUM_TV_DASH_CHAN_DAYS` A
		WHERE `DAYS` BETWEEN '".$start_date."' AND '".$end_date."'
		".$where."
		ORDER BY DAYS 
		";			
		
		 
		
		$result = $db->select($query);
		return $result->rows();	   
	}

	
	public function list_spot_by_date_all2_viewer_preset($where,$periode,$start_date,$end_date,$preset) {
		$query = "
		SELECT SUM(`VIEWERS`) `spot`,`DAYS` AS `date` FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` A
		WHERE `DAYS` BETWEEN '".$start_date."' AND '".$end_date."'
		".$preset."
		GROUP BY `DAYS`
		ORDER BY `DAYS` 
		";			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize();  
		return $sql->result_array();	   
	}	
	
	public function list_spot_by_date_all2_viewer_preset_s($where,$periode,$start_date,$end_date,$preset) {

		$db = $this->clickhouse->db();

		$query = "
		SELECT `VIEWERS` `spot`,`DAYS` AS `date` FROM `M_SUM_TV_DASH_CHAN_VIEWERS_DAYS_PTV` A
		WHERE `DAYS` BETWEEN '".$start_date."' AND '".$end_date."'
		".$where."
		ORDER BY `DAYS` 
		";			
	 
		$result = $db->select($query);
		return $result->rows();	   	   
	}

	public function list_spot_by_date_all2_duration($where,$periode,$start_date,$end_date,$preset) {

		$db = $this->clickhouse->db();
		
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV_DURATION
				  WHERE 1=1 AND DATE BETWEEN '".$start_date."' AND '".$end_date."' 
				  ".$where." 
				  ORDER BY DATE";			
	 

		$result = $db->select($query);
		return $result->rows();	   
	}
	
	public function list_spot_by_date_all2_duration_preset($where,$periode,$start_date,$end_date,$preset) {
		$query = 'SELECT SUM(`VIEWERS`) `spot`,`DAYS` AS `date` FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` A
					WHERE `DAYS` BETWEEN "'.$start_date.'" AND "'.$end_date.'"
					'.$preset.'
					GROUP BY `DAYS`
					ORDER BY `DAYS`';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}	
	
	public function list_spot_by_date_all2_duration_preset_s($where,$periode,$start_date,$end_date,$preset) {

		$db = $this->clickhouse->db();

		$query = "SELECT `VIEWERS` `spot`,`DAYS` AS `date` FROM `M_SUM_TV_DASH_CHAN_DURATION_DAYS_PTV` A
					WHERE `DAYS` BETWEEN '".$start_date."' AND '".$end_date."'
					".$where."
					ORDER BY `DAYS`";			
	 

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
		$query = 'SELECT COUNT(`PROGRAM`) AS spot FROM (
		SELECT DISTINCT a.`PROGRAM`,CHANNEL, VIEWERS AS Spot FROM M_SUM_TV_DASH_PROG_PTV a 
		WHERE `ID_PROFILE` = 0   AND TANGGAL="'.$periode.'" '.$where.' 
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
	
	public function count_channel_tvod($periode) {

		$db = $this->clickhouse->db();
		
		$query = "SELECT COUNT(DISTINCT(CHANNEL)) jmlch FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS WHERE TANGGAL = '".$periode."' AND ID_PROFILE = 0 AND TIPE_FILTER = 'TVOD' " ;
			
		$result = $db->select($query);
		return $result->rows();	 

		
		 
	}	
	
	public function count_channel_all($periode) {
		 

	$query = 'SELECT COUNT(DISTINCT(CHANNEL)) jmlch FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS`
	WHERE `TANGGAL` = "'.$periode.'" AND ID_PROFILE = 0 AND `TIPE_FILTER` = "ALL"';  		 			
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function count_program_tvod($periode) {
		 
		$db = $this->clickhouse->db();
				
		$query = "SELECT COUNT(DISTINCT(PROGRAM)) jmlpr FROM M_SUM_TV_DASH_PROG_TVOD WHERE TANGGAL = '".$periode."' AND ID_PROFILE = 0 AND TIPE_FILTER = 'TVOD' " ;
			
		$result = $db->select($query);
		return $result->rows();	 

		 
	}	
	
	public function count_program_all($periode) {
		 
$db = $this->clickhouse->db();
	$query = "SELECT COUNT(DISTINCT(PROGRAM)) jmlpr FROM `M_SUM_TV_DASH_PROG_TVOD`
	WHERE `TANGGAL` = '".$periode."' AND ID_PROFILE = 0 AND `TIPE_FILTER` = 'ALL'";  		 			
 		$result = $db->select($query);
		return $result->rows();	   
	}	
	
	public function count_program($periode) {
		   
		
		$db = $this->clickhouse->db();
		
		 
		
		$query = "SELECT COUNT(`PROGRAM`) AS jmlpr FROM (
		SELECT DISTINCT a.`PROGRAM`,CHANNEL FROM M_SUM_TV_DASH_PROG_PTV a 
		WHERE `ID_PROFILE` = 0   AND TANGGAL='".$periode."' 
		GROUP BY CHANNEL,a.`PROGRAM`
		
		) P ";  		
		
		$result = $db->select($query);
		return $result->rows();	 
	}
	
	public function get_active_audience_tvod($periode){

		$db = $this->clickhouse->db();
		
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE_TVOD WHERE TANGGAL = '".$periode."' AND TPE = 'TVOD' " ;
			
		$result = $db->select($query);
		return $result->rows();	 
		
		 	
	}	
	
	public function get_active_audience_all($periode){
		
		$db = $this->clickhouse->db();
		
		$query = "SELECT VIEWERS FROM M_SUM_TV_DASH_ACTIVE_TVOD WHERE TANGGAL= '".$periode."'
		AND TPE = 'ALL' " ;
 		
 		$result = $db->select($query);
		return $result->rows();	   		
	}	
	
	public function get_total_views_tvod($periode){
		
		$db = $this->clickhouse->db();
		
		$query = "SELECT SUM(VIEWERS) as TOTAL_VIEWS FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS 
		WHERE TANGGAL = '".$periode."' AND TIPE_VIEW = 'TOTAL_VIEWS' AND TIPE_FILTER = 'TVOD' " ;
			
		$result = $db->select($query);
		return $result->rows();	 
		
		
	 
	}
	
	public function get_total_views_all($periode){
		
		$db = $this->clickhouse->db();
		
		$query = "SELECT SUM(VIEWERS) as TOTAL_VIEWS FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS`
		WHERE `TANGGAL` = '".$periode."' AND TIPE_VIEW = 'TOTAL_VIEWS' AND TIPE_FILTER = 'ALL' " ;
 		
		$result = $db->select($query);
		return $result->rows();	 		
	}
	
	public function get_duration_tvod($periode){
		
		$db = $this->clickhouse->db();
		
		$query = "SELECT SUM(VIEWERS) as DURATION FROM M_SUM_TV_DASH_CHAN_TVOD_DAYS
		WHERE TANGGAL = '".$periode."' AND TIPE_VIEW = 'DURATION' AND TIPE_FILTER = 'TVOD' " ;
			
		$result = $db->select($query);
		return $result->rows();	 
		
		 
	}
	
	public function get_duration_all($periode){
		
		$db = $this->clickhouse->db();
		$query = "SELECT SUM(VIEWERS) as DURATION FROM `M_SUM_TV_DASH_CHAN_TVOD_DAYS`
		WHERE `TANGGAL` = '".$periode."' AND TIPE_VIEW = 'DURATION' AND TIPE_FILTER = 'ALL' " ;
 		
 		$result = $db->select($query);
		return $result->rows();	 			
	}
	
	
}	
