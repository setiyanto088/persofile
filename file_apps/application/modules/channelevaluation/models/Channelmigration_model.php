<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channelmigration_model extends CI_Model {
	
    public function __construct(){
        parent::__construct();
		//$this->db2 = $this->load->database('db_prod', TRUE);
    }
	
	public function get_tahun(){
		
		$query = "SELECT DISTINCT(TANGGAL)  TANGGAL FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL,'%Y-%M') DESC";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
    public function get_channel(){ 
		
		 $sql = "SELECT CHANNEL_NAME AS CHANNEL_CIM FROM `CHANNEL_PARAM` C
        WHERE C.`F2A_STATUS` IN (0,1) 
        ORDER BY C.`CHANNEL_NAME`";
        
        $out		= array();
        $query		= $this->db->query($sql);
        $result = $query->result_array();
        
        return $result;
    }	
		
  	public function get_profile3($iduser,$idrole,$period){
    		
                                                                      
        if($period == ""){
            $sPeriod = date('Y-m');     
        } else {
            $experiod = explode("/",$period);
            $sPeriod = $experiod[2]."-".$experiod[1];         
        }
        
        $sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
        
    		$out		= array();
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    			
    		return $result;
  	}
		
  	public function content_grouping($profile) {
    		$query = 'SELECT grouping
    				FROM t_profiling
    				WHERE id = '.$profile.'
    				AND STATUS = 1
            AND flag = 1;';  			
    		$sql	= $this->db2->query($query,array($profile));
    		$this->db2->close();
    		$this->db2->initialize(); 
    		return $sql->row_array();	   
  	}

  	public function get_userid($data) {
    		$query = "SELECT DISTINCT(USERID) FROM SINGLE_SOURCE_VALUE "." ".$data;
        
    		$sql	= $this->db2->query($query);
    		$this->db2->close();
    		$this->db2->initialize(); 	
    		return $sql->result_array();	   
  	}	
    
  	public function next_view($split, $channel){
    		$sql = " 	SELECT COUNT(CARDNO) VIEWER   
    				FROM M_SM_TEST_1JULY_V3 
    				WHERE  CHANNEL = '".$channel."'
    				AND SPLIT_MINUTES = '".$split."'
    				GROUP BY `DATE`,CHANNEL,SPLIT_MINUTES 
    				ORDER BY `DATE`,CHANNEL,SPLIT_MINUTES
    				";
    		$out		= array();
    		
    		$query		= $this->db2->query($sql);
    		$result = $query->result_array();
    		
    		return $result;
  	}	
	
  	public function list_program($param){                     
  			$sql = " 	SELECT CONCAT(PROGRAM, ' | ', BEGIN_PROGRAM) AS PROGRAM FROM `M_SUMM_MIGRATION_PTV`
  			WHERE DATE_FORMAT(`DATE`,'%Y-%m-%d') = '".$param['date']."' 
  			AND CHANNEL = '".$param['channel']."' 
			GROUP BY PROGRAM, BEGIN_PROGRAM
  			ORDER BY PROGRAM
  				";
    				
    		$out		= array();
    		
    		$query		= $this->db2->query($sql);
    		$result = $query->result_array();
    		
    		return $result;
  	}     
    
    public function current_date() {
  		$query = "SELECT DATE_FORMAT(CHANNEL_MIGRATION_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
      
  		$sql	= $this->db->query($query); 
  		$this->db->close();
  		$this->db->initialize(); 	
  		return $sql->result_array();	   
  	}
	
  	public function gain($split, $channel){
  		  $sql = " 	
    				SELECT GAIN.VIEWER AS GAIN,LOSS.VIEWER AS LOSS, 
    				CONT.CHANNEL AS CONT_CHANNEL, CONT.PROGRAM AS CONT_PROGRAM,
    				BEN.CHANNEL AS BEN_CHANNEL, BEN.PROGRAM AS BEN_PROGRAM 
    				FROM 
    				(
    					SELECT COUNT(CARDNO) VIEWER   
    					FROM M_SM_TEST_CM_V4 
    					WHERE  CHANNEL_BEFORE <> '".$channel."'
    					AND CHANNEL = '".$channel."' 
    					AND SPLIT_MINUTES = '".$split."' 
    				) GAIN,
    				(
    					SELECT COUNT(CARDNO) VIEWER   
    					FROM M_SM_TEST_CM_V4 
    					WHERE  CHANNEL_BEFORE = '".$channel."'
    					AND CHANNEL <> '".$channel."' 
    					AND SPLIT_MINUTES = '".$split."'
    				) LOSS,
    				(
    					SELECT CHANNEL_BEFORE AS CHANNEL, PROGRAM_BEFORE AS PROGRAM, MAX(VIEWER) FROM( 
    						SELECT CHANNEL_BEFORE, PROGRAM_BEFORE,COUNT(CARDNO) VIEWER    
    						FROM M_SM_TEST_CM_V4 
    						WHERE  CHANNEL_BEFORE <> '".$channel."'
    						AND CHANNEL = '".$channel."' 
    						AND SPLIT_MINUTES = '".$split."'
    						GROUP BY `DATE`,CHANNEL_BEFORE,PROGRAM,SPLIT_MINUTES  
    					) F					
    				) CONT,
    				(
    					SELECT  CHANNEL, PROGRAM, MAX(VIEWER) FROM(
    						SELECT CHANNEL, PROGRAM,COUNT(CARDNO) VIEWER   
    						FROM M_SM_TEST_CM_V4 
    						WHERE  CHANNEL_BEFORE = '".$channel."'
    						AND CHANNEL <> '".$channel."'  
    						AND SPLIT_MINUTES = '".$split."'
    						GROUP BY `DATE`,CHANNEL,PROGRAM_BEFORE,SPLIT_MINUTES  
    					) L					
    				) BEN 
    				";
                     
    		$out		= array();
    		
    		$query		= $this->db2->query($sql);
    		$result = $query->result_array();
    		
    		return $result;
  	}	
		
  	public function list_migration($params = array()){		

			
			
					
					$sql = ' SELECT A.*, B.* FROM `CHANNEL_EVALUATION` A
LEFT JOIN (SELECT * FROM `CHANNEL_PARAM_FINAL_EVAL` WHERE `F2A_STATUS` IN (0,-99) ) B
ON A.CHANNEL_NAME = B.`CHANNEL_NAME_PROG`
WHERE A.`PERIODE` = "'.$params['profiles'].'"
GROUP BY CHANNEL_NAME_PROG  
    				ORDER BY `RANK`
    				' ;
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
            if($l_result = mysqli_store_result($this->db->conn_id)){
                mysqli_free_result($l_result);
            }
    		}
    		
    		$total_filtered = count($result);
    		$total 			= count($result);
    		
    		if(($params['offset']+10) > $total_filtered){
            $limit_data = $total_filtered - $params['offset'];
    		}else{
            $limit_data = $params['limit'] ;
    		}
        

		
				$sql2		= ' SELECT A.*, B.* FROM `CHANNEL_EVALUATION` A
								LEFT JOIN (SELECT * FROM `CHANNEL_PARAM_FINAL_EVAL` WHERE `F2A_STATUS` IN (0,-99) ) B
								ON A.CHANNEL_NAME = B.`CHANNEL_NAME_PROG`
								WHERE A.`PERIODE` = "'.$params['profiles'].'"
								GROUP BY CHANNEL_NAME_PROG 
								ORDER BY `RANK`
								LIMIT '.$params['offset'].','.$limit_data;
		
        
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
  	}	
  
    public function list_chartmigration($params = array()){
		
		if($params['program'] == 'All Program'){
		
    		$sql		= ' SELECT * FROM M_SUMM_MIGRATION_PTV 
    				WHERE 
    				`DATE` = "'.$params['start_date'].'"
    				AND CHANNEL = "'.$params['channel'].'"
            AND ID_PROFILING = '.$params['profiles'].' 
    				ORDER BY `DATE`,SPLIT_MINUTES';
    		
		}else{
			
				$sql		= ' SELECT * FROM M_SUMM_MIGRATION_PTV 
    				WHERE 
    				`DATE` = "'.$params['start_date'].'"
    				AND CHANNEL = "'.$params['channel'].'"
    				AND PROGRAM = "'.$params['program'].'"
            AND BEGIN_PROGRAM = "'.$params['begin_program'].'"
            AND ID_PROFILING = '.$params['profiles'].' 
    				ORDER BY `DATE`,SPLIT_MINUTES';
			
		}
			
    		$out		= array();
    		
    		$query		= $this->db2->query($sql);
    		$result = $query->result_array();
    		
    		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
            if($l_result = mysqli_store_result($this->db2->conn_id)){
                mysqli_free_result($l_result);
            }
    		}
    		
    		$total_filtered = count($result);
    		$total 			= count($result);
        
			if($params['program'] == 'All Program'){
		
    		$sql2		= ' SELECT * FROM M_SUMM_MIGRATION_PTV 
    				WHERE 
    				`DATE` = "'.$params['start_date'].'"
    				AND CHANNEL = "'.$params['channel'].'"
    				
            AND ID_PROFILING = '.$params['profiles'].' 
    				ORDER BY `DATE`,SPLIT_MINUTES';
			
			}else{
				
					$sql2		= ' SELECT * FROM M_SUMM_MIGRATION_PTV 
    				WHERE 
    				`DATE` = "'.$params['start_date'].'"
    				AND CHANNEL = "'.$params['channel'].'"
    				AND PROGRAM = "'.$params['program'].'"
            AND BEGIN_PROGRAM = "'.$params['begin_program'].'"
            AND ID_PROFILING = '.$params['profiles'].' 
    				ORDER BY `DATE`,SPLIT_MINUTES';
				
			}
        
    		$query2		= $this->db2->query($sql2);
    		$result2 = $query2->result_array();
    		
    		return $result2;
  	}
  
    public function summ_tvr($params = array()){
		
			if($params['program'] == 'All Program'){
		
        $sql = 'SELECT H.*,START_TVR,END_TVR FROM  (
          SELECT AVG(TVR) AS AVG_TVR,SUM(GAIN) AS AVG_GAIN,SUM(LOSS) AS AVG_LOSS,
          MIN(SPLIT_MINUTES) AS MINSP, MAX(SPLIT_MINUTES) AS MAXSP FROM M_SUMM_MIGRATION_PTV 
          
          WHERE `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND ID_PROFILING = '.$params['profiles'].' 
          ORDER BY `DATE`,SPLIT_MINUTES
          ) H,
          (
          SELECT TVR AS START_TVR,SPLIT_MINUTES FROM M_SUMM_MIGRATION_PTV 
          
          WHERE `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND ID_PROFILING = '.$params['profiles'].' 
          ORDER BY `DATE`,SPLIT_MINUTES
          ) L,
          (
          SELECT TVR END_TVR,SPLIT_MINUTES FROM M_SUMM_MIGRATION_PTV 
          
          WHERE `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND ID_PROFILING = '.$params['profiles'].' 
          ORDER BY `DATE`,SPLIT_MINUTES
          ) K
          WHERE H.MINSP = L.SPLIT_MINUTES
          AND H.MAXSP = K.SPLIT_MINUTES
          ';
		
			}else{
				
 $sql = 'SELECT H.*,START_TVR,END_TVR FROM  (
          SELECT AVG(TVR) AS AVG_TVR,SUM(GAIN) AS AVG_GAIN,SUM(LOSS) AS AVG_LOSS,
          MIN(SPLIT_MINUTES) AS MINSP, MAX(SPLIT_MINUTES) AS MAXSP FROM M_SUMM_MIGRATION_PTV 
          
          WHERE `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND PROGRAM = "'.$params['program'].'" 
          AND ID_PROFILING = '.$params['profiles'].' 
          ORDER BY `DATE`,SPLIT_MINUTES
          ) H,
          (
          SELECT TVR AS START_TVR,SPLIT_MINUTES FROM M_SUMM_MIGRATION_PTV 
          
          WHERE `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND PROGRAM = "'.$params['program'].'" 
          AND ID_PROFILING = '.$params['profiles'].' 
          ORDER BY `DATE`,SPLIT_MINUTES
          ) L,
          (
          SELECT TVR END_TVR,SPLIT_MINUTES FROM M_SUMM_MIGRATION_PTV 
          
          WHERE `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND PROGRAM = "'.$params['program'].'" 
          AND ID_PROFILING = '.$params['profiles'].' 
          ORDER BY `DATE`,SPLIT_MINUTES
          ) K
          WHERE H.MINSP = L.SPLIT_MINUTES
          AND H.MAXSP = K.SPLIT_MINUTES
          ';
				
			}
        
        $query  = $this->db2->query($sql);
        $result = $query->result_array();
        
        return $result;
    }
    
    public function summ_beneficial($params = array()){
		
		if($params['program'] == 'All Program'){
		
        $sql = '	SELECT BEN_CHANNEL AS CHANNEL, BEN_PROGRAM AS PROGRAM, COUNT(PROGRAM) BEN FROM M_SUMM_MIGRATION_PTV 
          WHERE 
          `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          GROUP BY
          `DATE`,BEN_CHANNEL,BEN_PROGRAM,SPLIT_MINUTES  
          ORDER BY BEN DESC
          LIMIT 1';
		}else{
			
			 $sql = '	SELECT BEN_CHANNEL AS CHANNEL, BEN_PROGRAM AS PROGRAM, COUNT(PROGRAM) BEN FROM M_SUMM_MIGRATION_PTV 
          WHERE 
          `DATE` = "'.$params['start_date'].'"
          AND CHANNEL = "'.$params['channel'].'"
          AND PROGRAM = "'.$params['program'].'" 
          GROUP BY
          `DATE`,BEN_CHANNEL,BEN_PROGRAM,SPLIT_MINUTES  
          ORDER BY BEN DESC
          LIMIT 1';
			
		}
        
        $query  = $this->db2->query($sql);
        $result = $query->result_array();
        
        return $result;
    }
  
    public function summ_contributor($params = array()){
		
		if($params['program'] == 'All Program'){
		
        $sql = '	SELECT CONT_CHANNEL AS CHANNEL_BEFORE, CONT_PROGRAM AS PROGRAM_BEFORE, COUNT(PROGRAM) AS CON  FROM M_SUMM_MIGRATION_PTV 
        WHERE 
        `DATE` = "'.$params['start_date'].'"
        AND CHANNEL = "'.$params['channel'].'"
        GROUP BY
        `DATE`,CONT_CHANNEL,CONT_PROGRAM,SPLIT_MINUTES  
        ORDER BY CON DESC
        LIMIT 1';
		
		}else{
			
			  $sql = '	SELECT CONT_CHANNEL AS CHANNEL_BEFORE, CONT_PROGRAM AS PROGRAM_BEFORE, COUNT(PROGRAM) AS CON  FROM M_SUMM_MIGRATION_PTV 
			WHERE 
			`DATE` = "'.$params['start_date'].'"
			AND CHANNEL = "'.$params['channel'].'"
			AND PROGRAM = "'.$params['program'].'" 
			GROUP BY
			`DATE`,CONT_CHANNEL,CONT_PROGRAM,SPLIT_MINUTES  
			ORDER BY CON DESC
			LIMIT 1';
			
		}
        
        $query  = $this->db2->query($sql);
        $result = $query->result_array();
        
        return $result;
    }
  
    public function list_migration_sub($params = array()){
  		
  		$sql = ' SELECT CHANNEL,PROGRAM,TVR,GAIN,LOSS FROM M_SUMM_MIGRATION_PTV 
  				WHERE 
  				`DATE` = "'.$params['start_date'].'"
          AND ID_PROFILING = '.$params['profiles'].' 
          GROUP BY `DATE`,CHANNEL,PROGRAM	
  				ORDER BY `DATE`,SPLIT_MINUTES, TVR DESC,GAIN DESC,LOSS DESC
  				';		                              
  		
  		$out		= array();
  		
  		$query		= $this->db2->query($sql);
  		$result = $query->result_array();
  		
  		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
          if($l_result = mysqli_store_result($this->db2->conn_id)){
              mysqli_free_result($l_result);
          }
  		}
  		
  		$total_filtered = count($result);
  		$total 			= count($result);
  		
  		if(($params['offset']+10) > $total_filtered){
          $limit_data = $total_filtered - $params['offset'];
  		}else{
          $limit_data = $params['limit'] ;
  		}
      
  		$sql2		= '	SELECT CHANNEL,PROGRAM,TVR,GAIN,LOSS FROM M_SUMM_MIGRATION_PTV 
  		WHERE 
  		`DATE` = "'.$params['start_date'].'"
      AND ID_PROFILING = '.$params['profiles'].'
      GROUP BY `DATE`,CHANNEL,PROGRAM
  		ORDER BY `DATE`,SPLIT_MINUTES, TVR DESC,GAIN DESC,LOSS DESC 
  			LIMIT '.$params['offset'].','.$limit_data;
      
  		$query2		= $this->db2->query($sql2);
  		$result2 = $query2->result_array();
  		
  		$return = array(
  			'data' => $result2,
  			'total_filtered' => $total_filtered,
  			'total' => $total
  		);
  		
  		return $return;
  	}	      
    
    function listsearch($sprog,$sdate,$scha,$sprof,$srole){ 
        $query2 = " 	SELECT CONCAT(PROGRAM, ' | ', BEGIN_PROGRAM) AS PROGRAM FROM `M_SUMM_MIGRATION_PTV`
        WHERE DATE_FORMAT(`DATE`,'%Y-%m-%d') = '".$sdate."' 
        AND CHANNEL = '".$scha."' AND ID_PROFILING = '".$sprof."' AND PROGRAM LIKE '%".$sprog."%'
        GROUP BY PROGRAM, BEGIN_PROGRAM
        ORDER BY PROGRAM
        ";
        $sql2	= $this->db2->query($query2); 
        $this->db2->close();	   
        $hasil2 = $sql2->result_array();
        
        return $hasil2;
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
    
    public function channelsearch($strSearch,$role){ 
        $sql = "SELECT CHANNEL_NAME AS CHANNEL_CIM FROM `CHANNEL_PARAM` C
        WHERE C.`FLAG_TV` = 1 AND CHANNEL_NAME LIKE '%".strtoupper($strSearch)."%'  
        ORDER BY C.`CHANNEL_NAME`";
        $out		= array();
        $query		= $this->db2->query($sql);
        $result = $query->result_array();
        
        return $result;
    } 
}	