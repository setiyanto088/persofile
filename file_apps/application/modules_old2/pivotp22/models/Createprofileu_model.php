<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createprofileu_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
		
	public function pivot_data($query){
		$db = $this->clickhouse->db();
		

$result = $db->select($query);
		return $result->rows();			
		
	}		
	
	public function pivot_data_label(){
		$db = $this->clickhouse->db();
		
		$query = "
		SELECT * from `TREE_PROFILING_RES_P22`
		WHERE (`IS_CHILD` = 1 OR FIELD = 'KOTA' )
		AND STATUS_TREE = '1'
		";
		

$result = $db->select($query);
		return $result->rows();			
		 
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
	
	public function get_one($querys){
		
			
		$query = $querys;
		
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
		
	}
	
	

	public function listdataprofilenew2($typerole){
        $table = 'SS_CLASS_U_BARU2_RES_2';
		$queryh = 'SELECT DISTINCT CLASS_1_HEADER AS HEADER FROM '.$table.' WHERE CLASS_1_HEADER = "MEDIA HABBIT" ';
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
			$query1 = 'SELECT DISTINCT CLASS_2_HEADER AS VAL_ANAK1, CLASS_2_NAME AS ANAK1 FROM '.$table.' WHERE CLASS_1_HEADER="'.$v['HEADER'].'" AND CLASS_2_HEADER IN ("internet_cons","inet_type")  ORDER BY ORDER_SEQ, ANAK1';
			$sql1 = $this->db->query($query1);
			$this->db->close();	   
			$hasil1 = $sql1->result_array();

			
			foreach ($hasil1 as $v1) {
					$arr_child[$int] = $v1;
					$query2 = 'SELECT DISTINCT CLASS_3_HEADER AS VAL_ANAK2, CLASS_3_NAME AS ANAK2 FROM '.$table.' WHERE CLASS_2_HEADER="'.$v1['VAL_ANAK1'].'" AND CLASS_1_HEADER="'.$v['HEADER'].'" AND CLASS_3_HEADER IS NOT NULL ORDER BY CLASS_3_HEADER ASC';
					$sql2 = $this->db->query($query2);
					$this->db->close();	   
					$hasil2 = $sql2->result_array();
					
					$arr_child[$int]['ANAK2'] = $hasil2;
					
					
					
					$int3 = 0;
					foreach ($hasil2 as $v2) {
						
						$query3 = 'SELECT DISTINCT CLASS_4_HEADER AS VAL_ANAK3, CLASS_4_NAME AS ANAK3 FROM '.$table.' WHERE CLASS_3_HEADER="'.$v2['VAL_ANAK2'].'" AND CLASS_2_HEADER="'.$v1['VAL_ANAK1'].'" AND CLASS_4_HEADER IS NOT NULL ORDER BY CLASS_4_HEADER ASC';
						$sql3 = $this->db->query($query3);
						$this->db->close();	   
						$hasil3 = $sql3->result_array();
						
						$int3++;
						
						
					}
					
					$int++;
					
			}				
			$array_profile['HEADER'][$v['HEADER']] = $arr_child;
			$arr_child = array();

			$ja++;
		}

		array_push($result, $array_profile);
		return $result;

	}
	
	public function listdataprofilenew($typerole){
        $table = 'SS_CLASS_U_BARU2_RES_2';
		$queryh = 'SELECT DISTINCT CLASS_1_HEADER AS HEADER FROM '.$table.' ';
		$sqlh = $this->db->query($queryh);
		$this->db->close();	   
		$hasilh = $sqlh->result_array();
		$i = -1;
		$result = array();
		$int = 0;
		$int2 = 0;
		$int3 = 0;
		$arr_child = array();
		$arr_child2 = array();
		$arr_child3 = array();
		$ja = 0;
		$nomu = "";
		$array_profile = array();

		foreach ($hasilh as $k => $v) {
			$query1 = 'SELECT DISTINCT CLASS_2_HEADER AS VAL_ANAK1, CLASS_2_NAME AS ANAK1, CLASS_1_HEADER AS HEADER FROM '.$table.' WHERE CLASS_1_HEADER="'.$v['HEADER'].'" ORDER BY ORDER_SEQ, ANAK1';
			$sql1 = $this->db->query($query1);
			$this->db->close();	   
			$hasil1 = $sql1->result_array();

			foreach ($hasil1 as $v1) {
					$arr_child[$int] = $v1;
					if($v1['HEADER'] == "MEDIA HABBIT" || $v1['HEADER'] == "HEALTH" || $v1['HEADER'] == "VACATION"){
							$nomu = "";
					}else{
						$nomu = ", CLASS_1_REAL, VALUE_NAME ";
					}
					$query2 = 'SELECT DISTINCT CLASS_3_HEADER AS VAL_ANAK2, CLASS_3_NAME  AS ANAK2 '.$nomu.'  FROM '.$table.' WHERE CLASS_2_HEADER="'.$v1['VAL_ANAK1'].'" AND CLASS_1_HEADER="'.$v['HEADER'].'" AND CLASS_3_HEADER IS NOT NULL ORDER BY ORDER_SEQ, CLASS_3_HEADER ASC';
					$sql2 = $this->db->query($query2);
					$this->db->close();	   
					$hasil2 = $sql2->result_array();
					
					foreach ($hasil2 as $v2) {
						$arr_child[$int]['ANAK2'][$int2] = $v2;
							$query3 = 'SELECT DISTINCT CLASS_4_HEADER AS VAL_ANAK3, CLASS_4_NAME AS ANAK3, CLASS_1_REAL, VALUE_NAME, "'.$v2['VAL_ANAK2'].'" as PARENT FROM '.$table.' WHERE CLASS_3_HEADER="'.$v2['VAL_ANAK2'].'" AND CLASS_1_HEADER="'.$v['HEADER'].'" AND CLASS_4_HEADER IS NOT NULL ORDER BY ORDER_SEQ, CLASS_4_HEADER ASC';
							$sql3 = $this->db->query($query3);
							$this->db->close();	   
							$hasil3 = $sql3->result_array();
							foreach($hasil3 as $v3){
								
								if($v3['VAL_ANAK3']){
									if($v3['PARENT'] == $v2['VAL_ANAK2']){
										$arr_child[$int]['ANAK2'][$int2]['ANAK3'] = $hasil3;
									}
								}			
							}
							
							
						$int2++;
					}
					
					
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
		
		$query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub_res a order by a.`user_id_profil` ASC, status_job DESC, date_create desc ";
		
		
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
					FROM t_profiling_ub_res
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
		$table = 'TREE_PROFILING_RES';
        $query2 = 'SELECT distinct(LABEL) as name FROM '.$table.' WHERE LABEL like "%'.$id.'%"';  			
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
		
		
				$sql 	= 'SELECT * FROM M_MONTH_PROFILE_RES
							WHERE PROFILE_ID = '.$id.'
							AND STATUS_PROCESS <> 1
							ORDER BY PERIODE DESC';
					
					
		$query 	=  $this->db->query($sql);
		 $this->db->close();	 
		$result = $query->result_array();
		
		
		return $result;
		
		
	}
	
	public function done_p1($id){
		
		
				$sql 	= 'SELECT * FROM M_MONTH_PROFILE_RES
							WHERE PROFILE_ID = '.$id.'
							AND STATUS_PROCESS = 1
							ORDER BY PERIODE DESC';
					
					
		$query 	=  $this->db->query($sql);
		 $this->db->close();	 
		$result = $query->result_array();
		
		
		return $result;
		
		
	}
	
	public function list_profile($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'and ( a.id LIKE "%'.$params['filter'].'%" OR a.`name` LIKE "%'.$params['filter'].'%" OR a.people LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'asc';
        }
        
		
		$sql 	= 'SELECT a.id as idprofile, *  FROM t_profiling_ub_res a WHERE user_id_profil IN('.$params['iduser'].',0) '.$filter.'
                    ORDER BY a.`user_id_profil` ASC,status_job DESC, date_process DESC , name ASC
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
    /*
		if ($params['idrole']==18) {
			$total_filtered = $this->db->query('SELECT COUNT(id) as total_filtered FROM t_profiling_ub  where status = 1 or status = 3 ')->row_array();
			$total = $this->db->query('SELECT COUNT(id) as total FROM t_profiling_ub where status = 1 or status = 3 ')->row_array();
		} else {
    */
			$total_filtered = $this->db->query('SELECT COUNT(a.id) as total_filtered FROM t_profiling_ub_res a where (status = 1 or status = 3) AND user_id_profil IN('.$params['iduser'].',0)')->row_array();
			$total = $this->db->query('SELECT COUNT(a.id) as total FROM t_profiling_ub_res a where (status = 1 or status = 3) AND user_id_profil IN('.$params['iduser'].',0)')->row_array();
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
	
public function create1($data) {
	print_r($data);die;	
	$categorynew = array();
	$category = array("Tag"=>array(), "Data"=>array(), "Operation"=>array());
	$valuesbaru = array();
	$values = array();
	$datain =  '';
    $user_jumlah = 0;
    $user_profile = '';
    $text = 'WHERE';
    $text .= '';
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
                        $newdata[4]= "AND";
                        array_push($values, $newdata);	
                    }	

                    if(!in_array($newdata[1], $category, true)){

                        $category['Tag'] = $newdata[1];
                        array_push($categorynew, $category);

                    }
                    if ($newdata[2]=='KOTA') {
                    	$text .= 'OR KOTA="'.$newdata[0].'"';
                    }
                    else{
                    	$text .= 'OR PERSONAS_TRIM="'.$newdata[0].'"';	
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
				
				foreach($values as $newvalues){
					if($newvalues[1] == $newcategory['Tag']){
						array_push($tmp, str_replace("'"," ", $newvalues[0]));
						if(!in_array($newvalues[1], $tmp2, true)){
							array_push($tmp2, $newvalues[1]);
						}
						if(isset($newvalues[2])){
                         	if(!in_array($newvalues[2], $tmp3, true)){
                                
								array_push($tmp3, $newvalues[1]);
                                $tmp3[1] = "AND";
                                $tmp3[2] = $newvalues[1];
								
							}
                           array_push($sementara, $newvalues);
						}
						
					}
					
				}
				foreach($tmp2 as $tag){
					$datamasuk[$newcategory['Tag']]['Tag'] = $tag;
				}
                $caca = [];
                $headkey = [];
                $ct = 0;
                $lenghthead = count($tmp3);
				$datamasuk[$newcategory['Tag']]['Data'] = $tmp;				
				
			}

			foreach($datamasuk as $newdatamasuk){
                if($newdatamasuk['Data'][0] != "j1"){
                    array_push($ss, $newdatamasuk);
                }
				
			}
			
			$datain = json_encode($ss);
			$a = '"';
			$textwhere = array('WHEREOR', 'WHERE AND');
			$textreplca = "WHERE";
			$text = str_replace($textwhere, $textreplca, $text);
			$queryid = "SELECT GROUP_CONCAT(DISTINCT CONCAT('".$a."', NO, '".$a."')) AS USER_ID, COUNT(DISTINCT NO) as people FROM M_SINGLE_SOURCE_BARU ".$text;
			$sqlid	= $this->db->query($queryid);
			$this->db->close();	   
			$hasilid = $sqlid->row();
			$hasilid->USER_ID = "'".$hasilid->USER_ID."'";
			$sql 	= "INSERT INTO t_profiling_ub(`name`,grouping,`status`, people, user_id) VALUES('".$data['name']."','".$datain."','1',".$hasilid->people.", ".$hasilid->USER_ID.")";
			
			
			
			
			if ($sql) {
				
				
				$this->db->query($sql);
						$sql2 = "SELECT LAST_INSERT_ID() seq_tb_product;";
						$i2 = $this->db->query($sql2);
						$rows = $i2->row();
						$idTagHar = $rows->seq_tb_product;
						return $idTagHar;
			} 
			else {
				return false;
			}
	}
      
       
	}	


	public function check_job_user(){
		
		$id_user = $this->session->userdata('user_id');
		
		$query = " SELECT COUNT(`id`) AS RUNNING_JOB FROM `t_profiling_ub_res` WHERE user_id_profil = ".$id_user." AND status_job = 2 ";
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
		
		
	}
	
	public function insert_pid($list_id,$pis){
		
		$id_user = $this->session->userdata('user_id');
		
		$query = " update t_profiling_ub_res set status_job = 2, pid = '".$pis."',date_process ='".date("Y-m-d H:i:s")."' where `id` ='".$list_id."' ";
		
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
		  
		$query = "UPDATE M_MONTH_PROFILE_RES SET STATUS_PROCESS = 2 WHERE PROFILE_ID = ".$list." ".$auxWhere;
			
			$sql	= $this->db->query($query);
			$this->db->close();	
	}    
	
	public function inset_queue2($list_id,$periode_list,$command){
				
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
		
		
		
		$query = "UPDATE M_MONTH_PROFILE_RES SET STATUS_PROCESS = 2 WHERE PROFILE_ID = ".$list_id." ".$auxWhere;
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
		
		
		$script_check_date = "	INSERT INTO JOBS_QUEUE VALUES('".$list_id."','".$command."',NULL,NULL,2,'".date("Y-m-d H:i:s")."',18,NULL,NULL,2,'')  ";	
								
		$sql	= $this->db->query($script_check_date);
		$this->db->close();	
		
		$query2 = "UPDATE t_profiling_ub_res SET status_job = 3, date_process = '".date('Y-m-d H:i:s')."' WHERE `id` = ".$list_id;
		
		$sql2	= $this->db->query($query2);
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
		
		
		
		$query = "UPDATE M_MONTH_PROFILE_RES SET STATUS_PROCESS = 2 WHERE PROFILE_ID = ".$list_id." ".$auxWhere;
		
		$sql	= $this->db->query($query);
		$this->db->close();	
		
		
		$query = "UPDATE t_profiling_ub_res SET status_job = 1, date_process = '".date('Y-m-d H:i:s')."' WHERE `id` = ".$list_id;
		
		$sql	= $this->db->query($query);
		$this->db->close();	
  
		
		
	}
		
		
		
  
		
		
	
		
	
			
			
		
	
	
	
public function create($data,$where,$grouping) {
		
	
		
	
	
	$queryid = "SELECT COUNT(CARDNO) AS people, SUM(WEIGHT) AS populasi,SUM(WEIGHT_ALL) AS populasi_all FROM `HELIX_RES2` WHERE 1=1 ".$where;
	$sqliCNT	= $this->db->query($queryid);
	
	$hasilcnt = $sqliCNT->row(); 
	
	if($hasilcnt->people == '' ){
		
		$respondents = 0;
		$respondents_all = 0;
		$people  = 0;
		
	}else{
		
		$respondents = $hasilcnt->populasi;
		$respondents_all = $hasilcnt->populasi_all;
		$people = $hasilcnt->people;
	}
	
	$sql 	= "INSERT INTO t_profiling_ub_res(`name`,grouping,`status`, people,respondents,respondents_all, user_id,user_id_profil,postbuy_status,mediaplan_status,status_dash_str,status_tvcc_str,status_tvpc_str,cm_status_str,date_create) 
	VALUES('".$data['name']."','".$grouping."','1',".$people.",".$respondents.",".$respondents_all.", '','".$this->session->userdata('user_id')."','0 %','0 %','0 %','0 %','0 %','0 %','".date("Y-m-d H:i:s")."')";
	
	if ($sql) {
		
				$this->db->query($sql);
				$id = $this->db->insert_id();
				

				$sqlada = 	" INSERT INTO PROFILE_CARDNO_RES 
							 SELECT CARDNO,".$id." AS ID_PROFILE, 0 AS PO, weight, weight_all FROM `HELIX_RES2` WHERE 1=1 ".$where;
				$this->db->query($sqlada);

						
						$script_check ="SELECT TIMESTAMPDIFF(MONTH, '2020-01-01', '".date("Y-m-d")."') as DIFF ";

							$query2 	=  $this->db->query($script_check);
							$this->db->close();	 
							$result6 = $query2->result_array();
							
							$today = date('Y-m');
							$month_l = $result6[0]['DIFF'] + 1;
							
							for($i=0;$i<$month_l;$i++){
								
								$newdate = date('Y-m', strtotime('-'.$i.' months', strtotime($today))); 
								$i0 =  date_format(date_create($newdate),"Y-m");
								
								$sql5 = "INSERT INTO M_MONTH_PROFILE_RES VALUES('".$i0."','','',".$id.",'0') ";
								$this->db->query($sql5);
								
								
							}

						
						
	
						
						
						
						return $id;
		
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
		
		$query = "SELECT CLASS_2_REAL FROM SS_CLASS_U_BARU2_REV WHERE CLASS_2_HEADER = '".$level2."' limit 1";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	  
		
	}
	
		
	public function getReal1($level2){
		
		$query = "SELECT CLASS_1_REAL FROM SS_CLASS_U_BARU2_REV WHERE CLASS_1_HEADER = '".$level2."' limit 1";
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
								
								$sql5 = "INSERT INTO M_MONTH_PROFILE_RES VALUES('".$i0."','','',".$idTagHar.",'0') ";
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
      $query = "SELECT COUNT(`name`) AS CONAME FROM t_profiling_ub_res WHERE user_id_profil = ".$user_id." AND UPPER(`name`) = '".strtoupper($qname)."'";
      
      $sql	= $this->db->query($query);
  		$this->db->close();
  		$this->db->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CONAME'];
  }
  
  public function listnotyet($prof_id) {
		$query = "SELECT PERIODE FROM M_MONTH_PROFILE_RES WHERE STATUS_PROCESS = 0 AND PROFILE_ID = ".$prof_id." ORDER BY PERIODE DESC";
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
}	
