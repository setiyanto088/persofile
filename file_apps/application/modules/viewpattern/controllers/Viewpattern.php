<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Viewpattern extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvcc_model');
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
		
		$data['profile'] = $this->tvcc_model->list_profile($iduser,$idrole,"");
		$data['channel'] = $this->tvcc_model->list_channel();    
        $data['daypart'] = $this->tvcc_model->list_daypart($iduser);  
        $data['currdate'] = $this->tvcc_model->current_date();
        $data['genre'] = $this->tvcc_model->list_channel_genre();
 
		$this->template->load('maintemplate', 'viewpattern/views/tvcc_view', $data);
	}
	
	public function get_profile_id($profiles){
		$grouping_json = $this->tvcc_model->content_grouping($profiles); 
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
	
    if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$values[] = json_encode($mydata['Operation']);
				}
			}
		}
    
		$where = " WHERE 1=1 ";
		
		foreach($values as $vv){
			$str = str_replace("[{","",$vv);
			$str = str_replace("}]","",$str);
			$str_array = explode(",",$str);
			
			foreach($str_array as $str_arrays){
				$vals = explode(":",$str_arrays);
					
				$where = $where.' AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'.$vals[0].') = '.$vals[1];				
			}
			
		} 
		
		$get_userid = $this->tvcc_model->get_userid($where);					
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
  
    public function list_tvcc_city(){	                
      if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $start_date = $this->Anti_si($_POST['start_date']);
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
         
          $end_date = $this->Anti_si($_POST['end_date']);
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($this->Anti_si($_POST['program'])) ) {
          $program = str_replace("AND","&",$this->Anti_si($_POST['program']));
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($this->Anti_si($_POST['channel'])) ) {
          $channel = $this->Anti_si($_POST['channel']);
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
        
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
       $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
       $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
     
 
	    $arr_tvcc = [];
	  
      
	   $list = $this->tvcc_model->list_tvcc_city($params);
	   
 	   
      $n_a = $list['data'];
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
      $paging_array = array_slice($n_a,$params['offset'],$params['limit']);
      
      $data = array();		
      for($i=0;$i<count($paging_array);$i++){
          $new_array =  array_values($paging_array[$i]); 
          array_push($data,$new_array);
      } 
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }
  
  
  public function list_tvcc(){	                
      if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $start_date = $this->Anti_si($_POST['start_date']);
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
         
          $end_date = $this->Anti_si($_POST['end_date']);
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($this->Anti_si($_POST['program'])) ) {
          $program = str_replace("AND","&",$this->Anti_si($_POST['program']));
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($this->Anti_si($_POST['channel'])) ) {
          $channel = $this->Anti_si($_POST['channel']);
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
        
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
       $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
       $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
     
 
	    $arr_tvcc = [];
	  
     
	  
	   $list = $this->tvcc_model->list_tvcc($params);
	   
 	   
      $n_a = $list['data'];
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
      $paging_array = array_slice($n_a,$params['offset'],$params['limit']);
      
      $data = array();		
      for($i=0;$i<count($paging_array);$i++){
          $new_array =  array_values($paging_array[$i]); 
          array_push($data,$new_array);
      } 
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }
  
  function returnBetweenDates( $startDate, $endDate ){
    $startStamp = strtotime(  $startDate );
    $endStamp   = strtotime(  $endDate );

    if( $endStamp >= $startStamp ){
        while( $endStamp >= $startStamp ){

            $dateArr[] = date( 'Y-m-d', $startStamp );

            $startStamp = strtotime( ' +1 day ', $startStamp );

        }
        return $dateArr;    
    }else{
        return $startDate;
    }

}
  
   public function export_chart()
	{	                
    if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $start_date = $this->Anti_si($_POST['start_date']);
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
         
          $end_date = $this->Anti_si($_POST['end_date']);
      } else {
          $end_date = NULL;
      }
      
	  if( ! empty($this->Anti_si($_POST['days'])) ) {
         
          $days = $this->Anti_si($_POST['days']);
      } else {
          $days = NULL; 
      }
      
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($this->Anti_si($_POST['program'])) ) {
          $program = str_replace("AND","&",$this->Anti_si($_POST['program']));
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($this->Anti_si($_POST['channel'])) ) {
          $channel = $this->Anti_si($_POST['channel']);
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
	  
	   	$date_start = date_create($start_date);
			$date_end = date_create($end_date);
			
			$month =  date_format($date_start,"m");
			$year = date_format($date_start,"Y");
			$date = date_format($date_start,"d");
			$date_n = date_format($date_end,"d");
			$end_date_m = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	  
	  
	  
	   if($_POST['channel'] == "0"){
			$f = $this->tvcc_model->channelsearch2("",$genre,$start_date,$end_date);
			$cin = "";
			 $cin2 = "";
		
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f['CHANNEL']."',";
				
				 $cin2 = $cin2.$channel_f['CHANNEL'].",";
			}
			
 			
			$new_cin2 = substr($cin2, 0, -1);
			$new_cin = substr($cin, 0, -1);
			
			$hhh = explode(",",$new_cin);
		} else {
			
			$cin = "";
			 $cin2 = "";
			
		 
			
			foreach($_POST['channel'] as $channel_f){
				$cin = $cin."'".$channel_f."',";
				
				$cin2 = $cin2.$channel_f.",";
			}
			$new_cin = substr($cin2, 0, -1);
			$new_cin2 = substr($cin, 0, -1);
			
 			$hhh = $_POST['channel'];
		} 
      
	  
		 

     
      $params['channel'] 	= str_replace("AND","&",$channel);
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
	  $params['days']		= $days;
      $params['genre']		= str_replace("AND","&",$genre);
	  $params['channel_list']		= $new_cin;
       $params['program']		= str_replace("AND","&",$program);
	  $params['cgroup'] 		= 'viewers';
      
 
      $arr_tvcc = [];
      
	  $all_data = array();
	  $all_data_all = array();
 	  
	   $this->load->library('excel');
	  
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Reporting Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	  
	  $page_periode = 0;
	  
	 
		
				  $ts = 0;
 			
			 $arr_dates = '';
			
			$ich = 0;
			
			if( ($date == '01' && $date_n == $end_date_m && $_POST['channel'] == "0" ) || $_POST['channel'] == "0"){	

 
								$list = $this->tvcc_model->list_charttvcc_all($params,$params['start_date']);

								unset($data);
								$data = array();
								
								$ic = 0;
								$cur_prog = '';
								$cur_color = '';
						  
								
								if(count($list['data']) == 0){

								}else{
								
									foreach ( $list['data'] as $kk[$ts] ) { 				
										
										$data['FULL_PROG'][] = "";
 										$data['CHANNEL'][] = "ALL CHANNEL";
										$data['TIME'][] = $kk[$ts]['MINUTESS'];
										$data['PROGRAM'][] = $cur_prog;
 										$data['VIEWER'][] = intval($kk[$ts]['VIEWERS']);
										
										$ic++;
									}	
											
									$all_data_all[$ts][] = $data;
									
									if($page_periode == 0){
											
										}else{
											$objPHPExcel->createSheet($page_periode);
										}
									
										$objPHPExcel->setActiveSheetIndex($page_periode)
												->setCellValue('A1', 'Channel')
												->setCellValue('B1', 'TIME')
												->setCellValue('C1', 'VIEWERS');
										
										$int_data = 2;
										foreach($list['data'] as $lists){
											
											$objPHPExcel->setActiveSheetIndex($page_periode)
												->setCellValue('A'.$int_data, "ALL CHANNEL")
												->setCellValue('B'.$int_data, $lists['MINUTESS'])
												->setCellValue('C'.$int_data, intval($lists['VIEWERS']));
											
											$objPHPExcel->getActiveSheet()->setTitle('ALL CHANNEL'); 
											$int_data++;
										}
										
										$objPHPExcel->setActiveSheetIndex($page_periode);
										
										$page_periode++;
										
										 
										
 										

								 
								}

								$ich++;
							
							
						}else{
							
								foreach( $hhh	as $chn){
				
			  
										$list = $this->tvcc_model->list_charttvcc($params,$chn,$start_date);

 
										unset($data);
										$data = array();
										
										$ic = 0;
										$cur_prog = '';
										$cur_color = '';
										 
										
										if(count($list) == 0){
											
											
											
										}else{
										
											foreach ( $list as $kk[$ts] ) { 
												
												
												$data['FULL_PROG'][] = $kk[$ts]['FULL_PROG'];
												$data['CHANNEL'][] = $kk[$ts]['CHANNEL'];
												$data['TIME'][] = $kk[$ts]['MINUTES'];
												$data['PROGRAM'][] = $cur_prog;
												
												$data['VIEWER'][] = intval($kk[$ts]['VIEWERS']);
												
												$ic++;
											}	
													
											$all_data_all[$ts][] = $data;
										 
										}
										
										
										if($page_periode == 0){
											
										}else{
											$objPHPExcel->createSheet($page_periode);
										}
									
										$objPHPExcel->setActiveSheetIndex($page_periode)
												->setCellValue('A1', 'Channel')
												->setCellValue('B1', 'TIME')
												->setCellValue('C1', 'VIEWERS');
										
										$int_data = 2;
										foreach($list as $lists){
											
											$objPHPExcel->setActiveSheetIndex($page_periode)
												->setCellValue('A'.$int_data, $lists['CHANNEL'])
												->setCellValue('B'.$int_data, $lists['MINUTES'])
												->setCellValue('C'.$int_data, intval($lists['VIEWERS']));
											
											$objPHPExcel->getActiveSheet()->setTitle($lists['CHANNEL']); 
											$int_data++;
										}
										
										$objPHPExcel->setActiveSheetIndex($page_periode);
										
										$page_periode++;
										
										 
										
 										

										$ich++;
									}
									
									
 									
									$ts++;
							
						}
	 
	  
	  $objPHPExcel->setActiveSheetIndex(0);
	  
	  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	 
		
		$objWriter->save('/var/www/html/tmp_doc/viewing_pattern.xls');
	 
	  
	
  }  
  
  public function list_charttvcc()
	{	                
    if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $start_date = $this->Anti_si($_POST['start_date']);
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
         
          $end_date = $this->Anti_si($_POST['end_date']);
      } else {
          $end_date = NULL;
      }
	  
	  if( ! empty($this->Anti_si($_POST['days'])) ) {
         
          $days = $this->Anti_si($_POST['days']);
      } else {
          $days = NULL; 
      }
      
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($this->Anti_si($_POST['program'])) ) {
          $program = str_replace("AND","&",$this->Anti_si($_POST['program']));
      } else {
          $program = "0";
      }
      
      
      if( ! empty($this->Anti_si($_POST['channel'])) ) {
          $channel = $this->Anti_si($_POST['channel']);
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
	  
			$date_start = date_create($start_date);
			$date_end = date_create($end_date);
			
			$month =  date_format($date_start,"m");
			$year = date_format($date_start,"Y");
			$date = date_format($date_start,"d");
			$date_n = date_format($date_end,"d");
			$end_date_m = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	  
	   if($_POST['channel'] == "0"){
			$f = $this->tvcc_model->channelsearch2("",$genre,$start_date,$end_date);
			$cin = "";
			 $cin2 = "";
		
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f['CHANNEL']."',";
				$cin2 = $cin2.$channel_f['CHANNEL'].",";
			}
			
 			
			$new_cin2 = substr($cin2, 0, -1);
			$new_cin = substr($cin, 0, -1);
			
			$hhh = explode(",",$new_cin);
		} else {
			$cin = "";
			 $cin2 = "";
			foreach($_POST['channel'] as $channel_f){
				$cin = $cin."'".$channel_f."',";
				
				 $cin2 = $cin2.$channel_f.",";
			}
			
			$new_cin2 = substr($cin2, 0, -1);
			$new_cin = substr($cin, 0, -1);
			
			$hhh = $_POST['channel'];
		} 
      
       $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['days']		= $days;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['channel_list']		= $new_cin;
      $params['program']		= str_replace("AND","&",$program);
	  $params['cgroup'] 		= 'viewers';
      
 
      $arr_tvcc = [];
	  $all_data = array();
	  $all_data_all = array();
	  
	    $arr_datex = $this->returnBetweenDates( $params['start_date'], $params['end_date']);
		  
		$array_colors = ['000000','FF0000','FFFF00','808000','00FF00','00FFFF','0000FF','FF00FF','800000','808080','800080','000080'];
		$array_color = [];
		
		$tr = 0;
		  foreach( $hhh	as $chn){
			  $array_color[] = $this->generateColor($tr);
			  $tr++;
		  }
		  
		$ts = 0;
		$arr_dates = '';
	    $ich = 0;
			

						if( ($date == '01' && $date_n == $end_date_m && $_POST['channel'] == "0" ) || $_POST['channel'] == "0"){	

							$clr = $array_colors[0];

								$list = $this->tvcc_model->list_charttvcc_all($params,$params['start_date']);

								unset($data);
								$data = array();
								
								$ic = 0;
								$cur_prog = '';
								$cur_color = '';
								
								if(count($list['data']) == 0){

								}else{
								
									foreach ( $list['data'] as $kk[$ts] ) { 				
										
										$data['FULL_PROG'][] = $kk[$ts]['FULL_PROG'];
 										$data['CHANNEL'][] = "ALL CHANNEL";
										$data['TIME'][] = $kk[$ts]['MINUTES'];
										$data['PROGRAM'][] = $cur_prog;
										$data['COLOR'][] = '#'.$clr;
										$data['VIEWER'][] = intval($kk[$ts]['VIEWERS']);
										
										$ic++;
									}	
											
									$all_data_all[$ts][] = $data;
								 
								}

								$ich++;
							
							
						}else{
							
							foreach( $hhh	as $chn){
								
								if($ich < 12 ){
										
											$clr = $array_colors[$ich];
											
										}else{
											$clr = $this->generateColor($ich);
										}
							  
								$list = $this->tvcc_model->list_charttvcc($params,$chn,$params['start_date']);
								
 
								unset($data);
								$data = array();
								
								$ic = 0;
								$cur_prog = '';
								$cur_color = '';
								 
								
								if(count($list) == 0){
									
										
								}
                                else{
								
									foreach ( $list as $kk[$ts] ) { 
																
										$data['FULL_PROG'][] = $kk[$ts]['FULL_PROG'];
										$data['CHANNEL'][] = $kk[$ts]['CHANNEL'];
										$data['TIME'][] = $kk[$ts]['MINUTES'];
										$data['PROGRAM'][] = $cur_prog;
										$data['COLOR'][] = '#'.$clr;
										$data['VIEWER'][] = intval($kk[$ts]['VIEWERS']);
										
										$ic++;
									}	
											
									$all_data_all[$ts][] = $data;
								 
								}

								$ich++;
							}
						}

			
			
			$ts++;
	
	  
      $result["data"] = $all_data_all;	 	
	  $result["date"] = $start_date;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }  
  
  function generateColor($tr) {
	  $length = 6;
	$str = "";
	$characters = array_merge(range('A','F'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = $tr + 16;
		$str .= $characters[$rand];
	}
	return $str;
}
  
  public function list_charttvcc2()
	{	                
    if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $start_date = $this->Anti_si($_POST['start_date']);
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
         
          $end_date = $this->Anti_si($_POST['end_date']);
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($this->Anti_si($_POST['program'])) ) {
          $program = str_replace("AND","&",$this->Anti_si($_POST['program']));
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($this->Anti_si($_POST['channel'])) ) {
          $channel = $this->Anti_si($_POST['channel']);
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
       $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
	  $params['cgroup'] 		= $_POST['cgroup'];
 
      $arr_tvcc = [];
      
      
      
      $list = $this->tvcc_model->list_charttvcc2($params);
              $data = array();
		
		
		if($params['cgroup'] == 'viewers'){
			
			$ss = 'VIEWERS';
			
		}elseif($params['cgroup'] == 'total_views'){
			
			$ss = 'TOTAL_VIEWS';
		}else{
			$ss = 'DURASI';
		}
		
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['SEGMENT'],					
                    $v[$ss]
                )
            );
        }	
 	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }  
  
                                                                    
    
  public function genresearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->tvcc_model->genresearch($this->Anti_si($_GET['q']),$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                                                                        
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->profilesearch($this->Anti_si($_GET['q']),$iduser,$this->Anti_si($_GET['f']));
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }          
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->list_profile($iduser,"",$this->Anti_si($_GET['f']));          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                     
    
	 
	public function programsearch(){
       $params['channel'] = str_replace("AND","&",$this->Anti_si($_GET['q']));
      
	   $sec1 = strtotime($this->Anti_si($_GET['d'])); 
       $params['start_date'] = date("Y-m-d", $sec1); 
	   
	   $sec1 = strtotime($this->Anti_si($_GET['de'])); 
       $params['end_date'] = date("Y-m-d", $sec1); 
	  
	  $list = $this->tvcc_model->programsearch($params);
	  
       
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }  
	
  public function channelsearch(){
       $genre = str_replace("AND","&",$this->Anti_si($_GET['g']));
      $list = $this->tvcc_model->channelsearch($this->Anti_si($_GET['q']),$genre);
      
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
      
      $daypart = $this->tvcc_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}