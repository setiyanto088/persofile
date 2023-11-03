<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramun3 extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}
	


	public function filter_days(){
		
		$type =  $this->Anti_si($this->input->post('audiencebarday',true));
		$periode =  $this->Anti_si($this->input->post('periode',true));
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
 		
	}


	public function audiencebar_by_day_export(){

		$tahun=$this->Anti_si($this->input->post('tahun'));
		$nmonth = date("m", strtotime($tahun));
		$periode = $tahun;
		
		$where = '';
		
		$data['total_viewers'] = $this->tvprogramun_model->list_spot_by_date_all2_viewer($where,$periode);
		$data['duration'] = $this->tvprogramun_model->list_spot_by_date_all2_duration($where,$periode);
		$data['audience'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
			
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
					->setCellValue('A1', 'DATE')
					->setCellValue('B1', 'AUDIENCE')
					->setCellValue('C1', 'TOTAL_VIEWS')
					->setCellValue('D1', 'DURATION');
	   
	   $it1 = 2;
	   $ii = 0;
		 foreach($data['audience'] as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['date'])
					->setCellValue('B'.$it1, $frt['spot'])
					->setCellValue('C'.$it1, $data['total_viewers'][$ii]['spot'])
					->setCellValue('D'.$it1, $data['duration'][$ii]['spot']);

			$it1++;
			$ii++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Day Summary');
 		$objPHPExcel->setActiveSheetIndex(0);
 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_day.xls');	
		
			
	}
	

	public function audiencebar_by_program_export_tvodm(){
		
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('pilihprog',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile_prog',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$periode=$this->Anti_si($this->input->post('periode',true));
		$channel_prog=$this->Anti_si($this->input->post('channel_prog',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		  
 		  
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
			$params['week'] 	= $week;
			$params['searchtxt'] 	= "";
			$params['check'] 	= $check;
			$params['channel_prog'] 	= str_replace("_","+",$channel_prog);
 			
			
 			
			$nmonth = date("m", strtotime($periode));
			$datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			$datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			$params['tgl'] 	= $datefF;
		

			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_x_tvodm("PROGRAM",$where,$params,$pilihprog,'0');
	
				
		    $data = array();	
			  $idx = 0;
			  

				 $decs = 0;


		   foreach ( $list as $k => $v ) {
			   
			   $numb = $idx+1;
			   
			    array_push($data, 
				  array(
					  number_format($numb,0,',','.'),
					  $v['CHANNEL'],
					  $v['PROGRAM'],
					  number_format($v['VIEWERS'],0,'',''),
					  number_format($v['TOTAL_VIEWS'],0,'',''),
					  number_format($v['DURATION'],0,'','')
				  )
			  );
			  $idx++;
			   
		   }
			 $result["data"] = $data;
			 
 
			
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
					->setCellValue('C1', 'Content Name')
					->setCellValue('D1', 'Count Distinct Viewers')
					->setCellValue('E1', 'Count Viewers')
					->setCellValue('F1', 'Duration');
	   
	   $it1 = 2;
		 foreach($data as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt[0])
					->setCellValue('B'.$it1, $frt[1])
					->setCellValue('C'.$it1, $frt[2])
					->setCellValue('D'.$it1, $frt[3])
					->setCellValue('E'.$it1, $frt[4])
					->setCellValue('F'.$it1, $frt[5]);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);
 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_program_tvod.xls');	
		
			
	}

	public function audiencebar_by_program_export(){
		
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type = $this->Anti_si($this->input->post('pilihprog',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile_prog',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$periode=$this->Anti_si($this->input->post('periode',true));
		$channel_prog=$this->Anti_si($this->input->post('channel_prog',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		  
 		  
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
			$params['week'] 	= $week;
			$params['searchtxt'] 	= "";
			$params['check'] 	= $check;
			$params['channel_prog'] 	= str_replace("_","+",$channel_prog);
 			
			
 			
			$nmonth = date("m", strtotime($periode));
			$datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			$datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			$params['tgl'] 	= $datefF;
		
		if($tipe_filter == 'live'){	
		
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_x("PROGRAM",$where,$params,$pilihprog,'0');
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day_x("PROGRAM",$where,$params,$pilihprog,'0');
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week_x("PROGRAM",$where,$params,$pilihprog,'0');
			}
				
				}else{
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_tvod_x("PROGRAM",$where,$params,$pilihprog,$profile,$tipe_filter);
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("PROGRAM",$where,$params,$pilihprog,$profile);
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week("PROGRAM",$where,$params,$pilihprog,$profile);
			}
			
		}
				
		    $data = array();	
			  $idx = 0;
			  
			  if($pilihprog == 'TVR' || $pilihprog == 'Reach' || $pilihprog == 'avgtotdur'){
				  $decs = 2;
			  }else{
				  $decs = 0;
			  }
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			  
			  

		   foreach ( $list as $k => $v ) {
			   
			   $numb = $idx+1;
			   if($pilihprog == 'Reach'){
				   $re = ($v['Spot']/$totpopulasi[0]['tot_pop'])*100;
				   $vvv =  $re;
			   }else{
				   $vvv =  $v['Spot'];
			   }
			   
			    array_push($data, 
				  array(
					  number_format($numb,0,',','.'),
					  $v['PROGRAM'],
					  $v['CHANNEL'],
					  $vvv
				  )
			  );
			  $idx++;
			   
		   }
			 $result["data"] = $data;
 
			
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
					->setCellValue('D1', $types);
	   
	   $it1 = 2;
		 foreach($data as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt[0])
					->setCellValue('B'.$it1, $frt[1])
					->setCellValue('C'.$it1, $frt[2])
					->setCellValue('D'.$it1, $frt[3]);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);
 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	 
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
		  
		   if( !empty($_GET['tgl2']) ) {
			  $tgl = $_GET['tgl2'];
		  } else {
			  $tgl = '0';
		  }
		  
		   if( !empty($_GET['tipe_filter_prog']) ) {
			  $tipe_filter = $_GET['tipe_filter_prog'];
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($_GET['week2']) ) {
			  $week = $_GET['week2'];
		  } else {
			  $week = '0';
		  }
		  
		$check = $_GET['check'];
		   
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
				$where = " AND CHANNEL = '".str_replace("_","+",$_GET['channel'])."' ";
			  }
			  
		  } else {
			  $searchtxt = "";
		  }
		  
		   
		  if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		  if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		  if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		  $order_fields = array('TANGGAL','TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR');  
		  $order = $this->input->get_post('order');
		  if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		  if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		  
		    $params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['week'] 	= $week;
			$params['check'] 	= $check;
			$params['searchtxt'] 	= $_GET['search']['value'];
			
		 
			
			$nmonth = date("m", strtotime($periode));
			$datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			$datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			$params['tglf'] 	= $datef;
			$params['tgl'] 	= $datefF;
		
 		
		if($tipe_filter == 'live'){
		
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new("PROGRAM",$where,$params,$pilihprog,$profile);
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("PROGRAM",$where,$params,$pilihprog,$profile);
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week("PROGRAM",$where,$params,$pilihprog,$profile);
			}
			
		}else{
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_tvod("PROGRAM",$where,$params,$pilihprog,$profile,$tipe_filter);
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("PROGRAM",$where,$params,$pilihprog,$profile);
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week("PROGRAM",$where,$params,$pilihprog,$profile);
			}
			
		}
				
		    $data = array();	
			  $idx = 0; 
			  
			  if($pilihprog == 'TVS' || $pilihprog == 'TVR2' || $pilihprog == 'TVR' || $pilihprog == 'Reach' || $pilihprog == 'avgtotdur' || $pilihprog == 'avgtotaud'){
				  $decs = 2;
			  }else{
				  $decs = 0;
			  }
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			  
			  $rnk = 1;
		   foreach ( $list['data'] as $k => $v ) {
			   
			   if($pilihprog == 'Reach'){
				   $re = ($v['Spot']/$totpopulasi[0]['tot_pop'])*100;
				   $vvv =  "<p style='text-align:right;margin:0 0 0 0'>".number_format($re,$decs,',','.')."</p>";
			   }else{
				   $vvv =  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['Spot'],$decs,',','.')."</p>";
			   }
			   
			   if($pilihprog == 'avgtotaud'){
				   array_push($data, 
					  array(
						  number_format($rnk,0,',','.'),
						  $v['PROGRAM'],
						  $v['CHANNEL'],
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVR'],$decs,',','.')."</p>",
						  $vvv
					  )
					);
					$idx++;
			   }else{
			
					array_push($data, 
					  array(
						  number_format($rnk,0,',','.'),
						  $v['PROGRAM'],
						  $v['CHANNEL'],
						  $vvv
					  )
					);
					$idx++;
			   }
			   
			   $rnk++;
		   }
			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
 	  
			$this->json_result($result);
			
	}
	
	public function audiencebar_by_channel_export_sum(){
		
		$where = '';
		
		$sess_user_id =  $this->Anti_si($this->input->post('sess_user_id',true));
		$sess_token =  $this->Anti_si($this->input->post('sess_token',true));
		$periode=$this->Anti_si($this->input->post('periode',true));
		$pilihprog=$this->Anti_si($this->input->post('pilihprog',true));
		$tgl1mr=$this->Anti_si($this->input->post('tgl1mr',true));
		$tgl2mr=$this->Anti_si($this->input->post('tgl2mr',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$channel=$this->Anti_si($this->input->post('channel',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$tipe_filter=$this->nti_si($this->input->post('tipe_filter_prog',true));
		  
		 
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['tgl2mr'] 	= $tgl2mr;
			$params['tgl1mr'] 	= $tgl1mr;
			$params['check'] 	= $check;
			$array_mnth = array();
			
			$start    = new DateTime($tgl1mr);
			$start->modify('first day of this month');
			$end      = new DateTime($tgl2mr);
			$end->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);

			$array_period = array();
 			
			if($params['check'] == "True"){
				$wh_chn = ''; 
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
			
			 $query = 	" SELECT A.CHANNEL,";
			
			$h1 = '';
			$h12 = '';
			$iii = 0;
			foreach ($period as $dt) {
				
				$totpopulasi = $this->tvprogramun_model->list_populasi2($dt->format("Y-F"));
				
				$array_period[] = $dt->format("Y-F");
				$h1 .= " B".$iii.".VIEWERS AS AUDIENCE".$iii.", C".$iii.".`VIEWERS` AS TVR".$iii.", D".$iii.".`VIEWERS` AS TVS".$iii.", E".$iii.".`VIEWERS` AS VIEWER".$iii.",  B".$iii.".VIEWERS/".$totpopulasi[0]['tot_pop']." AS REACH".$iii.", ";
				
				$h12 .= " LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND ID_PROFILE = '".$profile."' ) B".$iii."
					ON A.CHANNEL = B".$iii.".CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND `TPE` = 'TVR' AND ID_PROFILE = '".$profile."' ) C".$iii."
					ON A.CHANNEL = C".$iii.".CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND `TPE` = 'TVS' AND ID_PROFILE = '".$profile."' ) D".$iii."
					ON A.CHANNEL = D".$iii.".CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_VIEWERS_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND ID_PROFILE = '".$profile."' ) E".$iii."
					ON A.CHANNEL = E".$iii.".CHANNEL  ";
				
				$iii++;
			}
			
			
				$query = " SELECT A.CHANNEL, ".$h1." 'aaa' as hoo FROM ( SELECT CHANNEL FROM `M_SUM_TV_DASH_CHAN_PTV` WHERE STR_TO_DATE(TANGGAL,'%Y-%M') BETWEEN STR_TO_DATE('".$tgl1mr."','%Y-%M') AND STR_TO_DATE('".$tgl2mr."','%Y-%M') AND ID_PROFILE = '".$profile."'
				".$wh_chn."
					 GROUP BY CHANNEL ) A  ".$h12." ORDER BY B0.VIEWERS DESC ";
			 
		
		if($tipe_filter == 'live'){
		
			$list = $this->tvprogramun_model->mr_get2("Program",$where,$params,$pilihprog,$profile,$query);
			
		}else{
			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("Program",$where,$params,$pilihprog,$profile);
			
		}
			
				$array_cell = ['C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE'];
 				
			    $this->load->library('excel');
	   
				$objPHPExcel = new PHPExcel();
				
				  $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
									 
									 
		    $data = array();	
			  $idx = 0; 
			  
			 $i = 1;
			 $is = 3;
  			$ik = 0;
			
			 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A2', 'Rank')
								->setCellValue('B2', 'Channel');
			
				foreach($list as $datax){
					
					  $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$is, $i)
								->setCellValue('B'.$is, $datax['CHANNEL']);
								
			 
					$frt = 0;
					$frts = 0;
					foreach ($array_period as $dts) {
								
								IF($datax['TVR'.$frt] == '' || $datax['TVR'.$frt] == NULL ){
								
									$cla = $frts;
									
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'AUDIENCE')
									->setCellValue($array_cell[$frts].$is, 0);
									
									$s_cell = $array_cell[$frts];
									
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'TVR')
									->setCellValue($array_cell[$frts].$is, 0);
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'TVS')
									->setCellValue($array_cell[$frts].$is, 0);
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'VIEWER')
									->setCellValue($array_cell[$frts].$is, 0);
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'REACH')
									->setCellValue($array_cell[$frts].$is, 0);
									
									$e_cell = $array_cell[$frts];
									$frts++;
									
									$clb = $frts;
									
									$objPHPExcel->getActiveSheet()->mergeCells($s_cell.'1:'.$e_cell.'1');
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($s_cell.'1', $dts);
								
								}ELSE{
									
									$cla = $frts;
									
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'AUDIENCE')
									->setCellValue($array_cell[$frts].$is, $datax['AUDIENCE'.$frt]);
									
									$s_cell = $array_cell[$frts];
									
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'TVR')
									->setCellValue($array_cell[$frts].$is, $datax['TVR'.$frt]);
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'TVS')
									->setCellValue($array_cell[$frts].$is, $datax['TVS'.$frt]);
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'VIEWER')
									->setCellValue($array_cell[$frts].$is, $datax['VIEWER'.$frt]);
									$frts++;
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($array_cell[$frts].'2', 'REACH')
									->setCellValue($array_cell[$frts].$is, $datax['REACH'.$frt]);
									
									$e_cell = $array_cell[$frts];
									$frts++;
									
									$clb = $frts;
									
									$objPHPExcel->getActiveSheet()->mergeCells($s_cell.'1:'.$e_cell.'1');
									$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($s_cell.'1', $dts);
									
								}	 
						$frt++;
					}
					$is++;
					$i++;
					$ik++;
				}
			

		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);

		
		 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	 
		
		$objWriter->save('/var/www/html/tmp_doc/summary_monthly.xls');
				
	}
	
	public function get_filter_programaud_mr2(){
		
		$where = '';
		
		$sess_user_id =  $this->Anti_si($this->input->post('sess_user_id',true));
		$sess_token =  $this->Anti_si($this->input->post('sess_token',true));
		$periode=$this->Anti_si($this->input->post('periode',true));
		$pilihprog=$this->Anti_si($this->input->post('pilihprog',true));
		$tgl1mr=$this->Anti_si($this->input->post('tgl1mr',true));
		$tgl2mr=$this->Anti_si($this->input->post('tgl2mr',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$channel=$this->Anti_si($this->input->post('channel',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter_prog',true));
		  
		 
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['tgl2mr'] 	= $tgl2mr;
			$params['tgl1mr'] 	= $tgl1mr;
			$params['check'] 	= $check;
			$array_mnth = array();
			
			$start    = new DateTime($tgl1mr);
			$start->modify('first day of this month');
			$end      = new DateTime($tgl2mr);
			$end->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);

			$array_period = array();
 			
			if($params['check'] == "True"){
				$wh_chn = ''; 
			}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							LEFT JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
			}
			
			 $query = 	" SELECT A.CHANNEL,";
			
			$h1 = '';
			$h12 = '';
			$iii = 0;
			foreach ($period as $dt) {
				
				$totpopulasi = $this->tvprogramun_model->list_populasi2($dt->format("Y-F"));
 				$array_period[] = $dt->format("Y-F");
				$h1 .= " B".$iii.".VIEWERS AS AUDIENCE".$iii.", C".$iii.".`VIEWERS` AS TVR".$iii.", D".$iii.".`VIEWERS` AS TVS".$iii.", E".$iii.".`VIEWERS` AS VIEWER".$iii.", B".$iii.".VIEWERS/".$totpopulasi[0]['tot_pop']." AS REACH".$iii.", ";
				
				$h12 .= " LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND ID_PROFILE = '".$profile."' ) B".$iii."
					ON A.CHANNEL = B".$iii.".CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND `TPE` = 'TVR' AND ID_PROFILE = '".$profile."' ) C".$iii."
					ON A.CHANNEL = C".$iii.".CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_EXT_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND `TPE` = 'TVS' AND ID_PROFILE = '".$profile."' ) D".$iii."
					ON A.CHANNEL = D".$iii.".CHANNEL 
					LEFT JOIN ( SELECT * FROM `M_SUM_TV_DASH_CHAN_VIEWERS_PTV` WHERE TANGGAL = '".$dt->format("Y-F")."' AND ID_PROFILE = '".$profile."' ) E".$iii."
					ON A.CHANNEL = E".$iii.".CHANNEL  ";
				
				$iii++;
			}
			
			
				$query = " SELECT A.CHANNEL, ".$h1." 'aaa' as hoo FROM ( SELECT CHANNEL FROM `M_SUM_TV_DASH_CHAN_PTV` WHERE STR_TO_DATE(TANGGAL,'%Y-%M') BETWEEN STR_TO_DATE('".$tgl1mr."','%Y-%M') AND STR_TO_DATE('".$tgl2mr."','%Y-%M') AND ID_PROFILE = '".$profile."'
				".$wh_chn."
					 GROUP BY CHANNEL ) A  ".$h12." ORDER BY B0.VIEWERS DESC ";
			 
		
		if($tipe_filter == 'live'){
		
			$list = $this->tvprogramun_model->mr_get2("Program",$where,$params,$pilihprog,$profile,$query);
			
		}else{
			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("Program",$where,$params,$pilihprog,$profile);
			
		}
 				
		    $data = array();	
			  $idx = 0; 
			  
			 $i = 1;
  			$ik = 0;
				foreach($list as $datax){
					$data_ch[$ik]['Rangking'] = $i;
					$data_ch[$ik]['CHANNEL'] = $datax['CHANNEL'];
					$frt = 0;
					foreach ($array_period as $dts) {
						
						IF($datax['TVR'.$frt] == '' || $datax['TVR'.$frt] == NULL ){
							$data_ch[$ik]['AUDIENCE'.$frt] =  0;
							$data_ch[$ik]['TVR'.$frt] =  0;
							$data_ch[$ik]['TVS'.$frt] =  0;
							$data_ch[$ik]['VIEWER'.$frt] =  0;
							$data_ch[$ik]['REACH'.$frt] =  0*100;
							$frt++;
						}ELSE{
							$data_ch[$ik]['AUDIENCE'.$frt] =  $datax['AUDIENCE'.$frt];
							$data_ch[$ik]['TVR'.$frt] =  $datax['TVR'.$frt];
							$data_ch[$ik]['TVS'.$frt] =  $datax['TVS'.$frt];
							$data_ch[$ik]['VIEWER'.$frt] =  $datax['VIEWER'.$frt];
							$data_ch[$ik]['REACH'.$frt] =  $datax['REACH'.$frt]*100;
							$frt++;
						}
						
						
					}
					$i++;
					$ik++;
				}
			  
			   
	  echo json_encode($data_ch,true);
 			
	}
	
	public function get_filter_programaud_mr_tvod(){
		
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
		  
		   if( !empty($_GET['tgl2mr']) ) {
			  $tgl2mr = $_GET['tgl2mr'];
		  } else {
			  $tgl2mr = '0';
		  }
		  
		   if( !empty($_GET['tipe_filter_prog']) ) {
			  $tipe_filter = $_GET['tipe_filter_prog'];
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($_GET['tgl1mr']) ) {
			  $tgl1mr = $_GET['tgl1mr'];
		  } else {
			  $tgl1mr = '0';
		  }
		  
		   $check = $_GET['check'];
		 
		  
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
				 
				  $where = ' AND CHANNEL = "'.str_replace("_","+",$_GET['channel']).'" ';
			  }
			  
		  } else {
			  $searchtxt = "";
		  }
	 
		   
		  if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		  if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		  if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		  $order_fields = array('VIEWERS','CHANNEL', 'PROGRAM', 'VIEWERS', 'TOTAL_VIEWS', 'DURATION'); // , 'COST'
		  $order = $this->input->get_post('order');
		  if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		  if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		  
		    $params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['tgl2mr'] 	= $tgl2mr;
			$params['tgl1mr'] 	= $tgl1mr;
			$params['check'] 	= $check;
			$params['searchtxt'] 	= $_GET['search']['value'];
			

			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day_tvodm("Program",$where,$params,$pilihprog,$profile);
	
		    $data = array();	
			  $idx = 0; 

			  
		   foreach ( $list['data'] as $k => $v ) {
			   		   
				   array_push($data, 
					  array(
						  number_format($params['offset']+$idx+1,0,',','.'),
						  $v['CHANNEL'],
						  $v['PROGRAM'],
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['VIEWERS'],0,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TOTAL_VIEWS'],0,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['DURATION'],0,',','.')."</p>"
					  )
					);
					$idx++;
			 
		   }
			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
 	  
			$this->json_result($result);
			
	}
	
	public function get_filter_programaud_mr(){
		
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
		  
		   if( !empty($_GET['tgl2mr']) ) {
			  $tgl2mr = $_GET['tgl2mr'];
		  } else {
			  $tgl2mr = '0';
		  }
		  
		   if( !empty($_GET['tipe_filter_prog']) ) {
			  $tipe_filter = $_GET['tipe_filter_prog'];
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($_GET['tgl1mr']) ) {
			  $tgl1mr = $_GET['tgl1mr'];
		  } else {
			  $tgl1mr = '0';
		  }
		  
		   $check = $_GET['check'];
 
		  
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
				 
				 
				  $where = ' AND CHANNEL = "'.str_replace("_","+",$_GET['channel']).'" ';
			  }
			  
		  } else {
			  $searchtxt = "";
		  }
 
		   
		  if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		  if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		  if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		  $order_fields = array('TANGGAL','TANGGAL', 'CHANNEL', 'PROGRAM', 'PRODUCT', 'ADVERTISER', 'SECTOR', 'START_TIME', 'DURATION', 'ADS_TYPE', 'TVR'); // , 'COST'
		  $order = $this->input->get_post('order');
		  if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		  if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		  
		    $params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['tgl2mr'] 	= $tgl2mr;
			$params['tgl1mr'] 	= $tgl1mr;
			$params['check'] 	= $check;
			$params['searchtxt'] 	= $_GET['search']['value'];
 
		if($tipe_filter == 'live'){
		
			$list = $this->tvprogramun_model->mr_get("Program",$where,$params,$pilihprog,$profile);
			
		}else{
			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("Program",$where,$params,$pilihprog,$profile);
			
		}
 				
		    $data = array();	
			  $idx = 0; 
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			   
			 
			
			  
		   foreach ( $list['data'] as $k => $v ) {
			   		   
				   array_push($data, 
					  array(
						  number_format($v['Rangking'],0,',','.'),
						  $v['CHANNEL'],
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['AUDIENCE'],0,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVR'],2,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVS'],2,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['VIEWER'],0,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format(($v['AUDIENCE']/$totpopulasi[0]['tot_pop'])*100,2,',','.')."</p>"
					  )
					);
					$idx++;
			 
		   }
			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
 	  
			$this->json_result($result);
			
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
		
 		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		//print_r($data['thn']);die;
	 
		if(!$this->session->userdata('user_id')) { 
 		}
		
		
		if($this->Anti_si($this->input->post('filter_text',true))){
			
				
				$filter = $this->Anti_si($this->input->post('filter_text',true));
				$starttime = $this->Anti_si($this->input->post('starttime',true));
				$endtime = $this->Anti_si($this->input->post('endtime',true));
				$mindur = $this->Anti_si($this->input->post('mindur',true));
				$maxdur = $this->Anti_si($this->input->post('maxdur',true));
				
				
				
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
 
		
		$tahun=$this->input->post('tahun',true);
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		
		
	 
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
 
		$pilihaudiencebar=$this->Anti_si($this->input->post('audiencebar',true));
		$pilihprog=$this->Anti_si($this->input->post('product_program',true));
		
		if (!isset($tahun)){ 
 
			
			$tahun= $data['thn'][0]['TANGGAL'];
 		}
		$periode=$tahun;
		
		//echo 'thn '.$periode;die;
 		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole,$periode);
		
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['channel_list'] = $this->tvprogramun_model->channel_list($periode);
 		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['aa'] = $data['active_audience'][0]['VIEWERS'];
	 
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
 		$data['cond'] = $where;
	 
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
 
		$html = "";
 
		$prime = 0;
		$nprime = 0;
 
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
 		
		$data['drag'] = $html;
 		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
 		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0","True"); 
	 
		$dataM=$data['channels'];
		$scama = array();
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			$scam['Spot'] = $dataM[$i]['Spot'];
			$scam['channel'] = $dataM[$i]['channel'];
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
			array_push($scama, $scam);
		}	
		
		$dataMa=$data['programsu'];
		
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
			$scamu['Rangking'] = $i+1;
			$scamu['Program'] = $dataMa[$i]['PROGRAM'];
			$scamu['CHANNEL'] = $dataMa[$i]['CHANNEL'];
			$scamu['Spot'] = $dataMa[$i]['Spot'];
			$data_chas[] = '"'.$dataMa[$i]['CHANNEL'].'"';
			$spot_chas[] = $dataMa[$i]['Spot'];
			array_push($scamas, $scamu);
		}
	 
		
		$data['audiencebychannel'] = json_encode($scama,true); 
		$data['programs'] = json_encode($scamas,true); 
		 
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		 
		$data['json_channel'] = $data_cha;
		$data['json_spot'] = $spot_cha;
		 
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		 
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date; 
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel($periode);
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);

		
		$this->template->load('maintemplate', 'tvprogramun3/views/Tvprogramun', $data);
	}	

	function days_in_month($month, $year) 
	{ 
 		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function cost_by_program(){
		
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
			$tgl=$this->Anti_si($this->input->post('tgl',true));
		$nmonth = date("m", strtotime($tahun)); 
		 $week=$this->Anti_si($this->input->post('week',true));
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$datefF = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		
		$periode=$tahun;  
		
		if ($week=="ALL"){
			if ($tgl=="0"){
				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$type,$profile);
 			}else {
				
 				$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari_date("Program",$where,$periode, $datef,$datefF,$type,$profile); 
 			}
		}else {
 			$data['programs'] = $this->tvprogramun_model->list_spot_by_program_all2Ps_hari("Program",$where,$periode,$week,$type,$profile);
		}
		
		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					$data_ch[$ik]['Rangking'] = $i;
					$data_ch[$ik]['Program'] = $datax['Program'];
					$data_ch[$ik]['CHANNEL'] = $datax['CHANNEL'];
 					$data_ch[$ik]['Spot'] =  $datax['Spot'];
					$i++;
					$ik++;
				}
    } else {
        $data_ch = null;
    }
			
	 
		
		echo json_encode($data_ch,true);
		
	}
	
	function audiencebar_by_channel_export(){
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$check =  $this->Anti_si($this->input->post('check',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		
			if 	($type=='GRP')	 {
				$types = 'GRP';
			}elseif ($type=='Viewers')	 {
				$types = 'Total Views';
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
		
	 
		$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		
		 
		if($tipe_filter == 'live'){	
			
		if ($week=="ALL"){
			if ($tgl=="0"){
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type,$profile,$check); 
			}else {
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile,$check); 
			}
		}else {
			$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile,$check); 
		}
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
			
		}else{
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_tvod("channel_name",$where,$periode,$type,$profile,$check,$tipe_filter); 
				}else {
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile,$check); 
				}
			}else {
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile,$check); 
			}
			
		}
       if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
    			if($type == 'Reach'){
    				foreach($data['channel'] as $datax){
     					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
     					$data_ch[$ik]['Spot'] = round(($datax['Spot']/$data['totpopulasi'][0]['tot_pop'])*100,2);
    					$i++;
    					$ik++;
    				}
    			}else{
    				foreach($data['channel'] as $datax){
     					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					$data_ch[$ik]['Spot'] = $datax['Spot'];
    					$i++;
    					$ik++;
    				}
    			}
       } else {
          $data_ch = null;
      }
      
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
					->setCellValue('C1', $types);
	   
	   $it1 = 2;
		 foreach($data_ch as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['channel'])
					->setCellValue('C'.$it1, $frt['Spot']);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);

		 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');

	   
	}
	
	function audiencebar_by_channel(){
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
	 
		$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		 
		if($tipe_filter == 'live'){
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type,$profile,$check); 
				}else {
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile,$check); 
				}
			}else {
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile,$check); 
			}
		
		}else{
			
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_tvod("channel_name",$where,$periode,$type,$profile,$check,$tipe_filter); 
				}else {
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date_tvod("channel_name",$where,$periode,$datef,$type,$profile,$check,$tipe_filter); 
				}
			}else {
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile,$check); 
			}
			
		}
		
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
			
       if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
    			if($type == 'Reach'){
    				foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					// $data_ch['data'][] = $datax['Spot'];
    					$data_ch[$ik]['Spot'] = round(($datax['Spot']/$data['totpopulasi'][0]['tot_pop'])*100,2);
    					$i++;
    					$ik++;
    				}
    			}else{
    				foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					$data_ch[$ik]['Spot'] = $datax['Spot'];
    					$i++;
    					$ik++;
    				}
    			}
       } else {
          $data_ch = null;
      }
      
		  echo json_encode($data_ch,true);
	}

}

