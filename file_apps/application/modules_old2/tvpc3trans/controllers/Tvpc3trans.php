<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvpc3trans extends CI_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvpc_model');
	}
	
	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['profile'] = $this->tvpc_model->list_profile($iduser,$idrole,"");
		$data['channel'] = $this->tvpc_model->list_channel();                   
		$data['daypart'] = $this->tvpc_model->list_daypart($iduser);
		$data['currdate'] = $this->tvpc_model->current_date();
		$data['genre'] = $this->tvpc_model->list_channel_genre();
		$this->template->load('maintemplate_trans', 'tvpc3trans/views/tvpc_view', $data);
	}
  
	public function get_profile_id($profiles){
		$grouping_json = $this->tvpc_model->content_grouping($profiles);
		$res = json_decode($grouping_json['grouping'],true);		
		$values = [];
		$tag = '';
		$values1 = '';
		
		$strsql='';
		$strsql2='';
		
		$asas = " WHERE 1=1 ";
		
		if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$key = array_keys($mydata['Operation']);
					$asas = $asas."AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'".$key[0]."') IN (";
					foreach($mydata['Operation'] as $val){
						foreach($val as $value){
							$asas = $asas."'".$value."',";
						}						
					}
					$asas = substr($asas,0,-1).") ";
				}
			}
		}
		
		$where = $asas;
		
		$get_userid = $this->tvpc_model->get_userid($where);
		
		if($res){		
			$key1 = '';
			foreach($get_userid as $key)
			{
				$key1 .= "'".$key['USERID']."'".",";
			}
			$profile = rtrim($key1,",");
		}else{
			$profile = '';	
		}
		
		return $profile;
		
	}
	
	public function Anti_sql_injection($string) {
		$string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
		return $string;
	}
	
	public function tvpc3_export()
	{	        
		
		$dt   = new DateTime();
		$date = $dt->createFromFormat('d/m/Y', $this->Anti_sql_injection($this->input->post('start_date', TRUE)));
		$params['start_date']  = $date->format('Y-m-d');
		
		$dt   = new DateTime();
		$date = $dt->createFromFormat('d/m/Y', $this->Anti_sql_injection($this->input->post('end_date', TRUE)));
		$params['end_date'] = $date->format('Y-m-d');
		
		$params['starttime'] =   $this->Anti_sql_injection($this->input->post('start_time', TRUE));
		$params['endtime'] =   $this->Anti_sql_injection($this->input->post('end_time', TRUE));
		$params['profile'] =   $this->Anti_sql_injection($this->input->post('profile', TRUE));
		$params['genre'] =   str_replace("AND","&",$this->Anti_sql_injection($this->input->post('genre', TRUE)));
		$params['daypart'] =   $this->Anti_sql_injection($this->input->post('daypart', TRUE));
		//$params['channel'] =   str_replace("AND","&",str_replace("  AND  "," & ",$this->Anti_sql_injection($this->input->post('channel', TRUE))));
		$channel =   str_replace("AND","&",str_replace("  AND  "," & ",$this->Anti_sql_injection($this->input->post('channel', TRUE))));
		$channel = explode(',',$channel);
		$ccc = '';
		
		foreach($channel as $chn){
			
			$ccc .= "'".$chn."',";
			
		}
		
		
		$params['channel'] = substr($ccc,0,-1);
		// Build params for calling model  
	
    //print_r($params); die();
		
		$list = $this->tvpc_model->list_tvpc_export($params);
		
		$this->load->library('excel');
	   
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	    $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
		
		//print_r($list); die();
		
		$data = array();	
		$it1 = 2;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', "Rank")
					->setCellValue('B1', "Date")
					->setCellValue('C1', "Program")
					->setCellValue('D1', "Channel")
					->setCellValue('E1', "Genre")
					->setCellValue('F1', "Begin Time")
					->setCellValue('G1', "End Time")
					->setCellValue('H1', "TVS")
					->setCellValue('I1', "TVR")
					->setCellValue('J1', "Viewer");
		
		foreach ( $list as $k => $v ) {      
		$num = $it1-1;
		
		
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $num)
					->setCellValue('B'.$it1, $v['DATE'])
					->setCellValue('C'.$it1, $v['PROGRAM'])
					->setCellValue('D'.$it1, $v['CHANNEL_NAME_PROG'])
					->setCellValue('E'.$it1, $v['GENRE_PROGRAM'])
					->setCellValue('F'.$it1, $v['BEGIN_PROGRAM'])
					->setCellValue('G'.$it1, $v['END_PROGRAM'])
					->setCellValue('H'.$it1, number_format(round($v['TVS'],2), 2, ",", "."))
					->setCellValue('I'.$it1, number_format(round($v['TVR'],2), 2, ",", "."))
					->setCellValue('J'.$it1, $v['VIEWERS']);
			
			$it1++;
			
					// $v['DATE'],				
					// $v['PROGRAM'],
					// $v['CHANNEL'],
					// $v['GENRE_PROGRAM'],					
					// $v['BEGIN_PROGRAM'],					
					// $v['END_PROGRAM'],
					// number_format(round($v['TVS'],2), 2, ",", "."),
					// number_format(round($v['TVR'],2), 2, ",", "."),
					// number_format(round($v['VIEWERS'],0), 0, ",", "."),
			
		}
    
    
		$objPHPExcel->getActiveSheet()->setTitle('Audience Analytics');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		
		// Redirect output to a client’s web browser (Excel2007)
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		// header('Cache-Control: max-age=0');
		// // If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');

		// // If you're serving to IE over SSL, then the following may be needed
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		//$objWriter->save('php://output');
		
		 //ob_end_clean();
		
		$objWriter->save('/var/www/html/tmp_doc/tvpc_export.xls');
	}
	
	
	public function list_tvpc()
	{	        
		if( ! empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}
        
		if( !empty($_GET['stime']) ) {
			$start_time = $_GET['stime'];
		} else {
			$start_time = NULL;
		}
		
		if( !empty($_GET['etime']) ) {
			$end_time = $_GET['etime'];
		} else {
			$end_time = NULL;
		}
        
		if( ! empty($_GET['profile']) ) {
			$profile = $_GET['profile'];
		} else {
			$profile = 0;
		}
    
		if( ! empty($_GET['genre']) ) {
		  $genre = $_GET['genre'];
		} else {
		  $genre = "0";
		}

		if( ! empty($_GET['channel']) ) {
			$channel = $_GET['channel'];
		} else {
			$channel = NULL;
		}	
    
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('rank','tanggal', 'program', 'channel', 'epg.genre','begin_time', 'end_time', 'TVS', 'TVR', 'viewers');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		
		$search = $this->input->get_post('search');		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		// Build params for calling model 
		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",str_replace("  AND  "," & ",$channel));
    //print_r($params); die();
		
		$list = $this->tvpc_model->list_tvpc($params);
		
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;               
    
    if($order_dir == "desc"){
        $nrow = (int) $start+1;
    } else if($order_dir == "asc"){
        $nrow = $list['total_filtered']-(int) $start;
    }    
		
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {      
			array_push($data, 
				array(
          // "<div class='checkbox urate-checkbox' align='center'><input type='checkbox' class='urate-form-checkbox' name='showHide' id='check".$nrow."' /><label for='check".$nrow."'></label></div>",	
          $nrow,		
					$v['DATE'],				
					$v['PROGRAM'],
					$v['CHANNEL'],
					$v['GENRE_PROGRAM'],					
					$v['BEGIN_PROGRAM'],					
					$v['END_PROGRAM'],
					number_format(round($v['TVS'],2), 2, ",", "."),
					number_format(round($v['TVR'],2), 2, ",", "."),
					number_format(round($v['VIEWERS'],0), 0, ",", "."),
				)
			);      
      
      if($order_dir == "desc"){
          $nrow = $nrow + 1;
      } else if($order_dir == "asc"){
          $nrow = $nrow - 1;
      }
		}		
    
		$result["data"] = $data;
		$this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

  public function listchart_tvpc()
	{	
	
		if( ! empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}
        
    if( !empty($_GET['stime']) ) {
			$start_time = $_GET['stime'];
		} else {
			$start_time = NULL;
		}
		
		if( !empty($_GET['etime']) ) {
			$end_time = $_GET['etime'];
		} else {
			$end_time = NULL;
		}
    
		if( ! empty($_GET['profile']) ) {
			$profile = $_GET['profile'];
		} else {
			$profile = 0;
		}
    
    if( ! empty($_GET['genre']) ) {
        $genre = $_GET['genre'];
    } else {
        $genre = "0";
    }

		if( ! empty($_GET['channel']) ) {
			$channel = $_GET['channel'];
		} else {
			$channel = NULL;
		}
    
    if( ! empty($_GET['cgroup']) ) {
			$cgroup = $_GET['cgroup'];
		} else {
			$cgroup = NULL;
		}
    
    $params['starttime'] 	= $start_time;
    $params['endtime'] 		= $end_time;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
    $params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",$channel);
    $params['cgroup']		= strtoupper($cgroup);
		$data['tvpc'] = $this->tvpc_model->listchart_tvpc($params);
		
		$result["data"] = $data;
		
		$this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}	                                                                 
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvpc_model->profilesearch($_GET['q'],$iduser,$_GET['f']);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }     
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvpc_model->list_profile($iduser,"",$_GET['f']);          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                      
  
  public function genresearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->tvpc_model->genresearch($_GET['q'],$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                  
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$_GET['g']);
      $list = $this->tvpc_model->channelsearch($_GET['q'],$genre,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }             
  
  public function checkdaypart(){
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($_GET['f']) ) {
          $from = $_GET['f'];
      } else {
          $from = "00:00";
      }
      
      if( ! empty($_GET['t']) ) {
          $to = $_GET['t'];
      } else {
          $to = "00:00";
      }
      
      $daypart = $_GET['f'].":00-".$_GET['t'].":00"; 
      
      $count_daypart = $this->tvcc_model->checkdaypart($userid,$daypart);
    
  		if ( $count_daypart != "1" ) {
        $result = array( 'success' => true, 'message' => 'Vacant', 'data' => array('hasil' => $count_daypart));
  			
  			$this->output->set_content_type('application/json')->set_output(json_encode($result));
  		} else {
  			$result = array( 'success' => false, 'message' => 'Exist', 'data' => array('hasil' => $count_daypart));
  			$this->output->set_content_type('application/json')->set_output(json_encode($result));
  		}
  }              
  
  public function setdaypart(){
      $typerole = $this->session->userdata('type_role');
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($_GET['f']) ) {
          $from = $_GET['f'];
      } else {
          $from = "00:00";
      }
      
      if( ! empty($_GET['t']) ) {
          $to = $_GET['t'];
      } else {
          $to = "00:00";
      }
      
      $daypart = $this->tvpc_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}