<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class postbuyadspeformance2resmdp22 extends JA_Controller {
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
      
      $this->template->load('maintemplate', 'postbuyadspeformance2resmdp22/views/Postbuyadspeformance', $data);
  }
  
  
  public function list_product()
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
      $profile = $this->Anti_si($_GET['profile']) ? $this->Anti_si($_GET['profile']) : 1;
      
      $params['product']		= $this->Anti_si($this->input->post('valselect',true));
      $params['profile']		= $profile;        
                                           
      $params['start_date']		= $this->Anti_si($this->input->post('start_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['start_date']);
      $params['start_date'] = $date->format('Y-m-d');
      
      $params['end_date']		= $this->Anti_si($this->input->post('end_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['end_date']);
      $params['end_date'] = $date->format('Y-m-d');
	  
       
      $list = $this->postbuyadspeformance_model->_list_product($params);
	  
 	  $html = ' <select style="width:100%;height:35px;" name="productss" id="productss" multiple >
	  <option value="all" Selected="selected" >All Product</option>';
 	  
	  foreach($list as  $lists){

          $html .= '<option value="'.$lists['PRODUCT'].'" >'.$lists['PRODUCT'].'</option>';

	  }
	  
	   $html .= '</select>';
       
      if ( $list ) {
          $result = array(
              'success' => true,
              'data' => $list,
              'html' => $html
          );
      } else {
          $result = array(
              'success' => false,
              'message' => 'Data not found'
          );
      } 
      
      $this->json_result($result);
	}
	
	
	public function list_program()
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
      
      $params['product']		= $this->Anti_si($this->input->post('valselect',true));
      $params['profile']		= $profile;        
                                           
      $params['start_date']		= $this->Anti_si($this->input->post('start_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['start_date']);
      $params['start_date'] = $date->format('Y-m-d');
      
      $params['end_date']		= $this->Anti_si($this->input->post('end_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['end_date']);
      $params['end_date'] = $date->format('Y-m-d');
	  
       
      $list = $this->postbuyadspeformance_model->_list_program($params);
	  
 	  $html = ' <select style="width:100%;height:35px;" name="programss" id="programss" multiple >
	  <option value="all" Selected="selected" >All Program</option>';
 	  
	  foreach($list as  $lists){

          $html .= '<option value="'.$lists['PROGRAM'].'" >'.$lists['PROGRAM'].'</option>';

	  }
	  
	   $html .= '</select>';
       
      if ( $list ) {
          $result = array(
              'success' => true,
              'data' => $list,
              'html' => $html
          );
      } else {
          $result = array(
              'success' => false,
              'message' => 'Data not found',
			  'html' => '<select style="width:100%;height:35px;" name="programss" id="programss" multiple >
	  <option value="all" Selected="selected" >All Program</option></select>'
          );
      } 
      
      $this->json_result($result);
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
      
      $params['product']		= $this->Anti_si($this->input->post('valselect',true));
      $params['profile']		= $profile;        
                                           
      $params['start_date']		= $this->Anti_si($this->input->post('start_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['start_date']);
      $params['start_date'] = $date->format('Y-m-d');
      
      $params['end_date']		= $this->Anti_si($this->input->post('end_date',true));
      $dt   = new DateTime();
      $date = $dt->createFromFormat('d/m/Y', $params['end_date']);
      $params['end_date'] = $date->format('Y-m-d');
      
	  //print_r($params);die;
	  
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
      $order_fields = array('DATE', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR', "TANGGAL, CHANNEL, START_TIME"); // , 'COST'
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] ;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      // Build params for calling model 
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
      
	  array_push($data, 
              array(
                  
                 '',	
                 '',	
				  '',				  
                 '',					
                 '',
                 ''
              )
          );
		
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
  
	public function array_channel(){
      $array_channel = [
          "TRANS7" => "channel01",
          "RCTI" => "channel02",
          "SCTV" => "channel03",
          "TRANSTV" => "channel04",
          "GLOBAL" => "channel05",
          "INDOSIAR" => "channel06",
          "MNC" => "channel07",
          "METRO" => "channel08",
          "TVONE" => "channel09",
          "ANTV" => "channel10",
          "RTV" => "channel12",
          "INEWS" => "channel13" ,
          "CHANNELTV" => "channel14",
          "NET" => "channel15",
          "KOMPAS" => "channel16",
          "KOMPASTV" => "channel16",
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
	
	public function print_pdf_2(){
		
		 $_POST = json_decode(file_get_contents("php://input"), true);
      
 	  
      if(empty($_POST))
      {
          $result = array(
              'success' => false,
              'message' => 'Error retrieving list program'
          );
          
          $this->json_result($result);
      }
		
		
	  if( !empty($this->Anti_si($_POST['start_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }

      if( !empty($this->Anti_si($_POST['end_date'])) ) { 
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['profile'])) ) {
          $profile = $this->Anti_si($_POST['profile']);
      } else {
          $profile = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_POST['kategori_by']);
      } else {
          $kategoriby = NULL;
      }	
      
      if( !empty($this->Anti_si($_POST['get_kategori'])) ) {
          $kategori = $this->Anti_si($_POST['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['chnl'])) ) {
          $chnl = $this->Anti_si($_POST['chnl']);
      } else {
          $chnl = "0";
      }
	  
	    if( !empty($this->Anti_si($_POST['svg'])) ) {
          $svg = $this->Anti_si($_POST['svg']);
      } else {
          $svg = "0";
      }
	  
	        $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($this->Anti_si($search['value'])) ) {
          $search_value = $this->Anti_si($search['value']);
      } else {
          $search_value = null;
      }
	  
	   if( !empty($this->Anti_si($_POST['get_product'])) ) {
          $get_product = $this->Anti_si($_POST['get_product']);
      } else {
          $get_product = "";
      }
	  
	  	    if( !empty($this->Anti_si($_POST['get_program'])) ) {
          $get_program = $this->Anti_si($_POST['get_program']);
      } else {
          $get_program = "";
      }
	  

      $params['order_dir'] 	= "ASC";
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']	= $kategori;
      $params['chnl']	= $chnl; 
	  $params['get_product_a']	= $get_product; 
	  
			foreach($get_product  as $channel_f){
				$cin = $cin."".$channel_f.",";
			}
			$new_cin = substr($cin, 0, -1);
			
		
		$params['get_product'] = $new_cin;
		 $params['get_program_a']	= $get_program; 
		 
		 foreach($get_program  as $channel_fp){
				$cinp = $cinp."".$channel_fp.",";
			}
			$new_cinp = substr($cinp, 0, -1);
		
		$params['get_program'] = $new_cinp;
		
	  
 	  
	   $list = $this->postbuyadspeformance_model->_get_filter_adspeformance_pr($params);
	   
 		
		$this->load->library('Pdff');
		
		$pdf = new FPDF();
		$pdf->AddPage('O');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Brand : '.$list['data'][0]['NAMA_BRAND'],0,1);
		$pdf->Cell(0,5,'Advertiser : '.$list['data'][0]['ADVERTISER'],0,1);
		$pdf->Cell(0,5,'Agency : '.$list['data'][0]['AGENCY'],0,1);
		$pdf->Cell(0,5,'Product : '.$new_cin,0,1);
		$pdf->Cell(0,15,$start_date." s/d ".$end_date,0,1);
		$pdf->SetFont('Arial','B',8);
		
		$header = array('Date', 'Day of Week', 'ISO Week', 'Channel','Program','House Number','Start Time','Duration','TVR','Total Viewers','Reach 000s', 'Reach 1+', 'Index');
		
		$w = array(16, 18, 15, 50,50,15, 14, 13, 20, 18, 18 );
 
		$pdf->Cell(array_sum($w)+22+14,0,'','T');
		$pdf->Ln();	
		
		$pdf->Cell(array_sum($w)+22+14,0,'','T');
		$pdf->Ln();	
		
		$pdf->Cell($w[0],6,'Date','BLR');
		$pdf->Cell($w[1],6,'Day of Week','BLR');
		$pdf->Cell($w[2],6,'ISO Week','BLR');
		$pdf->Cell($w[3],6,'Channel','BLR');
		$pdf->Cell($w[4],6,'Program','BLR');
		$pdf->Cell(22,6,'House Number','BLR');
		$pdf->Cell($w[5],6,'Start Time','BLR');
		$pdf->Cell($w[6],6,'Duration','BLR');
		$pdf->Cell($w[7],6,'TVR','BLR',0,'R');
		$pdf->Cell($w[8],6,'Total Viewers','BLR',0,'R');
		$pdf->Cell($w[9],6,'Reach 000s','BLR',0,'R');
		$pdf->Cell($w[10],6,'Reach 1+','BLR',0,'R');
		$pdf->Cell($w[6],6,'Index','BLR',0,'R');
		$pdf->Ln();		
		
		
 		foreach($list['data'] as $row)
		{
			$row['TVR'] = $row['VIEWERS']/$row['UNIVERSE']*100;
			$row['REACH0'] = (($row['VIEWERS']/$row['UNIVERSE'])*100)*$row['UNIVERSE']/1000;
			$row['REACH01'] = ($row['VIEWERS']/$row['UNIVERSE'])*100;
			  
			if($row['VIEWERS'] == ''){
				$row['VIEWERS'] = 0;
				$row['UNIVERSE'] = 0;
				$row['TVR'] = 0;
				$row['REACH0'] = 0;
				$row['REACH01'] = 0;
			}
			  
			  
			$arr_program = explode(' ',$row['PROGRAM']);
			$int_program = 0;
			$string_program = '';
			$array_str = [];
			$curr_program = '';
			
			$trp = 1;
		
			for($i=0;$i<count($arr_program);$i++){
				
				$int_program = $int_program + strlen($arr_program[$i])+1;
				if($int_program < 29 ){
					if($i == (count($arr_program)-1)){
						
						if($trp == 1){
							$string_program .= $arr_program[$i].' ';
							
							$pdf->Cell($w[0],6,$row['DATE'],'LR');
							$pdf->Cell($w[1],6,$row['DAYENAME'],'LR');
							$pdf->Cell($w[2],6,$row['WEEKNAME'],'LR');
							$pdf->Cell($w[3],6,$row['CHANNEL'],'LR');
							$pdf->Cell($w[4],6,$string_program,'LR');
							$pdf->Cell(22,6,$row['PO_NUMBER'],'LR');
							$pdf->Cell($w[5],6,$row['START_TIME'],'LR');
							$pdf->Cell($w[6],6,$row['DURATION'],'LR');
							$pdf->Cell($w[7],6,number_format($row['REACH01'],2,',','.'),'LR',0,'R');
							$pdf->Cell($w[8],6,number_format($row['VIEWERS'],0,',','.'),'LR',0,'R');
							$pdf->Cell($w[9],6,number_format($row['REACH0'],2,',','.'),'LR',0,'R');
							$pdf->Cell($w[10],6,number_format($row['REACH01'],2,',','.'),'LR',0,'R');
							$pdf->Cell($w[6],6,number_format($row['IDX'],2,',','.'),'LR',0,'R');
							$pdf->Ln();	
						}else{
							$string_program .= $arr_program[$i].' ';
						
							$pdf->Cell($w[0],6,'','LR');
							$pdf->Cell($w[1],6,'','LR');
							$pdf->Cell($w[2],6,'','LR');
							$pdf->Cell($w[3],6,'','LR');
							$pdf->Cell($w[4],6,$string_program,'LR');
							$pdf->Cell(22,6,'','LR');
							$pdf->Cell($w[5],6,'','LR');
							$pdf->Cell($w[6],6,'','LR');
							$pdf->Cell($w[7],6,'','LR',0,'R');
							$pdf->Cell($w[8],6,'','LR',0,'R');
							$pdf->Cell($w[9],6,'','LR',0,'R');
							$pdf->Cell($w[10],6,'','LR',0,'R');
							$pdf->Cell($w[6],6,'','LR',0,'R');
							$pdf->Ln();		
							
							$trp =1;
							
						}
					}
					
					
					$string_program .= $arr_program[$i].' ';
					
				}else{
						if($trp == 1){
							
							$pdf->Cell($w[0],6,$row['DATE'],'LR');
							$pdf->Cell($w[1],6,$row['DAYENAME'],'LR');
							$pdf->Cell($w[2],6,$row['WEEKNAME'],'LR');
							$pdf->Cell($w[3],6,$row['CHANNEL'],'LR');
							$pdf->Cell($w[4],6,$string_program,'LR');
							$pdf->Cell(22,6,$row['PO_NUMBER'],'LR');
							$pdf->Cell($w[5],6,$row['START_TIME'],'LR');
							$pdf->Cell($w[6],6,$row['DURATION'],'LR');
							$pdf->Cell($w[7],6,number_format($row['TVR'],2,',','.'),'LR',0,'R');
							$pdf->Cell($w[8],6,number_format($row['VIEWERS'],0,',','.'),'LR',0,'R');
							$pdf->Cell($w[9],6,number_format($row['REACH0'],2,',','.'),'LR',0,'R');
							$pdf->Cell($w[10],6,number_format($row['REACH01'],2,',','.'),'LR',0,'R');
							$pdf->Cell($w[6],6,number_format($row['IDX'],2,',','.'),'LR',0,'R');
							$pdf->Ln();	
						}else{
							
 							
							$pdf->Cell($w[0],6,'','LR');
							$pdf->Cell($w[1],6,'','LR');
							$pdf->Cell($w[2],6,'','LR');
							$pdf->Cell($w[3],6,'','LR');
							$pdf->Cell($w[4],6,$string_program,'LR');
							$pdf->Cell(22,6,'','LR');
							$pdf->Cell($w[5],6,'','LR');
							$pdf->Cell($w[6],6,'','LR');
							$pdf->Cell($w[7],6,'','LR',0,'R');
							$pdf->Cell($w[8],6,'','LR',0,'R');
							$pdf->Cell($w[9],6,'','LR',0,'R');
							$pdf->Cell($w[10],6,'','LR',0,'R');
							$pdf->Cell($w[6],6,'','LR',0,'R');
							$pdf->Ln();	
						}
						
						if($i == (count($arr_program)-1)){
							
							$string_program = $arr_program[$i].' ';	
							$pdf->Cell($w[0],6,'','LR');
							$pdf->Cell($w[1],6,'','LR');
							$pdf->Cell($w[2],6,'','LR');
							$pdf->Cell($w[3],6,'','LR');
							$pdf->Cell($w[4],6,$string_program,'LR');
							$pdf->Cell(22,6,'','LR');
							$pdf->Cell($w[5],6,'','LR');
							$pdf->Cell($w[6],6,'','LR');
							$pdf->Cell($w[7],6,'','LR',0,'R');
							$pdf->Cell($w[8],6,'','LR',0,'R');
							$pdf->Cell($w[9],6,'','LR',0,'R');
							$pdf->Cell($w[10],6,'','LR',0,'R');
							$pdf->Cell($w[6],6,'','LR',0,'R');
							$pdf->Ln();	
							
						}
						
							$int_program = strlen($arr_program[$i])+1;
							$string_program = $arr_program[$i].' ';			
							$trp++;							
				}
				
			}

		}
 		$pdf->Cell(array_sum($w)+22+14,0,'','T');
	
		
		$pdf->AddPage('0');
		$pdf->SetFont('Arial','B',12);
		
		$header2 = array('Date', 'Day of Week');
		
		$w = array(16, 18, 15, 50,50,15, 14, 13, 20, 18, 18 );

		$list = $this->postbuyadspeformance_model->_get_filter_adspeformance2_ss($params);
		
		$idx = 0;
		$grp = 0;
		$cost = 0;
		  
		$min = 0;
		$max = 0;
		
		foreach ( $list['data'] as $k => $v ) {

		  if($min == 0){
			  $min = $v['TVR'];
		  }else{
			  if($min > $v['TVR']){
				  $min = $v['TVR'];
			  }
		  }
		  
		   if($max == 0){
			  $max = $v['TVR'];
		  }else{
			  if($max < $v['TVR']){
				  $max = $v['TVR'];
			  }
		  }
		  
		  $grp = $grp + ($v['TVR']);
		  $cost = $cost + $v['PRICE'];
          $idx++;
		  
		}
		
		$spot = $idx;
	  
		  if($grp == 0){
			  $cprpp = 0;
			  $avgtvrs = 0;
		  }else{
			  $cprpp = $cost/$grp;
			  $avgtvrs = $grp/$spot;
		  }
 
		
		if($profile == 1){
			$params['univ'] = 19479392;
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach_all($params);
		}elseif($profile == 0){
			$params['univ'] = 17328363;
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach_all($params);
		}else{
			$get_univ = $this->postbuyadspeformance_model->get_univ($params);
			$params['univ'] = $get_univ[0]['respondents_all'];
			$params['flag'] = $get_univ[0]['flag'];
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach($params);
		}
		
		if($list_reach[0]['REACH_1'] == 0){
		  $freq = 0;
		  }else{
			  $freq = $grp/$list_reach[0]['REACH_1'];
		  }
		  
			$pdf->Cell($w[4],6,'Summary',0);
			$pdf->Cell($w[4],6,'',0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach & Frequency',0);
			$pdf->Cell(30,6,'',0,0,'R');
			$pdf->Cell(30,6,'',0,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Total Spot',1);
			$pdf->Cell($w[4],6,number_format($spot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach 1+',1);
			$pdf->Cell(30,6,number_format($list_reach[0]['REACH_1'],2,',','.'),1,0,'R');
			$pdf->Cell(30,6,number_format(($list_reach[0]['REACH_1']*$params['univ'])/1000,0,',','.'),1,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Total Cost',1);
			$pdf->Cell($w[4],6,number_format($cost,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach 2+',1);
			$pdf->Cell(30,6,number_format($list_reach[0]['REACH_2'],2,',','.'),1,0,'R');
			$pdf->Cell(30,6,number_format(($list_reach[0]['REACH_2']*$params['univ'])/1000,0,',','.'),1,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'GRP',1);
			$pdf->Cell($w[4],6,number_format($grp,2,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach 3+',1);
			$pdf->Cell(30,6,number_format($list_reach[0]['REACH_3'],2,',','.'),1,0,'R');
			$pdf->Cell(30,6,number_format(($list_reach[0]['REACH_3']*$params['univ'])/1000,0,',','.'),1,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'CPRP',1);
			$pdf->Cell($w[4],6,number_format($cprpp,2,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach 7+',1);
			$pdf->Cell(30,6,number_format($list_reach[0]['REACH_7'],2,',','.'),1,0,'R');
			$pdf->Cell(30,6,number_format(($list_reach[0]['REACH_7']*$params['univ'])/1000,0,',','.'),1,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Max TVR',1);
			$pdf->Cell($w[4],6,number_format($max,2,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach 13+',1);
			$pdf->Cell(30,6,number_format($list_reach[0]['REACH_13'],2,',','.'),1,0,'R');
			$pdf->Cell(30,6,number_format(($list_reach[0]['REACH_13']*$params['univ'])/1000,0,',','.'),1,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Min TVR',1);
			$pdf->Cell($w[4],6,number_format($min,2,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Reach 21+',1);
			$pdf->Cell(30,6,number_format($list_reach[0]['REACH_21'],2,',','.'),1,0,'R');
			$pdf->Cell(30,6,number_format(($list_reach[0]['REACH_21']*$params['univ'])/1000,0,',','.'),1,0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Avg TVR',1);
			$pdf->Cell($w[4],6,number_format($avgtvrs,2,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Cell($w[4],6,'Avg Freq',1);
			$pdf->Cell(60,6,number_format(ceil($freq),0,',','.'),1,0,'R');
			$pdf->Ln();
	
			
			$list2 = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params);
			  $content = '';
	  
			  $i = 1;
			  $views_tot = 0;
			  $spots_tot = 0;
			  $vgvps_tot = 0;
			  $price_tot = 0;
			  $arr_chann = array();
			  $arr_views = array();
			  
			  $ti2 = 2;
			  
			  $pdf->Ln();
			  $pdf->Ln();
			  $pdf->Ln();
			  $pdf->Cell(10,6,'No',1);
					$pdf->Cell(90,6,'Channel',1,0);
					$pdf->Cell($w[4],6,'Views',1,0,'R');
					$pdf->Cell(19,6,'Spot',1);
					$pdf->Cell(60,6,'AVG View per Spot',1,0,'R');
					$pdf->Ln();
			  
			  foreach($list2 as $listy){
		  
					 $pdf->Cell(10,6,$i,1);
					$pdf->Cell(90,6,$listy['CHANNEL'],1,0);
					$pdf->Cell($w[4],6,number_format($listy['VIEWS'],0,',','.'),1,0,'R');
					$pdf->Cell(19,6,number_format($listy['SPOT'],0,',','.'),1,0,'R');
					$pdf->Cell(60,6,number_format(ceil($listy['VG_VPS']),2,',','.'),1,0,'R');
					$pdf->Ln();
					
				  $views_tot = $views_tot + $listy['VIEWS'];
				  $spots_tot = $spots_tot + $listy['SPOT'];
				  $vgvps_tot = $vgvps_tot + $listy['VG_VPS'];
				  $price_tot = $price_tot + $listy['PRICE'];
				  
				  $arr_chann[] = $listy['CHANNEL'];
				  $arr_views[] = intval($listy['VIEWS']);
				  $i++;
				  $ti2++;
				}
				
				 $pdf->Cell(100,6,'Total',1);
					$pdf->Cell($w[4],6, number_format($views_tot,0,',','.'),1,0,'R');
					$pdf->Cell(19,6,number_format($spots_tot,0,',','.'),1,0,'R');
					$pdf->Cell(60,6,number_format(ceil($vgvps_tot),2,',','.'),1,0,'R');
					$pdf->Ln();
			 $pdf->Ln();
			  $pdf->Ln();
			  
			  
			$pdf->Cell($w[4],6,'Total Views',1);
			$pdf->Cell($w[4],6,number_format($views_tot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Total Cost',1);
			$pdf->Cell($w[4],6,'Rp. '.number_format($price_tot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Total Spot',1);
			$pdf->Cell($w[4],6,number_format($spots_tot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Average View per Spot',1);
			$pdf->Cell($w[4],6,number_format($views_tot/$spots_tot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Average Cost per Spot',1);
			$pdf->Cell($w[4],6,'Rp. '.number_format($price_tot/$spots_tot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Ln();
			$pdf->Cell($w[4],6,'Average Cost per View',1);
			$pdf->Cell($w[4],6,'Rp. '.number_format($price_tot/$views_tot,0,',','.'),1,0,'R');
			$pdf->Cell(20,6,'',0,'R');
			$pdf->Ln();
			  
	
			$img = explode(',',$svg,2)[1];
			$pic = 'data://text/plain;base64,'. $img;
			
			$pdf->AddPage('0');
			$pdf->Image($pic, 10,30,0,0,'png');
 
		$pdf->Output('F','/var/www/html/tmp_doc/Report_Postbuy_urban.pdf');
		
		if ( $list ) {			
			  $this->output->set_content_type('application/json')->set_output(json_encode($list));
		} else {
			  $result = array( 'Value not found!' );
			  $this->output->set_content_type('application/json')->set_output(json_encode($list));
		}

		
	}
	
	public function print_pdf(){
		
	  $_POST = json_decode(file_get_contents("php://input"), true);
      
 	  
      if(empty($_POST))
      {
          $result = array(
              'success' => false,
              'message' => 'Error retrieving list program'
          );
          
          $this->json_result($result);
      }
		
		
	if( !empty($this->Anti_si($_POST['start_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	 
	  
      if( !empty($this->Anti_si($_POST['end_date'])) ) { 
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['profile'])) ) {
          $profile = $this->Anti_si($_POST['profile']);
      } else {
          $profile = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_POST['kategori_by']);
      } else {
          $kategoriby = NULL;
      }	
      
      if( !empty($this->Anti_si($_POST['get_kategori'])) ) {
          $kategori = $this->Anti_si($_POST['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['chnl'])) ) {
          $chnl = $this->Anti_si($_POST['chnl']);
      } else {
          $chnl = "0";
      }
	  
	    if( !empty($this->Anti_si($_POST['svg'])) ) {
          $svg = $this->Anti_si($_POST['svg']);
      } else {
          $svg = "0";
      }
	  
 		
	if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 20;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('DATE','DATE', 'CHANNEL', 'PROGRAM', 'NAMA_BRAND', 'ADVERTISER', 'AGENCY','PO_NUMBER', 'START_TIME', 'DURATION', 'RATE', 'TVR'); // , 'COST'
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
		$params['svg']	= $svg;
	  
	 
		$rtext = '<br><p style="font-size: 8px">'.$kategoriby.' : '.$kategori.'<br>Periode : '.$start_date.' / '.$end_date.'</p> ';
 
		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		
		$pdf->SetTitle('Report Postbuy DTV');
		$pdf->SetHeaderMargin(10);
		$pdf->SetTopMargin(5);
		$pdf->setFooterMargin(10);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->SetPrintFooter(false);
		
		$pdf->AddPage();
 
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(200,10,'DATA KARYAWAN',0,0,'C');
		 
		$pdf->Cell(10,15,'',0,1);
		$pdf->SetFont('Times','B',9);
		$pdf->Cell(10,7,'NO',1,0,'C');
		$pdf->Cell(50,7,'NAMA' ,1,0,'C');
		$pdf->Cell(75,7,'ALAMAT',1,0,'C');
		$pdf->Cell(55,7,'EMAIL',1,0,'C');
		 
		 
		$pdf->Cell(10,7,'',0,1);
		$pdf->SetFont('Times','',10);
		$no=1;
	 
		$pdf->Output('/var/www/html/tmp_doc/Report_Postbuysasa.pdf', 'F'); 

		if ( $params ) {			
			  $this->output->set_content_type('application/json')->set_output(json_encode($list));
		} else {
			  $result = array( 'Value not found!' );
			  $this->output->set_content_type('application/json')->set_output(json_encode($list));
		}
		
		
	}
	
	public function print_excel(){
		
	  $_POST = json_decode(file_get_contents("php://input"), true);
      
 	  
      if(empty($_POST))
      {
          $result = array(
              'success' => false,
              'message' => 'Error retrieving list program'
          );
          
          $this->json_result($result);
      }
		
		
	if( !empty($this->Anti_si($_POST['start_date'])) ) {
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	 
	  
      if( !empty($this->Anti_si($_POST['end_date'])) ) { 
           $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_POST['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['profile'])) ) {
          $profile = $this->Anti_si($_POST['profile']);
      } else {
          $profile = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['kategori_by'])) ) {
          $kategoriby = $this->Anti_si($_POST['kategori_by']);
      } else {
          $kategoriby = NULL;
      }	
      
      if( !empty($this->Anti_si($_POST['get_kategori'])) ) {
          $kategori = $this->Anti_si($_POST['get_kategori']);
      } else {
          $kategori = NULL;
      }
      
      if( !empty($this->Anti_si($_POST['chnl'])) ) {
          $chnl = $this->Anti_si($_POST['chnl']);
      } else {
          $chnl = "0";
      }
	  
	    if( !empty($this->Anti_si($_POST['get_product'])) ) {
          $get_product = $this->Anti_si($_POST['get_product']);
      } else {
          $get_product = "";
      }
	  
	    if( !empty($this->Anti_si($_POST['get_program'])) ) {
          $get_program = $this->Anti_si($_POST['get_program']);
      } else {
          $get_program = "";
      }
 
		
	if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 20;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('DATE','DATE', 'CHANNEL', 'PROGRAM', 'NAMA_BRAND', 'ADVERTISER', 'AGENCY','PO_NUMBER', 'START_TIME', 'DURATION', 'RATE', 'TVR'); // , 'COST'
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
     
      // Build params for calling model 
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
	   $params['get_product_a']	= $get_product; 
	   
	  
			foreach($get_product  as $channel_f){
				$cin = $cin."".$channel_f.",";
			}
			$new_cin = substr($cin, 0, -1);
		
		$params['get_product'] = $new_cin;
		 $params['get_program_a']	= $get_program; 
		 
		 foreach($get_program  as $channel_fp){
				$cinp = $cinp."".$channel_fp.",";
			}
			$new_cinp = substr($cinp, 0, -1);
		
		$params['get_program'] = $new_cinp;
 		$filename = 'image'.time().'.xlsx';
 	  
	   $list = $this->postbuyadspeformance_model->_get_filter_adspeformance_pr($params);
 	   
	   $this->load->library('excel');
	   
	   $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	  
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Date')
					->setCellValue('B1', 'Day of Week')
					->setCellValue('C1', 'ISO Week')
					->setCellValue('D1', 'Channel')
					->setCellValue('E1', 'Program')
					->setCellValue('F1', 'Brand')
					->setCellValue('G1', 'Advertiser')
					->setCellValue('H1', 'Agency')
					->setCellValue('I1', 'Po Number')
					->setCellValue('J1', 'Start Time')
					->setCellValue('K1', 'Spot')
					->setCellValue('L1', 'Duration')
					->setCellValue('M1', 'TVR')
					->setCellValue('N1', 'Total Viewers')
					->setCellValue('O1', 'Reach 000s')
					->setCellValue('P1', 'Reach 1+')
					->setCellValue('Q1', 'Index');
	   
	   $it1 = 2;
		 foreach($list['data'] as $frt){
			 
			  $frt['TVR'] = $frt['VIEWERS']/$frt['UNIVERSE'];
			  $frt['REACH0'] = (($frt['VIEWERS']/$frt['UNIVERSE'])*100)*$frt['UNIVERSE']/1000;
			  $frt['REACH01'] = ($frt['VIEWERS']/$frt['UNIVERSE'])*100;
			  
			  if($frt['VIEWERS'] == ''){
				  $frt['VIEWERS'] = 0;
				  $frt['UNIVERSE'] = 0;
				  $frt['TVR'] = 0;
				  $frt['REACH0'] = 0;
				  $frt['REACH01'] = 0;
			  }
            
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['DATE'])
					->setCellValue('B'.$it1, $frt['DAYENAME'])
					->setCellValue('C'.$it1, $frt['WEEKNAME'])
					->setCellValue('D'.$it1, $frt['CHANNEL'])
					->setCellValue('E'.$it1, $frt['PROGRAM'])
					->setCellValue('F'.$it1, $frt['NAMA_BRAND'])
					->setCellValue('G'.$it1, $frt['ADVERTISER'])
					->setCellValue('H'.$it1, $frt['AGENCY'])
					->setCellValue('I'.$it1, $frt['PO_NUMBER'])
					->setCellValue('J'.$it1, $frt['START_TIME'])
					->setCellValue('K'.$it1, '1')
					->setCellValue('L'.$it1, $frt['DURATION'])
					->setCellValue('M'.$it1, $frt['REACH01'])
					->setCellValue('N'.$it1, $frt['VIEWERS'])
					->setCellValue('O'.$it1, $frt['REACH0'])
					->setCellValue('P'.$it1, $frt['REACH01'])
					->setCellValue('Q'.$it1, $frt['IDX']);
                    
			$it1++;
		}
		
		
		
	   $objPHPExcel->getActiveSheet()->setTitle('Postbuy List');

	   $objPHPExcel->createSheet(1);
	   
		$objPHPExcel->setActiveSheetIndex(1)
					->setCellValue('A1', 'No')
					->setCellValue('B1', 'Channel')
					->setCellValue('C1', 'Views')
					->setCellValue('D1', 'Spot')
					->setCellValue('E1', 'AVG View per Spot');

		  $list2 = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params);
		
		 $content = '';
	  
		  $i = 1;
		  $views_tot = 0;
		  $spots_tot = 0;
		  $vgvps_tot = 0;
		  $price_tot = 0;
		  $arr_chann = array();
		  $arr_views = array();
		  
		  $ti2 = 2;
		foreach($list2 as $listy){
		  
		  $objPHPExcel->setActiveSheetIndex(1)
					->setCellValue('A'.$ti2, $i)
					->setCellValue('B'.$ti2, $listy['CHANNEL'])
					->setCellValue('C'.$ti2, $listy['VIEWS'])
					->setCellValue('D'.$ti2, $listy['SPOT'])
					->setCellValue('E'.$ti2, ceil($listy['VG_VPS']));
		    
		  $views_tot = $views_tot + $listy['VIEWS'];
		  $spots_tot = $spots_tot + $listy['SPOT'];
		  $vgvps_tot = $vgvps_tot + $listy['VG_VPS'];
		  $price_tot = $price_tot + $listy['PRICE'];
		  
		  $arr_chann[] = $listy['CHANNEL'];
		  $arr_views[] = intval($listy['VIEWS']);
		  $i++;
		  $ti2++;
		}
		
		$objPHPExcel->setActiveSheetIndex(1)
					->mergeCells('A'.$ti2.':B'.$ti2)
					->setCellValue('A'.$ti2, 'Total')
					->setCellValue('C'.$ti2, $views_tot)
					->setCellValue('D'.$ti2, $spots_tot)
					->setCellValue('E'.$ti2, ceil($vgvps_tot));
					
		$objPHPExcel->getActiveSheet()->setTitle('Postbuy Report');
		
		$objPHPExcel->createSheet(2);
	   
		$objPHPExcel->setActiveSheetIndex(2)
					->setCellValue('A1', 'Total Views')
					->setCellValue('A2', 'Total Cost')
					->setCellValue('A3', 'Total Spot')
					->setCellValue('A4', 'Average View per Spot')
					->setCellValue('A5', 'Average Cost per Spot	')
					->setCellValue('A6', 'Average Cost per View	')
					->setCellValue('B1',  $views_tot)
					->setCellValue('B2',  $price_tot)
					->setCellValue('B3',  $spots_tot)
					->setCellValue('B4', number_format($views_tot/$spots_tot,0,'',''))
					->setCellValue('B5', number_format($price_tot/$spots_tot,0,'',''))
					->setCellValue('B6', number_format($price_tot/$views_tot,0,'',''));

		$objPHPExcel->setActiveSheetIndex(2);

		$objPHPExcel->getActiveSheet()->setTitle('Postbuy Report Summary');
		
		$objPHPExcel->createSheet(3);
		$objPHPExcel->setActiveSheetIndex(3);
		$objPHPExcel->getActiveSheet()->setTitle('Summary');
		
		$objPHPExcel->setActiveSheetIndex(3)
					->setCellValue('A1', 'Total Spot')
					->setCellValue('A2', 'Total Cost')
					->setCellValue('A3', 'GRP')
					->setCellValue('A4', 'CPRP')
					->setCellValue('A5', 'Max TVR')
					->setCellValue('A6', 'Min TVR')
					->setCellValue('A7', 'Avg TVR');
				
		$list_sm = $this->postbuyadspeformance_model->_get_filter_adspeformance2_ss($params);
		
			$grp = 0;
			$cost = 0;
		  
			$min = 0;
			$max = 0;
			$idx = 0;
		 foreach ( $list_sm['data'] as $k => $v ) {
		  if($min == 0){
			  $min = $v['TVR'];
		  }else{
			  if($min > $v['TVR']){
				  $min = $v['TVR'];
			  }
		  }
		  
		   if($max == 0){
			  $max = $v['TVR'];
		  }else{
			  if($max < $v['TVR']){
				  $max = $v['TVR'];
			  }
		  }
		  
		  $grp = $grp + ($v['TVR']);
		  $cost = $cost + $v['PRICE'];
          $idx++;
			 
		 }
		 
		    $spot = $idx;
	  
		  if($grp == 0){
			  $cprpp = 0;
			  $avgtvrs = 0;
		  }else{
			  $cprpp = $cost/$grp;
			  $avgtvrs = $grp/$spot;
		  }
		  
		  $objPHPExcel->setActiveSheetIndex(3)
					->setCellValue('B1', $spot)
					->setCellValue('B2', $cost)
					->setCellValue('B3', $grp)
					->setCellValue('B4', $cprpp)
					->setCellValue('B5', $max)
					->setCellValue('B6', $min)
					->setCellValue('B7', $avgtvrs);
		
		
		$objPHPExcel->createSheet(4);
		$objPHPExcel->setActiveSheetIndex(4);
		$objPHPExcel->getActiveSheet()->setTitle('Reach & Frequency');
		
		$objPHPExcel->setActiveSheetIndex(4)
					->setCellValue('A1', 'Reach 1+')
					->setCellValue('A2', 'Reach 2+')
					->setCellValue('A3', 'Reach 3+')
					->setCellValue('A4', 'Reach 7+')
					->setCellValue('A5', 'Reach 13+')
					->setCellValue('A6', 'Reach 21+')
					->setCellValue('A7', 'AVG Freq');
					
		if($profile == 0){
			$params['univ'] = 17328363;
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach_all($params);
		}else{
			$get_univ = $this->postbuyadspeformance_model->get_univ($params);
			$params['univ'] = $get_univ[0]['respondents_all'];
			$params['flag'] = $get_univ[0]['flag'];
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach($params);
		}	
		
		
		 if(count($list_reach) == 0 ){
			 
			 $objPHPExcel->setActiveSheetIndex(4)
						->setCellValue('B1', 0)
						->setCellValue('B2', 0)
						->setCellValue('B3', 0)
						->setCellValue('B4', 0)
						->setCellValue('B5', 0)
						->setCellValue('B6', 0)
						->setCellValue('B7', 0);
		
		 }else{
			 
			 if($list_reach[0]['REACH_1'] == 0){
			  $freq = 0;
			}else{
			  $freq = $grp/$list_reach[0]['REACH_1'];
			}
			
			
			  $objPHPExcel->setActiveSheetIndex(4)
						->setCellValue('B1', $list_reach[0]['REACH_1'])
						->setCellValue('B2', $list_reach[0]['REACH_2'])
						->setCellValue('B3', $list_reach[0]['REACH_3'])
						->setCellValue('B4', $list_reach[0]['REACH_7'])
						->setCellValue('B5', $list_reach[0]['REACH_13'])
						->setCellValue('B6', $list_reach[0]['REACH_21'])
						->setCellValue('C1', ($list_reach[0]['REACH_1']*$params['univ'])/1000)
						->setCellValue('C2', ($list_reach[0]['REACH_2']*$params['univ'])/1000)
						->setCellValue('C3', ($list_reach[0]['REACH_3']*$params['univ'])/1000)
						->setCellValue('C4', ($list_reach[0]['REACH_7']*$params['univ'])/1000)
						->setCellValue('C5', ($list_reach[0]['REACH_13']*$params['univ'])/1000)
						->setCellValue('C6', ($list_reach[0]['REACH_21']*$params['univ'])/1000)
						->setCellValue('C7', ceil($freq));
			 
		 }
 		$objPHPExcel->setActiveSheetIndex(0);

		
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
		
		$objWriter->save('/var/www/html/tmp_doc/Postbuy_analytics.xls');

 		
		if ( $list ) {			
			  $this->output->set_content_type('application/json')->set_output(json_encode($list));
		} else {
			  $result = array( 'Value not found!' );
			  $this->output->set_content_type('application/json')->set_output(json_encode($list));
		}
		
		
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
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 20;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('DATE','DATE', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'HOUSE_NUMBER', 'START_TIME', 'DURASI', 'RATE'); // , 'COST'
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
      
      foreach ( $list['data'] as $k => $v ) {
          
          
          array_push($data, 
              array(
                  
                  $v['CHANNEL'],	
                  $v['PROGRAM'],	
				  $v['TANGGAL'],				  
                  $v['START_TIME'],					
                  number_format($v['TOTAL_VIEW'],0,',','.'),
                  $v['SPOT']
              )
          );
          $idx++;
      }		
      $result["data"] = $data;
      
      $this->json_result($result);
	}
	
	
	public function get_filter_adspeformance2(){
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
	  
	  
	  if( !empty($this->Anti_si($_GET['get_product'])) ) {
          $get_product = $this->Anti_si($_GET['get_product']);
      } else {
          $get_product = "";
      }  
	  
	  if( !empty($this->Anti_si($_GET['get_program'])) ) {
          $get_program = $this->Anti_si($_GET['get_program']);
      } else {
          $get_program = "";
      }
    
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 20;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('DATE','DATE', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'HOUSE_NUMBER', 'START_TIME', 'DURASI', 'RATE'); // , 'COST'
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
      $params['get_product']	= $get_product; 
      $params['get_program']	= $get_program; 
 
      
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
      
       $list = $this->postbuyadspeformance_model->_get_filter_adspeformance2($params);
      //print_r($list);die;
 	  
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      $data = array();	
      
      $idx = 0;
      
      $array_channel = $this->array_channel();
      
	  $grp = 0;
	  $cost = 0;
	  //$tr = 0;
      foreach ( $list['data'] as $k => $v ) {
          
		  $v['TVR'] = $v['VIEWERS']/$v['UNIVERSE'];
		  $v['REACH0'] = (($v['VIEWERS']/$v['UNIVERSE'])*100)*$v['UNIVERSE']/1000;
		  $v['REACH01'] = ($v['VIEWERS']/$v['UNIVERSE'])*100;
		  
          if($v['VIEWERS'] == ''){
			  $v['VIEWERS'] = 0;
			  $v['UNIVERSE'] = 0;
			  $v['TVR'] = 0;
			  $v['REACH0'] = 0;
			  $v['REACH01'] = 0;
		  }
		  
          array_push($data,  
              array(
                  $v['DATE'],
				  $v['DAYENAME'],
                  $v['WEEKNAME'],
                  $v['CHANNEL'],	
				  $v['PROGRAM'],				  
				  $v['NAMA_BRAND'],				  
				  $v['ADVERTISER'],				  
				  $v['AGENCY'],				  
				  $v['PO_NUMBER'],				  
                  $v['START_TIME'],	
					1,				  
                  $v['DURATION'],					
                  number_format(($v['TVR'])*100,2,',','.'),
                  number_format($v['VIEWERS'],0,',','.'),
                  number_format($v['REACH0'],2,',','.'), 
                  number_format($v['REACH01'],2,',','.'),
                  number_format($v['IDX'],2,',','.')
                  
              )
          );
		  
		  $grp = $grp + $v['TVR'];
          $idx++;
      }		 
	 
	  $summary['grp'] = $grp;
	  $summary['spot'] = $idx;
	  
      $result["data"] = $data;
       
      $this->json_result($result);
	}
  
	public function get_filter_grandtotal_adspeformance_summ2(){
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
	  
	  	  if( !empty($this->Anti_si($_GET['get_product'])) ) {
          $get_product = $this->Anti_si($_GET['get_product']);
      } else {
          $get_product = "";
      }
	  
	    if( !empty($this->Anti_si($_GET['get_program'])) ) {
          $get_program = $this->Anti_si($_GET['get_program']);
      } else {
          $get_program = "";
      }
 
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 20;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('DATE','DATE', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'HOUSE_NUMBER', 'START_TIME', 'DURASI', 'RATE'); // , 'COST'
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
	   $params['get_product']	= $get_product; 
      $params['get_program']	= $get_program; 
 
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
      
       $list = $this->postbuyadspeformance_model->_get_filter_adspeformance2_ss($params);
      
 	  
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      $data = array();	
      
      $idx = 0;
      
      $array_channel = $this->array_channel();
      
	  $grp = 0;
	  $cost = 0;
	  
	  $min = 0;
	  $max = 0;
	  //$tr = 0;
      foreach ( $list['data'] as $k => $v ) {
          
          
          array_push($data, 
              array(
                  $v['TANGGAL'],
                  $v['CHANNEL'],	
				  $v['PROGRAM'],				  
				  $v['PRODUCT'],				  
				  $v['HOUSE_NUMBER'],				  
                  $v['START_TIME'],					
                  $v['DURASI'],					
				  number_format( $v['TVR'],2,',','.'),
                  number_format($v['VIEWERS'],0,',','.')
                  
              )
          );
		  
		  if($min == 0){
			  $min = $v['TVR'];
		  }else{
			  if($min > $v['TVR']){
				  $min = $v['TVR'];
			  }
		  }
		  
		   if($max == 0){
			  $max = $v['TVR'];
		  }else{
			  if($max < $v['TVR']){
				  $max = $v['TVR'];
			  }
		  }
		  
		  $grp = $grp + ($v['TVR']);
		  $cost = $cost + $v['PRICE'];
          $idx++;
		  
      }		 
	  
	   $spot = $idx;
	  
	  if($grp == 0){
		  $cprpp = 0;
		  $avgtvrs = 0;
	  }else{
		  $cprpp = $cost/$grp;
		  $avgtvrs = $grp/$spot;
	  }
	  
	 
	  $html = '<div ><h4><b>Summary</b></h4></div>
								<table class="table table-striped"  >
								<thead>
										</thead>
	  									<tr>
										<td>Total Spot</td>
										<td id="spot" align="right">'.number_format($spot,0,',','.').'</td>
									</tr>
									<tr>
										<td>Total Cost</td>
										<td id="sumcost" align="right">Rp. '.number_format($cost,0,',','.').'</td>
									</tr>
									<tr>
										<td>GRP</td>
										<td id="sumtvr" align="right">'.number_format($grp,2,',','.').'</td>
									</tr>
									<tr>
										<td>CPRP</td>
										<td id="cprp" align="right">Rp. '.number_format($cprpp,2,',','.').'</td>
									</tr>
									<tr>
										<td>Max TVR</td>
										<td id="maxtvr" align="right">'.number_format($max,2,',','.').'</td>
									</tr>
									<tr>
										<td>Min TVR</td>
										<td id="mintvr" align="right">'.number_format($min,2,',','.').'</td>
									</tr>
									<tr>
										<td>Avg TVR</td>
										<td id="avgtvr" align="right">'.number_format($avgtvrs,2,',','.').'</td>
									</tr>
									</table>
	  ';
	  
 	  
	  $summary['grp'] = number_format($grp,2,',','.');
	  $summary['spot'] = number_format($spot,0,',','.');
	  $summary['cost'] = number_format($cost,0,',','.');
	  $summary['maxtvr'] = number_format($max,2,',','.');
	  $summary['mintvr'] = number_format($min,2,',','.'); 
	  $summary['cprp'] = number_format($cprpp,2,',','.');
	  $summary['avgtvr'] = number_format( $avgtvrs,2,',','.');
	  $summary['tbl'] = $html;
	  
	  
	  
		if($profile == 1){
			$params['univ'] = 19479392;
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach_all($params);
		}elseif($profile == 0){
			$params['univ'] = 17328363;
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach_all($params);
		}else{
			$get_univ = $this->postbuyadspeformance_model->get_univ($params);
			$params['univ'] = $get_univ[0]['respondents_all'];
			$params['flag'] = $get_univ[0]['flag'];
			$list_reach = $this->postbuyadspeformance_model->_get_filter_adspeformance2_reach($params);
		}
 
	  if(count($list_reach) == 0 ){
		  $html2 = '
		  <div ><h4> <b>Reach & Frequency</b> </h4></div>
								<table class="table table-striped"  >
									<thead>
										</thead>
								
	  									<tr>
										<td>Reach 1+</td>
										<td id="spot" align="right"></td>
									</tr>
									<tr>
										<td>Reach 2+</td>
										<td id="sumcost" align="right"></td>
									</tr>
									<tr>
										<td>Reach 3+</td>
										<td id="sumtvr" align="right"></td>
									</tr>
									<tr>
										<td>Reach 7+</td>
										<td id="cprp" align="right"></td>
									</tr>
									<tr>
										<td>Reach 13+</td>
										<td id="maxtvr" align="right"></td>
									</tr>
									<tr>
										<td>Reach 21+</td>
										<td id="mintvr" align="right"></td>
									</tr>
									<tr>
										<td>Avg Freq</td>
										<td id="avgtvr" align="right"></td>
									</tr>
									</table>
	  ';
	   $summary['tbl2'] = $html2;
	  }else{
	  
	  if($list_reach[0]['REACH_1'] == 0){
		  $freq = 0;
	  }else{
		  $freq = $grp/$list_reach[0]['REACH_1'];
	  }
	  
	  $html2 = '
	  <div ><h4> <b>Reach & Frequency</b> </h4></div>
								<table class="table table-striped"  >
									<thead>
										</thead>
	  									<tr>
										<td>Reach 1+</td>
										<td id="spot" align="right">'.number_format($list_reach[0]['REACH_1'],2,',','.').'</td>
										<td align="right">'.number_format(($list_reach[0]['REACH_1']*$params['univ'])/1000,0,',','.').'</td>
									</tr>
									<tr>
										<td>Reach 2+</td>
										<td id="sumcost" align="right">'.number_format($list_reach[0]['REACH_2'],2,',','.').'</td>
										<td align="right">'.number_format(($list_reach[0]['REACH_2']*$params['univ'])/1000,0,',','.').'</td>
									</tr>
									<tr>
										<td>Reach 3+</td>
										<td id="sumtvr" align="right">'.number_format($list_reach[0]['REACH_3'],2,',','.').'</td>
										<td align="right">'.number_format(($list_reach[0]['REACH_3']*$params['univ'])/1000,0,',','.').'</td>
									</tr>
									<tr>
										<td>Reach 7+</td>
										<td id="cprp" align="right">'.number_format($list_reach[0]['REACH_7'],2,',','.').'</td>
										<td align="right">'.number_format(($list_reach[0]['REACH_7']*$params['univ'])/1000,0,',','.').'</td>
									</tr>
									<tr>
										<td>Reach 13+</td>
										<td id="maxtvr" align="right">'.number_format($list_reach[0]['REACH_13'],2,',','.').'</td>
										<td align="right">'.number_format(($list_reach[0]['REACH_13']*$params['univ'])/1000,0,',','.').'</td>
									</tr>
									<tr>
										<td>Reach 21+</td>
										<td id="mintvr" align="right">'.number_format($list_reach[0]['REACH_21'],2,',','.').'</td>
										<td align="right">'.number_format(($list_reach[0]['REACH_21']*$params['univ'])/1000,0,',','.').'</td>
									</tr>
									<tr>
										<td>Avg Freq</td>
										<td></td>
										<td id="avgtvr" align="right">'.number_format(ceil($freq),0,',','.').'</td>
									</tr>
									</table>
	  ';
	   $summary['tbl2'] = $html2;
	   
	  }
 	  
      $result["data"] = $summary;
 
      
      $this->json_result($result);
	}
  
  
	public function get_filter_grandtotal_adspeformance(){
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
          $list_id = $this->postbuyadspeformance_model->get_user_id($_GET['profile']);
          $a =  $list_id[0]['grouping'];
          
          $b = json_decode($a,true);
          
          $i = 0;
          $in_kota = "";
          $in_per = "";
          $in_dem = "";
          
          foreach($b as $arr){
              $sqlf = "";
              $in = "";
              if($arr['Header'] == "KOTA"){
                  foreach($arr['Data'] as $head){
                      $in_kota =$in_kota.",'".$head."'";
                  }
              } elseif($arr['Header'] == "HELIX_COMM") {
                  foreach($arr['Data'] as $head){
                      $in_per = $in_per.",'".$head."'";
                  } 
              } elseif($arr['Header'] == "DEMOGRAFI") {
                  foreach($arr['Data'] as $head){
                      $in = $in.",'".$head."'";
                  }
                  
                  $in_c[$i] = substr($in, 1);
                  
                  $sqlf = " ".$arr['Tag']." IN (".$in_c[$i].")";
                  
                  $sql = $sql.$sqlf." AND"; 
              }
          }
          
          if($in_kota <> ""){
              $in_kota = substr($in_kota, 1);
              $sqlk = " KOTA IN (".$in_kota.")";
              
              $sql = $sql.$sqlk." AND"; 
          }
          
          if($in_per <> ""){
              $in_per = substr($in_per, 1);
              $sqlkp = " PERSONAS IN (".$in_per.")";
              
              $sql = $sql.$sqlkp." AND"; 
          }
          
          $sql_c = substr($sql, 0,-3);
          
      }else{
          $params['user_id'] = "";
          $sql_c = "";
      }
       
      $params['sqlc'] = $sql_c;
      
 	   $starts = explode("-",$params['start_date']);
	  
	  $d=cal_days_in_month(CAL_GREGORIAN,$starts[1],$starts[0]);
 	  
	  if($starts[2] == "01" && $params['end_date'] == $starts[0]."-".$starts[1]."-".$d){
 		   $reach = $this->postbuyadspeformance_model->get_reach_m($params,0);
	  }else{
 		   $reach = $this->postbuyadspeformance_model->get_reach($params,0);
	  }
 
      
      if($reach[0]['REACH0'] == 0){
          $af = 0;
      }else{
          $listt = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params); 
          $af = ceil($listt[0]['sumtvr']/$reach[0]['REACH0']);
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
      
      $result["data"] = $data;
       	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
  
	public function get_filter_grandtotal_adspeformance_summ(){
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
	  
	   if( !empty($this->Anti_si($_GET['get_product'])) ) {
          $get_product = $this->Anti_si($_GET['get_product']);
      } else {
          $get_product = "";
      }
	  
	   if( !empty($this->Anti_si($_GET['get_program'])) ) {
          $get_program = $this->Anti_si($_GET['get_program']);
      } else {
          $get_program = "";
      }
      
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']		= $kategori;		
      $params['chnl']	= $chnl;            
		$params['get_product']	= $get_product; 
$params['get_program']	= $get_program; 		
       
      $list = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params);
	 // print_r($list);die;
       $content = '';
	  
	  $i = 1;
	  $views_tot = 0;
	  $spots_tot = 0;
	  $vgvps_tot = 0;
	  $price_tot = 0;
	  $arr_chann = array();
	  $arr_views = array();
	  
	  foreach($list as $listy){
		  
		   if($i % 2 == 0){
			   
			   $cl = 'role="row" class="odd"';
			   
		   }else{
			   $cl = 'role="row" class="even"';
		   }
		  
		  $content = $content.'<tr '.$cl.'><td>'.$i.'</td><td>'.$listy['CHANNEL'].'</td><td align="right">'.number_format($listy['VIEWS'],0,',','.').'</td><td align="right">'.number_format($listy['SPOT'],0,',','.').'</td><td align="right">'.number_format(ceil($listy['VG_VPS']),0,',','.').'</td></tr>';
		  
		  $views_tot = $views_tot + $listy['VIEWS'];
		  $spots_tot = $spots_tot + $listy['SPOT'];
		  $vgvps_tot = $vgvps_tot + $listy['VG_VPS'];
		  $price_tot = $price_tot + $listy['PRICE'];
		  
		  $arr_chann[] = $listy['CHANNEL'];
		  $arr_views[] = intval($listy['VIEWS']);
		  $i++;
	  }
	  
	  IF($i==1){
		  
		    $total_content = '<tr><td colspan="2">Total</td><td align="right">'.number_format($views_tot,0,',','.').'</td><td align="right">'.number_format($spots_tot,0,',','.').'</td><td align="right">'.number_format(ceil($vgvps_tot),0,',','.').'</td></tr>';
		  
		  $tbl_12 = ' <table id="example12" class="table table-striped"><thead style="color:red"><tr><th style="color:red">No </th><th style="">Channel </th><th style="">Views </th><th style="">Spot </th><th style="">Avg Views Per Spot </th></tr>'.$content.''.$total_content.'</thead></table>';
		  
		   $tbl_22 = ' <table id="example22" class="table table-striped "><thead style="color:red"><tr><td style="">Total Views</td><td align="right">'.number_format($views_tot,0,',','.').'</td></tr><tr><td style="">Total Cost</td><td align="right">Rp. '.number_format($price_tot,0,',','.').'</td></tr><tr><td style="">Total Spot</td><td align="right"> '.number_format($spots_tot,0,',','.').'</td></tr><tr><td style="">Average View per Spot</td><td align="right"> '.number_format(0,0,',','.').'</td></tr><tr><td style="">Average Cost per Spot</td><td align="right">Rp. '.number_format(0,0,',','.').'</td></tr><tr><td style="">Average Cost per Views</td><td align="right">Rp. '.number_format(0,0,',','.').'</td></tr></thead></table>';
		  
		  $result["data"][0] = $tbl_12;
		  $result["data"][1] = $tbl_22;
		  $result["data"][2] = $arr_chann;
		  $result["data"][3] = $arr_views;
		  
	  }else{
	  
		  $total_content = '<tr><td colspan="2"><b>Total</b></td><td align="right"><b>'.number_format($views_tot,0,',','.').'</b></td><td align="right"><b>'.number_format($spots_tot,0,',','.').'</b></td><td align="right"><b>'.number_format(ceil($vgvps_tot),0,',','.').'</b></td></tr>';
		  
		  $tbl_12 = ' <table id="example12" class="table table-striped"><thead style=""><tr><th style="color:red">No </th><th style="color:red">Channel </th><th style="color:red">Views </th><th style="color:red">Spot </th><th style="color:red">Avg Views Per Spot </th></tr>'.$content.''.$total_content.'</thead></table>';
		  
		   $tbl_22 = ' <table id="example22" class="table table-striped"><thead ><tr><td style="">Total Views</td><td align="right">'.number_format($views_tot,0,',','.').'</td></tr><tr><td style="">Total Cost</td><td align="right">Rp. '.number_format($price_tot,0,',','.').'</td></tr><tr><td style="">Total Spot</td><td align="right"> '.number_format($spots_tot,0,',','.').'</td></tr><tr><td style="">Average View per Spot</td><td align="right"> '.number_format($views_tot/$spots_tot,0,',','.').'</td></tr><tr><td style="">Average Cost per Spot</td><td align="right">Rp. '.number_format($price_tot/$spots_tot,0,',','.').'</td></tr><tr><td style="">Average Cost per Views</td><td align="right">Rp. '.number_format($price_tot/$views_tot,0,',','.').'</td></tr></thead></table>';
		  
		  $result["data"][0] = $tbl_12;
		  $result["data"][1] = $tbl_22;
		  $result["data"][2] = $arr_chann;
		  $result["data"][3] = $arr_views;
	  
	  }
 
      $this->output->set_content_type('Application/json')->set_output(json_encode($result,true));
  }                                       
    
  public function listsearch(){
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
      
      $list = $this->postbuyadspeformance_model->listsearch($this->Anti_si($_GET['q']),$this->Anti_si($_GET['c']),$start_date,$end_date);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                                        
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->postbuyadspeformance_model->profilesearch($this->Anti_si($_GET['q']),$iduser,$this->Anti_si($_GET['f']));
      
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
      $list = $this->postbuyadspeformance_model->get_profile($iduser,$idrole,$this->Anti_si($_GET['f']));          
                               
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                     
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->postbuyadspeformance_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
  
  public function download_video(){
      $filename = $this->Anti_si($_GET['f']);
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
      $chunkFilename = "/var/www/html/app/tmp_video/".$newFilenameArr[2];
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