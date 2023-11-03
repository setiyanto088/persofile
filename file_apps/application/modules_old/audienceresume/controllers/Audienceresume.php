<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audienceresume extends CI_Controller {
  public function __construct()
	{
      parent::__construct();			
      $this->load->model('audience_model');
      $this->load->model('createprofileu/createprofileu_model');
	 
	  
	}
	
	public function index(){
      $id = $this->session->userdata('project_id');
      $iduser = $this->session->userdata('user_id');
      
	 $test_prod = $this->audience_model->test_new();
	   
	  
      if($id == null){
          $id = 0;
      }else{
          $id = $this->session->userdata('project_id');
      }
      if(!$this->session->userdata('user_id')) {
          redirect ('/login');
      }
      
      $data['profile'] = $this->audience_model->list_profile();
      $data['daypart'] = $this->audience_model->list_daypart($iduser);
	  $data['channels'] = $this->audience_model->get_channel(); 
      
      $typerole = $this->session->userdata('type_role');
      $data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
      $data['currdate'] = $this->audience_model->current_date();
      
      $this->template->load('maintemplate', 'audienceresume/views/audience_view', $data);
	}
	
	
	public function list_audience(){	    
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
	  $list = $this->audience_model->list_audience($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                   $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

	public function list_audience_reg(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

     
      
	  $list = $this->audience_model->list_audience_reg($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                   '0'.$v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_witel(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

     
      
	  $list = $this->audience_model->list_audience_witel($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                   $v['RANK'],
                   $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

public function list_audience_datel(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

     
      
	  $list = $this->audience_model->list_audience_datel($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                   $v['RANK'],
                   $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

	public function list_audience_sto(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

     
      
	  $list = $this->audience_model->list_audience_sto($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                   $v['RANK'],
                   $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

	public function list_audience_city(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

     
      
	  $list = $this->audience_model->list_audience_city($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_comm(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

 	       
      
	  $list = $this->audience_model->list_audience_comm($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		
		 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	
		public function list_audience_web(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

   
      
	  $list = $this->audience_model->list_audience_web($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_audience_ses(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

      
	  $list = $this->audience_model->list_audience_ses($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_audience_arpu(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    	  $list = $this->audience_model->list_audience_arpu($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_house(){	
     
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

     
	  $list = $this->audience_model->list_audience_house($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_digi(){	
     
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

          
	  $list = $this->audience_model->list_audience_digi($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_age(){	
     
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    	  $list = $this->audience_model->list_audience_age($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
 
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	
	public function list_audience_gender(){	
    
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

         
	  $list = $this->audience_model->list_audience_gender($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_persona(){	
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

         
	  $list = $this->audience_model->list_audience_persona($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['RANK'],
                    $v['SEGMENT'],					
                   number_format($v['VIEWERS'], 0, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	

	public function list_chart_audience_sto(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
	  $list = $this->audience_model->list_chart_audience_sto($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

	public function list_chart_audience_datel(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
	  $list = $this->audience_model->list_chart_audience_datel($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}	
	
public function list_chart_audience_witel(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
	  $list = $this->audience_model->list_chart_audience_witel($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_reg(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
	  $list = $this->audience_model->list_chart_audience_reg($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_chart_audience_web(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
	  $list = $this->audience_model->list_chart_audience_web($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
				public function list_chart_audience_ses(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
      
	  $list = $this->audience_model->list_chart_audience_ses($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	 	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
			public function list_chart_audience_arpu(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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


    
      
	  $list = $this->audience_model->list_chart_audience_arpu($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   	 	$v['VIEWERS']
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
		public function list_chart_audience_house(){	
     
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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


    
      
	  $list = $this->audience_model->list_chart_audience_house($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_digi(){	

      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
      
	  $list = $this->audience_model->list_chart_audience_digi($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   	 	$v['VIEWERS']
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
		public function list_chart_audience_age(){	
    
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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


	  $list = $this->audience_model->list_chart_audience_age($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_gender(){	
 
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
    
      
	  $list = $this->audience_model->list_chart_audience_gender($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERS']
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_personas(){	

      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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


    
      
	  $list = $this->audience_model->list_chart_audience_personas($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERS']
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
		public function list_chart_audience_comm(){	

      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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

    
      
	  $list = $this->audience_model->list_chart_audience_comm($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
					 	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_city(){	

      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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


    
      
	  $list = $this->audience_model->list_chart_audience_city($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
					 	$v['VIEWERS']
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience(){	
      
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
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
      
	  $list = $this->audience_model->list_chart_audience($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERS']
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_chart_audience324(){	
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($_POST['stime']) ) {
          $start_time = $_POST['stime'];
      } else {
          $start_time = NULL;
      }
      
      if( !empty($_POST['etime']) ) {
          $end_time = $_POST['etime'];
      } else {
          $end_time = NULL;
      }
      
      if( !empty($_POST['tvs']) ) {
          $tvs = $_POST['tvs'];
      } else {
          $tvs = NULL;
      }
      
      if( !empty($_POST['tvr']) ) {
          $tvr = $_POST['tvr'];
      } else {
          $tvr = NULL;
      }
      
      if( !empty($_POST['viewers']) ) {
          $viewers = $_POST['viewers'];
      } else {
          $viewers = NULL;
      }
      if( !empty($_POST['group']) ) {
          $group = $_POST['group'];
      } else {
          $group = NULL;
      }
      
      if( !empty($_POST['subgroup']) ) {
          $subgroup = $_POST['subgroup'];
      } else {
          $subgroup = NULL;
      }
      
      $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['start_date'] 	= $start_date;
      $params['tvs']		= $tvs;
      $params['tvr']		= $tvr;
      $params['viewers']		= $viewers;
      $params['group']		= $group;
      $params['group2']		= '';
      $params['subgroup']		= $subgroup;
      
      foreach($group as $helix){     
          $helix = str_replace("GENDER","DEM_GENDER_PRED",$helix);
          $helix = str_replace("HOUSEHOLD_COMM_EXPENSE","HOUSEHOLD_PROFILE",$helix);
          
          $HELIX_PROF = EXPLODE("=",$helix);
          $list_id = "";
          
          if(count($HELIX_PROF) < 2){
          
          } else {
              $list_KO = $this->audience_model->list_audience($params,$list_id,$HELIX_PROF);
              $arr_data[] =  $list_KO;
          }
      }
      
      if ($arr_data){
          $data = array();
          
          foreach ( $arr_data as $k => $v ) {
              array_push($data, 
                  array(
                      $v['data'][0]['FIELD'],	
                      $v['data'][0]['SEGMENT'],
                      round($v['data'][0]['ANTV'],2),
                      round($v['data'][0]['IVM'],2),
                      round($v['data'][0]['KOMPASTV'],2),
                      round($v['data'][0]['METRO'],2),
                      round($v['data'][0]['NET'],2),
                      round($v['data'][0]['OCHNL'],2),
					  round($v['data'][0]['SCTV'],2),
                      round($v['data'][0]['TRANS'],2),
                      round($v['data'][0]['TRANS7'],2),
                      round($v['data'][0]['TVONE'],2),
                      round($v['data'][0]['TVRI'],2)
                  )
              );
          }	
      }
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_new(){	
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($_POST['stime']) ) {
          $start_time = $_POST['stime'];
      } else {
          $start_time = NULL;
      }
      
      if( !empty($_POST['etime']) ) {
          $end_time = $_POST['etime'];
      } else {
          $end_time = NULL;
      }
      
      if( !empty($_POST['tvs']) ) {
          $tvs = $_POST['tvs'];
      } else {
          $tvs = NULL;
      }
      
      if( !empty($_POST['tvr']) ) {
          $tvr = $_POST['tvr'];
      } else {
          $tvr = NULL;
      }
      
      if( !empty($_POST['viewers']) ) {
          $viewers = $_POST['viewers'];
      } else {
          $viewers = NULL;
      }
      
      if( !empty($_POST['group2']) ) {
          $group = $_POST['group2'];
      } else {
          $group = NULL;
      }
      
      if( !empty($_POST['subgroup']) ) {
          $subgroup = $_POST['subgroup'];
      } else {
          $subgroup = NULL;
      }
      
      $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['start_date'] 	= $start_date;
      $params['tvs']		= $tvs;
      $params['tvr']		= $tvr;
      $params['viewers']		= $viewers;
      $params['group']		= $group;
      
      $HELIX_PROF = EXPLODE("=",$group);
      $list_id = $this->audience_model->get_listid($params,$HELIX_PROF);
      $arr_id = '';
      
      foreach($list_id as $ass){
          $arr_id = $arr_id.'"'.$ass['people'].'",';		
      }
      
      $clean_arr = substr($arr_id, 0, -1);
      
      $list_KO = $this->audience_model->list_audience($params,$clean_arr,$HELIX_PROF);
      
      $arr_data[] =  $list_KO;
      
      if ($arr_data){
          $data = array();
          
          foreach ( $arr_data as $k => $v ) {
              array_push($data, 
                  array(
                      $v['data'][0]['FIELD'],	
                      $v['data'][0]['SEGMENT'],
                      round($v['data'][0]['ANTV'],2),
                      round($v['data'][0]['IVM'],2),
                      round($v['data'][0]['KOMPASTV'],2),
                      round($v['data'][0]['METRO'],2),
                      round($v['data'][0]['OCHNL'],2),
					  round($v['data'][0]['NET'],2),
                      round($v['data'][0]['SCTV'],2),
                      round($v['data'][0]['TRANS'],2),
                      round($v['data'][0]['TRANS7'],2),
                      round($v['data'][0]['TVONE'],2),
                      round($v['data'][0]['TVRI'],2)
                  )
              );
          }	
      }
      
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}               
  
      public function list_program(){
        
        if(empty($_POST)){
            $result = array(
                'success' => false,
                'message' => 'Error retrieving list program'
            );
            
            $this->json_result($result);
        }
        
        $param['channel']	= $this->input->post('valselect');
        $param['date']	= $this->input->post('dateselect');
      
        
        $list = $this->audience_model->list_program($param);
		
        
        if ( $list ) {
            $result = array(
                'success' => true,
                'data' => $list
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'Data not found'
            );
        } 
        
		 $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }
  
  
   public function listsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->audience_model->listsearch($_GET['q'],$_GET['d'],$_GET['c'], $typerole);
		
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
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
      
      $daypart = $this->audience_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}