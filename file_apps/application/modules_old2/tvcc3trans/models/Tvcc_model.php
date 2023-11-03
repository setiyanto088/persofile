<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvcc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}

	public function list_profile($iduser,$idrole,$period) {
		/*
		if ($idrole==18) {
			$query = "SELECT id, `name`, grouping, postbuy_status FROM t_profiling_ub WHERE STATUS = 1 OR STATUS = 3 ";
		} else {
			$query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a INNER JOIN hrd_profile b ON a.user_id_profil=b.id WHERE (STATUS = 1 OR STATUS = 3) AND user_id_profil=".$iduser;
		}	
		*/                                                                                               
    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
    
    $query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channelas() {
		$query = 'SELECT CHANNEL_RC as channel, COLOR FROM CHANNEL_PARAM WHERE F2A_STATUS=1 order by CHANNEL_RC';  
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channel() {
		//$query = 'SELECT channel_cim as channel FROM P_CHANNEL_ADS_USEETV WHERE FLAG_TV=1 and CHANNEL_NAME not in ("GTV","RCTI","INEWSTV","RCTI","MNCTV") order by channel ';
    // $query = "SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM` C
      // WHERE C.`F2A_STATUS` IN (0,-99)  
      // ORDER BY C.`CHANNEL_NAME`";	

//$query = 'SELECT CHANNEL_NAME_PROG as channel, COLOR FROM CHANNEL_PARAM_FINAL WHERE FLAG_TV = 1 GROUP BY CHANNEL_NAME_PROG order by CHANNEL_NAME_PROG';  	  
$query = 'SELECT CHANNEL as channel, "#344334" FROM M_SUMMARY_TVCC_30_TRANS GROUP BY CHANNEL order by CHANNEL';  	  
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
  
  public function list_channel_by_genre($strGenre) {
    if($strGenre == "0"){
        $strWhere = "";
    } else {
        $strWhere = "AND GENRE = '".$strGenre."' ";
    }
    
		//$query = 'SELECT channel_cim as channel FROM P_CHANNEL_ADS_USEETV WHERE FLAG_TV=1 and CHANNEL_NAME not in ("GTV","RCTI","INEWSTV","RCTI","MNCTV") order by channel ';
    // $query = "SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM` C
      // WHERE C.`F2A_STATUS` IN (0,-99)  ".$strWhere."  
      // ORDER BY C.`CHANNEL_NAME`";		

$query = " SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1 ".$strWhere."  
      ORDER BY C.`CHANNEL_NAME`";
	  
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
  
  public function list_channel_genre() {
		// $query = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      // WHERE C.`F2A_STATUS` IN (0,-99)  
      // ORDER BY C.`GENRE`";
    //print_r($query);			
	
	$query = " SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1
      ORDER BY C.`GENRE`";
	
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function content_grouping($profile) {
		$query = 'SELECT grouping
					FROM t_profiling_ub
					WHERE id = '.$profile.'
					AND STATUS = 1;';  					
		$sql	= $this->db->query($query,array($profile));
		$this->db->close();
		$this->db->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT USERID	FROM SINGLE_SOURCE_VALUE"." ".$data;
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
	public function get_ranged_tvcc($params = array(),$channel){
		$sql2 = 'SELECT DATE_FORMAT(STR_TO_DATE(`DATE`,"%d/%m/%Y"),"%Y-%m-%d") as `DATE`,M1 FROM 
				(
				SELECT DATE,
				CONCAT(SUBSTR(SPLIT_MINUTES,12,2),IF(SUBSTR(SPLIT_MINUTES,15,2) > 30,":30:00-",":00:00-" ),IF(SUBSTR(SPLIT_MINUTES,15,2) < 31,CONCAT(SUBSTR(SPLIT_MINUTES,12,2),":30:00"),CONCAT(IF(SUBSTR(SPLIT_MINUTES,12,2)+1 < 10,"0",""),SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00") )) AS M1 FROM `PTV_TVCC_RATING`
				WHERE SPLIT_MINUTES >= "'.$params['start_date'].' '.$params['starttime'].'" AND SPLIT_MINUTES < "'.$params['end_date'].' '.$params['endtime'].'" 
				AND PROFILE_ID = '.$params['profile'].' 
				) AS TVCSC
				GROUP BY M1
				ORDER BY `DATE`,M1';
		//print_r($sql2); die();
    
		$query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();						
		
		return $result2;
	}                
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(TVCC_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
	
	public function get_channel_tvcc_by_time($params = array(),$channel,$dater){
    if($params['cgroup'] == "tvr"){ 
        $search_col = 'ROUND(AVG(TVR),2) AS RATING';
    } else if($params['cgroup'] == "tvs"){
        $search_col = 'ROUND(AVG(TVS),2) AS SHARING';
    } else if($params['cgroup'] == "viewers"){
        $search_col = 'CEILING(AVG(VIEWERS)) AS VIEWERSS';
    }                              
		
    $sql2 = 'SELECT DATE_FORMAT(STR_TO_DATE(`DATE`,"%d/%m/%Y"),"%Y-%m-%d") as `DATE`,M1,CHANNEL, '.$search_col.'  FROM 
					(
          SELECT DATE,CHANNEL,'.strtoupper($params['cgroup']).',
					CONCAT(SUBSTR(SPLIT_MINUTES,12,2),IF(SUBSTR(SPLIT_MINUTES,15,2) > 30,":30:00-",":00:00-" ),IF(SUBSTR(SPLIT_MINUTES,15,2) < 31,CONCAT(SUBSTR(SPLIT_MINUTES,12,2),":30:00"),CONCAT(IF(SUBSTR(SPLIT_MINUTES,12,2)+1 < 10,"0",""),SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00") )) AS M1 FROM `PTV_TVCC_RATING`
					WHERE SPLIT_MINUTES >= "'.$params['start_date'].' '.$params['starttime'].'" AND SPLIT_MINUTES < "'.$params['end_date'].' '.$params['endtime'].'" 
					AND CHANNEL ='.$channel.' 
					AND PROFILE_ID = '.$params['profile'].' 
					) AS TVCSC
					WHERE M1 = "'.$dater['M1'].'" 
					GROUP BY M1,CHANNEL
					ORDER BY `DATE`,M1,CHANNEL';
					
					
					
	// $sql2 = 'SELECT `DATE`,M1,CHANNEL, '.$search_col.' FROM 
					// (
					// SELECT `DATE`,CHANNEL,'.strtoupper($params['cgroup']).',
					// CONCAT(SUBSTR(SPLIT_MINUTES,12,2),IF(SUBSTR(SPLIT_MINUTES,15,2) > 30,":30:00-",":00:00-" ),IF(SUBSTR(SPLIT_MINUTES,15,2) < 31,CONCAT(SUBSTR(SPLIT_MINUTES,12,2),":30:00"),CONCAT(IF(SUBSTR(SPLIT_MINUTES,12,2)+1 < 10,"0",""),SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00") )) AS M1 FROM `PTV_TVCC_RATING`
					// WHERE  DATE_FORMAT(SPLIT_MINUTES,"%H:%i") >= "'.substr($dater,0,5).'" AND DATE_FORMAT(SPLIT_MINUTES,"%H:%i") < "'.substr($dater,6,5).'" 
					// AND CHANNEL IN('.$channel.') 
					// AND PROFILE_ID = '.$params['profile'].' 
					// ) AS TVCSC
					// WHERE M1 = "'.$dater.'" 
					// GROUP BY M1,`DATE`,CHANNEL  
					// ORDER BY `DATE`,M1,CHANNEL';
		//print_r($sql2); die();
		
    $query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();						
		
		return $result2;
		
	}
	
	public function get_channel_tvcc($params = array(),$channel){
		$sql2 = 'SELECT DATE_FORMAT(STR_TO_DATE(`DATE`,"%d/%m/%Y"),"%Y-%m-%d") as `DATE`,M1,CHANNEL, ROUND(AVG(TVR),2) AS RATING, ROUND(AVG(TVS),2) AS SHARING, CEILING(AVG(VIEWERS)) AS VIEWERSS FROM 
				(
				SELECT *,
				CONCAT(SUBSTR(SPLIT_MINUTES,12,2),IF(SUBSTR(SPLIT_MINUTES,15,2) > 30,":30:00-",":00:00-" ),IF(SUBSTR(SPLIT_MINUTES,15,2) < 31,CONCAT(SUBSTR(SPLIT_MINUTES,12,2),":30:00"),CONCAT(IF(SUBSTR(SPLIT_MINUTES,12,2)+1 < 10,"0",""),SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00") )) AS M1 FROM `PTV_TVCC_RATING`
				WHERE SPLIT_MINUTES >= "'.$params['start_date'].' '.$params['starttime'].'" AND SPLIT_MINUTES < "'.$params['end_date'].' '.$params['endtime'].'" 
				AND CHANNEL ='.$channel.' 
				AND PROFILE_ID = '.$params['profile'].' 
				) AS TVCSC
				GROUP BY M1,CHANNEL
				ORDER BY `DATE`,M1,CHANNEL';
		//print_r($sql2); die();
		
    $query2		= $this->db->query($sql2);
		$result2 = $query2->result_array();						
		
		return $result2;
	}

	
	public function list_tvcc2($params = array()) {
    if($params['cgroup'] == "tvr"){ 
        $search_col = 'ROUND(AVG(TVR),2) AS RATING';
		$col = 'RATING';
    } else if($params['cgroup'] == "tvs"){
        $search_col = 'ROUND(AVG(TVS),2) AS SHARING';
		$col = 'SHARING';
    } else if($params['cgroup'] == "viewers"){
        $search_col = 'CEILING(AVG(VIEWERS)) AS VIEWERSS';
		$col = 'VIEWERSS';
    }
    
    if($params['channel'] == "0"){
        $f = $this->list_channel();
        $cin = "";
		 $cin2 = "";
    
        foreach($f as $channel_f){
            $cin = $cin."'".$channel_f['channel']."',";
			
			 $cin2 = $cin2.$channel_f['channel'].",f";
        }
        
		//print_r($cin2);die;
		
		$new_cin2 = substr($cin2, 0, -1);
        $new_cin = substr($cin, 0, -1);
    } else {
        $new_cin = $params['channel'];
		$new_cin2 = $params['channel'];
    } 
	
	$hhh = explode(",",$new_cin2);
	
	$case_max = "SELECT M2, ";
	
	$case_str = "( SELECT CONCAT(`DATE`,' ',M1) as M2, `DATE`,M1, ";
   
	// foreach($hhh as $case){
		
		
	// }
   
	foreach($hhh as $cases){
		
		$case = str_replace("'","",$cases);
		//print_r("asa");die;
		$case_str = $case_str." CASE WHEN channel='".$case."' THEN ROUND(".$col.",2) ELSE 0 END `".$case."`,";
		$case_max  = $case_max ."MAX(`".$case."`) AS `".$case."`,";
	}
	
	
	
	$case_str = substr($case_str, 0, -1);
	$case_max = substr($case_max, 0, -1);
	
	$case_str = $case_str." FROM ( ";
	$case_max = $case_max." FROM  ";
	//print_r($hhh);die;
	
    $sql = 'SELECT `DATE`,M1,CHANNEL, '.$search_col.' FROM 
			(
					SELECT DATE_FORMAT(STR_TO_DATE(`DATE`,"%d/%m/%Y"),"%Y-%m-%d") as `DATE`,CHANNEL,'.strtoupper($params['cgroup']).',
					CONCAT(SUBSTR(SPLIT_MINUTES,12,2),IF(SUBSTR(SPLIT_MINUTES,15,2) > 30,":30:00-",":00:00-" ),IF(SUBSTR(SPLIT_MINUTES,15,2) < 31,CONCAT(SUBSTR(SPLIT_MINUTES,12,2),":30:00"),CONCAT(IF(SUBSTR(SPLIT_MINUTES,12,2)+1 < 10,"0",""),SUBSTR(SPLIT_MINUTES,12,2)+1,":00:00") )) AS M1 FROM `M_SUMMARY_TVCC_PTV`
					WHERE DATE_FORMAT(STR_TO_DATE(`DATE`,"%d/%m/%Y"),"%Y-%m-%d")  BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'" 
					AND DATE_FORMAT(SPLIT_MINUTES,"%H:%i") >= "'.$params['starttime'].'" AND DATE_FORMAT(SPLIT_MINUTES,"%H:%i") < "'.$params['endtime'].'" 
					AND CHANNEL IN('.$new_cin.') 
					AND ID_PROFILE = '.$params['profile'].' 
			) AS TVCSC
					GROUP BY M1,`DATE`,CHANNEL  
					ORDER BY `DATE`,M1,CHANNEL
					
					) K GROUP BY M1,`DATE`,CHANNEL

) KKL GROUP BY `DATE`,M1
ORDER BY `DATE`,M1
					
					';          
		//print_r( $case_max.$case_str.$sql);die;  
		$usql = $case_max.$case_str.$sql;
		
		//echo $usql;die;
		
		$out		= array();
		$query		= $this->db->query($usql);
		$result = $query->result_array();
    
		$total_filtered = $this->db->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
	}
	
	
	public function list_tvcc($params = array()) {
    //print_r($params);
    if($params['cgroup'] == "tvr"){ 
        $search_col = 'ROUND(AVG(TVR),2) AS RATING';
		$col = 'RATING';
    } else if($params['cgroup'] == "tvs"){
        $search_col = 'ROUND(AVG(TVS),2) AS SHARING';
		$col = 'SHARING';
    } else if($params['cgroup'] == "viewers"){
        $search_col = 'CEILING(AVG(VIEWERS)) AS VIEWERSS';
		$col = 'VIEWERSS';
    }
    
    if($params['channel'] == "0"){
        $f = $this->list_channel_by_genre($params['genre']);
        $cin = "";
        $cin2 = "";
        
        foreach($f as $channel_f){
            $cin = $cin."'".$channel_f['channel']."',";
            
            $cin2 = $cin2.$channel_f['channel'].",";
        }
        
        $new_cin2 = substr($cin2, 0, -1);
        $new_cin = substr($cin, 0, -1);
    } else {
        $f = $params['channel'];
        $cin = "";
        $cin2 = "";
        
        foreach($f as $channel_f){
            $cin = $cin.$channel_f.",";
            
            $cin2 = $cin2.$channel_f.",";
        }
        
        $new_cin2 = substr($cin2, 0, -1);
        $new_cin = substr($cin, 0, -1);
    } 
    
    //print_r($new_cin);
    //print_r($new_cin2);die;
	
	$hhh = explode(",",$new_cin2);
	
	$case_max = "SELECT `DATE`,M1, ";
	
	$case_str = "( SELECT `DATE`,M1, ";
   
	// foreach($hhh as $case){
		
		
	// }
   
	foreach($hhh as $cases){
		
		$case = str_replace("'","",$cases);
		//print_r("asa");die;
		$case_str = $case_str." CASE WHEN channel='".$case."' THEN ROUND(".$col.",2) ELSE 0 END `".$case."`,";
		$case_max  = $case_max ."MAX(`".$case."`) AS `".$case."`,";
	}
	
	
	
	$case_str = substr($case_str, 0, -1);
	$case_max = substr($case_max, 0, -1);
	
	$case_str = $case_str." FROM ( ";
	$case_max = $case_max." FROM  ";
	//print_r($hhh);die;
  
  if($params['order_column'] == "DATE") {
      $strOrderBy = '`DATE` ASC, M1 ASC';
  } else {
      $strOrderBy = '`'.$params['order_column'].'` '.$params['order_dir'];
  }
	
    $sql = 'SELECT `DATE`,M1,CHANNEL, '.$search_col.' FROM 
			(
					SELECT `DATE`,CHANNEL_NAME_PROG CHANNEL,'.strtoupper($params['cgroup']).',
					CONCAT(M1_START,"-",M1_END) AS M1 FROM `M_SUMMARY_TVCC_30_TRANS` A JOIN 
					CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME
					WHERE `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'" 
					AND M1_START >= "'.$params['starttime'].'" AND M1_END <= "'.$params['endtime'].'" 
					AND CHANNEL_NAME_PROG IN('.$new_cin.')    
					AND PROFILE_ID = '.$params['profile'].' 
			) AS TVCSC
					GROUP BY M1,`DATE`,CHANNEL  
					ORDER BY `DATE`,M1,CHANNEL
					
					) K GROUP BY M1,`DATE`,CHANNEL

) KKL GROUP BY `DATE`,M1 
ORDER BY '.$strOrderBy;

		//print_r( $case_max.$case_str.$sql);die;  
		$usql = $case_max.$case_str.$sql;
		
		//echo $usql;die;
		
		$out		= array();
		$query		= $this->db->query($usql);
		$result = $query->result_array();
    
		$total_filtered = $this->db->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
	}
  
  public function list_charttvcc($params = array()) {		
		if($params['profile']==50){
			$params['profile']==0;
		}
    
    if($params['cgroup'] == "tvr"){ 
        $search_col = 'ROUND(AVG(TVR),2) AS RATING';
		$col = 'RATING';
    } else if($params['cgroup'] == "tvs"){
        $search_col = 'ROUND(AVG(TVS),2) AS SHARING';
		$col = 'SHARING';
    } else if($params['cgroup'] == "viewers"){
        $search_col = 'CEILING(AVG(VIEWERS)) AS VIEWERSS';
		$col = 'VIEWERSS';
    }
    
    if($params['channel'] == "0"){
        $f = $this->list_channel_by_genre($params['genre']);
        $cin = "";
        $cin2 = "";
        
        foreach($f as $channel_f){
            $cin = $cin."'".$channel_f['channel']."',";
            
            $cin2 = $cin2.$channel_f['channel'].",";
        }
        
        $new_cin2 = substr($cin2, 0, -1);
        $new_cin = substr($cin, 0, -1);
    } else {
        $f = $params['channel'];
        $cin = "";
        $cin2 = "";
        
        foreach($f as $channel_f){
            $cin = $cin.$channel_f.",";
            
            $cin2 = $cin2.$channel_f.",";
        }
        
        $new_cin2 = substr($cin2, 0, -1);
        $new_cin = substr($cin, 0, -1);
    } 
    
    $hhh = explode(",",$new_cin2);
  	
  	$case_max = "SELECT `DATE`,M1, ";
  	
  	$case_str = "( SELECT `DATE`,M1, ";
     
  	// foreach($hhh as $case){
  		
  		
  	// }
     
  	foreach($hhh as $cases){
  		
  		$case = str_replace("'","",$cases);
  		//print_r("asa");die;
  		$case_str = $case_str." CASE WHEN channel='".$case."' THEN ROUND(".$col.",2) ELSE 0 END `".$case."`,";
  		$case_max  = $case_max ."MAX(`".$case."`) AS `".$case."`,";
  	}  	
  	
  	$case_str = substr($case_str, 0, -1);
  	$case_max = substr($case_max, 0, -1);
  	
  	$case_str = $case_str." FROM ( ";
  	$case_max = $case_max." FROM  ";

    $sql = 'SELECT `DATE`,M1,CHANNEL, ROUND(AVG(TVR),2) AS RATING, ROUND(AVG(TVS),2) AS SHARING, CEILING(AVG(VIEWERS)) AS VIEWERSS FROM 
					(
					SELECT *,
					CONCAT(M1_START,"-",M1_END) AS M1 FROM `M_SUMMARY_TVCC_30_TRANS` 
          WHERE `DATE` BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"          
					AND M1_START >= "'.$params['starttime'].'" AND M1_END <= "'.$params['endtime'].'" 
					AND CHANNEL IN('.$new_cin.') 
					AND PROFILE_ID = '.$params['profile'].' 
					) AS TVCSC
						GROUP BY M1,`DATE`,CHANNEL  
					ORDER BY `DATE`,M1,CHANNEL
					) K GROUP BY M1,`DATE`,CHANNEL

) KKL GROUP BY `DATE`,M1 
ORDER BY `DATE`,M1
					';
    //print_r($sql);die;
    $usql = $case_max.$case_str.$sql;    
    //print_r($usql);die;
		
    $out		= array();
		$query		= $this->db->query($usql,
			array(
				$params['starttime'],
				$params['endtime'],
				$params['start_date'],
				$params['end_date']
			));
		
    $result = $query->result_array();
		
    $total_filtered = $this->db->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= count($result);		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
	}               
    
  public function genresearch($strSearch,$role){ 
      $sql = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` in (0,-99) AND GENRE LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`GENRE`";               
      //print_r($sql);
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                                   
    
  public function profilesearch($strSearch,$iduser,$period){      
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1];         
      } 
      
      // ORIG
      //$sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub2 a INNER JOIN hrd_profile b ON a.user_id_profil=b.id WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND status_tvcc_str = 'Done' AND a.`name` LIKE '%".$strSearch."%'";
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
      //print_r($sql);
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }        
    
  public function channelsearch($strSearch,$strGenre){ 
      //$query = 'SELECT CHANNEL_RC as channel, COLOR FROM CHANNEL_PARAM WHERE F2A_STATUS=1 order by CHANNEL_RC';
       if($strGenre == "0"){
          $strWhere = "AND CHANNEL LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND CHANNEL LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND D.GENRE = '".$strGenre."' AND CHANNEL LIKE '%".strtoupper($strSearch)."%' ";
      }
      
      // $sql = "SELECT CHANNEL_NAME AS CHANNEL FROM `CHANNEL_PARAM` C
      // WHERE C.`F2A_STATUS` in (0,-99) ".$strWhere."  
      // ORDER BY C.`CHANNEL_NAME`";   

 // $sql = "SELECT CHANNEL_NAME_PROG AS CHANNEL FROM `CHANNEL_PARAM_FINAL` C
      // WHERE C.`FLAG_TV` = 1 ".$strWhere."  
	  // GROUP BY CHANNEL_NAME_PROG
      // ORDER BY C.`CHANNEL_NAME`";	 
	  
	  $sql = "SELECT CHANNEL AS CHANNEL FROM `M_SUMMARY_TVCC_30_TRANS` C
	  LEFT JOIN CDR_EPG_PARAM_TRANS D ON C.CHANNEL = D.CHANNEL_CDR
	  WHERE 1=1 ".$strWhere."  
	  GROUP BY C.CHANNEL 
      ORDER BY C.`CHANNEL`";	  
      // print_r($sql);die;
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }         
  
  public function checkdaypart($user_id,$daypart){ 
      $query 	= "SELECT COUNT(DAYPART1) AS CODAP FROM DAYPART WHERE USERID = '".$user_id."' AND DAYPART1 = '".$daypart."'";
      //print_r($sql);
            
      $sql	= $this->db->query($query);
  		$this->db->close();
  		$this->db->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CODAP'];
  }
  
  public function setdaypart($user_id,$start_time,$end_time){ 
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":00','0')";
      //print_r($sql);
            
      if ($sql) {
          $this->db->query($sql);
          
          $query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$user_id.'" AND MENUS="0" ORDER BY DAYPART1 ';			
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