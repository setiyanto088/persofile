<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postbuyadspeformance_model extends CI_Model {
	
	public function __construct()
	{
		  parent::__construct();
		  //$this->db2 = $this->load->database('db_prod', TRUE);
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
      
  		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a JOIN (SELECT * FROM M_MONTH_PROFILE_RES UNION ALL SELECT * FROM M_MONTH_PROFILE_RES_P22) c ON a.`id` = c.`PROFILE_ID` 
		WHERE (STATUS IN (1,2,3)) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
		
	  
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
	
	public function get_channel(){
 
		$db = $this->clickhouse->db();
  
		$sql = "SELECT DISTINCT(CHANNEL) as channel FROM PTV_CIM_RATING_RES order by CHANNEL";  
  		 $querys		= $db->select($sql);
		  $result = $querys->rows();
		  return $result;
	}
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(POSTBUY_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
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
				
			}else if($params['kategoriby'] == "NAMA_BRAND"){
				
				$l_where_clause_kategori = ' AND BRAND = "'.$params['kategori'].'"';
				
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
			
  			if($params['kategoriby'] == "NAMA_BRAND"){
  					$sql = "
						SELECT BRAND AS NAMA_BRAND, * FROM PTV_REACH_BRAND_MONTHLY
						WHERE TANGGAL = '".$periode."'  
						AND ID_PROFILE = ".$params['profile']." 
						".$l_where_clause_kategori." 
						".$l_where_clause_channel." 
					
      				";
  			}elseif($params['kategoriby'] == "ADVERTISER"){
					$sql = "
        				SELECT * FROM PTV_REACH_ADVERTISER_MONTHLY
						WHERE TANGGAL = '".$periode."'  
						AND ID_PROFILE = ".$params['profile']." 
						".$l_where_clause_kategori." 
						".$l_where_clause_channel." 
        				";
  			}elseif($params['kategoriby'] == "AGENCY"){
      				$sql = "
      					SELECT * FROM PTV_REACH_AGENCY_MONTHLY
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
  		$query		= $this->db2->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
  
	public function get_reach($params = array(),$re){
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
  		
			$data_file = $params['start_date'];
			$date_epg = str_replace("-","",$data_file);
			
			$name_tb = strtoupper(date_format(date_create($data_file),"yM")); 
			$name_tbs = strtoupper(date_format(date_create($data_file),"My"));  
			$periode =date_format(date_create($data_file),"Y-F"); 
		
  		if($params['start_date'] <> NULL){
  			$l_where_clause_startdate = 'AND STR_TO_DATE(`DATE_UNICS`,"%Y-%m-%d") >= "'.$params['start_date'].'" ';
  		} else {
  			$l_where_clause_startdate = ''; 
  		}
  		
  		if($params['end_date'] <> NULL){
          $l_where_clause_enddate = ' AND STR_TO_DATE(`DATE_UNICS`,"%Y-%m-%d") <= "'.$params['end_date'].'" ';
  		} else {
          $l_where_clause_enddate = ''; 
  		}
  		
  		if($params['kategoriby'] == 'null'){
          $l_where_clause_kategori = ''; 
      } else {
          if($params['kategoriby'] == "PO_NUMBER"){
              $l_where_clause_kategori = ' AND REPLACE('.$params['kategoriby'].', "\r", "") = "'.$params['kategori'].'" ';
          } else {
              $l_where_clause_kategori = ' AND '.$params['kategoriby'].' = "'.$params['kategori'].'" ';
          }
      }
  	
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND PROVIDER LIKE '%UseeTV%' "; 
      } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND PROVIDER LIKE '%Mediahub%' "; 
      } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = ' AND CHANNEL IN ('.$new_cin.') ';
      }
  		

          $l_where_clause_cardno = ''; 
      
  		if($params['sqlc'] == ""){
  			 if($params['kategoriby'] == "NAMA_BRAND"){
  					$sql = "
      				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS_A1/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 1 
							   GROUP BY NAMA_BRAND
      					  ) AS VW0
      					  LEFT JOIN 
      						(
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 2
							   GROUP BY NAMA_BRAND
      					  ) AS VW2 ON VW0.NAMA_BRAND = VW2.NAMA_BRAND 
      					  LEFT JOIN
      						 (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 3
							   GROUP BY NAMA_BRAND
      					  ) AS VW3 ON VW2.NAMA_BRAND = VW3.NAMA_BRAND 
      					  LEFT JOIN
      						(
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 7
							   GROUP BY NAMA_BRAND
      					  ) AS VW7 ON VW3.NAMA_BRAND = VW7.NAMA_BRAND 
      					  LEFT JOIN
      					  (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 13
							   GROUP BY NAMA_BRAND
      					  ) AS VW13 ON VW7.NAMA_BRAND = VW13.NAMA_BRAND 
      					  LEFT JOIN
      					  (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'  
      							
      							".$l_where_clause_kategori."  
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 21
							   GROUP BY NAMA_BRAND
      					  ) AS VW21 ON VW13.NAMA_BRAND = VW21.NAMA_BRAND
      					  ,
      					  (
      					  SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 2  
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";
  				}elseif($params['kategoriby'] == "ADVERTISER"){
                $sql = "
        				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
        					(VIEWERS3/UNIVERSE)*100 AS REACH3,
        					(VIEWERS7/UNIVERSE)*100 AS REACH7,
        					(VIEWERS13/UNIVERSE)*100 AS REACH13,
        					(VIEWERS_A1/UNIVERSE)*100 AS REACH21 FROM (
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE CNT >= 1 
								   GROUP BY ADVERTISER
        					  ) AS VW0
        					 LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE CNT >= 2
								   GROUP BY ADVERTISER
        					  ) AS VW2 ON VW0.ADVERTISER = VW2.ADVERTISER 
      					  LEFT JOIN
        						 (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE CNT >= 3
								   GROUP BY ADVERTISER
        					  ) AS VW3 ON VW2.ADVERTISER = VW3.ADVERTISER 
      					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE CNT >= 7
								   GROUP BY ADVERTISER
        					  ) AS VW7
        					   ON VW3.ADVERTISER = VW7.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE CNT >= 13
								   GROUP BY ADVERTISER
        					  ) AS VW13 ON VW7.ADVERTISER = VW13.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE CNT >= 21
								  GROUP BY ADVERTISER
        					  ) AS VW21 ON VW13.ADVERTISER = VW21.ADVERTISER
      					  ,
        					  (
        					    SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 2  
        					  )
        					  AS UNIVERSE_REACH
        					)
        				";
  				}elseif($params['kategoriby'] == "AGENCY"){
      					$sql = "
      				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS_A1/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 1 
							   GROUP BY AGENCY
      					  ) AS VW0
      					 LEFT JOIN 
      						(
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 2
							   GROUP BY AGENCY
      					  ) AS VW2 ON VW0.AGENCY = VW2.AGENCY 
      					  LEFT JOIN
      						 (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 3
							   GROUP BY AGENCY
      					  ) AS VW3 ON VW2.AGENCY = VW3.AGENCY 
      					  LEFT JOIN
      						(
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 7
							   GROUP BY AGENCY
      					  ) AS VW7 ON VW3.AGENCY = VW7.AGENCY 
      					  LEFT JOIN
      					  (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 13
							   GROUP BY AGENCY
      					  ) AS VW13 ON VW7.AGENCY = VW13.AGENCY 
      					  LEFT JOIN
      					  (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 21
							    GROUP BY AGENCY
      					  ) AS VW21 ON VW13.AGENCY = VW21.AGENCY 
      					  ,
      					  (
      					    SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 2 
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";
  				}else{
              $sql = "
      				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 1 
      					  ) AS VW0
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 2
      					  ) AS VW2
      					  ,
      						 (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 3
      					  ) AS VW3
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 7
      					  ) AS VW7
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 13
      					  ) AS VW13
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 21
      					  ) AS VW21
      					  ,
      					  (
      							SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR' 
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";					
  				}
  		}else{
  			 if($params['kategoriby'] == "NAMA_BRAND"){
  					$sql = "
      				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
								AND CNT >= 1 
								GROUP BY NAMA_BRAND
      					  ) AS VW0
      					    LEFT JOIN 
      						(
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 2
							GROUP BY NAMA_BRAND
      					  ) AS VW2 ON VW0.NAMA_BRAND = VW2.NAMA_BRAND 
      					  LEFT JOIN
      						 (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 3
							GROUP BY NAMA_BRAND
      					  ) AS VW3 ON VW2.NAMA_BRAND = VW3.NAMA_BRAND 
      					  LEFT JOIN
      						(
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 7
      					  GROUP BY NAMA_BRAND
      					  ) AS VW7 ON VW3.NAMA_BRAND = VW7.NAMA_BRAND 
      					  LEFT JOIN
      					  (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 13
							GROUP BY NAMA_BRAND
      					  ) AS VW13 ON VW7.NAMA_BRAND = VW13.NAMA_BRAND 
      					  LEFT JOIN
      					  (
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
      						  (
      							SELECT * FROM PTV_REACH_NAMA_BRAND
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'  
      							
      							".$l_where_clause_kategori."  
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,NAMA_BRAND
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 21
      					    GROUP BY NAMA_BRAND
      					  ) AS VW21 ON VW13.NAMA_BRAND = VW21.NAMA_BRAND
      					  ,
      					  (
      					  SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND TYPE_DATA = 2
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";
  				}elseif($params['kategoriby'] == "ADVERTISER"){
                $sql = "
        				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
        					(VIEWERS3/UNIVERSE)*100 AS REACH3,
        					(VIEWERS7/UNIVERSE)*100 AS REACH7,
        					(VIEWERS13/UNIVERSE)*100 AS REACH13,
        					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 1 
        					  GROUP BY ADVERTISER
        					  ) AS VW0
        					 LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 2
        					   GROUP BY ADVERTISER
        					  ) AS VW2 ON VW0.ADVERTISER = VW2.ADVERTISER 
      					  LEFT JOIN
        						 (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 3
        					  GROUP BY ADVERTISER
        					  ) AS VW3 ON VW2.ADVERTISER = VW3.ADVERTISER 
      					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 7
        					  GROUP BY ADVERTISER
        					  ) AS VW7
        					   ON VW3.ADVERTISER = VW7.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 13
        					  GROUP BY ADVERTISER
        					  ) AS VW13 ON VW7.ADVERTISER = VW13.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
        						  (
        							SELECT * FROM PTV_REACH_ADVERTISER
        							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 21
        					   GROUP BY ADVERTISER
        					  ) AS VW21 ON VW13.ADVERTISER = VW21.ADVERTISER
        					  ,
        					  (
        					   SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 2  
        					  )
        					  AS UNIVERSE_REACH
        					)
        				";
  				}elseif($params['kategoriby'] == "AGENCY"){
      					$sql = "
      				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE CNT >= 1 
							GROUP BY AGENCY
      					  ) AS VW0
      					 LEFT JOIN 
      						(
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 2
      					   GROUP BY AGENCY
      					  ) AS VW2 ON VW0.AGENCY = VW2.AGENCY 
      					  LEFT JOIN
      						 (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 3
      					  GROUP BY AGENCY
      					  ) AS VW3 ON VW2.AGENCY = VW3.AGENCY 
      					  LEFT JOIN
      						(
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 7
      					    GROUP BY AGENCY
      					  ) AS VW7 ON VW3.AGENCY = VW7.AGENCY 
      					  LEFT JOIN
      					  (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 13
      					  GROUP BY AGENCY
      					  ) AS VW13 ON VW7.AGENCY = VW13.AGENCY 
      					  LEFT JOIN
      					  (
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
      						  (
      							SELECT * FROM PTV_REACH_AGENCY 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,AGENCY
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 21
      					   GROUP BY AGENCY
      					  ) AS VW21 ON VW13.AGENCY = VW21.AGENCY 
      					  ,
      					  (
      					    SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 2  
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";
  				}else{
              $sql = "
      				SELECT VIEWERS0,VIEWERS_A,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS_A1,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS_A/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 1 
      					  ) AS VW0
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS_A FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 2
      					  ) AS VW2
      					  ,
      						 (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 3
      					  ) AS VW3
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 7
      					  ) AS VW7
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 13
      					  ) AS VW13
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS_A1 FROM
      						  (
      							SELECT * FROM PTV_REACH_PO_NUMBER 
      							WHERE `DATE` BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
								".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS
      						  ,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people AND CNT >= 21
      					  ) AS VW21
      					  ,
      					  (
      							SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' 
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";					
  				}
  		}
		
       
  		$out		= array();
  		$query		= $this->db2->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}

	public function _get_filter_adspeformance_pr($params = array()) {	
		$db = $this->clickhouse->db();		
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
        if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
      
		if($params['kategori'] == 'All'){
		   $l_where_clause_kategori = ''; 
	  }else{
		  if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''  ){
			  $l_where_clause_kategori = ''; 
		  }else{
			  if($params['kategoriby'] == "PO_NUMBER"){
				  $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."'";
			  } else {
				  $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."'";
			  }
		  }
		 }
		 
		 	   if($params['get_product'] == 'null' || $params['get_product'] == '' || $params['kategori'] == 'All'){
          $l_where_clause_product = ''; 
      }else{
          if($params['get_product'] == "all"){
              $l_where_clause_product = '';
          } else {
			  
			$f = explode(",",$params['get_product']);
			$cin = "";
      
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);

            $l_where_clause_product = ' AND PRODUCT IN ('.$new_cin.') ';
          }
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = ' AND A.CHANNEL IN ('.$new_cin.') ';
      }
	  
 		$l_where_clause_productD = ''; 
		
		
	   if($params['get_product_a'][0] == 'null' || $params['get_product_a'][0] == '' || $params['get_program'] == ''){
          $l_where_clause_productD = ''; 
       }else{
          if($params['get_product_a'][0] == 'all'){
              $l_where_clause_productD = '';
           } else {
 			$cinD = "";
      
			foreach($params['get_product_a'] as $channel_fD){
				$cinD = $cinD."'".$channel_fD."',";
			}
			$new_cinD = substr($cinD, 0, -1);

            $l_where_clause_productD = ' AND PRODUCT IN ('.$new_cinD.') ';
          }
      }
	  
	   if($params['get_program'] == 'all' || $params['get_program'] == '0' || $params['get_program'] == ''){
           $l_where_clause_program = ''; 
       } else {
          $f = explode(",",$params['get_program']);
          $cin = "";
      
          foreach($f as $channel_fS){
              $cin = $cin."'".$channel_fS."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_program = " AND A.PROGRAM IN (".$new_cin.") ";
      }
       
       
      $sql22 = "
	SELECT A.`DATE`,A.`CHANNEL`,A.`PROGRAM`,A.`SPLIT_MINUTES`,A.`START_TIME`,A.`END_TIME`,A.`DURATION`,A.`DURATION`,A.`NAMA_BRAND`,
			A.`SLOT_NAME`,A.`PRICE`,A.`NET_PRICE`,A.`ADVERTISER`,A.`AGENCY`,A.`PO_NUMBER`,A.`STATUS`,A.`PROVIDER`,
			B.`VIEWERS` VIEWERS,B.`ALL_VIEWERS` ALL_VIEWERS,B.`UNIVERSE` UNIVERSE,B.`TVS` TVS,B.`TVR` TVR,B.`ID_PROFILE`,B.`REACH`,(B.TVR/A.TVR)*100 IDX,
			toDayOfWeek(A.DATE) DAYENAME,WEEK(A.DATE) WEEKNAME FROM (
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE= 1
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) A LEFT JOIN ( 
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE=".$params['profile']."
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME AND A.PO_NUMBER = B.PO_NUMBER AND A.NO = B.NO
			AND A.NAMA_BRAND = B.NAMA_BRAND
			ORDER BY A.CHANNEL, A.`DATE`, A.START_TIME
     ";	
       
      $query2		= $db->select($sql22);
      $result2 = $query2->rows();						
      $return = array(
          'data' => $result2,
         
      );
      return $return;
	}
	
	public function _get_filter_adspeformance($params = array()) {	
$db = $this->clickhouse->db();	
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
      if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
      
	if($params['kategori'] == 'All'){
		   $l_where_clause_kategori = ''; 
	  }else{
		  if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''  ){
			  $l_where_clause_kategori = ''; 
		  }else{
			  if($params['kategoriby'] == "PO_NUMBER"){
				  $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."'";
			  } else {
				  $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."'";
			  }
		  }
	  }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
      
	  $sql = "
		SELECT COUNT(*) AS jumlah FROM (
			SELECT * FROM PTV_CIM_RATING_RES
			WHERE ID_PROFILE=0
			".$l_where_clause_startdate."
			".$l_where_clause_enddate."
			".$l_where_clause_kategori."
			".$l_where_clause_channel."
		) A 

	  ";
 
		$querys		= $db->select($sql);
		$result = $querys->rows();
      
     $total_filtered = $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];	
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "
  SELECT  CHANNEL,PROGRAM, `DATE` AS TANGGAL, START_TIME, VIEWERS AS TOTAL_VIEW, 1 AS SPOT 
		FROM (
			SELECT * FROM PTV_CIM_RATING_RES
			WHERE ID_PROFILE=".$params['profile']."
			".$l_where_clause_startdate."
			".$l_where_clause_enddate."
			".$l_where_clause_kategori."
			".$l_where_clause_channel."
		
		) P
		ORDER BY CHANNEL,DATE,START_TIME
      LIMIT ".$params['limit']." 
      OFFSET ".$params['offset'];	
       
      $query2s		= $db->select($sql2);
      $result2 = $query2s->rows();	
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}

	public function _get_filter_adspeformance2($params = array()) {		
		$db = $this->clickhouse->db();	
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
       if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
      
		if($params['kategori'] == 'All'){
		   $l_where_clause_kategori = ''; 
	  }else{
		  if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''  ){
			  $l_where_clause_kategori = ''; 
		  }else{
			  if($params['kategoriby'] == "PO_NUMBER"){
				  $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."'";
			  } else {
				  $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."'";
			  }
		  }
		 }
	  
	   if($params['get_product'] == 'null' || $params['get_product'] == '' || $params['kategori'] == 'All'){
          $l_where_clause_product = ''; 
      }else{
          if($params['get_product'] == "all"){
              $l_where_clause_product = '';
          } else {
			  
			$f = explode(",",$params['get_product']);
			$cin = "";
      
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);

             $l_where_clause_channel = " AND PRODUCT IN (".$new_cin.") ";
          }
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
	  
	  
	  if($params['get_program'] == 'all' || $params['get_program'] == '0' || $params['get_program'] == ''){
           $l_where_clause_program = ''; 
       } else {
          $f = explode(",",$params['get_program']);
          $cin = "";
      
          foreach($f as $channel_fS){
              $cin = $cin."'".$channel_fS."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_program = " AND A.PROGRAM IN (".$new_cin.") ";
      }
	  
      
	  $sql = "
	  SELECT COUNT(*) AS jumlah FROM (
		
		SELECT A.`DATE`,A.`CHANNEL`,A.`PROGRAM`,A.`SPLIT_MINUTES`,A.`START_TIME`,A.`END_TIME`,A.`DURATION`,A.`NAMA_BRAND`,
			A.`SLOT_NAME`,A.`PRICE`,A.`NET_PRICE`,A.`ADVERTISER`,A.`AGENCY`,A.`PO_NUMBER`,A.`STATUS`,A.`PROVIDER`,
			B.`VIEWERS`,B.`ALL_VIEWERS`,B.`UNIVERSE`,B.`TVS`,B.`TVR`,B.`ID_PROFILE`,B.`REACH`,(B.TVR/A.TVR)*100 IDX,
			toDayOfWeek(A.DATE) DAYENAME,WEEK(A.DATE) WEEKNAME FROM (
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE= 1
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) A LEFT JOIN ( 
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE=".$params['profile']."
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME AND A.PO_NUMBER = B.PO_NUMBER AND A.NO = B.NO
			AND A.NAMA_BRAND = B.NAMA_BRAND
			ORDER BY A.CHANNEL, A.`DATE`, A.START_TIME
			
	) L
	  ";
 
      //ECHO $sql;DIE;
      $querys		= $db->select($sql);
		$result = $querys->rows();
	 
	  
      $total_filtered = $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];	
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "
			SELECT A.`DATE`,A.`CHANNEL`,A.`PROGRAM`,A.`SPLIT_MINUTES`,A.`START_TIME`,A.`END_TIME`,A.`DURATION`,A.`DURATION`,A.`NAMA_BRAND`,
			A.`SLOT_NAME`,A.`PRICE`,A.`NET_PRICE`,A.`ADVERTISER`,A.`AGENCY`,A.`PO_NUMBER`,A.`STATUS`,A.`PROVIDER`,
			B.`VIEWERS` VIEWERS,B.`ALL_VIEWERS` ALL_VIEWERS,B.`UNIVERSE` UNIVERSE,B.`TVS` TVS,B.`TVR` TVR,B.`ID_PROFILE`,B.`REACH`,(B.TVR/A.TVR)*100 IDX,
			toDayOfWeek(A.DATE) DAYENAME,WEEK(A.DATE) WEEKNAME FROM (
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE= 1
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) A LEFT JOIN ( 
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE=".$params['profile']."
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME AND A.PO_NUMBER = B.PO_NUMBER AND A.NO = B.NO
			AND A.NAMA_BRAND = B.NAMA_BRAND
			ORDER BY A.CHANNEL, A.`DATE`, A.START_TIME
      LIMIT ".$params['limit']." 
      OFFSET ".$params['offset'];	
	  
	  
	  //ECHO $sql2;DIE;
       
      $query2s		= $db->select($sql2);
      $result2 = $query2s->rows();	
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	
	
	public function _get_filter_adspeformance2_ss($params = array()) {	
$db = $this->clickhouse->db();		
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
      if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
      
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == '' || $params['kategori'] == 'All'){
          $l_where_clause_kategori = ''; 
      }else{
          if($params['kategoriby'] == "PO_NUMBER"){
				  $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."'";
			  } else {
				  $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."'";
			  }
      }
	  
	   if($params['get_product'] == 'null' || $params['get_product'] == '' || $params['get_product'] == 'undefined'){
          $l_where_clause_product = ''; 
      }else{
          if($params['get_product'] == "all"){
              $l_where_clause_product = '';
          } else {
			  
			$f = explode(",",$params['get_product']);
			$cin = "";
      
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);

            $l_where_clause_product = " AND PRODUCT IN (".$new_cin.") ";
          }
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
	  
	  if($params['get_program'] == 'all' || $params['get_program'] == '0' || $params['get_program'] == ''){
           $l_where_clause_program = ''; 
       } else {
          $f = explode(",",$params['get_program']);
          $cin = "";
      
          foreach($f as $channel_fS){
              $cin = $cin."'".$channel_fS."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_program = " AND A.PROGRAM IN (".$new_cin.") ";
      }
      
	  $sql = "
	  SELECT COUNT(*) AS jumlah FROM (
		   SELECT A.* FROM PTV_CIM_RATING_RES A 
		 JOIN `LOGPROOF_RES_FULL_STEP2` B 
		 ON A.CHANNEL = B.CHANNEL 
		 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
		 AND A.START_TIME = B.`TIME`
			WHERE ID_PROFILE= ".$params['profile']."
			".$l_where_clause_startdate."
			".$l_where_clause_enddate."
			".$l_where_clause_kategori."
			".$l_where_clause_channel."
			".$l_where_clause_product."
			".$l_where_clause_program."
	) L
	  ";
 
      
       $querys		= $db->select($sql);
		$result = $querys->rows();
      
      $total_filtered = $result[0]['jumlah'];
		  $total 			= $result[0]['jumlah'];	
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "
			SELECT A.`DATE`,A.`CHANNEL`,A.`PROGRAM`,A.`SPLIT_MINUTES`,A.`START_TIME`,A.`END_TIME`,A.`DURATION`,A.`DURATION`,A.`NAMA_BRAND`,
			A.`SLOT_NAME`,A.`PRICE` PRICE,A.`NET_PRICE` NET_PRICE,A.`ADVERTISER`,A.`AGENCY`,A.`PO_NUMBER`,A.`STATUS`,A.`PROVIDER`,
			B.`VIEWERS` VIEWERS,B.`ALL_VIEWERS` ALL_VIEWERS,B.`UNIVERSE` UNIVERSE,B.`TVS` TVS,B.`TVR` TVR,B.`ID_PROFILE`,B.`REACH` REACH,
			toDayOfWeek(A.DATE) DAYENAME,WEEK(A.DATE) WEEKNAME FROM (
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				  AND A.START_TIME = B.`TIME`
				   AND A.PO_NUMBER = B.HOUSE_NUMBER
				WHERE ID_PROFILE= ".$params['profile']."
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) A LEFT JOIN ( 
				SELECT B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				WHERE ID_PROFILE=".$params['profile']."
				 AND A.START_TIME = B.`TIME`
				  AND A.PO_NUMBER = B.HOUSE_NUMBER
				".$l_where_clause_startdate."
				".$l_where_clause_enddate."
				".$l_where_clause_kategori."
				".$l_where_clause_channel."
				".$l_where_clause_product."
				".$l_where_clause_program."
			) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME AND A.NO = B.NO
			AND A.PO_NUMBER = B.PO_NUMBER
			AND A.NAMA_BRAND = B.NAMA_BRAND
			ORDER BY A.CHANNEL, A.`DATE`, A.START_TIME
			";	
       
	   //echo $sql2;die;
       $query2s		= $db->select($sql2);
      $result2 = $query2s->rows();		
	  
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}
	

	public function list_adspeformance($params = array()) {	
  		$sql = "SELECT * FROM PTV_CIM_RATING_RES 
  		WHERE ID_PROFILE=0 AND `DATE` BETWEEN '2017-12-01' AND '2017-12-31'
  		ORDER BY ".$params['order_column']." ".$params['order_dir']."   
  		LIMIT ".$params['limit']." 
  		OFFSET ".$params['offset'];
       
  		$out		= array();
  		$query		= $this->db2->query($sql);
  		$result = $query->result_array();
      
  		$sql2 = "SELECT COUNT(*) AS jumlah
  		FROM PTV_CIM_RATING tcn  
  		WHERE ID_PROFILE=0
  		";
      
  		$out		= array();
  		$query2		= $this->db2->query($sql2);
  		$result2 = $query2->row();
  
  		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
      		if($l_result = mysqli_store_result($this->db2->conn_id)){
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
		$db = $this->clickhouse->db();	
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0;
      
  		 if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
  		
  		if($params['kategoriby'] == 'null'  || $params['kategoriby'] == '' || $params['kategori'] == 'All'){
          $l_where_clause_kategori = ''; 
      } else {
         if($params['kategoriby'] == "PO_NUMBER"){
				  $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."'";
			  } else {
				  $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."'";
			  }
      }
  	
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }   elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
	  
	  if($params['get_product'] == 'null' || $params['kategoriby'] == ''|| $params['get_product'] == 'undefined'){
          $l_where_clause_product = ''; 
      }else{
          if($params['get_product'] == "all"){
              $l_where_clause_product = '';
          } else {
			  
			$f = explode(",",$params['get_product']);
			$cin = "";
      
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);

            $l_where_clause_channel = " AND PRODUCT IN (".$new_cin.") ";
          }
      }
	  
	  	  if($params['get_program'] == 'all' || $params['get_program'] == '0' || $params['get_program'] == ''){
           $l_where_clause_program = ''; 
       } else {
          $f = explode(",",$params['get_program']);
          $cin = "";
      
          foreach($f as $channel_fS){
              $cin = $cin."'".$channel_fS."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_program = " AND A.PROGRAM IN (".$new_cin.") ";
      }
      
  		$sql2 = "
		SELECT CHANNEL, SUM(TOTAL_VIEW) AS VIEWS, SUM(SPOTS) AS SPOT, SUM(TOTAL_VIEW)/SUM(SPOTS) AS VG_VPS, SUM(PRICE) AS PRICE FROM (
			SELECT CHANNEL, `DATE` AS TANGGAL, START_TIME, VIEWERS AS TOTAL_VIEW, 1 AS SPOTS ,PRICE
			FROM (
				SELECT A.`DATE`,A.`CHANNEL`,A.`PROGRAM`,A.`SPLIT_MINUTES`,A.`START_TIME`,A.`END_TIME`,A.`DURATION`,A.`NAMA_BRAND`,
				A.`SLOT_NAME`,A.`PRICE`,A.`NET_PRICE`,A.`ADVERTISER`,A.`AGENCY`,A.`PO_NUMBER`,A.`STATUS`,A.`PROVIDER`,
				B.`VIEWERS` AS VIEWERS,B.`ALL_VIEWERS`,B.`UNIVERSE`,B.`TVS`,B.`TVR`,B.`ID_PROFILE`,B.`REACH`,
				toDayOfWeek(A.DATE) DAYENAME,WEEK(A.DATE) WEEKNAME FROM (
					SELECT  B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
					WHERE ID_PROFILE= 1
					".$l_where_clause_startdate."
					".$l_where_clause_enddate."
					".$l_where_clause_kategori."
					".$l_where_clause_channel."
					".$l_where_clause_product."
					".$l_where_clause_program."
				) A LEFT JOIN ( 
					SELECT  B.NO,A.* FROM PTV_CIM_RATING_RES A 
				 JOIN `LOGPROOF_RES_FULL_STEP2` B 
				 ON A.CHANNEL = B.CHANNEL 
				 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
				 AND A.START_TIME = B.`TIME`
				 AND A.PO_NUMBER = B.HOUSE_NUMBER
					WHERE ID_PROFILE=".$params['profile']."
					".$l_where_clause_startdate."
					".$l_where_clause_enddate."
					".$l_where_clause_kategori."
					".$l_where_clause_channel."
					".$l_where_clause_product."
					".$l_where_clause_program."
				) B ON A.DATE = B.DATE AND A.CHANNEL = B.CHANNEL AND A.PROGRAM = B.PROGRAM AND A.START_TIME = B.START_TIME AND A.NO = B.NO
				AND A.PO_NUMBER = B.PO_NUMBER
				AND A.NAMA_BRAND = B.NAMA_BRAND
			
			) P
		
		ORDER BY CHANNEL, `DATE`, START_TIME
	) P
GROUP BY CHANNEL ORDER BY CHANNEL
  		 ";
		 
		 //ECHO $sql2;DIE;
   		
		$querys		= $db->select($sql2);
		$result = $querys->rows();
  		
  		return $result;	
	}                                           
  
  public function listsearch($sSearch,$kategori,$start_date,$end_date){
  		$kategori = strtoupper($kategori);
      $sSearch = strtoupper($sSearch);
 
      
      $sql 	= "SELECT DISTINCT(".$kategori.") AS SEARH_RESULT FROM LOGPROOF_RES_ALL 
		WHERE STR_TO_DATE(`DATE`,'%d/%m/%Y') >= '".$start_date."' 
		AND STR_TO_DATE(`DATE`,'%d/%m/%Y') <= '".$end_date."'    
		AND ".$kategori." LIKE '%".$sSearch."%'   
		GROUP BY ".$kategori."
		ORDER BY ".$kategori." ASC;";
      
   		$query 	=  $this->db2->query($sql);
  		$this->db2->close();
  		$this->db2->initialize(); 
  		
  		$return = $query->result_array();
  		return $return;
	}                                    
      
	public function _get_filter_adspeformance2_reach_all($params = array()){
		$db = $this->clickhouse->db();	
  		 $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
      if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
      
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''  || $params['kategori'] == 'All'){
          $l_where_clause_kategori = ''; 
      }else{
          if($params['kategoriby'] == "PO_NUMBER"){
				  $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."'";
			  } else {
				  $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."'";
			  }
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == ''){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND A.CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
	  
	   
	   if($params['get_product'] == 'null' || $params['get_product'] == '' || $params['get_product'] == 'undefined'){
          $l_where_clause_product = ''; 
      }else{
          if($params['get_product'] == "all"){
              $l_where_clause_product = '';
          } else {
			  
			$f = explode(",",$params['get_product']);
			$cin = "";
      
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);

            $l_where_clause_channel = " AND PRODUCT IN (".$new_cin.") ";
          }
      }
	  
	   if($params['get_program'] == 'all' || $params['get_program'] == '0' || $params['get_program'] == ''){
           $l_where_clause_program = ''; 
       } else {
          $f = explode(",",$params['get_program']);
          $cin = "";
      
          foreach($f as $channel_fS){
              $cin = $cin."'".$channel_fS."',";
          }
          $new_cin = substr($cin, 0, -1);
          
           $l_where_clause_program = " AND A.PROGRAM IN (".$new_cin.") ";
      }
	  
	  
	  IF($params['profile'] == 1){
		  $tbls = 'REACH_POSTBUY_RES_ALL_P22';
	  }else{
		  $tbls = 'REACH_POSTBUY_RES_ALL';
	  }
	  
      IF($l_where_clause_product == ''){
	  
      $sql 	= "
	  
		 SELECT 
  		 (SUM(REACH1)/".$params['univ'].")*100 REACH_1,
  		 (SUM(REACH2)/".$params['univ'].")*100 REACH_2,
  		 (SUM(REACH3)/".$params['univ'].")*100 REACH_3,
  		 (SUM(REACH7)/".$params['univ'].")*100 REACH_7,
  		 (SUM(REACH13)/".$params['univ'].")*100 REACH_13,
  		 (SUM(REACH21)/".$params['univ'].")*100 REACH_21
  		 FROM (
			 SELECT RESPID,COUNT(RESPID) CNT,WEIGHT, ".$params['kategoriby'].",
			 IF(COUNT(RESPID) >= 1,toInt32(WEIGHT),0) REACH1,
			 IF(COUNT(RESPID) >= 2,toInt32(WEIGHT),0) REACH2,
			 IF(COUNT(RESPID) >= 3,toInt32(WEIGHT),0) REACH3,
			 IF(COUNT(RESPID) >= 7,toInt32(WEIGHT),0) REACH7,
			 IF(COUNT(RESPID) >= 13,toInt32(WEIGHT),0) REACH13,
			 IF(COUNT(RESPID) >= 21,toInt32(WEIGHT),0) REACH21 FROM ".$tbls." A
			 WHERE 1=1 
			 ".$l_where_clause_startdate."
			 ".$l_where_clause_enddate."
			 ".$l_where_clause_kategori."
			 ".$l_where_clause_channel."
			 ".$l_where_clause_program."
			 GROUP BY RESPID, ".$params['kategoriby'].",WEIGHT
  		 ) A 

	  ";
	  
	  }else{
		  
		  $sql 	= "
	  
		 SELECT 
  		 (SUM(REACH1)/".$params['univ'].")*100 REACH_1,
  		 (SUM(REACH2)/".$params['univ'].")*100 REACH_2,
  		 (SUM(REACH3)/".$params['univ'].")*100 REACH_3,
  		 (SUM(REACH7)/".$params['univ'].")*100 REACH_7,
  		 (SUM(REACH13)/".$params['univ'].")*100 REACH_13,
  		 (SUM(REACH21)/".$params['univ'].")*100 REACH_21
  		 FROM (
			 SELECT RESPID,COUNT(RESPID) CNT,WEIGHT, PRODUCT,
			 IF(COUNT(RESPID) >= 1,toInt32(WEIGHT),0) REACH1,
			 IF(COUNT(RESPID) >= 2,toInt32(WEIGHT),0) REACH2,
			 IF(COUNT(RESPID) >= 3,toInt32(WEIGHT),0) REACH3,
			 IF(COUNT(RESPID) >= 7,toInt32(WEIGHT),0) REACH7,
			 IF(COUNT(RESPID) >= 13,toInt32(WEIGHT),0) REACH13,
			 IF(COUNT(RESPID) >= 21,toInt32(WEIGHT),0) REACH21 FROM ".$tbls." A
			 WHERE 1=1 
			 ".$l_where_clause_startdate."
			 ".$l_where_clause_enddate."
			 ".$l_where_clause_kategori."
			 ".$l_where_clause_channel."
			 ".$l_where_clause_product."
			 ".$l_where_clause_program."
			 GROUP BY RESPID, PRODUCT,WEIGHT
  		 ) A 

	  ";
		  
	  }
	  
	 // ECHO  $sql;DIE;
      
   		 $query2s		= $db->select($sql);
		$return = $query2s->rows();	
  		return $return;
	}
	
	  public function _get_filter_adspeformance2_reach($params = array()){
		  $db = $this->clickhouse->db();
  		 $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
      if($params['start_date'] <> NULL){
           $l_where_clause_startdate = "AND `DATE` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
           $l_where_clause_enddate = " AND `DATE` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
      }
      
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == '' || $params['kategori'] == 'All'){
          $l_where_clause_kategori = ''; 
      }else{
          if($params['kategoriby'] == "PO_NUMBER"){
			  $params['kategoriby'] = "HOUSENUMBER";
              $l_where_clause_kategori = ' AND REPLACE(A.'.$params['kategoriby'].', "\r", "") = "'.str_replace("*","'",$params['kategori']).'" ';
          } else {
              $l_where_clause_kategori = ' AND A.'.$params['kategoriby'].' = "'.str_replace("*","'",$params['kategori']).'" ';
          }
      }
	  
	   if($params['get_product'] == 'null' || $params['get_product'] == '' || $params['get_product'] == 'undefined'){
          $l_where_clause_product = ''; 
      }else{
          if($params['get_product'] == "all"){
              $l_where_clause_product = '';
          } else {
			  
			$f = explode(",",$params['get_product']);
			$cin = "";
      
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f."',";
			}
			$new_cin = substr($cin, 0, -1);

            $l_where_clause_product = ' AND PRODUCT IN ('.$new_cin.') ';
          }
      }
      
      if($params['chnl'] == 'null' || $params['chnl'] == '0' || $params['chnl'] == '' || $params['get_product'] == 'undefined'){
          $l_where_clause_channel = ''; 
      }  elseif( $params['chnl'] == '1' ){
          $l_where_clause_channel = "AND CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='UseeTV' ) "; 
       } elseif( $params['chnl'] == '2' ){
          $l_where_clause_channel = " AND CHANNEL IN(SELECT CHANNEL FROM CHANNEL_PARAM_PROVIDER WHERE PROVIDER ='Mediahub' ) "; 
       } else {
          $f = explode(",",$params['chnl']);
          $cin = "";
      
          foreach($f as $channel_f){
              $cin = $cin."'".$channel_f."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
	  
	  if($params['get_program'] == 'all' || $params['get_program'] == '0' || $params['get_program'] == ''){
           $l_where_clause_program = ''; 
       } else {
          $f = explode(",",$params['get_program']);
          $cin = "";
      
          foreach($f as $channel_fS){
              $cin = $cin."'".$channel_fS."',";
          }
          $new_cin = substr($cin, 0, -1);
          
          $l_where_clause_program = " AND A.PROGRAM IN (".$new_cin.") ";
      }
	  
	  if($params['flag'] == 1){
		  $tbl_r = 'LOGPROOF_RES_ALL_DETAIL_2021';
	  }else{
		  $tbl_r = 'LOGPROOF_RES_ALL_DETAIL';
	  }
	  
	   IF($l_where_clause_product == ''){
      
      $sql 	= "
	  
		SELECT,
  		 (SUM(REACH1)/".$params['univ'].")*100 REACH_1,
  		 (SUM(REACH2)/".$params['univ'].")*100 REACH_2,
  		 (SUM(REACH3)/".$params['univ'].")*100 REACH_3,
  		 (SUM(REACH7)/".$params['univ'].")*100 REACH_7,
  		 (SUM(REACH13)/".$params['univ'].")*100 REACH_13,
  		 (SUM(REACH21)/".$params['univ'].")*100 REACH_21
  		 FROM (
			 SELECT RESPID,COUNT(RESPID) CNT,WEIGHT, ".$params['kategoriby'].",
			 IF(COUNT(RESPID) >= 1,toInt32(WEIGHT),0) REACH1,
			 IF(COUNT(RESPID) >= 2,toInt32(WEIGHT),0) REACH2,
			 IF(COUNT(RESPID) >= 3,toInt32(WEIGHT),0) REACH3,
			 IF(COUNT(RESPID) >= 7,toInt32(WEIGHT),0) REACH7,
			 IF(COUNT(RESPID) >= 13,toInt32(WEIGHT),0) REACH13,
			 IF(COUNT(RESPID) >= 21,toInt32(WEIGHT),0) REACH21 FROM REACH_POSTBUY_RES_P22 A 
			 JOIN `PROFILE_CARDNO_RES` B ON A.RESPID = B.CARDNO
			WHERE B.`ID_PROFILE` = ".$params['profile']."  
			 ".$l_where_clause_startdate."
			 ".$l_where_clause_enddate."
			 ".$l_where_clause_kategori."
			 ".$l_where_clause_channel."
			 ".$l_where_clause_program."
			 GROUP BY RESPID, ".$params['kategoriby'].",WEIGHT
  		 ) A 

	  
	  ";
	  
	   }ELSE{
		   
		    $sql 	= "
	  
		SELECT 
  		 (SUM(REACH1)/".$params['univ'].")*100 REACH_1,
  		 (SUM(REACH2)/".$params['univ'].")*100 REACH_2,
  		 (SUM(REACH3)/".$params['univ'].")*100 REACH_3,
  		 (SUM(REACH7)/".$params['univ'].")*100 REACH_7,
  		 (SUM(REACH13)/".$params['univ'].")*100 REACH_13,
  		 (SUM(REACH21)/".$params['univ'].")*100 REACH_21
  		 FROM (
			 SELECT RESPID,COUNT(RESPID) CNT,WEIGHT, PRODUCT,
			 IF(COUNT(RESPID) >= 1,toInt32(WEIGHT),0) REACH1,
			 IF(COUNT(RESPID) >= 2,toInt32(WEIGHT),0) REACH2,
			 IF(COUNT(RESPID) >= 3,toInt32(WEIGHT),0) REACH3,
			 IF(COUNT(RESPID) >= 7,toInt32(WEIGHT),0) REACH7,
			 IF(COUNT(RESPID) >= 13,toInt32(WEIGHT),0) REACH13,
			 IF(COUNT(RESPID) >= 21,toInt32(WEIGHT),0) REACH21 FROM REACH_POSTBUY_RES_PRODUCT_P22 A 
			 JOIN `PROFILE_CARDNO_RES` B ON A.RESPID = B.CARDNO
			WHERE B.`ID_PROFILE` = ".$params['profile']."  
			 ".$l_where_clause_startdate."
			 ".$l_where_clause_enddate."
			 ".$l_where_clause_kategori."
			 ".$l_where_clause_channel."
			 ".$l_where_clause_product."
			 ".$l_where_clause_program."
			 GROUP BY RESPID, PRODUCT,WEIGHT
  		 ) A 
		 
		 ";
		   
	   }
	   
	   //echo $sql;die;
      
   		$query 	=  $db->select($sql);
  		$return = $query->rows();
  		return $return;
	}                                    
    
  public function profilesearch($strSearch,$iduser,$period){ 
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1];         
      }
            
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub_res a JOIN M_MONTH_PROFILE_RES c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                   
   
  public function get_univ($params = array()){ 

 		   
      $sql = " SELECT * FROM t_profiling_ub_res where `id` = ".$params['profile'];
      //print_r($sql);
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                  
    
  public function channelsearch($strSearch,$role){
      
       $sql = "SELECT DISTINCT(CHANNEL) FROM `PTV_CIM_RATING` C
      WHERE CHANNEL LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`CHANNEL`";
      //print_r($sql);
      $out		= array();
      $query		= $this->db2->query($sql);
      $result = $query->result_array();
      
      return $result;
  }
  
  public function _list_subkategori($params){
	  	  $db = $this->clickhouse->db();
		  
		$kategori = strtoupper($params['product']);
		
		$sql 	= "SELECT DISTINCT(A.".$kategori.") AS SUBCAT FROM PTV_CIM_RATING_RES A
		WHERE `DATE` >= '".$params['start_date']."' 
		AND `DATE` <= '".$params['end_date']."'    
		AND A.".$kategori." <> ''   
		GROUP BY A.".$kategori."
		ORDER BY A.".$kategori." ASC";
 
		//ECHO $sql ;DIE;
		$result = $db->select($sql);
		return $result->rows();	
	}
	
	 public function _list_product($params){
		 $db = $this->clickhouse->db();	
		$kategori = strtoupper(str_replace("*","'",$params['product']));
		
		$sql 	= "
		 SELECT DISTINCT(B.PRODUCT) AS PRODUCT FROM PTV_CIM_RATING_RES A 
		 JOIN `LOGPROOF_RES_FULL_STEP2` B 
		 ON A.CHANNEL = B.CHANNEL 
		 AND toString(formatDateTime(A.DATE,'%d/%m/%Y')) = B.`DATE`
		 AND A.START_TIME = B.`TIME`
				WHERE ID_PROFILE=".$params['profile']."
				AND A.`DATE` >= '".$params['start_date']."' 
				 AND A.`DATE` <= '".$params['end_date']."' 
				 AND NAMA_BRAND = '".$kategori."' 
				 ORDER BY PRODUCT
		";
		
		
		$querys		= $db->select($sql);
		$result = $querys->rows();
		return $result;
	} 
	
	
	public function _list_program($params){
		
		 
		 $win = '';
		 
		 foreach($params['product'] as $programs){
			 $win .= '"'.$programs.'",';
		 }
		 
		 $win_fin = '('.substr($win, 0, -1).')';
 
		
		
		$sql 	= '
		 SELECT DISTINCT(A.PROGRAM) AS PROGRAM FROM PTV_CIM_RATING_RES A 
		 JOIN `LOGPROOF_RES_FULL_STEP2` B 
		 ON A.CHANNEL = B.CHANNEL 
		 AND A.DATE = STR_TO_DATE(B.`DATE`,"%d/%m/%Y")
		 AND A.START_TIME = B.`TIME`
				WHERE ID_PROFILE='.$params['profile'].'
				AND A.`DATE` >= "'.$params['start_date'].'" 
				 AND A.`DATE` <= "'.$params['end_date'].'" 
				 AND A.CHANNEL IN '.$win_fin.'
				 ORDER BY PROGRAM
		';
 
		
		$query 	=  $this->db2->query($sql);
		$this->db2->close();
		$this->db2->initialize(); 
		
		$return = $query->result_array();
		return $return;
	}
	
}