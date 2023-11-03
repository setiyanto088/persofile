<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class tvprogramun3tvvsea extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}

	public function filter_days(){
		
		$userid = $this->session->userdata('user_id');
		$type =  $this->Anti_si($this->input->post('audiencebarday',true));
		$periode =  $this->Anti_si($this->input->post('periode',true));
		$start_date =  $this->Anti_si($this->input->post('start_date',true));
		$end_date =  $this->Anti_si($this->input->post('end_date',true));
		$preset =  $this->Anti_si($this->input->post('preset',true));
		$channelp =  $this->Anti_si($this->input->post('channelp',true));
		$where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ";
		
 		
		$date_range = $this->getDatesFromRange($start_date,$end_date);
		
		
 		if($channelp == "0" ){
			
			 if($preset == "0"){
				 
				if($type == 'Viewers'){
					$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2_viewer($where,$periode,$start_date,$end_date,$preset);
				}elseif($type == 'Duration'){
					$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2_duration($where,$periode,$start_date,$end_date,$preset);
				}else{
					$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode,$start_date,$end_date,$preset);
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
			 }else{
				 
				 if($preset <> "0"){
					$channel_set = $this->tvprogramun_model->channel_set($preset,$userid);
					$channel_list = explode(',',$channel_set[0]['CHANNEL_LIST']);
				 }else{
					$channel_list = explode(',',$channelp);
				 }
				
 				
				$str_channel = '';
				$oo = 0;
				foreach($channel_list as $channel_lists){
					
					$color= "#".substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
					$str_channel = $str_channel."'".$channel_lists."',";
					
					$data['date'][$oo]['CHANNEL'] = $channel_lists;
					$data['date'][$oo]['COLOR'] = $color;
					
					if($type == 'Viewers'){
						$where = "AND CHANNEL = '".$channel_lists."'"; 
						$dataf = $this->tvprogramun_model->list_spot_by_date_all2_viewer_preset_s($where,$periode,$start_date,$end_date,$where);
					}elseif($type == 'Duration'){
						$where = "AND CHANNEL = '".$channel_lists."'";  
						$dataf = $this->tvprogramun_model->list_spot_by_date_all2_duration_preset_s($where,$periode,$start_date,$end_date,$where);
					}else{
						$where = "AND CHANNEL = '".$channel_lists."'";  
						$dataf = $this->tvprogramun_model->list_spot_by_date_all2_preset_s($where,$periode,$start_date,$end_date,$where);
					}
					
					foreach($dataf as $dataff){
						$data['date'][$oo][$dataff['date']] = $dataff['spot'];
					}
					
					$oo++;
					
				}
				
				$str_channel = substr($str_channel, 0, -1);
				
					if ($data['date'] <> null){ 
						foreach($date_range as $datasss){
							$data_date[] = $datasss;
 						}
					}		
					else {
						$data_date[]='';
						$spot_date[] =0;
					}		
					
					$data['json_date'] = $data_date;
					$data['json_spot_date'] = '';
				 
			 }
 			
		}else{
		 
				$channel_list = explode(',',$channelp);
		 
			
			$str_channel = '';
			$oo = 0;
			foreach($channel_list as $channel_lists){
				
				$color= "#".substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
				$str_channel = $str_channel."'".$channel_lists."',";
				
				$data['date'][$oo]['CHANNEL'] = $channel_lists;
				$data['date'][$oo]['COLOR'] = $color;
				
				if($type == 'Viewers'){
					$where = "AND CHANNEL = '".$channel_lists."'"; 
					$dataf = $this->tvprogramun_model->list_spot_by_date_all2_viewer_preset_s($where,$periode,$start_date,$end_date,$where);
				}elseif($type == 'Duration'){
					$where = "AND CHANNEL = '".$channel_lists."'";  
					$dataf = $this->tvprogramun_model->list_spot_by_date_all2_duration_preset_s($where,$periode,$start_date,$end_date,$where);
				}else{
					$where = "AND CHANNEL = '".$channel_lists."'";  
					$dataf = $this->tvprogramun_model->list_spot_by_date_all2_preset_s($where,$periode,$start_date,$end_date,$where);
				}
				
				foreach($dataf as $dataff){
					$data['date'][$oo][$dataff['date']] = $dataff['spot'];
				}
				
				$oo++;
				
			}
			
			$str_channel = substr($str_channel, 0, -1);

			if ($data['date'] <> null){ 
				foreach($date_range as $datasss){
					$data_date[] = $datasss;
 				}
			}		
			else {
				$data_date[]='';
				$spot_date[] =0;
			}		
			
			$data['json_date'] = $data_date;
			$data['json_spot_date'] = '';
			
		}
 
		
		echo json_encode($data,true); 
 		
	}

  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$this->Anti_si($_GET['g']));
      $list = $this->tvprogramun_model->channelsearch($this->Anti_si($_GET['q']),$genre,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }     

	public function audiencebar_by_program_export(){
		
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('pilihprog',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile_prog',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$periode=$this->Anti_si($this->input->post('periode',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		  
 		  
		 $where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ";
		
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
 			
			
 			
			$nmonth = date("m", strtotime($periode));
			$datef = $tgl."/".$nmonth."/".substr($periode,0,4);
			$datefF = substr($periode,0,4)."-".$nmonth."-".$tgl;
			
			$params['tgl'] 	= $datefF;
		
		if($tipe_filter == 'live'){	
		
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_x("Program",$where,$params,$pilihprog,'0');
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day_x("Program",$where,$params,$pilihprog,'0');
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week_x("Program",$where,$params,$pilihprog,'0');
			}
				
				}else{
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_tvod_x("Program",$where,$params,$pilihprog,$profile,$tipe_filter);
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("Program",$where,$params,$pilihprog,$profile);
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week("Program",$where,$params,$pilihprog,$profile);
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
			   
			   if($pilihprog == 'Reach'){
				   $re = ($v['Spot']/$totpopulasi[0]['tot_pop'])*100;
				   $vvv =  $re;
			   }else{
				   $vvv =  $v['Spot'];
			   }
			   
			    array_push($data, 
				  array(
					  number_format($v['Rangking'],0,',','.'),
					  $v['Program'],
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
		  
		   if( !empty($this->Anti_si($_GET['profile'])) ) {
			  $profile = $this->Anti_si($_GET['profile']);
		  } else {
			  $profile = '0';
		  }
		  
		   if( !empty($this->Anti_si($_GET['tgl2'])) ) {
			  $tgl = $this->Anti_si($_GET['tgl2']);
		  } else {
			  $tgl = '0';
		  }
		  
		   if( !empty($this->Anti_si($_GET['tipe_filter_prog'])) ) {
			  $tipe_filter = $this->Anti_si($_GET['tipe_filter_prog']);
		  } else {
			  $tipe_filter = 'live';
		  }
		  
		   if( !empty($this->Anti_si($_GET['week2'])) ) {
			  $week = $this->Anti_si($_GET['week2']);
		  } else {
			  $week = '0';
		  }
		  
		   $check = $this->Anti_si($_GET['check']);
		 
		  
		   if( !empty($this->Anti_si($_GET['searchtxt'])) ) {
			  $searchtxt = $this->Anti_si($_GET['searchtxt']);
		  } else {
			  $searchtxt = "";
		  }
		  
		  $where = '';
	 
		  
		   
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
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new("Program",$where,$params,$pilihprog,$profile);
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("Program",$where,$params,$pilihprog,$profile);
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week("Program",$where,$params,$pilihprog,$profile);
			}
			
		}else{
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_tvod("Program",$where,$params,$pilihprog,$profile,$tipe_filter);
				}else{
					$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_day("Program",$where,$params,$pilihprog,$profile);
				}
			}else{
				$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_week("Program",$where,$params,$pilihprog,$profile);
			}
			
		}
				
		    $data = array();	
			  $idx = 0; 
			  
			  if($pilihprog == 'TVR' || $pilihprog == 'Reach' || $pilihprog == 'avgtotdur' || $pilihprog == 'avgtotaud'){
				  $decs = 2;
			  }else{
				  $decs = 0;
			  }
			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			  
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
						  number_format($v['Rangking'],0,',','.'),
						  $v['Program'],
						  $v['CHANNEL'],
						  $vvv
					  )
					);
					$idx++;
			   }
		   }
			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
 	  
			$this->json_result($result);
			
	}
	
	function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
      
     $array = array(); 
      
   
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
  
     foreach($period as $date) {                  
        $array[] = $date->format($format);  
    } 
  
     return $array; 
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
		 
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
	 
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		if (!isset($tahun)){ 
			 
			
			$tahun= $data['thn'][0]['TANGGAL'];
 		}
		$periode=$tahun;
		
 		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole,$periode);
		
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		 
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience_all($periode);
 		$data['total_views'] = $this->tvprogramun_model->get_total_views_all($periode);
 		$data['duration'] = $this->tvprogramun_model->get_duration_all($periode);
		$data['aa'] = $data['active_audience'][0]['VIEWERS'];
	 
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		$name_tbs_new = strtoupper(date_format(date_create($periode),"Y-m")); 
		
		$starts_sds = explode("-",$name_tbs_new);
		$end_date_m = cal_days_in_month(CAL_GREGORIAN,$starts_sds[1],$starts_sds[0]);
		
		if($starts_sds[1] == date('m')){
			$end_month_full = $starts_sds[0].'-'.$starts_sds[1].'-'.date('d');
		}else{
			$end_month_full = $starts_sds[0].'-'.$starts_sds[1].'-'.$end_date_m;
		}
		
		$start_month_full = $starts_sds[0].'-'.$starts_sds[1].'-01';
		
 		$first_day = $start_month_full;
 		$this_day = $end_month_full;
		
		
 		$data['cond'] = $where;
		 
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode,$first_day,$this_day,"");
		$data['channel'] = $this->tvprogramun_model->list_channel();
		$params['user_id'] = $iduser;
		$data['preset'] = $this->tvprogramun_model->load_channels($params);
		
 
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
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0","True"); 
		
 
		$array_channel = array();

		$dataM=$data['channels'];
		$scama = array();
		$scama2 = array();
		for ($i=0;$i<count($dataM);$i++){
			
			$array_channel[$dataM[$i]['channel']]['Rangking'] = $i+1;
			$array_channel[$dataM[$i]['channel']]['Spot'] = $dataM[$i]['Spot'];
			$array_channel[$dataM[$i]['channel']]['CHANNEL'] = $dataM[$i]['channel'];
			
			$scam['Rangking'] = $i+1;
			$scam['Spot'] = $dataM[$i]['Spot'];
			$scam['channel'] = $dataM[$i]['channel'];
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
			array_push($scama, $scam); 
		}	
		
		
		
		$data['first_day'] = $first_day;
		$data['this_day'] =  $this_day;
 		
		$day_dates = array();
		
		$ddj = date_format(date_create($this_day),"j");
		$ddjh = date_format(date_create($this_day),"Y-m-");
		 
			
		for($iot=1;$iot<=intval($ddj);$iot++){
					
			if($iot < 10){
				$day_date = '0'.$iot;
			}else{
				$day_date = $iot;
			}
					 
			$curr_date_a = date($ddjh.$day_date);
					
			$day_dates[] = $curr_date_a;
 		}
		
	 
		
		$data['all_data'] = $this->tvprogramun_model->list_spot_all_days("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$first_day,$this_day);
		
		foreach($data['all_data'] as $all_data){
			
			$array_channel[$all_data['CHANNEL']][$all_data['DAYS']] = $all_data['VIEWERS'];
 			
		}
		
 		
		foreach($array_channel as $array_channel_a){
		
		
		if(isset($array_channel_a['CHANNEL'])){
			$curr_channel = $array_channel_a['CHANNEL'];
			
			$scam2['Rangking'] = $array_channel_a['Rangking']; 
			$scam2['Spot'] = $array_channel_a['Spot'];
			$scam2['channel'] = $array_channel_a['CHANNEL'];
			
				for($io=1;$io<=intval($ddj);$io++){
					
					if($io < 10){
						$day_date = '0'.$io;
					}else{
						$day_date = $io;
					}
					 
					$curr_date_a = date($ddjh.$day_date);
					
					 
					
					if(isset($array_channel_a[$curr_date_a])){
						$scam2[$curr_date_a] = $array_channel_a[$curr_date_a];
 					}else{
						$scam2[$curr_date_a] = 0;
						$array_channel[$curr_channel][$curr_date_a] = 0;
 					}
					
				}
			
 			}
			
			array_push($scama2, $scam2); 
		}
		
		$data['day_dates'] = $day_dates;
		$data['audiencebychannel'] = json_encode($scama2,true); 
		
		 
		$data['spots'] = $this->tvprogramun_model->count_program_all($periode);
		
		 
		$data['json_channel'] = $data_cha;
		$data['json_spot'] = $spot_cha;
		
	 
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
	 
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		 
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel($periode);
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);

		
		$this->template->load('maintemplate', 'tvprogramun3tvvsea/views/Tvprogramun', $data);
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
		
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$start_date=$this->Anti_si($this->input->post('start_date',true));
		$end_date=$this->Anti_si($this->input->post('end_date',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		$channel = $this->Anti_si($this->input->post('channel',true));
		$preset = $this->Anti_si($this->input->post('preset',true));
		
		
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
		
		if( ! empty($this->input->post('channel')) ) {
			$channel = $this->input->post('channel');
		} else {
			$channel = NULL;
		}	

		$datef = $start_date;
		$periode=$tahun;

		$pilihaudiencebar = $type;
		
		$first_day = $start_date;
		$this_day = $end_date;
		
		if($preset == "0"){
			
			$where = "";
		}else{
			
			$channel_set = $this->tvprogramun_model->channel_set($preset,$userid);
			
			$channel_list = explode(',',$channel_set[0]['CHANNEL_LIST']);
			
			$str_channel = '';
			foreach($channel_list as $channel_lists){
				
				$str_channel = $str_channel."'".$channel_lists."',";
				
			}
			
			$str_channel = substr($str_channel, 0, -1);
 			
			$where = "AND R.CHANNEL IN (".$str_channel.")"; 
		}
		
		 // $where = " AND R.CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ";
		
		$where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia','AL JAZEERA','BLOOMBERG','CHANNEL NEWS ASIA','CNBC','CNN INTERNATIONAL','DW TV','EURONEWS','FRANCE 24','SEA TODAY','TRT WORLD','TVBS NEWS','CNBC','TV ONE','CNN INDONESIA','METRO TV','KOMPAS TV','TVRI','BERITA SATU','TVRI','INEWS','IDX','MNC NEWS','CNBC Indonesia')";
		
		if($week == 'ALL'){
			
			$where = $where."";
			$where = $where." AND R.DAYS BETWEEN '".$first_day."' AND '".$this_day."'";
			
		}else{
			
			 $where = $where." AND WEEK(DAYS) = ".$week." AND TANGGAL = '".$periode."'";
			
		}
		
 		
		if($tipe_filter == 'live'){
		
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_fix_exp("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$first_day,$this_day,$where_k); 
		
		}else{
			
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_tvod_exp("channel_name",$where,$periode,$type,$profile,$check,$tipe_filter,$first_day,$this_day); 
			
		}
 		
		
		$array_channel = array();

		$dataM=$data['channels'];
		$scama = array();
		$scama2 = array();
		for ($i=0;$i<count($dataM);$i++){
			
			$array_channel[$dataM[$i]['channel']]['Rangking'] = $i+1;
			$array_channel[$dataM[$i]['channel']]['Spot'] = $dataM[$i]['Spot'];
			$array_channel[$dataM[$i]['channel']]['CHANNEL'] = $dataM[$i]['channel'];
			$array_channel[$dataM[$i]['channel']]['TOTAL_VIEWERS'] = $dataM[$i]['VIEWERS_TOTAL'];
			
			$scam['Rangking'] = $i+1;
			$scam['Spot'] = $dataM[$i]['Spot'];
			$scam['channel'] = $dataM[$i]['channel'];
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
			array_push($scama, $scam); 
		}	
		
		
		
		$data['first_day'] = $first_day;
		$data['this_day'] =  $this_day;
 		
 		
		if($week == 'ALL'){
			$day_dates = $this->getDatesFromRange($first_day,$this_day);
		}else{
			$day_datesSS = $this->tvprogramun_model->get_week_days($where);
			
			
			foreach($day_datesSS as $day_datesSSas){
				
				$day_dates[] = $day_datesSSas['DAYS'];
				
			}
 		}
		
 		
		$data['day_dates'] = $day_dates;
		
		$table_html = '<table id="example4" class="table table-striped table-bordered example" style="width: 100%"><thead><tr><th rowspan = "2" >Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th rowspan = "2" >Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th colspan = "'.count($day_dates).'">Audience </th></tr><tr>';
		foreach($day_dates as $day_datess){
			$table_html = $table_html.'<th >'.$day_datess.'</th>';
		}
		
		if($tipe_filter == 'live'){
			$data['all_data'] = $this->tvprogramun_model->list_spot_all_days("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$day_dates[0],end($day_dates));
		}else{
			$data['all_data'] = $this->tvprogramun_model->list_spot_all_days_tvod("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$first_day,$this_day,$tipe_filter);
		}
		
		foreach($data['all_data'] as $all_data){
			
			$array_channel[$all_data['CHANNEL']][$all_data['DAYS']] = $all_data['VIEWERS'];
 			
		}
		
 		
		foreach($array_channel as $array_channel_a){
		
		
			if(isset($array_channel_a['CHANNEL'])){
				$curr_channel = $array_channel_a['CHANNEL'];
				
				$scam2['Rangking'] = $array_channel_a['Rangking'];
				$scam2['Spot'] = $array_channel_a['Spot'];
				$scam2['channel'] = $array_channel_a['CHANNEL'];
				$scam2['TOTAL_VIEWERS'] = $array_channel_a['TOTAL_VIEWERS'];
			
				foreach($day_dates as $day_datesss){
				
				 
					$curr_date_a = $day_datesss;
					
			 
					
					if(isset($array_channel_a[$curr_date_a])){
						$scam2[$curr_date_a] = $array_channel_a[$curr_date_a];
 					}else{
						$scam2[$curr_date_a] = 0;
						$array_channel[$curr_channel][$curr_date_a] = 0;
 					}
					
 				
				}
				array_push($scama2, $scam2); 
 			}
			
			
		}
		
 		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$array_cell = ['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
		
		foreach($scama2 as $adadada){
			
			$table_html = $table_html.'<tr><td>'.$adadada['Rangking'].'</td><td>'.$adadada['channel'].'</td>';
			$ttrs = 0;
			foreach($day_dates as $day_datess){
				$table_html = $table_html.'<td>'.$adadada[$day_datess].'</td>';
				$ttrs++;
				
				$new_cell = $ttrs;
				 $objPHPExcel->setActiveSheetIndex(0)
				 ->setCellValue($array_cell[$new_cell].'2', $day_datess);
			}
			
			$table_html = $table_html.'</tr>';

		}
		
		
 		
		$table_html = $table_html.'</tr></thead></table>';
						
 						
		$data['table'] = $scama2;
		$data['date'] = $day_dates;
		
		
		
		$data['audiencebychannel'] = json_encode($scama2,true); 	
	 
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->mergeCells('A1:A2')
					->setCellValue('A1', 'Rangking')
					->mergeCells('B1:B2')
					->setCellValue('B1', 'Channel')
					->mergeCells('C1:'.$array_cell[$ttrs].'1')
					->setCellValue('C1', $types)
					->mergeCells($array_cell[$ttrs+1].'1:'.$array_cell[$ttrs+1].'2')
					->setCellValue($array_cell[$ttrs+1].'1', "TOTAL");
	   
	   $it1 = 3;
	 
		 foreach($scama2 as $frt){
			
 			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['channel']);
					
					$ttrs = 0;
 					for($rr=0;$rr<count($day_dates);$rr++){
						
 						$ttrs++;
						
						$new_cell = $ttrs;
						 $objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue($array_cell[$new_cell].$it1, $frt[$day_dates[$rr]])
						 ->setCellValue($array_cell[$ttrs+1].$it1, $frt['TOTAL_VIEWERS']);
					}

			$it1++; 
 		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);

		 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');

	   
	}
	
		public function load_channels()
	{
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		$daypart = $this->tvprogramun_model->load_channels($params);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		
		
		
	}
		
	  public function save_channels()
	{
		$userid = $this->session->userdata('user_id');
 		$params['save_channel_name'] = $this->Anti_si($_POST['save_channel_name']);
		
		$channel_lists = explode(',',$this->Anti_si($_POST['channel']));
		
		$arr_ss = array_unique($channel_lists);
		
		 
		$params['channel'] = implode(',', $arr_ss);
		$params['user_id'] = $userid;
		
 		
		$daypart2 = $this->tvprogramun_model->save_channels($params);
		
		$daypart = $this->tvprogramun_model->load_channels($params);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		
		
		
	}	 

	public function delete_channels()
	{
		$userid = $this->session->userdata('user_id');
 		$params['save_channel_name'] = $this->Anti_si($_POST['save_channel_name']);
		$params['user_id'] = $userid;
		
 		
		$daypart2 = $this->tvprogramun_model->delete_channels($params);
		
		$daypart = $this->tvprogramun_model->load_channels($params);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		
		
		
	}
	
	function header_change(){
		
		$periode =  $this->Anti_si($this->input->post('tahun',true));
		$tpe_f =  $this->Anti_si($this->input->post('tpe_f',true));
		
 		if($tpe_f == 'TVOD' ){
			
			$jmlchannel = $this->tvprogramun_model->count_channel_tvod($periode);
			$data['jmlchannel'] = number_format($jmlchannel[0]["jmlch"],0,',','.');
			$jmlprogram = $this->tvprogramun_model->count_program_tvod($periode);
			$data['jmlprogram'] = number_format($jmlprogram[0]["jmlpr"],0,',','.');
			$totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			$data['totpopulasi'] = number_format(intval($totpopulasi[0]["tot_pop"]),0,',','.');
			$active_audience = $this->tvprogramun_model->get_active_audience_tvod($periode);
			$data['active_audience'] = number_format($active_audience[0]['VIEWERS'],0,',','.');
			$total_views = $this->tvprogramun_model->get_total_views_tvod($periode);
			$data['total_views'] = number_format($total_views[0]['TOTAL_VIEWS'],0,',','.');
			$duration = $this->tvprogramun_model->get_duration_tvod($periode);
			$data['duration'] = number_format($duration[0]['DURATION']/60,0,',','.');
			$data['durmin'] = number_format($duration[0]['DURATION']/$total_views[0]['TOTAL_VIEWS'],2,',','.');
			$data['active_user'] = number_format(($active_audience[0]['VIEWERS']/$totpopulasi[0]["tot_pop"])*100,0,',','.');
			
			$data['aa'] = number_format($active_audience[0]['VIEWERS'],0,',','.');
		
		}elseif($tpe_f == 'ALL' ){
		
			$jmlchannel = $this->tvprogramun_model->count_channel_all($periode);
			$data['jmlchannel'] = number_format($jmlchannel[0]["jmlch"],0,',','.');
			$jmlprogram = $this->tvprogramun_model->count_program_all($periode);
			$data['jmlprogram'] = number_format($jmlprogram[0]["jmlpr"],0,',','.');
			$totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			$data['totpopulasi'] = number_format(intval($totpopulasi[0]["tot_pop"]),0,',','.');
			$active_audience = $this->tvprogramun_model->get_active_audience_all($periode);
			$data['active_audience'] = number_format($active_audience[0]['VIEWERS'],0,',','.');
			$total_views = $this->tvprogramun_model->get_total_views_all($periode);
			$data['total_views'] = number_format($total_views[0]['TOTAL_VIEWS'],0,',','.');
			$duration = $this->tvprogramun_model->get_duration_all($periode);
			$data['duration'] = number_format($duration[0]['DURATION']/60,0,',','.');
			$data['durmin'] = number_format($duration[0]['DURATION']/$total_views[0]['TOTAL_VIEWS'],2,',','.');
			$data['active_user'] = number_format(($active_audience[0]['VIEWERS']/$totpopulasi[0]["tot_pop"])*100,0,',','.');
			
			$data['aa'] = number_format($active_audience[0]['VIEWERS'],0,',','.');
		
		}else{
			
			$jmlchannel = $this->tvprogramun_model->count_channel($periode);
			$data['jmlchannel'] = number_format($jmlchannel[0]["jmlch"],0,',','.');
			$jmlprogram = $this->tvprogramun_model->count_program($periode);
			$data['jmlprogram'] = number_format($jmlprogram[0]["jmlpr"],0,',','.');
			$totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			$data['totpopulasi'] = number_format(intval($totpopulasi[0]["tot_pop"]),0,',','.');
			$active_audience = $this->tvprogramun_model->get_active_audience($periode);
			$data['active_audience'] = number_format($active_audience[0]['VIEWERS'],0,',','.');
			$total_views = $this->tvprogramun_model->get_total_views($periode);
			$data['total_views'] = number_format($total_views[0]['TOTAL_VIEWS'],0,',','.');
			$duration = $this->tvprogramun_model->get_duration($periode);
			$data['duration'] = number_format($duration[0]['DURATION']/60,0,',','.');
			$data['durmin'] = number_format($duration[0]['DURATION']/$total_views[0]['TOTAL_VIEWS'],2,',','.');
			$data['active_user'] = number_format(($active_audience[0]['VIEWERS']/$totpopulasi[0]["tot_pop"])*100,0,',','.');
			
			$data['aa'] = number_format($active_audience[0]['VIEWERS'],0,',','.');
			
		}
		echo json_encode($data,true);
		
	}
	
	function audiencebar_by_channel(){
		
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$start_date=$this->Anti_si($this->input->post('start_date',true));
		$end_date=$this->Anti_si($this->input->post('end_date',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		$channel = $this->Anti_si($this->input->post('channel',true));
		$preset = $this->Anti_si($this->input->post('preset',true));
		
 		
		if( ! empty($this->Anti_si($this->input->post('channel',true))) ) {
			$channel = $this->Anti_si($this->input->post('channel',true));
		} else {
			$channel = NULL;
		}	

		$datef = $start_date;
		$periode=$tahun;

		$pilihaudiencebar = $type;
		
		$first_day = $start_date;
		$this_day = $end_date;
		
		if($preset == "0"){
			
			$where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia','AL JAZEERA','BLOOMBERG','CHANNEL NEWS ASIA','CNBC','CNN INTERNATIONAL','DW TV','EURONEWS','FRANCE 24','SEA TODAY','TRT WORLD','TVBS NEWS','CNBC','TV ONE','CNN INDONESIA','METRO TV','KOMPAS TV','TVRI','BERITA SATU','TVRI','INEWS','IDX','MNC NEWS','CNBC Indonesia')";
		}else{
			
			$channel_set = $this->tvprogramun_model->channel_set($preset,$userid);
			
 			
			$channel_list = explode(',',$channel_set[0]['CHANNEL_LIST']);
			
			$str_channel = '';
			foreach($channel_list as $channel_lists){
				
				$str_channel = $str_channel."'".$channel_lists."',";
				
			}
			
			$str_channel = substr($str_channel, 0, -1);
 			
			$where = "AND CHANNEL IN (".$str_channel.")"; 
		}
		
		if($week == 'ALL'){
			
			$where = $where."";
			$where = $where." AND R.DAYS BETWEEN '".$first_day."' AND '".$this_day."'";
			
		}else{
			
			 $where = $where." AND WEEK(DAYS) = ".$week." AND TANGGAL = '".$periode."'";
			
		}
		
		if($tipe_filter == 'live'){
		
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_fix("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$first_day,$this_day); 
		
		}else{
			
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_tvod("channel_name",$where,$periode,$type,$profile,$check,$tipe_filter,$first_day,$this_day); 
			
		}
 		
		
		$array_channel = array();

		$dataM=$data['channels'];
		$scama = array();
		$scama2 = array();
		for ($i=0;$i<count($dataM);$i++){
			
			$array_channel[$dataM[$i]['channel']]['Rangking'] = $i+1;
			$array_channel[$dataM[$i]['channel']]['Spot'] = $dataM[$i]['Spot'];
			$array_channel[$dataM[$i]['channel']]['CHANNEL'] = $dataM[$i]['channel'];
			
			$scam['Rangking'] = $i+1;
			$scam['Spot'] = $dataM[$i]['Spot'];
			$scam['channel'] = $dataM[$i]['channel'];
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
			array_push($scama, $scam); 
		}	
		
		
		
		$data['first_day'] = $first_day;
		$data['this_day'] =  $this_day;
 		
 		
		if($week == 'ALL'){
			$day_dates = $this->getDatesFromRange($first_day,$this_day);
		}else{
			$day_datesSS = $this->tvprogramun_model->get_week_days($where);
			
			
			foreach($day_datesSS as $day_datesSSas){
				
				$day_dates[] = $day_datesSSas['DAYS'];
				
			}
 		}
		
 		
		$data['day_dates'] = $day_dates;
		
		$table_html = '<table id="example4" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th rowspan = "2" >Rank <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th rowspan = "2" >Channel <img class="cArrowDown" src="<?php echo $pathx;?>assets/images/icon_arrowdown.png"></th><th colspan = "'.count($day_dates).'">Audience </th></tr><tr>';
		foreach($day_dates as $day_datess){
			$table_html = $table_html.'<th >'.$day_datess.'</th>';
		}
		
		if($tipe_filter == 'live'){
			$data['all_data'] = $this->tvprogramun_model->list_spot_all_days("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$first_day,$this_day);
		}else{
			$data['all_data'] = $this->tvprogramun_model->list_spot_all_days_tvod("channel_name",$where,$periode,$pilihaudiencebar,"0","True",$first_day,$this_day,$tipe_filter);
		}
		
		
		
		foreach($data['all_data'] as $all_data){
			
			$array_channel[$all_data['CHANNEL']][$all_data['DAYS']] = $all_data['VIEWERS'];
 			
		}
		
 		
		foreach($array_channel as $array_channel_a){
		
		
			if(isset($array_channel_a['CHANNEL'])){
				$curr_channel = $array_channel_a['CHANNEL'];
				
				$scam2['Rangking'] = $array_channel_a['Rangking'];
				$scam2['Spot'] = $array_channel_a['Spot'];
				$scam2['channel'] = $array_channel_a['CHANNEL'];
			
				foreach($day_dates as $day_datesss){
				
				 
					$curr_date_a = $day_datesss;
					
				 
					
					if(isset($array_channel_a[$curr_date_a])){
						$scam2[$curr_date_a] = $array_channel_a[$curr_date_a];
 					}else{
						$scam2[$curr_date_a] = 0;
						$array_channel[$curr_channel][$curr_date_a] = 0;
 					}
					
 				
				}
			array_push($scama2, $scam2); 
 			}
			
			
		}
		
		//print_r($scama2);die;
		
 		
		
		foreach($scama2 as $adadada){
			
			$table_html = $table_html.'<tr><td>'.$adadada['Rangking'].'</td><td>'.$adadada['channel'].'</td>';
			
			foreach($day_dates as $day_datess){
				$table_html = $table_html.'<td>'.$adadada[$day_datess].'</td>';
			}
			
			$table_html = $table_html.'</tr>';

		}
		
		foreach($day_dates as $day_datess){
				$dated=date_create($day_datess);
				$day_dates2[] = date_format($dated,"d-m");
		}
		
		
		$table_html = $table_html.'</tr></thead></table>';
						
 						
		$data['table'] = $scama2;
		$data['date'] = $day_dates;
		
		
		
		$data['audiencebychannel'] = json_encode($scama2,true); 	
		
	
      
		  echo json_encode($data,true);
	}
 

}

