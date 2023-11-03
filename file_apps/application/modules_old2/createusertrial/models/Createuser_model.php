<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createuser_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function list_user_new($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( a.id LIKE "%'.$params['filter'].'%" OR a.nama LIKE "%'.$params['filter'].'%" OR b.activation_id LIKE "%'.$params['filter'].'%" OR b.status LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
		
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'desc';
        }
		
        

                    
		$sql 	= 'SELECT a.id, a.nama, COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, TIMESTAMPDIFF(DAY, b.paid_date,b.expired_date) AS expiredday, b.reason
					FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id
					WHERE create_by = '.$params['id'].'
                    
                        '.$filter.'
                    ORDER BY '.$params['order_column'].' '.$order_dir.'
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
		
		$total_filtered = $this->db->query('SELECT COUNT(a.id) as total_filtered FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id WHERE b.create_by = '.$params['id'])->row_array();
		$total = $this->db->query('SELECT COUNT(a.id) as total FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id WHERE b.create_by = '.$params['id'])->row_array();
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

	public function listdatausernew($typerole){
        $table = 'M_SINGLE_SOURCE';
		$HEADER = array(array('HEADER' => 'HELIX_COMM'));
		$i = -1;
		$result = array();
			$query1 = 'SELECT DISTINCT HELIX_COMM AS ANAK1 FROM '.$table.'';
			$sql1 = $this->db->query($query1);
			$this->db->close();	   
			$hasil1 = $sql1->result_array();

			$arr_child = array();


			$int = 0;
			foreach ($hasil1 as $v1) {

				if ($v1['ANAK1']!=='') {
					$arr_child[$int] = $v1;
					$kode_helix = substr($v1['ANAK1'], 0, 3);
					$kode_helix_end = $kode_helix + 99;
					$query2 = "SELECT DISTINCT PERSONAS_TRIM AS ANAK2 FROM M_SINGLE_SOURCE WHERE SUBSTRING(HELIX_COMM, 1, 3) BETWEEN ".$kode_helix." AND ".$kode_helix_end." ORDER BY PERSONAS_TRIM ASC";
					$sql2 = $this->db->query($query2);
					$this->db->close();	   
					$hasil2 = $sql2->result_array();
					$arr_child[$int]['ANAK2'] = $hasil2;
					$int++;
				}	
			}				

		$queryh2 = 'SELECT DISTINCT KOTA AS ANAK1 FROM '.$table.' ORDER BY KOTA';
		$sqlh2 = $this->db->query($queryh2);
		$this->db->close();
		$h2 = $sqlh2->result_array();

		$array_profile = array();
		$array_profile['HEADER']['HELIX_COMM'] = $arr_child;
		$array_profile['HEADER']['KOTA'] = $h2;

		array_push($result, $array_profile);
		return $result;

	}


	public function listuser() {
		$query = "SELECT id, username, nama, tmplahir, tgllahir, alamat, email FROM hrd_profile";
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}

	public function detailuser($id) {
		$query = "SELECT a.* , b.`activation_id` 
					FROM hrd_profile a
					LEFT JOIN t_activation b ON a.`id` = b.`user_id`
					WHERE a.id = ".$id;
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
					FROM t_profiling_u
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
	
	function listrole($id){
		
		$query2 = 'SELECT id, id_role role
                    FROM hrd_profile where id='.$id;  			
		$sql2	= $this->db->query($query2);
		
		$this->db->close();	   
		$hasil2 = $sql2->result_array();
						
		return $hasil2;
	}
	
	function listroleall(){
		
		$query2 = 'SELECT id, role
                      FROM pmt_role WHERE xs1 = 45 ORDER BY xn1';  			
		$sql2	= $this->db->query($query2);
		
		$this->db->close();	   
		$hasil2 = $sql2->result_array();
						
		return $hasil2;
	}

	function detailnew($id){
		
		$query2 = 'SELECT id, role
                    FROM pmt_role 
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
		$table = 'SS_CLASS_U';
        $query2 = 'SELECT distinct(VALUE_NAME) as name FROM '.$table.' WHERE VALUE_NAME like "%'.$id.'%"';  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();

				
		return $hasil2;
	}
	
	function searchopval($id){
		
		$query2 = 'SELECT * FROM t_source_fav_u where id_single_source = "'.$id.'"';  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();

				
		return $hasil2;
	}
	
	function ceksearchfav($data){
		
		$query2 = 'SELECT count(id) as hasil FROM t_source_fav_u where id_single_source = "'.$data['name'].'" and id_user = '.$data['user_id'].' ';  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();

				
		return $hasil2;
	}
	
	function searchfav($data){
		
        $query2 = 'SELECT id, id_user,id_single_source,`status` FROM t_source_fav_u WHERE id_user = '.$data['user_id'];  			
        $sql2	= $this->db->query($query2);
        $this->db->close();	   
        $hasil2 = $sql2->result_array();


        return $hasil2;	    

	}
	
	
	public function list_user($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( id LIKE "%'.$params['filter'].'%" OR `name` LIKE "%'.$params['filter'].'%" OR people LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'asc';
        }
        
		$sql 	= 'SELECT id, username, nama, tmplahir, tgllahir, alamat, email
                    FROM hrd_profile 
                    
						WHERE status_user = 1
                        '.$filter.'
                    ORDER BY ? '.$order_dir.'
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                $params['order_column'],
				$params['limit'],
				$params['offset']
				
			));
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		
		$total_filtered = $this->db->query('SELECT COUNT(id) as total_filtered FROM hrd_profile WHERE status_user = 1')->row_array();
		$total = $this->db->query('SELECT COUNT(id) as total FROM hrd_profile WHERE status_user = 1')->row_array();
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
	
public function create($data) {
		
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
                    if ($newdata[1]=='KOTA') {
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
			$queryid = "SELECT GROUP_CONCAT(DISTINCT CONCAT('".$a."', NO, '".$a."')) AS USER_ID, COUNT(DISTINCT NO) as people FROM M_SINGLE_SOURCE ".$text;
			
			 
			$sqlid	= $this->db->query($queryid);
			$this->db->close();	   
			$hasilid = $sqlid->row();
			$hasilid->USER_ID = "'".$hasilid->USER_ID."'";
			$sql 	= "INSERT INTO t_profiling_u(`name`,grouping,`status`, people, user_id) VALUES('".$data['name']."','".$datain."','1',".$hasilid->people.", ".$hasilid->USER_ID.")";
			
			
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

public function create2($data) {	
	$categorynew = array();
	$category = array("Tag"=>array(), "Data"=>array(), "Operation"=>array());	
	$valuesbaru = array();
	$values = array();
	$datain =  '';
    $user_profile = '';
    $user_jumlah = 0;
	if(!$data['list']){
		$datain =  '';
	}
	else{	
			foreach($data['list'] as $new){	
				$newdata = explode("=",$new);
				  if(!in_array($newdata[1], $category, true)){
                        $category['Tag'] = $newdata[1];
                        array_push($categorynew, $category);
                    }
                   	$ss = array();
					$valuesbaru = array();
					$datamasuk = array();
					$sementara = array();
			 		

				$newdata[1]=='KOTA' ? $where = 'WHERE KOTA="'.$newdata[0].'" ' : 'WHERE PERSONAS_TRIM="'.$newdata[0].'"';
				$a = "'";
				$queryid = 'SELECT GROUP_CONCAT(DISTINCT CONCAT("'.$a.'", NO, "'.$a.'")) AS USER_ID, COUNT(DISTINCT NO) as people FROM M_SINGLE_SOURCE '.$where;
			    $sqlid	= $this->db->query($queryid);
			    $this->db->close();	   
			    $hasilid = $sqlid->row();
			    $user_profile .= $hasilid->USER_ID;
			    $user_jumlah += $hasilid->JUMLAH_USER;								
			}
		$user_profile = substr($user_profile, 0, -1);	
	    
		$sql 	= "INSERT INTO t_profiling_u(`name`,grouping,`status`, people, user_id) VALUES('".$data['name']."','','1',".$user_jumlah.", '".$user_profile."')";
		if ($sql) {
				return $this->db->query($sql);
			} 
			else {
				return false;
			}
	}
		
	}
	public function create_pav($data){
        if($data['status'] == 1){
                $sql 	= "INSERT INTO t_source_fav_u(id_user,id_single_source,`status`, child) VALUES(?,?,?,?)";
                
        }else{
                $sql 	= "DELETE FROM t_source_fav_u
                            WHERE id_user = ? and id_single_source = ?";
              
        } 
             if ($sql) {
                 
                 if($data['status'] == 1){
                    $this->db->query($sql, array(
                                            $data['user_id'],
                                            $data['name'],
                                            $data['status'],
                                            $data['child'],

                    ));  
                }else{
                     $this->db->query($sql, array(
                                            $data['user_id'],
                                            $data['name'],

                     ));  
                } 
                 
                     
                    
                $query2 = 'SELECT id, id_user,id_single_source,`status` FROM t_source_fav_u WHERE id_user = '.$data['user_id'];  			
                $sql2	= $this->db->query($query2);
                $this->db->close();	   
                $hasil2 = $sql2->result_array();


                return $hasil2;	    


            } 
            else {
                return false;
            }	
	}
public function get_userid3($data) {
		$a = '"';
		$query = "SELECT GROUP_CONCAT(DISTINCT CONCAT('".$a."', NO, '".$a."')) AS USER_ID, COUNT(DISTINCT NO) as people FROM M_SINGLE_SOURCE ".$data;
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}	

public function content_grouping($profile) {
		$query = 'Select grouping
                    from t_profiling_u
                    where id = ?
                    and status = 1;';  			
		$sql	= $this->db->query($query,array($profile));
		$this->db->close();
		$this->db->initialize(); 
		return $sql->row_array();	   
	}
public function create_statistic($namaprofile,$data, $people, $user_id) {
			$user_id = "'".$user_id."'";
			$sql 	= "INSERT INTO t_profiling_u(`name`,grouping,`status`, people, user_id) VALUES('".$namaprofile."','".$data."','3','".$people."', ".$user_id.",'0','0' )";
			if ($sql) {
					return $this->db->query($sql);
				} 
				else {
					return false;
				}
	}			
	
	public function edit_user($params = array()) {
				
				if($params['role'] == 1){
					$aktivasi = "INTERVAL ".$params['months']." MONTH)";
				}else{
					$aktivasi = "INTERVAL 14 DAY)";
				}
				
				
				
				
				
						 
							$sql 	= "UPDATE t_activation SET
											activation_id = ".$params['role'].",
											expired_date = DATE_ADD(NOW(), ".$aktivasi." ,
											`status` = 2,
											doc = '".$params['images']."'
										WHERE user_id = ".$params['id'];
										
							if ($sql) {
								$sca = $this->db->query($sql);
								
								if($sca){
									$sql2 	= "INSERT INTO t_activation_log
										( user_id, date_log, `status`)
										VALUES
										(".$params['id'].", NOW(), 'PAID CONFIRMATION')";
									return $this->db->query($sql2);
									
								}else {
									return false;
								}
								
								
							} 
							else {
								return false;
							}
				
	}	
	
	
	public function edit_userself($params = array()) {
				
				if($params['role'] == 1){
					$aktivasi = 12;
				}else{
					$aktivasi = 1;
				}
				if(!$params['pwd']){
						$sql 	= "UPDATE hrd_profile SET
							username = '".$params['username']."',
							nama = '".$params['nama']."',
							tmplahir = '".$params['tmplahir']."',
							tgllahir = '".$params['tmplahir']."',
							alamat = '".$params['tmplahir']."',
							nokontak1 = '".$params['nokontak1']."',
							email = '".$params['email']."'
							WHERE id = ".$params['iduser'];
				}else{
						$sql 	= "UPDATE hrd_profile SET
							username = '".$params['username']."',
							pwd = '".password_hash($params['pwd'], PASSWORD_BCRYPT)."',
							nama = '".$params['nama']."',
							tmplahir = '".$params['tmplahir']."',
							tgllahir = '".$params['tmplahir']."',
							alamat = '".$params['tmplahir']."',
							nokontak1 = '".$params['nokontak1']."',
							email = '".$params['email']."'
							WHERE id = ".$params['iduser'];
				}
				if ($sql) {
					return $this->db->query($sql); 
				} 
				else {
					return false;
				}
				
	}	
	
	public function edit_pass($params = array()) {
			 	
				$sql 	= "UPDATE hrd_profile SET pwd = '".password_hash($params['pwd'], PASSWORD_BCRYPT)."' WHERE id = ".$params['iduser'];
				
				if ($sql) {
					return $this->db->query($sql); 
				} 
				else {
					return false;
				}
				
	}	
	
	public function save_user($params = array()) {
				$sqlmax 	= "select max(user_id) maxid from  t_activation";
				$sql2=$this->db->query($sqlmax);
				$hasil2 = $sql2->result_array();
				$id=$hasil2[0]['maxid']+1;
				$iduser = $this->session->userdata('user_id');
				if($params['role'] == 1){
					$aktivasi = 12;
				}else{
					$aktivasi = 1;
				}
				
				$sql 	= "INSERT INTO hrd_profile(id, username, pwd, nama, status_akses, alamat, email, nokontak1, id_role, status_user ) VALUES(".$id.",'".$params['username']."','".password_hash($params['password'], PASSWORD_BCRYPT)."','".$params['username']."','1','aa','aa', 0 , ".$params['role'].", ".$params['statuss'].")";
				if ($sql) {
						$sc = $this->db->query($sql);
						 $this->db->close();	    
						 
						if($sc){
					
							$sql 	= "INSERT INTO t_activation
										(activation_id, user_id, paid_date, doc, create_date, create_by, expired_date, status)
										VALUES
										(2, ".$id.", NOW(), '', NOW(), ".$iduser.",  DATE_ADD(NOW(), INTERVAL ".$params['duration']." DAY),1 )";
							if ($sql) {
								
								$sca = $this->db->query($sql);
								$this->db->close();	
								if($sca){
									$sql2 	= "INSERT INTO t_activation_log
										( user_id, date_log, `status`)
										VALUES
										(".$id.", NOW(), 'TRIAL CONFIRMATION')";
									return $this->db->query($sql2);
									
								}else {
									return false;
								}
								
								
								
								 
							} 
							else {
								return false;
							}
						}else {
							return false;
						}
					} 
					else {
						return false;
					}
				
	}	

	public function update_role($params = array()) {
				
				$sql 	= "UPDATE hrd_profile SET id_role= ".$params['role']." WHERE id=".$params['idUser'];

				if ($sql) {
						return $this->db->query($sql);
					} 
					else {
						return false;
					}
				
	}	
	
	
	
	
	public function list_user_admin($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( id LIKE "%'.$params['filter'].'%" OR nama LIKE "%'.$params['filter'].'%" )';
        }else{
            $filter = '';
        }
		
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'desc';
        }
		
        

                    
		$sql 	= 'SELECT id, nama, IF(status_user = 2, "Sales", "Tech") AS status_user
					FROM hrd_profile
					WHERE status_user NOT IN (0,1,4)
                        '.$filter.'
                    ORDER BY '.$params['order_column'].' '.$order_dir.'
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
		
		$total_filtered = $this->db->query('SELECT COUNT(id) as total_filtered FROM hrd_profile WHERE status_user NOT IN (0,1,4)')->row_array();
		$total = $this->db->query('SELECT COUNT(id) as total FROM hrd_profile WHERE status_user NOT IN (0,1,4)')->row_array();
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

	
	public function save_user_admin($params = array()) {
				$sqlmax 	= "select max(id) maxid from  hrd_profile";
				$sql2=$this->db->query($sqlmax);
				$hasil2 = $sql2->result_array();
				$id=$hasil2[0]['maxid']+1;
				$sc = '';
				if($params['role'] == 2){
					$sc = 3;
				}elseif($params['role'] == 3){
					$sc = 6;
				}
				$sql 	= "INSERT INTO hrd_profile(id, username, pwd, nama, id_role, status_user, nokontak1, email, status_akses) VALUES(".$id.",'".$params['username']."','".password_hash($params['password'], PASSWORD_BCRYPT)."','".$params['nama']."','".$sc."','".$params['role']."','0', '".$params['email']."', 1)";
				if ($sql) {
						return $this->db->query($sql);
						 
				} 
				else {
					return false;
				}
				
	}	
}