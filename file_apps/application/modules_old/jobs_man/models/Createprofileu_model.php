<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createprofileu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function validate_password($params = array()) {	
	
		$sql 	= 'SELECT id,  token 
						FROM hrd_profile
						WHERE id = ?
						AND id_role = 41';
			
			$query 	=  $this->db->query($sql,
				array(
					$params['uid']
				));
			$result = $query->result_array();
			
			if(isset($result[0]['token'])){
			
				if($params['token'] <> $result[0]['token']){
					
					$res = array(
						'status' => 0,
						'message' => 'Failed Authentication',
					); 
					
				}else{
					$res = array(
						'status' => 1,
						'message' => 'Success',
					); 
				}
			
			}else{
				$res = array(
						'status' => 0,
						'message' => 'Failed Authentication',
					); 
			}
			
			return $res;
	}
	

	public function listdataprofilenew($typerole){
        $table = 'SS_CLASS_U_BARU2';
		$queryh = 'SELECT DISTINCT CLASS_1_HEADER AS HEADER FROM '.$table.'';
		$sqlh = $this->db->query($queryh);
		$this->db->close();	   
		$hasilh = $sqlh->result_array();
		$i = -1;
		$result = array();
		$int = 0;
		$arr_child = array();
		$ja = 0;
		$array_profile = array();

		foreach ($hasilh as $k => $v) {
			$query1 = 'SELECT DISTINCT CLASS_2_HEADER AS ANAK1 FROM '.$table.' WHERE CLASS_1_HEADER="'.$v['HEADER'].'" ORDER BY ANAK1';
			$sql1 = $this->db->query($query1);
			$this->db->close();	   
			$hasil1 = $sql1->result_array();

			foreach ($hasil1 as $v1) {
					$arr_child[$int] = $v1;
					$query2 = 'SELECT DISTINCT CLASS_3_HEADER AS ANAK2 FROM '.$table.' WHERE CLASS_2_HEADER="'.$v1['ANAK1'].'" AND CLASS_1_HEADER="'.$v['HEADER'].'" AND CLASS_3_HEADER IS NOT NULL ORDER BY CLASS_3_HEADER ASC';
					$sql2 = $this->db->query($query2);
					$this->db->close();	   
					$hasil2 = $sql2->result_array();
					$arr_child[$int]['ANAK2'] = $hasil2;
					$int++;
			}				
			$array_profile['HEADER'][$v['HEADER']] = $arr_child;
			$arr_child = array();

			$ja++;
		}

		array_push($result, $array_profile);
		return $result;

	}


	public function listprofile($iduser,$idrole) {
		
		$query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub a WHERE (STATUS = 1 OR STATUS = 3) AND user_id_profil in(".$iduser.",0) order by a.`user_id_profil` ASC, status_job DESC, date_create desc ";
		
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	
	
	public function list_periode($params = array()) {
		
		$query = " ";
		
		
		
		$sql 	= 'SELECT * FROM T_PARAM_UNICS WHERE type_data = 1 order by id desc
                    LIMIT ? 
			        OFFSET ?';
					
					
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
               
				$params['limit'],
				$params['offset']
				
			));
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);

			$total_filtered = $this->db->query('SELECT  COUNT(`name`) as total_filtered FROM T_PARAM_UNICS WHERE type_data = 1')->row_array();
			$total = $this->db->query('SELECT  COUNT(`name`) as total FROM T_PARAM_UNICS WHERE type_data = 1')->row_array();
		/* } */
		
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);

		return $return;
			   
	}
	
	public function min_row() {
		
		$query = "SELECT VAL_INT AS MIN_ROW FROM T_PARAM_UNICS_UNIV WHERE DATA_TYPE = 'minimum_row' ";
		
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}		
	
	public function get_nper($periode) {
		
		$query = "SELECT * FROM USEETV_USAGE_2020 WHERE NPER = '".$periode."'";
		
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	
	
	public function listperiode() {
		
		$query = "SELECT *  FROM T_PERIODE order by PERIODE DESC ";
		
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
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
	
	
	function detail($id){
		
		$query2 = 'SELECT id, `name`, grouping
					FROM t_profiling_ub
					WHERE id = ?';  			
							$sql2	= $this->db->query($query2, array(
																		$id
													  )
							);
							$this->db->close();	   
							$hasil2 = $sql2->result_array();
							
			$dd = array();
			foreach($hasil2 as $new){
				$v = json_decode($new['grouping']);
				foreach($v as $newv){
				
					$query3 = 'SELECT FIELD_NAME, INDEX_FIELD FROM app_urate_field_dict WHERE INDEX_FIELD = "'.$newv->Tag.'"'; 
					
							$sql3	= $this->db->query($query3, array(
																		
													  )
							);
							$this->db->close();	   
							$hasil3 = $sql3->result_array();
						$newv->Field = $hasil3 ;
					
					array_push($dd, $newv);
				}
				$new['groupings'] = json_encode($dd);
			
			}
				
		return $new;
	}
	
	function detailnew($id){
		
		$query2 = 'SELECT id, `name`, grouping
					FROM t_profiling_ub
					WHERE id = ?';  			
							$sql2	= $this->db->query($query2, array(
																		$id
													  )
							);
							$this->db->close();	   
							$hasil2 = $sql2->result_array();
						
		return $hasil2;
	}
    
	function listsearch($id, $typerole){
		$table = 'SS_CLASS_U_BARU2';
        $query2 = 'SELECT distinct(VALUE_NAME) as name FROM '.$table.' WHERE VALUE_NAME like "%'.$id.'%"';  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();

				
		return $hasil2;
	}
	
	function searchopval($val){
		
		$query2 = 'SELECT * FROM t_source_fav_u where id_single_source = "'.$val.'" AND id_user = '.$this->session->userdata('user_id');  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();

				
		return $hasil2;
	}
	
	function ceksearchfav($data){
		
		$query2 = 'SELECT count(id) as hasil FROM t_source_fav_u where id_single_source = "'.$data['name'].'" and id_user = '.$this->session->userdata('user_id').' ';  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();

				
		return $hasil2;
	}
	
	function searchfav($data){
		
        $query2 = 'SELECT id, id_user,id_single_source,`status` FROM t_source_fav_u WHERE id_user = '.$this->session->userdata('user_id');  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();


        return $hasil2;	    

	}
	
	public function done_p($id){
		
		
				$sql 	= 'SELECT * FROM M_MONTH_PROFILE
							WHERE PROFILE_ID = '.$id.'
							AND STATUS_PROCESS <> 1
							ORDER BY PERIODE DESC';
					
					
		$query 	=  $this->db->query($sql);
		 $this->db->close();	 
		$result = $query->result_array();
		
		
		return $result;
		
		
	}
	
	public function done_p1($id){
		
		
				$sql 	= 'SELECT * FROM M_MONTH_PROFILE
							WHERE PROFILE_ID = '.$id.'
							AND STATUS_PROCESS = 1
							ORDER BY PERIODE DESC';
					
					
		$query 	=  $this->db->query($sql);
		 $this->db->close();	 
		$result = $query->result_array();
		
		
		return $result;
		
		
	}
	
	
	public function change_jobs_time($str,$set_hours,$set_min){
		
		$tm = $set_hours.':'.$set_min.':00';
		
		$query = " UPDATE JOBS_STATUS SET TIME_S = '".$tm."' WHERE `JOBS_ID` = '".$str."' ";
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
	}		
	
	public function change_jobs_univ($str,$set_name,$set_univ){
		
		
		$query = " UPDATE T_PARAM_UNICS SET val_str = '".$set_univ."',val_int = '".$set_univ."' WHERE `name` = '".$set_name."' ";
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
	}	
	
	public function change_min_row($set_min){
		
		
		
		$query = " UPDATE T_PARAM_UNICS_UNIV SET VAL_INT = '".$set_min."', VAL_STR =  '".$set_min."' WHERE `PERIODE` = 'MIN_ROW' ";
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
	}
	
	public function change_jobs($aaa){
		
		$query = " UPDATE JOBS_STATUS SET JOBS_STATUS = '".$aaa[0]."' WHERE `JOBS_ID` = '".$aaa[1]."' ";
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
	}
	
	
	
	public function list_jobs_set($params = array()) {					
    
		$sql 	= 'SELECT * FROM `JOBS_STATUS` WHERE JOBS_PROP = 1 ORDER BY JOBS_ID
                    ';
					
					
		$out = array();
		$query 	=  $this->db->query($sql);
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);

			$total_filtered = $this->db->query('SELECT COUNT(JOBS_NAME) as total_filtered  FROM JOBS_STATUS
					WHERE JOBS_STATUS IN (1,2)')->row_array();
			$total = $this->db->query('SELECT  COUNT(JOBS_NAME) as total FROM JOBS_STATUS
					WHERE JOBS_STATUS IN (1,2)')->row_array();
		/* } */
		
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);

		return $return;
	}
	
	public function list_profile($params = array()) {					
    
		$sql 	= 'SELECT * FROM JOBS_QUEUE A
					LEFT JOIN JOBS_PRIORITY B ON A.QUEUE = B.JOBS_ID
					WHERE STATUS_JOBS IN (1,2)
					ORDER BY STATUS_JOBS,B.PRIORITY,JOBS_DATE 
                    LIMIT ? 
			        OFFSET ?';
					
					
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
               
				$params['limit'],
				$params['offset']
				
			));
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);

			$total_filtered = $this->db->query('SELECT  COUNT(JOBS_DATE) as total_filtered FROM JOBS_QUEUE
					WHERE STATUS_JOBS IN (1,2)')->row_array();
			$total = $this->db->query('SELECT  COUNT(JOBS_DATE) as total FROM JOBS_QUEUE
					WHERE STATUS_JOBS IN (1,2)')->row_array();
		/* } */
		
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);

		return $return;
	}


	public function check_job_user(){
		
		$id_user = $this->session->userdata('user_id');
		
		$query = " SELECT COUNT(`id`) AS RUNNING_JOB FROM `t_profiling_ub` WHERE user_id_profil = ".$id_user." AND status_job = 2 ";
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
		
		
	}
	
	public function insert_pid($list_id,$pis){
		
		$id_user = $this->session->userdata('user_id');
		
		$query = " update t_profiling_ub set status_job = 2, pid = '".$pis."',date_process ='".date("Y-m-d H:i:s")."' where `id` ='".$list_id."' ";
		
		$sql	= $this->db->query($query);
		$this->db->close();	
  
		
		
	}
  
  public function insert_pid_partial($list,$periode_list){
    $periodel = "";
    $auxWhere = "";
    
    if($periode_list[0] != "all"){
        for($i=0; $i < sizeof($periode_list); $i++){
            $periodel .= "'" . $periode_list[$i] . "',";          
        }
        
        $periodel = rtrim($periodel,",");
          
        $auxWhere = "AND PERIODE IN(".$periodel.")";
    }
      
    $query = "UPDATE M_MONTH_PROFILE SET STATUS_PROCESS = 2 WHERE PROFILE_ID = ".$list." ".$auxWhere;
		
		$sql	= $this->db->query($query);
		$this->db->close();	
	}    
	
	public function inset_queue($list_id,$periode_list){
				
		$id_user = $this->session->userdata('user_id');
		$periodel = "";
		$auxWhere = "";
		
		if($periode_list[0] != "all"){
			for($i=0; $i < sizeof($periode_list); $i++){
				$periodel .= "'" . $periode_list[$i] . "',";          
			}
			
			$periodel = rtrim($periodel,",");
			  
			$auxWhere = "AND PERIODE IN(".$periodel.")";
		}
		  
		$query = "UPDATE M_MONTH_PROFILE SET STATUS_PROCESS = 2 WHERE PROFILE_ID = ".$list_id." ".$auxWhere;
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
		
		$query = "UPDATE t_profiling_ub SET status_job = 1, date_process = '".date('Y-m-d H:i:s')."' WHERE `id` = ".$list_id;
		
		$sql	= $this->db->query($query);
		$this->db->close();	
  
		
		
	}
		
		
		
  
		
		
	
		
	
			
			
		
	
	
	
public function create($data) {
		
		
		
	$categorynew = array();
	$category = array("Tag"=>array(), "Data"=>array(), "Operation"=>array(), "Header" => array());
	$valuesbaru = array();
	$values = array();
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
	$web_interest1 = '';
	
	
	$demo1 = '';
	
	if(!$data['list']){
		$datain =  '';
	}else{
		
			foreach($data['list'] as $new){
				
				
				$newdata = explode("=",$new);
			
                if(isset($newdata[1])){
                    if($newdata[1]){
                        foreach($data['isi'] as $new1){
                            $newdata1 = explode("=",$new1);
                            if($newdata1[0] == $newdata[0]){

                                    
                                    $newdata[]= $newdata1[1];
                            }
                        }
                        $totals = array($newdata[1] => $newdata[0]);
                        $newdata[4]= "OR";
                        array_push($values, $newdata);	
                    }	

                    if(!in_array($newdata[1], $category, true)){

                        $category['Tag'] = $newdata[1];
						
                        array_push($categorynew, $category);

                    }

                    if(!in_array($newdata[2], $category, true)){

                       $category['Header'] = $newdata[1];
                        array_push($categorynew, $category);

                    }

					if ($newdata[2]=='GEOGRAFI') {
                    	$kota1 .= "'".$newdata[0]."'".", ";
                    }
					
					elseif($newdata[2]=='DEMOGRAFI'){
                    	$demo1 .= "'".$newdata[0]."'".", ";
						if($newdata[1]=='AGE_GROUP'){
							$addgroup1 .= "'".$newdata[0]."'".", ";	
						}    
						elseif($newdata[1]=='GENDER'){
							$demgender1 .= "'".$newdata[0]."'".", ";
						}    
						elseif($newdata[1]=='DIGITAL_SEGMENT'){
							$digitalsegment1 .= "'".$newdata[0]."'".", ";
						}    
						elseif($newdata[1]=='SES_SEGMENT'){
							$sessegment1 .= "'".$newdata[0]."'".", ";
						}    
						elseif($newdata[1]=='HOUSEHOLD_PROFILE'){
							$householdprofile1 .= "'".$newdata[0]."'".", ";
						}   
						elseif($newdata[1]=='HOUSEHOLD_COMM_EXPENSE'){
							$katarpu1 .= "'".$newdata[0]."'".", ";
						}
						elseif($newdata[1]=='WEB_INTEREST'){
							$web_interest1 .= "'".$newdata[0]."'".", ";
						}

						
                    }    					
                    else{
                    	$helix1 .= "'".$newdata[0]."'".", ";
                    }                                     
                    
                }
				
				
			}
			  	
				
			$ss = array();
			$valuesbaru = array();
			$datamasuk = array();
			$sementara = array();
			foreach($categorynew as $newcategory){
				$tmp = [];
				$tmp2 = [];
				$tmp3 = [];
				$tmp4 = [];
				
				foreach($values as $newvalues){
					if($newvalues[1] == $newcategory['Tag']){
						array_push($tmp, str_replace("'"," ", $newvalues[0]));
						if(!in_array($newvalues[1], $tmp2, true)){
							array_push($tmp2, $newvalues[1]);
						}
						if(!in_array($newvalues[2], $tmp4, true)){
							array_push($tmp4, $newvalues[2]);
						}
						if(isset($newvalues[2])){
                         	if(!in_array($newvalues[2], $tmp3, true)){
                                
								array_push($tmp3, $newvalues[2]);
                                $tmp3[1] = "AND";
                                $tmp3[2] = "OR";
								
							}
                           array_push($sementara, $newvalues);
						}
						
					}
					
				}

				foreach($tmp4 as $header){
					$lh = $this->getReal1($header);
					
					$datamasuk[$newcategory['Tag']]['Header'] = $lh[0]['CLASS_1_REAL'];
				}

				foreach($tmp2 as $tag){
					$lh2 = $this->getReal2($tag);
					$datamasuk[$newcategory['Tag']]['Tag'] = $lh2[0]['CLASS_2_REAL'];
				}
                
                
                   
                       
                           
    				
				$datamasuk[$newcategory['Tag']]['Data'] = $tmp;
			}

			
		
			
			foreach($datamasuk as $newdatamasuk){
                if($newdatamasuk['Data'][0] != "j1"){
					
                    array_push($ss, $newdatamasuk);
                }
				
			}
			
			$datain = json_encode($ss);
			
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
	$web_interest = substr($web_interest1,0,-2);
	
	
	$demo = substr($demo1,0,-2);
	$kota = 'KOTA IN('.$kota.') AND';
	$helix = 'PERSONAS IN('.$helix.') AND';
	$addgroup = 'AGE_GROUP IN('.$addgroup.') AND';
	$demgender = 'DEM_GENDER_PRED IN('.$demgender.') AND';
	$digitalsegment = 'DIGITAL_SEGMENT IN('.$digitalsegment.') AND';
	$sessegment = 'SES_SEGMENT IN('.$sessegment.') AND';
	$householdprofile = 'HOUSEHOLD_PROFILE IN('.$householdprofile.') AND';
	$katdevice = 'KAT_DEVICE IN('.$katdevice.') AND';
	$katarpu = 'KAT_ARPU IN('.$katarpu.') AND';
	$web_interest = 'WEB_INTEREST IN('.$web_interest.') AND';
	
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
		if ($web_interest1 !=='') {
			$textwhere = $textwhere.' '.$web_interest;
		}
		
		

	$a = '"';
	
	
	
	
	
	$querycnt = "SELECT COUNT(`CARDNO`) AS people FROM M_SINGLE_SOURCE_BARU18 ".$text.$textwhere;
	$querycnt = substr($querycnt,0,-3);
	
	$sqliCNT	= $this->db->query($querycnt);
	
	$hasilcnt = $sqliCNT->row(); 
	
	
		
 
				
	
	
	$sql 	= "INSERT INTO t_profiling_ub(`name`,grouping,`status`, people, user_id,user_id_profil,postbuy_status,mediaplan_status,status_dash_str,status_tvcc_str,status_tvpc_str,cm_status_str,date_create) VALUES('".$data['name']."','".$datain."','1',".$hasilcnt->people.", '','".$this->session->userdata('user_id')."','0 %','0 %','0 %','0 %','0 %','0 %','".date("Y-m-d H:i:s")."')";
	
	if ($sql) {
		
				$this->db->query($sql);
						$sql2 = "SELECT LAST_INSERT_ID() seq_tb_product;";
						$i2 = $this->db->query($sql2);
						$rows = $i2->row();
						$idTagHar = $rows->seq_tb_product;
						
						$script_check ="SELECT TIMESTAMPDIFF(MONTH, '2017-07-01', '".date("Y-m-d")."') as DIFF ";

							$query2 	=  $this->db->query($script_check);
							$this->db->close();	 
							$result6 = $query2->result_array();
							
							$today = date('Y-m');
							$month_l = $result6[0]['DIFF'] + 1;
							
							for($i=0;$i<$month_l;$i++){
								
								$newdate = date('Y-m', strtotime('-'.$i.' months', strtotime($today))); 
								$i0 =  date_format(date_create($newdate),"Y-m");
								
								$sql5 = "INSERT INTO M_MONTH_PROFILE VALUES('".$i0."','','',".$idTagHar.",'0') ";
								$this->db->query($sql5);
								
								
							}

						
						
						$queryid = "SELECT DISTINCT(`CARDNO`) AS people, ".$idTagHar." as idp,'0' AS FTA FROM M_SINGLE_SOURCE_BARU18 ".$text.$textwhere;
	
						$queryid = substr($queryid,0,-3);
						
						$queryid2 = " INSERT INTO PROFILE_CARDNO ".$queryid;
						
						$sqlid	= $this->db->query($queryid2);
						
						return $idTagHar;
		
	} 
	else {
		return false;
	}

	}
	
	public function create_pav($data){
		$user_id = $this->session->userdata('user_id');
        if($data['status'] == 1){
                $sql 	= "INSERT INTO t_source_fav_u(id_user,id_single_source,`status`, child) VALUES(?,?,?,?)";
                
        }else{
                $sql 	= "DELETE FROM t_source_fav_u
                            WHERE id_user = ? and id_single_source = ?";
              
        } 
             if ($sql) {
                 
                 if($data['status'] == 1){
                    $this->db->query($sql, array(
                                            $user_id ,
                                            $data['name'],
                                            $data['status'],
                                            $data['child'],

                    ));  
                }else{
                     $this->db->query($sql, array(
                                            $user_id ,
                                            $data['name'],

                     ));  
                } 
                 
                     
                    
                $query2 = 'SELECT id, id_user,id_single_source,`status` FROM t_source_fav_u WHERE id_user = '.$user_id ;  			
                $sql2	= $this->db->query($query2);
                $this->db->close();	   
                $hasil2 = $sql2->result_array();


                return $hasil2;	    


            } 
            else {
                return false;
            }	
	}
	
	public function getReal2($level2){
		
		$query = "SELECT CLASS_2_REAL FROM SS_CLASS_U_BARU2 WHERE CLASS_2_HEADER = '".$level2."' limit 1";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	  
		
	}
	
		
	public function getReal1($level2){
		
		$query = "SELECT CLASS_1_REAL FROM SS_CLASS_U_BARU2 WHERE CLASS_1_HEADER = '".$level2."' limit 1";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	  
		
	}
	
public function get_userid3($data) {
		$a = '"';
		$query = "SELECT CARDNO AS USER_ID, COUNT(DISTINCT CARDNO) as people FROM M_SINGLE_SOURCE_BARU18 ".$data;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	 

public function content_grouping($profile) {
		$query = 'Select grouping, `status`
                    from t_profiling_ub
                    where id = ?';  		
		$sql	= $this->db->query($query,array($profile));
		$this->db->close();
		$this->db->initialize(); 
		return $sql->row_array();	   
	}
public function create_statistic($namaprofile,$data, $people, $user_id, $onlyconsonants) {
			$user_id = "'".$user_id."'";
			
			$sql 	= "INSERT INTO t_profiling_ub(`name`,grouping,`status`, people, user_id,user_id_profil,postbuy_status,mediaplan_status,status_dash_str,status_tvcc_str,status_tvpc_str,cm_status_str,date_create) VALUES('".$namaprofile."','".$data."','3',".$people.", '','".$this->session->userdata('user_id')."','0 %','0 %','0 %','0 %','0 %','0 %','".date("Y-m-d H:i:s")."')";
			
			if ($sql) {
				$this->db->query($sql);
						$sql2 = "SELECT LAST_INSERT_ID() seq_tb_product;";
						$i2 = $this->db->query($sql2);
						$rows = $i2->row();
						$idTagHar = $rows->seq_tb_product;
						
							$script_check ="SELECT TIMESTAMPDIFF(MONTH, '2017-07-01', '".date("Y-m-d")."') as DIFF ";

							$query2 	=  $this->db->query($script_check);
							$this->db->close();	 
							$result6 = $query2->result_array();
							
							$today = date('Y-m');
							$month_l = $result6[0]['DIFF'] + 1;
							
							for($i=0;$i<$month_l;$i++){
								
								$newdate = date('Y-m', strtotime('-'.$i.' months', strtotime($today))); 
								$i0 =  date_format(date_create($newdate),"Y-m");
								
								$sql5 = "INSERT INTO M_MONTH_PROFILE VALUES('".$i0."','','',".$idTagHar.",'0') ";
								$this->db->query($sql5);
								
								
							}

						
						
						$queryid = "SELECT DISTINCT(`CARDNO`) AS people, ".$idTagHar." as idp,'0' AS FTA FROM M_SINGLE_SOURCE_BARU18 ".$onlyconsonants;
	
						
						$queryid2 = " INSERT INTO PROFILE_CARDNO ".$queryid;
						
						$sqlid	= $this->db->query($queryid2);
						
						return $idTagHar; 
				} 
				else {
					return false;
				}
	}			  		
  
  public function checkname($user_id, $qname){
      $query = "SELECT COUNT(`name`) AS CONAME FROM t_profiling_ub WHERE user_id_profil = ".$user_id." AND UPPER(`name`) = '".strtoupper($qname)."'";
      
      $sql	= $this->db->query($query);
  		$this->db->close();
  		$this->db->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CONAME'];
  }
  
  public function listnotyet($prof_id) {
		$query = "SELECT PERIODE FROM M_MONTH_PROFILE WHERE STATUS_PROCESS = 0 AND PROFILE_ID = ".$prof_id." ORDER BY PERIODE DESC";
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
}	
