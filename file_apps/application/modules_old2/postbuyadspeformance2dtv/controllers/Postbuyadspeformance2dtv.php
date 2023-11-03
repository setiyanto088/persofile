<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Postbuyadspeformance2dtv extends JA_Controller {
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
      
      $this->template->load('maintemplate', 'postbuyadspeformance2dtv/views/Postbuyadspeformance', $data);
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
	  $params['svg']	= $svg;
	  
		$datag = $svg;

		$img = str_replace('data:image/png;base64,', '', $datag);
		$img = str_replace(' ', '+', $img);
		$datadsd = base64_decode($img);
		
		$filename = 'image'.time().'.png';
		file_put_contents('/var/www/html/tmp_doc/image/'.$filename, $datadsd);
	  
	   $list = $this->postbuyadspeformance_model->_get_filter_adspeformance_pr($params);
	   
	   $table1 = '';
	   
	    foreach($list['data'] as $frt){
			
			$table1 = $table1.'<tr style="border: 1px solid black;">
				<th style="border: 1px solid black;" align="left">'.$frt['CHANNEL'].'</th>
				<th style="border: 1px solid black;" align="left">'.$frt['TANGGAL'].'</th>
				<th style="border: 1px solid black;" align="left">'.$frt['START_TIME'].'</th>
				<th style="border: 1px solid black;" align="rigth">'.$frt['TOTAL_VIEW'].'</th>
				<th style="border: 1px solid black;" align="left">'.$frt['SPOT'].'</th>
			</tr>';
			
		}
	   
	    $list2 = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params);
 		
		 $content = '';
	  
		  $i = 1;
		  $views_tot = 0;
		  $spots_tot = 0;
		  $vgvps_tot = 0;
		  $price_tot = 0;
		  $arr_chann = array();
		  $arr_views = array();
		  
		foreach($list2 as $listy){
		  
		   if($i % 2 == 0){
			   
			   $cl = 'role="row" class="odd"';
			   
		   }else{
			   $cl = 'role="row" class="even"';
		   }
		  
		  $content = $content.'<tr '.$cl.'><td>'.$i.'</td><td>'.$listy['CHANNEL'].'</td><td>'.number_format($listy['VIEWS'],0,',','.').'</td><td>'.number_format($listy['SPOTS'],0,',','.').'</td><td>'.number_format(ceil($listy['VG_VPS']),0,',','.').'</td></tr>';
		  
		  $views_tot = $views_tot + $listy['VIEWS'];
		  $spots_tot = $spots_tot + $listy['SPOTS'];
		  $vgvps_tot = $vgvps_tot + $listy['VG_VPS'];
		  $price_tot = $price_tot + $listy['PRICE'];
		  
		  $arr_chann[] = $listy['CHANNEL'];
		  $arr_views[] = intval($listy['VIEWS']);
		  $i++;
		}
		
 		
		$total_content = '<tr><td colspan="2">Total</td><td>'.number_format($views_tot,0,',','.').'</td><td>'.number_format($spots_tot,0,',','.').'</td><td>'.number_format(ceil($vgvps_tot),0,',','.').'</td></tr>';
 	 $tbl_22 = ' <table id="example22" class="table table-striped table-bordered urate-table"><thead><tr><td style="">Total Views</td><td style="">'.number_format($views_tot,0,',','.').'</td></tr><tr><td style="">Total Cost</td><td>Rp. '.number_format($price_tot,0,',','.').'</td></tr><tr><td style="">Total Spot</td><td style=""> '.number_format($spots_tot,0,',','.').'</td></tr><tr><td style="">Average View per Spot</td><td style=""> '.number_format($views_tot/$spots_tot,0,',','.').'</td></tr><tr><td style="">Average Cost per Spot</td><td style="">Rp. '.number_format($price_tot/$spots_tot,0,',','.').'</td></tr><tr><td style="">Average Cost per View</td><td style="">Rp. '.number_format($price_tot/$views_tot,0,',','.').'</td></tr></thead></table>';
	   
 
		$img = '<div><br><img src="/var/www/html/tmp_doc/UseeTV.png" border="0" width="40px" /></div>';
		
		$rtext = '<br><p style="font-size: 8px">'.$kategoriby.' : '.$kategori.'<br>Periode : '.$start_date.' / '.$end_date.'</p> ';
		
		$ctext = '<br><p style="font-size: 12px"> REPORT LOG PROOF '.$kategori.' </p> ';
 		$html2 = '

		<!doctype html><html lang="en"><head>

					<title>Postbuy Analitycs</title>

					<style type="text/css">
						* {
							font-family: Verdana, Arial, sans-serif;
						}
						table{
							font-size: 8px;
							border: 1px solid black;
						}
						table tr td{
							
							border: 1px solid black;
						}
						tfoot tr td{
							font-weight: bold;
							font-size: x-small;
						}
						.gray {
							background-color: lightgray
						}
						p {
							font-size: 8px;
							
						}
					</style>

					</head><body>
					
					<div style=" float:left;">  
					  <table width="100%" style=" border: 1px solid black;">
						<tr style="border: 1px solid black;">
							<th style="border: 1px solid black;" align="left">No</th>
							<th style="border: 1px solid black;" align="left">Channel</th>
							<th style="border: 1px solid black;" align="left">View</th>
							<th style="border: 1px solid black;" align="left">Spot</th>
							<th style="border: 1px solid black;" align="left">View per Spot</th>
						</tr>'.$content.''.$total_content.'
						</table>
						
						<br><br>
						<table cellpadding="1" cellspacing="1" border="0" style="text-align:center;">
						<tr><td><img src="/var/www/html/tmp_doc/image/'.$filename.'" border="0" /></td></tr>
						</table>
						<br><br>
						'.$tbl_22.'
					  
					</div>';
		
		$html ='<!doctype html><html lang="en"><head>

					<title>Postbuy Analitycs</title>

					<style type="text/css">
						* {
							font-family: Verdana, Arial, sans-serif;
						}
						table{
							font-size: 8px;
							border: 1px solid black;
						}
						table tr td{
							
							border: 1px solid black;
						}
						tfoot tr td{
							font-weight: bold;
							font-size: x-small;
						}
						.gray {
							background-color: lightgray
						}
						
						p {
							font-size: 8px;
							
						}
					</style>

					</head><body>
					
					<div style=" float:left;">
					  <table style=" float:left;border: 1px solid black;" >
						<tr style="border: 1px solid black;">
							<th style="border: 1px solid black;" align="left" >Channel</th>
							<th style="border: 1px solid black;" align="left">Date</th>
							<th style="border: 1px solid black;" align="left">Time</th>
							<th style="border: 1px solid black;" align="left">Total Views</th>
							<th style="border: 1px solid black;" align="left">Spot</th>
						</tr>
						'.$table1.'
					  </table>
					</div>';
	
 		
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

		$y = $pdf->getY();
		
 				// set color for background
		$pdf->SetFillColor(255, 255, 255);

		// set color for text
		$pdf->SetTextColor(0, 0, 0);
		
		$pdf->writeHTMLCell(120, '', '', $y, $rtext, 0, 0, 1, true, 'L', true);
		
		// set color for background
		$pdf->SetFillColor(255, 255, 255);

		// set color for text
		$pdf->SetTextColor(0, 0, 0);
		
		$pdf->writeHTMLCell(80, '', '', '', $img, 0, 1, 1, true, 'R', true);
		
		$y = $pdf->getY();
		
 				// set color for background
		$pdf->SetFillColor(255, 255, 255);

		// set color for text
		$pdf->SetTextColor(0, 0, 0);
		
		$pdf->writeHTMLCell(180, '', '', $y, $ctext, 0, 1, 1, true, 'C', true);
		
		$y = $pdf->getY();
		
 				// set color for background
		$pdf->SetFillColor(255, 255, 255);

		// set color for text
		$pdf->SetTextColor(0, 0, 0);
		
		$pdf->writeHTMLCell(120, '', '', $y, $html, 0, 0, 1, true, 'J', true);
		
		// set color for background
		$pdf->SetFillColor(255, 255, 255);

		// set color for text
		$pdf->SetTextColor(0, 0, 0);
		
		$pdf->writeHTMLCell(80, '', '', '', $html2, 0, 1, 1, true, 'J', true);
		
		
		$pdf->SetPrintFooter(false);
		
		$pdf->lastPage();
 

		$pdf->Output('/var/www/html/tmp_doc/Report_Postbuy.pdf', 'F');

		if ( $list ) {			
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
					->setCellValue('A1', 'Channel')
					->setCellValue('B1', 'Date')
					->setCellValue('C1', 'Time')
					->setCellValue('D1', 'Total Views')
					->setCellValue('E1', 'Spot');
	   
	   $it1 = 2;
		 foreach($list['data'] as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['CHANNEL'])
					->setCellValue('B'.$it1, $frt['TANGGAL'])
					->setCellValue('C'.$it1, $frt['START_TIME'])
					->setCellValue('D'.$it1, $frt['TOTAL_VIEW'])
					->setCellValue('E'.$it1, $frt['SPOT']);

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
					->setCellValue('D'.$ti2, $listy['SPOTS'])
					->setCellValue('E'.$ti2, ceil($listy['VG_VPS']));
		    
		  $views_tot = $views_tot + $listy['VIEWS'];
		  $spots_tot = $spots_tot + $listy['SPOTS'];
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
		
		$objPHPExcel->getActiveSheet()->setTitle('Postbuy Report Summary');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
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
      
      if($this->Anti_si($_GET['profile']) <> "0"){
          $list_id = $this->postbuyadspeformance_model->get_user_id($this->Anti_si($_GET['profile']));
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
      
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['profile']		= $profile;
      $params['kategoriby']	= $kategoriby;
      $params['kategori']		= $kategori;		
      $params['chnl']	= $chnl;                                                              
       
      $list = $this->postbuyadspeformance_model->get_filter_grandtotal_adspeformance($params);
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
		  
		  $content = $content.'<tr '.$cl.'><td>'.$i.'</td><td>'.$listy['CHANNEL'].'</td><td align="right">'.number_format($listy['VIEWS'],0,',','.').'</td><td align="right">'.number_format($listy['SPOTS'],0,',','.').'</td><td align="right">'.number_format(ceil($listy['VG_VPS']),0,',','.').'</td></tr>';
		  
		  $views_tot = $views_tot + $listy['VIEWS'];
		  $spots_tot = $spots_tot + $listy['SPOTS'];
		  $vgvps_tot = $vgvps_tot + $listy['VG_VPS'];
		  $price_tot = $price_tot + $listy['PRICE'];
		  
		  $arr_chann[] = $listy['CHANNEL'];
		  $arr_views[] = intval($listy['VIEWS']);
		  $i++;
	  }
	  
	  $total_content = '<tr><td colspan="2"><b>Total</b></td><td align="right"><b>'.number_format($views_tot,0,',','.').'</b></td><td align="right"><b>'.number_format($spots_tot,0,',','.').'</b></td><td align="right"><b>'.number_format(ceil($vgvps_tot),0,',','.').'</b></td></tr>';
	  
	  $tbl_12 = ' <table id="example12" class="table table-striped"><thead><tr style="color:red"><th style="">No </th><th style="">Channel </th><th style="">View </th><th style="">Spot </th><th style="">Avg View Per Spot </th></tr>'.$content.''.$total_content.'</thead></table>';
	  
	   $tbl_22 = ' <table id="example22" class="table table-striped"><thead><tr><td style="">Total Views</td><td align="right">'.number_format($views_tot,0,',','.').'</td></tr><tr><td style="">Total Cost</td><td align="right">Rp. '.number_format($price_tot,0,',','.').'</td></tr><tr><td style="">Total Spot</td><td align="right"> '.number_format($spots_tot,0,',','.').'</td></tr><tr><td style="">Average View per Spot</td><td align="right"> '.number_format($views_tot/$spots_tot,0,',','.').'</td></tr><tr><td style="">Average Cost per Spot</td><td align="right">Rp. '.number_format($price_tot/$spots_tot,0,',','.').'</td></tr><tr><td style="">Average Cost per View</td><td align="right">Rp. '.number_format($price_tot/$views_tot,0,',','.').'</td></tr></thead></table>';
      
      $result["data"][0] = $tbl_12;
      $result["data"][1] = $tbl_22;
      $result["data"][2] = $arr_chann;
      $result["data"][3] = $arr_views;
     
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