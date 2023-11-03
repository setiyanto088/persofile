<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Audience_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		//$this->db2 = $this->load->database('db_prod', TRUE);
		$this->load->library('ClickHouse');
		
	}
	
	 function listsearch($sprog,$sdate,$enddate,$scha,$srole){  	
	 
	 $db = $this->clickhouse->db();
	 
	
        $query2 = "SELECT PROGRAM FROM `CDR_EPG_RES_ALL_STEP2_2021`
  			WHERE `BEGIN_PROGRAM` BETWEEN '".$sdate." 00:00:00' AND '".$enddate." 23:59:59' 
  			AND CHANNEL = '".$scha."' AND PROGRAM LIKE '%".strtoupper($sprog)."%'
			GROUP BY PROGRAM
  			ORDER BY PROGRAM";
	 
		
		$result = $db->select($query2);
		$hasil2 = $result->rows();	  
		
        
        return $hasil2;
  	} 
	
	
	public function tree1(){
		
		$db = $this->clickhouse->db();
		$query = "SELECT A.*,B.`FIELD` AS PARENTFIELD, B.DEFAULT AS PARENTDEFAULT FROM `TREE_PROFILING_RES_P22` A LEFT JOIN `TREE_PROFILING_RES_P22` B
		ON A.`PARENTID` = B.`ID`
		WHERE A.`STATUS_TREE` = '1'
		ORDER BY A.`PARENTID`,A.`SEQUENCE`,A.`LABEL`  ";
		
		
		$result = $db->select($query);
		return $result->rows();		

		
	}		
	
	public function list_sps($query){
		
			$db = $this->clickhouse->db();

		$result = $db->select($query);
		return $result->rows();	
		
	}		
	
	
	public function get_prof($ssss){
		
		 $db = $this->clickhouse->db();
		
			
		$query = "
			SELECT A.*,B.`FIELD`,B.VALUE AS PRNT FROM `TREE_PROFILING_RES_P22` A
			JOIN (SELECT * FROM `TREE_PROFILING_RES_P22` ) B ON A.PARENTID = B.ID
			WHERE A.`VALUE` = '".$ssss."'
			AND A.`FIELD` = 'kabkot'
		";
		
		
		
		$result = $db->select($query);
		return $result->rows();	
		
	}	
	
	 function list_program($param){  	
	 
	 
		$db = $this->clickhouse->db();
		
		if($param['date'] == $param['dateend']){
	 
			$query2 = "SELECT PROGRAM FROM `M_SUM_TV_DASH_PROG_DAY_RES`
  			WHERE `DATE` = '".$param['date']."' 
  			AND CHANNEL = '".$param['channel']."'
			AND DATA_TYPE = 'AUDIENCE_S'
			GROUP BY PROGRAM
			ORDER BY PROGRAM";       
			
		}else{
			
			$query2 = "SELECT PROGRAM FROM `M_SUM_TV_DASH_PROG_DAY_RES`
  			WHERE `DATE` BETWEEN '".$param['date']."' AND '".$param['dateend']."' 
  			AND CHANNEL = '".$param['channel']."'
			AND DATA_TYPE = 'AUDIENCE_S'
			GROUP BY PROGRAM
			ORDER BY PROGRAM";       
			
		}
		
		$result = $db->select($query2);
		return $result->rows();	  
        
  	} 
	
	 public function get_channel(){       
		
		
		
		 $sql = "SELECT CHANNEL AS CHANNEL_CIM, CHANNEL AS CHANNEL_CDR FROM `M_SUM_TV_DASH_CHAN_RES` C
		 GROUP BY CHANNEL
        ORDER BY C.`CHANNEL`";
        
        $out		= array();
        $query		= $this->db->query($sql);
        $result = $query->result_array();
        
        return $result;
    }	
	
	 public function get_profile_detail($id_profile){       

		
		 $sql = "SELECT * FROM t_profiling_ub_res WHERE id = '".$id_profile."'";
        
        $out		= array();
        $query		= $this->db2->query($sql);
        $result = $query->result_array();
        
        return $result;
    }	
	
	
	public function get_last_param($tag,$dataq){       

		
		 $sql = "  
                    SELECT * FROM `TREE_PROFILING_RES_P22`
                    WHERE `FIELD` = '".$tag."'
                    AND `VALUE` = '".$dataq."'
		
		";
        
        $out		= array();
        $query		= $this->db2->query($sql);
        $result = $query->result_array();
        
        return $result;
    }	
	
	public function list_profile($id) {
      $query = 'SELECT  * ,a.id as idprofile FROM t_profiling_ub_res a WHERE (status = 1 or status = 3) AND user_id_profil IN('.$id.',0)
                    ORDER BY a.`user_id_profil` ASC,status_job DESC, date_process DESC , name ASC';  	
		
		
      $sql	= $this->db->query($query);
      $this->db->close();
      $this->db->initialize(); 
      return $sql->result_array();	   
	}
	
	public function test_new() {
      $query = 'SELECT val_int FROM T_PARAM_UNICS where name = "UNIVERSE_CDR_MAR18" ';  			
      $sql	= $this->db->query($query);
      $this->db->close();
      $this->db->initialize(); 
      return $sql->result_array();	      
	}     
	
	public function list_channel() {
      $query = 'SELECT DISTINCT(channel) FROM CGI;';  			
      $sql	= $this->db->query($query);
      $this->db->close();
      $this->db->initialize(); 
      return $sql->result_array();	   
	}                         
  
  public function list_daypart($userid) {
		$query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$userid.'" AND MENUS="0" ORDER BY DAYPART1 ';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(AUDIENCE_FTA,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
	
	public function get_listid($param,$newdata){
      $datain =  '';
      $text = 'WHERE ';
      $text .= '';
      $kota1='';
      $helix1='';
      $addgroup1 = '';
      $demgender1 = '';
      $digitalsegment1 = '';
      $sessegment1 = '';
      $householdprofile1 = '';
      $katdevice1 = '';
      $katarpu1 = '';
      
      $demo1 = '';
      
      if ($newdata[2]=='GEOGRAFI') {
          $kota1 .= "'".$newdata[0]."'".", ";
      }elseif($newdata[2]=='DEMOGRAFI'){
          $demo1 .= "'".$newdata[0]."'".", ";
          
          if($newdata[1]=='AGE_GROUP'){
              $addgroup1 .= "'".$newdata[0]."'".", ";	
          }elseif($newdata[1]=='GENDER'){
              $demgender1 .= "'".$newdata[0]."'".", ";
          }elseif($newdata[1]=='DIGITAL_SEGMENT'){
              $digitalsegment1 .= "'".$newdata[0]."'".", ";
          }elseif($newdata[1]=='SES_SEGMENT'){
              $sessegment1 .= "'".$newdata[0]."'".", ";
          }elseif($newdata[1]=='HOUSEHOLD_PROFILE'){
              $householdprofile1 .= "'".$newdata[0]."'".", ";
          }elseif($newdata[1]=='HOUSEHOLD_COMM_EXPENSE'){
              $katarpu1 .= "'".$newdata[0]."'".", ";
          }   
      }else{
          $helix1 .= "'".$newdata[0]."'".", ";						
      }        
      
      $kota = substr($kota1, 0, -2);
      $helix = substr($helix1, 0, -2);
      $addgroup = substr($addgroup1,0,-2);
      $demgender = substr($demgender1,0,-2);
      $digitalsegment = substr($digitalsegment1,0,-2);
      $sessegment = substr($sessegment1,0,-2);
      $householdprofile = substr($householdprofile1,0,-2);
      $katdevice = substr($katdevice1,0,-2);
      $katarpu = substr($katarpu1,0,-2);
      $demo = substr($demo1,0,-2);
      $kota = 'KOTA_CLEAN IN('.$kota.') AND';
      $helix = 'PERSONAS_TRIM IN('.$helix.') AND';
      $addgroup = 'AGE_GROUP IN('.$addgroup.') AND';
      $demgender = 'DEM_GENDER_PRED IN('.$demgender.') AND';
      $digitalsegment = 'DIGITAL_SEGMENT IN('.$digitalsegment.') AND';
      $sessegment = 'SES_SEGMENT IN('.$sessegment.') AND';
      $householdprofile = 'HOUSEHOLD_PROFILE IN('.$householdprofile.') AND';
      $katdevice = 'KAT_DEVICE IN('.$katdevice.') AND';
      $katarpu = 'KAT_ARPU IN('.$katarpu.') AND';		
      
      $textwhere = '';
      
      if ($kota1 !=='') {
          $textwhere = $textwhere.' '.$kota;
      }
      if ($helix1 !=='') {
          $textwhere = $textwhere.' '.$helix;
      }
      if ($addgroup1 !=='') {
          $textwhere = $textwhere.' '.$addgroup;
      }
      if ($demgender1 !=='') {
          $textwhere = $textwhere.' '.$demgender;
      }
      if ($digitalsegment1 !=='') {
          $textwhere = $textwhere.' '.$digitalsegment;
      }
      if ($sessegment1 !=='') {
          $textwhere = $textwhere.' '.$sessegment;
      }
      if ($householdprofile1 !=='') {
          $textwhere = $textwhere.' '.$householdprofile;
      }
      if ($katdevice1 !=='') {
          $textwhere = $textwhere.' '.$katdevice;
      }
      if ($katarpu1 !=='') {
          $textwhere = $textwhere.' '.$katarpu;
      }
      
      $a = '"';
      
      $queryid = "SELECT `NO` FROM M_SINGLE_SOURCE_BARU b LEFT JOIN `NEW_PROFILE_TEMP` c
      ON b.`NCLI` = c.NCLI  ".$text.$textwhere;
      
      $queryid = substr($queryid,0,-3);
      
      return $queryid;
	}
	
	public function get_userid($data) {
      $query = "SELECT UserID	FROM t_single_source"." ".$data;
      $sql	= $this->db->query($query);
      $this->db->close();
      $this->db->initialize(); 	
      return $sql->result_array();	   
	}	
	
	
				public function list_chart_audience_web($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'WEB_INTEREST'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'WEB_INTEREST'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'WEB_INTEREST'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
				
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
			public function list_chart_audience_ses($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'SES_SEGMENT'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'SES_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'SES_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";

				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
			public function list_chart_audience_arpu($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'KAT_ARPU'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'KAT_ARPU'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'KAT_ARPU'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
			public function list_chart_audience_house($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'HOUSEHOLD_PROFILE'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'HOUSEHOLD_PROFILE'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'HOUSEHOLD_PROFILE'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}

		public function list_chart_audience_digi($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'DIGITAL_SEGMENT'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'DIGITAL_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'DIGITAL_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
		public function list_chart_audience_age($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'AGE_GROUP'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'AGE_GROUP'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'AGE_GROUP'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
					
				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
		public function list_chart_audience_gender($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'DEM_GENDER_PRED'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'DEM_GENDER_PRED'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'DEM_GENDER_PRED'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
	public function list_chart_audience_personas($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'PERSONAS'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'PERSONAS'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'PERSONAS'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
		public function list_chart_audience_comm($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'HELIX_COMM'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'HELIX_COMM'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'HELIX_COMM'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
				
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
	
	public function list_chart_audience_city($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'KOTA'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'KOTA'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'KOTA'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
					
				}				
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
	public function list_chart_audience($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'PROVINSI'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT 15";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'PROVINSI'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'PROVINSI'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT 15
					";
				}
				
			}
    		
    		$out		= array();
    		
    		$query		= $this->db->query($sql);
    		$result = $query->result_array();
    		
    		$return = array(
    			'data' => $result
    		);
    		
    		return $return;

	
	}
	
	
	public function list_audience_comm($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'HELIX_COMM'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'HELIX_COMM'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'HELIX_COMM'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}
			}
    		
			
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'HELIX_COMM'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'HELIX_COMM'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'HELIX_COMM'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	public function list_audience_persona($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'PERSONAS'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'PERSONAS'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'PERSONAS'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}				
			}
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'PERSONAS'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'PERSONAS'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'PERSONAS'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}
				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	
	
	public function list_audience_ses($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'SES_SEGMENT'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'SES_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'SES_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}
				
			}
			
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'SES_SEGMENT'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'SES_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'SES_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	
	public function list_audience_web($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND SEGMENT <> 'NULL'
				AND FIELD = 'WEB_INTEREST'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND SEGMENT <> 'NULL'
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'WEB_INTEREST'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND SEGMENT <> 'NULL'
					AND FIELD = 'WEB_INTEREST'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}
			}
			
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND SEGMENT <> 'NULL'
				AND FIELD = 'WEB_INTEREST'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND SEGMENT <> 'NULL'
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'WEB_INTEREST'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND SEGMENT <> 'NULL'
					AND FIELD = 'WEB_INTEREST'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
			public function list_audience_arpu($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'KAT_ARPU'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'KAT_ARPU'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'KAT_ARPU'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}				
			}
			
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'KAT_ARPU'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'KAT_ARPU'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'KAT_ARPU'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	
	
		public function list_audience_house($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'HOUSEHOLD_PROFILE'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'HOUSEHOLD_PROFILE'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'HOUSEHOLD_PROFILE'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}				
			}
			
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'HOUSEHOLD_PROFILE'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'HOUSEHOLD_PROFILE'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'HOUSEHOLD_PROFILE'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	
	public function list_audience_digi($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'DIGITAL_SEGMENT'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'DIGITAL_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'DIGITAL_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}				
			}
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'DIGITAL_SEGMENT'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'DIGITAL_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'DIGITAL_SEGMENT'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	public function list_audience_age($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'AGE_GROUP'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'AGE_GROUP'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'AGE_GROUP'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}				
			}
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'AGE_GROUP'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'AGE_GROUP'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'AGE_GROUP'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}
				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	public function list_audience_gender($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'DEM_GENDER_PRED'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'DEM_GENDER_PRED'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'DEM_GENDER_PRED'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";

				}
			}
			
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'DEM_GENDER_PRED'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'DEM_GENDER_PRED'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'DEM_GENDER_PRED'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}				
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	public function list_audience_city($params = array()) {	
	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "
				SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS, AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'KOTA'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql = "
					SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'KOTA'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "
					SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'KOTA'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}				
			}
    		
			
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "
				SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'KOTA'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "
					SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'KOTA'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "
					SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'KOTA'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}
			}
		
		
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	

	
	}
	
	public function list_audience($params = array()) {	
	
	
		$program_s = explode(",",$params['programsss']);
	
	
	
			if($program_s[0] == "ALL" ){
				
				$sql = "
				SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'PROVINSI'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC";
				
				
			}else{
				
				if($params['start_date'] == $params['end_date']){
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'PROVINSI'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}else{
					$sql = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'PROVINSI' 
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC";
				}
				
				
				
			}
    		
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
        
		
			if($program_s[0] == "ALL" ){
				
				$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
				SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
				WHERE `DATE` BETWEEN '".$params['start_date']."' 
				AND '".$params['end_date']."' 
				AND CHANNEL = '".$params['channel']."'
				AND PROGRAM = 'ALL'
				AND SEGMENT <> ''
				AND FIELD = 'PROVINSI'
				)G GROUP BY SEGMENT
				ORDER BY VIEWERS DESC
				LIMIT ".$params['offset'].",".$limit_data;
				
				
			}else{
				if($params['start_date'] == $params['end_date']){
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$program_s[0]."'
					AND SEGMENT <> ''
					AND START_PROGRAM = '".$program_s[1]."'
					AND FIELD = 'PROVINSI'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}else{
					$sql2 = "SELECT FIELD,SEGMENT,SUM(VIEWERS) AS VIEWERS,AVG(VIEWERS) VIEWERS_DAY FROM(
					SELECT `DATE`,FIELD, SEGMENT,VIEWERS  FROM `M_SUMMARY_AUDIENCE_N_PTV`
					WHERE `DATE` BETWEEN '".$params['start_date']."' 
					AND '".$params['end_date']."' 
					AND CHANNEL = '".$params['channel']."'
					AND PROGRAM = '".$params['programsss']."'
					AND SEGMENT <> ''
					AND FIELD = 'PROVINSI'
					)G GROUP BY SEGMENT
					ORDER BY VIEWERS DESC
					LIMIT ".$params['offset'].",".$limit_data;
				}
			}
		
		
        
    		$query2		= $this->db->query($sql2);
    		$result2 = $query2->result_array();
    		
    		$return = array(
    			'data' => $result2,
    			'total_filtered' => $total_filtered,
    			'total' => $total
    		);
    		
    		return $return;
	
	
	
	
			
			
			
			
			
	
		
        
	
	}
	
	public function list_audience2($params = array(),$list_id,$HELIX_PROF) {		
      $tvs=$params['tvs'];
      $tvr=$params['tvr'];
      $viewers=$params['viewers'];
	  
	  if($HELIX_PROF[2] == "GEOGRAFI" ){
		  
		  $profile =  'SELECT CARDNO FROM `M_SINGLE_SOURCE_BARU18` WHERE  KOTA = "'.$HELIX_PROF[0].'" ';
		  
	  }elseif($HELIX_PROF[2] == "HELIX PERSONAS" ){
		  
		   $profile =  'SELECT CARDNO FROM `M_SINGLE_SOURCE_BARU18` WHERE PERSONAS = "'.$HELIX_PROF[0].'" ';
	 
	 }else{              
		  
		  $profile = 'SELECT CARDNO FROM `M_SINGLE_SOURCE_BARU18` WHERE '.$HELIX_PROF[1].' = "'.$HELIX_PROF[0].'" ';
	 }
	  
	  
		$date=date_create($params['start_date']);
		$pt = strtoupper(date_format($date,"yM")); 
		
		if($pt == "18JAN"){
			$pt = "18JANN";
			
		} 
	  
      
     if ($tvs==1) {
			$sql2='
			SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,
			MAX(NET) AS NET,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
			SELECT 
			 CASE WHEN channel="ANTV" THEN ROUND(TVR,2) ELSE 0 END ANTV,
			 CASE WHEN channel="IVM" THEN ROUND(TVR,2) ELSE 0 END IVM,
			 CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,2) ELSE 0 END KOMPASTV,
			 CASE WHEN channel="METRO" THEN ROUND(TVR,2) ELSE 0 END METRO,
			 CASE WHEN channel="OCHNL" THEN ROUND(TVR,2) ELSE 0 END OCHNL,
			 CASE WHEN channel="NET" THEN ROUND(TVR,2) ELSE 0 END NET,
			 CASE WHEN channel="RTV" THEN ROUND(TVR,2) ELSE 0 END RTV,
			 CASE WHEN channel="SCTV" THEN ROUND(TVR,2) ELSE 0 END SCTV,
			 CASE WHEN channel="TRANS" THEN ROUND(TVR,2) ELSE 0 END TRANS,
			 CASE WHEN channel="TRANS7" THEN ROUND(TVR,2) ELSE 0 END TRANS7,
			 CASE WHEN channel="TVONE" THEN ROUND(TVR,2) ELSE 0 END TVONE,
			 CASE WHEN channel="TVRI" THEN ROUND(TVR,2) ELSE 0 END TVRI
			FROM (
				SELECT CHANNEL as channel, AVG(TVS) AS TVR FROM `M_SUMMARY_AUDIENCE_15_FTA` 
				WHERE SEGMENT = "'.$HELIX_PROF[0].'"
				AND `DATE` = "'.$params['start_date'].'"
				AND M1_START >= "'.$params['starttime'].'" AND M1_END <= "'.$params['endtime'].'" 
				GROUP BY CHANNEL
				ORDER BY CHANNEL 
			) KK 
)LL';
					
		} else if($tvr==1) {
			$sql2='
		SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,
			MAX(NET) AS NET,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
			SELECT 
			 CASE WHEN channel="ANTV" THEN ROUND(TVR,2) ELSE 0 END ANTV,
			 CASE WHEN channel="IVM" THEN ROUND(TVR,2) ELSE 0 END IVM,
			 CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,2) ELSE 0 END KOMPASTV,
			 CASE WHEN channel="METRO " THEN ROUND(TVR,2) ELSE 0 END METRO,
			 CASE WHEN channel="OCHNL" THEN ROUND(TVR,2) ELSE 0 END OCHNL,
			 CASE WHEN channel="NET" THEN ROUND(TVR,2) ELSE 0 END NET,
			 CASE WHEN channel="RTV" THEN ROUND(TVR,2) ELSE 0 END RTV,
			 CASE WHEN channel="SCTV" THEN ROUND(TVR,2) ELSE 0 END SCTV,
			 CASE WHEN channel="TRANS" THEN ROUND(TVR,2) ELSE 0 END TRANS,
			 CASE WHEN channel="TRANS7" THEN ROUND(TVR,2) ELSE 0 END TRANS7,
			 CASE WHEN channel="TVONE" THEN ROUND(TVR,2) ELSE 0 END TVONE,
			 CASE WHEN channel="TVRI" THEN ROUND(TVR,2) ELSE 0 END TVRI
			FROM (
				SELECT CHANNEL as channel, AVG(TVR) AS TVR FROM `M_SUMMARY_AUDIENCE_15_FTA` 
				WHERE SEGMENT = "'.$HELIX_PROF[0].'"
				AND `DATE` = "'.$params['start_date'].'"
				AND M1_START >= "'.$params['starttime'].'" AND M1_END <= "'.$params['endtime'].'" 
				GROUP BY CHANNEL
				ORDER BY CHANNEL 
			) KK 
)LL';
		}else {
			$sql2		= '
			SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,
			MAX(NET) AS NET,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
			SELECT 
			 CASE WHEN channel="ANTV" THEN ROUND(TVR,0) ELSE 0 END ANTV,
			 CASE WHEN channel="IVM" THEN ROUND(TVR,0) ELSE 0 END IVM,
			 CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,0) ELSE 0 END KOMPASTV,
			 CASE WHEN channel="METRO" THEN ROUND(TVR,0) ELSE 0 END METRO,
			 CASE WHEN channel="OCHNL" THEN ROUND(TVR,0) ELSE 0 END OCHNL,
			 CASE WHEN channel="NET" THEN ROUND(TVR,0) ELSE 0 END NET,
			 CASE WHEN channel="RTV" THEN ROUND(TVR,0) ELSE 0 END RTV,
			 CASE WHEN channel="SCTV" THEN ROUND(TVR,0) ELSE 0 END SCTV,
			 CASE WHEN channel="TRANS" THEN ROUND(TVR,0) ELSE 0 END TRANS,
			 CASE WHEN channel="TRANS7" THEN ROUND(TVR,0) ELSE 0 END TRANS7,
			 CASE WHEN channel="TVONE" THEN ROUND(TVR,0) ELSE 0 END TVONE,
			 CASE WHEN channel="TVRI" THEN ROUND(TVR,0) ELSE 0 END TVRI
			FROM (
				SELECT CHANNEL as channel, AVG(VIEWERS) AS TVR FROM `M_SUMMARY_AUDIENCE_15_FTA` 
				WHERE SEGMENT = "'.$HELIX_PROF[0].'"
				AND `DATE` = "'.$params['start_date'].'"
				AND M1_START >= "'.$params['starttime'].'" AND M1_END <= "'.$params['endtime'].'" 
				GROUP BY CHANNEL
				ORDER BY CHANNEL 
			) KK 
)LL';
		}
      
            
      $query2		= $this->db->query($sql2);
      $result2 = $query2->result_array();
      $return = array(
          'data' => $result2,
      );
      
      return $return;
	}

	
	public function list_chart_audience2($params = array(),$list_id,$HELIX_PROF) { 
      $tvs=$params['tvs'];
      $tvr=$params['tvr'];
      $viewers=$params['viewers'];	
      
      if ($tvs==1) {
          $sql2='
          SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(GTV) AS GTV,MAX(INEWSTV) AS INEWSTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,MAX(MNCTV) AS MNCTV,
          MAX(NET) AS NET,MAX(RCTI) AS RCTI,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
          SELECT 
          CASE WHEN channel="ANTV" THEN ROUND(TVR,2) ELSE 0 END ANTV,
          CASE WHEN channel="GTV" THEN ROUND(TVR,2) ELSE 0 END GTV,
          CASE WHEN channel="INEWSTV" THEN ROUND(TVR,2) ELSE 0 END INEWSTV,
          CASE WHEN channel="IVM" THEN ROUND(TVR,2) ELSE 0 END IVM,
          CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,2) ELSE 0 END KOMPASTV,
          CASE WHEN channel="METRO" THEN ROUND(TVR,2) ELSE 0 END METRO,
          CASE WHEN channel="MNCTV" THEN ROUND(TVR,2) ELSE 0 END MNCTV,
          CASE WHEN channel="OCHNL" THEN ROUND(TVR,2) ELSE 0 END OCHNL,
          CASE WHEN channel="NET" THEN ROUND(TVR,2) ELSE 0 END NET,
          CASE WHEN channel="RCTI" THEN ROUND(TVR,2) ELSE 0 END RCTI,
          CASE WHEN channel="RTV" THEN ROUND(TVR,2) ELSE 0 END RTV,
          CASE WHEN channel="SCTV" THEN ROUND(TVR,2) ELSE 0 END SCTV,
          CASE WHEN channel="TRANS" THEN ROUND(TVR,2) ELSE 0 END TRANS,
          CASE WHEN channel="TRANS7" THEN ROUND(TVR,2) ELSE 0 END TRANS7,
          CASE WHEN channel="TVONE" THEN ROUND(TVR,2) ELSE 0 END TVONE,
          CASE WHEN channel="TVRI" THEN ROUND(TVR,2) ELSE 0 END TVRI
          FROM (
          SELECT CHN.*, ALL_VIEWERS,  
          (VIEWERS/ALL_VIEWERS)*100 AS TVR FROM (
          
          SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS FROM `M_SUMMARY_MEDIAPLAN`
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          AND CARDNO IN('.$list_id.')
          GROUP BY CHANNEL
          ) CHN,
          (
          SELECT COUNT(DISTINCT(CARDNO)) ALL_VIEWERS FROM `M_SUMMARY_MEDIAPLAN` A 
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          
          
          ) AS ALL_VIEWERS
          ) KK 
          )LL';
      } else if($tvr==1) {
          $sql2='SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(GTV) AS GTV,MAX(INEWSTV) AS INEWSTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,MAX(MNCTV) AS MNCTV,
          MAX(NET) AS NET,MAX(RCTI) AS RCTI,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
          SELECT 
          CASE WHEN channel="ANTV" THEN ROUND(TVR,2) ELSE 0 END ANTV,
          CASE WHEN channel="GTV" THEN ROUND(TVR,2) ELSE 0 END GTV,
          CASE WHEN channel="INEWSTV" THEN ROUND(TVR,2) ELSE 0 END INEWSTV,
          CASE WHEN channel="IVM" THEN ROUND(TVR,2) ELSE 0 END IVM,
          CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,2) ELSE 0 END KOMPASTV,
          CASE WHEN channel="METRO" THEN ROUND(TVR,2) ELSE 0 END METRO,
          CASE WHEN channel="MNCTV" THEN ROUND(TVR,2) ELSE 0 END MNCTV,
          CASE WHEN channel="OCHNL" THEN ROUND(TVR,2) ELSE 0 END OCHNL,
          CASE WHEN channel="NET" THEN ROUND(TVR,2) ELSE 0 END NET,
          CASE WHEN channel="RCTI" THEN ROUND(TVR,2) ELSE 0 END RCTI,
          CASE WHEN channel="RTV" THEN ROUND(TVR,2) ELSE 0 END RTV,
          CASE WHEN channel="SCTV" THEN ROUND(TVR,2) ELSE 0 END SCTV,
          CASE WHEN channel="TRANS" THEN ROUND(TVR,2) ELSE 0 END TRANS,
          CASE WHEN channel="TRANS7" THEN ROUND(TVR,2) ELSE 0 END TRANS7,
          CASE WHEN channel="TVONE" THEN ROUND(TVR,2) ELSE 0 END TVONE,
          CASE WHEN channel="TVRI1" THEN ROUND(TVR,2) ELSE 0 END TVRI
          FROM (
          SELECT CHN.*, ALL_VIEWERS,  
          (VIEWERS/ALL_VIEWERS)*100 AS TVR FROM (
          
          SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS FROM `M_SUMMARY_MEDIAPLAN`
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          AND CARDNO IN('.$list_id.')
          GROUP BY CHANNEL
          ) CHN,
          (
          SELECT COUNT(DISTINCT(CARDNO)) ALL_VIEWERS FROM NEW_CDR_LIVE_CLEAN_CS 
          WHERE CARDNO IN('.$list_id.')
          
          ) AS ALL_VIEWERS
          ) KK 
          )LL';
      }else {
          $sql2		= 'SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(GTV) AS GTV,MAX(INEWSTV) AS INEWSTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,MAX(MNCTV) AS MNCTV,
          MAX(NET) AS NET,MAX(RCTI) AS RCTI,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
          SELECT 
          CASE WHEN channel="ANTV" THEN ROUND(TVR,0) ELSE 0 END ANTV,
          CASE WHEN channel="GTV" THEN ROUND(TVR,0) ELSE 0 END GTV,
          CASE WHEN channel="INEWSTV" THEN ROUND(TVR,0) ELSE 0 END INEWSTV,
          CASE WHEN channel="IVM" THEN ROUND(TVR,0) ELSE 0 END IVM,
          CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,0) ELSE 0 END KOMPASTV,
          CASE WHEN channel="METRO" THEN ROUND(TVR,0) ELSE 0 END METRO,
          CASE WHEN channel="MNCTV" THEN ROUND(TVR,0) ELSE 0 END MNCTV,
          CASE WHEN channel="OCHNL" THEN ROUND(TVR,0) ELSE 0 END OCHNL,
          CASE WHEN channel="NET" THEN ROUND(TVR,0) ELSE 0 END NET,
          CASE WHEN channel="RCTI" THEN ROUND(TVR,0) ELSE 0 END RCTI,
          CASE WHEN channel="RTV" THEN ROUND(TVR,0) ELSE 0 END RTV,
          CASE WHEN channel="SCTV" THEN ROUND(TVR,0) ELSE 0 END SCTV,
          CASE WHEN channel="TRANS" THEN ROUND(TVR,0) ELSE 0 END TRANS,
          CASE WHEN channel="TRANS7" THEN RUND(TVR,0) ELSE 0 END TRANS7,
          CASE WHEN channel="TVONE" THEN ROUND(TVR,0) ELSE 0 END TVONE,
          CASE WHEN channel="TVRI1" THEN ROUND(TVR,0) ELSE 0 END TVRI
          FROM (
          SELECT CHN.*, 
          (VIEWERS) AS TVR FROM (
          
          SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS FROM `M_SUMMARY_MEDIAPLAN`
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          AND CARDNO IN('.$list_id.')
          GROUP BY CHANNEL
          ) CHN
          ) KK 
          )LL';
      }
     
      
      $query2		= $this->db->query($sql2);
      $result2 = $query2->result_array();
      $return = array(
          'data' => $result2,
      );
      
      return $return;
	}
	
	
	public function list_chart_audience3($params = array(),$list_id,$HELIX_PROF) {
      $tvs=$params['tvs'];
      $tvr=$params['tvr'];
      $viewers=$params['viewers'];	
      
      if ($tvs==1) {
          $sql2='
          SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(GTV) AS GTV,MAX(INEWSTV) AS INEWSTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,MAX(MNCTV) AS MNCTV,
          MAX(NET) AS NET,MAX(RCTI) AS RCTI,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
          SELECT 
          CASE WHEN channel="ANTV" THEN ROUND(TVR,2) ELSE 0 END ANTV,
          CASE WHEN channel="GTV" THEN ROUND(TVR,2) ELSE 0 END GTV,
          CASE WHEN channel="INEWSTV" THEN ROUND(TVR,2) ELSE 0 END INEWSTV,
          CASE WHEN channel="IVM" THEN ROUND(TVR,2) ELSE 0 END IVM,
          CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,2) ELSE 0 END KOMPASTV,
          CASE WHEN channel="METRO" THEN ROUND(TVR,2) ELSE 0 END METRO,
          CASE WHEN channel="MNCTV" THEN ROUND(TVR,2) ELSE 0 END MNCTV,
          CASE WHEN channel="OCHNL" THEN ROUND(TVR,2) ELSE 0 END OCHNL,
          CASE WHEN channel="NET" THEN ROUND(TVR,2) ELSE 0 END NET,
          CASE WHEN channel="RCTI" THEN ROUND(TVR,2) ELSE 0 END RCTI,
          CASE WHEN channel="RTV" THEN ROUND(TVR,2) ELSE 0 END RTV,
          CASE WHEN channel="SCTV" THEN ROUND(TVR,2) ELSE 0 END SCTV,
          CASE WHEN channel="TRANS" THEN ROUND(TVR,2) ELSE 0 END TRANS,
          CASE WHEN channel="TRANS7" THEN ROUND(TVR,2) ELSE 0 END TRANS7,
          CASE WHEN channel="TVONE" THEN ROUND(TVR,2) ELSE 0 END TVONE,
          CASE WHEN channel="TVRI" THEN ROUND(TVR,2) ELSE 0 END TVRI
          FROM (
          SELECT CHN.*, ALL_VIEWERS,  
          (VIEWERS/ALL_VIEWERS)*100 AS TVR FROM (
          
          SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS FROM `M_SUMMARY_MEDIAPLAN`
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          AND CARDNO IN('.$list_id.')
          GROUP BY CHANNEL
          ) CHN,
          (
          SELECT COUNT(DISTINCT(CARDNO)) ALL_VIEWERS FROM `M_SUMMARY_MEDIAPLAN` A 
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          
          
          ) AS ALL_VIEWERS
          ) KK 
          )LL';
      } else if($tvr==1) {
          $sql2='SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(GTV) AS GTV,MAX(INEWSTV) AS INEWSTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,MAX(MNCTV) AS MNCTV,
          MAX(NET) AS NET,MAX(RCTI) AS RCTI,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
          SELECT 
          CASE WHEN channel="ANTV" THEN ROUND(TVR,2) ELSE 0 END ANTV,
          CASE WHEN channel="GTV" THEN ROUND(TVR,2) ELSE 0 END GTV,
          CASE WHEN channel="INEWSTV" THEN ROUND(TVR,2) ELSE 0 END INEWSTV,
          CASE WHEN channel="IVM" THEN ROUND(TVR,2) ELSE 0 END IVM,
          CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,2) ELSE 0 END KOMPASTV,
          CASE WHEN channel="METRO" THEN ROUND(TVR,2) ELSE 0 END METRO,
          CASE WHEN channel="MNCTV" THEN ROUND(TVR,2) ELSE 0 END MNCTV,
          CASE WHEN channel="OCHNL" THEN ROUND(TVR,2) ELSE 0 END OCHNL,
          CASE WHEN channel="NET" THEN ROUND(TVR,2) ELSE 0 END NET,
          CASE WHEN channel="RCTI" THEN ROUND(TVR,2) ELSE 0 END RCTI,
          CASE WHEN channel="RTV" THEN ROUND(TVR,2) ELSE 0 END RTV,
          CASE WHEN channel="SCTV" THEN ROUND(TVR,2) ELSE 0 END SCTV,
          CASE WHEN channel="TRANS" THEN ROUND(TVR,2) ELSE 0 END TRANS,
          CASE WHEN channel="TRANS7" THEN ROUND(TVR,2) ELSE 0 END TRANS7,
          CASE WHEN channel="TVONE" THEN ROUND(TVR,2) ELSE 0 END TVONE,
          CASE WHEN channel="TVRI1" THEN ROUND(TVR,2) ELSE 0 END TVRI
          FROM (
          SELECT CHN.*, ALL_VIEWERS,  
          (VIEWERS/ALL_VIEWERS)*100 AS TVR FROM (
          
          SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS FROM `M_SUMMARY_MEDIAPLAN`
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          AND CARDNO IN('.$list_id.')
          GROUP BY CHANNEL
          ) CHN,
          (
          SELECT COUNT(DISTINCT(CARDNO)) ALL_VIEWERS FROM NEW_CDR_LIVE_CLEAN_CS 
          WHERE CARDNO IN('.$list_id.')
          
          ) AS ALL_VIEWERS
          ) KK 
          )LL';
      }else {
          $sql2		= 'SELECT "'.$HELIX_PROF[1].'" AS FIELD,"'.$HELIX_PROF[0].'" AS SEGMENT,MAX(ANTV) AS ANTV,MAX(GTV) AS GTV,MAX(INEWSTV) AS INEWSTV,MAX(IVM) AS IVM,MAX(KOMPASTV) AS KOMPASTV,MAX(METRO) AS METRO,MAX(MNCTV) AS MNCTV,
          MAX(NET) AS NET,MAX(RCTI) AS RCTI,MAX(OCHNL) AS OCHNL,MAX(RTV) AS RTV,MAX(SCTV) AS SCTV,MAX(TRANS) AS TRANS,MAX(TRANS7) AS TRANS7,MAX(TVONE) AS TVONE,MAX(TVRI) AS TVRI FROM (
          SELECT 
          CASE WHEN channel="ANTV" THEN ROUND(TVR,0) ELSE 0 END ANTV,
          CASE WHEN channel="GTV" THEN ROUND(TVR,0) ELSE 0 END GTV,
          CASE WHEN channel="INEWSTV" THEN ROUND(TVR,0) ELSE 0 END INEWSTV,
          CASE WHEN channel="IVM" THEN ROUND(TVR,0) ELSE 0 END IVM,
          CASE WHEN channel="KOMPASTV" THEN ROUND(TVR,0) ELSE 0 END KOMPASTV,
          CASE WHEN channel="METRO" THEN ROUND(TVR,0) ELSE 0 END METRO,
          CASE WHEN channel="MNCTV" THEN ROUND(TVR,0) ELSE 0 END MNCTV,
          CASE WHEN channel="OCHNL" THEN ROUND(TVR,0) ELSE 0 END OCHNL,
          CASE WHEN channel="NET" THEN ROUND(TVR,0) ELSE 0 END NET,
          CASE WHEN channel="RCTI" THEN ROUND(TVR,0) ELSE 0 END RCTI,
          CASE WHEN channel="RTV" THEN ROUND(TVR,0) ELSE 0 END RTV,
          CASE WHEN channel="SCTV" THEN ROUND(TVR,0) ELSE 0 END SCTV,
          CASE WHEN channel="TRANS" THEN ROUND(TVR,0) ELSE 0 END TRANS,
          CASE WHEN channel="TRANS7" THEN RUND(TVR,0) ELSE 0 END TRANS7,
          CASE WHEN channel="TVONE" THEN ROUND(TVR,0) ELSE 0 END TVONE,
          CASE WHEN channel="TVRI1" THEN ROUND(TVR,0) ELSE 0 END TVRI
          FROM (
          SELECT CHN.*, 
          (VIEWERS) AS TVR FROM (
          
          SELECT CHANNEL,COUNT(DISTINCT(CARDNO)) AS VIEWERS FROM `M_SUMMARY_MEDIAPLAN`
          WHERE SPLIT_MINUTES BETWEEN "'.$params['start_date'].' '.$params['starttime'].'" AND "'.$params['start_date'].' '.$params['endtime'].'"
          AND CARDNO IN('.$list_id.')
          GROUP BY CHANNEL
          ) CHN
          ) KK 
          )LL';
      }
      
      $query2		= $this->db->query($sql2);
      $result2 = $query2->result_array();
      $return = array(
          'data' => $result2,
      );
      
      return $return;
	}
	
	public function listparent() {
      $query = 'SELECT *, "" as anak FROM t_group_profile WHERE parent = 1 GROUP BY `name` ORDER BY sorting ASC';  			
      $sql	= $this->db->query($query);
      $this->db->close();	   
      $hasil = $sql->result_array();
      
      $result = array();
      $resultakhir = array();
      $akhirnya = array();
      $resultanak1 = array();
      $resultanak2 = array();
      $resultanak3 = array();
      $resultanak4 = array();
      $sss = array();	
      
      foreach($hasil as $new){
          $query1 = 'SELECT *, "" as anak FROM t_group_profile WHERE parent = 0 and parent_id = '.$new['parent_id'].' GROUP BY `name` ORDER BY name ASC';  			
          $sql1	= $this->db->query($query1);
          $this->db->close();	   
          $hasil1 = $sql1->result_array();
          
          foreach($hasil1 as $new1){
              if($new1['parent_id'] == $new['id']){
                  $new['anak'] = $hasil1; 
              }
          }
          array_push($result, $hasil1);
      }
      
      foreach($result as $newresult){
          foreach($newresult as $anak){
              $query2 = 'SELECT *, "" as anak FROM t_group_profile WHERE parent = 0 and parent_id = '.$anak['id'].' GROUP BY `name` ORDER BY name ASC';  			
              $sql2	= $this->db->query($query2);
              $this->db->close();	   
              $hasil2 = $sql2->result_array();
              
              foreach($hasil2 as $new2){
                  if($anak['id'] == $new2['parent_id']){
                      $anak['anak'] = $hasil2; 
                  }
              }
              
              array_push($resultanak1, $anak);
          }
      }
      
      foreach($resultanak1 as $anakanakan){
          if(!empty($anakanakan['anak'])){
              foreach($anakanakan['anak'] as $anakbaru){	 
                  $query2 = 'SELECT *, "" as anak FROM t_group_profile WHERE parent = 0 and parent_id = '.$anakbaru['id'].' GROUP BY `name` ORDER BY name ASC';  			
                  $sql2	= $this->db->query($query2);
                  $this->db->close();	   
                  $hasil2 = $sql2->result_array();
                  
                  foreach($hasil2 as $new2){
                      if($anakbaru['id'] == $new2['parent_id']){
                          $anakbaru['anak'] = $hasil2;	
                      }
                  }
                  
                  array_push(	$resultanak2, $anakbaru);
              }
          }
      }	
      
      foreach($resultanak2 as $anakanakan2){
          if($anakanakan2['anak']){
              foreach($anakanakan2['anak'] as $anakbaru2){
                  if($anakbaru2['ss_id'] != "CHILD_2" && $anakbaru2['ss_id'] != "CHILD_1"){
                      $query2 = 'SELECT DISTINCT '.$anakbaru2['ss_id'].' as `name`, "'.$anakbaru2['ss_id'].'" AS parent FROM t_single_source ';  			
                      $sql2	= $this->db->query($query2);
                      $this->db->close();	   
                      $hasil2 = $sql2->result_array();
                      
                      foreach($hasil2 as $new2){
                          if($anakbaru2['ss_id'] == $new2['parent']){
                              $anakbaru2['anak'] = $hasil2; 
                          }
                      }
                      
                      array_push(	$resultanak3, $anakbaru2);
                  }
              }
          }
      }
      
      foreach($resultanak1 as $new1){
          if(!empty($new1['anak'])){
              foreach($new1['anak'] as $anakterakhir){
              
                  foreach($resultanak3 as $new3){
                      if($anakterakhir['id'] == $new3['parent_id']){
                          $anakterakhir['anak'] = $resultanak3; 
                      }	
                  }
                  
                  array_push($resultanak4, $anakterakhir);
              }
          }
      }
      
      foreach($result as $resultakhir){
          foreach($resultakhir as $akhir){
              array_push($sss, $akhir);		
          }
      }	
      
      $bas = array();
      foreach($sss as $bbkb){
          foreach($resultanak4 as $akaan){
              if($bbkb['id'] == $akaan['parent_id']){
                  $bbkb['anak'] = $resultanak4; 
              }			
          }
          
          array_push($bas, $bbkb);
      }	
      
      foreach($hasil as $bkkas){
          foreach($bas as $newsss){
              if($bkkas['id'] == $newsss['parent_id']){
                  $bkkas['anak'] = $bas; 
              }			
          }
          array_push($akhirnya, $bkkas);
      }
      
      return $akhirnya;
	}
	

  
  public function listdataprofilenew(){
      $query = 'SELECT IDX, CLASS_1_NAME, "" as PARENT FROM urate_single_source_class WHERE idx=1445 GROUP BY CLASS_1_NAME ORDER BY IDX ASC';  			
      $sql	= $this->db->query($query);
      $this->db->close();	   
      $hasil = $sql->result_array();
      
      $result = array();
      $result2 = array();
      $result3 = array();
      $result4 = array();
      $result5 = array();
      $result6 = array();
      $result7 = array();
      
      $i = -1;
      $sa = 0;
      $a = 0;
      $u = 0;
      $s = 0;
      $s6 = 0;
      $ss = 0;
      
  		foreach($hasil as $new){
  			$query1 = 'SELECT IDX, CLASS_1_NAME, CLASS_2_NAME FROM urate_single_source_class WHERE CLASS_1_NAME = "'.$new['CLASS_1_NAME'].'" AND CLASS_2_NAME="DEMOGRAPHICS" GROUP BY CLASS_2_NAME ORDER BY IDX ASC';  			
  			$sql1	= $this->db->query($query1);
  			$this->db->close();	   
  			$hasil1 = $sql1->result_array();
  			
  				 foreach($hasil1 as $new1){
  					if($new1['CLASS_1_NAME'] == $new['CLASS_1_NAME']){
  						$query2 = 'SELECT IDX, CLASS_2_NAME, CLASS_3_NAME, "" as ANAK2 FROM urate_single_source_class WHERE CLASS_2_NAME = "'.$new1['CLASS_2_NAME'].'"  GROUP BY CLASS_3_NAME ORDER BY IDX ASC';  			
  						$sql2	= $this->db->query($query2);
  						$this->db->close();	   
  						$hasil2 = $sql2->result_array();
  						foreach($hasil2 as $new2){
  							if($new2['CLASS_2_NAME'] == $new1['CLASS_2_NAME']){
  								if(!empty($new2['CLASS_3_NAME'])){
  									$query3 = 'SELECT IDX, CLASS_3_NAME, CLASS_4_NAME, "" as `ANAK3` FROM urate_single_source_class WHERE CLASS_3_NAME = "'.$new2['CLASS_3_NAME'].'"  GROUP BY CLASS_4_NAME ORDER BY IDX ASC';  			
  									$sql3	= $this->db->query($query3);
  									$this->db->close();	   
  									$hasil3 = $sql3->result_array();
  										foreach($hasil3 as $new3){
  											$i++;
  											if(!empty($new3['CLASS_4_NAME'])){
  												
  													if($new3['CLASS_3_NAME'] == $new2['CLASS_3_NAME']){
  														$query4 = 'SELECT IDX, CLASSS_4_NAME, CLASS_5_NAME, "" as `ANAK4` FROM urate_single_source_class WHERE CLASS_4_NAME = "'.$new3['CLASS_4_NAME'].'"  GROUP BY CLASS_5_NAME ORDER BY IDX ASC';  			
  														$sql4	= $this->db->query($query4);
  														$this->db->close();	   
  														$hasil4 = $sql4->result_array();
  														foreach($hasil4 as $new4){
  															$s++;
  															if(!empty($new4['CLASS_5_NAME'])){
  																if($new4['CLASS_4_NAME'] == $new3['CLASS_4_NAME']){
  																		$query5 = 'SELECT IDX, CLASS_5_NAME, CLASS_6_NAME, "" as `ANAK5` FROM urate_single_source_class WHERE CLASS_5_NAME = "'.$new4['CLASS_5_NAME'].'"  GROUP BY CLASS_6_NAME ORDER BY IDX ASC';  			
  																		$sql5	= $this->db->query($query5);
  																		$this->db->close();	   
  																		$hasil5 = $sql5->result_array();
  																			foreach($hasil5 as $new5){
  																				
  																				$s6++;
  																				if(!empty($new5['CLASS_6_NAME'])){
  																					if($new5['CLASS_5_NAME'] == $new4['CLASS_5_NAME']){
  																							$query6 = 'SELECT IDX, CLASS_6_NAME, VALUE_NAME, "" as `VALUE` FROM urate_single_source_class WHERE CLASS_6_NAME = "'.$new5['CLASS_6_NAME'].'"  GROUP BY VALUE_NAME ORDER BY IDX ASC';  			
  																							$sql6	= $this->db->query($query6);
  																							$this->db->close();	   
  																							$hasil6 = $sql6->result_array();																	
  																								foreach($hasil6 as $new6){
  																									$ss++;
  																									if($new6['CLASS_6_NAME'] == $new5['CLASS_6_NAME']){
  																										$query7 = 'SELECT IDX, VALUE_NAME, OPTION_NAME,  VALUE_HEADER, OPTION_HEADER FROM urate_single_source_class WHERE VALUE_NAME = "'.$new6['VALUE_NAME'].'"  GROUP BY OPTION_NAME ORDER BY IDX ASC';  			
  																										$sql7	= $this->db->query($query7);
  																										$this->db->close();	   
  																										$hasil7 = $sql7->result_array();
  																										foreach($hasil7 as $new7){
  																											if($new7['VALUE_NAME'] == $new6['VALUE_NAME']){
  																												$new6['VALUE'] = $hasil7;
  																											}
  																										}																								
  																										$new5['ANAK5'][$ss] = $new6;
  																									}
  																								}
  																							$new4['ANAK4'][$s6] = $new5;
  																						}
  																				}else{
  																					if($new5['CLASS_5_NAME'] == $new4['CLASS_5_NAME']){
  																						$query6 = 'SELECT IDX, CLASS_5_NAME, VALUE_NAME, "" as `VALUE` FROM urate_single_source_class WHERE CLASS_5_NAME = "'.$new5['CLASS_5_NAME'].'"  GROUP BY VALUE_NAME ORDER BY IDX ASC';  			
  																						$sql6	= $this->db->query($query6);
  																						$this->db->close();	   
  																						$hasil6 = $sql6->result_array();																	
  																							foreach($hasil6 as $new6){
  																								$ss++;
  																								if($new6['CLASS_5_NAME'] == $new5['CLASS_5_NAME']){
  																									$query7 = 'SELECT IDX, VALUE_NAME, OPTION_NAME,  VALUE_HEADER, OPTION_HEADER FROM urate_single_source_class WHERE VALUE_NAME = "'.$new6['VALUE_NAME'].'"  GROUP BY OPTION_NAME ORDER BY IDX ASC';  			
  																									$sql7	= $this->db->query($query7);
  																									$this->db->close();	   
  																									$hasil7 = $sql7->result_array();
  																									foreach($hasil7 as $new7){
  																										if($new7['VALUE_NAME'] == $new6['VALUE_NAME']){
  																											$new6['VALUE'] = $hasil7;
  																										}
  																									}
  																									$new4['ANAK4'][$s6] = $new6;
  																								}
  																							}
  																						}
  																				}
  																			}
  																		$new3['ANAK3'][$s] = $new4;
  																	}
  															}else{
  																if($new4['CLASS_4_NAME'] == $new3['CLASS_4_NAME']){
  																	$query6 = 'SELECT IDX, CLASS_4_NAME, VALUE_NAME, "" as `VALUE` FROM urate_single_source_class WHERE CLASS_4_NAME = "'.$new4['CLASS_4_NAME'].'"  GROUP BY VALUE_NAME ORDER BY IDX ASC';  			
  																	$sql6	= $this->db->query($query6);
  																	$this->db->close();	   
  																	$hasil6 = $sql6->result_array();																	
  																		foreach($hasil6 as $new6){
  																			$ss++;
  																			if($new6['CLASS_4_NAME'] == $new4['CLASS_4_NAME']){
  																				$query7 = 'SELECT IDX, VALUE_NAME, OPTION_NAME,  VALUE_HEADER, OPTION_HEADER FROM urate_single_source_class WHERE VALUE_NAME = "'.$new6['VALUE_NAME'].'"  GROUP BY OPTION_NAME ORDER BY IDX ASC';  			
  																				$sql7	= $this->db->query($query7);
  																				$this->db->close();	   
  																				$hasil7 = $sql7->result_array();
  																				foreach($hasil7 as $new7){
  																					if($new7['VALUE_NAME'] == $new6['VALUE_NAME']){
  																						$new6['VALUE'] = $hasil7;
  																					}
  																				}																					
  																				$new3['ANAK3'][$s] = $new6;
  																			}
  																		}
  																	}
  															}
  														}
  														
  														$new2['ANAK2'][$i] = $new3;
  														if(!in_array($new2, $result4, true)){
  																array_push($result4, $new2);
  														}	
  													}
  											}else{
  												if($new3['CLASS_3_NAME'] == $new2['CLASS_3_NAME']){
  												$query6 = 'SELECT IDX, CLASS_3_NAME, VALUE_NAME, "" as `VALUE` FROM urate_single_source_class WHERE CLASS_3_NAME = "'.$new2['CLASS_3_NAME'].'"  GROUP BY VALUE_NAME ORDER BY IDX ASC';  			
  												$sql6	= $this->db->query($query6);
  												$this->db->close();	   
  												$hasil6 = $sql6->result_array();																	
  													foreach($hasil6 as $new6){
  														$ss++;
  														if($new6['CLASS_3_NAME'] == $new3['CLASS_3_NAME']){
  															$query7 = 'SELECT IDX, VALUE_NAME, OPTION_NAME,  VALUE_HEADER, OPTION_HEADER FROM urate_single_source_class WHERE VALUE_NAME = "'.$new6['VALUE_NAME'].'"  GROUP BY OPTION_NAME ORDER BY IDX ASC';  			
  															$sql7	= $this->db->query($query7);
  															$this->db->close();	   
  															$hasil7 = $sql7->result_array();
  															foreach($hasil7 as $new7){
  																if($new7['VALUE_NAME'] == $new6['VALUE_NAME']){
  																	$new6['VALUE'] = $hasil7;
  																}
  															}
  															$new2['ANAK2'][$ss] = $new6;
  														}
  													}
  												}
  											}
  										}
  								}else{
                      if($new2['CLASS_2_NAME'] == $new1['CLASS_2_NAME']){
                          $query6 = 'SELECT IDX, CLASS_2_NAME, VALUE_NAME, "" as `VALUE` FROM urate_single_source_class WHERE CLASS_2_NAME = "'.$new2['CLASS_2_NAME'].'"  GROUP BY VALUE_NAME ORDER BY IDX ASC';  			
                          $sql6	= $this->db->query($query6);
                          $this->db->close();	   
                          $hasil6 = $sql6->result_array();																	
                              foreach($hasil6 as $new6){
                                  $sa++;
                                  if($new6['CLASS_2_NAME'] == $new2['CLASS_2_NAME']){
                                      $query7 = 'SELECT IDX, VALUE_NAME, OPTION_NAME,  VALUE_HEADER, OPTION_HEADER FROM urate_single_source_class WHERE VALUE_NAME = "'.$new6['VALUE_NAME'].'"  GROUP BY OPTION_NAME ORDER BY IDX ASC';  			
                                      $sql7	= $this->db->query($query7);
                                      $this->db->close();	   
                                      $hasil7 = $sql7->result_array();
                                      foreach($hasil7 as $new7){
                                          if($new7['VALUE_NAME'] == $new6['VALUE_NAME']){
                                              $new6['VALUE'] = $hasil7;
                                          }
                                      }
                                      $new1['ANAK1'][$sa] = $new6;
                                  }
                              }
                      }
                  }
                  
  								if(!in_array($new2, $result2, true)){
                      array_push($result2, $new2);
  								}
  							}
  							
  						}
              
  						array_push($result, $new1);
  					}
  				 }
  		}
  		
  		foreach($hasil as $bb){
          foreach($result as $cas){
              $u++;
              foreach($result2 as $sac){
                  $a++;
                  
                  if($sac['CLASS_2_NAME'] == $cas['CLASS_2_NAME']){
                      $cas['ANAK1'][$a] = $sac;
                  }
              }
              
              if($cas['CLASS_1_NAME'] == $bb['CLASS_1_NAME']){
                  $bb['PARENT'][$u] = $cas;
              }
          }
          array_push($result6, $bb);
  		}
      
  		return $result6;
	}	                           
  
  public function setdaypart($user_id,$start_time,$end_time){ 
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":00','1')";
            
      if ($sql) {
          $this->db->query($sql);
          
          $query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$user_id.'" AND MENUS="1" ORDER BY DAYPART1 ';			
      		$sql	= $this->db->query($query);
      		$this->db->close();
      		$this->db->initialize(); 
      		return $sql->result_array();	
      } 
      else {
          return false;
      }
  }
}	