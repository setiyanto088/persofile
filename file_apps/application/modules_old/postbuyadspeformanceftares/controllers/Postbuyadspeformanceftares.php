<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Postbuyadspeformanceftares extends JA_Controller {
  public function __construct()
	{
  		parent::__construct();			
  		$this->load->model('postbuyadspeformance_model');
	}
	
	public function index()
  {
      $id = $this->session->userdata('project_id') ? $this->session->userdata('project_id') : 0;
      $iduser = $this->session->userdata('user_id');
      $idrole = $this->session->userdata('id_role');
      
      $data['profile'] = $this->postbuyadspeformance_model->get_profile($iduser,$idrole,"");
       
      $data['channel'] = $this->_list_channel();
      $data['channels'] = $this->postbuyadspeformance_model->get_channel();
      $data['currdate'] = $this->postbuyadspeformance_model->current_date();      
      
      $data['all_program'] = 
      array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
      );
      
      $data['all_iklan'] = 
      array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=187,202',
          'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=247,277',
          'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=1,120',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=13,28',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=28,43',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=43,58',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=73,88',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=88,103',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=103,133',
          'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=133,163'
      );	
      
      $this->template->load('maintemplate', 'postbuyadspeformanceftares/views/Postbuyadspeformance', $data);
  }
  
	public function list_subkategori()
	{			
      $_POST = json_decode(file_get_contents("php://input"), true);
      
      if(empty($_POST))
      {
          $result = array(
              'success' => false,
              'message' => 'Error retrieving list program'
          );
          
          $this->json_result($result);
      }
      
      $kategori	= $this->Anti_si($this->input->post('valselect',true));
      $profile = $this->Anti_si($_GET['profile']) ? $this->Anti_si($_GET['profile']) : 0;
      
      $params['kategori']		= $this->Anti_si($this->input->post('valselect',true));
      $params['profile']		= $profile;        
                                           
      $params['start_date']		= $this->Anti_si($this->input->post('start_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['start_date']);
      $params['start_date'] = $date->format('Y-m-d');
      
      $params['end_date']		= $this->Anti_si($this->input->post('end_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['end_date']);
      $params['end_date'] = $date->format('Y-m-d');
      
      $list = $this->postbuyadspeformance_model->_list_subkategori($params);
	  
       
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
  
	/* get load first list ads performance */
	public function get_list_adspeformance(){
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR', "TANGGAL, CHANNEL, START_TIME"); // , 'COST'
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] ;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
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
      
      $list = $this->postbuyadspeformance_model->list_adspeformance($params);
       
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      $data = array();	
      
      $idx = 0;
      
      $array_channel = $this->array_channel();
      $array_channel2 = $this->array_channel2();
      
      foreach ( $list['data'] as $k => $v ) {
          if(substr($v['START_TIME'], 4, 1) >= 5){
              $min_vid = 5;
          }else{
              $min_vid = 0;
          }
          
          $arr_hours = substr($v['START_TIME'], 0, 2).":".substr($v['START_TIME'], 3, 1)."".$min_vid.":00";
          $arr_date = str_replace("-","_",$v['TANGGAL']);
          $arr_path = "https://urbanrate.id/video/".$array_channel2[$v['CHANNEL']]."/".$arr_date."/";
          $arr_filename = $array_channel2[$v['CHANNEL']]."_".$arr_date."_". str_replace(":","_",$arr_hours).".mp4";
          
          $start_vid = strtotime($v['START_TIME']) - strtotime($arr_hours); 
          $array_duration = explode(":",$v['DURATION']);
          $end_vid = $start_vid + (($array_duration[0]*3600)+($array_duration[1]*60)+($array_duration[2]));
          
          $arr_vid_time = "#t=".$start_vid.",".$end_vid;
          array_push($data, 
              array(
                  "<button class='btn urate-play-btn btn-sm' style='cursor: pointer;margin-top:15px' data-id='".$v['PROGRAM']."' onclick='vid_program(&#39;".$arr_path."".$arr_filename."".$arr_vid_time."&#39;,&#39;".$v['PROGRAM']."&#39;,&#39;".$arr_path.$arr_filename."&#39;,".$start_vid.",".$array_duration[2].")' ></button>",
                  $v['TANGGAL'],
                  $v['CHANNEL'],			
                  $v['PROGRAM'],	
                  $v['PRODUCT'],
                  $v['ADVERTISER'],
                  $v['SECTOR'],
                  $v['START_TIME'],					
                  $v['DURATION'],
                  $v['ADS_TYPE'], 
                  number_format($v['TVR'],2,',','.'),
                   $v['VIEWERS']
              )
          );
          $idx++;
      }		
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
  
  	public function array_channel(){
      $array_channel = [
          "TRANS7" => "Channel01",
		  "TRANS 7" => "Channel01",
          "RCTI" => "Channel02",
          "SCTV" => "Channel03",
          "TRANSTV" => "Channel04",
		  "TRANS TV" => "Channel04",
          "GLOBAL" => "Channel05",
          "INDOSIAR" => "Channel06",
          "MNC" => "Channel07",
          "METRO" => "Channel08",
		  "METRO TV" => "Channel08",
          "TVONE" => "Channel09",
		  "TV ONE" => "Channel09",
          "ANTV" => "Channel10",
          "RTV" => "Channel12",
          "INEWS" => "Channel13" ,
          "CHANNELTV" => "Channel14",
          "NET" => "Channel15",
		  "NET TV" => "Channel15",
          "KOMPAS" => "Channel16",
          "KOMPASTV" => "Channel16",
		  "KOMPAS TV" => "Channel16",
          "IVM" => "Channel06",
          "TRANS" => "Channel04",
          "MNCTV" => "Channel07",
          "INEWSTV" => "Channel13",
          "GTV" => "Channel05",
          "OCHNL" => "Channel14",
          "CHANNEL" => "CHANNEL"
      ];
      
      return 	$array_channel;
	}
  
	public function array_channel2(){
      $array_channel = [
          "TRANS7" => "channel01",
		  "TRANS 7" => "channel01",
          "RCTI" => "channel02",
          "SCTV" => "channel03",
          "TRANSTV" => "channel04",
		  "TRANS TV" => "channel04",
          "GLOBAL" => "channel05",
          "INDOSIAR" => "channel06",
          "MNC" => "channel07",
          "METRO" => "channel08",
		  "METRO TV" => "channel08",
          "TVONE" => "channel09",
		  "TV ONE" => "channel09",
          "ANTV" => "channel10",
          "RTV" => "channel12",
          "INEWS" => "channel13" ,
          "CHANNELTV" => "channel14",
          "NET" => "channel15",
		  "NET TV" => "channel15",
          "KOMPAS" => "channel16",
          "KOMPASTV" => "channel16",
		  "KOMPAS TV" => "channel16",
          "IVM" => "channel06",
          "TRANS" => "channel04",
          "MNCTV" => "channel07",
          "INEWSTV" => "channel13",
          "GTV" => "channel05",
          "OCHNL" => "channel14",
          "CHANNEL" => "CHANNEL"
      ];
      
      return 	$array_channel;
	}
	
	public function get_filter_summ1(){
		 if( !empty($this->Anti_si($_GET['start_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['end_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['profile'])) ) {
          $profile = $this->Anti_si($_GET['profile']);
      } else {
          $profile = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_GET['kategori_by']);
      } else {
          $kategoriby = NULL;
      }	
      
      if( !empty($this->Anti_si($_GET['get_kategori'])) ) {
          $kategori = $this->Anti_si($_GET['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      
      if( !empty($this->Anti_si($_GET['chnl'])) ) {
          $chnl = $this->Anti_si($_GET['chnl']);
      } else {
          $chnl = "0";
      }
   
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('SPOT','TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR'); // , 'COST'
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
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
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']	= $kategori;
      $params['chnl']	= $chnl; 
	  $params['searchtxt'] = $_GET['search']['value'];
 
      if ($kategoriby == 'product') {
          $data['all_program'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
          $data['all_iklan'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=187,202',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=247,277',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=1,120',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=13,28',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=28,43',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=43,58',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=73,88',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=88,103',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=103,133',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=133,163'
          );	
      } elseif($kategoriby == 'advertiser'){
          $data['all_program'] = 
          array(	'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
         
      } elseif ($kategoriby == 'sector') {
          $data['all_program'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
         
      
      } else{}
      
       $list = $this->postbuyadspeformance_model->_get_filter_adspeformance_summ1($params);
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      $data = array();	
      
      $idx = 0;
      
      $array_channel = $this->array_channel();
      $array_channel2 = $this->array_channel2();
      
      foreach ( $list['data'] as $k => $v ) {
          
          array_push($data, 
              array(
                  $v['CHANNEL'],
                  $v['PROGRAM'],	
                  number_format(($v['SPOT']),0,',','.'),
                  number_format(($v['COST']*1000),2,',','.'),
				  number_format($v['TVR_ALL'],2,',','.')
              )
          );
          $idx++;
      }		
      $result["data"] = $data;
      
      $this->json_result($result);
	}
	
	public function get_filter_summ2(){
		 if( !empty($this->Anti_si($_GET['start_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['end_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['profile'])) ) {
          $profile = $this->Anti_si($_GET['profile']);
      } else {
          $profile = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_GET['kategori_by']);
      } else {
          $kategoriby = NULL;
      }	
      
      if( !empty($this->Anti_si($_GET['get_kategori'])) ) {
          $kategori = $this->Anti_si($_GET['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      
      if( !empty($this->Anti_si($_GET['chnl'])) ) {
          $chnl = $this->Anti_si($_GET['chnl']);
      } else {
          $chnl = "0";
      }
 
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('SPOT','TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR'); // , 'COST'
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
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
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']	= $kategori;
      $params['chnl']	= $chnl; 
	  $params['searchtxt'] = $_GET['search']['value'];
 
      
      if ($kategoriby == 'product') {
          $data['all_program'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
          $data['all_iklan'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=187,202',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=247,277',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=1,120',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=13,28',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=28,43',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=43,58',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=73,88',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=88,103',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=103,133',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=133,163'
          );	
      } elseif($kategoriby == 'advertiser'){
          $data['all_program'] = 
          array(	'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
       
      } elseif ($kategoriby == 'sector') {
          $data['all_program'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
        
      
      } else{}
      
       $list = $this->postbuyadspeformance_model->_get_filter_adspeformance_summ2($params);
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      $data = array();	
      
      $idx = 0;
      
      $array_channel = $this->array_channel();
      $array_channel2 = $this->array_channel2();
      
      foreach ( $list['data'] as $k => $v ) {
         
          
          array_push($data, 
              array(
                  $v['CHANNEL'],
                  number_format(($v['SPOT']),0,',','.'),
                  number_format(($v['COST']*1000),2,',','.'),
				  number_format($v['TVR_ALL'],2,',','.')
              )
          );
          $idx++;
      }		
      $result["data"] = $data;
      
      $this->json_result($result);
	}
	
	
	public function get_filter_adspeformance(){
      if( !empty($this->Anti_si($_GET['start_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['end_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['profile'])) ) {
          $profile = $this->Anti_si($_GET['profile']);
      } else {
          $profile = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_GET['kategori_by']);
      } else {
          $kategoriby = NULL;
      }	
      
      if( !empty($this->Anti_si($_GET['get_kategori'])) ) {
          $kategori = $this->Anti_si($_GET['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      
      if( !empty($this->Anti_si($_GET['chnl'])) ) {
          $chnl = $this->Anti_si($_GET['chnl']);
      } else {
          $chnl = "0";
      }
    
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('TANGGAL','TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR'); // , 'COST'
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
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
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']	= $kategori;
      $params['chnl']	= $chnl; 
	  $params['searchtxt'] = $_GET['search']['value'];
 
      
      if ($kategoriby == 'product') {
          $data['all_program'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
          $data['all_iklan'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=187,202',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4#t=247,277',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=1,120',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=13,28',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=28,43',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=43,58',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=73,88',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=88,103',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=103,133',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4#t=133,163'
          );	
      } elseif($kategoriby == 'advertiser'){
          $data['all_program'] = 
          array(	'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
         
      } elseif ($kategoriby == 'sector') {
          $data['all_program'] = 
          array('upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_03_50_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_04_00_00.mp4#t=240,300',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4',
              'upload/video/ANTV/channel10_2016_11_01_05_10_00.mp4'
          );
          
         
      } else{}
      
       $list = $this->postbuyadspeformance_model->_get_filter_adspeformance($params);
	  
       
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      $data = array();	
      
      $idx = 0;
      
      $array_channel = $this->array_channel();
      $array_channel2 = $this->array_channel2();
      
      foreach ( $list['data'] as $k => $v ) {
          if(substr($v['START_TIME'], 4, 1) >= 5){
              $min_vid = 5;
          }else{
              $min_vid = 0;
          }
         
          $arr_hours = substr($v['START_TIME'], 0, 2).":".substr($v['START_TIME'], 3, 1)."".$min_vid.":00";
          $arr_date = str_replace("-","_",$v['DATE_UNICS']);
          $arr_path = "https://urbanrate.id/video/".$array_channel2[$v['CHANNEL']]."/".$arr_date."/";
          $arr_filename = $array_channel2[$v['CHANNEL']]."_".$arr_date."_". str_replace(":","_",$arr_hours).".mp4";
          
          $start_vid = strtotime($v['START_TIME']) - strtotime($arr_hours); 
          $array_duration = explode(":",$v['DURATION']);
          $end_vid = $start_vid + (($array_duration[0]*3600)+($array_duration[1]*60)+($array_duration[2]));
          
          $arr_vid_time = "#t=".$start_vid.",".$end_vid;
          
          array_push($data, 
              array(
                  "<button class='btn urate-play-btn btn-sm' style='cursor: pointer;margin-top:15px' data-id='".$v['PROGRAM']."' onclick='vid_program(&#39;".$arr_path."".$arr_filename."".$arr_vid_time."&#39;,&#39;".$v['PRODUCT']."&#39;,&#39;".$arr_path.$arr_filename."&#39;,".$start_vid.",".$array_duration[2].")' ></button>",
                  $v['DATE_UNICS'],
                  $v['CHANNEL'],
                  $v['PROGRAM'],	
                  $v['PRODUCT'],
                  $v['ADVERTISER'],
                  $v['SECTOR'],
                  $v['START_TIME'],					
                  $v['DURATION'],
                  $v['ADS_TYPE'],
				  number_format($v['TVR_ALL'],2,',','.'),
                  $v['VIEWERS_ALL']
              )
          );
          $idx++;
      }		
      $result["data"] = $data;
      
      $this->json_result($result);
	}
  
	public function get_filter_grandtotal_adspeformance(){
      if( ! $this->Anti_si(empty($_GET['start_date']) )) {
          //$start_date = str_replace('/','-',$_GET['start_date']);
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          //$end_date = str_replace('/','-',$_GET['end_date']);
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['profile'])) ) {
          $profile = $this->Anti_si($_GET['profile']);
      } else {
          $profile = NULL;
      }
      
      if( ! empty($this->Anti_si($_GET['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_GET['kategori_by']);
      } else {
          $kategoriby = NULL;
      }
      
      if( ! empty($this->Anti_si($_GET['get_kategori'])) ) {
          $kategori = $this->Anti_si($_GET['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['chnl'])) ) {
          $chnl = $this->Anti_si($_GET['chnl']);
      } else {
          $chnl = NULL;
      }
      
	 
	  
 	  
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']		= $kategori;		
      $params['chnl']	= $chnl; 
      
      $sql = "SELECT DISTINCT(`CARDNO`) AS people FROM M_SINGLE_SOURCE_BARU18 WHERE "; 
      
      $i = 0;
      
      if($_GET['profile'] <> "0"){
           $sql_c = "SELECT * FROM PROFILE_CARDNO_RES WHERE ID_PROFILE = ".$_GET['profile'];
       }else{
          $params['user_id'] = "";
          $sql_c = "";
      }
       
      $params['sqlc'] = $sql_c; 
      
	 
	  $starts = explode("-",$params['start_date']);
	  
	  $d=cal_days_in_month(CAL_GREGORIAN,$starts[1],$starts[0]);
	 
		   $reach = $this->postbuyadspeformance_model->get_reach($params,0);
		   $reach_nill = $this->postbuyadspeformance_model->get_reach_nil($params,0);
 
	  
      if($reach[0]['REACH0'] == 0){
          $af = 0;
          $af2 = 0;
      }else{
          $listt = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params); 
          $af = ceil($listt[0]['sumtvr']/$reach[0]['REACH0']);
          if($reach_nill[0]['r1'] == ''){
            $af2 = 0;
          }else{
		$af2 = ceil($reach_nill[0]['sumtvr']/$reach_nill[0]['r1']);
          }
      }
     
      $data = array(
          'r0' => round($reach[0]['REACH0'],2),
          'r2' => round($reach[0]['REACH2'],2),
          'r3' => round($reach[0]['REACH3'],2),
          'r7' => round($reach[0]['REACH7'],2),
          'r13' => round($reach[0]['REACH13'],2),
          'r21' => round($reach[0]['REACH21'],2),
          'fr' => $af 
      );	


	   $data2 = array(
          'r0' => round($reach_nill[0]['r1'],2),
          'r2' => round($reach_nill[0]['r2'],2),
          'r3' => round($reach_nill[0]['r3'],2),
          'r7' => round($reach_nill[0]['r4'],2),
          'r13' => round($reach_nill[0]['r5'],2),
          'r21' => $af2
      );	

    

	  
      $result["data"] = $data;
      $result["data2"] = $data2;
       	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
  
	public function get_filter_grandtotal_adspeformance_summ(){
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
      
      if( ! empty($this->Anti_si($_GET['profile'])) ) {
          $profile = $this->Anti_si($_GET['profile']);
      } else {
          $profile = "0";
      }
      
      if( ! empty($this->Anti_si($_GET['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_GET['kategori_by']);
      } else {
          $kategoriby = NULL;
      }
      
      if( ! empty($this->Anti_si($_GET['get_kategori'])) ) {
          $kategori = $this->Anti_si($_GET['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['chnl'])) ) {
          $chnl = $this->Anti_si($_GET['chnl']);
      } else {
          $chnl = NULL;
      }
      
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']		= $kategori;		
      $params['chnl']	= $chnl;                                                              
      
      $list = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params);
       
      $data = array(
          'spot' => number_format($list[0]['spot'],0,',','.'),
          'costpview' => "Rp " . number_format(($list[0]['sumcost']*1000)/$list[0]['sumviewers'],0,',','.'),  
          'sumcost' => $list[0]['sumcost'] = "Rp " . number_format($list[0]['sumcost']*1000,0,',','.'),
          'sumtvr' => number_format(round($list[0]['sumtvr'],2),2,',','.'), 
          'sumviewers' => number_format($list[0]['sumviewers'],0,',','.'),
          'cprp' => number_format($list[0]['cprp'],2,',','.'), 
          'maxtvr' => round($list[0]['maxtvr'],2), 
          'mintvr' => round($list[0]['mintvr'],2), 
          'avgtvr' => round($list[0]['avgtvr'],2)
      );	
	  
	   $list2 = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance_nil($params);
 

      IF($list2[0]['spot'] == 0){
        $data2 = array(
            'spot' => number_format(0,0,',','.'),
            'costpview' => "Rp " . number_format(0,0,',','.'),  
            'sumcost' => "Rp " . number_format(0,0,',','.'),
            'sumtvr' => number_format(0,2,',','.'), 
            'sumviewers' => number_format(0,0,',','.'),
            'cprp' => number_format(0,2,',','.'), 
            'maxtvr' => round(0,2), 
            'mintvr' => round(0,2), 
            'avgtvr' => round(0,2)
        );	
      }else{

	  $data2 = array(
          'spot' => number_format($list2[0]['spot'],0,',','.'),
          'costpview' => "Rp " . number_format(($list2[0]['sumcost']*1000)/$list2[0]['sumviewers'],0,',','.'),  
          'sumcost' => $list2[0]['sumcost'] = "Rp " . number_format($list2[0]['sumcost']*1000,0,',','.'),
          'sumtvr' => number_format(round($list2[0]['sumtvr'],2),2,',','.'), 
          'sumviewers' => number_format($list2[0]['sumviewers'],0,',','.'),
          'cprp' => number_format($list2[0]['cprp'],2,',','.'), 
          'maxtvr' => round($list2[0]['maxtvr'],2), 
          'mintvr' => round($list2[0]['mintvr'],2), 
          'avgtvr' => round($list2[0]['avgtvr'],2)
      );	
      
    }

      $result["data"] = $data;
      $result["data2"] = $data2;
       
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }                             
    
  public function listsearch(){
      if( ! empty($_GET['sd']) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_GET['sd']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_GET['ed']) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_GET['ed']);
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      $list = $this->postbuyadspeformance_model->listsearch($_GET['q'],$_GET['c'],$start_date,$end_date);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                                  
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->postbuyadspeformance_model->profilesearch($_GET['q'],$iduser,$_GET['f']);
      
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
      $list = $this->postbuyadspeformance_model->get_profile($iduser,$idrole,$_GET['f']);          
                 
 				 
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                    
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->postbuyadspeformance_model->channelsearch($_GET['q'],$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
  
  public function download_video(){
      $filename = $_GET['f'];
      $start_time = (int)$_GET['s'];
      $duration = (int)$_GET['d'];
      
      if($start_time > 59){
          $sMinute = floor($start_time / 60);
          $sSecond = $start_time % 60; 
      } else {
          $sMinute = 0;
          $sSecond = $start_time;
      }
      
      $arrFilename = explode("/",$filename);
      $newFilenameArr = array($arrFilename[4],$arrFilename[5],$arrFilename[6]);
      $newFilename = "/hd/".implode("/",$newFilenameArr); 
      $newFilenameArr[2] = "chunk_".$newFilenameArr[2];
      $chunkFilename = "/var/www/html/urbanrate/app2/tmp_video/".$newFilenameArr[2];
      $webPath = rtrim(base_url('tmp_video/'.$newFilenameArr[2]),"'");
      
      $exe_cut = system("ffmpeg -i ".trim($newFilename,"'")." -ss 00:0".$sMinute.":".$sSecond." -t 00:00:".$duration." -async 1 -strict -2 ".trim($chunkFilename,"'"), $retval);
      
      header( 'Expires: Mon, 1 Apr 1974 05:00:00 GMT' );
      header( 'Pragma: no-cache' );
      header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
      header( 'Content-Description: File Download' );
      header( 'Content-Type: application/octet-stream' );
      header( 'Content-Length: '.filesize( $chunkFilename ) );
      header( 'Content-Disposition: attachment; filename="'.basename( $chunkFilename ).'"' );
      header( 'Content-Transfer-Encoding: binary' );
      readfile( $chunkFilename );  
      exit();
  }    
}