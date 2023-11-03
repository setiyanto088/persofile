<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvcc extends CI_Controller {
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
		$data['channel'] = $this->tvcc_model->list_channelas();
    		$data['daypart'] = $this->tvcc_model->list_daypart($iduser);
    		$data['currdate'] = $this->tvcc_model->current_date();

		$this->template->load('maintemplate', 'tvcc/views/tvcc_view', $data);
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
  
  public function list_tvcc(){	                
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['end_date']);
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($_POST['dpart']) ) {
          $listDaypart = explode(",",$_POST['dpart']);
          
          if(count($listDaypart) > 1){
              $arrDaypart1 = explode("-",$listDaypart[0]);
              $start_time = $arrDaypart1[0];
              
              $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
              $end_time = $arrDaypart2[1];
          } else {
              $arrDaypart = explode("-",$_POST['dpart']);
              
              $start_time = $arrDaypart[0]; 
              $end_time = $arrDaypart[1];
          }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($_POST['profile']) ) {
          $profiles = $_POST['profile'];
      } else {
          $profiles = 0;
      }                                            
      
      $order_fields = ['DATE','M1'];
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          for($i=0;$i < sizeof($channel);$i++){
              $order_fields[$i+2] = str_replace("'","",$channel[$i]);
          }
      } else {
          $channel = "0";
          $channel_array = $this->tvcc_model->channelsearch("","");
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      if( ! empty($_POST['cgroup']) ) {
          $cgroup = $_POST['cgroup'];
      } else {
          $cgroup = NULL;
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
      $params['channel']		= $channel;
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
              if($cgroup == "viewers"){
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
  
  public function list_charttvcc()
	{	                
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['end_date']);
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($_POST['dpart']) ) {
          $listDaypart = explode(",",$_POST['dpart']);
          
          if(count($listDaypart) > 1){
              $arrDaypart1 = explode("-",$listDaypart[0]);
              $start_time = $arrDaypart1[0];
              
              $arrDaypart2 = explode("-",$listDaypart[count($listDaypart) - 1]);
              $end_time = $arrDaypart2[1];
          } else {
              $arrDaypart = explode("-",$_POST['dpart']);
              
              $start_time = $arrDaypart[0]; 
              $end_time = $arrDaypart[1];
          }
      } else {
          $start_time = NULL; 
          $end_time = NULL;
      }
      
      if( ! empty($_POST['profile']) ) {
          $profiles = $_POST['profile'];
      } else {
          $profiles = 0;
      }
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
      } else {
          $channel = "0";
      }
      
      if( ! empty($_POST['cgroup']) ) {
          $cgroup = $_POST['cgroup'];
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
      $params['order_column'] = $order_fields[$order_column];
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profiles;
      $params['channel']		= $channel;
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
     
    $data['tvcc'] = $final_data;
    $result["data"] = $data;
     
    $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }                                                                            
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->profilesearch($_GET['q'],$iduser,$_GET['f']);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }   
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->list_profile($iduser,"",$_GET['f']);          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                             
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->tvcc_model->channelsearch($_GET['q'],$typerole);
      
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
      
      $daypart = $this->tvcc_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}