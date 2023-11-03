<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvpcresp22 extends JA_Controller {
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
		$this->template->load('maintemplate', 'tvpcresp22/views/tvpc_view', $data);
	}
  
	public function get_profile_id($profiles){
		$grouping_json = $this->tvpc_model->content_grouping($this->Anti_si($profiles));
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
    
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('rank','tanggal', 'program', 'channel', 'epg.genre','begin_time', 'end_time', 'toFloat32(TVS)', 'toFloat32(TVR)', 'toInt32(viewers)');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
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
		$params['profile']		= $profile;
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
		
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {      
			array_push($data, 
				array(
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
		
		$channel = str_replace("\'","'",$channel);
    
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