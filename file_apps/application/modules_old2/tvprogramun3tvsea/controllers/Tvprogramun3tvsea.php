<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramun3tvsea extends JA_Controller {
 
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
		$where = '';
		
 		
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
		
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		
	$where = ''; 
		
			  $periode = $this->Anti_si($this->input->post('periode',true));

			  $type = $this->Anti_si($this->input->post('type',true));

		  
			  $profile = "0";

		  
			  $tgl = $this->Anti_si($this->input->post('tgl',true));
	
		  
		 
			  $tipe_filter = 'live';

		
			  $week =$this->Anti_si($this->input->post('week',true));

			$check = "True";

		  
			  $preset = "0";

		$where = ''; 
		
 
	
		  
 		 
		if($preset == "0"){
			
			$where = $where."";
		}else{
			
			$channel_set = $this->tvprogramun_model->channel_set($preset,$userid);
			
			$channel_list = explode(',',$channel_set[0]['CHANNEL_LIST']);
			
			$str_channel = '';
			foreach($channel_list as $channel_lists){ 
				
				$str_channel = $str_channel."'".$channel_lists."',";
				
			}
			
			$str_channel = substr($str_channel, 0, -1);
 			
			$where = $where." AND CHANNEL IN (".$str_channel.")"; 
		}
 		   
		  $where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One', 'CNN Indonesia', 'Metro TV', 'Kompas TV', 'TVRI', 'Berita Satu', 'TVRI', 'iNews', 'IDX Channel', 'MNC News', 'CNBC Indonesia')";
		  
 
		   

		    $params['limit'] 		= 0;
			$params['offset'] 		= 10;
			$params['periode'] 	= $periode;
			$params['profile'] 	= $profile;
			$params['week'] 	= $week;
			$params['tgl'] 	= $tgl;
			$params['check'] 	= $check;
			$params['searchtxt'] 	= "";
			
 			
			$first_day = $tgl;
			$this_day = $week;
		
		if($type == 'AUDIENCE'){
			
			$ggg = 'Audience';
					$type_tvod = 'VIEWERS';
			
					$tbt = 'M_SUM_TV_DASH_PROG_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$w_week = 0;
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$drag = 'MAX';
				}ELSEif($type == 'TOTAL_VIEWS'){
					$type_tvod = 'TOTAL_VIEWS';
					$w_week = 1;
					$tbt = 'M_SUM_TV_DASH_PROG_VIEWERS_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV';
					
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$drag = 'SUM';
					$ggg = 'Total Views';
				}ELSE{
					$type_tvod = 'DURATION';
					
					$tbt = 'M_SUM_TV_DASH_PROG_DURATION_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV';
					$w_week = 1;
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$drag = 'SUM';
					$ggg = 'Duration';
				}
		$data['monthdt'] = $this->tvprogramun_model->get_curr_month($tgl);
		$mth = $this->tvprogramun_model->get_curr_month($tgl);
		$in_month = '';
 		if($params['week'] == 'All'){
			
			
			$query_qr2 = "SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM
			( 
				SELECT A.PROGRAM PROGRAM, A.CHANNEL CHANNEL, A.VIEWERS AS TOTAL ";
			$week_in2 = "";
			$join_left2 = "";
			$ri2 = 1;
			$th_tb2 = "";
			
				
		
			IF($tipe_filter == 'live'){
				
			
				
				foreach($data['monthdt'] as $wkwkwk){
					
					$in_month = $in_month.",'".$wkwkwk['PERIODE_FULL']."'";
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS M".$ri2." ";
					
					$join_left2 = $join_left2." LEFT JOIN (
								SELECT * FROM ".$tbt."
								WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
								AND ID_PROFILE = 0
								".$where."
							) A".$ri2." ON A.CHANNEL = A".$ri2.".CHANNEL AND A.PROGRAM = A".$ri2.".PROGRAM ";
					
					$ri2++;
					
				}
			
				if($type == 'AUDIENCE'){
						
						$query_qr2 = $query_qr2."".$week_in2." FROM (
							SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM ".$tbt."
							WHERE `TANGGAL` = '".$tgl."'
							AND ID_PROFILE = 0
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ''
							".$where."
							GROUP BY `PROGRAM`,CHANNEL
						) A ".$join_left2." 
						ORDER BY TOTAL DESC) z ";
				}ELSE{
					$query_qr2 = $query_qr2."".$week_in2." FROM (
							SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM ".$tbt."
							WHERE `TANGGAL` IN (".substr($in_month,1).")
							AND ID_PROFILE = 0
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ''
							".$where."
							GROUP BY `PROGRAM`,CHANNEL
						) A ".$join_left2." 
						ORDER BY TOTAL DESC) z ";
				}
				
			}elseif($tipe_filter == 'TVOD'){
				
				foreach($data['monthdt'] as $wkwkwk){
					
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS M".$ri2." ";
					
					$join_left2 = $join_left2.' LEFT JOIN (
								SELECT CHANNEL,PROGRAM,MAX(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
								WHERE `TANGGAL` = "'.$wkwkwk['PERIODE_FULL'].'"
								AND TIPE_FILTER = "'.$tipe_filter.'"
								AND TIPE_VIEW = "'.$type_tvod.'"
								AND ID_PROFILE = 0
								'.$where.'
								GROUP BY CHANNEL,PROGRAM
							) A'.$ri2.' ON A.CHANNEL = A'.$ri2.'.CHANNEL AND A.PROGRAM = A'.$ri2.'.PROGRAM ';
					
					$ri2++;
					
				}
			
				if($type == 'AUDIENCE'){
			
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							SELECT CHANNEL,PROGRAM, MAX(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.date('Y').'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER = "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}ELSE{
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
						SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM (
							SELECT CHANNEL,PROGRAM,MAX(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER =  "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
							
							) F  GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}
				
			}else{
				
				foreach($data['monthdt'] as $wkwkwk){
					
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS M".$ri2." ";
					
					$join_left2 = $join_left2.' LEFT JOIN (
								SELECT CHANNEL,PROGRAM,MAX(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
								WHERE `TANGGAL` = "'.$wkwkwk['PERIODE_FULL'].'"
								AND TIPE_FILTER = "'.$tipe_filter.'"
								AND TIPE_VIEW = "'.$type_tvod.'"
								AND ID_PROFILE = 0
								'.$where.'
								GROUP BY CHANNEL,PROGRAM
							) A'.$ri2.' ON A.CHANNEL = A'.$ri2.'.CHANNEL AND A.PROGRAM = A'.$ri2.'.PROGRAM ';
					
					$ri2++;
					
				}
			
				if($type == 'AUDIENCE'){
			
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							SELECT CHANNEL,PROGRAM, MAX(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER = "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}ELSE{
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
						SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM (
							SELECT CHANNEL,PROGRAM,MAX(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER =  "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
							
							) F  GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}
				
			}		
				 
			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new_export("Program",$where,$params,$type,$profile,$query_qr2);
		
			$datax = $data['monthdt'];
			$data = array();	
			  $idx = 0; 

 			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			  
		   foreach ( $list['data'] as $k => $v ) {
					
					$array_ss = array();
					
					$array_ss['rank'] =  $v['Rangking'];
					$array_ss['program'] = $v['PROGRAM'];
					$array_ss['channel']	=  $v['CHANNEL'];
			
					$trtr = 1;
					foreach($datax as $wkwkwkfd){
						
						$array_ss['M'.$trtr] =  $v['M'.$trtr];
						$trtr++;
					}
					
					$array_ss['total']	=  $v['TOTAL'];
					array_push($data,$array_ss);
					
					 
					$idx++;
			  
		   }
		   
		   		$bulan['1'] = 'Jan';
				$bulan['2'] = 'Feb';
				$bulan['3'] = 'Mar';
				$bulan['4'] = 'Apr';
				$bulan['5'] = 'May';
				$bulan['6'] = 'Jun';
				$bulan['7'] = 'Jul';
				$bulan['8'] = 'Aug';
				$bulan['9'] = 'Sep';
				$bulan['10'] = 'Oct';
				$bulan['11'] = 'Nov';
				$bulan['12'] = 'Dec';
			
				$array_cell = ['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
				
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
						->setCellValue('C1', 'Channel');
		   
		   $it1 = 2;
			$rr=1;
			
			foreach($mth as $wkwk){
				
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$it1].'1', $bulan[$rr]);
			$it1++;
			$rr++;
			}
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$it1].'1', 'Total');
						
			$vtl = 2;
			foreach($data as $datass){
				
				 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$vtl, $datass['rank'])
						->setCellValue('B'.$vtl, $datass['program'])
						->setCellValue('C'.$vtl, $datass['channel']);
						
					$it1 = 2;
					$rr=1;
					
					foreach($mth as $wkwk){
						
						if($datass['M'.$rr] == ''){
							$nnh = 0;
						}else{
							$nnh = $datass['M'.$rr];
						}
						
						$objPHPExcel->setActiveSheetIndex(0)
 								->setCellValue($array_cell[$it1].$vtl, $nnh);
						$it1++;
						$rr++;
					}
					
					 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$it1].$vtl, $datass['total']);
				
				$vtl++;
			}
			
			
			$objPHPExcel->getActiveSheet()->setTitle('Audience by Program Summary');
 			$objPHPExcel->setActiveSheetIndex(0);

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
			$objWriter->save('/var/www/html/tmp_doc/Audience_by_program.xls');	
 
		
		}else{
			
			$data['monthdt'] = $this->tvprogramun_model->get_sel_week_month($first_day,$this_day);
			
			$mhtj = $data['monthdt'];
			
 			
			$bulan['01'] = 'January';
			$bulan['02'] = 'February';
			$bulan['03'] = 'March';
			$bulan['04'] = 'April';
			$bulan['05'] = 'May';
			$bulan['06'] = 'June';
			$bulan['07'] = 'July';
			$bulan['08'] = 'August';
			$bulan['09'] = 'September';
			$bulan['10'] = 'October';
			$bulan['11'] = 'November';
			$bulan['12'] = 'December';
			
			$query_qr = "SELECT z.*, rnk AS Rangking FROM 
			( SELECT CHN.CHANNEL CHANNEL,CHN.PROGRAM PROGRAM,CHN.Rangking as rnk,  ";
			$week_in = "";
			$join_left = "";
			$ri = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			
			
			IF($tipe_filter == 'live'){
			
			
			foreach($data['monthdt'] as $wkwk){
				$in_month = $in_month.',"'.$wkwk['PER'].'"';
				$wkwk['WEEK'] = $wkwk['WEEK'] - 1;
 				$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.", A".$ri.".`CHANNEL` AS CHANNEL".$ri.", A".$ri.".`PROGRAM` AS PROGRAM".$ri.",";
				$week_in = $week_in."'".(($wkwk['WEEK']-$w_week))."',";
				
				IF($ri == 1){
				
				$join_left = $join_left." 
				LEFT JOIN (	
				SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
												( 
							
							SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `".$tbt_2."`
							WHERE `WEEK` = '".($wkwk['WEEK'])."'
							AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
							AND ID_PROFILE = 0
							".$where."
							GROUP BY CHANNEL,PROGRAM
							ORDER BY VIEWERS desc
						) z ORDER BY Rangking
						) A".$ri." ON CHN.Rangking = A".$ri.".Rangking 
				";
				
				}else{
					
					$join_left = $join_left." 
				LEFT JOIN (	
				SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
												( 
							SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `".$tbt_2."`
							WHERE `WEEK` = '".($wkwk['WEEK'])."'
							AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
							AND ID_PROFILE = 0
							".$where."
							GROUP BY CHANNEL,PROGRAM
							ORDER BY VIEWERS desc
						) z ORDER BY Rangking
						) A".$ri." ON CHN.Rangking = A".$ri.".Rangking
				";
					
				}
				
				$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
				$ri++;
				
				
			}
			
			
 			
			$th_tbs = $th_tbs."</tr>";
			
			$week_in = substr($week_in, 0, -1);
			
			$ri_now = $ri - 1;
			$ri_last = $ri - 2;
			$query_qr = $query_qr."
					A1.VIEWERS AS TOTAL 
					FROM (
					SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM (
						SELECT CHANNEL,PROGRAM, MAX(VIEWERS) AS VIEWERS FROM `".$tbt_2."`
						WHERE `WEEK` IN (".$week_in.")
						AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
						AND ID_PROFILE = 0
						".$where."
						GROUP BY CHANNEL,PROGRAM
						) z ORDER BY Rangking
					) CHN  ".$join_left." 
					)z   order by rnk ";
		 
			}elseif($tipe_filter == 'TVOD'){

					foreach($data['monthdt'] as $wkwk){
						
						$wkwk['WEEK'] = $wkwk['WEEK_MONTH'] - 1;
 						$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",A".$ri.".`CHANNEL` AS CHANNEL".$ri.", A".$ri.".`PROGRAM` AS PROGRAM".$ri.",";
						$week_in = $week_in.''.$wkwk['WEEK'].',';
						
						IF($ri == 1){

						$join_left = $join_left." 
						LEFT JOIN (	
						SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
									WHERE `WEEK` = ".$wkwk['WEEK']."
									AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
									AND TIPE_FILTER = '".$tipe_filter."'
									AND TIPE_VIEW = '".$type_tvod."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,PROGRAM
								) z ORDER BY Rangking
								) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL AND CHN.PROGRAM = A".$ri.".PROGRAM
						";
						
						}ELSE{
							
							$join_left = $join_left." 
						LEFT JOIN (	
							SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
									WHERE `WEEK` = ".$wkwk['WEEK']."
									AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
									AND TIPE_FILTER = '".$tipe_filter."'
									AND TIPE_VIEW = '".$type_tvod."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,PROGRAM
								) z ORDER BY Rangking
								)  A".$ri." ON A1.Rangking = A".$ri.".Rangking
						";
							
						}
						
						$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
						$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
						$ri++;
					}
				

				
 				
				$th_tbs = $th_tbs."</tr>";
				
				$week_in = substr($week_in, 0, -1);
				
				$ri_now = $ri - 1;
				$ri_last = $ri - 2;
				
				IF($type_tvod == 'VIEWERS'){
				
					$query_qr = $query_qr."
						A1.VIEWERS AS TOTAL 
						FROM (
							SELECT CHANNEL,PROGRAM FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
							WHERE `WEEK` IN (".$week_in.")
							AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
							AND ID_PROFILE = 0
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$type_tvod."'
							".$where."
							GROUP BY CHANNEL,PROGRAM
						) CHN  ".$join_left."
						)z  ";
						
				}else{ 
				
					$query_qr = $query_qr."
						A1.VIEWERS AS TOTAL 
						FROM (
							SELECT CHANNEL,PROGRAM FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
							WHERE `WEEK` IN (".$week_in.")
							AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
							AND ID_PROFILE = 0
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$type_tvod."'
							".$where."
							GROUP BY CHANNEL,PROGRAM
						) CHN  ".$join_left." 
						)z  ";
						
				}
 				
			}ELSE{
				
				foreach($data['monthdt'] as $wkwk){
					
					$wkwk['WEEK'] = $wkwk['WEEK_MONTH'] - 1;
 					$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",A".$ri.".`CHANNEL` AS CHANNEL".$ri.", A".$ri.".`PROGRAM` AS PROGRAM".$ri.",";
					$week_in = $week_in.''.$wkwk['WEEK'].',';
					
					IF($ri == 1){
					$join_left = $join_left." 
					LEFT JOIN (	
					SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
								SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
								WHERE `WEEK` = ".$wkwk['WEEK']."
								AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
								AND TIPE_FILTER = '".$tipe_filter."'
								AND TIPE_VIEW = '".$type_tvod."'
								".$where."
								AND ID_PROFILE = 0
								GROUP BY CHANNEL,PROGRAM
							) z ORDER BY Rangking
							) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL AND CHN.PROGRAM = A".$ri.".PROGRAM
					";
					
					}ELSE{
							
							$join_left = $join_left." 
						LEFT JOIN (	
							SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
									WHERE `WEEK` = ".$wkwk['WEEK']."
									AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
									AND TIPE_FILTER = '".$tipe_filter."'
									AND TIPE_VIEW = '".$type_tvod."'
									".$where."
									AND ID_PROFILE = 0
									GROUP BY CHANNEL,PROGRAM
								) z ORDER BY Rangking
								)  A".$ri." ON A1.Rangking = A".$ri.".Rangking
						";
							
						}
					
					$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
					$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
					$ri++;
				}
				
				
 				
				$th_tbs = $th_tbs."</tr>";
				
				$week_in = substr($week_in, 0, -1);
				
				$ri_now = $ri - 1;
				$ri_last = $ri - 2;
				$query_qr = $query_qr."
						A1.VIEWERS AS TOTAL 
						FROM (
							SELECT CHANNEL,PROGRAM FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
							WHERE `WEEK` IN (".$week_in.")
							AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
							AND ID_PROFILE = 0
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$type_tvod."'
							".$where."
							GROUP BY CHANNEL,PROGRAM
						) CHN  ".$join_left." 
						)z  ";
				
			}
			
 			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_newprog_exp("Program",$where,$params,$type,$profile,$query_qr,$data['monthdt'][0]['YEAR']); 
		
 		
			$data = array();	
			  $idx = 0; 

			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			
			$scama = array();
		   foreach ( $list['data'] as $k => $v ) {
				$ih = 0;
				$scam['Rank'] = $v['Rangking'];
				$ih++;
				for($q=1;$q<=$ri_now;$q++){
					$scam['program'.$q] =  $v['PROGRAM'.$q];
					$ih++;
					$scam['channel'.$q] =  $v['CHANNEL'.$q];
					$ih++;
					$scam['m'.$q] =  $v['WE'.$q];
					$ih++;
				}
			 
				array_push($data, $scam); 
				$idx++;
			  
		   }
		   
 		   
		
			
				$array_cell = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
				
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
						->setCellValue('A1', 'Rangking');
		   $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
		    $gos = 1;
			$gosw = 1;
			
 			
			foreach($mhtj as $ssss){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos]."1", "Week ".$gosw." (".$ssss['PER'].")"); 
						$goss = $gos+1;
						$goss2 = $goss+1;
						$objPHPExcel->getActiveSheet()->mergeCells($array_cell[$gos].'1:'.$array_cell[$goss2].'1');
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$gos].'2', 'Program')
						->setCellValue($array_cell[$goss].'2', 'Channel')
						->setCellValue($array_cell[$goss2].'2', $ggg);
						$gos++;	
						$gos++;	
						$gos++;	
						$gosw++;
			}
 
			$vtl = 3;
			
 			
			foreach($data as $datass){
				
				 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$vtl, $datass['Rank']); 
						
				$gos = 1;
			$gosw = 1;
					foreach($mhtj as $ssss){
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos].$vtl, $datass['program'.$gosw]);
							$goss = $gos+1;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$goss].$vtl, $datass['channel'.$gosw]);
							$gossx = $goss+1;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gossx].$vtl, $datass['m'.$gosw]);
 							$gos++;	
							$gos++;	
							$gos++;	
							$gosw++;
					}
					
					 
				
				$vtl++;
			}
			
			
			$objPHPExcel->getActiveSheet()->setTitle('Audience by Program Summary');
 			$objPHPExcel->setActiveSheetIndex(0);

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
			$objWriter->save('/var/www/html/tmp_doc/Audience_by_program.xls');	
		   
		   
		
		}
		
 		
		 $result["data"] = $data;
		 
	}
	
	public function get_filter_programaud(){
		
		$where = ''; 
		
		 if( !empty($this->Anti_si($_GET['periode'])) ) {
			  $periode = $this->Anti_si($_GET['periode']);
		  } else {
			  $periode = NULL;
		  }
		  
		   if( !empty($this->Anti_si($_GET['pilihprog'])) ) {
			  $type = $this->Anti_si($_GET['pilihprog']);
		  } else {
			  $type = 'AUDIENCE';
		  }
		  
			  $profile = '0';

		  
		   if( !empty($this->Anti_si($_GET['tgl2'])) ) {
			  $tgl = $this->Anti_si($_GET['tgl2']);
		  } else {
			  $tgl = '0';
		  }
		  
			  $tipe_filter = 'live';
		  
		  
		   if( !empty($this->Anti_si($_GET['week2'])) ) {
			  $week = $this->Anti_si($_GET['week2']);
		  } else {
			  $week = '0';
		  }
		  
		   $check = $this->Anti_si($_GET['check']);
		    
		   if( !empty($this->Anti_si($_GET['search']['value'])) ) {
			  $searchtxt = $this->Anti_si($_GET['search']['value']);
			  $where =  $where." AND (CHANNEL LIKE '%".$searchtxt."%' OR PROGRAM LIKE '%".$searchtxt."%') ";
		  } else {
			  $where =  $where."";
		  }
		  
			  $preset = "0";

		  
		  $userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		  
 		 
		if($preset == "0"){
			
			$where .= " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One', 'CNN Indonesia', 'Metro TV', 'Kompas TV', 'TVRI', 'Berita Satu', 'TVRI', 'iNews', 'IDX Channel', 'MNC News', 'CNBC Indonesia')";
		}else{
			
			$channel_set = $this->tvprogramun_model->channel_set($preset,$userid);
			
			$channel_list = explode(',',$channel_set[0]['CHANNEL_LIST']);
			
			$str_channel = '';
			foreach($channel_list as $channel_lists){ 
				
				$str_channel = $str_channel."'".$channel_lists."',";
				
			}
		
			$str_channel = substr($str_channel, 0, -1);
 			
			$where .= " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One', 'CNN Indonesia', 'Metro TV', 'Kompas TV', 'TVRI', 'Berita Satu', 'TVRI', 'iNews', 'IDX Channel', 'MNC News', 'CNBC Indonesia') ";
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
			$params['week'] 	= $week;
			$params['tgl'] 	= $tgl;
			$params['check'] 	= $check;
			$params['searchtxt'] 	= $_GET['search']['value'];
			
			$first_day = $tgl;
			$this_day = $week;
		
		if($type == 'AUDIENCE'){
			
			$ggg = 'Audience';
					$type_tvod = 'VIEWERS';
			
					$tbt = 'M_SUM_TV_DASH_PROG_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$w_week = 0;
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$drag = 'MAX';
					
				}ELSEif($type == 'TOTAL_VIEWS'){
					$type_tvod = 'TOTAL_VIEWS';
					
					$tbt = 'M_SUM_TV_DASH_PROG_VIEWERS_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV';
					$w_week = 1;
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$drag = 'SUM';
					
					$ggg = 'Total Views';
				}ELSE{
					$type_tvod = 'DURATION';
					
					$tbt = 'M_SUM_TV_DASH_PROG_DURATION_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV';
					$w_week = 1;
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					$drag = 'SUM';
					
					$ggg = 'Duration';
				}
		
 			$in_month = '';
		if($params['week'] == 'All'){
			$data['monthdt'] = $this->tvprogramun_model->get_curr_month($tgl);
			
 			
			$query_qr2 = "SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM
			( 
				SELECT A.PROGRAM PROGRAM, A.CHANNEL CHANNEL, A.VIEWERS AS TOTAL ";
			$week_in2 = "";
			$join_left2 = "";
			$ri2 = 1;
			$th_tb2 = "";
			
				
		
			IF($tipe_filter == 'live'){
				
			
				
				foreach($data['monthdt'] as $wkwkwk){
					
					$in_month = $in_month.",'".$wkwkwk['PERIODE_FULL']."'";
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS M".$ri2." ";
					
					$join_left2 = $join_left2." LEFT JOIN (
								SELECT * FROM ".$tbt."
								WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
								AND ID_PROFILE = 0
								".$where."
							) A".$ri2." ON A.CHANNEL = A".$ri2.".CHANNEL AND A.PROGRAM = A".$ri2.".PROGRAM ";
					
					$ri2++;
					
				}
			
				if($type == 'AUDIENCE'){
						
						$query_qr2 = $query_qr2."".$week_in2." FROM (
							SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM ".$tbt."
							WHERE `TANGGAL` = '".$tgl."'
							AND ID_PROFILE = 0
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ''
							".$where."
							GROUP BY `PROGRAM`,CHANNEL
						) A ".$join_left2." 
						ORDER BY TOTAL DESC) z ";
				}ELSE{
					$query_qr2 = $query_qr2."".$week_in2." FROM (
							SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM ".$tbt."
							WHERE `TANGGAL` IN (".substr($in_month,1).")
							AND ID_PROFILE = 0
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ''
							".$where."
							GROUP BY `PROGRAM`,CHANNEL
						) A ".$join_left2." 
						ORDER BY TOTAL DESC) z ";
				}
				
			}elseif($tipe_filter == 'TVOD'){
				
				foreach($data['monthdt'] as $wkwkwk){
					
					$in_month = $in_month.',"'.$wkwkwk['PERIODE_FULL'].'"';
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS M".$ri2." ";
					
					$join_left2 = $join_left2.' LEFT JOIN (
								SELECT CHANNEL,PROGRAM,'.$drag.'(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
								WHERE `TANGGAL` = "'.$wkwkwk['PERIODE_FULL'].'"
								AND TIPE_FILTER = "'.$tipe_filter.'"
								AND TIPE_VIEW = "'.$type_tvod.'"
								AND ID_PROFILE = 0
								'.$where.'
								GROUP BY CHANNEL,PROGRAM
							) A'.$ri2.' ON A.CHANNEL = A'.$ri2.'.CHANNEL AND A.PROGRAM = A'.$ri2.'.PROGRAM ';
					
					$ri2++;
					
				}
			
				if($type == 'AUDIENCE'){
			
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							SELECT CHANNEL,PROGRAM, '.$drag.'(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER = "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}ELSE{
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
						SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM (
							SELECT CHANNEL,PROGRAM,'.$drag.'(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER =  "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
							
							) F  GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}
				
			}else{
				
				foreach($data['monthdt'] as $wkwkwk){
					
					$in_month = $in_month.',"'.$wkwkwk['PERIODE_FULL'].'"';
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS M".$ri2." ";
					
					$join_left2 = $join_left2.' LEFT JOIN (
								SELECT CHANNEL,PROGRAM,'.$drag.'(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
								WHERE `TANGGAL` = "'.$wkwkwk['PERIODE_FULL'].'"
								AND TIPE_FILTER = "'.$tipe_filter.'"
								AND TIPE_VIEW = "'.$type_tvod.'"
								AND ID_PROFILE = 0
								'.$where.'
								GROUP BY CHANNEL,PROGRAM
							) A'.$ri2.' ON A.CHANNEL = A'.$ri2.'.CHANNEL AND A.PROGRAM = A'.$ri2.'.PROGRAM ';
					
					$ri2++;
					
				}
			
				if($type == 'AUDIENCE'){
			
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							SELECT CHANNEL,PROGRAM, '.$drag.'(VIEWERS) VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER = "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}ELSE{
					$query_qr2 = $query_qr2.''.$week_in2.' FROM (
						SELECT CHANNEL,PROGRAM,SUM(VIEWERS) AS VIEWERS FROM (
							SELECT CHANNEL,PROGRAM,'.$drag.'(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_PROG_TVOD_WEEKS
							WHERE SUBSTR(`TANGGAL`,1,4) = "'.$tgl.'"
							AND ID_PROFILE = 0
							AND TIPE_FILTER =  "'.$tipe_filter.'"
							AND TIPE_VIEW = "'.$type_tvod.'"
							AND CHANNEL IS NOT NULL
							AND PROGRAM <> ""
							'.$where.'
							GROUP BY `PROGRAM`,CHANNEL
							
							) F  GROUP BY `PROGRAM`,CHANNEL
						) A '.$join_left2.' ) z ';
				}
				
			}		
				 
			
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_new("Program",$where,$params,$type,$profile,$query_qr2);
		
			$datax = $data['monthdt'];
			$data = array();	
			  $idx = 0; 

			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			  
		   foreach ( $list['data'] as $k => $v ) {
					
					$array_ss = array();
					
					$array_ss[] =  number_format($v['Rangking'],0,',','.');
					$array_ss[] = $v['PROGRAM'];
					$array_ss[]	=  $v['CHANNEL'];
			
					$trtr = 1;
					foreach($datax as $wkwkwkfd){
						
						$array_ss[] =  number_format($v['M'.$trtr],0,',','.');
						$trtr++;
					}
					
					$array_ss[]	=  number_format($v['TOTAL'],0,',','.');
					array_push($data,$array_ss);
					 
					$idx++;
			  
		   }
		
		}else{
			
			$data['monthdt'] = $this->tvprogramun_model->get_sel_week_month($first_day,$this_day);
			
 			
			$bulan['01'] = 'January';
			$bulan['02'] = 'February';
			$bulan['03'] = 'March';
			$bulan['04'] = 'April';
			$bulan['05'] = 'May';
			$bulan['06'] = 'June';
			$bulan['07'] = 'July';
			$bulan['08'] = 'August';
			$bulan['09'] = 'September';
			$bulan['10'] = 'October';
			$bulan['11'] = 'November';
			$bulan['12'] = 'December';
			
			$query_qr = "SELECT z.*, rnk AS Rangking FROM 
			( SELECT CHN.CHANNEL CHANNEL,CHN.PROGRAM PROGRAM,CHN.Rangking as rnk,  ";
			$week_in = "";
			$join_left = "";
			$ri = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			
			
			IF($tipe_filter == 'live'){
			
			
			foreach($data['monthdt'] as $wkwk){
				$in_month = $in_month.',"'.$wkwk['PER'].'"';
				$wkwk['WEEK'] = $wkwk['WEEK'] - 1;
 				$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.", A".$ri.".`CHANNEL` AS CHANNEL".$ri.", A".$ri.".`PROGRAM` AS PROGRAM".$ri.",";
				$week_in = $week_in."'".(($wkwk['WEEK']-$w_week))."',";
				
				IF($ri == 1){
				
				$join_left = $join_left." 
				LEFT JOIN (	
				SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
												( 
							
							SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `".$tbt_2."`
							WHERE `WEEK` = '".($wkwk['WEEK'])."'
							AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
							AND ID_PROFILE = 0
							".$where."
							GROUP BY CHANNEL,PROGRAM
							ORDER BY VIEWERS desc
						) z ORDER BY Rangking
						) A".$ri." ON CHN.Rangking = A".$ri.".Rangking 
				";
				
				}else{
					
					$join_left = $join_left." 
				LEFT JOIN (	
				SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
												( 
							SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `".$tbt_2."`
							WHERE `WEEK` = '".($wkwk['WEEK'])."'
							AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
							AND ID_PROFILE = 0
							".$where."
							GROUP BY CHANNEL,PROGRAM
							ORDER BY VIEWERS desc
						) z ORDER BY Rangking
						) A".$ri." ON CHN.Rangking = A".$ri.".Rangking
				";
					
				}
				
				$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
				$ri++;
				
				
			}
 
			
			$th_tbs = $th_tbs."</tr>";
			
			$week_in = substr($week_in, 0, -1);
			
			$ri_now = $ri - 1;
			$ri_last = $ri - 2;
			$query_qr = $query_qr."
					A1.VIEWERS AS TOTAL 
					FROM (
					SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM (
						SELECT CHANNEL,PROGRAM, MAX(VIEWERS) AS VIEWERS FROM `".$tbt_2."`
						WHERE `WEEK` IN (".$week_in.")
						AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
						AND ID_PROFILE = 0
						".$where."
						GROUP BY CHANNEL,PROGRAM
						) z ORDER BY Rangking
					) CHN  ".$join_left." 
					)z   order by rnk ";
		 
			
			}elseif($tipe_filter == 'TVOD'){

					foreach($data['monthdt'] as $wkwk){
						
						$wkwk['WEEK'] = $wkwk['WEEK'] - 1;
 						$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",A".$ri.".`CHANNEL` AS CHANNEL".$ri.", A".$ri.".`PROGRAM` AS PROGRAM".$ri.",";
						$week_in = $week_in.''.(($wkwk['WEEK']-$w_week)).',';
						
						IF($ri == 1){

						$join_left = $join_left." 
						LEFT JOIN (	
						SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
									WHERE `WEEK` = ".$wkwk['WEEK']."
									AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
									AND TIPE_FILTER = '".$tipe_filter."'
									AND TIPE_VIEW = '".$type_tvod."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,PROGRAM
								) z ORDER BY Rangking
								) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL AND CHN.PROGRAM = A".$ri.".PROGRAM
						";
						
						}ELSE{
							
							$join_left = $join_left." 
						LEFT JOIN (	
							SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
									WHERE `WEEK` = ".$wkwk['WEEK']."
									AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
									AND TIPE_FILTER = '".$tipe_filter."'
									AND TIPE_VIEW = '".$type_tvod."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,PROGRAM
								) z ORDER BY Rangking
								)  A".$ri." ON A1.Rangking = A".$ri.".Rangking
						";
							
						}
						
						$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
						$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
						$ri++;
					}
				

				
 				
				$th_tbs = $th_tbs."</tr>";
				
				$week_in = substr($week_in, 0, -1);
				
				$ri_now = $ri - 1;
				$ri_last = $ri - 2;
				
				IF($type_tvod == 'VIEWERS'){
				
					$query_qr = $query_qr."
						A1.VIEWERS AS TOTAL 
						FROM (
							SELECT CHANNEL,PROGRAM FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
							WHERE `WEEK` IN (".$week_in.")
							AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
							AND ID_PROFILE = 0
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$type_tvod."'
							".$where."
							GROUP BY CHANNEL,PROGRAM
						) CHN  ".$join_left."
						)z  ";
						
				}else{ 
				
					$query_qr = $query_qr."
						A1.VIEWERS AS TOTAL 
						FROM (
							SELECT CHANNEL,PROGRAM FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
							WHERE `WEEK` IN (".$week_in.")
							AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
							AND ID_PROFILE = 0
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$type_tvod."'
							".$where."
							GROUP BY CHANNEL,PROGRAM
						) CHN  ".$join_left." 
						)z  ";
						
				}
 				
			}ELSE{
				
				foreach($data['monthdt'] as $wkwk){
					
					$wkwk['WEEK'] = $wkwk['WEEK'] - 1;
 					$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",A".$ri.".`CHANNEL` AS CHANNEL".$ri.", A".$ri.".`PROGRAM` AS PROGRAM".$ri.",";
					$week_in = $week_in.''.(($wkwk['WEEK']-$w_week)).',';
					
					IF($ri == 1){
					$join_left = $join_left." 
					LEFT JOIN (	
					SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
								SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
								WHERE `WEEK` = ".$wkwk['WEEK']."
								AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
								AND TIPE_FILTER = '".$tipe_filter."'
								AND TIPE_VIEW = '".$type_tvod."'
								".$where."
								AND ID_PROFILE = 0
								GROUP BY CHANNEL,PROGRAM
							) z ORDER BY Rangking
							) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL AND CHN.PROGRAM = A".$ri.".PROGRAM
					";
					
					}ELSE{
							
							$join_left = $join_left." 
						LEFT JOIN (	
							SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT CHANNEL,PROGRAM,".$drag."(VIEWERS) AS VIEWERS FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
									WHERE `WEEK` = ".$wkwk['WEEK']."
									AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'
									AND TIPE_FILTER = '".$tipe_filter."'
									AND TIPE_VIEW = '".$type_tvod."'
									".$where."
									AND ID_PROFILE = 0
									GROUP BY CHANNEL,PROGRAM
								) z ORDER BY Rangking
								)  A".$ri." ON A1.Rangking = A".$ri.".Rangking
						";
							
						}
					
					$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
					$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
					$ri++;
				}
				
				
 				
				$th_tbs = $th_tbs."</tr>";
				
				$week_in = substr($week_in, 0, -1);
				
				$ri_now = $ri - 1;
				$ri_last = $ri - 2;
				$query_qr = $query_qr."
						A1.VIEWERS AS TOTAL 
						FROM (
							SELECT CHANNEL,PROGRAM FROM `M_SUM_TV_DASH_PROG_TVOD_WEEKS`
							WHERE `WEEK` IN (".$week_in.")
							AND SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."'
							AND ID_PROFILE = 0
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$type_tvod."'
							".$where."
							GROUP BY CHANNEL,PROGRAM
						) CHN  ".$join_left." 
						)z  ";
				
			}
			
 			//ECHO $query_qr;DIE;
			$list = $this->tvprogramun_model->list_spot_by_program_all2Ps_newprog("Program",$where,$params,$type,$profile,$query_qr,$data['monthdt'][0]['YEAR']); 
		
			$data = array();	
			  $idx = 0; 

			  
			  $totpopulasi = $this->tvprogramun_model->list_populasi2($periode);
			
			$scama = array();
		   foreach ( $list['data'] as $k => $v ) {
				$ih = 0;
				$scam[$ih] = number_format($v['Rangking'],0,',','.');
				$ih++;
				for($q=1;$q<=$ri_now;$q++){
					$scam[$ih] =  $v['PROGRAM'.$q];
					$ih++;
					$scam[$ih] =  $v['CHANNEL'.$q];
					$ih++;
					$scam[$ih] =  number_format($v['WE'.$q],0,',','.');
					$ih++;
				}
				$scam[$ih] = number_format($v['TOTAL'],0,',','.');
				
				array_push($data, $scam); 
				$idx++;
			  
		   }
		
		}
		 

			 $result["data"] = $data;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
 	  
			$this->json_result($result);
			
	}
	
	function get_header_tbl(){
		
			
		$week =  $this->Anti_si($this->input->post('week',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$field =  $this->Anti_si($this->input->post('field',true));
		$where =  $this->Anti_si($this->input->post('cond',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		
		
		if($type == 'AUDIENCE'){
			
			$ggg = 'Audience';
					$type_tvod = 'VIEWERS';
			
					$tbt = 'M_SUM_TV_DASH_PROG_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
				}ELSEif($type == 'TOTAL_VIEWS'){
					$type_tvod = 'TOTAL_VIEWS';
					
					$tbt = 'M_SUM_TV_DASH_PROG_VIEWERS_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_VIEWERS_WEEK_PTV';
					
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					
					$ggg = 'Total Views';
				}ELSE{
					$type_tvod = 'DURATION';
					
					$tbt = 'M_SUM_TV_DASH_PROG_DURATION_PTV';
					$tbt_2 = 'M_SUM_TV_DASH_PROG_DURATION_WEEK_PTV';
					
					$tbttvid = 'M_SUM_TV_DASH_PROG_PTV';
					$tbttvid_2 = 'M_SUM_TV_DASH_PROG_WEEK_PTV';
					
					$ggg = 'Duration';
				}
		
		
		if($week == 'All'){
			$data['monthdt'] = $this->tvprogramun_model->get_curr_month($tgl);
			$th_tb = "";
			foreach($data['monthdt'] as $wkwkwk){
				$th_tb = $th_tb."<th > ".$wkwkwk['PERIODE']."</th>";
				
			}
			
			$pathx = base_url() . 'assets/urate-frontend-master/';
			
			$table_html = '
			<table id="example3" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "0" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >Program <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >Channel <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
										<th rowspan = "0" >Total<img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									</tr>
								</thead>
							</table>
			';
			
							
			$data['table'] = $table_html;
 			
		}else{
			
			$data['monthdt'] = $this->tvprogramun_model->get_sel_week_month($tgl,$week);
			
			$ri = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			foreach($data['monthdt'] as $wkwk){
				
				$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Program</td><td>Channel</td><td>".$ggg."</td>";
				$ri++;
				
			}
			
			$pathx = base_url() . 'assets/urate-frontend-master/';
			
			$table_html = '
			<table id="example3" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "2" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
									</tr>
										'.$th_tbs.'
								</thead>
							</table>
			';
			
			
 							
			$data['table'] = $table_html;
			
		}
		
		echo json_encode($data,true);
		
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
		
		
		
		$data['weekdt'] = $this->tvprogramun_model->get_curr_week(date("Y-m-d"));
		$data['monthdt'] = $this->tvprogramun_model->get_curr_month(date("Y"));
		 

		$query_qr = "SELECT CHN.CHANNEL CHANNEL,";
		$week_in = "";
		$join_left = "";
		$ri = 1;
		$th_tb = "";
		foreach($data['weekdt'] as $wkwk){
 			$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",";
			$week_in = $week_in."'".$wkwk['WEEK']."',";
			 
			$join_left = $join_left." 
			LEFT JOIN (	
						SELECT `CHANNEL`,MAX(`VIEWERS`) AS VIEWERS FROM `M_SUM_TV_DASH_CHAN_PTV_WEEK` 
						WHERE ID_PROFILE = 0 AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = '".$wkwk['WEEK']."'
						AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')
							GROUP BY CHANNEL
					
					) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
			";
			
			$th_tb = $th_tb."<th >Week ".$ri." <br>".$wkwk['PER']."</th>";
			
			$ri++;
		}
		
		$week_in = substr($week_in, 0, -1);
		
		$ri_now = $ri - 1;
		$ri_last = $ri - 2;
		$query_qr = $query_qr." (IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`)) AS GROWTH, 
					((IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))/IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))*100 AS PERSEN
					FROM (
						SELECT DISTINCT(CHANNEL) FROM `M_SUM_TV_DASH_CHAN_PTV_WEEK`
						WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
						AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')
						AND CHANNEL IS NOT NULL
					) CHN  ".$join_left." ".$where." ORDER BY A1.`VIEWERS` DESC ";

		
 		$data['weeks'] = $this->tvprogramun_model->list_spot_by_program_all_bar2($query_qr,$where,$periode,$pilihaudiencebar,"0","True"); 
 		
 		
		
		$query_qr2 = "SELECT CHN.CHANNEL CHANNEL,CHN.VIEWERS AS TOTAL ";
		$week_in2 = "";
		$join_left2 = "";
		$ri2 = 1;
		$th_tb2 = "";
		foreach($data['monthdt'] as $wkwkwk){
			$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS V".$ri2." ";

			$join_left2 = $join_left2." LEFT JOIN (
						SELECT * FROM M_SUM_TV_DASH_CHAN_PTV
						WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
						AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')
						AND ID_PROFILE = 0
					) A".$ri2." ON CHN.CHANNEL = A".$ri2.".CHANNEL ";
			
			$ri2++;
		}
		
		if(date('Y') == '2021'){
		
			$query_qr2 = $query_qr2."".$week_in2." FROM (
						SELECT * FROM M_SUM_TV_DASH_CHAN_PTV
						WHERE `TANGGAL` = '2020'
						AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')
						AND ID_PROFILE = 0
					) CHN ".$join_left2." ORDER BY CHN.VIEWERS DESC ";
		
		}else{
			
			$query_qr2 = $query_qr2."".$week_in2." FROM (
						SELECT * FROM M_SUM_TV_DASH_CHAN_PTV
						WHERE `TANGGAL` = '".date('Y')."'
						AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')
						AND ID_PROFILE = 0
					) CHN ".$join_left2." ORDER BY CHN.VIEWERS DESC ";
			 
		}
		
 		$data['years'] = $this->tvprogramun_model->list_spot_by_program_all_bar42($query_qr2,$where,$periode,$pilihaudiencebar,"0","True"); 
 		 
 
		$array_channel = array();

		$dataM=$data['channels'];
		$scama = array();
		$scama2 = array();
		$scama42 = array();
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
	
		$rkn = 1;
		foreach($data['weeks'] as $array_channel_a){
		
		
			if(isset($array_channel_a['CHANNEL'])){
				$curr_channel = $array_channel_a['CHANNEL'];
				
				$scam2['Rangking'] = $rkn; 
				$scam2['channel'] = $array_channel_a['CHANNEL'];
				
				$wwa = 1;
				foreach($data['weekdt'] as $wkwk){
					$scam2['w'.$wwa] = number_format($array_channel_a['WE'.$wwa],0,',','.');
					
					$wwa++;
				}
				
				if($array_channel_a['GROWTH'] < 0){
					$scam2['growth'] = "<span style='color:red'>".number_format($array_channel_a['GROWTH'],0,',','.')."</span>";
					$scam2['pros'] = "<span style='color:red'>".number_format($array_channel_a['PERSEN'],2,',','.')."</span>"; 
				}else{
					$scam2['growth'] = "<span style='color:green'>".number_format($array_channel_a['GROWTH'],0,',','.')."</span>";
					$scam2['pros'] = "<span style='color:green'>".number_format($array_channel_a['PERSEN'],2,',','.')."</span>"; 
				}
 
			}
			
			array_push($scama2, $scam2); 
			
			$rkn++;
		}
		
		$rkn2 = 1;
		foreach($data['years'] as $array_channel_a){
		
		
			if(isset($array_channel_a['CHANNEL'])){
				$curr_channel = $array_channel_a['CHANNEL'];
				
				$scam42['Rangking'] = $rkn2; 
				$scam42['channel'] = $array_channel_a['CHANNEL'];
				
				for($ti = 1; $ti < date('m');$ti++){
				
					$scam42['V'.$ti] = number_format($array_channel_a['V'.$ti],0,',','.');
					 
					

				}
				
				$scam42['TOTAL'] = number_format($array_channel_a['TOTAL'],0,',','.');
 			}
			
			array_push($scama42, $scam42); 
			
			$rkn2++;
		}
		
		$data['day_dates'] = $day_dates;
		$data['audiencebychannel'] = json_encode($scama2,true); 
		$data['audiencebychannel2'] = json_encode($scama42,true); 
		 
		$data['spots'] = $this->tvprogramun_model->count_program_all($periode);
		
	 
		$data['json_channel'] = $data_cha;
		$data['json_spot'] = $spot_cha;
		 
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		 
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		 
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel($periode);
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);

		
		$this->template->load('maintemplate', 'tvprogramun3tvsea/views/Tvprogramun', $data);
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
		$preset =$this->Anti_si($this->input->post('preset',true));
		
 		
		if( ! empty( $this->Anti_si($this->input->post('channel',true))) ) {
			$channel =  $this->Anti_si($this->input->post('channel',true));
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
 			
			$where = "AND CHANNEL IN (".$str_channel.")"; 
		}
		
		$where = " AND CHANNEL IN (''Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')";
	 
		IF($type == 'AUDIENCE'){
			$tbl_x = 'M_SUM_TV_DASH_CHAN_PTV_WEEK';
			$tipe_tvod = 'VIEWERS';
			$drag = 'MAX';
			$w_week = 0;
		}ELSEIF($type == 'TOTAL_VIEWS'){
			$tbl_x = 'M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV';
			$tipe_tvod = $type;
			$drag = 'SUM';
			$w_week = 1;
		}ELSE{
			$tbl_x = 'M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV';
			$tipe_tvod = $type;
			$drag = 'SUM';
			$w_week = 1;
		}
		
		 
		$data['weekdt'] = $this->tvprogramun_model->get_sel_week($first_day,$this_day);
		
			$bulan['01'] = 'January';
			$bulan['02'] = 'February';
			$bulan['03'] = 'March';
			$bulan['04'] = 'April';
			$bulan['05'] = 'May';
			$bulan['06'] = 'June';
			$bulan['07'] = 'July';
			$bulan['08'] = 'August';
			$bulan['09'] = 'September';
			$bulan['10'] = 'October';
			$bulan['11'] = 'November';
			$bulan['12'] = 'December';
		
		$query_qr = "SELECT CHN.CHANNEL,";
		$week_in = "";
		$join_left = "";
		$ri = 1;
		$th_tb = "";
		foreach($data['weekdt'] as $wkwk){
 			$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",";
			$week_in = $week_in.''.(($wkwk['WEEK']-$w_week)).',';
			
			if($tipe_filter == "live"){ 
			
				$join_left = $join_left." 
				LEFT JOIN (	
							SELECT `CHANNEL`,".$drag."(`VIEWERS`) AS VIEWERS,`WEEK`,`ID_PROFILE` FROM ".$tbl_x." 
						WHERE ID_PROFILE = 0 AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".(($wkwk['WEEK']-$w_week))."
						 ".$where."
						  GROUP BY CHANNEL
						) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
				";
			
			}else{
				$join_left = $join_left." 
				LEFT JOIN (	
						SELECT `CHANNEL`, ".$drag."(VIEWERS) VIEWERS,`TANGGAL`,`WEEK`,`ID_PROFILE` FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
						WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".(($wkwk['WEEK']-$w_week))."
						AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
						 ".$where."
						GROUP BY SUBSTR(TANGGAL,1,4),CHANNEL,`WEEK`
					
					) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
			";
			}
			
			$th_tb = $th_tb."<th >Week ".$ri." <br>".$wkwk['PER']."</th>";
			
			$ri++;
		}
		
		$week_in = substr($week_in, 0, -1);
		
		$ri_now = $ri - 1;
		$ri_last = $ri - 2;
		
		if($tipe_filter == "live"){ 
		
			$query_qr = $query_qr." (IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`)) AS GROWTH, 
					((IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))/IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))*100 AS PERSEN
					FROM (
						SELECT DISTINCT(CHANNEL) FROM `".$tbl_x."`
						WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
						AND CHANNEL IS NOT NULL
						 ".$where."
					) CHN  ".$join_left." WHERE 1=1  ORDER BY A1.`VIEWERS` DESC ";
		
		}else{
			
			$query_qr = $query_qr." (IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`)) AS GROWTH, 
					((IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))/IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))*100 AS PERSEN
					FROM (
						SELECT DISTINCT(CHANNEL) FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
						WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
						AND CHANNEL IS NOT NULL
						AND TIPE_FILTER = '".$tipe_filter."'
						AND TIPE_VIEW = '".$tipe_tvod."'
						 ".$where."
					) CHN  ".$join_left." WHERE 1=1 ORDER BY A1.`VIEWERS` DESC ";
			
		}
	 
		
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_fix($query_qr); 
		

 		
		
		$array_channel = array();

		$dataM=$data['channels'];
		$scama = array();
		$scama2 = array();
		for ($i=0;$i<count($dataM);$i++){
			
			$scam['Rangking'] = $i+1;
			$scam['channel'] = $dataM[$i]['CHANNEL'];
		
			for($q=1;$q<=$ri_now;$q++){
				$scam['w'.$q] = $dataM[$i]['WE'.$q];
			}
		
					$scam['growth'] = $dataM[$i]['GROWTH'];
					$scam['pros'] = number_format($dataM[$i]['PERSEN'],2,',','.'); 

		
			array_push($scama, $scam); 
		}	
		
 		$pathx = base_url() . 'assets/urate-frontend-master/';
		
		$table_html = '
		<table id="example4" class="table table-striped table-bordered example" style="width: 100%">
							<thead>
								<tr>
									<th rowspan = "0" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									<th rowspan = "0" >Channel <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									'.$th_tb.'
									<th rowspan = "0" >Growth W'.$ri_last.' ke W'.$ri_now.' <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									<th rowspan = "0" >% Growth <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
								</tr>
							</thead>
						</table>
		';
		
						
		$data['table'] = $table_html;
		$data['data'] = $scama;
		
 		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$array_cell = ['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
		
		
		
		$data['audiencebychannel'] = json_encode($scama2,true); 	
 
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Channel');
					
					$gos = 1;
					
					foreach($data['weekdt'] as $wkwkS){
						
						 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos]."1", "Week ".$wkwkS['WEEK_MONTH']." \r ".$wkwkS['PER']."");
						 $objPHPExcel->getActiveSheet()->getStyle($array_cell[$gos]."1")->getAlignment()->setWrapText(true);
						
					$gos++;	
					}
					
					$gos2 = $gos+1;
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($array_cell[$gos].'1', 'Growth W'.$data['weekdt'][$gos-3]['WEEK_MONTH'].' ke W'.$data['weekdt'][$gos-2]['WEEK_MONTH'].'')
					->setCellValue($array_cell[$gos2].'1', '% Growth');
	   
 	   
	   $row_in = 2;
	   
	   foreach($scama as  $scamagg){
		   
		    $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row_in, $scamagg['Rangking'] )
					->setCellValue('B'.$row_in, $scamagg['channel']);
				
				$gos = 1;
				foreach($data['weekdt'] as $wkwkS){
						
						 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos].$row_in,$scamagg['w'.$gos]);
						
					$gos++;	
				}
				
				$gos2 = $gos+1;
				
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($array_cell[$gos].$row_in, $scamagg['growth'])
					->setCellValue($array_cell[$gos2].$row_in, $scamagg['pros']);
		   
		   $row_in++;
	   }
		
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);

		


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		
		$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel_growth.xls');

	   
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
		$tpe_f = $this->Anti_si($this->input->post('tpe_f',true));
		
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
			
			$where = "";
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
		
		$where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')";
	 
		
		IF($type == 'AUDIENCE'){
			$tbl_x = 'M_SUM_TV_DASH_CHAN_PTV_WEEK';
			$tipe_tvod = 'VIEWERS';
			$drag = 'MAX';
			$w_week = 0;
		}ELSEIF($type == 'TOTAL_VIEWS'){  
			$tbl_x = 'M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV';
			$tipe_tvod = $type;
			$drag = 'SUM';
			$w_week = 1;
		}ELSE{
			$tbl_x = 'M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV';
			$tipe_tvod = $type;
			$drag = 'SUM';
			$w_week = 1;
		}
		
		 
		$data['weekdt'] = $this->tvprogramun_model->get_sel_week($first_day,$this_day);
		
 		
			$bulan['01'] = 'January';
			$bulan['02'] = 'February';
			$bulan['03'] = 'March';
			$bulan['04'] = 'April';
			$bulan['05'] = 'May';
			$bulan['06'] = 'June';
			$bulan['07'] = 'July';
			$bulan['08'] = 'August';
			$bulan['09'] = 'September';
			$bulan['10'] = 'October';
			$bulan['11'] = 'November';
			$bulan['12'] = 'December';
		
		$query_qr = "SELECT CHN.CHANNEL,";
		$week_in = "";
		$join_left = "";
		$ri = 1;
		$th_tb = "";
		foreach($data['weekdt'] as $wkwk){
 			$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",";
			$week_in = $week_in.''.($wkwk['WEEK']-$w_week).',';
			
			if($tipe_filter == "live"){ 
			
				$join_left = $join_left." 
				LEFT JOIN (	
							SELECT `CHANNEL`,".$drag."(`VIEWERS`) AS VIEWERS,`WEEK`,`ID_PROFILE` FROM ".$tbl_x." 
						WHERE ID_PROFILE = 0 AND SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".($wkwk['WEEK']-$w_week)."
						 ".$where."
						  GROUP BY CHANNEL
						) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
				";
			
			}else{
				$join_left = $join_left." 
				LEFT JOIN (	
						SELECT `CHANNEL`, ".$drag."(VIEWERS) VIEWERS,`TANGGAL`,`WEEK`,`ID_PROFILE` FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
						WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".($wkwk['WEEK']-$w_week)."
						AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
						 ".$where."
						GROUP BY SUBSTR(TANGGAL,1,4),CHANNEL,`WEEK`
					
					) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
			";
			}
			
			$th_tb = $th_tb."<th >Week ".($wkwk['WEEK']-$w_week)." <br>".$wkwk['PER']."</th>";
			
			$ri++;
		}
		
		$week_in = substr($week_in, 0, -1);
		
		$ri_now = $ri - 1;
		$ri_last = $ri - 2;
		
 		
		if(count($data['weekdt']) < 2){
 		
			if($tipe_filter == "live"){ 
			
				$query_qr = $query_qr." 0 AS GROWTH,  
						0*100 AS PERSEN
						FROM (
							SELECT DISTINCT(CHANNEL) FROM `".$tbl_x."`
							WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
							AND CHANNEL IS NOT NULL
							 ".$where."
						) CHN  ".$join_left." WHERE 1=1  ORDER BY A1.`VIEWERS` DESC ";
			
			}else{
				
				$query_qr = $query_qr." 0 AS GROWTH, 
						0*100 AS PERSEN
						FROM (
							SELECT DISTINCT(CHANNEL) FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
							WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
							AND CHANNEL IS NOT NULL
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$tipe_tvod."'
							 ".$where."
						) CHN  ".$join_left." WHERE 1=1 ORDER BY A1.`VIEWERS` DESC ";
				
			}
		
		}else{
			
			if($tipe_filter == "live"){ 
			
				$query_qr = $query_qr." (IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`)) AS GROWTH, 
						((IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))/IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))*100 AS PERSEN
						FROM (
							SELECT DISTINCT(CHANNEL) FROM `".$tbl_x."`
							WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
							AND CHANNEL IS NOT NULL
							 ".$where."
						) CHN  ".$join_left." WHERE 1=1  ORDER BY A1.`VIEWERS` DESC ";
			
			}else{
				
				$query_qr = $query_qr." (IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`)) AS GROWTH, 
						((IF(A".$ri_now.".`VIEWERS` is null,0,A".$ri_now.".`VIEWERS`) - IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))/IF(A".$ri_last.".`VIEWERS` is null,0,A".$ri_last.".`VIEWERS`))*100 AS PERSEN
						FROM (
							SELECT DISTINCT(CHANNEL) FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
							WHERE SUBSTR(TANGGAL,1,4) = '".$data['weekdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
							AND CHANNEL IS NOT NULL
							AND TIPE_FILTER = '".$tipe_filter."'
							AND TIPE_VIEW = '".$tipe_tvod."'
							 ".$where."
						) CHN  ".$join_left." WHERE 1=1 ORDER BY A1.`VIEWERS` DESC ";
				
			}

			
		}
	 

		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_fix($query_qr); 
		

 		
		
		$array_channel = array();

		$dataM=$data['channels'];
		$scama = array();
		$scama2 = array();
		for ($i=0;$i<count($dataM);$i++){
			
			$scam['Rangking'] = $i+1;
			$scam['channel'] = $dataM[$i]['CHANNEL'];
		
			for($q=1;$q<=$ri_now;$q++){
				$scam['w'.$q] = number_format($dataM[$i]['WE'.$q],0,',','.');
			}
		
			if($dataM[$i]['GROWTH'] < 0){
					$scam['growth'] = "<span style='color:red'>".number_format($dataM[$i]['GROWTH'],0,',','.')."</span>";
					$scam['pros'] = "<span style='color:red'>".number_format($dataM[$i]['PERSEN'],2,',','.')."</span>"; 
			}else{
					$scam['growth'] = "<span style='color:green'>".number_format($dataM[$i]['GROWTH'],0,',','.')."</span>";
					$scam['pros'] = "<span style='color:green'>".number_format($dataM[$i]['PERSEN'],2,',','.')."</span>"; 
			}
		
			array_push($scama, $scam); 
		}	
		
 		$pathx = base_url() . 'assets/urate-frontend-master/';
		
		if(count($data['weekdt']) < 2){
		
			$table_html = '
			<table id="example4" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "0" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >Channel <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
										<th rowspan = "0" >Growth W ke W <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th> 
										<th rowspan = "0" >% Growth <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									</tr>
								</thead>
							</table>
			';
		
		}else{
			
			$table_html = '
			<table id="example4" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "0" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >Channel <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
										<th rowspan = "0" >Growth W'.$data['weekdt'][$ri_last-1]['WEEK_MONTH'].' ke W'.$data['weekdt'][$ri_now-1]['WEEK_MONTH'].' <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >% Growth <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									</tr>
								</thead>
							</table>
			';

		}
						
		$data['table'] = $table_html;
		$data['data'] = $scama;
		
      
		echo json_encode($data,true);
	}
	
	function audiencebar_by_channel42(){
		
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
		
		$DATE_NOW= DATE('m');
 		
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
			
			$where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ";
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
		
			$bulan['01'] = 'January';
			$bulan['02'] = 'February';
			$bulan['03'] = 'March';
			$bulan['04'] = 'April';
			$bulan['05'] = 'May';
			$bulan['06'] = 'June';
			$bulan['07'] = 'July';
			$bulan['08'] = 'August';
			$bulan['09'] = 'September';
			$bulan['10'] = 'October';
			$bulan['11'] = 'November';
			$bulan['12'] = 'December';
		
		
 		IF($type == 'AUDIENCE'){
			$tbt = 'M_SUM_TV_DASH_CHAN_PTV';
			$tbt2F = 'M_SUM_TV_DASH_CHAN_PTV_WEEK';
			$w_week = 0;
			$tbl_head = 'Audience';
			$drag = 'MAX';
			$vv = "VIEWERS";
		}ELSEIF($type == 'TOTAL_VIEWS'){
			$tbt = 'M_SUM_TV_DASH_CHAN_VIEWERS_PTV';
			$tbt2F = 'M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV';
			$w_week = 1;
			$tbl_head = 'Total Views';
			$drag = 'SUM';
			$vv = 'IF(CHANNEL = "SEA TODAY",CEIL(VIEWERS*1.87),VIEWERS)';
		}ELSE{
			$tbt = 'M_SUM_TV_DASH_CHAN_DURATION_PTV';
			$tbt2F = 'M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV';
			$w_week = 1;
			$tbl_head = 'Duration';
			$drag = 'SUM';
			$vv = "VIEWERS";
		}
		
		IF($type == 'AUDIENCE'){
			$tipe_tvod = 'VIEWERS';
		}ELSE{
			$tipe_tvod = $type;
		}
		
 		
		if($this_day == "All"){
			
			
		
			if($tipe_filter == 'live'){
				$data['monthdt'] = $this->tvprogramun_model->get_sel_month_all($first_day,$this_day);
				
				$query_qr2 = "SELECT CHN.CHANNEL CHANNEL,CHN.VIEWERS AS TOTAL ";
				$week_in2 = "";
				$join_left2 = "";
				$ri2 = 1;
				$th_tb = "";
				foreach($data['monthdt'] as $wkwkwk){
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS V".$ri2." ";

					
					$join_left2 = $join_left2." LEFT JOIN (
								SELECT * FROM ".$tbt."
								WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
								AND ID_PROFILE = 0
								".$where."
							) A".$ri2." ON CHN.CHANNEL = A".$ri2.".CHANNEL ";
					
					$th_tb = $th_tb."<th > ".$wkwkwk['PERIODE']."</th>";
					
					$ri2++;
				}
				
				IF($type == 'AUDIENCE'){
					if($DATE_NOW == '02' && DATE('Y') == $first_day ){
						$tbt = 'M_SUM_TV_DASH_CHAN_PTV';
						$query_qr2 = $query_qr2."".$week_in2." FROM (
									SELECT * FROM ".$tbt."
									WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,VIEWERS,TANGGAL,ID_PROFILE
								) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";

					}else{
					
						$tbt = 'M_SUM_TV_DASH_CHAN_PTV';
						$query_qr2 = $query_qr2."".$week_in2." FROM (
									SELECT * FROM ".$tbt."
									WHERE `TANGGAL` = '".$first_day."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,VIEWERS,TANGGAL,ID_PROFILE
								) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
					}
				}ELSEIF($type == 'TOTAL_VIEWS'){
					$tbt = 'M_SUM_TV_DASH_CHAN_VIEWERS_PTV';
					$query_qr2 = $query_qr2."".$week_in2." FROM (
								SELECT CHANNEL,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt."
								WHERE SUBSTR(`TANGGAL`,1,4) = '".$first_day."'
								AND ID_PROFILE = 0
								AND TANGGAL <> '".date('Y-F')."'
								".$where."
								GROUP BY CHANNEL
							) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
							
				}ELSE{
					$tbt = 'M_SUM_TV_DASH_CHAN_DURATION_PTV';
					$query_qr2 = $query_qr2."".$week_in2." FROM (
								SELECT CHANNEL,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt."
								WHERE SUBSTR(`TANGGAL`,1,4) = '".$first_day."'
								AND ID_PROFILE = 0
								AND TANGGAL <> '".date('Y-F')."'
								".$where."
								GROUP BY CHANNEL
							) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
							
				}
			
			}else{
				
				IF($type == 'AUDIENCE'){
					$tbts = 'VIEWERS';
				}ELSE{
					$tbts = $type;
				}
				
 				$data['monthdt'] = $this->tvprogramun_model->get_sel_month_all($first_day,$this_day);
				
				$query_qr2 = "SELECT CHN.CHANNEL,CHN.VIEWERS AS TOTAL ";
				$week_in2 = "";
				$join_left2 = "";
				$ri2 = 1;
				$th_tb = "";
				foreach($data['monthdt'] as $wkwkwk){
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS V".$ri2." ";

					
						$join_left2 = $join_left2." LEFT JOIN (
								SELECT CHANNEL,VIEWERS AS VIEWERS FROM M_SUM_TV_DASH_CHAN_TVOD
								WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
								AND TIPE_FILTER = '".$tipe_filter."'
								AND TIPE_VIEW = '".$tbts."'
								AND ID_PROFILE = 0
								".$where."
							) A".$ri2." ON CHN.CHANNEL = A".$ri2.".CHANNEL ";
					
					
					$th_tb = $th_tb."<th > ".$wkwkwk['PERIODE']."</th>";
					
					$ri2++;
				}
				
				if($type == 'ALL'){
						 
							
						IF($type == 'AUDIENCE'){
							$tbt = "M_SUM_TV_DASH_CHAN_TVOD";
							$query_qr2 = $query_qr2."".$week_in2." FROM (
							
							 SELECT A.CHANNEL,A.VIEWERS+IF(B.VIEWERS IS NULL,0,B.VIEWERS) VIEWERS FROM (
									SELECT * FROM M_SUM_TV_DASH_CHAN_PTV
									WHERE `TANGGAL` = '".$first_day."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,VIEWERS,TANGGAL,ID_PROFILE
								) A LEFT JOIN (
										SELECT CHANNEL,VIEWERS AS VIEWERS FROM ".$tbt."
										WHERE SUBSTR(`TANGGAL`,1,4) = '".$first_day."'
										AND TIPE_VIEW = 'VIEWERS'
										AND TIPE_FILTER = '".$tipe_filter."'
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,'%Y-%M') < STR_TO_DATE('".date('Y-F')."','%Y-%M')
										".$where."
										GROUP BY CHANNEL
								) B ON A.CHANNEL = B.CHANNEL		
										
									) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
						
						}ELSEIF($type == 'TOTAL_VIEWS'){
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							
										SELECT A.CHANNEL,A.VIEWERS+IF(B.VIEWERS IS NULL,0,B.VIEWERS) VIEWERS FROM (
											SELECT CHANNEL,'.$drag.'(VIEWERS) AS VIEWERS FROM '.$tbt.'
											WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
											AND ID_PROFILE = 0
											AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
											'.$where.'
											GROUP BY CHANNEL
										) A LEFT JOIN (
													SELECT CHANNEL,'.$drag.'(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV
													WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
													AND TIPE_VIEW = "TOTAL_VIEWS"
													AND TIPE_FILTER = "'.$tipe_filter.'"
													AND ID_PROFILE = 0
													AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
													'.$where.'
													GROUP BY CHANNEL
										) B ON A.CHANNEL = B.CHANNEL		
									) CHN '.$join_left2.' WHERE 1=1  ORDER BY CHN.VIEWERS DESC ';
									
						}ELSE{
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							
							SELECT A.CHANNEL,A.VIEWERS+IF(B.VIEWERS IS NULL,0,B.VIEWERS) VIEWERS FROM (
								SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM '.$tbt.'
									WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
									AND ID_PROFILE = 0
									AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
									'.$where.'
									GROUP BY CHANNEL
								) A LEFT JOIN (
										SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_CHAN_DURATION_PTV
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "DURATION"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
								) B ON A.CHANNEL = B.CHANNEL	
									) CHN '.$join_left2.' WHERE 1=1 ORDER BY CHN.VIEWERS DESC ';
									
						}	
							
					}else{
				
						IF($type == 'AUDIENCE'){
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
										SELECT CHANNEL,MAX(VIEWERS) AS VIEWERS FROM '.$tbt.'
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "VIEWERS"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
									) CHN '.$join_left2.' WHERE 1=1  ORDER BY CHN.VIEWERS DESC ';
						
						}ELSEIF($type == 'TOTAL_VIEWS'){
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
										SELECT CHANNEL,SUM(IF(CHANNEL = "SEA TODAY",CEIL(VIEWERS*1.87),VIEWERS)) AS VIEWERS FROM '.$tbt.'
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "TOTAL_VIEWS"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
									) CHN '.$join_left2.' WHERE 1=1 ORDER BY CHN.VIEWERS DESC ';
									
						}ELSE{
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
										SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM '.$tbt.'
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "DURATION"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
									) CHN '.$join_left2.' WHERE 1=1 ORDER BY CHN.VIEWERS DESC ';
									
						}
				 
					}
			}
		 
			
			$data['years'] = $this->tvprogramun_model->list_spot_by_program_all_bar42($query_qr2,$where,$periode,$pilihaudiencebar,"0","True"); 
 
			$array_channel = array();

 			$scama = array();
			$scama2 = array();
			$scama42 = array();
			$rkn2 = 1;
			foreach($data['years'] as $array_channel_a){
			
			
				if(isset($array_channel_a['CHANNEL'])){
					$curr_channel = $array_channel_a['CHANNEL'];
					
					$scam42['Rangking'] = $rkn2; 
					$scam42['channel'] = $array_channel_a['CHANNEL'];
					
					$sq = 1;
					foreach($data['monthdt'] as $ssss){
						$scam42['V'.$sq] = number_format($array_channel_a['V'.$sq],0,',','.');
						$sq++;
					}
					$scam42['TOTAL'] = number_format($array_channel_a['TOTAL'],0,',','.');

					
 				}
				
				array_push($scama42, $scam42); 
				
				$rkn2++;
			}
			
			 
			
			$pathx = base_url() . 'assets/urate-frontend-master/';
			
			$table_html = '
			<table id="example42" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "0" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >Channel <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
										<th rowspan = "0" >Total<img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									</tr>
								</thead>
							</table>
			';
			
							
			$data['table'] = $table_html;
			$data['data'] = $scama42;
		
		}else{

		
			$data['monthdt'] = $this->tvprogramun_model->get_sel_week_month($first_day,$this_day);
		
			$query_qr = "SELECT CHN.CHANNEL CHANNEL,";
			$week_in = "";
			$join_left = "";
			$ri = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			foreach($data['monthdt'] as $wkwk){
 				$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",A".$ri.".CHANNEL AS CHANNEL".$ri.",";
				$week_in = $week_in."'".((($wkwk['WEEK']-$w_week)))."',";
				
				if($tipe_filter == "live"){ 
				
					IF($ri == 1){
					
						$join_left = $join_left." 
							LEFT JOIN (	
								SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
									( 
										SELECT `CHANNEL`,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt2F."
										WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'  AND `WEEK` = '".((($wkwk['WEEK']-$w_week)))."'
										".$where."
										GROUP BY CHANNEL
										order by VIEWERS desc
									) z ORDER BY Rangking
								) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
						";
					}else{
						$join_left = $join_left." 
							LEFT JOIN (	
							SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
								( 
									SELECT `CHANNEL`,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt2F."
									WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'  AND `WEEK` = '".((($wkwk['WEEK']-$w_week)))."'
									".$where."
									GROUP BY CHANNEL
									order by VIEWERS desc
								) z ORDER BY Rangking
								) A".$ri." ON CHN.Rangking = A".$ri.".Rangking 
						";

					}
				
				}ELSE{
					
					IF($ri == 1){
						$join_left = $join_left." 
								LEFT JOIN (	
								SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT `CHANNEL`, ".$drag."(VIEWERS) VIEWERS,`TANGGAL`,`WEEK`,`ID_PROFILE` FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
									WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".($wkwk['WEEK']-$w_week)."
									AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
									".$where."
									GROUP BY SUBSTR(TANGGAL,1,4),CHANNEL,`WEEK`
								) z ORDER BY Rangking
								) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
								
						";
					}else{
						
						$join_left = $join_left." 
								LEFT JOIN (	
								SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT `CHANNEL`, ".$drag."(VIEWERS) VIEWERS,`TANGGAL`,`WEEK`,`ID_PROFILE` FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
									WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".($wkwk['WEEK']-$w_week)."
									AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
									".$where."
									GROUP BY SUBSTR(TANGGAL,1,4),CHANNEL,`WEEK`
								) z ORDER BY Rangking
								) A".$ri." ON A1.Rangking = A".$ri.".Rangking  
								
						";
						
					}
				}
				
				
				$th_tb = $th_tb."<th colspan = '2' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Channel</td><td>".$tbl_head."</td>";
				$ri++;
			}
			
 			
			$th_tbs = $th_tbs."</tr>";
			
			$week_in = substr($week_in, 0, -1);
			
			$ri_now = $ri - 1;
			$ri_last = $ri - 2;
			
			if($tipe_filter == "live"){ 
			
				$query_qr = $query_qr." A1.VIEWERS AS TOTAL
					FROM (
						SELECT *,rowNumberInAllBlocks()+1 as Rangking from (
							select 
							CHANNEL,max(VIEWERS) as VIEWERS FROM ".$tbt2F."
							WHERE SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
							AND CHANNEL IS NOT NULL
							".$where."
							GROUP BY CHANNEL
							order by VIEWERS desc
						) A
					) CHN  ".$join_left." 
					WHERE 1=1  ORDER BY  A1.VIEWERS DESC,CHANNEL ASC   "; 
			
			}ELSE{
				
				$query_qr = $query_qr." A1.VIEWERS AS TOTAL 
					FROM (
						SELECT rank() over ( ORDER BY CHANNEL DESC) AS Rangking,
						CHANNEL FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
						WHERE SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
						AND CHANNEL IS NOT NULL
						AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
						".$where." 
						GROUP BY CHANNEL
					) CHN  ".$join_left." 
					WHERE 1=1  ORDER BY  A1.VIEWERS DESC,CHANNEL ASC   ";
				
			}
			
			
			//echo $query_qr;die;
			 
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_fix($query_qr); 
			
			$array_channel = array();
 
			$dataM=$data['channels'];
			$scama = array();
			$scama2 = array();
			for ($i=0;$i<count($dataM);$i++){
				
				$scam['Rangking'] = $i+1;
				
 			
				for($q=1;$q<=$ri_now;$q++){
					$scam['channel'.$q] = $dataM[$i]['CHANNEL'.$q]; 
					$scam['w'.$q] = number_format($dataM[$i]['WE'.$q],0,',','.');
				}
			
				array_push($scama, $scam); 
			}	
			
 			$pathx = base_url() . 'assets/urate-frontend-master/';
			
			$table_html = '
			<table id="example42" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "2" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
									</tr>
										'.$th_tbs.'
								</thead>
							</table>
			';
			
			
 							
			$data['table'] = $table_html;
			$data['data'] = $scama;
			
			
		}
		
		echo json_encode($data,true);
		
		
	}
	
	public function audiencebar_by_channel_export2(){
	
		
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
			
			$where = "";
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
		
		$where = " AND CHANNEL IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia')";
		
		
			$bulan['01'] = 'January';
			$bulan['02'] = 'February';
			$bulan['03'] = 'March';
			$bulan['04'] = 'April';
			$bulan['05'] = 'May';
			$bulan['06'] = 'June';
			$bulan['07'] = 'July';
			$bulan['08'] = 'August';
			$bulan['09'] = 'September';
			$bulan['10'] = 'October';
			$bulan['11'] = 'November';
			$bulan['12'] = 'December';
		
		
 		IF($type == 'AUDIENCE'){
			$tbt = 'M_SUM_TV_DASH_CHAN_PTV';
			$tbt2F = 'M_SUM_TV_DASH_CHAN_PTV_WEEK';
			$w_week = 0;
			$tbl_head = 'Audience';
			$drag = 'MAX';
			$vv = "VIEWERS";
		}ELSEIF($type == 'TOTAL_VIEWS'){
			$tbt = 'M_SUM_TV_DASH_CHAN_VIEWERS_PTV';
			$tbt2F = 'M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV';
			$w_week = 1;
			$tbl_head = 'Total Views';
			$drag = 'SUM';
			$vv = 'IF(CHANNEL = "SEA TODAY",CEIL(VIEWERS*1.87),VIEWERS)';
		}ELSE{
			$tbt = 'M_SUM_TV_DASH_CHAN_DURATION_PTV';
			$tbt2F = 'M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV';
			$w_week = 1;
			$tbl_head = 'Duration';
			$drag = 'SUM';
			$vv = "VIEWERS";
		}
		
		IF($type == 'AUDIENCE'){
			$tipe_tvod = 'VIEWERS';
		}ELSE{
			$tipe_tvod = $type;
		}
		
 		
		if($this_day == "All"){
		
			if($tipe_filter == 'live'){
				$data['monthdt'] = $this->tvprogramun_model->get_sel_month_all($first_day,$this_day);
				
				$query_qr2 = "SELECT CHN.CHANNEL CHANNEL,CHN.VIEWERS AS TOTAL ";
				$week_in2 = "";
				$join_left2 = "";
				$ri2 = 1;
				$th_tb = "";
				foreach($data['monthdt'] as $wkwkwk){
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS V".$ri2." ";

					
					$join_left2 = $join_left2." LEFT JOIN (
								SELECT * FROM ".$tbt."
								WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
								AND ID_PROFILE = 0
								".$where."
							) A".$ri2." ON CHN.CHANNEL = A".$ri2.".CHANNEL ";
					
					$th_tb = $th_tb."<th > ".$wkwkwk['PERIODE']."</th>";
					
					$ri2++;
				}
				
				IF($type == 'AUDIENCE'){
					if($DATE_NOW == '02' && DATE('Y') == $first_day ){
						$tbt = 'M_SUM_TV_DASH_CHAN_PTV';
						$query_qr2 = $query_qr2."".$week_in2." FROM (
									SELECT * FROM ".$tbt."
									WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,VIEWERS,TANGGAL,ID_PROFILE
								) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";

					}else{
					
						$tbt = 'M_SUM_TV_DASH_CHAN_PTV';
						$query_qr2 = $query_qr2."".$week_in2." FROM (
									SELECT * FROM ".$tbt."
									WHERE `TANGGAL` = '".$first_day."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,VIEWERS,TANGGAL,ID_PROFILE
								) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
					}
				}ELSEIF($type == 'TOTAL_VIEWS'){
					$tbt = 'M_SUM_TV_DASH_CHAN_VIEWERS_PTV';
					$query_qr2 = $query_qr2."".$week_in2." FROM (
								SELECT CHANNEL,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt."
								WHERE SUBSTR(`TANGGAL`,1,4) = '".$first_day."'
								AND ID_PROFILE = 0
								AND TANGGAL <> '".date('Y-F')."'
								".$where."
								GROUP BY CHANNEL
							) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
							
				}ELSE{
					$tbt = 'M_SUM_TV_DASH_CHAN_DURATION_PTV';
					$query_qr2 = $query_qr2."".$week_in2." FROM (
								SELECT CHANNEL,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt."
								WHERE SUBSTR(`TANGGAL`,1,4) = '".$first_day."'
								AND ID_PROFILE = 0
								AND TANGGAL <> '".date('Y-F')."'
								".$where."
								GROUP BY CHANNEL
							) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
							
				}
			
			}else{
				
				IF($type == 'AUDIENCE'){
					$tbts = 'VIEWERS';
				}ELSE{
					$tbts = $type;
				}
				
 				$data['monthdt'] = $this->tvprogramun_model->get_sel_month_all($first_day,$this_day);
				
				$query_qr2 = "SELECT CHN.CHANNEL,CHN.VIEWERS AS TOTAL ";
				$week_in2 = "";
				$join_left2 = "";
				$ri2 = 1;
				$th_tb = "";
				foreach($data['monthdt'] as $wkwkwk){
					$week_in2 = $week_in2.",A".$ri2.".VIEWERS AS V".$ri2." ";

					
						$join_left2 = $join_left2." LEFT JOIN (
								SELECT CHANNEL,VIEWERS AS VIEWERS FROM M_SUM_TV_DASH_CHAN_TVOD
								WHERE `TANGGAL` = '".$wkwkwk['PERIODE_FULL']."'
								AND TIPE_FILTER = '".$tipe_filter."'
								AND TIPE_VIEW = '".$tbts."'
								AND ID_PROFILE = 0
								".$where."
							) A".$ri2." ON CHN.CHANNEL = A".$ri2.".CHANNEL ";
					
					
					$th_tb = $th_tb."<th > ".$wkwkwk['PERIODE']."</th>";
					
					$ri2++;
				}
				
				if($type == 'ALL'){
					 
							
						IF($type == 'AUDIENCE'){
							$tbt = "M_SUM_TV_DASH_CHAN_TVOD";
							$query_qr2 = $query_qr2."".$week_in2." FROM (
							
							 SELECT A.CHANNEL,A.VIEWERS+IF(B.VIEWERS IS NULL,0,B.VIEWERS) VIEWERS FROM (
									SELECT * FROM M_SUM_TV_DASH_CHAN_PTV
									WHERE `TANGGAL` = '".$first_day."'
									AND ID_PROFILE = 0
									".$where."
									GROUP BY CHANNEL,VIEWERS,TANGGAL,ID_PROFILE
								) A LEFT JOIN (
										SELECT CHANNEL,VIEWERS AS VIEWERS FROM ".$tbt."
										WHERE SUBSTR(`TANGGAL`,1,4) = '".$first_day."'
										AND TIPE_VIEW = 'VIEWERS'
										AND TIPE_FILTER = '".$tipe_filter."'
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,'%Y-%M') < STR_TO_DATE('".date('Y-F')."','%Y-%M')
										".$where."
										GROUP BY CHANNEL
								) B ON A.CHANNEL = B.CHANNEL		
										
									) CHN ".$join_left2." WHERE 1=1  ORDER BY CHN.VIEWERS DESC ";
						
						}ELSEIF($type == 'TOTAL_VIEWS'){
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							
										SELECT A.CHANNEL,A.VIEWERS+IF(B.VIEWERS IS NULL,0,B.VIEWERS) VIEWERS FROM (
											SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM '.$tbt.'
											WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
											AND ID_PROFILE = 0
											AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
											'.$where.'
											GROUP BY CHANNEL
										) A LEFT JOIN (
													SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_CHAN_VIEWERS_PTV
													WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
													AND TIPE_VIEW = "TOTAL_VIEWS"
													AND TIPE_FILTER = "'.$tipe_filter.'"
													AND ID_PROFILE = 0
													AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
													'.$where.'
													GROUP BY CHANNEL
										) B ON A.CHANNEL = B.CHANNEL		
									) CHN '.$join_left2.' WHERE 1=1  ORDER BY CHN.VIEWERS DESC ';
									
						}ELSE{
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
							
							SELECT A.CHANNEL,A.VIEWERS+IF(B.VIEWERS IS NULL,0,B.VIEWERS) VIEWERS FROM (
								SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM '.$tbt.'
									WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
									AND ID_PROFILE = 0
									AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
									'.$where.'
									GROUP BY CHANNEL
								) A LEFT JOIN (
										SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM M_SUM_TV_DASH_CHAN_DURATION_PTV
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "DURATION"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
								) B ON A.CHANNEL = B.CHANNEL	
									) CHN '.$join_left2.' WHERE 1=1 ORDER BY CHN.VIEWERS DESC ';
									
						}	
							
					}else{
				
						IF($type == 'AUDIENCE'){
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
										SELECT CHANNEL,MAX(VIEWERS) AS VIEWERS FROM '.$tbt.'
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "VIEWERS"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
									) CHN '.$join_left2.' WHERE 1=1  ORDER BY CHN.VIEWERS DESC ';
						
						}ELSEIF($type == 'TOTAL_VIEWS'){
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
										SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM '.$tbt.'
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "TOTAL_VIEWS"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
									) CHN '.$join_left2.' WHERE 1=1 ORDER BY CHN.VIEWERS DESC ';
									
						}ELSE{
							$tbt = 'M_SUM_TV_DASH_CHAN_TVOD';
							$query_qr2 = $query_qr2.''.$week_in2.' FROM (
										SELECT CHANNEL,SUM(VIEWERS) AS VIEWERS FROM '.$tbt.'
										WHERE SUBSTR(`TANGGAL`,1,4) = "'.$first_day.'"
										AND TIPE_VIEW = "DURATION"
										AND TIPE_FILTER = "'.$tipe_filter.'"
										AND ID_PROFILE = 0
										AND STR_TO_DATE(TANGGAL,"%Y-%M") < STR_TO_DATE("'.date('Y-F').'","%Y-%M")
										'.$where.'
										GROUP BY CHANNEL
									) CHN '.$join_left2.' WHERE 1=1 ORDER BY CHN.VIEWERS DESC ';
									
						}
				 
					}
			}
			
		 
			
			$data['years'] = $this->tvprogramun_model->list_spot_by_program_all_bar42($query_qr2,$where,$periode,$pilihaudiencebar,"0","True"); 
 
			$array_channel = array();

 			$scama = array();
			$scama2 = array();
			$scama42 = array();
			$rkn2 = 1;
			foreach($data['years'] as $array_channel_a){
			
			
				if(isset($array_channel_a['CHANNEL'])){
					$curr_channel = $array_channel_a['CHANNEL'];
					
					$scam42['Rangking'] = $rkn2; 
					$scam42['channel'] = $array_channel_a['CHANNEL'];
					
					$sq = 1;
					foreach($data['monthdt'] as $ssss){
						$scam42['V'.$sq] = $array_channel_a['V'.$sq];
						$sq++;
					}
					$scam42['TOTAL'] = $array_channel_a['TOTAL'];

					
 				}
				
				array_push($scama42, $scam42); 
				
				$rkn2++;
			}
			
		 
			
			$pathx = base_url() . 'assets/urate-frontend-master/';
			
			$table_html = '
			<table id="example42" class="table table-striped table-bordered example" style="width: 100%">
								<thead>
									<tr>
										<th rowspan = "0" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										<th rowspan = "0" >Channel <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
										<th rowspan = "0" >Total<img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
									</tr>
								</thead>
							</table>
			';
			
							
			$data['table'] = $table_html;
			$data['data'] = $scama42;
		
		$array_cell = ['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
			
			$bulanX['1'] = 'Jan';
			$bulanX['2'] = 'Feb';
			$bulanX['3'] = 'Mar';
			$bulanX['4'] = 'Apr';
			$bulanX['5'] = 'May';
			$bulanX['6'] = 'Jun';
			$bulanX['7'] = 'Jul';
			$bulanX['8'] = 'Aug';
			$bulanX['9'] = 'Sep';
			$bulanX['10'] = 'Oct';
			$bulanX['11'] = 'Nov';
			$bulanX['12'] = 'Dec';
			
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
					->setCellValue('B1', 'Channel');
		   
					$gos = 1;
					foreach($data['monthdt'] as $ssss){
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos]."1", $bulanX[$gos]."-".$start_date); 
						$gos++;	
					}
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($array_cell[$gos].'1', 'Total');
					
					$gosx = 2;
					foreach($scama42 as $scama42s){
						 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$gosx, $scama42s['Rangking'])
						->setCellValue('B'.$gosx, $scama42s['channel']);
						
						$gos = 1;
						foreach($data['monthdt'] as $ssss){
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos].$gosx, $scama42s['V'.$gos]);
							$gos++;	
						}
						
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$gos].$gosx, $scama42s['TOTAL']);
						
						$gosx++;	
						
					}
					
			
			$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 			$objPHPExcel->setActiveSheetIndex(0);


			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');	
		
		}else{

		
			$data['monthdt'] = $this->tvprogramun_model->get_sel_week_month($first_day,$this_day);
		
 		
			$query_qr = "SELECT CHN.CHANNEL CHANNEL,";
			$week_in = "";
			$join_left = "";
			$ri = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			foreach($data['monthdt'] as $wkwk){
 				$query_qr = $query_qr." IF(A".$ri.".`VIEWERS` is null,0,A".$ri.".`VIEWERS`) AS WE".$ri.",A".$ri.".CHANNEL AS CHANNEL".$ri.",";
				$week_in = $week_in."'".((($wkwk['WEEK']-$w_week)))."',";
				
				if($tipe_filter == "live"){ 
				
					IF($ri == 1){
					
						$join_left = $join_left." 
							LEFT JOIN (	
								SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
									( 
										SELECT `CHANNEL`,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt2F."
										WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'  AND `WEEK` = '".((($wkwk['WEEK']-$w_week)))."'
										".$where."
										GROUP BY CHANNEL
										order by VIEWERS desc
									) z ORDER BY Rangking
								) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
						";
					}else{
						$join_left = $join_left." 
							LEFT JOIN (	
							SELECT z.*, rowNumberInAllBlocks()+1 as Rangking FROM 
								( 
									SELECT `CHANNEL`,".$drag."(VIEWERS) AS VIEWERS FROM ".$tbt2F."
									WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."'  AND `WEEK` = '".((($wkwk['WEEK']-$w_week)))."'
									".$where."
									GROUP BY CHANNEL
									order by VIEWERS desc
								) z ORDER BY Rangking
								) A".$ri." ON CHN.Rangking = A".$ri.".Rangking 
						";

					}
				
				}ELSE{
					
					IF($ri == 1){
						$join_left = $join_left." 
								LEFT JOIN (	
								SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT `CHANNEL`, ".$drag."(VIEWERS) VIEWERS,`TANGGAL`,`WEEK`,`ID_PROFILE` FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
									WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".($wkwk['WEEK']-$w_week)."
									AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
									".$where."
									GROUP BY SUBSTR(TANGGAL,1,4),CHANNEL,`WEEK`
								) z ORDER BY Rangking
								) A".$ri." ON CHN.CHANNEL = A".$ri.".CHANNEL 
								
						";
					}else{
						
						$join_left = $join_left." 
								LEFT JOIN (	
								SELECT z.*, rank() over ( ORDER BY VIEWERS DESC,CHANNEL DESC) AS Rangking FROM 
												( 
									SELECT `CHANNEL`, ".$drag."(VIEWERS) VIEWERS,`TANGGAL`,`WEEK`,`ID_PROFILE` FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
									WHERE SUBSTR(TANGGAL,1,4) = '".$wkwk['YEAR']."' AND `WEEK` = ".($wkwk['WEEK']-$w_week)."
									AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
									".$where."
									GROUP BY SUBSTR(TANGGAL,1,4),CHANNEL,`WEEK`
								) z ORDER BY Rangking
								) A".$ri." ON A1.Rangking = A".$ri.".Rangking  
								
						";
						
					}
				}
				
				
				$th_tb = $th_tb."<th colspan = '2' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Channel</td><td>".$tbl_head."</td>";
				$ri++;
			}
			
 			
			$th_tbs = $th_tbs."</tr>";
			
			$week_in = substr($week_in, 0, -1);
			
			$ri_now = $ri - 1;
			$ri_last = $ri - 2;
			
			if($tipe_filter == "live"){ 
			
				$query_qr = $query_qr." A1.VIEWERS AS TOTAL
					FROM (
						SELECT *,rowNumberInAllBlocks()+1 as Rangking from (
							select 
							CHANNEL,max(VIEWERS) as VIEWERS FROM ".$tbt2F."
							WHERE SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
							AND CHANNEL IS NOT NULL
							".$where."
							GROUP BY CHANNEL
							order by VIEWERS desc
						) A
					) CHN  ".$join_left." 
					WHERE 1=1  ORDER BY  A1.VIEWERS DESC,CHANNEL ASC   "; 
			
			}ELSE{
				
				$query_qr = $query_qr." A1.VIEWERS AS TOTAL 
					FROM (
						SELECT rank() over ( ORDER BY CHANNEL DESC) AS Rangking,
						CHANNEL FROM `M_SUM_TV_DASH_CHAN_TVOD_WEEKS`
						WHERE SUBSTR(TANGGAL,1,4) = '".$data['monthdt'][0]['YEAR']."' AND `WEEK` IN (".$week_in.")
						AND CHANNEL IS NOT NULL
						AND TIPE_FILTER = '".$tipe_filter."' AND TIPE_VIEW = '".$tipe_tvod."'
						".$where." 
						GROUP BY CHANNEL
					) CHN  ".$join_left." 
					WHERE 1=1  ORDER BY  A1.VIEWERS DESC,CHANNEL ASC   ";
				
			}
			
			 
			$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar_fix($query_qr); 
			
			$array_channel = array();
 
			$dataM=$data['channels'];
			$scama = array();
			$scama2 = array();
			for ($i=0;$i<count($dataM);$i++){
				
				$scam['Rangking'] = $i+1;
				
 			
				for($q=1;$q<=$ri_now;$q++){
					$scam['channel'.$q] = $dataM[$i]['CHANNEL'.$q]; 
					$scam['w'.$q] = $dataM[$i]['WE'.$q];
				}
			
				array_push($scama, $scam); 
			}	
			
 			$pathx = base_url() . 'assets/urate-frontend-master/';
			
			$table_html = '
			<table id="example42" class="table table-striped table-bordered example" style="width: 100%">
								<thead>
									<tr>
										<th rowspan = "2" >Rank <img class="cArrowDown" src="'.$pathx.'assets/images/icon_arrowdown.png"></th>
										'.$th_tb.'
									</tr>
										'.$th_tbs.'
								</thead>
							</table>
			';
			
			
 							
			$data['table'] = $table_html;
			$data['data'] = $scama;
			
			
			$array_cell = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
			
			$bulanX['1'] = 'Jan';
			$bulanX['2'] = 'Feb';
			$bulanX['3'] = 'Mar';
			$bulanX['4'] = 'Apr';
			$bulanX['5'] = 'May';
			$bulanX['6'] = 'Jun';
			$bulanX['7'] = 'Jul';
			$bulanX['8'] = 'Aug';
			$bulanX['9'] = 'Sep';
			$bulanX['10'] = 'Oct';
			$bulanX['11'] = 'Nov';
			$bulanX['12'] = 'Dec';
			
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
					->setCellValue('A1', 'Rangking');
					
			$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
		   
					$gos = 1;
					$gosw = 1;
					foreach($data['monthdt'] as $ssss){
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos]."1", "Week ".$gosw." (".$ssss['PER'].")"); 
						$goss = $gos+1;
						$objPHPExcel->getActiveSheet()->mergeCells($array_cell[$gos].'1:'.$array_cell[$goss].'1');
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_cell[$gos].'2', 'Channel')
						->setCellValue($array_cell[$goss].'2', $tbl_head);
						$gos++;	
						$gos++;	
						$gosw++;
					}
					
					
					$gosx = 3;
					foreach($scama as $scama42s){
						 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$gosx, $scama42s['Rangking']);
						
						$gos = 1;
						$gosw = 1;
						foreach($data['monthdt'] as $ssss){
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$gos].$gosx, $scama42s['channel'.$gosw]);
							$goss = $gos+1;
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($array_cell[$goss].$gosx, $scama42s['w'.$gosw]);
							$gos++;	
							$gos++;	
							$gosw++;
						}
						
						$gosx++;	

					}
					
					
			
			$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 			$objPHPExcel->setActiveSheetIndex(0);


			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			$objWriter->save('/var/www/html/tmp_doc/Audience_by_channel.xls');	
			
			
		}
				

		
		
	}

}

