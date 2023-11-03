<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function get_channel(){
		

		
		$sql 	= "
						 SELECT CHANNEL AS STANDAR_CHANNEL FROM CHANNEL_EPG_CONFIG
						 WHERE `STATUS` = 1
		";

		$query_all 	=  $this->db->query($sql);

		$result = $query_all->result_array();
		
		$this->db->close();
		$this->db->initialize();
		
		return $result;
		
	}		
	
	
	function insert_new_channel($params){

		$sql 	= "
		INSERT INTO CHANNEL_EPG_CONFIG (CHANNEL,STATUS,NOTE,CHANNEL_ORIGIN) VALUES ('".$params['STANDAR_CHANNEL']."','1','','".$params['CHANNEL']."');
		";
		$query 	= $this->db->query($sql);
		//$result = $query->row_array();

		$this->db->close();
		$this->db->initialize();

		//return $result;
	}
	
	function update_new_channel($params){

		$sql 	= "
		UPDATE CHANNEL_EPG_CONFIG SET CHANNEL = '".$params['STANDAR_CHANNEL_BARU']."' WHERE CHANNEL = '".$params['STANDAR_CHANNEL']."'
		";
		$query 	= $this->db->query($sql);
		//$result = $query->row_array();

		$this->db->close();
		$this->db->initialize();

		//return $result;
	}
	
	function delete_new_channel($params){

		$sql 	= "
		UPDATE CHANNEL_EPG_CONFIG SET STATUS = 0 WHERE CHANNEL = '".$params['STANDAR_CHANNEL']."'
		";
		$query 	= $this->db->query($sql);
		//$result = $query->row_array();

		$this->db->close();
		$this->db->initialize();

		//return $result;
	}
	
	function insert_epg_today($param,$token){

		foreach($param as $params){
			$sql 	= "
			INSERT INTO EPG_UPLOAD_API (CHANNEL,PERIOD,SCHEDULE_NAME,START_TIME,END_TIME,GENRE,TGL_UPLOAD,JAM_UPLOAD,TOKEN,UPLOAD_TIME) VALUES ('".$params['CHANNEL']."','".$params['PERIOD']."','".$params['SCHEDULE_NAME']."','".$params['START_TIME']."','".$params['END_TIME']."','".$params['GENRE']."','".$params['TGL_UPLOAD']."','".$params['JAM_UPLOAD']."','".$token."','".date('Y-m-d H:i:s')."');
			";
			$query 	= $this->db->query($sql);
			$this->db->close();
			$this->db->initialize();
		}
		
			$sql 	= "
			INSERT INTO FILE_UPLOAD_EPG
			SELECT CONCAT(TOKEN,'-',TGL_UPLOAD,'-',JAM_UPLOAD) AS FILENAME,CHANNEL,MIN(START_TIME) AS START_TIME, MAX(END_TIME) AS END_TIME,UPLOAD_TIME,
			TOKEN,0 AS IDS, COUNT(*) CND FROM `EPG_UPLOAD_API`
			WHERE TOKEN = '".$token."'
			GROUP BY TOKEN,CHANNEL
			";
			$query 	= $this->db->query($sql);
			$this->db->close();
			$this->db->initialize();
			
			
			$sql 	= "
			INSERT INTO EPG_RAW1_TEMP
			SELECT CHANNEL,SCHEDULE_NAME,START_TIME,END_TIME,GENRE,'".$token."' AS TOKEN FROM `EPG_UPLOAD_API`
			WHERE TOKEN = '".$token."'
			";
			$query 	= $this->db->query($sql);
			$this->db->close();
			$this->db->initialize();
			
			
			
		//return $result;
	}
	
	public function delete_data_epg($lis,$params){ 

		$sql 	= "
		DELETE FROM EPG_RAW1_TEST 
		WHERE CHANNEL = '".$lis['CHANNEL']."'
		AND START_TIME BETWEEN '".$lis['START_TIME']."' AND '".$lis['END_TIME']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   
	
	public function epg_today_delete_today($param){ 

		$sql 	= "
		DELETE FROM EPG_RAW1_TEST 
		WHERE CHANNEL = '".$param['CHANNEL']."'
		AND PROGRAM = '".$param['SCHEDULE_NAME']."'
		AND START_TIME = '".$param['START_TIME']."' 
		AND END_TIME = '".$param['END_TIME']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   

	public function process_data_epg($lis,$params){ 

		$sql 	= "
		INSERT INTO EPG_RAW1_TEST
		SELECT CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE FROM EPG_RAW1_TEMP_DEV
		WHERE CHANNEL = '".$lis['CHANNEL']."'
		AND START_TIME BETWEEN '".$lis['START_TIME']."' AND '".$lis['END_TIME']."'
		AND TOKEN = '".$params['token']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   	
	
	public function get_epg_file($param){
		
		$query = " SELECT * FROM FILE_UPLOAD_EPG_DEV WHERE ID_USER = '0' AND TOKEN = '".$param['token']."' ";
		//echo $query;die;
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_channel_today($param){

		$sql 	= " SELECT
		A.CHANNEL AS CHANNEL,PERIODE AS `PERIOD`,PROGRAM AS SCHEDULE_NAME, A.START_TIME, A.END_TIME, A.GENRE,UPLOAD_TIME AS TGL_UPLOAD,JAM_UPLOAD 
		FROM EPG_RAW1_TEST A LEFT JOIN (
			SELECT *,DATE_FORMAT(UPLOAD_DATE,'%Y%m') AS PERIODE,DATE_FORMAT(UPLOAD_DATE,'%Y%m%d') AS UPLOAD_TIME,
			DATE_FORMAT(UPLOAD_DATE,'%H') AS JAM_UPLOAD
			FROM (SELECT *,RANK()  OVER ( PARTITION BY CHANNEL ORDER BY UPLOAD_DATE DESC) AS rnk FROM FILE_UPLOAD_EPG A
			) A WHERE rnk = 1
		) B ON A.CHANNEL = B.CHANNEL
		WHERE A.CHANNEL = '".$param['channel']."'
		AND A.START_TIME BETWEEN '".$param['date']." 00:00:00' AND '".$param['date']." 23:59:59'
		";
		
		//echo $sql ;die;
		$query_all 	=  $this->db->query($sql);

		$result = $query_all->result_array();
		
		$this->db->close();
		$this->db->initialize();
		
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