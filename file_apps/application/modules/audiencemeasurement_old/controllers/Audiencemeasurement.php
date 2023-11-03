<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audiencemeasurement extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvpc_model');
	}
	
	public function load_channels()
	{
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		$daypart = $this->tvpc_model->load_channels($params);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		
		
		
	}
	
	  public function save_channels()
	{
		$userid = $this->session->userdata('user_id');
		$params['save_channel_name'] = $this->Anti_si($_POST['save_channel_name']);
		$params['channel'] = $this->Anti_si($_POST['channel']);
		$params['user_id'] = $userid;
		
		$daypart = $this->tvpc_model->save_channels($params);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		
		
		
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
		$data['daypart'] = $this->tvpc_model->list_daypart(0);
		$data['currdate'] = $this->tvpc_model->current_date();
		$data['genre'] = $this->tvpc_model->list_channel_genre();
		$this->template->load('maintemplate', 'audiencemeasurement/views/tvpc_view', $data);
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
	
	public function excel_all(){
		
			if( ! empty($this->Anti_si($this->input->post('start_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('start_date',true)));
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($this->input->post('end_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('end_date',true)));
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}
        
		if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}
        
		if( ! empty($this->Anti_si($this->input->post('profile',true))) ) {
			$profile = $this->Anti_si($this->input->post('profile',true));
		} else {
			$profile = 0;
		}
    
		if( ! empty($this->Anti_si($this->input->post('genre',true))) ) {
		  $genre =$this->Anti_si( $this->input->post('genre',true));
		} else {
		  $genre = "0";
		}

		if( ! empty($this->Anti_si($this->input->post('channel',true))) ) {
			$channel = $this->Anti_si($this->input->post('channel',true));
		} else {
			$channel = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('daypart',true))) ) {
			$daypart = $this->Anti_si($this->input->post('daypart',true));
		} else {
			$daypart = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('daypart2',true))) ) {
			$daypart2 = $this->Anti_si($this->input->post('daypart2',true));
		} else {
			$daypart2 = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('layout1',true))) ) {
			$layout1 = $this->Anti_si($this->input->post('layout1',true));
		} else {
			$layout1 = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('layout2',true))) ) {
			$layout2 = $this->Anti_si($this->input->post('layout2',true));
		} else {
			$layout2 = NULL;
		}	
		
		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['daypart']		= $daypart;
		$params['daypart2']		= $daypart2;
		$params['layout1']		= $layout1;
		$params['layout2']		= $layout2;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",$channel);
			
			$date_start = date_create($params['start_date']);
			$date_end = date_create($params['end_date']);
			
			$interval_date = date_format($date_start,"d").'-'.date_format($date_end,"d");
			$month =  date_format($date_start,"m");
			$year = date_format($date_start,"Y");
			$params['periode'] = date_format($date_start,"Y-F");
			
			if( $params['end_date'] == date("Y-m-d") ){
				$end_date_m = date("d");
			}else{
				$end_date_m = cal_days_in_month(CAL_GREGORIAN,$month,$year);
			}
			
			
			
			if($interval_date == '01-07'){
				
				$type_vo = 'WEEK1';
				$type_val = '1';
				
			}elseif($interval_date == '01-14'){
				
				$type_vo = 'WEEK2';
				$type_val = '1';
				
			}elseif($interval_date == '08-14'){
				
				$type_vo = 'WEEK1';
				$type_val = '2';
				
			}elseif($interval_date == '15-21'){
				
				$type_vo = 'WEEK1';
				$type_val = '3';
				
			}else{
				if(date_format($date_start,"d") == '22' && date_format($date_end,"d") == $end_date_m ){
					$type_vo = 'WEEK1';
					$type_val = '4';
				}elseif(date_format($date_start,"d") == '15' && date_format($date_end,"d") == $end_date_m ){
					$type_vo = 'WEEK2';
					$type_val = '2';
				}elseif(date_format($date_start,"d") == '01' && date_format($date_end,"d") == $end_date_m ){
					$type_vo = 'MONTHLY';
				}else{
					$type_vo = 'NORMAL';
					$type_val = 'NORMAL';

				}
			}
			
			$params['type_vo'] = $type_vo;
			$params['type_val'] = $type_val ;
			
			$data['channel'] = $this->tvpc_model->list_tvpc_all($params);
			
				$i = 1;
    			$ik = 0;
			
			  $this->load->library('excel');
	   
	   $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	   
	   if($params['layout2'] <> 'ALL'){
		   
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Channel')
					->setCellValue('C1', 'Audience')
					->setCellValue('D1', 'TVR')
					->setCellValue('E1', 'TVS')
					->setCellValue('F1', 'Total Views')
					->setCellValue('G1', 'Reach');
	   }else{
		   
		   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Audience')
					->setCellValue('C1', 'TVR')
					->setCellValue('D1', 'TVS')
					->setCellValue('E1', 'Total Views')
					->setCellValue('F1', 'Reach');
		   
	   }
			
			  $it1 = 2;
			  
			foreach($data['channel'] as $datax){
				
				if($params['layout2'] <> 'ALL'){
					
					if($params['type_vo'] == 'NORMAL'){
					
					   $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$it1, $i)
						->setCellValue('B'.$it1, $datax['TYPE_NAME'])
						->setCellValue('C'.$it1, $datax['AUDIENCE'])
						->setCellValue('D'.$it1, $datax['TVR'])
						->setCellValue('E'.$it1, $datax['TVS'])
						->setCellValue('F'.$it1, $datax['TOTAL_VIEW'])
						->setCellValue('G'.$it1, $datax['REACH']);
					
					}else{
						  $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$it1, $i)
						->setCellValue('B'.$it1, $datax['CHANNEL'])
						->setCellValue('C'.$it1, $datax['AUDIENCE'])
						->setCellValue('D'.$it1, $datax['TVR'])
						->setCellValue('E'.$it1, $datax['TVS'])
						->setCellValue('F'.$it1, $datax['TOTAL_VIEW'])
						->setCellValue('G'.$it1, $datax['REACH']);
					}
				}ELSE{
					  $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $i)
					->setCellValue('B'.$it1, $datax['AUDIENCE'])
					->setCellValue('C'.$it1, $datax['TVR'])
					->setCellValue('D'.$it1, $datax['TVS'])
					->setCellValue('E'.$it1, $datax['TOTAL_VIEW'])
					->setCellValue('F'.$it1, $datax['REACH']);
					
				}
				$it1++;
    			$i++;
    		}
			
			$objPHPExcel->getActiveSheet()->setTitle('Audience Measurement');
			$objPHPExcel->setActiveSheetIndex(0);
			
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			
			
			$objWriter->save('/var/www/html/tmp_doc/Audience_measurement.xls');	
		
			echo json_encode($data['channel'],true);
		
	}
	
	public function all_all(){
		
		
		
		if( ! empty($this->Anti_si($this->input->post('start_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('start_date',true)));
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($this->input->post('end_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('end_date',true)));
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}
        
		if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}
        
		if( ! empty($this->Anti_si($this->input->post('profile',true))) ) {
			$profile = $this->Anti_si($this->input->post('profile',true));
		} else {
			$profile = 0;
		}
    
		if( ! empty($this->Anti_si($this->input->post('genre',true))) ) {
		  $genre = $this->Anti_si($this->input->post('genre',true));
		} else {
		  $genre = "0";
		}

		if( ! empty($this->Anti_si($this->input->post('channel',true))) ) {
			$channel = $this->Anti_si($this->input->post('channel',true));
		} else {
			$channel = NULL;
		}	
		
		$channel = str_replace("\'","'",$channel);
		
		if( ! empty($this->Anti_si($this->input->post('daypart',true))) ) {
			$daypart = $this->Anti_si($this->input->post('daypart',true));
		} else {
			$daypart = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('daypart2',true))) ) {
			$daypart2 = $this->Anti_si($this->input->post('daypart2',true));
		} else {
			$daypart2 = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('layout1',true))) ) {
			$layout1 = $this->Anti_si($this->input->post('layout1',true));
		} else {
			$layout1 = NULL;
		}	
		
		if( ! empty($this->Anti_si($this->input->post('layout2',true))) ) {
			$layout2 = $this->Anti_si($this->input->post('layout2',true));
		} else {
			$layout2 = NULL;
		}	
		
		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['daypart']		= $daypart;
		$params['daypart2']		= $daypart2;
		$params['layout1']		= $layout1;
		$params['layout2']		= $layout2;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",$channel);
			
			
			$date_start = date_create($params['start_date']);
			$date_end = date_create($params['end_date']);
			
			$interval_date = date_format($date_start,"d").'-'.date_format($date_end,"d");
			$month =  date_format($date_start,"m");
			$year = date_format($date_start,"Y");
			$params['periode'] = date_format($date_start,"Y-F");
			
			if( $params['end_date'] == date("Y-m-d") ){
				$end_date_m = date("d");
			}else{
				$end_date_m = cal_days_in_month(CAL_GREGORIAN,$month,$year);
			}
			
			
			
			if($interval_date == '01-07'){
				
				$type_vo = 'WEEK1';
				$type_val = '1';
				
			}elseif($interval_date == '01-14'){
				
				$type_vo = 'WEEK2';
				$type_val = '1';
				
			}elseif($interval_date == '08-14'){
				
				$type_vo = 'WEEK1';
				$type_val = '2';
				
			}elseif($interval_date == '15-21'){
				
				$type_vo = 'WEEK1';
				$type_val = '3';
				
			}else{
				if(date_format($date_start,"d") == '22' && date_format($date_end,"d") == $end_date_m ){
					$type_vo = 'WEEK1';
					$type_val = '4';
				}elseif(date_format($date_start,"d") == '15' && date_format($date_end,"d") == $end_date_m ){
					$type_vo = 'WEEK2';
					$type_val = '2';
				}elseif(date_format($date_start,"d") == '01' && date_format($date_end,"d") == $end_date_m ){
					$type_vo = 'MONTHLY';
				}else{
					$type_vo = 'NORMAL';
					$type_val = 'NORMAL';

				}
			}
			
			$params['type_vo'] = $type_vo;
			$params['type_val'] = $type_val ;
			
			
			$data['channel'] = $this->tvpc_model->list_tvpc_all($params);
			
				$i = 1;
    			$ik = 0;
			
			foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
						
						if($params['layout2'] <> 'ALL'){
							
							if($params['type_vo'] == 'NORMAL'){
								$data_ch[$ik]['TYPE_NAME'] = $datax['TYPE_NAME'];
							}ELSE{
								$data_ch[$ik]['TYPE_NAME'] = $datax['CHANNEL'];
							}
						}
						
    					$data_ch[$ik]['AUDIENCE'] = $datax['AUDIENCE'];
    					$data_ch[$ik]['TVR'] = $datax['TVR'];
    					$data_ch[$ik]['TVS'] = $datax['TVS'];
    					$data_ch[$ik]['TOTAL_VIEW'] = $datax['TOTAL_VIEW'];
    					$data_ch[$ik]['REACH'] = $datax['REACH'];
    					$i++;
    					$ik++;
    				}
					
					
			
			  
				  
			
			echo json_encode($data_ch,true);
		
	}
	
	
	public function list_tvpc()
	{	        
		if( ! empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}
        
		if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}
        
		if( ! empty($this->Anti_si($_GET['profile'])) ) {
			$profile = $this->Anti_si($_GET['profile']);
		} else {
			$profile = 0;
		}
    
		if( ! empty($this->Anti_si($_GET['genre'])) ) {
		  $genre = $this->Anti_si($_GET['genre']);
		} else {
		  $genre = "0";
		}

		if( ! empty($this->Anti_si($_GET['channel'])) ) {
			$channel = $this->Anti_si($_GET['channel']);
		} else {
			$channel = NULL;
		}	
		
		$channel = str_replace("\'","'",$channel);
		
		if( ! empty($this->Anti_si($_GET['daypart'])) ) {
			$daypart = $this->Anti_si($_GET['daypart']);
		} else {
			$daypart = NULL;
		}	
		
		if( ! empty($this->Anti_si($_GET['daypart2'])) ) {
			$daypart2 = $this->Anti_si($_GET['daypart2']);
		} else {
			$daypart2 = NULL;
		}	
		
		if( ! empty($this->Anti_si($_GET['layout1'])) ) {
			$layout1 = $this->Anti_si($_GET['layout1']);
		} else {
			$layout1 = NULL;
		}	
		
		if( ! empty($this->Anti_si($_GET['layout2'])) ) {
			$layout2 = $this->Anti_si($_GET['layout2']);
		} else {
			$layout2 = NULL;
		}	
		
		if( ! empty($this->Anti_si($_GET['sort_by'])) ) {
			$sort_by = $this->Anti_si($_GET['sort_by']);
		} else {
			$sort_by = NULL;
		}	
		
		
    
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 			

		if($sort_by == null){
			$order_fields = array( 'AUDIENCE', 'DATE', 'TYPE_NAME');
		}else{
			$order_fields = explode('|',$sort_by);
			
		}
		
		$sort_col = '';
		
		foreach($order_fields as $s_cc){
			
			if($s_cc == 'CHANNEL'){
				$sort_col = $sort_col.' TYPE DESC ,';
			}else{
				$sort_col = $sort_col.' '.$s_cc.' DESC ,';
			}
			
			
		}
		
		
		$order = $this->input->get_post('order');
		$order_dir    = 'desc';
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		
		$search = $this->input->get_post('search');		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = substr($sort_col, 0, -1);;
		$params['order_dir'] 	= '';
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['daypart']		= $daypart;
		$params['daypart2']		= $daypart2;
		$params['layout1']		= $layout1;
		$params['layout2']		= $layout2;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",$channel);
		
		$list = $this->tvpc_model->list_tvpc($params);
		
		
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;               
    
    if($order_dir == "desc"){
        $nrow = (int) $start+1;
    } else if($order_dir == "asc"){
        $nrow = $list['total_filtered']-(int) $start;
    }    
		
		
		
		$in_num = 1;
		$data = array();	
		
		if($params['layout2'] == 'channel'){
		
			if($params['daypart'] == 'ALL_ALL'){
			
				foreach ( $list['data'] as $k => $v ) {      
					array_push($data, 
						array(
				  $nrow,		
							$v['CHANNEL_NAME_PROG'],				
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
			
			}ELSE if($params['daypart'] == 'ALL'){
			
				foreach ( $list['data'] as $k => $v ) {      
					array_push($data, 
						array(
				  $nrow,		
				  $v['DATE'],
							$v['CHANNEL_NAME_PROG'],				
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
			
			}else if($params['daypart'] == 'HOUR'){
				
				foreach ( $list['data'] as $k => $v ) {      
				array_push($data, 
					array(
				  $nrow,		
				  $v['DATE'],
				  $v['HOURS'],
							$v['CHANNEL_NAME_PROG'],				
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
				
			}else if($params['daypart'] == 'MINUTE'){
				
				foreach ( $list['data'] as $k => $v ) {      
				array_push($data, 
					array(
				  $nrow,		
				  $v['DATE'],
				  $v['HOURS'],
				  $v['SPLIT_MINUTES'],
							$v['CHANNEL_NAME_PROG'],				
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
				
			}
		
		}else if($params['layout2'] == 'program'){
		
			if($params['daypart'] == 'ALL'){
			
				foreach ( $list['data'] as $k => $v ) {      
					array_push($data, 
						array(
					$nrow,		
						$v['DATE'],
						$v['CHANNEL_NAME_PROG'],							
							$v['TYPE_NAME'],
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
			
			}else if($params['daypart'] == 'HOUR'){
				
				foreach ( $list['data'] as $k => $v ) {      
				array_push($data, 
					array(
				  $nrow,		
				  $v['DATE'],
				  $v['HOURS'],
				  $v['CHANNEL_NAME_PROG'],
							$v['TYPE_NAME'],	
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
				
			}else if($params['daypart'] == 'MINUTE'){
				
				foreach ( $list['data'] as $k => $v ) {      
				array_push($data, 
					array(
				  $nrow,		
				  $v['DATE'],
				  $v['HOURS'],
				  $v['SPLIT_MINUTES'],
				  $v['CHANNEL_NAME_PROG'],
							$v['TYPE_NAME'],				
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
				
			}
		
		}else if($params['layout2'] == 'ALL'){
		
			if($params['daypart'] == 'ALL'){
			
				foreach ( $list['data'] as $k => $v ) {      
					array_push($data, 
						array(
					$nrow,		
						$v['DATE'],
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
			
			}else if($params['daypart'] == 'HOUR'){
				
				foreach ( $list['data'] as $k => $v ) {      
				array_push($data, 
					array(
				  $nrow,		
				  $v['DATE'],
				  $v['HOURS'],
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
				
			}else if($params['daypart'] == 'MINUTE'){
				
				foreach ( $list['data'] as $k => $v ) {      
				array_push($data, 
					array(
				  $nrow,		
				  $v['DATE'],
				  $v['HOURS'],
				  $v['SPLIT_MINUTES'],			
							number_format(round($v['AUDIENCE'],0), 0, ",", "."), 
							number_format($v['TVR'], 2, ",", "."),
							number_format($v['TVS'], 2, ",", "."),
							number_format(round($v['TOTAL_VIEW'],0), 0, ",", "."),
							number_format($v['REACH'], 2, ",", "."),
						)
					);      
			  
				  if($order_dir == "desc"){
					  $nrow = $nrow + 1;
				  } else if($order_dir == "asc"){
					  $nrow = $nrow - 1;
				  }
				  
				  $in_num++;
				}		
				
			}
		
		}
    
		$result["data"] = $data;
		$this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

  public function listchart_tvpc()
	{	
	
		if( ! empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}
        
    if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}
    
		if( ! empty($this->Anti_si($_GET['profile'])) ) {
			$profile = $this->Anti_si($_GET['profile']);
		} else {
			$profile = 0;
		}
    
    if( ! empty($this->Anti_si($_GET['genre'])) ) {
        $genre = $this->Anti_si($_GET['genre']);
    } else {
        $genre = "0";
    }

		if( ! empty($this->Anti_si($_GET['channel'])) ) {
			$channel = $this->Anti_si($_GET['channel']);
		} else {
			$channel = NULL;
		}
    
    if( ! empty($this->Anti_si($_GET['cgroup'])) ) {
			$cgroup = $this->Anti_si($_GET['cgroup']);
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
      $list = $this->tvpc_model->profilesearch($this->Anti_si($_GET['q']),$iduser,$this->Anti_si($_GET['f']));
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }     
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvpc_model->list_profile($iduser,"",$this->Anti_si($_GET['f']));          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                      
  
  public function genresearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->tvpc_model->genresearch($this->Anti_si($_GET['q']),$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                  
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$this->Anti_si($_GET['g']));
      $list = $this->tvpc_model->channelsearch($this->Anti_si($_GET['q']),$genre,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }             
  
  public function checkdaypart(){
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($this->Anti_si($_GET['f'])) ) {
          $from = $this->Anti_si($_GET['f']);
      } else {
          $from = "00:00";
      }
      
      if( ! empty($this->Anti_si($_GET['t'])) ) {
          $to = $this->Anti_si($_GET['t']);
      } else {
          $to = "00:00";
      }
      
      $daypart = $this->Anti_si($_GET['f']).":00-".$this->Anti_si($_GET['t']).":00"; 
      
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
      
      if( ! empty($this->Anti_si($_GET['f'])) ) {
          $from = $this->Anti_si($_GET['f']);
      } else {
          $from = "00:00";
      }
      
      if( ! empty($this->Anti_si($_GET['t'])) ) {
          $to = $this->Anti_si($_GET['t']);
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