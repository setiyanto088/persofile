<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Apiidm extends REST_Controller {

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

	public function Anti_si($string) {
		$string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
		return $string;
	}
	
	function generateRandomString($length = 16) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	
	function epg_get_list_channel_get(){
		
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		//$data = json_decode(file_get_contents("php://input"));
		
		if($param['token'] == '4Oxx33POLMB7ufjx'){
			
			$check = $this->home_model->get_channel(); 
			echo json_encode($check,true);
			
		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		
		 
	}
	
	function epg_channel_insert_post() {
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		
		if($param['token'] == '4Oxx33POLMB7ufjx'){
			
			$data = json_decode(file_get_contents("php://input"),true);
			 
			if(count($data) == 0){
				$error = array('status' => 'Data Tidak Valid'); 
				echo json_encode($error,true);
			}else{
				$check = $this->home_model->insert_new_channel($data); 
				$result_success = array('status' => 'berhasil eksekusi'); 
                echo json_encode($result_success,true);
			}

		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		 
		
        $data = json_decode(file_get_contents("php://input"));
	
	}
	
	function epg_channel_update_post() {
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		
		if($param['token'] == '4Oxx33POLMB7ufjx'){
			
			$data = json_decode(file_get_contents("php://input"),true);
			 
			if(count($data) == 0){
				$error = array('status' => 'Data Tidak Valid'); 
				echo json_encode($error,true);
			}else{
				$check = $this->home_model->update_new_channel($data); 
				$result_success = array('status' => 'berhasil eksekusi'); 
                echo json_encode($result_success,true);
			}

		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		 
		
        $data = json_decode(file_get_contents("php://input"));
	
	}
	
	function epg_channel_delete_post() {
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		
		if($param['token'] == '4Oxx33POLMB7ufjx'){
			
			$data = json_decode(file_get_contents("php://input"),true);
			 
			if(count($data) == 0){
				$error = array('status' => 'Data Tidak Valid'); 
				echo json_encode($error,true);
			}else{
				$check = $this->home_model->delete_new_channel($data); 
				$result_success = array('status' => 'berhasil eksekusi'); 
                echo json_encode($result_success,true);
			}

		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		 
		
        $data = json_decode(file_get_contents("php://input"));
	
	}
	
	function epg_today_get_get(){
		
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		$param['channel'] =  $this->Anti_si($this->uri->segment(4)); 
		//$data = json_decode(file_get_contents("php://input"));
		$param['channel'] = str_replace('%20',' ',$param['channel']);
		$param['date'] = date('Y-m-d');
		
		if($param['token'] == 'it8jVej7djlomr6Q'){
			
			$check = $this->home_model->get_channel_today($param); 
			echo json_encode($check,true);
			
		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		
		 
	}
	
	function epg_today_post_post() {
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		
		if($param['token'] == 'ucPkBu24OLGNDZDj'){
			
			$data = json_decode(file_get_contents("php://input"),true);
			
			$bad_date=[];
            $bad_date['kesalahan_format_time']=[];
            $bad_date['kesalahan_format_detik']=[];
            $bad_date['kesalahan_end_time_kurang_dari_start_time']=[];
            $bad_date['kesalahan_tanggal_sudah_lewat']=[];
			
			$tr = 0;
			$count=0;
			foreach ($data as $key ) {
                $data_=[];
                $start = str_replace('.','-',$key['START_TIME']);
                $finish = str_replace('.','-',$key['END_TIME']);
                $start1 = str_replace('-','.',$key['START_TIME']);
                $finish1 = str_replace('-','.',$key['END_TIME']);

                $tgl_hari = date("Y-m-d");
                $tgl_hari_ini = strtotime($tgl_hari);

                $tgl_start = SUBSTR($start,0,10);
                $tgl_start = strtotime($tgl_start);
                 
                $start_time = strtotime($start);
                $end_time = strtotime($finish);


                
                $bad_message = $key['CHANNEL'].' - '.$key['START_TIME'].' - '.$key['END_TIME'];
                $pattern='/\d{4}\.\d{2}\.\d{2} \d{2}:\d{2}:\d{2}/';
                $match = preg_match($pattern,$start1) * preg_match($pattern,$finish1);
               
                if($match==0){
					array_push($bad_date['kesalahan_format_time'], $bad_message);
                	$count=$count+1;
                }

                if(SUBSTR($key['START_TIME'],17,2)!=00 || SUBSTR($key['END_TIME'],17,2)!=59) {
                        array_push($bad_date['kesalahan_format_detik'], $bad_message);
                        $count=$count+1;
                }
				
				if($end_time<$start_time){
						array_push($bad_date['kesalahan_end_time_kurang_dari_start_time'], $bad_message);
						$count=$count+1;
                }
				
				if($tgl_start<$tgl_hari_ini){
                        array_push($bad_date['kesalahan_tanggal_sudah_lewat'], $bad_message);   
                        $count=$count+1;  
				}
				
				
				
				if($count == 0){
                          $params[$tr]['CHANNEL']=$key['CHANNEL'];
                          $params[$tr]['PERIOD']=date("Ym");
                          $params[$tr]['SCHEDULE_NAME']= str_replace ("'","''", $key['SCHEDULE_NAME']);
                          $params[$tr]['START_TIME']=$start1;
                          $params[$tr]['END_TIME']=$finish1;
                          $params[$tr]['GENRE']=$key['GENRE'];
                          $params[$tr]['TGL_UPLOAD']=date("Ymd");
                          $params[$tr]['JAM_UPLOAD']=date("H");
                } 
                 
				$tr++;
            }
			//echo $count;
			// print_r($params);die;
			
			if($count>0){
                $array=array("status" => "Gagal","error"=>$bad_date);
	        	echo json_encode($array);
	        }else{
				$token = $this->generateRandomString();
	        	$result = $this->home_model->insert_epg_today($params,$token); 
				
				$paramss['token'] = $token;
			
				$list = $this->home_model->get_epg_file($paramss);
				//print_r($list);die;
				
				foreach($list as $lists){
					$this->home_model->delete_data_epg($lists,$paramss);
					$this->home_model->process_data_epg($lists,$paramss);
				}

	            // if($result){
	                $result_success = array('status' => 'berhasil eksekusi'); 
	                echo json_encode($result_success);
	            // }else{
	                // $result_error = array('status' => 'gagal eksekusi'); 
	                // echo json_encode($result_error);
	            // }
	        }    
			
		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		 
		
        $data = json_decode(file_get_contents("php://input"));
	
	}
	
	function epg_today_delete_post() {
		$param['token'] =  $this->Anti_si($this->uri->segment(3)); 
		//PRINT_R($param);DIE;
		
		if($param['token'] == 'ucPkBu24OLGNDZDj'){
			
			$data = json_decode(file_get_contents("php://input"),true);
			
			
			
			foreach ($data as $key ) {           
                $param['CHANNEL']= $key['CHANNEL'];
                $param['SCHEDULE_NAME'] = str_replace ("'","''", $key['SCHEDULE_NAME']);
                $start = str_replace('-','.',$key['START_TIME']);
                $finish = str_replace('-','.',$key['END_TIME']);
                $param['START_TIME'] = $start;
                $param['END_TIME'] = $finish;
            }  
			
			//PRINT_R($param);DIE;
			
			$check = $this->home_model->epg_today_delete_today($param); 
			$result_success = array('status' => 'berhasil eksekusi'); 
			echo json_encode($result_success,true);
			
		}else{
			$error = array('status' => 'Token Salah'); 
			echo json_encode($error,true);
		 }
		 
		
        $data = json_decode(file_get_contents("php://input"));
	
	}
}
