<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvpc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		//$this->db2 = $this->load->database('db_prod', TRUE);
	}
  
	public function save_channels($params){ 
      $sql 	= "INSERT INTO CHANNEL_SAVE(`USERID`,`CHANNEL_NAME`,`CHANNEL_LIST`,MENUS) VALUES('".$params['user_id']."','".$params['save_channel_name']."','".$params['channel']."','0')";
            
      if ($sql) {
          $this->db->query($sql);
          
          $query = 'SELECT * FROM CHANNEL_SAVE WHERE USERID="'.$params['user_id'].'" AND MENUS="0" ORDER BY CHANNEL_NAME ';			
      		$sql	= $this->db2->query($query);
      		$this->db->close();
      		$this->db->initialize(); 
      		return $sql->result_array();	
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
	
	public function list_market(){
		
			$query = " 
		
		SELECT KOTA AS `name` FROM MARKET ORDER BY KOTA
		
		";
    
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
		
	}
  
	public function list_profile($iduser,$idrole,$period) {

    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
    
		$query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.id = c.PROFILE_ID WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil= ".$iduser.") AND c.STATUS_PROCESS = 1 AND c.PERIODE = '".$sPeriod."'";
      
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channel() {
		
		$query = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS channel FROM  `CHANNEL_PARAM_FINAL` B ORDER BY CHANNEL_NAME_PROG ";
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		return $sql->result_array();	   
	}          
  
  public function list_channel_by_genre($strGenre) {     
    if($strGenre == "0"){
        $strWhere = "";
    } else {
        $strWhere = "AND GENRE = '".$strGenre."' ";
    }
    
	$query = " SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1 ".$strWhere."  
      ORDER BY C.`CHANNEL_NAME`";
	
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}                               
  
  public function list_daypart($userid) {
		$query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$userid.'" AND MENUS="0" ORDER BY DAYPART1 ';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
  
  public function list_channel_genre() {
	  
	    
	  $query = " SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1 
      ORDER BY C.`GENRE`";
	  
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	} 
	
	public function list_package() {
		$query = "SELECT DISTINCT(PACKAGES) AS GENRE FROM `CHANNEL_PARAM_FINAL` C    
      ORDER BY C.`PACKAGES`";
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}
	
	public function content_grouping($profile) {
		$query = 'SELECT grouping
					FROM t_profiling_ub
					WHERE id = '.$profile.'
					AND STATUS = 1;';  			
		$sql	= $this->db2->query($query,array($profile));
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT USERID	FROM SINGLE_SOURCE_VALUE"." ".$data;
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	   
	}	
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(TVPC_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
	public function list_tvpc_all($params = array()) {
		
		
		
		IF($params['layout1'] == '1'){
			$lmt = '';
		}ELSE{
			$lmt = " LIMIT ".$params['layout1']." ";
		}
	  
	  IF($params['type_vo'] == 'NORMAL'){
	  
			IF($params['layout2'] == 'channel' ){
	  
	  		$sql = "
				SELECT RANK() OVER (
					ORDER BY AUDIENCE DESC
				) Rangking, * FROM (
				SELECT A.*,B.TYPE_NAME, TVR as TVR, B.TVS, C.TOTAL_VIEWERS AS TOTAL_VIEW, B.ACTIVE_A, B.PROFILE_ID, (A.AUDIENCE/B.ACTIVE_A)*100 AS REACH FROM (
				SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AUDIENCE FROM `NEW_CDR_LIVE_CLEAN_CS`
				WHERE (`USER_BEGIN_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
				OR `USER_END_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59' )
				AND CHANNEL NOT IN ('ANTV','INDOSIAR','KOMPAS TV','METRO TV','NET TV','RTV','SCTV','TRANS 7','TRANS TV','TV ONE','TVRI')
				GROUP BY CHANNEL
				ORDER BY AUDIENCE DESC
				) A LEFT JOIN
				(
				SELECT `TYPE`,`TYPE_NAME`, HOURS, AVG(TVR) AS TVR, AVG(TVS) AS TVS,
						SUM(TOTAL_VIEW) AS TOTAL_VIEW,ACTIVE_A, `PROFILE_ID`
						FROM `AUDIENCE_MINUTES` A,
						( SELECT `VIEWERS` AS ACTIVE_A FROM `M_SUM_TV_DASH_ACTIVE_PTV` WHERE `TANGGAL` = '".$params['periode']."' ) B 
						WHERE `PROFILE_ID` = ".$params['profile']."
						AND `TYPE` = 'CHANNEL'
						AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
						AND SPLIT_MINUTES BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
						GROUP BY TYPE_NAME
				) B ON A.CHANNEL = B.TYPE_NAME
				LEFT JOIN 
				(
					SELECT CHANNEL, COUNT(USER_BEGIN_SESSION) AS TOTAL_VIEWERS FROM `NEW_CDR_LIVE_CLEAN_CS`
					WHERE (`USER_BEGIN_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
					OR `USER_END_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59' ) 
					AND CHANNEL IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
					GROUP BY CHANNEL
						
				) C ON A.CHANNEL = C.CHANNEL
				WHERE TVR IS NOT NULL
				ORDER BY AUDIENCE DESC
				".$lmt." 
					) O
				";
			
			}else IF($params['layout2'] == 'ALL' ){
				
				$sql = "
							SELECT RANK() OVER (
					ORDER BY AUDIENCE DESC
				) Rangking, * FROM (
				SELECT A.*,B.TYPE_NAME, TVR as TVR , B.TVS, C.TOTAL_VIEWERS AS TOTAL_VIEW, B.ACTIVE_A, B.PROFILE_ID, (A.AUDIENCE/B.ACTIVE_A)*100 AS REACH FROM (
				SELECT 'ALL' AS CHANNEL,COUNT(DISTINCT(CARDNO)) AUDIENCE FROM `NEW_CDR_LIVE_CLEAN_CS`
				WHERE (`USER_BEGIN_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
				OR `USER_END_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59' )
				AND CHANNEL NOT IN ('ANTV','INDOSIAR','KOMPAS TV','METRO TV','NET TV','RTV','SCTV','TRANS 7','TRANS TV','TV ONE','TVRI')
				ORDER BY AUDIENCE DESC
				) A LEFT JOIN
				(
				SELECT `TYPE`,'ALL' AS `TYPE_NAME`, HOURS, AVG(TVR) AS TVR, AVG(TVS) AS TVS,
						SUM(TOTAL_VIEW) AS TOTAL_VIEW,ACTIVE_A, `PROFILE_ID`
						FROM `AUDIENCE_MINUTES` A,
						( SELECT `VIEWERS` AS ACTIVE_A FROM `M_SUM_TV_DASH_ACTIVE_PTV` WHERE `TANGGAL` = '".$params['periode']."' ) B 
						WHERE `PROFILE_ID` = ".$params['profile']."
						AND `TYPE` = 'ALL'
						AND SPLIT_MINUTES BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
				) B ON A.CHANNEL = B.TYPE_NAME
				LEFT JOIN 
				(
					SELECT CHANNEL, COUNT(USER_BEGIN_SESSION) AS TOTAL_VIEWERS FROM `NEW_CDR_LIVE_CLEAN_CS`
					WHERE (`USER_BEGIN_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
					OR `USER_END_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59' ) 
					AND CHANNEL IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
					GROUP BY CHANNEL
						
				) C ON A.CHANNEL = C.CHANNEL
				WHERE TVR IS NOT NULL
				ORDER BY AUDIENCE DESC
				".$lmt."
				) O
				";
			
			}
			
	  }else{
		  
		  	IF($params['layout2'] == 'channel' ){
	  
	  		$sql = "
				SELECT * FROM AUDIENCE_DAYS_ALL
				WHERE PERIODE = '".$params['periode']."' 
				AND `TYPE` = '".$params['type_vo']."'
				AND `TYPE_NAME` = '".$params['type_val']."'
				AND `PROFILE_ID` = ".$params['profile']."
				AND CHANNEL IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY AUDIENCE DESC
				".$lmt."
				";
			
			}else IF($params['layout2'] == 'ALL' ){
				
				$sql = "
					SELECT * FROM AUDIENCE_DAYS_ALL_ALL
					WHERE PERIODE = '".$params['periode']."' 
					AND `TYPE` = '".$params['type_vo']."'
					AND `TYPE_NAME` = '".$params['type_val']."'
					AND `PROFILE_ID` = ".$params['profile']."
					AND CHANNEL IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") )
					ORDER BY AUDIENCE DESC
					".$lmt."	
				";
			
			}
		  
	  }
			
			
			$out		= array();
			$query		= $this->db2->query($sql);
			$result = $query->result_array();
	  
			return $result;
	}
  
	public function list_tvpc($params = array()) {
		$db = $this->clickhouse->db();	
		
		IF($params['layout1'] == '1'){
			$lmt = '';
		}ELSE{
			$lmt = " LIMIT ".$params['layout1']." ";
		}
	  
		
		IF($params['daypart'] == 'ALL_ALL' ){
			
			IF($params['layout2'] == 'channel' ){
				
				$sql = "
			SELECT A.*,B.TYPE_NAME, B.TVR, B.TVS, B.TOTAL_VIEW, B.ACTIVE_A, B.PROFILE_ID, (A.AUDIENCE/B.ACTIVE_A)*100 AS REACH FROM (
			SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AUDIENCE FROM `NEW_CDR_LIVE_CLEAN_CS`
			WHERE `USER_BEGIN_SESSION` BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
			AND CHANNEL NOT IN ('ANTV','INDOSIAR','KOMPAS TV','METRO TV','NET TV','RTV','SCTV','TRANS 7','TRANS TV','TV ONE','TVRI')
			GROUP BY CHANNEL
			ORDER BY AUDIENCE DESC
			) A LEFT JOIN
			(
			SELECT `TYPE`,`TYPE_NAME`, HOURS, AVG(TVR) AS TVR, AVG(TVS) AS TVS,
					SUM(TOTAL_VIEW) AS TOTAL_VIEW,ACTIVE_A, `PROFILE_ID`
					FROM `AUDIENCE_MINUTES` A,
					( SELECT `VIEWERS` AS ACTIVE_A FROM `M_SUM_TV_DASH_ACTIVE_PTV` WHERE `TANGGAL` = '2021-October' ) B 
					WHERE `PROFILE_ID` = ".$params['profile']."
					AND `TYPE` = 'CHANNEL'
					AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
					AND SPLIT_MINUTES BETWEEN '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
					GROUP BY TYPE_NAME
			) B ON A.CHANNEL = B.TYPE_NAME
			WHERE TVR IS NOT NULL
			
			ORDER BY ".$params['order_column']." ".$params['order_dir']."
			".$lmt." 
				
				";
			
			}else IF($params['layout2'] == 'ALL' ){
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'ALL'
				AND TVR IS NOT NULL
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}
			
		}ELSE IF($params['daypart'] == 'ALL' ){
			
			IF($params['layout2'] == 'channel' ){
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'CHANNEL'
				AND TVR IS NOT NULL
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				LIMIT ".$params['layout1']." 
				
				) A 
				
				";
			
			}else IF($params['layout2'] == 'program' ){
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE <> 'CHANNEL'
				AND TYPE <> 'ALL'
				AND TVR IS NOT NULL
				AND TYPE IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") )
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}else IF($params['layout2'] == 'ALL' ){
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'ALL'
				AND TVR IS NOT NULL
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}
			
		}elseif($params['daypart'] == 'HOUR'){
			
			IF($params['layout2'] == 'channel' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = ' AND HOURS = "'.$params['daypart2'].'" ';
				}else{
					$where_dp2 = '';
				}
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_HOURS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'CHANNEL' ".$where_dp2."
				AND TVR IS NOT NULL
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}elseIF($params['layout2'] == 'program' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_HOURS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE <> 'CHANNEL'
				AND TYPE <> 'ALL' ".$where_dp2."
				AND TVR IS NOT NULL
				AND TYPE IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") )
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}elseIF($params['layout2'] == 'ALL' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_HOURS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'ALL' ".$where_dp2."
				AND TVR IS NOT NULL
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}
			
		}elseif($params['daypart'] == 'MINUTE'){
			
			IF($params['layout2'] == 'channel' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_MINUTES WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'CHANNEL' ".$where_dp2."
				AND TVR IS NOT NULL
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}elseif($params['layout2'] == 'program' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_MINUTES WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TVR IS NOT NULL
				AND TYPE <> 'CHANNEL' AND TYPE <> 'ALL'  ".$where_dp2."
				AND TYPE IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") )
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}elseif($params['layout2'] == 'ALL' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql = "
				SELECT * FROM (
				SELECT * FROM AUDIENCE_MINUTES WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TVR IS NOT NULL
				AND TYPE = 'ALL' ".$where_dp2."
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A 
				
				";
			
			}
			
		}
		
		$querys	= $db->select($sql);
		$result = $querys->rows();	  
	
		// $out		= array();
		// $query		= $this->db2->query($sql);
		// $result = $query->result_array();

		// while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		// if($l_result = mysqli_store_result($this->db2->conn_id)){
			  // mysqli_free_result($l_result);
			// }
		// }

		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
		if(($params['offset']+10) > $total_filtered['ROWS']){
			$limit_data = $total_filtered['ROWS'] - $params['offset']; 
		}else{
			$limit_data = $params['limit'] ;
		}
			
			
				IF($params['daypart'] == 'ALL_ALL' ){
			
			IF($params['layout2'] == 'channel' ){
				
				$sql2 = "
			SELECT C.CHANNEL_NAME_PROG, A.*,B.TYPE_NAME, B.TVR, B.TVS, B.TOTAL_VIEW, B.ACTIVE_A, B.PROFILE_ID, (A.AUDIENCE/B.ACTIVE_A)*100 AS REACH FROM (
			SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AUDIENCE FROM `NEW_CDR_LIVE_CLEAN_CS`
			WHERE `USER_BEGIN_SESSION` BETWEEN  '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
			AND CHANNEL NOT IN ('ANTV','INDOSIAR','KOMPAS TV','METRO TV','NET TV','RTV','SCTV','TRANS 7','TRANS TV','TV ONE','TVRI')
			GROUP BY CHANNEL
			ORDER BY AUDIENCE DESC
			) A LEFT JOIN
			(
			SELECT `TYPE`,`TYPE_NAME`, HOURS, AVG(TVR) AS TVR, AVG(TVS) AS TVS,
					SUM(TOTAL_VIEW) AS TOTAL_VIEW,ACTIVE_A, `PROFILE_ID`
					FROM `AUDIENCE_MINUTES` A,
					( SELECT `VIEWERS` AS ACTIVE_A FROM `M_SUM_TV_DASH_ACTIVE_PTV` WHERE `TANGGAL` = '2019-May' ) B 
					WHERE `PROFILE_ID` = ".$params['profile']."
					AND `TYPE` = 'CHANNEL'
					AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") )
					AND SPLIT_MINUTES BETWEEN  '".$params['start_date']." 00:00:00' AND '".$params['end_date']." 23:59:59'
					GROUP BY TYPE_NAME
			) B ON A.CHANNEL = B.TYPE_NAME
			LEFT JOIN CHANNEL_PARAM_FINAL C ON A.CHANNEL = C.CHANNEL_NAME
			WHERE TVR IS NOT NULL
			
			ORDER BY ".$params['order_column']." ".$params['order_dir']."
			LIMIT ".$params['offset'].",".$limit_data
				
				;
			
			}else IF($params['layout2'] == 'ALL' ){
				
				$sql2 = "
				SELECT A.*,C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'ALL'
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME
				
				";
			
			}
			
		}ELSE IF($params['daypart'] == 'ALL' ){
			
			IF($params['layout2'] == 'channel' ){
				
				$sql2 = "
				SELECT A.*,C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'CHANNEL'
				AND TVR IS NOT NULL
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") )
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				LIMIT ".$params['offset'].",".$limit_data;		

			
			}else IF($params['layout2'] == 'program' ){
				
				$sql2 = "
				SELECT A.*,C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE <> 'CHANNEL'
				AND TYPE <> 'ALL'
				AND TVR IS NOT NULL
				AND TYPE IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE = C.CHANNEL_NAME
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				LIMIT ".$params['offset'].",".$limit_data;		

			
			}else IF($params['layout2'] == 'ALL' ){
				
				$sql2 = "
				SELECT A.*, C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_DAYS WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TYPE = 'ALL'
				AND TVR IS NOT NULL
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				LIMIT ".$params['offset'].",".$limit_data;		

			
			}
			
			
		}elseif($params['daypart'] == 'HOUR'){
			
			IF($params['layout2'] == 'channel' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = ' AND HOURS = "'.$params['daypart2'].'" ';
				}else{
					$where_dp2 = '';
				}
				
				$sql2 = '
				SELECT A.*, CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_HOURS WHERE DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND PROFILE_ID = '.$params['profile'].'
				AND TYPE = "CHANNEL" '.$where_dp2.'
				AND TVR IS NOT NULL
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN('.$params['channel'].') ) 
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
				'.$lmt.' 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
				LIMIT '.$params['offset'].','.$limit_data;	
			
			}else IF($params['layout2'] == 'program' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = ' AND HOURS = "'.$params['daypart2'].'" ';
				}else{
					$where_dp2 = '';
				}
				
				$sql2 = '
				SELECT A.*, C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_HOURS WHERE DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND PROFILE_ID = '.$params['profile'].'
				AND TVR IS NOT NULL
				AND TYPE <> "CHANNEL" AND TYPE <> "ALL" '.$where_dp2.'
				AND TYPE IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN('.$params['channel'].') )
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
				'.$lmt.' 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE = C.CHANNEL_NAME
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
				LIMIT '.$params['offset'].','.$limit_data;	
			
			}else IF($params['layout2'] == 'ALL' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = ' AND HOURS = "'.$params['daypart2'].'" ';
				}else{
					$where_dp2 = '';
				}
				
				$sql2 = '
				SELECT A.*,CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_HOURS WHERE DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND PROFILE_ID = '.$params['profile'].'
				AND TVR IS NOT NULL
				AND TYPE = "ALL" '.$where_dp2.'
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
				'.$lmt.' 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME
				ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
				LIMIT '.$params['offset'].','.$limit_data;	
			
			}
			
		}elseif($params['daypart'] == 'MINUTE'){
			
			IF($params['layout2'] == 'channel' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql2 = "
				SELECT A.*,C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_MINUTES WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TVR IS NOT NULL
				AND TYPE = 'CHANNEL' ".$where_dp2."
				AND TYPE_NAME IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME
				ORDER BY ".$params['order_column']." ".$params['order_dir']." 
				LIMIT ".$params['offset'].",".$limit_data;	
			
			}else IF($params['layout2'] == 'program' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql2 = "
				SELECT A.*, C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_MINUTES WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TVR IS NOT NULL
				AND TYPE <> 'CHANNEL' AND TYPE <> 'ALL' ".$where_dp2."
				AND TYPE IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN(".$params['channel'].") ) 
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE = C.CHANNEL_NAME
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				LIMIT ".$params['offset'].",".$limit_data;	
			
			}else IF($params['layout2'] == 'ALL' ){
				
				IF($params['daypart2'] <> 'ALL' ){
					
					$where_dp2 = " AND HOURS = '".$params['daypart2']."' ";
				}else{
					$where_dp2 = "";
				}
				
				$sql2 = "
				SELECT A.*, C.CHANNEL_NAME_PROG FROM (
				SELECT * FROM AUDIENCE_MINUTES WHERE DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND PROFILE_ID = ".$params['profile']."
				AND TVR IS NOT NULL
				AND TYPE = 'ALL' ".$where_dp2."
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				".$lmt." 
				
				) A LEFT JOIN CHANNEL_PARAM_FINAL C ON A.TYPE_NAME = C.CHANNEL_NAME
				ORDER BY ".$params['order_column']." ".$params['order_dir']."
				LIMIT ".$params['offset'].",".$limit_data;	
			
			}
			
		}
						
						
		//ECHO $sql2;DIE;				
    
		// $query2		= $this->db2->query($sql2);
		// $result2 = $query2->result_array();
		
		 $querys	= $db->select($sql2);
		  $result2 = $querys->rows();

		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
		
		return $return;
	}

	public function listchart_tvpc($params = array()) {	
				
				
				$sql		= 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ( SELECT CHANNEL_NAME FROM `CHANNEL_PARAM_FINAL` WHERE `CHANNEL_NAME_PROG` IN('.$params['channel'].') ) AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				AND BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
				AND END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
				AND TIME_PERIODE = "TVPC" 
				AND PROFILE_ID = '.$params['profile'].'
				ORDER BY '.$params['cgroup'].' DESC';
						
		$out		= array();
		
		$query		= $this->db2->query($sql);
		$result = $query->result_array();
		
		return $result;
	}
  
	public function list_tvpc_allviwers($params = array()) {	
		$sql = 'SELECT 
								SQL_CALC_FOUND_ROWS 
									
								COUNT(DISTINCT pm.USER_ID) AS all_viewers
							      FROM t_people_meter AS pm , t_epg AS epg
							      WHERE epg.channel = pm.channel
									DATE_FORMAT(epg.tanggal, "%Y-%m-%d") BETWEEN CAST("'.$params['start_date'].'" AS DATE) AND CAST("'.$params['end_date'].'" AS DATE)
									AND epg.date = DATE_FORMAT(pm.begin_session, "%Y-%m-%d")
									AND epg.user_id "'.$params['profile'].'"
									
							GROUP BY epg.start_time
							ORDER BY epg.start_time ASC';
     
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
		$total_filtered = $this->db2->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= $this->db2->query('SELECT COUNT(a.id) as total
											FROM t_people_meter a')->row_array();
		
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total['total'],
		);
		
		return $return;
	}
	
	public function universe($profile) {
		$query = "SELECT COUNT(pm.USER_ID) AS universe 
				FROM t_people_meter AS pm 
				WHERE pm.user_id"." ".$profile;
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
  }                                 
    
  public function profilesearch($strSearch,$iduser,$period){
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1]; 
      }
            
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
      $out		= array();
      $query		= $this->db2->query($sql);
      $result = $query->result_array();
      
      return $result;
  } 
  
  public function genresearch($strSearch,$role){ 
      $sql = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` IN (0,-99) AND GENRE LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`GENRE`";               
      $out		= array();
      $query		= $this->db2->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                          
    
  public function channelsearch($strSearch,$strGenre,$role){

      if($strGenre == "0"){
          $strWhere = "AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND GENRE = '".$strGenre."' AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%' ";
      }
      
	  
	   $sql = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS CHANNEL FROM  `CHANNEL_PARAM_FINAL` B  
	  WHERE B.`F2A_STATUS` in (0,-99) ".$strWhere."   ORDER BY CHANNEL_NAME_PROG ";  
	  
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }             
  
  public function checkdaypart($user_id,$daypart){ 
      $query 	= "SELECT COUNT(DAYPART1) AS CODAP FROM DAYPART WHERE USERID = '".$user_id."' AND DAYPART1 = '".$daypart."'";
            
      $sql	= $this->db2->query($query);
  		$this->db2->close();
  		$this->db2->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CODAP'];
  }                                 
  
  public function setdaypart($user_id,$start_time,$end_time){ 
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":00','0')";
            
      if ($sql) {
          $this->db2->query($sql);
          
          $query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$user_id.'" AND MENUS="0" ORDER BY DAYPART1 ';			
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