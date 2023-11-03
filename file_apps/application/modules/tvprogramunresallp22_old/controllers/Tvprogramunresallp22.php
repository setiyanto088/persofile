<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramunresallp22 extends JA_Controller {
 
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

	public function audiencebar_by_program_export(){
		
		
		$where = '';
		

			$periode = date_format(date_create($this->Anti_si($this->input->post('end_date',true))),"Y-F");

		  
		   if( !empty($this->Anti_si($this->input->post('type',true))) ) {
			  $type = $this->Anti_si($this->input->post('type',true));
		  } else {
			  $type = 'Viewers';
		  }
		 
		   if( !empty($this->Anti_si($this->input->post('profile',true))) ) {
			  $profile = $this->Anti_si($this->input->post('profile',true));
		  } else {
			  $profile = '0';
		  }
		  
		   if( !empty($this->Anti_si($this->input->post('start_date',true))) ) {
			  $start_date = $this->Anti_si($this->input->post('start_date',true));
		  } else {
			  $start_date = '0';
		  }
		  
		   if( !empty($this->Anti_si($this->input->post('tipe_filter_prog',true))) ) {
			  $tipe_filter = $this->Anti_si($this->input->post('tipe_filter_prog',true));
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($this->Anti_si($this->input->post('end_date',true))) ) {
			  $end_date = $this->Anti_si($this->input->post('end_date',true));
		  } else {
			  $end_date = '0';
		  }
		  
		   if( !empty($this->Anti_si($this->input->post('check',true))) ) {
			  $check = $this->Anti_si($this->input->post('check',true));
		  } else {
			  $check = 'False';
		  }

		  if( !empty($this->Anti_si($this->input->post('check2',true))) ) {
			  $check2 = $this->Anti_si($this->input->post('check2',true));
		  } else {
			  $check2 = 'False';
		  }
		  
		   if( !empty($this->Anti_si($_GET['searchtxt'])) ) {
			  $searchtxt = $this->Anti_si($_GET['searchtxt']);
		  } else {
			  $searchtxt = "";
		  } 
		  
		  

		  
		   if( !empty($this->Anti_si($_GET['channel'])) ) {
			  $searchtxt = $this->Anti_si($_GET['channel']);
			  
			  if($this->Anti_si($_GET['channel']) == 'All'){
				  $where = '';
			  }else{
				  $where = '  ';
			  }
			  
		  } else {
			  $searchtxt = "";
		  }
		  
		  if( !empty($this->Anti_si($this->input->post('survey_data',true))) ) {
			  $survey_data = $this->Anti_si($this->input->post('survey_data',true));
		  } else {
			  $survey_data = '';
		  }

		  
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
			
			if($survey_data == '2022'){
				$id_profile_all = 1;
				$tnt_dec = 0;
				$tb1 = 'M_SUM_TV_DASH_OTHER_RES_P22';

				
			}else{
				$id_profile_all = 0;
				 $tnt_dec = 3;
				 $tb1 = 'M_SUM_TV_DASH_OTHER_RES';
			}
			
			$array_ordering = ['rank','PROGRAM','CHANNEL','AUDIENCE','VIEWERS','TVR','TVS','INDEX','REACH'];
		 
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['searchtxt'] 	= "";
			$params['check'] 	= $check;
			$params['check2'] 	= $check2;
			$params['start_date'] 	= $start_date;
			$params['end_date'] 	= $end_date;
			$params['survey_data'] 	= $survey_data;
			$params['search_t'] = $this->input->post('search_t');
			$params['order_t'] = $this->input->post('order_t');
			
			
			$order_s = explode(',',$params['order_t']);
			
			if($params['order_t'] == '' ){
				$params['order_column'] = "AUDIENCE";
				$params['order_dir'] = "DESC";
			}else{
				$params['order_column'] = $array_ordering[$order_s[0]];
				$params['order_dir'] = $order_s[1];
			}
			

		$date_periode = $this->tvprogramun_model->get_periode_date($periode); 
		
		if($tipe_filter == 'live'){
		
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL'] ){
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_alls_print("Program",$where,$params,$pilihprog,$profile);
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_avg_alls_print("Program",$where,$params,$pilihprog,$profile,$start_date,$end_date);
			}
		}
		
				
		    $data = array();	
			  $idx = 1; 
			  
			  if($pilihprog == 'TVR' || $pilihprog == 'TVS' || $pilihprog == 'Reach' || $pilihprog == 'avgtotdur' || $pilihprog == 'avgtotaud' || $pilihprog == 'IDX'){
				  $decs = 2;
			  }elseif($pilihprog == 'Audience2'){
				  $decs = 0;
			  }else{
				  $decs = 3;
			  }
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode,$tb1);
			  
			if( $profile == 0 ){
				$universe = 17328363;
			} elseif( $profile == 1 ){
				$universe = 19479435;
				$int_sda = 0;
			} else{
				$get_univ = $this->tvprogramun_model->get_univ($profile);
				$universe = $get_univ[0]['respondents_all'];
				$params['flag'] = $get_univ[0]['flag'];
			}
			  
			  
		   foreach ( $list['data'] as $k => $v ) {
			   
				array_push($data, 
					  array(
						  number_format($idx,0,',','.'),
						  $v['PROGRAM'],
						  $v['CHANNEL'],
						  number_format($v['AUDIENCE'],0,'',''),
						  number_format($v['VIEWERS'],3,'',''),
						   number_format($v['TVR'],2,'',','),
						  number_format($v['TVS'],2,'',','),
						   number_format($v['INDEX'],2,'',','),
						  number_format(($v['AUDIENCE']/$universe)*100,2,'',',')
						   
						  
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
					->setCellValue('D1', 'Audience')
					->setCellValue('E1', 'Viewers')
					->setCellValue('F1', 'TVR')
					->setCellValue('G1', 'TVS')
					->setCellValue('H1', 'INDEX')
					->setCellValue('I1', 'Reach');
	   
	   $it1 = 2;
		 foreach($data as $frt){
			
			
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
		$objPHPExcel->setActiveSheetIndex(0);

		

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('/var/www/html/tmp_doc/Audience_by_program.xls');	
		
			
	}
	
	public function get_filter_programaud(){
		
		$where = '';
		
		
		 if( !empty($this->Anti_si($_GET['periode'])) ) {
			  $periode = $this->Anti_si($_GET['periode']);
		  } else {
			  $periode = NULL;
		  }
		  
		   if( !empty($this->Anti_si($_GET['pilihprog'])) ) {
			  $pilihprog = $this->Anti_si($_GET['pilihprog']);
		  } else {
			  $pilihprog = 'Viewers';
		  }
		  
		   if( !empty($this->Anti_si($_GET['profile'])) || $this->Anti_si($_GET['profile']) == 0 ) {
			  $profile = $this->Anti_si($_GET['profile']);
		  } else {
			  $profile = '1';
		  }
		  
		  
		  
		   if( !empty($this->Anti_si($_GET['start_date2'])) ) {
			  $start_date = $this->Anti_si($_GET['start_date2']);
		  } else {
			  $start_date = '0';
		  }
		  
		   if( !empty($this->Anti_si($_GET['tipe_filter_prog'])) ) {
			  $tipe_filter = $this->Anti_si($_GET['tipe_filter_prog']);
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($this->Anti_si($_GET['end_date2'])) ) {
			  $end_date = $this->Anti_si($_GET['end_date2']);
		  } else {
			  $end_date = '0';
		  } 
		  
		  if( !empty($this->Anti_si($_GET['survey_data'])) ) {
			  $survey_data = $this->Anti_si($_GET['survey_data']);
		  } else {
			  $survey_data = '';
		  }
		  
		   if( !empty($this->Anti_si($_GET['check'])) ) {
			  $check = $this->Anti_si($_GET['check']);
		  } else {
			  $check = 'False';
		  }
		  
		  if( !empty($this->Anti_si($_GET['check2'])) ) {
			  $check2 = $this->Anti_si($_GET['check2']);
		  } else {
			  $check2 = 'False';
		  }
		  
		   if( !empty($this->Anti_si($_GET['searchtxt'])) ) {
			  $searchtxt = $this->Anti_si($_GET['searchtxt']);
		  } else {
			  $searchtxt = "";
		  }
		  
		   if( !empty($this->Anti_si($_GET['channel'])) ) {
			  $searchtxt = $this->Anti_si($_GET['channel']);
			  
			  if($_GET['channel'] == 'All'){
				  $where = '';
			  }else{
				  $where = '  ';
			  }
			  
		  } else {
			  $where = "";
		  }
		  
		 
		  
		if($survey_data == '2022'){
			$id_profile_all = 1;
			$tnt_dec = 0;
			$tb1 = 'M_SUM_TV_DASH_OTHER_RES_P22';

			
		}else{
			$id_profile_all = 0;
			 $tnt_dec = 3;
			 $tb1 = 'M_SUM_TV_DASH_OTHER_RES';
		}
		  

		  
		   
		  if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		  if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		  if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		  $order_fields = array('AUDIENCE','PROGRAM','CHANNEL','AUDIENCE','VIEWERS','TVR','TVS','`INDEX`','REACH');
		  $order = $this->input->get_post('order');
		  if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		  if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		  
		    $params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['periode'] = date("Y-F", strtotime($start_date));
			$params['profile'] 	= $profile;
			$params['start_date'] 	= $start_date;
			$params['end_date'] = $end_date;
			$params['check'] 	= $check;
			$params['check2'] 	= $check2;
			$params['survey_data'] 	= $survey_data;
			$params['searchtxt'] 	= $_GET['search']['value'];
			

			
			$nmonth = date("m", strtotime($periode));
			$date_periode = $this->tvprogramun_model->get_periode_date_n($params['periode']);
			
			//print_r($date_periode);die;
		
		
		
		if($tipe_filter == 'live'){
		
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL'] ){
				
				
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_alls("Program",$where,$params,$pilihprog,$profile);
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_avg_alls("Program",$where,$params,$pilihprog,$profile,$start_date,$end_date);
			}
		}
				
				
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
			  
			  $int_sda = 3;
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode,$tb1);
			 
			  
			  if( $profile == 0 ){
				$universe = 17328363;
			} elseif( $profile == 1 ){
				$universe = 19479435;
				$int_sda = 0;
			} else{
				$get_univ = $this->tvprogramun_model->get_univ($profile);
				$universe = $get_univ[0]['respondents_all'];
				$params['flag'] = $get_univ[0]['flag'];
			}
			  
		   foreach ( $list['data'] as $k => $v ) {
			   
			
			   if($pilihprog == 'avgtotaud'){
				   array_push($data, 
					  array(
						  number_format($v['Rangking'],0,',','.'),
						  $v['Program'],
						  $v['CHANNEL'],
						  "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVR'],$decs,',','.')."</p>",
						  ''
					  )
					);
					$idx++;
			   }else{
			
					array_push($data, 
					  array(
						  number_format($idxx,0,',','.'),
						  $v['PROGRAM'],
						  $v['CHANNEL'],
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['AUDIENCE'],0,',','.')."</p>",
						  "<p style='text-align:right;margin:0 0 0 0'>". number_format($v['VIEWERS'],$tnt_dec,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVR'],2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['TVS'],2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format($v['INDEX'],2,',','.')."</p>",
						   "<p style='text-align:right;margin:0 0 0 0'>".number_format(($v['AUDIENCE']/$universe)*100,2,',','.')."</p>"
						   
						  
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
			$id = 1;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['thn'] = $this->tvprogramun_model->get_tahun();
	
		if(!$this->session->userdata('user_id')) { 
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

		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$survey=$this->input->post('survey');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
	
		$pilihaudiencebar=$this->input->post('audiencebar');
		
		
		$pilihprog=$this->input->post('product_program');
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		
		if (!isset($survey)){ 
		
			$survey = '2022';
		
		}
		$periode=$tahun;
		
		
		if($survey == '2022'){
			$id_profile_all = 1;
			$tnt_dec = 0;
			$tb1 = 'M_SUM_TV_DASH_OTHER_RES_P22';
			$tbl2 = 'M_SUM_TV_DASH_DATE_RES_P22';
			$tbl3 = 'M_MONTH_PROFILE_RES_P22';
			$data['no_respondent'] = '17.521';
			
		}else{
			$id_profile_all = 0;
			 $tnt_dec = 3;
			 $tb1 = 'M_SUM_TV_DASH_OTHER_RES';
			 $tbl2 = 'M_SUM_TV_DASH_DATE_RES';
			 $tbl3 = 'M_MONTH_PROFILE_RES';
			 $data['no_respondent'] = '14.036';
		}
		
		
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole,$periode,$tbl3);
		
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['channel_list'] = $this->tvprogramun_model->channel_list($periode);
		$data['dayparts'] = $this->tvprogramun_model->list_daypart($iduser);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode,$tb1);
		$data['active_audience2'] = $this->tvprogramun_model->get_active_audience2($periode,$tb1);
		$data['aa'] = $data['active_audience'][0]['VIEWERS'];
		$data['aa2'] = $data['active_audience2'][0]['VIEWERS'];
		
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
		
		
		$time = strtotime($data['STR_TGL']);
		$data['final'] = date("Y-m-d", strtotime("-2 month", $time));
		


		$data['id_profile_all'] = $id_profile_all;
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode,$tb1);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode,$tb1);
		$data['daypart_list'] = $this->tvprogramun_model->list_default_daypart($iduser,$periode);
		$data['daypart_list_all'] = $this->tvprogramun_model->list_default_daypart_all($iduser,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode,$tbl2);
		

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
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("PROGRAM",$where,$periode,$pilihprog,$id_profile_all);
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_alls("channel_name",$where,$periode,$pilihaudiencebar,$id_profile_all,"True","ALL"); 
				 
		$dataM=$data['channels'];
		$scama = array();
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			$scam['AUDIENCE'] = number_format($dataM[$i]['AUDIENCE'],0,',','.');
			$scam['VIEWERS'] = number_format($dataM[$i]['VIEWERS'],$tnt_dec,',','.');
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
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode,$tb1);
		$data['totpopulasi_a'] = $this->tvprogramun_model->list_populasi2a($periode,$tb1);
		$data['survey_data'] = $survey;


			$this->template->load('maintemplate_urban', 'tvprogramunresallp22/views/Tvprogramun', $data);

		
	}	

	function days_in_month($month, $year) 
	{ 
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function day_filter(){
		
		$param['start_date_d'] =  $this->Anti_si($this->input->post('start_date_d',true));
		$param['end_date_d'] =  $this->Anti_si($this->input->post('end_date_d',true));
		$param['channel_d'] =  $this->Anti_si($this->input->post('channel_d',true));
		$param['audiencebar_2']=$this->Anti_si($this->input->post('audiencebar_2',true));
		$param['interval']=$this->Anti_si($this->input->post('interval',true)); 
		$param['respondent']=$this->Anti_si($this->input->post('respondent',true));
		$param['survey_data']=$this->Anti_si($this->input->post('survey_data',true));
		
		if($param['survey_data'] == '2022'){
			$param['tbl'] = 'M_SUM_TV_DASH_DATE_RES_P22';
		}else{
			$param['tbl'] = 'M_SUM_TV_DASH_DATE_RES';
		}
		 
		
		$data['date'] = $this->tvprogramun_model->day_filters($param);
		
		
			if ($data['date'] <> null){
				foreach($data['date'] as $datasss){
					$data_date[] = $datasss['date'];
					$spot_date[] = floatval($datasss['spot']);
				}
			}else {
				$data_date[]='';
				$spot_date[] =0;
			}	

		
		
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		
		echo json_encode($data,true); 
		
		
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
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$end_date=$this->Anti_si($this->input->post('end_date',true));
		$start_date=$this->Anti_si($this->input->post('start_date',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		$search=$this->Anti_si($this->input->post('search',true));
		$order=$this->Anti_si($this->input->post('order',true));
		$daypart=$this->Anti_si($this->input->post('dayparts',true));
		$survey=$this->Anti_si($this->input->post('survey',true));
		
		
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
			}else{
				$types = 'Audience';
			}

	
		$periode=$tahun;
		$date_periode = $this->tvprogramun_model->get_periode_date($periode);
	
		if($tipe_filter == 'live'){
			
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL']){
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_alls_exp("channel_name",$where,$periode,$type,$profile,$check,$order,$search,$daypart); 
			}else{
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_avg_alls_exp($daypart,$where,$periode,$type,$profile,$check,$start_date,$end_date,$order,$search,$survey); 
			}
		
		}
		
		
		// print_r($data['channel']);die;
		
		
		if($daypart == 'ALL' ){
			$int_sda = 3;
		}else{
			$int_sda = 0;
		}
		
		if( $profile == 0 ){
			$universe = 17328363;
		} elseif( $profile == 1 ){
			$universe = 19479194;
			$int_sda = 0;
		} else{
			$get_univ = $this->tvprogramun_model->get_univ($profile);
			$universe = $get_univ[0]['respondents_all'];
			$params['flag'] = $get_univ[0]['flag'];
			if($params['flag'] == 2){
				$int_sda = 0;
			}
		}
		
	
      if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
					foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    				
						$data_ch[$ik]['AUDIENCE'] = number_format($datax['AUDIENCE'],0,'','');
						$data_ch[$ik]['VIEWERS'] = number_format($datax['VIEWERS'],$int_sda,'','');
						$data_ch[$ik]['TVR'] = number_format($datax['TVR'],2,',','');
						$data_ch[$ik]['TVS'] = number_format($datax['TVS'],2,',','');
						$data_ch[$ik]['INDEX'] = number_format($datax['INDEX'],2,',','');
						$data_ch[$ik]['REACH'] = number_format(($datax['AUDIENCE']/$universe)*100,2,',','');
						 
    					$i++; 
    					$ik++;
    				}
      } else {
          $data_ch = null;
      }
      
//print_r($data_ch);die;
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
		$end_date=$this->Anti_si($this->input->post('end_date',true));
		$survey=$this->Anti_si($this->input->post('survey',true));
		$start_date=$this->Anti_si($this->input->post('start_date',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		$daypart=$this->Anti_si($this->input->post('dayparts',true));
		
		
		$periode=$tahun;
		
		
		$date_periode = $this->tvprogramun_model->get_periode_date_n($start_date);
		
		
		
		if($tipe_filter == 'live'){
			
			if($start_date == $date_periode[0]['STR_TGL'] && $end_date == $date_periode[0]['END_TGL']){
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_alls("channel_name",$where,$periode,$type,$profile,$check,$daypart); 
			}else{
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_avg_alls($daypart,$where,$periode,$type,$profile,$check,$start_date,$end_date,$survey); 
			}
		
		}else{
			
			
			
		}
		
		if($daypart == 'ALL' ){
			$int_sda = 3;
		}else{
			$int_sda = 0;
		}
		
		
		if( $profile == 0 ){
			$universe = 17328363;
		} elseif( $profile == 1 ){
			$universe = 19479194;
			$int_sda = 0;
		} else{
			$get_univ = $this->tvprogramun_model->get_univ($profile);
			$universe = $get_univ[0]['respondents_all'];
			$params['flag'] = $get_univ[0]['flag'];
			if($params['flag'] == 2){
				$int_sda = 0;
			}
		}

      if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;

    				foreach($data['channel'] as $datax){
    					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					
						$data_ch[$ik]['AUDIENCE'] = number_format($datax['AUDIENCE'],0,',','.');
						$data_ch[$ik]['VIEWERS'] = number_format($datax['VIEWERS'],$int_sda,',','.');
						$data_ch[$ik]['TVR'] = number_format($datax['TVR'],2,',','.');
						$data_ch[$ik]['TVS'] = number_format($datax['TVS'],2,',','.');
						$data_ch[$ik]['INDEX'] = number_format($datax['INDEX'],2,',','.');
						$data_ch[$ik]['REACH'] = number_format(($datax['AUDIENCE']/$universe)*100,2,',','.');
						 
    					$i++; 
    					$ik++;
    				}
  
      } else {
          $data_ch = null;
      }
      
		  echo json_encode($data_ch,true);
	}
	
	
	function save_daypart(){
		
		$data['new_time'] =  $this->input->post('new_time');
		$data['to'] =  $this->input->post('to');
		$data['from'] =  $this->input->post('from');
		$data['user_id'] = $this->session->userdata('user_id');
		
		$data['new_to'] =  date("H:i:s", strtotime($data['to'].":00") - 1);
		$data['new_from'] = $data['from'].':00';
		
		$data['list_save'] = $this->tvprogramun_model->save_daypart($data);
		
		print_r($data);die;
		
	}
	
	function apply_daypart(){
		
		$data['user_id'] = $this->session->userdata('user_id');
		$data['vis_val_1'] =  $this->Anti_si($this->input->post('vis_val_1',true));
		$data['vis_val_2'] =  $this->Anti_si($this->input->post('vis_val_2',true));
		$data['vis_val_3'] =  $this->Anti_si($this->input->post('vis_val_3',true));
		$data['vis_val_4'] =  $this->Anti_si($this->input->post('vis_val_4',true));
		$data['vis_val_5'] =  $this->Anti_si($this->input->post('vis_val_5',true));
		$data['vis_val_6'] =  $this->Anti_si($this->input->post('vis_val_6',true));
		$data['dplist_1'] =  $this->Anti_si($this->input->post('dplist_1',true));
		$data['dplist_2'] =  $this->Anti_si($this->input->post('dplist_2',true));
		$data['dplist_3'] =  $this->Anti_si($this->input->post('dplist_3',true));
		$data['dplist_4'] =  $this->Anti_si($this->input->post('dplist_4',true));
		$data['dplist_5'] =  $this->Anti_si($this->input->post('dplist_5',true));
		$data['dplist_6'] = $this->Anti_si( $this->input->post('dplist_6',true));
		$data['periode'] =  $this->Anti_si($this->input->post('periode',true));
		$data['survey_data'] =  $this->Anti_si($this->input->post('survey_data',true));
		$data['periode_num'] =  date('Ym',strtotime($data['periode']));

		$list_data = $this->tvprogramun_model->apply_daypart($data);
		
		$data_label = [];
		$data_num = [];
		foreach($list_data as $list_datas){
			
			$data_label[] = $list_datas['TEXT'];
			$data_num[] = $list_datas['AUD'];
			
		}
		
		$data_return['data_label'] = $data_label;
		$data_return['data_num'] = $data_num;
		
		echo json_encode($data_return,true);
		
	}

}

