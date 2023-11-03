<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Channelmigration2 extends JA_Controller {
    public function __construct(){
        parent::__construct();			
        $this->load->model('channelmigration_model');
    }
	
    public function index(){
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
        
        $data['profile'] = $this->channelmigration_model->get_profile3($iduser,$idrole,"");
        $data['channels'] = $this->channelmigration_model->get_channel(); 
        $data['currdate'] = date('d/m/Y');
        $this->template->load('maintemplate', 'channelmigration2/views/Channelmigration_view', $data);
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
        $param['profile']	= $this->input->post('profileselect');
        
        $list = $this->channelmigration_model->list_program($param);
        
		
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
        
        $this->json_result($result);
    }
	
  	public function list_migration(){
        if( !empty($_GET['start_date']) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($_GET['profile']) ) {
            $profiles = $_GET['profile'];
        } else {
            $profiles = "0";
        }
        
        if( !empty($_GET['channel']) ) {
            $channel = $_GET['channel'];
        } else {
            $channel = NULL;
        }
        
        if( !empty($_GET['program']) ) {
            $program = str_replace("`ht`","#",$_GET['program']);
        } else {
            $program = NULL;
        }
        
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
        
        $params['limit'] 		= (int) $length;
        $params['offset'] 		= (int) $start;
        $params['order_column'] = $order_fields[$order_column];
        $params['order_dir'] 	= $order_dir;
        $params['filter'] 		= $search_value;
        $params['start_date'] 	= $start_date;
        $params['profiles']	= $profiles;
        $params['channel']	= $_GET['channel'];
        $params['program']	= str_replace("`ht`","#",$_GET['program']);
        
        $list = $this->channelmigration_model->list_migration($params);
        
        $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
        	
        foreach ( $list['data'] as $k => $v ) {
            $n = $v['GAIN']-$v['LOSS'];
            
            if($v['GAIN']-$v['LOSS'] < 0){
                $net = "<span style='color:red'>".number_format($n, 0, ",", ".")."<span>";
            }else{
                $net = "<span style='color:green'>".number_format($n, 0, ",", ".")."<span>";
            }
            
            array_push($data, 
                array(
                    $v['SPLIT_MINUTES'],
                    $v['CHANNEL'],	
                    $v['PROGRAM'],					
                    "<p style='text-align:right'>".number_format($v['TVR'], 2, ",", ".")."</p>",
                    "<p style='text-align:right'>".number_format($v['GAIN'], 0, ",", ".")."</p>",
                    "<p style='text-align:right'>".number_format($v['LOSS'], 0, ",", ".")."</p>",
                    "<p style='text-align:right'>".$net."</p>",
                    $v['CONT_CHANNEL']."-".$v['CONT_PROGRAM'],
                    $v['BEN_CHANNEL']."-".$v['BEN_PROGRAM']
                )
            );
        }	
        
        $result["data"] = $data;
        $this->json_result($result);	
  	}	
  
    public function list_chartcm(){	
        if( !empty($_GET['start_date']) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($_GET['profile']) ) {
            $profiles = $_GET['profile'];
        } else {
            $profiles = "0";
        }
        
        if( !empty($_GET['channel']) ) {
            $channel = $_GET['channel'];
        } else {
            $channel = NULL;
        }
        
        if( !empty($_GET['program']) ) {
            $program = str_replace("`ht`","#",$_GET['program']);
        } else {
            $program = NULL;
        }
        
        $params['start_date'] 	= $start_date;
        $params['profiles']	= $profiles;
        $params['channel']	= $channel;
        $params['program']	= $program;
        $data['chartcm'] = $this->channelmigration_model->list_chartmigration($params);
        
        $cnt_list = count($data['chartcm']);
        
        $data_awal =  $data['chartcm'][0];
        $data_akhir = $data['chartcm'][$cnt_list-1];
        
        $st_rt = $data_awal['TVR']-$data_akhir['TVR'];   
        
        $result["data"] = $data;
        $result['st_rt'] = $st_rt;
        $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  	}
  
    public function list_summarycm(){	
        if( !empty($_GET['start_date']) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($_GET['profile']) ) {
            $profiles = $_GET['profile'];
        } else {
            $profiles = "0";
        }
        
        if( !empty($_GET['channel']) ) {
            $channel = $_GET['channel'];
        } else {
            $channel = NULL;
        }
        
        if( !empty($_GET['program']) ) {
            $program = str_replace("`ht`","#",$_GET['program']);
        } else {
            $program = NULL;
        }        
        
        $params['start_date'] = $start_date;
        $params['profiles']   = $profiles;
        $params['channel']    = $channel;
        $params['program']	= $program;  
        
        $data['summ'] = $this->channelmigration_model->summ_tvr($params);
        $data['summ_beneficial'] = $this->channelmigration_model->summ_beneficial($params);
        $data['summ_contributor'] = $this->channelmigration_model->summ_contributor($params);
        
        $result["data"] = $data;
        $this->output->set_content_type('Application/json')->set_output(json_encode($result));
    }
  
    public function list_migration_sub(){	
        if( !empty($_GET['start_date']) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $_GET['start_date']);
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($_GET['channel']) ) {
            $channel = $_GET['channel'];
        } else {
            $channel = NULL;
        }
        
        if( !empty($_GET['program']) ) {
            $program = str_replace("`ht`","#",$_GET['program']);
        } else {
            $program = NULL;
        }
        
        if( !empty($_GET['profile']) ) {
            $profiles = $_GET['profile'];
        } else {
            $profiles = NULL;
        }
        
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
        
        $params['limit'] 		= (int) $length;
        $params['offset'] 		= (int) $start;
        $params['order_column'] = $order_fields[$order_column];
        $params['order_dir'] 	= $order_dir;
        $params['filter'] 		= $search_value;
        $params['start_date'] 	= $start_date;
        $params['channel']	= $_GET['channel'];
        $params['program']	= str_replace("`ht`","#",$_GET['program']);
        $params['profiles']	= 	$profiles; 
        
        $list = $this->channelmigration_model->list_migration_sub($params);
        
        $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();	
        foreach ( $list['data'] as $k => $v ) {
            $n = $v['GAIN']-$v['LOSS'];
            
            if($v['GAIN']-$v['LOSS'] < 0){
                $net = "<span style='color:red'>".number_format($n, 0, ",", ".")."<span>";
            }else{
                $net = "<span style='color:green'>".number_format($n, 0, ",", ".")."<span>";
            
            }
            
            array_push($data, 
                array(
                    $v['CHANNEL'],	
                    $v['PROGRAM'],					
                    "<p style='text-align:right'>".number_format($v['TVR']*100, 2, ",", ".")."</p>",
                    "<p style='text-align:right'>".number_format($v['GAIN'], 0, ",", ".")."</p>",
                    "<p style='text-align:right'>".number_format($v['LOSS'], 0, ",", ".")."</p>",
                    "<p style='text-align:right'>".$net."</p>",
                )
            );
        }	
        
        $result["data"] = $data;
        $this->json_result($result);	
  	}                                                                     
    
    public function profilesearch(){
        $iduser = $this->session->userdata('user_id');
        $list = $this->channelmigration_model->profilesearch($_GET['q'],$iduser,$_GET['f']);
        
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
        $list = $this->channelmigration_model->get_profile3($iduser,$idrole,$_GET['f']);          
                                 
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }                        
    
    public function channelsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->channelmigration_model->channelsearch($_GET['q'],$_GET['d'],$_GET['p'],$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
    
    public function listsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->channelmigration_model->listsearch($_GET['q'],$_GET['d'],$_GET['c'],$_GET['p'], $typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }                
}