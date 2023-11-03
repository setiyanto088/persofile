<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->db3 = $this->load->database('db_survey', TRUE);
		
	}
	
	
			public function get_merk(){
		
		// $sql 	= "
			// SELECT A.*,B.DESCRIPTION AS MERK_TYPE FROM (

// SELECT * FROM `TREE_PROFILING_RES`
		// WHERE `FIELD` LIKE '%merk%'
		// AND `FIELD` <> `VALUE`
		// ORDER BY ID,`FIELD`,`VALUE`,LABEL,SEQUENCE
		
		// ) AS A JOIN `MERK_NAME` B
		// ON A.FIELD = B.FIELD 
		// ";		
		
		$sql 	= "
						 SELECT A.*,B.DESCRIPTION AS MERK_TYPE,B.SURVEY FROM (

SELECT * FROM `MERK_NAME_CLN`
ORDER BY `DESCRIPTION`,`FIELD`,LABEL

		) AS A JOIN `MERK_NAME` B
		ON A.`DESCRIPTION` = B.FIELD 
		ORDER BY `DESCRIPTION`,`FIELD`,LABEL
		";

		$query_all 	=  $this->db3->query($sql);

		$result = $query_all->result_array();
		
		$this->db3->close();
		$this->db3->initialize();
		
		return $result;
		
	}		
	
	public function get_merk_v2(){
		
		// $sql 	= "
			// SELECT A.*,B.DESCRIPTION AS MERK_TYPE FROM (

// SELECT * FROM `TREE_PROFILING_RES`
		// WHERE `FIELD` LIKE '%merk%'
		// AND `FIELD` <> `VALUE`
		// ORDER BY ID,`FIELD`,`VALUE`,LABEL,SEQUENCE
		
		// ) AS A JOIN `MERK_NAME` B
		// ON A.FIELD = B.FIELD 
		// ";		
		
		$sql 	= "
						 SELECT A.*,B.DESCRIPTION AS MERK_TYPE,B.SURVEY,B.PRIORITY FROM (

SELECT * FROM `MERK_NAME_CLN`
ORDER BY `DESCRIPTION`,`FIELD`,LABEL

		) AS A JOIN `MERK_NAME_2` B
		ON A.`DESCRIPTION` = B.FIELD 
		ORDER BY B.SURVEY,B.PRIORITY,`DESCRIPTION`,`FIELD`,LABEL
		";

		$query_all 	=  $this->db3->query($sql);

		$result = $query_all->result_array();
		
		$this->db3->close();
		$this->db3->initialize();
		
		return $result;
		
	}	

		public function get_respondent($data){
		
		$sql 	= "
		SELECT *,KOTA_KABUPATEN_DAGRI AS KOTA_X, NAMA AS NAMA_PELANGGAN, NOTEL_INET AS CARDNO, ALAMAT_NOSS AS ALAMAT FROM RESPONDENT_SURVEY_CLEAR A
		JOIN `TOP_20_PROGRAM_SURVEY_CLEAN` B ON A.NOTEL_INET = B.CARDNO
		WHERE NOTEL_INET = '".$data['id']."'
		ORDER BY `RANK` ASC,DURATION DESC
		";
		
		//echo $sql;die;

		$query_all 	=  $this->db->query($sql);

		$result = $query_all->result_array();
		
		$this->db->close();
		$this->db->initialize();
		
		return $result;
		
	}	
	
	public function get_respondet_nd($data){
			
			$sql 	= '
						SELECT c.status_survey, a.*,DATE_FORMAT(time_call,"%d %M %Y") AS dd,DATEDIFF(date_survey, NOW()) sa, `KOTA_KABUPATEN_DAGRI` `KOTA_X`,b.`NO_HP`,`ALAMAT_NOSS` `ALAMAT`,`NAMA` NAMA_PELANGGAN, b.KECAMATAN_DAGRI, b.KELURAHAN_DESA_DAGRI FROM `t_outbond_call` a
						JOIN `RESPONDENT_SURVEY_CLEAR` b ON a.cardno = b.`NOTEL_INET`
						LEFT JOIN `t_kuisioner` c ON a.id_outbound = c.id_outbound
						WHERE id_user = ?
						AND respond = 7
						AND status_survey <> 1
						GROUP BY a.cardno
						ORDER BY time_call DESC
						
			';

			$query_all 	=  $this->db->query($sql,array('user_id' => $data));

			$result = $query_all->result_array();
			
			$this->db->close();
			$this->db->initialize();
			
			return $result;
			
	}
	
	public function get_respondet_ndd($data){
			
			$sql 	= '
						SELECT a.id_outbound,`respond`,`note`,`time_call`,`date_survey`,`day_survey`,`hours_survey`,`seq`,`date_hours_survey`,`p1`,`p2`,`p3`,`p4`,`p5`,
						`p6`,`p7`,`p8`,`p9`,`p10`,`p11`,`p12`,`p13`,`p14`,`p15`,`p16`,`p17`,`p18`,`p19`,`p20`,DATE_FORMAT(time_call,"%d %M %Y") AS dd,DATEDIFF(date_survey, NOW()) sa,
						`KOTA_KABUPATEN_DAGRI` `KOTA_X`,b.`NO_HP`,`ALAMAT_NOSS` `ALAMAT`,`NAMA` NAMA_PELANGGAN, b.KECAMATAN_DAGRI,
						b.KELURAHAN_DESA_DAGRI,
												IF(status_survey = 1,1,0) status,
						IF(status_survey = 1,if(valid=0,"Data Unvalidate",if(valid=1,"Data Valid",IF(valid=2,"Data Tidak Valid",IF(valid=3,"Data Valid Supervisor","Data Unvalidate")))),"") status_survey
						 FROM `t_outbond_call` a
						JOIN `RESPONDENT_SURVEY_CLEAR` b ON a.cardno = b.`NOTEL_INET`
						LEFT JOIN `t_kuisioner` c ON a.id_outbound = c.id_outbound
						left JOIN `t_qc` g ON a.id_outbound = g.id_outbound
						WHERE a.id_user = '.$data.'
						AND respond = 7
							GROUP BY a.cardno
							ORDER BY c.status_survey asc,time_call DESC
						
			';
			
			
			//echo $sql;die;

			$query_all 	=  $this->db3->query($sql);

			$result = $query_all->result_array();
			
			$this->db3->close();
			$this->db3->initialize();
			
			return $result;
			
	}
	
	public function get_history($data){
			
			$sql 	= '
						SELECT c.status_survey, a.id_outbound,`respond`,`note`,`time_call`,`date_survey`,`day_survey`,`hours_survey`,`seq`,`date_hours_survey`,`p1`,`p2`,`p3`,`p4`,`p5`,
						`p6`,`p7`,`p8`,`p9`,`p10`,`p11`,`p12`,`p13`,`p14`,`p15`,`p16`,`p17`,`p18`,`p19`,`p20`,DATE_FORMAT(time_call,"%d %M %Y") AS dd,DATEDIFF(date_survey, NOW()) sa FROM `t_outbond_call` a
						JOIN `RESPONDENT_SURVEY_CLEAR` b ON a.cardno = b.`NOTEL_INET`
						LEFT JOIN `t_kuisioner` c ON a.id_outbound = c.id_outbound
						WHERE id_user = ?
						AND respond = 7
						AND status_survey = 1
						GROUP BY a.cardno
						ORDER BY time_call DESC
						
			';

			$query_all 	=  $this->db3->query($sql,array('user_id' => $data));

			$result = $query_all->result_array();
			
			$this->db3->close();
			$this->db3->initialize();
			
			return $result;
			
		}
		
		public function get_history_done($data){
			
			$sql 	= '
						SELECT c.status_survey, a.*,DATE_FORMAT(time_call,"%d %M %Y") AS dd,DATEDIFF(date_survey, NOW()) sa, `KOTA_KABUPATEN_DAGRI` `KOTA_X`,b.`NO_HP`,`ALAMAT_NOSS` `ALAMAT`,`NAMA` NAMA_PELANGGAN, b.KECAMATAN_DAGRI, b.KELURAHAN_DESA_DAGRI FROM `t_outbond_call` a
						JOIN `RESPONDENT_SURVEY_CLEAR` b ON a.cardno = b.`NOTEL_INET`
						LEFT JOIN `t_kuisioner` c ON a.id_outbound = c.id_outbound
						WHERE id_user = ?
						AND respond = 7
						AND status_survey = 1
						GROUP BY a.cardno
						ORDER BY time_call DESC
						
			';

			$query_all 	=  $this->db->query($sql,array('user_id' => $data));

			$result = $query_all->result_array();
			
			$this->db->close();
			$this->db->initialize();
			
			return $result;
			
		}
		
	public function get_kecamatan($data){
		
		$sql 	= 'SELECT KECAMATAN_DAGRI AS KECAMATAN,KOTA_KABUPATEN_DAGRI  AS KOTA from RESPONDENT_SURVEY_CLEAR A 
		JOIN mapping_kecamatan B on A.KECAMATAN_DAGRI = B.KECAMATAN
		WHERE KOTA_KABUPATEN_DAGRI <> ""
		AND B.ID_USER = '.$data.'
		group by KECAMATAN_DAGRI 
		order by KECAMATAN_DAGRI';

		$query_all 	=  $this->db3->query($sql);

		$result = $query_all->result_array();
		
		$this->db3->close();
		$this->db3->initialize();
		
		return $result;
		
	}	
	
	
	public function check_token($data){
		
		$sql 	= "
		SELECT count(*) cnt FROM u_user 
		WHERE id = '".$data['id']."' and token = '".$data['token']."'
		";
		
		//echo $sql;die;

		$query_all 	=  $this->db3->query($sql);

		$result = $query_all->result_array();
		
		$this->db3->close();
		$this->db3->initialize();
		
		return $result;
		
	}	
	
	public function get_outbound2($data){
		
		$sql 	= "
		SELECT * FROM t_outbond_call 
		WHERE CARDNO = '".$data['id']."'
		";
		
		//echo $sql;die;

		$query_all 	=  $this->db->query($sql);

		$result = $query_all->result_array();
		
		$this->db->close();
		$this->db->initialize();
		
		return $result;
		
	}	

	function login($params){

		//$sql 	= 'CALL login_auth(?)';
		$sql 	= 'SELECT uu.id,uu.sms_status as userid
					FROM u_user uu
					LEFT JOIN u_user_group uug ON uug.id_user = uu.id
					WHERE uug.username = ?
					AND uu.status_akses = 1';
		$query 	= $this->db3->query($sql,
					array(
						$params['username']
					));
		$result = $query->row_array();

		$this->db3->close();
		$this->db3->initialize();

		return $result;
	}		
	
	function get_param_value(){

		//$sql 	= 'CALL login_auth(?)';
		$sql 	= "SELECT param_value FROM t_param WHERE param_name = 'tokenloginID'";
		$query 	= $this->db3->query($sql);
		$result = $query->row_array();

		$this->db3->close();
		$this->db3->initialize();

		return $result;
	}	
	
	function check_hash($params){

		//$sql 	= 'CALL login_auth(?)';
		$sql 	= "SELECT uug.password AS passwords FROM u_user uu
		LEFT JOIN u_user_group uug ON uug.id_user = uu.id WHERE uu.id = '".$params[id]."'";

		$query 	= $this->db3->query($sql);
		$result = $query->row_array();

		$this->db3->close();
		$this->db3->initialize();

		return $result;
	}	
	
	function login_step2($params){

		//$sql 	= 'CALL login_auth(?)';
		$sql 	= "
		SELECT
		uu.id AS user_id, uu.sms_status,
		uu.nama AS nama,
		uu.nokontak AS nokontak,
		IF(uu.image IS NOT NULL,CONCAT('uploads/profile/',uu.image),NULL) AS profile_picture,
		uu.email AS email,
		( SELECT MD5(CONCAT('AgusMerdekoLogin2017_', ?, ? )) ) AS token,
                uug.id_role ,
		ug.group AS name_role,
		uug.username AS username,
		uu.status_akses AS status_akses,
		tp.xs1 AS status_name,
		uug.password AS passwords,
		uu.last_activity AS last_activity,
		uu.last_activity_status AS last_activity_status,
		uu.token AS token_db,
		uu.lokasi AS idlokasi
		FROM u_user uu
		LEFT JOIN u_user_group uug ON uug.id_user = uu.id
		LEFT JOIN u_group ug ON ug.id = uug.id_role
		LEFT JOIN t_param tp ON tp.param_name = 'STATUS' AND tp.param_id = uu.status_akses
		WHERE uug.username = ?
		AND uu.status_akses = 1;
		";
		
		//print_r($params);die;
		$query 	= $this->db3->query($sql,
					array(
						$params['param_value'],
						$params['time'],
						$params['username']
					));
		$result = $query->row_array();
		//print_r($result);die;

		$this->db3->close();
		$this->db3->initialize();

		return $result;
	}	
	
	function login_step3($params){

		//$sql 	= 'CALL login_auth(?)';
		$sql 	= "
		UPDATE 
		t_param
		SET 
			param_value = param_value + 1 
		WHERE 
		param_name = 'tokenloginID' ;
		";
		$query 	= $this->db3->query($sql);
		//$result = $query->row_array();

		$this->db3->close();
		$this->db3->initialize();

		//return $result;
	}

	function login_menu($idrole){

		$sql 	= 'SELECT um.url_mobile AS component, um.label AS title
					FROM u_menu um
					LEFT JOIN u_menu_group umg ON umg.menu_id = um.id
					WHERE umg.group_id = '.$idrole.' AND umg.status = 1';
		$query 	= $this->db->query($sql);
		$result = $query->result_array();

		$this->db->close();
		$this->db->initialize();

		return $result;
	}
	
	function sava_data_raw($data,$dataraw){
		
		$datas = array(
			'ID_SURVEY' => $data['id_survey'],
			'TIME_SURVEY' => $data['time_survey'],
			'TIME_UPLOAD' => $data['time_upload'],
			'ID_USER' => $data['id_user'],
			'DATA' => $dataraw
		);
		
		$this->db3->insert('DATA_SURVEY_RAW',$datas);
		
		$query = $this->db3->query('SELECT LAST_INSERT_ID()');
		$row = $query->row_array();
		$lastid = $row['LAST_INSERT_ID()'];

		$result	= $this->db->affected_rows();

		$this->db3->close();
		$this->db3->initialize();
		
		$sql 	= '
			UPDATE t_kuisioner
						SET 
						status_survey = 1,
						`start_time` = "'.$data['time_survey'].'",
						`end_time` = "'.$data['time_upload'].'"
						WHERE id_outbound = "'.$data['id_survey'].'"
		';
		$query 	= $this->db3->query($sql);
		
		
		return $datas;
		
	}
	
	function edit_user($data){
		
		$sql 	= '
			UPDATE u_user_group
						SET 
						`password` = "'.$data['password_hash'].'"
						WHERE id_user = "'.$data['id'].'"
			';
			
		$query 	= $this->db3->query($sql);
		
		return $query;
		
	}
	
	
}	