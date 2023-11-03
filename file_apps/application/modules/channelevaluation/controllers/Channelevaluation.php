<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Channelevaluation extends JA_Controller {
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
        
		$data['thn'] = $this->channelmigration_model->get_tahun();
        $data['profile'] = $this->channelmigration_model->get_profile3($iduser,$idrole,"");
        $data['channels'] = $this->channelmigration_model->get_channel(); 
        $data['currdate'] = $this->channelmigration_model->current_date();
        $this->template->load('maintemplate', 'channelevaluation/views/Channelmigration_view', $data);
    }

    public function list_program(){
        
        if(empty($_POST)){
            $result = array(
                'success' => false,
                'message' => 'Error retrieving list program'
            );
            
            $this->json_result($result);
        }
        
        $param['channel']	= $this->Anti_si($this->input->post('valselect',true));
        $param['date']	= $this->Anti_si($this->input->post('dateselect',true));
        $param['profile']	= $this->Anti_si($this->input->post('profile',true));
                                                
        $dt   = new DateTime();
        $date = $dt->createFromFormat('d/m/Y', $param['date']);
        $param['date'] = $date->format('Y-m-d');
        
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
        if( !empty($this->Anti_si($_GET['start_date'])) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['profile'])) ) {
            $profiles = $this->Anti_si($_GET['profile']);
        } else {
            $profiles = "0";
        }
        
		
        $ordernya = '';
        if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
        if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
        if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 
        $order_fields = array('date', 'channel', 'program', 'level1', 'level2', 'tvr', 'tvs', 'cprp', 'cost');
        
        $order = $this->input->get_post('order');
        if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
        if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
        
        $search = $this->Anti_si($this->input->get_post('search'));		
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
        $params['profiles']	= $profiles;
        
        $list = $this->channelmigration_model->list_migration($params);
		
		
        $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
        	
        foreach ( $list['data'] as $k => $v ) {
            
            if($v['RANK_GROWTH'] < 0){
                $RG = "<span style='color:red'>".$v['RANK_GROWTH']."<span>";
            }else{
                $RG = "<span style='color:green'>".$v['RANK_GROWTH']."<span>";
            }
			
			 
            if($v['TRAFFIC_UV'] < 0){
                $TUV = "<span style='color:red'><p style='text-align:right'>".number_format($v['TRAFFIC_UV'], 0, ",", ".")."</p><span>";
            }else{
				$TUV = "<span style='color:green'><p style='text-align:right'>".number_format($v['TRAFFIC_UV'], 0, ",", ".")."</p><span>";
            }
			
			 
            if($v['SHARE_GROWTH'] < 0){
                $SG = "<span style='color:red'>".$v['SHARE_GROWTH']."<span>";
            }else{
                $SG = "<span style='color:green'>".$v['SHARE_GROWTH']."<span>";
            }
			
			 
            if($v['TRAFFIC_TV'] < 0){
                $TTV = "<span style='color:red'><p style='text-align:right'>".number_format($v['TRAFFIC_TV'], 0, ",", ".")."</p><span>";
            }else{
				$TTV = "<span style='color:green'><p style='text-align:right'>".number_format($v['TRAFFIC_TV'], 0, ",", ".")."</p><span>";
            }
            
            array_push($data, 
                array(
                    $v['CHANNEL_NAME_PROG'], 
                    $v['CHANNEL_NUMBER'],	
                    $v['QUALITY'],			
					$v['RANK'],			
					$RG,					
					$TUV,
                    "<p style='text-align:right'>".number_format($v['UNIQUE_VIEWER'], 0, ",", ".")."</p>",
					"<p style='text-align:right'>".number_format($v['VIEWERS_SHARE']*100, 2, ",", ".")." % </p>",
					$SG,
                    $TTV,
                    "<p style='text-align:right'>".number_format($v['TOTAL_VIEWERS'], 0, ",", ".")."</p>",
                    "<p style='text-align:right'>".number_format($v['TOTAL_DURATION'], 0, ",", ".")."</p>",
                    "<p style='text-align:right'>".number_format($v['AVG_DURATION'], 2, ",", ".")."</p>",
                    $v['PACKAGES'],
					$v['CATEGORY'],		
                    $v['GENRE'],
					$v['CHANNEL_REG']
                )
            );
        }	
        
        $result["data"] = $data;
        $this->json_result($result);	
  	}	
  
    public function list_chartcm(){	
        if( !empty($this->Anti_si($_GET['start_date'])) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['profile'])) ) {
            $profiles = $this->Anti_si($_GET['profile']);
        } else {
            $profiles = "0";
        }
        
        if( !empty($this->Anti_si($_GET['channel'])) ) {
            $channel = $this->Anti_si($_GET['channel']);
        } else {
            $channel = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['program'])) ) {
            if($this->Anti_si($_GET['program']) == 'All Program'){
				
					$program = 'All Program';
            
					$begin_program = "null";
				
			}else{
				
				    $program = str_replace("`ht`","#",$this->Anti_si($_GET['program'])); 
            
					$programArr = explode(" | ",$program);
					
					$program = $programArr[0];
					$begin_program = $programArr[1]; 
				
			}
        } else {
            $program = NULL;
        }
        
        $params['start_date'] 	= $start_date;
        $params['profiles']	= $profiles;
        $params['channel']	= $channel;
        $params['program']	= $program;
        $params['begin_program']	= $begin_program;
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
        if( !empty($this->Anti_si($_GET['start_date'])) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['profile'])) ) {
            $profiles = $this->Anti_si($_GET['profile']);
        } else {
            $profiles = "0";
        }
        
        if( !empty($this->Anti_si($_GET['channel'])) ) {
            $channel = $this->Anti_si($_GET['channel']);
        } else {
            $channel = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['program'])) ) {
             if($this->Anti_si($_GET['program']) == 'All Program'){
				
					$program = 'All Program';
            
					$begin_program = "null";
				
			}else{
				
				    $program = str_replace("`ht`","#",$this->Anti_si($_GET['program'])); #$_GET['program'];
            
					$programArr = explode(" | ",$program);
					
					$program = $programArr[0];
					$begin_program = $programArr[1]; 
				
			}
        } else {
            $program = NULL;
        }        
        
        $params['start_date'] = $start_date;
        $params['profiles']   = $profiles;
        $params['channel']    = $channel;
        $params['program']	= $program;
        $params['begin_program']	= $begin_program;
        
        $data['summ'] = $this->channelmigration_model->summ_tvr($params);
        $data['summ_beneficial'] = $this->channelmigration_model->summ_beneficial($params);
        $data['summ_contributor'] = $this->channelmigration_model->summ_contributor($params);
        
        $result["data"] = $data;
		
        $this->output->set_content_type('Application/json')->set_output(json_encode($result));
    }
  
    public function list_migration_sub(){	
        if( !empty($this->Anti_si($_GET['start_date'])) ) {
            $dt   = new DateTime();
            $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
            $start_date = $date->format('Y-m-d');
        } else {
            $start_date = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['channel'])) ) {
            $channel = $this->Anti_si($_GET['channel']);
        } else {
            $channel = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['program'])) ) {
            
            $programArr = explode(" | ",$this->Anti_si($_GET['program']));
            
            $program = $programArr[0];
            $begin_program = $programArr[1];
        } else {
            $program = NULL;
        }
        
        if( !empty($this->Anti_si($_GET['profile'])) ) {
            $profiles = $this->Anti_si($_GET['profile']);
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
        
        $search = $this->Anti_si($this->input->get_post('search'));		
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
        $params['program']	= $program;
        $params['begin_program']	= $begin_program;
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
    
    public function listsearch(){
        $typerole = $this->session->userdata('type_role');         
                                                
        $dt   = new DateTime();
        $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['d']));
        $searchDate = $date->format('Y-m-d');
        
        $list = $this->channelmigration_model->listsearch($this->Anti_si($_GET['q']),$searchDate,$this->Anti_si($_GET['c']),$this->Anti_si($_GET['p']), $typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }                                                                    
    
    public function profilesearch(){
        $iduser = $this->session->userdata('user_id');
        $list = $this->channelmigration_model->profilesearch($this->Anti_si($_GET['q']),$iduser,$this->Anti_si($_GET['f']));
        
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
        $list = $this->channelmigration_model->get_profile3($iduser,$idrole,$this->Anti_si($_GET['f']));          
                                 
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
    
    public function channelsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->channelmigration_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}