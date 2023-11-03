<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listtvpc extends CI_Controller {
  public function __construct()
	{
      parent::__construct();			
      $this->load->model('audience_model');
      $this->load->model('createprofileu/createprofileu_model');
	 
	  
	}
	
	public function channelsearch(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->audience_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
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
	  $data['channels'] = $this->audience_model->list_channel(); 
      
	  
      $typerole = $this->session->userdata('type_role');
      $data['listparent'] = $this->audience_model->listdataprofilenew($typerole);
      $data['currdate'] = $this->audience_model->current_date();
	  $data['channel'] = $this->audience_model->list_channel();
	  $params['user_id'] = $iduser;
	  $data['preset'] = $this->audience_model->load_channels($params);
	  
	  $menu = array(
				'items' => array(),
				'parents' => array() 
			);
	  
	  $result = $this->audience_model->tree1();
			
			foreach ($result as $items)
				{
				$menu['items'][$items['ID']] = $items;
				$menu['parents'][$items['PARENTID']][] = $items['ID'];
				}
            
            $result["data"] = $menu;
    
			$data['tree_s'] = $this->_build_menu(0, $result["data"]);
      
      $this->template->load('maintemplate', 'listtvpc/views/audience_view', $data);
	}
	
		function generate_html() {
		return $this->_build_menu(0, $this->menu_data['data']);
	}
	
	function _build_menu($parent, $menu)
	{
	   $html = '';
	   if (isset($menu['parents'][$parent]))
	   {
      $packageSeq = 0;
		   foreach ($menu['parents'][$parent] as $itemId)
		   {                 
			  if( ! isset($menu['parents'][$itemId]))
			  {
				  
				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","id" : "'.$menu['items'][$itemId]['VALUE'].'='.$menu['items'][$itemId]['FIELD'].'='.$menu['items'][$itemId]['PARENTFIELD'].'='.$menu['items'][$itemId]['PARENTDEFAULT'].'='.$menu['items'][$itemId]['LABEL'].'", "state" : { "opened" : false } }';
				
			  }
			  if( isset($menu['parents'][$itemId]) )
			  {                        

				$html .= '{"text" : "'.$menu['items'][$itemId]['LABEL'].'","state" : { "opened" : false } ,"children" : [ ';
				
				$html .= $this->_build_menu($itemId, $menu);
				
				$html .= ' ] }'; 
				
			  }   
		   }
	   }
	   
	   $htmls =str_replace("}{","},{",$html); 
	   
	   return $htmls;
	}
	
	
  
	public function cr_pp(){
		
		
		
		$params['id_user'] = $this->session->userdata('user_id');
		$params['list'] = $this->Anti_si($_POST['list']);
		$params['channel'] = $this->Anti_si($_POST['channel']);
		$params['preset'] = $this->Anti_si($_POST['preset']);
		$params['start_date'] = explode('/',$this->Anti_si($_POST['start_date']));
		$params['end_date'] = explode('/',$this->Anti_si($_POST['end_date']));
		$params['program'] = $this->Anti_si($_POST['program']);
		$params['daypart'] = $this->Anti_si($_POST['daypart']);
		$params['data'] = $this->Anti_si($_POST['data']);
		
		if($params['daypart'] == 'ALL'){
			$params['time_segment'][0] = "00:00:00";
			$params['time_segment'][1] = "23:59:59";
		}else{
			$params['time_segment'] = explode('-',$params['daypart']);
		}
		
		
		$genre_program = $this->audience_model->get_genre($params);
		
		
		if($params['preset'] == "0"){
			
			$params['channel'] = "";
			
			if($params['program'] == 'ALL,ALL' || ''){
				$params['w_program'] = ' ';
			}ELSE{
				$params['w_program'] = " AND GENRE_PROGRAM = '".$genre_program[0]['GENRE_PROGRAM']."' ";
			}
			
		}else{
			
			$preset_channel = $this->audience_model->channel_set($params['preset'],$params['id_user']);
			
			$preset_channels = explode(',',$preset_channel[0]['CHANNEL_LIST']);
			
			$channel_lists = "";
			foreach($preset_channels as $preset_channelss){
				
				$channel_lists .= "'".$preset_channelss."',";
				
			}
			
			$params['channel'] = " AND CHANNEL IN (".substr($channel_lists, 0, -1).") " ;

			
			$params['w_program'] = " AND GENRE_PROGRAM = '".$genre_program[0]['GENRE_PROGRAM']."' ";
		}

		$daypart2 = $this->audience_model->list_program_ss($params);
		
		
		$data = array();
		$ri = 1;
		foreach($daypart2 as $daypart2s){
			$datas = array();
			$datas['number'] = $ri;
			$datas['GENRE_PROGRAM'] = $daypart2s['GENRE_PROGRAM'];
			$datas['PROGRAM'] = $daypart2s['PROGRAM'];
			$datas['CHANNEL'] = $daypart2s['CHANNEL'];
			$datas['JAM_MULAI'] = $daypart2s['JAM_MULAI'];
			$datas['JAM_AKHIR'] = $daypart2s['JAM_AKHIR'];
			$datas['CNT'] = $daypart2s['CNT'];
			$datas['DATA'] = $daypart2s[strtoupper($params['data'])];
			$datas['AVGDATA'] = $daypart2s[strtoupper($params['data'])]/$daypart2s['CNT'];
			
			$data[]= $datas;
			$ri++;
		}
		
		 $result["data"]["table"] = '';	
		 $result["data"]["data"] = $data;	
		$this->output->set_content_type('Application/json')->set_output(json_encode($result)); 
		
	}
  
  	  public function save_channels()
	{
		$userid = $this->session->userdata('user_id');
		$params['save_channel_name'] =  $this->Anti_si($_POST['save_channel_name']);
		
		$channel_lists = explode(',', $this->Anti_si($_POST['channel']));
		
		$arr_ss = array_unique($channel_lists);
		
		
		$params['channel'] = implode(',', $arr_ss);
		$params['user_id'] = $userid;
		
		
		$daypart2 = $this->audience_model->save_channels($params);
		
		$daypart = $this->audience_model->load_channels($params);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		
		
		
	}
  
	function audience_export(){
		
		$ads =   $this->Anti_si($this->input->post('ads',true));
		
		$this->load->library('excel');
	   
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	    $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	    $data1 = explode('#',$ads);
	   
	    $it1 = 1;
		foreach($data1 as $data1s){
			
			$frt = explode("|", $data1s);
			
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt[0])
					->setCellValue('B'.$it1, $frt[1])
					->setCellValue('C'.$it1, $frt[2])
					->setCellValue('D'.$it1, $frt[3]);
			
			$it1++;
		}
		
	  
	   

		
		$objPHPExcel->getActiveSheet()->setTitle('Audience Analytics');
		$objPHPExcel->setActiveSheetIndex(0);

		


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_export.xls');
		
		
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
        $param['dateend']	= $this->Anti_si($this->input->post('dateend',true));
      
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['dateend']);
          $param['dateend'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['date']);
          $param['date'] = $date->format('Y-m-d');
	  
        
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
		
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['d']));
          $_GET['d'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['dend']));
          $_GET['dend'] = $date->format('Y-m-d');
		
        $list = $this->audience_model->listsearch($this->Anti_si($_GET['q']),$this->Anti_si($_GET['d']),$this->Anti_si($_GET['dend']),$this->Anti_si($_GET['c']), $typerole);
		
        
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
      
      $daypart = $this->audience_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}