<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postbuyadspeformance_model extends CI_Model {
	
	public function __construct()
	{
		  parent::__construct();
		  $this->db2 = $this->load->database('db_prod', TRUE);
		  $this->load->library('ClickHouse');
	}
  
	public function get_user_id($userid){
  		$sql = "SELECT user_id,grouping FROM  t_profiling_ub where `id` = ".$userid;
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  		
      return $result;
	}
	
	public function get_profile($iduser,$idrole,$period) {
          
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1];         
      }
      
  		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a JOIN M_MONTH_PROFILE_RES c ON a.`id` = c.`PROFILE_ID` 
		WHERE (STATUS = 1 OR STATUS = 3) AND flag = 1 AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
		
       
  		$out		= array();
  		$query		= $this->db2->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
	
	public function get_channel(){
  		$sql = "SELECT CHANNEL_CIM FROM `P_CHANNEL_ADS_USEETV` C
  WHERE C.`FLAG_TV` = 0 
  ORDER BY C.`CHANNEL_CIM`";
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(POSTBUY_FTA,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
  public function get_reach_m($params = array(),$re){
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
  		
  		if($params['start_date'] <> NULL){
  			$l_where_clause_startdate = $params['start_date'];
  		} else {
  			$l_where_clause_startdate = ''; 
  		}
  		
  		if($params['end_date'] <> NULL){
          $l_where_clause_enddate = $params['end_date'];
  		} else {
          $l_where_clause_enddate = ''; 
  		}
  		
  		if($params['kategoriby'] == 'null'){
          $l_where_clause_kategori = ''; 
  		} else {
			
			if($params['kategoriby'] == "advertiser"){
				
				$l_where_clause_kategori = ' AND ADVERTISER = "'.$params['kategori'].'"';
				
			}else{
				$l_where_clause_kategori = ' AND '.$params['kategoriby'].' = "'.$params['kategori'].'"';
			}
          
  		}
   	
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
  		} else {
          $f = explode(",",$params['chnl']);
    			$cin = "";
    			
    			foreach($f as $channel_f){
      				$cin = $cin."'".$channel_f."',";	
    			}
    			$new_cin = substr($cin, 0, -1);
          
    			$l_where_clause_channel = ' AND CHANNEL IN ('.$new_cin.') ';
  		}
  		

          $l_where_clause_cardno = $params['profile']; 

		$periode =date_format(date_create($params['start_date']),"Y-F");  
			
  			if($params['kategoriby'] == "product"){
  					$sql = "
						SELECT * FROM M_SUMM_REACH_PRODUCT_MONTHLY
						WHERE TANGGAL = '".$periode."'  
						AND ID_PROFILE = ".$params['profile']." 
						".$l_where_clause_kategori." 
						".$l_where_clause_channel." 
					
      				";
  			}elseif($params['kategoriby'] == "advertiser"){
					$sql = "
        				SELECT * FROM M_SUMM_REACH_ADVERTISER_MONTHLY
						WHERE TANGGAL = '".$periode."'  
						AND ID_PROFILE = ".$params['profile']." 
						".$l_where_clause_kategori." 
						".$l_where_clause_channel." 
        				";
  			}elseif($params['kategoriby'] == "sector"){
      				$sql = "
      					SELECT * FROM M_SUMM_REACH_SECTOR_MONTHLY
						WHERE TANGGAL = '".$periode."'  
						AND ID_PROFILE = ".$params['profile']." 
						".$l_where_clause_kategori." 
						".$l_where_clause_channel." 
      				";
  			}else{
					$sql = "
						SELECT * FROM M_SUMM_REACH_SECTOR_MONTHLY
						WHERE TANGGAL = '".$periode."'  
						AND ID_PROFILE = ".$params['profile']." 
						".$l_where_clause_kategori." 
						".$l_where_clause_channel." 
      				";					
  			}

		
		
       
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
  
  public function get_reach_per($params = array(),$re){
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
		
		$data_file = $params['start_date'];
			$date_epg = str_replace("-","",$data_file);
			
			$name_tb = strtoupper(date_format(date_create($data_file),"yM")); 
			$name_tbs = strtoupper(date_format(date_create($data_file),"My"));  
			$periode =date_format(date_create($data_file),"Y-F");  
  		
  		if($params['start_date'] <> NULL){
  			$l_where_clause_startdate = $params['start_date'];
  		} else {
  			$l_where_clause_startdate = ''; 
  		}
  		
  		if($params['end_date'] <> NULL){
          $l_where_clause_enddate = $params['end_date'];
  		} else {
          $l_where_clause_enddate = ''; 
  		}
  		
  		if($params['kategoriby'] == 'null'){
          $l_where_clause_kategori = ''; 
  		} else {
			
			if($params['kategoriby'] == "advertiser"){
				
				$l_where_clause_kategori = ' AND ADVERTISER = "'.$params['kategori'].'"';
				
			}else{
				$l_where_clause_kategori = ' AND '.$params['kategoriby'].' = "'.$params['kategori'].'"';
			}
          
  		}
   	
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
  		} else {
          $f = explode(",",$params['chnl']);
    			$cin = "";
    			
    			foreach($f as $channel_f){
      				$cin = $cin."'".$channel_f."',";	
    			}
    			$new_cin = substr($cin, 0, -1);
          
    			$l_where_clause_channel = ' AND CHANNEL IN ('.$new_cin.') ';
  		}
  		

          $l_where_clause_cardno = $params['profile']; 

		
			
 			
			
  			 if($params['kategoriby'] == "product"){
  					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,13340911 UNIVERSE, (VIEWERS0/13340911)*100 AS REACH0, (VIEWERS2/13340911)*100 AS REACH2,
      					(VIEWERS3/13340911)*100 AS REACH3,
      					(VIEWERS7/13340911)*100 AS REACH7,
      					(VIEWERS13/13340911)*100 AS REACH13,
      					(VIEWERS21/13340911)*100 AS REACH21 FROM (
      					  (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
							   GROUP BY PRODUCT
      					  ) AS VW0
      					   LEFT JOIN 
      						(
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
							  GROUP BY PRODUCT
      					  ) AS VW2 ON VW0.PRODUCT = VW2.PRODUCT 
      					  LEFT JOIN
      						 (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
							  GROUP BY PRODUCT
      					  ) AS VW3 ON VW2.PRODUCT = VW3.PRODUCT 
      					  LEFT JOIN
      						(
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
							  GROUP BY PRODUCT
      					  ) AS VW7 ON VW3.PRODUCT = VW7.PRODUCT 
      					  LEFT JOIN
      					  (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
							  GROUP BY PRODUCT
      					  ) AS VW13 ON VW7.PRODUCT = VW13.PRODUCT 
      					  LEFT JOIN
      					  (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
							  GROUP BY PRODUCT
      					  ) AS VW21 ON VW13.PRODUCT = VW21.PRODUCT 
      					)
      				";
  				}elseif($params['kategoriby'] == "advertiser"){
                $sql = "
        				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,13340911 UNIVERSE, (VIEWERS0/13340911)*100 AS REACH0, (VIEWERS2/13340911)*100 AS REACH2,
        					(VIEWERS3/13340911)*100 AS REACH3,
        					(VIEWERS7/13340911)*100 AS REACH7,
        					(VIEWERS13/13340911)*100 AS REACH13,
        					(VIEWERS21/13340911)*100 AS REACH21 FROM (
        					  (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS0 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_RES
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 1 
								  GROUP BY ADVERTISER
        					  ) AS VW0
        					   LEFT JOIN 
        						(
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS2 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_RES
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 2
								  GROUP BY ADVERTISER
        					  ) AS VW2 ON VW0.ADVERTISER = VW2.ADVERTISER 
      					  LEFT JOIN
        						 (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS3 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_RES
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 3
								  GROUP BY ADVERTISER
        					  ) AS VW3 ON VW2.ADVERTISER = VW3.ADVERTISER 
      					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS7 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_RES
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 7
								  GROUP BY ADVERTISER
        					  ) AS VW7 ON VW3.ADVERTISER = VW7.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS13 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_RES
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 13
								  GROUP BY ADVERTISER
        					  ) AS VW13 ON VW7.ADVERTISER = VW13.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS21 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_RES
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 21
								  GROUP BY ADVERTISER
        					  ) AS VW21 ON VW13.ADVERTISER = VW21.ADVERTISER 
        					)
        				";
  				}elseif($params['kategoriby'] == "sector"){
      					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,13340911 UNIVERSE, (VIEWERS0/13340911)*100 AS REACH0, (VIEWERS2/13340911)*100 AS REACH2,
      					(VIEWERS3/13340911)*100 AS REACH3,
      					(VIEWERS7/13340911)*100 AS REACH7,
      					(VIEWERS13/13340911)*100 AS REACH13,
      					(VIEWERS21/13340911)*100 AS REACH21 FROM (
      					  (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
							  GROUP BY SECTOR
      					  ) AS VW0
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
							  GROUP BY SECTOR
      					  ) AS VW2 ON VW0.SECTOR = VW2.SECTOR 
      					  LEFT JOIN
      						 (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
							  GROUP BY SECTOR
      					  ) AS VW3 ON VW2.SECTOR = VW3.SECTOR 
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
							  GROUP BY SECTOR
      					  ) AS VW7 ON VW3.SECTOR = VW7.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
							  GROUP BY SECTOR
      					  ) AS VW13 ON VW7.SECTOR = VW13.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
							  GROUP BY SECTOR
      					  ) AS VW21 ON VW13.SECTOR = VW21.SECTOR 
      					)
      				";
  				}else{
              $sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
      					  ) AS VW0
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
      					  ) AS VW2
      					  ,
      						 (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
      					  ) AS VW3
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
      					  ) AS VW7
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
      					  ) AS VW13
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_RES
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
      					  ) AS VW21
      					  ,
      					  (
      							SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' 
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";					
  				}
  		
		
		
       
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
  
  
	public function get_reach_nil($params = array(),$re){
		
		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0;
      
  		if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ""; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = "AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
                                                                  
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
      }else{
          $l_where_clause_kategori = " AND B.".strtoupper($params['kategoriby'])." = '".$params['kategori']."' ";
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '' || $params['chnl'] == '0'){ 
          $l_where_clause_channel = ''; 
      } else {
           $cin = "";
 
		  
		  $tasa = explode(',',$params['chnl']);
          
		  foreach($tasa as $channel_f){
             
                  $cin = $cin."'".$channel_f."',";

          }
		  
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
 
      }
      
   		$sql2 = "SELECT
  			AVG(Reach1) AS r1,
  			AVG(Reach2) AS r2,
  			AVG(Reach3) AS r3,
  			AVG(Reach4) AS r4,
  			AVG(Reach5) AS r5,
  			AVG(reach_views) AS reach_views,
			SUM(TVR) AS sumtvr			FROM ( 
		
		SELECT B.* FROM M_CIM_F2A_SUMMARY_CB_RES A
        JOIN `MDM_RAW_CIM_PART2_V2` B ON A.CHANNEL = B.CHANNEL AND A.START_TIME = B.START_TIME
  		WHERE B.SECTOR <> 'NON-COMMERCIAL ADVERTISEMENT'
  			 
  		AND ID_PROFILE=".$params['profile']." 
  		 ".$l_where_clause_startdate."
  		 ".$l_where_clause_enddate."
  		".$l_where_clause_kategori."
  		".$l_where_clause_channel."
		   
		) L
  		 ";
   		
      $out		= array();
	  $query2		= $this->db2->query($sql2);
	  $result = $query2->result_array();
	  
  	 
  		return $result;	
		
		
	}
  

  
	public function get_reach($params = array(),$re){
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
		
		$data_file = $params['start_date'];
			$date_epg = str_replace("-","",$data_file);
			
			$name_tb = strtoupper(date_format(date_create($data_file),"yM")); //18MAR
			$name_tbs = strtoupper(date_format(date_create($data_file),"My")); //MAR18
			$periode =date_format(date_create($data_file),"Y-F"); //2018-March
  		
  		if($params['start_date'] <> NULL){
  			$l_where_clause_startdate = $params['start_date'];
  		} else {
  			$l_where_clause_startdate = ''; 
  		}
  		
  		if($params['end_date'] <> NULL){
          $l_where_clause_enddate = $params['end_date'];
  		} else {
          $l_where_clause_enddate = ''; 
  		}
  		
  		if($params['kategoriby'] == 'null'){
          $l_where_clause_kategori = ''; 
  		} else {
			
			if($params['kategoriby'] == "advertiser"){
				
				$l_where_clause_kategori = " AND ADVERTISER = '".$params['kategori']."'";
				
			}else{
				$l_where_clause_kategori = " AND ".strtoupper($params['kategoriby'])." = '".$params['kategori']."'";
			}
          
  		}
   	
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
  		} else {
          $f = explode(",",$params['chnl']);
    			$cin = "";
    			
    			foreach($f as $channel_f){
      				$cin = $cin."'".$channel_f."',";	
    			}
    			$new_cin = substr($cin, 0, -1);
          
    			$l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
  		}
  		

          $l_where_clause_cardno = $params['profile']; 
  		

		$db = $this->clickhouse->db();
			
 			
			
  			 if($params['kategoriby'] == "product"){
  					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,17328363 UNIVERSE, (VIEWERS0/17328363)*100 AS REACH0, (VIEWERS2/17328363)*100 AS REACH2,
      					(VIEWERS3/17328363)*100 AS REACH3,
      					(VIEWERS7/17328363)*100 AS REACH7,
      					(VIEWERS13/17328363)*100 AS REACH13,
      					(VIEWERS21/17328363)*100 AS REACH21 FROM 
      					  (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS0 FROM
      						  (
      							SELECT RESPID,WEIGHT,PRODUCT,count(PRODUCT) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,PRODUCT
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
							   GROUP BY PRODUCT
      					  ) AS VW0
      					   LEFT JOIN 
      						(
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS2 FROM
      						  (
      							SELECT RESPID,WEIGHT,PRODUCT,count(PRODUCT) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
							  GROUP BY PRODUCT
      					  ) AS VW2 ON VW0.PRODUCT = VW2.PRODUCT 
      					  LEFT JOIN
      						 (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS3 FROM
      						  (
      							SELECT RESPID,WEIGHT,PRODUCT,count(PRODUCT) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
							  GROUP BY PRODUCT
      					  ) AS VW3 ON VW2.PRODUCT = VW3.PRODUCT 
      					  LEFT JOIN
      						(
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS7 FROM
      						  (
      							SELECT RESPID,WEIGHT,PRODUCT,count(PRODUCT) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
							  GROUP BY PRODUCT
      					  ) AS VW7 ON VW3.PRODUCT = VW7.PRODUCT 
      					  LEFT JOIN
      					  (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS13 FROM
      						  (
      							SELECT RESPID,WEIGHT,PRODUCT,count(PRODUCT) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
							  GROUP BY PRODUCT
      					  ) AS VW13 ON VW7.PRODUCT = VW13.PRODUCT 
      					  LEFT JOIN
      					  (
      						  SELECT PRODUCT,SUM(WEIGHT) AS VIEWERS21 FROM
      						  (
      							SELECT RESPID,WEIGHT,PRODUCT,count(PRODUCT) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
							  GROUP BY PRODUCT
      					  ) AS VW21 ON VW13.PRODUCT = VW21.PRODUCT 
      					
      				";
  				}elseif($params['kategoriby'] == "advertiser"){
                $sql = "
        				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,17328363 UNIVERSE, (VIEWERS0/17328363)*100 AS REACH0, (VIEWERS2/17328363)*100 AS REACH2,
        					(VIEWERS3/17328363)*100 AS REACH3,
        					(VIEWERS7/17328363)*100 AS REACH7,
        					(VIEWERS13/17328363)*100 AS REACH13,
        					(VIEWERS21/17328363)*100 AS REACH21 FROM 
        					  (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS0 FROM
        						  (
        							SELECT RESPID,WEIGHT,ADVERTISER,count(ADVERTISER) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID,WEIGHT,ADVERTISER
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 1 
								  GROUP BY ADVERTISER
        					  ) AS VW0
        					   LEFT JOIN 
        						(
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS2 FROM
        						  (
        							SELECT RESPID,WEIGHT,ADVERTISER,count(ADVERTISER) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID,WEIGHT,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 2
								  GROUP BY ADVERTISER
        					  ) AS VW2 ON VW0.ADVERTISER = VW2.ADVERTISER 
      					  LEFT JOIN
        						 (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS3 FROM
        						  (
        							SELECT RESPID,WEIGHT,ADVERTISER,count(ADVERTISER) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID,WEIGHT,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 3
								  GROUP BY ADVERTISER
        					  ) AS VW3 ON VW2.ADVERTISER = VW3.ADVERTISER 
      					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS7 FROM
        						  (
        							SELECT RESPID,WEIGHT,ADVERTISER,count(ADVERTISER) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID,WEIGHT,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 7
								  GROUP BY ADVERTISER
        					  ) AS VW7 ON VW3.ADVERTISER = VW7.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS13 FROM
        						  (
        							SELECT RESPID,WEIGHT,ADVERTISER,count(ADVERTISER) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID,WEIGHT,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 13
								  GROUP BY ADVERTISER
        					  ) AS VW13 ON VW7.ADVERTISER = VW13.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,SUM(WEIGHT) AS VIEWERS21 FROM
        						  (
        							SELECT RESPID,WEIGHT,ADVERTISER,count(ADVERTISER) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY RESPID,WEIGHT,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 21
								  GROUP BY ADVERTISER
        					  ) AS VW21 ON VW13.ADVERTISER = VW21.ADVERTISER 
        					
        				";
  				}elseif($params['kategoriby'] == "sector"){
      					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,17328363 UNIVERSE, (VIEWERS0/17328363)*100 AS REACH0, (VIEWERS2/17328363)*100 AS REACH2,
      					(VIEWERS3/17328363)*100 AS REACH3,
      					(VIEWERS7/17328363)*100 AS REACH7,
      					(VIEWERS13/17328363)*100 AS REACH13,
      					(VIEWERS21/17328363)*100 AS REACH21 FROM 
      					  (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS0 FROM
      						  (
      							SELECT RESPID,WEIGHT,SECTOR,count(SECTOR) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,SECTOR
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
							  GROUP BY SECTOR
      					  ) AS VW0
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS2 FROM
      						  (
      							SELECT RESPID,WEIGHT,SECTOR,count(SECTOR) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
							  GROUP BY SECTOR
      					  ) AS VW2 ON VW0.SECTOR = VW2.SECTOR 
      					  LEFT JOIN
      						 (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS3 FROM
      						  (
      							SELECT RESPID,WEIGHT,SECTOR,count(SECTOR) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
							  GROUP BY SECTOR
      					  ) AS VW3 ON VW2.SECTOR = VW3.SECTOR 
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS7 FROM
      						  (
      							SELECT RESPID,WEIGHT,SECTOR,count(SECTOR) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
							  GROUP BY SECTOR
      					  ) AS VW7 ON VW3.SECTOR = VW7.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS13 FROM
      						  (
      							SELECT RESPID,WEIGHT,SECTOR,count(SECTOR) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
							  GROUP BY SECTOR
      					  ) AS VW13 ON VW7.SECTOR = VW13.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,SUM(WEIGHT) AS VIEWERS21 FROM
      						  (
      							SELECT RESPID,WEIGHT,SECTOR,count(SECTOR) AS COUNT_VIEW FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY RESPID,WEIGHT,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
							  GROUP BY SECTOR
      					  ) AS VW21 ON VW13.SECTOR = VW21.SECTOR 
      					
      				";
  				}else{
              $sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT A.* FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
      					  ) AS VW0
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
      						  (
      							SELECT A.* FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
      					  ) AS VW2
      					  ,
      						 (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT A.* FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
      					  ) AS VW3
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT A.* FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
      					  ) AS VW7
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT A.* FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
      					  ) AS VW13
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
      						  (
      							SELECT A.* FROM M_SUMM_REACH_RES A
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
      					  ) AS VW21
      					  ,
      					  (
      							SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' 
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";					
  				}
  		
		
       
  		$out		= array();
  
		
		$query2 = $db->select($sql);
		$result =  $query2->rows();
  			
  		return $result;
	}
	
	
	
	
	public function _get_filter_adspeformance($params = array()) {		
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
	  if($params['searchtxt'] == ''){
		  $where_search = '';
	  }else{
		  
		  $where_search = " AND (`CHANNEL` LIKE '%".$params['searchtxt']."%' OR `PROGRAM` LIKE '%".$params['searchtxt']."%' OR `SECTOR` LIKE '%".$params['searchtxt']."%' OR `PRODUCT` LIKE '%".$params['searchtxt']."%' OR `ADVERTISER` LIKE '%".$params['searchtxt']."%' OR `START_TIME` LIKE '%".$params['searchtxt']."%' OR `DURATION` LIKE '%".$params['searchtxt']."%' OR `TYPE` LIKE '%".$params['searchtxt']."%' ) ";
	  }
	  
      if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ""; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = "AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
                                                                  
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
      }else{
          $l_where_clause_kategori = " AND ".strtoupper($params['kategoriby'])." = '".$params['kategori']."' ";
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '' || $params['chnl'] == '0'){ 
          $l_where_clause_channel = ''; 
      } else {
           $cin = "";
 
		  
		  $tasa = explode(',',$params['chnl']);
          
		  foreach($tasa as $channel_f){
             
                  $cin = $cin."'".$channel_f."',";

          }
		  
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
  
      }
 	  
	  $db = $this->clickhouse->db();
      
      $sql = "SELECT COUNT(*) AS jumlah 
      FROM ( SELECT CHANNEL, PROGRAM, SECTOR, CATEGORY, ADVERTISER, PRODUCT ,START_TIME,END_TIME,DATE_UNICS FROM M_CIM_F2A_SUMMARY_CB_RES as tcn
      WHERE SECTOR <> 'NON-COMMERCIAL ADVERTISEMENT'
      AND ID_PROFILE=".$params['profile']."	 
      ".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	  ".$where_search."
      GROUP BY CHANNEL, PROGRAM, SECTOR, CATEGORY, ADVERTISER, PRODUCT ,START_TIME,END_TIME,DATE_UNICS     
	  ) L";
	  
       
      $out		= array();
 
	  $query = $db->select($sql);
	  $result =  $query->rows();	  
      
 	  
      $total_filtered = $result[0]['jumlah'];
      $total 			= $result[0]['jumlah'];
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "SELECT DATE_UNICS AS TANGGAL, 
      DATE_UNICS,
      CHANNEL, 
      PROGRAM, 
      PRODUCT, 
      ADVERTISER, 
      SECTOR, 
	  COST,
      START_TIME, 
      `TYPE` AS ADS_TYPE,
      TVR as TVR,  
      DURATION_INT, DURATION, VIEWERS  , VIEWERS_ALL, TVR_ALL
      FROM ( SELECT *,DATE_UNICS AS TANGGAL FROM M_CIM_F2A_SUMMARY_CB_RES
      WHERE ID_PROFILE=".$params['profile']."	 
      ".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	  ".$where_search."
      ORDER BY ".$params['order_column']." ".$params['order_dir']."
      LIMIT ".$params['limit']." 
      OFFSET ".$params['offset']." ) L ";	
 	

	  $query2 = $db->select($sql2);
	  $result2 =  $query2->rows();	
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	
	
	public function _get_filter_adspeformance_summ2($params = array()) {		
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
	   if($params['searchtxt'] == ''){
		  $where_search = '';
	  }else{
		  
		  $where_search = " AND (`CHANNEL` LIKE '%".$params['searchtxt']."%' OR `PROGRAM` LIKE '%".$params['searchtxt']."%' OR `SECTOR` LIKE '%".$params['searchtxt']."%' OR `PRODUCT` LIKE '%".$params['searchtxt']."%' OR `ADVERTISER` LIKE '%".$params['searchtxt']."%' OR `START_TIME` LIKE '%".$params['searchtxt']."%' OR `DURATION` LIKE '%".$params['searchtxt']."%' OR `TYPE` LIKE '%".$params['searchtxt']."%' ) ";
	  }
	  
      if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ""; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = "AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
                                                                  
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
      }else{
          $l_where_clause_kategori = " AND ".strtoupper($params['kategoriby'])." = '".$params['kategori']."' ";
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '' || $params['chnl'] == '0'){ 
          $l_where_clause_channel = ''; 
      } else {
           $cin = "";
      
 
		  
		  $tasa = explode(',',$params['chnl']);
          
		  foreach($tasa as $channel_f){
             
                  $cin = $cin."'".$channel_f."',";

          }
		  
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
  
      }
 	  
	  $db = $this->clickhouse->db();
      
      $sql = "SELECT COUNT(*) AS jumlah 
      FROM ( SELECT CHANNEL,COST FROM M_CIM_F2A_SUMMARY_CB_RES as tcn
      WHERE SECTOR <> 'NON-COMMERCIAL ADVERTISEMENT'
      AND ID_PROFILE=".$params['profile']."	 
      ".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	  ".$where_search."
      GROUP BY CHANNEL ,COST
	  ) L";
       
      $out		= array();
 
	   $query = $db->select($sql);
	  $result =  $query->rows();
 
	   $total_filtered = $result[0]['jumlah'];
      $total 			= $result[0]['jumlah'];
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "SELECT * FROM (SELECT 
	  CHANNEL,
	  COUNT(PROGRAM) AS SPOT,
      SUM(TVR) as TVR,  
	  COST,
      SUM(TVR_ALL) AS TVR_ALL
      FROM ( SELECT * FROM M_CIM_F2A_SUMMARY_CB_RES
      WHERE ID_PROFILE=".$params['profile']."	 
      ".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	  ".$where_search."
	    
       ) L 
	  GROUP BY CHANNEL,COST
	  
	  ) OP 
	  ORDER BY SPOT DESC
      LIMIT ".$params['limit']." 
      OFFSET ".$params['offset']."
	  ";	
 		

	  $query2 = $db->select($sql2);
	  $result2 =  $query2->rows();	
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	
	
	public function _get_filter_adspeformance_summ1($params = array()) {		
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
	  if($params['searchtxt'] == ''){
		  $where_search = '';
	  }else{
		  
		  $where_search = " AND (`CHANNEL` LIKE '%".$params['searchtxt']."%' OR `PROGRAM` LIKE '%".$params['searchtxt']."%' OR `SECTOR` LIKE '%".$params['searchtxt']."%' OR `PRODUCT` LIKE '%".$params['searchtxt']."%' OR `ADVERTISER` LIKE '%".$params['searchtxt']."%' OR `START_TIME` LIKE '%".$params['searchtxt']."%' OR `DURATION` LIKE '%".$params['searchtxt']."%' OR `TYPE` LIKE '%".$params['searchtxt']."%' ) ";
	  }
	  
      if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ""; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = "AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
                                                                  
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
      }else{
          $l_where_clause_kategori = " AND ".strtoupper($params['kategoriby'])." = '".$params['kategori']."' ";
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '' || $params['chnl'] == '0'){ 
          $l_where_clause_channel = ''; 
      } else {
           $cin = "";
 
		  
		  $tasa = explode(',',$params['chnl']);
          
		  foreach($tasa as $channel_f){
             
                  $cin = $cin."'".$channel_f."',";

          }
		  
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
 
      }
 	  $db = $this->clickhouse->db();
      
      $sql = "SELECT COUNT(*) AS jumlah 
      FROM ( SELECT CHANNEL, PROGRAM, COST FROM M_CIM_F2A_SUMMARY_CB_RES as tcn
      WHERE SECTOR <> 'NON-COMMERCIAL ADVERTISEMENT'
      AND ID_PROFILE=".$params['profile']."	 
      ".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	  ".$where_search."
      GROUP BY CHANNEL, PROGRAM, COST 
	  ) L";
       
      $out		= array();
   
	  $query = $db->select($sql);
	  $result =  $query->rows();
      
 	  
      $total_filtered = $result[0]['jumlah'];
      $total 			= $result[0]['jumlah'];
 
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "SELECT * FROM ( SELECT
		CHANNEL, 
      PROGRAM, 
	  COUNT(PROGRAM) AS SPOT,
	  COST,
      SUM(TVR) as TVR,  
      SUM(TVR_ALL) TVR_ALL
      FROM ( SELECT *,DATE_UNICS AS TANGGAL FROM M_CIM_F2A_SUMMARY_CB_RES
      WHERE ID_PROFILE=".$params['profile']."	 
      ".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	  ".$where_search."
	      
       ) L 
	  GROUP BY CHANNEL, PROGRAM, COST
	  
	  ) OP 
	  ORDER BY SPOT DESC
      LIMIT ".$params['limit']." 
      OFFSET ".$params['offset']."
	  ";	
  	

		$query2 = $db->select($sql2);
	  $result2 =  $query2->rows();	
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}

	public function list_adspeformance($params = array()) {	
  		$sql = "SELECT DATE_UNICS AS TANGGAL, 
  		DATE_UNICS,
  					CHANNEL, 
  					PROGRAM, 
  					PRODUCT, 
  					ADVERTISER, 
  					SECTOR, 
  					START_TIME, 
  					`TYPE` AS ADS_TYPE,
  					TVR as TVR,  
  					DURATION_INT, DURATION, VIEWERS 
  		FROM ( SELECT *,DATE_UNICS AS TANGGAL FROM M_CIM_F2A_SUMMARY_CB 
  		WHERE SECTOR <> 'NON-COMMERCIAL ADVERTISEMENT' 
  		AND ID_PROFILE=0 AND DATE_UNICS BETWEEN '2017-08-01' AND '2017-08-31'
  		ORDER BY ".$params['order_column']." ".$params['order_dir']."   
		GROUP BY CHANNEL, PROGRAM, SECTOR, CATEGORY, ADVERTISER, PRODUCT ,START_TIME,END_TIME,DATE_UNICS     
  		LIMIT ".$params['limit']." 
  		OFFSET ".$params['offset']." ) L " ;
       
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
      
  		$sql2 = "SELECT COUNT(*) AS jumlah
  		FROM ( SELECT * FROM M_CIM_F2A_SUMMARY_CB tcn  
  		WHERE ID_PROFILE=0
		GROUP BY CHANNEL, PROGRAM, SECTOR, CATEGORY, ADVERTISER, PRODUCT ,START_TIME,END_TIME,DATE_UNICS
		) L
  		";
      
  		$out		= array();
  		$query2		= $this->db->query($sql2);
  		$result2 = $query2->row();
  
  		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
      		if($l_result = mysqli_store_result($this->db->conn_id)){
              mysqli_free_result($l_result);
          }
  		}
      
  		$total_filtered = $result2->jumlah;
  		$total 			= $result2->jumlah;
  		
  		$return = array(
          'data' => $result,
          'total_filtered' => $total_filtered,
          'total' => $total,
  		);
      
  		return $return;
	}

	public function get_filter_grandtotal_adspeformance($params = array()) {	
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0;
      
  		if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ""; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = "AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
                                                                  
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
      }else{
          $l_where_clause_kategori = " AND ".strtoupper($params['kategoriby'])." = '".$params['kategori']."' ";
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '' || $params['chnl'] == '0'){ 
          $l_where_clause_channel = ''; 
      } else {
           $cin = "";
      
   
		  
		  $tasa = explode(',',$params['chnl']);
          
		  foreach($tasa as $channel_f){
             
                  $cin = $cin."'".$channel_f."',";

          }
		  
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
          
 
      }
      
	  $db = $this->clickhouse->db();
  		$sql2 = "SELECT
  			SUM(COST) AS sumcost, 
  			SUM(TVR_ALL) AS sumtvr, 
  			MAX(TVR_ALL) AS maxtvr, 
  			MIN(TVR_ALL) AS mintvr, 
  			AVG(TVR_ALL) AS avgtvr,
  			(SUM(COST)*1000) / SUM(TVR_ALL) as cprp,  
  			COUNT(DATE_UNICS) AS spot, 
        SUM(VIEWERS) AS sumviewers  FROM ( SELECT * FROM M_CIM_F2A_SUMMARY_CB_RES
  		WHERE SECTOR <> 'NON-COMMERCIAL ADVERTISEMENT'
  			 
  		AND ID_PROFILE=".$params['profile']." 
  		 ".$l_where_clause_startdate."
  		 ".$l_where_clause_enddate."
  		".$l_where_clause_kategori."
  		".$l_where_clause_channel."
		   
		) L
  		 ";
   		
      $out		= array();
 
		
		 $query = $db->select($sql2);
		$result =  $query->rows();
  		return $result;	
	}	
	
	public function get_filter_grandtotal_adspeformance_nil($params = array()) {	
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0;
      
  		if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ""; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = "AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
                                                                  
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
      }else{
          $l_where_clause_kategori = " AND B.".strtoupper($params['kategoriby'])." = '".$params['kategori']."' ";
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '' || $params['chnl'] == '0'){ 
          $l_where_clause_channel = ''; 
      } else {
           $cin = "";
 
		  
		  $tasa = explode(',',$params['chnl']);
          
		  foreach($tasa as $channel_f){
             
                  $cin = $cin."'".$channel_f."',";

          }
		  
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
 
      }
      
	 
		 $sql2 = "
		 SELECT COUNT(*) spot,SUM(`Cost`) sumcost,SUM(TVR) sumtvr,(SUM(COST)*1000)/SUM(TVR) cprp,MAX(TVR) maxtvr,MIN(TVR) mintvr,AVG(TVR) avgtvr,SUM(Views) AS sumviewers, AVG(Reach1) Reach1
				,AVG(Reach2) Reach2,AVG(Reach3) Reach3,AVG(Reach4) Reach4,AVG(Reach5) Reach5 FROM `MDM_RAW_CIM_PART2`
				WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
		 ";
   		
      $out		= array();
  		$query2		= $this->db2->query($sql2);
  
  		 
  		
  		$result = $query2->result_array();
 
  		return $result;	
	}                              
  
  public function listsearch($sSearch,$kategori,$sdate,$edate){
  		$kategori = strtoupper($kategori);
      $sSearch = strtoupper($sSearch);
      
      $sql 	= "SELECT DISTINCT(SUBCAT) AS SEARH_RESULT FROM M_POSTBUY_SUBCAT_08_FTA
  		WHERE STR_TO_DATE(`DATE`,'%Y-%m-%d') >= '".$sdate."' 
      AND STR_TO_DATE(`DATE`,'%Y-%m-%d') <= '".$edate."'    
      AND CAT = '".$kategori."'  
      AND SUBCAT LIKE '%".$sSearch."%'   
  		ORDER BY SUBCAT ASC;";
     
  		$query 	=  $this->db->query($sql);
  		$this->db->close();
  		$this->db->initialize(); 
  		
  		$return = $query->result_array();
  		return $return;
	}                                        
    
  public function profilesearch($strSearch,$iduser,$period){ 
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1];         
      }
            
 
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub a JOIN M_MONTH_PROFILE c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }            
    
  public function channelsearch($strSearch,$role){ 
      $sql = "SELECT CHANNEL_CIM AS CHANNEL FROM `P_CHANNEL_ADS_USEETV` C
      WHERE C.`FLAG_TV` = 0 AND CHANNEL_CIM LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`CHANNEL_CIM`";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }
  
  public function _list_subkategori($params){
		$kategori = strtoupper($params['kategori']);
		
		 
	
	 $sql 	= "SELECT DISTINCT(".$kategori.") AS ".$kategori." FROM M_CIM_F2A_SUMMARY_CB_RES
		WHERE DATE_UNICS >= '".$params['start_date']."' 
    AND DATE_UNICS <= '".$params['end_date']."'
		ORDER BY ".$kategori." ASC";
	
 		$out		= array();
		$query 	=  $this->db2->query($sql);
		
 		
		$this->db2->close();
		$this->db2->initialize(); 
		
		$return = $query->result_array();
		return $return;
 
		
	}
}