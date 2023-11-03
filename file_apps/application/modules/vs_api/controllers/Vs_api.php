<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Vs_api extends REST_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');		
		$this->db3 = $this->load->database('db_survey', TRUE);
		//$this->load->model('Login_model');
	
	}

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
	// takes two dates formatted as YYYY-MM-DD and creates an
	// inclusive array of the dates between the from and to dates.

	// could test validity of dates here but I'm already doing
	// that in the main script

	$aryRange = [];

	$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
	$iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

	if ($iDateTo >= $iDateFrom) {
		array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
		while ($iDateFrom<$iDateTo) {
		$iDateFrom += 86400; // add 24 hours
		array_push($aryRange, date('Y-m-d', $iDateFrom));
		}
	}

	return $aryRange;

		}
	
	
	function update_profile_post() {
		
        $data = json_decode(file_get_contents("php://input"));
		
		
		

        $dataArray = array(
            'id' => $this->Anti_sql_injection($data->id) == '' ? null : $this->Anti_sql_injection($data->id),
            'token' => $this->Anti_sql_injection($data->token) == '' ? null : $this->Anti_sql_injection($data->token),
            'username' => $this->Anti_sql_injection($data->username) == '' ? null : $this->Anti_sql_injection($data->username),
            'password_old' => $this->Anti_sql_injection($data->password_old) == '' ? null : $this->Anti_sql_injection($data->password_old),
            'password' => $this->Anti_sql_injection($data->password) == '' ? null : $this->Anti_sql_injection($data->password),
            'password_confirm' => $this->Anti_sql_injection($data->password_confirm) == '' ? null : $this->Anti_sql_injection($data->password_confirm),
			'password_hash' => password_hash($this->Anti_sql_injection($data->password), PASSWORD_BCRYPT)
        );
		
		$check = $this->home_model->check_token($dataArray); 
		
		if($check[0]['cnt'] == 1 ){
		
		
			if(strlen($dataArray['password']) < 6 ){
				
				$header = 'HTTP/1.1 400 Bad Request';
				$status = 'Error';
				$msg = 'Password Tidak Boleh Kurang dari 6 Karakter';
				
			}else{
				if($dataArray['password'] == $dataArray['password_confirm'] ){
					
					$check_hash = $this->home_model->check_hash($dataArray); 
					
					if (password_verify($dataArray['password_old'], $check_hash['passwords'])) {
					
						$result = $this->home_model->edit_user($dataArray);
						
						$header = 'HTTP/1.1 200 OK';
						$status = 'Success';
						$msg = 'Update Berhasil';
					}else{
						$header = 'HTTP/1.1 400 Bad Request';
						$status = 'Error';
						$msg = 'Konfirmasi Password Lama Tidak Sama';
					}
					
				}else{
					
					$header = 'HTTP/1.1 400 Bad Request';
					$status = 'Error';
					$msg = 'Konfirmasi Password Tidak Sama';

				}
			}
		
		}else{
			
			$header = 'HTTP/1.1 400 Bad Request';
			$status = 'Error';
			$msg = 'Validasi Token Gagal';
			
		}
		
		$res = array(
				'status' => $status,
				'message' => $msg,
				'data' => []// 'menu'      => $datamenu
			);
		
		
		
								
       
	
		
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);


		}
	
	function login2_post() {
		
		// echo 'aaaa';die;
		
        $data = json_decode(file_get_contents("php://input"));
		
		
		// print_r($data);die;

				 // $res = array(
                    // 'status' => 'error',
                    // 'message' => print_r($data)
                // );
				
				 // header($header);
		// header('Cache-Control: no-cache, must-revalidate');
		// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		// header('Content-type: application/json');
		// 
		// echo json_encode($res);
		// //print_r($data);
// die;

        //$appkey = $this->Anti_sql_injection($data->appkey) == '' ? null : $this->Anti_sql_injection($data->appkey);
        $dataArray = array(
            'username' => $this->Anti_sql_injection($data->username) == '' ? null : $this->Anti_sql_injection($data->username)
        );
		
		
		
        // if ($appkey !== $this->config->item('app_key')) {

            // $res = array('status' => 'error', 'message' => 'Wrong API key');
        // } else {

            $password = $this->Anti_sql_injection($data->password) == '' ? null : $this->Anti_sql_injection($data->password);
			
			//echo "aaaaa";die;
            $data2 = $this->home_model->login($dataArray);
			
			//if($data2['userid'] == 1 || $data2['userid'] == 2){
				
					$param_value = $this->home_model->get_param_value();
					
					
					$dataArray['param_value'] = $param_value['param_value'];
					$dataArray['time'] = date('Y-m-d H:i:s');
					//print_r($param_value);die;
				
				 $data = $this->home_model->login_step2($dataArray);
				 $this->home_model->login_step3($dataArray);
				 
				 
			//}
			
		//print_r($data);die;

			$header = 'HTTP/1.1 400 Bad Request';

            if ($data) {
                $hash = $data['passwords'];
				//print_r($password);
				//echo "<br/>";
				//print_r($hash);die;
               // if (password_verify($password, $hash)) {
					// die;
               // if ($password == '123456' || $password == 'telkom' ) {
					//echo "aaaa";die;
					
                    //jika password cocok cek status
                   // if ($data['status_akses'] == 1) {
                        //$set_token = $this->db->query('select set_token(?, ?, ?) as is_token', array($data['user_id'], $data['token'], $data['id_role']));
                        $set_token2 = $this->db->query('UPDATE u_user SET token = ? WHERE id = ? ', array($data['token'], $data['user_id']));
                        $set_token = $this->db->query('INSERT INTO  t_token (id_user,token,id_role,TIMESTAMP,STATUS) VALUES (?,?,?,NOW(),1) ', array($data['user_id'], $data['token'], $data['id_role']));
                        //$row = $set_token->row_array();
						$row	= $this->db->affected_rows();
						
						//echo $row;die;
						
                        $picture = $data['profile_picture'];
                        if (!$picture) {
                            $picture = 'https://inrate.id/survey/uploads/profile/user.png';
                        }
                        if ($row == 1) {
                            $datauser = array(
                                'user_id' => $data['user_id'],
                                'nama' => $data['nama'],
                                'profile_picture' => $picture,
                                'email' => $data['email'],
                                'nokontak' => $data['nokontak'],
                                'token' => $data['token'],
                                'id_role' => $data['id_role'],
                                'name_role' => $data['name_role'],
                                'username' => $data['username'],
                                'idlokasi' => $data['idlokasi']
                            );

                            // $datamenu = $this->login_model->login_menu($data['id_role']);
                            // $this->session->sess_expiration = '604800';// expires in 7 days
                            //set user session
                            $this->session->set_userdata('logged_in', $datauser);
                            
                            $nama = $this->session->userdata['logged_in']['nama'];
                            
//                            print_r($nama);die;
                            log_activity('Login','Nama user '.$nama.'.');
							
							$header = 'HTTP/1.1 200 OK';
								
                            $res = array(
                                'status' => 'success',
                                'message' => 'Success Login',
                                'data' => $datauser
                                    // 'menu'      => $datamenu
                            );
                        } else {
                            //jika user masih aktif login
                            $res = array(
                                'status' => 'error',
                                'message' => 'Tidak bisa menggenerate token.'
                            );
                        }
                 /*   } else {
                        //jika status tidak aktif tampilkan error
                        $res = array(
                            'status' => 'error',
                            'message' => $data['status_name']
                        );
                    } */
                // } else {
                    // $res = array(
                        // 'status' => 'error',
                        // 'message' => 'Password atau Username Salah'
                    // );
                // }
            } else {
                $res = array(
                    'status' => 'error',
                    'message' => 'System Error'
                );
            }
       // }
		

		
		//die;
		
		//$header = 'HTTP/1.1 200 OK';
		
		//$list = $this->item_model->get_selling($data);  
		// $res = array(
                // 'status' => 'Success',
                // 'message' => 'Success Request',
                // 'data' => ''
		// );
		
		 header($header); 
		//header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);

        // header('Cache-Control: no-cache, must-revalidate');
        // header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        // header('Content-type: application/json');
        // 
        // echo json_encode($res);
    }
	
    function login_post() {
		
		
        $data = json_decode(file_get_contents("php://input"));


        //$appkey = $this->Anti_sql_injection($data->appkey) == '' ? null : $this->Anti_sql_injection($data->appkey);
        $dataArray = array(
            'username' => $this->Anti_sql_injection($data->username) == '' ? null : $this->Anti_sql_injection($data->username)
        );
		


            $password = $this->Anti_sql_injection($data->password) == '' ? null : $this->Anti_sql_injection($data->password);
			
            $data2 = $this->home_model->login($dataArray);
			
				
					$param_value = $this->home_model->get_param_value();
					
					
					$dataArray['param_value'] = $param_value['param_value'];
					$dataArray['time'] = date('Y-m-d H:i:s');
				
				 $data = $this->home_model->login_step2($dataArray);
				 $this->home_model->login_step3($dataArray);
				 
				 //print_r($data);die;


			$header = 'HTTP/1.1 400 Bad Request';

			
            if ($data) {
				if($data['sms_status'] > 5){
				  
				  $res = array(
							'status' => 'error',
							'message' => 'User diblokir '
						);
				  
				}else{
					$hash = $data['passwords'];
					//print_r($password);
					//echo "<br/>";
					//print_r($hash);die;
					if (password_verify($password, $hash)) {
						// die;
				   // if ($password == '123456' || $password == 'telkom' ) {
						//echo "aaaa";die;
						
						//jika password cocok cek status
					   // if ($data['status_akses'] == 1) {
							//$set_token = $this->db->query('select set_token(?, ?, ?) as is_token', array($data['user_id'], $data['token'], $data['id_role']));
							$set_token2 = $this->db3->query('UPDATE u_user SET token = ? WHERE id = ? ', array($data['token'], $data['user_id']));
							$set_token = $this->db3->query('INSERT INTO  t_token (id_user,token,id_role,TIMESTAMP,STATUS) VALUES (?,?,?,NOW(),1) ', array($data['user_id'], $data['token'], $data['id_role']));
							//$row = $set_token->row_array();
							$row	= $this->db3->affected_rows();
							
							//echo $row;die;
							
							$picture = $data['profile_picture'];
							if (!$picture) {
								$picture = 'https://inrate.id/survey/uploads/profile/user.png';
							}
							if ($row == 1) {
								$datauser = array(
									'user_id' => $data['user_id'],
									'nama' => $data['nama'],
									'profile_picture' => $picture,
									'email' => $data['email'],
									'token' => $data['token'],
									'id_role' => $data['id_role'],
									'name_role' => $data['name_role'],
									'username' => $data['username'],
									'idlokasi' => $data['idlokasi']
								);

								// $datamenu = $this->login_model->login_menu($data['id_role']);
								// $this->session->sess_expiration = '604800';// expires in 7 days
								//set user session
								$this->session->set_userdata('logged_in', $datauser);
								
								$nama = $this->session->userdata['logged_in']['nama'];
								
	//                            print_r($nama);die;
								//log_activity('Login','Nama user '.$nama.'.');
								$this->db3->query('UPDATE u_user SET sms_status = 0 WHERE id = ? ', array($data['user_id']));
								
								$header = 'HTTP/1.1 200 OK';
									
								$res = array(
									'status' => 'success',
									'message' => 'Success Login',
									'data' => $datauser
										// 'menu'      => $datamenu
								);
							} else {
								//jika user masih aktif login
								$res = array(
									'status' => 'error',
									'message' => 'Tidak bisa menggenerate token.'
								);
							}
					 /*   } else {
							//jika status tidak aktif tampilkan error
							$res = array(
								'status' => 'error',
								'message' => $data['status_name']
							);
						} */
					} else {
						
						$this->db3->query('UPDATE u_user SET sms_status = sms_status+1 WHERE id = ? ', array($data['user_id']));
						
						$res = array(
							'status' => 'error',
							'message' => 'Password atau Username Salah'
						);
					}
				}
            } else {
                $res = array(
                    'status' => 'error',
                    'message' => 'System Error'
                );
            }
       // }
		

		
		//die;
		
		//$header = 'HTTP/1.1 200 OK';
		
		//$list = $this->item_model->get_selling($data);  
		// $res = array(
                // 'status' => 'Success',
                // 'message' => 'Success Request',
                // 'data' => ''
		// );
		
		 header($header); 
		//header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);

        // header('Cache-Control: no-cache, must-revalidate');
        // header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        // header('Content-type: application/json');
        // 
        // echo json_encode($res);
    }
	
	
	function save_data_dev_post(){
		
		$data = json_decode(file_get_contents("php://input"),true);
		$error_int = 0;
		$error_str = '';
		
		$error_msg = '';
		
		// Header Data
		
		if($data['id_survey'] == NULL) {
			$error_msg .= "Main. id_survey | ";
			$error_int++;
		}
		
		if($data['time_upload'] == NULL) {
			$error_msg .= "Main. time_upload | ";
			$error_int++;
		}
		
		// if($data['time_survey'] == NULL) {
			// $error_msg .= "Main. time_survey | ";
			// $error_int++;
		// }
		
		// if($data['id_user']== NULL) {
			// $error_msg .= "Main. id_user | ";
			// $error_int++;
		// }
		
		// Demografi
		
		if($data['data_demografi']['jenis_kelamin'] == NULL) {
			$error_msg .= "Demografi. jenis_kelamin | ";
			$error_int++;
		}
		
		if($data['data_demografi']['usia'] == NULL) {
			$error_msg .= "Demografi. usia | ";
			$error_int++;
		}
		
		if($data['data_demografi']['pendidikan'] == NULL) {
			$error_msg .= "Demografi. pendidikan | ";
			$error_int++;
		}
		
		if($data['data_demografi']['pekerjaan'] == NULL) {
			$error_msg .= "Demografi. pekerjaan | ";
			$error_int++;
		}
		
		// Data A
		
		if($data['data_a']['status_pernikahan'] == NULL) {
			$error_msg .= "A. status_pernikahan | ";
			$error_int++;
		}
		
		if($data['data_a']['posisi_keluarga'] == NULL) {
			$error_msg .= "A. posisi_keluarga | ";
			$error_int++;
		}
		
		if($data['data_a']['jml_anggota_keluarga'] == NULL) {
			$error_msg .= "A. jml_anggota_keluarga | ";
			$error_int++;
		}
		
		if($data['data_a']['jml_anggota_keluarga_berpenghasilan'] == NULL) {
			$error_msg .= "A. jml_anggota_keluarga_berpenghasilan | ";
			$error_int++;
		}
		
		if($data['data_a']['pengeluaran_keluarga'] == NULL) {
			$error_msg .= "A. pengeluaran_keluarga | ";
			$error_int++;
		}
		
		if($data['data_a']['status_rumah'] == NULL) {
			$error_msg .= "A. status_rumah | ";
			$error_int++;
		}
		
		//print_r($data['data_a']['keluarga']);die;
		
		$int_fam = 0;
		foreach($data['data_a']['keluarga'] as $family){
			
			if($family['is_anggota_keluarga'] == true ){
				//echo "aaaa";die;
				
				if($family['usia'] == NULL ){
					$error_msg .= "A. usia ".$family['anggota_keluarga']." | ";
					$error_int++;
					$int_fam++;
				}
				
				if($family['jenis_kelamin'] == NULL ){
					$error_msg .= "A. jenis_kelamin ".$family['anggota_keluarga']." | ";
					$error_int++;
					$int_fam++;
				}
				
				
				
			}

		}
		
		if($int_fam > 0){
			$error_msg .= "A. keluarga | ";
			$error_int++;
		}
		
		// Data B
		
		if(count($data['data_b']['paket_data']) == 0) {
			$error_msg .= "B. paket_data | ";
			$error_int++;
		}
		
		if($data['data_b']['pengeluaran_paket_data'] == NULL) {
			$error_msg .= "B. pengeluaran_paket_data | ";
			$error_int++;
		}
		
		if($data['data_b']['frekuensi_paket_data'] == NULL) {
			$error_msg .= "B. frekuensi_paket_data | ";
			$error_int++;
		}
		
		if($data['data_b']['terakhir_pakai'] == NULL) {
			$error_msg .= "B. terakhir_pakai | ";
			$error_int++;
		}
		
		// Data C
		
		if($data['data_c']['status_pernikahan'] == NULL) {
			$error_msg .= "C. status_pernikahan | ";
			$error_int++;
		}
		
		if($data['data_c']['durasi_jam_nonton'] == NULL) {
			$error_msg .= "C. durasi_jam_nonton | ";
			$error_int++;
		}
		
		if(count($data['data_c']['nonton_weekday']) == 0) {
			$error_msg .= "C. nonton_weekday | ";
			$error_int++;
		}
		
		if(count($data['data_c']['nonton_weekend']) == 0) {
			$error_msg .= "C. nonton_weekend | ";
			$error_int++;
		}
		
		$int_waktu_nonton = 0;
		foreach($data['data_c']['waktu_nonton'] as $waktu_nonton){
			
			if(count($waktu_nonton['keluarga']) > 0){
				$int_waktu_nonton++;
			}
			
		}
		
		if($int_waktu_nonton == 0){
			$error_msg .= "C. waktu_nonton | ";
			$error_int++;
		}
		
		$int_kategori_nonton = 0;
		foreach($data['data_c']['kategori_nonton'] as $kategori_nonton){
			
			if(count($kategori_nonton['keluarga']) > 0){
				$int_kategori_nonton++;
			}
			
		}
		
		if($int_kategori_nonton == 0){
			$error_msg .= "C. kategori_nonton | ";
			$error_int++;
		}
		
		if($data['data_c']['nonton_terakhir_kali'] == NULL) {
			$error_msg .= "C. nonton_terakhir_kali | ";
			$error_int++;
		}
		
		if($data['data_c']['nonton_terakhir_kali'] == 'Ya' ) {
			
			if($data['data_c']['jenis_siaran'] == NULL) {
				$error_msg .= "C. jenis_siaran | ";
				$error_int++;
			}
			
		}
		
		if($data['data_c']['jenis_siaran'] == 'TV Digital' ) {
			
			if($data['data_c']['durasi_digital'] == NULL) {
				$error_msg .= "C. durasi_digital | ";
				$error_int++;
			}
			
			if($data['data_c']['digital_tv_nasional'] == NULL) {
				$error_msg .= "C. digital_tv_nasional | ";
				$error_int++;
			}
			
			if($data['data_c']['alasan_nonton_tv_nasional'] == NULL) {
				$error_msg .= "C. alasan_nonton_tv_nasional | ";
				$error_int++;
			}
			
		}
		
		if($data['data_c']['jenis_siaran'] == 'TV Analog' ) {
			
			if($data['data_c']['durasi_analog'] == NULL) {
				$error_msg .= "C. durasi_analog | ";
				$error_int++;
			}
			
		}
		
		$int_program_tv = 0;
		foreach($data['data_c']['program_tv'] as $program_tv){

			$data_program = explode("|",$program_tv['nama_program']);
			if($data_program[0] == 'Ya'){
				if(count($program_tv['keluarga']) == 0){
					$error_msg .= "C. nama_program ".$data_program[1]." | ";
					$error_int++;
				}
			}
			
		}
		
		
		// Data D
		
		if($data['data_d']['perhatian_utama'] == null ) {
			
			$error_msg .= "D. perhatian_utama | ";
			$error_int++;
			
		}
		
		if($data['data_d']['program_acara'] == null ) {
			
			$error_msg .= "D. program_acara | ";
			$error_int++;
			
		}
		
		// Data E
		
		if(count($data['data_e']['sering_nonton']) == 0){
			$error_msg .= "E. sering_nonton | ";
			$error_int++;
		}
		
		$int_channel_tv_e = 0;
		foreach($data['data_e']['channel_tv'] as $channel_tv){
			
			if(count($channel_tv['kategory_film']) > 0){
				$int_channel_tv_e++;
			}
			
		}
		
		if($int_channel_tv_e == 0 ){
			$error_msg .= "E. channel_tv_genre | ";
			$error_int++;
		}
		
		// Data F
		
		
		if($data['data_f']['f1'] == null ) {
			
			$error_msg .= "f1 | ";
			$error_int++;
			
		}else{
			
			if($data['data_f']['f2'] == null ) {
				$error_msg .= "f2 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f3']['value']) == 0 ) {
				$error_msg .= "f3 | ";
				$error_int++;
			}
			
			if($data['data_f']['f4'] == null ) {
				$error_msg .= "f4 | ";
				$error_int++;
			}
			
		}
		
		if(count($data['data_f']['f5']['value']) == 0 ) {
			$error_msg .= "f5 | ";
			$error_int++;
		}
		
		if($data['data_f']['f6'] == null ) {
			$error_msg .= "f6 | ";
			$error_int++;
		}
		
		if($data['data_f']['f7']['value'] == null ) {
			$error_msg .= "f7 | ";
			$error_int++;
		}else{
			if($data['data_f']['f7']['value'] == "Ya" ) {
				if($data['data_f']['f7']['valueLainnya'] == null ) {
					$error_msg .= "f7 | ";
				}
			}
		}
		
		if($data['data_f']['f8']['value'] == null ) {
			$error_msg .= "f8 | ";
			$error_int++;
		}else{
			if($data['data_f']['f8']['value'] == "Ya" ) {
				if($data['data_f']['f8']['valueLainnya'] == null ) {
					$error_msg .= "f8 | ";
				}
			}
		}
		
		if($data['data_f']['f9']['value'] == null ) {
			$error_msg .= "f9 | ";
			$error_int++;
		}
		
		
		$int_mediaKonvensional = 0;
		$int_mediaDigital = 0;
		$int_mediaKonvensional2 = 0;
		if(count($data['data_f']['f10']['value']) > 0 ) {
			
			foreach($data['data_f']['f10']['mediaKonvensional'] as $mediaKonvensional){
				
				if($mediaKonvensional['waktu'] <> null){
					$int_mediaKonvensional++;
				}
				
				// if($mediaKonvensional['selected'] == true){
					// if($mediaKonvensional['waktu'] == null){
						// $int_mediaKonvensional2++;
					// }
				// }
				
			}
			
			foreach($data['data_f']['f10']['mediaDigital'] as $mediaDigital){
				
				if($mediaDigital['waktu'] <> null){
					$int_mediaDigital++;
				}

			}

		}else{
			$error_msg .= "f10 | ";
			$error_int++;
		}
		
		if($int_mediaKonvensional + $int_mediaDigital == 0){
			$error_msg .= "f10 | ";
			$error_int++;
		}
		
		if($data['data_f']['f10']['mediaKonvensional'][4]['waktu'] <> null){
			if(count($data['data_f']['f11']) == 0 ) {
				$error_msg .= "f11 | ";
				$error_int++;
			}
			
			if(in_array("Berlangganan", $data['data_f']['f11'])) {
				if($data['data_f']['f12'] == NULL ) {
					$error_msg .= "f12 | ";
					$error_int++;
				}
			}
			
			if($data['data_f']['f13'] == NULL ) {
				$error_msg .= "f13 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f14']['value']) == 0 ) {
				$error_msg .= "f14 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f15']) == 0 ) {
				$error_msg .= "f15 | ";
				$error_int++;
			}
		}
	
		if($data['data_f']['f10']['mediaKonvensional'][1]['waktu'] <> null
		|| $data['data_f']['f10']['mediaKonvensional'][6]['waktu'] <> null ){
			
			if(count($data['data_f']['f16']) == 0 ) {
				$error_msg .= "f16 | ";
				$error_int++;
			}
			
			if(in_array("Berlangganan", $data['data_f']['f16'])) {
				if($data['data_f']['f17'] == NULL ) {
					$error_msg .= "f17 | ";
					$error_int++;
				}
			}
			
			if(count($data['data_f']['f18']['value']) == 0 ) {
				$error_msg .= "f18 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f19']['value']) == 0 ) {
				$error_msg .= "f19 | ";
				$error_int++;
			}
			
		}
		
		if($data['data_f']['f10']['mediaKonvensional'][0]['waktu'] <> null){
			
			if(count($data['data_f']['f20']['value']) == 0 ) {
				$error_msg .= "f20 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f21']['value']) == 0 ) {
				$error_msg .= "f21 | ";
				$error_int++;
			}
			
			if($data['data_f']['f22'] == NULL ) {
				$error_msg .= "f22 | ";
				$error_int++;
			}
			
		}
		
		if($data['data_f']['f10']['mediaDigital'][0]['waktu'] <> null
		|| $data['data_f']['f10']['mediaDigital'][1]['waktu'] <> null
		|| $data['data_f']['f10']['mediaDigital'][3]['waktu'] <> null		
		|| $data['data_f']['f10']['mediaDigital'][6]['waktu'] <> null){
			
			if($data['data_f']['f23'] == NULL ) {
				$error_msg .= "f23 | ";
				$error_int++;
			}
			
			if($data['data_f']['f24'] == NULL ) {
				$error_msg .= "f24 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f25']) == 0 ) {
				$error_msg .= "f25 | ";
				$error_int++;
			}
			
			
		}
		
		if($data['data_f']['f10']['mediaDigital'][5]['waktu'] <> null){
			if(count($data['data_f']['f26']['value']) == 0 ) {
				$error_msg .= "f26 | ";
				$error_int++;
			}
			
		}
		
		$error_msg27 = " f27 ";
		$int_errorf10 = 0;
		if(count($data['data_f']['f27']['value']) == 0 ) {
				$error_msg27 .= "|";
				$error_int++;
				$int_errorf10++;
		}else{
			
			if(in_array("Facebook", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanFacebook'] == NULL ) {
					$error_msg27 .= " Facebook,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Twitter", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanTwitter'] == NULL ) {
					$error_msg27 .= " Twitter,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Youtube", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanYoutube'] == NULL ) {
					$error_msg27 .= " Youtube,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Tiktok", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanTiktok'] == NULL ) {
					$error_msg27 .= " Tiktok,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Instagram", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanInstagram'] == NULL ) {
					$error_msg27 .= " Instagram,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Pinterest", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanPinterest'] == NULL ) {
					$error_msg27 .= " Pinterest,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Linkedln", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanLinkedln'] == NULL ) {
					$error_msg27 .= " Linkedln,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Snapchat", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanSnapchat'] == NULL ) {
					$error_msg27 .= " Snapchat,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Lainnya", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueAkunLainnya'] <> NULL ) {
					if($data['data_f']['f27']['valueUrutanLainnya'] == NULL ) {
						$error_msg27 .= " Lainnya,";
						$error_int++;
						$int_errorf10++;
					}
				}else{
					$error_msg27 .= " Lainnya,";
					$error_int++;
					$int_errorf10++;
				}
				
			}
			
		}
		
		if($int_errorf10 > 0){
			$error_msg .= substr($error_msg27,0,-1)." | ";
		}
		
		if(in_array("Youtube", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanYoutube'] <> NULL ) {
			if($data['data_f']['f28'] == NULL ) {
				$error_msg .= "f28 | ";
				$error_int++;
			}
			
			if($data['data_f']['f29'] == NULL ) {
				$error_msg .= "f29 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f30']) == 0 ) {
				$error_msg .= "f30 | ";
				$error_int++;
			}
		}
		
		if(in_array("Facebook", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanFacebook'] <> NULL ) {
			
			if(count($data['data_f']['f31']['value']) == 0 ) {
				$error_msg .= "f31 | ";
				$error_int++;
			}
			
			if($data['data_f']['f32'] == NULL ) {
				$error_msg .= "f32 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Instagram", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanInstagram'] <> NULL ) {
			
			if(count($data['data_f']['f33']['value']) == 0 ) {
				$error_msg .= "f33 | ";
				$error_int++;
			}
			
			if($data['data_f']['f34'] == NULL ) {
				$error_msg .= "f34 | ";
				$error_int++;
			}
			
		}

		if(in_array("Tiktok", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanTiktok'] <> NULL ) {
			
			if(count($data['data_f']['f35']['value']) == 0 ) {
				$error_msg .= "f35 | ";
				$error_int++;
			}
			
			if($data['data_f']['f36'] == NULL ) {
				$error_msg .= "f36 | ";
				$error_int++;
			}
			
		}		
		
		$error_msg37 = " f37 ";
		$int_err_msg = 0;
		if(count($data['data_f']['f37']['value']) == 0 ) {
				$error_msg37 .= "|";
				$error_int++;
				$int_err_msg++;
		}else{
			
			if(in_array("Line", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanLine'] == NULL ) {
					$error_msg37 .= " Line,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("IMO", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanImo'] == NULL ) {
					$error_msg37 .= " IMO,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("WeChat", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanWeChat'] == NULL ) {
					$error_msg37 .= " WeChat,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Skype", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanSkype'] == NULL ) {
					$error_msg37 .= " Skype,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Whatsapp", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanWhatsapp'] == NULL ) {
					$error_msg37 .= " Whatsapp,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Telegram", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanTelegram'] == NULL ) {
					$error_msg37 .= " Telegram,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("FB Messenger", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanFbMessenger'] == NULL ) {
					$error_msg37 .= " FB Messenger,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Yahoo Messenger", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanYM'] == NULL ) {
					$error_msg37 .= " Yahoo Messenger,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Lainnya", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueAkunLainnya'] <> NULL ) {
					if($data['data_f']['f37']['valueUrutanLainnya'] == NULL ) {
						$error_msg37 .= " Lainnya,";
						$error_int++;
						$int_err_msg++;
					}
				}else{
					$error_msg37 .= " Lainnya,";
					$error_int++;
					$int_err_msg++;
				}
				
			}
			
		}
		
		if($int_err_msg > 0){
			$error_msg .= substr($error_msg37,0,-1)." | ";
		}
		
		if(count($data['data_f']['f38']['value']) == 0 ) {
			$error_msg .= "f38 | ";
			$error_int++;
		}

		if(in_array("Akses situs berita dan informasi", $data['data_f']['f38']['value'])) {
			if(count($data['data_f']['f39']['value']) == 0 ) {
				$error_msg .= "f39 | ";
				$error_int++;
			}
		}
		
		if(in_array("Akses situs musik/ audio streaming (mis: JOOX, Spotify)", $data['data_f']['f38']['value'])) {
			if(count($data['data_f']['f40']['value']) == 0 ) {
				$error_msg .= "f40 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f41']['value']) == 0 ) {
				$error_msg .= "f41 | ";
				$error_int++;
			}
			
			if($data['data_f']['f42']['value'] == NULL ) {
				$error_msg .= "f42 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f43']['value']) == 0 ) {
				$error_msg .= "f43 | ";
				$error_int++;
			}
			
			if($data['data_f']['f44'] == NULL ) {
				$error_msg .= "f44 | ";
				$error_int++;
			}
		}
		
		if(in_array("Akses situs video streaming", $data['data_f']['f38']['value'])) {
			
			if(count($data['data_f']['f45']['value']) == 0 ) {
				$error_msg .= "f45 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f46']['value']) == 0 ) {
				$error_msg .= "f46 | ";
				$error_int++;
			}
			
			if($data['data_f']['f47']['value'] == NULL ) {
				$error_msg .= "f47 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f48']['value']) == 0 ) {
				$error_msg .= "f48 | ";
				$error_int++;
			}

			if($data['data_f']['f49'] == NULL ) {
				$error_msg .= "f49 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Akses situs video streaming", $data['data_f']['f38']['value'])) {
			
			if(count($data['data_f']['f50']['value']) == 0 ) {
				$error_msg .= "f50 | ";
				$error_int++;
			}
			
			if($data['data_f']['f51']['value'] == NULL ) {
				$error_msg .= "f51 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f52']['value']) == 0 ) {
				$error_msg .= "f52 | ";
				$error_int++;
			}
			
			if($data['data_f']['f53'] == NULL ) {
				$error_msg .= "f53 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f54']['value']) == 0 ) {
				$error_msg .= "f54 | ";
				$error_int++;
			}
	
		}
		
		
		//f55
		
		if(in_array("Minimarket", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f56']['value']) == 0 ) {
				$error_msg .= "f56 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Supermarket", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f57']['value']) == 0 ) {
				$error_msg .= "f57 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Hipermarket", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f58']['value']) == 0 ) {
				$error_msg .= "f58 | ";
				$error_int++;
			}
			
		}	
		
		if(in_array("Online Shop", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f59']['value']) == 0 ) {
				$error_msg .= "f59 | ";
				$error_int++;
			}
			
		}
		
		if($data['data_f']['f60'] == NULL ) {
			$error_msg .= "f60 | ";
			$error_int++;
		}
		
		$in_f61 = 0;
		$error_msg61 = ' f61 : ';
		$int_error_msg61 = 0;
		foreach($data['data_f']['f61'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msg61++;
				}
			} 
			
		}
		
		if($int_error_msg61 > 0){
			$error_msg .= substr($error_msg61,0,-2)." | ";
		}
		
		if($data['data_f']['f62'] == NULL ) {
			$error_msg .= "f62 | ";
			$error_int++;
		}
		
		if($data['data_f']['f62'] == "Tidak pernah sama sekali belanja online" ) {
			if(count($data['data_f']['f63']['value']) == 0 ) {
				$error_msg .= "f63 | ";
				$error_int++;
			}
		}
		
		if($data['data_f']['f62'] == "Ya" ) {
			if(count($data['data_f']['f64']['value']) == 0 ) {
				$error_msg .= "f64 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f65']['value']) == 0 ) {
				$error_msg .= "f65 | ";
				$error_int++;
			}
			
			if($data['data_f']['f66'] == NULL ) {
				$error_msg .= "f66 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f67']['value']) == 0 ) {
				$error_msg .= "f67 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f68']['value']) == 0 ) {
				$error_msg .= "f68 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f69']['value']) == 0 ) {
				$error_msg .= "f69 | ";
				$error_int++;
			}else{
				if(in_array("E-Wallet", $data['data_f']['f69']['value'])) {
					
					if(count($data['data_f']['f70']['value']) == 0 ) {
						$error_msg .= "f70 | ";
						$error_int++;
					}
					
				}
			}
		}
		
		if($data['data_f']['f71'] == NULL ) {
			$error_msg .= "f71 | ";
			$error_int++;
		}
		
		if($data['data_f']['f71'] == "Ya" ) {
			if($data['data_f']['f72'] == NULL ) {
				$error_msg .= "f72 | ";
				$error_int++;
			}
			
			if($data['data_f']['f73'] == NULL ) {
				$error_msg .= "f73 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f74']['value']) == 0 ) {
				$error_msg .= "f74 | ";
				$error_int++;
			}
			
			if($data['data_f']['f75a'] == "" && $data['data_f']['f75b'] == "" ) {
				$error_msg .= "f75 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f76']['value']) == 0 ) {
				$error_msg .= "f76 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f77']['value']) == 0 ) {
				$error_msg .= "f77 | ";
				$error_int++;
			}else{
				
				if(in_array("Melalui online / Aplikasi", $data['data_f']['f77']['value'])) {
					
					if(count($data['data_f']['f78']['value']) == 0 ) {
						$error_msg .= "f78 | ";
						$error_int++;
					}
					
				}
				
			}
		}
		
		if(count($data['data_f']['f79']) == 0 ) {
			$error_msg .= "f79 | ";
			$error_int++;
		}
		
		if($data['data_f']['f80']['value'] == NULL ) {
			$error_msg .= "f80 | ";
			$error_int++;
		}else{
			if($data['data_f']['f80']['value'] == "Ya" ) {
				if($data['data_f']['f80']['valueLainnya'] == NULL){
					$error_msg .= "f80 | ";
					$error_int++;
				}
			}
		}
		
		if($data['data_f']['f81']['value'] == NULL ) {
			$error_msg .= "f81 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f82']['value']) == 0 ) {
			$error_msg .= "f82 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f83']['value']) == 0 ) {
			$error_msg .= "f83 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f84']['value']) == 0 ) {
			$error_msg .= "f84 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f85']['value']) == 0 ) {
			$error_msg .= "f85 | ";
			$error_int++;
		}
		
		if($data['data_f']['f86'] == NULL ) {
			$error_msg .= "f86 | ";
			$error_int++;
		}else{
			if($data['data_f']['f86'] == "Ya" ) {
				if($data['data_f']['f87'] == NULL ) {
					$error_msg .= "f87 | ";
					$error_int++;
				}
			}
		}
		
		if($data['data_f']['f88'] == NULL ) {
			$error_msg .= "f88 | ";
			$error_int++;
		}else{
			if($data['data_f']['f88'] == "Ya" ) {
				if(count($data['data_f']['f89']) == 0 ) {
					$error_msg .= "f89 | ";
					$error_int++;
				}else{
					if(in_array("Les Bimbingan Belajar", $data['data_f']['f89'])) {
						if(count($data['data_f']['f90']['value']) == 0 ) {
							$error_msg .= "f90 | ";
							$error_int++;
						}
						
						if($data['data_f']['f91'] == NULL ) {
							$error_msg .= "f91 | ";
							$error_int++;
						}else{
							if($data['data_f']['f91'] == "Ya" ) {
								if(count($data['data_f']['f92']['value']) == 0 ) {
									$error_msg .= "f92 | ";
									$error_int++;
								}
							}
						}
					}
				}
			}
		}
		
		$in_f93 = 0;
		$error_msgf93 = ' f93 : ';
		$int_error_msgf93 = 0;
		foreach($data['data_f']['f93a'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		
		foreach($data['data_f']['f93b'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		
		foreach($data['data_f']['f93c'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		
		foreach($data['data_f']['f93d'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		if($int_error_msgf93 > 0){
			$error_msg .= substr($error_msgf93,0,-2)." | ";
		}
		
		$in_f94 = 0;
		$error_msgf94 = ' f94 : ';
		$int_error_msgf94 = 0;
		foreach($data['data_f']['f94'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf94++;
					
				}
			} 
			
		}
		if($int_error_msgf94 > 0){
		$error_msg .= substr($error_msgf94,0,-2)." | ";
		}
		
		if($data['data_f']['f95']["value"] == NULL ) {
			$error_msg .= "f95 | ";
			$error_int++;
		}
		
		if($data['data_f']['f96']["value"] == NULL ) {
			$error_msg .= "f96 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f97']['value']) == 0 ) {
			$error_msg .= "f97 | ";
			$error_int++;
		}
						
		if(count($data['data_f']['f98']['value']) == 0 ) {
			$error_msg .= "f98 | ";
			$error_int++;
		}		

		if($data['data_f']['f99'] == NULL ) {
			$error_msg .= "f99 | ";
			$error_int++;
		}else{
			if($data['data_f']['f99'] == "Ya" || $data['data_f']['f99'] == "Kadang-kadang"){
				if(count($data['data_f']['f100']['value']) == 0 ) {
					$error_msg .= "f100 | ";
					$error_int++;
				}

				if(count($data['data_f']['f101']['value']) == 0 ) {
					$error_msg .= "f101 | ";
					$error_int++;
				}				
			}
		}	
		
		// Data G
		
			$in_g1a = 0;
			$error_msgg1a = ' g1 : ';
			$mobil = $data['data_g']['dataG1A'][0];
			$int_error_msgg1a = 0;
			if(count($mobil['merek']) > 0){
				foreach($mobil['kendaraan'] as $kendaraan){
					if(count($kendaraan['anggota_keluarga']) == 0 || $kendaraan['tahun'] == NULL ){
						$error_msgg1a .= $mobil['jenis'].", ";
						$error_int++;
						$int_error_msgg1a++;
					}
				}
				
			} 
			
		//}
		
		$motor = $data['data_g']['dataG1A'][1];

			if(count($motor['merek']) > 0){
				foreach($motor['kendaraan'] as $kendaraan){
					if(count($kendaraan['anggota_keluarga']) == 0 || $kendaraan['tahun'] == NULL ){
						$error_msgg1a .= $motor['jenis'].", ";
						$error_int++;
						$int_error_msgg1a++;
					}
				}
				
			} 

		//$error_msg .= substr($error_msgg1a,0,-2)." | ";
		
		foreach($data['data_g']['dataG1'] as $g1){
			
			if(count($g1['merek']) > 0){
				if(count($g1['anggota_keluarga']) == 0){
					$error_msgg1a .= $g1['jenis'].", ";
					$error_int++;
					$int_error_msgg1a++;
				}
			} 
			
		}
		if($int_error_msgg1a > 0){
			$error_msg .= substr($error_msgg1a,0,-2)." | ";
		}
		
		if(count($data['data_g']['dataG3']) == 0 ) {
			$error_msg .= "g3 | ";
			$error_int++;
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG3'])) {
				if($data['data_g']['dataG3_lainnya'] == NULL ) {
					$error_msg .= "g3 | ";
					$error_int++;
				}
			}
		}
		
		if(count($data['data_g']['dataG4']) == 0 ) {
			$error_msg .= "g4 | ";
			$error_int++;
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG4'])) {
				if($data['data_g']['dataG4_lainnya'] == NULL ) {
					$error_msg .= "g4 | ";
					$error_int++;
				}
			}
		}
		
		if(count($data['data_g']['dataG5']) == 0 ) {
			$error_msg .= "g5 | ";
			$error_int++;
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG5'])) {
				if($data['data_g']['dataG5_lainnya'] == NULL ) {
					$error_msg .= "g5 | ";
					$error_int++;
				}
			}
		}
		
		if(in_array("Asuransi", $data['data_g']['dataG3'])) {
			if(count($data['data_g']['dataG6']) == 0 ) {
				$error_msg .= "g6 | ";
				$error_int++;
			}else{
				if(in_array("Lainnya", $data['data_g']['dataG6'])) {
					if($data['data_g']['dataG6_lainnya'] == NULL ) {
						$error_msg .= "g6 | ";
						$error_int++;
					}
				}
			}
			
			if(count($data['data_g']['dataG7']) == 0 ) {
				$error_msg .= "g7 | ";
				$error_int++;
			}else{
				if(in_array("Lainnya", $data['data_g']['dataG7'])) {
					if($data['data_g']['dataG7_lainnya'] == NULL ) {
						$error_msg .= "g7 | ";
						$error_int++;
					}
				}
			}
		}
		
		if(count($data['data_g']['dataG8']) == 0 ) {
			$error_msg .= "g8 | ";
			$error_int++;
		}else{
				if(in_array("Lainnya", $data['data_g']['dataG8'])) {
					if($data['data_g']['dataG8_lainnya'] == NULL ) {
						$error_msg .= "g8 | ";
						$error_int++;
					}
				}
			}
		
		if(in_array("e-Wallet (dompet virtual – berbasis aplikasi)", $data['data_g']['dataG8'])) {
			if(count($data['data_g']['dataG9']) == 0 ) {
				$error_msg .= "g9 | ";
				$error_int++;
			}
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG9'])) {
				if($data['data_g']['dataG9_lainnya'] == NULL ) {
					$error_msg .= "g9 | ";
					$error_int++;
				}
			}
		}
		
		if($data['data_g']['dataG10'] == NULL ) {
			$error_msg .= "g10 | ";
			$error_int++;
		}
		
						
		
		if($error_int > 0){
			$error_msg = 'Data Berikut Tidak Boleh Kosong : '.$error_msg;
			$header = 'HTTP/1.1 400 Bad Request';
			$status = 'Error';
		}else{
			
			$this->home_model->sava_data_raw($data,file_get_contents("php://input"));
			$header = 'HTTP/1.1 200 OK';
			$status = 'Success';

		}

		
		$res = array(
                'status' => $status,
                'message' => $error_msg,
                'error_count' => $error_int,
                'data' =>[]
		);
		
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);
		
	}
	
	
	function save_data_post(){
		
		$data = json_decode(file_get_contents("php://input"),true);
		$error_int = 0;
		$error_str = '';
		
		$error_msg = '';
		
		$array_prm['id'] = $data['id_user'];
		$array_prm['token'] = $data['token'];
		
		$check = $this->home_model->check_token($array_prm); 
		
		if($check[0]['cnt'] == 1 ){
		 
		// Header Data
		
		if($data['id_survey'] == NULL) {
			$error_msg .= "Main. id_survey | ";
			$error_int++;
		}
		
		if($data['token'] == NULL) {
			$error_msg .= "Main. token | ";
			$error_int++;
		}
		
		if($data['time_upload'] == NULL) {
			$error_msg .= "Main. time_upload | ";
			$error_int++;
		}
		
		if($data['time_survey'] == NULL) {
			$error_msg .= "Main. time_survey | ";
			$error_int++;
		}
		
		if($data['id_user']== NULL) {
			$error_msg .= "Main. id_user | ";
			$error_int++;
		}
		
		//Demografi
		
		if($data['data_demografi']['jenis_kelamin'] == NULL) {
			$error_msg .= "Demografi. jenis_kelamin | ";
			$error_int++;
		}
		
		if($data['data_demografi']['usia'] == NULL) {
			$error_msg .= "Demografi. usia | ";
			$error_int++;
		}
		
		if($data['data_demografi']['pendidikan'] == NULL) {
			$error_msg .= "Demografi. pendidikan | ";
			$error_int++;
		}
		
		if($data['data_demografi']['pekerjaan'] == NULL) {
			$error_msg .= "Demografi. pekerjaan | ";
			$error_int++;
		}
		
		// Data A
		
		if($data['data_a']['status_pernikahan'] == NULL) {
			$error_msg .= "A. status_pernikahan | ";
			$error_int++;
		}
		
		if($data['data_a']['posisi_keluarga'] == NULL) {
			$error_msg .= "A. posisi_keluarga | ";
			$error_int++;
		}
		
		if($data['data_a']['jml_anggota_keluarga'] == NULL) {
			$error_msg .= "A. jml_anggota_keluarga | ";
			$error_int++;
		}
		
		if($data['data_a']['jml_anggota_keluarga_berpenghasilan'] == NULL) {
			$error_msg .= "A. jml_anggota_keluarga_berpenghasilan | ";
			$error_int++;
		}
		
		if($data['data_a']['pengeluaran_keluarga'] == NULL) {
			$error_msg .= "A. pengeluaran_keluarga | ";
			$error_int++;
		}
		
		if($data['data_a']['status_rumah'] == NULL) {
			$error_msg .= "A. status_rumah | ";
			$error_int++;
		}
		
		//print_r($data['data_a']['keluarga']);die;
		
		$int_fam = 0;
		foreach($data['data_a']['keluarga'] as $family){
			
			if($family['is_anggota_keluarga'] == true ){
				//echo "aaaa";die;
				
				if($family['usia'] == NULL ){
					$error_msg .= "A. usia ".$family['anggota_keluarga']." | ";
					$error_int++;
					$int_fam++;
				}
				
				if($family['jenis_kelamin'] == NULL ){
					$error_msg .= "A. jenis_kelamin ".$family['anggota_keluarga']." | ";
					$error_int++;
					$int_fam++;
				}
				
				
				
			}

		}
		
		if($int_fam > 0){
			$error_msg .= "A. keluarga | ";
			$error_int++;
		}
		
		// Data B
		
		if(count($data['data_b']['paket_data']) == 0) {
			$error_msg .= "B. paket_data | ";
			$error_int++;
		}
		
		if($data['data_b']['pengeluaran_paket_data'] == NULL) {
			$error_msg .= "B. pengeluaran_paket_data | ";
			$error_int++;
		}
		
		if($data['data_b']['frekuensi_paket_data'] == NULL) {
			$error_msg .= "B. frekuensi_paket_data | ";
			$error_int++;
		}
		
		if($data['data_b']['terakhir_pakai'] == NULL) {
			$error_msg .= "B. terakhir_pakai | ";
			$error_int++;
		}
		
		//Data C
		
		
		if(count($data['data_c']['nonton_weekday']) == 0) {
			$error_msg .= "C. nonton_weekday | ";
			$error_int++;
		}
		
		if(count($data['data_c']['nonton_weekend']) == 0) {
			$error_msg .= "C. nonton_weekend | ";
			$error_int++;
		}
		
		$int_waktu_nonton = 0;
		foreach($data['data_c']['waktu_nonton'] as $waktu_nonton){
			
			if(count($waktu_nonton['keluarga']) > 0){
				$int_waktu_nonton++;
			}
			
		}
		
		if($int_waktu_nonton == 0){
			$error_msg .= "C. waktu_nonton | ";
			$error_int++;
		}
		
		$int_kategori_nonton = 0;
		foreach($data['data_c']['kategori_nonton'] as $kategori_nonton){
			
			if(count($kategori_nonton['keluarga']) > 0){
				$int_kategori_nonton++;
			}
			
		}
		
		if($int_kategori_nonton == 0){
			$error_msg .= "C. kategori_nonton | ";
			$error_int++;
		}
		
		// if($data['data_c']['nonton_terakhir_kali'] == NULL) {
			// $error_msg .= "C. nonton_terakhir_kali | ";
			// $error_int++;
		// }
		
		if($data['data_c']['nonton_terakhir_kali'] == 'Ya' ) {
			
			if($data['data_c']['jenis_siaran'] == NULL) {
				$error_msg .= "C. jenis_siaran | ";
				$error_int++;
			}
			
		}
		
		if($data['data_c']['jenis_siaran'] == 'TV Digital' ) {
			
			if($data['data_c']['durasi_digital'] == NULL) {
				$error_msg .= "C. durasi_digital | ";
				$error_int++;
			}
			
			if($data['data_c']['digital_tv_nasional'] == NULL) {
				$error_msg .= "C. digital_tv_nasional | ";
				$error_int++;
			}
			
			if($data['data_c']['alasan_nonton_tv_nasional'] == NULL) {
				$error_msg .= "C. alasan_nonton_tv_nasional | ";
				$error_int++;
			}
			
		}
		
		if($data['data_c']['jenis_siaran'] == 'TV Analog' ) {
			
			if($data['data_c']['durasi_analog'] == NULL) {
				$error_msg .= "C. durasi_analog | ";
				$error_int++;
			}
			
		}
		
		$int_program_tv = 0;
		foreach($data['data_c']['program_tv'] as $program_tv){

			$data_program = explode("|",$program_tv['nama_program']);
			if($data_program[0] == 'Ya'){
				if(count($program_tv['keluarga']) == 0){
					$error_msg .= "C. nama_program ".$data_program[1]." | ";
					$error_int++;
				}
			}
			
		}
		
		
		//Data D
		
		if($data['data_d']['perhatian_utama'] == null ) {
			
			$error_msg .= "D. perhatian_utama | ";
			$error_int++;
			
		}
		
		if($data['data_d']['program_acara'] == null ) {
			
			$error_msg .= "D. program_acara | ";
			$error_int++;
			
		}
		
		//Data E
		
		if(count($data['data_e']['sering_nonton']) == 0){
			$error_msg .= "E. sering_nonton | ";
			$error_int++;
		}
		
		$int_channel_tv_e = 0;
		foreach($data['data_e']['channel_tv'] as $channel_tv){
			
			if(count($channel_tv['kategory_film']) > 0){
				$int_channel_tv_e++;
			}
			
		}
		
		if($int_channel_tv_e == 0 ){
			$error_msg .= "E. channel_tv_genre | ";
			$error_int++;
		}
		
		//Data F
		
		
		if($data['data_f']['f1'] == null ) {
			
			$error_msg .= "f1 | ";
			$error_int++;
			
		}else{
			
			if($data['data_f']['f2'] == null ) {
				$error_msg .= "f2 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f3']['value']) == 0 ) {
				$error_msg .= "f3 | ";
				$error_int++;
			}
			
			if($data['data_f']['f4'] == null ) {
				$error_msg .= "f4 | ";
				$error_int++;
			}
			
		}
		
		if(count($data['data_f']['f5']['value']) == 0 ) {
			$error_msg .= "f5 | ";
			$error_int++;
		}
		
		if($data['data_f']['f6'] == null ) {
			$error_msg .= "f6 | ";
			$error_int++;
		}
		
		if($data['data_f']['f7']['value'] == null ) {
			$error_msg .= "f7 | ";
			$error_int++;
		}else{
			if($data['data_f']['f7']['value'] == "Ya" ) {
				if($data['data_f']['f7']['valueLainnya'] == null ) {
					$error_msg .= "f7 | ";
				}
			}
		}
		
		if($data['data_f']['f8']['value'] == null ) {
			$error_msg .= "f8 | ";
			$error_int++;
		}else{
			if($data['data_f']['f8']['value'] == "Ya" ) {
				if($data['data_f']['f8']['valueLainnya'] == null ) {
					$error_msg .= "f8 | ";
				}
			}
		}
		
		if($data['data_f']['f9']['value'] == null ) {
			$error_msg .= "f9 | ";
			$error_int++;
		}
		
		
		$int_mediaKonvensional = 0;
		$int_mediaDigital = 0;
		$int_mediaKonvensional2 = 0;
		//if(count($data['data_f']['f10']['value']) > 0 ) {
			
			foreach($data['data_f']['f10']['mediaKonvensional'] as $mediaKonvensional){
				
				if($mediaKonvensional['waktu'] <> null){
					$int_mediaKonvensional++;
				}
				
				// if($mediaKonvensional['selected'] == true){
					// if($mediaKonvensional['waktu'] == null){
						// $int_mediaKonvensional2++;
					// }
				// }
				
			}
			
			foreach($data['data_f']['f10']['mediaDigital'] as $mediaDigital){
				
				if($mediaDigital['waktu'] <> null){
					$int_mediaDigital++;
				}

			}

		//}
		
		if($int_mediaKonvensional + $int_mediaDigital == 0){
			$error_msg .= "f10 | ";
			$error_int++;
		}
		
		if($data['data_f']['f10']['mediaKonvensional'][4]['waktu'] <> null){
			if(count($data['data_f']['f11']) == 0 ) {
				$error_msg .= "f11 | ";
				$error_int++;
			}
			
			if(in_array("Berlangganan", $data['data_f']['f11'])) {
				if($data['data_f']['f12'] == NULL ) {
					$error_msg .= "f12 | ";
					$error_int++;
				}
			}
			
			if($data['data_f']['f13'] == NULL ) {
				$error_msg .= "f13 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f14']['value']) == 0 ) {
				$error_msg .= "f14 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f15']) == 0 ) {
				$error_msg .= "f15 | ";
				$error_int++;
			}
		}
	
		if($data['data_f']['f10']['mediaKonvensional'][1]['waktu'] <> null
		|| $data['data_f']['f10']['mediaKonvensional'][6]['waktu'] <> null ){
			
			if(count($data['data_f']['f16']) == 0 ) {
				$error_msg .= "f16 | ";
				$error_int++;
			}
			
			if(in_array("Berlangganan", $data['data_f']['f16'])) {
				if($data['data_f']['f17'] == NULL ) {
					$error_msg .= "f17 | ";
					$error_int++;
				}
			}
			
			if(count($data['data_f']['f18']['value']) == 0 ) {
				$error_msg .= "f18 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f19']['value']) == 0 ) {
				$error_msg .= "f19 | ";
				$error_int++;
			}
			
		}
		
		if($data['data_f']['f10']['mediaKonvensional'][0]['waktu'] <> null){
			
			if(count($data['data_f']['f20']['value']) == 0 ) {
				$error_msg .= "f20 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f21']['value']) == 0 ) {
				$error_msg .= "f21 | ";
				$error_int++;
			}
			
			if($data['data_f']['f22'] == NULL ) {
				$error_msg .= "f22 | ";
				$error_int++;
			}
			
		}
		
		if($data['data_f']['f10']['mediaDigital'][0]['waktu'] <> null
		|| $data['data_f']['f10']['mediaDigital'][1]['waktu'] <> null
		|| $data['data_f']['f10']['mediaDigital'][3]['waktu'] <> null		
		|| $data['data_f']['f10']['mediaDigital'][6]['waktu'] <> null){
			
			if($data['data_f']['f23'] == NULL ) {
				$error_msg .= "f23 | ";
				$error_int++;
			}
			
			if($data['data_f']['f24'] == NULL ) {
				$error_msg .= "f24 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f25']) == 0 ) {
				$error_msg .= "f25 | ";
				$error_int++;
			}
			
			
		}
		
		if($data['data_f']['f10']['mediaDigital'][5]['waktu'] <> null){
			if(count($data['data_f']['f26']['value']) == 0 ) {
				$error_msg .= "f26 | ";
				$error_int++;
			}
			
		}
		
		$error_msg27 = " f27 ";
		$int_errorf10 = 0;
		if(count($data['data_f']['f27']['value']) == 0 ) {
				$error_msg27 .= "|";
				$error_int++;
				$int_errorf10++;
		}else{
			
			if(in_array("Facebook", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanFacebook'] == NULL ) {
					$error_msg27 .= " Facebook,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Twitter", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanTwitter'] == NULL ) {
					$error_msg27 .= " Twitter,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Youtube", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanYoutube'] == NULL ) {
					$error_msg27 .= " Youtube,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Tiktok", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanTiktok'] == NULL ) {
					$error_msg27 .= " Tiktok,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Instagram", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanInstagram'] == NULL ) {
					$error_msg27 .= " Instagram,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Pinterest", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanPinterest'] == NULL ) {
					$error_msg27 .= " Pinterest,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Linkedln", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanLinkedln'] == NULL ) {
					$error_msg27 .= " Linkedln,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Snapchat", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueUrutanSnapchat'] == NULL ) {
					$error_msg27 .= " Snapchat,";
					$error_int++;
					$int_errorf10++;
				}
			}
			
			if(in_array("Lainnya", $data['data_f']['f27']['value'])) {
				if($data['data_f']['f27']['valueAkunLainnya'] <> NULL ) {
					if($data['data_f']['f27']['valueUrutanLainnya'] == NULL ) {
						$error_msg27 .= " Lainnya,";
						$error_int++;
						$int_errorf10++;
					}
				}else{
					$error_msg27 .= " Lainnya,";
					$error_int++;
					$int_errorf10++;
				}
				
			}
			
		}
		
		if($int_errorf10 > 0){
			$error_msg .= substr($error_msg27,0,-1)." | ";
		}
		
		if(in_array("Youtube", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanYoutube'] <> NULL ) {
			if($data['data_f']['f28'] == NULL ) {
				$error_msg .= "f28 | ";
				$error_int++;
			}
			
			if($data['data_f']['f29'] == NULL ) {
				$error_msg .= "f29 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f30']) == 0 ) {
				$error_msg .= "f30 | ";
				$error_int++;
			}
		}
		
		if(in_array("Facebook", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanFacebook'] <> NULL ) {
			
			if(count($data['data_f']['f31']['value']) == 0 ) {
				$error_msg .= "f31 | ";
				$error_int++;
			}
			
			if($data['data_f']['f32'] == NULL ) {
				$error_msg .= "f32 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Instagram", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanInstagram'] <> NULL ) {
			
			if(count($data['data_f']['f33']['value']) == 0 ) {
				$error_msg .= "f33 | ";
				$error_int++;
			}
			
			if($data['data_f']['f34'] == NULL ) {
				$error_msg .= "f34 | ";
				$error_int++;
			}
			
		}

		if(in_array("Tiktok", $data['data_f']['f27']['value']) ||
		$data['data_f']['f27']['valueUrutanTiktok'] <> NULL ) {
			
			if(count($data['data_f']['f35']['value']) == 0 ) {
				$error_msg .= "f35 | ";
				$error_int++;
			}
			
			if($data['data_f']['f36'] == NULL ) {
				$error_msg .= "f36 | ";
				$error_int++;
			}
			
		}		
		
		$error_msg37 = " f37 ";
		$int_err_msg = 0;
		if(count($data['data_f']['f37']['value']) == 0 ) {
				$error_msg37 .= "|";
				$error_int++;
				$int_err_msg++;
		}else{
			
			if(in_array("Line", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanLine'] == NULL ) {
					$error_msg37 .= " Line,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("IMO", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanImo'] == NULL ) {
					$error_msg37 .= " IMO,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("WeChat", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanWeChat'] == NULL ) {
					$error_msg37 .= " WeChat,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Skype", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanSkype'] == NULL ) {
					$error_msg37 .= " Skype,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Whatsapp", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanWhatsapp'] == NULL ) {
					$error_msg37 .= " Whatsapp,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Telegram", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanTelegram'] == NULL ) {
					$error_msg37 .= " Telegram,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("FB Messenger", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanFbMessenger'] == NULL ) {
					$error_msg37 .= " FB Messenger,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Yahoo Messenger", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueUrutanYM'] == NULL ) {
					$error_msg37 .= " Yahoo Messenger,";
					$error_int++;
					$int_err_msg++;
				}
			}
			
			if(in_array("Lainnya", $data['data_f']['f37']['value'])) {
				if($data['data_f']['f37']['valueAkunLainnya'] <> NULL ) {
					if($data['data_f']['f37']['valueUrutanLainnya'] == NULL ) {
						$error_msg37 .= " Lainnya,";
						$error_int++;
						$int_err_msg++;
					}
				}else{
					$error_msg37 .= " Lainnya,";
					$error_int++;
					$int_err_msg++;
				}
				
			}
			
		}
		
		if($int_err_msg > 0){
			$error_msg .= substr($error_msg37,0,-1)." | ";
		}
		
		if(count($data['data_f']['f38']['value']) == 0 ) {
			$error_msg .= "f38 | ";
			$error_int++;
		}

		if(in_array("Akses situs berita dan informasi", $data['data_f']['f38']['value'])) {
			if(count($data['data_f']['f39']['value']) == 0 ) {
				$error_msg .= "f39 | ";
				$error_int++;
			}
		}
		
		if(in_array("Akses situs musik/ audio streaming (mis: JOOX, Spotify)", $data['data_f']['f38']['value'])) {
			if(count($data['data_f']['f40']['value']) == 0 ) {
				$error_msg .= "f40 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f41']['value']) == 0 ) {
				$error_msg .= "f41 | ";
				$error_int++;
			}
			
			if($data['data_f']['f42']['value'] == NULL ) {
				$error_msg .= "f42 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f43']['value']) == 0 ) {
				$error_msg .= "f43 | ";
				$error_int++;
			}
			
			if($data['data_f']['f44'] == NULL ) {
				$error_msg .= "f44 | ";
				$error_int++;
			}
		}
		
		if(in_array("Akses situs video streaming", $data['data_f']['f38']['value'])) {
			
			if(count($data['data_f']['f45']['value']) == 0 ) {
				$error_msg .= "f45 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f46']['value']) == 0 ) {
				$error_msg .= "f46 | ";
				$error_int++;
			}
			
			if($data['data_f']['f47']['value'] == NULL ) {
				$error_msg .= "f47 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f48']['value']) == 0 ) {
				$error_msg .= "f48 | ";
				$error_int++;
			}

			if($data['data_f']['f49'] == NULL ) {
				$error_msg .= "f49 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Akses situs video streaming", $data['data_f']['f38']['value'])) {
			
			if(count($data['data_f']['f50']['value']) == 0 ) {
				$error_msg .= "f50 | ";
				$error_int++;
			}
			
			if($data['data_f']['f51']['value'] == NULL ) {
				$error_msg .= "f51 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f52']['value']) == 0 ) {
				$error_msg .= "f52 | ";
				$error_int++;
			}
			
			if($data['data_f']['f53'] == NULL ) {
				$error_msg .= "f53 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f54']['value']) == 0 ) {
				$error_msg .= "f54 | ";
				$error_int++;
			}
	
		}
		
		
		//f55
		
		if(in_array("Minimarket", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f56']['value']) == 0 ) {
				$error_msg .= "f56 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Supermarket", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f57']['value']) == 0 ) {
				$error_msg .= "f57 | ";
				$error_int++;
			}
			
		}
		
		if(in_array("Hipermarket", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f58']['value']) == 0 ) {
				$error_msg .= "f58 | ";
				$error_int++;
			}
			
		}	
		
		if(in_array("Online Shop", $data['data_f']['f55'])) {
			
			if(count($data['data_f']['f59']['value']) == 0 ) {
				$error_msg .= "f59 | ";
				$error_int++;
			}
			
		}
		
		if($data['data_f']['f60'] == NULL ) {
			$error_msg .= "f60 | ";
			$error_int++;
		}
		
		$in_f61 = 0;
		$error_msg61 = ' f61 : ';
		$int_error_msg61 = 0;
		foreach($data['data_f']['f61'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msg61++;
				}
			} 
			
		}
		
		if($int_error_msg61 > 0){
			$error_msg .= substr($error_msg61,0,-2)." | ";
		}
		
		if($data['data_f']['f62'] == NULL ) {
			$error_msg .= "f62 | ";
			$error_int++;
		}
		
		if($data['data_f']['f62'] == "Tidak pernah sama sekali belanja online" ) {
			if(count($data['data_f']['f63']['value']) == 0 ) {
				$error_msg .= "f63 | ";
				$error_int++;
			}
		}
		
		if($data['data_f']['f62'] == "Ya" ) {
			if(count($data['data_f']['f64']['value']) == 0 ) {
				$error_msg .= "f64 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f65']['value']) == 0 ) {
				$error_msg .= "f65 | ";
				$error_int++;
			}
			
			if($data['data_f']['f66'] == NULL ) {
				$error_msg .= "f66 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f67']['value']) == 0 ) {
				$error_msg .= "f67 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f68']['value']) == 0 ) {
				$error_msg .= "f68 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f69']['value']) == 0 ) {
				$error_msg .= "f69 | ";
				$error_int++;
			}else{
				if(in_array("E-Wallet", $data['data_f']['f69']['value'])) {
					
					if(count($data['data_f']['f70']['value']) == 0 ) {
						$error_msg .= "f70 | ";
						$error_int++;
					}
					
				}
			}
		}
		
		if($data['data_f']['f71'] == NULL ) {
			$error_msg .= "f71 | ";
			$error_int++;
		}
		
		if($data['data_f']['f71'] == "Ya" ) {
			if($data['data_f']['f72'] == NULL ) {
				$error_msg .= "f72 | ";
				$error_int++;
			}
			
			if($data['data_f']['f73'] == NULL ) {
				$error_msg .= "f73 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f74']['value']) == 0 ) {
				$error_msg .= "f74 | ";
				$error_int++;
			}
			
			if($data['data_f']['f75a'] == "" && $data['data_f']['f75b'] == "" ) {
				$error_msg .= "f75 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f76']['value']) == 0 ) {
				$error_msg .= "f76 | ";
				$error_int++;
			}
			
			if(count($data['data_f']['f77']['value']) == 0 ) {
				$error_msg .= "f77 | ";
				$error_int++;
			}else{
				
				if(in_array("Melalui online / Aplikasi", $data['data_f']['f77']['value'])) {
					
					if(count($data['data_f']['f78']['value']) == 0 ) {
						$error_msg .= "f78 | ";
						$error_int++;
					}
					
				}
				
			}
		}
		
		if(count($data['data_f']['f79']) == 0 ) {
			$error_msg .= "f79 | ";
			$error_int++;
		}
		
		if($data['data_f']['f80']['value'] == NULL ) {
			$error_msg .= "f80 | ";
			$error_int++;
		}else{
			if($data['data_f']['f80']['value'] == "Ya" ) {
				if($data['data_f']['f80']['valueLainnya'] == NULL){
					$error_msg .= "f80 | ";
					$error_int++;
				}
			}
		}
		
		if($data['data_f']['f81']['value'] == NULL ) {
			$error_msg .= "f81 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f82']['value']) == 0 ) {
			$error_msg .= "f82 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f83']['value']) == 0 ) {
			$error_msg .= "f83 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f84']['value']) == 0 ) {
			$error_msg .= "f84 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f85']['value']) == 0 ) {
			$error_msg .= "f85 | ";
			$error_int++;
		}
		
		if($data['data_f']['f86'] == NULL ) {
			$error_msg .= "f86 | ";
			$error_int++;
		}else{
			if($data['data_f']['f86'] == "Ya" ) {
				if($data['data_f']['f87'] == NULL ) {
					$error_msg .= "f87 | ";
					$error_int++;
				}
			}
		}
		
		if($data['data_f']['f88'] == NULL ) {
			$error_msg .= "f88 | ";
			$error_int++;
		}else{
			if($data['data_f']['f88'] == "Ya" ) {
				if(count($data['data_f']['f89']) == 0 ) {
					$error_msg .= "f89 | ";
					$error_int++;
				}else{
					if(in_array("Les Bimbingan Belajar", $data['data_f']['f89'])) {
						if(count($data['data_f']['f90']['value']) == 0 ) {
							$error_msg .= "f90 | ";
							$error_int++;
						}
						
						if($data['data_f']['f91'] == NULL ) {
							$error_msg .= "f91 | ";
							$error_int++;
						}else{
							if($data['data_f']['f91'] == "Ya" ) {
								if(count($data['data_f']['f92']['value']) == 0 ) {
									$error_msg .= "f92 | ";
									$error_int++;
								}
							}
						}
					}
				}
			}
		}
		
		$in_f93 = 0;
		$error_msgf93 = ' f93 : ';
		$int_error_msgf93 = 0;
		foreach($data['data_f']['f93a'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		
		foreach($data['data_f']['f93b'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		
		foreach($data['data_f']['f93c'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		
		foreach($data['data_f']['f93d'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf93++;
				}
			} 
			
		}
		if($int_error_msgf93 > 0){
			$error_msg .= substr($error_msgf93,0,-2)." | ";
		}
		
		$in_f94 = 0;
		$error_msgf94 = ' f94 : ';
		$int_error_msgf94 = 0;
		foreach($data['data_f']['f94'] as $f61){
			
			if(count($f61['merek']) > 0){
				if(count($f61['anggota_keluarga']) == 0){
					$error_msg61 .= $f61['jenis'].", ";
					$error_int++;
					$int_error_msgf94++;
					
				}
			} 
			
		}
		if($int_error_msgf94 > 0){
		$error_msg .= substr($error_msgf94,0,-2)." | ";
		}
		
		if($data['data_f']['f95']["value"] == NULL ) {
			$error_msg .= "f95 | ";
			$error_int++;
		}
		
		if($data['data_f']['f96']["value"] == NULL ) {
			$error_msg .= "f96 | ";
			$error_int++;
		}
		
		if(count($data['data_f']['f97']['value']) == 0 ) {
			$error_msg .= "f97 | ";
			$error_int++;
		}
						
		if(count($data['data_f']['f98']['value']) == 0 ) {
			$error_msg .= "f98 | ";
			$error_int++;
		}		

		if($data['data_f']['f99'] == NULL ) {
			$error_msg .= "f99 | ";
			$error_int++;
		}else{
			if($data['data_f']['f99'] == "Ya" || $data['data_f']['f99'] == "Kadang-kadang"){
				if(count($data['data_f']['f100']['value']) == 0 ) {
					$error_msg .= "f100 | ";
					$error_int++;
				}

				if(count($data['data_f']['f101']['value']) == 0 ) {
					$error_msg .= "f101 | ";
					$error_int++;
				}				
			}
		}	
		
		// Data G
		
			$in_g1a = 0;
			$error_msgg1a = ' g1 : ';
			$mobil = $data['data_g']['dataG1A'][0];
			$int_error_msgg1a = 0;
			if(count($mobil['merek']) > 0){
				foreach($mobil['kendaraan'] as $kendaraan){
					if(count($kendaraan['anggota_keluarga']) == 0 || $kendaraan['tahun'] == NULL ){
						$error_msgg1a .= $mobil['jenis'].", ";
						$error_int++;
						$int_error_msgg1a++;
					}
				}
				
			} 
			
		//}
		
		$motor = $data['data_g']['dataG1A'][1];

			if(count($motor['merek']) > 0){
				foreach($motor['kendaraan'] as $kendaraan){
					if(count($kendaraan['anggota_keluarga']) == 0 || $kendaraan['tahun'] == NULL ){
						$error_msgg1a .= $motor['jenis'].", ";
						$error_int++;
						$int_error_msgg1a++;
					}
				}
				
			} 

		//$error_msg .= substr($error_msgg1a,0,-2)." | ";
		
		foreach($data['data_g']['dataG1'] as $g1){
			
			if(count($g1['merek']) > 0){
				if(count($g1['anggota_keluarga']) == 0){
					$error_msgg1a .= $g1['jenis'].", ";
					$error_int++;
					$int_error_msgg1a++;
				}
			} 
			
		}
		if($int_error_msgg1a > 0){
			$error_msg .= substr($error_msgg1a,0,-2)." | ";
		}
		
		if(count($data['data_g']['dataG3']) == 0 ) {
			$error_msg .= "g3 | ";
			$error_int++;
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG3'])) {
				if($data['data_g']['dataG3_lainnya'] == NULL ) {
					$error_msg .= "g3 | ";
					$error_int++;
				}
			}
		}
		
		if(count($data['data_g']['dataG4']) == 0 ) {
			$error_msg .= "g4 | ";
			$error_int++;
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG4'])) {
				if($data['data_g']['dataG4_lainnya'] == NULL ) {
					$error_msg .= "g4 | ";
					$error_int++;
				}
			}
		}
		
		if(count($data['data_g']['dataG5']) == 0 ) {
			$error_msg .= "g5 | ";
			$error_int++;
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG5'])) {
				if($data['data_g']['dataG5_lainnya'] == NULL ) {
					$error_msg .= "g5 | ";
					$error_int++;
				}
			}
		}
		
		if(in_array("Asuransi", $data['data_g']['dataG3'])) {
			if(count($data['data_g']['dataG6']) == 0 ) {
				$error_msg .= "g6 | ";
				$error_int++;
			}else{
				if(in_array("Lainnya", $data['data_g']['dataG6'])) {
					if($data['data_g']['dataG6_lainnya'] == NULL ) {
						$error_msg .= "g6 | ";
						$error_int++;
					}
				}
			}
			
			if(count($data['data_g']['dataG7']) == 0 ) {
				$error_msg .= "g7 | ";
				$error_int++;
			}else{
				if(in_array("Lainnya", $data['data_g']['dataG7'])) {
					if($data['data_g']['dataG7_lainnya'] == NULL ) {
						$error_msg .= "g7 | ";
						$error_int++;
					}
				}
			}
		}
		
		if(count($data['data_g']['dataG8']) == 0 ) {
			$error_msg .= "g8 | ";
			$error_int++;
		}else{
				if(in_array("Lainnya", $data['data_g']['dataG8'])) {
					if($data['data_g']['dataG8_lainnya'] == NULL ) {
						$error_msg .= "g8 | ";
						$error_int++;
					}
				}
			}
		
		if(in_array("e-Wallet (dompet virtual – berbasis aplikasi)", $data['data_g']['dataG8'])) {
			if(count($data['data_g']['dataG9']) == 0 ) {
				$error_msg .= "g9 | ";
				$error_int++;
			}
		}else{
			if(in_array("Lainnya", $data['data_g']['dataG9'])) {
				if($data['data_g']['dataG9_lainnya'] == NULL ) {
					$error_msg .= "g9 | ";
					$error_int++;
				}
			}
		}
		
		if($data['data_g']['dataG10'] == NULL ) {
			$error_msg .= "g10 | ";
			$error_int++;
		}
		
						
		
		if($error_int > 0){
			$error_msg = 'Data Berikut Tidak Boleh Kosong : '.$error_msg;
			$header = 'HTTP/1.1 400 Bad Request';
			$status = 'Error';
		}else{
			
			$this->home_model->sava_data_raw($data,file_get_contents("php://input"));
			$header = 'HTTP/1.1 200 OK';
			$status = 'Success';

		}


	}else{
		$error_msg = 'Token Validate Error ';
			$header = 'HTTP/1.1 400 Bad Request';
			$status = 'Error';
			$error_int++;
	}
		
		$res = array(
                'status' => $status,
                'message' => $error_msg,
                'error_count' => $error_int,
                'data' => []
		);
		
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		echo json_encode($res);

	}
	
	function list_respondent_dev_post(){
		
		 $data = json_decode(file_get_contents("php://input"));
		 
		 //print_r($data->id);die;
		 
		 $result = $this->home_model->get_respondet_ndd($data->id); 
		 
		 //print_r($result);die;
		 $res = array(
                'status' => 'Success',
                'message' => 'Success Request',
                'data' => $result
		);
		
		$header = 'HTTP/1.1 200 OK';
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);
	}	
	
	function list_respondent_post(){
		
		 $data = json_decode(file_get_contents("php://input"));
		 
		 //print_r($data->id);die;
		  $check = $this->home_model->check_token((array)$data); 
		 
		  if($check[0]['cnt'] == 1 ){
		 //$result = $this->home_model->get_respondet_nd($data->id); 
		 $result = $this->home_model->get_respondet_ndd($data->id); 
		 
		 $res = array(
                'status' => 'Success',
                'message' => 'Success Request',
                'data' => $result
		);
		
		  }else{
			  $res = array(
                'status' => 'Error',
                'message' => 'Token Validate Error',
                'data' => []
			);
		  }
		
		$header = 'HTTP/1.1 200 OK';
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

		echo json_encode($res);
	}	
	
	function list_respondent_done_post(){
		
		 $data = json_decode(file_get_contents("php://input"));
		 
		 $check = $this->home_model->check_token((array)$data); 
		 
		if($check[0]['cnt'] == 1 ){
			  
			$result = $this->home_model->get_history($data->id); 
		 
			$res = array(
                'status' => 'Success',
                'message' => 'Success Request',
                'data' => $result
			);
		
		 }else{
			 $res = array(
                'status' => 'Error',
                'message' => 'Token Validate Error',
                'data' => []
			);
		 }
		
		$header = 'HTTP/1.1 200 OK';
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);
	}
	
	function list_merk_get(){
		
		 $data = json_decode(file_get_contents("php://input"));
		 
		 //print_r($data->id);die;
		 
		 $result_merk = $this->home_model->get_merk(); 
		 
		 $array_merk = [];
		 
			foreach($result_merk as $result_merks){
				
				// $array_merk[$result_merks['FIELD']]['MERK'] = $result_merks['FIELD'];
				// $array_merk[$result_merks['FIELD']]['MERK_TYPE'] = $result_merks['MERK_TYPE'];
				// $array_merk[$result_merks['FIELD']]['VALUE'][] = ARRAY('FIELD' => $result_merks['VALUE'],'LABEL' => $result_merks['LABEL']);

				$array_merk[$result_merks['DESCRIPTION']]['SURVEY'] = $result_merks['SURVEY'];	
				$array_merk[$result_merks['DESCRIPTION']]['MERK'] = $result_merks['DESCRIPTION'];
				$array_merk[$result_merks['DESCRIPTION']]['MERK_TYPE'] = $result_merks['MERK_TYPE'];
				$array_merk[$result_merks['DESCRIPTION']]['VALUE'][] = ARRAY('FIELD' => $result_merks['FIELD'],'LABEL' => $result_merks['LABEL']);
				
				
			}
			
			$array_data = [];
			foreach($array_merk as $array_merk_v2){
				$array_data[] = $array_merk_v2;
			}
			//rint_r($array_data);die;
		
			
		$result = $array_data;
		 
		 $res = array(
                'status' => 'Success',
                'message' => 'Success Request',
                'data' => $result
		);
		
		$header = 'HTTP/1.1 200 OK';
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);
	}
	
	
	function list_merk_v2_get(){
		
		 $data = json_decode(file_get_contents("php://input"));
		 
		 //print_r($data->id);die;
		 
		 $result_merk = $this->home_model->get_merk_v2(); 
		 
		 $array_merk = [];
		 
			foreach($result_merk as $result_merks){
				
				// $array_merk[$result_merks['FIELD']]['MERK'] = $result_merks['FIELD'];
				// $array_merk[$result_merks['FIELD']]['MERK_TYPE'] = $result_merks['MERK_TYPE'];
				// $array_merk[$result_merks['FIELD']]['VALUE'][] = ARRAY('FIELD' => $result_merks['VALUE'],'LABEL' => $result_merks['LABEL']);

				$array_merk[$result_merks['DESCRIPTION']]['SURVEY'] = $result_merks['SURVEY'];	
				$array_merk[$result_merks['DESCRIPTION']]['DATA_PRORITY'] = $result_merks['PRIORITY'];	
				$array_merk[$result_merks['DESCRIPTION']]['MERK'] = $result_merks['DESCRIPTION'];
				$array_merk[$result_merks['DESCRIPTION']]['MERK_TYPE'] = $result_merks['MERK_TYPE'];
				$array_merk[$result_merks['DESCRIPTION']]['VALUE'][] = ARRAY('FIELD' => $result_merks['FIELD'],'LABEL' => $result_merks['LABEL']);
				
				
			}
			
			$array_data = [];
			foreach($array_merk as $array_merk_v2){
				$array_data[] = $array_merk_v2;
			}
			//rint_r($array_data);die;
		
			
		$result = $array_data;
		 
		 $res = array(
                'status' => 'Success',
                'message' => 'Success Request',
                'data' => $result
		);
		
		$header = 'HTTP/1.1 200 OK';
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);
	}
	
	function list_kecamatan_post(){
		
		 $data = json_decode(file_get_contents("php://input"));
		 
		 
		 $check = $this->home_model->check_token((array)$data); 
		 
		 if($check[0]['cnt'] == 1 ){
		 
		 $result = $this->home_model->get_kecamatan($data->id); 
		 
			$res = array(
                'status' => 'Success',
                'message' => 'Success Request',
                'data' => $result
			);
		
		 }else{
			 $res = array(
                'status' => 'Error',
                'message' => 'Token Validate Error',
                'data' => []
			);
		 }
		
		$header = 'HTTP/1.1 200 OK';
		header($header);
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		echo json_encode($res);
	}

	function test_get() {
        $data = json_decode(file_get_contents("php://input"));

        $res = array(
			'status' => 'success',
			'message' => 'Ini Hanya test'
		);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        
        echo json_encode($res);
    }
	
	
	

	public function Anti_sql_injection($string) {
		$string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
		return $string;
	}
	
}
