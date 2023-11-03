<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvcc3dtv extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvcc_model');
	}


	public function load_channels()
	{
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		$daypart = $this->tvcc_model->load_channels($params);
      
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
		
		$daypart = $this->tvcc_model->save_channels($params);
      
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
		
		$data['profile'] = $this->tvcc_model->list_profile($iduser,$idrole,"");
		$data['channel'] = $this->tvcc_model->list_channel();    
    $data['daypart'] = $this->tvcc_model->list_daypart($iduser);  
    $data['currdate'] = $this->tvcc_model->current_date();
    $data['genre'] = $this->tvcc_model->list_channel_genre();
 
		$this->template->load('maintemplate', 'tvcc3dtv/views/tvcc_view', $data);
	}
	
	public function get_profile_id($profiles){
		$grouping_json = $this->tvcc_model->content_grouping($this->Anti_si($profiles)); 
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
	
	public function tvcc_export(){	     
 
  
      if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
	  
	  
      if( !empty($this->Anti_si($_POST['dpart'])) ) {
		  if($this->Anti_si($_POST['dpart']) == 'ALL'){
				$start_time = '00:00:00'; 
				$end_time = '23:59:59'; 
		  }else{
			  $listDaypart = explode(",",$this->Anti_si($_POST['dpart']));
			  
			  if(count($listDaypart) > 1){
				  $arrDaypart1 = explode("-",$listDaypart[0]);
				  $start_time = $arrDaypart1[0];
				  
				  $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
				  $end_time = $arrDaypart2[1];
			  } else {
				  $arrDaypart = explode("-",$this->Anti_si($_POST['dpart']));
				  
				  $start_time = $arrDaypart[0]; 
				  $end_time = $arrDaypart[1];
			  }
		  }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['profile'])) ) {
          $profiles = $this->Anti_si($_POST['profile']);
      } else {
          $profiles = 0;
      }   
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
      
      $order_fields = ['DATE','M1'];
      
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
      
      if( ! empty($this->Anti_si($_POST['cgroup'])) ) {
          $cgroup = $this->Anti_si($_POST['cgroup']);
      } else {
          $cgroup = NULL;
      }       
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
       $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
       $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
      $params['order_column'] = $order_fields[$order_column];
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profiles;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['cgroup']		= $cgroup;
   
	  
	   $list = $this->tvcc_model->list_tvcc($params);
	   
 	   
      $n_a = $list['data'];
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
       $paging_array = $n_a;
      
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
	  
	  $letters = array();
		$letter = 'C';
		while ($letter !== 'AAA') {
			$letters[] = $letter++;
		}
		
	 
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'DATE')
					->setCellValue('B1', 'TIME');
		
		
		$in = 0;
		foreach($params['channel'] as $n_as){
			$CHN = str_replace($n_as,"'","");
 			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letters[$in].'1', str_replace("'","",$n_as));
			$in++;
		}
	  
		$ints = 2;
		foreach($n_a as $dass){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ints, $dass['DATE']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ints, $dass['M1']);
			$in = 0;
			foreach($params['channel'] as $n_as){
				$CHN = str_replace($n_as,"'","");
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letters[$in].$ints, $dass[str_replace("'","",$n_as)]);
				$in++;
			}
			$ints++;
		}
		
		$objPHPExcel->setActiveSheetIndex(0);
	  
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	 
		$objWriter->save('C:\xampp56\htdocs\set\tvpc_export_dtv.xls');
 
     
  }
  
  public function list_tvcc(){	                
      if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
       if( !empty($this->Anti_si($_POST['dpart'])) ) {
		  if($this->Anti_si($_POST['dpart']) == 'ALL'){
				$start_time = '00:00:00'; 
				$end_time = '23:59:59'; 
		  }else{
			  $listDaypart = explode(",",$this->Anti_si($_POST['dpart']));
			  
			  if(count($listDaypart) > 1){
				  $arrDaypart1 = explode("-",$listDaypart[0]);
				  $start_time = $arrDaypart1[0];
				  
				  $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
				  $end_time = $arrDaypart2[1];
			  } else {
				  $arrDaypart = explode("-",$this->Anti_si($_POST['dpart']));
				  
				  $start_time = $arrDaypart[0]; 
				  $end_time = $arrDaypart[1];
			  }
		  }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['profile'])) ) {
          $profiles = $this->Anti_si($_POST['profile']);
      } else {
          $profiles = 0;
      }   
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = str_replace("AND","&",$this->Anti_si($_POST['genre']));
      } else {
          $genre = "0";
      }
      
      $order_fields = ['DATE','M1'];
	  // $channel = $_POST['channel'];
      
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
      
      if( ! empty($this->Anti_si($_POST['cgroup'])) ) {
          $cgroup = $this->Anti_si($_POST['cgroup']);
      } else {
          $cgroup = NULL;
      }       
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      //$order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
       $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
      $params['order_column'] = $order_fields[$order_column];
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profiles;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['cgroup']		= $cgroup;
 
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
          for($j=2; $j < count($new_array); $j++){ 
              if($cgroup == "viewers" || $cgroup == "total_viewers"){
                  $new_array[$j] = number_format($new_array[$j],0,",",".");
              } else {
                  $new_array[$j] = number_format($new_array[$j],2,",",".");
              }
          } 
          array_push($data,$new_array);
      } 
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }
  
  
   public function tooltip_program()
	{
		
		$params['profile'] = $this->Anti_si($_POST['profile']);
		$params['channel'] = $this->Anti_si($_POST['channel']);
		$params['time'] = $this->Anti_si($_POST['time']);
		
		$params['time_arr'] = explode('-',$params['time']);
		
		$list = $this->tvcc_model->tool_prog($params);
 
		
		$CHN = str_replace("&","AND",$list[0]['PROGRAM']);
		
		echo $CHN;
		
		
		
	}
  
  public function list_charttvcc()
	{	                
      if( ! empty($this->Anti_si($_POST['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
       if( !empty($this->Anti_si($_POST['dpart'])) ) {
		  if($this->Anti_si($_POST['dpart']) == 'ALL'){
				$start_time = '00:00:00'; 
				$end_time = '23:59:59'; 
		  }else{
			  $listDaypart = explode(",",$this->Anti_si($_POST['dpart']));
			  
			  if(count($listDaypart) > 1){
				  $arrDaypart1 = explode("-",$listDaypart[0]);
				  $start_time = $arrDaypart1[0];
				  
				  $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
				  $end_time = $arrDaypart2[1];
			  } else {
				  $arrDaypart = explode("-",$this->Anti_si($_POST['dpart']));
				  
				  $start_time = $arrDaypart[0]; 
				  $end_time = $arrDaypart[1];
			  }
		  }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($this->Anti_si($_POST['profile'])) ) {
          $profiles = $this->Anti_si($_POST['profile']);
      } else {
          $profiles = 0;
      }  
      
      if( ! empty($this->Anti_si($_POST['genre'])) ) {
          $genre = $this->Anti_si($_POST['genre']);
      } else {
          $genre = "0";
      }
      
      if( ! empty($this->Anti_si($_POST['channel'])) ) {
          $channel = $this->Anti_si($_POST['channel']);
      } else {
          $channel = "0";
      }
      
      if( ! empty($this->Anti_si($_POST['cgroup'])) ) {
          $cgroup = $this->Anti_si($_POST['cgroup']);
      } else {
          $cgroup = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $this->Anti_si($search = $this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
       $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
      $params['order_column'] = $order_fields[$order_column];
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profiles;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['cgroup']		= $cgroup;
 
      $arr_tvcc = [];
   
      
      $list = $this->tvcc_model->list_charttvcc($params);
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
      
      $data = $n_a; 
      
       $final_data = [];
      
      foreach($data as $datas){
          $has = 0;
          foreach($datas as $datass){
          
              $final_data[$has][] =  $datass;
              $has++;
          }
          
      }
	  
	    if($params['channel'] == "0"){
			$f = $this->tvcc_model->list_channel_by_genre($params['genre']);
			$cin = "";
			$cin2 = "";
			
			foreach($f as $channel_f){
				$cin = $cin."'".$channel_f['channel']."',";
				
				$cin2 = $cin2.$channel_f['channel'].",";
			}
			
			$new_cin2 = substr($cin2, 0, -1);
			$new_cin = substr($cin, 0, -1);
		} else {
			$f = $params['channel'];
			$cin = "";
			$cin2 = "";
			
			foreach($f as $channel_f){
				$cin = $cin.$channel_f.",";
				
				$cin2 = $cin2.$channel_f.",";
			}
			
			$new_cin2 = substr($cin2, 0, -1);
			$new_cin = substr($cin, 0, -1);
		}
	  
	   $hhh = explode(",",$new_cin2);
 	  
	  $arr_prog = array();
	  
	  foreach($hhh as $channels){
		  
		$list = $this->tvcc_model->tool_prog($params,str_replace("'","",$channels));
		$arr_prog[] = $list; 
		
	  }
	  
       
      $data['tvcc'] = $final_data;
	  $data['proglist'] = $arr_prog;
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