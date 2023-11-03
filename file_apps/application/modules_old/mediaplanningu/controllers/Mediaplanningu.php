<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mediaplanningu extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('mediaplanningu_model');
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
		if(!$this->session->userdata('user_id')) {
			redirect ('/login');
		}
		$data['profile'] = $this->mediaplanningu_model->get_profile3($iduser,$idrole,"");
		$data['channels'] = $this->mediaplanningu_model->get_channel(); 
    $data['currdate'] = $this->mediaplanningu_model->current_date();
		$this->template->load('maintemplate', 'mediaplanningu/views/Mediaplanningu_view', $data);
	}
  
	public function list_planning()
	{	
		if( !empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($_GET['cost']) ) {
			$cost = $_GET['cost'];
		} else {
			$cost = NULL;
		}	
		
		if( !empty($_GET['discount']) ) {
			$discount = $_GET['discount'];
		} else {
			$discount = 0;
		}	
		
		if( !empty($_GET['profile']) ) {			
			if($_GET['profile'] == "all"){
				$profiles = "0";
			}else{
				$profiles = $_GET['profile'];
			}
		} else {
			$profiles = "0";
		}
     
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];		
		$index = $_GET['index'];
		
		$ordernya = '';
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 
		$order_fields = array('date', 'channel', 'program', 'level1', 'level2', 'tvr', 'tvs', 'cprp', 'cost');
				
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->input->get_post('search');		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}	
			
		$cs = 0;
		if($high_tvr == 1){
			$cs = 4;
		}
     
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['discount']		= 100-$discount;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['channel']	= $_GET['channel']; 
		
		
		$list = $this->mediaplanningu_model->list_planning($params);

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) { 
				$cprp = number_format($v['CPRP'], 0, ",", ".");			
					$cost = $v['RATE']*1000;
					$tvs = $v['TVS'];
					$index = $v['IDX']*100;
			array_push($data, 
				array(
					$v['DATE'],
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					number_format($v['TVR']*100,2, ",", "."),
					number_format($tvs*100,2, ",", "."),
					$cprp,
					number_format($cost,0, ",", "."),
					number_format($index,0, ",", ".")
				)
			);
		}	
			
		$result["data"] = $data;
		$this->json_result($result);	
	}
	
	public function list_planning_sub()
	{	
		if( !empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($_GET['cost']) ) {
			$cost = $_GET['cost'];
		} else {
			$cost = NULL;
		}	
    
		if( !empty($_GET['profile']) ) {	
			if($_GET['profile'] == "all"){
				$profiles = "0";
			}else{
				$profiles = $_GET['profile'];
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($_GET['discount']) ) {
			$discount = $_GET['discount'];
		} else {
			$discount = 0;
		}	
    
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];			
		$index = $_GET['index'];		

		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('channel', 'program', 'program', 'spot', 'cost', 'tvr');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->input->get_post('search');		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_sub($params);

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {
			array_push($data, 
				array(
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$v['SPOT'],					
					$v['RATE'] = number_format($v['RATE']*1000,0, ",", "."),
					number_format($v['TVR']*100,2, ",", ".")			
				)
			);
		}	
	
		$result["data"] = $data;
		$this->json_result($result);	
	}

	public function list_planning_total()
	{	
		if( !empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($_GET['cost']) ) {
			$cost = $_GET['cost'];
		} else {
			$cost = NULL;
		}
    
    if( !empty($_GET['profile']) ) {
			if($_GET['profile'] == "all"){
				$profiles = "0";
			}else{
				$profiles = $_GET['profile'];
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($_GET['discount']) ) {
			$discount = $_GET['discount'];
		} else {
			$discount = 0;
		}	
				
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];		
		$index = $_GET['index'];		

		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('channel', 'spot', 'spot', 'cost', 'tvr');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->input->get_post('search');		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_total($params); 
		
    $sum = 0;

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {
			$sum+= $v['SPOT'];
			array_push($data, 
				array(
					$v['CHANNEL'],	
					$v['SPOT'],					
					$v['COSTS'] = number_format($v['COSTS']*1000,0, ",", "."),		
					number_format($v['TVRS']*100,2, ",", "."),
					$sum	
				)
			);
		}	
    
    $result["data"] = $data;
    $this->json_result($result);	
	}	
	
	public function list_planning_grandtotal()
	{	
    if( ! empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( ! empty($_GET['cost']) ) {
			$cost = $_GET['cost'];
		} else {
			$cost = NULL;
		}	
		
		if( !empty($_GET['profile']) ) {
			if($_GET['profile'] == "all"){
				$profiles = "0";
			}else{
				$profiles = $_GET['profile'];
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($_GET['discount']) ) {
			$discount = $_GET['discount'];
		} else {
			$discount = 0;
		}	
		
		
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];			
		$index = $_GET['index'];		

		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];

		$list = $this->mediaplanningu_model->list_planning_grandtotal($params);

		$spot = 0;
		$cost = 0;
		$tvr = 0;
		
		foreach ( $list as $k => $v ) {
			$spot+= $v['SPOT'];
			$cost+=  $v['RATE']*1000;			
			$tvr+= $v['TVR'];
		}
		
		$cost = number_format($cost, 0,",",".");
		
		$data = array(
					'spot' => $spot,
					'cost' => $cost,
					'tvr' => number_format($tvr*100,2,",",".")				
    );		

    $result = array('success' => true, 'data' => $data);
    $this->json_result($result);
	}	
	
	public function list_planning_rest()
	{	
		if( !empty($_GET['start_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($_GET['end_date']) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $_GET['end_date']);
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($_GET['cost']) ) {
			$cost = $_GET['cost'];
		} else {
			$cost = NULL;
		}	
		
    if( !empty($_GET['profile']) ) {
			if($_GET['profile'] == "all"){
				$profiles = "0";
			}else{
				$profiles = $_GET['profile'];
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($_GET['discount']) ) {
			$discount = $_GET['discount'];
		} else {
			$discount = 0;
		}	
    
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];			
		$index = $_GET['index'];		

		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_rest($params);

		$sum = 0;
		$cost = 0;
		$mincprp = 0;
		$cprp = 0;
		$total_tvr = 0;
		
		$tvr = array();
		$totaltvr = 0;
		
		if(count($list)==0){
        $data = array(
        		'maxtvr' => 0.00,
        		'mintvr' => 0.00,
        		'avgtvr' => 0.00,
            'cprp1'	=>	0
        );
		}else{ 
			foreach ( $list as $k => $v ) {
				$total_tvr += $v['TVR'];
				$tvr[$k] = $v['TVR']*100;
				$cost += $v['RATE']*1000;
				$totaltvr+= $v['TVR']*100; 
				$cprp += $v['CPRP'];
        
				$sum+= 1;
			}
			
			$data = array(
						'maxtvr' => number_format(max($tvr),2,",","."),
						'mintvr' => number_format(min($tvr),2,",","."),
						'avgtvr' => number_format($totaltvr/$sum,2,",","."),
            'cprp1'	=>	number_format($cost/$totaltvr,0,",","."),
				);	
		}
		
		$result = array('success' => true, 'data' => $data);
		$this->json_result($result);
	}		                                                                          
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->mediaplanningu_model->profilesearch($_GET['q'],$iduser,$_GET['f']);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                          
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $idrole = $this->session->userdata('id_role');
      $list = $this->mediaplanningu_model->get_profile3($iduser,$idrole,$_GET['f']);          
                               
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                  
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->mediaplanningu_model->channelsearch($_GET['q'],$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}