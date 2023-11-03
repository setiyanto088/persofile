<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramuntrans extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}

	public function filter_days(){
		
		$type =  $this->input->post('audiencebarday');
		$periode =  $this->input->post('periode');
		$where = '';
		
		if($type == 'Viewers'){
			$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2_viewer($where,$periode);
		}elseif($type == 'Duration'){
			$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2_duration($where,$periode);
		}else{
			$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		}
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = $datasss['date'];
				$spot_date[] = floatval($datasss['spot']);
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		
		echo json_encode($data,true); 
		//echo $type;die;
		
	}

	public function audiencebar_by_program_export(){
		
		
		$where = '';
		
		 if( !empty($this->input->post('periode')) ) {
			  $periode = date_format(date_create($this->input->post('end_date')),"Y-F");
		  } else {
			  $periode = date_format(date_create($this->input->post('end_date')),"Y-F");
		  }
		  
		   if( !empty($this->input->post('type')) ) {
			  $type = $this->input->post('type');
		  } else {
			  $type = 'Viewers';
		  }
		  
		   if( !empty($this->input->post('profile_prog')) ) {
			  $profile = $this->input->post('profile_prog');
		  } else {
			  $profile = '0';
		  }
		  
		   if( !empty($this->input->post('start_date')) ) {
			  $start_date = $this->input->post('start_date');
		  } else {
			  $start_date = '0';
		  }
		  
		   if( !empty($this->input->post('tipe_filter_prog')) ) {
			  $tipe_filter = $this->input->post('tipe_filter_prog');
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($this->input->post('end_date')) ) {
			  $end_date = $this->input->post('end_date');
		  } else {
			  $end_date = '0';
		  }
		  
		 //  $check = $_GET['check'];
		   if( !empty($this->input->post('check')) ) {
			  $check = $this->input->post('check');
		  } else {
			  $check = 'False';
		  }

		  if( !empty($this->input->post('check2')) ) {
			  $check2 = $this->input->post('check2');
		  } else {
			  $check2 = 'False';
		  }
		  
		   if( !empty($_GET['searchtxt']) ) {
			  $searchtxt = $_GET['searchtxt'];
		  } else {
			  $searchtxt = "";
		  }
		  
		   if( !empty($_GET['channel']) ) {
			  $searchtxt = $_GET['channel'];
			  
			  if($_GET['channel'] == 'All'){
				  $where = '';
			  }else{
				 // $where = ' AND CHANNEL = "'.$_GET['channel'].'" ';
				  $where = '  ';
			  }
			  
		  } else {
			  $searchtxt = "";
		  }
		  
		
		// $where =  $this->input->post('cond');
		// $type =  $this->input->post('pilihprog');
		// $tahun=$this->input->post('tahun');
		// $bulan=$this->input->post('bulan');
		// $profile=$this->input->post('profile_prog');
		// $nmonth = date("m", strtotime($tahun));
		// $week=$this->input->post('week');
		// $tgl=$this->input->post('tgl');
		// $periode=$this->input->post('periode');
		// $check=$this->input->post('check');
		// $tipe_filter=$this->input->post('tipe_filter');
		  
		 // echo $tgl;die;
		  
		  $where = '';
		  $pilihprog = $type;
		  		  
		   	if 	($type=='GRP')	 {
				$types = 'GRP';
			}elseif ($type=='Viewers')	 {
				$types = 'Total Views';
			}elseif ($type=='TVR')	 {
				$types = 'TVR';
			}elseif ($type=='Duration')	 {
				$types = 'Duration';
			}elseif ($type=='share')	 {
				$types = 'Audience Share';
			}elseif ($type=='avgtotdur')	 {
				$types = 'AVG Dur/Views';
			}elseif ($type=='Reach')	 {
				$types = 'Reach';
			}else{
				$types = 'Audience';
			}
		 
			$params['periode'] 	= $periode;
		//	$params['week'] 	= $week;
			$params['searchtxt'] 	= "";
			$params['check'] 	= $check;
			$params['check2'] 	= $check2;
			//$params['searchtxt'] 	= $_GET['search']['value'];
			
			
			//$params['tgl'] 	= $tgl;
			
			// $nmonth = date("m", strtotime($periode));
			// $datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			// $datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			// $params['tgl'] 	= $datefF;
		$date_periode = $this->tvprogramun_model->get_periode_date($periode);
		//print_r($date_periode);die;
		
		if($tipe_filter == 'live'){
		
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL'] ){
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_alls_print("Program",$where,$params,$pilihprog,$profile);
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_avg_alls_print("Program",$where,$params,$pilihprog,$profile,$start_date,$end_date);
				//ECHO "SSS";DIE;
			}
		}
		
		//print_r($list);die; 
				
		    $data = array();	
			  $idx = 1; 
			  
			  if($pilihprog == 'TVR' || $pilihprog == 'TVS' || $pilihprog == 'Reach' || $pilihprog == 'avgtotdur' || $pilihprog == 'avgtotaud' || $pilihprog == 'IDX'){
				  $decs = 2;
			  }elseif($pilihprog == 'Audience2'){
				  $decs = 0;
			  }else{
				  $decs = 3;
			  }
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			  
		   foreach ( $list['data'] as $k => $v ) {
			   
				array_push($data, 
					  array(
						  number_format($idx,0,',','.'),
						  $v['PROGRAM'],
						  $v['CHANNEL'],
						  number_format($v['AUDIENCE'],0,',','.'),
						  number_format($v['VIEWERS'],3,',','.'),
						   number_format($v['TVR'],2,',','.'),
						  number_format($v['TVS'],2,',','.'),
						   number_format($v['INDEX'],2,',','.'),
						  number_format($v['REACH'],2,',','.')
						   
						  
					  )
					);
					$idx++;
		   }
			 $result["data"] = $data;
			 
			//var_dump($data);die;  
		// $result["recordsTotal"] = $list['total'];
		// $result["recordsFiltered"] = $list['total_filtered'];
		// $result["draw"] = $draw;
		// //$result["data"] = $list['data'];
	  
			// $this->json_result($result);
			
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
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Program')
					->setCellValue('C1', 'Channel')
					->setCellValue('D1', 'Audience')
					->setCellValue('E1', 'Viewers')
					->setCellValue('F1', 'TVR')
					->setCellValue('G1', 'TVS')
					->setCellValue('H1', 'INDEX')
					->setCellValue('I1', 'Reach');
	   
	   $it1 = 2;
		 foreach($data as $frt){
			
			//print_r($frt);die;
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt[0])
					->setCellValue('B'.$it1, $frt[1])
					->setCellValue('C'.$it1, $frt[2])
					->setCellValue('D'.$it1, $frt[3])
					->setCellValue('E'.$it1, $frt[4]) 
					->setCellValue('F'.$it1, $frt[5]) 
					->setCellValue('G'.$it1, $frt[6]) 
					->setCellValue('H'.$it1, $frt[7]) 
					->setCellValue('I'.$it1, $frt[8]); 

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		
		// Redirect output to a client’s web browser (Excel2007)
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		// header('Cache-Control: max-age=0');
		// // If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');

		// // If you're serving to IE over SSL, then the following may be needed
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		//$objWriter->save('php://output');
		
		 //ob_end_clean();
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_program.xls');	
		
			
	}
	
	public function get_filter_programaud(){
		
		$where = '';
		
		 if( !empty($_GET['periode']) ) {
			  $periode = $_GET['periode'];
		  } else {
			  $periode = NULL;
		  }
		  
		   if( !empty($_GET['pilihprog']) ) {
			  $pilihprog = $_GET['pilihprog'];
		  } else {
			  $pilihprog = 'Viewers';
		  }
		  
		   if( !empty($_GET['profile']) ) {
			  $profile = $_GET['profile'];
		  } else {
			  $profile = '0';
		  }
		  
		   if( !empty($_GET['start_date2']) ) {
			  $start_date = $_GET['start_date2'];
		  } else {
			  $start_date = '0';
		  }
		  
		   if( !empty($_GET['tipe_filter_prog']) ) {
			  $tipe_filter = $_GET['tipe_filter_prog'];
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($_GET['end_date2']) ) {
			  $end_date = $_GET['end_date2'];
		  } else {
			  $end_date = '0';
		  }
		  
		 //  $check = $_GET['check'];
		   if( !empty($_GET['check']) ) {
			  $check = $_GET['check'];
		  } else {
			  $check = 'False';
		  }
		  
		  if( !empty($_GET['check2']) ) {
			  $check2 = $_GET['check2'];
		  } else {
			  $check2 = 'False';
		  }
		  
		   if( !empty($_GET['searchtxt']) ) {
			  $searchtxt = $_GET['searchtxt'];
		  } else {
			  $searchtxt = "";
		  }
		  
		   if( !empty($_GET['channel']) ) {
			  $searchtxt = $_GET['channel'];
			  
			  if($_GET['channel'] == 'All'){
				  $where = '';
			  }else{
				 // $where = ' AND CHANNEL = "'.$_GET['channel'].'" ';
				  $where = '  ';
			  }
			  
		  } else {
			  $searchtxt = "";
		  }
		  
		 
		  
		  
		  //$pilihprog = 'Viewers';
		  
		 //echo $where;die; 
		  
		   
		  if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		  if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		  if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		  $order_fields = array('TVR','PROGRAM','CHANNEL','TVR','TVS','VIEWERS','AUDIENCE','REACH','`INDEX`'); // , 'COST'
		  $order = $this->input->get_post('order');
		  if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		  if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		  
		    $params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['start_date'] 	= $start_date;
			$params['end_date'] = $end_date;
			//$params['week'] 	= $week;
			$params['check'] 	= $check;
			$params['check2'] 	= $check2;
			$params['searchtxt'] 	= $_GET['search']['value'];
			
			//var_dump($params);die;
			//$params['tgl'] 	= $tgl;
			
			$nmonth = date("m", strtotime($periode));
			$date_periode = $this->tvprogramun_model->get_periode_date($periode);
		
			// $datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			// $datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			// $params['tglf'] 	= $datef;
			// $params['tgl'] 	= $datefF;
		
			//echo $pilihprog;die; 
		
		if($tipe_filter == 'live'){
		
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL'] ){
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_alls("Program",$where,$params,$pilihprog,$profile);
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_avg_alls("Program",$where,$params,$pilihprog,$profile,$start_date,$end_date);
				//ECHO "SSS";DIE;
			}
		}
				
				//print_r($list);die;
				
		    $data = array();	
			  $idx = 0; 
			  $idxx = $params['offset']+1;
			  if($pilihprog == 'TVR' || $pilihprog == 'TVS' || $pilihprog == 'Reach' || $pilihprog == 'avgtotdur' || $pilihprog == 'avgtotaud' || $pilihprog == 'IDX'){
				  $decs = 2;
			  }elseif($pilihprog == 'Audience2'){
				  $decs = 0;
			  }else{
				  $decs = 3;
			  }
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2a($periode);
			  
		   foreach ( $list['data'] as $k => $v ) {
			   
			   // if($pilihprog == 'Reachww'){
				   // $re = ($v['Spot']/$totpopulasi[0]['tot_pop'])*100;
				   // $vvv =  "<p style='text-align:right;margin:0 0 0 0'>".number_format($re,$decs,',','.')."</p>";
			   // }else{
				   // $vvv =  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['Spot'],$decs,',','.')."</p>";
				   // $vvv2 =  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['Spot2'],$decs,',','.')."</p>";
			   // }
			   
			   if($pilihprog == 'avgtotaud'){
				   array_push($data, 
					  array(
						  number_format($v['Rangking'],0,',','.'),
						  $v['Program'],
						  $v['CHANNEL'],
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVR'],$decs,',','.')."</p>",
						  $vvv
					  )
					);
					$idx++;
			   }else{
			
					array_push($data, 
					  array(
						  number_format($idxx,0,',','.'),
						  $v['PROGRAM'],
						  $v['CHANNEL'],
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVR'],2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVS'],2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>". number_format($v['VIEWERS'],2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['AUDIENCE'],0,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format(($v['AUDIENCE']/$totpopulasi[0]['tot_pop'])*100,2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>100</p>"
						   
						  
					  )
					);
					$idx++;
					$idxx++;
			   }
		   }
			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		//$result["data"] = $list['data'];
	  
			$this->json_result($result);
			
	}
	
	 public function index2()
	{
		echo "Aaaaa";
		
	}
	
  public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		 
		 
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		// $data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		
		//print_r($data['thn']);die;
		
	
		
		//cek session login
		if(!$this->session->userdata('user_id')) { 
			//redirect ('/login');
		}
		
		if($this->input->post('filter_text')){
				
				$filter = $this->input->post('filter_text');
				$starttime = $this->input->post('starttime');
				$endtime = $this->input->post('endtime');
				$mindur = $this->input->post('mindur');
				$maxdur = $this->input->post('maxdur');
				
				
				
				$f_array = json_decode($filter,true);
				
				$where = " AND";
				foreach($f_array as $farray){
					
					
					if(isset($farray["children"])){
						
						$where = $where." ".$farray['id']." IN (";
						
						foreach($farray["children"] as $child){
							
							$where = $where."'".$child["id"]."',"; 
							
						}
						$where = rtrim($where, ",");
						
						$where = $where.") AND";
					}
					
				} 
				
				$where = rtrim($where, "AND");
				
				if($starttime <> "00:00:00"){
					
					$where = $where." AND DATE_FORMAT(STR_TO_DATE(start_time, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('".$starttime."', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(end_time, '%T'), '%T') < DATE_FORMAT(STR_TO_DATE('".$endtime."', '%T'), '%T') ";
					
				}
				
				if($mindur <> "00:00:00"){
					
					$where = $where." AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('".$mindur."', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') <= DATE_FORMAT(STR_TO_DATE('".$maxdur."', '%T'), '%T') ";
					
				}
			
		}else{
			
			$where = " ";
		}
		
		//echo $where;
		
		//die;
		
		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		// echo "jumlah hari".$this->days_in_month($bulan, $tahun) ;
		 //die;
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		//echo $nmonth;
		// print_r($this->days_in_month($bulan, $tahun));die;
		//echo "bulan".$bulan;
		$pilihaudiencebar=$this->input->post('audiencebar');
		
		//echo $pilihaudiencebar;die;
		
		$pilihprog=$this->input->post('product_program');
		
		if (!isset($tahun)){ 
			// $tahun="2017";
			// //$bulan="October"; 
			// $bulan="December";
			
			$tahun= $data['thn'][0]['TANGGAL'];
			//$data['aa'] = "765273";
		}
		$periode=$tahun;
		
		$array_periode = array('2020-September', '2020-October', '2020-November', '2020-December');
		
		// if(in_array($tahun,$array_periode)){  
			// //the magic
		// }else{
			// //echo $tahun; die;
			// //header("Location: https://inrate.id/app2/tvprogramunres2");
			// $this->index2();
			// die();
		// }
		
		//$this->tvprogramun_model->get_year_int($periode);
		
		
		
		//echo $periode; 
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole,$periode);
		
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['channel_list'] = $this->tvprogramun_model->channel_list($periode);
		//print_r($data['channel_list']);die;
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['active_audience2'] = $this->tvprogramun_model->get_active_audience2($periode);
		$data['aa'] = $data['active_audience'][0]['VIEWERS'];
		$data['aa2'] = $data['active_audience2'][0]['VIEWERS'];
		//echo "tahun ".$periode;
		//die;
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		$date_periode = $this->tvprogramun_model->get_periode_date($periode);
		
		if(!isset($date_periode[0]['STR_TGL'])){
			$data['STR_TGL'] = date('Y-m-d');
			$data['END_TGL'] = date('Y-m-d');
			
		}ELSE{
			$data['STR_TGL'] = $date_periode[0]['STR_TGL'];
			$data['END_TGL'] = $date_periode[0]['END_TGL'];
		}
		
		//var_dump($date_periode);die;
		//var_dump($data['spot'][0]["spot"]);die;
		$data['cond'] = $where;
		//$data['profile'] = $this->_list_profile();
		// $data['channel'] = $this->tvprogramun_model->list_spot_by_chanel_all2($where);
		// $data['adstype'] = $this->tvprogramun_model->list_spot_by_program_all("ads_type",$where);
		//$data['adstype'] = $this->tvprogramun_model->list_spot_by_adstype_all($where);
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
		
		// $data['sector'] = $this->tvprogramun_model->list_sector();
		// $data['category'] = $this->tvprogramun_model->list_category();
		// $data['advertiser'] = $this->tvprogramun_model->list_advertiser();
		// $data['product'] = $this->tvprogramun_model->list_product();
		// $data['channelf'] = $this->tvprogramun_model->list_cgi_field("CHANNEL");
		// $data['level1'] = $this->tvprogramun_model->list_cgi_field("LEVEL1");
		// $data['level2'] = $this->tvprogramun_model->list_cgi_field("LEVEL2");
		// $data['program'] = $this->tvprogramun_model->list_cgi_field("PROGRAM");
		// $data['ads_type'] = $this->tvprogramun_model->list_cgi_field("ADS_TYPE");
		
		//var_dump($data['program']);die;
		
		$html = "";
		
		// $html = $html.$this->create_nested($data['sector'],"SECTOR");
		// $html = $html.$this->create_nested($data['category'],"CATEGORY");
		// $html = $html.$this->create_nested($data['advertiser'],"ADVERTISER");
		// $html = $html.$this->create_nested($data['product'],"PRODUCT");
		// $html = $html.$this->create_nested($data['channelf'],"CHANNEL");
		// $html = $html.$this->create_nested($data['level1'],"LEVEL1");
		// $html = $html.$this->create_nested($data['level2'],"LEVEL2");
		// $html = $html.$this->create_nested($data['program'],"PROGRAM");
		// $html = $html.$this->create_nested($data['ads_type'],"ADS_TYPE");
		
		//var_dump($data['ads_type']);die;
		
		// foreach($data['channel'] as $datax){
			// $data_ch[] = '"'.$datax['channel'].'"';
			// $spot_ch[] = $datax['spot'];
			
		// }
		
		// foreach($data['adstype'] as $datas){
			// $data_ads[] = '"'.$datas['ads_type'].'"';
			// $spot_ads[] = $datas['Spot'];
			
		// }
		
		$prime = 0;
		$nprime = 0;
		
		// foreach($data['daytime'] as $datass){
			// $data_daytime[] = '"'.$datass['htype'].'"';
			// $spot_daytime[] = $datass['spot'];
			
			// if($datass['htype'] == "18:00 - 22:00"){
				// $prime = $prime + $datass['spot'];
			// }else{
				// $nprime = $nprime + $datass['spot'];
			// }
		// }
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		if ($data['daytime'] <> null){
		
			$prime = $data['daytime'][0]['VIEWERS'];
			$nprime = $data['daytime'][1]['VIEWERS'];
		}
		//echo $prime.$nprime;
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		//var_dump($html);die;
		
		$data['drag'] = $html;
		// $data['products'] = json_encode($this->tvprogramun_model->list_spot_by_program_all2("Program",$where,$periode),true);
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_alls("channel_name",$where,$periode,$pilihaudiencebar,"0","True"); 
		
		//var_dump($data['channels']);die;
		//print_r($data['channels']);
		 // $data_cha[]="";
		 // $spot_cha[]="";
		$dataM=$data['channels'];
		$scama = array();
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			//$scam['Spot'] = $dataM[$i]['Spot'];
			$scam['AUDIENCE'] = number_format($dataM[$i]['AUDIENCE'],0,',','.');
			//$scam['Spot2'] = $dataM[$i]['Spot2'];
			$scam['VIEWERS'] = number_format($dataM[$i]['VIEWERS'],2,',','.');
			$scam['TVR'] = number_format($dataM[$i]['TVR'],2,',','.');
			$scam['TVS'] = number_format($dataM[$i]['TVS'],2,',','.');
			$scam['INDEX'] = number_format($dataM[$i]['INDEX'],2,',','.');
			$scam['REACH'] = number_format($dataM[$i]['REACH'],2,',','.');
			$scam['channel'] = $dataM[$i]['channel'];
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['AUDIENCE'];
			array_push($scama, $scam);
		}	
		
		$dataMa=$data['programsu'];
		
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
			$scamu['Rangking'] = $i+1;
			$scamu['Program'] = $dataMa[$i]['Program'];
			$scamu['CHANNEL'] = $dataMa[$i]['CHANNEL'];
			$scamu['Spot'] = $dataMa[$i]['Spot'];
			$scamu['Spot2'] = $dataMa[$i]['Spot2'];
			$data_chas[] = '"'.$dataMa[$i]['CHANNEL'].'"';
			$spot_chas[] = $dataMa[$i]['Spot'];
			array_push($scamas, $scamu);
		}
		// echo "<pre>";
		// print_r($scamas); die;
		//print_r($scama); die;
		
		
		$data['audiencebychannel'] = json_encode($scama,true); 
		$data['programs'] = json_encode($scamas,true); 
		// foreach($data['channels'] as $datac){
			// $data_cha[] = '"'.$datac['channel'].'"';
			// $spot_cha[] = $datac['Spot'];
			
		// }
		// print_r($data_cha);
		// print_r($spot_cha);
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		// $data['grps'] = $this->tvprogramun_model->list_grp($periode);
		// $data['cost'] = $this->tvprogramun_model->list_cost_all2($where);
		$data['json_channel'] = $data_cha;
		$data['json_spot'] = $spot_cha;
		
		// $data['json_ads'] = $data_ads;
		// $data['json_spot_ads'] = $spot_ads;
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		// $data['json_days'] = "";
		// $data['json_spot_days'] = "";
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		//$data['corress'] = $this->tvprogramun_model->get_corres();
		//$data['corress'] =  { [ { ["CORESSPONDENT"] => "95522147" } ]};
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel($periode);
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['totpopulasi_a'] = $this->tvprogramun_model->list_populasi2a($periode);

		
		$this->template->load('maintemplate_trans', 'tvprogramuntrans/views/Tvprogramun', $data);
	}	

	function days_in_month($month, $year) 
	{ 
	// calculate number of days in a month 
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function day_filter(){
		
		$param['start_date_d'] =  $this->input->post('start_date_d');
		$param['end_date_d'] =  $this->input->post('end_date_d');
		$param['channel_d'] =  $this->input->post('channel_d');
		$param['audiencebar_2']=$this->input->post('audiencebar_2');
		$param['interval']=$this->input->post('interval'); 
		$param['respondent']=$this->input->post('respondent');
		 
		//print_r($param);die;
		
		$data['date'] = $this->tvprogramun_model->day_filters($param);
		
		IF($param['respondent'] == 'RESP'){ 
		
			if ($data['date'] <> null){
				foreach($data['date'] as $datasss){
					$data_date[] = $datasss['date'];
					$spot_date[] = floatval($datasss['spot']);
				}
			}else {
				$data_date[]='';
				$spot_date[] =0;
			}	
		
		}ELSE{
			
			if ($data['date'] <> null){
				foreach($data['date'] as $datasss){
					$data_date[] = $datasss['date'];
					$spot_date[] = floatval($datasss['spot']);
				}
			}else {
				$data_date[]='';
				$spot_date[] =0;
			}	

		}
		
		
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		
		echo json_encode($data,true); 
		
		//print_r($data_list);die;
		
	}
	
	function cost_by_program(){
		
		$type =  $this->input->post('type');
		$field =  $this->input->post('field');
		$where =  $this->input->post('cond');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan'); 
		$profile=$this->input->post('profile');
			$tgl=$this->input->post('tgl');
		$nmonth = date("m", strtotime($tahun));
		// $hariawal=$this->input->post('hariawal');
		// $hariakhir=$this->input->post('hariakhir');
		 $week=$this->input->post('week');
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$datefF = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		
		$periode=$tahun; 
		// if (strlen($hariawal)==1) {$hariawal='0'.$hariawal;}
		// if (strlen($hariakhir)==1) {$hariakhir='0'.$hariakhir;}
		// $start_date=$tahun."-".$nmonth."-".$hariawal;
		// $end_date=$tahun."-".$nmonth."-".$hariakhir;
		// echo $where;die;
		//echo $type." ".$field;die;
		
		//Echo $tgl;die;
		
		if ($week=="ALL"){
			if ($tgl=="0"){
				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$type,$profile);
				// $data['programs'] = json_encode($this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$type,$profile),true);
			}else {
				
				//echo "adadsa";die;
				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari_date("Program",$where,$periode, $datef,$datefF,$type,$profile); 
				// $data['programs'] = json_encode($this->tvprogramun_model->list_spot_by_program_all2Ps_hari_date("Program",$where,$periode, $datef,$datefF,$type,$profile),true); 
			}
		}else {
			// $data['programs'] = json_encode($this->tvprogramun_model->list_spot_by_program_all2Ps_hari("Program",$where,$periode,$week,$type,$profile),true);
			$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari("Program",$where,$periode,$week,$type,$profile);
		}
		
		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					$data_ch[$ik]['Rangking'] = $i;
					$data_ch[$ik]['Program'] = $datax['Program'];
					$data_ch[$ik]['CHANNEL'] = $datax['CHANNEL'];
					// $data_ch['data'][] = $datax['Spot'];
					$data_ch[$ik]['Spot'] =  $datax['Spot'];
					$i++;
					$ik++;
				}
    } else {
        $data_ch = null;
    }
			
		
		// echo "<pre>";	
		// print_r($data['programs']);
		// die;
		// if($type == "Cost"){			
			// $data['programs'] = json_encode($this->tvprogramun_model->proc_get_cost_by_program_all($field,$where),true);
			
		// }elseif($type == "Spot"){
			// $data['programs'] = json_encode($this->tvprogramun_model->list_spot_by_program_all($field,$where),true);

		// }elseif($type == "GRP"){
			// $data['programs'] = json_encode($this->tvprogramun_model->list_grp_by_program_all($field,$where),true);

		// }
		//print_r($type);die;
		
		//var_dump($data['programs']);die;
		
		echo json_encode($data_ch,true);
		
	}
	
	function audiencebar_by_channel_export(){
		
		$where =  $this->input->post('cond');
		$type =  $this->input->post('type');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$end_date=$this->input->post('end_date');
		$start_date=$this->input->post('start_date');
		$check=$this->input->post('check');
		$tipe_filter=$this->input->post('tipe_filter');
		
		
			if 	($type=='GRP')	 {
				$types = 'GRP';
			}elseif ($type=='audience')	 {
				$types = "'000s ";
			}elseif ($type=='Duration')	 {
				$types = 'Duration';
			}elseif ($type=='share')	 {
				$types = 'Audience Share';
			}elseif ($type=='avgtotdur')	 {
				$types = 'AVG Dur/Views';
			}elseif ($type=='Reach')	 {
				$types = 'Reach';
			}elseif ($type=='tvr')	 {
				$types = 'TVR';
			}elseif ($type=='tvs')	 {
				$types = 'TVS';
			}elseif ($type=='idx')	 {
				$types = 'INDEX';
			}elseif ($type=='Reach')	 {
				$types = 'Reach';
			}else{
				$types = 'Audience';
			}
		
		//echo $tgl;die;
		// $hariakhir=$this->input->post('hariakhir');
		//$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		$date_periode = $this->tvprogramun_model->get_periode_date($periode);
		//$where = " AND CHANNEL LIKE '%".$wheres."%' ";
		//echo $datef;die;
		//$view = $this->Tvpostbuyu_model->proc_get_spot_all2("");
		// if (strlen($hariawal)==1) {$hariawal='0'.$hariawal;}
		// if (strlen($hariakhir)==1) {$hariakhir='0'.$hariakhir;}
		// $start_date=$tahun."-".$nmonth."-".$hariawal;
		// $end_date=$tahun."-".$nmonth."-".$hariakhir;
		//echo $start_date;die;
			//$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type);
		if($tipe_filter == 'live'){
			
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL'] ){
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_alls("channel_name",$where,$periode,$type,$profile,$check); 
			}else{
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_avg_alls("channel_name",$where,$periode,$type,$profile,$check,$start_date,$end_date); 
				//ECHO "SSS";DIE;
			}
		
		}
		
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
     // print_r(sizeof($data['channel'])); die;
      if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
					foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					
						$data_ch[$ik]['AUDIENCE'] = number_format($datax['AUDIENCE'],0,',','.');
						//$scam['Spot2'] = $dataM[$i]['Spot2'];
						$data_ch[$ik]['VIEWERS'] = number_format($datax['VIEWERS'],2,',','.');
						$data_ch[$ik]['TVR'] = number_format($datax['TVR'],2,',','.');
						$data_ch[$ik]['TVS'] = number_format($datax['TVS'],2,',','.');
						$data_ch[$ik]['INDEX'] = number_format($datax['INDEX'],2,',','.');
						$data_ch[$ik]['REACH'] = number_format($datax['REACH'],2,',','.');
						 
    					$i++; 
    					$ik++;
    				}
    			//print_r($data_ch); die;
      } else {
          $data_ch = null;
      }
      
	  // print_r($data_ch); die;
	  // die;
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
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Channel')
					->setCellValue('C1', 'AUDIENCE' )
					->setCellValue('D1', 'VIEWERS' )
					->setCellValue('E1', 'TVR' )
					->setCellValue('F1', 'TVS' )
					->setCellValue('G1', 'INDEX' )
					->setCellValue('H1', 'REACH' );
	   
	   $it1 = 2;
		 foreach($data_ch as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['channel'])
					->setCellValue('C'.$it1, $frt['AUDIENCE'])
					->setCellValue('D'.$it1, $frt['VIEWERS'])
					->setCellValue('E'.$it1, $frt['TVR'])
					->setCellValue('F'.$it1, $frt['TVS'])
					->setCellValue('G'.$it1, $frt['INDEX'])
					->setCellValue('H'.$it1, $frt['REACH']);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		
		// Redirect output to a client’s web browser (Excel2007)
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		// header('Cache-Control: max-age=0');
		// // If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');

		// // If you're serving to IE over SSL, then the following may be needed
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="Postbuy_analytics.xlsx"');
		//$objWriter->save('php://output');
		
		 //ob_end_clean();
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');

	  
		//var_dump($data_ch);die;  
	  
		  //echo json_encode($data_ch,true); die;
	}
	
	function audiencebar_by_channel(){
		
		$where =  $this->input->post('cond');
		$type =  $this->input->post('type');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$end_date=$this->input->post('end_date');
		$start_date=$this->input->post('start_date');
		$check=$this->input->post('check');
		$tipe_filter=$this->input->post('tipe_filter');
		
		//echo $tgl;die;
		// $hariakhir=$this->input->post('hariakhir');
		//$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		
		
		$date_periode = $this->tvprogramun_model->get_periode_date($periode);
		
		//print_r($date_periode);die;
		//echo $datef;die;
		//$view = $this->Tvpostbuyu_model->proc_get_spot_all2("");
		// if (strlen($hariawal)==1) {$hariawal='0'.$hariawal;}
		// if (strlen($hariakhir)==1) {$hariakhir='0'.$hariakhir;}
		// $start_date=$tahun."-".$nmonth."-".$hariawal; 
		// $end_date=$tahun."-".$nmonth."-".$hariakhir;
		//echo $start_date;die;
			//$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type);
		
		if($tipe_filter == 'live'){
			
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL'] ){
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_alls("channel_name",$where,$periode,$type,$profile,$check); 
			}else{
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_avg_alls("channel_name",$where,$periode,$type,$profile,$check,$start_date,$end_date); 
				//ECHO "SSS";DIE;
			}
		
		}else{
			
			
			
		}
		
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
			
      //print_r(sizeof($data['channel'])); die;
      if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;

    				foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					
						$data_ch[$ik]['AUDIENCE'] = number_format($datax['AUDIENCE'],0,',','.');
						//$scam['Spot2'] = $dataM[$i]['Spot2'];
						$data_ch[$ik]['VIEWERS'] = number_format($datax['VIEWERS'],3,',','.');
						$data_ch[$ik]['TVR'] = number_format($datax['TVR'],2,',','.');
						$data_ch[$ik]['TVS'] = number_format($datax['TVS'],2,',','.');
						$data_ch[$ik]['INDEX'] = number_format($datax['INDEX'],2,',','.');
						$data_ch[$ik]['REACH'] = number_format($datax['REACH'],2,',','.');
						 
    					$i++; 
    					$ik++;
    				}
  
    			//print_r($data_ch); die;
      } else {
          $data_ch = null;
      }
      
		  echo json_encode($data_ch,true);
	}

}

