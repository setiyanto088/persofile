<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daypartvir extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvpc_model');
	}
	
	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['profile'] = $this->tvpc_model->list_profile($iduser,$idrole,"");
		$data['channel'] = $this->tvpc_model->list_channel();    

		
		$data['daypart'] = $this->tvpc_model->list_daypart($iduser);
		$data['currdate'] = $this->tvpc_model->current_date();
		$data['genre'] = $this->tvpc_model->list_channel_genre();
		$this->template->load('maintemplate', 'daypartvir/views/tvpc_view', $data);
	}
  
	public function get_profile_id($profiles){
		$grouping_json = $this->tvpc_model->content_grouping($profiles);
		$res = json_decode($grouping_json['grouping'],true);		
		$values = [];
		$tag = '';
		$values1 = '';
		
		$strsql='';
		$strsql2='';
		
		$asas = " WHERE 1=1 ";
		
		if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$key = array_keys($mydata['Operation']);
					$asas = $asas."AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'".$key[0]."') IN (";
					foreach($mydata['Operation'] as $val){
						foreach($val as $value){
							$asas = $asas."'".$value."',";
						}						
					}
					$asas = substr($asas,0,-1).") ";
				}
			}
		}
		
		$where = $asas;
		
		$get_userid = $this->tvpc_model->get_userid($where);
		
		if($res){		
			$key1 = '';
			foreach($get_userid as $key)
			{
				$key1 .= "'".$key['USERID']."'".",";
			}
			$profile = rtrim($key1,",");
		}else{
			$profile = '';	
		}
		
		return $profile;
		
	}
	
		public function getDatesFromRange($start, $end, $format = 'Ym') {
		$array = array();
		$interval = new DateInterval('P1D');
	    
		$realEnd = new DateTime($end);
		$realEnd->add($interval);
	    
		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);
	    
		    $curr = '';
		foreach($period as $date) { 
			    if($curr == ''){
				    $array[] = $date->format($format); 
			    }else{
				    if($curr == $date->format($format)){
					    
				    }else{
					    $array[] = $date->format($format); 
				    }
			    }
			    
			    $curr = $date->format($format); 
		}
	    
		return $array;
	    }
	
	public function list_tvpc2()
	{	        
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
        
		if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}	
		
		if( !empty($this->Anti_si($_GET['datatp'])) ) {
			$datatp = $this->Anti_si($_GET['datatp']);
		} else {
			$datatp = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['daypart'])) ) {
			$daypart = $this->Anti_si($_GET['daypart']);
		} else {
			$daypart = NULL;
		}
        
		if( ! empty($this->Anti_si($_GET['profile'])) ) {
			$profile = $this->Anti_si($_GET['profile']);
		} else {
			$profile = 0;
		}
    
		if( ! empty($this->Anti_si($_GET['genre'])) ) {
		  $genre = $this->Anti_si($_GET['genre']);
		} else {
		  $genre = "0";
		}

		if( ! empty($this->Anti_si($_GET['channel'])) ) {
			$channel = $this->Anti_si($_GET['channel']);
		} else {
			$channel = NULL;
		}	
    
		$channel = str_replace("\'","'",$channel);

		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['datatp'] 		= $datatp;
		$params['start_date'] 	= $start_date;
		$params['daypart'] 		= $daypart;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",str_replace("  AND  "," & ",$channel));
		
		$channel_cnt = explode(',',$params['channel']);
		$array_date = $this->getDatesFromRange($start_date,$end_date);
		
		
		$r = 0;

		if($params['datatp'] == 'audience') {
			$huk = 'COUNT(DISTINCT(CARDNO))';
			$tbs = 'M_SUM_TV_DASH_CHAN_PTV_WEEK';
			$tbs2 = 'M_SUM_TV_DASH_CHAN_PTV';
			$mw = 0;
		}elseif($params['datatp'] == 'total_views') {
			$huk = 'COUNT(CARDNO)';
			$tbs = 'M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV';
			$tbs2 = 'M_SUM_TV_DASH_CHAN_VIEWERS_PTV';
			$mw = 1;
		}else{
			$huk = 'SUM(DURASI)';
			$tbs = 'M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV';
			$tbs2 = 'M_SUM_TV_DASH_CHAN_DURATION_PTV';
			$mw = 1;
		}

		$get_week = $this->tvpc_model->get_week($params);
		
		$starts_sds = explode("-",$start_date);
		$end_date_m = cal_days_in_month(CAL_GREGORIAN,$starts_sds[1],$starts_sds[0]);
		
		$end_month_full = $starts_sds[0].'-'.$starts_sds[1].'-'.$end_date_m;
		$start_month_full = $starts_sds[0].'-'.$starts_sds[1].'-01';
		$periode =date_format(date_create($start_date),"Y-F");
		
		
		if(count($get_week) > 0 && count($channel_cnt) == 1  ){
			$query_s = "
				SELECT a.CHANNEL,MAX(a.VIEWERS) as  VIEWERS FROM ".$tbs." a JOIN 
				( SELECT *,(toInt32(WEEK))-".$mw." AS D FROM WEEK_PARAM_DATE a 
				WHERE START_DATE = '".$start_date."' AND EMD_DATE = '".$end_date."' ) b
				on toInt64(a.WEEK) = b.D AND SUBSTRING(a.TANGGAL,1,4) = b.YEAR
				WHERE  ID_PROFILE = 0
				AND CHANNEL IN (".$params['channel'].")
				GROUP BY CHANNEL 				
			";
		}else if($start_date == $start_month_full && $end_date == $end_month_full && count($channel_cnt) == 1 ){ 
			$query_s = "
				SELECT a.CHANNEL,MAX(a.VIEWERS) as  VIEWERS,a.TANGGAL FROM ".$tbs2." a
				WHERE  ID_PROFILE = 0
				AND TANGGAL = '".$periode."'
				AND CHANNEL IN (".$params['channel'].") 
			";


		}else{
	
			if($params['daypart'] == 'ALL' ){

				foreach($array_date as $array_dates){
					
					if($r == 0){
						$query_s = "
						SELECT ".$huk." AS VIEWERS FROM (SELECT * FROM 
							(SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
							WHERE (USER_BEGIN_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
							USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
							AND CHANNEL IN (".$params['channel'].")
							GROUP BY CARDNO,CHANNEL,DATE,DURASI) 
						";
					}else{
						$query_s .= "
						UNION ALL 
						SELECT * FROM (
								SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
						WHERE (USER_BEGIN_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
								USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
								AND CHANNEL IN (".$params['channel'].")
								GROUP BY CARDNO,CHANNEL,`DATE`,DURASI

						) 
						";
					}

					$r++;

				}

			}else{

				$dt = explode('-',$params['daypart']);
				foreach($array_date as $array_dates){

					if($r == 0){
						$query_s = "
						SELECT ".$huk." AS VIEWERS FROM (
							SELECT * FROM 
							(
							SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
							WHERE (USER_BEGIN_SESSION  BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
									USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
									AND CHANNEL IN (".$params['channel'].")
									AND DATE_FORMAT(BEGIN_PROGRAM,'%H:%i:%s') BETWEEN '".$dt[0]."' AND '".$dt[1]."'
									GROUP BY CARDNO,CHANNEL,`DATE`,DURASI
							) 
						";
					}else{
						$query_s .= "
						UNION ALL 
						SELECT * FROM (
								SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
								WHERE (USER_BEGIN_SESSION  BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
								USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
								AND CHANNEL IN (".$params['channel'].")
								AND DATE_FORMAT(BEGIN_PROGRAM,'%H:%i:%s') BETWEEN '".$dt[0]."' AND '".$dt[1]."'
								GROUP BY CARDNO,CHANNEL,`DATE`,DURASI

						) 
						";
					}
					
					$r++;

				}

			}

			$query_s .=" ) ";

		}
		
		
		$params['query_s'] = $query_s;
		
		
		$list = $this->tvpc_model->list_tvpc2($params);
		
		
		$list_all = $this->tvpc_model->list_tvpc_all($params);
		$list2 = $this->tvpc_model->list_tvpc3($params);
		$table1 = '';
		
		if(count($list_all) <> 0){
		
			$table1 = $table1."<tr>";
			$table1 = $table1."<td>All Time</td>";
			$table1 = $table1."<td style='text-align: right'>".number_format($list_all[0]['VIEWERS'],0,',','.')."</td>";
			$table1 = $table1."</tr>";
		
		}else{
			$table1 = $table1."<tr>";
			$table1 = $table1."<td colspan=2>Data Not Found</td>";
			$table1 = $table1."</tr>";
		}

		foreach($list as $lista){
			$table1 = $table1."<tr>";
			$table1 = $table1."<td>".$lista['DAYPART']."<br>".$lista['TEXT']."</td>";
			$table1 = $table1."<td style='text-align: right'>".number_format($lista['VIEWERS'],0,',','.')."</td>";
			$table1 = $table1."</tr>";
		}
		
		
		$list2 = $this->tvpc_model->list_tvpc3($params);
		
		
		$table2 = '';
		
		if(count($list2) <> 0){
		
		$table2 = $table2."<tr>";
			$table2 = $table2."<td>All Time</td>";
			$table2 = $table2."<td style='text-align: right'>".number_format($list_all[0]['VIEWERS'],0,',','.')."</td>";
			$table2 = $table2."</tr>";
			
		}else{
			$table2 = $table2."<tr>";
			$table2 = $table2."<td colspan=2>Data Not Found</td>";
			$table2 = $table2."</tr>";
		}

		$array_day = ['Sunday','Monday','Tuesday','Wednenday','Thursday','Friday','Saturday'];

		foreach($list2 as $lista){
			$table2 = $table2."<tr>";
			$table2 = $table2."<td>".$array_day[$lista['DAYPART']]."</td>";
			$table2 = $table2."<td style='text-align: right'>".number_format($lista['VIEWERS'],0,',','.')."</td>";
			$table2 = $table2."</tr>";
		}
		
		
		
    
		$result["table1"] = $table1;
		$result["table2"] = $table2;
		$this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_tvpc2_export()
	{	        
	
	
	
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
        
		if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}	
		
		if( !empty($this->Anti_si($_GET['datatp'])) ) {
			$datatp = $this->Anti_si($_GET['datatp']);
		} else {
			$datatp = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['daypart'])) ) {
			$daypart = $this->Anti_si($_GET['daypart']);
		} else {
			$daypart = NULL;
		}
        
		if( ! empty($this->Anti_si($_GET['profile'])) ) {
			$profile = $this->Anti_si($_GET['profile']);
		} else {
			$profile = 0;
		}
    
		if( ! empty($this->Anti_si($_GET['genre'])) ) {
		  $genre = $this->Anti_si($_GET['genre']);
		} else {
		  $genre = "0";
		}

		if( ! empty($this->Anti_si($_GET['channel'])) ) {
			$channel = $this->Anti_si($_GET['channel']);
		} else {
			$channel = NULL;
		}	
    
		$channel = str_replace("\'","'",$channel);

		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['datatp'] 		= $datatp;
		$params['start_date'] 	= $start_date;
		$params['daypart'] 		= $daypart;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",str_replace("  AND  "," & ",$channel));
		
		$channel_cnt = explode(',',$params['channel']);
		$array_date = $this->getDatesFromRange($start_date,$end_date);
		
		$r = 0;

		if($params['datatp'] == 'audience') {
			$huk = 'COUNT(DISTINCT(CARDNO))';
			$tbs = 'M_SUM_TV_DASH_CHAN_PTV_WEEK';
			$tbs2 = 'M_SUM_TV_DASH_CHAN_PTV';
			$mw = 0;
		}elseif($params['datatp'] == 'total_views') {
			$huk = 'COUNT(CARDNO)';
			$tbs = 'M_SUM_TV_DASH_CHAN_VIEWERS_WEEK_PTV';
			$tbs2 = 'M_SUM_TV_DASH_CHAN_VIEWERS_PTV';
			$mw = 1;
		}else{
			$huk = 'SUM(DURASI)';
			$tbs = 'M_SUM_TV_DASH_CHAN_DURATION_WEEK_PTV';
			$tbs2 = 'M_SUM_TV_DASH_CHAN_DURATION_PTV';
			$mw = 1;
		}

		$get_week = $this->tvpc_model->get_week($params);
		
		$starts_sds = explode("-",$start_date);
		$end_date_m = cal_days_in_month(CAL_GREGORIAN,$starts_sds[1],$starts_sds[0]);
		
		$end_month_full = $starts_sds[0].'-'.$starts_sds[1].'-'.$end_date_m;
		$start_month_full = $starts_sds[0].'-'.$starts_sds[1].'-01';
		$periode =date_format(date_create($start_date),"Y-F");
		
		
		if(count($get_week) > 0 && count($channel_cnt) == 1  ){
			$query_s = "
				SELECT a.CHANNEL,MAX(a.VIEWERS) as  VIEWERS FROM ".$tbs." a JOIN 
				( SELECT *,(toInt32(WEEK))-".$mw." AS D FROM WEEK_PARAM_DATE a 
				WHERE START_DATE = '".$start_date."' AND EMD_DATE = '".$end_date."' ) b
				on toInt64(a.WEEK) = b.D AND SUBSTRING(a.TANGGAL,1,4) = b.YEAR
				WHERE  ID_PROFILE = 0
				AND CHANNEL IN (".$params['channel'].")
				GROUP BY CHANNEL 				
			";
		}else if($start_date == $start_month_full && $end_date == $end_month_full && count($channel_cnt) == 1 ){
			$query_s = "
				SELECT a.CHANNEL,MAX(a.VIEWERS) as  VIEWERS,a.TANGGAL FROM ".$tbs2." a
				WHERE  ID_PROFILE = 0
				AND TANGGAL = '".$periode."'
				AND CHANNEL IN (".$params['channel'].") 
			";


		}else{
	
			if($params['daypart'] == 'ALL' ){

				foreach($array_date as $array_dates){
					
					if($r == 0){
						$query_s = "
						SELECT ".$huk." AS VIEWERS FROM (SELECT * FROM 
							(SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
							WHERE (USER_BEGIN_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
							USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
							AND CHANNEL IN (".$params['channel'].")
							GROUP BY CARDNO,CHANNEL,`DATE`,DURASI) 
						";
					}else{
						$query_s .= "
						UNION ALL 
						SELECT * FROM (
								SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
						WHERE (USER_BEGIN_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
								USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
								AND CHANNEL IN (".$params['channel'].")
								GROUP BY CARDNO,CHANNEL,`DATE`,DURASI

						) 
						";
					}

					$r++;

				}

			}else{

				$dt = explode('-',$params['daypart']);
				foreach($array_date as $array_dates){

					if($r == 0){
						$query_s = "
						SELECT ".$huk." AS VIEWERS FROM (
							SELECT * FROM 
							(
							SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
							WHERE (USER_BEGIN_SESSION  BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
									USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
									AND CHANNEL IN (".$params['channel'].")
									AND DATE_FORMAT(BEGIN_PROGRAM,'%H:%i:%s') BETWEEN '".$dt[0]."' AND '".$dt[1]."'
									GROUP BY CARDNO,CHANNEL,`DATE`,DURASI
							) 
						";
					}else{
						$query_s .= "
						UNION ALL 
						SELECT * FROM (
								SELECT CARDNO,CHANNEL,`DATE`,DURASI FROM CDR_EPG_ALL_SESSION_HARIAN_".$array_dates."_N
								WHERE (USER_BEGIN_SESSION  BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59' OR 
								USER_END_SESSION BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59')
								AND CHANNEL IN (".$params['channel'].")
								AND DATE_FORMAT(BEGIN_PROGRAM,'%H:%i:%s') BETWEEN '".$dt[0]."' AND '".$dt[1]."'
								GROUP BY CARDNO,CHANNEL,`DATE`,DURASI

						) 
						";
					}
					
					$r++;

				}

			}

			$query_s .=" ) ";

		}
		
		$params['query_s'] = $query_s;
		
		$list = $this->tvpc_model->list_tvpc2($params);
		$list_all = $this->tvpc_model->list_tvpc_all($params);
		
		

		
		
		$list2 = $this->tvpc_model->list_tvpc3($params);
		
		

		
		 if($datatp == "audience"){
						$data_text = "Audience"; 
					 }else if($datatp == "total_views"){
						 $data_text = "Total Views"; 
					 }else{
						 $data_text = "Duration"; 
					 }
		
		
		
		 $this->load->library('excel');
	  
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Reporting Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
									 
									 
		$array_day = ['Sunday','Monday','Tuesday','Wednenday','Thursday','Friday','Saturday'];
									 
									 
		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'DAYPART')
						->setCellValue('B1', $data_text)
						->setCellValue('D1', 'Days')
						->setCellValue('E1', $data_text)
						->setCellValue('D2', 'ALL TIME')
						->setCellValue('E2', $list_all[0]['VIEWERS'])		
						->setCellValue('A2', 'ALL TIME')
						->setCellValue('B2', $list_all[0]['VIEWERS']);		

		$sd_b = 3;
		foreach($list as $lista){
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$sd_b, $lista['TEXT'])
						->setCellValue('B'.$sd_b, ceil($lista['VIEWERS']));
			$sd_b++;
		}

		$sd_c = 3;
		foreach($list2 as $lista){
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('D'.$sd_c, $array_day[$lista['DAYPART']])
						->setCellValue('E'.$sd_c, ceil($lista['VIEWERS']));	
			$sd_c++;
		}						
		
		$objPHPExcel->setActiveSheetIndex(0);
	  
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		$objWriter->save('/var/www/html/tmp_doc/daypart.xls');
		
	}
	
	
	public function list_tvpc()
	{	        
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
        
		if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}
        
		if( ! empty($this->Anti_si($_GET['profile'])) ) {
			$profile = $this->Anti_si($_GET['profile']);
		} else {
			$profile = 0;
		}
    
		if( ! empty($this->Anti_si($_GET['genre'])) ) {
		  $genre = $this->Anti_si($_GET['genre']);
		} else {
		  $genre = "0";
		}

		if( ! empty($this->Anti_si($_GET['channel'])) ) {
			$channel = $this->Anti_si($_GET['channel']);
		} else {
			$channel = NULL;
		}	
    
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('rank','tanggal', 'program', 'channel', 'epg.genre','begin_time', 'end_time', 'viewers','total_views','duration','audience');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search'));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		$params['starttime'] 	= $start_time;
		$params['endtime'] 		= $end_time;
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
		$params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",str_replace("  AND  "," & ",$channel));
		
		$list = $this->tvpc_model->list_tvpc($params);
		
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;               
    
    if($order_dir == "desc"){
        $nrow = (int) $start+1;
    } else if($order_dir == "asc"){
        $nrow = $list['total_filtered']-(int) $start;
    }    
		
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {      
			array_push($data, 
				array(
          $nrow,		
					$v['DATE'],				
					$v['PROGRAM'],
					$v['CHANNEL'],
					$v['GENRE_PROGRAM'],					
					$v['BEGIN_PROGRAM'],					
					$v['END_PROGRAM'],
					number_format(round($v['VIEWERS'],0), 0, ",", "."),
					number_format(round($v['TOTAL_VIEWS'],0), 0, ",", "."),
					number_format($v['DURATION'], 2, ",", "."),
					number_format(round($v['AUDIENCE'],0), 0, ",", "."),
				)
			);      
      
      if($order_dir == "desc"){
          $nrow = $nrow + 1;
      } else if($order_dir == "asc"){
          $nrow = $nrow - 1;
      }
		}		
    
		$result["data"] = $data;
		$this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

  public function listchart_tvpc()
	{	
	
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
        
    if( !empty($this->Anti_si($_GET['stime'])) ) {
			$start_time = $this->Anti_si($_GET['stime']);
		} else {
			$start_time = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['etime'])) ) {
			$end_time = $this->Anti_si($_GET['etime']);
		} else {
			$end_time = NULL;
		}
    
		if( ! empty($this->Anti_si($_GET['profile'])) ) {
			$profile = $this->Anti_si($_GET['profile']);
		} else {
			$profile = 0;
		}
    
    if( ! empty($this->Anti_si($_GET['genre'])) ) {
        $genre = $this->Anti_si($_GET['genre']);
    } else {
        $genre = "0";
    }

		if( ! empty($this->Anti_si($_GET['channel'])) ) {
			$channel = $this->Anti_si($_GET['channel']);
		} else {
			$channel = NULL;
		}
    
    if( ! empty($this->Anti_si($_GET['cgroup'])) ) {
			$cgroup = $this->Anti_si($_GET['cgroup']);
		} else {
			$cgroup = NULL;
		}
    
    $params['starttime'] 	= $start_time;
    $params['endtime'] 		= $end_time;
		$params['start_date'] 	= $start_date;
		$params['end_date']		= $end_date;
		$params['profile']		= $profile;
    $params['genre']		= str_replace("AND","&",$genre);
		$params['channel']		= str_replace("AND","&",$channel);
    $params['cgroup']		= strtoupper($cgroup);
	
	
		$data['tvpc'] = $this->tvpc_model->listchart_tvpc($params);
		
		$result["data"] = $data;
		
		$this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}	                                                                 
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvpc_model->profilesearch($this->Anti_si($_GET['q']),$iduser,$this->Anti_si($_GET['f']));
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }     
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvpc_model->list_profile($iduser,"",$this->Anti_si($_GET['f']));          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                      
  
  public function genresearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->tvpc_model->genresearch($this->Anti_si($_GET['q']),$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                  
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $genre = str_replace("AND","&",$this->Anti_si($_GET['g']));
      $list = $this->tvpc_model->channelsearch($this->Anti_si($_GET['q']),$genre,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }             
  
  public function checkdaypart(){
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
      
      $daypart = $this->Anti_si($_GET['f']).":00-".$this->Anti_si($_GET['t']).":00"; 
      
      $count_daypart = $this->tvcc_model->checkdaypart($userid,$daypart);
    
  		if ( $count_daypart != "1" ) {
        $result = array( 'success' => true, 'message' => 'Vacant', 'data' => array('hasil' => $count_daypart));
  			
  			$this->output->set_content_type('application/json')->set_output(json_encode($result));
  		} else {
  			$result = array( 'success' => false, 'message' => 'Exist', 'data' => array('hasil' => $count_daypart));
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
      
      $daypart = $this->tvpc_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}