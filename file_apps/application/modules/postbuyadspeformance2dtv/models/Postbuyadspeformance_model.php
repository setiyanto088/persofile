<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postbuyadspeformance_model extends CI_Model {
	
	public function __construct()
	{
		  parent::__construct();
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
      
  		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
      
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
	
	public function get_channel(){
  
  $db = $this->clickhouse->db();
  $sql = 'SELECT DISTINCT(CHANNEL) as channel FROM PTV_CIM_RATING order by CHANNEL';  
  		$out		= array(); 
		
		$query2		= $db->select($sql);
		$result2 = $query2->rows();	 
  			
  		return $result2;
	}
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(POSTBUY_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
	public function get_reach_m($params = array(),$re){
		
		$periode = strtoupper(date_format(date_create($params['start_date']),"Y-F"));  
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
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}
  
	public function get_reach($params = array(),$re){
		
		$name_tbs = strtoupper(date_format(date_create($params['start_date']),"My"));  
		
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
  		
			$data_file = $params['start_date'];
			$date_epg = str_replace("-","",$data_file);
			
		
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
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS21/UNIVERSE)*100 AS REACH21 FROM (
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
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
        				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
        					(VIEWERS3/UNIVERSE)*100 AS REACH3,
        					(VIEWERS7/UNIVERSE)*100 AS REACH7,
        					(VIEWERS13/UNIVERSE)*100 AS REACH13,
        					(VIEWERS21/UNIVERSE)*100 AS REACH21 FROM (
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
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS21/UNIVERSE)*100 AS REACH21 FROM (
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
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
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
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
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
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
      						  SELECT NAMA_BRAND,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
        				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
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
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
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
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
      						  SELECT AGENCY,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
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
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
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
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
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
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
  			
  		return $result;
	}

	public function _get_filter_adspeformance_pr($params = array()) {	
		$db = $this->clickhouse->db();
	
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
      if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND TANGGAL >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = " AND TANGGAL <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
      
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
		  $w_sds = " * ";
      }else{
          if($params['kategoriby'] == "PO_NUMBER"){
              $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."' ";
          } else {
              $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."' ";
          }
		   $w_sds = " CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, ".$params['kategori']." ";
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
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
      
      
      $sql2 = "
	   SELECT CHANNEL, TANGGAL, START_TIME, COUNT(CARDNO) AS TOTAL_VIEW, 1 AS SPOT 
	FROM (

	SELECT CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND FROM `PTV_DETAIL_LOGPROOF_DTV2`
	WHERE 1=1  AND NET_PRICE > 0 
	".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

	) P
	GROUP BY CHANNEL, TANGGAL, START_TIME
	ORDER BY CHANNEL, TANGGAL, START_TIME
     ";	
      

		$results = $db->select($sql2);
		$result2 = $results->rows();	
	  
      $return = array(
          'data' => $result2,
         
      );
      return $return;
	}
	
	public function _get_filter_adspeformance($params = array()) {	

$db = $this->clickhouse->db();

	
      $params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0; 
      
      if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND TANGGAL >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = " AND TANGGAL <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
      
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
		  $w_sds = " * ";
      }else{
          if($params['kategoriby'] == "PO_NUMBER"){
              $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."' ";
          } else {
              $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."' ";
          }
		   $w_sds = " CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, ".$params['kategori']." ";
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
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
      
	  $sql = "
	  SELECT COUNT(*) AS jumlah FROM (
		  SELECT CHANNEL, TANGGAL, START_TIME, COUNT(CARDNO) AS TOTAL_VIEW, 1 AS SPOT 
	FROM (

	SELECT CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND FROM `PTV_DETAIL_LOGPROOF_DTV2`
	WHERE 1=1  AND NET_PRICE > 0 
	".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

	) P
	GROUP BY CHANNEL, TANGGAL, START_TIME
	ORDER BY CHANNEL, TANGGAL, START_TIME
	) L
	  ";
	  
	  
      
      $out		= array();
     $results = $db->select($sql);
		$result = $results->rows();	
		
      
	  
	  $total_filtered = $result[0]['jumlah'];
      $total 			= $result[0]['jumlah'];
      
      if(($params['offset']+10) > $total_filtered){
      $limit_data = $total_filtered - $params['offset'];
      }else{
      $limit_data = $params['limit'] ;
      }
      
      $sql2 = "
	   SELECT CHANNEL, TANGGAL, START_TIME, COUNT(CARDNO) AS TOTAL_VIEW, 1 AS SPOT 
	FROM (

	SELECT CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND FROM `PTV_DETAIL_LOGPROOF_DTV2`
	WHERE 1=1  AND NET_PRICE > 0 
	".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND

	) P
	GROUP BY CHANNEL, TANGGAL, START_TIME
	ORDER BY CHANNEL, TANGGAL, START_TIME
      LIMIT ".$params['limit']." 
      OFFSET ".$params['offset'];	
      
     $query2		= $db->select($sql2);
		$result2 = $query2->rows();	 
		
      $return = array(
          'data' => $result2,
          'total_filtered' => $total_filtered,
          'total' => $total,
      );
      return $return;
	}

	public function list_adspeformance($params = array()) {	
  		$sql = "SELECT * FROM PTV_CIM_RATING_DTV 
  		WHERE ID_PROFILE=0 AND `DATE` BETWEEN '2017-12-01' AND '2017-12-31'
  		ORDER BY ".$params['order_column']." ".$params['order_dir']."   
  		LIMIT ".$params['limit']." 
  		OFFSET ".$params['offset'];
      
  		$out		= array();
  		$query		= $this->db->query($sql);
  		$result = $query->result_array();
      
  		$sql2 = "SELECT COUNT(*) AS jumlah
  		FROM PTV_CIM_RATING tcn  
  		WHERE ID_PROFILE=0
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
	$db = $this->clickhouse->db();
	
  		$params['profile'] = $params['profile']<>NULL ? $params['profile'] : 0;
      
  		  if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND TANGGAL >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
       
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = " AND TANGGAL <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ""; 
      }
      
      if($params['kategoriby'] == 'null' || $params['kategoriby'] == ''){
          $l_where_clause_kategori = ""; 
		  $w_sds = " * ";
      }else{
          if($params['kategoriby'] == "PO_NUMBER"){
              $l_where_clause_kategori = " AND REPLACE(".$params['kategoriby'].", '\r', '') = '".$params['kategori']."' ";
          } else {
              $l_where_clause_kategori = " AND ".$params['kategoriby']." = '".$params['kategori']."' ";
          }
		   $w_sds = " CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, ".$params['kategori']." ";
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
          
          $l_where_clause_channel = " AND CHANNEL IN (".$new_cin.") ";
      }
      
  		$sql2 = "
		SELECT CHANNEL, SUM(TOTAL_VIEW) AS VIEWS, SUM(SPOT) AS SPOTS, SUM(TOTAL_VIEW)/SUM(SPOT) AS VG_VPS, SUM(NET_PRICE) AS PRICE FROM (
		  SELECT CHANNEL, TANGGAL, START_TIME, COUNT(CARDNO) AS TOTAL_VIEW, 1 AS SPOT, NET_PRICE 
	FROM (

	SELECT CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND,NET_PRICE FROM `PTV_DETAIL_LOGPROOF_DTV2`
	WHERE 1=1 AND NET_PRICE > 0 
	".$l_where_clause_startdate."
      ".$l_where_clause_enddate."
      ".$l_where_clause_kategori."
      ".$l_where_clause_channel."
	GROUP BY CARDNO, CHANNEL, PROGRAM, TANGGAL, START_TIME, NAMA_BRAND,NET_PRICE

	) P
	GROUP BY CHANNEL, TANGGAL, START_TIME,NET_PRICE
	ORDER BY CHANNEL, TANGGAL, START_TIME,NET_PRICE
	) P
GROUP BY CHANNEL ORDER BY CHANNEL
  		 ";
  		
      $out		= array();
		
		$query2		= $db->select($sql2);
		$result = $query2->rows();	 
  
  		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
          if($l_result = mysqli_store_result($this->db->conn_id)){
              mysqli_free_result($l_result);
          }
  		}
  		
  		return $result;	
	}                                           
  
  public function listsearch($sSearch,$kategori,$start_date,$end_date){
  		$kategori = strtoupper($kategori);
      $sSearch = strtoupper($sSearch);
      
      $sql 	= "SELECT DISTINCT(SUBCAT) AS SEARH_RESULT FROM M_POSTBUY_SUBCAT_08
  		WHERE STR_TO_DATE(`DATE`,'%Y-%m-%d') >= '".$start_date."' 
      AND STR_TO_DATE(`DATE`,'%Y-%m-%d') <= '".$end_date."'    
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
            
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                  
    
  public function channelsearch($strSearch,$role){
      
      $sql = "SELECT DISTINCT(CHANNEL) FROM `PTV_CIM_RATING` C
      WHERE CHANNEL LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`CHANNEL`";
      $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }
  
  public function _list_subkategori($params){
	  
	  $db = $this->clickhouse->db();
	  
		$kategori = strtoupper($params['kategori']);
		
		$sql 	= "SELECT DISTINCT(SUBCAT) AS ".$kategori." FROM M_POSTBUY_SUBCAT_08
		WHERE `DATE` >= '".$params['start_date']."' 
    AND `DATE` <= '".$params['end_date']."'    
    AND CAT = '".$kategori."' AND SUBCAT <> ''   
		ORDER BY ".$kategori." ASC ";
 
	
	$out		= array();
		
		$query2		= $db->select($sql);
		$result2 	= $query2->rows();	 


		return $query2->rows();	 
	}
}