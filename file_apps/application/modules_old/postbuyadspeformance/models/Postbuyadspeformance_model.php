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
      
  		$sql = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a JOIN M_MONTH_PROFILE c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
      
  		$out		= array();
  		$query		= $this->db->query($sql);
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
  
  
	public function get_reach($params = array(),$re){
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
				
				$l_where_clause_kategori = ' AND ADVERTISING = "'.$params['kategori'].'"';
				
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
  		

		
		if($params['sqlc'] == ""){
			
 			
			
  			 if($params['kategoriby'] == "product"){
  					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_PRODUCT
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
							   GROUP BY PRODUCT
      					  ) AS VW0
      					   LEFT JOIN 
      						(
      						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_PRODUCT
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
							  GROUP BY PRODUCT
      					  ) AS VW2 ON VW0.PRODUCT = VW2.PRODUCT 
      					  LEFT JOIN
      						 (
      						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_PRODUCT
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
							  GROUP BY PRODUCT
      					  ) AS VW3 ON VW2.PRODUCT = VW3.PRODUCT 
      					  LEFT JOIN
      						(
      						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_PRODUCT
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
							  GROUP BY PRODUCT
      					  ) AS VW7 ON VW3.PRODUCT = VW7.PRODUCT 
      					  LEFT JOIN
      					  (
      						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_PRODUCT
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
							  GROUP BY PRODUCT
      					  ) AS VW13 ON VW7.PRODUCT = VW13.PRODUCT 
      					  LEFT JOIN
      					  (
      						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_PRODUCT
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,PRODUCT
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
							  GROUP BY PRODUCT
      					  ) AS VW21 ON VW13.PRODUCT = VW21.PRODUCT 
      					  ,
      					  (
      					  SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 0
      					  )
      					  AS UNIVERSE_REACH
      					)
      				";
  				}elseif($params['kategoriby'] == "advertiser"){
                $sql = "
        				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
        					(VIEWERS3/UNIVERSE)*100 AS REACH3,
        					(VIEWERS7/UNIVERSE)*100 AS REACH7,
        					(VIEWERS13/UNIVERSE)*100 AS REACH13,
        					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 1 
								  GROUP BY ADVERTISER
        					  ) AS VW0
        					   LEFT JOIN 
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 2
								  GROUP BY ADVERTISER
        					  ) AS VW2 ON VW0.ADVERTISER = VW2.ADVERTISER 
      					  LEFT JOIN
        						 (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 3
								  GROUP BY ADVERTISER
        					  ) AS VW3 ON VW2.ADVERTISER = VW3.ADVERTISER 
      					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 7
								  GROUP BY ADVERTISER
        					  ) AS VW7 ON VW3.ADVERTISER = VW7.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 13
								  GROUP BY ADVERTISER
        					  ) AS VW13 ON VW7.ADVERTISER = VW13.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							AND ID_PROFILE = ".$params['profile']." 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS
        						  WHERE COUNT_VIEW >= 21
								  GROUP BY ADVERTISER
        					  ) AS VW21 ON VW13.ADVERTISER = VW21.ADVERTISER 
      					 ,
        					  (
        					   SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 0
        					  )
        					  AS UNIVERSE_REACH
        					)
        				";
  				}elseif($params['kategoriby'] == "sector"){
      					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 1 
							  GROUP BY SECTOR
      					  ) AS VW0
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 2
							  GROUP BY SECTOR
      					  ) AS VW2 ON VW0.SECTOR = VW2.SECTOR 
      					  LEFT JOIN
      						 (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 3
							  GROUP BY SECTOR
      					  ) AS VW3 ON VW2.SECTOR = VW3.SECTOR 
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 7
							  GROUP BY SECTOR
      					  ) AS VW7 ON VW3.SECTOR = VW7.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 13
							  GROUP BY SECTOR
      					  ) AS VW13 ON VW7.SECTOR = VW13.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							AND ID_PROFILE = ".$params['profile']." 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS
      						  WHERE COUNT_VIEW >= 21
							  GROUP BY SECTOR
      					  ) AS VW21 ON VW17.SECTOR = VW21.SECTOR 
      					  ,
      					  (
      					    SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 0
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
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
  		}else{
  			if($params['kategoriby'] == "product"){
            $sql = "
    				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
    					(VIEWERS3/UNIVERSE)*100 AS REACH3,
    					(VIEWERS7/UNIVERSE)*100 AS REACH7,
    					(VIEWERS13/UNIVERSE)*100 AS REACH13,
    					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
    					  (
    						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
    						  (
    							SELECT * FROM M_SUMM_REACH_PRODUCT
    							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
    							".$l_where_clause_kategori." 
    							".$l_where_clause_channel." 
    							GROUP BY CARDNO,PRODUCT
    							
    						  ) AS PRODUCT_VIEWERS,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
    						  AND COUNT_VIEW >= 1 
							   GROUP BY PRODUCT
    					  ) AS VW0
    					LEFT JOIN 
    						(
    						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
    						  (
    							SELECT * FROM M_SUMM_REACH_PRODUCT
    							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
    							".$l_where_clause_kategori." 
    							".$l_where_clause_channel." 
    							
    							GROUP BY CARDNO,PRODUCT
    							
    						  ) AS PRODUCT_VIEWERS,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
    						  AND COUNT_VIEW >= 2
							  GROUP BY PRODUCT
    					  ) AS VW2 ON VW0.PRODUCT = VW2.PRODUCT 
      					  LEFT JOIN
    						 (
    						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
    						  (
    							SELECT * FROM M_SUMM_REACH_PRODUCT
    							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
    							".$l_where_clause_kategori." 
    							".$l_where_clause_channel." 
    							
    							GROUP BY CARDNO,PRODUCT
    							
    						  ) AS PRODUCT_VIEWERS,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
    						  AND COUNT_VIEW >= 3
							  GROUP BY PRODUCT
    					  ) AS VW3 ON VW2.PRODUCT = VW3.PRODUCT 
      					  LEFT JOIN
    						(
    						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
    						  (
    							SELECT * FROM M_SUMM_REACH_PRODUCT
    							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
    							".$l_where_clause_kategori." 
    							".$l_where_clause_channel." 
    							
    							GROUP BY CARDNO,PRODUCT
    							
    						  ) AS PRODUCT_VIEWERS,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
    						  AND COUNT_VIEW >= 7
							  GROUP BY PRODUCT
    					  ) AS VW7 ON VW3.PRODUCT = VW7.PRODUCT 
      					  LEFT JOIN
    					  (
    						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
    						  (
    							SELECT * FROM M_SUMM_REACH_PRODUCT
    							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
    							".$l_where_clause_kategori." 
    							".$l_where_clause_channel." 
    							
    							GROUP BY CARDNO,PRODUCT
    							
    						  ) AS PRODUCT_VIEWERS,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
    						  AND COUNT_VIEW >= 13
							  GROUP BY PRODUCT
    					  ) AS VW13 ON VW7.PRODUCT = VW13.PRODUCT 
      					  LEFT JOIN
    					  (
    						  SELECT PRODUCT,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
    						  (
    							SELECT * FROM M_SUMM_REACH_PRODUCT
    							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
    							".$l_where_clause_kategori." 
    							".$l_where_clause_channel." 
    							
    							GROUP BY CARDNO,PRODUCT
    							
    						  ) AS PRODUCT_VIEWERS,
    						  (
    							".$params['sqlc'] ."
    						  ) BB
    							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
    						  AND COUNT_VIEW >= 21
							  GROUP BY PRODUCT
    					  ) AS VW21 ON VW13.PRODUCT = VW21.PRODUCT 
      					  ,
    					  (
    					  SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 0
    					  )
    					  AS UNIVERSE_REACH
    					)
    				";
  				}elseif($params['kategoriby'] == "advertiser"){
  							$sql = "
        				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
        					(VIEWERS3/UNIVERSE)*100 AS REACH3,
        					(VIEWERS7/UNIVERSE)*100 AS REACH7,
        					(VIEWERS13/UNIVERSE)*100 AS REACH13,
        					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS,
        						  (
        							".$params['sqlc'] ."
        						  ) BB
        							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
        						  AND COUNT_VIEW >= 1 
								  GROUP BY ADVERTISER
        					  ) AS VW0
        					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS,
        						  (
        							".$params['sqlc'] ."
        						  ) BB
        							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
        						  AND COUNT_VIEW >= 2
								  GROUP BY ADVERTISER
        					  ) AS VW2 ON VW0.ADVERTISER = VW2.ADVERTISER 
      					  LEFT JOIN
        						 (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS,
        						  (
        							".$params['sqlc'] ."
        						  ) BB
        							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
        						  AND COUNT_VIEW >= 3
								  GROUP BY ADVERTISER
        					  ) AS VW3 ON VW2.ADVERTISER = VW3.ADVERTISER 
      					  LEFT JOIN
        						(
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS,
        						  (
        							".$params['sqlc'] ."
        						  ) BB
        							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
        						  AND COUNT_VIEW >= 7
								  GROUP BY ADVERTISER
        					  ) AS VW7 ON VW3.ADVERTISER = VW7.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS,
        						  (
        							".$params['sqlc'] ."
        						  ) BB
        							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
        						  AND COUNT_VIEW >= 13
								  GROUP BY ADVERTISER
        					  ) AS VW13 ON VW7.ADVERTISER = VW13.ADVERTISER 
      					  LEFT JOIN
        					  (
        						  SELECT ADVERTISER,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
        						  (
        							SELECT * FROM M_SUMM_REACH_ADVERTISER
        							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
        							".$l_where_clause_kategori." 
        							".$l_where_clause_channel." 
        							
        							GROUP BY CARDNO,ADVERTISER
        							
        						  ) AS PRODUCT_VIEWERS,
        						  (
        							".$params['sqlc'] ."
        						  ) BB
        							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
        						  AND COUNT_VIEW >= 21
								  GROUP BY ADVERTISER
        					  ) AS VW21 ON VW13.ADVERTISER = VW21.ADVERTISER 
      					  ,
        					  (
        					   SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 0
        					  )
        					  AS UNIVERSE_REACH
        					)
        				";
  				}elseif($params['kategoriby'] == "sector"){
      					$sql = "
      				SELECT VIEWERS0,VIEWERS2,VIEWERS3,VIEWERS7,VIEWERS13,VIEWERS21,UNIVERSE, (VIEWERS0/UNIVERSE)*100 AS REACH0, (VIEWERS2/UNIVERSE)*100 AS REACH2,
      					(VIEWERS3/UNIVERSE)*100 AS REACH3,
      					(VIEWERS7/UNIVERSE)*100 AS REACH7,
      					(VIEWERS13/UNIVERSE)*100 AS REACH13,
      					(VIEWERS13/UNIVERSE)*100 AS REACH21 FROM (
      					  (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS0 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 1 
							  GROUP BY SECTOR
      					  ) AS VW0
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 2
							   GROUP BY SECTOR
      					  ) AS VW2 VW0.SECTOR = VW2.SECTOR 
      					  LEFT JOIN
      						 (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 3
							   GROUP BY SECTOR
      					  ) AS VW3 VW2.SECTOR = VW3.SECTOR 
      					  LEFT JOIN
      						(
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 7
							   GROUP BY SECTOR
      					  ) AS VW7 VW3.SECTOR = VW7.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 13
							   GROUP BY SECTOR
      					  ) AS VW13 VW7.SECTOR = VW13.SECTOR 
      					  LEFT JOIN
      					  (
      						  SELECT SECTOR,COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_kategori." 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO,SECTOR
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 21
							   GROUP BY SECTOR
      					  ) AS VW21 VW13.SECTOR = VW21.SECTOR 
      					  ,
      					  (
      					    SELECT val_int UNIVERSE FROM T_PARAM_UNICS WHERE NAME = 'UNIVERSE_CDR_".$name_tbs."' AND type_data = 0
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
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 1 
							  
      					  ) AS VW0
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS2 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 2
      					  ) AS VW2
      					  ,
      						 (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS3 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 3
      					  ) AS VW3
      					  ,
      						(
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS7 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 7
      					  ) AS VW7
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS13 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 13
      					  ) AS VW13
      					  ,
      					  (
      						  SELECT COUNT(DISTINCT(CARDNO)) AS VIEWERS21 FROM
      						  (
      							SELECT * FROM M_SUMM_REACH_SECTOR
      							WHERE TANGGAL BETWEEN '".$params['start_date']."' AND '".$params['end_date']."' 
      							".$l_where_clause_channel." 
      							
      							GROUP BY CARDNO
      							
      						  ) AS PRODUCT_VIEWERS,
      						  (
      							".$params['sqlc'] ."
      						  ) BB
      							WHERE PRODUCT_VIEWERS.CARDNO = BB.people 
      						  AND COUNT_VIEW >= 21
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
          $l_where_clause_startdate = ''; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = " AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
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
          
          $l_where_clause_channel = ' AND CHANNEL IN ('.$new_cin.') ';
          
         
      }
 	  
	   $db = $this->clickhouse->db();
      
      $sql = "SELECT COUNT(*) AS jumlah 
      FROM ( SELECT CHANNEL, PROGRAM, SECTOR, CATEGORY, ADVERTISER, PRODUCT ,START_TIME,END_TIME,DATE_UNICS FROM M_CIM_F2A_SUMMARY_CB as tcn
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
		$result = $query->rows(); 
		
       
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
      START_TIME, 
      `TYPE` AS ADS_TYPE,
      TVR as TVR,  
      DURATION_INT, DURATION, VIEWERS  
      FROM ( SELECT *,DATE_UNICS AS TANGGAL FROM M_CIM_F2A_SUMMARY_CB
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
		$result2 = $query2->rows(); 
		
 	  
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
  		FROM ( SELECT CHANNEL, PROGRAM, SECTOR, CATEGORY, ADVERTISER, PRODUCT ,START_TIME,END_TIME,DATE_UNICS AS TANGGAL FROM M_CIM_F2A_SUMMARY_CB 
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
      
	  if($params['searchtxt'] == ''){
		  $where_search = '';
	  }else{
		  
		  $where_search = " AND (`CHANNEL` LIKE '%".$params['searchtxt']."%' OR `PROGRAM` LIKE '%".$params['searchtxt']."%' OR `SECTOR` LIKE '%".$params['searchtxt']."%' OR `PRODUCT` LIKE '%".$params['searchtxt']."%' OR `ADVERTISER` LIKE '%".$params['searchtxt']."%' OR `START_TIME` LIKE '%".$params['searchtxt']."%' OR `DURATION` LIKE '%".$params['searchtxt']."%' OR `TYPE` LIKE '%".$params['searchtxt']."%' ) ";
	  }
	  
      if($params['start_date'] <> NULL){
          $l_where_clause_startdate = "AND `DATE_UNICS` >= '".$params['start_date']."' ";
      } else {
          $l_where_clause_startdate = ''; 
      }
      
      if($params['end_date'] <> NULL){
          $l_where_clause_enddate = " AND `DATE_UNICS` <= '".$params['end_date']."' ";
      } else {
          $l_where_clause_enddate = ''; 
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
          
          $l_where_clause_channel = ' AND CHANNEL IN ('.$new_cin.') ';
    
      }
		
		  $db = $this->clickhouse->db();
      
  		$sql2 = "SELECT
  			SUM(COST) AS sumcost, 
  			SUM(TVR) AS sumtvr, 
  			MAX(TVR) AS maxtvr, 
  			MIN(TVR) AS mintvr, 
  			AVG(TVR) AS avgtvr,
  			(SUM(COST)*1000) / SUM(TVR) as cprp,    
  			COUNT(DATE_UNICS) AS spot, 
        SUM(VIEWERS) AS sumviewers  FROM ( SELECT * FROM M_CIM_F2A_SUMMARY_CB
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
		$result = $query->rows(); 
  
  		while(mysqli_more_results($this->db->conn_id) && mysqli_next_result($this->db->conn_id)){
          if($l_result = mysqli_store_result($this->db->conn_id)){
              mysqli_free_result($l_result);
          }
  		}
  		
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
		
    $sql 	= "SELECT DISTINCT(SUBCAT) AS ".$kategori." FROM M_POSTBUY_SUBCAT_08_FTA
		WHERE STR_TO_DATE(`DATE`,'%Y-%m-%d') >= '".$params['start_date']."' 
    AND STR_TO_DATE(`DATE`,'%Y-%m-%d') <= '".$params['end_date']."'    
    AND CAT = '".$kategori."'    
		ORDER BY ".$kategori." ASC;";
 
		
		$query 	=  $this->db->query($sql);
		$this->db->close();
		$this->db->initialize(); 
		
		$return = $query->result_array();
		return $return;
	}
}